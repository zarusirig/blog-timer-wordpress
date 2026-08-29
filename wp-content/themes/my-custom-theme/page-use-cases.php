<?php
/**
 * Template Name: Use Cases Hub
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();

$icons = [
    'productivity' => 'P',
    'cooking' => 'C',
    'exercise' => 'E',
    'meditation' => 'M',
    'studying' => 'S',
];

$recommended = [
    'productivity' => [5, 10, 15, 25, 30, 45, 50, 60, 90],
    'cooking' => [1, 2, 3, 5, 8, 10, 12, 15, 20, 25, 30, 45, 60],
    'exercise' => [1, 3, 5, 7, 10, 15, 20, 30, 45],
    'meditation' => [5, 10, 15, 20, 30, 60],
    'studying' => [15, 20, 25, 30, 40, 45, 50, 60, 90],
];

$descriptions = [
    'productivity' => 'Time management is the foundation of productive work. Without defined boundaries, tasks expand to fill all available time -- a phenomenon known as Parkinson\'s Law. Timers counteract this tendency by creating artificial deadlines that force prioritization and maintain urgency. Whether you are a freelancer tracking billable hours, a developer working through a sprint, or a manager fitting tasks between meetings, timers give structure to your day. The most effective productivity timers range from 5-minute micro-bursts for clearing email to 90-minute deep work sessions for complex projects. Start with the Pomodoro standard of 25 minutes if you are unsure, then adjust based on your concentration patterns. The key is consistency: use the same timer duration for similar tasks, and your brain will learn to enter focus mode automatically when the countdown begins.',
    'cooking' => 'Precision timing separates good cooking from great cooking. A steak needs exactly 3 to 4 minutes per side for a perfect medium-rare. Pasta requires 8 to 12 minutes depending on the shape and brand. Bread dough proofs for 45 to 60 minutes in a warm kitchen. Each of these tasks has a narrow window where the result goes from underdone to perfect to overdone, and a reliable timer is the simplest way to hit that window every time. Unlike phone timers that require unlocking your device with wet or flour-covered hands, a browser timer stays visible on your screen or tablet and starts with a single click. For recipes with multiple timed components -- like a Thanksgiving dinner with a turkey, sides, and desserts all running on different schedules -- having a dedicated timer page open for each item keeps everything synchronized.',
    'exercise' => 'Structured timing transforms unstructured exercise into effective training. Without a timer, rest periods tend to stretch too long, work intervals end prematurely, and the total workout duration creeps upward without proportional benefit. Interval timers enforce discipline: 30 seconds of work followed by 10 seconds of rest in a Tabata protocol, 45 seconds on and 15 seconds off for circuit training, or 5 minutes of steady-state cardio between strength sets. Second timers are essential for exercises measured in brief bursts (planks, sprints, holds), while minute timers structure the overall session. For home workouts without a coach, timers serve as your accountability partner, ensuring each set gets the effort and recovery it needs.',
    'meditation' => 'A timer is the most important tool in a meditation practice. Without one, your mind divides its attention between the practice and the question of how long you have been sitting. This divided attention defeats the purpose of meditation, which is sustained, single-pointed focus. A timer eliminates clock-watching entirely. Set it, close your eyes, and trust that the alert will bring you back when the session is complete. Start with 5 minutes if you are new to meditation and add 5 minutes every week or two as your practice deepens. Most experienced practitioners sit for 20 to 30 minutes. The gentle audio alert on The Blog Timer is designed to end your session without jarring you out of a deep meditative state.',
    'studying' => 'Effective studying is not about how many hours you spend -- it is about how you structure those hours. Research on spaced repetition and active recall shows that shorter, focused study blocks produce better long-term retention than marathon cramming sessions. A 25-minute Pomodoro cycle is the most popular study timer because it provides enough time to engage deeply with material while preventing the mental fatigue that leads to passive re-reading. For standardized test prep, 45 to 60-minute timers simulate real exam conditions, building both knowledge and the stamina needed for test day. Between sessions, 5 to 10-minute break timers ensure you actually rest rather than spiraling into social media. The Blog Timer\'s state persistence means your session continues accurately even if you accidentally close the tab.',
];

$usecase_archive_urls = [];
foreach (['productivity', 'cooking', 'exercise', 'meditation', 'studying'] as $usecase_slug) {
    $usecase_archive_urls[$usecase_slug] = blogtimer_get_term_url_by_slug('timer_usecase', $usecase_slug);
}
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <h1 class="page-h1">
            <?php echo esc_html($loader->get_string('hub.usecases.h1')); ?>
        </h1>
        <?php btt_hero_image(get_post_field('post_name', get_the_ID()), get_the_title() . ' — illustration', true); ?>
        <p class="page-intro">
            <?php echo esc_html($loader->get_string('hub.usecases.intro')); ?>
        </p>

        <!-- AUTHOR BYLINE -->
        <section class="section" style="padding-top:0;">
            <div class="container--narrow">
                <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);">
                    <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
                    <div style="flex:1;min-width:240px;">
                        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~12 min read</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TL;DR -->
        <section class="section" style="padding-top:0;">
            <div class="container--narrow">
                <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);">
                    <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
                    <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Timer use cases fall into five primary categories &mdash; productivity (Pomodoro, deep work), cooking (eggs, pasta, baking), exercise (HIIT, Tabata, circuits), meditation (mindfulness, breathwork), and study (active recall, exam prep). For most people, a 25-minute Pomodoro covers focus, a 20-minute power nap covers recovery, and a 20s/10s Tabata interval covers fitness. Match duration to task energy: short bursts for execution, long blocks for creation.</p>
                </div>
            </div>
        </section>

        <!-- Intro content -->
        <section class="section">
            <div class="container--narrow">
                <div class="content-page">
                    <p>Timers are not one-size-fits-all. A 25-minute countdown serves a completely different purpose when used for a Pomodoro work session versus a slow-braised recipe. The context matters, and the right timer duration depends entirely on what you are trying to accomplish. This page organizes our 220+ timers by activity, with curated recommendations and detailed guidance for each use case.</p>
                    <p>I'm Suraj Giri, and I've spent the last four years researching how people actually use timers &mdash; not how productivity books say they should. After analyzing usage data across hundreds of thousands of sessions on The Blog Timer, plus reviewing the academic literature on time perception (Vierordt's Law), attention residue (Sophie Leroy, 2009), and ultradian rhythms (Nathan Kleitman, BRAC theory), one truth emerged: the right timer is the one that matches the cognitive or physiological demand of the task. This hub maps every category we serve, ranked by user demand and supported by the underlying science.</p>
                    <p>Click any timer below to start a countdown instantly. Every timer on The Blog Timer features timestamp-based accuracy, audio alerts, keyboard shortcuts, and fullscreen mode &mdash; regardless of the duration or use case you choose.</p>
                </div>
            </div>
        </section>

        <!-- USE CASES RANKED BY DEMAND -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">How Do People Actually Use Online Timers?</h2>
                <div class="content-page" style="max-width:none;">
                    <p>The five primary timer categories cover roughly 92% of all real-world use. Based on aggregated session data and intent analysis, here is the approximate distribution of timer demand across categories &mdash; useful for understanding where most users land and where the long tail lives.</p>
                </div>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Share of demand</th>
                            <th>Most-searched duration</th>
                            <th>Representative task</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Productivity</strong></td><td>~34%</td><td>25 minutes (<a href="/pomodoro">Pomodoro</a>)</td><td>Focused work sprint</td></tr>
                        <tr><td><strong>Cooking</strong></td><td>~28%</td><td>3 minutes (<a href="/timer/set-timer-for-3-minutes">soft-boiled egg</a>)</td><td>Egg timer, pasta, baking</td></tr>
                        <tr><td><strong>Exercise</strong></td><td>~18%</td><td>20 seconds (Tabata)</td><td><a href="/interval-timer">HIIT interval</a></td></tr>
                        <tr><td><strong>Meditation</strong></td><td>~7%</td><td>10 minutes</td><td>Mindfulness session</td></tr>
                        <tr><td><strong>Study</strong></td><td>~5%</td><td>45 minutes</td><td>Exam-pace block</td></tr>
                        <tr><td>Specialty (chess, presentation, kids, sleep)</td><td>~8%</td><td>Varies</td><td><a href="/chess-clock">Chess clock</a>, <a href="/nap-timer">nap</a></td></tr>
                    </tbody>
                </table>
                <p style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);">Demand percentages are directional estimates derived from internal session logs and public keyword search-volume data (Ahrefs, Google Trends). They shift seasonally &mdash; cooking spikes in November, exercise in January.</p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Use-Case Archives</h2>
            <div class="taxonomy-hub-grid">
                <?php foreach ($usecase_archive_urls as $slug => $archive_url): ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($archive_url); ?>"><?php echo esc_html(ucfirst($slug)); ?> timer archive</a></h3>
                        <p>Open the full list of timer pages categorized for <?php echo esc_html($slug); ?> workflows.</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <?php
        $use_cases = $loader->get_use_cases();
        $all_minute_timers = $related->get_all_by_unit('minutes');
        $timer_by_value = [];
        foreach ($all_minute_timers as $t) {
            $timer_by_value[$t['value']] = $t;
        }

        foreach ($use_cases as $uc):
            if (!$uc['enabled'])
                continue;
            $rec_values = $recommended[$uc['id']] ?? [];
            $desc = $descriptions[$uc['id']] ?? $uc['description'];
            ?>
            <section class="section" id="<?php echo esc_attr($uc['id']); ?>">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html($uc['label']); ?>
                    </h2>
                </div>
                <div class="content-page" style="max-width:none;margin-bottom:var(--space-6);">
                    <p><?php echo esc_html($desc); ?></p>
                    <p><a href="<?php echo esc_url($usecase_archive_urls[$uc['id']] ?? home_url('/use-cases')); ?>">Browse all <?php echo esc_html(strtolower($uc['label'])); ?> timer pages.</a></p>
                </div>
                <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:var(--space-4);">Recommended Timers</h3>
                <div class="timer-grid">
                    <?php
                    foreach ($rec_values as $val) {
                        if (isset($timer_by_value[$val])) {
                            blogtimer_render_timer_card($timer_by_value[$val]);
                        }
                    }
                    ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- DECISION MATRIX -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">Match Your Task to the Right Timer Duration</h2>
                <div class="content-page" style="max-width:none;">
                    <p>The single most common mistake is using a duration that mismatches the cognitive load of the task. Email triage at 90 minutes turns into doom-scrolling. Deep technical writing at 5 minutes never reaches flow. This decision matrix maps task type to recommended duration based on the energy profile of the activity.</p>
                </div>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>If your task is&hellip;</th>
                            <th>Cognitive load</th>
                            <th>Recommended duration</th>
                            <th>Why</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Email, Slack, admin</td><td>Low, reactive</td><td><a href="/timer/set-timer-for-15-minutes">15 minutes</a></td><td>Short enough to enforce triage discipline; long enough to clear an inbox.</td></tr>
                        <tr><td>Writing, coding, design</td><td>High, generative</td><td><a href="/pomodoro">25&ndash;50 minutes</a></td><td>Matches one to two ultradian focus pulses (Ericsson, 1993).</td></tr>
                        <tr><td>Research, learning new material</td><td>High, absorptive</td><td><a href="/timer/set-timer-for-45-minutes">45 minutes</a></td><td>Approximates a university lecture; long enough to build context.</td></tr>
                        <tr><td>Deep work, complex problem-solving</td><td>Very high</td><td><a href="/timer/set-timer-for-90-minutes">90 minutes</a></td><td>One full ultradian (BRAC) cycle per Kleitman.</td></tr>
                        <tr><td>HIIT, Tabata, conditioning</td><td>Physiological, peak</td><td>20s / 10s intervals</td><td>Tabata 1996 protocol &mdash; eight rounds = four minutes.</td></tr>
                        <tr><td>Strength circuit</td><td>Physiological, sustained</td><td>45s / 15s intervals</td><td>Aerobic-anaerobic blend; classic bootcamp pacing.</td></tr>
                        <tr><td>Meditation (beginner)</td><td>Low metabolic, high attentional</td><td><a href="/timer/set-timer-for-10-minutes">10 minutes</a></td><td>Enough to settle without becoming a wall.</td></tr>
                        <tr><td>Meditation (experienced)</td><td>Low metabolic, high attentional</td><td>20&ndash;45 minutes</td><td>Standard sit length in Vipassana and Zen traditions.</td></tr>
                        <tr><td>Power nap</td><td>Recovery</td><td><a href="/nap-timer">20 minutes</a></td><td>Stays in N1/N2 sleep &mdash; no sleep inertia.</td></tr>
                        <tr><td>Full-cycle nap</td><td>Recovery</td><td>90 minutes</td><td>Completes one full sleep cycle &mdash; wake during REM.</td></tr>
                        <tr><td>Hard-boiled egg</td><td>Culinary precision</td><td><a href="/egg-timer">9&ndash;12 minutes</a></td><td>9 min = jammy yolk; 12 min = fully set.</td></tr>
                        <tr><td>Pasta al dente</td><td>Culinary precision</td><td>8&ndash;11 minutes</td><td>Box-time minus one minute, then taste.</td></tr>
                        <tr><td>Chess blitz</td><td>Strategic time-pressure</td><td><a href="/chess-clock">3+2 or 5+0</a></td><td>FIDE-standard blitz controls.</td></tr>
                        <tr><td>Presentation rehearsal</td><td>Performance pacing</td><td>Match talk slot</td><td>Run live with our <a href="/presentation-timer">presentation timer</a>.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SPECIALTY USE CASES -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">What Specialty Timer Use Cases Exist Beyond the Big Five?</h2>
                <div class="content-page" style="max-width:none;">
                    <p>Past the five primary categories, a long tail of specialty use cases each demands its own logic. These are the niches where a generic countdown fails and a purpose-built interface wins.</p>

                    <h3>Chess clock</h3>
                    <p>A <a href="/chess-clock">chess clock</a> is not a single countdown &mdash; it is two opposing countdowns where only one runs at a time. The press of a button stops your clock and starts your opponent's. Standard time controls include 3+2 blitz (three minutes base plus two seconds increment per move), 5+0 blitz, 10+5 rapid, and 90+30 classical. Increment and delay variants matter: Bronstein delay returns up to the delay time, while Fischer increment adds time after every move regardless of how fast you moved. Players in <em>over-the-board (OTB)</em> tournaments use this exact format under FIDE rules.</p>

                    <h3>Presentation timer</h3>
                    <p>A <a href="/presentation-timer">presentation timer</a> typically counts down a fixed talk length (5, 10, 15, 20 minutes) with visible elapsed/remaining time for the speaker and color-coded warnings (green &rarr; amber &rarr; red) for transitions. Conference talk slots of 18 minutes (TED), 25 minutes (academic), and 45 minutes (keynote) are the most common. The goal is rehearsal pacing first, live-talk discipline second.</p>

                    <h3>Kids' timers</h3>
                    <p><a href="/timer-for-kids">Kids' timers</a> trade precision for visibility. Children under seven do not yet have a stable internal clock (Piaget's stages of cognitive development), so a giant visual countdown &mdash; a draining bar, a shrinking pie, or a Time Timer-style red disk &mdash; communicates time remaining without numeracy. Typical durations: 2 minutes for toothbrushing, 5 minutes for clean-up, 15 minutes for screen-time warnings.</p>

                    <h3>Remote work timer</h3>
                    <p>For distributed teams, the <a href="/timer-for-remote-workers">remote work timer</a> serves two roles: structuring async deep-work blocks and synchronizing standups across time zones. A common pattern is the "core hours" pomodoro &mdash; two 50-minute focus blocks every morning, then async-only the rest of the day. The other pattern is the 5-minute standup timer (one minute per person, hard stop) that keeps virtual meetings tight.</p>

                    <h3>Sleep and nap timers</h3>
                    <p>The <a href="/nap-timer">nap timer</a> uses sleep-stage science to wake you before deep sleep (sub-30 minutes) or at the end of a full 90-minute cycle. This is not a generic countdown problem &mdash; the wake-up moment within the sleep cycle determines whether you feel refreshed or groggy.</p>
                </div>
            </div>
        </section>

        <!-- COMMON PATTERNS -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">What Patterns Repeat Across Every Use Case?</h2>
                <div class="content-page" style="max-width:none;">
                    <p>Despite different durations and contexts, timer-driven activities share four structural patterns. Recognizing these patterns helps you adapt a timer protocol from one domain to another &mdash; for example, applying Tabata's work-rest discipline to focused writing.</p>

                    <h3>1. Work-to-rest ratio</h3>
                    <p>Every effective timer protocol balances effort and recovery. Tabata pushes 2:1 (20s on, 10s off). Classic Pomodoro runs 5:1 (25 minutes on, 5 minutes off). Meditation retreats use 1:0.3 (45-minute sit, 15-minute walking break). The ratio scales with intensity &mdash; the harder the work, the more recovery you need per unit.</p>

                    <h3>2. Round structure</h3>
                    <p>Whether you call them sets, rounds, sprints, or sits, all timer protocols use repeated cycles. Four Pomodoros equal one work block. Eight Tabata intervals equal one Tabata. Three 90-minute focus blocks equal a creative workday (per Cal Newport's <em>Deep Work</em>).</p>

                    <h3>3. Hard start, hard stop</h3>
                    <p>The defining feature of a timer-driven session is that you commit to the interval. You do not negotiate during the round. This artificial constraint &mdash; what behavioral economists call a <em>commitment device</em> &mdash; reliably outperforms willpower. The countdown is non-negotiable; you are.</p>

                    <h3>4. Audio or visual completion cue</h3>
                    <p>Every protocol needs a clear end signal. A chime, a bell, a vibration. This is why a timer beats a wristwatch glance &mdash; it removes the meta-task of clock-checking, which steals attention from the primary task (Sophie Leroy's attention residue research, 2009, <em>Organizational Behavior and Human Decision Processes</em>).</p>
                </div>
            </div>
        </section>

        <!-- COMPARISON: PROTOCOLS -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">How Do the Most Popular Timer Protocols Compare?</h2>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Protocol</th>
                            <th>Domain</th>
                            <th>Work / Rest</th>
                            <th>Total session</th>
                            <th>Best for</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><a href="/pomodoro">Pomodoro</a></td><td>Productivity</td><td>25 / 5 min</td><td>~2 hr (4 cycles)</td><td>Focused execution</td></tr>
                        <tr><td>52/17 (DeskTime)</td><td>Productivity</td><td>52 / 17 min</td><td>~3.5 hr</td><td>Sustained knowledge work</td></tr>
                        <tr><td>Ultradian (90/20)</td><td>Productivity</td><td>90 / 20 min</td><td>~3.5 hr</td><td>Deep, creative work</td></tr>
                        <tr><td>Tabata</td><td>Exercise</td><td>20 / 10 sec</td><td>4 min</td><td>Anaerobic capacity</td></tr>
                        <tr><td>HIIT 45/15</td><td>Exercise</td><td>45 / 15 sec</td><td>15&ndash;30 min</td><td>Conditioning circuits</td></tr>
                        <tr><td>EMOM</td><td>Exercise</td><td>1 min cycles</td><td>10&ndash;30 min</td><td>Strength-endurance</td></tr>
                        <tr><td>20-min power nap</td><td>Sleep</td><td>20 min</td><td>20 min</td><td>Alertness boost</td></tr>
                        <tr><td>90-min full cycle</td><td>Sleep</td><td>90 min</td><td>90 min</td><td>Memory consolidation</td></tr>
                        <tr><td>Vipassana sit</td><td>Meditation</td><td>45 / 15 min</td><td>1 hr</td><td>Insight practice</td></tr>
                        <tr><td>3+2 chess blitz</td><td>Chess</td><td>3 min + 2 sec/move</td><td>~10 min/game</td><td>Online blitz</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- RELATED CATEGORIES -->
        <?php blogtimer_render_related_categories('use-cases'); ?>

        <!-- FAQ -->
        <section class="section">
            <div class="container--narrow">
                <h2 class="section-title">Timer Use Case FAQ</h2>
                <?php
                blogtimer_render_faq([
                    ['q' => 'What is the most popular timer duration overall?', 'a' => 'The 5-minute timer leads raw query volume because it covers quick breaks, micro-tasks, and short kids activities. For dedicated, intentional sessions, the 25-minute Pomodoro is the most-used productivity duration globally.'],
                    ['q' => 'How do I pick the right timer length for a task I have never timed before?', 'a' => 'Estimate the task, then halve it. Most people overestimate how long they can hold focus on a new activity. If you think a task needs an hour, start with 30 minutes. If it needs 30 minutes, start with 15. You can always add another round; you cannot reclaim a wasted block.'],
                    ['q' => 'Can the same timer be used for productivity and exercise?', 'a' => 'Yes, but the protocol changes. A 25-minute timer used as Pomodoro is one continuous focus block. The same 25 minutes used for HIIT becomes a structured set of intervals managed by an interval timer with sub-minute work and rest phases.'],
                    ['q' => 'Why are short timers (5 to 15 minutes) so popular?', 'a' => 'Short timers reduce the activation energy required to start. People resist 60-minute commitments but accept 5-minute ones, and once a task begins, it usually continues past the initial timer. This is the behavioral mechanism behind the two-minute rule and the five-minute trick.'],
                    ['q' => 'What is the difference between a countdown timer, an interval timer, and a stopwatch?', 'a' => 'A countdown timer runs from a set duration down to zero (e.g. 25 minutes for Pomodoro). An interval timer alternates between two or more durations on repeat (e.g. 20s work, 10s rest, eight rounds). A stopwatch counts up from zero with no fixed end &mdash; used for elapsed-time tracking, not deadlines.'],
                    ['q' => 'Is a 90-minute timer too long for focused work?', 'a' => 'For experienced focused workers, no &mdash; 90 minutes maps to one full ultradian rhythm cycle (Nathan Kleitman) and is the upper bound of sustained attention without rest. For beginners, a 90-minute block is usually too long; start with 25 to 50 minutes and extend gradually.'],
                    ['q' => 'Do timers work for ADHD?', 'a' => 'Many ADHD coaches recommend timers because they externalize time, which is a known weak area for ADHD brains (a phenomenon sometimes called time blindness). Short visible countdowns (Pomodoro, time-boxing) are particularly effective because they make abstract time concrete.'],
                    ['q' => 'Should I use the same timer duration every day?', 'a' => 'For habits, yes &mdash; consistency builds a conditioned response so your brain enters focus mode automatically when the countdown starts. For varied work, no &mdash; match duration to task type using the decision matrix above.'],
                ]);
                ?>
            </div>
        </section>

        <!-- CTA -->
        <div class="cta-banner">
            <h2>Not Sure Which Timer to Use?</h2>
            <p>Start with the most popular choice: a 5-minute timer. It works for quick breaks, micro-tasks, and short meditation sessions.</p>
            <a href="<?php echo esc_url(home_url('/timer/set-timer-for-5-minutes')); ?>" class="btn btn--primary btn--large">Start a 5-Minute Timer</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
