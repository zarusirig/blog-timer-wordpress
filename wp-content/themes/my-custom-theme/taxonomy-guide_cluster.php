<?php
/**
 * Guide cluster taxonomy template.
 */
get_header();

$term = get_queried_object();
$cluster_name = $term instanceof WP_Term ? $term->name : 'Guide Cluster';
$cluster_desc = $term instanceof WP_Term ? $term->description : '';
$cluster_terms = blogtimer_get_taxonomy_terms('guide_cluster', ['pomodoro', 'studying', 'exercise', 'cooking', 'meditation', 'accuracy']);
$guide_hubs = [
    ['label' => 'All Guides', 'url' => home_url('/guides/')],
    ['label' => 'Minute Timers Hub', 'url' => home_url('/minute-timers/')],
    ['label' => 'Second Timers Hub', 'url' => home_url('/second-timers/')],
    ['label' => 'Pomodoro Hub', 'url' => home_url('/pomodoro/')],
];
?>

<main class="site-main">
    <div class="container">
        <header class="section-header">
            <h1 class="page-h1"><?php echo esc_html($cluster_name); ?> Guides</h1>
            <p class="page-intro"><?php echo esc_html($cluster_desc ?: 'Deep-dive guides for this topic, with linked timer pages and practical implementation patterns.'); ?></p>
        </header>

        <section class="section">
            <h2 class="section-title">Related Guide Collections</h2>
            <div class="taxonomy-hub-grid">
                <?php foreach ($cluster_terms as $cluster_term): ?>
                    <?php $cluster_url = get_term_link($cluster_term); ?>
                    <?php if (is_wp_error($cluster_url)) {
                        continue;
                    } ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($cluster_url); ?>"><?php echo esc_html($cluster_term->name); ?> guides</a></h3>
                        <p><?php echo esc_html($cluster_term->description ?: 'Topic-specific guide archive with practical methods and linked timers.'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <ul class="taxonomy-link-list" style="margin-top:var(--space-5);grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                <?php foreach ($guide_hubs as $hub): ?>
                    <li><a href="<?php echo esc_url($hub['url']); ?>"><?php echo esc_html($hub['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="section">
            <h2 class="section-title">All Guides in This Cluster</h2>
            <?php if (have_posts()): ?>
                <div class="archive-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <article class="card guide-archive-card">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 32)); ?></p>
                            <a class="btn btn--secondary" href="<?php the_permalink(); ?>">Read Guide</a>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="archive-nav"><?php the_posts_navigation(); ?></div>
            <?php else: ?>
                <p>No guides were found for this cluster.</p>
            <?php endif; ?>
        </section>

        <section class="section">
            <div class="content-page container--narrow">
                <h2>How to Read This Cluster Efficiently</h2>
                <p>Start with the foundational guide first, then move to implementation and troubleshooting articles. This order reduces contradictory advice and helps you build a stable timing workflow with fewer resets.</p>
                <p>Each article is designed to connect directly to timer pages so you can move from concept to execution in one click. Keep one guide open and one timer page running side-by-side while testing methods in real sessions.</p>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
