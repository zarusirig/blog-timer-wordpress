<?php
/**
 * Template Name: EMOM Timer Page
 * Description: Every Minute on the Minute training timer
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free EMOM Timer &mdash; Every Minute on the Minute Training</h1>
        <p class="page-intro">A dedicated EMOM (Every Minute on the Minute) timer. A bell sounds at the top of every minute, signaling a new round of prescribed reps. Default 10-minute EMOM &mdash; the standard programming length.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~13 min read &middot; Built on CrossFit Inc. methodology and Pavel Tsatsouline's "ladder" programming</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">EMOM means "Every Minute on the Minute." At the top of each minute, complete a prescribed number of reps; whatever time remains is your rest before the next minute starts. Common formats run 5, 10, 12, 15, or 20 minutes. EMOM works best when the prescribed reps take 30 to 45 seconds, leaving 15 to 30 seconds rest. Use EMOM for strength (heavy singles), conditioning (burpees), or skill work (Turkish get-ups).</p>
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="600"
             data-unit="minutes"
             data-value="10"
             data-mode="standard">
            <div class="timer-display">10:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start EMOM</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>EMOM Complete</h3>
                <p>Log the rounds you completed cleanly. Recover before any cool-down.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">EMOM Length Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary">
                    <strong>Sprint EMOM</strong>
                    <span>5 minutes</span>
                </a>
                <a href="/timer/set-timer-for-10-minutes" class="btn btn--secondary">
                    <strong>Standard EMOM</strong>
                    <span>10 minutes</span>
                </a>
                <a href="/timer/set-timer-for-15-minutes" class="btn btn--secondary">
                    <strong>Long EMOM</strong>
                    <span>15 minutes</span>
                </a>
                <a href="/timer/set-timer-for-20-minutes" class="btn btn--secondary">
                    <strong>Strength EMOM</strong>
                    <span>20 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Is an EMOM?</h2>
            <p>EMOM stands for "Every Minute on the Minute." It is a structured interval format in which the athlete completes a fixed number of prescribed reps at the start of each minute, then rests for whatever time remains in that minute before the next round begins. As the trainee gets stronger or more efficient, the work portion takes less time, lengthening the rest portion and producing a self-regulating recovery system.</p>

            <p>EMOM is one of three time-domain structures alongside AMRAP and "For Time" workouts. CrossFit Inc. popularized EMOM in CrossFit Journal articles from the late 2000s, although the structure traces back to Pavel Tsatsouline's "ladder" methodology and traditional Eastern European weightlifting "EMOM lifting" used to prescribe high-volume sub-maximal work.</p>

            <h2 class="section-title">EMOM Programming By Goal</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Goal</th>
                        <th>Work / round</th>
                        <th>Total time</th>
                        <th>Sample movement</th>
                        <th>Target rest each minute</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Strength</strong></td><td>1&ndash;3 heavy reps</td><td>10&ndash;20 min</td><td>Back squat, clean &amp; jerk</td><td>40&ndash;50 sec</td></tr>
                    <tr><td><strong>Power/skill</strong></td><td>1&ndash;3 explosive reps</td><td>5&ndash;10 min</td><td>Snatch, box jump</td><td>45+ sec</td></tr>
                    <tr><td><strong>Conditioning</strong></td><td>10&ndash;15 reps</td><td>10&ndash;20 min</td><td>Burpees, wall balls</td><td>20&ndash;30 sec</td></tr>
                    <tr><td><strong>Strength-endurance</strong></td><td>5&ndash;10 reps moderate load</td><td>10&ndash;15 min</td><td>Front squat, push press</td><td>20&ndash;30 sec</td></tr>
                    <tr><td><strong>Aerobic capacity</strong></td><td>50&ndash;55 sec work</td><td>10&ndash;30 min</td><td>Row, bike, run</td><td>5&ndash;10 sec</td></tr>
                    <tr><td><strong>Skill work</strong></td><td>1&ndash;2 controlled reps</td><td>10&ndash;15 min</td><td>Turkish get-up, muscle-up</td><td>40+ sec</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why EMOM Works</h2>

            <h3>Self-regulating rest</h3>
            <p>Unlike AMRAP (where pace is fully self-managed) or fixed-rest intervals (where rest is identical regardless of fatigue), EMOM ties rest directly to work efficiency. If you take 25 seconds to complete the reps, you get 35 seconds rest. If fatigue stretches the same reps to 45 seconds, you only get 15 seconds rest &mdash; which immediately signals that pace is unsustainable. The structure forces honest pacing.</p>

            <h3>Built-in volume tracking</h3>
            <p>An EMOM that calls for 5 reps per minute for 10 minutes accumulates 50 reps. The structure makes total volume easy to plan and easy to retest. Most strength coaches use EMOM specifically because the total work is precise and reproducible.</p>

            <h3>Quality control through forced rest</h3>
            <p>EMOM stops athletes from going to muscular or central-nervous-system failure within the workout. The forced rest at the top of each minute resets the next set, allowing higher-quality movement than continuous AMRAP work. This is why heavy strength EMOMs (heavy singles or doubles) are typically run with 40&ndash;50 second rest windows.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sample EMOM Workouts By Goal</h2>

            <h3>Strength EMOM &mdash; back squat singles</h3>
            <p>15-minute EMOM: 1 back squat at 85&ndash;90% 1RM, every minute on the minute. Total: 15 heavy singles. Use this format twice in a build cycle and once in a peak week to maintain volume at near-max loads without exhausting the central nervous system.</p>

            <h3>Conditioning EMOM &mdash; burpee ladder</h3>
            <p>10-minute EMOM: minute 1 = 5 burpees, minute 2 = 6 burpees, ..., minute 10 = 14 burpees. As the reps climb, rest shrinks. Most trainees fail around minute 8 or 9; finishing the full ladder is an advanced benchmark.</p>

            <h3>Strength-endurance EMOM &mdash; kettlebell complex</h3>
            <p>12-minute EMOM, alternating: odd minutes = 5 kettlebell swings (heavy); even minutes = 5 goblet squats. Total: 30 swings, 30 goblet squats. Effective at modest weights (24 kg for men, 16 kg for women).</p>

            <h3>Skill EMOM &mdash; Turkish get-up</h3>
            <p>10-minute EMOM: 1 Turkish get-up per minute, alternating sides. Each rep should take 30&ndash;40 seconds with deliberate position-by-position movement. Use moderate weight; this is skill work, not maximum-load lifting.</p>

            <h3>Aerobic EMOM &mdash; rowing capacity</h3>
            <p>20-minute EMOM: 200m row per minute. The faster you row, the more rest you get. Most trainees hold sub-50 seconds for the row and get 10&ndash;15 seconds rest each minute. Builds aerobic capacity with strict pacing.</p>

            <h3>Mixed-modal EMOM &mdash; three-movement rotation</h3>
            <p>15-minute EMOM rotating: minute 1 = 8 push-ups; minute 2 = 12 air squats; minute 3 = 5 pull-ups. Repeat the cycle five times. Builds work capacity without burnout because no movement repeats in consecutive minutes.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">EMOM Programming Rules</h2>

            <h3>Rule 1: Work should fit in 30 to 45 seconds</h3>
            <p>If the prescribed work consistently takes more than 50 seconds, the prescription is too high. The athlete falls behind the clock, misses reps, and the structure breaks down. If work takes less than 15 seconds, the rest is too long for the conditioning effect and the format should be replaced with straight sets.</p>

            <h3>Rule 2: Scale by reps, not by removing rounds</h3>
            <p>If a 15-minute EMOM is too aggressive, scale by reducing the rep count per round (5 burpees instead of 10) rather than shortening the total session to 10 minutes. The 15-minute length is part of the adaptation; cutting it removes the metabolic stimulus.</p>

            <h3>Rule 3: Round prescriptions should be sustainable from round 1 to last</h3>
            <p>The reps you complete cleanly in round 1 should be the reps you complete cleanly in round 15. If round 1 has 30 seconds of slack and round 15 has zero seconds, the prescription is wrong &mdash; either scale down or accept that the last 3&ndash;5 rounds are designed to be the failure point.</p>

            <h3>Rule 4: Pair with the right complementary work</h3>
            <p>Heavy strength EMOMs pair with mobility cool-downs. Conditioning EMOMs pair with longer warm-ups. Skill EMOMs pair with controlled accessory work. Pair this page with our <a href="/crossfit-amrap-timer">AMRAP timer</a> for as-many-rounds work, <a href="/interval-timer">interval timer</a> for general work-rest splits, and the <a href="/workout-timers">workout timers hub</a> for other formats.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">EMOM Mistakes</h2>

            <h3>Treating EMOM like AMRAP</h3>
            <p>EMOM is not "do as many as you can each minute." It is a prescribed number of reps with the rest as the variable. Going beyond the prescription each minute defeats the self-regulating logic of the format and produces inconsistent training stimulus.</p>

            <h3>Choosing wrong weights</h3>
            <p>If you cannot complete the prescribed reps cleanly inside 50 seconds during minute 3, the weight is too heavy. Reduce by 10&ndash;15% and continue. Continuing at a weight you cannot manage produces missed reps, broken form, and limited adaptation.</p>

            <h3>Skipping the warm-up</h3>
            <p>EMOMs start hot. Heavy strength EMOM at 85% 1RM from cold is a serious injury risk. Take 10&ndash;15 minutes to warm up the movement at progressively heavier loads before the first work minute.</p>

            <h3>Running EMOMs daily</h3>
            <p>Two or three high-intensity EMOM sessions per week is the standard programming. Daily EMOMs &mdash; especially heavy strength or conditioning &mdash; produce overreaching and CNS fatigue within 2 to 3 weeks. Alternate EMOM days with strength, easy aerobic, or skill days.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">EMOM Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'What does EMOM mean?', 'a' => 'EMOM stands for "Every Minute on the Minute." At the top of each minute, the athlete completes a prescribed number of reps. Whatever time remains is rest before the next minute begins. EMOM is a structured interval format used widely in CrossFit, strength training, and conditioning programs.'],
                ['q' => 'How long should an EMOM be?', 'a' => 'Most EMOMs run 5, 10, 12, 15, or 20 minutes. Sprint EMOMs are 5 to 8 minutes; standard programming EMOMs are 10 to 15 minutes; strength-focused EMOMs can extend to 20 minutes for heavy-single work. Beyond 25 minutes, the format usually loses its training advantage.'],
                ['q' => 'How many reps should I do each minute in an EMOM?', 'a' => 'The work portion should take 30 to 45 seconds, leaving 15 to 30 seconds of rest. Strength EMOMs: 1 to 3 heavy reps. Conditioning EMOMs: 8 to 15 moderate-effort reps. Skill EMOMs: 1 to 3 deliberate reps. If reps consistently take more than 50 seconds, scale down.'],
                ['q' => 'What is the difference between EMOM and AMRAP?', 'a' => 'EMOM prescribes a fixed amount of work at the top of each minute with rest as the variable. AMRAP prescribes a circuit with no rest and total rounds as the variable. EMOM rewards consistent execution; AMRAP rewards sustained pace. Both build work capacity through different mechanisms.'],
                ['q' => 'Can I do heavy lifting in an EMOM?', 'a' => 'Yes &mdash; heavy single or double EMOMs are a staple of Olympic weightlifting and powerlifting programming. The forced rest each minute allows near-maximal loads without CNS exhaustion. Common formats: 10 to 15 minutes of one back squat per minute at 80 to 90% 1RM.'],
                ['q' => 'How many EMOMs per week should I do?', 'a' => 'Two to three EMOM sessions per week is the typical programming sweet spot. Daily EMOMs reliably produce CNS fatigue and reduced strength output within 2 to 3 weeks. Alternate EMOM days with strength, aerobic, or skill work to allow recovery.'],
                ['q' => 'What happens if I fall behind the clock?', 'a' => 'You either reduce the reps for the next round, take a forced rest minute, or end the session early. Continuing to fall further behind the clock means the prescription is too aggressive &mdash; the structure has broken and the workout is no longer producing the intended training stimulus.'],
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
  "name": "EMOM Workout",
  "description": "Every Minute on the Minute training format. Complete prescribed reps at the start of each minute and rest with whatever time remains.",
  "exerciseType": "EMOM",
  "duration": "PT10M",
  "url": "https://theblogtimer.com/emom-timer/"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free EMOM Timer - Every Minute on the Minute Training",
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "url": "https://theblogtimer.com/author-suraj-giri/"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "https://theblogtimer.com/"
  },
  "mainEntityOfPage": "https://theblogtimer.com/emom-timer/"
}
</script>

<?php get_footer(); ?>
