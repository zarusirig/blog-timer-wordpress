<?php
get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container container--narrow">
        <header class="section-header">
            <h1 class="page-h1">Page Not Found (404)</h1>
            <p class="page-intro">The page you're looking for doesn't exist or may have moved. Try a search, or jump straight to a popular timer.</p>
        </header>

        <section class="section">
            <div class="content-page" style="margin-bottom: var(--space-8);">
                <?php get_search_form(); ?>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Popular Timers</h2>
            <div class="timer-grid">
                <?php
                $popular_404 = [
                    ['pomodoro',           'Pomodoro',      '25 min focus'],
                    ['stopwatch',          'Stopwatch',     'Count up'],
                    ['countdown-timer',    'Countdown',     'Set a time'],
                    ['egg-timer',          'Egg Timer',     'Cooking'],
                    ['hiit-timer',         'HIIT Timer',    'Workout'],
                    ['minute-timers',      'Minute Timers', '1–161 min'],
                    ['online-alarm-clock', 'Alarm Clock',   'Wake-up'],
                    ['world-clock',        'World Clock',   'Time zones'],
                ];
                foreach ($popular_404 as $card) :
                    $url = home_url('/' . $card[0] . '/');
                    ?>
                    <a class="timer-card" href="<?php echo esc_url($url); ?>">
                        <span class="timer-card-value"><?php echo esc_html($card[1]); ?></span>
                        <span class="timer-card-label"><?php echo esc_html($card[2]); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section">
            <p><a class="btn btn--primary" href="<?php echo esc_url(home_url('/')); ?>">Back to Home</a></p>
        </section>
    </div>
</main>

<?php get_footer(); ?>
