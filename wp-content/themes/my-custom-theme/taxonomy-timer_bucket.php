<?php
/**
 * Timer bucket taxonomy template.
 */
get_header();

$term = get_queried_object();
$bucket_name = $term instanceof WP_Term ? $term->name : 'Timer Bucket';
$bucket_desc = $term instanceof WP_Term ? $term->description : '';
$bucket_slug = $term instanceof WP_Term ? $term->slug : '';
$unit_slug = strpos($bucket_slug, 'seconds_') === 0 ? 'seconds' : 'minutes';
$unit_url = blogtimer_get_term_url_by_slug('timer_unit', $unit_slug);
$sibling_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit($unit_slug));
$usecase_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'cooking', 'exercise', 'meditation', 'studying']);

$query = new WP_Query([
    'post_type' => 'timer',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'timer_bucket',
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
            <h1 class="page-h1"><?php echo esc_html($bucket_name); ?></h1>
            <p class="page-intro"><?php echo esc_html($bucket_desc ?: 'Browse countdown durations in this range and select a timer that matches your pace and workload.'); ?></p>
        </header>

        <section class="section">
            <h2 class="section-title">Related Timer Archives</h2>
            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($unit_url); ?>"><?php echo esc_html(ucfirst($unit_slug)); ?> unit archive</a></h3>
                    <p>Open all <?php echo esc_html($unit_slug); ?> timers in one index and compare neighboring durations.</p>
                </article>
                <?php foreach ($sibling_bucket_terms as $sibling_term): ?>
                    <?php $sibling_url = get_term_link($sibling_term); ?>
                    <?php if (is_wp_error($sibling_url)) {
                        continue;
                    } ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($sibling_url); ?>"><?php echo esc_html($sibling_term->name); ?> range</a></h3>
                        <p><?php echo esc_html($sibling_term->description ?: 'Another duration bucket in the same unit family.'); ?></p>
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
                        <li><a href="<?php echo esc_url($usecase_url); ?>"><?php echo esc_html($bucket_name); ?> timers for <?php echo esc_html(strtolower($usecase_term->name)); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="section">
            <h2 class="section-title">Timers in This Range</h2>
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
                <p>No timers are currently assigned to this range.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </section>

        <section class="section">
            <div class="content-page container--narrow">
                <h2>When to Choose This Timer Bucket</h2>
                <p>Timer buckets group durations by intent. Short buckets are ideal for fast iterations and resistance-free starts. Medium buckets support complete task chunks with manageable cognitive load. Long and extended buckets are best when context switching is expensive and deep continuity matters.</p>
                <p>Start with a timer you can complete consistently, then scale upward only when your completion quality stays high. If you frequently pause sessions or restart, move one bucket shorter and stabilize your routine before increasing duration again.</p>
                <p>Compare other ranges in <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">Minute Timers</a> and <a href="<?php echo esc_url(home_url('/second-timers/')); ?>">Second Timers</a>.</p>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
