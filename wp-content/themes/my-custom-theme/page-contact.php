<?php
/**
 * Template Name: Contact Page
 * Description: Contact page for The Blog Timer
 */

get_header();

$contact_status = isset($_GET['contact_status']) ? sanitize_key(wp_unslash($_GET['contact_status'])) : '';
$support_usecase_url = blogtimer_get_term_url_by_slug('timer_usecase', 'productivity');
$accuracy_guides_url = blogtimer_get_term_url_by_slug('guide_cluster', 'accuracy');
$contact_notices = [
    'success' => ['type' => 'success', 'text' => 'Thanks for your message. Our team has received it and will respond as soon as possible.'],
    'validation_error' => ['type' => 'error', 'text' => 'Please complete all required fields and include at least 50 characters in your message.'],
    'invalid_nonce' => ['type' => 'error', 'text' => 'Your session expired before submit. Please try again.'],
    'send_error' => ['type' => 'error', 'text' => 'We could not send your message right now. Please try again in a few minutes.'],
];
?>

<main class="site-main content-page">
    <div class="container">
        <h1 class="page-h1">Get in Touch with The Blog Timer</h1>

        <?php if (isset($contact_notices[$contact_status])): ?>
            <div class="highlight-box <?php echo $contact_notices[$contact_status]['type'] === 'success' ? 'highlight-box--success' : 'highlight-box--accent'; ?>" role="status" aria-live="polite">
                <p><?php echo esc_html($contact_notices[$contact_status]['text']); ?></p>
            </div>
        <?php endif; ?>

        <div class="highlight-box highlight-box--accent">
            <p>We're here to listen. Whether you have a question, suggestion, bug report, or just want to share how you're using The Blog Timer, we'd love to hear from you. Your feedback helps us build better tools for everyone.</p>
        </div>

        <section class="section">
            <h2 class="section-title">Send Us a Message</h2>
            <p>Fill out the form below and we'll get back to you as soon as possible. Please provide as much detail as you can so we can assist you effectively.</p>

            <form id="contact-form" class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="blogtimer_contact">
                <?php wp_nonce_field('blogtimer_contact_submit', 'blogtimer_contact_nonce'); ?>
                <div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                    <label for="blogtimer-website">Leave this field empty</label>
                    <input type="text" id="blogtimer-website" name="blogtimer_website" tabindex="-1" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="contact-name" class="form-label">Your Name *</label>
                    <input type="text" id="contact-name" name="contact-name" class="form-input" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="contact-email" class="form-label">Email Address *</label>
                    <input type="email" id="contact-email" name="contact-email" class="form-input" required placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label for="contact-subject" class="form-label">Subject *</label>
                    <select id="contact-subject" name="contact-subject" class="form-select" required>
                        <option value="">Select a topic...</option>
                        <option value="general">General Inquiry</option>
                        <option value="feature">Feature Request</option>
                        <option value="bug">Bug Report</option>
                        <option value="partnership">Partnership Opportunity</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contact-message" class="form-label">Message *</label>
                    <textarea id="contact-message" name="contact-message" class="form-textarea" rows="8" minlength="50" required placeholder="Tell us what's on your mind..."></textarea>
                </div>

                <button type="submit" class="btn btn--primary btn--large">Send Message</button>
            </form>
        </section>

        <section class="section">
            <h2 class="section-title">How We Handle Your Feedback</h2>
            <p>Every message we receive is read by a real person on our team. We take your feedback seriously because it directly shapes the future of The Blog Timer. Here's what happens when you reach out to us:</p>

            <div class="card">
                <h3>Immediate Acknowledgment</h3>
                <p>Once you submit your message, you'll receive an automated confirmation email letting you know we've received your inquiry. This ensures your message didn't get lost in cyberspace.</p>
            </div>

            <div class="card">
                <h3>Team Review</h3>
                <p>Your message is assigned to the most appropriate team member based on the subject you selected. Feature requests go to our product team, bug reports to our developers, and general inquiries to our support team.</p>
            </div>

            <div class="card">
                <h3>Thoughtful Response</h3>
                <p>We don't believe in template responses. Each reply is crafted specifically for your situation, whether that's troubleshooting a technical issue, discussing a feature idea, or answering your questions about how our timers work.</p>
            </div>

            <div class="card">
                <h3>Follow Through</h3>
                <p>If your feedback leads to a bug fix or feature implementation, we'll let you know when it goes live. Many of our best features started as user suggestions, and we love closing that feedback loop.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Requesting New Features</h2>
            <p>We're constantly improving The Blog Timer based on what our users need. If you have an idea for a new timer type, duration, or feature, we want to hear it. Here's how to submit a feature request that helps us understand your needs:</p>

            <div class="highlight-box highlight-box--success">
                <h3>What to Include in Your Feature Request</h3>
                <ul>
                    <li><strong>The Problem:</strong> Describe the challenge you're facing or the gap you've noticed in our current offerings. Context helps us understand the "why" behind your request.</li>
                    <li><strong>Your Proposed Solution:</strong> Share your vision for how this feature would work. Don't worry about technical details—focus on the user experience you're imagining.</li>
                    <li><strong>Use Case Examples:</strong> Tell us how you would use this feature in your daily routine. Real-world scenarios help us prioritize and refine ideas.</li>
                    <li><strong>Current Workarounds:</strong> If you've found a temporary solution, let us know. This helps us understand urgency and validate the need.</li>
                    <li><strong>Impact:</strong> Would this help you occasionally or daily? Are you requesting this for yourself or for a group of users you represent?</li>
                </ul>
            </div>

            <p>Our product team reviews all feature requests monthly. We evaluate each suggestion based on user demand, technical feasibility, alignment with our mission, and potential impact. Popular requests are added to our public roadmap, which we update quarterly.</p>

            <div class="card">
                <h3>How We Prioritize Features</h3>
                <p>We use a transparent prioritization framework that balances multiple factors. High-impact features that benefit many users typically move faster through our development queue. Features that align with our core mission of providing free, accessible timing tools get priority consideration. We also factor in technical complexity—some features can be shipped quickly while others require significant infrastructure changes.</p>
                <p>We're particularly interested in features that increase accessibility, expand use cases for our existing timer library, or improve the user experience for mobile visitors. If your request fits these categories, there's a strong chance we'll implement it.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Reporting Bugs and Technical Issues</h2>
            <p>Encounter something that doesn't work as expected? We want to fix it fast. The more information you provide, the quicker we can identify and resolve the issue. Here's what helps our developers troubleshoot effectively:</p>

            <div class="highlight-box">
                <h3>Essential Information for Bug Reports</h3>
                <ul>
                    <li><strong>Browser and Version:</strong> Are you using Chrome 110, Safari 16, Firefox 109, or another browser? Include the version number if possible.</li>
                    <li><strong>Device Type:</strong> Desktop, laptop, tablet, or smartphone? Operating system matters too—Windows, Mac, iOS, Android, or Linux.</li>
                    <li><strong>Screen Size:</strong> Some issues only appear on certain screen sizes. Mobile portrait, mobile landscape, tablet, or desktop?</li>
                    <li><strong>What You Were Doing:</strong> Walk us through the exact steps that led to the problem. "I clicked the 25-minute timer, then opened another tab, and when I came back..." gives us a trail to follow.</li>
                    <li><strong>What Happened:</strong> Describe the unexpected behavior. Did the timer stop? Did the alarm not play? Did something display incorrectly?</li>
                    <li><strong>What Should Have Happened:</strong> Tell us what you expected to occur instead. This confirms we understand the intended functionality.</li>
                    <li><strong>Frequency:</strong> Does this happen every time you try, or only occasionally? Can you reproduce it consistently?</li>
                    <li><strong>Screenshots or Video:</strong> If possible, capture what you're seeing. Visual evidence can be invaluable for UI bugs or layout issues.</li>
                </ul>
            </div>

            <p>Common issues we see include timer audio not playing (usually a browser permission setting), timers not displaying properly on certain screen sizes (responsive design bugs), or notifications not appearing (browser notification settings). Many of these have quick fixes we can guide you through, even if they're not technically bugs on our end.</p>

            <div class="card">
                <h3>Our Bug Fix Process</h3>
                <p>Critical bugs that prevent core functionality get immediate attention. If the timer doesn't start, stop, or alert properly, we treat it as a priority one issue and aim for same-day fixes. Visual bugs and minor usability issues are typically addressed within a week. Enhancement requests disguised as bugs (like "the timer should have a different sound") are redirected to our feature request queue.</p>
                <p>We test all fixes across multiple browsers and devices before deployment. Once fixed, we'll email you to confirm the issue is resolved and invite you to verify the solution.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Response Time Expectations</h2>
            <p>We strive to respond to every message within 24-48 hours during business days. Here's a realistic breakdown of our typical response times:</p>

            <div class="card">
                <h3>General Inquiries</h3>
                <p>Most questions about how to use our timers, clarifications about our features, or general curiosity about The Blog Timer are answered within 24 hours. Simple questions often get same-day responses.</p>
            </div>

            <div class="card">
                <h3>Bug Reports</h3>
                <p>We acknowledge bug reports within 12-24 hours. If we need additional information to reproduce the issue, we'll ask follow-up questions immediately. Once we've confirmed the bug, we'll provide an estimated timeline for the fix.</p>
            </div>

            <div class="card">
                <h3>Feature Requests</h3>
                <p>We confirm receipt of feature requests within 48 hours. These require more consideration than simple inquiries, so the initial response typically acknowledges your idea and explains our review process. Full evaluation feedback comes during our monthly product review cycle.</p>
            </div>

            <div class="card">
                <h3>Partnership Opportunities</h3>
                <p>Business partnership inquiries receive responses within 2-3 business days. These often require discussion among multiple team members before we can provide a thoughtful reply.</p>
            </div>

            <p>Please note that we're a small team, and response times may extend during holidays, major product launches, or periods of high message volume. We appreciate your patience and promise that every message gets a response—we never ghost our users.</p>
        </section>

        <section class="section">
            <h2 class="section-title">Our Commitment to You</h2>
            <p>The Blog Timer exists because we believe everyone deserves access to quality productivity tools without paywalls, subscriptions, or tracking. Your feedback is essential to fulfilling that mission. Here's what you can count on when you contact us:</p>

            <div class="highlight-box highlight-box--success">
                <h3>Respect for Your Time</h3>
                <p>We won't waste your time with long surveys, multiple follow-ups, or attempts to upsell you services. Your message gets a direct, helpful response and nothing more—unless you ask for additional assistance.</p>
            </div>

            <div class="highlight-box highlight-box--success">
                <h3>Privacy Protection</h3>
                <p>Your email address and message content are used solely for responding to your inquiry. We don't add you to marketing lists, sell your information, or share it with third parties. When you contact us, you're talking to our team, not a marketing database.</p>
            </div>

            <div class="highlight-box highlight-box--success">
                <h3>Honest Communication</h3>
                <p>If we can't implement your feature request, we'll tell you why. If we don't know the answer to your question, we'll admit it and research the answer. If a bug is taking longer to fix than expected, we'll update you proactively. Transparency builds trust, and trust is something we value deeply.</p>
            </div>

            <div class="highlight-box highlight-box--success">
                <h3>Continuous Improvement</h3>
                <p>Every piece of feedback contributes to making The Blog Timer better. We track common questions to improve our documentation, note recurring feature requests to inform our roadmap, and fix bugs to create a smoother experience for everyone. Your input has real impact.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Frequently Asked Questions About Contacting Us</h2>

            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>How long does it take to get a response?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Most messages receive a response within 24-48 hours during business days (Monday-Friday). Urgent bug reports often get same-day attention, while feature requests may take a bit longer as they require team discussion. We respond to every message—if you haven't heard from us within three business days, please check your spam folder or send a follow-up.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>Can I request a specific timer duration that's not on your site?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely! We're always expanding our timer library based on user needs. Submit a feature request through the contact form above, and let us know what duration you need and how you plan to use it. If we receive multiple requests for the same duration, it moves up our priority list. Many of our timer pages were created directly from user suggestions.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>Do you offer phone support or live chat?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Currently, we handle all support through email via the contact form. This allows us to provide thoughtful, detailed responses and maintain a record of our conversation in case follow-up is needed. It also helps us operate efficiently as a small team while keeping The Blog Timer completely free for users. Most questions are resolved with a single email exchange.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>I found a bug. Will you fix it?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we take bug reports seriously and prioritize fixes based on severity. Critical bugs that prevent timers from working correctly are addressed immediately—often within hours. Visual glitches or minor usability issues are typically fixed within a week. When you report a bug, we'll acknowledge it quickly, investigate the issue, and update you when the fix is deployed. Your bug report helps improve the experience for everyone.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>Can I suggest features even if I'm not a programmer?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Please do! You don't need any technical knowledge to suggest features. In fact, some of our best ideas come from users who simply describe what they wish the timer could do. Focus on explaining the problem you're trying to solve and how you envision the solution working from a user's perspective. Our development team handles the technical implementation details.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>Will you respond to partnership and collaboration inquiries?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we're open to partnerships that align with our mission of providing free, accessible productivity tools. We've collaborated with educational institutions, productivity bloggers, and app developers in the past. When reaching out about partnerships, please describe what you have in mind, how it benefits both parties, and why you think we'd be a good fit. We review all partnership proposals, though we're selective about which opportunities we pursue.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h3>What if my question isn't answered in your FAQ or guides?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>That's exactly what this contact form is for! We can't anticipate every question, and your unique situation might not be covered in our existing documentation. Send us your question with as much context as possible, and we'll provide a personalized answer. If we receive the same question multiple times, we add it to our FAQ to help future users.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Alternative Ways to Reach Out</h2>
            <p>While the contact form above is the fastest way to reach our team, we understand that different people prefer different communication channels. Here are additional ways to connect with The Blog Timer community and team:</p>

            <div class="card">
                <h3>Social Media</h3>
                <p>Follow us on social media for product updates, productivity tips, and community highlights. While we don't handle support requests through social media (it's difficult to track and respond comprehensively in that format), we do share announcements about new timers, features, and occasionally ask for community input on decisions.</p>
            </div>

            <div class="card">
                <h3>Community Forums</h3>
                <p>Join discussions with other Blog Timer users in our community forums. This is a great place to share how you're using timers, discover new productivity techniques, and help other users troubleshoot common issues. Our team monitors the forums and jumps in when needed, but the community itself is often the fastest source of helpful advice.</p>
            </div>

            <div class="card">
                <h3>GitHub Issues</h3>
                <p>If you're technically inclined and want to report a bug with detailed logs, browser console outputs, or network traces, you can file an issue on our GitHub repository. This is particularly useful for developers who want to contribute code fixes or have deep technical discussions about implementation details.</p>
            </div>

            <p>Regardless of which channel you choose, we're committed to hearing you out and responding thoughtfully. The contact form on this page remains the most reliable method for getting a direct response from our core team, but we value community engagement across all platforms.</p>
        </section>

        <section class="section">
            <h2 class="section-title">Helpful Internal Resources</h2>
            <ul class="context-link-list">
                <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">Read frequently asked timer support questions</a></li>
                <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Browse all timer guides before submitting a ticket</a></li>
                <li><a href="<?php echo esc_url($accuracy_guides_url); ?>">Check timer accuracy and browser behavior guides</a></li>
                <li><a href="<?php echo esc_url(home_url('/pomodoro/')); ?>">Try the built-in Pomodoro timer workflow</a></li>
                <li><a href="<?php echo esc_url($support_usecase_url); ?>">Browse productivity timer use-case pages</a></li>
            </ul>
        </section>

        <div class="cta-banner">
            <h2>Your Voice Shapes The Blog Timer</h2>
            <p>Every feature we've added, every bug we've fixed, and every improvement we've made started with feedback from users like you. Whether you have a quick question or a detailed suggestion, we're listening. Don't hesitate—reach out today and help us build better timing tools for everyone.</p>
            <a href="#contact-form" class="btn btn--primary btn--large">Send Us Your Feedback</a>
        </div>

        <script>
        // Smooth scroll to form when CTA is clicked
        document.addEventListener('DOMContentLoaded', function() {
            const ctaButton = document.querySelector('.cta-banner a[href="#contact-form"]');
            if (ctaButton) {
                ctaButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = document.querySelector('.contact-form');
                    if (form) {
                        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        setTimeout(function() {
                            document.getElementById('contact-name').focus();
                        }, 500);
                    }
                });
            }

            // FAQ accordion functionality
            const faqQuestions = document.querySelectorAll('.faq-question');
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const faqItem = this.parentElement;
                    const isActive = faqItem.classList.contains('active');

                    // Close all FAQ items
                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Open clicked item if it wasn't already active
                    if (!isActive) {
                        faqItem.classList.add('active');
                    }
                });
            });
        });
        </script>
    </div>
</main>

<?php get_footer(); ?>
