<?php
/**
 * Timer unit taxonomy template.
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$term = get_queried_object();
$unit = $term instanceof WP_Term ? $term->slug : 'minutes';
$unit_label = $term instanceof WP_Term ? $term->name : 'Minute';
$buckets = $loader->get_buckets($unit);
$popular = $related->get_popular_posts($unit, 12);
$bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit($unit));
$usecase_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);
?>

<main class="site-main">
    <div class="container">
        <header class="section-header">
            <h1 class="page-h1"><?php echo esc_html($unit_label); ?> Timers</h1>
            <p class="page-intro">Browse all <?php echo esc_html(strtolower($unit_label)); ?> countdown durations with instant start, accurate background timing, and clear completion alerts. Choose a preset below or jump to a specific range based on your task.</p>
        </header>

        <?php if (!empty($bucket_terms)): ?>
            <section class="section">
                <h2 class="section-title">Browse <?php echo esc_html($unit_label); ?> Ranges</h2>
                <div class="taxonomy-hub-grid">
                    <?php foreach ($bucket_terms as $bucket_term): ?>
                        <?php $bucket_url = get_term_link($bucket_term); ?>
                        <?php if (is_wp_error($bucket_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> range</a></h3>
                            <p><?php echo esc_html($bucket_term->description ?: 'Timer archive for this duration range.'); ?></p>
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
                            <li><a href="<?php echo esc_url($usecase_url); ?>"><?php echo esc_html($unit_label); ?> timers for <?php echo esc_html(strtolower($usecase_term->name)); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if (!empty($popular)): ?>
            <section class="section">
                <h2 class="section-title">Popular <?php echo esc_html($unit_label); ?> Timers</h2>
                <div class="timer-grid">
                    <?php foreach ($popular as $timer_data): ?>
                        <?php blogtimer_render_timer_card($timer_data); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php foreach ($buckets as $bucket): ?>
            <?php $bucket_timers = $related->get_all_by_unit($unit, $bucket['id']); ?>
            <?php if (empty($bucket_timers)) {
                continue;
            } ?>
            <section class="section">
                <h2 class="section-title"><?php echo esc_html($bucket['label']); ?></h2>
                <p class="section-subtitle">
                    <?php echo esc_html($bucket['description']); ?>
                    <a href="<?php echo esc_url(blogtimer_get_term_url_by_slug('timer_bucket', $bucket['id'])); ?>">View this range archive.</a>
                </p>
                <div class="timer-grid">
                    <?php foreach ($bucket_timers as $timer_data): ?>
                        <?php blogtimer_render_timer_card($timer_data); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <section class="section">
            <div class="content-page container--narrow">
                <h2>Choosing the Right <?php echo esc_html($unit_label); ?> Duration</h2>
                <p>Use shorter durations when you need urgency and quick execution, and longer durations when your task requires sustained concentration. If your sessions often run over, increase your timer in small steps. If your focus drops early, shorten the interval and chain multiple sessions with planned breaks.</p>
                <p>For consistency, use the same duration for similar tasks during a full week. This helps your brain associate the timer start with a specific work mode, making it easier to enter focus quickly and reduce decision fatigue before each session.</p>
                <p>Need use-case recommendations? Visit the <a href="<?php echo esc_url(home_url('/use-cases/')); ?>">Timer Use Cases</a> hub for productivity, cooking, exercise, meditation, and study-specific setups.</p>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
