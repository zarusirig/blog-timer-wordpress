<?php
/**
 * Template Name: Minute Timers Hub
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$minute_unit_url = blogtimer_get_term_url_by_slug('timer_unit', 'minutes');
$minute_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('minutes'));
$usecase_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);
?>

<main class="site-main">
    <div class="container">
        <h1 class="page-h1">
            <?php echo esc_html($loader->get_string('hub.minutes.h1')); ?>
        </h1>
        <p class="page-intro">
            <?php echo esc_html($loader->get_string('hub.minutes.intro')); ?>
        </p>

        <section class="section">
            <h2 class="section-title">Browse Minute Timer Archives</h2>
            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($minute_unit_url); ?>">All Minute Timers</a></h3>
                    <p>View the complete minute unit archive from 1-minute timers through extended deep-work durations.</p>
                </article>
                <?php foreach ($minute_bucket_terms as $bucket_term): ?>
                    <?php $bucket_url = get_term_link($bucket_term); ?>
                    <?php if (is_wp_error($bucket_url)) {
                        continue;
                    } ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> minute range</a></h3>
                        <p><?php echo esc_html($bucket_term->description ?: 'Duration grouping for this minute timer range.'); ?></p>
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
                        <li><a href="<?php echo esc_url($usecase_url); ?>">Minute timers for <?php echo esc_html(strtolower($usecase_term->name)); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- Popular Minutes -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.popular_timers')); ?>
            </h2>
            <p class="section-subtitle">The most frequently used minute timers. Click any duration to start your countdown instantly.</p>
            <?php $popular = $related->get_popular_posts('minutes', 12); ?>
            <div class="timer-grid">
                <?php foreach ($popular as $t):
                    blogtimer_render_timer_card($t); endforeach; ?>
            </div>
        </section>

        <!-- Bucket sections -->
        <?php
        $buckets = $loader->get_buckets('minutes');
        foreach ($buckets as $bucket):
            $bucket_timers = $related->get_all_by_unit('minutes', $bucket['id']);
            if (empty($bucket_timers))
                continue;
            ?>
            <section class="section" id="<?php echo esc_attr($bucket['id']); ?>">
                <h2 class="section-title">
                    <?php echo esc_html($bucket['label']); ?>
                </h2>
                <p class="section-subtitle">
                    <?php
                    $bucket_archive_url = blogtimer_get_term_url_by_slug('timer_bucket', $bucket['id']);
                    echo esc_html($bucket['description']);
                    ?>
                    <a href="<?php echo esc_url($bucket_archive_url); ?>">View all pages in this range.</a>
                </p>
                <div class="timer-grid">
                    <?php foreach ($bucket_timers as $t):
                        blogtimer_render_timer_card($t); endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- COMPREHENSIVE GUIDE CONTENT -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">The Complete Guide to Minute Timers</h2>
                <div class="content-page">
                    <p>Minute-based timers are the backbone of structured time management. From quick kitchen countdowns to extended deep work sessions, choosing the right duration can make a meaningful difference in how you spend your time. This guide covers everything you need to know about selecting, using, and getting the most out of minute timers for any activity.</p>

                    <h3>Short Timers: 1 to 10 Minutes</h3>
                    <p>Short timers in the 1-to-10-minute range are designed for tasks that require brief, focused bursts of attention. A 1-minute timer is ideal for quick physical exercises like planks, wall sits, or jumping jacks. Two to three-minute timers work well for brewing tea, brushing teeth, or completing a single micro-task during a busy workday. Five-minute timers are among the most versatile durations, commonly used for short meditation sessions, quick writing sprints, or timed brainstorming exercises.</p>
                    <p>The 10-minute timer sits at the boundary between short and medium durations. It is a powerful tool for overcoming procrastination -- when a task feels overwhelming, committing to just 10 minutes of work often generates enough momentum to keep going. This approach, sometimes called the "10-minute rule," is widely recommended by productivity coaches because it lowers the psychological barrier to starting difficult tasks.</p>

                    <h3>Medium Timers: 11 to 30 Minutes</h3>
                    <p>Medium-duration timers are the sweet spot for most focused work sessions. A 15-minute timer provides enough time to make meaningful progress on a task without the mental fatigue that comes with longer sessions. Twenty-minute timers align well with cooking tasks like roasting vegetables, simmering sauces, or baking quick breads.</p>
                    <p>The 25-minute timer holds a special place in productivity culture as the standard Pomodoro interval. Developed by Francesco Cirillo in the late 1980s, the Pomodoro Technique uses 25-minute work sessions followed by 5-minute breaks to maintain sustained focus throughout the day. Researchers have found that this interval length is long enough to achieve flow state but short enough to prevent burnout. The 30-minute timer is popular for yoga sessions, study blocks, and as an alternative Pomodoro length for people who find 25 minutes too short.</p>

                    <h3>Long Timers: 31 to 60 Minutes</h3>
                    <p>Long timers in the 31-to-60-minute range are designed for activities that require extended, uninterrupted attention. A 45-minute timer matches the length of a standard classroom lecture and is widely used in educational contexts for study sessions. Many people find that 45 minutes represents the maximum duration for peak concentration before a break becomes necessary.</p>
                    <p>The 60-minute timer is the standard for hour-long activities: full workout sessions, long-form writing, exam practice, or deep project work. Setting a one-hour timer creates a defined container for work that is long enough to reach deep focus but bounded enough to prevent the open-ended drift that erodes productivity during "I'll just keep going" sessions.</p>

                    <h3>Extended Timers: 61 to 100 Minutes</h3>
                    <p>Extended timers beyond one hour serve specialized purposes. A 90-minute timer aligns with the body's natural ultradian rhythm -- research suggests that humans cycle between periods of high and low alertness in roughly 90-minute intervals. Working in 90-minute blocks followed by substantial breaks (15 to 20 minutes) is a strategy used by elite performers across creative, athletic, and academic fields.</p>
                    <p>Timers in the 75-to-100-minute range are also common for standardized test preparation, film screening sessions, and long-distance running or cycling. The Blog Timer supports every minute from 1 to 100, giving you precise control over your extended sessions without the limitations of apps that only offer preset intervals.</p>

                    <h3>Tips for Choosing the Right Duration</h3>
                    <p>The right timer length depends on the task, your energy level, and your experience with timed work. If you are new to structured timing, start with shorter durations (10 to 15 minutes) and gradually increase as your focus stamina improves. For creative work, shorter intervals often produce better results because they prevent overthinking. For analytical or repetitive work, longer intervals allow you to build momentum and reduce the overhead of frequent context switches.</p>
                    <p>Experiment with different durations over several days and pay attention to when your concentration naturally starts to fade. That point is your personal optimal interval. The Blog Timer makes experimentation easy -- just click a different duration and start a new session.</p>
                </div>
            </div>
        </section>

        <!-- How-to -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.how_to_use')); ?>
            </h2>
            <?php blogtimer_render_howto(); ?>
        </section>

        <!-- FAQ -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.faq')); ?>
            </h2>
            <?php
            $faqs = [];
            $cb_path = ABSPATH . '../datasets/copyblocks.json';
            if (file_exists($cb_path)) {
                $cb = json_decode(file_get_contents($cb_path), true);
                foreach ($cb['faqs'] as $key => $faq) {
                    if (strpos($key, 'faq_timer_') === 0)
                        $faqs[] = $faq['en'];
                }
            }
            blogtimer_render_faq(array_slice($faqs, 0, 6));
            ?>
        </section>

        <!-- RELATED CATEGORIES -->
        <?php blogtimer_render_related_categories('minute-timers'); ?>

        <!-- RELATED GUIDES -->
        <section class="section">
            <h2 class="section-title">Related Guides</h2>
            <div class="usecase-grid">
                <?php
                $guide_slugs = ['pomodoro-technique', 'timer-accuracy', 'study-timer-methods', 'deep-work-timers'];
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
            <h2>Need a Second-Based Timer?</h2>
            <p>For shorter intervals measured in seconds, check out our complete collection of second timers from 1 to 60 seconds.</p>
            <a href="<?php echo esc_url(home_url('/second-timers/')); ?>" class="btn btn--primary btn--large">Browse Second Timers</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
