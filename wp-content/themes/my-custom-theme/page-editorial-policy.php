<?php
/**
 * Template Name: Editorial Policy
 * Description: Editorial standards, content creation process, and E-E-A-T transparency.
 */
get_header();
?>

<main class="content-page">
    <div class="container">

        <h1>Editorial Policy</h1>
        <p class="page-updated">Last updated: <?php echo date('F j, Y'); ?></p>

        <section class="legal-section">
            <h2>Our Editorial Mission</h2>
            <p>The Blog Timer is committed to producing accurate, helpful, and trustworthy content about time management, productivity techniques, and the effective use of timer tools. Our editorial mission is to provide visitors with information they can rely on for making decisions about their work habits, exercise routines, cooking techniques, study methods, and meditation practices.</p>
            <p>Every piece of content on The Blog Timer is created with the goal of being genuinely useful to our readers. We prioritize depth, accuracy, and practical applicability over content volume or search engine optimization tactics.</p>
        </section>

        <section class="legal-section">
            <h2>Content Creation Standards</h2>
            <p>All content published on The Blog Timer adheres to the following standards:</p>

            <h3>Accuracy and Fact-Checking</h3>
            <ul>
                <li>Claims about productivity techniques, timing methods, and health-related topics are verified against published research and authoritative sources</li>
                <li>Technical claims about timer accuracy, browser behavior, and web technologies are validated through testing</li>
                <li>Statistics and data points are sourced from reputable organizations and cited where appropriate</li>
                <li>Content is reviewed for factual accuracy before publication</li>
            </ul>

            <h3>Originality</h3>
            <ul>
                <li>All content is original and written specifically for The Blog Timer</li>
                <li>We do not copy, scrape, or spin content from other websites</li>
                <li>When referencing external research or methodologies (such as the Pomodoro Technique), we provide proper attribution</li>
                <li>Our timer tool descriptions are based on first-hand testing and use of our own platform</li>
            </ul>

            <h3>Helpfulness</h3>
            <ul>
                <li>Content is written to genuinely help users accomplish their goals, not to manipulate search rankings</li>
                <li>We provide actionable advice that readers can implement immediately</li>
                <li>Timer recommendations are based on practical utility for the described use case</li>
                <li>We acknowledge limitations and edge cases rather than overpromising results</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Experience and Expertise</h2>
            <p>The Blog Timer's content is informed by direct, hands-on experience with the tools and techniques we describe:</p>

            <h3>First-Hand Experience</h3>
            <ul>
                <li><strong>Timer development:</strong> Our team built The Blog Timer from scratch, giving us deep knowledge of how browser-based timers work, their limitations, and how to maximize accuracy</li>
                <li><strong>Productivity methods:</strong> We use our own timers daily for Pomodoro sessions, deep work blocks, and interval training, and write from that practical experience</li>
                <li><strong>Technical testing:</strong> All claims about timer accuracy, background tab behavior, and cross-device compatibility are based on our own extensive testing</li>
            </ul>

            <h3>Subject Matter Knowledge</h3>
            <ul>
                <li><strong>Web development:</strong> Our team has professional experience in frontend development, JavaScript engineering, and web performance optimization</li>
                <li><strong>Productivity research:</strong> We stay current with academic research on time management, attention science, and cognitive performance</li>
                <li><strong>User experience design:</strong> Our content and tool design draws on UX best practices and accessibility standards</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Editorial Independence</h2>
            <p>The Blog Timer maintains full editorial independence in all content decisions:</p>
            <ul>
                <li><strong>No paid reviews:</strong> We do not accept payment in exchange for favorable coverage of products, services, or techniques</li>
                <li><strong>Advertising separation:</strong> Advertising content is clearly separated from editorial content. Ads do not influence our editorial decisions, timer recommendations, or content priorities</li>
                <li><strong>Affiliate transparency:</strong> If we participate in affiliate programs, this is disclosed clearly. Affiliate relationships do not influence our editorial recommendations</li>
                <li><strong>No sponsored content:</strong> Our guides and articles are not sponsored by third parties. All content reflects our independent editorial judgment</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>Content Update Policy</h2>
            <p>We are committed to keeping our content current and accurate:</p>
            <ul>
                <li>Published content is reviewed periodically to ensure ongoing accuracy</li>
                <li>Technical content is updated when browser behavior, web standards, or our platform changes</li>
                <li>Research-based claims are updated when new studies provide better evidence</li>
                <li>All pages display a "last updated" date so readers know how recently the content was reviewed</li>
                <li>Significant corrections are noted transparently rather than silently edited</li>
            </ul>
        </section>

        <section class="legal-section">
            <h2>User-Generated Content</h2>
            <p>The Blog Timer does not currently accept user-submitted articles or guest posts. All published content is created by our editorial team to maintain consistent quality standards. We do welcome feedback, corrections, and suggestions through our <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact page</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Corrections Policy</h2>
            <p>If we discover an error in our content, or if a reader brings an error to our attention, we will:</p>
            <ol>
                <li>Investigate the reported error promptly</li>
                <li>Correct the content if the error is confirmed</li>
                <li>Note significant corrections with a correction notice where appropriate</li>
                <li>Thank the person who reported the error (if they wish to be acknowledged)</li>
            </ol>
            <p>To report a factual error, please use our <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact form</a> and select "Bug Report" as the subject.</p>
        </section>

        <section class="legal-section">
            <h2>Medical and Professional Disclaimer</h2>
            <p>While our content covers topics related to productivity, exercise, cooking, and meditation, The Blog Timer does not provide medical, legal, financial, or other professional advice. Content related to exercise timing, meditation practices, and study techniques is informational in nature and should not replace guidance from qualified professionals.</p>
            <p>For more information, see our <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">full disclaimer</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Contact Our Editorial Team</h2>
            <p>Questions about our editorial standards, content accuracy, or suggestions for improvement are welcome. Please reach out through our <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact page</a>.</p>
        </section>

        <section class="legal-section">
            <h2>Related Pages</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer</a></li>
                <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a></li>
                <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>">Terms of Service</a></li>
            </ul>
        </section>

    </div>
</main>

<?php get_footer(); ?>
