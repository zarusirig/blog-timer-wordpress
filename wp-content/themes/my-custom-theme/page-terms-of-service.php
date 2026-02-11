<?php
/**
 * Template Name: Terms of Service
 * Description: Terms of service page template.
 */
get_header();
$terms_usecase_url = blogtimer_get_term_url_by_slug('timer_usecase', 'productivity');
$terms_guide_cluster_url = blogtimer_get_term_url_by_slug('guide_cluster', 'accuracy');
?>

<main class="content-page">
    <div class="container">

        <h1>Terms of Service</h1>
        <p class="page-updated">Last updated:
            <?php echo date('F j, Y'); ?>
        </p>

        <section class="legal-section">
            <h2>Acceptance of Terms</h2>
            <p>By accessing and using The Blog Timer ("the Website"), you agree to be bound by these Terms of Service.
                If you do not agree with any part of these terms, please do not use the Website.</p>
        </section>

        <section class="legal-section">
            <h2>Description of Service</h2>
            <p>The Blog Timer provides free online timer tools including countdown timers, Pomodoro timers, and related
                utility tools. The service is provided "as is" without warranties of any kind.</p>
        </section>

        <section class="legal-section">
            <h2>Use of the Service</h2>
            <p>You agree to use The Blog Timer only for its intended purpose. You may not:</p>
            <ul>
                <li>Attempt to reverse engineer, modify, or exploit the Website's code.</li>
                <li>Use automated tools to scrape or collect data from the Website.</li>
                <li>Use the Website in any way that could disable, overburden, or impair our servers.</li>
                <li>Attempt to gain unauthorized access to any part of the Website.</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Accuracy &amp; Reliability</h2>
            <p>While we strive for accuracy, The Blog Timer relies on your device's clock and browser capabilities. We
                do not guarantee perfect timing precision. The timer should not be used for critical, safety-sensitive,
                or medical timing applications.</p>
        </section>

        <section class="legal-section">
            <h2>Intellectual Property</h2>
            <p>All content, design, and code on The Blog Timer are the property of The Blog Timer and are protected by
                copyright laws. You may not reproduce, distribute, or create derivative works without express written
                permission.</p>
        </section>

        <section class="legal-section">
            <h2>Limitation of Liability</h2>
            <p>In no event shall The Blog Timer, its owners, or contributors be liable for any direct, indirect,
                incidental, special, or consequential damages arising from your use of the Website or inability to use
                the Website.</p>
        </section>

        <section class="legal-section">
            <h2>Links to Third Parties</h2>
            <p>The Website may contain links to third-party websites. We are not responsible for the content or
                practices of any linked third-party sites.</p>
        </section>

        <section class="legal-section">
            <h2>Modifications</h2>
            <p>We reserve the right to modify these Terms of Service at any time. Continued use of the Website after
                changes constitutes acceptance of the updated terms.</p>
        </section>

        <section class="legal-section">
            <h2>Governing Law</h2>
            <p>These terms shall be governed by and construed in accordance with applicable laws, without regard to
                conflict of law principles.</p>
        </section>

        <section class="legal-section">
            <h2>Contact</h2>
            <p>For questions regarding these terms, please visit our <a
                    href="<?php echo home_url('/contact/'); ?>">Contact page</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Related Resources</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">Read usage and policy FAQs</a></li>
                <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Browse operational timer guides</a></li>
                <li><a href="<?php echo esc_url($terms_guide_cluster_url); ?>">Read timing accuracy guidance</a></li>
                <li><a href="<?php echo esc_url($terms_usecase_url); ?>">Open productivity timer use-case pages</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
