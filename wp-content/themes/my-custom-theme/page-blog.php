<?php
/**
 * Template Name: Blog Index
 *
 * The /blog hub: newest guest articles + links to every approved topic archive.
 * Assigned to the "Blog" page (slug: blog) by the guest-blog setup script.
 */
get_header();

$latest = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'no_found_rows' => true,
    'ignore_sticky_posts' => true,
]);
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">

        <header class="section-header">
            <p class="gp-kicker">The Blog Timer Blog</p>
            <h1 class="page-h1">Expert Insights &amp; Guest Articles</h1>
            <p class="page-intro">Practical articles from our editorial team and guest contributors — time management, productivity tools, technology, and working smarter. Every submission passes editorial review before publishing.</p>
        </header>

        <section class="section">
            <h2 class="section-title">Browse by Topic</h2>
            <div class="taxonomy-hub-grid">
                <?php
                foreach (blogtimer_indexable_category_slugs() as $topic_slug) {
                    $topic_term = get_term_by('slug', $topic_slug, 'category');
                    if ($topic_term && !is_wp_error($topic_term)) {
                        $topic_desc = $topic_term->description
                            ? wp_trim_words(wp_strip_all_tags($topic_term->description), 18, '…')
                            : 'Guest articles on this topic.';
                        printf(
                            '<article class="card taxonomy-link-card"><h3><a href="%s">%s</a></h3><p>%s</p></article>',
                            esc_url(get_term_link($topic_term)),
                            esc_html($topic_term->name),
                            esc_html($topic_desc)
                        );
                    }
                }
                ?>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Latest Articles</h2>
            <?php if ($latest->have_posts()): ?>
                <div class="archive-grid">
                    <?php while ($latest->have_posts()): $latest->the_post(); ?>
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
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="content-page container--narrow">
                    <p>No guest articles have been published yet. Want to be the first? Read our <a href="<?php echo esc_url(home_url('/write-for-us')); ?>">Write for Us</a> guidelines.</p>
                </div>
            <?php endif; ?>
        </section>

        <section class="section">
            <div class="content-page container--narrow gp-wfw-cta">
                <h2>Want to contribute?</h2>
                <p>We accept original, well-researched guest articles on the topics above. See the rules and submit via our <a href="<?php echo esc_url(home_url('/write-for-us')); ?>">Write for Us</a> page.</p>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
