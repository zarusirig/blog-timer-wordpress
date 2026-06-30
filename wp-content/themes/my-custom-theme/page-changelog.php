<?php
/**
 * Template Name: Editorial Changelog
 * Description: Dated log of editorial and infrastructure changes on The Blog Timer.
 */

get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">Editorial Changelog</h1>
                <p class="page-intro">A dated, plain-language log of every substantive change on The Blog Timer &mdash; new guides, corrected facts, updated study citations, infrastructure updates, and methodology revisions. Silent rewrites are not the standard here.</p>
                <p class="page-byline">Maintained by <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a> &middot; Last entry <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <section class="section">
                <h2 class="section-title">Why a Public Changelog Exists</h2>
                <p>Most websites edit themselves quietly. A claim from last year gets softened. A study citation gets swapped out for a newer one. A guide gets rewritten without a note. Readers who came back to verify what they read the first time end up unable to tell whether they misremember or whether the site changed.</p>
                <p>The Blog Timer logs editorial changes publicly because the alternative is a slow, invisible erosion of trust. If a fact on this site was wrong last month and is correct now, that's a thing worth admitting in writing. The same goes for infrastructure changes that affect privacy, security, or how the timer behaves &mdash; readers deserve to know.</p>
                <p>Each entry below is dated, named, and described in one paragraph or less. Substantive corrections additionally get a banner on the affected article for 30 days. Citations to the editorial policy that governs this process are on the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a> page.</p>
            </section>

            <section class="section">
                <h2 class="section-title">What Counts as a Logged Change</h2>
                <p>The changelog records:</p>
                <ul>
                    <li><strong>New published guides or hub pages.</strong> Each new piece of permanent content gets a single dated entry on the day it goes live.</li>
                    <li><strong>Corrected factual claims.</strong> Any time a statement of fact is changed because new evidence emerged or a reader reported an error.</li>
                    <li><strong>Updated study citations.</strong> When a newer or stronger primary source supersedes one previously cited.</li>
                    <li><strong>Infrastructure changes affecting users.</strong> SSL changes, hosting moves, performance optimizations that materially change the site, privacy-relevant additions.</li>
                    <li><strong>Methodology updates.</strong> Changes to how we test timer accuracy, our browser/OS matrix, or our statistical reporting.</li>
                    <li><strong>Policy changes.</strong> Edits to the editorial policy, privacy policy, terms of service, or disclosure standards.</li>
                </ul>
                <p>Routine typo fixes and copyedits that don't change meaning are not logged individually. Style-only rewrites are not logged. Everything that changes what a reader knows or can rely on, is logged.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Recent Entries</h2>

                <article class="source-entry">
                    <h3>2026-05-22 &mdash; Trust-infrastructure pages published</h3>
                    <p>Published four new pages: <a href="<?php echo esc_url(home_url('/methodology/')); ?>">/methodology/</a> documenting our 8-test timer-accuracy protocol; <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a> as the complete bibliography of cited research; <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">/author-suraj-giri/</a> as the author bio page for byline links; and <a href="<?php echo esc_url(home_url('/changelog/')); ?>">/changelog/</a> (this page). Substantially rewrote the existing <a href="<?php echo esc_url(home_url('/about/')); ?>">about</a> and <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a> pages to align with the new transparency standards.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-04-30 &mdash; Timer ID dataset fix</h3>
                    <p>Fixed a data-integrity bug in the internal timer-preset dataset where 7 duration entries had non-unique IDs, causing 4 timer pages to load the wrong preset metadata. Affected pages have been corrected; URLs and content of public timer pages were unaffected.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-04-12 &mdash; 69 timer guides launched</h3>
                    <p>Published a batch of 69 long-form timer guides covering the full minute-timer range (1&ndash;60 minutes) plus extended focus blocks. Every guide goes through the standard <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial-policy</a> review &mdash; primary sources, plain-language read, dated byline.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-03-18 &mdash; New hub pages: minute-timers, second-timers, use-cases</h3>
                    <p>Reorganized the site around three top-level hub pages: <a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">/minute-timers/</a>, <a href="<?php echo esc_url(home_url('/second-timers/')); ?>">/second-timers/</a>, and <a href="<?php echo esc_url(home_url('/use-cases/')); ?>">/use-cases/</a>. Internal linking from individual timer pages was updated to point to the appropriate hub.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-02-25 &mdash; SSL certificate installed and HTTP redirected to HTTPS</h3>
                    <p>Provisioned a Let's Encrypt certificate and configured a permanent 301 redirect from the HTTP origin to HTTPS. All internal links and canonical URLs updated to use HTTPS. No user data was previously transmitted over insecure connections; this is a defense-in-depth improvement.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-02-10 &mdash; Nap-timer guide updated with Brooks &amp; Lack (2006)</h3>
                    <p>Added <a href="https://pubmed.ncbi.nlm.nih.gov/16796222/" rel="nofollow noopener" target="_blank">Brooks &amp; Lack (2006)</a> as a primary citation on the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> guide, supporting the recommendation of 10-minute naps as the most consistently restorative without sleep inertia. Previously the guide cited only Mednick (2002) and Hayashi (1999). Reader correction prompted by an email from a sleep researcher; thanks to the contributor (anonymous by request).</p>
                </article>

                <article class="source-entry">
                    <h3>2026-01-28 &mdash; Tabata-protocol duration corrected on interval-timer guide</h3>
                    <p>An earlier version of the <a href="<?php echo esc_url(home_url('/interval-timer/')); ?>">interval timer</a> guide described the Tabata protocol as "8 rounds of 20 seconds high-intensity with 10 seconds rest, totaling roughly 4 minutes." The "roughly" was imprecise. The protocol as described in <a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">Tabata et al. (1996)</a> is exactly 8 rounds of (20 s work + 10 s rest) = exactly 4 minutes (240 seconds). The guide has been corrected to remove the "roughly." Affected article carried a correction banner from 2026-01-28 through 2026-02-27.</p>
                </article>

                <article class="source-entry">
                    <h3>2026-01-14 &mdash; Methodology page formalized</h3>
                    <p>Formalized the previously-informal internal timer-testing checklist into the public <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a>, with the 8 named tests and the full browser/OS matrix. Where the engine had been tested informally for ~14 months prior, every release going forward will be documented against this published protocol.</p>
                </article>

                <article class="source-entry">
                    <h3>2025-12-20 &mdash; AI-use disclosure added to editorial policy</h3>
                    <p>Added a section to the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a> explicitly documenting how (and how not) large language models are used in our content workflow. Summary: outlining and language polish allowed; citation generation and empirical-claim generation prohibited; every fact verified by the named human author.</p>
                </article>

                <article class="source-entry">
                    <h3>2025-11-30 &mdash; iOS Safari long-background limitation documented</h3>
                    <p>Added a "Known Limitations" section to the methodology page explicitly documenting the iOS Safari long-background suspension issue: when a tab is backgrounded for more than ~5 minutes, Safari may discard the page entirely and the audio alert cannot fire while the page is discarded. Surfaced as an in-app banner on iOS for timer durations &gt; 5 minutes. Honest disclosure of a real limitation we cannot engineer around.</p>
                </article>

                <article class="source-entry">
                    <h3>2025-11-08 &mdash; Chess clock launched</h3>
                    <p>Published <a href="<?php echo esc_url(home_url('/chess-clock/')); ?>">/chess-clock/</a> with bullet, blitz, rapid, and classical presets plus a tap-to-switch turn interface. First two-player timing tool on the site; built in response to repeated user requests.</p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Older Entries</h2>
                <p>The full archive of prior changelog entries (2024 and earlier) is being migrated from internal git commit logs into this format. Until that migration is complete, you can request specific historical context (e.g. "when did the privacy-policy first include localStorage disclosure?") by writing to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a>.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Report a Missing Change</h2>
                <p>If you remember a substantive change to The Blog Timer that isn't logged here, that's a bug. Email <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> with the date you remember and what changed, and we'll either confirm and add the entry, or explain why we believe the change wasn't substantive enough to log.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Related Pages</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial policy &mdash; corrections process</a></li>
                    <li><a href="<?php echo esc_url(home_url('/methodology/')); ?>">Testing methodology</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources/')); ?>">Cited sources and bibliography</a></li>
                    <li><a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">Author: Suraj Giri</a></li>
                </ul>
            </section>

        </article>
    </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Editorial Changelog",
  "url": "<?php echo esc_url(home_url('/changelog/')); ?>",
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
  "description": "Dated public log of editorial, factual, infrastructure, and policy changes on The Blog Timer."
}
</script>

<?php
get_footer();
?>
