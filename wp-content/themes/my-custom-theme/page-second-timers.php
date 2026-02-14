<?php
/**
 * Template Name: Second Timers Hub
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$second_unit_url = blogtimer_get_term_url_by_slug('timer_unit', 'seconds');
$second_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('seconds'));
$usecase_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);
?>

<main class="site-main">
    <div class="container">
        <h1 class="page-h1">
            <?php echo esc_html($loader->get_string('hub.seconds.h1')); ?>
        </h1>
        <p class="page-intro">
            <?php echo esc_html($loader->get_string('hub.seconds.intro')); ?>
        </p>

        <section class="section">
            <h2 class="section-title">Browse Second Timer Archives</h2>
            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($second_unit_url); ?>">All Second Timers</a></h3>
                    <p>View every second-based timer page in one archive, from 1-second bursts to 60-second intervals.</p>
                </article>
                <?php foreach ($second_bucket_terms as $bucket_term): ?>
                    <?php $bucket_url = get_term_link($bucket_term); ?>
                    <?php if (is_wp_error($bucket_url)) {
                        continue;
                    } ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> second range</a></h3>
                        <p><?php echo esc_html($bucket_term->description ?: 'Duration grouping for this second timer range.'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($usecase_terms)): ?>
                <ul class="taxonomy-link-list" style="margin-top:var(--space-5);grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                    <?php foreach ($usecase_terms as $usecase_term): ?>
                        <?php $usecase_url = get_term_link($usecase_term); ?>
                        <?php if (is_wp_error($usecase_url)) {
                            continue;
                        } ?>
                        <li><a href="<?php echo esc_url($usecase_url); ?>">Second timers for <?php echo esc_html(strtolower($usecase_term->name)); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- All Seconds -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.browse_all')); ?>
            </h2>
            <p class="section-subtitle">Every second timer from 1 to 60. Click any duration to start counting down instantly.</p>
            <?php $sec_timers = $related->get_all_by_unit('seconds'); ?>
            <div class="timer-grid">
                <?php foreach ($sec_timers as $t):
                    blogtimer_render_timer_card($t); endforeach; ?>
            </div>
        </section>

        <!-- COMPREHENSIVE GUIDE CONTENT -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">The Complete Guide to Second Timers</h2>
                <div class="content-page">
                    <p>Second-based timers serve a fundamentally different purpose than their minute-based counterparts. While minute timers structure longer work sessions, second timers provide the precision required for activities where every moment counts. From high-intensity interval training to cooking techniques that demand exact timing, second timers are indispensable tools for anyone who needs accuracy at a granular level.</p>

                    <h3>When to Use a Second Timer</h3>
                    <p>Second timers are essential for activities measured in brief, precise intervals. The most common use cases include exercise intervals (HIIT circuits, Tabata rounds, rest periods between sets), cooking tasks (blanching vegetables, searing proteins, timing espresso pulls), games and challenges (speed rounds, physical challenges, party games), and quick mindfulness exercises (box breathing, grounding techniques).</p>
                    <p>Unlike minute timers, which are designed for extended focus periods, second timers create urgency. A 30-second countdown for a plank exercise generates a completely different psychological response than a 30-minute study session. The short duration makes every second feel important, which naturally increases effort and engagement.</p>

                    <h3>Second Timers for Exercise and Fitness</h3>
                    <p>High-Intensity Interval Training (HIIT) is one of the most popular applications for second timers. A typical HIIT workout alternates between periods of maximum effort and brief rest intervals. Common structures include 30 seconds of work followed by 10 seconds of rest (the Tabata protocol), 45 seconds on and 15 seconds off, or 20 seconds of all-out effort followed by 10 seconds of recovery.</p>
                    <p>Second timers are equally valuable for strength training rest periods. Research suggests that rest intervals between sets significantly affect training outcomes: shorter rests (30 to 60 seconds) promote muscular endurance and metabolic conditioning, while longer rests (2 to 5 minutes) favor maximum strength and power development. Using a timer for rest periods ensures consistency and prevents the common habit of resting too long between sets.</p>

                    <h3>Second Timers in the Kitchen</h3>
                    <p>Professional chefs rely on precise timing for techniques where a few seconds can mean the difference between perfect and overdone. Blanching vegetables requires plunging them into boiling water for exactly 30 to 60 seconds before transferring them to an ice bath. Searing a scallop demands 45 to 60 seconds per side for a golden crust without overcooking the center. Pulling an espresso shot typically takes 25 to 30 seconds for optimal extraction. Even soft-boiled eggs require precise second-level timing to achieve the ideal runny yolk.</p>

                    <h3>Breathing Exercises and Meditation</h3>
                    <p>Many mindfulness practices use second-based intervals for structured breathing. Box breathing, used by Navy SEALs and first responders to manage stress, involves inhaling for 4 seconds, holding for 4 seconds, exhaling for 4 seconds, and holding for 4 seconds. The 4-7-8 technique prescribes a 4-second inhale, 7-second hold, and 8-second exhale. While these are typically self-counted, using a second timer during practice helps build an accurate internal sense of timing that carries over to unguided sessions.</p>

                    <h3>Short Seconds: 1 to 10</h3>
                    <p>Timers of 1 to 10 seconds are used for extremely brief actions: reaction time drills, quick photography exposures, speed clicking challenges, or precisely timing a brief cooking step. These ultra-short countdowns demand immediate attention and are often used in gaming, competitions, and rapid-fire practice drills.</p>

                    <h3>Medium Seconds: 11 to 30</h3>
                    <p>The 11-to-30-second range is the most commonly used interval for exercise and fitness applications. A 20-second timer is the standard Tabata work interval, while 30 seconds is the most popular duration for bodyweight exercises like planks, wall sits, and jumping jacks. This range also covers most speed-based cooking techniques and quick mindfulness exercises.</p>

                    <h3>Long Seconds: 31 to 60</h3>
                    <p>Timers from 31 to 60 seconds bridge the gap between brief bursts and full minute-long activities. A 45-second work interval is popular in circuit training, while a 60-second rest period is standard for moderate-intensity strength training. This range is also common for speech practice, where speakers time individual talking points to stay within presentation limits.</p>

                    <h3>Tips for Using Second Timers Effectively</h3>
                    <p>Because second timers are short, preparation matters more than with longer durations. Have everything set up before you start the countdown -- your exercise position ready, your cooking ingredients prepped, your breathing pattern in mind. The timer should measure your activity, not your setup time.</p>
                    <p>For repetitive intervals (like HIIT circuits), consider using a minute timer set to the total workout length alongside second timers for individual intervals. This gives you both the macro view of your overall session and the micro precision of each rep. The Blog Timer's keyboard shortcuts (Space to start/pause, R to reset) make rapid-fire timing easy without reaching for the mouse between intervals.</p>
                </div>
            </div>
        </section>

        <!-- Popular Minute Timers (cross-link) -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.popular_timers')); ?>
            </h2>
            <p class="section-subtitle">Need a longer countdown? Browse our most popular minute timers.</p>
            <?php $popular_min = $related->get_popular_posts('minutes', 8); ?>
            <div class="timer-grid">
                <?php foreach ($popular_min as $t):
                    blogtimer_render_timer_card($t); endforeach; ?>
            </div>
            <div class="hub-cta">
                <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_minutes')); ?> &rarr;
                </a>
            </div>
        </section>

        <!-- How-to -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.how_to_use')); ?>
            </h2>
            <?php blogtimer_render_howto(); ?>
        </section>

        <!-- RELATED CATEGORIES -->
        <?php blogtimer_render_related_categories('second-timers'); ?>

        <!-- RELATED GUIDES -->
        <section class="section">
            <h2 class="section-title">Related Guides</h2>
            <div class="usecase-grid">
                <?php
                $guide_slugs = ['hiit-interval-timers', 'timer-accuracy', 'browser-timer-drift'];
                foreach ($guide_slugs as $gs) {
                    $g = get_page_by_path($gs, OBJECT, 'guide');
                    if ($g): ?>
                        <a href="<?php echo esc_url(get_permalink($g->ID)); ?>" class="card usecase-card" style="text-decoration:none;">
                            <div class="usecase-card-icon">G</div>
                            <h3><?php echo esc_html($g->post_title); ?></h3>
                            <p><?php echo esc_html(wp_trim_words($g->post_excerpt, 12)); ?></p>
                        </a>
                    <?php endif;
                }
                ?>
            </div>
        </section>

        <!-- CTA -->
        <div class="cta-banner">
            <h2>Ready to Time Your Next Interval?</h2>
            <p>Pick any second timer above and start your countdown with a single click. Precise, reliable, and free.</p>
            <a href="<?php echo esc_url(home_url('/pomodoro/')); ?>" class="btn btn--primary btn--large">Try the Pomodoro Timer</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
