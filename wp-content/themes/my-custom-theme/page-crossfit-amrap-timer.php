<?php
/**
 * Template Name: CrossFit AMRAP Timer Page
 * Description: AMRAP timer for 5, 10, 15, 20 minute workouts
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free CrossFit AMRAP Timer &mdash; 5, 10, 15, 20 Minute Workouts</h1>
        <p class="page-intro">A dedicated AMRAP (As Many Rounds As Possible) timer for CrossFit, conditioning circuits, and benchmark workouts. Default 20-minute AMRAP &mdash; the most common WOD format.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~14 min read &middot; Cross-referenced against CrossFit Inc. benchmark WODs and CrossFit Journal</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">AMRAP stands for "As Many Rounds As Possible" within a fixed time cap. The most common formats are 5-, 10-, 15-, and 20-minute AMRAPs. You score the total rounds plus any partial reps completed when the timer expires (e.g., "11 rounds + 8 reps"). Benchmark "Girl" AMRAPs include Cindy (20 min: 5 pull-ups, 10 push-ups, 15 air squats) and Mary (20 min: 5 HSPU, 10 pistols, 15 pull-ups).</p>
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="1200"
             data-unit="minutes"
             data-value="20"
             data-mode="standard">
            <div class="timer-display">20:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start AMRAP</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Time! Drop the Bar</h3>
                <p>Record your rounds + reps. Recover before the cool-down.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">AMRAP Time Caps</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary">
                    <strong>Quick AMRAP</strong>
                    <span>5 minutes</span>
                </a>
                <a href="/timer/set-timer-for-10-minutes" class="btn btn--secondary">
                    <strong>Sprint AMRAP</strong>
                    <span>10 minutes</span>
                </a>
                <a href="/timer/set-timer-for-15-minutes" class="btn btn--secondary">
                    <strong>Mid AMRAP</strong>
                    <span>15 minutes</span>
                </a>
                <a href="/timer/set-timer-for-20-minutes" class="btn btn--secondary">
                    <strong>Cindy/Mary</strong>
                    <span>20 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Is an AMRAP?</h2>
            <p>AMRAP stands for "As Many Rounds As Possible" (sometimes "As Many Reps As Possible" in single-movement variants). The athlete completes a prescribed circuit of movements as many times as possible within a fixed time cap, scoring total rounds plus any partial reps at the buzzer. AMRAP is one of three time-domain structures in CrossFit programming alongside "For Time" (complete a fixed amount of work as fast as possible) and EMOM (complete prescribed work each minute on the minute).</p>

            <p>AMRAP scoring is a pure work-capacity test. The athlete who completes the most total reps inside the time cap wins. There is no judging of speed or pace within the workout &mdash; only total output. This makes AMRAP one of the cleanest measurements of conditioning improvement over time, because the workout structure is identical from one attempt to the next.</p>

            <h2 class="section-title">Benchmark CrossFit AMRAP Workouts</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>WOD</th>
                        <th>Time cap</th>
                        <th>Movements</th>
                        <th>Reps per round</th>
                        <th>RX standard</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Cindy</strong></td><td>20 min</td><td>Pull-ups, push-ups, air squats</td><td>5-10-15</td><td>20+ rounds elite</td></tr>
                    <tr><td><strong>Mary</strong></td><td>20 min</td><td>HSPU, pistols, pull-ups</td><td>5-10-15</td><td>9+ rounds elite</td></tr>
                    <tr><td><strong>Chelsea</strong></td><td>EMOM 30 min (related to AMRAP)</td><td>Same as Cindy</td><td>5-10-15 per min</td><td>30 rounds complete</td></tr>
                    <tr><td><strong>Tabata Something Else</strong></td><td>16 min</td><td>Pull-ups, push-ups, sit-ups, squats</td><td>Tabata 20/10 each</td><td>500+ total reps</td></tr>
                    <tr><td><strong>3-min AMRAP couplets</strong></td><td>3 min</td><td>Variable (Open-style)</td><td>Variable</td><td>Used in CrossFit Open</td></tr>
                </tbody>
            </table>

            <p>Cindy is the most-attempted AMRAP in CrossFit history. The bodyweight-only design makes it accessible anywhere, while the simple movement pattern allows for direct comparison across athletes and across years. Elite scores exceed 30 rounds; intermediate trainees typically score 12 to 20 rounds; novices score 8 to 12 rounds.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How To Pace an AMRAP</h2>

            <h3>Sprint AMRAPs (5 minutes or less)</h3>
            <p>Treat as anaerobic work. Go nearly all-out from the buzzer; expect a power drop in the final 60 seconds. Recovery is impossible inside a 5-minute window, so do not try to "save" energy &mdash; you will not redeem it before time expires.</p>

            <h3>Mid-range AMRAPs (10&ndash;15 minutes)</h3>
            <p>Sustain just below your max sustainable pace. Aim for steady consistent rounds rather than fast-slow-fast pacing. Most elite CrossFitters describe the optimal mid-range AMRAP pace as "uncomfortable but maintainable for the full clock."</p>

            <h3>Long AMRAPs (20+ minutes)</h3>
            <p>Run aerobic with brief anaerobic surges. The key skill is finding the largest unbroken rep set you can hold throughout the workout. For Cindy, this often means doing all 5 pull-ups unbroken every round even when your hands hurt &mdash; transitions cost time and break rhythm.</p>

            <h2 class="section-title">AMRAP Strategies By Movement</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Movement</th>
                        <th>Strategy</th>
                        <th>Common error</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Pull-ups (kipping)</td><td>Stay loose; small sets prevent grip failure</td><td>Going to grip failure in round 1</td></tr>
                    <tr><td>Push-ups</td><td>Pace breathing; rest in plank, not standing</td><td>Resting too long between sets</td></tr>
                    <tr><td>Air squats</td><td>Steady cadence; no pause at top or bottom</td><td>Slowing in late rounds to "recover"</td></tr>
                    <tr><td>Burpees</td><td>Slow consistent pace beats fast then stop</td><td>Going too fast in first 60 sec</td></tr>
                    <tr><td>Box jumps</td><td>Step down on the descent to save legs</td><td>Bouncing on every rep</td></tr>
                    <tr><td>Kettlebell swings</td><td>Hip drive only; let the bell float</td><td>Muscling the bell up with the arms</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sample AMRAP Workouts</h2>

            <h3>5-minute sprint AMRAP</h3>
            <p>5 minutes AMRAP of: 10 wall balls (20 lb / 14 lb), 10 burpees. Score = total rounds + reps. Intermediate target: 5+ rounds. Recover for 3&ndash;5 minutes before any cool-down.</p>

            <h3>10-minute AMRAP (Sprint conditioning)</h3>
            <p>10 minutes AMRAP of: 5 deadlifts (225/155 lb), 10 push-ups, 15 air squats. Score = rounds + reps. Intermediate target: 7&ndash;9 rounds. Pace requires breaking deadlifts before failure, not after.</p>

            <h3>15-minute AMRAP (Mid-range)</h3>
            <p>15 minutes AMRAP of: 200m run, 15 kettlebell swings (53/35 lb), 10 toes-to-bar. Score = total rounds + reps. Intermediate target: 8&ndash;10 rounds. The run is the recovery; pace the KB and T2B sustainably.</p>

            <h3>20-minute Cindy (benchmark)</h3>
            <p>20 minutes AMRAP of: 5 pull-ups, 10 push-ups, 15 air squats. Score = total rounds. Intermediate target: 15&ndash;20 rounds. Elite target: 25+ rounds. The benchmark Cindy WOD &mdash; retest every 6&ndash;8 weeks to measure conditioning progress.</p>

            <h3>20-minute Mary (advanced benchmark)</h3>
            <p>20 minutes AMRAP of: 5 handstand push-ups, 10 pistols (alternating), 15 pull-ups. Score = total rounds. Elite target: 9+ rounds. Scale to abmat HSPU and assisted pistols if needed.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">AMRAP Scoring &amp; Tracking</h2>

            <h3>The standard score format</h3>
            <p>AMRAP scores are written as "rounds + reps" &mdash; for example, "16 rounds + 8 reps" means you completed 16 full rounds and 8 additional reps of the next round when the buzzer sounded. Some apps and competitions convert this to total reps for tiebreaking; CrossFit Inc. uses the round + reps format for benchmark tracking.</p>

            <h3>Logbook discipline</h3>
            <p>Every AMRAP attempt should be logged with: WOD name, total score, scaling applied (e.g., banded pull-ups, abmat HSPU), date, and any notes on pacing. The value of AMRAP as a measurement tool depends on consistent logging &mdash; you cannot track progress without baselines.</p>

            <h3>Retest cadence</h3>
            <p>Benchmark AMRAPs should be retested every 6 to 12 weeks. Retesting more often does not give the body time to adapt and produces noisy data; retesting less often makes it harder to feel ongoing progress and adjust programming.</p>

            <p>Pair this page with our <a href="/emom-timer">EMOM timer</a> for "every minute on the minute" workouts, the <a href="/interval-timer">interval timer</a> for general work-rest splits, and the <a href="/workout-timers">workout timers hub</a> for other formats.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">AMRAP Mistakes</h2>

            <h3>Going out too hot</h3>
            <p>The most common AMRAP mistake. Athletes burn through round 1 at unsustainable pace, blow up in round 4, and spend the rest of the workout breathing instead of moving. Practice "sandbagging" the first 90 seconds to set a sustainable rhythm.</p>

            <h3>Failing reps</h3>
            <p>Failing a lift or movement in the middle of an AMRAP is costly &mdash; you lose 5 to 15 seconds resetting and the next rep is even harder. Break sets before failure rather than going to failure. Five sets of three pull-ups beats two sets of seven plus a failed eighth.</p>

            <h3>Overlong transitions</h3>
            <p>The gap between movements is where seconds disappear. Walking to the bar instead of jogging; chalking up for 8 seconds instead of 3; staring at the clock for 5 seconds. Aim for under 3 seconds between movements throughout the workout.</p>

            <h3>Wrong scaling</h3>
            <p>If you cannot complete round 1 at the RX prescription with form, the WOD is mis-scaled. Drop weights, reduce gymnastic difficulty, or shorten the time cap. CrossFit's stated programming logic is "mechanics, consistency, intensity" &mdash; in that order. Sacrificing mechanics for an RX score defeats the purpose.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">AMRAP Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'What does AMRAP mean?', 'a' => 'AMRAP stands for "As Many Rounds As Possible" within a fixed time cap. Sometimes "As Many Reps As Possible" for single-movement variants. The athlete completes the prescribed circuit as many times as possible inside the time limit and scores total rounds plus any partial reps at the buzzer.'],
                ['q' => 'How long is a typical AMRAP?', 'a' => 'Common AMRAP time caps are 5, 7, 10, 12, 15, and 20 minutes. Benchmark CrossFit WODs Cindy and Mary are both 20-minute AMRAPs. Sprint AMRAPs run 3 to 5 minutes; standard conditioning AMRAPs run 10 to 20 minutes; endurance-focused AMRAPs can extend to 30 or 45 minutes.'],
                ['q' => 'What is the difference between AMRAP and EMOM?', 'a' => 'AMRAP measures total work completed within a fixed time. EMOM (Every Minute On the Minute) prescribes a fixed amount of work to complete at the top of each minute, with the remaining time as rest. AMRAP rewards sustained pace; EMOM rewards consistent execution at a set work-rate.'],
                ['q' => 'What is a good Cindy score?', 'a' => 'Beginner: 8 to 12 rounds. Intermediate: 12 to 20 rounds. Advanced: 20 to 25 rounds. Elite: 25+ rounds. The record exceeds 35 rounds, set by elite-level CrossFit Games athletes. Most recreational trainees see Cindy improvements of 2 to 4 rounds over the first 12 months of training.'],
                ['q' => 'Should I rest during an AMRAP?', 'a' => 'Strategically, yes &mdash; but brief and active. Resting 5 to 10 seconds before a difficult movement to break the set into smaller chunks often produces a higher total score than going to grip or muscular failure mid-set. Plan rest breaks rather than stumbling into them.'],
                ['q' => 'How often should I do AMRAP workouts?', 'a' => 'Two to four AMRAP-style sessions per week is the typical CrossFit programming range. More than four high-intensity conditioning sessions per week reliably produces overreaching and reduces total adaptation. Balance with strength work and one or two longer aerobic sessions.'],
                ['q' => 'What happens if the buzzer goes off mid-rep?', 'a' => 'A rep that is not complete by the time the buzzer sounds does not count. Score the most recent fully completed rep. The buzzer is final &mdash; CrossFit competition standards do not allow "finishing the rep you started" after time expires.'],
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
  "name": "CrossFit AMRAP Workout",
  "description": "As Many Rounds As Possible workout within a fixed time cap. Common formats are 5, 10, 15, and 20-minute AMRAPs.",
  "exerciseType": "CrossFit",
  "duration": "PT20M",
  "url": "https://theblogtimer.com/crossfit-amrap-timer/"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free CrossFit AMRAP Timer - 5, 10, 15, 20 Minute Workouts",
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
  "mainEntityOfPage": "https://theblogtimer.com/crossfit-amrap-timer/"
}
</script>

<?php get_footer(); ?>
