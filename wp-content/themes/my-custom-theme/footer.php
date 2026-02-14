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
$privacy_url = $privacy_page ? get_permalink($privacy_page->ID) : home_url('/privacy-policy/');
$terms_url = $terms_page ? get_permalink($terms_page->ID) : home_url('/terms-of-service/');
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand-col">
                <a href="<?php echo esc_url(home_url('')); ?>" class="footer-brand">
                    <span>&#9201;</span>
                    <span><?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?></span>
                </a>
                <p>Free, precision online timers that work in any browser. No sign-ups and no downloads. Just accurate
                    countdowns from 1 second to 161 minutes, built for real-world tasks.</p>
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
                <h4>Timer Tools</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">Minute Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/second-timers/')); ?>">Second Timers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/pomodoro/')); ?>">Pomodoro Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-5-minutes/')); ?>">5 Minute Timer</a>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-10-minutes/')); ?>">10 Minute
                            Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/timer/set-timer-for-25-minutes/')); ?>">25 Minute
                            Timer</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Use Cases</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/#productivity')); ?>">Productivity</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/#cooking')); ?>">Cooking</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/#exercise')); ?>">Exercise</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/#meditation')); ?>">Meditation</a></li>
                    <li><a href="<?php echo esc_url(home_url('/use-cases/#studying')); ?>">Studying</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Guides</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">&copy; <?php echo date('Y'); ?>
                <?php echo esc_html(Timer_Content_Loader::get_instance()->get_string('brand.name') ?: 'The Blog Timer'); ?>.
                All rights reserved.
            </p>
            <div class="footer-bottom-links">
                <a href="<?php echo esc_url($privacy_url); ?>">Privacy Policy</a>
                <a href="<?php echo esc_url($terms_url); ?>">Terms of Service</a>
                <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a>
                <a href="<?php echo esc_url(home_url('/dmca/')); ?>">DMCA</a>
                <a href="<?php echo esc_url(home_url('/accessibility/')); ?>">Accessibility</a>
            </div>
        </div>
    </div>
</footer>

<button class="scroll-top" id="scroll-top" aria-label="Scroll to top">&#8593;</button>

<?php wp_footer(); ?>
</body>

</html>
