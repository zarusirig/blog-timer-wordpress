#!/usr/bin/env bash
# ============================================================
# Guest-blog setup — The Blog Timer
#
# Creates:
#   - 9 guest-post categories (with intro descriptions)
#   - "Blog" page (Blog Index template) and "Write for Us" page
#   - Post permalinks /blog/%postname%/, category base /topics/
#   - Two editor accounts for the guest-post team
#
# Idempotent: safe to re-run; existing items are updated, not duplicated.
#
# Usage:
#   ./setup-guest-blog.sh           # local Docker (wp-dev container)
#   ./setup-guest-blog.sh --prod    # production (Cloudways, via SSH)
# ============================================================

set -euo pipefail

SSH_CMD='sshpass -p G5f6XEcAzHtj ssh -o StrictHostKeyChecking=no master_tpzxehsbve@157.245.211.77'
PROD_ROOT='/home/1630465.cloudwaysapps.com/ppcsfrtyxs/public_html'

# --prod from the laptop: ship this script to the server and run it there.
if [ "${1:-}" = "--prod" ] && [ -z "${BT_GUEST_REMOTE:-}" ]; then
    $SSH_CMD "BT_GUEST_REMOTE=1 bash -s" < "$0"
    exit $?
fi

if [ -n "${BT_GUEST_REMOTE:-}" ]; then
    MODE='remote'
    cd "$PROD_ROOT"
    echo '== Guest-blog setup: PRODUCTION =='
else
    MODE='local'
    echo '== Guest-blog setup: LOCAL Docker =='
    # wp-cli.phar is not persisted in the image — reinstall if missing.
    if ! docker exec wp-dev wp --version >/dev/null 2>&1; then
        echo 'wp-cli missing in container, installing…'
        docker exec wp-dev bash -c "curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"
    fi
fi

wpx() {
    if [ "$MODE" = 'remote' ]; then
        wp --allow-root "$@"
    else
        docker exec wp-dev wp --allow-root --path=/var/www/html "$@"
    fi
}

# ------------------------------------------------------------
# 1. Categories (slug|Name|Description)
# ------------------------------------------------------------
create_category() {
    local slug="$1" name="$2" desc="$3" term_id
    term_id=$(wpx term list category --slug="$slug" --fields=term_id --format=csv | tail -n +2 | head -1 | tr -d '[:space:]')
    if [ -n "$term_id" ]; then
        wpx term update category "$term_id" --name="$name" --description="$desc" >/dev/null
        echo "  [ok] category exists, updated: $name"
    else
        wpx term create category "$name" --slug="$slug" --description="$desc" >/dev/null
        echo "  [ok] category created: $name"
    fi
}

echo '-- Categories --'
create_category 'business' 'Business' 'Business strategy and operations explained for owners and managers — planning, hiring, processes, and the time habits that make teams productive.'
create_category 'technology' 'Technology' 'Technology explainers and buying guidance: apps, devices, workflows, and the timing details that decide whether a tool actually saves you time.'
create_category 'seo-digital-marketing' 'SEO & Digital Marketing' 'SEO and digital marketing how-tos from working practitioners — keyword research, on-page work, content systems, and campaign timing.'
create_category 'travel' 'Travel' 'Travel planning with a planner’s eye: best times to visit, flight and connection timing, itineraries, and how long things really take.'
create_category 'education' 'Education' 'Study technique, learning schedules, and exam prep — how long to study, when to break, and what the research says about retention.'
create_category 'home-garden' 'Home & Garden' 'Household timing know-how: food storage, cooking, cleaning schedules, gardening calendars, and maintenance intervals.'
create_category 'career' 'Career' 'Career growth and workplace productivity — job search timelines, skill-building hours, interview prep, and working smarter.'
create_category 'lifestyle' 'Lifestyle' 'Everyday routines and habits — morning and evening schedules, wellness timing, hobbies, and organizing your week.'
create_category 'ai-tools' 'AI Tools' 'AI tools in practice: which assistants, generators, and automation platforms actually help, how long workflows take, and how to verify output.'

# WP-CLI HTML-encodes "&" in term names on create/update; decode so the
# frontend's esc_html() does not double-encode them to &amp;amp;.
if [ "$MODE" = 'remote' ]; then
    wpx db query "UPDATE wp_terms SET name = REPLACE(name, '&amp;', '&') WHERE name LIKE '%&amp;%';" >/dev/null 2>&1 || true
