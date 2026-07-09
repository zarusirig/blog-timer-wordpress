#!/bin/bash
# Deploy the 2026-07-10 SEO/perf changes to production — FILES ONLY.
#
# ⚠️  Do NOT use migrate_now.sh for this: it replaces the production database
#     with the local Docker DB (which is stale) and would destroy live content.
#     This script syncs only the changed theme/plugin files + .htaccess.
#
# Usage:
#   ./deploy_seo_changes.sh                          # root@157.245.211.77, /var/www/html
#   DEPLOY_HOST=user@host WP_PATH=/path ./deploy_seo_changes.sh
#   SSH_KEY=~/.ssh/some_key ./deploy_seo_changes.sh
set -euo pipefail
cd "$(dirname "$0")"

DEPLOY_HOST="${DEPLOY_HOST:-root@157.245.211.77}"
WP_PATH="${WP_PATH:-/var/www/html}"
SSH_OPTS=(-o ConnectTimeout=10)
[ -n "${SSH_KEY:-}" ] && SSH_OPTS+=(-i "$SSH_KEY" -o IdentitiesOnly=yes)

THEME_SRC="wp-content/themes/my-custom-theme"
THEME_DST="$WP_PATH/wp-content/themes/my-custom-theme"
PLUGIN_SRC="wp-content/plugins/timer-engine"
PLUGIN_DST="$WP_PATH/wp-content/plugins/timer-engine"

echo "→ Deploying to $DEPLOY_HOST:$WP_PATH"

# 1. Server-side backup of every file we are about to replace.
ssh "${SSH_OPTS[@]}" "$DEPLOY_HOST" "
  set -e
  ts=\$(date +%Y%m%d-%H%M%S)
  mkdir -p /root/seo-deploy-backup-\$ts
  cp -a '$THEME_DST/functions.php' '$THEME_DST/single-guide.php' '$THEME_DST/single-timer.php' \
        '$THEME_DST/page-author-suraj-giri.php' '$PLUGIN_DST/timer-engine.php' '$WP_PATH/.htaccess' \
        /root/seo-deploy-backup-\$ts/
  echo \"  backup: /root/seo-deploy-backup-\$ts\"
"

# 2. Sync changed files + new fonts directory.
scp "${SSH_OPTS[@]}" \
  "$THEME_SRC/functions.php" "$THEME_SRC/single-guide.php" "$THEME_SRC/single-timer.php" \
  "$THEME_SRC/page-author-suraj-giri.php" "$DEPLOY_HOST:$THEME_DST/"
scp "${SSH_OPTS[@]}" -r "$THEME_SRC/fonts" "$DEPLOY_HOST:$THEME_DST/"
scp "${SSH_OPTS[@]}" "$PLUGIN_SRC/timer-engine.php" "$DEPLOY_HOST:$PLUGIN_DST/"
scp "${SSH_OPTS[@]}" .htaccess "$DEPLOY_HOST:$WP_PATH/.htaccess"

# 3. Fix ownership, sanity-check PHP syntax on the server, flush caches.
ssh "${SSH_OPTS[@]}" "$DEPLOY_HOST" "
  set -e
  chown -R www-data:www-data '$THEME_DST' '$PLUGIN_DST' '$WP_PATH/.htaccess'
  php -l '$THEME_DST/functions.php' && php -l '$PLUGIN_DST/timer-engine.php'
  command -v wp >/dev/null && (cd '$WP_PATH' && wp --allow-root cache flush || true; wp --allow-root breeze purge --cache=all 2>/dev/null || true)
  command -v systemctl >/dev/null && (systemctl reload apache2 2>/dev/null || systemctl reload nginx 2>/dev/null || true)
  echo '  server updated.'
"

# 4. Verify live behavior.
echo '→ Verifying https://theblogtimer.com'
sleep 3
title=$(curl -s https://theblogtimer.com/ -H 'Cache-Control: no-cache' | grep -oE '<title>[^<]*</title>' | head -1)
echo "  homepage title: $title"
code=$(curl -s -o /dev/null -w '%{http_code}' https://theblogtimer.com/item/9999999)
echo "  /item/9999999 → $code (expect 410)"
lastmods=$(curl -s https://theblogtimer.com/sitemap-fresh.xml | grep -c lastmod || true)
echo "  sitemap lastmod entries: $lastmods (expect ~390)"
gfonts=$(curl -s https://theblogtimer.com/ | grep -c fonts.googleapis || true)
echo "  Google Fonts references: $gfonts (expect 0)"
fontcode=$(curl -s -o /dev/null -w '%{http_code}' 'https://theblogtimer.com/wp-content/themes/my-custom-theme/fonts/inter-var-latin.woff2?ver=v1')
echo "  self-hosted Inter font: $fontcode (expect 200)"
echo '✓ Done. If any check failed, the edge cache may still be serving old HTML — purge it and re-check.'
