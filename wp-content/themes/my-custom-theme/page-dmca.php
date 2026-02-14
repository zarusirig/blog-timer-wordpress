<?php
/**
 * Template Name: DMCA Policy
 * Description: DMCA copyright notice and takedown procedure.
 */
get_header();
?>

<main class="content-page">
    <div class="container">

        <h1>DMCA Policy</h1>
        <p class="page-updated">Last updated: <?php echo date('F j, Y'); ?></p>

        <section class="legal-section">
            <h2>Digital Millennium Copyright Act Notice</h2>
            <p>The Blog Timer (theblogtimer.com) respects the intellectual property rights of others and expects its users to do the same. In accordance with the Digital Millennium Copyright Act of 1998 (DMCA), we will respond promptly to claims of copyright infringement committed using our website.</p>
            <p>If you believe that your copyrighted work has been copied in a way that constitutes copyright infringement and is accessible on this site, you may notify our copyright agent as set forth in this policy.</p>
        </section>

        <section class="legal-section">
            <h2>Filing a DMCA Takedown Notice</h2>
            <p>To file a notice of claimed copyright infringement, you must provide a written communication that includes substantially the following information (please confirm these requirements with your legal counsel, or see Section 512(c)(3) of the Copyright Act to confirm these requirements):</p>
            <ol>
                <li><strong>Physical or electronic signature</strong> of a person authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.</li>
                <li><strong>Identification of the copyrighted work</strong> claimed to have been infringed, or if multiple copyrighted works at a single online site are covered by a single notification, a representative list of such works at that site.</li>
                <li><strong>Identification of the material</strong> that is claimed to be infringing or to be the subject of infringing activity, and that is to be removed or access to which is to be disabled, and information reasonably sufficient to permit us to locate the material. Providing URLs in the body of the notice is the best way to help us locate content quickly.</li>
                <li><strong>Contact information</strong> reasonably sufficient to permit us to contact the complaining party, such as an address, telephone number, and, if available, an email address at which the complaining party may be contacted.</li>
                <li><strong>A statement that the complaining party has a good faith belief</strong> that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law.</li>
                <li><strong>A statement that the information</strong> in the notification is accurate, and under penalty of perjury, that the complaining party is authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.</li>
            </ol>
        </section>

        <section class="legal-section">
            <h2>Counter-Notification</h2>
            <p>If you believe that your content that was removed (or to which access was disabled) is not infringing, or that you have the authorization from the copyright owner, the copyright owner's agent, or pursuant to the law, to post and use the material, you may send a counter-notification containing the following information:</p>
            <ol>
                <li>Your physical or electronic signature.</li>
                <li>Identification of the content that has been removed or to which access has been disabled, and the location at which the content appeared before it was removed or disabled.</li>
                <li>A statement that you have a good faith belief that the content was removed or disabled as a result of mistake or misidentification of the content.</li>
                <li>Your name, address, telephone number, and email address.</li>
                <li>A statement that you consent to the jurisdiction of the federal court located in your judicial district, and that you will accept service of process from the person who provided notification of the alleged infringement.</li>
            </ol>
            <p>If a counter-notification is received, we may send a copy of the counter-notification to the original complaining party, informing that person that we may replace the removed content or cease disabling it within 10 business days.</p>
        </section>

        <section class="legal-section">
            <h2>Designated DMCA Agent</h2>
            <p>DMCA notices and counter-notifications should be sent to our designated agent via our <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact page</a>. Please select "General Inquiry" and include "DMCA Notice" or "DMCA Counter-Notification" in your message subject.</p>
        </section>

        <section class="legal-section">
            <h2>Repeat Infringers</h2>
            <p>In accordance with the DMCA and other applicable law, we have adopted a policy of terminating, in appropriate circumstances and at our sole discretion, access for users who are deemed to be repeat infringers. We may also, at our sole discretion, limit access to the website and/or terminate the accounts of any users who infringe any intellectual property rights of others, whether or not there is any repeat infringement.</p>
        </section>

        <section class="legal-section">
            <h2>Good Faith</h2>
            <p>Please note that under Section 512(f) of the Copyright Act, any person who knowingly materially misrepresents that material or activity is infringing, or that material or activity was removed or disabled by mistake or misidentification, may be subject to liability for damages.</p>
        </section>

        <section class="legal-section">
            <h2>Related Pages</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>">Terms of Service</a></li>
                <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Us</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
