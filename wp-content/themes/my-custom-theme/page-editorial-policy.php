<?php
/**
 * Template Name: Editorial Policy
 * Description: Editorial standards, fact-checking process, update cadence, corrections policy, and disclosures.
 */

get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">Editorial Policy</h1>
                <p class="page-intro">How content gets made on The Blog Timer: who writes it, how it's fact-checked, when it gets updated, and what we refuse to do for money. Plain language, falsifiable claims, public corrections.</p>
                <p class="page-byline">By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a> &middot; Updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <section class="section">
                <h2 class="section-title">Editorial Standards</h2>
                <p>Every page on The Blog Timer follows the same editorial bar. The bar is intentionally high, because the site exists to be a trustworthy reference for timing-related decisions &mdash; productivity protocols, exercise intervals, cooking times, nap durations &mdash; and trust degrades the moment we cut corners.</p>
                <p>Concretely, every published article meets four requirements before going live:</p>
                <ol>
                    <li><strong>Factually accurate.</strong> Every empirical claim is sourced from a primary citation: peer-reviewed research, a seminal practitioner text, a government safety reference, or our own measurement. Secondary blog-post sources are not acceptable.</li>
                    <li><strong>Genuinely useful.</strong> The article answers the question a real person had when they searched for it. We do not pad content with synonym-stuffed paragraphs to hit a word count.</li>
                    <li><strong>Honest about uncertainty.</strong> Where the research is contested or thin, we say so. Where a popular productivity claim is overstated, we say so. Where our own testing has a limitation, we document it.</li>
                    <li><strong>Bylined and dated.</strong> Every article has a named author and an explicit "updated on" date. Anonymous authority is not authority.</li>
                </ol>
                <p>The full bibliography of works we rely on is at <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a>. The full testing protocol for any accuracy-related claim is at <a href="<?php echo esc_url(home_url('/methodology/')); ?>">/methodology/</a>.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Fact-Checking Process</h2>
                <p>Before a guide or timer page is published, it passes through a three-step check.</p>
                <div class="two-col">
                    <div class="col">
                        <h3>Step 1: Source verification</h3>
                        <p>Every numeric claim, named-study citation, and "research shows" statement is traced back to the primary source. The author (currently Suraj) must hold the actual study in a reference manager &mdash; we use Zotero &mdash; and the link in the article must resolve to the canonical version of the paper, not a press release about the paper.</p>
                        <p>For seminal practitioner texts (Cirillo's <em>The Pomodoro Technique</em>, Newport's <em>Deep Work</em>, Levitin's <em>The Organized Mind</em>), citations include book + year + relevant chapter. For peer-reviewed studies, citations include lead author, year, journal, and a stable link &mdash; PubMed PMID, DOI, or publisher-hosted PDF.</p>
                    </div>
                    <div class="col">
                        <h3>Step 2: Replication test</h3>
                        <p>For any claim about timer behavior, browser behavior, or technical accuracy, we run the documented test from the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a> and confirm the claim against actual measurement. We do not write "our timer is accurate to within X milliseconds" without an X.</p>
                        <p>For claims about cooking times (egg boiling, poultry temperatures), we cross-check against the <a href="https://www.fsis.usda.gov/food-safety/safe-food-handling-and-preparation/meat/poultry" rel="nofollow noopener" target="_blank">USDA Food Safety and Inspection Service guidelines</a> and the <a href="https://www.fda.gov/food/buy-store-serve-safe-food/safe-food-handling" rel="nofollow noopener" target="_blank">FDA Safe Food Handling reference</a> as the authoritative sources.</p>
                    </div>
                </div>
                <h3>Step 3: Plain-language read</h3>
                <p>Before publication, the article is read aloud once. If a sentence is unreadable, it gets rewritten. If a claim sounds confident but the underlying citation is weak, the confidence is dialed down to match the evidence. This is the step where most overclaiming gets caught.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Update Cadence</h2>
                <p>Articles get updated when one of the following triggers fires:</p>
                <ul>
                    <li><strong>New primary research</strong> changes the recommendation. Example: if a meta-analysis on nap duration supersedes Mednick (2002) or Hayashi (1999), the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> guides get rewritten.</li>
                    <li><strong>Browser behavior changes.</strong> When Chromium or Safari changes background-tab throttling policy, the methodology page and any guides that reference timer behavior get updated.</li>
                    <li><strong>USDA / FDA safety guidance updates.</strong> The cooking-related guides reference government tables; when those tables change, our guides change.</li>
                    <li><strong>Reader-reported error.</strong> Any confirmed factual error triggers an immediate correction (see Corrections Policy below).</li>
                    <li><strong>Quarterly review.</strong> Every guide is reviewed at minimum once per quarter even if no trigger has fired, to catch broken links and stale references.</li>
                </ul>
                <p>The full list of recent updates is maintained at <a href="<?php echo esc_url(home_url('/changelog/')); ?>">/changelog/</a>. Every entry there has a date and a one-sentence description of what changed. We do not silently rewrite articles.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Corrections Policy</h2>
                <p>If you find a factual error on The Blog Timer, the process is:</p>
                <ol>
                    <li>Email <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> with the URL, the specific claim you believe is wrong, and (ideally) the source that contradicts it.</li>
                    <li>Within 72 hours, we either correct the article or write back explaining why we disagree. We don't ignore corrections.</li>
                    <li>If the correction is made, the article gets a dated correction note at the bottom &mdash; not just a silent rewrite. Example: "Correction (2026-03-04): an earlier version of this article cited Tabata (1996) as a 4-minute protocol; the correct duration is 4 minutes total (8 rounds of 20s work + 10s rest)."</li>
                    <li>The correction is also logged in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">changelog</a>.</li>
                    <li>If you want to be credited, we credit you. If you want to remain anonymous, we don't.</li>
                </ol>
                <p>Substantive corrections &mdash; ones that change the recommendation a reader would act on &mdash; get a top-of-article banner for 30 days so returning readers know to recheck.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Disclosures</h2>
                <div class="highlight-box highlight-box--accent">
                    <h3>What this site does NOT do, at time of writing:</h3>
                    <ul>
                        <li><strong>No paid placements.</strong> We have never accepted payment in exchange for editorial coverage. We do not run "sponsored content" or "branded content" of any kind.</li>
                        <li><strong>No affiliate links.</strong> There are currently zero affiliate links on The Blog Timer. If this ever changes, every affiliate link will carry <code>rel="sponsored"</code> per <a href="https://developers.google.com/search/blog/2019/09/evolving-nofollow-new-ways-to-identify" rel="nofollow noopener" target="_blank">Google's 2019 link-attribute guidance</a> and a top-of-page disclosure will appear.</li>
                        <li><strong>No paid reviews.</strong> We do not write product reviews in exchange for free product or compensation. If we ever recommend a non-free product, we will have purchased and used it ourselves, and we will say so.</li>
                        <li><strong>No newsletter dark patterns.</strong> We do not run popup modals, exit-intent overlays, or "scroll-to-unlock" walls.</li>
                        <li><strong>No bought backlinks.</strong> Backlinks to The Blog Timer are organic. We do not pay for placement.</li>
                    </ul>
                </div>
                <p>The full privacy posture is documented on the <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">privacy policy</a>. Operational analytics (used to understand which pages need work) are described there.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Author Requirements</h2>
                <p>Currently the entire editorial team is one person (<a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">Suraj Giri</a>). As the site grows we expect to bring in contributors. Any author who publishes on The Blog Timer must meet all of the following:</p>
                <ul>
                    <li><strong>Named on the byline.</strong> No ghostwriting. No "Editorial Team" mystery-meat bylines. Every article has a real person attached.</li>
                    <li><strong>Public author page.</strong> The byline links to a bio page (like <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">/author-suraj-giri/</a>) documenting credentials and contact.</li>
                    <li><strong>Demonstrable expertise in the topic.</strong> A nap-timer guide should be written by someone with sleep-science credentials or substantial relevant experience &mdash; not a generalist freelancer. The bio page must make the expertise verifiable.</li>
                    <li><strong>Reachable for corrections.</strong> Every author publishes a working email. If a reader finds an error, the author is contactable.</li>
                    <li><strong>No conflicts of interest.</strong> If an author has a financial relationship with a product or technique they're writing about, it's disclosed at the top of the article.</li>
                    <li><strong>Follows this policy.</strong> Every contributor signs off on this editorial policy before publishing.</li>
                </ul>
                <p>If you want to contribute, write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> with what you'd write and why you're qualified. We are particularly looking for contributors with credentials in sleep science, sports/exercise science, food science, and clinical psychology.</p>
            </section>

            <section class="section">
                <h2 class="section-title">AI Use Disclosure</h2>
                <p>Some research-gathering and draft-structuring tasks on The Blog Timer use large language models as a tool, in the same way an editor uses a search engine or a writer uses a grammar checker. Every published article is read, verified, edited, and signed off by a named human author. The human author is responsible for every claim. We do not auto-publish AI-generated text.</p>
                <p>Specifically: AI is allowed for outlining, citation-discovery, and language polish. AI is not allowed for original empirical claims, for citation generation (every citation must trace to a real, verified primary source &mdash; LLMs hallucinate citations), or for assertions of personal experience ("in our testing", "we measured X") unless the human author actually did the test.</p>
                <p>This policy exists because the alternative &mdash; pretending no AI tooling is used &mdash; would be dishonest, and pretending AI-generated text without human verification is acceptable would violate the fact-checking standard above.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Medical, Legal, and Professional Advice Disclaimer</h2>
                <p>The Blog Timer publishes information about productivity techniques, exercise protocols, nap durations, and cooking times. None of it is medical advice, legal advice, financial advice, or any other form of professional advice. If a protocol on this site interacts with a health condition you have, talk to a qualified clinician. The <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">full disclaimer</a> covers this in more detail.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Contact the Editor</h2>
                <p>For corrections, citation suggestions, contributor pitches, or policy questions: <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a>. We respond within 72 hours during normal weeks.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Related Pages</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/methodology/')); ?>">Testing methodology</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources/')); ?>">Cited sources and bibliography</a></li>
                    <li><a href="<?php echo esc_url(home_url('/changelog/')); ?>">Editorial changelog</a></li>
                    <li><a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">Author: Suraj Giri</a></li>
                    <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Full disclaimer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy policy</a></li>
                </ul>
            </section>

        </article>
    </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Editorial Policy",
  "url": "<?php echo esc_url(home_url('/editorial-policy/')); ?>",
  "datePublished": "<?php echo esc_js(get_post_time('c', true)); ?>",
  "dateModified": "<?php echo esc_js(get_post_modified_time('c', true)); ?>",
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "email": "suraj@theblogtimer.com",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "<?php echo esc_url(home_url('/')); ?>"
  },
  "description": "The Blog Timer's editorial standards, fact-checking process, update cadence, corrections policy, and disclosures."
}
</script>

<?php
get_footer();
?>
