<?php
/**
 * Template Name: Interval Timer Page
 * Description: Customizable interval training timer with work/rest presets
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Interval Timer</h1>
        <p class="page-intro">Customizable work and rest intervals for HIIT, circuit training, and any activity that needs alternating on/off timing.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~15 min read &middot; Reviewed against the Tabata (1996) primary source</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">An interval timer alternates timed work and rest phases. For Tabata, use 20 seconds work and 10 seconds rest for eight rounds (four minutes total) at maximal effort. For general HIIT, use 30&ndash;60 seconds work and 15&ndash;30 seconds rest. Intervals improve VO2max, anaerobic capacity, and EPOC-driven fat oxidation faster than steady-state cardio. Pick a work-to-rest ratio (1:1, 1:2, 2:1) that matches your goal: power, conditioning, or endurance.</p>
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
                <button class="btn btn--primary btn--large start-timer">Start Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Interval Complete!</h3>
                <p>Take your rest, then start the next round.</p>
                <button class="btn btn--success start-timer">Start Next Round</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Common Interval Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-20-seconds" class="btn btn--secondary">
                    <strong>Tabata Work</strong>
                    <span>20 seconds</span>
                </a>
                <a href="/timer/set-timer-for-10-seconds" class="btn btn--secondary">
                    <strong>Tabata Rest</strong>
                    <span>10 seconds</span>
                </a>
                <a href="/timer/set-timer-for-45-seconds" class="btn btn--secondary">
                    <strong>HIIT Work</strong>
                    <span>45 seconds</span>
                </a>
                <a href="/timer/set-timer-for-15-seconds" class="btn btn--secondary">
                    <strong>HIIT Rest</strong>
                    <span>15 seconds</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Is an Interval Timer?</h2>
            <p>An interval timer alternates between two periods — typically a work phase and a rest phase — for a set number of rounds. This structure is the foundation of high-intensity interval training (HIIT), circuit workouts, Tabata, EMOM (every minute on the minute), and dozens of other training protocols proven to improve cardiovascular fitness, burn fat, and build muscular endurance faster than steady-state cardio.</p>

            <p>The key advantage of interval training over continuous exercise is the elevation of your heart rate into and out of high-intensity zones. This variation triggers greater calorie burn both during and after your workout (the "afterburn effect," technically known as excess post-exercise oxygen consumption or EPOC). A well-designed interval timer is essential for maintaining this structure without watching a clock.</p>

            <h2 class="section-title">Popular Interval Timer Protocols</h2>

            <h3>Tabata Protocol (20/10)</h3>
            <p>The most studied interval protocol: 20 seconds of maximum effort followed by 10 seconds of rest, repeated 8 times for a total of 4 minutes. Developed by Dr. Izumi Tabata, this format produces both anaerobic and aerobic fitness gains in a fraction of the time of traditional cardio. Use our <a href="/timer/set-timer-for-20-seconds">20-second timer</a> and <a href="/timer/set-timer-for-10-seconds">10-second timer</a> for each phase.</p>

            <h3>HIIT (45/15 or 40/20)</h3>
            <p>High-intensity interval training typically uses longer work periods (30-60 seconds) with shorter rest periods (10-20 seconds). The 45/15 split (45 seconds work, 15 seconds rest) is popular for bodyweight circuits and conditioning workouts. The slightly longer work phase builds more aerobic capacity while still maintaining intensity.</p>

            <h3>EMOM (Every Minute On the Minute)</h3>
            <p>Set a 1-minute timer and complete a fixed number of reps at the start of each minute. Whatever time remains is your rest before the next minute begins. As you get stronger, the reps take less time, giving you more rest. EMOM workouts are excellent for strength-endurance and tracking progress over time.</p>

            <h3>Work-to-Rest Ratios for Different Goals</h3>
            <ul>
                <li><strong>Speed and power (1:4 ratio):</strong> 15 seconds work, 60 seconds rest — maximal effort, full recovery</li>
                <li><strong>Anaerobic capacity (1:2 ratio):</strong> 30 seconds work, 60 seconds rest — hard effort with substantial recovery</li>
                <li><strong>Aerobic conditioning (1:1 ratio):</strong> 45 seconds work, 45 seconds rest — challenging but sustainable</li>
                <li><strong>Muscular endurance (2:1 ratio):</strong> 40 seconds work, 20 seconds rest — keeps heart rate elevated throughout</li>
            </ul>
        </div>
    </section>

    <!-- EXERCISE SCIENCE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Does the Exercise Science Actually Say About Intervals?</h2>
            <p>Interval training works through three primary physiological mechanisms: elevated <strong>EPOC</strong>, improved <strong>anaerobic capacity</strong>, and increased <strong>VO2max</strong>. Each of these is supported by decades of peer-reviewed research.</p>

            <h3>EPOC: the "afterburn effect"</h3>
            <p>Excess Post-exercise Oxygen Consumption (EPOC) refers to the elevated oxygen uptake your body sustains after intense exercise ends, as it works to restore homeostasis &mdash; replenishing ATP and creatine phosphate stores, clearing lactate, restoring oxygen to myoglobin and hemoglobin, and recovering elevated core body temperature. A 2006 review by LaForgia, Withers, and Gore in the <em>Journal of Sports Sciences</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/17101527/" rel="nofollow noopener" target="_blank">PMID 17101527</a>) found that EPOC can extend for 12&ndash;24 hours after high-intensity interval work but is comparatively brief after moderate steady-state cardio. Practically, intervals continue burning calories long after you stop.</p>

            <h3>VO2max and aerobic capacity</h3>
            <p>VO2max &mdash; the maximum rate at which your body can use oxygen during exercise &mdash; is the single best laboratory predictor of cardiovascular fitness. A 2013 meta-analysis by Bacon et al. in <em>PLOS ONE</em> (<a href="https://journals.plos.org/plosone/article?id=10.1371/journal.pone.0073182" rel="nofollow noopener" target="_blank">10.1371/journal.pone.0073182</a>) found high-intensity interval training raised VO2max by roughly 4.5 mL/kg/min versus continuous training, with most gains achieved in 6&ndash;8 weeks of consistent sessions.</p>

            <h3>Anaerobic capacity</h3>
            <p>Anaerobic capacity is your ability to produce energy without sufficient oxygen &mdash; the system that fuels sprints, jumps, and short, all-out efforts via the phosphocreatine and glycolytic pathways. Intervals at &gt;90% of VO2max train this system directly. Steady-state cardio does not.</p>
        </div>
    </section>

    <!-- TABATA 1996 -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Did the Tabata 1996 Study Actually Find?</h2>
            <p>Almost every "Tabata" workout sold online misreports the original study. Here is what the primary source actually says.</p>
            <p>The study, published as Tabata, Nishimura, Kouzaki, Hirai, Ogita, Miyachi, and Yamamoto, "Effects of moderate-intensity endurance and high-intensity intermittent training on anaerobic capacity and VO2max," appeared in <em>Medicine and Science in Sports and Exercise</em>, 28(10), 1327&ndash;1330, October 1996 (<a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">PMID 8897392</a>).</p>

            <p>Two groups of moderately trained men trained 5 days per week for 6 weeks on a mechanically braked cycle ergometer:</p>
            <ul>
                <li><strong>Group 1 (steady-state):</strong> 60 minutes at 70% VO2max, five times per week.</li>
                <li><strong>Group 2 (intervals):</strong> 7&ndash;8 sets of 20 seconds at 170% VO2max with 10 seconds rest. Total work time: less than 4 minutes per session.</li>
            </ul>

            <p>The findings overturned conventional wisdom:</p>
            <ul>
                <li>The steady-state group improved VO2max by 5 mL/kg/min but did <em>not</em> improve anaerobic capacity.</li>
                <li>The interval group improved VO2max by 7 mL/kg/min <em>and</em> improved anaerobic capacity by 28%.</li>
                <li>The interval group accomplished both improvements in less than one tenth the total training time.</li>
            </ul>

            <p>Three points the internet usually omits: (1) the work intensity is 170% of VO2max &mdash; not "vigorous," not "very hard," but a near-supramaximal effort most people cannot sustain on bodyweight squats; (2) the protocol was tested on a calibrated cycle ergometer, not burpees in a living room; (3) "Tabata" is not eight rounds of any exercise &mdash; it is a specific physiological protocol that requires reaching the right intensity.</p>

            <p>Start your own attempt with our <a href="/timer/set-timer-for-20-seconds">20-second work timer</a> and <a href="/timer/set-timer-for-10-seconds">10-second rest timer</a>, paired with a stationary bike or assault bike for the closest match to the original.</p>
        </div>
    </section>

    <!-- PROTOCOL COMPARISON TABLE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How Do Tabata, HIIT, AMRAP, EMOM, and Circuit Training Compare?</h2>
            <p>The terms get used interchangeably online. They are not the same.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Protocol</th>
                        <th>Structure</th>
                        <th>Intensity</th>
                        <th>Duration</th>
                        <th>Primary goal</th>
                        <th>Best timer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Tabata</strong></td>
                        <td>8 &times; (20s work / 10s rest)</td>
                        <td>~170% VO2max (near-max)</td>
                        <td>4 min</td>
                        <td>Anaerobic + aerobic capacity</td>
                        <td>20s / 10s interval</td>
                    </tr>
                    <tr>
                        <td><strong>HIIT (45/15)</strong></td>
                        <td>Variable rounds, 45s on / 15s off</td>
                        <td>85&ndash;95% HRmax</td>
                        <td>15&ndash;30 min</td>
                        <td>Conditioning, fat loss</td>
                        <td>45s / 15s interval</td>
                    </tr>
                    <tr>
                        <td><strong>AMRAP</strong></td>
                        <td>"As Many Rounds As Possible" of a circuit within a time cap</td>
                        <td>Self-paced &mdash; 80&ndash;90% effort</td>
                        <td>5&ndash;30 min</td>
                        <td>Work capacity</td>
                        <td>Single countdown</td>
                    </tr>
                    <tr>
                        <td><strong>EMOM</strong></td>
                        <td>"Every Minute on the Minute" &mdash; fixed reps each minute, rest with remainder</td>
                        <td>Moderate-high</td>
                        <td>10&ndash;30 min</td>
                        <td>Strength-endurance, pacing</td>
                        <td>Repeating 60s timer</td>
                    </tr>
                    <tr>
                        <td><strong>Circuit training</strong></td>
                        <td>Station-to-station with short rest</td>
                        <td>Moderate</td>
                        <td>20&ndash;45 min</td>
                        <td>General fitness</td>
                        <td>30&ndash;60s interval</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- WORK-TO-REST RATIOS DEEP DIVE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Which Work-to-Rest Ratio Should You Use?</h2>
            <p>The work-to-rest ratio is the most important variable in any interval session. It determines which energy system you train.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Ratio</th>
                        <th>Example</th>
                        <th>Energy system</th>
                        <th>Goal</th>
                        <th>Sample movement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>1:4</strong></td><td>15s work / 60s rest</td><td>Phosphocreatine (ATP-PCr)</td><td>Pure speed, power, sprinting</td><td>Max-effort sled push, 40-yd sprint</td></tr>
                    <tr><td><strong>1:2</strong></td><td>30s work / 60s rest</td><td>Anaerobic glycolytic</td><td>Anaerobic capacity</td><td>Assault-bike sprints, hill repeats</td></tr>
                    <tr><td><strong>1:1</strong></td><td>45s work / 45s rest</td><td>Mixed aerobic-anaerobic</td><td>VO2max, conditioning</td><td>Rowing intervals, kettlebell swings</td></tr>
                    <tr><td><strong>2:1</strong></td><td>40s work / 20s rest</td><td>Aerobic + muscular endurance</td><td>Endurance, work capacity</td><td>Bodyweight circuits</td></tr>
                    <tr><td><strong>Tabata 2:1</strong></td><td>20s work / 10s rest</td><td>Anaerobic + aerobic (supra-VO2max)</td><td>Max anaerobic + aerobic capacity</td><td>Cycle ergometer at 170% VO2max</td></tr>
                </tbody>
            </table>
            <p>Use a 1:4 ratio if your goal is athletic power and you need to be fresh for every rep. Use 1:1 or 2:1 if your goal is conditioning, fat loss, or general fitness. Use the Tabata 2:1 only when you can hit and hold the intensity &mdash; otherwise you are doing a 20/10 circuit, which is fine, but is not Tabata.</p>
        </div>
    </section>

    <!-- SAMPLE WORKOUTS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sample Interval Workouts by Goal</h2>

            <h3>Cardio-focused (VO2max)</h3>
            <p>Eight rounds on a rowing erg or assault bike: 30 seconds at ~95% effort, 30 seconds easy. After the eighth round, rest 3 minutes and repeat the block. Total session: 14 minutes including warm-up cool-down.</p>

            <h3>Strength-endurance (kettlebell complex)</h3>
            <p>EMOM for 12 minutes: minute 1 &mdash; 10 kettlebell swings; minute 2 &mdash; 6 goblet squats; minute 3 &mdash; 10 push-ups. Repeat the cycle four times. Rest is whatever remains in each minute. Loads should be heavy enough that finishing the reps takes 35&ndash;45 seconds.</p>

            <h3>Fat-loss conditioning</h3>
            <p>45 seconds on / 15 seconds off, five exercises, three rounds: jump rope, mountain climbers, plyo lunges, burpees, high knees. Total work: 15 minutes plus warm-up. Heart rate should sit in zone 4 (80&ndash;90% HRmax) throughout the work phases.</p>

            <h3>Sport-specific (court/field athletes)</h3>
            <p>Six rounds of 10-second shuttle runs (1:5 ratio) with 50 seconds rest. The 1:5 ratio mirrors basketball, soccer, and tennis work patterns where short max-effort bursts are followed by walking or jogging recovery. Use the <a href="/timer/set-timer-for-10-seconds">10-second timer</a> for the work phase.</p>
        </div>
    </section>

    <!-- EQUIPMENT-FREE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Equipment-Free Interval Workouts You Can Do Anywhere</h2>
            <p>No gym, no equipment, no excuse. These bodyweight intervals require only enough floor space to lie flat.</p>

            <h3>The 7-Minute Bodyweight HIIT (Klika &amp; Jordan, ACSM)</h3>
            <p>The protocol popularized in the 2013 <em>ACSM's Health &amp; Fitness Journal</em> piece "High-Intensity Circuit Training Using Body Weight" (<a href="https://journals.lww.com/acsm-healthfitness/Fulltext/2013/05000/HIGH_INTENSITY_CIRCUIT_TRAINING_USING_BODY_WEIGHT_.5.aspx" rel="nofollow noopener" target="_blank">Klika &amp; Jordan, 2013</a>) uses 12 exercises at 30 seconds each with 10-second transitions: jumping jacks, wall sit, push-up, abdominal crunch, step-up onto a chair, squat, triceps dip on chair, plank, high knees, lunge, push-up with rotation, side plank. One full pass takes about 7 minutes.</p>

            <h3>Tabata bodyweight (true 20/10 &times; 8)</h3>
            <p>Pick one movement and go all-out: burpees, jumping squats, mountain climbers, or push-ups (advanced). Set a 20-second work timer and a 10-second rest timer. Eight rounds. Four minutes. Done correctly, rounds 6&ndash;8 should feel impossible.</p>

            <h3>EMOM bodyweight ladder</h3>
            <p>Every minute on the minute for 10 minutes, increase reps by one: 1 burpee in minute 1, 2 burpees in minute 2, 10 burpees in minute 10. Rest is whatever remains each minute &mdash; until it isn't.</p>
        </div>
    </section>

    <!-- MISTAKES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Mistakes That Ruin Interval Workouts</h2>

            <h3>Intensity miscalibration</h3>
            <p>The single most common error: not pushing hard enough during work intervals. HIIT only works when work phases are <em>high intensity</em>. If you can hold a conversation, you are doing moderate continuous training with extra steps. A good rule: by the last work phase, you should not be able to speak in complete sentences.</p>

            <h3>Skipping rest to "get more work in"</h3>
            <p>Rest is not optional &mdash; it is structurally required for your nervous system to recover enough to produce another high-intensity effort. Cutting rest turns intervals into a moderate-intensity slog and eliminates the EPOC, VO2max, and anaerobic-capacity benefits you were chasing.</p>

            <h3>Choosing the wrong work-to-rest ratio for your goal</h3>
            <p>Doing 1:4 sprints when you want fat-loss conditioning, or doing 1:1 conditioning when you want pure speed. The ratio determines the energy system. Pick the ratio that matches your goal (see table above), not the one the popular YouTube workout uses.</p>

            <h3>Going daily</h3>
            <p>True high-intensity intervals demand 48&ndash;72 hours of central-nervous-system recovery. Two to three sessions per week is the sweet spot for most people. Daily HIIT becomes daily moderate cardio because you cannot reach the required intensity.</p>

            <h3>No warm-up</h3>
            <p>Cold-starting a Tabata or sprint set is the fastest path to muscle strain. Spend 5&ndash;8 minutes on dynamic mobility and a graded ramp-up to about 70% effort before the first true work interval.</p>
        </div>
    </section>

    <!-- BEGINNER PROGRESSION -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How Should a Beginner Start Interval Training Safely?</h2>
            <p>If you have not done intervals before, do not start with Tabata. Build a base first.</p>

            <h3>Weeks 1&ndash;2: Aerobic base</h3>
            <p>Three sessions per week of 20 minutes continuous moderate cardio (zone 2: 60&ndash;70% HRmax). The goal is mitochondrial density and stroke volume &mdash; the cardiovascular plumbing that intervals will later stress.</p>

            <h3>Weeks 3&ndash;4: Intro to intervals</h3>
            <p>Two sessions per week of 1:3 intervals &mdash; 30 seconds at perceived 7/10 effort, 90 seconds easy. Start with six rounds and add one round per week. Heart rate should reach roughly 80% HRmax in the last 5 seconds of each work bout.</p>

            <h3>Weeks 5&ndash;6: True HIIT</h3>
            <p>Two sessions per week at 1:1 or 1:2 ratios. Effort climbs to 8&ndash;9 out of 10. This is where most recreational athletes can safely live long-term.</p>

            <h3>Weeks 7+: Tabata, if you want</h3>
            <p>Reserve one session per week for a true Tabata effort, on a bike or assault bike rather than complex movements. The remaining session stays at 1:1 or 1:2 for variety and joint recovery.</p>
        </div>
    </section>

    <!-- HEART RATE ZONES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Heart Rate Zones Apply to Interval Work?</h2>
            <p>HRmax is approximated by 220 &minus; age (Fox, Naughton, Haskell formula) or more accurately by 208 &minus; (0.7 &times; age) (Tanaka et al., 2001, <em>Journal of the American College of Cardiology</em>, <a href="https://www.sciencedirect.com/science/article/pii/S0735109700010548" rel="nofollow noopener" target="_blank">DOI 10.1016/S0735-1097(00)01054-8</a>). For a 35-year-old, that is approximately 184 bpm by Tanaka.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>% HRmax</th>
                        <th>Feels like</th>
                        <th>Role in interval session</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Zone 1</td><td>50&ndash;60%</td><td>Very easy, recovery</td><td>Cool-down, active rest between sets</td></tr>
                    <tr><td>Zone 2</td><td>60&ndash;70%</td><td>Conversational</td><td>Warm-up, aerobic base on off days</td></tr>
                    <tr><td>Zone 3</td><td>70&ndash;80%</td><td>Comfortable hard</td><td>EMOM, longer work intervals</td></tr>
                    <tr><td>Zone 4</td><td>80&ndash;90%</td><td>Hard, broken speech</td><td>HIIT work phases</td></tr>
                    <tr><td>Zone 5</td><td>90&ndash;100%</td><td>All-out</td><td>Tabata, sprints &mdash; brief windows only</td></tr>
                </tbody>
            </table>
            <p>For Tabata, the last 3&ndash;5 seconds of each 20-second work bout should pin you in zone 5. If you never touch zone 5, intensity is too low; if you spend the entire workout in zone 5, you cannot recover and quality collapses.</p>
        </div>
    </section>

    <!-- RECOVERY SCIENCE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Active or Passive Rest Between Intervals?</h2>
            <p>The rest phase is not dead time &mdash; it is the engine of the next work phase. Two recovery modes compete:</p>

            <h3>Passive rest</h3>
            <p>Stand or sit still during the rest interval. Heart rate drops faster, perceived recovery is greater, and you can hit higher absolute intensities on subsequent work phases. Best for short, all-out sprints (Tabata, 1:4 power work).</p>

            <h3>Active rest</h3>
            <p>Light movement &mdash; walking, easy pedaling, shaking out the arms. A 2003 study by Spierer et al. in the <em>Journal of Sports Medicine and Physical Fitness</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/14767405/" rel="nofollow noopener" target="_blank">PMID 14767405</a>) showed active recovery clears blood lactate roughly twice as fast as passive recovery. Best for longer intervals (1:1, 2:1) and sustained conditioning sessions where lactate buffering matters.</p>

            <p>Rule of thumb: passive rest for pure power, active rest for conditioning. Skip neither.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How to Use This Interval Timer</h2>
            <p>Select your work interval from the presets above or navigate to any specific timer duration. Use your browser's back button to move between work and rest timers, or open both in separate tabs so you can switch instantly when each phase ends.</p>

            <p>For the best workout experience, enable browser notifications so the alarm fires even when you're away from the screen. The Blog Timer uses timestamp-based calculation, so it stays accurate even if your browser tabs go to sleep between intervals — no missed reps due to timer drift.</p>

            <p>If you're doing extended interval sessions (20+ minutes), consider bookmarking the specific timers you need. Many athletes create a simple interval card that lists which timers to switch to at each round, eliminating the need to track progress manually during a sweaty workout.</p>

            <p>Pair this page with our deeper guides: the <a href="/guides/tabata-timer-guide">Tabata timer guide</a> covers the precise four-minute protocol and common modifications, and the <a href="/guides/hiit-interval-timers">HIIT interval timers</a> reference catalogs ratios, splits, and movement libraries for every common goal.</p>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Interval Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'Is Tabata really better than steady-state cardio?', 'a' => 'For VO2max and anaerobic capacity in time-efficient terms, yes &mdash; the 1996 Tabata study showed superior improvements in both measures versus 60-minute steady-state cycling. For overall caloric burn during the workout itself, steady-state still wins by total volume. The trade-off is intensity for time.'],
                ['q' => 'How long should an interval workout be?', 'a' => 'A true high-intensity session is 4 to 25 minutes of actual work, plus warm-up and cool-down. If your interval workout is over 30 minutes of work, the intensity is too low to qualify as HIIT; you are doing circuit conditioning, which is still useful but trains different systems.'],
                ['q' => 'How many times per week should I do interval training?', 'a' => 'Two to three sessions per week with at least 48 hours of recovery between hard sessions. Daily HIIT is counterproductive for most recreational athletes because the central nervous system cannot recover fast enough to produce true high-intensity efforts day after day.'],
                ['q' => 'Can beginners do Tabata safely?', 'a' => 'Not on day one. The 170% VO2max intensity in the original protocol is unreachable without an aerobic base. Spend two to four weeks building zone 2 fitness and then introduce 1:3 intervals before attempting a true Tabata effort.'],
                ['q' => 'What is the difference between HIIT and Tabata?', 'a' => 'Tabata is a specific HIIT protocol: 20 seconds work at supramaximal intensity, 10 seconds rest, eight rounds, four minutes total. HIIT is the broader category that includes Tabata along with 30/30, 45/15, sprint intervals, and other work-rest schemes at high intensity.'],
                ['q' => 'Should I do intervals fasted?', 'a' => 'Most evidence supports having some carbohydrate before high-intensity intervals because the anaerobic glycolytic system depends on muscle glycogen. Fasted steady-state cardio has merit; fasted HIIT typically produces lower-quality work due to insufficient available glucose.'],
                ['q' => 'Are interval timers and HIIT timers the same thing?', 'a' => 'In everyday usage, yes. Technically, an interval timer is any timer that alternates two or more phases. A HIIT timer is an interval timer used specifically for high-intensity interval training. Our interval timer handles both.'],
                ['q' => 'Why do my intervals get slower as the workout progresses?', 'a' => 'Two reasons: glycogen depletion in fast-twitch fibers and central-nervous-system fatigue. The goal is to minimize, not eliminate, the drop-off. If round 8 is 50% slower than round 1, your initial intensity was too high; aim for a 5 to 15% drop from first to last round.'],
            ]);
            ?>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
