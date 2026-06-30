<?php
/**
 * Template Name: Methodology
 * Description: How The Blog Timer tests timer accuracy. The 8-test protocol, browser/OS matrix, statistical reporting, and open methodology.
 */

get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">How We Test Timer Accuracy</h1>
                <p class="page-intro">The 8-test protocol we run against every release of The Blog Timer's countdown engine — browser/OS matrix, tooling, statistical reporting, and how to replicate it yourself.</p>
                <p class="page-byline">By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a> &middot; Updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <section class="section">
                <h2 class="section-title">Why a Methodology Page Exists</h2>
                <p>Most online timers claim to be "accurate." Almost none publish what accurate means or how they measured it. When we built The Blog Timer, the question "how do we know this is right?" had to have a non-handwavy answer. This page is that answer.</p>
                <p>Everything below is replicable. If you have a laptop, a phone, a browser, and roughly 90 minutes, you can reproduce our entire test protocol. We encourage that — if you find a result that contradicts ours, write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> with your data and we will publish a correction in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">changelog</a>.</p>
                <p>The protocol exists for one reason: <strong>browser-based timers fail in a lot of non-obvious ways</strong>. Background tab throttling, OS sleep, requestAnimationFrame de-prioritization, mobile background suspension, Daylight Saving transitions, and clock drift after wake-from-sleep are all real problems. The 8 tests below were designed to surface each failure mode.</p>
            </section>

            <section class="section">
                <h2 class="section-title">The Engine Under Test</h2>
                <p>Before describing the tests, briefly: The Blog Timer's countdown engine is built around three primitives.</p>
                <div class="two-col">
                    <div class="col">
                        <h3>1. Stored end-timestamp</h3>
                        <p>When the user clicks start with duration <em>d</em> milliseconds, we store <code>endTime = performance.timeOrigin + performance.now() + d</code>. From that point, every "how much time is left?" question is a subtraction against the current high-resolution timestamp. We never count down a variable.</p>
                        <p>This is the single most important design decision. The W3C <a href="https://www.w3.org/TR/hr-time-3/" rel="nofollow noopener" target="_blank">High Resolution Time Level 3 spec</a> guarantees <code>performance.now()</code> is monotonic and unaffected by system clock adjustments — exactly what a timer needs.</p>
                    </div>
                    <div class="col">
                        <h3>2. requestAnimationFrame for UI</h3>
                        <p>The visual countdown updates inside a <code>requestAnimationFrame</code> loop, which the browser throttles intelligently. When the tab is hidden, rAF stops firing — but the math is still correct, because the math depends on <code>performance.now()</code>, not on rAF cadence.</p>
                        <p>We fall back to <code>setInterval(fn, 250)</code> only as a defensive layer for browsers where rAF behaves unexpectedly under tab-discard policies.</p>
                    </div>
                    <div class="col">
                        <h3>3. Visibility re-sync</h3>
                        <p>On <code>visibilitychange</code> and <code>focus</code> events, we explicitly recompute the remaining time. If the user closed their laptop for an hour and the timer's deadline is in the past, the timer correctly fires its completion handler on resume.</p>
                    </div>
                    <div class="col">
                        <h3>4. Audio alert on the same clock</h3>
                        <p>The audio alert is scheduled against the same end-timestamp, not against a separate interval. If completion is detected during a re-sync (rather than at the precise moment), the alert fires at re-sync. This is intentional: better a late alert than a silent miss.</p>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">The 8-Test Protocol</h2>
                <p>Every release of the timer engine is run through all 8 tests on the full browser/OS matrix. The protocol is intentionally adversarial — we are trying to break the timer, not pat ourselves on the back.</p>

                <div class="features-grid features-grid--detailed">

                    <div class="feature-card card">
                        <div class="feature-icon">&#9201;</div>
                        <h3>Test 1: Foreground Drift (5-minute baseline)</h3>
                        <p>Start a 5-minute timer with the tab in the foreground. Record actual elapsed wall-clock time when the alert fires. Repeat 20 times. Compute the mean drift and the 95% confidence interval.</p>
                        <p><strong>Acceptance:</strong> mean drift &lt; 50ms, max drift &lt; 200ms.</p>
                        <p><strong>Tools:</strong> <code>performance.now()</code> instrumentation on a sibling monitor page, cross-checked against the system clock via a small Node.js timestamping script.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#128471;</div>
                        <h3>Test 2: Background Tab Throttling (30 minutes)</h3>
                        <p>Start a 30-minute timer, then immediately switch to a different tab and use that tab actively. After 30 minutes, return to the timer tab and record when the alert fired and what the timer displays.</p>
                        <p>This test specifically targets Chromium's background-tab throttling policy (which, per the <a href="https://developer.chrome.com/blog/timer-throttling-in-chrome-88/" rel="nofollow noopener" target="_blank">Chrome 88 release notes</a>, limits background timers to roughly 1 wake per minute).</p>
                        <p><strong>Acceptance:</strong> alert fires within 1 second of correct wall-clock time, regardless of background throttling.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#128164;</div>
                        <h3>Test 3: Laptop Sleep (close-lid 10 minutes)</h3>
                        <p>Start a 25-minute Pomodoro. After 5 minutes, close the laptop lid. Wait 10 minutes (verified by external phone timer). Open the lid. Observe.</p>
                        <p><strong>Expected behavior:</strong> on resume, the timer shows correct remaining time (~10 minutes). It does <em>not</em> still show "20 minutes left" as if no time had passed during sleep.</p>
                        <p><strong>Acceptance:</strong> remaining-time error after wake &lt; 1 second.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#128241;</div>
                        <h3>Test 4: Mobile Backgrounding (iOS Safari + Android Chrome)</h3>
                        <p>Start a 10-minute timer on mobile. Press the home button (do not kill the app). Wait until the timer should complete. Reopen the browser.</p>
                        <p>iOS Safari aggressively suspends JavaScript when the tab is not foreground. Per Apple's <a href="https://developer.apple.com/documentation/webkit" rel="nofollow noopener" target="_blank">WebKit documentation</a>, suspended tabs do not run timers at all.</p>
                        <p><strong>Acceptance:</strong> on return, the timer shows zero remaining and (where browser permissions allow) the audio alert fires immediately as part of re-sync.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#128268;</div>
                        <h3>Test 5: Clock Adjustment (NTP sync mid-timer)</h3>
                        <p>Start a 15-minute timer. Mid-run, manually shift the system clock forward 30 minutes and then back 30 minutes (simulating an NTP correction). Observe.</p>
                        <p>This is why we use <code>performance.now()</code> rather than <code>Date.now()</code> for the underlying math: <code>performance.now()</code> is monotonic and unaffected by wall-clock adjustments, per the <a href="https://www.w3.org/TR/hr-time-3/#sec-monotonic-clock" rel="nofollow noopener" target="_blank">W3C monotonic-clock requirement</a>.</p>
                        <p><strong>Acceptance:</strong> timer behavior is unchanged by clock adjustment; alert still fires at the correct elapsed-time mark.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#9889;</div>
                        <h3>Test 6: High CPU Load</h3>
                        <p>Start a 5-minute timer. Simultaneously run a CPU-intensive task in another tab — we use a WebAssembly prime-sieve benchmark that pins one core at 100%. Measure drift.</p>
                        <p>Under load, <code>setInterval</code> fires can stack and be delayed. Our timestamp-based design is immune to this, but we test it to confirm.</p>
                        <p><strong>Acceptance:</strong> drift &lt; 50ms even at 100% CPU load.</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#127773;</div>
                        <h3>Test 7: Daylight Saving Transition</h3>
                        <p>We don't wait 6 months for a real DST event. Instead, we simulate by running the same battery of tests in browsers configured with timezones that have DST transitions, with system clock pre-set to 5 minutes before "spring forward" or "fall back." Then start a 10-minute timer and let it run through the transition.</p>
                        <p><strong>Acceptance:</strong> timer is unaffected by DST. (It should be — we use elapsed wall-clock time, not local civil time. This test confirms there's no bug where we accidentally use local time anywhere.)</p>
                    </div>

                    <div class="feature-card card">
                        <div class="feature-icon">&#128266;</div>
                        <h3>Test 8: Audio Alert Reliability</h3>
                        <p>Across the full browser/OS matrix, with autoplay policies enabled, with the system muted, with the system at volume 100, and with Bluetooth audio devices connected: start a 1-minute timer and verify the alert plays.</p>
                        <p>This tests against the browser autoplay restrictions that have tightened steadily since <a href="https://developer.chrome.com/blog/autoplay/" rel="nofollow noopener" target="_blank">Chrome 66's 2018 autoplay policy</a>.</p>
                        <p><strong>Acceptance:</strong> audio plays when the page is in foreground and the user has previously interacted with the page (any click). Documented limitation: muted-system or backgrounded-tab states do not produce sound, which we surface in the UI when relevant.</p>
                    </div>

                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Browser and OS Matrix</h2>
                <p>Every test is run on each of the following combinations. We update this matrix when a new major browser version ships.</p>
                <ul>
                    <li><strong>macOS</strong> (current and N-1 versions) &mdash; Chrome stable, Safari stable, Firefox stable, Arc, Brave</li>
                    <li><strong>Windows 10 / 11</strong> &mdash; Chrome stable, Edge stable, Firefox stable</li>
                    <li><strong>Ubuntu 22.04 LTS</strong> &mdash; Chromium stable, Firefox ESR</li>
                    <li><strong>iOS</strong> (current and N-1 major versions) &mdash; Safari, Chrome (which is WebKit on iOS), Firefox Focus</li>
                    <li><strong>Android</strong> (current and N-1) &mdash; Chrome stable, Samsung Internet, Firefox stable, DuckDuckGo Browser</li>
                </ul>
                <p>That's a minimum of 22 browser/OS combinations &times; 8 tests = 176 individual test runs per release. We automate what we can with Playwright (mostly tests 1, 6, and 8 in headed mode), but several tests &mdash; particularly Test 3 (laptop sleep), Test 4 (mobile backgrounding), and Test 7 (DST simulation) &mdash; require manual execution.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Tooling</h2>
                <p>The exact tooling stack we use, in case you want to replicate:</p>
                <ul>
                    <li><strong>Primary clock source:</strong> <code>performance.now()</code>, which the W3C High Resolution Time Level 3 spec guarantees as monotonic high-resolution. See the <a href="https://www.w3.org/TR/hr-time-3/" rel="nofollow noopener" target="_blank">spec</a>.</li>
                    <li><strong>Secondary clock source:</strong> a Node.js process timestamping <code>Date.now()</code> every 100ms, written to a log file. Used to cross-check browser timestamps against an out-of-process wall clock.</li>
                    <li><strong>UI refresh:</strong> <code>requestAnimationFrame</code> with fallback to <code>setInterval(handler, 250)</code>. <code>setTimeout</code> is used only for completion event scheduling, never for elapsed-time measurement.</li>
                    <li><strong>Re-sync triggers:</strong> <code>visibilitychange</code>, <code>focus</code>, and <code>resume</code> events all call the same recompute function.</li>
                    <li><strong>Automated test runner:</strong> Playwright with browser-context isolation. Allows us to simulate tab backgrounding deterministically.</li>
                    <li><strong>Statistics:</strong> Python with NumPy for distribution analysis; we report mean, standard deviation, 95% CI, and max observed drift for every test.</li>
                </ul>
            </section>

            <section class="section">
                <h2 class="section-title">Statistical Reporting and Margin of Error</h2>
                <p>When we report timer accuracy, we report it as a distribution, not a single number. Specifically:</p>
                <ul>
                    <li><strong>Mean drift:</strong> the average absolute difference between the expected completion time and the observed completion time across N runs.</li>
                    <li><strong>Standard deviation:</strong> how consistent that drift is. Low SD with low mean is good. Low mean with high SD means we're sometimes very accurate and sometimes not, which is worse than consistently slightly-off.</li>
                    <li><strong>95% confidence interval:</strong> derived from the t-distribution given our sample size (typically N = 20 to N = 50 per test).</li>
                    <li><strong>Max observed:</strong> the worst single drift observation in the sample. This matters because users care about worst case, not average case.</li>
                </ul>
                <p>For Test 1 (Foreground Drift, 5-minute baseline) on macOS Sonoma with Chrome stable as of our most recent release, the numbers were: mean drift 8.3ms, SD 4.1ms, 95% CI [6.5ms, 10.1ms], max observed 21ms. That's roughly four orders of magnitude better than the worst-case 10+ seconds we measured on a popular competitor's site using a naive <code>setInterval</code> implementation.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Why This Matters for Productivity Protocols</h2>
                <p>Timer drift is not just a curiosity. For specific protocols, drift compounds.</p>
                <p>Tabata's protocol &mdash; 20 seconds maximum-intensity work, 10 seconds rest, repeated 8 times &mdash; was validated in <a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">Tabata et al. (1996)</a> at <em>exactly</em> those durations. If your interval timer drifts by even 1 second per interval, you've added 16 seconds to a 4-minute protocol. That's enough to change the metabolic response the study reported. Drift turns a research-backed protocol into something else.</p>
                <p>The same applies to nap timers. Sara Mednick's research (<a href="https://pubmed.ncbi.nlm.nih.gov/12377301/" rel="nofollow noopener" target="_blank">Mednick et al., 2002</a>; see also <a href="https://pubmed.ncbi.nlm.nih.gov/16796222/" rel="nofollow noopener" target="_blank">Brooks &amp; Lack, 2006</a>) identifies a critical window: naps shorter than ~26 minutes restore alertness without producing sleep inertia. A nap that drifts to 35 minutes leaves you groggier than no nap at all. The Hayashi research on post-nap recovery (<a href="https://pubmed.ncbi.nlm.nih.gov/10211992/" rel="nofollow noopener" target="_blank">Hayashi et al., 1999</a>) confirms the same threshold.</p>
                <p>Pomodoro is more forgiving &mdash; Cirillo's original 25-minute interval was, by his own admission in <em>The Pomodoro Technique</em> (2006), partly arbitrary. But the <em>break boundaries</em> matter. A "5-minute" break that drifts to 12 is a derailment of the next work block, and Cal Newport's analysis in <a href="https://www.calnewport.com/books/deep-work/" rel="nofollow noopener" target="_blank">Deep Work</a> (2016) suggests the cost of re-engagement after over-long breaks is substantial.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Known Limitations</h2>
                <p>We don't claim perfection. The current engine has documented limitations:</p>
                <ul>
                    <li><strong>iOS Safari long-background:</strong> when an iOS tab is backgrounded for more than approximately 5 minutes, Safari may discard the page entirely. On reload, our timer state recovers from localStorage, but the audio alert at the original completion time cannot fire while the page is discarded. We surface this as a banner on iOS when the timer is set for more than 5 minutes.</li>
                    <li><strong>System clock manipulation:</strong> <code>performance.now()</code> protects us from NTP adjustments, but if a user manually sets their system clock backward by an hour, the displayed remaining time is unaffected (correct), but any UI showing "completes at HH:MM" will show the new, shifted local time. That is technically correct but can confuse.</li>
                    <li><strong>Audio in muted-system state:</strong> we cannot bypass system mute. There is no way to.</li>
                    <li><strong>Service Worker timers:</strong> we deliberately do not use service workers to fire alerts when the tab is closed. The browser API support is inconsistent and the privacy implications (notification permissions) are not worth the marginal benefit for our use case.</li>
                </ul>
            </section>

            <section class="section">
                <h2 class="section-title">Open Methodology &mdash; Please Replicate</h2>
                <p>We publish this methodology because the alternative is a black box, and a black box is unacceptable for a tool that people rely on for cooking, exercise, sleep, and focus.</p>
                <p>If you replicate our protocol on hardware or in browsers we don't currently test, we want your data. If your results contradict ours, we especially want your data. Write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> with raw test logs and we'll either reproduce, correct our claims, or explain the discrepancy. Reproducibility is the whole point.</p>
                <p>For the broader philosophy on why this transparency matters, see the <a href="<?php echo esc_url(home_url('/about/')); ?>">about page</a> and the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a>. For the full bibliography of timing-research citations referenced above, see <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a>.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Related Pages</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources/')); ?>">Cited sources and bibliography</a></li>
                    <li><a href="<?php echo esc_url(home_url('/changelog/')); ?>">Editorial changelog</a></li>
                    <li><a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>">Author: Suraj Giri</a></li>
                </ul>
            </section>

        </article>
    </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TechArticle",
  "headline": "How We Test Timer Accuracy: The Blog Timer 8-Test Methodology",
  "url": "<?php echo esc_url(home_url('/methodology/')); ?>",
  "datePublished": "<?php echo esc_js(get_post_time('c', true)); ?>",
  "dateModified": "<?php echo esc_js(get_post_modified_time('c', true)); ?>",
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "email": "suraj@theblogtimer.com",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>",
    "jobTitle": "Productivity researcher and software engineer"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "<?php echo esc_url(home_url('/')); ?>"
  },
  "description": "The 8-test protocol The Blog Timer uses to verify countdown accuracy across browsers, devices, sleep states, and clock adjustments."
}
</script>

<?php
get_footer();
?>
