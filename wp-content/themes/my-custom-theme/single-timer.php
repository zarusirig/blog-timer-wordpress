<?php
/**
 * Template: Single Timer Page
 *
 * Render order (main content first, link clusters last — see F-01b):
 *   Breadcrumbs → H1 → Intro → Timer Widget → <article>(
 *     About This Duration → Quick Use Ideas → How To Use → FAQ
 *     → "How to Use … Effectively"
 *   )</article> → ad slot → Hub CTA → Nearby Timers → Related Timers
 *   → Related Categories → Learn More → See Also.  Schema is emitted in wp_head.
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$post_id = get_the_ID();
$value = Timer_Engine::get_timer_value($post_id);
$unit = Timer_Engine::get_timer_unit($post_id);
$duration = Timer_Engine::get_duration_seconds($post_id);
$title_key = ($unit === 'hours' && (int) $value === 1) ? 'timer.title.hours_singular' : "timer.title.{$unit}";
$title = $loader->get_string($title_key, ['value' => $value]);
$unit_terms = get_the_terms($post_id, 'timer_unit');
$bucket_terms = get_the_terms($post_id, 'timer_bucket');
$usecase_terms = get_the_terms($post_id, 'timer_usecase');

// Resolve relevant guides early so the in-content use-case bridge and the
// "Learn More" section share one computation.
// Logic: if minute timer -> accuracy guides. if short/pomodoro -> pomodoro guides.
$relevant_guides = [];
$potential_slugs = [];

// Base guides for everyone
$potential_slugs[] = 'timer-accuracy';

// Specifics
if ($unit === 'minutes') {
    // Cooking-duration timers (3-24 min): route equity into the cooking cluster.
    // Kept out of the 25-60 productivity zone so the pomodoro/deep-work flow is untouched.
    if ($value >= 3 && $value <= 24) {
        $cooking_map = array(
            3  => 'how-long-to-poach-an-egg',
            4  => 'how-long-to-boil-eggs', 7  => 'how-long-to-boil-eggs',
            9  => 'how-long-to-boil-eggs', 12 => 'how-long-to-boil-eggs',
            5  => 'how-long-to-steam-broccoli', 6 => 'how-long-to-steam-broccoli',
            8  => 'how-long-to-cook-a-burger',
            10 => 'how-long-to-boil-corn-on-the-cob',
            11 => 'how-long-to-bake-cookies', 13 => 'how-long-to-bake-cookies',
            15 => 'how-long-to-cook-rice', 18 => 'how-long-to-cook-rice',
            20 => 'how-long-to-roast-vegetables', 22 => 'how-long-to-roast-vegetables',
        );
        if (isset($cooking_map[$value])) {
            $potential_slugs[] = $cooking_map[$value];
        }
    }
    if ($value >= 25 && $value <= 60) {
        $potential_slugs[] = 'pomodoro-technique';
        $potential_slugs[] = 'deep-work-timers';
    } elseif ($value > 60) {
        // 61+ minute timers are the highest-impression pages on the site;
        // route their equity into the productivity cluster (deep work first —
        // these durations match deep-work blocks better than pomodoros).
        $potential_slugs[] = 'deep-work-timers';
        $potential_slugs[] = 'pomodoro-technique';
    } elseif ($value < 10) {
        $potential_slugs[] = 'meditation-timers-beginners';
    }
} elseif ($unit === 'seconds') {
    $potential_slugs[] = 'hiit-interval-timers';
    $potential_slugs[] = 'tabata-timer-guide';
} elseif ($unit === 'hours') {
    $potential_slugs[] = 'deep-work-timers';
    $potential_slugs[] = 'pomodoro-technique';
}

// Fetch objects
foreach ($potential_slugs as $slug) {
    $g = get_page_by_path($slug, OBJECT, 'guide');
    if ($g)
        $relevant_guides[] = $g;
    if (count($relevant_guides) >= 3)
        break; // Limit to 3: the accuracy trust node + both productivity guides
}

// F-08: pre-compute the static start value shown in the timer display and a
// human-readable duration label. Both are reused by the widget and the
// <noscript> fallback so the numbers can never drift apart.
if ($unit === 'hours') {
    $start_display = sprintf('%02d:00:00', $value);
} elseif ($unit === 'minutes') {
    $start_display = ($value >= 60)
        ? sprintf('%02d:%02d:00', floor($value / 60), $value % 60)
        : sprintf('%02d:00', $value);
} else {
    $start_display = ($value >= 60)
        ? sprintf('%02d:%02d', floor($value / 60), $value % 60)
        : sprintf('00:%02d', $value);
}
$duration_unit_singular = rtrim($unit, 's'); // hour / minute / second
// Compound-adjective form ("25-minute", "2-hour", "30-second") reads cleanly
// in the <noscript> sentence and is correct for both singular and plural values.
$duration_label = $value . '-' . $duration_unit_singular;
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container container--narrow">

        <!-- BREADCRUMBS -->
        <?php Timer_Engine::render_breadcrumbs($post_id); ?>

        <!-- H1 -->
        <h1 class="page-h1">
            <?php echo esc_html($title); ?>
        </h1>

        <!-- INTRO -->
        <?php
        $intro = $loader->get_intro($post);
        if ($intro):
            ?>
            <p class="page-intro">
                <?php echo esc_html($intro); ?>
            </p>
        <?php endif; ?>

        <!-- TIMER WIDGET -->
        <div class="timer-widget timer-widget--hero" id="page-timer" data-duration="<?php echo esc_attr($duration); ?>"
            data-unit="<?php echo esc_attr($unit); ?>" data-value="<?php echo esc_attr($value); ?>">
            <div class="timer-label">
                <?php echo esc_html($title); ?>
            </div>
            <input type="text" class="timer-name-input" id="timer-name"
                placeholder="<?php echo esc_attr($loader->get_string('ui.timer_name')); ?>">
            <div class="timer-display" id="timer-display">
                <?php echo esc_html($start_display); ?>
            </div>
            <?php /* F-08: defensive fallback for Google's two-wave (no-JS) rendering. */ ?>
            <noscript>
                <p class="timer-noscript">This <?php echo esc_html($duration_label); ?> timer shows <?php echo esc_html($start_display); ?> and counts down when JavaScript is enabled.</p>
            </noscript>
            <div class="timer-progress">
                <div class="timer-progress-bar" id="timer-progress-bar"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large" id="timer-start">
                    <?php echo esc_html($loader->get_string('ui.start')); ?>
                </button>
                <button class="btn btn--secondary btn--large" id="timer-reset">
                    <?php echo esc_html($loader->get_string('ui.reset')); ?>
                </button>
                <button class="btn btn--outline fullscreen-btn" id="timer-fullscreen" aria-label="Enter fullscreen">&#x26F6; Fullscreen</button>
            </div>
            <div class="timer-complete-banner" id="timer-complete-banner">
                <p class="timer-complete-title" role="status" aria-live="polite">
                    <?php echo esc_html($loader->get_string('ui.time_up')); ?>
                </p>
                <button class="btn btn--success" id="timer-replay-sound">&#128266;
                    <?php echo esc_html($loader->get_string('ui.replay_sound')); ?>
                </button>
            </div>
            <div class="kbd-hints">
                <span><kbd>Space</kbd> Start / Pause</span>
                <span><kbd>R</kbd> Reset</span>
                <span><kbd>F</kbd> Fullscreen</span>
            </div>
        </div>

        <?php /* F-04: <article> wraps the main, article-worthy content (About
               through the explanatory "How to Use … Effectively" section). The
               nav/footer/link-cluster blocks intentionally stay OUTSIDE it so
               Google's vision-based segmentation reads one clean main block.
               The single H1 above remains inside <main>, adjacent to <article>. */ ?>
        <article class="single-timer-content">

        <?php btt_hero_image(btt_timer_hero_slug($post_id), get_the_title() . ' — illustration'); ?>


            <!-- ABOUT THIS DURATION -->
            <?php
            // F-content: deterministic, per-duration arithmetic facts. Every
            // sentence below is pure math on $duration — no opinions, sources,
            // studies, or statistics. True for every timer page.
            $duration_facts = $loader->get_duration_facts((int) $value, $unit); // curated JSON anchors (fallback)
            $computed_facts = [];
            $dur = (int) $duration;
            if ($dur > 0) {
                // Hours / minutes / seconds breakdown.
                $bd_h = (int) floor($dur / 3600);
                $bd_rem = $dur % 3600;
                $bd_m = (int) floor($bd_rem / 60);
                $bd_s = $bd_rem % 60;
                $bd_parts = [];
                if ($bd_h > 0) $bd_parts[] = $bd_h . ' ' . ($bd_h === 1 ? 'hour' : 'hours');
                if ($bd_m > 0) $bd_parts[] = $bd_m . ' ' . ($bd_m === 1 ? 'minute' : 'minutes');
                if ($bd_s > 0) $bd_parts[] = $bd_s . ' ' . ($bd_s === 1 ? 'second' : 'seconds');
                $breakdown = !empty($bd_parts) ? implode(' ', $bd_parts) : '0 seconds';

                // F1: total seconds (+ human breakdown once it reaches a minute).
                if ($dur >= 60) {
                    $computed_facts[] = 'This timer runs for exactly ' . number_format($dur) . ' seconds — ' . $breakdown . '.';
                } else {
                    $computed_facts[] = 'This timer runs for exactly ' . number_format($dur) . ' seconds.';
                }

                // F2: total minutes equivalent (>= 1 hour only; sub-hour is
                // already conveyed by the breakdown / share-of-hour facts).
                if ($dur >= 3600 && $dur % 60 === 0) {
                    $total_minutes = $dur / 60;
                    $computed_facts[] = 'That is ' . number_format($total_minutes) . ' ' . ($total_minutes === 1 ? 'minute' : 'minutes') . ' in total.';
                }

                // F3: share of a full hour (sub-hour only — avoids > 100%).
                if ($dur < 3600) {
                    $pct_hour = rtrim(rtrim(number_format(($dur / 3600) * 100, 2), '0'), '.');
                    $computed_facts[] = 'It covers about ' . $pct_hour . '% of a full hour.';
                }

                // F4: relationship to a one-hour anchor.
                if ($dur >= 3600) {
                    if ($dur !== 3600) { // skip "1x" — redundant with the breakdown
                        $ratio = $dur / 3600;
                        $ratio_is_int = ($ratio == (int) $ratio);
                        $ratio_str = $ratio_is_int ? sprintf('%d', (int) $ratio) : rtrim(rtrim(number_format($ratio, 2), '0'), '.');
                        $computed_facts[] = 'It is ' . ($ratio_is_int ? 'exactly' : 'about') . ' ' . $ratio_str . ' times the length of a single hour.';
                    }
                } elseif ($dur >= 300) {
                    // 5–59 minutes: compare to the nearest round-number anchors.
                    foreach ([900 => 'a 15-minute quarter-hour', 1800 => 'a 30-minute half-hour'] as $anchor_sec => $anchor_label) {
                        if ($dur === $anchor_sec) {
                            continue;
                        }
                        $diff = abs($dur - $anchor_sec);
                        $diff_min = (int) floor($diff / 60);
                        $diff_sec = $diff % 60;
                        $diff_parts = [];
                        if ($diff_min > 0) $diff_parts[] = $diff_min . ' ' . ($diff_min === 1 ? 'minute' : 'minutes');
                        if ($diff_sec > 0) $diff_parts[] = $diff_sec . ' ' . ($diff_sec === 1 ? 'second' : 'seconds');
                        $diff_str = !empty($diff_parts) ? implode(' ', $diff_parts) : '0 seconds';
                        $direction = ($dur > $anchor_sec) ? 'longer than' : 'shorter than';
                        $computed_facts[] = 'It runs ' . $diff_str . ' ' . $direction . ' ' . $anchor_label . '.';
                    }
                }

                // F5: how many fit inside one hour (sub-hour only).
                if ($dur < 3600) {
                    $fit_count = (int) floor(3600 / $dur);
                    if ($fit_count >= 1) {
                        $fit_verb = ($fit_count === 1) ? 'fits' : 'fit';
                        $fit_leftover = 3600 - ($fit_count * $dur);
                        if ($fit_leftover === 0) {
                            $computed_facts[] = 'Exactly ' . $fit_count . ' of these timers ' . $fit_verb . ' inside one hour.';
                        } else {
                            $fl_min = (int) floor($fit_leftover / 60);
                            $fl_sec = $fit_leftover % 60;
                            $fl_parts = [];
                            if ($fl_min > 0) $fl_parts[] = $fl_min . ' ' . ($fl_min === 1 ? 'minute' : 'minutes');
                            if ($fl_sec > 0) $fl_parts[] = $fl_sec . ' ' . ($fl_sec === 1 ? 'second' : 'seconds');
                            $fl_str = !empty($fl_parts) ? implode(' ', $fl_parts) : '0 seconds';
                            $computed_facts[] = $fit_count . ' of these timers ' . $fit_verb . ' inside one hour, with ' . $fl_str . ' to spare.';
                        }
                    }
                }

                // F6: Pomodoro 25-minute work blocks (25 min = 1500 sec).
                if ($dur >= 1500) {
                    $work_blocks = (int) floor($dur / 1500);
                    $work_rem = $dur % 1500;
                    $wb_word = ($work_blocks === 1) ? 'complete 25-minute work block' : 'complete 25-minute work blocks';
                    if ($work_rem === 0) {
                        $computed_facts[] = 'The countdown fits ' . $work_blocks . ' ' . $wb_word . ' with no time left over.';
                    } else {
                        $wr_min = (int) floor($work_rem / 60);
                        $wr_sec = $work_rem % 60;
                        $wr_parts = [];
                        if ($wr_min > 0) $wr_parts[] = $wr_min . ' ' . ($wr_min === 1 ? 'minute' : 'minutes');
                        if ($wr_sec > 0) $wr_parts[] = $wr_sec . ' ' . ($wr_sec === 1 ? 'second' : 'seconds');
                        $wr_str = !empty($wr_parts) ? implode(' ', $wr_parts) : '0 seconds';
                        $computed_facts[] = 'It holds ' . $work_blocks . ' ' . $wb_word . ', with ' . $wr_str . ' remaining.';
                    }
                }

                // F7: classic 30-minute Pomodoro cycles (25 work + 5 break).
                if ($dur >= 1800) {
                    $cycles = (int) floor($dur / 1800);
                    $cyc_word = ($cycles === 1) ? 'full Pomodoro cycle' : 'full Pomodoro cycles';
                    $computed_facts[] = 'Measured in classic 30-minute Pomodoro cycles (25 minutes of work plus a 5-minute break), that is ' . $cycles . ' ' . $cyc_word . '.';
                }

                // F8: share of a 24-hour day.
                $pct_day = rtrim(rtrim(number_format(($dur / 86400) * 100, 2), '0'), '.');
                $computed_facts[] = 'It makes up about ' . $pct_day . '% of a full 24-hour day.';

                // F9: share of a standard 8-hour workday.
                if ($dur <= 28800) {
                    $pct_workday = rtrim(rtrim(number_format(($dur / 28800) * 100, 2), '0'), '.');
                    $computed_facts[] = 'It equals about ' . $pct_workday . '% of a standard 8-hour workday.';
                }
            }

            // Prefer the rich computed facts; keep the curated JSON facts as a
            // safety net only when computation yielded nothing (avoids both
            // empty sections and duplicated "runs for X seconds" sentences).
            $about_facts = !empty($computed_facts) ? $computed_facts : $duration_facts;

            if (!empty($about_facts)):
                ?>
                <section class="section about-duration">
                    <h2 class="section-title">About This Duration</h2>
                    <?php foreach ($about_facts as $fact): ?>
                        <p><?php echo esc_html($fact); ?></p>
                    <?php endforeach; ?>
                    <?php
                    // Use-case bridge: in-content contextual links to the matching
                    // use-case hub and the most specific relevant guide.
                    $bridge_term = (!empty($usecase_terms) && !is_wp_error($usecase_terms)) ? $usecase_terms[0] : null;
                    $bridge_term_url = $bridge_term ? get_term_link($bridge_term) : null;
                    if ($bridge_term && is_wp_error($bridge_term_url)) {
                        $bridge_term = null;
                    }
                    $bridge_guide = $relevant_guides[1] ?? $relevant_guides[0] ?? null;
                    $bridge_parts = [];
                    if ($bridge_term) {
                        $bridge_parts[] = sprintf(
                            'This duration is a common pick for <a href="%s">%s timers</a>',
                            esc_url($bridge_term_url),
                            esc_html(strtolower($bridge_term->name))
                        );
                    }
                    if ($bridge_guide) {
                        $guide_link = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url(get_permalink($bridge_guide->ID)),
                            esc_html($bridge_guide->post_title)
                        );
                        $bridge_parts[] = !empty($bridge_parts)
                            ? sprintf('and our %s guide covers how to structure a session of this length', $guide_link)
                            : sprintf('Our %s guide covers how to structure a session of this length', $guide_link);
                    }
                    if (!empty($bridge_parts)):
                        ?>
                        <p class="about-duration-bridge">
                            <?php echo implode(', ', $bridge_parts) . '.'; ?>
                        </p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <!-- QUICK USE IDEAS -->
            <?php
            $ideas = $loader->get_quick_use_ideas($post);
            if (!empty($ideas)):
                ?>
                <section class="section">
                    <h2 class="section-title">
                        <?php echo esc_html($loader->get_string('ui.quick_use_ideas')); ?>
                    </h2>
                    <div class="use-ideas">
                        <?php foreach ($ideas as $idea): ?>
                            <span class="use-idea-tag">✦
                                <?php echo esc_html($idea); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- HOW TO USE -->
            <section class="section">
                <h2 class="section-title">
                    <?php echo esc_html($loader->get_string('ui.how_to_use')); ?>
                </h2>
                <?php blogtimer_render_howto(); ?>
            </section>

            <!-- FAQ -->
            <?php
            $faqs = $loader->get_faqs($post, 4);
            if (!empty($faqs)):
                ?>
                <section class="section">
                    <h2 class="section-title">
                        <?php echo esc_html($loader->get_string('ui.faq')); ?>
                    </h2>
                    <?php blogtimer_render_faq($faqs); ?>
                </section>
            <?php endif; ?>

            <!-- CONTEXTUAL CONTENT -->
            <section class="section">
                <div class="content-page">
                    <?php if ($unit === 'hours'):
                        $hour_label = ((int) $value === 1) ? 'Hour' : 'Hours';
                        ?>
                        <h2>How to Use a <?php echo esc_html($value); ?>-<?php echo esc_html($hour_label === 'Hour' ? 'Hour' : 'Hour'); ?> Timer Effectively</h2>
                        <p>A <?php echo esc_html($value); ?>-<?php echo esc_html(strtolower($hour_label)); ?> timer marks out a long, defined window of time — the kind that's right for sustained work blocks, sleep cycles, fasting windows, slow cooking, and full-day deadlines. Unlike short countdowns that create urgency, hour-long timers create a structured container for activities that need to run without you watching the clock.</p>
                        <?php if ($value <= 3): ?>
                            <p>Timers in the 1-to-3-hour range are ideal for deep work sessions, long study blocks, naps, and slow-cooked recipes. A <?php echo esc_html($value); ?>-<?php echo esc_html(strtolower($hour_label)); ?> countdown gives you enough runway to enter and sustain a flow state — research consistently shows that uninterrupted blocks of 60-to-180 minutes produce the highest-quality cognitive output.</p>
                            <p>This duration also covers most slow-cooking techniques: braising tough cuts of meat, simmering stocks, baking bread, or letting dough rise. Setting a single <?php echo esc_html($value); ?>-<?php echo esc_html(strtolower($hour_label)); ?> timer is more reliable than checking the oven or stove repeatedly.</p>
                        <?php elseif ($value <= 12): ?>
                            <p>Timers in the 4-to-12-hour range cover work shifts, sleep cycles, study marathons, and extended fasting windows. A <?php echo esc_html($value); ?>-hour countdown helps you structure long-duration activities without constantly checking the time — the alert tells you exactly when the window closes.</p>
                            <p>For intermittent fasting, <?php echo esc_html($value); ?> hours is a common eating-window or fasting-window length. For sleep, an 8-hour timer aligns with the recommended adult sleep duration. For deep work, 4-to-6-hour blocks are typical for high-output creative and analytical work when broken up with proper breaks.</p>
                        <?php else: ?>
                            <p>Extended timers from 13 to 24 hours track day-long activities. A <?php echo esc_html($value); ?>-hour countdown is built for full-day fasts, long-duration project deadlines, multi-day prep cycles, and overnight slow-cooking. The Blog Timer's timestamp-based engine keeps accurate time across browser sessions and background tabs, which matters most for long countdowns.</p>
                            <p>A 24-hour timer is also useful for daily reset markers — tracking the time since you last did something, counting down to an appointment, or marking a daily ritual. Use the audio alert as a clear signal that your defined window has closed.</p>
                        <?php endif; ?>
                        <p>The Blog Timer's <?php echo esc_html($value); ?>-<?php echo esc_html(strtolower($hour_label)); ?> countdown uses timestamp-based accuracy, so it stays precise even if your browser tab goes to sleep or your device enters power-saving mode. The audio alert ensures you never miss the end of your session, and the fullscreen mode keeps the display visible from across the room.</p>
                    <?php elseif ($unit === 'minutes'): ?>
                        <h2>How to Use a <?php echo esc_html($value); ?>-Minute Timer Effectively</h2>
                        <p>A <?php echo esc_html($value); ?>-minute timer creates a defined window of time that helps you focus on a single task without distraction. Whether you are working, studying, cooking, or exercising, setting a clear time boundary transforms vague intentions into concrete action. The countdown creates a mild sense of urgency that keeps your mind engaged while the defined endpoint prevents burnout and mental fatigue.</p>
                        <?php if ($value <= 10): ?>
                            <p>Short timers in the 1-to-10-minute range are ideal for micro-tasks, quick breaks, and brief exercises. A <?php echo esc_html($value); ?>-minute countdown works well for clearing a few emails, doing a short meditation, stretching between longer work sessions, or timing a quick recipe step. The brevity makes it easy to commit to — even when motivation is low, almost anyone can focus for <?php echo esc_html($value); ?> minutes.</p>
                            <p>The "<?php echo esc_html($value); ?>-minute rule" is a popular procrastination-beating technique: commit to working on a dreaded task for just <?php echo esc_html($value); ?> minutes. More often than not, the hardest part is starting, and once the timer is running, momentum carries you forward well past the initial countdown.</p>
                        <?php elseif ($value <= 30): ?>
                            <p>Timers in the 11-to-30-minute range hit the sweet spot for focused work sessions. A <?php echo esc_html($value); ?>-minute block provides enough time to make meaningful progress on a task without the mental fatigue that comes with longer unbroken periods. This duration aligns well with the Pomodoro Technique and similar structured productivity methods that alternate focused work with short breaks.</p>
                            <p>For cooking, <?php echo esc_html($value); ?> minutes covers a wide range of preparations — from roasting vegetables to simmering sauces to baking quick items. For exercise, this duration works for circuit training, yoga flows, or moderate cardio sessions. For studying, it provides a concentrated block that improves retention compared to marathon cramming sessions.</p>
                        <?php elseif ($value <= 60): ?>
                            <p>Longer timers between 31 and 60 minutes are designed for deep work — the kind of sustained, uninterrupted focus that produces your best output. A <?php echo esc_html($value); ?>-minute session gives you enough runway to enter a flow state, where concentration deepens and productivity peaks. This is the ideal range for complex writing, programming, analysis, and creative projects.</p>
                            <p>Research suggests that most people can maintain peak concentration for 45 to 60 minutes before needing a break. By setting a <?php echo esc_html($value); ?>-minute timer, you create a structured container that maximizes focus while preventing the open-ended drift that erodes productivity during "I'll just keep going" sessions. When the timer ends, take a genuine 10-to-15-minute break before starting another session.</p>
                        <?php else: ?>
                            <p>Extended timers beyond 60 minutes serve specialized purposes. A <?php echo esc_html($value); ?>-minute session aligns with ultradian rhythms — the natural 90-minute cycles of high and low alertness that researchers have identified in human biology. Working in alignment with these rhythms, rather than against them, can significantly improve both the quality and sustainability of your output.</p>
                            <p>This duration is also common for standardized test preparation, where simulating real exam conditions builds both knowledge and stamina. Athletes use extended timers for long-distance training sessions, and creative professionals use them for deep immersion in complex projects that require sustained concentration.</p>
                        <?php endif; ?>
                        <p>The Blog Timer's <?php echo esc_html($value); ?>-minute countdown uses timestamp-based accuracy, so it stays precise even if your browser tab goes to sleep or your device enters power-saving mode. The audio alert ensures you never miss the end of your session, and the fullscreen mode keeps the display visible from across the room.</p>
                    <?php else: ?>
                        <h2>How to Use a <?php echo esc_html($value); ?>-Second Timer Effectively</h2>
                        <p>A <?php echo esc_html($value); ?>-second timer provides the precision required for activities where every moment counts. Unlike minute-based timers that structure longer sessions, second timers create intense, focused intervals that demand immediate action and full engagement.</p>
                        <?php if ($value <= 10): ?>
                            <p>Ultra-short timers of 1 to 10 seconds are used for reaction time drills, speed challenges, quick photography exposures, and precisely timing brief cooking steps. These durations create maximum urgency — every second feels significant, which naturally increases effort and concentration.</p>
                            <p>In fitness, <?php echo esc_html($value); ?>-second intervals work for explosive movements like box jumps, burpees, or sprint starts. In cooking, this duration covers quick techniques like flambeing, flash-searing, or timing a precise pour. In games and competitions, short countdowns add excitement and pressure.</p>
                        <?php elseif ($value <= 30): ?>
                            <p>The 11-to-30-second range is the most commonly used interval for exercise and fitness. A <?php echo esc_html($value); ?>-second timer is perfect for HIIT work intervals, Tabata rounds, plank holds, wall sits, and bodyweight exercises. This range also covers speed-based cooking techniques and quick mindfulness exercises like focused breathing.</p>
                            <p>For exercise, <?php echo esc_html($value); ?> seconds provides enough time for a challenging but achievable work interval. The brief duration makes it psychologically easier to push through discomfort — you know the end is coming soon, which helps you maintain intensity throughout the entire interval.</p>
                        <?php else: ?>
                            <p>Timers from 31 to 60 seconds bridge the gap between brief bursts and minute-long activities. A <?php echo esc_html($value); ?>-second interval is popular in circuit training, moderate-intensity exercises, and cooking techniques that need precise but not ultra-brief timing.</p>
                            <p>This duration also works well for speech practice, where speakers time individual talking points to stay within presentation limits. For breathing exercises, <?php echo esc_html($value); ?> seconds can structure longer inhale-hold-exhale cycles that promote relaxation and stress reduction.</p>
                        <?php endif; ?>
                        <p>The Blog Timer's second countdowns are built with the same timestamp-based accuracy as our minute timers. The display updates smoothly, the audio alert is clear without being jarring, and keyboard shortcuts let you start, pause, and reset without reaching for the mouse — essential when you are in the middle of a workout or cooking task.</p>
                    <?php endif; ?>
                </div>
            </section>

        </article><!-- /.single-timer-content -->

        <?php blogtimer_render_ad_slot('single_timer_after_content'); ?>

        <?php /* F-01b: link-cluster sections render AFTER the main content and FAQ,
               not interleaved before/around it. The call sites below are unchanged
               in logic — only their position in the template moved. */ ?>

        <!-- HUB CTA -->
        <div class="hub-cta">
            <?php if ($unit === 'minutes'): ?>
                <a href="<?php echo esc_url(home_url('/minute-timers')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_minutes')); ?> →
                </a>
            <?php elseif ($unit === 'hours'): ?>
                <a href="<?php echo esc_url(home_url('/hour-timers')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_hours') ?: 'Browse All Hour Timers'); ?> →
                </a>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/second-timers')); ?>">
                    <?php echo esc_html($loader->get_string('cta.browse_seconds')); ?> →
                </a>
            <?php endif; ?>
        </div>

        <!-- NEARBY TIMERS -->
        <?php
        $nearby_timers = $loader->get_nearby_timers((int) $value, $unit);
        if (!empty($nearby_timers)):
            $nearby_unit_singular = rtrim($unit, 's');
            $nearby_unit_word = ((int) $value === 1) ? $nearby_unit_singular : $unit;
            ?>
            <aside class="section nearby-timers">
                <nav aria-label="Nearby timer durations">
                    <h2 class="section-title">Nearby Timers</h2>
                    <p>
                        Need a slightly shorter or longer countdown than <?php echo esc_html($value . ' ' . $nearby_unit_word); ?>? These are the closest durations with their own timer page:
                    </p>
                    <div class="use-ideas nearby-timers-list">
                        <?php foreach ($nearby_timers as $nt): ?>
                            <a class="use-idea-tag" href="<?php echo esc_url(home_url('/timer/' . $nt['slug'] . '/')); ?>">
                                <?php echo esc_html($nt['value'] . ' ' . $nearby_unit_singular . ' timer'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </nav>
            </aside>
        <?php endif; ?>

        <!-- RELATED TIMERS -->
        <?php
        $related_timers = $related->get_related($post);
        if (!empty($related_timers)):
            ?>
            <section class="related-section section">
                <h2>
                    <?php echo esc_html($loader->get_string('ui.related_timers')); ?>
                </h2>
                <div class="timer-grid">
                    <?php foreach ($related_timers as $rt):
                        blogtimer_render_timer_card($rt);
                    endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- RELATED CATEGORIES -->
        <?php
        $has_tax_links = (!empty($unit_terms) && !is_wp_error($unit_terms)) || (!empty($bucket_terms) && !is_wp_error($bucket_terms)) || (!empty($usecase_terms) && !is_wp_error($usecase_terms));
        if ($has_tax_links):
            ?>
            <section class="section">
                <h2 class="section-title">Related Categories</h2>
                <div class="taxonomy-hub-grid">
                    <?php if (!empty($unit_terms) && !is_wp_error($unit_terms)): ?>
                        <?php foreach ($unit_terms as $term): ?>
                            <?php $term_url = get_term_link($term); ?>
                            <?php if (is_wp_error($term_url)) {
                                continue;
                            } ?>
                            <article class="card taxonomy-link-card">
                                <h3><a href="<?php echo esc_url($term_url); ?>"><?php echo esc_html($term->name); ?> timer archive</a></h3>
                                <p>Explore all countdown pages classified under the <?php echo esc_html(strtolower($term->name)); ?> unit.</p>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($bucket_terms) && !is_wp_error($bucket_terms)): ?>
                        <?php foreach ($bucket_terms as $term): ?>
                            <?php $term_url = get_term_link($term); ?>
                            <?php if (is_wp_error($term_url)) {
                                continue;
                            } ?>
                            <article class="card taxonomy-link-card">
                                <h3><a href="<?php echo esc_url($term_url); ?>"><?php echo esc_html($term->name); ?> range</a></h3>
                                <p>Compare similar duration pages within the <?php echo esc_html(strtolower($term->name)); ?> range.</p>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($usecase_terms) && !is_wp_error($usecase_terms)): ?>
                        <?php foreach ($usecase_terms as $term): ?>
                            <?php $term_url = get_term_link($term); ?>
                            <?php if (is_wp_error($term_url)) {
                                continue;
                            } ?>
                            <article class="card taxonomy-link-card">
                                <h3><a href="<?php echo esc_url($term_url); ?>">Timers for <?php echo esc_html(strtolower($term->name)); ?></a></h3>
                                <p>Browse every duration mapped to <?php echo esc_html(strtolower($term->name)); ?> sessions and workflows.</p>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- LEARN MORE / RELEVANT GUIDES -->
        <?php
        // $relevant_guides is resolved at the top of the template (shared with the
        // in-content use-case bridge in the About This Duration section).
        if (!empty($relevant_guides)):
            ?>
            <section class="section" style="margin-top: 3rem;">
                <h2 class="section-title"><?php echo esc_html__('Learn More', 'timer-engine'); ?></h2>
                <div class="usecase-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                    <?php foreach ($relevant_guides as $rg): ?>
                        <a href="<?php echo esc_url(get_permalink($rg->ID)); ?>" class="card usecase-card"
                            style="text-decoration:none;">
                            <div class="usecase-card-icon">📘</div>
                            <h3><?php echo esc_html($rg->post_title); ?></h3>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- SEE ALSO -->
        <?php blogtimer_render_see_also('timer'); ?>

    </div>
</main>

<!-- Fullscreen Overlay -->
<div class="timer-fullscreen-overlay" id="timer-fullscreen-overlay">
    <button class="fullscreen-close" id="fullscreen-close" aria-label="Exit fullscreen">&times;</button>
    <div class="fullscreen-display" id="fullscreen-display">00:00</div>
    <div class="fullscreen-label"><?php echo esc_html($title); ?></div>
</div>

<?php get_footer(); ?>
