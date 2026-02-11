<?php
/**
 * Timer use case taxonomy template.
 */
get_header();

$term = get_queried_object();
$usecase_name = $term instanceof WP_Term ? $term->name : 'Timer Use Case';
$usecase_desc = $term instanceof WP_Term ? $term->description : '';
$sibling_usecases = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);
$minute_unit_url = blogtimer_get_term_url_by_slug('timer_unit', 'minutes');
$second_unit_url = blogtimer_get_term_url_by_slug('timer_unit', 'seconds');
$minute_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('minutes'));
$second_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('seconds'));

$query = new WP_Query([
    'post_type' => 'timer',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'timer_usecase',
            'field' => 'term_id',
            'terms' => (int) get_queried_object_id(),
        ],
    ],
    'meta_key' => '_timer_value',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'no_found_rows' => true,
]);
?>

<main class="site-main">
    <div class="container">
        <header class="section-header">
            <h1 class="page-h1"><?php echo esc_html($usecase_name); ?> Timers</h1>
            <p class="page-intro"><?php echo esc_html($usecase_desc ?: 'Use curated timer durations built for this activity and start countdowns instantly.'); ?></p>
        </header>

        <section class="section">
            <h2 class="section-title">Related Archives</h2>
            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($minute_unit_url); ?>">Minute timer archive</a></h3>
                    <p>Browse all minute-based durations recommended for long-form <?php echo esc_html(strtolower($usecase_name)); ?> tasks.</p>
                </article>
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($second_unit_url); ?>">Second timer archive</a></h3>
                    <p>Browse all second-based durations useful for short bursts and interval-style <?php echo esc_html(strtolower($usecase_name)); ?> sessions.</p>
                </article>
            </div>

            <?php if (!empty($sibling_usecases)): ?>
                <ul class="taxonomy-link-list" style="margin-top:var(--space-5);grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                    <?php foreach ($sibling_usecases as $sibling_term): ?>
                        <?php $sibling_url = get_term_link($sibling_term); ?>
                        <?php if (is_wp_error($sibling_url)) {
                            continue;
                        } ?>
                        <li><a href="<?php echo esc_url($sibling_url); ?>"><?php echo esc_html($sibling_term->name); ?> timer use-case</a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <ul class="taxonomy-link-list" style="margin-top:var(--space-4);grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                <?php foreach (array_merge($minute_bucket_terms, $second_bucket_terms) as $bucket_term): ?>
                    <?php $bucket_url = get_term_link($bucket_term); ?>
                    <?php if (is_wp_error($bucket_url)) {
                        continue;
                    } ?>
                    <li><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> timer range</a></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="section">
            <h2 class="section-title">Recommended Countdown Pages</h2>
            <?php if ($query->have_posts()): ?>
                <div class="timer-grid">
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <?php
                        $timer_value = (int) get_post_meta(get_the_ID(), '_timer_value', true);
                        $timer_unit = get_post_meta(get_the_ID(), '_timer_unit', true) ?: 'minutes';
                        blogtimer_render_timer_card([
                            'post' => get_post(),
                            'value' => $timer_value,
                            'unit' => $timer_unit,
                        ]);
                        ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No timers are currently mapped to this use case.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </section>

        <section class="section">
            <div class="content-page container--narrow">
                <h2>Applying Timers to <?php echo esc_html($usecase_name); ?></h2>
                <p>For best results, pair each timer with a clear task definition before pressing start. A named objective plus a fixed interval improves completion rates and keeps sessions measurable across days.</p>
                <p>Track which durations deliver both high-quality output and sustainable energy. If quality drops near the end of your interval, shorten by 5 to 10 minutes. If you consistently finish early, extend gradually and reassess after a week.</p>
                <p>Need broader recommendations? Visit <a href="<?php echo esc_url(home_url('/use-cases/')); ?>">Timer Use Cases</a> for a full breakdown by activity and common timing patterns.</p>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
