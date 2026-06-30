<?php
/**
 * Template Name: Tabata Timer Page
 * Description: Real Tabata interval timer with audio cues for work/rest transitions
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Tabata Timer with Audio Cues &mdash; 8 Rounds of 20s/10s</h1>
        <p class="page-intro">A real Tabata interval timer: 8 rounds of 20 seconds work and 10 seconds rest, with distinct audio beeps for each transition. Customize rounds and work-rest ratios. Built around what Tabata's 1996 paper (PMID 8897392) actually proved &mdash; not what the internet says it proved.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~17 min read &middot; Primary source: Tabata et al. <em>Med. Sci. Sports Exerc.</em> 1996 (<a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" target="_blank" rel="noopener nofollow">PMID 8897392</a>)</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">A Tabata workout is 8 rounds of 20 seconds at maximal effort followed by 10 seconds of rest &mdash; 4 minutes total. Dr. Izumi Tabata's 1996 study on speed-skaters at the National Institute of Fitness and Sports in Tokyo showed this protocol improved <strong>both</strong> anaerobic capacity (+28%) and VO2max (+15%) after 6 weeks, at 5 days per week. The critical word is "maximal." Anything less intense than 170% of VO2max is not Tabata &mdash; it's just an interval workout. Use this timer with audio cues to keep transitions precise.</p>
        </div>
    </div>

    <!-- HERO TABATA TIMER -->
    <div class="container">
        <div id="top" class="timer-widget timer-widget--hero tabata-timer-widget"
             data-work="20"
             data-rest="10"
             data-rounds="8">
            <div class="tabata-state" style="text-align:center;font-size:0.875rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-text-muted,#7c87a8);margin-bottom:var(--space-2);">Ready</div>
            <div class="timer-display">20</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div style="text-align:center;font-size:0.9375rem;color:var(--color-text-secondary);margin:var(--space-3) 0;">
                Round <span class="tabata-round-num">0</span> of <span class="tabata-round-total">8</span>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Tabata</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Tabata Complete!</h3>
                <p>Eight rounds done. Total work time: 4 minutes.</p>
                <button class="btn btn--success restart-tabata">Run Another Round</button>
            </div>
        </div>

        <!-- CUSTOMIZE -->
        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Customize Your Tabata</h3>
            <div class="timer-grid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));">
                <div style="display:flex;flex-direction:column;gap:var(--space-2);">
                    <label style="font-size:0.8125rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--color-text-muted,#7c87a8);">Work (seconds)</label>
                    <input type="number" id="tabata-work-input" value="20" min="5" max="120" style="padding:var(--space-3);border-radius:6px;border:1px solid rgba(255,255,255,0.1);background:rgba(0,0,0,0.2);color:var(--color-text);font-size:1.125rem;">
                </div>
                <div style="display:flex;flex-direction:column;gap:var(--space-2);">
                    <label style="font-size:0.8125rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--color-text-muted,#7c87a8);">Rest (seconds)</label>
                    <input type="number" id="tabata-rest-input" value="10" min="0" max="120" style="padding:var(--space-3);border-radius:6px;border:1px solid rgba(255,255,255,0.1);background:rgba(0,0,0,0.2);color:var(--color-text);font-size:1.125rem;">
                </div>
                <div style="display:flex;flex-direction:column;gap:var(--space-2);">
                    <label style="font-size:0.8125rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--color-text-muted,#7c87a8);">Rounds</label>
                    <input type="number" id="tabata-rounds-input" value="8" min="1" max="40" style="padding:var(--space-3);border-radius:6px;border:1px solid rgba(255,255,255,0.1);background:rgba(0,0,0,0.2);color:var(--color-text);font-size:1.125rem;">
                </div>
                <button class="btn btn--secondary" id="tabata-apply" style="align-self:end;">Apply</button>
            </div>
            <div style="margin-top:var(--space-4);display:flex;gap:var(--space-3);flex-wrap:wrap;">
                <button class="btn btn--secondary tabata-preset" data-work="20" data-rest="10" data-rounds="8"><strong>Classic Tabata</strong><span>20/10 &times; 8</span></button>
                <button class="btn btn--secondary tabata-preset" data-work="30" data-rest="15" data-rounds="8"><strong>Beginner</strong><span>30/15 &times; 8</span></button>
                <button class="btn btn--secondary tabata-preset" data-work="40" data-rest="20" data-rounds="6"><strong>Conditioning</strong><span>40/20 &times; 6</span></button>
                <button class="btn btn--secondary tabata-preset" data-work="20" data-rest="10" data-rounds="16"><strong>Double Tabata</strong><span>20/10 &times; 16</span></button>
            </div>
        </div>
    </div>

    <!-- WHAT TABATA ACTUALLY IS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What is a Tabata workout?</h2>
            <p>A Tabata workout is an interval training protocol consisting of 8 rounds of 20 seconds of all-out effort followed by 10 seconds of rest, for a total of 4 minutes of work-and-rest time. The protocol was developed by Dr. Izumi Tabata and colleagues at the National Institute of Fitness and Sports in Kanoya, Japan, during a 1996 study examining the effects of high-intensity intermittent training on Olympic speed-skaters and recreationally active university students.</p>

            <p>The defining characteristic of true Tabata &mdash; the property that separates it from a generic 20/10 interval workout &mdash; is intensity. In the original study, participants worked at approximately 170% of their maximal oxygen uptake (VO2max) during the work phases. That is well above the lactate threshold and well above what a casual exerciser will ever reach. Most modern "Tabata" workouts marketed in fitness apps and group classes use the timing structure but not the intensity. They are interval workouts using a Tabata clock; they are not Tabata in the physiological sense.</p>

            <p>This distinction matters for two reasons. First, the documented benefits &mdash; simultaneous improvements in both anaerobic capacity and aerobic capacity in only 4 minutes per session &mdash; require the maximal intensity. Lower intensities produce lower returns. Second, the 4-minute duration is not a feature, it is a hard limit. Maximal-intensity work cannot be sustained for longer because the metabolic system that produces it (anaerobic glycolysis plus phosphocreatine recycling) cannot recover fast enough beyond the 8-round window.</p>
        </div>
    </section>

    <!-- WHAT THE 1996 STUDY ACTUALLY PROVED -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What did the 1996 Tabata study actually prove?</h2>
            <p>The Tabata protocol's evidence base rests primarily on one paper: Tabata, Nishimura, Kouzaki, Hirai, Ogita, Miyachi, and Yamamoto (1996), "Effects of moderate-intensity endurance and high-intensity intermittent training on anaerobic capacity and VO2max," published in <em>Medicine and Science in Sports and Exercise</em>, volume 28, issue 10, pages 1327&ndash;1330 (<a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" target="_blank" rel="noopener nofollow">PMID 8897392</a>).</p>

            <p>The study compared two training groups over 6 weeks, 5 sessions per week, on cycle ergometers:</p>

            <ul>
                <li><strong>Group 1 (moderate-intensity):</strong> 60 minutes at 70% of VO2max. Standard steady-state endurance training.</li>
                <li><strong>Group 2 (high-intensity intermittent / Tabata):</strong> 8 rounds of 20 seconds at 170% of VO2max with 10 seconds of rest &mdash; 4 minutes total of work-and-rest time, preceded by a 10-minute warm-up.</li>
            </ul>

            <p>The findings were striking:</p>

            <ul>
                <li><strong>Anaerobic capacity</strong> (measured by maximal accumulated oxygen deficit) improved by approximately 28% in the Tabata group and not at all in the moderate-intensity group.</li>
                <li><strong>VO2max</strong> improved by approximately 7 mL/kg/min (about 15%) in the Tabata group and by approximately 5 mL/kg/min in the moderate-intensity group, despite the Tabata group training for one-tenth as long per session.</li>
            </ul>

            <p>That is the actual finding. Four minutes of work, five times per week, produced anaerobic and aerobic gains that 60 minutes of moderate cardio could not match. Note the qualifiers: the participants were not beginners, they trained at 170% of VO2max, they completed all eight rounds, and the protocol ran for six weeks. The result does not generalize automatically to "do any 4-minute workout and get fit."</p>

            <p>The internet's version of Tabata &mdash; "the 4-minute workout that replaces a 60-minute workout" &mdash; is the headline, not the methodology. If you want the documented benefits, you have to do the documented work.</p>
        </div>
    </section>

    <!-- HOW THE TIMER USES AUDIO CUES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How the audio cues work in this timer</h2>
            <p>Maximal-intensity work is hard to time visually. By the third round you should not be looking at a screen &mdash; your eyes should be either closed or on your form. This timer provides four distinct audio cues so you can keep your eyes off the screen entirely:</p>
            <ul>
                <li><strong>Long high beep</strong> at the start of each work interval &mdash; "Go." Higher pitch (880 Hz), longer duration, clearly recognizable when out of breath.</li>
                <li><strong>Three short countdown beeps</strong> in the final 3 seconds of work &mdash; "3, 2, 1." Low-pitch ticks (440 Hz) so they do not get confused with the start cue.</li>
                <li><strong>Short low beep</strong> at the start of each rest interval &mdash; "Stop." Lower pitch (440 Hz), shorter duration.</li>
                <li><strong>Triple beep</strong> at the very end &mdash; the workout is complete.</li>
            </ul>
            <p>The audio uses the Web Audio API directly so no audio file needs to load &mdash; the cues fire instantly even on slow connections. On mobile, the first interaction (pressing Start) unlocks the audio context; subsequent rounds beep without permission prompts.</p>
        </div>
    </section>

    <!-- EPOC AND WHY TABATA WORKS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why does the Tabata protocol work physiologically?</h2>
            <p>Three mechanisms drive the documented results:</p>

            <h3>Maximal recruitment of glycolytic pathways</h3>
            <p>At 170% of VO2max, aerobic energy production cannot keep up. The body relies heavily on the phosphocreatine system and anaerobic glycolysis. Phosphocreatine stores deplete within 10 to 15 seconds of maximal effort and partially replenish during the 10-second rest. The 20/10 ratio is the longest work duration that still permits enough phosphocreatine recovery to sustain near-maximal output across 8 rounds. Longer work intervals at the same intensity become impossible by round 4 or 5.</p>

            <h3>EPOC and metabolic afterburn</h3>
            <p>Excess Post-exercise Oxygen Consumption (EPOC) is the elevated oxygen uptake the body maintains after intense exercise as it restores homeostasis &mdash; replenishing ATP and creatine phosphate, clearing lactate, restoring oxygen to myoglobin, and recovering elevated core body temperature. A 2006 review by LaForgia, Withers, and Gore in the <em>Journal of Sports Sciences</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/17101527/" target="_blank" rel="noopener nofollow">PMID 17101527</a>) found that EPOC can extend for 12 to 24 hours after high-intensity work but is much shorter after moderate steady-state cardio. Practically, the 4-minute Tabata workout continues burning calories long after it ends.</p>

            <h3>Mitochondrial adaptation</h3>
            <p>Repeated bouts of maximal-intensity work trigger mitochondrial biogenesis &mdash; the creation of new mitochondria within muscle cells &mdash; via activation of the PGC-1&alpha; signaling pathway. More mitochondria mean greater capacity to produce ATP aerobically, which is one mechanism behind the VO2max improvement seen even in this short protocol.</p>
        </div>
    </section>

    <!-- COMPARISON: WORK:REST RATIOS -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Work-to-rest ratios and what each one trains</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Ratio</th>
                        <th>Example</th>
                        <th>Energy System</th>
                        <th>Trains</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>2:1 (Tabata)</strong></td><td>20s / 10s</td><td>Anaerobic glycolytic + ATP-PCr</td><td>Anaerobic capacity, VO2max</td><td>Conditioning, fat loss in minimal time</td></tr>
                    <tr><td><strong>1:1</strong></td><td>30s / 30s</td><td>Mixed anaerobic / aerobic</td><td>Repeated sprint ability</td><td>Sport conditioning</td></tr>
                    <tr><td><strong>1:2</strong></td><td>30s / 60s</td><td>Mostly aerobic with anaerobic peaks</td><td>Cardiovascular base</td><td>Beginners, longer sessions</td></tr>
                    <tr><td><strong>1:4</strong></td><td>15s / 60s</td><td>ATP-PCr, near-full recovery</td><td>Speed, max power</td><td>Sprinters, jumpers</td></tr>
                    <tr><td><strong>4:1 (HIIT)</strong></td><td>4 min / 1 min</td><td>Aerobic with anaerobic peaks</td><td>VO2max (Norwegian 4x4)</td><td>Endurance athletes</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- BEST EXERCISES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Which exercises work best for Tabata?</h2>
            <p>Tabata's original study used a cycle ergometer because it allows precise intensity measurement and minimizes form breakdown under fatigue. For unsupervised home use, choose exercises that meet three criteria: large muscle mass involvement, low form risk under fatigue, and minimal coordination demand.</p>
            <ul>
                <li><strong>Stationary cycling.</strong> The closest match to the original protocol. Set heavy resistance, sprint 20 seconds, ease for 10. Hard to cheat the intensity.</li>
                <li><strong>Rowing.</strong> Full-body, low-impact, easy to push to maximal output. The Concept2 ergometer is the standard.</li>
                <li><strong>Sprint running.</strong> Outdoor or on a treadmill (treadmill is dangerous at maximum unless you are skilled; outdoor is safer).</li>
                <li><strong>Air bike (Assault Bike, Echo Bike).</strong> The cardiovascular gold standard for Tabata in modern gyms.</li>
                <li><strong>Burpees.</strong> Bodyweight, simple, full-body. Form degrades by round 5 &mdash; tolerable for fitness gains but pay attention to landing mechanics.</li>
                <li><strong>Kettlebell swings.</strong> Hip-hinge dominant, easy to scale, technically demanding. Use with caution if your swing form is not solid.</li>
                <li><strong>Mountain climbers.</strong> Bodyweight cardio, no form-breakdown injuries, good for beginners.</li>
                <li><strong>Jump rope.</strong> Lower joint load than sprinting; rhythmic and easy to time.</li>
            </ul>
            <p>Exercises to avoid in pure Tabata format: heavy compound lifts with complex form (clean and jerk, snatch), exercises requiring fine coordination (Olympic lifts under fatigue), and anything with high injury risk during exhaustion (heavy dumbbell snatches, box jumps in later rounds).</p>
        </div>
    </section>

    <!-- COMMON MISTAKES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Tabata mistakes</h2>
            <ul>
                <li><strong>Treating it as a 4-minute workout.</strong> Tabata is the intense part of a 25 to 30-minute session that also includes a 10-minute warm-up and 5 to 10-minute cool-down. The 1996 protocol included a 10-minute warm-up before the 4-minute Tabata block.</li>
                <li><strong>Pacing rounds 1 and 2.</strong> If you have anything left after round 8, you were not at Tabata intensity. The protocol is designed so you should be unable to sustain output in the final rounds without maximal effort early.</li>
                <li><strong>Doing it daily.</strong> Maximal-intensity work requires recovery. Three to five sessions per week, with full rest days between, is the supported range. Daily Tabata for weeks leads to overtraining, immune suppression, and injury.</li>
                <li><strong>Using moderate exercises.</strong> Bicep curls, lateral raises, and small-muscle isolation exercises do not produce the systemic metabolic load required. Use compound, large-muscle-mass movements.</li>
                <li><strong>Skipping the warm-up.</strong> Cold muscles at 170% of VO2max is a quick path to a strain. 5 to 10 minutes of progressive warm-up is non-negotiable.</li>
                <li><strong>Doing Tabata without medical clearance if you are sedentary, older, or have cardiovascular risk factors.</strong> Maximal-intensity work is genuinely demanding. Pre-existing heart conditions and uncontrolled blood pressure are contraindications.</li>
                <li><strong>Confusing CrossFit-style "Tabata" with real Tabata.</strong> Most class-format Tabata workouts are interval circuits with Tabata timing, not Tabata-intensity training. They have their own value &mdash; just not the same physiological adaptations.</li>
            </ul>
        </div>
    </section>

    <!-- RELATED -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Related workout timers</h2>
            <div class="usecase-grid">
                <a class="card usecase-card" href="/interval-timer/" style="text-decoration:none;">
                    <div class="usecase-card-icon">I</div>
                    <h3>Interval Timer</h3>
                    <p>Flexible work/rest intervals for any protocol.</p>
                </a>
                <a class="card usecase-card" href="/hiit-timer/" style="text-decoration:none;">
                    <div class="usecase-card-icon">H</div>
                    <h3>HIIT Timer</h3>
                    <p>Higher work-rest ratios for sustained conditioning.</p>
                </a>
                <a class="card usecase-card" href="/emom-timer/" style="text-decoration:none;">
                    <div class="usecase-card-icon">E</div>
                    <h3>EMOM Timer</h3>
                    <p>Every Minute On the Minute &mdash; for strength endurance.</p>
                </a>
                <a class="card usecase-card" href="/workout-timers/" style="text-decoration:none;">
                    <div class="usecase-card-icon">W</div>
                    <h3>All Workout Timers</h3>
                    <p>Hub of every fitness timer on the site.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Tabata timer FAQ</h2>
            <?php
            $faqs = [
                ['q' => 'How long is a Tabata workout?', 'a' => 'The Tabata block itself is 4 minutes &mdash; 8 rounds of 20 seconds work and 10 seconds rest. The full session including a 10-minute warm-up and brief cool-down is 20 to 30 minutes.'],
                ['q' => 'How many Tabata rounds should I do?', 'a' => 'The original 1996 protocol used 8 rounds. Beginners can start with 4 or 6 rounds, building up over weeks. Advanced trainees sometimes perform two Tabata blocks separated by 2 minutes of rest, but this is well beyond the protocol\'s documented intensity.'],
                ['q' => 'How often should I do Tabata?', 'a' => 'Three to five sessions per week with at least one full rest day between consecutive Tabata sessions. Daily maximal-intensity work leads to overtraining, suppressed immune function, and injury risk.'],
                ['q' => 'Is Tabata good for fat loss?', 'a' => 'Yes, primarily through the EPOC mechanism &mdash; elevated post-exercise oxygen consumption that can continue burning calories for 12 to 24 hours after the session. That said, calorie deficit through diet remains the dominant driver of fat loss; Tabata accelerates it but does not replace nutrition discipline.'],
                ['q' => 'What\'s the difference between Tabata and HIIT?', 'a' => 'Tabata is a specific 20/10/&times;8 protocol at 170% of VO2max. HIIT is the broader category of any high-intensity interval training. All Tabata is HIIT; not all HIIT is Tabata. HIIT typically uses longer work intervals (30 to 90 seconds) at lower (but still high) intensities.'],
                ['q' => 'Can I do Tabata with bodyweight exercises?', 'a' => 'Yes &mdash; burpees, mountain climbers, jumping jacks, jump squats, and high knees all work. The constraint is reaching maximal intensity, which is harder without resistance. Choose exercises that recruit large muscle mass and that you can sustain at full effort across all 8 rounds.'],
                ['q' => 'Does the audio cue play on mobile?', 'a' => 'Yes, but browsers require an initial user gesture to enable audio. Pressing the Start button unlocks the audio context; subsequent beeps then play automatically across all rounds.'],
                ['q' => 'Why does my timer say "Ready" before starting?', 'a' => 'The timer waits in a Ready state so you can mentally prepare and assume your starting position. Pressing Start begins the first 20-second work interval immediately, accompanied by the high-pitched "Go" beep.'],
            ];
            blogtimer_render_faq($faqs);
            ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>20 seconds. 10 seconds. Eight rounds. Maximal effort.</h2>
                <p>The original Tabata protocol exactly as studied. Audio cues keep your eyes off the screen so you can focus on the work.</p>
                <a href="#top" class="btn btn--primary btn--large">Start a Tabata Round</a>
            </div>
        </div>
    </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Tabata Timer with Audio Cues",
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "<?php echo esc_url(home_url('/')); ?>"
  },
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "mainEntityOfPage": "<?php echo esc_url(get_permalink()); ?>",
  "description": "A real Tabata interval timer with audio cues: 8 rounds of 20s work / 10s rest. Customizable. Built around the 1996 Tabata study (PMID 8897392)."
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.querySelector('.tabata-timer-widget');
    if (!widget) return;
    const stateEl = widget.querySelector('.tabata-state');
    const display = widget.querySelector('.timer-display');
    const progressBar = widget.querySelector('.timer-progress-bar');
    const roundNumEl = widget.querySelector('.tabata-round-num');
    const roundTotalEl = widget.querySelector('.tabata-round-total');
    const startBtn = widget.querySelector('.start-timer');
    const resetBtn = widget.querySelector('.reset-timer');
    const completeBanner = widget.querySelector('.timer-complete-banner');
    const restartBtn = completeBanner.querySelector('.restart-tabata');

    let workSec = 20;
    let restSec = 10;
    let totalRounds = 8;
    let currentRound = 0;
    let phase = 'idle'; // idle | work | rest | done
    let remaining = workSec;
    let intervalId = null;
    let phaseEndTimestamp = null; // timestamp-based timing (survives tab sleep)

    let audioCtx = null;
    function ensureAudio() {
        if (!audioCtx) {
            try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch (e) {}
        } else if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
    }
    function tone(freq, durMs, gainMax) {
        if (!audioCtx) return;
        const o = audioCtx.createOscillator();
        const g = audioCtx.createGain();
        o.connect(g); g.connect(audioCtx.destination);
        o.frequency.value = freq; o.type = 'sine';
        const t = audioCtx.currentTime;
        g.gain.setValueAtTime(0.001, t);
        g.gain.exponentialRampToValueAtTime(gainMax || 0.3, t + 0.02);
        g.gain.exponentialRampToValueAtTime(0.001, t + (durMs / 1000));
        o.start(t); o.stop(t + (durMs / 1000) + 0.05);
    }
    function beepGo() { tone(880, 500, 0.35); }
    function beepRest() { tone(440, 300, 0.25); }
    function beepTick() { tone(440, 90, 0.18); }
    function beepDone() {
        tone(880, 200, 0.3);
        setTimeout(function() { tone(880, 200, 0.3); }, 250);
        setTimeout(function() { tone(1320, 500, 0.35); }, 500);
    }

    function render() {
        display.textContent = remaining;
        const total = (phase === 'work') ? workSec : restSec;
        const pct = ((total - remaining) / total) * 100;
        progressBar.style.width = pct + '%';
        if (phase === 'work') {
            stateEl.textContent = 'Work';
            stateEl.style.color = '#22c55e';
        } else if (phase === 'rest') {
            stateEl.textContent = 'Rest';
            stateEl.style.color = '#f59e0b';
        } else if (phase === 'idle') {
            stateEl.textContent = 'Ready';
            stateEl.style.color = '';
        } else {
            stateEl.textContent = 'Done';
            stateEl.style.color = '#22c55e';
        }
        roundNumEl.textContent = currentRound;
        roundTotalEl.textContent = totalRounds;
    }

    function startInterval() {
        clearInterval(intervalId);
        intervalId = setInterval(tick, 250);
    }

    function tick() {
        if (!phaseEndTimestamp) return;
        var now = Date.now();
        var prev = remaining;
        remaining = Math.max(0, Math.ceil((phaseEndTimestamp - now) / 1000));
        // Countdown ticks during the final 3s of work (fire once per new second)
        if (phase === 'work' && remaining > 0 && remaining <= 3 && remaining !== prev) {
            beepTick();
        }
        if (remaining <= 0) {
            if (phase === 'work') {
                if (currentRound >= totalRounds) {
                    // workout done
                    clearInterval(intervalId);
                    phaseEndTimestamp = null;
                    phase = 'done';
                    remaining = 0;
                    render();
                    beepDone();
                    completeBanner.style.display = '';
                    startBtn.style.display = '';
                    resetBtn.style.display = 'none';
                    return;
                }
                phase = 'rest';
                remaining = restSec;
                phaseEndTimestamp = Date.now() + remaining * 1000;
                beepRest();
            } else if (phase === 'rest') {
                currentRound++;
                phase = 'work';
                remaining = workSec;
                phaseEndTimestamp = Date.now() + remaining * 1000;
                beepGo();
            }
        }
        render();
    }

    function startWorkout() {
        ensureAudio();
        if (phase === 'done' || phase === 'idle') {
            currentRound = 1;
            phase = 'work';
            remaining = workSec;
            phaseEndTimestamp = Date.now() + remaining * 1000;
            render();
            beepGo();
            startBtn.style.display = 'none';
            resetBtn.style.display = '';
            completeBanner.style.display = 'none';
            startInterval();
        }
    }
    function resetWorkout() {
        clearInterval(intervalId);
        phaseEndTimestamp = null;
        phase = 'idle';
        currentRound = 0;
        remaining = workSec;
        render();
        startBtn.style.display = '';
        resetBtn.style.display = 'none';
        completeBanner.style.display = 'none';
    }
    function apply(work, rest, rounds) {
        workSec = work;
        restSec = rest;
        totalRounds = rounds;
        widget.dataset.work = work;
        widget.dataset.rest = rest;
        widget.dataset.rounds = rounds;
        resetWorkout();
    }

    startBtn.addEventListener('click', startWorkout);
    resetBtn.addEventListener('click', resetWorkout);
    restartBtn.addEventListener('click', function() { resetWorkout(); startWorkout(); });

    document.getElementById('tabata-apply').addEventListener('click', function() {
        const w = parseInt(document.getElementById('tabata-work-input').value, 10) || 20;
        const r = parseInt(document.getElementById('tabata-rest-input').value, 10) || 10;
        const rd = parseInt(document.getElementById('tabata-rounds-input').value, 10) || 8;
        apply(w, r, rd);
    });
    document.querySelectorAll('.tabata-preset').forEach(function(b) {
        b.addEventListener('click', function() {
            const w = parseInt(this.dataset.work, 10);
            const r = parseInt(this.dataset.rest, 10);
            const rd = parseInt(this.dataset.rounds, 10);
            document.getElementById('tabata-work-input').value = w;
            document.getElementById('tabata-rest-input').value = r;
            document.getElementById('tabata-rounds-input').value = rd;
            apply(w, r, rd);
            document.querySelectorAll('.tabata-preset').forEach(function(x) { x.classList.remove('active'); });
            this.classList.add('active');
        });
    });

    render();
});
</script>

<?php get_footer(); ?>
