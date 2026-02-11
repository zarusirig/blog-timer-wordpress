<?php
/**
 * Plugin Name: Timer Engine
 * Plugin URI: https://theblogtimer.com
 * Description: Programmatic SEO timer engine — registers Timer CPT, taxonomies, templates, and internal linking.
 * Version: 1.0.0
 * Author: The Blog Timer
 * License: GPL v2 or later
 * Text Domain: timer-engine
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TIMER_ENGINE_VERSION', '1.0.0');
define('TIMER_ENGINE_PATH', plugin_dir_path(__FILE__));
define('TIMER_ENGINE_URL', plugin_dir_url(__FILE__));
define('TIMER_ENGINE_DATASETS', ABSPATH . '../datasets/');

// Include classes
require_once TIMER_ENGINE_PATH . 'includes/class-content-loader.php';
require_once TIMER_ENGINE_PATH . 'includes/class-related-timers.php';

if (defined('WP_CLI') && WP_CLI) {
    require_once TIMER_ENGINE_PATH . 'includes/class-timer-generator.php';
    require_once TIMER_ENGINE_PATH . 'includes/class-guide-generator.php';
}

class Timer_Engine
{

    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomies']);
        add_action('template_redirect', [$this, 'redirect_legacy_taxonomy_query_urls']);

        add_action('wp_head', [$this, 'output_seo_meta'], 1);
        add_action('wp_head', [$this, 'output_schema'], 99);

        add_filter('single_template', [$this, 'load_timer_template']);
        add_filter('single_template', [$this, 'load_guide_template']);
        add_filter('document_title_parts', [$this, 'filter_title']);
        add_filter('wp_robots', [$this, 'filter_wp_robots']);
        add_filter('wp_sitemaps_posts_query_args', [$this, 'filter_sitemap_posts_query_args'], 10, 2);
    }

    /**
     * Register the Timer custom post type.
     */
    public function register_post_type()
    {
        $this->register_timer_cpt();
        $this->register_guide_cpt();
    }

    private function register_timer_cpt()
    {

        $labels = [
            'name' => _x('Timers', 'Post type general name', 'timer-engine'),
            'singular_name' => _x('Timer', 'Post type singular name', 'timer-engine'),
            'menu_name' => _x('Timers', 'Admin Menu text', 'timer-engine'),
            'add_new' => __('Add New', 'timer-engine'),
            'add_new_item' => __('Add New Timer', 'timer-engine'),
            'edit_item' => __('Edit Timer', 'timer-engine'),
            'new_item' => __('New Timer', 'timer-engine'),
            'view_item' => __('View Timer', 'timer-engine'),
            'search_items' => __('Search Timers', 'timer-engine'),
            'not_found' => __('No timers found', 'timer-engine'),
            'not_found_in_trash' => __('No timers found in Trash', 'timer-engine'),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'timer', 'with_front' => false],
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-clock',
            'supports' => ['title', 'editor', 'custom-fields'],
            'show_in_rest' => true,
        ];

        register_post_type('timer', $args);
    }

    /**
     * Register the Guide custom post type.
     */
    private function register_guide_cpt()
    {
        $labels = [
            'name' => _x('Guides', 'Post type general name', 'timer-engine'),
            'singular_name' => _x('Guide', 'Post type singular name', 'timer-engine'),
            'menu_name' => _x('Guides', 'Admin Menu text', 'timer-engine'),
            'add_new' => __('Add New', 'timer-engine'),
            'add_new_item' => __('Add New Guide', 'timer-engine'),
            'edit_item' => __('Edit Guide', 'timer-engine'),
            'new_item' => __('New Guide', 'timer-engine'),
            'view_item' => __('View Guide', 'timer-engine'),
            'search_items' => __('Search Guides', 'timer-engine'),
            'not_found' => __('No guides found', 'timer-engine'),
            'not_found_in_trash' => __('No guides found in Trash', 'timer-engine'),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'guides', 'with_front' => false],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-book-alt',
            'supports' => ['title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'],
            'show_in_rest' => true,
        ];

        register_post_type('guide', $args);
    }

    /**
     * Register taxonomies for Timer CPT.
     */
    public function register_taxonomies()
    {
        // Unit taxonomy (minutes / seconds)
        register_taxonomy('timer_unit', 'timer', [
            'labels' => [
                'name' => _x('Units', 'taxonomy general name', 'timer-engine'),
                'singular_name' => _x('Unit', 'taxonomy singular name', 'timer-engine'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'timer-unit', 'with_front' => false],
            'show_in_rest' => true,
        ]);

        // Bucket taxonomy (short / medium / long / extended)
        register_taxonomy('timer_bucket', 'timer', [
            'labels' => [
                'name' => _x('Buckets', 'taxonomy general name', 'timer-engine'),
                'singular_name' => _x('Bucket', 'taxonomy singular name', 'timer-engine'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'timer-bucket', 'with_front' => false],
            'show_in_rest' => true,
        ]);

        // Use case taxonomy
        register_taxonomy('timer_usecase', 'timer', [
            'labels' => [
                'name' => _x('Use Cases', 'taxonomy general name', 'timer-engine'),
                'singular_name' => _x('Use Case', 'taxonomy singular name', 'timer-engine'),
            ],
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'timer-usecase', 'with_front' => false],
            'show_in_rest' => true,
        ]);

        // Guide Cluster taxonomy
        register_taxonomy('guide_cluster', 'guide', [
            'labels' => [
                'name' => _x('Clusters', 'taxonomy general name', 'timer-engine'),
                'singular_name' => _x('Cluster', 'taxonomy singular name', 'timer-engine'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'guide-cluster', 'with_front' => false],
            'show_in_rest' => true,
        ]);
    }

    /**
     * Redirect legacy query-string taxonomy URLs to pretty taxonomy permalinks.
     */
    public function redirect_legacy_taxonomy_query_urls()
    {
        if (is_admin() || wp_doing_ajax()) {
            return;
        }

        if (!is_tax(['timer_unit', 'timer_bucket', 'timer_usecase'])) {
            return;
        }

        $has_legacy_query = isset($_GET['timer_unit']) || isset($_GET['timer_bucket']) || isset($_GET['timer_usecase']);
        if (!$has_legacy_query) {
            return;
        }

        $term = get_queried_object();
        if ($term instanceof WP_Term) {
            $term_link = get_term_link($term);
            if (!is_wp_error($term_link) && $term_link) {
                wp_safe_redirect($term_link, 301);
                exit;
            }
        }
    }

    /**
     * Keep thin default content out of index and sitemap.
     */
    public function filter_wp_robots($robots)
    {
        if (is_page('sample-page') || is_author() || is_date() || is_search() || is_404()) {
            $robots['noindex'] = true;
            $robots['follow'] = true;
        }
        return $robots;
    }

    public function filter_sitemap_posts_query_args($args, $post_type)
    {
        if ($post_type !== 'page') {
            return $args;
        }

        $sample = get_page_by_path('sample-page');
        if ($sample) {
            $args['post__not_in'] = isset($args['post__not_in']) ? (array) $args['post__not_in'] : [];
            $args['post__not_in'][] = (int) $sample->ID;
        }

        return $args;
    }

    /**
     * Load custom single-timer template from theme (fallback to plugin).
     */
    public function load_timer_template($template)
    {
        global $post;
        if ($post && $post->post_type === 'timer') {
            $theme_template = locate_template('single-timer.php');
            if ($theme_template) {
                return $theme_template;
            }
            // Fallback to plugin template
            $plugin_template = TIMER_ENGINE_PATH . 'templates/single-timer.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        return $template;
    }

    /**
     * Load custom single-guide template from theme.
     */
    public function load_guide_template($template)
    {
        global $post;
        if ($post && $post->post_type === 'guide') {
            $theme_template = locate_template('single-guide.php');
            if ($theme_template) {
                return $theme_template;
            }
        }
        return $template;
    }

    /**
     * Filter document title for timer pages.
     */
    public function filter_title($title_parts)
    {
        if (is_singular('timer')) {
            global $post;
            $value = get_post_meta($post->ID, '_timer_value', true);
            $unit = get_post_meta($post->ID, '_timer_unit', true);
            if ($value && $unit) {
                $loader = Timer_Content_Loader::get_instance();
                $title_key = 'timer.seo_title.' . $unit;
                $seo_title = $loader->get_string($title_key, ['value' => $value]);
                if ($seo_title) {
                    $title_parts['title'] = $seo_title;
                    unset($title_parts['site']);
                    unset($title_parts['tagline']);
                }
            }
        }
        return $title_parts;
    }

    /**
     * Output meta tags and social tags for all indexable page types.
     */
    public function output_seo_meta()
    {
        if (is_admin() || is_feed() || is_trackback()) {
            return;
        }

        $meta_desc = $this->get_meta_description();
        if (!empty($meta_desc)) {
            echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        }

        // Core already prints canonical for singular content, so we print for non-singular contexts only.
        $canonical = $this->get_context_canonical_url();
        if (!is_singular() && $canonical) {
            echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        }

        $title = wp_get_document_title();
        $social_desc = $meta_desc ?: get_bloginfo('description');
        $social_url = $canonical ?: (is_singular() ? get_permalink() : home_url(''));
        $og_type = (is_front_page() || is_home() || is_archive()) ? 'website' : 'article';
        $site_name = get_bloginfo('name');
        $image = get_site_icon_url(512);

        echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($social_desc) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($social_url) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";

        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
            echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
        }

        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($social_desc) . '">' . "\n";
        echo '<meta name="twitter:url" content="' . esc_url($social_url) . '">' . "\n";
    }

    /**
     * Resolve context-aware meta description.
     */
    private function get_meta_description()
    {
        if (is_singular('timer')) {
            global $post;
            return $this->get_timer_meta_description($post);
        }

        if (is_front_page()) {
            return 'Free online timers for work, workouts, study, cooking, and focus sessions. Accurate countdowns, Pomodoro tools, and second-by-second timers that work on every device.';
        }

        if (is_page()) {
            $post_id = get_queried_object_id();
            $slug = get_post_field('post_name', $post_id);
            $loader = Timer_Content_Loader::get_instance();

            $core_page_meta = [
                'about' => 'Learn how The Blog Timer is built, why it prioritizes privacy, and how its countdown engine maintains reliable timing across devices.',
                'contact' => 'Contact The Blog Timer team for support questions, bug reports, and feature requests. Submit details securely through the built-in contact form.',
                'faq' => 'Read frequently asked questions about timer accuracy, Pomodoro workflows, keyboard shortcuts, mobile usage, and troubleshooting.',
                'privacy-policy' => 'Review The Blog Timer privacy policy, including local storage usage, essential cookies, and how we handle operational server logs.',
                'privacy-policy-2' => 'Review The Blog Timer privacy policy, including local storage usage, essential cookies, and how we handle operational server logs.',
                'terms-of-service' => 'Read The Blog Timer terms of service, usage rules, liability limitations, and legal conditions for accessing the website.',
            ];

            if (isset($core_page_meta[$slug])) {
                return $core_page_meta[$slug];
            }

            $hub_meta_map = [
                'minute-timers' => 'hub.minutes.meta',
                'second-timers' => 'hub.seconds.meta',
                'pomodoro' => 'hub.pomodoro.meta',
                'use-cases' => 'hub.usecases.meta',
            ];

            if (isset($hub_meta_map[$slug])) {
                $hub_meta = $loader->get_string($hub_meta_map[$slug]);
                if (!empty($hub_meta)) {
                    return $hub_meta;
                }
            }

            return $this->get_post_fallback_description($post_id);
        }

        if (is_singular('guide')) {
            return $this->get_post_fallback_description(get_queried_object_id());
        }

        if (is_tax('timer_unit')) {
            $term = get_queried_object();
            return sprintf(
                'Browse all %s countdown timers with instant start, reliable alerts, and clean interfaces for productivity, workouts, cooking, and daily routines.',
                strtolower($term->name)
            );
        }

        if (is_tax('timer_bucket')) {
            $term = get_queried_object();
            $desc = trim(wp_strip_all_tags($term->description));
            if (!empty($desc)) {
                return wp_trim_words($desc, 28, '...');
            }
            return sprintf('Explore %s and choose the right countdown duration for your task with practical recommendations and one-click start links.', strtolower($term->name));
        }

        if (is_tax('timer_usecase')) {
            $term = get_queried_object();
            return sprintf('Discover timers for %s, including recommended durations and focused countdown pages that help you stay on pace.', strtolower($term->name));
        }

        if (is_tax('guide_cluster')) {
            $term = get_queried_object();
            return sprintf('Read expert %s timer guides covering practical methods, common mistakes, and recommended timer setups.', strtolower($term->name));
        }

        if (is_post_type_archive('guide')) {
            return 'Explore in-depth timer guides on Pomodoro, focus sessions, exercise intervals, cooking timing, meditation, and browser timer accuracy.';
        }

        return '';
    }

    private function get_timer_meta_description($post)
    {
        if (!$post) {
            return '';
        }

        $value = get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);

        if (!$value || !$unit) {
            return '';
        }

        $loader = Timer_Content_Loader::get_instance();
        $variant_index = ((int) $value) % 3;
        $variant_letter = ['a', 'b', 'c'][$variant_index];
        $meta_key = "timer.meta.{$unit}_{$variant_letter}";

        return (string) $loader->get_string($meta_key, ['value' => $value]);
    }

    private function get_post_fallback_description($post_id)
    {
        $post = get_post($post_id);
        if (!$post) {
            return '';
        }

        if (!empty($post->post_excerpt)) {
            return wp_trim_words(wp_strip_all_tags($post->post_excerpt), 28, '...');
        }

        if (!empty($post->post_content)) {
            return wp_trim_words(wp_strip_all_tags($post->post_content), 28, '...');
        }

        return '';
    }

    /**
     * Build canonical URL for the current request context.
     */
    private function get_context_canonical_url()
    {
        if (is_search() || is_404() || is_author() || is_date()) {
            return '';
        }

        if (is_front_page()) {
            return home_url('');
        }

        if (is_home()) {
            $page_for_posts = (int) get_option('page_for_posts');
            return $page_for_posts ? get_permalink($page_for_posts) : home_url('');
        }

        if (is_singular()) {
            return get_permalink();
        }

        $paged = (int) get_query_var('paged');
        if ($paged > 1) {
            return get_pagenum_link($paged);
        }

        if (is_tax() || is_category() || is_tag()) {
            $term = get_queried_object();
            if ($term instanceof WP_Term) {
                $term_link = get_term_link($term);
                if (!is_wp_error($term_link)) {
                    return $term_link;
                }
            }
        }

        if (is_post_type_archive()) {
            $post_type = get_query_var('post_type');
            if (is_array($post_type)) {
                $post_type = reset($post_type);
            }
            $archive_link = get_post_type_archive_link($post_type ?: 'post');
            if ($archive_link) {
                return $archive_link;
            }
        }

        return home_url('');
    }

    /**
     * Output structured data (JSON-LD).
     */
    public function output_schema()
    {
        if (is_admin() || is_feed() || is_trackback()) {
            return;
        }

        if (is_singular('timer')) {
            $this->output_timer_schema();
            return;
        }

        if (is_front_page()) {
            $this->output_site_schema();
            return;
        }

        if (is_singular('guide')) {
            $this->output_guide_schema();
            return;
        }

        if (is_page()) {
            $this->output_page_schema();
            return;
        }

        if (is_tax() || is_post_type_archive('guide')) {
            $this->output_collection_schema();
        }
    }

    private function output_timer_schema()
    {
        global $post;
        $value = get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);

        if (!$value || !$unit) {
            return;
        }

        $loader = Timer_Content_Loader::get_instance();
        $title = $loader->get_string("timer.title.{$unit}", ['value' => $value]);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $title ?: "Set Timer for {$value} " . ucfirst($unit),
            'url' => get_permalink($post->ID),
            'applicationCategory' => 'UtilityApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
        ];

        $this->output_json_ld($schema);

        $faqs = $loader->get_faqs($post);
        if (!empty($faqs)) {
            $faq_schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => [],
            ];

            foreach ($faqs as $faq) {
                $faq_schema['mainEntity'][] = [
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['a'],
                    ],
                ];
            }

            $this->output_json_ld($faq_schema);
        }

        $breadcrumbs = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => home_url(''),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $unit === 'minutes' ? 'Minute Timers' : 'Second Timers',
                    'item' => $unit === 'minutes' ? home_url('/minute-timers/') : home_url('/second-timers/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $title,
                    'item' => get_permalink($post->ID),
                ],
            ],
        ];

        $this->output_json_ld($breadcrumbs);
    }

    private function output_site_schema()
    {
        $name = get_bloginfo('name');
        $url = home_url('');

        $website_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $name,
            'url' => $url,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            ],
        ];

        $org_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $name,
            'url' => $url,
        ];

        $logo = get_site_icon_url(512);
        if ($logo) {
            $org_schema['logo'] = $logo;
        }

        $this->output_json_ld($website_schema);
        $this->output_json_ld($org_schema);
    }

    private function output_guide_schema()
    {
        $post_id = get_queried_object_id();
        $post = get_post($post_id);
        if (!$post) {
            return;
        }

        $article = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title($post_id),
            'description' => $this->get_post_fallback_description($post_id),
            'url' => get_permalink($post_id),
            'datePublished' => get_the_date(DATE_W3C, $post_id),
            'dateModified' => get_the_modified_date(DATE_W3C, $post_id),
            'author' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ],
        ];

        $image = get_site_icon_url(512);
        if ($image) {
            $article['image'] = [$image];
            $article['publisher']['logo'] = [
                '@type' => 'ImageObject',
                'url' => $image,
            ];
        }

        $this->output_json_ld($article);
    }

    private function output_collection_schema()
    {
        $title = wp_get_document_title();
        $url = $this->get_context_canonical_url();

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $title,
            'url' => $url,
        ];

        $posts = [];
        if (is_tax()) {
            $posts = get_posts([
                'post_type' => is_tax('guide_cluster') ? 'guide' : 'timer',
                'posts_per_page' => 10,
                'tax_query' => [
                    [
                        'taxonomy' => get_queried_object()->taxonomy,
                        'field' => 'term_id',
                        'terms' => (int) get_queried_object_id(),
                    ],
                ],
                'orderby' => 'date',
                'order' => 'DESC',
            ]);
        } elseif (is_post_type_archive('guide')) {
            $posts = get_posts([
                'post_type' => 'guide',
                'posts_per_page' => 10,
                'orderby' => 'date',
                'order' => 'DESC',
            ]);
        }

        if (!empty($posts)) {
            $schema['mainEntity'] = [
                '@type' => 'ItemList',
                'itemListElement' => [],
            ];

            foreach ($posts as $idx => $p) {
                $schema['mainEntity']['itemListElement'][] = [
                    '@type' => 'ListItem',
                    'position' => $idx + 1,
                    'name' => get_the_title($p->ID),
                    'url' => get_permalink($p->ID),
                ];
            }
        }

        $this->output_json_ld($schema);
    }

    private function output_page_schema()
    {
        $post_id = get_queried_object_id();
        if (!$post_id) {
            return;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => get_the_title($post_id),
            'url' => get_permalink($post_id),
            'description' => $this->get_meta_description(),
            'datePublished' => get_the_date(DATE_W3C, $post_id),
            'dateModified' => get_the_modified_date(DATE_W3C, $post_id),
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => get_bloginfo('name'),
                'url' => home_url(''),
            ],
        ];

        $this->output_json_ld($schema);
    }

    private function output_json_ld($schema)
    {
        if (empty($schema)) {
            return;
        }
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }

    /**
     * Helper: get timer value from post.
     */
    public static function get_timer_value($post_id = null)
    {
        if (!$post_id)
            $post_id = get_the_ID();
        return (int) get_post_meta($post_id, '_timer_value', true);
    }

    /**
     * Helper: get timer unit from post.
     */
    public static function get_timer_unit($post_id = null)
    {
        if (!$post_id)
            $post_id = get_the_ID();
        return get_post_meta($post_id, '_timer_unit', true);
    }

    /**
     * Helper: check if timer is popular.
     */
    public static function is_popular($post_id = null)
    {
        if (!$post_id)
            $post_id = get_the_ID();
        return (bool) get_post_meta($post_id, '_timer_is_popular', true);
    }

    /**
     * Helper: get timer duration in seconds.
     */
    public static function get_duration_seconds($post_id = null)
    {
        $value = self::get_timer_value($post_id);
        $unit = self::get_timer_unit($post_id);
        return $unit === 'minutes' ? $value * 60 : $value;
    }

    /**
     * Render breadcrumbs for a timer page.
     */
    public static function render_breadcrumbs($post_id = null)
    {
        if (!$post_id)
            $post_id = get_the_ID();
        $unit = self::get_timer_unit($post_id);
        $value = self::get_timer_value($post_id);

        $loader = Timer_Content_Loader::get_instance();
        $home_label = $loader->get_string('breadcrumb.home') ?: 'Home';

        if ($unit === 'minutes') {
            $hub_label = $loader->get_string('breadcrumb.minute_timers') ?: 'Minute Timers';
            $hub_url = home_url('/minute-timers/');
        } else {
            $hub_label = $loader->get_string('breadcrumb.second_timers') ?: 'Second Timers';
            $hub_url = home_url('/second-timers/');
        }

        $current_label = "{$value} " . ucfirst($unit);

        echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
        echo '<ol>';
        echo '<li><a href="' . esc_url(home_url('')) . '">' . esc_html($home_label) . '</a></li>';
        echo '<li><a href="' . esc_url($hub_url) . '">' . esc_html($hub_label) . '</a></li>';
        echo '<li aria-current="page">' . esc_html($current_label) . '</li>';
        echo '</ol>';
        echo '</nav>';
    }
}

// Initialize
Timer_Engine::get_instance();

// Flush rewrite rules on activation
register_activation_hook(__FILE__, function () {
    Timer_Engine::get_instance()->register_post_type();
    Timer_Engine::get_instance()->register_taxonomies();
    flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
});
