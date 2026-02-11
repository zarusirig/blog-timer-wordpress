<?php
/**
 * Template Name: Privacy Policy
 * Description: Privacy policy page template.
 */
get_header();
$loader = Timer_Content_Loader::get_instance();
$privacy_faq_url = home_url('/faq/');
$privacy_guide_cluster_url = blogtimer_get_term_url_by_slug('guide_cluster', 'accuracy');
?>

<main class="content-page">
    <div class="container">

        <h1>Privacy Policy</h1>
        <p class="page-updated">Last updated:
            <?php echo date('F j, Y'); ?>
        </p>

        <section class="legal-section">
            <h2>Information We Collect</h2>
            <p>The Blog Timer is designed to be privacy-friendly. We do not require account creation, and we do not
                collect personal information.</p>
            <ul>
                <li><strong>Timer Data:</strong> Timer settings and state are stored locally in your browser via
                    localStorage. This data never leaves your device.</li>
                <li><strong>Analytics and Advertising:</strong> Depending on your region and consent choices, we may
                    use analytics or advertising integrations to operate and improve the service.</li>
                <li><strong>Server Logs:</strong> Our web server automatically collects standard log data including IP
                    addresses, browser type, and pages visited. These logs are retained for security and operational
                    purposes only.</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Cookies</h2>
            <p>The Blog Timer uses minimal cookies:</p>
            <ul>
                <li><strong>Essential cookies:</strong> Required for basic website functionality.</li>
                <li><strong>Advertising cookies (where applicable):</strong> If ads are enabled, consented users may
                    receive cookies used for ad delivery, measurement, and fraud prevention.</li>
            </ul>
            <p>Where required, consent choices are collected before ad requests are sent.</p>
        </section>

        <section class="legal-section">
            <h2>localStorage</h2>
            <p>We use your browser's localStorage to save:</p>
            <ul>
                <li>Timer duration preferences</li>
                <li>Timer name labels</li>
                <li>Active timer state (so timers persist across page refreshes)</li>
            </ul>
            <p>This data is stored entirely on your device and is never transmitted to our servers. You can clear it at
                any time through your browser settings.</p>
        </section>

        <section class="legal-section">
            <h2>Third-Party Services</h2>
            <p>We may use the following third-party services:</p>
            <ul>
                <li><strong>Google Fonts:</strong> For typography. Google may collect your IP address when fonts are
                    loaded. See <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google's
                        Privacy Policy</a>.</li>
                <li><strong>Content Delivery Networks (CDNs):</strong> To serve static assets efficiently.</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Children's Privacy</h2>
            <p>Our website is suitable for general audiences and does not knowingly collect information from children
                under 13. If you are a parent and believe your child has provided personal information, please contact
                us.</p>
        </section>

        <section class="legal-section">
            <h2>Changes to This Policy</h2>
            <p>We may update this privacy policy from time to time. Changes will be posted on this page with an updated
                revision date.</p>
        </section>

        <section class="legal-section">
            <h2>Contact</h2>
            <p>If you have questions about this privacy policy, please visit our <a
                    href="<?php echo home_url('/contact/'); ?>">Contact page</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Related Resources</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url($privacy_faq_url); ?>">Read timer privacy and usage FAQs</a></li>
                <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Browse timer setup and troubleshooting guides</a></li>
                <li><a href="<?php echo esc_url($privacy_guide_cluster_url); ?>">Open timer accuracy guide cluster pages</a></li>
                <li><a href="<?php echo esc_url(home_url('/timer-unit/minutes/')); ?>">Browse minute timer archive pages</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
