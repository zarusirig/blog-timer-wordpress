<?php
/**
 * Template Name: Write for Us
 *
 * Guest-post guidelines page (slug: write-for-us). The rules here mirror the
 * editorial checks the team applies before publishing, and the Google link-spam
 * policy for guest contributions (nofollow/sponsored author links).
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <header class="section-header">
            <p class="gp-kicker">Contribute</p>
            <h1 class="page-h1">Write for Us</h1>
            <p class="page-intro">The Blog Timer accepts guest articles from practitioners with real, demonstrable experience. We publish original, useful, well-structured articles for an audience that cares about time, tools, and working smarter.</p>
        </header>

        <section class="section">
            <div class="content-page container--narrow">

                <h2>Topics We Accept</h2>
                <p>Pick one topic per pitch. Your article must fit one of our published topic hubs:</p>
                <div class="gp-topics-inline">
                    <?php
                    foreach (blogtimer_indexable_category_slugs() as $topic_slug) {
                        $topic_term = get_term_by('slug', $topic_slug, 'category');
                        if ($topic_term && !is_wp_error($topic_term)) {
                            printf(
                                '<a class="gp-topic-chip" href="%s">%s</a>',
                                esc_url(get_term_link($topic_term)),
                                esc_html($topic_term->name)
                            );
                        }
                    }
                    ?>
                </div>

                <h2>Submission Rules</h2>
                <ul>
                    <li><strong>Original content only.</strong> The article must not be published anywhere else before or after it goes live here, including your own blog or article directories.</li>
                    <li><strong>Minimum 1,000 words</strong> of genuinely useful content — a clear method, examples, and practical steps a reader can apply the same day.</li>
                    <li><strong>Write for humans.</strong> We reject thinly reworded, AI-generated filler. Every claim that matters needs a source or first-hand experience behind it.</li>
                    <li><strong>Structure it.</strong> Short paragraphs, descriptive subheadings (H2/H3), lists where they help, and a clear takeaway.</li>
                    <li><strong>Cite facts.</strong> Statistics, research, and specific numbers need a link to the original source.</li>
                    <li><strong>One featured image</strong> (1200&times;675 or larger) that you own or that is properly licensed. Images you upload are hosted on our servers.</li>
                    <li><strong>Author bio.</strong> Two or three sentences about you, with one website link and optionally one social profile link.</li>
                </ul>

                <h2>Link Policy</h2>
                <ul>
                    <li><strong>Author bio links are nofollow.</strong> This follows Google's link-spam rules for guest posts. It is not negotiable.</li>
                    <li>Up to <strong>2 links in the bio</strong> (website + one social profile). No keyword-stuffed anchors.</li>
                    <li>Links inside the article must point to genuinely relevant, helpful resources — not to your sales pages.</li>
                    <li>Affiliate links, redirect chains, and link shorteners are removed.</li>
                </ul>

                <h2>What We Do Not Accept</h2>
                <ul>
                    <li>Gambling, casino, betting, lottery, or poker content</li>
                    <li>Crypto exchanges, token promotion, or financial "opportunities"</li>
                    <li>Essay mills, homework services, or academic dishonesty services</li>
                    <li>Adult content, drugs, weapons, or violence</li>
                    <li>Payday loans, credit-repair schemes, or get-rich-quick offers</li>
                    <li>Rehashed press releases or product announcements with no insight</li>
                </ul>

                <h2>Editorial Review</h2>
                <p>Every submission is reviewed by an editor. We may edit for clarity, structure, grammar, and house style, and we may add internal links to our own tools and guides. Published articles carry an author byline and bio. We do not pay guest contributors, and contributors do not receive dofollow links.</p>

                <h2>How to Pitch</h2>
                <p>Send your pitch through our <a href="<?php echo esc_url(home_url('/contact')); ?>">contact page</a> with:</p>
                <ol>
                    <li>Your name and a short bio (with your experience on the topic)</li>
                    <li>The topic you are targeting</li>
                    <li>Your proposed title and a 3&ndash;5 sentence outline</li>
                    <li>One or two samples of your writing</li>
                </ol>
                <p>We reply to accepted pitches within 5 business days. If you do not hear from us, the pitch was not a fit this time.</p>

            </div>
        </section>
    </div>
</main>

<?php get_footer();
