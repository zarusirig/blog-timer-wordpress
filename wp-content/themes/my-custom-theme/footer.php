<?php
$privacy_candidates = get_posts([
    'post_type' => 'page',
    'name' => 'privacy-policy',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'no_found_rows' => true,
]);
if (empty($privacy_candidates)) {
    $privacy_candidates = get_posts([
        'post_type' => 'page',
        'name' => 'privacy-policy-2',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'no_found_rows' => true,
    ]);
}

$terms_candidates = get_posts([
    'post_type' => 'page',
    'name' => 'terms-of-service',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'no_found_rows' => true,
]);

$privacy_page = !empty($privacy_candidates) ? $privacy_candidates[0] : null;
$terms_page = !empty($terms_candidates) ? $terms_candidates[0] : null;
$privacy_url = $privacy_page ? get_permalink($privacy_page->ID) : home_url('/privacy-policy');
$terms_url = $terms_page ? get_permalink($terms_page->ID) : home_url('/terms-of-service');
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand-col">
                <a href="<?php echo esc_url(home_url('')); ?>" class="footer-brand">
                    <span class="brand-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2"/><path d="M9 2h6"/><path d="M12 5V2"/></svg></span>
                    <span><?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?></span>
                </a>
                <p>Evidence-based timing for focus, deep work, study, cooking, and more. Free, precision online timers
                    that run in any browser&mdash;no sign-ups, no downloads&mdash;plus research-backed guides on how long
                    to do things. Accurate countdowns from 1 second to 161 minutes, built for real-world tasks.</p>
                <div class="footer-stats">
                    <div class="footer-stat">
                        <span class="footer-stat-value">220+</span>
                        <span class="footer-stat-label">Timers</span>
                    </div>
                    <div class="footer-stat">
                        <span class="footer-stat-value">Fast</span>
                        <span class="footer-stat-label">Load Speed</span>
                    </div>
                    <div class="footer-stat">
                        <span class="footer-stat-value">100%</span>
                        <span class="footer-stat-label">Free</span>
                    </div>
                </div>
            </div>

            <div class="footer-col">
                <p class="footer-heading">Timer Tools</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers')); ?>">Minute Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/second-timers')); ?>">Second Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/pomodoro')); ?>">Pomodoro Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-5-minutes')); ?>">5 Minute Timer</a>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-10-minutes')); ?>">10 Minute
                            Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-25-minutes')); ?>">25 Minute
                            Timer</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <p class="footer-heading">Use Cases</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/use-cases#productivity')); ?>">Productivity</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases#cooking')); ?>">Cooking</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases#exercise')); ?>">Exercise</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases#meditation')); ?>">Meditation</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases#studying')); ?>">Studying</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <p class="footer-heading">Resources</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guides')); ?>">Guides</a></li>
                    <li><a href="<?php echo esc_url(home_url('/focus-timer')); ?>">Deep Work &amp; Focus Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/study-timer')); ?>">Study Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/methodology')); ?>">Methodology</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources')); ?>">Sources</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy')); ?>">Editorial Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq')); ?>">FAQ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <p class="footer-heading">Guides by Topic</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/animals')); ?>">Animal Lifespans &amp; Pregnancy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/travel')); ?>">Best Time to Visit</a></li>
                    <li><a href="<?php echo esc_url(home_url('/auto')); ?>">Car &amp; Auto Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/beauty')); ?>">Beauty &amp; Self-Care</a></li>
                    <li><a href="<?php echo esc_url(home_url('/science')); ?>">Space &amp; Science</a></li>
                    <li><a href="<?php echo esc_url(home_url('/body')); ?>">Body &amp; Frequency</a></li>
                    <li><a href="<?php echo esc_url(home_url('/health')); ?>">Healing &amp; Recovery</a></li>
                    <li><a href="<?php echo esc_url(home_url('/craft')); ?>">Craft &amp; Fermentation</a></li>
                    <li><a href="<?php echo esc_url(home_url('/gardening')); ?>">Gardening Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/household')); ?>">Household Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/parenting')); ?>">Parenting &amp; Baby Sleep</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <p class="footer-heading">Timer Categories</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/pomodoro')); ?>">Focus &amp; Productivity Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers')); ?>">Minute &amp; Second Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/hour-timers')); ?>">Hour Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/cooking-timers')); ?>">Cooking Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/workout-timers')); ?>">Workout &amp; Interval Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sleep-meditation-timers')); ?>">Sleep &amp; Meditation Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/stopwatch-clock-tools')); ?>">Stopwatch &amp; Clock Tools</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">&copy; <?php echo date('Y'); ?>
                <?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?>.
                All rights reserved.
            </p>
            <div class="footer-bottom-links">
                <a href="<?php echo esc_url(home_url('/site-index')); ?>">Site Index</a>
                <a href="<?php echo esc_url($privacy_url); ?>">Privacy Policy</a>
                <a href="<?php echo esc_url($terms_url); ?>">Terms of Service</a>
                <a href="<?php echo esc_url(home_url('/disclaimer')); ?>">Disclaimer</a>
                <a href="<?php echo esc_url(home_url('/dmca')); ?>">DMCA</a>
                <a href="<?php echo esc_url(home_url('/accessibility')); ?>">Accessibility</a>
            </div>
        </div>
    </div>
</footer>

<button class="scroll-top" id="scroll-top" aria-label="Scroll to top">&#8593;</button>

<?php wp_footer(); ?>
</body>

</html>
