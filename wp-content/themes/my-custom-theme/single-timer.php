<?php
/**
 * Template: Single Timer Page
 *
 * Renders: Breadcrumbs → H1 → Intro → Timer Widget → Quick Use Ideas
 *          → Related Timers → Hub CTA → How-to → FAQ → Schema (in wp_head)
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$post_id = get_the_ID();
$value = Timer_Engine::get_timer_value($post_id);
$unit = Timer_Engine::get_timer_unit($post_id);
$duration = Timer_Engine::get_duration_seconds($post_id);
$title = $loader->get_string("timer.title.{$unit}", ['value' => $value]);
$unit_terms = get_the_terms($post_id, 'timer_unit');
$bucket_terms = get_the_terms($post_id, 'timer_bucket');
$usecase_terms = get_the_terms($post_id, 'timer_usecase');
?>

<main class="site-main">
    <div class="container container--narrow">

        <!-- BREADCRUMBS -->
        <?php Timer_Engine::render_breadcrumbs($post_id); ?>

        <!-- H1 -->
        <h1 class="page-h1">
            <?php echo esc_html($title); ?>
        </h1>

        <!-- INTRO -->
        <?php
        $intro = $loader->get_intro($post);
        if ($intro):
            ?>
            <p class="page-intro">
                <?php echo esc_html($intro); ?>
            </p>
        <?php endif; ?>

        <!-- TIMER WIDGET -->
        <div class="timer-widget timer-widget--hero" id="page-timer" data-duration="<?php echo esc_attr($duration); ?>"
            data-unit="<?php echo esc_attr($unit); ?>" data-value="<?php echo esc_attr($value); ?>">
            <div class="timer-label">
                <?php echo esc_html($title); ?>
            </div>
            <input type="text" class="timer-name-input" id="timer-name"
                placeholder="<?php echo esc_attr($loader->get_string('ui.timer_name')); ?>">
            <div class="timer-display" id="timer-display">
                <?php
                if ($unit === 'minutes') {
                    printf('%02d:00', $value);
                } else {
                    if ($value >= 60) {
                        printf('%02d:%02d', floor($value / 60), $value % 60);
                    } else {
                        printf('00:%02d', $value);
                    }
                }
                ?>
            </div>
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
                <button class="btn btn--outline fullscreen-btn" id="timer-fullscreen" aria-label="Enter fullscreen">&#x26F6; Fullscreen</button>
            </div>
            <div class="timer-complete-banner" id="timer-complete-banner">
                <h3>
                    <?php echo esc_html($loader->get_string('ui.time_up')); ?>
                </h3>
                <button class="btn btn--success" id="timer-replay-sound">&#128266;
                    <?php echo esc_html($loader->get_string('ui.replay_sound')); ?>
                </button>
            </div>
            <div class="kbd-hints">
                <span><kbd>Space</kbd> Start / Pause</span>
                <span><kbd>R</kbd> Reset</span>
                <span><kbd>F</kbd> Fullscreen</span>
            </div>
        </div>

        <!-- QUICK USE IDEAS -->
        <?php
        $ideas = $loader->get_quick_use_ideas($post);
        if (!empty($ideas)):
            ?>
            <section class="section">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.quick_use_ideas')); ?>
                </h2>
                <div class="use-ideas">
                    <?php foreach ($ideas as $idea): ?>
                        <span class="use-idea-tag">✦
                            <?php echo esc_html($idea); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- RELATED TIMERS -->
        <?php
        $related_timers = $related->get_related($post);
        if (!empty($related_timers)):
            ?>
            <section class="related-section section">
                <h2>
                    <?php echo esc_html($loader->get_string('ui.related_timers')); ?>
                </h2>
                <div class="timer-grid">
                    <?php foreach ($related_timers as $rt):
                        blogtimer_render_timer_card($rt);
                    endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- HUB CTA -->
        <div class="hub-cta">
            <?php if ($unit === 'minutes'): ?>
                <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_minutes')); ?> →
                </a>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/second-timers/')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_seconds')); ?> →
                </a>
            <?php endif; ?>
        </div>

    <?php
    $has_tax_links = (!empty($unit_terms) && !is_wp_error($unit_terms)) || (!empty($bucket_terms) && !is_wp_error($bucket_terms)) || (!empty($usecase_terms) && !is_wp_error($usecase_terms));
    if ($has_tax_links):
        ?>
        <section class="section">
            <h2 class="section-title">Related Categories</h2>
            <div class="taxonomy-hub-grid">
                <?php if (!empty($unit_terms) && !is_wp_error($unit_terms)): ?>
                    <?php foreach ($unit_terms as $term): ?>
                        <?php $term_url = get_term_link($term); ?>
                        <?php if (is_wp_error($term_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($term_url); ?>"><?php echo esc_html($term->name); ?> timer archive</a></h3>
                            <p>Explore all countdown pages classified under the <?php echo esc_html(strtolower($term->name)); ?> unit.</p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($bucket_terms) && !is_wp_error($bucket_terms)): ?>
                    <?php foreach ($bucket_terms as $term): ?>
                        <?php $term_url = get_term_link($term); ?>
                        <?php if (is_wp_error($term_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($term_url); ?>"><?php echo esc_html($term->name); ?> range</a></h3>
                            <p>Compare similar duration pages within the <?php echo esc_html(strtolower($term->name)); ?> range.</p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($usecase_terms) && !is_wp_error($usecase_terms)): ?>
                    <?php foreach ($usecase_terms as $term): ?>
                        <?php $term_url = get_term_link($term); ?>
                        <?php if (is_wp_error($term_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($term_url); ?>"><?php echo esc_html($term->name); ?> use-case</a></h3>
                            <p>Browse timer pages mapped to <?php echo esc_html(strtolower($term->name)); ?> sessions and workflows.</p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- LEARN MORE / RELEVANT GUIDES -->
    <?php
    $relevant_guides = [];
    // Determine relevant guides based on unit/bucket/usecase
    // Logic: if minute timer -> accuracy guides. if short/pomodoro -> pomodoro guides.
    
    $potential_slugs = [];

    // Base guides for everyone
    $potential_slugs[] = 'timer-accuracy';

    // Specifics
    if ($unit === 'minutes') {
        if ($value >= 25 && $value <= 60) {
            $potential_slugs[] = 'pomodoro-technique';
            $potential_slugs[] = 'deep-work-timers';
        } elseif ($value < 10) {
            $potential_slugs[] = 'meditation-timers-beginners';
        }
    } elseif ($unit === 'seconds') {
        $potential_slugs[] = 'hiit-interval-timers';
        $potential_slugs[] = 'tabata-timer-guide';
    }

    // Fetch objects
    foreach ($potential_slugs as $slug) {
        $g = get_page_by_path($slug, OBJECT, 'guide');
        if ($g)
            $relevant_guides[] = $g;
        if (count($relevant_guides) >= 2)
            break; // Limit to 2
    }

    if (!empty($relevant_guides)):
        ?>
        <section class="section" style="margin-top: 3rem;">
            <h2 class="section-title"><?php echo esc_html__('Learn More', 'timer-engine'); ?></h2>
            <div class="usecase-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <?php foreach ($relevant_guides as $rg): ?>
                    <a href="<?php echo esc_url(get_permalink($rg->ID)); ?>" class="card usecase-card"
                        style="text-decoration:none;">
                        <div class="usecase-card-icon">📘</div>
                        <h3><?php echo esc_html($rg->post_title); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- HOW TO USE -->
    <section class="section">
        <h2 class="section-title">
            <?php echo esc_html($loader->get_string('ui.how_to_use')); ?>
        </h2>
        <?php blogtimer_render_howto(); ?>
    </section>

    <!-- FAQ -->
    <?php
    $faqs = $loader->get_faqs($post, 4);
    if (!empty($faqs)):
        ?>
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.faq')); ?>
            </h2>
            <?php blogtimer_render_faq($faqs); ?>
        </section>
    <?php endif; ?>

        <!-- CONTEXTUAL CONTENT -->
        <section class="section">
            <div class="content-page">
                <?php if ($unit === 'minutes'): ?>
                    <h2>How to Use a <?php echo esc_html($value); ?>-Minute Timer Effectively</h2>
                    <p>A <?php echo esc_html($value); ?>-minute timer creates a defined window of time that helps you focus on a single task without distraction. Whether you are working, studying, cooking, or exercising, setting a clear time boundary transforms vague intentions into concrete action. The countdown creates a mild sense of urgency that keeps your mind engaged while the defined endpoint prevents burnout and mental fatigue.</p>
                    <?php if ($value <= 10): ?>
                        <p>Short timers in the 1-to-10-minute range are ideal for micro-tasks, quick breaks, and brief exercises. A <?php echo esc_html($value); ?>-minute countdown works well for clearing a few emails, doing a short meditation, stretching between longer work sessions, or timing a quick recipe step. The brevity makes it easy to commit to — even when motivation is low, almost anyone can focus for <?php echo esc_html($value); ?> minutes.</p>
                        <p>The "<?php echo esc_html($value); ?>-minute rule" is a popular procrastination-beating technique: commit to working on a dreaded task for just <?php echo esc_html($value); ?> minutes. More often than not, the hardest part is starting, and once the timer is running, momentum carries you forward well past the initial countdown.</p>
                    <?php elseif ($value <= 30): ?>
                        <p>Timers in the 11-to-30-minute range hit the sweet spot for focused work sessions. A <?php echo esc_html($value); ?>-minute block provides enough time to make meaningful progress on a task without the mental fatigue that comes with longer unbroken periods. This duration aligns well with the Pomodoro Technique and similar structured productivity methods that alternate focused work with short breaks.</p>
                        <p>For cooking, <?php echo esc_html($value); ?> minutes covers a wide range of preparations — from roasting vegetables to simmering sauces to baking quick items. For exercise, this duration works for circuit training, yoga flows, or moderate cardio sessions. For studying, it provides a concentrated block that improves retention compared to marathon cramming sessions.</p>
                    <?php elseif ($value <= 60): ?>
                        <p>Longer timers between 31 and 60 minutes are designed for deep work — the kind of sustained, uninterrupted focus that produces your best output. A <?php echo esc_html($value); ?>-minute session gives you enough runway to enter a flow state, where concentration deepens and productivity peaks. This is the ideal range for complex writing, programming, analysis, and creative projects.</p>
                        <p>Research suggests that most people can maintain peak concentration for 45 to 60 minutes before needing a break. By setting a <?php echo esc_html($value); ?>-minute timer, you create a structured container that maximizes focus while preventing the open-ended drift that erodes productivity during "I'll just keep going" sessions. When the timer ends, take a genuine 10-to-15-minute break before starting another session.</p>
                    <?php else: ?>
                        <p>Extended timers beyond 60 minutes serve specialized purposes. A <?php echo esc_html($value); ?>-minute session aligns with ultradian rhythms — the natural 90-minute cycles of high and low alertness that researchers have identified in human biology. Working in alignment with these rhythms, rather than against them, can significantly improve both the quality and sustainability of your output.</p>
                        <p>This duration is also common for standardized test preparation, where simulating real exam conditions builds both knowledge and stamina. Athletes use extended timers for long-distance training sessions, and creative professionals use them for deep immersion in complex projects that require sustained concentration.</p>
                    <?php endif; ?>
                    <p>The Blog Timer's <?php echo esc_html($value); ?>-minute countdown uses timestamp-based accuracy, so it stays precise even if your browser tab goes to sleep or your device enters power-saving mode. The audio alert ensures you never miss the end of your session, and the fullscreen mode keeps the display visible from across the room.</p>
                <?php else: ?>
                    <h2>How to Use a <?php echo esc_html($value); ?>-Second Timer Effectively</h2>
                    <p>A <?php echo esc_html($value); ?>-second timer provides the precision required for activities where every moment counts. Unlike minute-based timers that structure longer sessions, second timers create intense, focused intervals that demand immediate action and full engagement.</p>
                    <?php if ($value <= 10): ?>
                        <p>Ultra-short timers of 1 to 10 seconds are used for reaction time drills, speed challenges, quick photography exposures, and precisely timing brief cooking steps. These durations create maximum urgency — every second feels significant, which naturally increases effort and concentration.</p>
                        <p>In fitness, <?php echo esc_html($value); ?>-second intervals work for explosive movements like box jumps, burpees, or sprint starts. In cooking, this duration covers quick techniques like flambeing, flash-searing, or timing a precise pour. In games and competitions, short countdowns add excitement and pressure.</p>
                    <?php elseif ($value <= 30): ?>
                        <p>The 11-to-30-second range is the most commonly used interval for exercise and fitness. A <?php echo esc_html($value); ?>-second timer is perfect for HIIT work intervals, Tabata rounds, plank holds, wall sits, and bodyweight exercises. This range also covers speed-based cooking techniques and quick mindfulness exercises like focused breathing.</p>
                        <p>For exercise, <?php echo esc_html($value); ?> seconds provides enough time for a challenging but achievable work interval. The brief duration makes it psychologically easier to push through discomfort — you know the end is coming soon, which helps you maintain intensity throughout the entire interval.</p>
                    <?php else: ?>
                        <p>Timers from 31 to 60 seconds bridge the gap between brief bursts and minute-long activities. A <?php echo esc_html($value); ?>-second interval is popular in circuit training, moderate-intensity exercises, and cooking techniques that need precise but not ultra-brief timing.</p>
                        <p>This duration also works well for speech practice, where speakers time individual talking points to stay within presentation limits. For breathing exercises, <?php echo esc_html($value); ?> seconds can structure longer inhale-hold-exhale cycles that promote relaxation and stress reduction.</p>
                    <?php endif; ?>
                    <p>The Blog Timer's second countdowns are built with the same timestamp-based accuracy as our minute timers. The display updates smoothly, the audio alert is clear without being jarring, and keyboard shortcuts let you start, pause, and reset without reaching for the mouse — essential when you are in the middle of a workout or cooking task.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php blogtimer_render_ad_slot('single_timer_after_content'); ?>

        <!-- SEE ALSO -->
        <?php blogtimer_render_see_also('timer'); ?>

    </div>
</main>

<!-- Fullscreen Overlay -->
<div class="timer-fullscreen-overlay" id="timer-fullscreen-overlay">
    <button class="fullscreen-close" id="fullscreen-close" aria-label="Exit fullscreen">&times;</button>
    <div class="fullscreen-display" id="fullscreen-display">00:00</div>
    <div class="fullscreen-label"><?php echo esc_html($title); ?></div>
</div>

<?php get_footer(); ?>
