<?php
/**
 * Theme Functions — The Blog Timer
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function blogtimer_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');

    register_nav_menus([
        'primary' => __('Primary Menu', 'my-custom-theme'),
        'footer' => __('Footer Menu', 'my-custom-theme'),
    ]);
}
add_action('after_setup_theme', 'blogtimer_setup');

/**
 * Set a Timing-centric site tagline (blogdescription) when it is empty.
 *
 * The blogdescription is the fallback for OG/social/meta descriptions and the
 * WebSite tagline. Leaving it blank means social shares carry no Central Entity
 * signal. We only write it when empty so a manually-set tagline is never clobbered.
 */
function blogtimer_set_default_blogdescription()
{
    $current = trim((string) get_option('blogdescription'));
    if ($current === '') {
        update_option(
            'blogdescription',
            'Evidence-based timing — research-backed "how long should I…" guides and accurate online timers.'
        );
    }
}
add_action('after_setup_theme', 'blogtimer_set_default_blogdescription');

/**
 * Enqueue scripts and styles
 */
function blogtimer_enqueue_assets()
{
    // Fonts are SELF-HOSTED variable fonts (see blogtimer_inline_font_faces) —
    // the old render-blocking fonts.googleapis.com stylesheet and both Google
    // origins are gone from the critical path entirely.

    // Main stylesheet
    wp_enqueue_style('blogtimer-style', get_stylesheet_uri(), [], filemtime(get_stylesheet_directory() . '/style.css'));

    // Mobile navigation
    wp_enqueue_script('blogtimer-mobile-nav', get_template_directory_uri() . '/js/mobile-nav.js', [], '2.0.0', [
        'in_footer' => true,
        'strategy' => 'defer',
    ]);

    // Timer widget JS — only on pages that use the ID-based widget markup
    // (#timer-start / #timer-display). pomodoro is self-driven (inline script),
    // and minute-timers/second-timers are link hubs with no widget.
    if (is_singular('timer') || is_front_page()) {
        wp_enqueue_script('blogtimer-timer', get_template_directory_uri() . '/js/timer-widget.js', [], '2.1.0', [
            'in_footer' => true,
            'strategy' => 'defer',
        ]);

        // Pass localized data to JS
        $timer_data = [
            'audioUrl' => get_template_directory_uri() . '/audio/timer-alert.wav',
        ];

        // If on a single timer page, pass timer-specific data
        if (is_singular('timer')) {
            $timer_data['value'] = (int) get_post_meta(get_the_ID(), '_timer_value', true);
            $timer_data['unit'] = get_post_meta(get_the_ID(), '_timer_unit', true);
            $timer_data['durationSeconds'] = Timer_Engine::get_duration_seconds(get_the_ID());
        }

        wp_localize_script('blogtimer-timer', 'blogTimerData', $timer_data);
    }

    // Shared hub-timer engine: drives the CLASS-BASED .timer-widget markup on the
    // niche hub pages that shipped without any timer JavaScript (their Start buttons
    // were dead). Enqueued ONLY on these scriptless pages so it never double-binds the
    // pages with their own bespoke timer script (stopwatch, tabata-timer, countdown-timer,
    // sleep-timer, focus-timer, study-timer, chess-clock, online-alarm-clock) or the
    // ID-based timer-widget.js pages. If you add a new class-based hub timer page that
    // has no inline timer script, add its slug here.
    $blogtimer_hub_timer_pages = [
        'egg-timer', 'coffee-timer', 'pasta-timer', 'rice-timer', 'tea-timer', 'steak-timer',
        'turkey-timer', 'sous-vide-timer', 'bbq-timer', 'bread-baking-timer', 'microwave-popcorn-timer',
        'baby-bottle-timer', 'hiit-timer', 'emom-timer', 'crossfit-amrap-timer', 'boxing-round-timer',
        'jump-rope-timer', 'running-interval-timer', 'plank-timer', 'stretching-timer', 'yoga-timer',
        'nap-timer', 'sprint-timer', 'presentation-timer', 'interval-timer', 'timer-for-kids',
        'timer-for-remote-workers',
    ];
    if (is_page($blogtimer_hub_timer_pages)) {
        wp_enqueue_script('blogtimer-hub-timer', get_template_directory_uri() . '/js/hub-timer.js', [], '1.0.0', [
            'in_footer' => true,
            'strategy' => 'defer',
        ]);
        wp_localize_script('blogtimer-hub-timer', 'blogTimerData', [
            'audioUrl' => get_template_directory_uri() . '/audio/timer-alert.wav',
        ]);
    }

    // Gestation / pregnancy countdown widget — only on single guides (a guide's
    // content may embed a .bt-gestation-widget placeholder). The script no-ops if
    // the placeholder is absent, so it's safe to load on every guide.
    if (is_singular('guide')) {
        wp_enqueue_style('blogtimer-gestation', get_template_directory_uri() . '/css/gestation-widget.css', [], '1.0.0');
        wp_enqueue_script('blogtimer-gestation', get_template_directory_uri() . '/js/gestation-widget.js', [], '1.0.0', [
            'in_footer' => true,
            'strategy' => 'defer',
        ]);
    }

    // FAQ accordion
    wp_enqueue_script('blogtimer-faq', get_template_directory_uri() . '/js/faq-accordion.js', [], '2.0.0', [
        'in_footer' => true,
        'strategy' => 'defer',
    ]);
}
add_action('wp_enqueue_scripts', 'blogtimer_enqueue_assets');

/**
 * Self-hosted variable fonts: preload + inline @font-face, emitted at the very
 * top of <head> (priority 0) so font fetches start before the stylesheet parses.
 *
 * One variable woff2 per family replaces the 7 static files Google served:
 * Inter covers weights 400-800, JetBrains Mono 400-700 (latin subset, v20/v24
 * from fonts.gstatic.com, vendored 2026-07-10). font-display: swap keeps text
 * visible during load; the latin unicode-range lets non-latin glyphs fall
 * through to the system stack instead of forcing a font download.
 */
function blogtimer_inline_font_faces()
{
    $fonts_uri = get_template_directory_uri() . '/fonts';
    $ver = 'v1'; // bump when font files change — assets are cached for 1 year
    $inter = esc_url($fonts_uri . '/inter-var-latin.woff2?ver=' . $ver);
    $mono = esc_url($fonts_uri . '/jetbrains-mono-var-latin.woff2?ver=' . $ver);
    $latin_range = 'U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD';

    echo '<link rel="preload" href="' . $inter . '" as="font" type="font/woff2" crossorigin>' . "\n";
    echo '<link rel="preload" href="' . $mono . '" as="font" type="font/woff2" crossorigin>' . "\n";
    echo '<style id="blogtimer-fonts">'
        . "@font-face{font-family:'Inter';font-style:normal;font-weight:400 800;font-display:swap;src:url({$inter}) format('woff2');unicode-range:{$latin_range};}"
        . "@font-face{font-family:'JetBrains Mono';font-style:normal;font-weight:400 700;font-display:swap;src:url({$mono}) format('woff2');unicode-range:{$latin_range};}"
        . '</style>' . "\n";
}
add_action('wp_head', 'blogtimer_inline_font_faces', 0);

/**
 * GA4 Measurement ID. Set via `define('BLOGTIMER_GA4_ID', 'G-XXXXXXXXXX');`
 * in wp-config.php (preferred) or the `blogtimer_ga4_id` option. Empty = GA off.
 */
function blogtimer_ga4_measurement_id()
{
    if (defined('BLOGTIMER_GA4_ID') && BLOGTIMER_GA4_ID) {
        return (string) BLOGTIMER_GA4_ID;
    }
    return (string) get_option('blogtimer_ga4_id', '');
}

/**
 * Google Analytics 4 with Consent Mode v2, wired to the theme cookie banner.
 *
 * - Defaults every consent signal to denied; gtag then sends only cookieless
 *   pings until the visitor clicks "Accept All" (stored by the banner in
 *   localStorage as blogtimer_cookie_consent = 'all' | 'essential').
 * - Skipped for logged-in users and non-production hosts so admin sessions
 *   and local Docker never pollute the property.
 */
add_action('wp_head', function () {
    $ga_id = blogtimer_ga4_measurement_id();
    if ($ga_id === '' || is_user_logged_in()) {
        return;
    }
    $host = (string) wp_parse_url(home_url('/'), PHP_URL_HOST);
    if ($host === '' || strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
        return;
    }
    $ga_id_attr = esc_js($ga_id);
    ?>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('consent', 'default', {
        analytics_storage: 'denied',
        ad_storage: 'denied',
        ad_user_data: 'denied',
        ad_personalization: 'denied',
        wait_for_update: 500
    });
    try {
        if (localStorage.getItem('blogtimer_cookie_consent') === 'all') {
            gtag('consent', 'update', {
                analytics_storage: 'granted',
                ad_storage: 'granted',
                ad_user_data: 'granted',
                ad_personalization: 'granted'
            });
        }
    } catch (e) {}
    gtag('js', new Date());
    gtag('config', '<?php echo $ga_id_attr; ?>');
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo rawurlencode($ga_id); ?>"></script>
    <?php
}, 3);

/**
 * Remove WordPress frontend assets that the classic theme does not use.
 */
function blogtimer_cleanup_frontend_assets()
{
    if (is_admin()) {
        return;
    }

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');

    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'blogtimer_cleanup_frontend_assets', 100);

/**
 * Disable WordPress emoji detection and styles on the public frontend.
 */
function blogtimer_disable_frontend_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'blogtimer_disable_frontend_emojis');

/**
 * Remove the obsolete s.w.org emoji DNS prefetch hint.
 */
