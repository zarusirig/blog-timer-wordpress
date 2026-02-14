<?php
/**
 * Template Name: Accessibility Statement
 * Description: Accessibility commitment and WCAG compliance statement.
 */
get_header();
?>

<main class="content-page">
    <div class="container">

        <h1>Accessibility Statement</h1>
        <p class="page-updated">Last updated: <?php echo date('F j, Y'); ?></p>

        <section class="legal-section">
            <h2>Our Commitment to Accessibility</h2>
            <p>The Blog Timer is committed to ensuring digital accessibility for people of all abilities. We strive to continually improve the user experience for everyone and apply the relevant accessibility standards to make our timer tools and content accessible to the widest possible audience.</p>
            <p>We believe that everyone deserves equal access to productivity tools, regardless of their abilities or the assistive technologies they use. This commitment is reflected in our design decisions, development practices, and ongoing accessibility improvements.</p>
        </section>

        <section class="legal-section">
            <h2>Conformance Status</h2>
            <p>We aim to conform to the Web Content Accessibility Guidelines (WCAG) 2.1 at Level AA. These guidelines explain how to make web content more accessible to people with disabilities and more user-friendly for everyone.</p>
            <p>While we strive for full compliance, we recognize that accessibility is an ongoing effort and some areas may not yet fully conform. We are actively working to identify and resolve any accessibility barriers.</p>
        </section>

        <section class="legal-section">
            <h2>Accessibility Features</h2>
            <p>The Blog Timer includes the following accessibility features:</p>

            <h3>Keyboard Navigation</h3>
            <ul>
                <li>All timer controls are fully keyboard accessible</li>
                <li>Keyboard shortcuts: <kbd>Space</kbd> to start/pause, <kbd>R</kbd> to reset, <kbd>F</kbd> for fullscreen, <kbd>Esc</kbd> to exit fullscreen</li>
                <li>Tab navigation works throughout the entire interface</li>
                <li>Clear focus indicators on all interactive elements</li>
            </ul>

            <h3>Screen Reader Support</h3>
            <ul>
                <li>Semantic HTML structure with proper heading hierarchy</li>
                <li>ARIA labels on interactive elements (buttons, navigation, timer controls)</li>
                <li>Meaningful link text that describes the destination</li>
                <li>Timer state changes are communicated through ARIA live regions where supported</li>
            </ul>

            <h3>Visual Accessibility</h3>
            <ul>
                <li>Sufficient color contrast ratios throughout the interface</li>
                <li>Large, clear timer display digits readable from a distance</li>
                <li>Fullscreen mode for maximum readability</li>
                <li>Responsive design that adapts to different screen sizes and zoom levels</li>
                <li>No content relies solely on color to convey information</li>
            </ul>

            <h3>Motor Accessibility</h3>
            <ul>
                <li>Large click/tap targets on timer buttons</li>
                <li>No time-limited interactions (except the timer itself, which is user-controlled)</li>
                <li>Single-click/tap actions for all primary functions</li>
            </ul>

            <h3>Cognitive Accessibility</h3>
            <ul>
                <li>Clean, distraction-minimized interface design</li>
                <li>Consistent navigation and layout across all pages</li>
                <li>Clear, simple language in all content</li>
                <li>Predictable behavior of interactive elements</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Audio and Alerts</h2>
            <p>Timer completion alerts use audio notifications. We recognize this may not be accessible to users who are deaf or hard of hearing. We provide the following alternatives:</p>
            <ul>
                <li>Visual completion banner displayed prominently when a timer ends</li>
                <li>Progress bar that shows remaining time visually</li>
                <li>Timer display that clearly shows 00:00 when complete</li>
                <li>Fullscreen mode provides a highly visible visual cue on completion</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Known Limitations</h2>
            <p>While we work toward full accessibility, we are aware of the following areas that may present challenges:</p>
            <ul>
                <li>Some older browsers may not support all ARIA attributes used by our timer controls</li>
                <li>Third-party content (such as advertisements) may not meet the same accessibility standards as our own content</li>
                <li>The real-time nature of countdown timers may create challenges for some screen reader configurations</li>
            </ul>
            <p>We are committed to addressing these limitations as technology and standards evolve.</p>
        </section>

        <section class="legal-section">
            <h2>Assistive Technology Compatibility</h2>
            <p>The Blog Timer is designed to be compatible with the following assistive technologies:</p>
            <ul>
                <li>Screen readers (NVDA, JAWS, VoiceOver, TalkBack)</li>
                <li>Screen magnification software</li>
                <li>Speech recognition software</li>
                <li>Keyboard-only navigation</li>
                <li>Browser accessibility extensions and plugins</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Feedback and Contact</h2>
            <p>We welcome your feedback on the accessibility of The Blog Timer. If you encounter accessibility barriers or have suggestions for improvement, please let us know:</p>
            <ul>
                <li><strong>Contact form:</strong> <a href="<?php echo esc_url(home_url('/contact/')); ?>">Visit our Contact page</a> and select "Bug Report" or "Feature Request"</li>
                <li><strong>Response time:</strong> We aim to respond to accessibility feedback within 5 business days</li>
            </ul>
            <p>When reporting accessibility issues, please include:</p>
            <ul>
                <li>The page URL where you encountered the issue</li>
                <li>A description of the problem</li>
                <li>The assistive technology and browser you were using</li>
                <li>Any suggestions for how we might resolve the issue</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Related Pages</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Us</a></li>
                <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">Frequently Asked Questions</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
