<?php
/**
 * Template Name: FAQ Page
 * Description: Frequently Asked Questions about The Blog Timer
 */

get_header();

// Load the content loader for dynamic FAQs
$loader = Timer_Content_Loader::get_instance();
$exercise_usecase_url = blogtimer_get_term_url_by_slug('timer_usecase', 'exercise');
$pomodoro_cluster_url = blogtimer_get_term_url_by_slug('guide_cluster', 'pomodoro');
?>

<main class="content-page">
    <div class="container">
        <h1 class="page-h1">Frequently Asked Questions</h1>

        <div class="page-intro">
            <p>Welcome to The Blog Timer FAQ page. Whether you're new to online timers or a seasoned productivity enthusiast, this comprehensive guide answers all your questions about using our free timer tools. From basic functionality to advanced features like the Pomodoro Technique, keyboard shortcuts, and technical specifications, we've compiled everything you need to know to get the most out of The Blog Timer. If you can't find the answer you're looking for, feel free to contact us through our support channels.</p>
        </div>

        <!-- General Timer Questions Section -->
        <section class="section">
            <h2 class="section-title">General Timer Questions</h2>

            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>How do I start a timer?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Starting a timer on The Blog Timer is incredibly simple. Navigate to any timer page (such as the 1-minute, 5-minute, or custom duration timers), and click the large "Start" button in the center of the timer interface. You can also use the spacebar as a keyboard shortcut to start the timer instantly. Once started, the timer will begin counting down from your selected duration, and you'll see the time decreasing in real-time on your screen. The interface is designed to be intuitive, so you can get started within seconds of visiting the page.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Can I run timers in the background?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, absolutely. The Blog Timer is designed to continue running even when the browser tab is in the background or minimized. The timer uses browser APIs that ensure accurate timekeeping regardless of tab focus. When your timer reaches zero, you'll receive both an audio alert and a browser notification (if you've granted notification permissions), ensuring you never miss the completion of your timer session. This makes it perfect for multitasking scenarios where you need to work on other tasks while keeping track of time.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Does the timer work if I switch tabs?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, the timer continues to function accurately even when you switch to different browser tabs or windows. Our timers are built with modern JavaScript that maintains precise timing in the background. The countdown continues uninterrupted, and when the timer completes, you'll hear the notification sound and see a browser notification (if enabled) to alert you. This feature is essential for productivity, allowing you to focus on your work in other tabs while the timer tracks your session duration. The timer state is preserved throughout your browsing session.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>How accurate are the timers?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>The Blog Timer uses high-precision JavaScript timing mechanisms to ensure accuracy within milliseconds. Our timers employ the requestAnimationFrame API combined with performance.now() timestamps, which provide far more accuracy than traditional setInterval methods. In practical terms, this means your timer will be accurate to within a fraction of a second over typical durations. We've optimized the code to compensate for browser throttling and system performance variations, ensuring that whether you're timing a 30-second exercise or a 2-hour work session, the timer remains reliably accurate throughout.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Can I name my timer or add custom labels?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Currently, The Blog Timer focuses on providing a clean, distraction-free timing experience without custom naming features. However, each timer page is already labeled with its specific duration and purpose (such as "5 Minute Timer" or "Pomodoro Timer"), which appears in your browser tab title. This makes it easy to identify which timer you're running when you have multiple tabs open. We're constantly evaluating user feedback and considering additional features like custom labels for future updates. For now, the streamlined interface ensures you can start timing immediately without any setup complexity.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>What happens when the timer ends?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>When your timer reaches zero, several things happen simultaneously to ensure you're properly notified. First, a pleasant audio alert plays (you can adjust your system volume to your preference). Second, if you've granted browser notification permissions, you'll receive a desktop notification that appears even if you're in a different tab or application. Third, the timer display shows "00:00" and the interface updates to indicate completion. Finally, the page title changes to alert you that time is up, which is visible in your browser tab. You can then choose to restart the timer, reset it, or close the page as needed.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Can I use a custom duration instead of preset times?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>While The Blog Timer offers a comprehensive range of preset durations (from 1 second to 60 minutes and beyond), we understand that sometimes you need specific custom times. Many of our timer pages include input fields where you can enter your exact desired duration in minutes and seconds. Simply enter your custom time and click "Start" to begin a personalized countdown. This flexibility makes our timers suitable for any scenario, whether you need a 7-minute workout timer, a 23-minute presentation timer, or a 90-minute focus session. The custom timer functionality gives you complete control over your time management.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Do I need to create an account to use the timers?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>No account is required. The Blog Timer is completely free and accessible without any registration, login, or personal information. Simply visit any timer page and start using it immediately. This approach respects your privacy and removes barriers to productivity. You don't need to remember passwords, verify email addresses, or manage account settings. Just bookmark your favorite timer pages for quick access whenever you need them. This commitment to accessibility and simplicity is core to our mission of providing hassle-free timing tools for everyone, whether you're a student, professional, athlete, or anyone who needs to track time effectively.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pomodoro Technique Questions Section -->
        <section class="section">
            <h2 class="section-title">Pomodoro Technique Questions</h2>

            <div class="page-intro">
                <p>The Pomodoro Technique is one of the most popular time management methods in the world, and The Blog Timer provides specialized tools to help you implement it effectively. Below are answers to the most common questions about using the Pomodoro method with our timers.</p>
            </div>

            <?php
            $pomodoro_faqs = $loader->get_pomodoro_faqs();
            if (!empty($pomodoro_faqs)) {
                blogtimer_render_faq($pomodoro_faqs);
            }
            ?>

            <div class="highlight-box highlight-box--accent">
                <h3>Ready to boost your productivity?</h3>
                <p>Try our dedicated <a href="<?php echo home_url('/pomodoro/'); ?>">Pomodoro Timer</a> with automatic work and break intervals, session tracking, and audio notifications to keep you on schedule.</p>
            </div>
        </section>

        <!-- Technical Questions Section -->
        <section class="section">
            <h2 class="section-title">Technical Questions</h2>

            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>What browsers are supported?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>The Blog Timer works on all modern web browsers, including Google Chrome, Mozilla Firefox, Microsoft Edge, Safari, Opera, and Brave. We use standard web technologies (HTML5, CSS3, and vanilla JavaScript) that are supported across all major browser platforms. For the best experience, we recommend using the latest version of your preferred browser. Mobile browsers are also fully supported, including Chrome Mobile, Safari iOS, and Samsung Internet. The responsive design automatically adapts to your screen size, whether you're on a desktop computer, laptop, tablet, or smartphone, ensuring a consistent and reliable timing experience across all devices.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Does the timer use cookies or track my data?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>The Blog Timer respects your privacy completely. We do not use tracking cookies, analytics cookies, or any form of personal data collection through the timer functionality itself. The timers run entirely in your browser using client-side JavaScript, meaning all timer operations happen locally on your device without sending any information to our servers. We may use basic analytics to understand general site traffic patterns, but this does not track your individual timer usage or personal information. Your timing sessions, preferences, and patterns remain completely private to you. We believe productivity tools should enhance your work without compromising your privacy.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Can I use this timer on my mobile phone or tablet?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely. The Blog Timer is fully optimized for mobile devices and tablets. The responsive design automatically adjusts the timer interface to fit your screen size perfectly, whether you're using a smartphone, tablet, or any other mobile device. Touch controls work seamlessly, allowing you to start, pause, and reset timers with simple taps. The timers continue running even when your phone screen locks (as long as the browser tab remains open), and you'll receive audio and notification alerts when the timer completes. This makes our timers perfect for workouts, cooking, meditation, studying on the go, or any mobile timing needs you might have.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Does the timer work offline or without an internet connection?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Once you load a timer page, it will continue to function even if you lose your internet connection, because the timer logic runs entirely in your browser's JavaScript engine without requiring server communication. However, you do need an internet connection to initially load the page. For full offline functionality, we recommend bookmarking your favorite timer pages, and many modern browsers will cache the resources for faster subsequent loading. If you frequently work in environments with unreliable internet, consider loading the timer page before disconnecting. The timer doesn't depend on continuous connectivity, making it reliable for use in various situations where internet access may be intermittent.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Why does my timer reset when I close the browser or refresh the page?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>The timer resets upon page refresh or browser closure because it operates as a session-based tool that doesn't store state between visits. This design choice ensures simplicity and privacy, as no data about your timing sessions is saved or tracked. Each time you load a timer page, you start with a fresh timer ready to use. While this means active timers won't survive a page refresh, it also means your timing data never leaves your device or gets stored in databases. If you need persistent timing across sessions, we recommend avoiding page refreshes while a timer is active, and using the pause feature if you need to briefly step away from your device.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q:</span>
                        <h3>Is my timer data stored on your servers or in the cloud?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>No, absolutely not. The Blog Timer operates entirely within your web browser using client-side JavaScript technology. When you start, pause, or reset a timer, all of these actions happen locally on your device without any data being sent to our servers or stored in any cloud database. This architecture provides several benefits: your timing sessions remain completely private, the timers work incredibly fast because there's no network latency, and your data never risks being exposed or breached. We've intentionally designed the timers this way to maximize both performance and privacy. Your productivity data belongs to you alone, and we have no access to it whatsoever.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Keyboard Shortcuts Section -->
        <section class="section">
            <h2 class="section-title">Keyboard Shortcuts Reference</h2>

            <div class="page-intro">
                <p>Power users can control The Blog Timer more efficiently using keyboard shortcuts. These shortcuts work on all timer pages and help you manage your timing sessions without reaching for the mouse. Master these commands to streamline your productivity workflow.</p>
            </div>

            <div class="highlight-box">
                <h3>Available Keyboard Commands</h3>
                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span class="faq-icon">KEY:</span>
                            <h3>Spacebar - Start or Pause Timer</h3>
                        </div>
                        <div class="faq-answer">
                            <p>Press the spacebar to start a stopped timer or pause a running timer. This is the most frequently used shortcut and provides quick toggle control without moving your hands from the keyboard. Works identically to clicking the main Start/Pause button on the timer interface.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span class="faq-icon">KEY:</span>
                            <h3>R - Reset Timer</h3>
                        </div>
                        <div class="faq-answer">
                            <p>Press the 'R' key to instantly reset the timer back to its original starting duration. This works whether the timer is running, paused, or completed. It's particularly useful when you want to restart a session quickly without using the mouse to click the reset button.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span class="faq-icon">KEY:</span>
                            <h3>F - Enter Fullscreen Mode</h3>
                        </div>
                        <div class="faq-answer">
                            <p>Press 'F' to expand the timer to fullscreen mode, hiding all browser interface elements and maximizing the timer display. This is perfect for presentations, workouts, or any situation where you want the timer to be highly visible. The large display helps you track time from across a room.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <span class="faq-icon">KEY:</span>
                            <h3>Escape - Exit Fullscreen Mode</h3>
                        </div>
                        <div class="faq-answer">
                            <p>Press the 'Escape' key to exit fullscreen mode and return to normal browser view. This immediately restores the browser interface while keeping your timer running uninterrupted. You can also exit fullscreen by pressing 'F' again, giving you flexibility in how you control the display mode.</p>
                        </div>
                    </div>
                </div>

                <p style="margin-top: 20px;"><strong>Pro Tip:</strong> Combine these shortcuts for maximum efficiency. For example, press 'F' to go fullscreen, then Spacebar to start your timer, all without touching your mouse. These shortcuts work consistently across all timer durations and types on The Blog Timer.</p>
            </div>
        </section>

        <!-- Additional Information Section -->
        <section class="section">
            <h2 class="section-title">Still Have Questions?</h2>

            <div class="page-intro">
                <p>We've covered the most common questions about The Blog Timer, but if you have additional questions or need support, we're here to help. Our timer tools are designed to be intuitive and user-friendly, but we understand that everyone has unique needs and use cases. Whether you're using our timers for professional productivity, academic studying, fitness training, cooking, meditation, or any other purpose, we want to ensure you have the best possible experience.</p>

                <p>If you've encountered a technical issue, have a feature suggestion, or simply want to share how you're using The Blog Timer, please don't hesitate to reach out through our <a href="<?php echo home_url('/contact/'); ?>">contact page</a>. We actively read and respond to all user feedback, and many of our best features have come directly from user suggestions. Your input helps us continuously improve and expand our timer offerings to serve the community better.</p>
            </div>

            <div class="highlight-box highlight-box--accent">
                <h3>Explore Our Timer Collection</h3>
                <p>The Blog Timer offers dozens of preset timers for every need, from quick 1-second timers to extended 60-minute sessions. Browse our complete collection of <a href="<?php echo home_url('/second-timers/'); ?>">second timers</a> and <a href="<?php echo home_url('/minute-timers/'); ?>">minute timers</a> to find the perfect duration for your specific task. Each timer is optimized for instant loading and reliable performance.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Quick Internal Links</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Browse the full timer guides archive</a></li>
                <li><a href="<?php echo esc_url($pomodoro_cluster_url); ?>">Read Pomodoro-specific guide cluster pages</a></li>
                <li><a href="<?php echo esc_url(home_url('/timer-unit/minutes/')); ?>">Open the minute timer taxonomy archive</a></li>
                <li><a href="<?php echo esc_url(home_url('/timer-unit/seconds/')); ?>">Open the second timer taxonomy archive</a></li>
                <li><a href="<?php echo esc_url($exercise_usecase_url); ?>">View exercise timer use-case pages</a></li>
            </ul>
        </section>

        <!-- Call-to-Action Banner -->
        <section class="section">
            <div class="cta-banner">
                <h2>Start Using The Blog Timer Today</h2>
                <p>No registration required. No downloads needed. Just simple, accurate, and reliable online timers that work anywhere, anytime. Choose from our extensive collection of preset timers or create your own custom duration. Whether you need a quick 30-second timer or a comprehensive Pomodoro session manager, The Blog Timer has you covered. Join thousands of users who rely on our timers every day for productivity, fitness, cooking, studying, and more.</p>
                <a href="<?php echo home_url(''); ?>" class="btn btn--primary btn--large">Browse All Timers</a>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
