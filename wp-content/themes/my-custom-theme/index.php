<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <header class="section-header">
            <?php if (is_home()): ?>
                <h1 class="page-h1">Latest Updates</h1>
                <p class="page-intro">Recent posts and updates from The Blog Timer.</p>
            <?php elseif (is_archive()): ?>
                <h1 class="page-h1"><?php the_archive_title(); ?></h1>
                <?php if (get_the_archive_description()): ?>
                    <p class="page-intro"><?php echo wp_kses_post(get_the_archive_description()); ?></p>
                <?php endif; ?>
            <?php else: ?>
                <h1 class="page-h1"><?php echo esc_html(get_bloginfo('name')); ?></h1>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <p><?php esc_html_e('No posts found.', 'my-custom-theme'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
