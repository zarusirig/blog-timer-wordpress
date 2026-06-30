<?php
/**
 * Template Name: Egg Timer Page
 * Description: Kitchen egg timer with soft/medium/hard presets
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Egg Timer — Soft, Medium, and Hard-Boiled</h1>
        <p class="page-intro">Get perfectly cooked eggs every time. Set your egg timer by doneness level — from runny soft-boiled to firm hard-boiled.</p>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="360"
             data-unit="minutes"
             data-value="6"
             data-mode="standard">
            <div class="timer-display">6:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Egg Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Eggs Are Ready!</h3>
                <p>Move to an ice bath immediately to stop cooking.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Egg Doneness Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-4-minutes" class="btn btn--secondary">
                    <strong>Runny Soft-Boiled</strong>
                    <span>4 minutes</span>
                </a>
                <a href="/timer/set-timer-for-6-minutes" class="btn btn--secondary">
                    <strong>Soft-Boiled</strong>
                    <span>6 minutes</span>
                </a>
                <a href="/timer/set-timer-for-8-minutes" class="btn btn--secondary">
                    <strong>Medium-Boiled</strong>
                    <span>8 minutes</span>
                </a>
                <a href="/timer/set-timer-for-12-minutes" class="btn btn--secondary">
                    <strong>Hard-Boiled</strong>
                    <span>12 minutes</span>
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Boiled Egg Timing Guide</h2>
            <p>Egg cooking times vary based on egg size, starting temperature (cold from fridge vs. room temperature), and altitude. The times below are for large eggs starting from a cold fridge, placed into already-boiling water.</p>

            <table style="width:100%;border-collapse:collapse;margin:var(--space-6) 0;">
                <thead>
                    <tr style="border-bottom:2px solid var(--color-border);">
                        <th style="text-align:left;padding:var(--space-3);">Time</th>
                        <th style="text-align:left;padding:var(--space-3);">White</th>
                        <th style="text-align:left;padding:var(--space-3);">Yolk</th>
                        <th style="text-align:left;padding:var(--space-3);">Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);">
                        <td style="padding:var(--space-3);">4 minutes</td>
                        <td style="padding:var(--space-3);">Barely set</td>
                        <td style="padding:var(--space-3);">Completely runny</td>
                        <td style="padding:var(--space-3);">Dippy eggs, Ramen</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--color-border);">
                        <td style="padding:var(--space-3);">6 minutes</td>
                        <td style="padding:var(--space-3);">Fully set</td>
                        <td style="padding:var(--space-3);">Jammy, flowing</td>
                        <td style="padding:var(--space-3);">Ramen, salads, toast</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--color-border);">
                        <td style="padding:var(--space-3);">8 minutes</td>
                        <td style="padding:var(--space-3);">Firm</td>
                        <td style="padding:var(--space-3);">Mostly set, slightly soft center</td>
                        <td style="padding:var(--space-3);">Salads, slicing</td>
                    </tr>
                    <tr>
                        <td style="padding:var(--space-3);">12 minutes</td>
                        <td style="padding:var(--space-3);">Firm</td>
                        <td style="padding:var(--space-3);">Fully set, crumbly</td>
                        <td style="padding:var(--space-3);">Deviled eggs, egg salad</td>
                    </tr>
                </tbody>
            </table>

            <h2 class="section-title">Tips for Perfect Boiled Eggs</h2>

            <h3>Always Use the Ice Bath</h3>
            <p>When your timer goes off, immediately transfer eggs to a bowl of ice water. This stops the cooking process instantly and prevents the dreaded grey-green ring around the yolk (caused by iron sulfide forming when eggs are overcooked). Leave them in the ice bath for at least 2 minutes before peeling.</p>

            <h3>Start with Boiling Water</h3>
            <p>Lower eggs into already-boiling water rather than starting in cold water. This gives you precise timing control — the timer starts the moment the eggs hit the hot water. Use a slotted spoon to lower them gently to prevent cracking from the impact.</p>

            <h3>Room Temperature vs. Cold Eggs</h3>
            <p>Cold eggs straight from the refrigerator need about 1 extra minute compared to room-temperature eggs. If your eggs have been sitting on the counter for 30 minutes, subtract a minute from the times above. In warmer climates, eggs stored at room temperature cook slightly faster.</p>

            <h3>Altitude Adjustments</h3>
            <p>At high altitude (5,000+ feet), water boils at a lower temperature, so eggs take longer to cook. Add 1-2 minutes to all times above if you're cooking at altitude. At sea level, the times above are accurate for standard stovetop cooking at a rolling boil.</p>

            <h3>Easy Peeling Trick</h3>
            <p>Older eggs peel more easily than fresh ones. If you need perfectly peeled hard-boiled eggs for deviled eggs or a party platter, use eggs that are at least a week old. After the ice bath, crack the shell all over by rolling the egg on the counter, then peel under running cold water.</p>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
