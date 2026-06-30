<?php
/**
 * Template Name: About Page
 * Description: About The Blog Timer - Suraj Giri's origin story, methodology overview, and trust commitments.
 */

get_header();
$productivity_usecase_url = blogtimer_get_term_url_by_slug('timer_usecase', 'productivity');
$pomodoro_cluster_url = blogtimer_get_term_url_by_slug('guide_cluster', 'pomodoro');
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">About The Blog Timer</h1>
                <p class="page-intro">Built by Suraj Giri — productivity researcher and software engineer — after a browser timer drifted by 47 seconds and ruined dinner. The Blog Timer exists because the timer in your browser tab is probably lying to you, and most people don't realize how much that matters.</p>
                <p class="page-byline">By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a> &middot; Updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-value">220+</div>
                    <div class="stat-label">Timer Presets</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Accuracy Tests</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Trackers in Face</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">100%</div>
                    <div class="stat-label">Free Forever</div>
                </div>
            </div>

            <section class="section">
                <h2 class="section-title">The Cooking Disaster That Started This</h2>
                <p>In early 2023 I was reducing a beurre blanc on the stove. I'd set a 12-minute countdown in a popular browser tab timer and walked away to answer Slack messages in another window. When I came back, the sauce had broken. The timer said 4 minutes 18 seconds remaining. The stove clock said I'd been gone almost 20 minutes.</p>
                <p>The timer had silently drifted. The browser tab had been throttled in the background — a thing modern browsers do aggressively to save battery — and the timer's <code>setInterval</code> loop had simply stopped ticking at its normal rate. The visual countdown kept showing time remaining, but the underlying clock had fallen badly out of sync with reality.</p>
                <p>I'm a software engineer. I spent the next weekend reading the Chromium source code on background tab throttling, the Page Visibility API spec, and the W3C High Resolution Time documentation. What I found was the same architectural mistake repeated across nearly every "online timer" site I tested: counting <em>down</em> using browser intervals, instead of comparing the current wall-clock time against a stored target timestamp.</p>
                <p>It's a small bug. It's also why your kitchen smells like burnt cream.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Why The Blog Timer Exists</h2>
                <div class="two-col">
                    <div class="col">
                        <p>The Blog Timer was built to solve one problem: provide a browser-based countdown that <strong>does not drift</strong>, on any device, in any tab state, even when your laptop sleeps for an hour and wakes back up. That is a surprisingly tall order in 2025. Most timer sites get it wrong.</p>
                        <p>From there, the project grew. I added 220+ presets covering the durations real humans actually use — 25 minutes for Pomodoro (after Francesco Cirillo's 1992 technique, formalized in his 2006 book <a href="https://francescocirillo.com/products/the-pomodoro-technique" rel="nofollow noopener" target="_blank">The Pomodoro Technique</a>), 20-second Tabata bursts (from <a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">Tabata et al., 1996</a>), 26-minute power naps (the sweet spot identified by <a href="https://www.nasa.gov/history/alsj/a17/A17_FlightPlan.html" rel="nofollow noopener" target="_blank">NASA's 1995 fatigue-countermeasure study</a> and replicated in <a href="https://pubmed.ncbi.nlm.nih.gov/12377301/" rel="nofollow noopener" target="_blank">Mednick et al., 2002</a>), and so on.</p>
                        <p>Every duration on this site has a reason. We don't make up presets to fill out an SEO grid. If we list a 90-minute timer, it's because Daniel Levitin's research on ultradian rhythms in <em>The Organized Mind</em> (2014) suggests 90-minute focus blocks align with the human attention cycle. If we list 161 minutes, it's because someone wrote in asking for a "epic focus block" length and we shipped it.</p>
                    </div>
                    <div class="col">
                        <div class="highlight-box highlight-box--accent">
                            <h3>What Makes The Blog Timer Different</h3>
                            <ul>
                                <li><strong>Timestamp-based engine</strong> — we store the end time, not a counter. Read the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">testing methodology</a> for the full protocol.</li>
                                <li><strong>Open testing methodology</strong> — every accuracy claim we make is replicable. Drift is measured in milliseconds against <code>performance.now()</code> and verified against system clocks.</li>
                                <li><strong>No tracking in your face</strong> — no email walls, no popups, no autoplay, no engagement nudges. See our <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a> for the full list of things we refuse to do.</li>
                                <li><strong>Citations to real research</strong> — every productivity claim links to a real study, not a Medium article. See the full <a href="<?php echo esc_url(home_url('/sources/')); ?>">source list</a>.</li>
                                <li><strong>Public changelog</strong> — see exactly what we change and when in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">editorial changelog</a>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Methodology Overview: Timestamp-Based, Not setInterval</h2>
                <p>In our testing, the single biggest cause of browser-timer inaccuracy is the use of <code>setInterval(fn, 1000)</code> as the heartbeat of the countdown. JavaScript does not promise that interval will fire every 1000ms. Browsers throttle background tabs to roughly one tick per minute. Operating systems pause JavaScript execution entirely when the device sleeps. Mobile Safari kills timers when the app loses focus.</p>
                <p>The Blog Timer's engine works differently. When you click start, we record an end timestamp: <code>endTime = Date.now() + duration</code>. From that point forward, every UI update is just a subtraction: <code>remaining = endTime - Date.now()</code>. We never trust an interval to measure elapsed time. The interval only triggers <em>re-renders</em>; the math is anchored to the real clock.</p>
                <p>The result: if you start a 25-minute Pomodoro, switch tabs for 24 minutes, close your laptop lid for 6 minutes, then come back — the timer correctly reads zero. It does not show "5 minutes remaining." It does not silently desync. It tells you the truth. We document this exhaustively, including the 8 tests we run against every release, on the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a>.</p>
                <p>For the deep-dive on why this matters for productivity protocols specifically, Cal Newport's <a href="https://www.calnewport.com/books/deep-work/" rel="nofollow noopener" target="_blank">Deep Work</a> (2016) makes a strong case that even small interruptions — and silent timer failures are interruptions — measurably degrade cognitive performance through "attention residue." A timer that lies to you isn't a productivity tool; it's a productivity hazard.</p>
            </section>

            <section class="section">
                <h2 class="section-title">The Team</h2>
                <div class="two-col">
                    <div class="col">
                        <h3>Suraj Giri — Founder, Engineer, Editor</h3>
                        <p>I built The Blog Timer and write most of the content on it. My background is web development (frontend systems, performance work) and undergraduate research in cognitive psychology — specifically attention and time perception. I've been using Pomodoro since 2014, daily, with one notebook per quarter to track session quality. That practice is where most of the editorial intuition on this site comes from.</p>
                        <p>For now, the team is just me. As the site grows I expect to bring in subject-matter contributors — particularly for the cooking, exercise, and meditation timer guides — but every contributor will be named on the byline, will follow the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a>, and will have a public author page like the one at <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">/author-suraj-giri/</a>.</p>
                        <p>Reach me at <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> for corrections, citations you think we should add, or methodology questions.</p>
                    </div>
                    <div class="col">
                        <h3>Editorial Advisors (Future)</h3>
                        <p>We intend to credit external advisors as the content scope widens. Specifically:</p>
                        <ul>
                            <li><strong>Sleep and naps</strong> — content on the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> currently cites Sara Mednick's research; an advisor with formal sleep-science credentials would strengthen this.</li>
                            <li><strong>HIIT and exercise protocols</strong> — Tabata, EMOM, and AMRAP timing draws from sports-science literature; a CSCS-credentialed advisor would review the <a href="<?php echo esc_url(home_url('/interval-timer/')); ?>">interval timer</a> guides.</li>
                            <li><strong>Food safety</strong> — egg, poultry, and meat timing references USDA and FDA tables; a culinary instructor or food scientist will eventually own the <a href="<?php echo esc_url(home_url('/egg-timer/')); ?>">egg timer</a> guide.</li>
                        </ul>
                        <p>If any of those describe you and you want to contribute, write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a>.</p>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Our Trust Commitments</h2>
                <p>The Blog Timer makes specific, falsifiable commitments about how this site behaves. If we violate any of these, that's a correction and a public note in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">changelog</a>. Not an excuse.</p>

                <div class="features-grid">
                    <div class="feature-card card">
                        <div class="feature-icon">&#128274;</div>
                        <h3>No Tracking In Your Face</h3>
                        <p>We do not use behavioral popups, exit-intent overlays, autoplay video, browser-push prompts, newsletter modals, or "share before reading" gates. Operational analytics and the privacy policy are documented on the <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">privacy page</a>. If you don't want any of it, our timers still work without it — the timing engine runs entirely in your browser.</p>
                    </div>
                    <div class="feature-card card">
                        <div class="feature-icon">&#128176;</div>
                        <h3>No Affiliate Links (Currently)</h3>
                        <p>At time of writing, there are zero affiliate links on this site. If that ever changes, every affiliate link will be marked <code>rel="sponsored"</code> per <a href="https://developers.google.com/search/blog/2019/09/evolving-nofollow-new-ways-to-identify" rel="nofollow noopener" target="_blank">Google's 2019 link-attribute guidance</a> and disclosed in the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a>. We will never recommend a product we have not used.</p>
                    </div>
                    <div class="feature-card card">
                        <div class="feature-icon">&#128221;</div>
                        <h3>Citations to Real Studies</h3>
                        <p>If we say "research shows naps under 30 minutes restore alertness without sleep inertia," there is a link to the actual paper. We cite Mednick (2002), Hayashi (1999), Tabata (1996), Cirillo (2006), Newport (2016), and 20+ others. The full bibliography lives at <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a>.</p>
                    </div>
                    <div class="feature-card card">
                        <div class="feature-icon">&#128296;</div>
                        <h3>Public Methodology</h3>
                        <p>Our <a href="<?php echo esc_url(home_url('/methodology/')); ?>">testing methodology</a> documents the exact 8 tests we run on the timer engine against every release, the browser/OS matrix we test on, and the statistical reporting we use. You can replicate it.</p>
                    </div>
                    <div class="feature-card card">
                        <div class="feature-icon">&#128221;</div>
                        <h3>Public Changelog</h3>
                        <p>Every editorial change of substance — a new guide, a corrected fact, an updated study citation, an infrastructure change — is logged in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">editorial changelog</a> with a date and a one-line description. Silent rewrites are an antipattern.</p>
                    </div>
                    <div class="feature-card card">
                        <div class="feature-icon">&#128279;</div>
                        <h3>Corrections, Fast</h3>
                        <p>If you find a factual error, write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> and I will fix it within 72 hours or explain why I disagree. Corrections get a dated note in the changelog. See the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">corrections policy</a>.</p>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">What "Productivity Research" Means Here</h2>
                <p>The phrase "productivity research" is heavily abused on the internet. On The Blog Timer, it means a specific thing: claims about how humans manage time and attention are grounded in cited, peer-reviewed studies, the seminal practitioner texts (Cirillo, Newport, Levitin, Csikszentmihalyi), or our own direct measurement. We do not cite LinkedIn posts. We do not cite "studies show" without naming the study.</p>
                <p>When we make a claim that cannot be sourced, we say so. For example, the claim that a 90-minute focus block is optimal is sometimes overstated — Levitin's framing of ultradian cycles in <em>The Organized Mind</em> (2014) is more nuanced than the popular "90-90-90" Twitter formulation suggests. We say that, on the <a href="<?php echo esc_url(home_url('/sprint-timer/')); ?>">sprint timer</a> guides, instead of pretending the research is cleaner than it is.</p>
                <p>The full bibliography, organized by topic, is at <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a>. If a guide makes a claim that is <em>not</em> backed by a source listed there, that's a bug — please report it.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Architecture and Sustainability</h2>
                <p>The Blog Timer runs on minimal infrastructure: WordPress on a Cloudways-managed DigitalOcean droplet behind Cloudflare. The timer engine itself is vanilla JavaScript — no frameworks, no build step, no runtime dependencies that could rot. The total client-side JS for a timer page is well under 30KB after gzip. Pages serve in under 200ms on a warm cache.</p>
                <p>That architecture matters because it makes the no-tracking, no-ads-in-face commitments actually sustainable. Sites that depend on aggressive monetization to cover bloated infrastructure inevitably break the trust commitments first. The Blog Timer's running cost is low enough that we can afford to keep it the way it is.</p>
                <p>If you want to know the exact stack, see the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a> — there is a full disclosure of every browser, OS, and tooling version we use to verify accuracy.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Explore More</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/methodology/')); ?>">How we test timer accuracy (full 8-test protocol)</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial policy and corrections workflow</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources/')); ?>">Bibliography of cited studies</a></li>
                    <li><a href="<?php echo esc_url(home_url('/changelog/')); ?>">Editorial changelog</a></li>
                    <li><a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">About the author: Suraj Giri</a></li>
                    <li><a href="<?php echo esc_url(home_url('/minute-timers/')); ?>">Browse all minute timers</a></li>
                    <li><a href="<?php echo esc_url($pomodoro_cluster_url); ?>">Pomodoro guide cluster</a></li>
                </ul>
            </section>

        </article>
    </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AboutPage",
  "name": "About The Blog Timer",
  "url": "<?php echo esc_url(home_url('/about/')); ?>",
  "description": "About The Blog Timer: built by Suraj Giri to solve browser-timer drift. Timestamp-based timing engine, open testing methodology, no tracking in your face.",
  "mainEntity": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "<?php echo esc_url(home_url('/')); ?>",
    "founder": {
      "@type": "Person",
      "name": "Suraj Giri",
      "email": "suraj@theblogtimer.com",
      "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>",
      "jobTitle": "Productivity researcher and software engineer"
    }
  },
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"
  }
}
</script>

<?php
get_footer();
?>
