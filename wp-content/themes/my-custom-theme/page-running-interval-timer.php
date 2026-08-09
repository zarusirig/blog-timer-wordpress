<?php
/**
 * Template Name: Running Interval Timer Page
 * Description: Track intervals, fartlek, Yasso 800s, tempo runs
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Running Interval Timer &mdash; Track Workouts and Tempo Runs</h1>
        <p class="page-intro">Time your 400s, 800s, mile splits, fartlek surges, Yasso 800s, and tempo runs. Default to the 800-meter interval that anchors most marathon and 5K training plans.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~14 min read &middot; Built on Jack Daniels' Running Formula and Hal Higdon's intermediate marathon plans</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Track interval sessions usually combine 400s (~75&ndash;90 sec at VO2max pace), 800s (Yasso 800s for marathoners), and mile repeats at threshold pace. Standard rest is equal to or half the work-interval duration. Jack Daniels' VDOT system prescribes interval pace at roughly current 5K pace; Yasso 800s use marathon-goal pace in hours/minutes as the 800m time in minutes/seconds. Tempo runs sit at lactate threshold pace, sustained 20&ndash;40 minutes.</p>
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="180"
             data-unit="minutes"
             data-value="3"
             data-mode="standard">
            <div class="timer-display">3:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Interval</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Interval Complete</h3>
                <p>Jog the recovery, then restart for the next rep.</p>
                <button class="btn btn--success start-timer">Start Next Rep</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Running Interval Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-90-seconds" class="btn btn--secondary">
                    <strong>400m Rep</strong>
                    <span>~90 seconds</span>
                </a>
                <a href="/timer/set-timer-for-3-minutes" class="btn btn--secondary">
                    <strong>800m / Yasso</strong>
                    <span>3 minutes</span>
                </a>
                <a href="/timer/set-timer-for-6-minutes" class="btn btn--secondary">
                    <strong>Mile Repeat</strong>
                    <span>6 minutes</span>
                </a>
                <a href="/timer/set-timer-for-20-minutes" class="btn btn--secondary">
                    <strong>Tempo Run</strong>
                    <span>20 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Five Workouts Every Distance Runner Uses</h2>
            <p>Coaches from Arthur Lydiard to Jack Daniels to Hal Higdon converge on the same five workout types, varying only the volume, pacing prescription, and weekly placement. Each one has a distinct timer requirement.</p>

            <h2 class="section-title">Common Running Interval Workouts</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Workout</th>
                        <th>Typical structure</th>
                        <th>Target pace</th>
                        <th>Recovery</th>
                        <th>Primary adaptation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>400m repeats</strong></td><td>8&ndash;16 &times; 400m</td><td>VO2max pace (~5K)</td><td>200m jog or equal time</td><td>VO2max, running economy</td></tr>
                    <tr><td><strong>800m repeats</strong></td><td>5&ndash;10 &times; 800m</td><td>VO2max pace</td><td>400m jog or 2&ndash;3 min</td><td>VO2max + threshold</td></tr>
                    <tr><td><strong>Yasso 800s</strong></td><td>10 &times; 800m</td><td>Marathon goal time (min:sec = hours)</td><td>equal time</td><td>Marathon-pace stamina</td></tr>
                    <tr><td><strong>Mile repeats</strong></td><td>3&ndash;6 &times; 1 mile</td><td>5K to 10K pace</td><td>2&ndash;4 min jog</td><td>Threshold, lactate clearance</td></tr>
                    <tr><td><strong>Tempo run</strong></td><td>20&ndash;40 min continuous</td><td>Lactate threshold pace</td><td>n/a</td><td>Lactate threshold</td></tr>
                    <tr><td><strong>Fartlek</strong></td><td>30 min mixed surges</td><td>Variable: easy to 5K</td><td>Easy jog between surges</td><td>Pace versatility</td></tr>
                    <tr><td><strong>Strides</strong></td><td>6&ndash;10 &times; 20s</td><td>Mile to 5K pace</td><td>Full recovery (60&ndash;90s)</td><td>Neuromuscular activation</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Yasso 800s &mdash; The Marathon Prediction Workout</h2>
            <p>Bart Yasso, longtime <em>Runner's World</em> chief running officer, popularized the workout that bears his name: ten 800-meter repeats at a pace where the time in minutes and seconds equals your marathon goal time in hours and minutes. Goal a 3-hour marathon? Your 800s should be at 3:00 each, with equal-time recovery jogs (3 minutes).</p>

            <p>Yasso's claim is not that the workout guarantees the marathon time &mdash; it is that being able to complete the full ten 800s on target, comfortably, with equal-time recovery, is a strong indicator that the goal time is realistic. Most marathon training plans drop in two to three Yasso 800 sessions in the final 6&ndash;8 weeks of preparation, separated by easy weeks.</p>

            <h2 class="section-title">Jack Daniels' VDOT System</h2>
            <p>Jack Daniels, in <em>Daniels' Running Formula</em>, defines five training intensities mapped to recent race performance (the VDOT value). Each intensity uses a specific work-to-rest structure when run as intervals.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Daniels intensity</th>
                        <th>Approximate pace</th>
                        <th>Typical interval</th>
                        <th>Recovery</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Easy (E)</td><td>~75&ndash;80% HRmax</td><td>30&ndash;60 min continuous</td><td>n/a</td></tr>
                    <tr><td>Threshold (T)</td><td>~88&ndash;92% HRmax (15K race pace)</td><td>20 min continuous or 4 &times; 5 min</td><td>1 min jog between</td></tr>
                    <tr><td>Interval (I)</td><td>VO2max pace (~3K to 5K)</td><td>3&ndash;5 min repeats</td><td>Equal time or slightly less</td></tr>
                    <tr><td>Repetition (R)</td><td>Mile pace</td><td>200&ndash;400m repeats</td><td>Full recovery (2&ndash;4 min)</td></tr>
                </tbody>
            </table>

            <p>For your specific pace targets, look up your current VDOT from a recent race time using Daniels' VDOT table. The system is widely reproduced in his book and online &mdash; the underlying premise is that all paces should be percentage-derived from recent fitness, not arbitrary speeds.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Hal Higdon's Approach to Interval Volume</h2>
            <p>Hal Higdon's intermediate and advanced marathon plans are the most-used training plans in American distance running. Higdon prescribes a single quality session per week for novice and intermediate plans, building to two quality sessions for advanced trainees. Quality work in Higdon's plans alternates Yasso 800s, mile repeats at 5K pace, and tempo runs of 3 to 6 miles.</p>

            <p>The Higdon principle most relevant to the running timer: never run intervals so hard you cannot maintain the prescribed pace across all reps. If rep 8 is 15 seconds slower than rep 1, the starting pace was too aggressive. Aim for a 3- to 5-second drop from first to last rep, not more.</p>

            <h2 class="section-title">Sample Running Interval Sessions</h2>

            <h3>5K-focused: 12 &times; 400m at 5K pace</h3>
            <p>Warm up 10&ndash;15 minutes easy. Twelve 400-meter repeats at current 5K race pace, 200-meter jog recovery between each (roughly 90 seconds). Cool down 10 minutes. Total session: ~45&ndash;55 minutes.</p>

            <h3>Marathon-focused: Yasso 800s</h3>
            <p>Warm up 15&ndash;20 minutes easy. Ten 800-meter repeats with time matching your marathon goal in hours/minutes (e.g., 3:30 marathoner runs 3:30 800s), 800-meter walk-jog recovery between each. Cool down 10 minutes. Total session: ~70&ndash;85 minutes.</p>

            <h3>Threshold tempo (lactate threshold)</h3>
            <p>Warm up 10 minutes easy. Twenty minutes continuous at "comfortably hard" pace &mdash; roughly 15-kilometer race pace, where breathing is steady but conversation is difficult. Cool down 10 minutes. Total: ~40 minutes.</p>

            <h3>Fartlek (Swedish "speed play")</h3>
            <p>Thirty minutes continuous running with periodic surges between landmarks (run hard to the next telephone pole, easy to the next, hard to the third). No clock, no track &mdash; just self-paced surges of 20 seconds to 2 minutes scattered through the run.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How To Pace Track Workouts</h2>

            <h3>Even splits, not negative</h3>
            <p>For first interval sessions, aim for even splits across all reps. Negative splits (running rep 8 faster than rep 1) feel impressive but typically indicate the early reps were too conservative. Even splits is the harder, more honest workout.</p>

            <h3>Pacing on the first 200m of every rep</h3>
            <p>The first 200 meters of every interval is where the rep is won or lost. If you go out too fast, you cannot hold pace. If you go out too slow, you over-correct in the second 200 and arrive at the finish too fatigued for the next rep. Practice even pacing within reps by clocking the 200-meter split halfway through.</p>

            <h3>Recovery jog, not walk</h3>
            <p>Active recovery clears blood lactate roughly twice as fast as passive rest (Spierer et al., <a href="https://pubmed.ncbi.nlm.nih.gov/14767405/" rel="nofollow noopener" target="_blank">PMID 14767405</a>). For 400m and 800m repeats, jog the recovery at roughly 50&ndash;60% HRmax rather than walking.</p>

            <h3>Track conditions and adjustments</h3>
            <p>Wind, heat, and humidity all slow track times measurably. A 5&deg;C (10&deg;F) increase from optimal conditions adds approximately 2&ndash;3% to 5K race times, per studies in the <em>Journal of Sports Sciences</em>. Adjust pace by feel and heart rate, not by clock-target, in hot conditions.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Running Interval Mistakes</h2>

            <h3>Too many quality sessions per week</h3>
            <p>For most recreational distance runners, two hard workouts per week (one interval, one tempo or long run) is the upper limit before injury rates climb. Three quality sessions per week works for advanced trainees with several years of consistent base mileage.</p>

            <h3>Skipping warm-up</h3>
            <p>VO2max-pace intervals on cold legs sharply elevate calf, hamstring, and Achilles strain risk. Spend 10&ndash;15 minutes on easy jogging plus dynamic mobility before the first hard rep. Pair this page with our <a href="/sprint-timer">sprint timer</a> for true short-sprint work.</p>

            <h3>Running every rep at "as hard as I can"</h3>
            <p>The whole architecture of interval training depends on holding a defined pace across many repetitions. "All-out" pacing is a sprint workout, not an interval workout. Use the prescribed pace (VDOT, marathon-goal, 5K pace) and hit the same time every rep.</p>

            <h3>Ignoring rest weeks</h3>
            <p>Three weeks of building volume should be followed by one week of cut-back mileage and reduced quality work. Higdon, Daniels, and Lydiard all program down weeks every fourth week to allow CNS recovery and prevent overtraining.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Running Interval Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'How fast should I run 400m repeats?', 'a' => 'For most distance runners, 400m repeats are run at current 5K race pace (Jack Daniels\' Interval pace). Use a recent 5K time or 5K predictor to set the target. A typical session is 8 to 12 &times; 400m with 200m jog recovery between each.'],
                ['q' => 'What are Yasso 800s?', 'a' => 'Bart Yasso\'s marathon prediction workout: ten 800-meter repeats at a pace where minutes:seconds matches your marathon goal in hours:minutes. Goal a 3:30 marathon? Run 800s at 3:30 each, with equal-time recovery jogs. Completing the full ten on target is a strong indicator the marathon goal is realistic.'],
                ['q' => 'How long should a tempo run be?', 'a' => 'Tempo runs are typically 20 to 40 minutes of continuous running at lactate threshold pace (roughly 15K race pace or "comfortably hard"). Beginners start at 20 minutes; experienced runners build to 30 to 40 minutes. Add 5 to 10 minutes of easy running on each side as warm-up and cool-down.'],
                ['q' => 'What is the difference between intervals and tempo?', 'a' => 'Intervals are short, hard efforts (1 to 6 minutes) with recovery between reps, targeting VO2max. Tempo runs are continuous sustained efforts (20 to 40 minutes) at lactate threshold pace, targeting threshold clearance. Both build aerobic fitness via different mechanisms.'],
                ['q' => 'How many days per week should I do interval workouts?', 'a' => 'One to two quality sessions per week is the standard for recreational runners. Three quality sessions per week is sustainable only for advanced trainees with several years of consistent base mileage. Two quality sessions plus one long run is the most common weekly structure.'],
                ['q' => 'Are mile repeats good for marathon training?', 'a' => 'Yes. Mile repeats at 5K to 10K pace train the upper aerobic and threshold systems, both of which improve marathon performance. Most marathon plans include mile repeats in the early build phase, then transition to longer threshold work and Yasso 800s closer to race day.'],
                ['q' => 'What is a fartlek run?', 'a' => 'Fartlek is Swedish for "speed play." It is unstructured interval training where surges of varying length and intensity (20 seconds to 2 minutes) are mixed into a continuous run, with easy running between surges. Fartlek builds pace versatility and is less mentally taxing than track intervals.'],
            ]);
            ?>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ExerciseAction",
  "name": "Running Interval Workout",
  "description": "Track-based running intervals including 400m repeats, 800m repeats, Yasso 800s, mile repeats, and tempo runs.",
  "exerciseType": "Running",
  "duration": "PT3M",
  "url": "https://theblogtimer.com/running-interval-timer/"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Running Interval Timer - Track Workouts and Tempo Runs",
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"},
  "mainEntityOfPage": "https://theblogtimer.com/running-interval-timer/"
}
</script>

<?php get_footer(); ?>
