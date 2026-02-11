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

    // Timer widget JS (only on pages that need it)
    if (is_singular('timer') || is_front_page() || is_page(['pomodoro', 'minute-timers', 'second-timers'])) {
        wp_enqueue_script('blogtimer-timer', get_template_directory_uri() . '/js/timer-widget.js', [], '2.0.0', true);

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
    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="<?php echo esc_attr($classes); ?>">
        <span class="timer-card-value"><?php echo esc_html($value); ?></span>
        <span class="timer-card-label"><?php echo esc_html(ucfirst($unit)); ?></span>
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
        <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span><?php echo esc_html($faq['q']); ?></span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
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
                window.addEventListener('scroll', function () {
                    if (window.scrollY > 400) {
                        scrollBtn.classList.add('visible');
                    } else {
                        scrollBtn.classList.remove('visible');
                    }
                });
                scrollBtn.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        })();
    </script>
    <?php
}, 99);
