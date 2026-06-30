<?php
/**
 * Template Name: HIIT Timer Page
 * Description: Dedicated HIIT timer with all major protocols
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free HIIT Timer &mdash; All Major Protocols, Cardio &amp; Strength</h1>
        <p class="page-intro">A dedicated HIIT timer that covers every major protocol: 30/30, 45/15, 40/20, Gibala 60-second intervals, and the original Tabata 20/10 format.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~16 min read &middot; Built on Gibala 2006, Buchheit &amp; Laursen 2013, and Tabata 1996</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">HIIT alternates short bouts of near-maximal effort with structured rest. The most common formats are 30/30 (30s work, 30s rest), 45/15, 40/20, and the Gibala protocol (60 seconds at ~90% HRmax with 75 seconds active recovery). True HIIT requires reaching 85&ndash;95% of HRmax during work phases. Two to three sessions per week produces measurable VO2max and metabolic gains within 6&ndash;8 weeks.</p>
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="45"
             data-unit="seconds"
             data-value="45"
             data-mode="standard">
            <div class="timer-display">0:45</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start HIIT Work</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Work Interval Complete</h3>
                <p>Take your 15-second rest, then restart for the next round.</p>
                <button class="btn btn--success start-timer">Start Next Round</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">HIIT Protocol Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-20-seconds" class="btn btn--secondary">
                    <strong>Tabata Work</strong>
                    <span>20 seconds</span>
                </a>
                <a href="/timer/set-timer-for-30-seconds" class="btn btn--secondary">
                    <strong>30/30 Split</strong>
                    <span>30 seconds</span>
                </a>
                <a href="/timer/set-timer-for-45-seconds" class="btn btn--secondary">
                    <strong>45/15 Work</strong>
                    <span>45 seconds</span>
                </a>
                <a href="/timer/set-timer-for-1-minute" class="btn btn--secondary">
                    <strong>Gibala Interval</strong>
                    <span>1 minute</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Counts as HIIT?</h2>
            <p>High-intensity interval training (HIIT) is any structured session that alternates short bouts of near-maximal cardiovascular effort with timed recovery periods. The defining feature is intensity, not duration &mdash; work intervals must drive heart rate to roughly 85&ndash;95% of maximum (zone 4 to 5) to qualify as HIIT, per the working definitions used by Buchheit and Laursen in their two-part 2013 <em>Sports Medicine</em> review (<a href="https://pubmed.ncbi.nlm.nih.gov/23539308/" rel="nofollow noopener" target="_blank">PMID 23539308</a>).</p>

            <p>If you can hold a conversation during a "HIIT" work interval, intensity is too low and the protocol is functionally moderate continuous training. The whole point of HIIT &mdash; oversized VO2max and metabolic adaptations in low total training time &mdash; depends on hitting the intensity ceiling.</p>

            <h2 class="section-title">Major HIIT Protocols Compared</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Protocol</th>
                        <th>Work / rest</th>
                        <th>Rounds</th>
                        <th>Target intensity</th>
                        <th>Total session</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Tabata 20/10</strong></td><td>20s / 10s</td><td>8</td><td>~170% VO2max (supramaximal)</td><td>4 min work</td></tr>
                    <tr><td><strong>30/30</strong></td><td>30s / 30s</td><td>10&ndash;20</td><td>90&ndash;95% HRmax</td><td>10&ndash;20 min</td></tr>
                    <tr><td><strong>45/15</strong></td><td>45s / 15s</td><td>10&ndash;15</td><td>85&ndash;90% HRmax</td><td>10&ndash;15 min</td></tr>
                    <tr><td><strong>40/20</strong></td><td>40s / 20s</td><td>10&ndash;20</td><td>85&ndash;95% HRmax</td><td>10&ndash;20 min</td></tr>
                    <tr><td><strong>Gibala SIT</strong></td><td>60s / 75s active rest</td><td>8&ndash;12</td><td>~90% HRmax</td><td>~25 min</td></tr>
                    <tr><td><strong>Wingate</strong></td><td>30s all-out / 4 min rest</td><td>4&ndash;6</td><td>maximal effort</td><td>~20 min</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Does the Research Say?</h2>

            <h3>Tabata 1996: the original protocol</h3>
            <p>Tabata et al. in <em>Medicine and Science in Sports and Exercise</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">PMID 8897392</a>) showed that 6 weeks of 20-second intervals at 170% VO2max with 10-second rest improved VO2max by 7 mL/kg/min and raised anaerobic capacity by 28% in under 4 minutes of daily work. Steady-state cycling at 70% VO2max for 60 minutes improved VO2max similarly but did not move anaerobic capacity.</p>

            <h3>Gibala 2006: low-volume sprint interval training</h3>
            <p>Gibala et al. in <em>The Journal of Physiology</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/16916910/" rel="nofollow noopener" target="_blank">PMID 16916910</a>) compared 6 sessions of low-volume sprint interval training (4&ndash;6 &times; 30-second all-out cycle sprints with 4 minutes rest) against 6 sessions of 90&ndash;120 minutes of moderate continuous cycling. Skeletal muscle oxidative capacity, glycogen content, and exercise performance improved equivalently &mdash; despite the SIT group performing less than one-tenth of the total work.</p>

            <h3>Buchheit &amp; Laursen 2013: the modern framework</h3>
            <p>Buchheit and Laursen's two-part review (<a href="https://pubmed.ncbi.nlm.nih.gov/23539308/" rel="nofollow noopener" target="_blank">PMID 23539308</a> and <a href="https://pubmed.ncbi.nlm.nih.gov/23568373/" rel="nofollow noopener" target="_blank">PMID 23568373</a>) defines nine variables that determine HIIT outcomes: work interval intensity, work duration, rest intensity, rest duration, number of intervals, number of sets, between-set rest, modality, and total session work. Adjusting any one variable changes which physiological adaptation dominates.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sample HIIT Workouts By Goal</h2>

            <h3>VO2max focus (Gibala 60/75)</h3>
            <p>Ten rounds of 60 seconds at 90% HRmax on a stationary bike, rowing erg, or assault bike, with 75 seconds of easy spinning between rounds. Warm up for 10 minutes; cool down for 5. Total: ~37 minutes. Three sessions per week for 6 weeks produces approximately 12% VO2max improvement in untrained subjects.</p>

            <h3>Fat-loss conditioning (45/15 bodyweight)</h3>
            <p>15 rounds of 45 seconds work / 15 seconds rest, rotating five movements: burpees, mountain climbers, jumping squats, push-ups, plank shoulder taps. Total: 15 minutes plus warm-up. Heart rate should remain above zone 4 throughout the work phases.</p>

            <h3>Anaerobic capacity (Tabata cycle ergometer)</h3>
            <p>Warm up for 8 minutes. Eight rounds of 20 seconds at maximal effort with 10 seconds passive rest. The first round should feel almost easy; the last should feel impossible. Total work: 4 minutes. Cool down for 8 minutes. Once per week maximum.</p>

            <h3>Sport-specific HIIT (40/20 plyometric)</h3>
            <p>Ten rounds of 40 seconds plyometric movements (box jumps, broad jumps, lateral bounds) with 20 seconds rest. Builds power endurance for court and field athletes. Match to your sport's work patterns &mdash; basketball, soccer, and tennis players benefit from the 2:1 ratio because it mirrors typical possession-and-recovery patterns.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Choosing the Right HIIT Protocol</h2>
            <p>The work-to-rest ratio determines which energy system dominates and which adaptation you will see. Pair the right protocol to the right goal.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Goal</th>
                        <th>Best protocol</th>
                        <th>Frequency</th>
                        <th>Why</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Improve VO2max fast</td><td>Gibala 60/75 or Tabata</td><td>2&ndash;3&times;/week</td><td>Drives sustained near-maximal oxygen uptake</td></tr>
                    <tr><td>Fat loss + body composition</td><td>45/15 or 40/20</td><td>3&ndash;4&times;/week</td><td>Longer work-phase volume elevates EPOC and weekly caloric expenditure</td></tr>
                    <tr><td>Anaerobic power</td><td>Wingate 30s all-out / 4 min</td><td>1&ndash;2&times;/week</td><td>Trains glycolytic capacity with full recovery between bouts</td></tr>
                    <tr><td>Sport-specific endurance</td><td>30/30 or sport-specific work intervals</td><td>2&times;/week in-season</td><td>Matches stop-start patterns of team sports</td></tr>
                    <tr><td>General conditioning</td><td>30/30 or 40/20</td><td>2&ndash;3&times;/week</td><td>Balanced aerobic and anaerobic stress</td></tr>
                </tbody>
            </table>
            <p>For longer-format conditioning, pair this page with our <a href="/interval-timer">interval timer</a> for any work-rest split, and the <a href="/workout-timers">workout timers hub</a> for non-HIIT formats.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Cardiovascular Adaptations to HIIT</h2>

            <h3>VO2max</h3>
            <p>HIIT produces consistent VO2max gains of 4&ndash;5 mL/kg/min over 6&ndash;8 weeks, according to a 2013 meta-analysis by Bacon et al. in <em>PLOS ONE</em> (10.1371/journal.pone.0073182). This exceeds the gains from equivalent volumes of moderate continuous training in roughly 80% of comparison studies.</p>

            <h3>Stroke volume and cardiac output</h3>
            <p>The heart's left ventricle adapts to repeated high-intensity stress by increasing end-diastolic volume, raising stroke volume at any given heart rate. This is the structural basis of the resting-heart-rate drop most HIIT trainees see within 3&ndash;4 weeks.</p>

            <h3>Mitochondrial density</h3>
            <p>Both Tabata-style and Gibala-style intervals trigger PGC-1&alpha; signaling that drives skeletal muscle mitochondrial biogenesis. More mitochondria means more capacity to oxidize fat and clear lactate, which is why HIIT-trained athletes typically have better fat oxidation at sub-maximal intensities than steady-state-trained athletes.</p>

            <h3>Lactate threshold</h3>
            <p>HIIT raises the workload at which blood lactate begins to accumulate, allowing athletes to sustain harder paces for longer before fatigue. This is the adaptation that translates HIIT into improved 5K, 10K, and time-trial performance.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">HIIT Programming Mistakes</h2>

            <h3>Daily HIIT</h3>
            <p>True HIIT demands 48&ndash;72 hours of central-nervous-system recovery. Daily sessions produce daily moderate-intensity training, because the body cannot reach the required work-phase intensity ceiling. Two to three sessions per week is the sweet spot for almost all trainees.</p>

            <h3>Too-short work intervals with insufficient intensity</h3>
            <p>A 20-second burpee set at 70% effort is not Tabata; it is a short circuit. If you cannot pin yourself in zone 5 on the last round, intensity is too low or the work interval is too long for your conditioning.</p>

            <h3>No warm-up</h3>
            <p>Cold-starting a Tabata or Wingate is the fastest path to muscle strain. Spend 8&ndash;10 minutes on graded warm-up to roughly 70% effort before the first true work interval.</p>

            <h3>Ignoring rest intensity</h3>
            <p>Active recovery (light pedaling, walking) clears blood lactate faster than passive recovery, which is the right choice for longer work intervals (Gibala, 45/15, 40/20). Passive rest is better for short all-out sprints where you want full recovery between bouts.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">HIIT Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'How long should a HIIT workout be?', 'a' => 'A true high-intensity session is 4 to 25 minutes of actual work, plus warm-up and cool-down. If your HIIT session exceeds 30 minutes of work, intensity has dropped below the threshold that defines HIIT &mdash; it is now circuit conditioning, which is useful but trains different systems.'],
                ['q' => 'Is HIIT better than steady-state cardio?', 'a' => 'For time-efficient VO2max improvement and anaerobic capacity, yes. For pure total caloric expenditure during the session, longer steady-state still wins by volume. Most well-rounded programs include both modalities at different times of the week.'],
                ['q' => 'How many times per week should I do HIIT?', 'a' => 'Two to three sessions per week, with at least 48 hours between hard sessions. Three sessions is the upper end for advanced trainees; recreational athletes generally see best results at two HIIT sessions plus one or two steady-state aerobic days.'],
                ['q' => 'What heart rate should I hit during HIIT work intervals?', 'a' => '85 to 95% of maximum heart rate, with the last 5&ndash;10 seconds of each work phase touching 95%+. If you stay below 85% throughout, the protocol is moderate continuous training, not HIIT.'],
                ['q' => 'Can beginners do HIIT safely?', 'a' => 'Yes, but start with a 1:3 work-to-rest ratio (e.g., 30 seconds work, 90 seconds rest) for 4&ndash;6 rounds, two times per week for the first 2&ndash;4 weeks. Build aerobic base before introducing Tabata or Wingate protocols.'],
                ['q' => 'What is the difference between HIIT and SIT?', 'a' => 'Sprint interval training (SIT) uses all-out, supramaximal efforts &mdash; typically 30-second Wingate sprints with 4 minutes of recovery. HIIT uses high but submaximal efforts (85&ndash;95% HRmax) with shorter rest. SIT is a subset of HIIT focused on maximal anaerobic capacity.'],
                ['q' => 'Should I do HIIT fasted?', 'a' => 'Most evidence supports having carbohydrates available before HIIT because anaerobic glycolysis depends on muscle glycogen. Fasted HIIT typically produces lower-quality work and reduced training adaptation; fasted steady-state cardio has more support in the literature.'],
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
  "name": "HIIT Workout",
  "description": "High-intensity interval training alternating near-maximal work bouts with structured rest. Common protocols include Tabata 20/10, 30/30, 45/15, and Gibala 60/75.",
  "exerciseType": "HIIT",
  "duration": "PT15M",
  "url": "https://theblogtimer.com/hiit-timer/"
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free HIIT Timer - All Major Protocols, Cardio & Strength",
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
  "mainEntityOfPage": "https://theblogtimer.com/hiit-timer/"
}
</script>

<?php get_footer(); ?>
