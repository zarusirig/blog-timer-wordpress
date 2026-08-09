<?php
/**
 * Template Name: Sprint Timer Page
 * Description: Focused work sprint timer for productivity and deep work
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Sprint Timer — Focused Work Sprints</h1>
        <p class="page-intro">Time-box your work into focused sprints with clear start and end points. Beat procrastination and build momentum with structured productivity intervals.</p>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="1500"
             data-unit="minutes"
             data-value="25"
             data-mode="standard">
            <div class="timer-display">25:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Sprint</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Sprint Complete!</h3>
                <p>Review what you accomplished, then take a short break.</p>
                <button class="btn btn--success start-timer">Start Another Sprint</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Sprint Duration Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-15-minutes" class="btn btn--secondary">
                    <strong>Quick Sprint</strong>
                    <span>15 minutes</span>
                </a>
                <a href="/timer/set-timer-for-25-minutes" class="btn btn--secondary">
                    <strong>Pomodoro Sprint</strong>
                    <span>25 minutes</span>
                </a>
                <a href="/timer/set-timer-for-45-minutes" class="btn btn--secondary">
                    <strong>Deep Sprint</strong>
                    <span>45 minutes</span>
                </a>
                <a href="/timer/set-timer-for-90-minutes" class="btn btn--secondary">
                    <strong>Ultradian Sprint</strong>
                    <span>90 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Is a Work Sprint?</h2>
            <p>A work sprint is a defined block of focused, uninterrupted work time — typically 15 to 90 minutes — during which you commit to a single task or project. The sprint has a clear beginning (the alarm starts) and end (the alarm fires), transforming vague "I should work on this" into a concrete, accountable commitment.</p>

            <p>The term comes from agile software development, where teams work in time-boxed "sprints" to produce deliverable output in a predictable cadence. Applied to individual productivity, a sprint timer helps you eliminate the two biggest obstacles to deep work: starting and stopping. The timer forces you to start now and guarantees you can stop when it rings.</p>

            <h2 class="section-title">Choosing Your Sprint Duration</h2>

            <h3>15-Minute Quick Sprint</h3>
            <p>The shortest sprint that's meaningful. A 15-minute sprint is perfect when you're procrastinating on a task and need to build momentum. Tell yourself: "Just 15 minutes." Once you start, the momentum usually carries you further. Ideal for email responses, quick edits, administrative tasks, or getting unstuck on a creative project.</p>

            <h3>25-Minute Pomodoro Sprint</h3>
            <p>The classic Pomodoro duration, 25 minutes sits in the sweet spot between long enough to make real progress and short enough to maintain urgency throughout. Pair with a 5-minute break and repeat 4 times for a full 2-hour morning work block. See our <a href="/pomodoro">Pomodoro Timer</a> for the full structured experience.</p>

            <h3>45-Minute Deep Sprint</h3>
            <p>For complex cognitive tasks — writing, analysis, coding, strategic planning — a 45-minute sprint provides enough uninterrupted time to get into a genuine flow state without the mental fatigue that comes from longer blocks. Research suggests 50 minutes is near the limit of peak cognitive performance before diminishing returns set in.</p>

            <h3>90-Minute Ultradian Sprint</h3>
            <p>Based on the body's natural ultradian rhythm, 90 minutes aligns with the natural cycle of alertness and rest that governs everything from sleep stages to waking attention. A 90-minute sprint followed by a 20-minute recovery break can unlock the highest levels of focused work output. Use this format for your most demanding creative or analytical projects.</p>

            <h2 class="section-title">The Sprint Protocol: Before, During, After</h2>

            <h3>Before the Sprint</h3>
            <p>Choose exactly one task or deliverable for the sprint. Write it down: "In this sprint, I will complete the first draft of the introduction." Vague goals like "work on the report" produce weak results. Specific, completable objectives produce strong ones. Set your timer before opening any files — the act of starting the timer is your commitment signal.</p>

            <h3>During the Sprint</h3>
            <p>If a thought, task, or distraction surfaces, write it on a "parking lot" list and return immediately to your task. The parking lot captures everything that would otherwise derail you while guaranteeing you won't forget it. Silence your phone, close unnecessary tabs, and let the ticking timer be the only thing competing for your attention.</p>

            <h3>After the Sprint</h3>
            <p>Take a genuine break — step away from the screen. Note one concrete thing you accomplished during the sprint. This reinforces the habit loop and gives you an honest record of what you produced. After 4 sprints, take a longer 30-minute break before your next block. The review habit is what separates sprint working from mere task management.</p>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
