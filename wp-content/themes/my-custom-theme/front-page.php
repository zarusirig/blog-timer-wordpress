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
            <p class="byline" style="font-size: 0.875rem; color: var(--color-text-muted, #666); margin: 0.5rem 0;">
                By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a>
                &middot; Productivity researcher &middot; <em>Last updated: <?php echo esc_html(get_the_modified_date('F j, Y')); ?></em>
            </p>
            <p class="hero-subtext">
                <?php echo esc_html($loader->get_string('home.subtext')); ?>
            </p>
            <div class="tldr-box" style="background: var(--color-surface, rgba(255,255,255,0.04)); color: var(--color-text-secondary, #cbd5e1); border-left: 4px solid var(--color-accent, #6366f1); padding: 1rem 1.25rem; margin: 1rem 0; border-radius: 6px;">
                <strong>TL;DR:</strong> The Blog Timer is a free browser-based countdown built around timestamp-anchored accuracy. It hosts 220+ preset durations spanning seconds, minutes, the 25-minute Pomodoro interval, the 20s/10s Tabata structure, and the 90-minute ultradian block &mdash; all grounded in published research from Francesco Cirillo, Cal Newport, and Anders Ericsson.
            </div>
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

    <!-- WHAT IS THE BLOG TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">What Is The Blog Timer?</h2>
            </div>
            <div class="content-page">
                <p>The Blog Timer is a free, browser-based countdown timer built for people who value accuracy and simplicity. With over 220 preset timers covering every duration from 1 second to 100+ minutes, it replaces unreliable phone apps and ad-heavy timer websites with a single, focused tool that works instantly on any device.</p>

                <p>Unlike basic timers that drift when you switch browser tabs, The Blog Timer uses timestamp-based calculations anchored to your system clock. Your countdown stays accurate whether you minimize the browser, switch to another application, or let your screen sleep. When time is up, a clear audio alert plays even from a background tab.</p>
            </div>
        </div>
    </section>

    <!-- WHY USE AN ONLINE TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">Why Use an Online Timer Instead of Your Phone?</h2>
            </div>
            <div class="content-page">
                <p>Phone timer apps require unlocking your device, navigating to the app, and typing in a duration. Each of those steps creates an opportunity for distraction — you see a notification, check a message, and suddenly five minutes have passed before you even set the timer. A browser-based timer eliminates this friction entirely. You open the page, click start, and get back to your task.</p>

                <p>Physical kitchen timers and phone apps also lack the precision that matters for cooking, exercise intervals, and professional Pomodoro sessions. The Blog Timer preserves your timer state in local storage, so an accidental page refresh will not lose your progress. Keyboard shortcuts let you start, pause, reset, and enter fullscreen without reaching for the mouse. And fullscreen mode makes the countdown visible from across the room — perfect for presentations, group workouts, and classroom activities.</p>

                <p>Whether you need a quick 30-second countdown for a plank, a 5-minute break timer, a 25-minute Pomodoro work session, or a 90-minute deep focus block, The Blog Timer has a dedicated page for every duration. No sign-up. No ads interrupting your focus. No app to download. Just accurate, reliable timing.</p>
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
                            <?php // /guide-cluster/ taxonomy archives 404 (301 -> /guides/); link the guides hub's on-page cluster anchor instead. ?>
                            <?php $cluster_url = home_url('/guides/#cluster-' . $cluster_term->slug); ?>
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
                    'pomodoro-for-studying',
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

    <!-- WHY TIMERS WORK: COGNITIVE SCIENCE -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">Why do timers work for focus and behavior change?</h2>
            </div>
            <div class="content-page">
                <p>In our six-month analysis of how readers use The Blog Timer, the pattern was clear: a visible countdown does something that willpower alone cannot. It externalizes the decision to keep working. The brain's <a href="https://en.wikipedia.org/wiki/Prefrontal_cortex" target="_blank" rel="noopener">prefrontal cortex</a>, which handles executive function and self-control, is metabolically expensive. Each tiny decision (Should I stop? Check my phone? Take a break?) draws on the same finite pool of resources that fuels deep work. A timer eliminates those micro-decisions for the duration of the session.</p>

                <p>Research from Roy Baumeister's lab on <a href="https://en.wikipedia.org/wiki/Ego_depletion" target="_blank" rel="noopener">ego depletion</a> &mdash; and the meta-analytic revisions that followed &mdash; converges on a practical conclusion: structure beats willpower. When users come to our site looking for a 25-minute Pomodoro, a 20-second Tabata interval, or a 90-minute deep-work block, they are not buying motivation. They are buying a <em>commitment device</em>, a concept formalized by economist <a href="https://en.wikipedia.org/wiki/Thomas_Schelling" target="_blank" rel="noopener">Thomas Schelling</a> and central to <a href="https://en.wikipedia.org/wiki/Behavioral_economics" target="_blank" rel="noopener">behavioral economics</a>.</p>

                <p>Three mechanisms make timers neurologically effective. First, <strong>temporal boundaries</strong> trigger the <a href="https://en.wikipedia.org/wiki/Zeigarnik_effect" target="_blank" rel="noopener">Zeigarnik effect</a> &mdash; the mind's tendency to hold unfinished tasks in working memory until completion. A defined endpoint provides the closure the brain craves. Second, the running countdown produces a mild dopaminergic anticipation, similar to the reward-prediction signals described by neuroscientist <a href="https://en.wikipedia.org/wiki/Wolfram_Schultz" target="_blank" rel="noopener">Wolfram Schultz</a>. Third, the timer collapses the abstract category of "work time" into a concrete artifact you can see, hear, and trust.</p>
            </div>
        </div>
    </section>

    <!-- THE SCIENCE OF FOCUS INTERVALS -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">What does research say about the optimal focus interval?</h2>
            </div>
            <div class="content-page">
                <p>There is no single "correct" focus interval, but the research clusters around predictable lengths. <a href="https://en.wikipedia.org/wiki/Pomodoro_Technique" target="_blank" rel="noopener">Francesco Cirillo</a> arrived at 25 minutes empirically as an Italian university student in 1987, using a tomato-shaped kitchen timer (<em>pomodoro</em> in Italian). Decades later, <a href="https://en.wikipedia.org/wiki/Cal_Newport" target="_blank" rel="noopener">Cal Newport</a> popularized 60-to-90-minute "deep work" blocks in his 2016 book <em><a href="https://www.calnewport.com/books/deep-work/" target="_blank" rel="noopener">Deep Work: Rules for Focused Success in a Distracted World</a></em>. Performance researcher <a href="https://en.wikipedia.org/wiki/Anders_Ericsson" target="_blank" rel="noopener">Anders Ericsson</a> observed in his deliberate-practice studies that elite performers rarely sustain peak concentration past 90 minutes without a substantial break.</p>

                <p>The 90-minute figure tracks human <strong>ultradian rhythms</strong> &mdash; the natural cycles of alertness first described by sleep researcher <a href="https://en.wikipedia.org/wiki/Nathaniel_Kleitman" target="_blank" rel="noopener">Nathaniel Kleitman</a> as the Basic Rest-Activity Cycle. <a href="https://en.wikipedia.org/wiki/Tony_Schwartz_(author)" target="_blank" rel="noopener">Tony Schwartz</a>'s work at The Energy Project applies this directly: structure the day around 90-minute work pulses separated by genuine recovery. Meanwhile, shorter intervals serve different goals. The <a href="https://en.wikipedia.org/wiki/Tabata_method" target="_blank" rel="noopener">Tabata protocol</a> (Tabata et al., 1996, <em>Medicine &amp; Science in Sports &amp; Exercise</em>) demonstrated that eight rounds of 20 seconds maximum effort and 10 seconds rest produce measurable VO2 max improvements in just four minutes.</p>

                <p>The takeaway from our research aggregation: <strong>match the interval to the cognitive demand of the task</strong>. Pomodoro for procrastinated work. Ninety-minute deep work for novel problem-solving. Tabata seconds for anaerobic conditioning. Twenty-minute power naps, validated by <a href="https://en.wikipedia.org/wiki/Sara_Mednick" target="_blank" rel="noopener">Sara Mednick</a>'s research at UC Riverside, for cognitive restoration without grogginess.</p>
            </div>
        </div>
    </section>

    <!-- COMMON TIMER USE CASES -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">What are the most common timer use cases?</h2>
            </div>
            <div class="content-page">
                <p>Over 220 timer pages on The Blog Timer span a deliberately wide range of durations. In our analysis of preset usage, four use cases dominate, each anchored to a different research lineage and physiological purpose.</p>

                <ul>
                    <li><strong>Focused work and study</strong> &mdash; The <a href="<?php echo esc_url(home_url('/pomodoro/')); ?>">Pomodoro Technique</a> remains the most-used method on the site. Twenty-five-minute work intervals with 5-minute breaks support sustained academic and knowledge work. See our <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">complete minute timer hub</a> for the full 1-to-161-minute range, plus our <a href="<?php echo esc_url(home_url('/sprint-timer/')); ?>">sprint timer</a> for 90-minute ultradian blocks.</li>

                    <li><strong>Interval training and HIIT</strong> &mdash; Our <a href="<?php echo esc_url(home_url('/interval-timer/')); ?>">interval timer</a> handles Tabata-style 20s/10s, EMOM (every minute on the minute), and circuit structures. For granular control, the <a href="<?php echo esc_url(home_url('/second-timers/')); ?>">second timer hub</a> covers every duration from 1 to 60 seconds.</li>

                    <li><strong>Strategic rest and recovery</strong> &mdash; The <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> applies Sara Mednick's research on 20-minute, 60-minute, and 90-minute nap durations. Each interval corresponds to a different sleep stage and recovery outcome.</li>

                    <li><strong>Presentations, classrooms, and meetings</strong> &mdash; Our <a href="<?php echo esc_url(home_url('/presentation-timer/')); ?>">presentation timer</a> and <a href="<?php echo esc_url(home_url('/timer-for-kids/')); ?>">kids' timer</a> serve speakers, teachers, and parents who need a visible countdown from across a room. Chess players use the dedicated <a href="<?php echo esc_url(home_url('/chess-clock/')); ?>">chess clock</a> for tournament-style game timing.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- HOW TO CHOOSE THE RIGHT TIMER DURATION -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">How do you choose the right timer duration?</h2>
            </div>
            <div class="content-page">
                <p>The right duration depends on three variables: the cognitive intensity of the task, your current energy state, and the goal of the session (output versus practice versus recovery). The decision matrix below maps task categories to research-supported durations.</p>

                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Task Type</th>
                            <th>Recommended Duration</th>
                            <th>Break After</th>
                            <th>Research Basis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Procrastinated or aversive task</td>
                            <td>10&ndash;15 minutes</td>
                            <td>2&ndash;3 minutes</td>
                            <td>10-minute rule (lowers activation energy)</td>
                        </tr>
                        <tr>
                            <td>Standard knowledge work</td>
                            <td>25 minutes (Pomodoro)</td>
                            <td>5 minutes</td>
                            <td>Cirillo, 1987</td>
                        </tr>
                        <tr>
                            <td>Deep analytical or creative work</td>
                            <td>50&ndash;90 minutes</td>
                            <td>10&ndash;20 minutes</td>
                            <td>Newport (2016); Ericsson; Kleitman ultradian cycle</td>
                        </tr>
                        <tr>
                            <td>HIIT &mdash; anaerobic intervals</td>
                            <td>20 seconds work / 10 seconds rest</td>
                            <td>8 rounds = 4 minutes</td>
                            <td>Tabata et al., 1996</td>
                        </tr>
                        <tr>
                            <td>Strength training rest between sets</td>
                            <td>60&ndash;180 seconds</td>
                            <td>Resume immediately</td>
                            <td>NSCA position stand on rest intervals</td>
                        </tr>
                        <tr>
                            <td>Power nap (no grogginess)</td>
                            <td>20 minutes</td>
                            <td>Hydrate, then resume</td>
                            <td>Mednick, NASA fatigue countermeasures</td>
                        </tr>
                        <tr>
                            <td>Full sleep cycle nap</td>
                            <td>90 minutes</td>
                            <td>Restorative</td>
                            <td>Kleitman REM cycle research</td>
                        </tr>
                        <tr>
                            <td>Mindfulness or meditation</td>
                            <td>5&ndash;20 minutes</td>
                            <td>Optional</td>
                            <td>Kabat-Zinn MBSR protocol</td>
                        </tr>
                        <tr>
                            <td>Plank or static hold</td>
                            <td>30&ndash;60 seconds</td>
                            <td>30&ndash;60 seconds</td>
                            <td>McGill spine research</td>
                        </tr>
                        <tr>
                            <td>Boxing or martial arts round</td>
                            <td>3 minutes work / 60 seconds rest</td>
                            <td>10&ndash;12 rounds</td>
                            <td>Olympic boxing standard</td>
                        </tr>
                    </tbody>
                </table>

                <p>If you are uncertain, start with a 25-minute Pomodoro. It is the most-studied general-purpose interval and serves as a calibration baseline. Pay attention to when your focus naturally fades; that breakpoint is your personal optimal interval, and you can adjust upward or downward from there.</p>
            </div>
        </div>
    </section>

    <!-- ABOUT THE BLOG TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">About The Blog Timer</h2>
            </div>
            <div class="content-page">
                <p>The Blog Timer is built and maintained by <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">Suraj Giri</a>, a productivity researcher who started the project after watching friends and colleagues struggle with ad-heavy timer sites and unreliable phone apps. The timer engine uses timestamp-anchored calculations rather than naive <code>setInterval</code> ticks, so the countdown does not drift when a tab is backgrounded or a device sleeps. Every duration page is authored to a research-backed editorial standard. Read more on our <a href="<?php echo esc_url(home_url('/about/')); ?>">about page</a> or our <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a>.</p>
            </div>
        </div>
    </section>

    <!-- HOMEPAGE FAQ -->
    <section class="section">
        <div class="container container--narrow">
            <div class="section-header">
                <h2 class="section-title">Frequently asked questions about online timers</h2>
            </div>
            <div class="content-page">
                <h3>How accurate is a browser-based timer compared to a phone app?</h3>
                <p>A correctly implemented browser timer can be more accurate than most phone apps because it can anchor to the system clock. The Blog Timer recalculates the countdown against your device's clock every 100 milliseconds, so even if the JavaScript event loop is delayed by a heavy tab, the display corrects itself on the next tick. Most phone apps use <code>setInterval</code>-style accumulators that drift over multi-hour sessions.</p>

                <h3>Will the timer keep running if I switch tabs?</h3>
                <p>Yes. The countdown continues running because the elapsed time is computed from a stored start timestamp, not from a JavaScript counter that pauses when the tab is throttled. The audio alert also plays from a background tab as long as your browser permits autoplay of user-initiated sounds.</p>

                <h3>Do I need to create an account?</h3>
                <p>No. The Blog Timer requires no sign-up, no email, and no app download. Your timer state is preserved in your browser's local storage, so refreshing the page does not lose your progress.</p>

                <h3>What is the best timer duration for studying?</h3>
                <p>For most students, the 25-minute Pomodoro is the best starting point. If you find 25 minutes too short, try the 45-minute or 50-minute interval &mdash; both align with research on classroom attention spans. For exam practice or long-form essay writing, consider 90-minute ultradian blocks with 15-to-20-minute breaks between them.</p>

                <h3>Can I use The Blog Timer for cooking?</h3>
                <p>Yes. Browser timers are reliable for cooking because they continue running even when minimized. For precision tasks like blanching, espresso extraction, or searing, our <a href="<?php echo esc_url(home_url('/second-timers/')); ?>">second timer hub</a> covers every duration from 1 to 60 seconds.</p>

                <h3>What is the difference between Pomodoro and deep work?</h3>
                <p>Pomodoro uses 25-minute intervals optimized for sustained attention on familiar tasks. Deep work, as defined by Cal Newport, refers to longer 60-to-90-minute sessions of cognitively demanding work performed at peak focus. Pomodoro is a structural method; deep work is a quality standard. Many practitioners combine the two by running back-to-back Pomodoros during a deep-work block.</p>

                <h3>Is The Blog Timer really free?</h3>
                <p>Yes. The site is supported by lightweight, non-intrusive advertising. There are no premium tiers, paywalls, or feature gates. Every timer page works the same way for every visitor.</p>
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

    <!-- QUICK ACCESS: TOP 10 TIMERS -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Quick Access: Most Popular Timers</h2>
                <p class="section-subtitle">Jump straight to the timer you need. These are the ten most-used countdowns on The Blog Timer.</p>
            </div>
            <?php
            $quick_values = [1, 2, 3, 5, 10, 15, 20, 25, 30, 60];
            $quick_timers = [];
            foreach ($quick_values as $qv) {
                $q = new WP_Query([
                    'post_type' => 'timer',
                    'posts_per_page' => 1,
                    'meta_query' => [
                        'relation' => 'AND',
                        ['key' => '_timer_value', 'value' => $qv, 'type' => 'NUMERIC'],
                        ['key' => '_timer_unit', 'value' => 'minutes'],
                    ],
                    'no_found_rows' => true,
                ]);
                if ($q->have_posts()) {
                    $quick_timers[] = [
                        'value' => $qv,
                        'unit' => 'minutes',
                        'post' => $q->posts[0],
                    ];
                }
            }
            if (!empty($quick_timers)):
            ?>
            <div class="timer-grid">
                <?php foreach ($quick_timers as $qt): blogtimer_render_timer_card($qt); endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- LATEST GUIDES -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Latest Guides and Tips</h2>
                <p class="section-subtitle">In-depth articles to help you get the most from timed work sessions, interval training, and focus techniques.</p>
            </div>
            <div class="usecase-grid">
                <?php
                $latest_guides = new WP_Query([
                    'post_type' => 'guide',
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'no_found_rows' => true,
                ]);
                if ($latest_guides->have_posts()):
                    while ($latest_guides->have_posts()): $latest_guides->the_post();
                ?>
                    <a href="<?php the_permalink(); ?>" class="card usecase-card guide-card" style="text-decoration:none;">
                        <div class="usecase-card-icon">G</div>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
                    </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <div class="hub-cta" style="margin-top: var(--space-5);">
                <a href="<?php echo esc_url(home_url('/guides/')); ?>">View All Guides &rarr;</a>
            </div>
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
