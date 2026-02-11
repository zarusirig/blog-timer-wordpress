<?php
/**
 * Guide archive template.
 */
get_header();

$guide_clusters = blogtimer_get_taxonomy_terms('guide_cluster', ['pomodoro', 'studying', 'exercise', 'cooking', 'meditation', 'accuracy']);
?>

<main class="site-main">
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
                <div class="taxonomy-hub-grid">
                    <?php foreach ($guide_clusters as $cluster_term): ?>
                        <?php $cluster_url = get_term_link($cluster_term); ?>
                        <?php if (is_wp_error($cluster_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($cluster_url); ?>"><?php echo esc_html($cluster_term->name); ?> Guides</a></h3>
                            <p><?php echo esc_html($cluster_term->description ?: 'Focused guide collection with implementation steps and linked timer pages.'); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title">All Guides</h2>
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
                <p>No guides found.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
