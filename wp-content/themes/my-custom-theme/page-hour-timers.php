<?php
/**
 * Template Name: Hour Timers Hub
 *
 * Cluster hub for all hour-based timers (1–24 hours). Resolves the up-links
 * from the 10 individual hour-timer pages and from single-timer breadcrumbs,
 * which previously dead-ended at /hour-timers/ with no template.
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();
$hour_unit_url = blogtimer_get_term_url_by_slug('timer_unit', 'hours');
$hour_bucket_terms = blogtimer_get_taxonomy_terms('timer_bucket', blogtimer_get_bucket_slugs_for_unit('hours'));
$usecase_terms = blogtimer_get_taxonomy_terms('timer_usecase', ['productivity', 'studying', 'meditation', 'cooking']);

// All hour timers, ordered by value (1, 2, 3, ... 24).
$hour_timers = $related->get_all_by_unit('hours');
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <?php
        blogtimer_render_breadcrumb_nav([
            ['label' => 'Home', 'url' => home_url('/')],
            ['label' => 'Timers by Duration', 'url' => home_url('/minute-timers')],
            ['label' => 'Hour Timers', 'url' => null],
        ]);
        ?>

        <h1 class="page-h1">
            <?php echo esc_html($loader->get_string('hub.hours.h1') ?: 'Online Hour Timers'); ?>
        </h1>
        <p class="byline">
            By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" rel="author">Suraj Giri</a>
            &middot; Productivity researcher &middot; <em>Last updated: 2026-05-27</em>
        </p>
        <p class="page-intro">
            <?php echo esc_html($loader->get_string('hub.hours.intro') ?: 'Long-duration hour-based countdown timers for sleep cycles, fasting windows, work shifts, study marathons, and deep focus sessions.'); ?>
        </p>
        <div class="tldr-box">
            <strong>TL;DR:</strong> Hour timers cover the long-duration intervals where minutes become unwieldy &mdash; the 8-hour work shift, the 16-hour intermittent-fasting window, the 90-minute-aligned multi-cycle sleep block, and the multi-hour deep-work marathon. The Blog Timer hosts hour timers from 1 hour to 24 hours, grouped into three buckets: short (1&ndash;3), long (4&ndash;12), and extended (13&ndash;24). Each duration maps to an evidence-based use case, anchored to research on ultradian rhythms, circadian sleep cycles, and sustained-attention limits.
        </div>

        <section class="section">
            <h2 class="section-title">Browse Hour Timer Archives</h2>
            <div class="taxonomy-hub-grid">
                <article class="card taxonomy-link-card">
                    <h3><a href="<?php echo esc_url($hour_unit_url); ?>">All Hour Timers</a></h3>
                    <p>View the complete hour unit archive, from a 1-hour focus block through 24-hour day-length countdowns.</p>
                </article>
                <?php foreach ($hour_bucket_terms as $bucket_term): ?>
                    <?php $bucket_url = get_term_link($bucket_term); ?>
                    <?php if (is_wp_error($bucket_url)) {
                        continue;
                    } ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($bucket_url); ?>"><?php echo esc_html($bucket_term->name); ?> hour range</a></h3>
                        <p><?php echo esc_html($bucket_term->description ?: 'Duration grouping for this hour timer range.'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($usecase_terms)): ?>
                <ul class="taxonomy-link-list" style="margin-top:var(--space-5);grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                    <?php foreach ($usecase_terms as $usecase_term): ?>
                        <?php $usecase_url = get_term_link($usecase_term); ?>
                        <?php if (is_wp_error($usecase_url)) {
                            continue;
                        } ?>
                        <li><a href="<?php echo esc_url($usecase_url); ?>">Hour timers for <?php echo esc_html(strtolower($usecase_term->name)); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- All Hour Timers (every hour-timer page as a real link) -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.browse_all') ?: 'Browse All'); ?>
            </h2>
            <p class="section-subtitle">Every hour timer in the library, from 1 hour to 24 hours. Click any duration to start counting down instantly.</p>
            <?php if (!empty($hour_timers)): ?>
                <div class="timer-grid">
                    <?php foreach ($hour_timers as $t):
                        blogtimer_render_timer_card($t); endforeach; ?>
                </div>
            <?php else: ?>
                <p>Hour timers are being added. In the meantime, browse our <a href="<?php echo esc_url(home_url('/minute-timers')); ?>">minute timers</a>.</p>
            <?php endif; ?>
        </section>

        <!-- COMPREHENSIVE GUIDE CONTENT -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">The Complete Guide to Hour Timers</h2>
                <div class="content-page">
                    <p>Hour-based timers handle the durations where the activity itself outlasts a single block of sustained attention. Where a minute timer governs one Pomodoro and a second timer governs one Tabata interval, an hour timer governs the larger container: the full work shift, the overnight sleep window, the slow-cooked roast, the all-day fasting protocol. Choosing the right hour-length matters because human performance, digestion, and sleep all follow rhythms that play out across hours, not minutes.</p>

                    <h3>How long should an hour-scale focus session be?</h3>
                    <p>The honest answer from the research is that you do not work for hours of uninterrupted focus &mdash; you work in cycles inside an hour-scale window. Sleep researcher <a href="https://en.wikipedia.org/wiki/Nathaniel_Kleitman" target="_blank" rel="noopener">Nathaniel Kleitman</a>'s basic rest-activity cycle (BRAC) describes roughly 90-minute waves of alertness. A 2-hour or 3-hour deep-work block, structured as two 90-minute ultradian sprints with a real break between them, respects that rhythm. Setting a single hour-scale countdown gives you a defined container that prevents the open-ended drift of "I'll just keep going," while the breaks inside it keep concentration from collapsing.</p>

                    <h3>How long are common hour-scale activities?</h3>
                    <p>An 8-hour timer maps to the standard work shift and to a full night of sleep &mdash; long enough to complete roughly five 90-minute sleep cycles. A 12-hour timer suits a 12:12 eating window, an overnight slow-cook, or a half-day deadline. A 16-hour timer is the fasting phase of the popular 16:8 intermittent-fasting schedule. The 24-hour timer is the day-length container used for fasting challenges, extended deadlines, and any countdown that must run to the same time tomorrow. Shorter hour timers &mdash; 1, 2, and 3 hours &mdash; cover focused study marathons, long-form writing sessions, and the simmer-and-rest windows of braising and roasting.</p>

                    <h3>Short Hour Timers: 1 to 3 Hours</h3>
                    <p>Hour timers in the 1-to-3-hour range are designed for sustained-but-bounded work. A 1-hour timer is the standard container for a workout, a long-form writing session, or an exam-practice block. Two- and three-hour timers fit a deep-work marathon (built from 90-minute ultradian sprints), a full feature film, a standardized test, or a slow-cooked braise that needs to be checked on a schedule. These are the durations where you are present and attentive but pacing yourself across an extended task.</p>

                    <h3>Long Hour Timers: 4 to 12 Hours</h3>
                    <p>The 4-to-12-hour range covers the structural blocks of a day. A full work shift, an overnight slow-cooker recipe, a long-haul travel leg, and a single night of sleep all live here. An 8-hour timer is the most-used duration in this bucket because it doubles as both the standard workday and the recommended nightly sleep target. These countdowns are typically set and left running in the background, so timer accuracy &mdash; no drift over many hours &mdash; matters more here than anywhere else.</p>

                    <h3>Extended Hour Timers: 13 to 24 Hours</h3>
                    <p>Extended hour timers run for the better part of a day. The 16-hour timer is the fasting window of the 16:8 intermittent-fasting protocol; the 18- and 20-hour timers serve more aggressive fasting schedules; and the 24-hour timer is a full day-length countdown for fasting challenges, project deadlines, and any "same time tomorrow" reminder. At this scale the timer becomes a passive tracking device, and a trustworthy clock-anchored countdown is essential because manual estimation over a full day is hopeless.</p>

                    <h3>Tips for Choosing the Right Hour Duration</h3>
                    <p>Pick the hour-length that matches the natural boundary of the activity, then plan the breaks inside it. For focus work, do not set a single 3-hour timer and expect 3 hours of flow; set it as the container and take a real break every 90 minutes. For fasting, sleep, and cooking, the hour-length is dictated by the protocol or the recipe, so the timer's job is simply to keep accurate time in the background. When the activity spans more than a few hours, prefer a clock-anchored timer (like The Blog Timer) over a phone stopwatch that can be killed by aggressive background-app management.</p>
                </div>
            </div>
        </section>

        <!-- WHY HOURS ARE THE UNIT OF THE DAY -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">Why is the hour the natural unit for day-scale planning?</h2>
                <div class="content-page">
                    <p>The hour is one twenty-fourth of a solar day, a division that traces back to ancient Egyptian and Babylonian timekeeping and was fixed at a constant 60-minute length once mechanical clocks made equal hours practical. Unlike the minute &mdash; which suits a single task &mdash; the hour is the unit at which the body's circadian and ultradian rhythms become visible. Alertness rises and falls on a roughly 90-minute ultradian cycle within the waking day, and the full sleep&ndash;wake cycle repeats every 24 hours under the control of the suprachiasmatic nucleus.</p>

                    <p>This is why hour-based timers cluster around durations that mirror those rhythms. A 90-minute block (1.5 hours) aligns with a single ultradian cycle and a single sleep cycle. An 8-hour block aligns with both the standard work shift and a full night's roughly five sleep cycles. A 16-hour block aligns with the waking portion of a day in the 16:8 fasting schedule, and a 24-hour block closes the full circadian loop. The hour is large enough to contain whole biological cycles, which is exactly why it became the unit of work shifts, sleep recommendations, and fasting protocols.</p>
                </div>
            </div>
        </section>

        <!-- COMMON HOUR DURATIONS -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">What are the most common hour durations and what are they used for?</h2>
                <div class="content-page">
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Duration</th>
                                <th>Primary Use Case</th>
                                <th>Secondary Use Case</th>
                                <th>Research Anchor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1 hour</td>
                                <td>Workout, study block, writing session</td>
                                <td>Meeting, exam practice</td>
                                <td>ACSM single-session guidance</td>
                            </tr>
                            <tr>
                                <td>2 hours</td>
                                <td>Deep-work marathon (two ultradian sprints)</td>
                                <td>Film, standardized test</td>
                                <td>Kleitman BRAC / ultradian rhythm</td>
                            </tr>
                            <tr>
                                <td>3 hours</td>
                                <td>Extended project block, slow braise</td>
                                <td>Long study session</td>
                                <td>Ultradian sprint stacking</td>
                            </tr>
                            <tr>
                                <td>4 hours</td>
                                <td>Half-day deep work, slow roast</td>
                                <td>Travel leg</td>
                                <td>Sustained-attention limits</td>
                            </tr>
                            <tr>
                                <td>8 hours</td>
                                <td>Work shift</td>
                                <td>Full night of sleep (~5 cycles)</td>
                                <td>NSF sleep guidelines</td>
                            </tr>
                            <tr>
                                <td>12 hours</td>
                                <td>12:12 eating window, overnight slow-cook</td>
                                <td>Half-day deadline</td>
                                <td>Circadian eating research</td>
                            </tr>
                            <tr>
                                <td>16 hours</td>
                                <td>16:8 intermittent fasting window</td>
                                <td>Long deadline</td>
                                <td>Time-restricted eating studies</td>
                            </tr>
                            <tr>
                                <td>24 hours</td>
                                <td>Day-length countdown, fasting challenge</td>
                                <td>Project deadline</td>
                                <td>Circadian (24-hour) cycle</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- WHY ACCURACY MATTERS OVER LONG DURATIONS -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">Why does accuracy matter more for long-duration timers?</h2>
                <div class="content-page">
                    <p>Drift compounds with time. A naive timer that loses a few milliseconds per tick is imperceptible over a 5-minute Pomodoro, but over an 8-hour or 16-hour run the same per-tick error can accumulate into minutes of drift &mdash; and background-tab throttling makes it far worse. Mobile operating systems aggressively suspend or kill background tabs and apps to save battery, so a phone stopwatch left running for a fasting window or an overnight sleep block can silently stop counting.</p>

                    <p>The Blog Timer avoids this by anchoring the countdown to an absolute end timestamp and recomputing remaining time as <code>endTime - Date.now()</code> on every tick. Even if a callback fires late, or the tab was throttled, the next correct read snaps the display back to true time. For hour-scale use cases &mdash; fasting, sleep, work shifts, slow cooking &mdash; this clock-anchored approach is the difference between a reliable countdown and one that quietly loses time over the course of a day.</p>
                </div>
            </div>
        </section>

        <!-- How-to -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.how_to_use') ?: 'How to Use'); ?>
            </h2>
            <?php blogtimer_render_howto(); ?>
        </section>

        <!-- FAQ -->
        <section class="section">
            <h2 class="section-title">
                <?php echo esc_html($loader->get_string('ui.faq') ?: 'Frequently Asked Questions'); ?>
            </h2>
            <?php
            $faqs = [];
            $cb_path = ABSPATH . '../datasets/copyblocks.json';
            if (file_exists($cb_path)) {
                $cb = json_decode(file_get_contents($cb_path), true);
                if (!empty($cb['faqs'])) {
                    foreach ($cb['faqs'] as $key => $faq) {
                        if (strpos($key, 'faq_timer_') === 0)
                            $faqs[] = $faq['en'];
                    }
                }
            }
            blogtimer_render_faq(array_slice($faqs, 0, 6));
            ?>
        </section>

        <!-- RELATED CATEGORIES -->
        <?php blogtimer_render_related_categories('hour-timers'); ?>

        <!-- RELATED GUIDES (linked directly via get_permalink, never /guide-cluster/) -->
        <section class="section">
            <h2 class="section-title">Related Guides</h2>
            <div class="usecase-grid">
                <?php
                $guide_slugs = ['deep-work-timers', 'study-timer-methods', 'timer-accuracy', 'background-timers-mobile'];
                foreach ($guide_slugs as $gs) {
                    $g = get_page_by_path($gs, OBJECT, 'guide');
                    if ($g): ?>
                        <a href="<?php echo esc_url(get_permalink($g->ID)); ?>" class="card usecase-card" style="text-decoration:none;">
                            <div class="usecase-card-icon">G</div>
                            <h3><?php echo esc_html($g->post_title); ?></h3>
                            <p><?php echo esc_html(wp_trim_words($g->post_excerpt, 12)); ?></p>
                        </a>
                    <?php endif;
                }
                ?>
            </div>
        </section>

        <!-- CROSS-LINK UP TO OTHER DURATION HUBS -->
        <section class="section">
            <h2 class="section-title">Need a shorter timer?</h2>
            <p class="section-subtitle">Hour timers are for day-scale durations. For shorter intervals, browse our minute and second timer hubs.</p>
            <ul class="taxonomy-link-list" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                <li><a href="<?php echo esc_url(home_url('/minute-timers')); ?>">All Minute Timers (1&ndash;161 minutes)</a></li>
                <li><a href="<?php echo esc_url(home_url('/second-timers')); ?>">All Second Timers (1&ndash;60 seconds)</a></li>
                <li><a href="<?php echo esc_url(home_url('/pomodoro')); ?>">Pomodoro Timer (25-minute focus blocks)</a></li>
            </ul>
        </section>

        <!-- CTA -->
        <div class="cta-banner">
            <h2>Structure Your Next Deep-Work Marathon</h2>
            <p>Set an hour timer as the container, then work in 90-minute ultradian sprints with real breaks between them. Accurate, clock-anchored, and free.</p>
            <a href="<?php echo esc_url(home_url('/minute-timers')); ?>" class="btn btn--primary btn--large">Browse Minute Timers</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
