<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <?php // Favicons — raster-first so Google's SERP favicon fetcher (which does not
          // reliably render SVG) gets a PNG/ICO. SVG kept last as progressive enhancement. ?>
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon-192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon-16.png">
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="<?php echo esc_url(home_url('/favicon.ico')); ?>">
    <meta name="theme-color" content="#4f46e5">
    <?php wp_head(); ?>
    <style id="megamenu-css">
        /* ===========================================================
           Semantic mega-menu — crawl-discovery navigation.
           Owned by header.php (does not touch shared style.css).
           Enhances the theme's existing .nav-item--has-submenu /
           .nav-submenu base styles with multi-column silo panels,
           section labels, and keyword-rich spoke links.
           Real <a href> links are server-rendered in the DOM so
           Googlebot discovers every silo without JS/hover.
           =========================================================== */

        /* Wide multi-column dropdown panel (desktop) */
        .primary-nav .nav-submenu.mega-panel {
            width: max-content;
            min-width: 520px;
            max-width: 92vw;
            padding: 18px;
            display: none;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 6px 22px;
        }

        /* Single-column silos stay narrow */
        .primary-nav .nav-submenu.mega-panel--single {
            min-width: 300px;
            grid-template-columns: 1fr;
        }

        /* Reveal on hover + keyboard focus (crawlable + accessible) */
        .primary-nav .nav-item--has-submenu:hover > .nav-submenu.mega-panel,
        .primary-nav .nav-item--has-submenu:focus-within > .nav-submenu.mega-panel {
            display: grid;
        }

        /* Invisible hover bridge: the base .nav-submenu sits at top:calc(100% + 8px),
           leaving an 8px dead zone between the nav item and the panel. Without this,
           moving the cursor across that gap (especially fast/diagonally) drops :hover
           and the panel disappears. This transparent strip fills the gap so the
           hover chain to the parent <li> stays unbroken. It only renders while the
           panel is open (the panel is display:none when closed). */
        .primary-nav .nav-item--has-submenu > .nav-submenu::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 0;
            right: 0;
            height: 12px;
            background: transparent;
        }

        /* Keep the right edge inside the viewport for later dropdowns */
        .primary-nav > li.nav-align-right > .nav-submenu.mega-panel {
            left: auto;
            right: 0;
        }

        /* Section label inside a silo panel */
        .mega-panel .mega-section-label {
            grid-column: 1 / -1;
            margin: 4px 8px 2px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-text-muted, #5f6889);
        }

        /* Hub / lead link emphasis */
        .mega-panel a.mega-hub-link {
            font-weight: 600;
            color: var(--color-text-primary, #eef0f6);
        }

        .mega-panel a.mega-hub-link:hover {
            color: var(--color-accent, #4f46e5);
        }

        /* Tighten link rows inside the mega panel */
        .mega-panel a {
            line-height: 1.25;
        }

        /* ---- Mobile: silo accordion (caret-toggled), default-collapsed ---- */
        @media (max-width: 1320px) {
            .primary-nav .nav-submenu.mega-panel {
                display: none;
                grid-template-columns: 1fr;
                min-width: 0;
                width: auto;
                max-width: none;
                padding: 4px 0 8px;
            }

            /* No hover bridge on mobile — it's a tap accordion, not a hover menu. */
            .primary-nav .nav-item--has-submenu > .nav-submenu::before {
                display: none;
            }

            /* Expanded only when the caret toggles .submenu-open on the parent <li>. */
            .primary-nav .nav-item--has-submenu.submenu-open > .nav-submenu.mega-panel {
                display: block;
            }

            .primary-nav > li.nav-align-right > .nav-submenu.mega-panel {
                right: auto;
                left: 0;
            }

            .mega-panel .mega-section-label {
                padding: 6px 24px 0;
                margin: 0;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a href="<?php echo esc_url(home_url('')); ?>" class="site-brand">
                <span class="brand-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2"/><path d="M9 2h6"/><path d="M12 5V2"/></svg></span>
                <span><?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?></span>
            </a>

            <button class="mobile-toggle" id="mobile-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="primary-nav">
                <svg class="icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg class="icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>

            <nav aria-label="Primary">
                <ul class="primary-nav" id="primary-nav">

                    <li><a href="<?php echo esc_url(home_url('')); ?>" <?php echo is_front_page() ? 'class="active"' : ''; ?>>Home</a></li>

                    <!-- Silo 1: Focus &amp; Productivity (Quality Nodes — productivity FIRST) -->
                    <li class="nav-item--has-submenu">
                        <a href="<?php echo esc_url(home_url('/pomodoro')); ?>" <?php echo (is_page(['pomodoro', 'focus-timer', 'study-timer', 'study-work-timers', 'interval-timer'])) ? 'class="active"' : ''; ?>>Focus &amp; Productivity</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel">
                            <li class="mega-section-label">Focus &amp; Study Timers</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/pomodoro')); ?>">Pomodoro Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/focus-timer')); ?>">Deep Work &amp; Focus Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/study-timer')); ?>">Study Timer for Students</a></li>
                            <li><a href="<?php echo esc_url(home_url('/study-work-timers')); ?>">Study &amp; Work Timers</a></li>
                            <li><a href="<?php echo esc_url(home_url('/interval-timer')); ?>">Interval &amp; Time-Blocking Timer</a></li>
                            <li class="mega-section-label">Evidence-Based Guides</li>
                            <li><a href="<?php echo esc_url(home_url('/guides/how-long-is-a-pomodoro')); ?>">How Long Is a Pomodoro?</a></li>
                            <li><a href="<?php echo esc_url(home_url('/guides/deep-work-timers')); ?>">Best Deep Work Timers</a></li>
                        </ul>
                    </li>

                    <!-- Silo 2: Timers by Duration -->
                    <li class="nav-item--has-submenu">
                        <a href="<?php echo esc_url(home_url('/minute-timers')); ?>" <?php echo (is_page(['minute-timers', 'second-timers', 'hour-timers', 'use-cases']) || is_tax('timer_unit') || is_tax('timer_bucket') || is_tax('timer_usecase')) ? 'class="active"' : ''; ?>>Timers by Duration</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel mega-panel--single">
                            <li class="mega-section-label">Set a Timer by Length</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/minute-timers')); ?>">Minute Timers (1&ndash;161 min)</a></li>
                            <li><a href="<?php echo esc_url(home_url('/second-timers')); ?>">Second Timers (1&ndash;60 sec)</a></li>
                            <li><a href="<?php echo esc_url(home_url('/hour-timers')); ?>">Hour Timers (1&ndash;12 hr)</a></li>
                            <li><a href="<?php echo esc_url(home_url('/use-cases')); ?>">Browse Timers by Use Case</a></li>
                        </ul>
                    </li>

                    <!-- Silo 3: Cooking Timers -->
                    <li class="nav-item--has-submenu">
                        <a href="<?php echo esc_url(home_url('/cooking-timers')); ?>" <?php echo (is_page(['cooking-timers', 'egg-timer', 'pasta-timer', 'tea-timer', 'coffee-timer', 'steak-timer', 'rice-timer', 'turkey-timer'])) ? 'class="active"' : ''; ?>>Cooking Timers</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel">
                            <li class="mega-section-label">Kitchen &amp; Cooking Timers</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/cooking-timers')); ?>">All Cooking Timers</a></li>
                            <li><a href="<?php echo esc_url(home_url('/egg-timer')); ?>">Egg Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/pasta-timer')); ?>">Pasta Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/tea-timer')); ?>">Tea Steeping Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/coffee-timer')); ?>">Coffee Brew Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/steak-timer')); ?>">Steak Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/rice-timer')); ?>">Rice Cooking Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/turkey-timer')); ?>">Turkey Roasting Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/bread-baking-timer')); ?>">Bread Baking Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/microwave-popcorn-timer')); ?>">Microwave Popcorn Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/sous-vide-timer')); ?>">Sous Vide Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/bbq-timer')); ?>">BBQ &amp; Grill Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/baby-bottle-timer')); ?>">Baby Bottle Timer</a></li>
                        </ul>
                    </li>

                    <!-- Silo 4: Workout &amp; Interval Timers -->
                    <li class="nav-item--has-submenu nav-align-right">
                        <a href="<?php echo esc_url(home_url('/workout-timers')); ?>" <?php echo (is_page(['workout-timers', 'hiit-timer', 'tabata-timer', 'boxing-round-timer', 'emom-timer', 'crossfit-amrap-timer', 'plank-timer', 'yoga-timer'])) ? 'class="active"' : ''; ?>>Workout &amp; Interval Timers</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel">
                            <li class="mega-section-label">HIIT, Tabata &amp; Interval Timers</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/workout-timers')); ?>">All Workout Timers</a></li>
                            <li><a href="<?php echo esc_url(home_url('/hiit-timer')); ?>">HIIT Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/tabata-timer')); ?>">Tabata Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/boxing-round-timer')); ?>">Boxing Round Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/emom-timer')); ?>">EMOM Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/crossfit-amrap-timer')); ?>">CrossFit AMRAP Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/plank-timer')); ?>">Plank Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/yoga-timer')); ?>">Yoga Session Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/jump-rope-timer')); ?>">Jump Rope Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/running-interval-timer')); ?>">Running Interval Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/stretching-timer')); ?>">Stretching Timer</a></li>
                        </ul>
                    </li>

                    <!-- Silo 5: Sleep &amp; Meditation -->
                    <li class="nav-item--has-submenu nav-align-right">
                        <a href="<?php echo esc_url(home_url('/sleep-meditation-timers')); ?>" <?php echo (is_page(['sleep-meditation-timers', 'nap-timer', 'sleep-timer'])) ? 'class="active"' : ''; ?>>Sleep &amp; Meditation</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel mega-panel--single">
                            <li class="mega-section-label">Sleep &amp; Meditation Timers</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/sleep-meditation-timers')); ?>">Sleep &amp; Meditation Timers</a></li>
                            <li><a href="<?php echo esc_url(home_url('/nap-timer')); ?>">Power Nap Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/sleep-timer')); ?>">Sleep Timer</a></li>
                        </ul>
                    </li>

                    <!-- Silo 6: Clocks &amp; Tools -->
                    <li class="nav-item--has-submenu nav-align-right">
                        <a href="<?php echo esc_url(home_url('/stopwatch-clock-tools')); ?>" <?php echo (is_page(['stopwatch-clock-tools', 'stopwatch', 'online-alarm-clock', 'countdown-timer', 'world-clock'])) ? 'class="active"' : ''; ?>>Clocks &amp; Tools</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel mega-panel--single">
                            <li class="mega-section-label">Stopwatch &amp; Clock Tools</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/stopwatch-clock-tools')); ?>">Stopwatch &amp; Clock Tools</a></li>
                            <li><a href="<?php echo esc_url(home_url('/stopwatch')); ?>">Online Stopwatch</a></li>
                            <li><a href="<?php echo esc_url(home_url('/online-alarm-clock')); ?>">Online Alarm Clock</a></li>
                            <li><a href="<?php echo esc_url(home_url('/countdown-timer')); ?>">Countdown Timer</a></li>
                            <li><a href="<?php echo esc_url(home_url('/world-clock')); ?>">World Clock</a></li>
                        </ul>
                    </li>

                    <!-- Silo 7: Guides (evidence-based / methodology trust node) -->
                    <li class="nav-item--has-submenu nav-align-right">
                        <a href="<?php echo esc_url(home_url('/guides')); ?>" <?php echo (is_post_type_archive('guide') || is_singular('guide') || is_page(['methodology', 'sources', 'site-index'])) ? 'class="active"' : ''; ?>>Guides</a>
                        <button class="nav-submenu-toggle" type="button" aria-expanded="false" aria-label="Toggle submenu"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2 4 L6 8 L10 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <ul class="nav-submenu mega-panel mega-panel--single">
                            <li class="mega-section-label">Evidence-Based Timing Guides</li>
                            <li><a class="mega-hub-link" href="<?php echo esc_url(home_url('/guides')); ?>">All Timer Guides</a></li>
                            <li><a href="<?php echo esc_url(home_url('/methodology')); ?>">Timer Accuracy &amp; Methodology</a></li>
                            <li><a href="<?php echo esc_url(home_url('/sources')); ?>">Research Sources</a></li>
                            <li><a href="<?php echo esc_url(home_url('/site-index')); ?>">Full Site Index</a></li>
                        </ul>
                    </li>

                    <!-- Silo 8: Blog (guest articles) -->
                    <li><a href="<?php echo esc_url(home_url('/blog')); ?>" <?php echo (is_page('blog') || is_singular('post') || is_category()) ? 'class="active"' : ''; ?>>Blog</a></li>

                    <li><a href="<?php echo esc_url(home_url('/faq')); ?>" <?php echo is_page('faq') ? 'class="active"' : ''; ?>>FAQ</a></li>

                </ul>
            </nav>
        </div>
    </header>
