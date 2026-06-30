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
    // Google Fonts: Inter + JetBrains Mono
    wp_enqueue_style(
        'blogtimer-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style('blogtimer-style', get_stylesheet_uri(), ['blogtimer-fonts'], TIMER_ENGINE_VERSION ?? '2.0.0');

    // Mobile navigation
    wp_enqueue_script('blogtimer-mobile-nav', get_template_directory_uri() . '/js/mobile-nav.js', [], '2.0.0', true);

    // Timer widget JS — only on pages that use the ID-based widget markup
    // (#timer-start / #timer-display). pomodoro is self-driven (inline script),
    // and minute-timers/second-timers are link hubs with no widget.
    if (is_singular('timer') || is_front_page()) {
        wp_enqueue_script('blogtimer-timer', get_template_directory_uri() . '/js/timer-widget.js', [], '2.1.0', true);

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
        wp_enqueue_script('blogtimer-hub-timer', get_template_directory_uri() . '/js/hub-timer.js', [], '1.0.0', true);
        wp_localize_script('blogtimer-hub-timer', 'blogTimerData', [
            'audioUrl' => get_template_directory_uri() . '/audio/timer-alert.wav',
        ]);
    }

    // FAQ accordion
    wp_enqueue_script('blogtimer-faq', get_template_directory_uri() . '/js/faq-accordion.js', [], '2.0.0', true);
}
add_action('wp_enqueue_scripts', 'blogtimer_enqueue_assets');

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

    // One-off guide consolidations: 301 a retired duplicate slug to its replacement.
    $guide_redirects = [
        '/guides/pomodoro-vs-52-17' => '/guides/52-17-rule-vs-pomodoro',
    ];
    $path_trimmed = rtrim($path, '/');
    if (isset($guide_redirects[$path_trimmed])) {
        wp_safe_redirect(home_url($guide_redirects[$path_trimmed]), 301);
        exit;
    }

    // Pattern 1: /item/{numeric-id} -> current permalink for that post.
    if (preg_match('#^/item/(\d+)#', $path, $m)) {
        $post_id = (int) $m[1];
        $permalink = $post_id > 0 ? get_permalink($post_id) : false;
        // Only redirect to a published, public permalink; otherwise let it 404.
        if ($permalink && get_post_status($post_id) === 'publish') {
            wp_safe_redirect($permalink, 301);
            exit;
        }
        return;
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
        wp_safe_redirect(add_query_arg('contact_status', 'invalid_nonce', home_url('/contact/')));
        exit;
    }

    // Honeypot field: silently accept to reduce bot retries.
    if (!empty($_POST['blogtimer_website'])) {
        wp_safe_redirect(add_query_arg('contact_status', 'success', home_url('/contact/')));
        exit;
    }

    $name = sanitize_text_field(wp_unslash($_POST['contact-name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['contact-email'] ?? ''));
    $subject_key = sanitize_key(wp_unslash($_POST['contact-subject'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['contact-message'] ?? ''));

    $subject_map = blogtimer_contact_subjects();

    if (strlen($name) < 2 || !is_email($email) || empty($subject_map[$subject_key]) || strlen($message) < 50) {
        wp_safe_redirect(add_query_arg('contact_status', 'validation_error', home_url('/contact/')));
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

    wp_safe_redirect(add_query_arg('contact_status', $sent ? 'success' : 'send_error', home_url('/contact/')));
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
 * Override WordPress default robots.txt with strict version
 * This tells Google and all crawlers to ONLY index known-good URL patterns
 */
add_filter('robots_txt', function ($output, $public) {
    // Build a strict robots.txt that whitelists only legitimate paths
    $robots = "# robots.txt for The Blog Timer\n";
    $robots .= "# Security hardened - blocks spam/injected pages from being indexed\n\n";

    // Sitemap location
    $robots .= "Sitemap: " . home_url('/wp-sitemap.xml') . "\n\n";

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
    $robots .= "Allow: /chess-clock\n";
    $robots .= "Allow: /egg-timer\n";
    $robots .= "Allow: /interval-timer\n";
    $robots .= "Allow: /nap-timer\n";
    $robots .= "Allow: /sprint-timer\n";
    $robots .= "Allow: /presentation-timer\n";
    $robots .= "Allow: /timer-for/*\n";
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
    // Known legitimate page slugs
    $allowed_pages = [
        'home', 'about', 'contact', 'faq',
        'privacy-policy', 'terms-of-service',
        'minute-timers', 'second-timers',
        'pomodoro', 'use-cases',
        'disclaimer', 'dmca', 'accessibility',
        'editorial-policy',
        'methodology', 'sources', 'author-suraj-giri', 'changelog',
        'chess-clock', 'egg-timer', 'interval-timer',
        'nap-timer', 'sprint-timer', 'presentation-timer',
        'timer-for', 'kids', 'remote-workers',
            // tool & hub pages added 2026-05-27
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
    ];

    // Timer (/timer/*) and guide (/guides/*) CPT pages must ALWAYS be indexable.
    // This post-type check runs BEFORE any slug whitelist so a newly published
    // timer/guide can never be accidentally noindexed by an out-of-date list.
    if (is_singular(['timer', 'guide'])) {
        return;
    }

    // The guide CPT archive (/guides/) and the legitimate custom taxonomies are
    // indexable programmatic-SEO hubs — must NOT be noindexed.
    if (is_post_type_archive('guide') || is_tax(['timer_unit', 'timer_bucket', 'timer_usecase', 'guide_cluster'])) {
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
    $allowed_pages = [
        'home', 'about', 'contact', 'faq',
        'privacy-policy', 'terms-of-service',
        'minute-timers', 'second-timers',
        'pomodoro', 'use-cases',
        'disclaimer', 'dmca', 'accessibility',
        'editorial-policy',
        'methodology', 'sources', 'author-suraj-giri', 'changelog',
        'chess-clock', 'egg-timer', 'interval-timer',
        'nap-timer', 'sprint-timer', 'presentation-timer',
        'timer-for', 'kids', 'remote-workers',
            // tool & hub pages added 2026-05-27
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
    ];

    // Timer (/timer/*) and guide (/guides/*) CPT pages must ALWAYS be indexable.
    // Post-type check runs BEFORE the slug whitelist for the same reason as above.
    if (is_singular(['timer', 'guide'])) {
        return;
    }

    // The guide CPT archive (/guides/) and the legitimate custom taxonomies are
    // indexable programmatic-SEO hubs — must NOT be noindexed.
    if (is_post_type_archive('guide') || is_tax(['timer_unit', 'timer_bucket', 'timer_usecase', 'guide_cluster'])) {
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
 * Remove all taxonomy-based sitemaps (often contain spam)
 */
add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    // Remove all taxonomy sitemaps - they often contain injected spam terms
    return [];
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
 * Disable Nginx/CDN caching on sitemap URLs so search engines always see fresh content.
 * Cloudways Varnish/Nginx was caching wp-sitemap-*.xml for 4+ hours, causing GSC to read stale counts.
 */
add_action('send_headers', function () {
    if (!isset($_SERVER['REQUEST_URI'])) { return; }
    $uri = $_SERVER['REQUEST_URI'];
    if (preg_match('#/(wp-)?sitemap[^/]*\.xml#', $uri)) {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0', true);
        header('Pragma: no-cache', true);
        header('Expires: 0', true);
        header('X-Accel-Expires: 0', true);  // Nginx-specific directive to bypass cache
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

    header('Content-Type: application/xml; charset=UTF-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('X-Accel-Expires: 0');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Add homepage
    echo '  <url><loc>' . esc_url(home_url('/')) . '</loc></url>' . "\n";

    // Add all whitelisted pages
    $allowed_page_slugs = [
        'about','contact','faq','privacy-policy','terms-of-service',
        'minute-timers','second-timers','pomodoro','use-cases',
        'disclaimer','dmca','accessibility','editorial-policy',
        'methodology','sources','author-suraj-giri','changelog',
        'chess-clock','egg-timer','interval-timer','nap-timer',
        'sprint-timer','presentation-timer','timer-for','kids','remote-workers',
        'stopwatch','online-alarm-clock','countdown-timer','sleep-timer',
        'world-clock','focus-timer','study-timer','tabata-timer',
        'cooking-timers','workout-timers','sleep-meditation-timers',
        'study-work-timers','stopwatch-clock-tools',
        'pasta-timer','tea-timer','coffee-timer','steak-timer','rice-timer',
        'turkey-timer','bread-baking-timer','microwave-popcorn-timer',
        'sous-vide-timer','bbq-timer','baby-bottle-timer',
        'boxing-round-timer','hiit-timer','yoga-timer','plank-timer',
        'jump-rope-timer','running-interval-timer','stretching-timer',
        'crossfit-amrap-timer','emom-timer','hour-timers',
        'site-index',
    ];
    foreach ($allowed_page_slugs as $slug) {
        $page = get_page_by_path($slug);
        if ($page && $page->post_status === 'publish') {
            echo '  <url><loc>' . esc_url(get_permalink($page->ID)) . '</loc></url>' . "\n";
        }
    }

    // All timer posts
    $timers = get_posts(['post_type' => 'timer', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids']);
    foreach ($timers as $tid) {
        echo '  <url><loc>' . esc_url(get_permalink($tid)) . '</loc></url>' . "\n";
    }

    // All guide posts
    $guides = get_posts(['post_type' => 'guide', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids']);
    foreach ($guides as $gid) {
        echo '  <url><loc>' . esc_url(get_permalink($gid)) . '</loc></url>' . "\n";
    }

    echo '</urlset>' . "\n";
    exit;
});

add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
    if ($post_type === 'page') {
        $allowed_pages = [
            'home', 'about', 'contact', 'faq',
            'privacy-policy', 'terms-of-service',
            'minute-timers', 'second-timers',
            'pomodoro', 'use-cases',
            'disclaimer', 'dmca', 'accessibility',
            'editorial-policy',
            'methodology', 'sources', 'author-suraj-giri', 'changelog',
            'chess-clock', 'egg-timer', 'interval-timer',
            'nap-timer', 'sprint-timer', 'presentation-timer',
            'timer-for', 'kids', 'remote-workers',
            // tool & hub pages added 2026-05-27
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
        ];
        $args['post_name__in'] = $allowed_pages;
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
        $canonical = get_post_type_archive_link(get_post_type());
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
    $person_id = home_url('/author-suraj-giri/') . '#person';

    // ONE logo node. Only favicon.svg exists in the theme images dir today.
    // TODO: replace with PNG logo ≥112px (Google requires a raster logo ≥112x112px for rich results).
    $logo_url = get_theme_file_uri('images/favicon.svg');

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
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $logo_url,
        ],
        // TODO: confirm founding year
        'foundingDate' => '2025',
        'founder' => [
            '@id' => $person_id,
        ],
        // TODO: orchestrator populates real social/Wikidata/Crunchbase URLs — do NOT invent
        'sameAs' => [],
    ];

    // WebSite schema with SearchAction — homepage only. SINGLE consolidated node (stable @id).
    // This is the ONLY WebSite output site-wide; the plugin's duplicate has been neutralized.
    if (is_front_page()) {
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
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $site_url . '?s={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

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
                    'item' => blogtimer_untrailingslashit_url(home_url('/minute-timers/')),
                ];
            } elseif ($unit === 'hours') {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'Hour Timers',
                    'item' => blogtimer_untrailingslashit_url(home_url('/hour-timers/')),
                ];
            } else {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => 'Second Timers',
                    'item' => blogtimer_untrailingslashit_url(home_url('/second-timers/')),
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
                'item' => blogtimer_untrailingslashit_url(home_url('/guides/')),
            ];
            // Cluster level — the /guide-cluster/{term}/ archive 404s and is redirected,
            // so the cluster crumb links to the /guides/ hub rather than the dead archive.
            $guide_cluster_crumb = blogtimer_guide_cluster_crumb();
            if ($guide_cluster_crumb) {
                $breadcrumb_items[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $guide_cluster_crumb['label'],
                    'item' => blogtimer_untrailingslashit_url(home_url('/guides/')),
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
                'itemListElement' => $breadcrumb_items,
            ];
        }
    }

    // FAQPage schema — pages that render FAQ sections (except guide pages which handle their own)
    if (!is_singular('guide')) {
        $faq_items = [];

        if (is_front_page() || is_page(['minute-timers', 'second-timers', 'faq'])) {
            $copyblocks_path = ABSPATH . '../datasets/copyblocks.json';
            if (file_exists($copyblocks_path)) {
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
            if (class_exists('Timer_Content_Loader')) {
                $loader = Timer_Content_Loader::get_instance();
                $timer_faqs = $loader->get_faqs(get_post(), 4);
                if (!empty($timer_faqs)) {
                    foreach ($timer_faqs as $faq) {
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

        if (!empty($faq_items)) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq_items,
            ];
        }
    }

    // HowTo schema — pages with how-to sections
    if (is_front_page() || is_singular('timer') || is_page(['minute-timers', 'second-timers'])) {
        if (class_exists('Timer_Content_Loader')) {
            $loader = Timer_Content_Loader::get_instance();
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'HowTo',
                'name' => 'How to Use The Blog Timer',
                'description' => 'Set a countdown timer in three simple steps. No sign-up required.',
                'step' => [
                    [
                        '@type' => 'HowToStep',
                        'position' => 1,
                        'name' => $loader->get_string('howto.step1.title'),
                        'text' => $loader->get_string('howto.step1.desc'),
                    ],
                    [
                        '@type' => 'HowToStep',
                        'position' => 2,
                        'name' => $loader->get_string('howto.step2.title'),
                        'text' => $loader->get_string('howto.step2.desc'),
                    ],
                    [
                        '@type' => 'HowToStep',
                        'position' => 3,
                        'name' => $loader->get_string('howto.step3.title'),
                        'text' => $loader->get_string('howto.step3.desc'),
                    ],
                ],
                'totalTime' => 'PT10S',
            ];
        }
    }

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
        'url'   => home_url('/guides/'),
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
            $items[] = ['label' => 'Minute Timers', 'url' => home_url('/minute-timers/')];
        } elseif ($unit === 'hours') {
            $items[] = ['label' => 'Hour Timers', 'url' => home_url('/hour-timers/')];
        } else {
            $items[] = ['label' => 'Second Timers', 'url' => home_url('/second-timers/')];
        }
        $items[] = ['label' => get_the_title(), 'url' => null];
    } elseif (is_singular('guide')) {
        $items[] = ['label' => 'Guides', 'url' => home_url('/guides/')];
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
        $links[] = ['url' => home_url('/minute-timers/'), 'label' => 'Browse All Minute Timers'];
        $links[] = ['url' => home_url('/second-timers/'), 'label' => 'Browse All Second Timers'];
        $links[] = ['url' => home_url('/pomodoro/'), 'label' => 'Try the Pomodoro Timer'];
        $links[] = ['url' => home_url('/use-cases/'), 'label' => 'Timers by Use Case'];
        $links[] = ['url' => home_url('/guides/'), 'label' => 'Timer Guides & Tips'];
    } elseif ($context === 'guide') {
        $links[] = ['url' => home_url('/guides/'), 'label' => 'All Guides'];
        $links[] = ['url' => home_url('/minute-timers/'), 'label' => 'Minute Timers'];
        $links[] = ['url' => home_url('/second-timers/'), 'label' => 'Second Timers'];
        $links[] = ['url' => home_url('/pomodoro/'), 'label' => 'Pomodoro Timer'];
        $links[] = ['url' => home_url('/faq/'), 'label' => 'Frequently Asked Questions'];
    } elseif ($context === 'page') {
        // Tool / hub pages (egg-timer, hiit-timer, etc.) — link to sibling hubs + guides.
        $links[] = ['url' => home_url('/use-cases/'), 'label' => 'Browse Timers by Use Case'];
        $links[] = ['url' => home_url('/pomodoro/'), 'label' => 'Pomodoro Timer'];
        $links[] = ['url' => home_url('/minute-timers/'), 'label' => 'Minute Timers'];
        $links[] = ['url' => home_url('/second-timers/'), 'label' => 'Second Timers'];
        $links[] = ['url' => home_url('/guides/'), 'label' => 'Timer Guides & Tips'];
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
                <p>By clicking "Accept All," you consent to the use of all cookies. You can manage your preferences or learn more in our <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>.</p>
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
        });

        document.getElementById('cookie-essential-only').addEventListener('click', function() {
            localStorage.setItem(CONSENT_KEY, 'essential');
            banner.style.display = 'none';
        });
    })();
    </script>
    <?php
}, 100);
