<?php
/**
 * Template Name: Presentation Timer Page
 * Description: Timer for presentations, speeches, and public speaking practice
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Presentation Timer — Speaking and Speech Timer</h1>
        <p class="page-intro">Practice speeches, time presentations, and stay on schedule during talks. Full-screen timer with visual alerts for every presentation format.</p>
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
                <button class="btn btn--primary btn--large start-timer">Start Presentation</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Time's Up!</h3>
                <p>Wrap up your presentation and open for questions.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Common Presentation Formats</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary">
                    <strong>Lightning Talk</strong>
                    <span>5 minutes</span>
                </a>
                <a href="/timer/set-timer-for-10-minutes" class="btn btn--secondary">
                    <strong>Ignite / Pecha Kucha</strong>
                    <span>10 minutes</span>
                </a>
                <a href="/timer/set-timer-for-20-minutes" class="btn btn--secondary">
                    <strong>TED-Style Talk</strong>
                    <span>20 minutes</span>
                </a>
                <a href="/timer/set-timer-for-45-minutes" class="btn btn--secondary">
                    <strong>Full Conference Talk</strong>
                    <span>45 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Presentation Timing: Why Every Minute Counts</h2>
            <p>Running over time is one of the most damaging things a speaker can do. It signals poor preparation, disrespects the audience's schedule, and often means rushing through your most important points at the end when the audience is already mentally checking out. On the other hand, finishing well under time can feel anticlimactic and suggests weak content. The sweet spot: finish within the last 10% of your allotted time.</p>

            <p>Professional speakers use a simple rule: rehearse with a timer until you can consistently hit your target within 30 seconds, in both directions. If your 10-minute talk runs between 9:30 and 10:00 every rehearsal, you're ready. The timer doesn't just keep you honest during practice — it reveals which sections run long and need trimming before you're on stage.</p>

            <h2 class="section-title">Presentation Format Guide</h2>

            <h3>Lightning Talk (5 minutes)</h3>
            <p>Maximum 5 slides. One idea, one story, one clear takeaway. Lightning talks require ruthless editing — there's no room for context-setting or caveats. Open with your single strongest point, support it with one vivid example, and close with a crisp call to action. Five minutes is enough for a powerful, memorable message when used efficiently.</p>

            <h3>Pecha Kucha / Ignite Format (6-7 minutes)</h3>
            <p>These structured formats use 20 slides that auto-advance every 20 seconds (Pecha Kucha) or 15 seconds (Ignite). The rigid timing forces slides to serve as visual punctuation rather than bullet-point lists. Excellent for creative fields and conference environments where dozens of speakers need equal, controlled time slots.</p>

            <h3>TED-Style Talk (12-20 minutes)</h3>
            <p>The sweet spot for most conference presentations. TED talks cap at 18 minutes because research shows this is near the limit of unbroken audience attention for a single voice. Structure: hook (90 seconds), context (3 minutes), core idea development (10 minutes), call to action (2 minutes), closing line (30 seconds). Use the <a href="/timer/set-timer-for-18-minutes">18-minute timer</a> to practice.</p>

            <h3>Full Conference Session (45-60 minutes)</h3>
            <p>Extended presentations need internal time checkpoints. Use a 45-minute timer as your outer boundary and mentally mark when you should be at each section transition. A good structure: opening and agenda (3 min), main content in 3-4 segments (35 min), Q&A setup (2 min), Q&A (10 min). Always protect your Q&A time — it's where real audience engagement happens.</p>

            <h2 class="section-title">Practice Tips for Perfect Timing</h2>
            <ul>
                <li><strong>Record yourself.</strong> A video recording catches habits you can't observe live: filler words, pacing issues, and the sections where you unconsciously rush or drag.</li>
                <li><strong>Practice out loud.</strong> Mental rehearsal runs faster than verbal delivery. A talk that takes 8 minutes in your head usually takes 12 out loud.</li>
                <li><strong>Time each section separately.</strong> Know exactly how long your intro, middle, and conclusion each run so you can make surgical cuts when needed.</li>
                <li><strong>Build in buffer.</strong> Technical difficulties, introduction time, and audience laughter add 5-15% to your expected duration. Account for this in practice.</li>
            </ul>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
