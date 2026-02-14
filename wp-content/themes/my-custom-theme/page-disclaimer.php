<?php
/**
 * Template Name: Disclaimer
 * Description: Website disclaimer page — AdSense compliance.
 */
get_header();
?>

<main class="content-page">
    <div class="container">

        <h1>Disclaimer</h1>
        <p class="page-updated">Last updated: <?php echo date('F j, Y'); ?></p>

        <section class="legal-section">
            <h2>General Disclaimer</h2>
            <p>The information provided on The Blog Timer (theblogtimer.com) is for general informational and educational purposes only. While we strive to keep the content accurate and up to date, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability, or availability of the information, products, services, or related graphics contained on this website for any purpose.</p>
            <p>Any reliance you place on such information is strictly at your own risk. In no event will we be liable for any loss or damage, including without limitation indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.</p>
        </section>

        <section class="legal-section">
            <h2>Timer Accuracy Disclaimer</h2>
            <p>The Blog Timer uses timestamp-based calculations to provide accurate countdown timers. However, timer accuracy depends on factors outside our control, including your device's system clock accuracy, browser implementation, operating system power management, and network conditions.</p>
            <p>While our timers are designed to be highly accurate for everyday use, they should not be relied upon as precision instruments for scientific, medical, legal, or safety-critical applications. For any situation where exact timing could affect health, safety, or legal outcomes, please use certified timing equipment.</p>
            <p>The Blog Timer is not responsible for any outcomes resulting from reliance on our timer tools, including but not limited to overcooked food, missed deadlines, or inaccurate interval training.</p>
        </section>

        <section class="legal-section">
            <h2>External Links Disclaimer</h2>
            <p>This website may contain links to external websites that are not provided or maintained by, or in any way affiliated with, The Blog Timer. Please note that we do not guarantee the accuracy, relevance, timeliness, or completeness of any information on these external websites.</p>
            <p>The inclusion of any links does not necessarily imply a recommendation or endorsement of the views expressed within them. We have no control over the nature, content, and availability of external sites.</p>
        </section>

        <section class="legal-section">
            <h2>Advertising Disclaimer</h2>
            <p>The Blog Timer may display advertisements provided by third-party advertising networks, including Google AdSense. These advertisements are clearly identified and separated from our editorial content.</p>
            <p>The presence of advertisements on our website does not constitute an endorsement, guarantee, or recommendation of the advertised products or services. We do not control the content of third-party advertisements and are not responsible for any claims made in those advertisements.</p>
            <p>Ad placements on our site are designed to be non-intrusive and clearly distinguishable from our timer tools and editorial content. If you believe an advertisement is misleading or inappropriate, please <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact us</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Affiliate Links Disclaimer</h2>
            <p>The Blog Timer may participate in affiliate marketing programs. This means we may earn a commission if you click on certain links and make a purchase, at no additional cost to you. Any affiliate relationships are disclosed where applicable.</p>
            <p>Our editorial content and timer tool recommendations are not influenced by affiliate relationships. We only recommend products and services that we believe provide genuine value to our users.</p>
        </section>

        <section class="legal-section">
            <h2>Content and Editorial Disclaimer</h2>
            <p>The articles, guides, and informational content on The Blog Timer are written based on research, personal experience, and publicly available information. This content is intended for educational and informational purposes and should not be construed as professional advice.</p>
            <p>For medical, fitness, nutritional, or health-related decisions, consult a qualified healthcare professional. For financial or legal decisions, consult a qualified professional in the relevant field. Our productivity and time management tips are general suggestions that may not suit every individual's circumstances.</p>
        </section>

        <section class="legal-section">
            <h2>"As Is" Provision</h2>
            <p>This website and its timer tools are provided on an "as is" and "as available" basis without any warranties of any kind. We do not warrant that the website will be uninterrupted, timely, secure, or error-free. We do not warrant that the results obtained from the use of our timer tools will be accurate or reliable.</p>
        </section>

        <section class="legal-section">
            <h2>Changes to This Disclaimer</h2>
            <p>We reserve the right to update or change this disclaimer at any time. Changes will be posted on this page with an updated revision date. Your continued use of the website after any changes constitutes acceptance of the updated disclaimer.</p>
        </section>

        <section class="legal-section">
            <h2>Contact</h2>
            <p>If you have questions about this disclaimer, please visit our <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact page</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Related Pages</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>">Terms of Service</a></li>
                <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