else
    # wp-dev container has no mysql client; query the DB container directly.
    docker exec wp-mysql mysql -u wordpress -pwordpress_password wordpress \
        -e "UPDATE wp_terms SET name = REPLACE(name, '&amp;', '&') WHERE name LIKE '%&amp;%';" >/dev/null 2>&1 || true
fi

# Default category for new posts = Business (so nothing lands in Uncategorized).
BUSINESS_ID=$(wpx term list category --slug=business --fields=term_id --format=csv | tail -n +2 | head -1 | tr -d '[:space:]')
if [ -n "$BUSINESS_ID" ]; then
    wpx option update default_category "$BUSINESS_ID" >/dev/null
fi

# ------------------------------------------------------------
# 2. Pages (Blog + Write for Us) with their templates
# ------------------------------------------------------------
ensure_page() {
    local slug="$1" title="$2" template="$3" existing
    existing=$(wpx post list --post_type=page --name="$slug" --posts_per_page=1 --fields=ID --format=csv | tail -n +2 | head -1)
    if [ -n "$existing" ]; then
        wpx post update "$existing" --page_template="$template" --post_status=publish >/dev/null
        echo "  [ok] page exists, template ensured: /$slug"
    else
        wpx post create --post_type=page --post_title="$title" --post_name="$slug" --post_status=publish --page_template="$template" >/dev/null
        echo "  [ok] page created: /$slug ($title)"
    fi
}

echo '-- Pages --'
ensure_page 'blog' 'Blog' 'page-blog.php'
ensure_page 'write-for-us' 'Write for Us' 'page-write-for-us.php'

# ------------------------------------------------------------
# 3. Permalinks: posts -> /blog/{slug}/, categories -> /topics/{slug}/
# ------------------------------------------------------------
echo '-- Permalinks --'
wpx rewrite structure '/blog/%postname%/' --hard >/dev/null
wpx option update category_base 'topics' >/dev/null
wpx rewrite flush --hard >/dev/null
echo '  [ok] posts at /blog/{slug}/, categories at /topics/{slug}/'

# Remove the default sample post if present (production safety check).
HELLO=$(wpx post list --post_type=post --fields=ID,post_title --format=csv | grep -i 'Hello world' | cut -d, -f1 || true)
if [ -n "$HELLO" ]; then
    wpx post delete "$HELLO" --force >/dev/null
    echo "  [ok] deleted sample post #$HELLO"
fi

# ------------------------------------------------------------
# 4. Editor accounts for the guest-post team
# ------------------------------------------------------------
ensure_user() {
    local login="$1" email="$2" display="$3" pass="$4" existing
    existing=$(wpx user list --login="$login" --fields=ID --format=csv | tail -n +2 | head -1)
    if [ -n "$existing" ]; then
        wpx user update "$login" --role=editor --display_name="$display" >/dev/null
        echo "  [ok] user exists, role ensured: $login"
    else
        wpx user create "$login" "$email" --role=editor --display_name="$display" --user_pass="$pass" >/dev/null
        echo "  [ok] user created: $login | password: $pass"
    fi
}

echo '-- Editor accounts --'
PW1=$(openssl rand -base64 18 2>/dev/null | tr -d '/+=' | cut -c1-16)
PW2=$(openssl rand -base64 18 2>/dev/null | tr -d '/+=' | cut -c1-16)
if [ -n "$PW1" ] && [ -n "$PW2" ]; then
    ensure_user 'faizanlink' 'faizanlinksolutions@gmail.com' 'Faizan Link' "$PW1"
    ensure_user 'johnfridmen' 'johnfridmen369@gmail.com' 'John Fridmen' "$PW2"
else
    # No openssl on the box — create with a strong-enough fallback.
    ensure_user 'faizanlink' 'faizanlinksolutions@gmail.com' 'Faizan Link' "BT-$(date +%s)-fa"
    ensure_user 'johnfridmen' 'johnfridmen369@gmail.com' 'John Fridmen' "BT-$(date +%s)-jo"
fi

echo
echo '== Done. Login at /wp-admin/ (username + password above). =='
