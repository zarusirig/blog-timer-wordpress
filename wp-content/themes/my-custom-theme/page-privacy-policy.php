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
            <h2>Cookies and Tracking Technologies</h2>
            <p>The Blog Timer uses the following types of cookies and tracking technologies:</p>

            <h3>Essential Cookies</h3>
            <p>These cookies are strictly necessary for the website to function properly. They include cookies for basic website functionality and your cookie consent preferences. These cannot be disabled.</p>

            <h3>Advertising Cookies</h3>
            <p>Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this website or other websites. Google's use of advertising cookies enables it and its partners to serve ads to you based on your visit to The Blog Timer and/or other sites on the Internet.</p>
            <p>Advertising cookies may include:</p>
            <ul>
                <li><strong>Google AdSense cookies:</strong> Used for ad delivery, personalization, measurement, and fraud prevention</li>
                <li><strong>DoubleClick cookies:</strong> Used by Google for ad targeting and frequency capping</li>
                <li><strong>Third-party ad network cookies:</strong> Other advertising partners may place cookies for ad relevance and performance tracking</li>
            </ul>

            <h3>Managing Your Cookie Preferences</h3>
            <p>You can manage your cookie preferences in the following ways:</p>
            <ul>
                <li><strong>Cookie consent banner:</strong> When you first visit our site, you can choose to accept or decline non-essential cookies</li>
                <li><strong>Google Ads Settings:</strong> You may opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener">Google Ads Settings</a></li>
                <li><strong>NAI opt-out:</strong> You may opt out of third-party vendor cookies by visiting the <a href="https://optout.networkadvertising.org/" target="_blank" rel="noopener">Network Advertising Initiative opt-out page</a></li>
                <li><strong>DAA opt-out:</strong> Visit <a href="https://optout.aboutads.info/" target="_blank" rel="noopener">aboutads.info</a> to opt out of interest-based advertising</li>
                <li><strong>Browser settings:</strong> Most browsers allow you to block or delete cookies through their settings</li>
            </ul>
            <p>Please note that opting out of advertising cookies does not mean you will no longer see ads; it means the ads you see may be less relevant to your interests.</p>
        </section>

        <section class="legal-section">
            <h2>localStorage</h2>
            <p>We use your browser's localStorage to save:</p>
            <ul>
                <li>Timer duration preferences</li>
                <li>Timer name labels</li>
                <li>Active timer state (so timers persist across page refreshes)</li>
                <li>Cookie consent preferences</li>
                <li>Pomodoro session count</li>
            </ul>
            <p>This data is stored entirely on your device and is never transmitted to our servers. You can clear it at any time through your browser settings.</p>
        </section>

        <section class="legal-section">
            <h2>Third-Party Services</h2>
            <p>We use or may use the following third-party services:</p>
            <ul>
                <li><strong>Google AdSense:</strong> For advertising. Google may collect data through cookies and similar technologies to serve personalized or non-personalized ads. See <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener">How Google uses information from sites that use its services</a>.</li>
                <li><strong>Google Fonts:</strong> For typography. Google may collect your IP address when fonts are loaded. See <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google's Privacy Policy</a>.</li>
                <li><strong>Content Delivery Networks (CDNs):</strong> To serve static assets efficiently.</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>GDPR Rights (European Economic Area)</h2>
            <p>If you are located in the European Economic Area (EEA), you have certain data protection rights under the General Data Protection Regulation (GDPR):</p>
            <ul>
                <li><strong>Right to access:</strong> You can request information about whether we process your personal data</li>
                <li><strong>Right to rectification:</strong> You can request correction of inaccurate personal data</li>
                <li><strong>Right to erasure:</strong> You can request deletion of your personal data</li>
                <li><strong>Right to restrict processing:</strong> You can request restriction of processing of your personal data</li>
                <li><strong>Right to data portability:</strong> You can request to receive your personal data in a structured, machine-readable format</li>
                <li><strong>Right to object:</strong> You can object to the processing of your personal data</li>
                <li><strong>Right to withdraw consent:</strong> You can withdraw your consent at any time by clearing your cookies or using the cookie consent controls on our site</li>
            </ul>
            <p>Since The Blog Timer stores user data primarily in localStorage on your device, you can exercise most of these rights directly by clearing your browser data. For server-side data inquiries, please <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact us</a>.</p>
        </section>

        <section class="legal-section">
            <h2>CCPA Rights (California Residents)</h2>
            <p>If you are a California resident, you have additional rights under the California Consumer Privacy Act (CCPA):</p>
            <ul>
                <li><strong>Right to know:</strong> You can request disclosure of the categories and specific pieces of personal information we collect</li>
                <li><strong>Right to delete:</strong> You can request deletion of personal information we have collected</li>
                <li><strong>Right to opt out:</strong> You can opt out of the sale of personal information. Note: We do not sell personal information in the traditional sense, but targeted advertising may constitute a "sale" under CCPA</li>
                <li><strong>Right to non-discrimination:</strong> We will not discriminate against you for exercising your CCPA rights</li>
            </ul>
            <p>To exercise your CCPA rights, please <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact us</a> or use the opt-out links provided in the Cookies section above.</p>
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
