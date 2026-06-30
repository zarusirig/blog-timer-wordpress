<?php
/**
 * Template Name: Sources / Bibliography
 * Description: The complete bibliography of works cited across The Blog Timer. Organized by topic.
 */

get_header();
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="content-page">
        <article class="page-content container container--narrow">

            <header class="page-header">
                <h1 class="page-h1">Sources and Bibliography</h1>
                <p class="page-intro">The complete index of works cited across The Blog Timer &mdash; productivity research, sleep science, exercise and HIIT physiology, food safety guidance, and cognitive psychology. Every claim on this site traces back to one of these primary sources.</p>
                <p class="page-byline">Maintained by <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a> &middot; Updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
            </header>

            <section class="section">
                <h2 class="section-title">How to Read This Page</h2>
                <p>Each entry below includes the citation in roughly APA style, the year, the lead author or publishing body, a short note on what we cite the work for, and a link to the canonical version of the source. Where a PubMed PMID, a DOI, or a stable publisher URL exists, that's what we link to &mdash; not a press release or a summary article.</p>
                <p>If a citation here is broken, contradicted by newer research, or used incorrectly elsewhere on the site, write to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a> and we'll fix it. See the <a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">corrections policy</a> for how that works.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Productivity Research</h2>

                <article class="source-entry">
                    <h3>Cirillo, F. (2006). <em>The Pomodoro Technique</em>.</h3>
                    <p><strong>Lead author:</strong> Francesco Cirillo. <strong>Year:</strong> 2006 (technique originally developed 1987&ndash;1992). <strong>Type:</strong> Seminal practitioner book.</p>
                    <p><strong>What we cite it for:</strong> The 25-minute work / 5-minute break canonical structure, the four-pomodoro long-break cycle, and Cirillo's own admission that the 25-minute duration is partly arbitrary (a calibration decision, not a research finding).</p>
                    <p><strong>Link:</strong> <a href="https://francescocirillo.com/products/the-pomodoro-technique" rel="nofollow noopener" target="_blank">francescocirillo.com</a> (official author page).</p>
                </article>

                <article class="source-entry">
                    <h3>Newport, C. (2016). <em>Deep Work: Rules for Focused Success in a Distracted World</em>. Grand Central Publishing.</h3>
                    <p><strong>Lead author:</strong> Cal Newport. <strong>Year:</strong> 2016. <strong>Type:</strong> Seminal practitioner book grounded in cognitive-psychology literature.</p>
                    <p><strong>What we cite it for:</strong> The framework of "deep work" as cognitively demanding, distraction-free work; the cost of "attention residue" (drawing on Sophie Leroy's 2009 research); and the case for blocking long focus sessions rather than short fragmented ones.</p>
                    <p><strong>Link:</strong> <a href="https://www.calnewport.com/books/deep-work/" rel="nofollow noopener" target="_blank">calnewport.com/books/deep-work/</a></p>
                </article>

                <article class="source-entry">
                    <h3>Leroy, S. (2009). Why is it so hard to do my work? The challenge of attention residue when switching between work tasks. <em>Organizational Behavior and Human Decision Processes</em>, 109(2), 168&ndash;181.</h3>
                    <p><strong>Lead author:</strong> Sophie Leroy. <strong>Year:</strong> 2009. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> The "attention residue" phenomenon &mdash; the measurable cognitive cost of leaving a task incomplete before switching. Underpins our argument that silent timer failures are not trivial and that breaks should be discrete and bounded.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1016/j.obhdp.2009.04.002" rel="nofollow noopener" target="_blank">doi.org/10.1016/j.obhdp.2009.04.002</a></p>
                </article>

                <article class="source-entry">
                    <h3>Ericsson, K. A., Krampe, R. T., &amp; Tesch-R&ouml;mer, C. (1993). The role of deliberate practice in the acquisition of expert performance. <em>Psychological Review</em>, 100(3), 363&ndash;406.</h3>
                    <p><strong>Lead author:</strong> K. Anders Ericsson. <strong>Year:</strong> 1993. <strong>Type:</strong> Peer-reviewed foundational paper.</p>
                    <p><strong>What we cite it for:</strong> The deliberate-practice framework &mdash; that improvement requires focused, effortful, feedback-rich work, typically in sessions of bounded duration. The basis for time-boxed practice timers.</p>
                    <p><strong>Link:</strong> <a href="https://psycnet.apa.org/doi/10.1037/0033-295X.100.3.363" rel="nofollow noopener" target="_blank">psycnet.apa.org (DOI 10.1037/0033-295X.100.3.363)</a></p>
                </article>

                <article class="source-entry">
                    <h3>Csikszentmihalyi, M. (1990). <em>Flow: The Psychology of Optimal Experience</em>. Harper &amp; Row.</h3>
                    <p><strong>Lead author:</strong> Mihaly Csikszentmihalyi. <strong>Year:</strong> 1990. <strong>Type:</strong> Foundational practitioner text grounded in 25+ years of empirical research.</p>
                    <p><strong>What we cite it for:</strong> The flow construct &mdash; the conditions under which deep, intrinsically rewarding focus emerges. Cited on the <a href="<?php echo esc_url(home_url('/sprint-timer/')); ?>">sprint timer</a> guides re: long-block focus.</p>
                    <p><strong>Link:</strong> <a href="https://www.harpercollins.com/products/flow-mihaly-csikszentmihalyi" rel="nofollow noopener" target="_blank">harpercollins.com (publisher page)</a></p>
                </article>

                <article class="source-entry">
                    <h3>Mark, G., Gudith, D., &amp; Klocke, U. (2008). The cost of interrupted work: More speed and stress. <em>Proceedings of the SIGCHI Conference on Human Factors in Computing Systems</em>, 107&ndash;110.</h3>
                    <p><strong>Lead author:</strong> Gloria Mark. <strong>Year:</strong> 2008. <strong>Type:</strong> Peer-reviewed conference paper.</p>
                    <p><strong>What we cite it for:</strong> The measured cost of interruptions on knowledge work &mdash; specifically that interrupted workers compensate with speed but at the cost of higher stress and frustration. Underpins our argument for hard-stop timers.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1145/1357054.1357072" rel="nofollow noopener" target="_blank">doi.org/10.1145/1357054.1357072</a></p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Sleep Science</h2>

                <article class="source-entry">
                    <h3>Mednick, S. C., Nakayama, K., &amp; Stickgold, R. (2002). The restorative effect of naps on perceptual deterioration. <em>Nature Neuroscience</em>, 5(7), 677&ndash;681.</h3>
                    <p><strong>Lead author:</strong> Sara C. Mednick. <strong>Year:</strong> 2002. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> The finding that naps of ~30 minutes restore perceptual performance to baseline; the cognitive value of short naps; and (in conjunction with later work) the existence of a sleep-inertia threshold around 30 minutes that we use to anchor the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> presets.</p>
                    <p><strong>Link:</strong> <a href="https://pubmed.ncbi.nlm.nih.gov/12032543/" rel="nofollow noopener" target="_blank">PubMed PMID 12032543</a></p>
                </article>

                <article class="source-entry">
                    <h3>Hayashi, M., Masuda, A., &amp; Hori, T. (1999). The alerting effects of caffeine, bright light and face washing after a short daytime nap. <em>Clinical Neurophysiology</em>, 110(8), 1419&ndash;1427.</h3>
                    <p><strong>Lead author:</strong> Mitsuo Hayashi. <strong>Year:</strong> 1999. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> Post-nap alertness recovery strategies and confirmation of the short-nap (15&ndash;20 min) sweet spot for avoiding sleep inertia. Cited on the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a> page.</p>
                    <p><strong>Link:</strong> <a href="https://pubmed.ncbi.nlm.nih.gov/10454279/" rel="nofollow noopener" target="_blank">PubMed PMID 10454279</a></p>
                </article>

                <article class="source-entry">
                    <h3>Brooks, A., &amp; Lack, L. (2006). A brief afternoon nap following nocturnal sleep restriction: which nap duration is most recuperative? <em>Sleep</em>, 29(6), 831&ndash;840.</h3>
                    <p><strong>Lead author:</strong> Amber Brooks. <strong>Year:</strong> 2006. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> Direct comparison of 5, 10, 20, and 30-minute naps. The finding that 10-minute naps produced the most consistent benefit with the least sleep inertia &mdash; the empirical basis for our 10-minute nap preset.</p>
                    <p><strong>Link:</strong> <a href="https://pubmed.ncbi.nlm.nih.gov/16796222/" rel="nofollow noopener" target="_blank">PubMed PMID 16796222</a></p>
                </article>

                <article class="source-entry">
                    <h3>Rosekind, M. R., Graeber, R. C., Dinges, D. F., et al. (1995). Crew factors in flight operations IX: Effects of planned cockpit rest on crew performance and alertness in long-haul operations. <em>NASA Technical Memorandum 108839</em>.</h3>
                    <p><strong>Lead author:</strong> Mark Rosekind (NASA Ames). <strong>Year:</strong> 1995. <strong>Type:</strong> NASA technical report.</p>
                    <p><strong>What we cite it for:</strong> The "NASA nap" finding &mdash; a planned 26-minute cockpit rest improved pilot performance by ~34% and alertness by ~54%. The reason "NASA nap" appears as a labeled preset on the <a href="<?php echo esc_url(home_url('/nap-timer/')); ?>">nap timer</a>.</p>
                    <p><strong>Link:</strong> <a href="https://ntrs.nasa.gov/citations/19960013817" rel="nofollow noopener" target="_blank">NASA Technical Reports Server (NTRS)</a></p>
                </article>

                <article class="source-entry">
                    <h3>Hirshkowitz, M., Whiton, K., Albert, S. M., et al. (2015). National Sleep Foundation's sleep time duration recommendations: methodology and results summary. <em>Sleep Health</em>, 1(1), 40&ndash;43.</h3>
                    <p><strong>Lead author:</strong> Max Hirshkowitz. <strong>Year:</strong> 2015. <strong>Type:</strong> Peer-reviewed expert-consensus paper.</p>
                    <p><strong>What we cite it for:</strong> The National Sleep Foundation's age-stratified sleep-duration recommendations &mdash; the baseline against which "I'm sleep-deprived enough that a nap is warranted" is reasonably assessed.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1016/j.sleh.2014.12.010" rel="nofollow noopener" target="_blank">doi.org/10.1016/j.sleh.2014.12.010</a></p>
                </article>

                <article class="source-entry">
                    <h3>Tassi, P., &amp; Muzet, A. (2000). Sleep inertia. <em>Sleep Medicine Reviews</em>, 4(4), 341&ndash;353.</h3>
                    <p><strong>Lead author:</strong> Patricia Tassi. <strong>Year:</strong> 2000. <strong>Type:</strong> Peer-reviewed review article.</p>
                    <p><strong>What we cite it for:</strong> The mechanism and duration of sleep inertia &mdash; the post-wake grogginess that arises when a nap crosses into slow-wave sleep, and why nap timing precision matters.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1053/smrv.2000.0098" rel="nofollow noopener" target="_blank">doi.org/10.1053/smrv.2000.0098</a></p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Exercise &amp; HIIT</h2>

                <article class="source-entry">
                    <h3>Tabata, I., Nishimura, K., Kouzaki, M., Hirai, Y., Ogita, F., Miyachi, M., &amp; Yamamoto, K. (1996). Effects of moderate-intensity endurance and high-intensity intermittent training on anaerobic capacity and VO2max. <em>Medicine &amp; Science in Sports &amp; Exercise</em>, 28(10), 1327&ndash;1330.</h3>
                    <p><strong>Lead author:</strong> Izumi Tabata. <strong>Year:</strong> 1996. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> The Tabata protocol &mdash; 20 seconds maximum-intensity work / 10 seconds rest, 8 rounds &mdash; and the original empirical finding that this protocol improved both aerobic and anaerobic capacity more than steady-state cardio. The duration precision (20/10/8) is non-negotiable and is why timer accuracy matters; see the <a href="<?php echo esc_url(home_url('/interval-timer/')); ?>">interval timer</a> guide.</p>
                    <p><strong>Link:</strong> <a href="https://pubmed.ncbi.nlm.nih.gov/8897392/" rel="nofollow noopener" target="_blank">PubMed PMID 8897392</a></p>
                </article>

                <article class="source-entry">
                    <h3>Gibala, M. J., Little, J. P., MacDonald, M. J., &amp; Hawley, J. A. (2012). Physiological adaptations to low-volume, high-intensity interval training in health and disease. <em>The Journal of Physiology</em>, 590(5), 1077&ndash;1084.</h3>
                    <p><strong>Lead author:</strong> Martin Gibala. <strong>Year:</strong> 2012. <strong>Type:</strong> Peer-reviewed review.</p>
                    <p><strong>What we cite it for:</strong> The broader HIIT-physiology literature underpinning interval-training timers beyond Tabata's original protocol &mdash; including longer work/rest ratios and metabolic adaptations.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1113/jphysiol.2011.224725" rel="nofollow noopener" target="_blank">doi.org/10.1113/jphysiol.2011.224725</a></p>
                </article>

                <article class="source-entry">
                    <h3>Buchheit, M., &amp; Laursen, P. B. (2013). High-intensity interval training, solutions to the programming puzzle: Part I and II. <em>Sports Medicine</em>, 43(5), 313&ndash;338; 43(10), 927&ndash;954.</h3>
                    <p><strong>Lead author:</strong> Martin Buchheit. <strong>Year:</strong> 2013. <strong>Type:</strong> Peer-reviewed review (two parts).</p>
                    <p><strong>What we cite it for:</strong> Programming framework for the various HIIT work/rest structures &mdash; long intervals (3&ndash;5 min), short intervals (10&ndash;60 s), repeated-sprint, sprint-interval &mdash; that inform our interval-timer preset library.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1007/s40279-013-0029-x" rel="nofollow noopener" target="_blank">doi.org/10.1007/s40279-013-0029-x</a></p>
                </article>

                <article class="source-entry">
                    <h3>American College of Sports Medicine. (2018). <em>ACSM's Guidelines for Exercise Testing and Prescription</em> (10th ed.). Wolters Kluwer.</h3>
                    <p><strong>Lead author:</strong> ACSM (institutional). <strong>Year:</strong> 2018 (10th ed.). <strong>Type:</strong> Authoritative practice guideline.</p>
                    <p><strong>What we cite it for:</strong> The general exercise-prescription framework, including the FITT-VP model (Frequency, Intensity, Time, Type, Volume, Progression) that informs our timer recommendations for non-HIIT contexts.</p>
                    <p><strong>Link:</strong> <a href="https://www.acsm.org/read-research/books/acsms-guidelines-for-exercise-testing-and-prescription" rel="nofollow noopener" target="_blank">acsm.org</a></p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Cooking &amp; Food Safety</h2>

                <article class="source-entry">
                    <h3>USDA Food Safety and Inspection Service (FSIS). Safe Minimum Internal Temperatures.</h3>
                    <p><strong>Publisher:</strong> United States Department of Agriculture, Food Safety and Inspection Service. <strong>Type:</strong> Authoritative government guidance.</p>
                    <p><strong>What we cite it for:</strong> The canonical minimum-safe internal temperatures for poultry (165&deg;F / 74&deg;C), ground meats (160&deg;F / 71&deg;C), whole cuts of beef/pork/lamb (145&deg;F / 63&deg;C with a 3-minute rest), and seafood (145&deg;F / 63&deg;C). The basis for any cooking-time guidance on this site.</p>
                    <p><strong>Link:</strong> <a href="https://www.fsis.usda.gov/food-safety/safe-food-handling-and-preparation/food-safety-basics/safe-temperature-chart" rel="nofollow noopener" target="_blank">fsis.usda.gov &mdash; Safe Temperature Chart</a></p>
                </article>

                <article class="source-entry">
                    <h3>FDA. (2022). Food Code, 2022.</h3>
                    <p><strong>Publisher:</strong> US Food and Drug Administration. <strong>Year:</strong> 2022 (latest published edition). <strong>Type:</strong> Authoritative regulatory reference.</p>
                    <p><strong>What we cite it for:</strong> Foodservice-grade safe-handling guidance &mdash; time/temperature combinations for pasteurization, the 2-hour danger-zone rule, and cooling-rate requirements that affect any food-related timer recommendation.</p>
                    <p><strong>Link:</strong> <a href="https://www.fda.gov/food/fda-food-code/food-code-2022" rel="nofollow noopener" target="_blank">fda.gov/food/fda-food-code/food-code-2022</a></p>
                </article>

                <article class="source-entry">
                    <h3>Vega, C., Ubbink, J., &amp; van der Linden, E. (Eds.). (2012). <em>The Kitchen as Laboratory: Reflections on the Science of Food and Cooking</em>. Columbia University Press.</h3>
                    <p><strong>Lead editor:</strong> Cesar Vega. <strong>Year:</strong> 2012. <strong>Type:</strong> Peer-reviewed academic essay collection on food science.</p>
                    <p><strong>What we cite it for:</strong> Egg-coagulation thermodynamics and the empirical basis for the soft-boiled (6&ndash;7 min), medium (8&ndash;9 min), and hard-boiled (10&ndash;12 min) timing windows on our <a href="<?php echo esc_url(home_url('/egg-timer/')); ?>">egg timer</a>.</p>
                    <p><strong>Link:</strong> <a href="https://cup.columbia.edu/book/the-kitchen-as-laboratory/9780231153454" rel="nofollow noopener" target="_blank">Columbia University Press</a></p>
                </article>

                <article class="source-entry">
                    <h3>McGee, H. (2004). <em>On Food and Cooking: The Science and Lore of the Kitchen</em> (Revised edition). Scribner.</h3>
                    <p><strong>Lead author:</strong> Harold McGee. <strong>Year:</strong> 2004. <strong>Type:</strong> Seminal food-science reference text.</p>
                    <p><strong>What we cite it for:</strong> The standard reference for the food-science principles underlying cooking-timer recommendations &mdash; protein denaturation, Maillard reaction kinetics, starch gelatinization, and emulsion stability.</p>
                    <p><strong>Link:</strong> <a href="https://www.curiouscook.com/site/on-food-and-cooking.html" rel="nofollow noopener" target="_blank">curiouscook.com</a> (author's site)</p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Cognitive Psychology &amp; Attention</h2>

                <article class="source-entry">
                    <h3>Levitin, D. J. (2014). <em>The Organized Mind: Thinking Straight in the Age of Information Overload</em>. Dutton.</h3>
                    <p><strong>Lead author:</strong> Daniel J. Levitin. <strong>Year:</strong> 2014. <strong>Type:</strong> Seminal practitioner text grounded in cognitive-neuroscience literature.</p>
                    <p><strong>What we cite it for:</strong> The ultradian rhythm framework &mdash; 90-minute cycles in human attention and arousal, originally described by Kleitman, that informs the 90-minute focus block on the <a href="<?php echo esc_url(home_url('/sprint-timer/')); ?>">sprint timer</a>. Also cited (with caveats) for the limits of multitasking.</p>
                    <p><strong>Link:</strong> <a href="https://daniellevitin.com/publicpage/books/the-organized-mind/" rel="nofollow noopener" target="_blank">daniellevitin.com</a></p>
                </article>

                <article class="source-entry">
                    <h3>Kleitman, N. (1963). <em>Sleep and Wakefulness</em> (Revised and enlarged ed.). University of Chicago Press.</h3>
                    <p><strong>Lead author:</strong> Nathaniel Kleitman. <strong>Year:</strong> 1963. <strong>Type:</strong> Foundational sleep-science monograph.</p>
                    <p><strong>What we cite it for:</strong> The original description of the Basic Rest-Activity Cycle (BRAC) &mdash; the 90-minute ultradian rhythm that Levitin and others reference. Cited where we make claims about 90-minute work blocks.</p>
                    <p><strong>Link:</strong> <a href="https://press.uchicago.edu/ucp/books/book/chicago/S/bo3622774.html" rel="nofollow noopener" target="_blank">press.uchicago.edu</a></p>
                </article>

                <article class="source-entry">
                    <h3>Kahneman, D. (2011). <em>Thinking, Fast and Slow</em>. Farrar, Straus and Giroux.</h3>
                    <p><strong>Lead author:</strong> Daniel Kahneman. <strong>Year:</strong> 2011. <strong>Type:</strong> Seminal cognitive-psychology synthesis.</p>
                    <p><strong>What we cite it for:</strong> The System 1 / System 2 framework, which informs why effortful, time-boxed thinking benefits from external timing scaffolds &mdash; we cite this when explaining why visible countdowns reduce cognitive load.</p>
                    <p><strong>Link:</strong> <a href="https://us.macmillan.com/books/9780374533557/thinkingfastandslow" rel="nofollow noopener" target="_blank">macmillan.com</a></p>
                </article>

                <article class="source-entry">
                    <h3>Posner, M. I., &amp; Petersen, S. E. (1990). The attention system of the human brain. <em>Annual Review of Neuroscience</em>, 13, 25&ndash;42.</h3>
                    <p><strong>Lead author:</strong> Michael I. Posner. <strong>Year:</strong> 1990. <strong>Type:</strong> Peer-reviewed review.</p>
                    <p><strong>What we cite it for:</strong> The foundational neuroscience of attention systems &mdash; alerting, orienting, executive control &mdash; that underlies why deliberate time-on-task is cognitively expensive and why explicit boundaries help.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1146/annurev.ne.13.030190.000325" rel="nofollow noopener" target="_blank">doi.org/10.1146/annurev.ne.13.030190.000325</a></p>
                </article>

                <article class="source-entry">
                    <h3>Killingsworth, M. A., &amp; Gilbert, D. T. (2010). A wandering mind is an unhappy mind. <em>Science</em>, 330(6006), 932.</h3>
                    <p><strong>Lead author:</strong> Matthew Killingsworth. <strong>Year:</strong> 2010. <strong>Type:</strong> Peer-reviewed empirical research.</p>
                    <p><strong>What we cite it for:</strong> Large-N experience-sampling evidence that mind-wandering correlates with reduced subjective wellbeing &mdash; a soft argument for the value of time-boxed, present-focused work sessions.</p>
                    <p><strong>Link:</strong> <a href="https://doi.org/10.1126/science.1192439" rel="nofollow noopener" target="_blank">doi.org/10.1126/science.1192439</a></p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">Web Performance &amp; Browser Timing</h2>

                <article class="source-entry">
                    <h3>W3C. (2024). High Resolution Time Level 3 (W3C Working Draft).</h3>
                    <p><strong>Publisher:</strong> World Wide Web Consortium. <strong>Type:</strong> Web standards specification.</p>
                    <p><strong>What we cite it for:</strong> The formal specification of <code>performance.now()</code> as a monotonic high-resolution clock immune to system time adjustments &mdash; the foundation of our timer engine, as documented on the <a href="<?php echo esc_url(home_url('/methodology/')); ?>">methodology page</a>.</p>
                    <p><strong>Link:</strong> <a href="https://www.w3.org/TR/hr-time-3/" rel="nofollow noopener" target="_blank">w3.org/TR/hr-time-3/</a></p>
                </article>

                <article class="source-entry">
                    <h3>W3C. Page Visibility Level 2.</h3>
                    <p><strong>Publisher:</strong> World Wide Web Consortium. <strong>Type:</strong> Web standards specification.</p>
                    <p><strong>What we cite it for:</strong> The <code>visibilitychange</code> event and the <code>document.visibilityState</code> API that we use to trigger re-sync of timer state when a tab returns to foreground.</p>
                    <p><strong>Link:</strong> <a href="https://www.w3.org/TR/page-visibility-2/" rel="nofollow noopener" target="_blank">w3.org/TR/page-visibility-2/</a></p>
                </article>

                <article class="source-entry">
                    <h3>Google Chrome. (2021). Timer throttling in Chrome 88. <em>Chrome Developers Blog</em>.</h3>
                    <p><strong>Publisher:</strong> Google Chrome team. <strong>Year:</strong> 2021. <strong>Type:</strong> Vendor engineering announcement.</p>
                    <p><strong>What we cite it for:</strong> The official documentation of Chromium's background-tab throttling policy &mdash; specifically that background timers are limited to roughly one wake per minute. The reason our engine cannot rely on <code>setInterval</code> for timing accuracy.</p>
                    <p><strong>Link:</strong> <a href="https://developer.chrome.com/blog/timer-throttling-in-chrome-88/" rel="nofollow noopener" target="_blank">developer.chrome.com/blog/timer-throttling-in-chrome-88/</a></p>
                </article>

                <article class="source-entry">
                    <h3>Google Chrome. (2018). Autoplay policy in Chrome.</h3>
                    <p><strong>Publisher:</strong> Google Chrome team. <strong>Year:</strong> 2018 (with subsequent updates). <strong>Type:</strong> Vendor engineering announcement.</p>
                    <p><strong>What we cite it for:</strong> The browser-autoplay restrictions that govern when timer audio alerts can play, and the user-gesture requirement we work within.</p>
                    <p><strong>Link:</strong> <a href="https://developer.chrome.com/blog/autoplay/" rel="nofollow noopener" target="_blank">developer.chrome.com/blog/autoplay/</a></p>
                </article>

            </section>

            <section class="section">
                <h2 class="section-title">How to Suggest a Citation</h2>
                <p>If a guide on this site makes a claim that you think is missing a citation, or if you know of a stronger primary source for an existing claim, send it to <a href="mailto:suraj@theblogtimer.com">suraj@theblogtimer.com</a>. Include the specific page, the claim, and the proposed source (with stable link). Confirmed additions get logged in the <a href="<?php echo esc_url(home_url('/changelog/')); ?>">changelog</a>.</p>
            </section>

            <section class="section">
                <h2 class="section-title">Related Pages</h2>
                <ul class="context-link-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About The Blog Timer</a></li>
                    <li><a href="<?php echo esc_url(home_url('/editorial-policy/')); ?>">Editorial policy &mdash; how sources are vetted</a></li>
                    <li><a href="<?php echo esc_url(home_url('/methodology/')); ?>">Testing methodology &mdash; how technical claims are verified</a></li>
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
  "@type": "Article",
  "headline": "Sources and Bibliography",
  "url": "<?php echo esc_url(home_url('/sources/')); ?>",
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
  "description": "Bibliography of all primary sources cited across The Blog Timer: productivity research, sleep science, exercise physiology, food safety, and cognitive psychology."
}
</script>

<?php
get_footer();
?>
