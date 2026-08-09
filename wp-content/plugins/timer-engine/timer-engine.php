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
define('TIMER_ENGINE_DATASETS', file_exists(ABSPATH . '../datasets/') ? ABSPATH . '../datasets/' : ABSPATH . 'datasets/');

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
                $seo_title = $this->get_timer_seo_title((int) $value, $unit);
                if ($seo_title) {
                    $title_parts['title'] = $seo_title;
                    // Google renders the site name separately in SERPs, so the
                    // brand suffix would only waste differentiation space.
                    unset($title_parts['site']);
                    unset($title_parts['tagline']);
                }
            }
            return $title_parts;
        }

        // Plugin taxonomy archives otherwise fall back to the bare term name
        // (e.g. /timer-usecase/studying → "Studying"), which is useless in SERPs.
        if (is_tax(['timer_unit', 'timer_bucket', 'timer_usecase', 'guide_cluster'])) {
            $term = get_queried_object();
            if ($term instanceof WP_Term) {
                $tax_title = $this->get_taxonomy_archive_title($term);
                if (!empty($tax_title)) {
                    $title_parts['title'] = $tax_title;
                    unset($title_parts['tagline'], $title_parts['site']);
                }
            }
            return $title_parts;
        }

        // Per-slug title overrides for the homepage and brand-heavy hub pages.
        // Google appends the brand automatically, so we lead with the keyword/benefit
        // and let the core "title" part carry the visible title (kept <= 60 chars).
        $title_override = $this->get_title_override();
        if (!empty($title_override)) {
            $title_parts['title'] = $title_override;
            // On the front page core populates 'tagline' (not 'site'), which would
            // append the full ~90-char tagline after the override. Drop both so the
            // override is the complete <=60-char title.
            unset($title_parts['tagline'], $title_parts['site']);
        }

        return $title_parts;
    }

    /**
     * Resolve a per-slug document title override for the homepage and key hub pages.
     */
    private function get_title_override()
    {
        if (is_front_page()) {
            return 'Free Online Timer — Countdown, Pomodoro & Stopwatch';
        }

        if (!is_page()) {
            return '';
        }

        $slug = get_post_field('post_name', get_queried_object_id());

        $page_title_overrides = [
            'minute-timers' => 'Minute Timers — 1 to 161-Minute Countdowns',
            'second-timers' => 'Second Timers — 1 to 90-Second Countdowns',
            'pomodoro' => 'Pomodoro Timer — 25/5 & 50/10 Presets',
            'use-cases' => 'Timer Use Cases — Find the Right Timer for Any Task',
            'hour-timers' => 'Hour Timers — 1 to 24-Hour Countdowns',
            'world-clock' => 'World Clock — Current Time in Cities Worldwide',
            'timer-for' => 'Timer For Every Task, Person & Activity',
            'timer-for-kids' => 'Timer for Kids — Visual Countdowns for Children',
            'timer-for-remote-workers' => 'Timer for Remote Workers — Focus & Break Blocks',
        ];

        return $page_title_overrides[$slug] ?? '';
    }

    /**
     * Build the differentiated SERP title for a timer page.
     *
     * The base pattern comes from strings.en.json and carries NO brand suffix —
     * Google renders the site name separately, so the suffix only wasted space.
     * Long minute timers get an hour-fraction conversion ("150 Minute Timer
     * (2.5 Hours)") and every title ends with one truthful value hook selected
     * deterministically by duration so adjacent pages never share a title.
     */
    private function get_timer_seo_title($value, $unit)
    {
        $loader = Timer_Content_Loader::get_instance();
        if ($unit === 'hours' && $value === 1) {
            $title_key = 'timer.seo_title.hours_singular';
        } else {
            $title_key = 'timer.seo_title.' . $unit;
        }
        $title = $loader->get_string($title_key, ['value' => $value]);
        if (!$title) {
            return '';
        }

        // Hour-fraction conversion is genuinely useful for long minute timers.
        // Only clean quarter-hour fractions (90 → 1.5, 105 → 1.75, 150 → 2.5).
        if ($unit === 'minutes' && $value >= 90 && $value % 15 === 0) {
            $hours = rtrim(rtrim(number_format($value / 60, 2, '.', ''), '0'), '.');
            $hours_label = ($hours === '1') ? 'Hour' : 'Hours';
            $title .= " ({$hours} {$hours_label})";
        }

        // One truthful value hook per page, rotated deterministically by duration.
        $hook_letters = ['a', 'b', 'c', 'd', 'e', 'f'];
        $hook = $loader->get_string('timer.seo_hook.' . $hook_letters[$value % count($hook_letters)]);
        if ($hook) {
            $title .= ' — ' . $hook;
        }

        return $title;
    }

    /**
     * Build a real document title for plugin taxonomy archives.
     */
    private function get_taxonomy_archive_title($term)
    {
        if ($term->taxonomy === 'timer_usecase') {
            $usecase_titles = [
                'studying' => 'Study Timers — Every Duration for Focused Study Sessions',
                'productivity' => 'Productivity Timers — Focus Blocks, Sprints & Breaks',
                'cooking' => 'Cooking Timers — Durations for Boiling, Baking & Brewing',
                'exercise' => 'Exercise Timers — Intervals, Rounds & Rest Durations',
                'meditation' => 'Meditation Timers — Calm, Breathing & Mindfulness Sessions',
            ];
            return $usecase_titles[$term->slug] ?? sprintf('%s Timers — Every Duration for the Task', $term->name);
        }

        if ($term->taxonomy === 'timer_unit') {
            $unit_titles = [
                'minutes' => 'All Minute Timers — Every Duration from 1 to 161 Minutes',
                'seconds' => 'All Second Timers — Every Duration from 1 to 60 Seconds',
                'hours' => 'All Hour Timers — Countdowns from 1 to 24 Hours',
            ];
            return $unit_titles[$term->slug] ?? sprintf('%s Timers — Browse Every Duration', $term->name);
        }

        if ($term->taxonomy === 'timer_bucket') {
            $bucket = $this->get_bucket_range($term->slug);
            if ($bucket) {
                return sprintf('%s — %d to %d %s Countdowns', $term->name, $bucket['min'], $bucket['max'], $bucket['unit_label']);
            }
            return sprintf('%s — Pick a Duration & Start Counting Down', $term->name);
        }

        if ($term->taxonomy === 'guide_cluster') {
            return sprintf('%s Guides — Evidence-Based Timing & Methods', $term->name);
        }

        return '';
    }

    /**
     * Look up a bucket's duration range from the dataset by term slug.
     */
    private function get_bucket_range($slug)
    {
        $loader = Timer_Content_Loader::get_instance();
        $unit_labels = [
            'minutes' => 'Minute',
            'seconds' => 'Second',
            'hours' => 'Hour',
        ];
        foreach ($unit_labels as $unit => $label) {
            foreach ($loader->get_buckets($unit) as $bucket) {
                if (($bucket['id'] ?? '') === $slug && isset($bucket['min'], $bucket['max'])) {
                    return [
                        'min' => (int) $bucket['min'],
                        'max' => (int) $bucket['max'],
                        'unit_label' => $label,
                    ];
                }
            }
        }
        return null;
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

        // NOTE: canonical, Open Graph, and Twitter Card tags are emitted by the
        // THEME (functions.php), which owns the complete, de-duplicated meta set.
        // The plugin intentionally contributes ONLY the per-context meta description
        // above to avoid duplicate og:description / canonical / twitter tags.
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
                'chess-clock' => 'Free online chess clock for two players. Set bullet, blitz, rapid, or classical time controls and switch turns with a single tap. Works for chess, board games, and debates.',
                'egg-timer' => 'Free online egg timer with soft, medium, and hard-boiled presets. Get perfect eggs every time with science-backed boiling times and tips for foolproof results.',
                'interval-timer' => 'Free interval timer for HIIT, Tabata, EMOM, and circuit training. Customizable work and rest periods with presets for every common interval protocol.',
                'nap-timer' => 'Science-backed power nap timer with NASA, 10-minute, 20-minute, and 90-minute presets. Wake up refreshed, not groggy, with the right nap duration.',
                'sprint-timer' => 'Free online sprint timer for focused work sessions. 15, 25, 45, and 90-minute work sprint presets to boost productivity and beat procrastination.',
                'presentation-timer' => 'Free presentation timer for speakers. Time lightning talks, Pecha Kucha, TED-style talks, and conference sessions with simple visual countdowns.',
                'timer-for' => 'Browse timers designed for specific audiences and use cases — students, remote workers, kids, fitness enthusiasts, and more.',
                'timer-for-kids' => 'Child-friendly timers for homework, chores, screen time, and calm-down moments. Age-appropriate durations and tips for managing kids time with visual countdowns.',
                'timer-for-remote-workers' => 'Productivity timers for remote work and work-from-home schedules. Structure your day with focus blocks, scheduled breaks, and hard-stop timers.',
                'methodology' => 'How The Blog Timer tests countdown accuracy: the 8-test protocol, browser/OS matrix, statistical drift reporting, and an open methodology you can replicate.',
                'sources' => 'Complete bibliography of primary sources cited across The Blog Timer: productivity research, sleep science, HIIT physiology, food safety, and cognitive psychology.',
                'author-suraj-giri' => 'Suraj Giri is the founder and editor of The Blog Timer. Productivity researcher and software engineer writing on attention, timing, and tool design.',
                'changelog' => 'Dated public log of editorial corrections, new guides, study-citation updates, infrastructure changes, and policy revisions on The Blog Timer.',
                // Tool & hub pages — meta descriptions added for GSC snippet recovery (2026-06).
                'stopwatch' => 'Free online stopwatch with lap times and split tracking. Start, stop, and reset with one click or the spacebar. Time workouts, races, and tasks precisely.',
                'online-alarm-clock' => 'Free online alarm clock that rings on time, even in a background tab. Set wake-up alarms, reminders, and alerts with custom sounds. No app or download required.',
                'countdown-timer' => 'Free online countdown timer to any time, date, or duration. Watch the seconds tick down with loud alerts when time is up — ideal for events and deadlines.',
                'sleep-timer' => 'Free online sleep timer that fades out music and stops audio so you can drift off. Set 15 to 60-minute presets and fall asleep without your phone playing.',
                'world-clock' => 'Free online world clock showing the current time in cities worldwide at a glance. Compare time zones instantly to schedule calls and coordinate across countries.',
                'focus-timer' => 'Free online focus timer for deep work and distraction-free sessions. Pick 25, 45, or 90-minute blocks to enter flow, beat procrastination, and get more done.',
                'study-timer' => 'Free online study timer built for focused revision and exam prep. Use Pomodoro and timed study blocks with breaks to retain more and study without burning out.',
                'tabata-timer' => 'Free online Tabata timer with the classic 20s work / 10s rest x 8 protocol. Loud interval beeps keep you moving through every round of this 4-minute HIIT workout.',
                'cooking-timers' => 'Free online cooking timers for every dish, from pasta to steak to bread. Science-backed times and one-click presets so nothing burns, overcooks, or comes out raw.',
                'workout-timers' => 'Free online workout timers for HIIT, Tabata, EMOM, circuits, and rounds. Customizable work and rest intervals with loud beeps to keep your training on pace.',
                'sleep-meditation-timers' => 'Free online sleep and meditation timers for rest, breathwork, and mindfulness. Gentle fade-outs and quiet bells help you unwind, meditate, and fall asleep.',
                'study-work-timers' => 'Free online study and work timers for focused sessions. Pomodoro, deep work, and 52/17 presets help you concentrate, take real breaks, and beat distraction.',
                'stopwatch-clock-tools' => 'Free online stopwatch, alarm clock, world clock, and countdown tools in one place. Measure, limit, or track time with the right timing tool for any task.',
                'pasta-timer' => 'Free online pasta timer with al dente cooking times for every shape. From spaghetti to penne, get perfectly cooked pasta with a loud alert the moment it\'s ready.',
                'tea-timer' => 'Free online tea timer with steeping times for green, black, oolong, and herbal tea. Brew the perfect cup every time and never over-steep into bitterness again.',
                'coffee-timer' => 'Free online coffee timer for pour-over, French press, AeroPress, and espresso. Dial in the ideal brew time for a balanced, never-bitter cup with every method.',
                'steak-timer' => 'Free online steak timer for rare to well-done, by thickness and cut. Get juicy, perfectly cooked steak with precise per-side times and a loud alert when to flip.',
                'rice-timer' => 'Free online rice timer with cooking times for white, brown, basmati, and jasmine. Get fluffy, perfectly cooked rice every time with the right simmer and rest.',
                'turkey-timer' => 'Free online turkey timer with roasting times by weight for a juicy, safe bird. Get your Thanksgiving turkey right with per-pound timing and temperature targets.',
                'bread-baking-timer' => 'Free online bread baking timer for proofing, rising, and baking. Track bulk fermentation, proof, and bake times for perfect loaves, sourdough, and fresh bread.',
                'microwave-popcorn-timer' => 'Free online popcorn timer to pop the perfect bag without burning. Listen for the right pops-per-second window and stop microwave popcorn at its peak every time.',
                'sous-vide-timer' => 'Free online sous vide timer with time and temperature guides by food and thickness. Cook steak, chicken, and eggs to a precise, edge-to-edge perfect doneness.',
                'bbq-timer' => 'Free online BBQ and grill timer for low-and-slow and hot-and-fast cooks. Track ribs, brisket, chicken, and burgers with per-cut times for tender, juicy results.',
                'baby-bottle-timer' => 'Free online baby bottle timer to track feeds and warming times safely. Time each feeding, log intervals between bottles, and keep your newborn\'s schedule on track.',
                'boxing-round-timer' => 'Free online boxing round timer with 3-minute rounds and 1-minute rests. Loud bells signal every round and break for boxing, MMA, and heavy-bag training.',
                'hiit-timer' => 'Free online HIIT timer with customizable work and rest intervals. Set rounds, intervals, and rest with loud beeps to power through any high-intensity workout.',
                'yoga-timer' => 'Free online yoga timer for holding poses and timing flows and meditation. Gentle interval chimes let you stay present on the mat without watching the clock.',
                'plank-timer' => 'Free online plank timer to build core strength and beat your hold record. Track your time, follow progressive presets, and push past your plateau second by second.',
                'jump-rope-timer' => 'Free online jump rope timer for interval skipping and conditioning rounds. Set work and rest intervals with beeps to structure cardio, boxing, and HIIT sessions.',
                'running-interval-timer' => 'Free online running interval timer for sprints, intervals, and run-walk training. Set work and recovery splits with audio cues to nail every rep and pace.',
                'stretching-timer' => 'Free online stretching timer with interval cues for each hold and side. Time your mobility routine, cool-down, and flexibility work to stretch evenly and safely.',
                'crossfit-amrap-timer' => 'Free online CrossFit AMRAP timer to count down your WOD and track rounds. Set the clock, hear the buzzer, and push for as many rounds as possible, every workout.',
                'emom-timer' => 'Free online EMOM timer for Every Minute on the Minute workouts. Customize round length and total duration, then hear the bell at the top of every minute.',
                'site-index' => 'A complete, human-readable directory of every timer, guide, and hub on The Blog Timer, grouped by topic and duration for easy one-click browsing.',
            ];

            if (isset($core_page_meta[$slug])) {
                return $core_page_meta[$slug];
            }

            $hub_meta_map = [
                'minute-timers' => 'hub.minutes.meta',
                'second-timers' => 'hub.seconds.meta',
                'hour-timers' => 'hub.hours.meta',
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
            $slug = get_post_field('post_name', get_queried_object_id());
            // Per-slug overrides for guides whose excerpts make weak SERP snippets.
            $guide_meta_overrides = [
                'pomodoro-technique' => 'What the Pomodoro Technique is and how to use it: the classic 25/5 work-break cycle, why it beats procrastination, when to use 50/10 instead, and the research behind it.',
                'deep-work-timers' => 'How long a deep work session should be, backed by research: 60-90 minute blocks, ultradian rhythms, and the timer setups that protect focus from interruption.',
            ];
            if (isset($guide_meta_overrides[$slug])) {
                return $guide_meta_overrides[$slug];
            }
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

        $value = (int) get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);

        if (!$value || !$unit) {
            return '';
        }

        // Rotating sentence frames (stable per page via value % count) with a
        // duration-specific {fact} slot computed from the number itself, so no
        // two adjacent durations share a description and no fact is fabricated.
        $loader = Timer_Content_Loader::get_instance();
        $frames = [];
        foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $letter) {
            $frame = $loader->get_string("timer.meta_frame.{$unit}_{$letter}");
            if ($frame) {
                $frames[] = $frame;
            }
        }

        if (empty($frames)) {
            return '';
        }

        $frame = $frames[$value % count($frames)];
        $fact = $this->get_timer_duration_fact($value, $unit);

        return str_replace(['{value}', '{fact}'], [$value, $fact], $frame);
    }

    /**
     * Compute a truthful, duration-specific fact for the meta description.
     *
     * Every fact is derived arithmetically from the value itself (hour
     * fractions, 25+5 Pomodoro-cycle equivalents, seconds counts), so it can
     * never be fabricated.
     */
    private function get_timer_duration_fact($value, $unit)
    {
        $value = (int) $value;

        if ($unit === 'hours') {
            if ($value === 1) {
                return "That's 60 minutes — exactly two 25/5 Pomodoro cycles.";
            }
            $minutes = $value * 60;
            $cycles = $value * 2;
            return "That's {$minutes} minutes — exactly {$cycles} 25/5 Pomodoro cycles.";
        }

        if ($unit === 'seconds') {
            if ($value === 60) {
                return "That's exactly one full minute, second by second.";
            }
            if ($value === 30) {
                return "That's exactly half a minute, second by second.";
            }
            if ($value === 15) {
                return "That's one quarter of a minute, second by second.";
            }
            if (60 % $value === 0) {
                $fits = 60 / $value;
                return "One minute holds exactly {$fits} of these {$value}-second rounds.";
            }
            $percent = (int) round(($value / 60) * 100);
            return "That's about {$percent}% of one minute on the clock.";
        }

        // Minutes.
        if ($value % 60 === 0) {
            $hours = $value / 60;
            $hour_word = ($hours === 1) ? 'hour' : 'hours';
            $cycles = $value / 30;
            return "That's exactly {$hours} {$hour_word} — {$cycles} full 25/5 Pomodoro cycles.";
        }
        if ($value > 60) {
            $hours = (int) floor($value / 60);
            $mins = $value % 60;
            $hour_word = ($hours === 1) ? 'hour' : 'hours';
            $cycles = (int) round($value / 30);
            return "That's {$hours} {$hour_word} {$mins} min — about {$cycles} Pomodoro cycles.";
        }
        if ($value === 30) {
            return "That's half an hour — one full 25/5 Pomodoro cycle.";
        }
        if ($value >= 25) {
            if ($value % 25 === 0) {
                $blocks_word = ($value === 25) ? 'one' : 'two';
                $block_word = ($value === 25) ? 'block' : 'blocks';
                return "That's exactly {$blocks_word} 25-minute Pomodoro work {$block_word}.";
            }
            $blocks = (int) round($value / 25);
            $block_word = ($blocks === 1) ? 'block' : 'blocks';
            return "That's about {$blocks} classic 25-minute Pomodoro work {$block_word}.";
        }
        $seconds = $value * 60;
        return "That's {$seconds} seconds on the clock from start to zero.";
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
            // Timer structured data is emitted by the theme's consolidated schema graph.
            // Keeping a single owner avoids duplicate WebApplication, FAQPage, and
            // BreadcrumbList nodes on every timer URL. NOTE (2026-07 CTR audit): HowTo
            // rich results were deprecated by Google in 2023 and the rotated copyblocks
            // FAQ pool is NOT per-page-distinct — neither may be (re-)emitted here.
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

    private function output_site_schema()
    {
        // Organization + WebSite are emitted as the SINGLE site-wide source of truth in
        // the theme's functions.php (home_url('/#organization') and home_url('/#website')).
        // Previously this method emitted duplicate, @id-less Organization and WebSite nodes,
        // which created conflicting entity nodes for Google. Intentionally neutralized so
        // exactly one Organization and one WebSite exist site-wide. Do NOT re-add them here.
        return;
    }

    /**
     * Resolve the guides dataset path, trying the same locations as the content loader.
     */
    private function get_guides_dataset_path()
    {
        $candidates = [
            '/var/www/datasets/guides.dataset.json',      // Docker volume mount
            ABSPATH . '../datasets/guides.dataset.json',  // Docker: relative to web root
            ABSPATH . 'datasets/guides.dataset.json',     // Cloudways: within public_html
            TIMER_ENGINE_PATH . '../../datasets/guides.dataset.json', // relative from plugin
        ];
        if (defined('TIMER_ENGINE_DATASETS')) {
            array_unshift($candidates, TIMER_ENGINE_DATASETS . 'guides.dataset.json');
        }
        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        return '';
    }

    /**
     * Look up a guide dataset entry by post slug.
     *
     * The trust fields (author, datePublished, dateModified, sources) MAY NOT EXIST
     * yet for every guide, so all callers must apply safe fallbacks. Returns [] on miss.
     */
    private function get_guide_dataset_entry($slug)
    {
        static $guides = null;
        if ($guides === null) {
            $guides = [];
            $path = $this->get_guides_dataset_path();
            if ($path !== '') {
                $decoded = json_decode((string) file_get_contents($path), true);
                if (is_array($decoded) && !empty($decoded['guides']) && is_array($decoded['guides'])) {
                    foreach ($decoded['guides'] as $g) {
                        if (!empty($g['slug'])) {
                            $guides[$g['slug']] = $g;
                        }
                    }
                }
            }
        }
        return $guides[$slug] ?? [];
    }

    private function output_guide_schema()
    {
        $post_id = get_queried_object_id();
        $post = get_post($post_id);
        if (!$post) {
            return;
        }

        // SHARED CONTRACT @ids — must match the theme's consolidated Organization/WebSite/Person nodes.
        $org_id = home_url('/#organization');
        $person_id = home_url('/author-suraj-giri/') . '#person';

        // Pull optional trust fields from the guides dataset (may be absent — use safe fallbacks).
        $slug = get_post_field('post_name', $post_id);
        $entry = $slug ? $this->get_guide_dataset_entry($slug) : [];

        // Dates: prefer dataset ISO fields, fall back to post dates so pages never break.
        $date_published = !empty($entry['datePublished'])
            ? (string) $entry['datePublished']
            : get_the_date(DATE_W3C, $post_id);
        $date_modified = !empty($entry['dateModified'])
            ? (string) $entry['dateModified']
            : get_the_modified_date(DATE_W3C, $post_id);

        $article = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title($post_id),
            'description' => $this->get_post_fallback_description($post_id),
            'url' => get_permalink($post_id),
            'datePublished' => $date_published,
            'dateModified' => $date_modified,
            // Author is the Person entity (was Organization) — referenced by @id so Google
            // consolidates it with the author-bio Person node.
            'author' => [
                '@id' => $person_id,
            ],
            // Publisher references the single consolidated Organization node by @id.
            'publisher' => [
                '@id' => $org_id,
            ],
            'mainEntityOfPage' => get_permalink($post_id),
        ];

        // Citations from the dataset `sources` array, when present. Each source maps to a
        // CreativeWork (or a bare URL string if only a URL is available).
        if (!empty($entry['sources']) && is_array($entry['sources'])) {
            $citations = [];
            foreach ($entry['sources'] as $source) {
                if (is_string($source)) {
                    $citations[] = $source;
                    continue;
                }
                if (!is_array($source)) {
                    continue;
                }
                $name = trim((string) ($source['title'] ?? ''));
                $url = trim((string) ($source['url'] ?? ''));
                if ($name === '' && $url === '') {
                    continue;
                }
                if ($name === '' && $url !== '') {
                    $citations[] = $url;
                    continue;
                }
                $work = [
                    '@type' => 'CreativeWork',
                    'name' => $name,
                ];
                if ($url !== '') {
                    $work['url'] = $url;
                }
                if (!empty($source['author'])) {
                    $work['author'] = (string) $source['author'];
                }
                if (!empty($source['year'])) {
                    $work['datePublished'] = (string) $source['year'];
                }
                $citations[] = $work;
            }
            if (!empty($citations)) {
                $article['citation'] = $citations;
            }
        }

        $image = get_site_icon_url(512);
        if ($image) {
            $article['image'] = [$image];
        }

        // Entity layer: `about` (primary topic) + `mentions` (secondary topics), each
        // anchored to a Wikipedia URI via sameAs so Google can resolve the page to
        // Knowledge Graph entities instead of inferring the topic from text alone.
        $entities = $this->get_guide_entities($slug, (string) ($entry['cluster'] ?? ''));
        if (!empty($entities['about'])) {
            $article['about'] = $entities['about'];
        }
        if (!empty($entities['mentions'])) {
            $article['mentions'] = $entities['mentions'];
        }

        $article['inLanguage'] = 'en-US';
        $article['isPartOf'] = ['@id' => home_url('/#website')];
        // E-E-A-T: point Google at the editorial standards behind every guide.
        $editorial_policy = get_page_by_path('editorial-policy');
        if ($editorial_policy) {
            $article['publishingPrinciples'] = get_permalink($editorial_policy);
        }

        $this->output_json_ld($article);
    }

    /**
     * Knowledge Graph entity registry for guides.
     *
     * Every sameAs URL below was verified live (HTTP 200 on en.wikipedia.org,
     * 2026-07-10). Do NOT add entries with unverified URLs — a sameAs that 404s
     * is worse than no entity link at all.
     */
    private function get_guide_entities($slug, $cluster)
    {
        $wiki = static function ($name, $path) {
            return [
                '@type' => 'Thing',
                'name' => $name,
                'sameAs' => 'https://en.wikipedia.org/wiki/' . $path,
            ];
        };

        // Slug-keyword rules, most specific first. First match becomes `about`;
        // its companion entities become `mentions`.
        $rules = [
            'pomodoro' => [$wiki('Pomodoro Technique', 'Pomodoro_Technique'), $wiki('Time management', 'Time_management')],
            'deep-work' => [$wiki('Deep Work', 'Deep_Work'), $wiki('Attention', 'Attention'), $wiki('Flow (psychology)', 'Flow_(psychology)')],
            '52-17' => [$wiki('Time management', 'Time_management'), $wiki('Pomodoro Technique', 'Pomodoro_Technique')],
            'time-blocking' => [$wiki('Time management', 'Time_management')],
            'tabata' => [$wiki('High-intensity interval training', 'High-intensity_interval_training')],
            'hiit' => [$wiki('High-intensity interval training', 'High-intensity_interval_training')],
            'plank' => [$wiki('Plank (exercise)', 'Plank_(exercise)'), $wiki('Exercise', 'Exercise')],
            'boxing' => [$wiki('Boxing training', 'Boxing_training')],
            'nap' => [$wiki('Power nap', 'Power_nap'), $wiki('Sleep', 'Sleep')],
            'sleep' => [$wiki('Sleep', 'Sleep')],
            'ultradian' => [$wiki('Ultradian rhythm', 'Ultradian_rhythm'), $wiki('Circadian rhythm', 'Circadian_rhythm')],
            'spaced-repetition' => [$wiki('Spaced repetition', 'Spaced_repetition'), $wiki('Study skills', 'Study_skills')],
            'flashcard' => [$wiki('Spaced repetition', 'Spaced_repetition')],
            'boil-eggs' => [$wiki('Boiled egg', 'Boiled_egg'), $wiki('Egg timer', 'Egg_timer')],
            'meditat' => [$wiki('Meditation', 'Meditation')],
            'mindfulness' => [$wiki('Meditation', 'Meditation')],
            'breath' => [$wiki('Meditation', 'Meditation')],
            'study' => [$wiki('Study skills', 'Study_skills')],
            'exam' => [$wiki('Study skills', 'Study_skills')],
            'accuracy' => [$wiki('Timer', 'Timer'), $wiki('Time perception', 'Time_perception')],
            'drift' => [$wiki('Timer', 'Timer'), $wiki('Time perception', 'Time_perception')],
        ];

        // Cluster fallbacks when no slug keyword matches.
        $cluster_map = [
            'pomodoro' => [$wiki('Pomodoro Technique', 'Pomodoro_Technique'), $wiki('Time management', 'Time_management')],
            'productivity' => [$wiki('Time management', 'Time_management'), $wiki('Productivity', 'Productivity')],
            'study' => [$wiki('Study skills', 'Study_skills')],
            'studying' => [$wiki('Study skills', 'Study_skills')],
            'accuracy' => [$wiki('Timer', 'Timer'), $wiki('Stopwatch', 'Stopwatch')],
            'fitness' => [$wiki('Interval training', 'Interval_training'), $wiki('Exercise', 'Exercise')],
            'exercise' => [$wiki('Exercise', 'Exercise')],
            'meditation' => [$wiki('Meditation', 'Meditation')],
            'cooking' => [$wiki('Cooking', 'Cooking')],
            'devices' => [$wiki('Timer', 'Timer')],
            'comparisons' => [$wiki('Time management', 'Time_management'), $wiki('Timer', 'Timer')],
        ];

        $matched = null;
        foreach ($rules as $keyword => $entity_set) {
            if (strpos($slug, $keyword) !== false) {
                $matched = $entity_set;
                break;
            }
        }
        if ($matched === null && isset($cluster_map[$cluster])) {
            $matched = $cluster_map[$cluster];
        }
        if ($matched === null) {
            return ['about' => [], 'mentions' => []];
        }

        return [
            'about' => [array_shift($matched)],
            'mentions' => $matched,
        ];
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
        if ($unit === 'hours') {
            return $value * 3600;
        }
        if ($unit === 'minutes') {
            return $value * 60;
        }
        return $value;
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
        } elseif ($unit === 'hours') {
            $hub_label = $loader->get_string('breadcrumb.hour_timers') ?: 'Hour Timers';
            $hub_url = home_url('/hour-timers/');
        } else {
            $hub_label = $loader->get_string('breadcrumb.second_timers') ?: 'Second Timers';
            $hub_url = home_url('/second-timers/');
        }

        $unit_label = ucfirst($unit);
        if ($unit === 'hours' && (int) $value === 1) {
            $unit_label = 'Hour';
        }
        $current_label = "{$value} " . $unit_label;

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
