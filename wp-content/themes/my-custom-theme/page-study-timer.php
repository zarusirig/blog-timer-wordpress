<?php
/**
 * Template Name: Study Timer Page
 * Description: Study timer with 25/50/90-min presets and a study log
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Study Timer &mdash; Built on Spaced Practice and Deliberate Practice Research</h1>
        <p class="page-intro">A study timer with 25, 50, and 90-minute presets and a local study log. Designed around what cognitive psychology and education research actually say about learning &mdash; not productivity folklore.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~16 min read &middot; References: Cepeda et al. (Psych. Bull. 2006), Ericsson et al. (1993)</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">A study timer structures learning into focused intervals separated by recovery breaks. Use 25 minutes for review and recall, 50 minutes for active learning of moderately difficult material, and 90 minutes for problem-solving or writing. The single best-documented learning principle &mdash; spaced practice (Cepeda et al. 2006, <em>Psychological Bulletin</em>) &mdash; says multiple shorter sessions distributed over days produce dramatically better retention than equivalent total time massed into one sitting. The timer enforces that distribution.</p>
        </div>
    </div>

    <!-- HERO STUDY TIMER -->
    <div class="container">
        <div class="timer-widget timer-widget--hero study-timer-widget"
             data-duration="1500"
             data-unit="minutes"
             data-value="25"
             data-mode="standard">
            <div class="timer-display">25:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Studying</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Study Session Logged!</h3>
                <p>Take a break before your next session.</p>
                <button class="btn btn--success start-timer">Start Another Session</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Study Duration Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary study-preset" data-minutes="25">
                    <strong>Recall</strong>
                    <span>25 minutes &mdash; review &amp; flashcards</span>
                </button>
                <button class="btn btn--secondary study-preset" data-minutes="50">
                    <strong>Active Learning</strong>
                    <span>50 minutes &mdash; new material</span>
                </button>
                <button class="btn btn--secondary study-preset" data-minutes="90">
                    <strong>Deep Study</strong>
                    <span>90 minutes &mdash; problems &amp; writing</span>
                </button>
            </div>
        </div>

        <!-- STUDY LOG -->
        <div class="card" style="margin-top:var(--space-5);padding:var(--space-5);">
            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:var(--space-3);">
                <h3 style="margin:0;">Today's Study Log</h3>
                <div style="display:flex;gap:var(--space-3);flex-wrap:wrap;">
                    <div><strong class="study-count-number">0</strong> sessions</div>
                    <div><strong class="study-total-min">0</strong> minutes</div>
                    <button class="btn btn--secondary reset-study-log">Reset Today</button>
                </div>
            </div>
            <ul class="study-log-list" style="margin:var(--space-4) 0 0;padding:0;list-style:none;"></ul>
            <p style="margin:var(--space-3) 0 0;font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);">Stored locally in your browser. Resets automatically each day.</p>
        </div>
    </div>

    <!-- WHAT IS A STUDY TIMER -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What is a study timer?</h2>
            <p>A study timer is a countdown clock designed to structure learning sessions. Unlike a generic timer, a study timer typically tracks session counts and total time to give learners feedback on cumulative effort. The fundamental purpose is not to make studying feel shorter but to make it feel finite. A defined endpoint reduces the cognitive load of holding "how long should I do this?" in working memory, freeing more capacity for the actual material.</p>

            <p>Effective study timers share three characteristics. First, they enforce a clear single-tasked block. Second, they prompt breaks rather than letting sessions run indefinitely. Third, they accumulate evidence of effort over time. The third point matters more than the other two: students who track total study minutes consistently outperform students who simply intend to study, because the visible record creates accountability and exposes the gap between intention and behavior.</p>

            <p>This tool implements all three properties. The hero timer enforces the block. The post-session banner prompts a break. The study log accumulates today's sessions and minutes, persisting in your browser between page reloads but resetting each new day so the log reflects current effort and not lifetime aggregates.</p>
        </div>
    </section>

    <!-- LEARNING SCIENCE -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What does learning science say about study duration?</h2>
            <p>The cognitive psychology of learning has produced unusually robust findings over the last fifty years. Most of them are inconvenient. The most effective study strategies are the ones that feel hardest while you are doing them.</p>

            <h3>Spaced practice (Cepeda 2006)</h3>
            <p>The single largest effect size in the learning literature is the spacing effect. A 2006 meta-analysis by Cepeda, Pashler, Vul, Wixted, and Rohrer in <em>Psychological Bulletin</em> (<a href="https://pubmed.ncbi.nlm.nih.gov/16719566/" target="_blank" rel="noopener nofollow">PMID 16719566</a>) reviewed 254 study comparisons and found that distributing study time across multiple sessions produced substantially better retention than massing the same total time into one session. The optimal inter-session gap depends on the retention interval &mdash; if you need to remember material in a week, study sessions about a day apart; if you need to remember in six months, gap them about a month apart. The practical implication: three 50-minute sessions across three days beat one 150-minute marathon. A study timer enforces the distribution by making each session a discrete unit.</p>

            <h3>Retrieval practice (Roediger and Karpicke 2006)</h3>
            <p>The second-largest finding is the testing effect &mdash; actively retrieving information from memory strengthens it more than re-reading or highlighting. Roediger and Karpicke's 2006 paper in <em>Psychological Science</em> showed that students who self-tested after an initial study session retained material substantially better than students who restudied for the same total time. This means a productive 25-minute study block usually contains active retrieval &mdash; flashcards, practice problems, blank-page recall &mdash; rather than passive review.</p>

            <h3>Deliberate practice (Ericsson 1993)</h3>
            <p>For skill acquisition, the foundational work is Anders Ericsson's 1993 paper "The Role of Deliberate Practice in the Acquisition of Expert Performance" in <em>Psychological Review</em>. Deliberate practice is effortful, specific, feedback-driven work aimed at improving a defined sub-skill at the edge of current ability. Ericsson's research on violinists, chess players, and athletes found that elite performers sustained roughly four hours of deliberate practice per day, in blocks of about 90 minutes, with substantial recovery between. The 90-minute preset on our study timer aligns with this finding.</p>

            <h3>Cognitive load (Sweller 1988)</h3>
            <p>John Sweller's cognitive load theory identifies three sources of mental effort during learning: intrinsic load (inherent difficulty of the material), extraneous load (poor presentation or distractions), and germane load (the productive effort of building schemas). A study timer reduces extraneous load by removing the meta-decision of when to stop and start, freeing capacity for germane load. Phones nearby, browser tabs open, and ambient music with lyrics all add extraneous load and reduce learning efficiency.</p>

            <h3>The Pomodoro Technique in study contexts</h3>
            <p>The original Pomodoro Technique was developed by Francesco Cirillo while he was an undergraduate at Guido Carli International University struggling to study. The 25-minute interval is well-suited to review-and-recall sessions, less so to deep problem-solving. Many students use a hybrid: <a href="/pomodoro/">Pomodoro blocks</a> for flashcards and revision, longer 50 or 90-minute blocks for problem sets and writing.</p>
        </div>
    </section>

    <!-- STUDY DURATIONS BY AGE -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Recommended study session lengths by age and stage</h2>
            <p class="section-subtitle">Attention capacity grows with age. These ranges reflect a synthesis of educational psychology research; individual variation is large.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Stage</th>
                        <th>Single Session</th>
                        <th>Daily Total</th>
                        <th>Best Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Elementary (ages 6&ndash;10)</td><td>10&ndash;20 min</td><td>30&ndash;60 min</td><td>Reading, flashcards, math facts</td></tr>
                    <tr><td>Middle school (ages 11&ndash;13)</td><td>20&ndash;30 min</td><td>60&ndash;90 min</td><td>Homework blocks, light note review</td></tr>
                    <tr><td>High school (ages 14&ndash;18)</td><td>25&ndash;50 min</td><td>90&ndash;180 min</td><td>Exam prep, problem sets, essays</td></tr>
                    <tr><td>Undergraduate</td><td>50&ndash;90 min</td><td>3&ndash;4 hours</td><td>Active learning, deep reading</td></tr>
                    <tr><td>Graduate / professional</td><td>90 min</td><td>3&ndash;4 hours of deliberate practice</td><td>Dissertation, board prep, research</td></tr>
                    <tr><td>Adult self-learner</td><td>25&ndash;50 min</td><td>30&ndash;90 min</td><td>Online courses, language learning</td></tr>
                </tbody>
            </table>
            <p style="margin-top:var(--space-4);font-size:0.875rem;color:var(--color-text-muted,#7c87a8);">If you study with younger learners, our <a href="/timer-for-kids/">kid-friendly timer</a> has a calmer interface and shorter default intervals.</p>
        </div>
    </section>

    <!-- ADHD CONSIDERATIONS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Study timer considerations for ADHD learners</h2>
            <p>Students with attention deficit hyperactivity disorder often experience what Russell Barkley calls "time-blindness" &mdash; abstract time does not function as a behavioral cue. A visible countdown converts time into a perceivable signal. This is one of the few productivity interventions with consistent ADHD-positive evidence.</p>
            <ul>
                <li><strong>Start short.</strong> Begin with 10 to 15-minute sessions even if 25 feels like a fair target. Successful completions train the habit; failed long sessions undermine it.</li>
                <li><strong>Pair with movement.</strong> Brief movement before a study block (a 5-minute walk, jumping jacks, stretching) raises norepinephrine and supports focus. Some learners benefit from movement during shallow review sessions &mdash; pacing while reviewing flashcards is a valid technique.</li>
                <li><strong>Pre-define the task.</strong> Open the textbook, lay out the materials, write the specific task on a sticky note before starting the timer. Activation energy is the hardest part of an ADHD study session.</li>
                <li><strong>Body-doubling.</strong> Studying alongside another focused person (in-person or via a video call with mics muted) reliably extends session length for many ADHD learners.</li>
                <li><strong>Honor the break.</strong> Skipping breaks because you finally feel focused is tempting. It also predicts a longer crash. Five-minute breaks every 25 minutes sustain longer total study time across the day.</li>
                <li><strong>Stimulant medication interaction.</strong> If you take ADHD medication, your peak focus window typically aligns with the drug's plasma curve. Schedule the 50 or 90-minute blocks inside that window and use 25-minute review blocks afterward.</li>
            </ul>
        </div>
    </section>

    <!-- HOW TO USE -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">How to run an effective study session</h2>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Identify the goal</h3>
                    <p>"Study biology" is not a goal. "Complete chapter 7 review questions" is. The specific endpoint determines whether the session was productive.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Choose the right duration</h3>
                    <p>Use 25 minutes for flashcards or review. Use 50 minutes for new material. Use 90 minutes for problem sets or essay writing. The 90-minute block aligns with ultradian rhythm research.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Set up the environment</h3>
                    <p>Phone in another room. Materials in front of you. Water nearby. The 2 minutes of setup save 20 minutes of mid-session distraction.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Start the timer; commit to the block</h3>
                    <p>Once the timer starts, you do not check your phone, your messages, or any other tab. If a thought arises, write it down on paper for the break.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <h3>Use active retrieval</h3>
                    <p>Re-reading is the least effective study technique. Cover the page and recall. Do practice problems. Explain to an imaginary student. Active retrieval beats passive review by a wide margin.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">6</div>
                    <h3>Take a real break</h3>
                    <p>Stand up, walk, hydrate. The break is when memory consolidation happens. Scrolling social media during the break sabotages that consolidation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPARISON: STUDY APPS -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">How study timer tools compare</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Free?</th>
                        <th>Presets</th>
                        <th>Session Log</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>The Blog Timer</strong> (this page)</td><td>Yes</td><td>25 / 50 / 90 + custom</td><td>Local daily log</td><td>Spaced practice study, ADHD-friendly</td></tr>
                    <tr><td><strong>Forest</strong></td><td>Free + paid</td><td>10&ndash;120 min</td><td>Tree forest</td><td>Mobile gamification</td></tr>
                    <tr><td><strong>Quizlet (study sessions)</strong></td><td>Free + paid</td><td>Flexible</td><td>Per-deck</td><td>Flashcard-driven study</td></tr>
                    <tr><td><strong>Notion + Pomodoro widget</strong></td><td>Free + paid</td><td>Pomodoro variants</td><td>Notes-integrated</td><td>Knowledge-management studiers</td></tr>
                    <tr><td><strong>Study Bunny / Flora</strong></td><td>Free + paid</td><td>Pomodoro variants</td><td>Streaks</td><td>Younger learners, gamification</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- COMMON MISTAKES -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common study timer mistakes</h2>
            <ul>
                <li><strong>Massing study at the last minute.</strong> The strongest learning-science result &mdash; the spacing effect &mdash; says you cannot make up for missed distribution by studying longer the day before. Three 50-minute sessions across three days beat one 150-minute cram.</li>
                <li><strong>Confusing re-reading with studying.</strong> Re-reading produces familiarity, which feels like learning. Retrieval produces actual retention. If the session does not include active recall, it is not study, it is review-theater.</li>
                <li><strong>Studying while half-distracted.</strong> Phone in pocket, group chat open, music with lyrics &mdash; each adds extraneous cognitive load. Sweller's research shows the effect is non-linear: the third distraction costs more than the first.</li>
                <li><strong>Treating long sessions as proof of work.</strong> A two-hour session that includes one hour of phone-checking is not a two-hour session. Honest accounting matters; the timer only matters if you respect it.</li>
                <li><strong>Skipping breaks during exam week.</strong> Sleep, breaks, and walks are what consolidate memory. Pulling all-night sessions during exam week reliably reduces performance the next day.</li>
                <li><strong>Studying without a defined task.</strong> "Open the textbook and figure it out" wastes the first 10 minutes of every session. The task should be written down before the timer starts.</li>
            </ul>
        </div>
    </section>

    <!-- RELATED TIMERS -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Related study and productivity timers</h2>
            <div class="usecase-grid">
                <a class="card usecase-card" href="/pomodoro/" style="text-decoration:none;">
                    <div class="usecase-card-icon">P</div>
                    <h3>Pomodoro Timer</h3>
                    <p>25/5 intervals for revision and flashcards.</p>
                </a>
                <a class="card usecase-card" href="/focus-timer/" style="text-decoration:none;">
                    <div class="usecase-card-icon">F</div>
                    <h3>Focus Timer</h3>
                    <p>15&ndash;90 minute focus blocks for deep work.</p>
                </a>
                <a class="card usecase-card" href="/timer-for-kids/" style="text-decoration:none;">
                    <div class="usecase-card-icon">K</div>
                    <h3>Kid-Friendly Timer</h3>
                    <p>Calmer interface and shorter intervals for young learners.</p>
                </a>
                <a class="card usecase-card" href="/study-work-timers/" style="text-decoration:none;">
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
            <h2 class="section-title">Study timer FAQ</h2>
            <?php
            $faqs = [
                ['q' => 'How long should a study session be?', 'a' => 'For review and recall, 25 minutes. For active learning of new material, 50 minutes. For problem sets, essay writing, and other deep cognitive work, 90 minutes. Match duration to task type rather than to availability.'],
                ['q' => 'Is the 25-minute Pomodoro the best study interval?', 'a' => 'Only for the right kind of work. Twenty-five minutes is ideal for flashcards, vocabulary review, and homework completion. For activities that require warm-up &mdash; mathematical problem-solving, essay drafting, programming &mdash; 50 to 90 minutes is more productive because the warm-up cost is paid only once per session.'],
                ['q' => 'What is spaced practice and why does it matter?', 'a' => 'Spaced practice means distributing study sessions across time rather than massing them. A 2006 meta-analysis by Cepeda and colleagues in Psychological Bulletin found that distributed study produces substantially better retention than massed study of the same total duration. The optimal gap between sessions scales with how long you need to remember the material.'],
                ['q' => 'Should I take a break every 25 minutes or work straight through?', 'a' => 'Breaks every 25 to 50 minutes outperform straight-through work for nearly all learners. Memory consolidation, default mode network activation, and physiological recovery all require brief rest. Working through breaks feels productive but consistently underperforms in retention studies.'],
                ['q' => 'Does the study log persist if I close the browser?', 'a' => 'Yes &mdash; today\'s sessions and total minutes are stored in your browser\'s local storage and persist across page reloads. The log resets each new day to reflect current effort. Clearing your browser data will erase the log.'],
                ['q' => 'How many study sessions can I sustain in a day?', 'a' => 'For most students, three to four 50-minute sessions or two to three 90-minute sessions per day is a sustainable maximum. Ericsson\'s research on elite performers suggests roughly four hours of deliberate practice as the upper ceiling before quality degrades sharply.'],
                ['q' => 'Is studying with music a good idea?', 'a' => 'For familiar review-type tasks, instrumental music can mask interruptions. For novel cognitive work requiring verbal processing &mdash; reading, writing, problem-solving with text &mdash; music with lyrics consistently reduces performance. Silence or low-volume ambient noise is the safest choice for deep study.'],
                ['q' => 'How is a study timer different from a Pomodoro timer?', 'a' => 'A Pomodoro timer locks the interval at 25 minutes with a 5-minute break. A study timer typically offers multiple presets (25, 50, 90) because different learning tasks have different optimal durations. The study timer also tracks total minutes and session counts to give learners feedback on cumulative effort.'],
            ];
            echo blogtimer_render_faq($faqs);
            ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>Pick a duration. Open the book. Start the timer.</h2>
                <p>Spaced practice, retrieval practice, deliberate practice. The three best-documented learning principles, embedded in a free study timer with a daily log.</p>
                <a href="#top" class="btn btn--primary btn--large">Start a Study Session</a>
            </div>
        </div>
    </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Study Timer &mdash; Spaced Practice and Deliberate Practice",
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
  "description": "A study timer with 25, 50, and 90-minute presets and a daily local study log. Built on spaced practice and deliberate practice research."
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.querySelector('.study-timer-widget');
    if (!widget) return;
    const display = widget.querySelector('.timer-display');
    const progressBar = widget.querySelector('.timer-progress-bar');
    const startBtn = widget.querySelector('.start-timer');
    const resetBtn = widget.querySelector('.reset-timer');
    const completeBanner = widget.querySelector('.timer-complete-banner');
    const presets = document.querySelectorAll('.study-preset');
    const countElement = document.querySelector('.study-count-number');
    const totalElement = document.querySelector('.study-total-min');
    const logList = document.querySelector('.study-log-list');
    const resetLogBtn = document.querySelector('.reset-study-log');

    let durationSec = 25 * 60;
    let remaining = durationSec;
    let intervalId = null;
    let running = false;
    let endTimestamp = null; // timestamp-based timing (survives tab sleep)

    function todayKey() {
        const d = new Date();
        return 'studyLog_' + d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }
    function loadLog() {
        try {
            const raw = localStorage.getItem(todayKey());
            return raw ? JSON.parse(raw) : [];
        } catch (e) { return []; }
    }
    function saveLog(arr) { localStorage.setItem(todayKey(), JSON.stringify(arr)); }
    function renderLog() {
        const arr = loadLog();
        countElement.textContent = arr.length;
        const total = arr.reduce(function(s, x) { return s + (x.minutes || 0); }, 0);
        totalElement.textContent = total;
        logList.innerHTML = '';
        arr.slice().reverse().forEach(function(entry) {
            const li = document.createElement('li');
            li.style.cssText = 'padding:var(--space-2) 0;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;justify-content:space-between;font-size:0.9375rem;';
            li.innerHTML = '<span>' + entry.minutes + '-minute session</span><span style="color:var(--color-text-muted,#7c87a8);">' + entry.time + '</span>';
            logList.appendChild(li);
        });
    }
    function fmt(s) {
        const m = Math.floor(s / 60);
        const r = s % 60;
        return String(m).padStart(2, '0') + ':' + String(r).padStart(2, '0');
    }
    function render() {
        display.textContent = fmt(remaining);
        progressBar.style.width = (((durationSec - remaining) / durationSec) * 100) + '%';
    }
    function beep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const o = ctx.createOscillator();
            const g = ctx.createGain();
            o.connect(g); g.connect(ctx.destination);
            o.frequency.value = 660; o.type = 'sine';
            g.gain.setValueAtTime(0.001, ctx.currentTime);
            g.gain.exponentialRampToValueAtTime(0.3, ctx.currentTime + 0.02);
            g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.9);
            o.start(); o.stop(ctx.currentTime + 1.0);
        } catch (e) {}
    }
    function tick() {
        if (!running || !endTimestamp) return;
        remaining = Math.max(0, Math.ceil((endTimestamp - Date.now()) / 1000));
        render();
        if (remaining <= 0) {
            clearInterval(intervalId);
            running = false;
            endTimestamp = null;
            beep();
            completeBanner.style.display = '';
            startBtn.style.display = '';
            resetBtn.style.display = 'none';
            const arr = loadLog();
            const now = new Date();
            arr.push({
                minutes: Math.round(durationSec / 60),
                time: String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0')
            });
            saveLog(arr);
            renderLog();
            remaining = durationSec;
        }
    }
    function start() {
        if (running) return;
        running = true;
        startBtn.style.display = 'none';
        resetBtn.style.display = '';
        completeBanner.style.display = 'none';
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
    }
    startBtn.addEventListener('click', start);
    resetBtn.addEventListener('click', reset);
    completeBanner.querySelector('.start-timer').addEventListener('click', function() { completeBanner.style.display = 'none'; start(); });
    presets.forEach(function(b) {
        b.addEventListener('click', function() {
            durationSec = parseInt(this.dataset.minutes, 10) * 60;
            remaining = durationSec;
            reset();
            presets.forEach(function(x) { x.classList.remove('active'); });
            this.classList.add('active');
        });
    });
    resetLogBtn.addEventListener('click', function() {
        localStorage.removeItem(todayKey());
        renderLog();
    });
    render();
    renderLog();
});
</script>

<?php get_footer(); ?>