function blogtimer_remove_emoji_resource_hint($urls, $relation_type)
{
    if ($relation_type === 'dns-prefetch') {
        $urls = array_diff($urls, ['https://s.w.org']);
    }

    return $urls;
}
add_filter('wp_resource_hints', 'blogtimer_remove_emoji_resource_hint', 10, 2);

/**
 * Register widget areas
 */
function blogtimer_widgets()
{
    register_sidebar([
        'name' => __('Sidebar', 'my-custom-theme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'my-custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
add_action('widgets_init', 'blogtimer_widgets');

/**
 * Custom page templates registration
 */
function blogtimer_page_templates($templates)
{
    $templates['page-minute-timers.php'] = 'Minute Timers Hub';
    $templates['page-second-timers.php'] = 'Second Timers Hub';
    $templates['page-pomodoro.php'] = 'Pomodoro Timer';
    $templates['page-use-cases.php'] = 'Use Cases Hub';
    $templates['page-about.php'] = 'About Page';
    $templates['page-contact.php'] = 'Contact Page';
    $templates['page-faq.php'] = 'FAQ Page';
    $templates['page-disclaimer.php'] = 'Disclaimer Page';
    $templates['page-dmca.php'] = 'DMCA Policy Page';
    $templates['page-accessibility.php'] = 'Accessibility Statement';
    $templates['page-editorial-policy.php'] = 'Editorial Policy Page';
    return $templates;
}
add_filter('theme_page_templates', 'blogtimer_page_templates');

/**
 * Helper: render a timer card link
 */
function blogtimer_render_timer_card($timer_data, $show_popular = true)
{
    $value = $timer_data['value'];
    $unit = $timer_data['unit'];
    $post = $timer_data['post'];
    $is_popular = get_post_meta($post->ID, '_timer_is_popular', true);
    $classes = 'timer-card';
    if ($show_popular && $is_popular)
        $classes .= ' popular';
    ?>
    <?php
    $unit_label = ucfirst($unit);
    if ($unit === 'hours' && (int) $value === 1) {
        $unit_label = 'Hour';
    }
    ?>
    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="<?php echo esc_attr($classes); ?>">
        <span class="timer-card-value"><?php echo esc_html($value); ?></span>
        <span class="timer-card-label"><?php echo esc_html($unit_label); ?></span>
    </a>
    <?php
}

/**
 * Resolve a taxonomy archive URL by term slug.
 */
function blogtimer_get_term_url_by_slug($taxonomy, $slug)
{
    $term = get_term_by('slug', $slug, $taxonomy);
    if ($term && !is_wp_error($term)) {
        $url = get_term_link($term);
        if (!is_wp_error($url)) {
            return $url;
        }
    }

    $tax_obj = get_taxonomy($taxonomy);
    $rewrite_slug = ($tax_obj && isset($tax_obj->rewrite['slug'])) ? $tax_obj->rewrite['slug'] : $taxonomy;
    return home_url('/' . trim($rewrite_slug, '/') . '/' . $slug . '/');
}

/**
 * Get taxonomy terms in a deterministic order.
 */
function blogtimer_get_taxonomy_terms($taxonomy, $ordered_slugs = [], $hide_empty = false)
{
    if (!empty($ordered_slugs)) {
        $ordered_terms = [];
        foreach ($ordered_slugs as $slug) {
            $term = get_term_by('slug', $slug, $taxonomy);
            if ($term && !is_wp_error($term)) {
                $ordered_terms[] = $term;
            }
        }
        return $ordered_terms;
    }

    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => (bool) $hide_empty,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);

    if (is_wp_error($terms) || !is_array($terms)) {
        return [];
    }

    return $terms;
}

/**
 * Bucket slugs by timer unit.
 */
function blogtimer_get_bucket_slugs_for_unit($unit)
{
    if ($unit === 'seconds') {
        return ['seconds_short', 'seconds_medium', 'seconds_long'];
    }

    if ($unit === 'hours') {
        return ['hours_short', 'hours_long', 'hours_extended'];
    }

    return ['short', 'medium', 'long', 'extended'];
}

/**
 * Normalize frontend URLs to no trailing slash (except static file paths).
 */
function blogtimer_untrailingslashit_url($url)
{
    $parts = wp_parse_url($url);
    if (!$parts) {
        return $url;
    }

    $path = isset($parts['path']) ? (string) $parts['path'] : '';
    if ($path !== '' && preg_match('/\.[a-z0-9]+$/i', $path)) {
        return $url;
    }

    return untrailingslashit($url);
}

/**
 * Filter home_url outputs to remove trailing slash from non-root paths.
 *
 * Keep the homepage URL with a root path slash when requested as '/' to avoid
 * canonical.php notices from core URL normalization.
 */
function blogtimer_filter_home_url_no_trailing_slash($url, $path = '', $orig_scheme = null, $blog_id = null)
{
    if (is_admin()) {
        return $url;
    }

    if ((string) $path === '/') {
        return trailingslashit($url);
    }

    return blogtimer_untrailingslashit_url($url);
}
add_filter('home_url', 'blogtimer_filter_home_url_no_trailing_slash', 20, 4);

/**
 * Filter URL outputs to remove trailing slash across public links.
 */
function blogtimer_filter_public_url_no_trailing_slash($url)
{
    if (is_admin()) {
        return $url;
    }

    return blogtimer_untrailingslashit_url($url);
}
add_filter('post_type_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('post_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('page_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('term_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('author_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('day_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('month_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);
add_filter('year_link', 'blogtimer_filter_public_url_no_trailing_slash', 20);

/**
 * Force incoming non-file URLs to the no-trailing-slash canonical form.
 */
function blogtimer_redirect_trailing_slash_urls()
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    if (is_feed() || is_trackback()) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    if ($request_uri === '') {
        return;
    }

    $parts = wp_parse_url($request_uri);
    if (!$parts) {
        return;
    }

    $path = isset($parts['path']) ? (string) $parts['path'] : '';
    if ($path === '' || $path === '/') {
        return;
    }

    if (preg_match('/\.[a-z0-9]+$/i', $path)) {
        return;
    }

    if (substr($path, -1) !== '/') {
        return;
    }

    $target = home_url(untrailingslashit($path));
    if (!empty($parts['query'])) {
        $target .= '?' . $parts['query'];
    }

    wp_safe_redirect($target, 301);
    exit;
}
add_action('template_redirect', 'blogtimer_redirect_trailing_slash_urls', 1);

/**
 * 301 www.theblogtimer.com -> https://theblogtimer.com (host canonicalization).
 *
 * Production is Cloudways Nginx with no server-config access, so the host
 * redirect must happen in PHP. Hooked on 'init' (priority 0) because
 * template_redirect fires too late for some asset/endpoint requests — without
 * this, www serves 200s and Google sees two hosts with only a canonical hint.
 */
function blogtimer_redirect_www_to_apex()
{
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }
    if (php_sapi_name() === 'cli' || is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $host = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
    if ($host !== 'www.theblogtimer.com') {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '/';
    wp_safe_redirect('https://theblogtimer.com' . $request_uri, 301);
    exit;
}
add_action('init', 'blogtimer_redirect_www_to_apex', 0);

/**
 * Legacy "timer for" URL variants that should redirect to clean canonical pages.
 */
function blogtimer_timer_for_redirect_map()
{
    return [
        '/timer-for/kids' => '/timer-for-kids',
        '/timer/for/kids' => '/timer-for-kids',
        '/timer-for/remote-workers' => '/timer-for-remote-workers',
        '/timer/for/remote-workers' => '/timer-for-remote-workers',
    ];
}

/**
 * 301-redirect legacy migration URLs that Google still crawls.
 *
 * Two old patterns produce 404s in Search Console:
 *   1. /item/{id}        - the OLD CPT permalink base. Posts still exist; their
 *                          permalink is now /timer/... or /guides/..., so we
 *                          redirect to the current permalink for that post ID.
 *   2. /guide-cluster/*  - an OLD removed taxonomy. Redirect to the /guides/
 *                          hub (or the homepage if no guides hub page exists).
 *
 * Only fires on these specific path patterns to stay cheap on every request.
 */
function blogtimer_redirect_legacy_migration_urls()
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    if ($request_uri === '') {
        return;
    }

    $parts = wp_parse_url($request_uri);
    if (!$parts) {
        return;
    }

    $path = isset($parts['path']) ? (string) $parts['path'] : '';
    if ($path === '') {
        return;
    }

    // Canonicalize old/nested "timer for" URL variants to the clean page URLs.
    $timer_for_redirects = blogtimer_timer_for_redirect_map();
    $path_trimmed = rtrim($path, '/');
    if (isset($timer_for_redirects[$path_trimmed])) {
        wp_safe_redirect(home_url($timer_for_redirects[$path_trimmed]), 301);
        exit;
    }

    // One-off guide consolidations: 301 a retired duplicate slug to its replacement.
    // (pomodoro-vs-52-17 was removed from this map 2026-07-31: the page was
    // resurrected as the 52/17 implementation guide and must resolve again.)
    $guide_redirects = [];
    if (isset($guide_redirects[$path_trimmed])) {
        wp_safe_redirect(home_url($guide_redirects[$path_trimmed]), 301);
        exit;
    }

    // Pattern 1: /item/{numeric-id} -> current permalink for that post.
    if (preg_match('#^/item/(\d+)#', $path, $m)) {
        $post_id = (int) $m[1];
        $permalink = $post_id > 0 ? get_permalink($post_id) : false;
        if ($permalink && get_post_status($post_id) === 'publish') {
            wp_safe_redirect($permalink, 301);
            exit;
        }
        // The ID doesn't exist in this install (legacy IDs from the pre-migration
        // site). Serve 410 Gone instead of 404: Google de-indexes 410s faster and
        // stops re-crawling them, reclaiming the crawl budget these URLs burn.
        status_header(410);
        nocache_headers();
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="robots" content="noindex"><title>410 Gone</title></head>'
            . '<body><h1>410 — This page has been permanently removed</h1>'
            . '<p>Try the <a href="' . esc_url(home_url('/')) . '">free online timer</a> or browse the <a href="' . esc_url(home_url('/guides')) . '">timing guides</a>.</p>'
            . '</body></html>';
        exit;
    }

    // Pattern 2: /guide-cluster/* -> /guides/ hub, or homepage as a fallback.
    if (preg_match('#^/guide-cluster(/|$)#', $path)) {
        $target = '';
        // Prefer a real "guides" page if one exists.
        $guides_hub = get_page_by_path('guides');
        if ($guides_hub) {
            $target = get_permalink($guides_hub);
        }
        // Otherwise use the guide CPT archive (/guides/), which is the real hub.
        if (!$target) {
            $archive = get_post_type_archive_link('guide');
            if ($archive) {
                $target = $archive;
            }
        }
        if (!$target) {
            $target = home_url('/');
        }
        wp_safe_redirect($target, 301);
        exit;
    }
}
add_action('template_redirect', 'blogtimer_redirect_legacy_migration_urls', 1);

/**
 * Helper: ad enablement flag.
 *
 * Enable with BLOGTIMER_ADS_ENABLED=1 in environment when ad slots are ready.
 */
function blogtimer_ads_enabled()
{
    $raw = getenv('BLOGTIMER_ADS_ENABLED');
    $enabled = false;
    if ($raw !== false) {
        $enabled = in_array(strtolower((string) $raw), ['1', 'true', 'yes', 'on'], true);
    }

    return (bool) apply_filters('blogtimer_ads_enabled', $enabled);
}

/**
 * Helper: render a safe ad slot wrapper.
 */
function blogtimer_render_ad_slot($slot_id, $label = 'Advertisement')
{
    if (!blogtimer_ads_enabled() || empty($slot_id)) {
        return;
    }
    ?>
    <section class="ad-slot" data-ad-slot-id="<?php echo esc_attr($slot_id); ?>">
        <div class="ad-slot__inner" role="complementary" aria-label="<?php echo esc_attr($label); ?>">
            <span class="ad-slot__label"><?php echo esc_html($label); ?></span>
            <?php do_action('blogtimer_render_ad_slot', $slot_id); ?>
        </div>
    </section>
    <?php
}

/**
 * Resolve ads.txt publisher line.
 */
function blogtimer_ads_txt_line()
{
    $default = 'google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0';
    $env_line = getenv('BLOGTIMER_ADS_TXT_LINE');
    $line = $env_line !== false ? trim((string) $env_line) : $default;

    return (string) apply_filters('blogtimer_ads_txt_line', $line);
}

/**
 * Register ads.txt rewrite endpoint.
 */
function blogtimer_register_ads_txt_rewrite()
{
    add_rewrite_rule('^ads\.txt$', 'index.php?blogtimer_ads_txt=1', 'top');
}
add_action('init', 'blogtimer_register_ads_txt_rewrite');

/**
 * Register ads.txt query var.
 */
function blogtimer_ads_txt_query_vars($vars)
{
    $vars[] = 'blogtimer_ads_txt';
    return $vars;
}
add_filter('query_vars', 'blogtimer_ads_txt_query_vars');

/**
 * Prevent canonical redirects from re-adding trailing slashes.
 */
function blogtimer_disable_ads_txt_canonical($redirect_url, $requested_url)
{
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    if ((int) get_query_var('blogtimer_ads_txt') === 1 || preg_match('#/ads\.txt/?$#', $request_uri)) {
        return false;
    }

    if (empty($redirect_url) || empty($requested_url)) {
        return $redirect_url;
    }

    $requested_parts = wp_parse_url($requested_url);
    $redirect_parts = wp_parse_url($redirect_url);
    if (!$requested_parts || !$redirect_parts) {
        return $redirect_url;
    }

    $requested_path = isset($requested_parts['path']) ? (string) $requested_parts['path'] : '/';
    $redirect_path = isset($redirect_parts['path']) ? (string) $redirect_parts['path'] : '/';

    // Keep static/file URLs untouched.
    if (preg_match('/\.[a-z0-9]+$/i', $requested_path)) {
        return $redirect_url;
    }

    // If canonical differs only by trailing slash, keep the no-trailing-slash request.
    if (untrailingslashit($requested_path) === untrailingslashit($redirect_path)) {
        return false;
    }

    // Normalize redirect target itself to no trailing slash.
    if ($redirect_path !== '/' && substr($redirect_path, -1) === '/') {
        return blogtimer_untrailingslashit_url($redirect_url);
    }

    return $redirect_url;
}
add_filter('redirect_canonical', 'blogtimer_disable_ads_txt_canonical', 10, 2);

/**
 * Serve ads.txt through WordPress routing.
 */
function blogtimer_render_ads_txt_route()
{
    if ((int) get_query_var('blogtimer_ads_txt') !== 1) {
        return;
    }

    nocache_headers();
    header('Content-Type: text/plain; charset=utf-8');
    echo "# The Blog Timer ads.txt\n";
    echo blogtimer_ads_txt_line() . "\n";
    exit;
}
add_action('template_redirect', 'blogtimer_render_ads_txt_route');

/**
 * Helper: render FAQ accordion
 */
function blogtimer_render_faq($faqs)
{
    if (empty($faqs))
        return;
    ?>
    <div class="faq-list">
        <?php
        static $faq_idx = 0;
        foreach ($faqs as $faq) :
            $faq_id = 'faq-' . (++$faq_idx);
        ?>
            <div class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr($faq_id); ?>">
                    <span><?php echo esc_html($faq['q']); ?></span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                </button>
                <div class="faq-answer" id="<?php echo esc_attr($faq_id); ?>" role="region">
                    <p><?php echo esc_html($faq['a']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Resolve the absolute path to datasets/copyblocks.json across local + production layouts.
 *
 * Several features (FAQ schema, taxonomy hub overrides) read this file. Local Docker
 * and Cloudways production place the datasets directory at different depths relative
 * to ABSPATH, so we probe a few candidates and cache the first hit.
 *
 * @return string|null Absolute path to copyblocks.json, or null if not found.
 */
function blogtimer_copyblocks_path()
{
    static $path = null;
    static $looked = false;
    if (!$looked) {
        $looked = true;
        $candidates = [
            ABSPATH . '../datasets/copyblocks.json',       // Docker: repo root above wp/
            ABSPATH . 'datasets/copyblocks.json',          // datasets inside WP root
            '/var/www/datasets/copyblocks.json',           // Cloudways production layout
            WP_CONTENT_DIR . '/../datasets/copyblocks.json',
        ];
        foreach ($candidates as $c) {
            if (is_file($c)) {
                $path = $c;
                break;
            }
        }
    }
    return $path;
}

/**
 * Contact form subject labels.
 */
function blogtimer_contact_subjects()
{
    return [
        'general' => 'General Inquiry',
        'feature' => 'Feature Request',
        'bug' => 'Bug Report',
        'partnership' => 'Partnership Opportunity',
        'other' => 'Other',
    ];
}

/**
 * Handle contact form submission.
 */
function blogtimer_handle_contact_form()
{
    if (!isset($_POST['blogtimer_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['blogtimer_contact_nonce'])), 'blogtimer_contact_submit')) {
        wp_safe_redirect(add_query_arg('contact_status', 'invalid_nonce', home_url('/contact')), 302);
        exit;
    }

    // Honeypot field: silently accept to reduce bot retries.
    if (!empty($_POST['blogtimer_website'])) {
        wp_safe_redirect(add_query_arg('contact_status', 'success', home_url('/contact')), 302);
        exit;
    }

    $name = sanitize_text_field(wp_unslash($_POST['contact-name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['contact-email'] ?? ''));
    $subject_key = sanitize_key(wp_unslash($_POST['contact-subject'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['contact-message'] ?? ''));

    $subject_map = blogtimer_contact_subjects();

    if (strlen($name) < 2 || !is_email($email) || empty($subject_map[$subject_key]) || strlen($message) < 50) {
        wp_safe_redirect(add_query_arg('contact_status', 'validation_error', home_url('/contact')), 302);
        exit;
    }

    $email_subject = sprintf('[The Blog Timer] %s', $subject_map[$subject_key]);
    $email_body = implode("\n", [
        'A new contact form submission was received.',
        '',
        'Name: ' . $name,
        'Email: ' . $email,
        'Subject: ' . $subject_map[$subject_key],
        'Submitted At (UTC): ' . gmdate('Y-m-d H:i:s'),
        'IP Address: ' . sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? 'unknown')),
        '',
        'Message:',
        $message,
    ]);

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $sent = wp_mail(get_option('admin_email'), $email_subject, $email_body, $headers);

    wp_safe_redirect(add_query_arg('contact_status', $sent ? 'success' : 'send_error', home_url('/contact')), 302);
    exit;
}
add_action('admin_post_blogtimer_contact', 'blogtimer_handle_contact_form');
add_action('admin_post_nopriv_blogtimer_contact', 'blogtimer_handle_contact_form');

/**
 * Helper: render how-to steps
 */
function blogtimer_render_howto()
{
    $loader = Timer_Content_Loader::get_instance();
    $steps = [
        ['title' => $loader->get_string('howto.step1.title'), 'desc' => $loader->get_string('howto.step1.desc')],
        ['title' => $loader->get_string('howto.step2.title'), 'desc' => $loader->get_string('howto.step2.desc')],
        ['title' => $loader->get_string('howto.step3.title'), 'desc' => $loader->get_string('howto.step3.desc')],
    ];
    ?>
    <div class="steps-grid">
        <?php foreach ($steps as $i => $step): ?>
            <div class="step-card card">
                <span class="step-number"><?php echo $i + 1; ?></span>
                <h3><?php echo esc_html($step['title']); ?></h3>
                <p><?php echo esc_html($step['desc']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}



/**
 * Scroll-to-top button and fullscreen sync scripts
 */
add_action('wp_footer', function () {
    ?>
    <script>
        (function () {
            // Scroll-to-top button
            var scrollBtn = document.getElementById('scroll-top');
            if (scrollBtn) {
                var ticking = false;
                window.addEventListener('scroll', function () {
                    if (ticking) return;
                    ticking = true;
                    requestAnimationFrame(function () {
                        if (window.scrollY > 400) {
                            scrollBtn.classList.add('visible');
                        } else {
                            scrollBtn.classList.remove('visible');
                        }
                        ticking = false;
                    });
                });
                scrollBtn.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        })();
    </script>
    <?php
}, 99);

// ==========================================
// SECURITY HARDENING
// ==========================================

/**
 * Disable XML-RPC entirely (brute force and DDoS attack vector)
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', function () {
    return [];
});

/**
 * Remove WordPress version from HTML head, RSS feeds, and scripts
 * Attackers use version info to find known vulnerabilities
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
add_filter('style_loader_src', 'blogtimer_remove_version_query', 9999);
add_filter('script_loader_src', 'blogtimer_remove_version_query', 9999);
function blogtimer_remove_version_query($src)
{
    if (strpos($src, 'ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

/**
 * Disable user enumeration via REST API (prevents username discovery)
 * Attackers use /?rest_route=/wp/v2/users to find admin usernames
 */
add_filter('rest_endpoints', function ($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

/**
 * Block author enumeration via ?author=N queries
 */
add_action('template_redirect', function () {
    if (is_author() && !is_admin()) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
});

/**
 * Disable application passwords (added in WP 5.6 - often overlooked attack surface)
 */
add_filter('wp_is_application_passwords_available', '__return_false');

/**
 * Remove unnecessary header information
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Limit login attempts - basic rate limiting
 * Blocks IP after 5 failed attempts for 15 minutes
 */
add_filter('authenticate', function ($user, $username, $password) {
    if (empty($username) || empty($password)) {
        return $user;
    }

    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);

    if ($attempts !== false && (int) $attempts >= 5) {
        return new WP_Error(
            'too_many_attempts',
            'Too many failed login attempts. Please try again in 15 minutes.'
        );
    }

    return $user;
}, 30, 3);

add_action('wp_login_failed', function ($username) {
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);

    if ($attempts === false) {
        set_transient($transient_key, 1, 15 * MINUTE_IN_SECONDS);
    } else {
        set_transient($transient_key, (int) $attempts + 1, 15 * MINUTE_IN_SECONDS);
    }
});

/**
 * Disable pingbacks entirely (used in DDoS amplification attacks)
 */
add_filter('pings_open', '__return_false', 9999);

// ==========================================
// SPAM DE-INDEXING & CRAWLER CONTROL
// ==========================================

/**
 * Canonical public page slugs that are allowed to be indexed and listed in sitemaps.
 *
 * Keep this as the single source of truth for page-level crawl/index controls.
 * Timer and guide CPT URLs, the guide archive, and approved custom taxonomies are
 * handled separately by post-type/taxonomy checks.
 */
function blogtimer_indexable_page_slugs()
{
    return [
        'home', 'about', 'contact', 'faq',
        'privacy-policy', 'terms-of-service',
        'minute-timers', 'second-timers',
        'pomodoro', 'use-cases',
        'disclaimer', 'dmca', 'accessibility',
        'editorial-policy',
        'methodology', 'sources', 'author-suraj-giri', 'changelog',
        'chess-clock', 'egg-timer', 'interval-timer',
        'nap-timer', 'sprint-timer', 'presentation-timer',
        'timer-for', 'timer-for-kids', 'timer-for-remote-workers',
        'stopwatch',
        'online-alarm-clock',
        'countdown-timer',
        'sleep-timer',
        'world-clock',
        'focus-timer',
        'study-timer',
        'tabata-timer',
        'cooking-timers',
        'workout-timers',
        'sleep-meditation-timers',
        'study-work-timers',
        'stopwatch-clock-tools',
        'pasta-timer',
        'tea-timer',
        'coffee-timer',
        'steak-timer',
        'rice-timer',
        'turkey-timer',
        'bread-baking-timer',
        'microwave-popcorn-timer',
        'sous-vide-timer',
        'bbq-timer',
        'baby-bottle-timer',
        'boxing-round-timer',
        'hiit-timer',
        'yoga-timer',
        'plank-timer',
        'jump-rope-timer',
        'running-interval-timer',
        'stretching-timer',
        'crossfit-amrap-timer',
        'emom-timer',
        'hour-timers',
        'site-index',
        'animals',
        'travel',
        'auto',
        'beauty',
        'body',
        'health',
    ];
}

function blogtimer_indexable_taxonomies()
{
    return ['timer_unit', 'timer_bucket', 'timer_usecase'];
}

/**
 * Override WordPress default robots.txt with strict version
 * This tells Google and all crawlers to ONLY index known-good URL patterns
 */
add_filter('robots_txt', function ($output, $public) {
    // Build a strict robots.txt that whitelists only legitimate paths
    $robots = "# robots.txt for The Blog Timer\n";
    $robots .= "# Security hardened - blocks spam/injected pages from being indexed\n\n";

    // Sitemap location — sitemap-fresh.xml ONLY. WP core sitemaps are disabled
    // (see wp_sitemaps_enabled below); advertising both confused Google.
    $robots .= "Sitemap: " . home_url('/sitemap-fresh.xml') . "\n\n";

    // Allow all legitimate bots to crawl whitelisted content
    $robots .= "User-agent: *\n";

    // Block sensitive WordPress paths
    $robots .= "Disallow: /wp-admin/\n";
    $robots .= "Allow: /wp-admin/admin-ajax.php\n";
    $robots .= "Disallow: /wp-includes/\n";
    $robots .= "Disallow: /wp-content/plugins/\n";
    $robots .= "Disallow: /wp-content/cache/\n";
    $robots .= "Disallow: /wp-json/\n";
    $robots .= "Disallow: /xmlrpc.php\n";
    $robots .= "Disallow: /wp-login.php\n";
    $robots .= "Disallow: /wp-register.php\n";
    $robots .= "Disallow: /wp-trackback.php\n";
    $robots .= "Disallow: /wp-cron.php\n";
    $robots .= "Disallow: /readme.html\n";
    $robots .= "Disallow: /license.txt\n";

    // Block query parameter abuse (common in Japanese keyword hacks)
    $robots .= "Disallow: /*?\n";
    $robots .= "Disallow: /*&\n";

    // Block feed URLs (often abused to create spam pages)
    $robots .= "Disallow: /feed/\n";
    $robots .= "Disallow: /*/feed/\n";
    $robots .= "Disallow: /comments/feed/\n";

    // Block author pages (used in enumeration)
    $robots .= "Disallow: /author/\n";

    // Block tag and date archives (often spam vectors)
    $robots .= "Disallow: /tag/\n";
    $robots .= "Disallow: /category/\n";
    $robots .= "Disallow: /20*/\n";

    // Block trackback and comment pages
    $robots .= "Disallow: /*/trackback/\n";
    $robots .= "Disallow: /*/comment-page-*\n";

    // Block attachment pages
    $robots .= "Disallow: /attachment/\n\n";

    // Explicitly allow only legitimate content paths
    $robots .= "# Allowed paths (legitimate content only)\n";
    $robots .= "Allow: /timer/*\n";
    $robots .= "Allow: /guides/*\n";
    $robots .= "Allow: /minute-timers\n";
    $robots .= "Allow: /second-timers\n";
    $robots .= "Allow: /pomodoro\n";
    $robots .= "Allow: /use-cases\n";
    $robots .= "Allow: /animals\n";
    $robots .= "Allow: /travel\n";
    $robots .= "Allow: /auto\n";
    $robots .= "Allow: /beauty\n";
    $robots .= "Allow: /body\n";
    $robots .= "Allow: /health\n";
    $robots .= "Allow: /chess-clock\n";
    $robots .= "Allow: /egg-timer\n";
    $robots .= "Allow: /interval-timer\n";
    $robots .= "Allow: /nap-timer\n";
    $robots .= "Allow: /sprint-timer\n";
    $robots .= "Allow: /presentation-timer\n";
    $robots .= "Allow: /timer-for\n";
    $robots .= "Allow: /timer-for-kids\n";
    $robots .= "Allow: /timer-for-remote-workers\n";
    $robots .= "Allow: /about\n";
    $robots .= "Allow: /contact\n";
    $robots .= "Allow: /faq\n";
    $robots .= "Allow: /privacy-policy\n";
    $robots .= "Allow: /terms-of-service\n";
    $robots .= "Allow: /disclaimer\n";
    $robots .= "Allow: /dmca\n";
    $robots .= "Allow: /accessibility\n";
    $robots .= "Allow: /editorial-policy\n";
    $robots .= "Allow: /wp-content/uploads/\n";
    $robots .= "Allow: /wp-content/themes/\n\n";

    return $robots;
}, 10, 2);

/**
 * Add meta noindex to non-legitimate pages
 * This is the most authoritative way to tell Google to de-index a page
 * Google treats meta robots as a DIRECTIVE (must obey), not a suggestion
 */
add_action('wp_head', function () {
    $allowed_pages = blogtimer_indexable_page_slugs();

    // Timer (/timer/*) and guide (/guides/*) CPT pages must ALWAYS be indexable.
    // This post-type check runs BEFORE any slug whitelist so a newly published
    // timer/guide can never be accidentally noindexed by an out-of-date list.
    if (is_singular(['timer', 'guide'])) {
        return;
    }

    // The guide CPT archive (/guides/) and the legitimate custom taxonomies are
    // indexable programmatic-SEO hubs — must NOT be noindexed.
    if (is_post_type_archive('guide') || is_tax(blogtimer_indexable_taxonomies())) {
        return;
    }

    // Allow the front page
    if (is_front_page() || is_home()) {
        return;
    }

    // Allow known legitimate pages by slug
    if (is_page($allowed_pages)) {
        return;
    }

    // Everything else gets noindex, nofollow - this covers any injected spam
    echo '<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">' . "\n";
}, 1);

/**
 * Send X-Robots-Tag HTTP header for noindex on non-legitimate pages
 * Belt-and-suspenders approach: header + meta tag
 */
add_action('send_headers', function () {
    $allowed_pages = blogtimer_indexable_page_slugs();

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    $path = $request_uri !== '' ? wp_parse_url($request_uri, PHP_URL_PATH) : '';
    if ($path && preg_match('#/(robots\.txt|sitemap-fresh\.xml|wp-sitemap.*\.xml)$#', $path)) {
        return;
    }
    if ($path && isset(blogtimer_timer_for_redirect_map()[rtrim($path, '/')])) {
        return;
    }

    // Timer (/timer/*) and guide (/guides/*) CPT pages must ALWAYS be indexable.
    // Post-type check runs BEFORE the slug whitelist for the same reason as above.
    if (is_singular(['timer', 'guide'])) {
        return;
    }

    // The guide CPT archive (/guides/) and the legitimate custom taxonomies are
    // indexable programmatic-SEO hubs — must NOT be noindexed.
    if (is_post_type_archive('guide') || is_tax(blogtimer_indexable_taxonomies())) {
        return;
    }

    if (is_front_page() || is_home()) {
        return;
    }
    if (is_page($allowed_pages)) {
        return;
    }

    header('X-Robots-Tag: noindex, nofollow, noarchive', true);
}, 1);

/**
 * Fully disable WP core sitemaps (/wp-sitemap*.xml).
 *
 * The site runs a single sitemap system: /sitemap-fresh.xml (submitted to GSC).
 * Running wp-sitemap.xml alongside it fed Google thin taxonomy index sitemaps
 * and split discovery signals across two systems. sitemap-fresh.xml carries all
 * timer/guide/page URLs PLUS the /timer-unit/*, /timer-bucket/*, /timer-usecase/*
 * taxonomy archives, so nothing loses sitemap presence.
 *
 * The wp_sitemaps_* filters below are intentionally KEPT (not dead code removal
 * candidates): wp_sitemaps_add_provider still fires during core registration
 * even when disabled, and the whole set is the safety net that keeps spam/thin
 * URLs out of wp-sitemap.xml if core sitemaps are ever re-enabled.
 */
add_filter('wp_sitemaps_enabled', '__return_false');

/**
 * Remove spam pages from WordPress default sitemap
 * Only include legitimate content types in the sitemap
 */
add_filter('wp_sitemaps_post_types', function ($post_types) {
    // Only allow timer and guide post types in sitemap
    $allowed = ['timer', 'guide', 'page'];
    foreach ($post_types as $key => $value) {
        if (!in_array($key, $allowed, true)) {
            unset($post_types[$key]);
        }
    }
    return $post_types;
});

/**
 * Keep only approved taxonomy sitemaps.
 */
add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    $allowed = blogtimer_indexable_taxonomies();
    foreach ($taxonomies as $key => $value) {
        if (!in_array($key, $allowed, true)) {
            unset($taxonomies[$key]);
        }
    }
    return $taxonomies;
});

/**
 * Remove author sitemaps
 */
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    if ($name === 'users') {
        return false;
    }
    return $provider;
}, 10, 2);

/**
 * Filter out any non-legitimate pages from the sitemap
 */
/**
 * Cache + robots headers for robots.txt and sitemap XML responses.
 *
 * These used to send no-store/no-cache, which forced a full WordPress boot on
 * EVERY crawler fetch — GSC logged 53.7% of crawl responses as "robots.txt not
 * available" and a 3-week crawl outage. A 1-hour cache window keeps them fresh
 * enough for GSC while letting Nginx/Varnish absorb repeat fetches.
 *
 * robots.txt is normally a physical file served by Nginx (see repo-root
 * robots.txt deployed to public_html); this branch is only the WP fallback.
 *
 * X-Robots-Tag: noindex on sitemap XML keeps the sitemap files themselves out
 * of web search results (they were ranking at position 7-16) — Google still
 * reads noindexed sitemaps for URL discovery.
 */
add_action('send_headers', function () {
    if (!isset($_SERVER['REQUEST_URI'])) { return; }
    $uri = $_SERVER['REQUEST_URI'];
    if (preg_match('#/(robots\.txt|(wp-)?sitemap[^/]*\.xml)#', $uri)) {
        header('Cache-Control: public, max-age=3600', true);
        header('X-Accel-Expires: 3600', true);  // Nginx-specific cache lifetime
        if (preg_match('#/robots\.txt$#', (string) parse_url($uri, PHP_URL_PATH))) {
            header('Content-Type: text/plain; charset=utf-8', true);
        } else {
            header('X-Robots-Tag: noindex', true);
        }
    }
}, 1);

/**
 * Fresh custom sitemap endpoint that bypasses the Cloudways Nginx page cache.
 * Handled at parse_request (very early) to avoid WP's canonical-redirect for unknown URLs.
 * Accessible at /sitemap-fresh.xml — submit this to GSC.
 */
add_action('parse_request', function ($wp) {
    if (!isset($_SERVER['REQUEST_URI'])) { return; }
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($path !== '/sitemap-fresh.xml') { return; }

    // Cacheable for 1 hour: the old no-store headers forced a WP boot on every
    // Googlebot fetch (GSC "robots.txt not available" / crawl-outage root cause).
    // This handler exits before send_headers fires, so headers live here.
    // noindex keeps the XML file itself out of web search results; Google still
    // reads noindexed sitemaps for URL discovery.
    header('Content-Type: application/xml; charset=UTF-8');
    header('Cache-Control: public, max-age=3600');
    header('X-Accel-Expires: 3600');
    header('X-Robots-Tag: noindex');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Accurate <lastmod> tells Google which URLs actually changed so re-crawl
    // budget goes to fresh content first. Only emit dates we genuinely track
    // (post_modified_gmt) — fabricated lastmod values teach Google to ignore them.
    $sitemap_url = static function ($loc, $modified_gmt = '') {
        $lastmod = '';
        if ($modified_gmt && $modified_gmt !== '0000-00-00 00:00:00') {
            $lastmod = '<lastmod>' . esc_html(gmdate('Y-m-d', strtotime($modified_gmt))) . '</lastmod>';
        }
        echo '  <url><loc>' . esc_url($loc) . '</loc>' . $lastmod . '</url>' . "\n";
    };

    // Homepage: lastmod = most recently modified content anywhere on the site.
    $latest = get_posts([
        'post_type' => ['timer', 'guide', 'page'],
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ]);
    $sitemap_url(home_url('/'), $latest ? $latest[0]->post_modified_gmt : '');

    // Add all whitelisted pages.
    foreach (blogtimer_indexable_page_slugs() as $slug) {
        $page = get_page_by_path($slug);
        if ($page && $page->post_status === 'publish') {
            $sitemap_url(get_permalink($page->ID), $page->post_modified_gmt);
        }
    }

    $guides_archive = get_post_type_archive_link('guide');
    if ($guides_archive) {
        echo '  <url><loc>' . esc_url($guides_archive) . '</loc></url>' . "\n";
    }

    foreach (blogtimer_indexable_taxonomies() as $taxonomy) {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);
        if (is_wp_error($terms) || empty($terms)) {
            continue;
        }
        foreach ($terms as $term) {
            $term_url = get_term_link($term);
            if (!is_wp_error($term_url)) {
                echo '  <url><loc>' . esc_url($term_url) . '</loc></url>' . "\n";
            }
        }
    }

    // All timer posts
    $timers = get_posts(['post_type' => 'timer', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($timers as $timer_post) {
        $sitemap_url(get_permalink($timer_post->ID), $timer_post->post_modified_gmt);
    }

    // All guide posts
    $guides = get_posts(['post_type' => 'guide', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($guides as $guide_post) {
        $sitemap_url(get_permalink($guide_post->ID), $guide_post->post_modified_gmt);
    }

    echo '</urlset>' . "\n";
    exit;
});

add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
    if ($post_type === 'page') {
        $args['post_name__in'] = blogtimer_indexable_page_slugs();
    }
    return $args;
}, 10, 2);

/**
 * Add security headers via PHP (backup for .htaccess headers)
 */
add_action('send_headers', function () {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        // CSP + HSTS live here (not only .htaccess): the Cloudways nginx/Varnish
        // stack drops Apache-set headers on HTML responses; PHP-set ones survive.
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com; style-src 'self' 'unsafe-inline'; font-src 'self'; img-src 'self' data: https://images.unsplash.com https://source.unsplash.com https://*.google-analytics.com https://www.googletagmanager.com; connect-src 'self' https://*.google-analytics.com https://*.analytics.google.com https://www.googletagmanager.com; frame-ancestors 'self'");
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    }
});

// ==========================================
// CANONICAL TAGS & META ENHANCEMENTS
// ==========================================

// The theme prints its own comprehensive canonical (singular/page/tax/archive).
// Remove WP core's rel_canonical (singular/front only) so we don't emit two.
remove_action('wp_head', 'rel_canonical', 10);

/**
 * Output canonical URL, hreflang, and enhanced meta tags in wp_head.
 */
add_action('wp_head', function () {
    $canonical = '';

    if (is_front_page() || is_home()) {
        $canonical = home_url('/');
    } elseif (is_singular()) {
        $canonical = get_permalink();
    } elseif (is_page()) {
        $canonical = get_permalink();
    } elseif (is_tax() || is_category() || is_tag()) {
        $term = get_queried_object();
        if ($term) {
            $canonical = get_term_link($term);
            if (is_wp_error($canonical)) {
                $canonical = '';
            }
        }
    } elseif (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }
        $canonical = get_post_type_archive_link($post_type ?: 'post');
    }

    if (!empty($canonical)) {
        $canonical = blogtimer_untrailingslashit_url($canonical);
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        echo '<link rel="alternate" hreflang="en" href="' . esc_url($canonical) . '">' . "\n";
    }

    // Open Graph tags
    $og_title = wp_get_document_title();
    $og_desc = get_bloginfo('description');
    $og_type = 'website';
    // Fallback chain: post thumbnail (singular, set below) → site icon → theme default.
    $og_image = get_site_icon_url(512) ?: get_template_directory_uri() . '/images/og-default.png';

    if (is_singular()) {
        $og_type = 'article';
        $post_obj = get_queried_object();
        if ($post_obj) {
            $excerpt = $post_obj->post_excerpt ?: wp_trim_words(strip_tags($post_obj->post_content), 25, '...');
            if ($excerpt) {
                $og_desc = $excerpt;
            }
            if (has_post_thumbnail($post_obj->ID)) {
                $og_image = get_the_post_thumbnail_url($post_obj->ID, 'large');
            }
            echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c', $post_obj)) . '">' . "\n";
            echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c', $post_obj)) . '">' . "\n";
        }
    }

    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_desc) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($canonical ?: home_url('/')) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    echo '<meta property="og:site_name" content="The Blog Timer">' . "\n";
    echo '<meta property="og:locale" content="en_US">' . "\n";

    // Twitter Card tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($og_desc) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
}, 2);

// ==========================================
// JSON-LD SCHEMA MARKUP
// ==========================================

/**
 * Build the CollectionPage + ItemList graph for public timer taxonomy archives.
 *
 * @param WP_Term $term Current timer taxonomy term.
 * @param string  $org_id Stable Organization @id.
 * @param string  $website_id Stable WebSite @id.
 * @param string  $breadcrumb_id Stable BreadcrumbList @id for this archive.
 * @return array|null
 */
function blogtimer_get_timer_taxonomy_archive_schema($term, $org_id, $website_id, $breadcrumb_id)
{
    if (!$term instanceof WP_Term || !in_array($term->taxonomy, blogtimer_indexable_taxonomies(), true)) {
        return null;
    }

    $term_url = get_term_link($term);
    if (is_wp_error($term_url) || empty($term_url)) {
        return null;
    }

    $term_url = blogtimer_untrailingslashit_url($term_url);
    $page_id = $term_url . '#webpage';
    $item_list_id = $term_url . '#itemlist';
    $term_name = single_term_title('', false);
    if ($term_name === '') {
        $term_name = $term->name;
    }

    $description = trim(wp_strip_all_tags(term_description((int) $term->term_id, $term->taxonomy)));
    if ($description === '') {
        if ($term->taxonomy === 'timer_unit') {
            $description = sprintf(
                'Browse all %s countdown timers with instant start, reliable alerts, and clean interfaces for productivity, workouts, cooking, and daily routines.',
                strtolower($term->name)
            );
        } elseif ($term->taxonomy === 'timer_usecase') {
            $description = sprintf(
                'Discover timers for %s, including recommended durations and focused countdown pages that help you stay on pace.',
                strtolower($term->name)
            );
        } else {
            $description = sprintf(
                'Explore %s and choose the right countdown duration for your task with practical recommendations and one-click start links.',
                strtolower($term->name)
            );
        }
    }

    $timer_query = new WP_Query([
        'post_type' => 'timer',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => $term->taxonomy,
                'field' => 'term_id',
                'terms' => (int) $term->term_id,
            ],
        ],
        'meta_key' => '_timer_value',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    ]);

    $list_items = [];
    $position = 1;
    foreach ($timer_query->posts as $timer_post) {
        $timer_url = blogtimer_untrailingslashit_url(get_permalink($timer_post));
        if (empty($timer_url)) {
            continue;
        }

        $list_items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'item' => [
                '@type' => 'WebPage',
                '@id' => $timer_url . '#webpage',
                'url' => $timer_url,
                'name' => get_the_title($timer_post),
            ],
        ];
    }
    wp_reset_postdata();

    $item_list = [
        '@type' => 'ItemList',
        '@id' => $item_list_id,
        'name' => $term_name . ' timer pages',
        'numberOfItems' => count($list_items),
        'itemListElement' => $list_items,
    ];

    return [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        '@id' => $page_id,
        'url' => $term_url,
        'name' => $term_name,
        'description' => wp_trim_words($description, 40, '...'),
        'isPartOf' => [
            '@id' => $website_id,
        ],
        'publisher' => [
            '@id' => $org_id,
        ],
        'breadcrumb' => [
            '@id' => $breadcrumb_id,
        ],
        'mainEntity' => $item_list,
    ];
}

/**
 * Keep timer taxonomy archive JSON-LD consolidated in the theme graph.
 */
add_action('wp_head', function () {
    if (!is_tax(blogtimer_indexable_taxonomies()) || !class_exists('Timer_Engine')) {
        return;
    }

    remove_action('wp_head', [Timer_Engine::get_instance(), 'output_schema'], 99);
}, 4);

/**
 * Output JSON-LD structured data in wp_head.
 */
add_action('wp_head', function () {
    $schemas = [];
    $site_url = home_url('/');
    $site_name = 'The Blog Timer';

    // ── Canonical entity @ids (SHARED CONTRACT — other agents/templates rely on these exact values) ──
    // Single source of truth for the site-wide Organization, WebSite, and Person nodes.
    // Person @id points at the canonical author URL (/author-suraj-giri/). The author-bio
    // and methodology templates emit the full Person node; here we only reference it by @id
    // so Google consolidates the entity instead of seeing competing/anonymous nodes.
    $org_id = home_url('/#organization');
    $website_id = home_url('/#website');
    $person_id = home_url('/author-suraj-giri') . '#person';
    $current_url = blogtimer_untrailingslashit_url(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')));
    $breadcrumb_id = $current_url . '#breadcrumb';

    // F-11 (resolved): Google requires a RASTER logo ≥112x112px for Article / rich
    // results — SVG is not accepted. The theme now ships a deterministic 512px PNG
    // (images/favicon-512.png, generated from favicon.svg) used for the Organization
    // schema logo and, at smaller sizes, the favicon link tags in header.php. No
    // longer depends on the WP site-icon being configured.
    $logo_url  = get_theme_file_uri('images/favicon-512.png');
    $logo_size = ['width' => 512, 'height' => 512];

    // Organization schema — every page. SINGLE consolidated node (stable @id).
    // This is the ONLY Organization output site-wide; the plugin's duplicate has been neutralized.
    $schemas[] = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => $org_id,
        'name' => $site_name,
        'url' => $site_url,
        // Source-Context "evidence-based timing" message — the E-E-A-T differentiator.
        'description' => 'The most rigorously researched timing resource on the web — evidence-based "how long should I…" guides and accurate countdown tools, with every duration sourced to research.',
        'logo' => array_merge(
            ['@type' => 'ImageObject', 'url' => $logo_url],
            $logo_size ? ['width' => $logo_size['width'], 'height' => $logo_size['height']] : []
        ),
        // TODO: confirm founding year
        'foundingDate' => '2025',
        'founder' => [
            '@id' => $person_id,
        ],
        // TODO: orchestrator populates real social/Wikidata/Crunchbase URLs — do NOT invent
        'sameAs' => [],
        // Topical-authority claim, anchored to Knowledge Graph entities.
        // All Wikipedia URLs verified live (HTTP 200, 2026-07-10).
        'knowsAbout' => [
            ['@type' => 'Thing', 'name' => 'Time management', 'sameAs' => 'https://en.wikipedia.org/wiki/Time_management'],
            ['@type' => 'Thing', 'name' => 'Pomodoro Technique', 'sameAs' => 'https://en.wikipedia.org/wiki/Pomodoro_Technique'],
            ['@type' => 'Thing', 'name' => 'Timer', 'sameAs' => 'https://en.wikipedia.org/wiki/Timer'],
            ['@type' => 'Thing', 'name' => 'Time perception', 'sameAs' => 'https://en.wikipedia.org/wiki/Time_perception'],
            ['@type' => 'Thing', 'name' => 'High-intensity interval training', 'sameAs' => 'https://en.wikipedia.org/wiki/High-intensity_interval_training'],
            ['@type' => 'Thing', 'name' => 'Meditation', 'sameAs' => 'https://en.wikipedia.org/wiki/Meditation'],
        ],
        'publishingPrinciples' => blogtimer_untrailingslashit_url(home_url('/editorial-policy')),
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer support',
            'url' => blogtimer_untrailingslashit_url(home_url('/contact')),
            'email' => 'suraj@theblogtimer.com',
        ],
    ];

    // WebSite schema — every page. SINGLE consolidated node (stable @id).
    // Emitted site-wide (not just the homepage) so the many isPartOf/publisher
    // references to #website resolve inside the same page's graph — crawlers
    // shouldn't have to visit the homepage to dereference the node.
    // This is the ONLY WebSite output site-wide; the plugin's duplicate has been neutralized.
    $schemas[] = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $website_id,
        'name' => $site_name,
        'url' => $site_url,
        'description' => 'Evidence-based timing: research-backed "how long should I…" guides and accurate online countdown, Pomodoro, and stopwatch tools.',
        'publisher' => [
            '@id' => $org_id,
        ],
    ];

    // WebApplication schema — homepage and single timer pages
    if (is_front_page() || is_singular('timer')) {
        $app_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $site_name,
            'url' => $site_url,
            'applicationCategory' => 'UtilitiesApplication',
            'operatingSystem' => 'Any',
            'browserRequirements' => 'Requires JavaScript',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
            'featureList' => [
                'Timestamp-based precision timing',
                'Background tab accuracy',
                'Audio completion alerts',
                'Keyboard shortcuts (Space, R, F)',
                'Fullscreen mode',
                'Custom timer naming',
                'Local storage state persistence',
            ],
        ];

        if (is_singular('timer')) {
            $post_id = get_the_ID();
            $value = Timer_Engine::get_timer_value($post_id);
            $unit = Timer_Engine::get_timer_unit($post_id);
            $unit_label_schema = ucfirst($unit);
            if ($unit === 'hours' && (int) $value === 1) {
                $unit_label_schema = 'Hour';
            }
            $app_schema['name'] = "Set Timer for {$value} " . $unit_label_schema;
            $app_schema['url'] = get_permalink($post_id);
        }

        $schemas[] = $app_schema;
    }

    // BreadcrumbList schema — all pages except homepage
    if (!is_front_page()) {
        $breadcrumb_items = [];
        $position = 1;

        $breadcrumb_items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Home',
            'item' => $site_url,
        ];

        if (is_singular('timer')) {
            $post_id = get_the_ID();
            $unit = Timer_Engine::get_timer_unit($post_id);
            if ($unit === 'minutes') {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'Minute Timers',
                    'item' => blogtimer_untrailingslashit_url(home_url('/minute-timers')),
                ];
            } elseif ($unit === 'hours') {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'Hour Timers',
                    'item' => blogtimer_untrailingslashit_url(home_url('/hour-timers')),
                ];
            } else {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'Second Timers',
                    'item' => blogtimer_untrailingslashit_url(home_url('/second-timers')),
                ];
            }
            $breadcrumb_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
            ];
        } elseif (is_singular('guide')) {
            $breadcrumb_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Guides',
                'item' => blogtimer_untrailingslashit_url(home_url('/guides')),
            ];
            // Cluster level — the /guide-cluster/{term}/ archive 404s and is redirected,
            // so the cluster crumb links to the /guides/ hub rather than the dead archive.
            $guide_cluster_crumb = blogtimer_guide_cluster_crumb();
            if ($guide_cluster_crumb) {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $guide_cluster_crumb['label'],
                    'item' => blogtimer_untrailingslashit_url(home_url('/guides')),
                ];
            }
            $breadcrumb_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
            ];
        } elseif (is_page()) {
            $breadcrumb_items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
            ];
        } elseif (is_tax() || is_category() || is_tag()) {
            $term = get_queried_object();
            if ($term) {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $term->name,
                ];
            }
        }

        if (count($breadcrumb_items) > 1) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                '@id' => $breadcrumb_id,
                'itemListElement' => $breadcrumb_items,
            ];
        }
    }

    if (is_tax(blogtimer_indexable_taxonomies())) {
        $taxonomy_schema = blogtimer_get_timer_taxonomy_archive_schema(get_queried_object(), $org_id, $website_id, $breadcrumb_id);
        if (!empty($taxonomy_schema)) {
            $schemas[] = $taxonomy_schema;
        }
    }

    // FAQPage schema — every page that renders a visible FAQ block (except guide
    // pages, which emit their own). Google requires the Question/Answer text in the
    // markup to mirror the visible on-page FAQ, so each branch here sources from the
    // SAME data the corresponding template renders.
    if (!is_singular('guide')) {
        $faq_items = [];

        if (is_front_page() || is_page(['minute-timers', 'second-timers', 'faq'])) {
            // F-09: previously this used a single hardcoded path
            // (ABSPATH . '../datasets/copyblocks.json') that does not resolve on the
            // Cloudways production layout, so FAQPage silently never emitted on the
            // homepage. Use the shared multi-candidate resolver instead.
            $copyblocks_path = blogtimer_copyblocks_path();
            if ($copyblocks_path) {
                $cb = json_decode(file_get_contents($copyblocks_path), true);
                if (!empty($cb['faqs'])) {
                    $count = 0;
                    foreach ($cb['faqs'] as $key => $faq) {
                        if (strpos($key, 'faq_timer_') === 0 && isset($faq['en'])) {
                            $faq_items[] = [
                                '@type' => 'Question',
                                'name' => $faq['en']['q'],
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => $faq['en']['a'],
                                ],
                            ];
                            $count++;
                            if (is_front_page() && $count >= 5) break;
                            if (is_page(['minute-timers', 'second-timers']) && $count >= 6) break;
                        }
                    }
                }
            }
        } elseif (is_page('pomodoro')) {
            if (class_exists('Timer_Content_Loader')) {
                $loader = Timer_Content_Loader::get_instance();
                $pom_faqs = $loader->get_pomodoro_faqs();
                if (!empty($pom_faqs)) {
                    foreach ($pom_faqs as $faq) {
                        $faq_items[] = [
                            '@type' => 'Question',
                            'name' => $faq['q'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $faq['a'],
                            ],
                        ];
                    }
                }
            }
        } elseif (is_singular('timer')) {
            // F-09: single timer pages render their FAQ via
            // Timer_Content_Loader::get_faqs($post, 4) in single-timer.php. To satisfy
            // Google's schema-mirrors-visible-content rule, the FAQPage markup is built
            // from that EXACT same loader call (same post, same count, same rotation),
            // guaranteeing the Question name/text matches what the visitor sees.
            //
            // VARIETY, not suppression: get_faqs() rotates the shared faq_timer_* pool
            // by the timer's numeric value (offset = value % pool_size), so the 4-Q
            // subset and its ordering differ across the ~233 timer pages — the emitted
            // JSON-LD is NOT byte-identical, avoiding the boilerplate-detection signal.
            // Deepening this to per-bucket question sets requires expanding the FAQ
            // pool in datasets/copyblocks.json (see TODO(F-09) below).
            if (class_exists('Timer_Content_Loader')) {
                $timer_post = get_post(get_the_ID());
                if ($timer_post) {
                    $loader = Timer_Content_Loader::get_instance();
                    $timer_faqs = $loader->get_faqs($timer_post, 4);
                    if (!empty($timer_faqs)) {
                        foreach ($timer_faqs as $faq) {
                            if (empty($faq['q']) || empty($faq['a'])) {
                                continue;
                            }
                            $faq_items[] = [
                                '@type' => 'Question',
                                'name' => $faq['q'],
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => $faq['a'],
                                ],
                            ];
                        }
                    }
                }
            }
            // TODO(F-09): for fuller per-duration variety (3-4 genuinely different
            // question sets per bucket: short <10min / medium 10-30 / long 30-90 /
            // extended >90, and seconds vs minutes vs hours), add bucket-scoped FAQ
            // entries to datasets/copyblocks.json (e.g. faq_timer_short_*, _medium_*,
            // _long_*, _extended_*) and extend Timer_Content_Loader::get_faqs() to pick
            // the bucket's set before rotating. The schema here will inherit that
            // variety automatically since it mirrors get_faqs(). Editing copyblocks.json
            // and the loader is outside this file's boundary.
        }

        if (!empty($faq_items)) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq_items,
            ];
        }
    }

    // HowTo schema removed 2026-07-31: Google dropped HowTo rich results in 2023,
    // and one identical block across the front page + all timers + hubs was
    // boilerplate. The visible how-to steps still render on the pages.

    // ItemList schema — category hub pages
    if (is_page('minute-timers') || is_page('second-timers')) {
        $unit = is_page('minute-timers') ? 'minutes' : 'seconds';
        if (class_exists('Timer_Related')) {
            $related = Timer_Related::get_instance();
            $popular = $related->get_popular_posts($unit, 10);
            if (!empty($popular)) {
                $list_items = [];
                $pos = 1;
                foreach ($popular as $t) {
                    $list_items[] = [
                        '@type' => 'ListItem',
                        'position' => $pos++,
                        'name' => $t['value'] . ' ' . ucfirst($t['unit']) . ' Timer',
                        'url' => get_permalink($t['post']->ID),
                    ];
                }
                $schemas[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'name' => is_page('minute-timers') ? 'Popular Minute Timers' : 'Popular Second Timers',
                    'numberOfItems' => count($list_items),
                    'itemListElement' => $list_items,
                ];
            }
        }
    }

    // Output all schemas
    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}, 5);

