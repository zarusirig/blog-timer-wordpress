<?php
/**
 * Template Name: Author - Suraj Giri
 * Description: Author bio page for Suraj Giri, founder and editor of The Blog Timer.
 */

get_header();
?>

<main class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">Suraj Giri</h1>
                <p class="page-intro">Productivity researcher, software engineer, and founder of The Blog Timer. Writes about attention, timing, and the design of tools that don't get in your way.</p>
                <p class="page-byline">Author profile &middot; Updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <section class="section">
                <h2 class="section-title">Background</h2>
                <p>I'm a web developer by trade and a productivity researcher by obsession. My background is in frontend systems and web performance &mdash; I've spent most of my professional career building fast, well-instrumented interfaces. My academic background is in cognitive psychology, with undergraduate research focused on attention and time perception. Those two things converged into The Blog Timer.</p>
                <p>I have used the Pomodoro Technique daily since 2014. I keep a paper journal of session quality each quarter. Most of the editorial intuition on this site &mdash; what's worth a guide, what's overhyped, what the actual research says versus what Twitter says it says &mdash; comes from that practice.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Why I Built The Blog Timer</h2>
                <p>In short: a browser timer drifted on me while I was reducing a sauce, and dinner was ruined. The longer version is on the <a href="<?php echo esc_url(home_url('/about/')); ?>">about page</a>. The condensed version: most browser-based timers count down using <code>setInterval</code>, which browsers throttle aggressively in background tabs. The result is a timer that quietly lies to you. I built The Blog Timer's engine around stored end-timestamps so this class of bug cannot occur. The full testing protocol is on the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a>.</p>
                <p>From there, the project expanded into a 220+ preset library covering Pomodoro work blocks, Tabata intervals, NASA-grade nap durations, and a long tail of cooking, study, and meditation timings. Every preset is anchored either to a primary research source (see <a href="<?php echo esc_url(home_url('/sources/')); ?>">/sources/</a>) or to a documented user request &mdash; never to fill out an SEO grid.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Areas of Expertise</h2>
                <ul>
                    <li><strong>Web performance &amp; browser timing APIs.</strong> <code>performance.now()</code>, <code>requestAnimationFrame</code>, the Page Visibility API, autoplay policies, background-tab throttling, service workers. Hands-on for ~10 years.</li>
                    <li><strong>Productivity protocols.</strong> Pomodoro (Cirillo 2006), deep work (Newport 2016), deliberate practice (Ericsson 1993), ultradian rhythms (Kleitman 1963, Levitin 2014). Daily user since 2014; reads the underlying papers, not just the popular write-ups.</li>
                    <li><strong>Cognitive psychology of attention.</strong> Undergraduate research foundation; ongoing reading of Posner, Kahneman, Killingsworth, Mark, and Leroy. Comfortable distinguishing what the research says from what self-help books say it says.</li>
                    <li><strong>Sleep science (intermediate).</strong> Familiar with the Mednick / Hayashi / Brooks-Lack literature on short-duration naps; happy to be corrected by formally credentialed sleep scientists, and actively recruiting one as an editorial advisor.</li>
                    <li><strong>HIIT and interval-training programming (intermediate).</strong> Have read the Tabata 1996 original, Gibala's review work, and Buchheit &amp; Laursen's HIIT programming framework. Not a credentialed coach.</li>
                </ul>
                <p>Where my expertise is intermediate or thin (sleep, exercise, cooking), I default to citing the strongest primary sources I can find and clearly flagging open questions. That's the only honest move.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Contact</h2>
                <ul>
                    <li><strong>Email:</strong> <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> &mdash; for corrections, citation suggestions, contributor pitches, and methodology questions. I read everything; I respond within 72 hours.</li>
                    <li><strong>Corrections:</strong> see the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a> for the formal corrections process. Confirmed corrections get a dated note in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">changelog</a>.</li>
                    <li><strong>Press / interview / citation requests:</strong> same email. Happy to talk about timer accuracy, browser-timing internals, or the productivity research literature.</li>
                </ul>
            </section>

            <section class="section">
                <h2 class="section-title">Editorial Standards I Hold Myself To</h2>
                <p>Briefly &mdash; the full version lives on the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">editorial policy</a>:</p>
                <ul>
                    <li>Every empirical claim links to a primary source. No "studies show" without a study.</li>
                    <li>Where I'm not credentialed, I say so, and I cite people who are.</li>
                    <li>Corrections are public, dated, and logged. Silent rewrites are not acceptable.</li>
                    <li>AI is a tool I use for outlining and language polish. It is not allowed to generate citations or empirical claims; every fact must be verified by me.</li>
                    <li>No paid placements. No affiliate links (currently). No newsletter dark patterns.</li>
                </ul>
            </section>

            <section class="section">
                <h2 class="section-title">Recent Guides Published</h2>
                <p>A rolling selection of guides I have authored or substantially edited recently. (This list will be replaced by an auto-generated query once the byline is wired into the <code>guide</code> custom post type.)</p>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/pomodoro/')); ?>">Pomodoro Technique: the full guide</a></li>
                    <li><a href="<?php echo esc_url(home_url('/interval-timer/')); ?>">Interval timer for HIIT, Tabata, and EMOM</a></li>
                    <li><a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">Science-backed power nap timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sprint-timer/')); ?>">Sprint timer for focused work blocks</a></li>
                    <li><a href="<?php echo esc_url(home_url('/egg-timer/')); ?>">Egg timer with food-science temperature anchors</a></li>
                    <li><a href="<?php echo esc_url(home_url('/presentation-timer/')); ?>">Presentation timer for talks and lightning sessions</a></li>
                    <li><a href="<?php echo esc_url(home_url('/chess-clock/')); ?>">Chess clock for two-player games and debates</a></li>
                    <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">All guides &mdash; full archive</a></li>
                </ul>
            </section>

            <section class="section">
                <h2 class="section-title">Related Pages</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer (origin story)</a></li>
                    <li><a href="<?php echo esc_url(home_url('/methodology/')); ?>">Timer-accuracy testing methodology</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sources/')); ?>">Bibliography of cited sources</a></li>
                    <li><a href="<?php echo esc_url(home_url('/changelog/')); ?>">Editorial changelog</a></li>
                </ul>
            </section>

        </article>
    </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfilePage",
  "@id": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>#profilepage",
  "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>",
  "mainEntity": {
    "@type": "Person",
    "@id": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>#person",
    "name": "Suraj Giri",
    "givenName": "Suraj",
    "familyName": "Giri",
    "email": "suraj@theblogtimer.com",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>",
    "jobTitle": "Productivity researcher and software engineer",
    "description": "Founder and editor of The Blog Timer. Background in web development and cognitive psychology research, focused on attention and time perception. Built The Blog Timer to solve browser timer accuracy issues.",
    "knowsAbout": [
      "Web performance",
      "Browser timing APIs",
      "Pomodoro Technique",
      "Deep work",
      "Cognitive psychology of attention",
      "Ultradian rhythms",
      "Productivity research"
    ],
    "worksFor": {
      "@id": "<?php echo esc_url(home_url('/')); ?>#organization"
    }
  }
}
</script>

<?php
get_footer();
?>
