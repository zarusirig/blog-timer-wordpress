<?php
/**
 * Template: Front Page — The Blog Timer
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();

$minute_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('minutes'));
$second_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('seconds'));
$usecase_archive_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);
$guide_cluster_terms = blogtimer_get_taxonomy_terms('guide_cluster', ['pomodoro', 'studying', 'exercise', 'cooking', 'meditation', 'accuracy']);
?>

<main class="site-main">
    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <h1>
                <?php echo esc_html($loader->get_string('home.h1')); ?>
            </h1>
            <p class="hero-subtext">
                <?php echo esc_html($loader->get_string('home.subtext')); ?>
            </p>
            <div class="hero-ctas">
                <a href="<?php echo esc_url(home_url('/timer/set-timer-for-5-minutes/')); ?>"
                    class="btn btn--primary btn--large">
                    <?php echo esc_html($loader->get_string('home.cta_primary')); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>" class="btn btn--secondary btn--large">
                    <?php echo esc_html($loader->get_string('home.cta_secondary')); ?>
                </a>
            </div>
            <div class="hero-trust">
                <span class="trust-item"><span class="trust-icon">&#10003;</span> No sign-up required</span>
                <span class="trust-item"><span class="trust-icon">&#10003;</span> 100% free forever</span>
                <span class="trust-item"><span class="trust-icon">&#10003;</span> Works on any device</span>
            </div>
        </div>
    </section>

    <!-- EMBEDDED TIMER WIDGET -->
    <section class="section">
        <div class="container container--narrow">
            <div class="timer-widget timer-widget--hero" id="home-timer" data-duration="300" data-unit="minutes"
                data-value="5">
                <button class="fullscreen-btn" id="timer-fullscreen" aria-label="Fullscreen timer" title="Fullscreen (F)">&#x26F6;</button>
                <div class="timer-label">
                    <?php echo esc_html($loader->get_string('ui.custom_timer')); ?>
                </div>
                <input type="text" class="timer-name-input" id="timer-name"
                    placeholder="<?php echo esc_attr($loader->get_string('ui.timer_name')); ?>">
                <div class="timer-display" id="timer-display">05:00</div>
                <div class="timer-progress">
                    <div class="timer-progress-bar" id="timer-progress-bar"></div>
                </div>
                <div class="timer-controls">
                    <button class="btn btn--primary btn--large" id="timer-start">
                        <?php echo esc_html($loader->get_string('ui.start')); ?>
                    </button>
                    <button class="btn btn--secondary btn--large" id="timer-reset">
                        <?php echo esc_html($loader->get_string('ui.reset')); ?>
                    </button>
                </div>
                <div class="timer-custom">
                    <input type="number" class="timer-custom-input" id="timer-custom-value" min="1" max="100" value="5"
                        placeholder="<?php echo esc_attr($loader->get_string('ui.enter_value')); ?>">
                    <div class="timer-unit-toggle">
                        <button class="active" data-unit="minutes">
                            <?php echo esc_html($loader->get_string('ui.unit_toggle_minutes')); ?>
                        </button>
                        <button data-unit="seconds">
                            <?php echo esc_html($loader->get_string('ui.unit_toggle_seconds')); ?>
                        </button>
                    </div>
                </div>
                <div class="kbd-hints">
                    <span class="kbd-hint"><kbd>Space</kbd> Start / Pause</span>
                    <span class="kbd-hint"><kbd>R</kbd> Reset</span>
                    <span class="kbd-hint"><kbd>F</kbd> Fullscreen</span>
                </div>
                <div class="timer-complete-banner" id="timer-complete-banner">
                    <h3>
                        <?php echo esc_html($loader->get_string('ui.time_up')); ?>
                    </h3>
                    <button class="btn btn--success" id="timer-replay-sound">
                        <?php echo esc_html($loader->get_string('ui.replay_sound')); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <section class="section">
        <div class="container">
            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-value">220+</span>
                    <span class="stat-label">Preset Timers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">1-161</span>
                    <span class="stat-label">Minute Range</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">1-60</span>
                    <span class="stat-label">Second Range</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Low</span>
                    <span class="stat-label">Distraction Design</span>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY USE AN ONLINE TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">Why Use an Online Timer?</h2>
            </div>
            <div class="content-page">
                <p>Online timers have become essential tools for productivity, cooking, exercise, studying, and meditation. Unlike physical timers or phone apps, a browser-based timer requires no installation, no sign-up, and works instantly on any device with a web browser. You open the page, press start, and get back to the task at hand.</p>

                <p>The Blog Timer was built because most online timer tools fall short in critical ways. Many are overloaded with advertisements that interrupt your focus. Others require you to download an app or create an account before you can set a simple countdown. Some lose track of time when you switch browser tabs, giving you an inaccurate alert. We built a timer that solves every one of these problems.</p>

                <p>Our timers use timestamp-based calculations rather than simple interval counters. This means even if you switch to another tab, minimize your browser, or let your screen go to sleep, the countdown remains perfectly accurate. When your timer ends, you receive a clear audio alert that works even if the tab is in the background. Your timer state is preserved in your browser's local storage, so an accidental page refresh will not lose your progress.</p>

                <p>Whether you need a quick 30-second countdown for a plank exercise, a 5-minute break timer, a 25-minute Pomodoro work session, or a 90-minute deep focus block, The Blog Timer has a dedicated page for every duration. Each timer page loads instantly, starts with a single click, and gives you a distraction-free experience designed to keep you in flow.</p>
            </div>
        </div>
    </section>

    <!-- POPULAR TIMERS GRID -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.popular_timers')); ?>
                </h2>
                <p class="section-subtitle">Choose a preset duration or browse by category. Every timer starts instantly with one click.</p>
            </div>

            <div class="tab-nav" id="popular-tabs">
                <button class="tab-btn active" data-filter="popular">Popular</button>
                <button class="tab-btn" data-filter="short">Short (1-10 min)</button>
                <button class="tab-btn" data-filter="medium">Medium (11-30 min)</button>
                <button class="tab-btn" data-filter="long">Long (31-60 min)</button>
                <button class="tab-btn" data-filter="extended">Extended (61+ min)</button>
                <button class="tab-btn" data-filter="seconds">Seconds</button>
            </div>

            <?php
            $popular = $related->get_popular_posts(null, 20);
            if (!empty($popular)):
                ?>
                <div class="timer-grid" id="timer-list-popular">
                    <?php foreach ($popular as $t):
                        blogtimer_render_timer_card($t);
                    endforeach; ?>
                </div>
            <?php endif; ?>

            <?php
            $buckets = ['short', 'medium', 'long', 'extended'];
            foreach ($buckets as $bucket):
                $bucket_timers = $related->get_all_by_unit('minutes', $bucket);
                if (!empty($bucket_timers)):
                    ?>
                    <div class="timer-grid" id="timer-list-<?php echo esc_attr($bucket); ?>" style="display:none;">
                        <?php foreach ($bucket_timers as $t):
                            blogtimer_render_timer_card($t, false);
                        endforeach; ?>
                    </div>
                <?php endif; endforeach; ?>

            <?php
            $sec_timers = $related->get_all_by_unit('seconds');
            if (!empty($sec_timers)):
                ?>
                <div class="timer-grid" id="timer-list-seconds" style="display:none;">
                    <?php foreach ($sec_timers as $t):
                        blogtimer_render_timer_card($t, false);
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- EXPLORE TAXONOMIES -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Explore Timer Categories and Topics</h2>
                <p class="section-subtitle">Browse all timer pages by duration type, range, use case, and guide topic to find the exact page you need faster.</p>
            </div>

            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3>Timer Units</h3>
                    <ul class="taxonomy-link-list">
                        <li><a href="<?php echo esc_url(blogtimer_get_term_url_by_slug('timer_unit', 'minutes')); ?>">Minute timer archive</a></li>
                        <li><a href="<?php echo esc_url(blogtimer_get_term_url_by_slug('timer_unit', 'seconds')); ?>">Second timer archive</a></li>
                    </ul>
                </article>

                <article class="card taxonomy-link-card">
                    <h3>Minute Timer Ranges</h3>
                    <ul class="taxonomy-link-list">
                        <?php foreach ($minute_bucket_terms as $bucket_term): ?>
                            <?php $bucket_url = get_term_link($bucket_term); ?>
                            <?php if (is_wp_error($bucket_url)) {
                                continue;
                            } ?>
                            <li><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> minute range</a></li>
                        <?php endforeach; ?>
                    </ul>
                </article>

                <article class="card taxonomy-link-card">
                    <h3>Second Timer Ranges</h3>
                    <ul class="taxonomy-link-list">
                        <?php foreach ($second_bucket_terms as $bucket_term): ?>
                            <?php $bucket_url = get_term_link($bucket_term); ?>
                            <?php if (is_wp_error($bucket_url)) {
                                continue;
                            } ?>
                            <li><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> second range</a></li>
                        <?php endforeach; ?>
                    </ul>
                </article>

                <article class="card taxonomy-link-card">
                    <h3>Use-Case Archives</h3>
                    <ul class="taxonomy-link-list">
                        <?php foreach ($usecase_archive_terms as $usecase_term): ?>
                            <?php $usecase_url = get_term_link($usecase_term); ?>
                            <?php if (is_wp_error($usecase_url)) {
                                continue;
                            } ?>
                            <li><a href="<?php echo esc_url($usecase_url); ?>"><?php echo esc_html($usecase_term->name); ?> timer use-case</a></li>
                        <?php endforeach; ?>
                    </ul>
                </article>

                <article class="card taxonomy-link-card">
                    <h3>Guide Clusters</h3>
                    <ul class="taxonomy-link-list">
                        <?php foreach ($guide_cluster_terms as $cluster_term): ?>
                            <?php $cluster_url = get_term_link($cluster_term); ?>
                            <?php if (is_wp_error($cluster_url)) {
                                continue;
                            } ?>
                            <li><a href="<?php echo esc_url($cluster_url); ?>"><?php echo esc_html($cluster_term->name); ?> guide topic</a></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <!-- KEY FEATURES -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.key_features')); ?>
                </h2>
                <p class="section-subtitle">Every feature is designed to make timing faster, easier, and more reliable than any alternative.</p>
            </div>
            <div class="features-grid">
                <div class="card feature-card">
                    <div class="feature-icon"><?php echo esc_html($loader->get_string('features.precision.title')[0] ?? 'P'); ?></div>
                    <h3><?php echo esc_html($loader->get_string('features.precision.title')); ?></h3>
                    <p><?php echo esc_html($loader->get_string('features.precision.desc')); ?> Our timestamp-based engine means your countdown never drifts, even if your device sleeps or you switch tabs. Unlike interval-based timers that lose accuracy over time, ours recalculates against the system clock every 100 milliseconds.</p>
                </div>
                <div class="card feature-card feature-card--cyan">
                    <div class="feature-icon"><?php echo esc_html($loader->get_string('features.audio.title')[0] ?? 'A'); ?></div>
                    <h3><?php echo esc_html($loader->get_string('features.audio.title')); ?></h3>
                    <p><?php echo esc_html($loader->get_string('features.audio.desc')); ?> The completion sound plays even when the tab is in the background, so you never miss the alert. You can also replay the sound at any time after the timer finishes.</p>
                </div>
                <div class="card feature-card feature-card--green">
                    <div class="feature-icon"><?php echo esc_html($loader->get_string('features.custom.title')[0] ?? 'C'); ?></div>
                    <h3><?php echo esc_html($loader->get_string('features.custom.title')); ?></h3>
                    <p><?php echo esc_html($loader->get_string('features.custom.desc')); ?> Set any duration from 1 to 100 in either minutes or seconds. Name your timer for easy reference. Your settings persist across sessions so you can pick up where you left off.</p>
                </div>
                <div class="card feature-card feature-card--amber">
                    <div class="feature-icon">K</div>
                    <h3>Keyboard Shortcuts</h3>
                    <p>Power users can control timers entirely from the keyboard. Press Space to start or pause, R to reset, and F to enter fullscreen mode. These shortcuts work on every timer page across the site, making The Blog Timer the fastest timer tool available.</p>
                </div>
                <div class="card feature-card">
                    <div class="feature-icon">F</div>
                    <h3>Fullscreen Mode</h3>
                    <p>Expand any timer to fill your entire screen with a single click or keypress. Fullscreen mode is perfect for presentations, classroom activities, group workouts, or any situation where you need the countdown visible from across the room.</p>
                </div>
                <div class="card feature-card feature-card--cyan">
                    <div class="feature-icon">D</div>
                    <h3>Works on Any Device</h3>
                    <p>The Blog Timer is fully responsive and tested across desktop browsers, tablets, and smartphones. The interface adapts to your screen size, and touch controls work seamlessly on mobile devices. No app download required.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- USE CASES -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.use_cases')); ?>
                </h2>
                <p class="section-subtitle">Timers are not one-size-fits-all. Explore curated timer recommendations for your specific activity.</p>
            </div>
            <?php
            $icons = [
                'productivity' => 'P',
                'cooking' => 'C',
                'exercise' => 'E',
                'meditation' => 'M',
                'studying' => 'S',
            ];
            $use_cases = $loader->get_use_cases();
            ?>
            <div class="usecase-grid">
                <?php foreach ($use_cases as $uc):
                    if (!$uc['enabled'])
                        continue;
                    $usecase_url = blogtimer_get_term_url_by_slug('timer_usecase', $uc['id']);
                    ?>
                    <a href="<?php echo esc_url($usecase_url); ?>" class="card usecase-card">
                        <div class="usecase-card-icon">
                            <?php echo $icons[$uc['id']] ?? 'T'; ?>
                        </div>
                        <h3>
                            <?php echo esc_html($uc['label']); ?>
                        </h3>
                        <p>
                            <?php echo esc_html($uc['description']); ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- GUIDES SECTION -->
    <section class="section">
        <div class="container active-guides">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html__('Guides and Tips', 'timer-engine'); ?>
                </h2>
                <p class="section-subtitle"><?php echo esc_html__('In-depth articles on time management, the Pomodoro method, exercise intervals, and getting the most out of your timer.', 'timer-engine'); ?></p>
            </div>
            <div class="usecase-grid">
                <?php
                $guide_slugs = [
                    'timer-accuracy',
                    'browser-timer-drift',
                    'pomodoro-technique',
                    'pomodoro-studying',
                    'study-timer-methods',
                    'hiit-interval-timers'
                ];

                foreach ($guide_slugs as $slug) {
                    $guide = get_page_by_path($slug, OBJECT, 'guide');
                    if ($guide) {
                        ?>
                        <a href="<?php echo esc_url(get_permalink($guide->ID)); ?>" class="card usecase-card guide-card"
                            style="text-decoration:none;">
                            <div class="usecase-card-icon">G</div>
                            <h3><?php echo esc_html($guide->post_title); ?></h3>
                            <p><?php echo esc_html(wp_trim_words($guide->post_excerpt, 15)); ?></p>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- HOW ONLINE TIMERS IMPROVE PRODUCTIVITY -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">How Online Timers Improve Your Productivity</h2>
            </div>
            <div class="content-page">
                <p>Research in cognitive psychology consistently shows that time-bounded work sessions lead to better focus and higher output. When you set a timer, you create what psychologists call a "commitment device" -- a concrete boundary that tells your brain the task has a defined endpoint. This simple act reduces procrastination because the work no longer feels infinite.</p>

                <p>The Pomodoro Technique, which uses 25-minute work intervals followed by 5-minute breaks, has been studied extensively since its creation in the late 1980s. Practitioners report increased focus, reduced mental fatigue, and a clearer sense of how long tasks actually take. But the Pomodoro method is just one approach. Many people find that shorter intervals of 10 to 15 minutes work better for tasks requiring creative thinking, while longer sessions of 45 to 90 minutes suit deep analytical work.</p>

                <p>Timers are equally valuable outside of work. In the kitchen, a reliable countdown prevents overcooked meals and burnt sauces. During exercise, interval timers structure HIIT workouts, rest periods, and circuit training with precision. For meditation, a gentle timer lets you close your eyes without worrying about losing track of time. Students use timers to break study marathons into focused review blocks, improving retention and reducing burnout.</p>

                <p>The key to getting value from a timer is consistency. When you use the same tool every day, starting a timer becomes an automatic trigger for focus. Your brain learns to associate the countdown with productive work, creating a habit loop that gets stronger over time. The Blog Timer is designed to be that consistent, reliable tool -- always available, always accurate, and never in your way.</p>
            </div>
        </div>
    </section>

    <?php blogtimer_render_ad_slot('front_page_mid_content'); ?>

    <!-- HOW TO USE -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.how_to_use')); ?>
                </h2>
                <p class="section-subtitle">Getting started takes less than three seconds. No account, no setup, no configuration.</p>
            </div>
            <?php blogtimer_render_howto(); ?>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.faq')); ?>
                </h2>
            </div>
            <?php
            $home_faqs = [];
            $copyblocks_path = ABSPATH . '../datasets/copyblocks.json';
            if (file_exists($copyblocks_path)) {
                $cb = json_decode(file_get_contents($copyblocks_path), true);
                foreach ($cb['faqs'] as $key => $faq) {
                    if (strpos($key, 'faq_timer_') === 0) {
                        $home_faqs[] = $faq['en'];
                    }
                    if (count($home_faqs) >= 5)
                        break;
                }
            }
            blogtimer_render_faq($home_faqs);
            ?>
        </div>
    </section>

    <!-- CTA BANNER -->
    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>Ready to Start Timing?</h2>
                <p>Pick any duration and begin your countdown instantly. No sign-up, no downloads, no distractions.</p>
                <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>" class="btn btn--primary btn--large">Browse All Timers</a>
            </div>
        </div>
    </section>
</main>

<!-- Fullscreen overlay -->
<div class="timer-fullscreen-overlay" id="timer-fullscreen-overlay">
    <button class="fullscreen-close" id="fullscreen-close" aria-label="Exit fullscreen">&times;</button>
    <div class="fullscreen-display" id="fullscreen-display">05:00</div>
    <div class="fullscreen-label">The Blog Timer</div>
</div>

<script>
    // Tab filtering for popular timers grid
    document.addEventListener('DOMContentLoaded', function () {
        var tabs = document.querySelectorAll('#popular-tabs .tab-btn');
        var grids = document.querySelectorAll('[id^="timer-list-"]');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                var filter = tab.getAttribute('data-filter');
                grids.forEach(function (grid) {
                    grid.style.display = grid.id === 'timer-list-' + filter ? '' : 'none';
                });
            });
        });
    });
</script>

<?php get_footer(); ?>
