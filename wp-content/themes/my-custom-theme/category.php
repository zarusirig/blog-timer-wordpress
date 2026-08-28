<?php
/**
 * Template: Guest-Blog Category Archive (/topics/{slug})
 *
 * Renders: Breadcrumbs → H1 → Category intro (term description) → Article cards →
 * Pagination → Cross-links to the other approved topics.
 */
get_header();

$term = get_queried_object();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <ol>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li><a href="<?php echo esc_url(home_url('/blog')); ?>">Blog</a></li>
                <li aria-current="page"><?php echo esc_html($term ? $term->name : ''); ?></li>
            </ol>
        </nav>

        <header class="section-header topic-header">
            <p class="gp-kicker">Topic</p>
            <h1 class="page-h1"><?php echo esc_html($term ? $term->name : ''); ?></h1>
            <?php if ($term && !empty($term->description)): ?>
                <p class="page-intro"><?php echo esc_html($term->description); ?></p>
            <?php endif; ?>
        </header>

        <?php if (have_posts()): ?>
            <section class="section">
                <div class="archive-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <article class="card guide-archive-card gp-article-card">
                            <?php if (has_post_thumbnail()): ?>
                                <a class="gp-card-thumb" href="<?php echo esc_url(get_permalink()); ?>" tabindex="-1" aria-hidden="true">
                                    <?php the_post_thumbnail('medium_large', ['loading' => 'lazy']); ?>
                                </a>
                            <?php endif; ?>
                            <p class="gp-card-meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('M j, Y')); ?></time>
                                &middot; <?php echo esc_html((string) blogtimer_read_time(get_the_ID())); ?> min read
                            </p>
                            <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 24)); ?></p>
                            <a class="btn btn--secondary" href="<?php echo esc_url(get_permalink()); ?>">Read Article</a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination([
                    'mid_size' => 1,
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                ]);
                ?>
            </section>
        <?php else: ?>
            <section class="section">
                <div class="content-page container--narrow">
                    <h2>No articles in this topic yet</h2>
                    <p>New guest articles are published here regularly. In the meantime, browse the other topics below or read our evidence-based <a href="<?php echo esc_url(home_url('/guides')); ?>">timer guides</a>.</p>
                </div>
            </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title">Browse Topics</h2>
            <div class="gp-topics-inline">
                <?php
                foreach (blogtimer_indexable_category_slugs() as $topic_slug) {
                    $topic_term = get_term_by('slug', $topic_slug, 'category');
                    if ($topic_term && !is_wp_error($topic_term)) {
                        printf(
                            '<a class="gp-topic-chip%s" href="%s">%s</a>',
                            ($term && $term->slug === $topic_slug) ? ' is-active' : '',
                            esc_url(get_term_link($topic_term)),
                            esc_html($topic_term->name)
                        );
                    }
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php get_footer();