// ==========================================
// INTERNAL LINKING HELPERS
// ==========================================

/**
 * Render cross-links to sibling category pages.
 *
 * @param string $current_page Slug of the current page to exclude.
 */
function blogtimer_render_related_categories($current_page = '')
{
    $categories = [
        'minute-timers' => ['label' => 'Minute Timers', 'desc' => 'Countdown timers from 1 to 100+ minutes for productivity, cooking, and deep work.'],
        'second-timers' => ['label' => 'Second Timers', 'desc' => 'Precision timers from 1 to 60 seconds for HIIT, cooking, and quick intervals.'],
        'pomodoro'      => ['label' => 'Pomodoro Timer', 'desc' => 'Structured 25-minute work sessions with breaks using the Pomodoro Technique.'],
        'use-cases'     => ['label' => 'Timer Use Cases', 'desc' => 'Timers organized by activity: productivity, cooking, exercise, meditation, studying.'],
        'faq'           => ['label' => 'FAQ', 'desc' => 'Answers to common questions about online timers, accuracy, and features.'],
    ];

    $links = [];
    foreach ($categories as $slug => $data) {
        if ($slug === $current_page) continue;
        $links[] = $data + ['slug' => $slug];
    }

    if (empty($links)) return;
    ?>
    <section class="section related-categories-section">
        <h2 class="section-title">Explore Other Timer Categories</h2>
        <div class="taxonomy-hub-grid">
            <?php foreach ($links as $link): ?>
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url(home_url('/' . $link['slug'] . '/')); ?>"><?php echo esc_html($link['label']); ?></a></h3>
                    <p><?php echo esc_html($link['desc']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

/**
 * Resolve the breadcrumb cluster label/url for a single guide.
 *
 * Derives the cluster from the guide's `guide_cluster` term (term name as label).
 * Because the /guide-cluster/{term}/ archive 404s and is redirected, the cluster
 * crumb links to the /guides/ hub rather than the dead taxonomy archive.
 *
 * @param int|null $post_id Guide post ID (defaults to current post).
 * @return array|null ['label' => string, 'url' => string] or null when no cluster.
 */
function blogtimer_guide_cluster_crumb($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();
    $cluster_terms = get_the_terms($post_id, 'guide_cluster');
    if (empty($cluster_terms) || is_wp_error($cluster_terms)) {
        return null;
    }
    $cluster_term = reset($cluster_terms);
    return [
        'label' => $cluster_term->name,
        // Cluster archive 404s; point the labeled step at the guides hub instead.
        'url'   => home_url('/guides'),
    ];
}

/**
 * Build a sensible default breadcrumb trail for the current context.
 *
 * Used when blogtimer_render_breadcrumb_nav() is called bare (no $items),
 * so any hub/page-*.php template can get a crawlable breadcrumb for free:
 *   - timer  → Home › {unit hub} › {This timer}
 *   - guide  → Home › Guides › {Cluster} › {This guide}
 *   - page   → Home › {Page Title}
 *
 * @return array Array of ['label' => string, 'url' => string|null] items.
 */
function blogtimer_build_breadcrumb_items()
{
    $items = [
        ['label' => 'Home', 'url' => home_url('/')],
    ];

    if (is_singular('timer')) {
        $post_id = get_the_ID();
        $unit = (class_exists('Timer_Engine') && method_exists('Timer_Engine', 'get_timer_unit'))
            ? Timer_Engine::get_timer_unit($post_id)
            : get_post_meta($post_id, '_timer_unit', true);
        if ($unit === 'minutes') {
            $items[] = ['label' => 'Minute Timers', 'url' => home_url('/minute-timers')];
        } elseif ($unit === 'hours') {
            $items[] = ['label' => 'Hour Timers', 'url' => home_url('/hour-timers')];
        } else {
            $items[] = ['label' => 'Second Timers', 'url' => home_url('/second-timers')];
        }
        $items[] = ['label' => get_the_title(), 'url' => null];
    } elseif (is_singular('guide')) {
        $items[] = ['label' => 'Guides', 'url' => home_url('/guides')];
        $cluster_crumb = blogtimer_guide_cluster_crumb();
        if ($cluster_crumb) {
            $items[] = $cluster_crumb;
        }
        $items[] = ['label' => get_the_title(), 'url' => null];
    } else {
        // Generic page (hub, page-*.php, etc.): Home › {Page Title}
        $title = is_singular() ? get_the_title() : wp_get_document_title();
        $items[] = ['label' => $title, 'url' => null];
    }

    return $items;
}

/**
 * Render a breadcrumb navigation trail.
 *
 * Pass an explicit $items array of ['label' => string, 'url' => string|null]
 * to render a custom trail. Call bare (no argument) on any hub/page/single
 * template to auto-derive a sensible, crawlable breadcrumb from the current
 * context via blogtimer_build_breadcrumb_items().
 *
 * @param array|null $items Optional. Breadcrumb items; auto-derived when omitted.
 */
function blogtimer_render_breadcrumb_nav($items = null)
{
    if ($items === null || $items === []) {
        $items = blogtimer_build_breadcrumb_items();
    }
    if (empty($items)) return;
    ?>
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <ol>
            <?php foreach ($items as $i => $item): ?>
                <?php if (!empty($item['url']) && $i < count($items) - 1): ?>
                    <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
                <?php else: ?>
                    <li aria-current="page"><?php echo esc_html($item['label']); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </nav>
    <?php
}

/**
 * Render "See Also" cross-links for guide and timer pages.
 *
 * Outputs links to related category pages and guides based on context.
 *
 * @param string $context 'timer' or 'guide'
 */
function blogtimer_render_see_also($context = 'timer')
{
    $links = [];

    if ($context === 'timer') {
        $links[] = ['url' => home_url('/minute-timers'), 'label' => 'Browse All Minute Timers'];
        $links[] = ['url' => home_url('/second-timers'), 'label' => 'Browse All Second Timers'];
        $links[] = ['url' => home_url('/pomodoro'), 'label' => 'Try the Pomodoro Timer'];
        $links[] = ['url' => home_url('/use-cases'), 'label' => 'Timers by Use Case'];
        $links[] = ['url' => home_url('/guides'), 'label' => 'Timer Guides & Tips'];
    } elseif ($context === 'guide') {
        $links[] = ['url' => home_url('/guides'), 'label' => 'All Guides'];
        $links[] = ['url' => home_url('/minute-timers'), 'label' => 'Minute Timers'];
        $links[] = ['url' => home_url('/second-timers'), 'label' => 'Second Timers'];
        $links[] = ['url' => home_url('/pomodoro'), 'label' => 'Pomodoro Timer'];
        $links[] = ['url' => home_url('/faq'), 'label' => 'Frequently Asked Questions'];
    } elseif ($context === 'page') {
        // Tool / hub pages (egg-timer, hiit-timer, etc.) — link to sibling hubs + guides.
        $links[] = ['url' => home_url('/use-cases'), 'label' => 'Browse Timers by Use Case'];
        $links[] = ['url' => home_url('/pomodoro'), 'label' => 'Pomodoro Timer'];
        $links[] = ['url' => home_url('/minute-timers'), 'label' => 'Minute Timers'];
        $links[] = ['url' => home_url('/second-timers'), 'label' => 'Second Timers'];
        $links[] = ['url' => home_url('/guides'), 'label' => 'Timer Guides & Tips'];
    }

    if (empty($links)) return;
    ?>
    <section class="section see-also-section">
        <h2 class="section-title">See Also</h2>
        <ul class="see-also-links">
            <?php foreach ($links as $link): ?>
                <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php
}

// ==========================================
// COOKIE CONSENT BANNER (GDPR / CCPA)
// ==========================================

/**
 * Output cookie consent banner in wp_footer.
 *
 * Uses localStorage to remember the user's choice. Does not load any
 * third-party scripts until consent is given (consent-first approach).
 */
add_action('wp_footer', function () {
    ?>
    <div id="cookie-consent-banner" class="cookie-consent" style="display:none;" role="dialog" aria-label="Cookie consent">
        <div class="cookie-consent__inner">
            <div class="cookie-consent__text">
                <p><strong>Cookie Notice:</strong> We use cookies to improve your experience and serve relevant ads through Google AdSense. Essential cookies are required for site functionality. Advertising cookies help us show you relevant ads and keep this site free.</p>
                <p>By clicking "Accept All," you consent to the use of all cookies. You can manage your preferences or learn more in our <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>.</p>
            </div>
            <div class="cookie-consent__actions">
                <button id="cookie-accept-all" class="btn btn--primary">Accept All</button>
                <button id="cookie-essential-only" class="btn btn--secondary">Essential Only</button>
            </div>
        </div>
    </div>
    <style>
        .cookie-consent {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 99999;
            background: var(--color-surface, #1a1a2e);
            border-top: 2px solid var(--color-primary, #6c63ff);
            padding: 1rem 0 calc(1rem + env(safe-area-inset-bottom));
            box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
        }
        .cookie-consent__inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .cookie-consent__text {
            flex: 1;
            min-width: 280px;
        }
        .cookie-consent__text p {
            margin: 0 0 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: var(--color-text-secondary, #b0b0c0);
        }
        .cookie-consent__text p:last-child { margin-bottom: 0; }
        .cookie-consent__text a {
            color: var(--color-primary, #6c63ff);
            text-decoration: underline;
        }
        .cookie-consent__actions {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0;
        }
        @media (max-width: 640px) {
            .cookie-consent__inner { flex-direction: column; text-align: left; align-items: stretch; gap: 1rem; padding: 0 1rem; }
            .cookie-consent__text { min-width: 0; text-align: left; }
            /* Stack the buttons full-width so "Accept All" is large and always fully visible. */
            .cookie-consent__actions { width: 100%; flex-direction: column; gap: 0.5rem; }
            .cookie-consent__actions .btn { width: 100%; }
        }
    </style>
    <script>
    (function() {
        var CONSENT_KEY = 'blogtimer_cookie_consent';
        var banner = document.getElementById('cookie-consent-banner');
        if (!banner) return;

        var stored = localStorage.getItem(CONSENT_KEY);
        if (stored) {
            // Consent already given — do not show banner
            return;
        }

        // Show the banner
        banner.style.display = 'block';

        document.getElementById('cookie-accept-all').addEventListener('click', function() {
            localStorage.setItem(CONSENT_KEY, 'all');
            banner.style.display = 'none';
            // Tell GA4 Consent Mode immediately (no reload needed).
            if (typeof gtag === 'function') {
                gtag('consent', 'update', {
                    analytics_storage: 'granted',
                    ad_storage: 'granted',
                    ad_user_data: 'granted',
                    ad_personalization: 'granted'
                });
            }
        });

        document.getElementById('cookie-essential-only').addEventListener('click', function() {
            localStorage.setItem(CONSENT_KEY, 'essential');
            banner.style.display = 'none';
        });
    })();
    </script>
    <?php
}, 100);
