<?php
/**
 * Guide archive template.
 */
get_header();

// Render ALL guide clusters (was limited to 6, omitting fitness/productivity/study/
// devices/comparisons and ~51 guides). Ordered productivity-first per source context.
$guide_clusters = blogtimer_get_taxonomy_terms('guide_cluster', [
    'pomodoro',
    'productivity',
    'study',
    'studying',
    'meditation',
    'fitness',
    'exercise',
    'cooking',
    'devices',
    'comparisons',
    'accuracy',
]);

// Human-readable section labels keyed by cluster slug (fallback to term name).
$cluster_labels = [
    'pomodoro'     => 'Pomodoro',
    'productivity' => 'Productivity & Focus',
    'study'        => 'Study',
    'studying'     => 'Studying',
    'meditation'   => 'Meditation & Sleep',
    'fitness'      => 'Fitness & Training',
    'exercise'     => 'Exercise',
    'cooking'      => 'Cooking',
    'devices'      => 'Device Timers',
    'comparisons'  => 'Comparisons',
    'accuracy'     => 'Timer Accuracy',
];
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <header class="section-header">
            <h1 class="page-h1">Timer Guides and Strategy Library</h1>
            <p class="page-intro">Practical guides on Pomodoro workflows, focus blocks, study sessions, interval training, cooking timers, and browser timing accuracy. Use this archive to find implementation-ready advice for your exact timing scenario.</p>
        </header>

        <section class="section">
            <div class="content-page container--narrow">
                <h2>How to Use This Guide Library</h2>
                <p>Each guide includes a clear method, common pitfalls, and recommended timer durations that connect directly to live countdown pages. Start with the guide that matches your immediate goal, apply the suggested timing pattern for a week, then adjust based on your own results.</p>
                <p>If you are new to structured timing, begin with Pomodoro guides and short break intervals. If you need sustained concentration, move into deep-work and study patterns. For physical routines, jump directly to interval and rest-timer articles.</p>
            </div>
        </section>

        <?php if (!empty($guide_clusters)): ?>
            <section class="section">
                <h2 class="section-title">Browse by Guide Topic</h2>
                <p class="section-subtitle">Jump to any topic below &mdash; every guide is listed on this page.</p>
                <div class="taxonomy-hub-grid">
                    <?php foreach ($guide_clusters as $cluster_term): ?>
                        <?php
                        $label = $cluster_labels[$cluster_term->slug] ?? $cluster_term->name;
                        ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="#cluster-<?php echo esc_attr($cluster_term->slug); ?>"><?php echo esc_html($label); ?> Guides</a></h3>
                            <p><?php echo esc_html($cluster_term->description ?: 'Focused guide collection with implementation steps and linked timer pages.'); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title">All Guides by Topic</h2>
            <?php
            $any_guides = false;
            if (!empty($guide_clusters)):
                foreach ($guide_clusters as $cluster_term):
                    $cluster_query = new WP_Query([
                        'post_type'      => 'guide',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                        'no_found_rows'  => true,
                        'tax_query'      => [[
                            'taxonomy' => 'guide_cluster',
                            'field'    => 'slug',
                            'terms'    => [$cluster_term->slug],
                        ]],
                    ]);
                    if (!$cluster_query->have_posts()) {
                        wp_reset_postdata();
                        continue;
                    }
                    $any_guides = true;
                    $label = $cluster_labels[$cluster_term->slug] ?? $cluster_term->name;
                    ?>
                    <div class="guide-cluster-group" id="cluster-<?php echo esc_attr($cluster_term->slug); ?>">
                        <h3 class="section-title"><?php echo esc_html($label); ?> Guides</h3>
                        <div class="archive-grid">
                            <?php while ($cluster_query->have_posts()): $cluster_query->the_post(); ?>
                                <article class="card guide-archive-card">
                                    <h4><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 32)); ?></p>
                                    <a class="btn btn--secondary" href="<?php echo esc_url(get_permalink()); ?>">Read Guide</a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                endforeach;
            endif;

            if (!$any_guides): ?>
                <p>No guides found.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
