<?php
/**
 * Template Name: Focus Timer Page
 * Description: Customizable focus timer with cognitive science research
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Focus Timer &mdash; Science-Backed Concentration Intervals</h1>
        <p class="page-intro">A research-grounded focus timer with custom durations (15, 25, 45, 90 minutes), session tracking, and optional break alarms. Built around what cognitive science actually says about sustained attention.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~16 min read &middot; References: Newport (2016), Mark (UC Irvine 2008), Csikszentmihalyi (1990)</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">A focus timer is a countdown clock used to commit to a single, uninterrupted block of cognitive work. Pick 25 minutes for procrastination-prone tasks (Pomodoro), 45&ndash;50 minutes for sustained knowledge work, or 90 minutes to align with one ultradian cycle &mdash; the longest interval the brain can hold high-quality attention before measurable performance decay. Research by Gloria Mark at UC Irvine shows the average knowledge worker is interrupted every 3 minutes, and that the average refocus time after an interruption is 23 minutes 15 seconds. A timer externalizes the boundary, eliminating that compounding cost.</p>
        </div>
    </div>

    <!-- HERO FOCUS TIMER -->
    <div class="container">
        <div class="timer-widget timer-widget--hero focus-timer-widget"
             data-duration="1500"
             data-unit="minutes"
             data-value="25"
             data-mode="standard">
            <div class="timer-display">25:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Focus Block</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Focus Block Complete!</h3>
                <p>Take a short break before your next session.</p>
                <button class="btn btn--success start-timer">Start Another Block</button>
            </div>
        </div>

        <!-- FOCUS PRESETS -->
        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Focus Duration Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary focus-preset" data-minutes="15">
                    <strong>Sprint</strong>
                    <span>15 minutes &mdash; warm-up</span>
                </button>
                <button class="btn btn--secondary focus-preset" data-minutes="25">
                    <strong>Pomodoro</strong>
                    <span>25 minutes &mdash; classic</span>
                </button>
                <button class="btn btn--secondary focus-preset" data-minutes="45">
                    <strong>Deep Work</strong>
                    <span>45 minutes &mdash; sustained</span>
                </button>
                <button class="btn btn--secondary focus-preset" data-minutes="90">
                    <strong>Ultradian</strong>
                    <span>90 minutes &mdash; one full cycle</span>
                </button>
            </div>
        </div>

        <!-- SESSION COUNTER + BREAK TOGGLE -->
        <div class="pomodoro-session-count" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;justify-content:space-between;padding:var(--space-4);margin-top:var(--space-5);">
            <div>
                <h4 style="margin:0;">Focus Sessions Today: <span class="focus-count-number">0</span></h4>
                <p style="margin:var(--space-1) 0 0;font-size:0.875rem;color:var(--color-text-muted,#7c87a8);">Tracked locally in your browser. No account needed.</p>
            </div>
            <div style="display:flex;gap:var(--space-3);align-items:center;flex-wrap:wrap;">
                <label style="display:flex;align-items:center;gap:var(--space-2);font-size:0.875rem;cursor:pointer;">
                    <input type="checkbox" id="focus-break-alarm" checked>
                    <span>Break alarm at end</span>
                </label>
                <button class="btn btn--secondary reset-focus-sessions">Reset Counter</button>
            </div>
        </div>
    </div>

    <!-- WHAT IS A FOCUS TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What is a focus timer?</h2>
            <p>A focus timer is a countdown clock used to commit to a single, uninterrupted block of cognitive work. The mechanism is simple: choose a duration, start the timer, work on one task until it rings. The discipline is harder than the tool. What a focus timer actually does &mdash; the part that matters &mdash; is externalize the decision to keep working. You do not have to repeatedly ask yourself whether to continue or stop; the timer holds that decision for you, freeing your prefrontal cortex to commit fully to the task.</p>

            <p>Focus timers differ from general countdown timers in three ways. First, they are tied to a single task, not a generic event. Second, they typically include a session counter or log so you can see cumulative output over time. Third, they often pair with break alarms or session transitions because attention research consistently shows that uninterrupted work eventually degrades, and that brief, deliberate rest restores it. A focus timer is therefore part timing instrument, part behavioral commitment device, and part personal analytics tool.</p>

            <p>The defining feature of an effective focus timer is its honesty. If you check your phone, stop the timer. If you switch tasks, restart. The numbers on the dial only mean something if they correspond to actual single-tasked work. This is the core principle behind Francesco Cirillo's original Pomodoro method, and it is the same principle that makes a modern <a href="/pomodoro">Pomodoro timer</a>, a <a href="/sprint-timer">15-minute sprint timer</a>, or a long-form deep work block work the way it does.</p>
        </div>
    </section>

    <!-- COGNITIVE SCIENCE OF FOCUS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What does cognitive science say about sustained focus?</h2>
            <p>The research on attention is unusually consistent. Studies converge on the finding that the brain cannot maintain peak concentration indefinitely &mdash; it operates in cycles of engagement and recovery, and the duration of those cycles depends on task complexity, sleep, novelty, and motivation.</p>

            <h3>Gloria Mark and the cost of interruption</h3>
            <p>The foundational empirical work on workplace attention comes from <a href="https://en.wikipedia.org/wiki/Gloria_Mark" target="_blank" rel="noopener">Gloria Mark</a> at the University of California, Irvine. In a 2008 study published in the proceedings of CHI, Mark and her colleagues observed information workers in situ and found that the average interruption-free task duration was 3 minutes 5 seconds, and that the average time to fully return to the original task after an interruption was 23 minutes 15 seconds. In follow-up work, Mark documented that interruptions accumulate stress, and that switched-attention work produces higher error rates than focused work of equivalent total duration. The conclusion is uncomfortable but actionable: the cost of an interruption is not the interruption itself, it is the multiplicative effect on subsequent attention quality. A focus timer is, fundamentally, a counter-measure to that multiplicative cost.</p>

            <h3>Cal Newport and deep work</h3>
            <p>Computer scientist <a href="https://en.wikipedia.org/wiki/Cal_Newport" target="_blank" rel="noopener">Cal Newport</a> formalized a category he calls "deep work" &mdash; cognitively demanding tasks performed in a state of distraction-free concentration. In his 2016 book <em>Deep Work</em>, Newport argues that the ability to sustain such concentration is increasingly rare and economically valuable. His prescription pairs naturally with a focus timer: protect a multi-hour block, work on a single hard problem, and resist any input that is not the work itself. The shorter Pomodoro-style intervals serve as on-ramps; the 45 to 90-minute deep work blocks are where novel intellectual output actually happens.</p>

            <h3>The default mode network and the prefrontal cortex</h3>
            <p>From neuroscience, the relevant brain systems are the task-positive network (centered in the lateral prefrontal cortex and parietal regions) and the <a href="https://en.wikipedia.org/wiki/Default_mode_network" target="_blank" rel="noopener">default mode network</a>, identified by Marcus Raichle in 2001. The task-positive network is engaged during focused work. The default mode network is active during mind-wandering, planning, and self-reflective thought. These networks are anti-correlated &mdash; when one is highly active, the other is suppressed. A focus timer prolongs task-positive engagement, but breaks must allow default-mode activation. Research by Christoff and colleagues (2009) and Andrews-Hanna (2012) shows that default-mode activity during rest contributes to memory consolidation, creative connection-making, and integrative thinking. Working through breaks defeats the cycle.</p>

            <h3>Flow and Csikszentmihalyi</h3>
            <p>Hungarian-American psychologist <a href="https://en.wikipedia.org/wiki/Mihaly_Csikszentmihalyi" target="_blank" rel="noopener">Mih&aacute;ly Cs&iacute;kszentmih&aacute;lyi</a> spent decades studying the optimal experience he termed "flow" &mdash; a state of complete absorption in a task. Flow requires three conditions: clear goals, immediate feedback, and a balance between challenge and skill. A focus timer cannot generate flow on its own, but it provides the structural conditions that allow flow to emerge. By eliminating the friction of when-to-stop decisions, the timer lets the cognitive system enter the deep engagement that produces flow states. Csikszentmihalyi's interview-based research found that flow most reliably emerges 10 to 15 minutes after starting a focused task &mdash; which is why the 15-minute sprint preset is rarely enough for deep cognitive work, but enough to break inertia.</p>

            <h3>Ultradian rhythms and the 90-minute cycle</h3>
            <p>The 90-minute ultradian rhythm was first described by sleep researcher Nathaniel Kleitman in the 1950s. Kleitman observed that during waking hours, the brain alternates between roughly 90-minute periods of higher alertness and 20-minute troughs. Energy expert Tony Schwartz and his collaborator Jim Loehr translated this into a workplace prescription: work in 90-minute pulses with deliberate 15 to 20-minute recovery. Modern wearable research has muddied the picture &mdash; ultradian periods vary across individuals from 70 to 110 minutes &mdash; but the principle holds. The 90-minute preset on our focus timer aligns with this natural biological boundary.</p>
        </div>
    </section>

    <!-- COMPARISON TABLE -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">How do focus timer apps compare?</h2>
            <p class="section-subtitle">The major focus timer tools differ in interface, distraction blocking, and analytics. Here is the honest comparison.</p>

            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Free?</th>
                        <th>Custom Intervals</th>
                        <th>Distraction Blocking</th>
                        <th>Analytics</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>The Blog Timer</strong> (this page)</td>
                        <td>Yes</td>
                        <td>15/25/45/90 + custom</td>
                        <td>No (browser-based)</td>
                        <td>Local session count</td>
                        <td>Quick, privacy-preserving sessions</td>
                    </tr>
                    <tr>
                        <td><strong>Forest</strong></td>
                        <td>Free tier + paid</td>
                        <td>10&ndash;120 minutes</td>
                        <td>Phone-side</td>
                        <td>Tree forest growth</td>
                        <td>Mobile focus, gamification</td>
                    </tr>
                    <tr>
                        <td><strong>Freedom</strong></td>
                        <td>Paid only</td>
                        <td>Time-window scheduling</td>
                        <td>Site/app block (strong)</td>
                        <td>Detailed sessions</td>
                        <td>Habitual distractions, multi-device</td>
                    </tr>
                    <tr>
                        <td><strong>Cold Turkey Blocker</strong></td>
                        <td>Free + Pro</td>
                        <td>Schedules and Pomodoros</td>
                        <td>Site/app block (uncircumventable)</td>
                        <td>Block stats</td>
                        <td>Severe willpower failure</td>
                    </tr>
                    <tr>
                        <td><strong>Be Focused</strong> (macOS/iOS)</td>
                        <td>Free + paid sync</td>
                        <td>Pomodoro variants</td>
                        <td>No</td>
                        <td>Tasks &amp; tags</td>
                        <td>Apple ecosystem Pomodoro</td>
                    </tr>
                    <tr>
                        <td><strong>Toggl Track</strong></td>
                        <td>Free + paid</td>
                        <td>Open-ended timer</td>
                        <td>No</td>
                        <td>Heavy time-tracking</td>
                        <td>Billable hours, freelancers</td>
                    </tr>
                    <tr>
                        <td><strong>Focus Keeper</strong></td>
                        <td>Free + paid</td>
                        <td>Pomodoro variants</td>
                        <td>No</td>
                        <td>Daily/weekly</td>
                        <td>Pure Pomodoro adherents</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- HOW TO USE -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">How to use the focus timer effectively</h2>
            <p class="section-subtitle">A six-step protocol grounded in the attention research above.</p>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Choose one task, write it down</h3>
                    <p>The act of writing the specific task externalizes the goal and reduces the cognitive load of holding it in working memory. "Work on report" is not a task. "Draft section 2 of the Q2 report" is.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Pick the right duration</h3>
                    <p>Use 15 or 25 minutes for procrastination-heavy starts. Use 45 minutes for sustained knowledge work after warm-up. Use 90 minutes for novel problem-solving when you can protect the block from interruption.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Pre-commit the environment</h3>
                    <p>Phone in another room or on Do Not Disturb. Browser tabs closed. Notifications off. Water nearby. These small frictions, removed in advance, compound into hours of preserved attention.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Start the timer; do not check it</h3>
                    <p>Checking the timer is itself a form of attention break. Trust the alarm. The whole reason to use an external timer is so your brain stops timekeeping.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <h3>If a distraction arrives, write it down</h3>
                    <p>A small notepad next to your workspace lets you capture interrupting thoughts without acting on them. The act of writing defers the urgency. You will return to the list during the break.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">6</div>
                    <h3>Take a real break</h3>
                    <p>Stand up. Walk. Look out a window. Do not scroll. Default mode network activation requires that you stop task-positive processing &mdash; checking email keeps the task network engaged and defeats the purpose.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMON MISTAKES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common focus timer mistakes</h2>
            <ul>
                <li><strong>Starting too long.</strong> Beginners often pick 90 minutes because it sounds impressive. The likelihood of breaking concentration in the first session is high, and the failure undermines the habit. Start at 25.</li>
                <li><strong>Switching tasks mid-block.</strong> The whole point is single-tasking. Sophie Leroy's research on "attention residue" shows that switching leaves cognitive remnants of the prior task that impair the new one for several minutes.</li>
                <li><strong>Skipping the break.</strong> Sustained work without recovery degrades subsequent sessions. The break is the recovery half of the cycle, not a luxury.</li>
                <li><strong>Working through "just one more thing".</strong> If you end at 25 minutes, end at 25 minutes. Disciplined endings train the brain to respect the boundary.</li>
                <li><strong>Treating the timer as a punishment.</strong> The timer is a commitment device, not a sentence. If a session goes poorly, log it honestly and reset.</li>
                <li><strong>Multitasking inside a block.</strong> Listening to a podcast while writing is two tasks, not one. The brain pays a switching cost even when you do not notice.</li>
                <li><strong>Ignoring biological readiness.</strong> Sleep debt, hunger, and high stress reduce attention capacity by measurable amounts. A focus timer cannot override an undernourished or undersrested brain.</li>
            </ul>
        </div>
    </section>

    <!-- FOCUS FOR DIFFERENT AUDIENCES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Focus timer use by audience</h2>

            <h3>Students</h3>
            <p>For exam preparation and study sessions, 25 to 50-minute blocks paired with our <a href="/study-timer">study timer</a> work best. Spaced practice research (Cepeda et al., 2006) shows that distributed sessions outperform massed study, so multiple focus blocks across a day or week beat one long marathon.</p>

            <h3>Knowledge workers</h3>
            <p>For analysts, engineers, and writers, the 45 to 90-minute block is the sweet spot. Schedule it during your peak cognitive window &mdash; most chronotypes peak two to four hours after wake. Defend the block from meetings and use the <a href="/pomodoro">Pomodoro timer</a> for shallower work later in the day.</p>

            <h3>Remote workers</h3>
            <p>Without the structure of an office, time can blur. A focus timer reintroduces explicit boundaries. Pair it with our <a href="/timer-for-remote-workers">remote-work timer guide</a> for context-shifting and end-of-day shutdown rituals.</p>

            <h3>ADHD</h3>
            <p>Adults with ADHD often experience time-blindness &mdash; abstract time does not register as a behavioral cue. A visible countdown converts time into a perceivable signal. Russell Barkley's framing of ADHD as an executive function disorder supports this. Start with shorter 15-minute blocks and build up; rigid 90-minute blocks can backfire.</p>

            <h3>Creative work</h3>
            <p>Writers, designers, and artists need warm-up time to enter flow. The 15-minute sprint is for overcoming resistance to start. The 45-minute block is for productive flow. The 90-minute block is for deep creative synthesis. Skip the 25 if you are already in motion.</p>
        </div>
    </section>

    <!-- WHAT TO DO IN BREAKS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What should you actually do during focus breaks?</h2>
            <p>Default mode network activation is what restores attention. Activities that maintain task-positive engagement &mdash; scrolling social media, checking email, watching a video clip &mdash; do not provide recovery. Effective breaks share three properties: they remove you from the work environment, they require minimal cognitive load, and they allow mind-wandering.</p>
            <ul>
                <li><strong>Walk.</strong> Even a 5-minute walk outside increases blood flow and supports memory consolidation. Walking while thinking has produced documented creative effects since Aristotle.</li>
                <li><strong>Stretch or do light mobility.</strong> Couple it with a <a href="/stretching-timer">stretching timer</a> for structure.</li>
                <li><strong>Look at distance.</strong> Long-distance focus relaxes ciliary muscles tightened by screen work and reduces eye strain.</li>
                <li><strong>Hydrate.</strong> Mild dehydration reduces cognitive performance, especially in long sessions.</li>
                <li><strong>Breathe deliberately.</strong> A 4-minute breathing exercise &mdash; box breathing, or 4-7-8 &mdash; downregulates sympathetic activation.</li>
                <li><strong>Stare out a window.</strong> Genuinely. The mental idle is the point.</li>
                <li><strong>Do not start another task.</strong> Reading work-adjacent material is not a break.</li>
            </ul>
            <p>Not sure how long to make the break itself? See our <a href="/guides/break-timers">guide to break timing</a> for micro-break, restorative-break, and study-break lengths.</p>
        </div>
    </section>

    <!-- RELATED TIMERS -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Related focus and productivity timers</h2>
            <div class="usecase-grid">
                <a class="card usecase-card" href="/pomodoro" style="text-decoration:none;">
                    <div class="usecase-card-icon">P</div>
                    <h3>Pomodoro Timer</h3>
                    <p>The classic 25/5 interval, with full session tracking and history.</p>
                </a>
                <a class="card usecase-card" href="/study-timer" style="text-decoration:none;">
                    <div class="usecase-card-icon">S</div>
                    <h3>Study Timer</h3>
                    <p>Spaced-practice intervals for exam prep and long-form learning.</p>
                </a>
                <a class="card usecase-card" href="/sprint-timer" style="text-decoration:none;">
                    <div class="usecase-card-icon">15</div>
                    <h3>Sprint Timer (15 min)</h3>
                    <p>Short, high-commitment bursts to break inertia and start hard tasks.</p>
                </a>
                <a class="card usecase-card" href="/study-work-timers" style="text-decoration:none;">
                    <div class="usecase-card-icon">H</div>
                    <h3>All Study &amp; Work Timers</h3>
                    <p>Hub of every productivity timer on the site.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Focus timer FAQ</h2>
            <?php
            $faqs = [
                ['q' => 'How long should a focus block be?', 'a' => 'For procrastination or warm-up, 15 to 25 minutes. For sustained knowledge work, 45 to 50 minutes. For deep cognitive synthesis, 90 minutes &mdash; one ultradian cycle. Match duration to task complexity and your current attention reserves.'],
                ['q' => 'Is the focus timer the same as a Pomodoro timer?', 'a' => 'A Pomodoro timer is a specific form of focus timer using the 25/5 ratio invented by Francesco Cirillo. A focus timer is the general category. The presets here include the classic Pomodoro plus longer deep-work and ultradian-aligned blocks.'],
                ['q' => 'What is the science behind 25-minute focus blocks?', 'a' => 'Vigilance research shows that sustained attention typically begins to decline after 20 to 30 minutes of continuous focus. The 25-minute interval falls inside the high-attention window and provides regular psychological closure (the Zeigarnik effect) that reduces cognitive load.'],
                ['q' => 'Does focus music help during a focus block?', 'a' => 'Mixed evidence. For familiar, low-novelty work, instrumental music or ambient noise can mask interruptions and aid focus. For novel cognitive work that requires verbal processing, music with lyrics typically reduces performance. Pink noise and binaural beats have weak but suggestive evidence.'],
                ['q' => 'How many focus blocks can a person sustain in a day?', 'a' => 'For deep work, research by Cal Newport and Anders Ericsson suggests three to four 90-minute blocks per day as a sustainable maximum for elite knowledge workers. Most people overestimate their capacity. Three high-quality blocks beat eight low-quality ones.'],
                ['q' => 'Should I track focus sessions over time?', 'a' => 'Yes. The session counter on this page increments locally. Tracking creates feedback that improves planning. Cirillo&rsquo;s original Pomodoro book treats the daily session count as the primary self-improvement metric &mdash; not output, not hours.'],
                ['q' => 'Can a focus timer help with ADHD?', 'a' => 'Yes &mdash; a visible countdown externalizes abstract time, which is a known area of executive-function difficulty in ADHD. Start with 10 to 15-minute blocks and build up, rather than starting at 25 or 45 minutes.'],
                ['q' => 'Does the timer keep running if I close the tab?', 'a' => 'No. This is a browser-side timer; closing or refreshing the page resets the active session. The session counter persists in your browser local storage between visits.'],
            ];
            echo blogtimer_render_faq($faqs);
            ?>
        </div>
    </section>

    <!-- CTA -->
    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>Pick a duration. Start the timer. Do the work.</h2>
                <p>Single-tasking, externalized commitment, deliberate breaks. The same principles that have governed expert attention for decades, packaged into a free browser timer.</p>
                <a href="#top" class="btn btn--primary btn--large">Start a Focus Block</a>
            </div>
        </div>
    </section>
</main>

<!-- ARTICLE SCHEMA -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Focus Timer &mdash; Science-Backed Concentration Intervals",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"},
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "mainEntityOfPage": "<?php echo esc_url(get_permalink()); ?>",
  "description": "A research-backed focus timer with 15, 25, 45, and 90-minute presets and session tracking. Built around Gloria Mark's interruption research, Cal Newport's deep work framework, and ultradian rhythm science."
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.querySelector('.focus-timer-widget');
    if (!widget) return;
    const display = widget.querySelector('.timer-display');
    const progressBar = widget.querySelector('.timer-progress-bar');
    const startBtn = widget.querySelector('.start-timer');
    const resetBtn = widget.querySelector('.reset-timer');
    const completeBanner = widget.querySelector('.timer-complete-banner');
    const presetButtons = document.querySelectorAll('.focus-preset');
    const countElement = document.querySelector('.focus-count-number');
    const resetCountBtn = document.querySelector('.reset-focus-sessions');
    const breakAlarm = document.getElementById('focus-break-alarm');

    let durationSec = 25 * 60;
    let remaining = durationSec;
    let intervalId = null;
    let running = false;
    let endTimestamp = null; // timestamp-based timing (survives tab sleep)

    function fmt(s) {
        const m = Math.floor(s / 60);
        const r = s % 60;
        return String(m).padStart(2, '0') + ':' + String(r).padStart(2, '0');
    }
    function render() {
        display.textContent = fmt(remaining);
        const pct = ((durationSec - remaining) / durationSec) * 100;
        progressBar.style.width = pct + '%';
    }
    function beep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const o = ctx.createOscillator();
            const g = ctx.createGain();
            o.connect(g); g.connect(ctx.destination);
            o.frequency.value = 880; o.type = 'sine';
            g.gain.setValueAtTime(0.001, ctx.currentTime);
            g.gain.exponentialRampToValueAtTime(0.25, ctx.currentTime + 0.02);
            g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.7);
            o.start(); o.stop(ctx.currentTime + 0.75);
        } catch (e) {}
    }
    function tick() {
        if (!running || !endTimestamp) return;
        remaining = Math.max(0, Math.ceil((endTimestamp - Date.now()) / 1000));
        render();
        if (window.BT) BT.title(fmt(remaining));
        if (remaining <= 0) {
            clearInterval(intervalId);
            running = false;
            endTimestamp = null;
            if (breakAlarm && breakAlarm.checked) beep();
            completeBanner.style.display = '';
            startBtn.style.display = '';
            resetBtn.style.display = 'none';
            if (window.BT) {
                BT.keepAwake(false);
                BT.title('');
                BT.announce('Focus session complete');
            }
            let c = parseInt(localStorage.getItem('focusSessions') || '0', 10);
            c++;
            localStorage.setItem('focusSessions', String(c));
            if (countElement) countElement.textContent = c;
            remaining = durationSec;
            render();
        }
    }
    function start() {
        if (running) return;
        running = true;
        startBtn.style.display = 'none';
        resetBtn.style.display = '';
        completeBanner.style.display = 'none';
        if (window.BT) BT.keepAwake(true);
        endTimestamp = Date.now() + remaining * 1000;
        intervalId = setInterval(tick, 250);
    }
    function reset() {
        clearInterval(intervalId);
        running = false;
        endTimestamp = null;
        remaining = durationSec;
        render();
        startBtn.style.display = '';
        resetBtn.style.display = 'none';
        completeBanner.style.display = 'none';
        if (window.BT) { BT.keepAwake(false); BT.title(''); }
    }
    startBtn.addEventListener('click', start);
    resetBtn.addEventListener('click', reset);

    // Keyboard: Space starts the session, R resets (standard tool guard set).
    document.addEventListener('keydown', function(e) {
        if (window.BT && BT.keysBlocked(e)) return;
        if (e.code === 'Space') { e.preventDefault(); if (!running) start(); }
        else if (e.code === 'KeyR') { e.preventDefault(); reset(); }
    });
    completeBanner.querySelector('.start-timer').addEventListener('click', function() {
        completeBanner.style.display = 'none';
        start();
    });
    presetButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const mins = parseInt(this.dataset.minutes, 10);
            durationSec = mins * 60;
            remaining = durationSec;
            render();
            reset();
            presetButtons.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
        });
    });
    if (countElement) {
        countElement.textContent = parseInt(localStorage.getItem('focusSessions') || '0', 10);
    }
    if (resetCountBtn) {
        resetCountBtn.addEventListener('click', function() {
            localStorage.setItem('focusSessions', '0');
            if (countElement) countElement.textContent = '0';
        });
    }
    render();
});
</script>

<?php get_footer(); ?>
