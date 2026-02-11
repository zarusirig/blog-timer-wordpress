<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header">
        <div class="container header-inner">
            <a href="<?php echo esc_url(home_url('')); ?>" class="site-brand">
                <span class="brand-icon">&#9201;</span>
                <span><?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?></span>
            </a>

            <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle navigation" aria-expanded="false">
                <span>&#9776;</span>
            </button>

            <nav>
                <ul class="primary-nav" id="primary-nav">
                    <li><a href="<?php echo esc_url(home_url('')); ?>" <?php echo is_front_page() ? 'class="active"' : ''; ?>>Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers/')); ?>" <?php echo (is_page('minute-timers') || is_tax('timer_unit', 'minutes') || is_tax('timer_bucket', ['short', 'medium', 'long', 'extended'])) ? 'class="active"' : ''; ?>>Minute Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/second-timers/')); ?>" <?php echo (is_page('second-timers') || is_tax('timer_unit', 'seconds') || is_tax('timer_bucket', ['seconds_short', 'seconds_medium', 'seconds_long'])) ? 'class="active"' : ''; ?>>Second Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/pomodoro/')); ?>" <?php echo is_page('pomodoro') ? 'class="active"' : ''; ?>>Pomodoro</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/')); ?>" <?php echo (is_page('use-cases') || is_tax('timer_usecase')) ? 'class="active"' : ''; ?>>Use Cases</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guides/')); ?>" <?php echo (is_post_type_archive('guide') || is_singular('guide') || is_tax('guide_cluster')) ? 'class="active"' : ''; ?>>Guides</a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>" <?php echo is_page('faq') ? 'class="active"' : ''; ?>>FAQ</a></li>
                </ul>
            </nav>
        </div>
    </header>
