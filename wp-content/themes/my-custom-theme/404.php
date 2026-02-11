<?php
get_header();
?>

<main class="site-main">
    <div class="container container--narrow">
        <header class="section-header">
            <h1 class="page-h1">Page Not Found</h1>
            <p class="page-intro">The page you requested does not exist. Use one of these links to continue:</p>
        </header>

        <section class="section">
            <div class="content-page">
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">Minute Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/second-timers/')); ?>">Second Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/pomodoro/')); ?>">Pomodoro Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Guides</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
                </ul>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
