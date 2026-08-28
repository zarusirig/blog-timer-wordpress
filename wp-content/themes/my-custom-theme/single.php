<?php
/**
 * Template: Single Guest-Blog Post (/blog/{slug})
 *
 * Renders: Breadcrumbs → H1 → Byline → Featured Image → Content → Author Box → Related → Topics CTA
 *
 * Guest-author outbound links carry rel="nofollow" per the editorial policy
 * (Google link-spam rules for guest posts).
 */
get_header();

while (have_posts()) :
    the_post();
    $post_id = get_the_ID();

    $post_cats = get_the_category($post_id);
    $primary_cat = !empty($post_cats) ? $post_cats[0] : null;

    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name');
    $author_bio = get_the_author_meta('description');
    $author_url = get_the_author_meta('user_url');

    // Initials avatar (CSP blocks external avatar hosts, so no Gravatar).
    $initials = '';
    foreach (preg_split('/\s+/', trim((string) $author_name)) as $word) {
        if ($word !== '' && mb_strlen($initials) < 2) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }
    }
    if ($initials === '') {
        $initials = 'BT';
    }

    $read_minutes = blogtimer_read_time($post_id);
    ?>

    <main id="main" tabindex="-1" class="site-main">
        <div class="container container--narrow">

            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <ol>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog')); ?>">Blog</a></li>
                    <?php if ($primary_cat): ?>
                        <li><a href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a></li>
                    <?php endif; ?>
                    <li aria-current="page"><?php the_title(); ?></li>
                </ol>
            </nav>

            <header class="page-header custom-guide-header">
                <?php if ($primary_cat): ?>
                    <p class="gp-kicker"><a href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a></p>
                <?php endif; ?>
                <h1 class="page-h1"><?php the_title(); ?></h1>
                <p class="page-byline byline">
                    By
                    <?php if ($author_url): ?>
                        <a href="<?php echo esc_url($author_url); ?>" target="_blank" rel="nofollow sponsored noopener"><?php echo esc_html($author_name); ?></a>
                    <?php else: ?>
                        <?php echo esc_html($author_name); ?>
                    <?php endif; ?>
                    &middot; <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                    &middot; <em><?php echo esc_html((string) $read_minutes); ?> min read</em>
                </p>
                <?php if (has_excerpt()): ?>
                    <p class="page-intro"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()): ?>
                <figure class="gp-featured-image">
                    <?php
                    the_post_thumbnail('large', [
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                        'alt' => the_title_attribute(['echo' => false]),
                    ]);
                    ?>
                </figure>
            <?php endif; ?>

            <article class="guide-content content-page">
                <?php the_content(); ?>
            </article>

            <!-- AUTHOR BOX — guest writer credit. Website links are nofollow. -->
            <section class="gp-author-box" aria-label="About the author">
                <span class="gp-author-avatar" aria-hidden="true"><?php echo esc_html($initials); ?></span>
                <div class="gp-author-meta">
                    <p class="gp-author-name"><?php echo esc_html($author_name); ?></p>
                    <?php if ($author_bio !== ''): ?>
                        <p class="gp-author-bio"><?php echo esc_html($author_bio); ?></p>
                    <?php endif; ?>
                    <?php if ($author_url): ?>
                        <a class="gp-author-link" href="<?php echo esc_url($author_url); ?>" target="_blank" rel="nofollow sponsored noopener">Author website</a>
                    <?php endif; ?>
                </div>
            </section>

            <?php
            // Related: newest other posts from the same primary category.
            if ($primary_cat) {
                $related_query = new WP_Query([
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'post__not_in' => [$post_id],
                    'no_found_rows' => true,
                    'category__in' => [$primary_cat->term_id],
                ]);
                if ($related_query->have_posts()): ?>
                    <section class="section related-section">
                        <h2 class="section-title">More in <?php echo esc_html($primary_cat->name); ?></h2>
                        <div class="archive-grid">
                            <?php while ($related_query->have_posts()): $related_query->the_post(); ?>
                                <article class="card guide-archive-card">
                                    <h4><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 24)); ?></p>
                                    <a class="btn btn--secondary" href="<?php echo esc_url(get_permalink()); ?>">Read Article</a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>
                    <?php wp_reset_postdata();
                endif;
            }
            ?>

            <section class="section gp-topics-cta">
                <h2 class="section-title">Explore More Topics</h2>
                <div class="gp-topics-inline">
                    <?php
                    foreach (blogtimer_indexable_category_slugs() as $topic_slug) {
                        $topic_term = get_term_by('slug', $topic_slug, 'category');
                        if ($topic_term && !is_wp_error($topic_term) && (int) $topic_term->count > 0) {
                            printf(
                                '<a class="gp-topic-chip" href="%s">%s</a>',
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

<?php endwhile; ?>

<?php get_footer();
