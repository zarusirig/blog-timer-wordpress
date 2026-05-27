<?php
/**
 * Template Name: Timer for Kids Page
 * Description: Child-friendly timers for homework, chores, and screen time
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Timer for Kids — Homework, Chores, and Screen Time</h1>
        <p class="page-intro">Simple, visual timers that children can understand. Help kids manage homework time, household chores, and screen time limits with clear countdowns.</p>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="900"
             data-unit="minutes"
             data-value="15"
             data-mode="standard">
            <div class="timer-display">15:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Time's Up!</h3>
                <p>Great job! You made it through the whole timer.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Common Kids' Timer Durations</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary">
                    <strong>Clean-Up Time</strong>
                    <span>5 minutes</span>
                </a>
                <a href="/timer/set-timer-for-15-minutes" class="btn btn--secondary">
                    <strong>Homework Block</strong>
                    <span>15 minutes</span>
                </a>
                <a href="/timer/set-timer-for-20-minutes" class="btn btn--secondary">
                    <strong>Reading Time</strong>
                    <span>20 minutes</span>
                </a>
                <a href="/timer/set-timer-for-30-minutes" class="btn btn--secondary">
                    <strong>Screen Time</strong>
                    <span>30 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why Timers Help Children</h2>
            <p>Children, especially those under 10, struggle with abstract time concepts. "We're leaving in 20 minutes" means very little to a 6-year-old. A visual countdown timer transforms that abstract statement into something concrete and understandable — they can see the time shrinking and anticipate the endpoint. This reduces the "just one more minute" battles that exhaust parents and confuse kids.</p>

            <p>Timers also help children build self-regulation skills. When a child can see that 15 minutes of homework time is finite and will end regardless of whether they stall, the incentive to stall disappears. Researchers in child psychology have found that visual timers significantly reduce transition difficulties — the moments between one activity and the next that often trigger tantrums or resistance.</p>

            <h2 class="section-title">Best Uses for Kids' Timers</h2>

            <h3>Homework and Study Sessions (15-25 minutes)</h3>
            <p>Most children can sustain focused attention for 10-20 minutes before needing a mental reset. For younger children (ages 5-7), start with 10-minute homework blocks followed by 5-minute breaks. For older children (ages 8-12), 20-25 minute blocks work well — matching the Pomodoro technique. Set the timer together so the child is involved in the process rather than having time imposed on them.</p>

            <h3>Screen Time Limits (20-60 minutes)</h3>
            <p>A visible screen time timer eliminates the "but you said I could play for longer" argument. Set the agreed-upon limit before screens come on. When the timer rings, it's the timer's decision — not yours — that screen time is over. This removes the child's perception that the parent is arbitrarily interrupting their fun, significantly reducing conflict around screen time transitions.</p>

            <h3>Chore and Clean-Up Time (5-10 minutes)</h3>
            <p>The "clean-up race" is a classic parenting technique: set a 5-minute timer and challenge children to clean up as much as possible before it rings. This transforms chores from a dreaded obligation into a game with a clear endpoint. Even young children (ages 3-5) understand the game and often participate enthusiastically when a timer is involved.</p>

            <h3>Mindfulness and Calm-Down Time (3-5 minutes)</h3>
            <p>For children who need help managing big emotions, a "calm-down timer" provides a structured, time-limited cooling-off period. Three to five minutes in a quiet space gives the child's nervous system time to regulate while giving them a clear endpoint — they're not stuck in timeout indefinitely, just until the timer rings. This works better than open-ended time-outs because children understand it will end.</p>

            <h2 class="section-title">Age-Appropriate Timer Durations</h2>
            <ul>
                <li><strong>Ages 3-5:</strong> 2-5 minutes for any single activity. Attention spans are very short; frequent transitions keep engagement high.</li>
                <li><strong>Ages 6-8:</strong> 10-15 minutes per focused activity before a movement break. Reading, drawing, or puzzles can stretch longer.</li>
                <li><strong>Ages 9-12:</strong> 20-30 minute blocks with 5-10 minute breaks. Beginning to approach adult attention capacity for engaging tasks.</li>
                <li><strong>Teenagers:</strong> 25-45 minutes, similar to the Pomodoro technique used by adults for study and creative work.</li>
            </ul>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
