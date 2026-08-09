<?php
/**
 * Copy and link helpers for timer taxonomy hub templates.
 */

if (!function_exists('blogtimer_taxhub_term_description')) {
    function blogtimer_taxhub_term_description($term, $fallback)
    {
        if ($term instanceof WP_Term && trim((string) $term->description) !== '') {
            return wp_strip_all_tags($term->description);
        }

        return $fallback;
    }
}

if (!function_exists('blogtimer_taxhub_bucket_unit')) {
    function blogtimer_taxhub_bucket_unit($slug)
    {
        if (strpos((string) $slug, 'seconds_') === 0) {
            return 'seconds';
        }

        if (strpos((string) $slug, 'hours_') === 0) {
            return 'hours';
        }

        return 'minutes';
    }
}

if (!function_exists('blogtimer_taxhub_bucket_profile')) {
    function blogtimer_taxhub_bucket_profile($slug, $name, $unit)
    {
        $profiles = [
            'short' => [
                'summary' => 'Short minute timers work best for quick resets, small admin tasks, and low-friction starts when a longer block feels too heavy.',
                'best_for' => ['Email triage and admin tasks', 'Quick room resets or chores', 'Short study reviews', 'Low-commitment focus starts'],
                'guidance' => 'Choose this range when momentum matters more than session depth. Chain two or three completed short timers before moving into medium blocks.',
            ],
            'medium' => [
                'summary' => 'Medium minute timers give enough room for a complete focus cycle without making the session hard to start.',
                'best_for' => ['Pomodoro-style work blocks', 'Cooking tasks with active monitoring', 'Workout sets and recovery windows', 'Study drills and practice rounds'],
                'guidance' => 'Use this range when the task has a clear finish line and you want a balance between urgency and useful working time.',
            ],
            'long' => [
                'summary' => 'Long minute timers support deep work, longer recipes, endurance training, and tasks where interruptions are expensive.',
                'best_for' => ['Deep work and writing sessions', 'Long cooking or baking stages', 'Workout circuits and mobility work', 'Exam practice and focused reading'],
                'guidance' => 'Pick a long timer when setup time is already complete and the next step benefits from uninterrupted continuity.',
            ],
            'extended' => [
                'summary' => 'Extended minute timers are built for marathon study blocks, slow cooking, long creative sessions, and other activities that need more than an hour of continuity.',
                'best_for' => ['Long study sessions and mock exams', 'Slow cooking and extended kitchen prep', 'Deep work sprints beyond one hour', 'Workshops, classes, and long meetings'],
                'guidance' => 'Use an extended timer when the main risk is losing track of elapsed time, not losing urgency. For demanding work, schedule a break checkpoint before starting.',
            ],
            'seconds_short' => [
                'summary' => 'Short second timers cover instant countdowns for reactions, transitions, and very fast interval cues.',
                'best_for' => ['Reaction drills', 'Quick transitions', 'Breath holds or releases', 'Rapid kitchen checks'],
                'guidance' => 'Use this range when every second matters and the timer is acting as a cue rather than a full work session.',
            ],
            'seconds_medium' => [
                'summary' => 'Medium second timers are practical for exercise reps, breathing drills, short rests, and timed micro-tasks.',
                'best_for' => ['Exercise intervals', 'Breathing patterns', 'Short rest periods', 'Presentation timing drills'],
                'guidance' => 'Choose this range for interval structures where the countdown repeats often and must be easy to scan.',
            ],
            'seconds_long' => [
                'summary' => 'Long second timers bridge the gap between quick cues and full minute timers for planks, rests, meditation starts, and focused bursts.',
                'best_for' => ['Planks and holds', 'One-minute rests', 'Breathing rounds', 'Short focus bursts'],
                'guidance' => 'Use this range when a full minute is the natural unit but you still need second-level precision.',
            ],
            'hours_short' => [
                'summary' => 'Short hour timers are useful for multi-hour work blocks, naps, cooking windows, and long-form sessions that need a clear endpoint.',
                'best_for' => ['One to three hour work blocks', 'Naps and rest periods', 'Slow cooking windows', 'Classroom or workshop timing'],
                'guidance' => 'Choose this range when minute-level precision is less important than having a reliable long countdown.',
            ],
            'hours_long' => [
                'summary' => 'Long hour timers support shifts, slow cooking, travel waits, fasting windows, and other half-day countdowns.',
                'best_for' => ['Work shifts', 'Slow cooking and proofing', 'Fasting windows', 'Long deadline tracking'],
                'guidance' => 'Use this range when you need a persistent countdown that can stay open in the background for most of the day.',
            ],
            'hours_extended' => [
                'summary' => 'Extended hour timers are for day-length countdowns where the browser timer acts as a simple deadline tracker.',
                'best_for' => ['Day-long deadlines', 'Extended fasting', 'Travel countdowns', 'Long recovery windows'],
                'guidance' => 'Pick this range when the timer is mainly a visible time-left reference over a very long span.',
            ],
        ];

        return $profiles[$slug] ?? [
            'summary' => sprintf('%s groups related %s timers so you can compare nearby durations and choose the right countdown quickly.', $name, $unit),
            'best_for' => ['Comparing nearby durations', 'Choosing a reliable countdown', 'Building repeatable timing routines', 'Finding related timer pages'],
            'guidance' => 'Start with the shortest duration that gives the task enough room, then increase only when completion quality stays consistent.',
        ];
    }
}

if (!function_exists('blogtimer_taxhub_unit_profile')) {
    function blogtimer_taxhub_unit_profile($slug, $label)
    {
        $profiles = [
            'minutes' => [
                'intro' => 'Minute timers are the main planning unit for focus sessions, cooking stages, exercise blocks, study routines, and breaks.',
                'best_for' => ['Focus sessions', 'Cooking and baking stages', 'Workout blocks', 'Study intervals'],
                'guidance' => 'Choose minutes when the activity has a meaningful start and finish rather than a repeated cue every few seconds.',
            ],
            'seconds' => [
                'intro' => 'Second timers give precise countdowns for intervals, drills, short rests, breathing patterns, and quick kitchen timing.',
                'best_for' => ['HIIT intervals', 'Breathing drills', 'Short rests', 'Timed transitions'],
                'guidance' => 'Choose seconds when the exact cue matters and the session is too short to round up to a minute.',
            ],
            'hours' => [
                'intro' => 'Hour timers cover long countdowns for work shifts, naps, slow cooking, fasting windows, deadlines, and extended tracking.',
                'best_for' => ['Work shifts', 'Slow cooking', 'Long breaks or naps', 'Deadline tracking'],
                'guidance' => 'Choose hours when a persistent long timer is more useful than a precise minute-by-minute countdown.',
            ],
        ];

        return $profiles[$slug] ?? [
            'intro' => sprintf('%s timers collect every available countdown in this unit so related durations are easy to compare.', $label),
            'best_for' => ['Browsing related timers', 'Comparing durations', 'Choosing repeatable routines', 'Finding matching use cases'],
            'guidance' => 'Pick the unit that matches how precisely the activity needs to be timed.',
        ];
    }
}

if (!function_exists('blogtimer_taxhub_usecase_profile')) {
    function blogtimer_taxhub_usecase_profile($slug, $name)
    {
        $profiles = [
            'productivity' => [
                'intro' => 'Productivity timers help turn open-ended work into visible, bounded sessions for writing, planning, admin, and deep focus.',
                'best_for' => ['Deep work blocks', 'Email and admin sprints', 'Planning sessions', 'Pomodoro-style routines'],
                'guidance' => 'Use shorter timers to start when resistance is high, then move into medium or long blocks once the task is clearly defined.',
            ],
            'cooking' => [
                'intro' => 'Cooking timers make recipe stages easier to track, from second-level checks to long bakes, simmering, proofing, and slow cooking.',
                'best_for' => ['Boiling and steaming', 'Baking stages', 'Coffee and tea brewing', 'Slow cooking windows'],
                'guidance' => 'Use second timers for precision steps and longer minute or hour timers when the food can sit undisturbed.',
            ],
            'exercise' => [
                'intro' => 'Exercise timers structure work intervals, rests, holds, warmups, circuits, and cooldowns without relying on memory mid-session.',
                'best_for' => ['HIIT intervals', 'Rest periods', 'Planks and holds', 'Mobility sessions'],
                'guidance' => 'Use second timers for repeated interval cues and minute timers for longer conditioning, stretching, or recovery blocks.',
            ],
            'meditation' => [
                'intro' => 'Meditation timers give quiet structure to mindfulness sessions, breathwork, body scans, naps, and wind-down routines.',
                'best_for' => ['Breathwork rounds', 'Mindfulness sessions', 'Body scans', 'Sleep preparation'],
                'guidance' => 'Start with a duration you can finish calmly. Increase the session length only after the end of the timer feels comfortable.',
            ],
            'studying' => [
                'intro' => 'Study timers help divide reading, review, practice problems, memorization, and mock exams into measurable sessions.',
                'best_for' => ['Reading blocks', 'Flashcard reviews', 'Practice tests', 'Focused writing or note-taking'],
                'guidance' => 'Use medium timers for focused drills and extended timers for exams, long reading assignments, or uninterrupted review blocks.',
            ],
        ];

        return $profiles[$slug] ?? [
            'intro' => sprintf('%s timers collect countdowns that fit this activity so you can pick a duration by intent instead of guessing.', $name),
            'best_for' => ['Choosing activity-specific timers', 'Building repeatable routines', 'Comparing short and long durations', 'Finding related timer pages'],
            'guidance' => 'Match the timer to the smallest complete unit of work the activity requires.',
        ];
    }
}

if (!function_exists('blogtimer_taxhub_copy_library')) {
    /**
     * Built-in hub copy per term ("taxonomy:slug" keys): descriptive H1,
     * document title (no brand suffix), curated intro HTML with internal
     * timer/guide links, and meta description. Mirrored in
     * datasets/copyblocks.json under "taxonomyHubs" (override layer).
     */
    function blogtimer_taxhub_copy_library()
    {
        return [
            'timer_usecase:studying' => [
                'h1' => 'Study Timers & Focus Sessions',
                'title' => 'Study Timers — The Best Timer Durations for Studying',
                'intro_html' => '<p>The right study timer depends on what you are studying and how long you can genuinely concentrate. For flashcards, vocabulary drills, and quick reviews, a <a href="/timer/set-timer-for-25-minutes">25-minute timer</a> — the classic Pomodoro length — keeps sessions sharp without burning out. Problem sets and note-taking usually fit a <a href="/timer/set-timer-for-30-minutes">30-minute</a> or <a href="/timer/set-timer-for-45-minutes">45-minute timer</a>, while reading-heavy subjects reward a deeper <a href="/timer/set-timer-for-50-minutes">50-minute block</a> followed by a ten-minute break.</p><p>For past papers and mock exams, match the real thing: a <a href="/timer/set-timer-for-60-minutes">60-minute</a> or <a href="/timer/set-timer-for-90-minutes">90-minute timer</a> builds the stamina exams actually demand. Start shorter than you think you need and extend only when you finish blocks without drifting. Our guides on <a href="/guides/study-timer-methods">study timer methods</a> and <a href="/guides/how-long-to-study">how long to study</a> explain which interval fits each subject and how to structure breaks so review actually sticks.</p>',
                'meta_description' => 'Find the best study timer durations — 25, 45, 50, 60 and 90-minute focus sessions for reading, problem sets, and exam practice, with free one-click countdowns.',
            ],
            'timer_usecase:productivity' => [
                'h1' => 'Productivity Timers & Deep Work Blocks',
                'title' => 'Productivity Timers — The Best Timer Durations for Deep Work',
                'intro_html' => '<p>Productivity timers turn a vague intention to "do some work" into a bounded, finishable session. When starting feels hard, open a <a href="/timer/set-timer-for-5-minutes">5-minute timer</a> and just begin — momentum usually follows. Email triage and admin fit a <a href="/timer/set-timer-for-15-minutes">15-minute sprint</a>, while the classic <a href="/timer/set-timer-for-25-minutes">25-minute Pomodoro</a> remains the most reliable default for everyday tasks.</p><p>For writing, coding, and planning that needs real depth, step up to a <a href="/timer/set-timer-for-50-minutes">50-minute</a> or <a href="/timer/set-timer-for-90-minutes">90-minute deep work block</a> — long enough to reach flow, short enough to protect your energy across the day. Cap meetings with a <a href="/timer/set-timer-for-60-minutes">60-minute timer</a> so they end on time. See our guides to the <a href="/guides/pomodoro-technique">Pomodoro Technique</a> and <a href="/guides/deep-work-timer-guide">deep work timers</a> to pick the ratio of focus to break that fits your role.</p>',
                'meta_description' => 'The best productivity timer durations for deep work and daily tasks — 5, 15, 25, 50 and 90-minute focus blocks with free one-click online countdowns.',
            ],
            'timer_usecase:exercise' => [
                'h1' => 'Workout & Exercise Interval Timers',
                'title' => 'Workout Timers — The Best Timer Durations for Exercise',
                'intro_html' => '<p>Exercise timing works on two scales: seconds for intervals and minutes for full sessions. Sprint and HIIT work typically alternates a <a href="/timer/set-timer-for-30-seconds">30-second effort</a> with rest, while a <a href="/timer/set-timer-for-45-seconds">45-second timer</a> suits planks, wall sits, and longer holds. For strength training, rest <a href="/timer/set-timer-for-3-minutes">3 minutes</a> between heavy sets so power actually recovers.</p><p>For complete sessions, a <a href="/timer/set-timer-for-20-minutes">20-minute timer</a> covers a solid HIIT or core circuit, and a <a href="/timer/set-timer-for-30-minutes">30-minute countdown</a> fits most home workouts, runs, and mobility routines. Warm up first — five minutes is enough to raise your heart rate and protect your joints. Our guides to <a href="/guides/hiit-interval-timers">HIIT interval timers</a> and <a href="/guides/rest-timers-strength">rest timers for strength training</a> break down exact work-to-rest ratios by goal, from fat loss to max strength. Consistency in rest lengths matters as much as effort — timing rests stops the drift that quietly turns intervals into casual breaks.</p>',
                'meta_description' => 'The best workout timer durations — 30 and 45-second intervals, 3-minute rests, and 20-30 minute sessions for HIIT, strength, and cardio. Free online timers.',
            ],
            'timer_usecase:meditation' => [
                'h1' => 'Meditation & Mindfulness Timers',
                'title' => 'Meditation Timers — The Best Timer Durations for Mindfulness',
                'intro_html' => '<p>A meditation timer removes the one distraction mindfulness cannot: wondering how long you have been sitting. Beginners do best with a <a href="/timer/set-timer-for-5-minutes">5-minute timer</a> — short enough to finish calmly every day — before moving to the widely recommended <a href="/timer/set-timer-for-10-minutes">10-minute</a> and <a href="/timer/set-timer-for-15-minutes">15-minute sessions</a>. Experienced meditators often settle at <a href="/timer/set-timer-for-20-minutes">20</a> or <a href="/timer/set-timer-for-30-minutes">30 minutes</a>, the lengths used in most studied mindfulness programs.</p><p>For breathwork, seconds matter more than minutes: a repeating <a href="/timer/set-timer-for-30-seconds">30-second countdown</a> can pace box breathing and extended exhales. Whatever length you choose, consistency beats duration — a daily ten minutes outperforms an occasional hour. Start with our guides to <a href="/guides/meditation-timers-beginners">meditation timers for beginners</a> and <a href="/guides/how-long-to-meditate">how long to meditate</a> to match session length to your experience and goals. If a session ends before you feel ready, sit for three more breaths before standing — the timer marks the minimum, not the limit.</p>',
                'meta_description' => 'The best meditation timer durations — 5, 10, 15, 20 and 30-minute mindfulness sessions plus breathing countdowns. Free, quiet online timers that end gently.',
            ],
            'timer_usecase:cooking' => [
                'h1' => 'Cooking & Kitchen Timers',
                'title' => 'Cooking Timers — The Best Timer Durations for the Kitchen',
                'intro_html' => '<p>Cooking is the one place where a timer is not optional — thirty seconds separates silky eggs from rubbery ones. For soft-boiled eggs, set a <a href="/timer/set-timer-for-6-minutes">6-minute timer</a>; hard-boiled needs <a href="/timer/set-timer-for-10-minutes">10 minutes</a>. Most dried pasta lands al dente around <a href="/timer/set-timer-for-11-minutes">11 minutes</a>, while white rice wants <a href="/timer/set-timer-for-18-minutes">18 minutes</a> of covered simmering plus a rest.</p><p>Longer jobs need longer countdowns: a <a href="/timer/set-timer-for-45-minutes">45-minute timer</a> covers roast vegetables and traybakes, and a <a href="/timer/set-timer-for-2-hours">2-hour timer</a> handles braises and slow roasts. Set the timer the moment food meets heat, not after you tidy up. Our guides on <a href="/guides/how-long-to-boil-eggs">how long to boil eggs</a> and <a href="/guides/how-long-to-cook-pasta">how long to cook pasta</a> give exact times by size, shape, and doneness. Altitude, pan size, and starting temperature all shift times slightly, so treat the first attempt as calibration and adjust by a minute either way.</p>',
                'meta_description' => 'The best cooking timer durations — 6 and 10-minute eggs, 11-minute pasta, 18-minute rice, 45-minute roasts and 2-hour braises. Free one-click kitchen timers.',
            ],
            'timer_bucket:short' => [
                'h1' => 'Short Timers: 1–10 Minute Countdowns',
                'title' => 'Short Timers (1–10 Min) — The Best Quick Countdown Durations',
                'intro_html' => '<p>Short timers between one and ten minutes are the workhorses of daily timing. A <a href="/timer/set-timer-for-1-minutes">1-minute timer</a> paces rests between exercise sets, a <a href="/timer/set-timer-for-3-minutes">3-minute timer</a> steeps most black teas, and a <a href="/timer/set-timer-for-5-minutes">5-minute countdown</a> is the classic low-resistance way to start a task you have been avoiding.</p><p>At the top of the range, a <a href="/timer/set-timer-for-7-minutes">7-minute timer</a> runs the famous bodyweight workout of the same name, and <a href="/timer/set-timer-for-10-minutes">10 minutes</a> is enough for a meaningful tidy-up, a meditation session, or an inbox sweep. Chain two or three completed short timers to build momentum before committing to a longer block. See our guides to <a href="/guides/break-timers">break timers</a> and <a href="/guides/email-batching-timer">email batching</a> for routines built entirely from short countdowns. Because these countdowns end quickly, keep the tab visible — the value of a short timer is the finish line you can actually see.</p>',
                'meta_description' => 'Quick 1-10 minute countdown timers for breaks, tea, workouts and fast tasks. Pick a 1, 3, 5, 7 or 10-minute timer and start with one click — free online.',
            ],
            'timer_bucket:medium' => [
                'h1' => 'Medium Timers: 11–30 Minute Countdowns',
                'title' => 'Medium Timers (11–30 Min) — The Best All-Round Durations',
                'intro_html' => '<p>The 11–30 minute range is where most real work gets done. The <a href="/timer/set-timer-for-25-minutes">25-minute timer</a> — one Pomodoro — is the most popular duration on this site for a reason: long enough to finish something, short enough to start without dread. A <a href="/timer/set-timer-for-15-minutes">15-minute timer</a> suits admin sprints and quick workouts, while <a href="/timer/set-timer-for-20-minutes">20 minutes</a> is the sweet spot for power naps and HIIT sessions.</p><p>In the kitchen this range covers <a href="/timer/set-timer-for-12-minutes">12-minute pasta</a> and <a href="/timer/set-timer-for-18-minutes">18-minute rice</a>, and a full <a href="/timer/set-timer-for-30-minutes">30-minute countdown</a> handles home workouts, study drills, and most weeknight cooking. If a task regularly overruns this bucket, that is a sign to move up to a long timer rather than restart. Start with the <a href="/guides/pomodoro-technique">Pomodoro Technique guide</a> or check <a href="/guides/how-long-to-cook-pasta">exact pasta times</a>.</p>',
                'meta_description' => '11-30 minute countdown timers for Pomodoro sessions, naps, HIIT, pasta and rice. Pick a 15, 20, 25 or 30-minute timer and start instantly — free online.',
            ],
            'timer_bucket:long' => [
                'h1' => 'Long Timers: 31–60 Minute Countdowns',
                'title' => 'Long Timers (31–60 Min) — The Best Deep Work Durations',
                'intro_html' => '<p>Timers between 31 and 60 minutes exist for work that needs a run-up. A <a href="/timer/set-timer-for-45-minutes">45-minute timer</a> matches a school period or therapy session and covers most roast dinners; the research-backed <a href="/timer/set-timer-for-52-minutes">52-minute block</a> (from the 52/17 method) suits sustained office work; and a <a href="/timer/set-timer-for-50-minutes">50-minute timer</a> plus a ten-minute break makes a clean, repeatable hour.</p><p>The full <a href="/timer/set-timer-for-60-minutes">60-minute countdown</a> is the natural ceiling: one uninterrupted hour of writing, coding, or reading is a genuinely productive session by any standard. Protect these blocks — silence notifications before you press start, because a single interruption costs far more here than in a short timer. Our guides to <a href="/guides/deep-work-timers">deep work timers</a> and the <a href="/guides/52-17-rule-vs-pomodoro">52/17 rule vs Pomodoro</a> show when longer blocks beat shorter cycles. Keep water and notes within reach so the block stays unbroken from the first minute to the last.</p>',
                'meta_description' => '31-60 minute timers for deep work, study hours and long cooking. Pick a 45, 50, 52 or 60-minute countdown and start with one click — free online timers.',
            ],
            'timer_bucket:extended' => [
                'h1' => 'Extended Timers: Countdowns Over an Hour',
                'title' => 'Extended Timers (61+ Min) — The Best Long Session Durations',
                'intro_html' => '<p>Extended timers cover everything from just over an hour to two and a half hours — sessions where the risk is not losing urgency but losing track of time entirely. A <a href="/timer/set-timer-for-75-minutes">75-minute timer</a> matches a university lecture, a <a href="/timer/set-timer-for-90-minutes">90-minute block</a> aligns with a full ultradian focus cycle (and a football match), and <a href="/timer/set-timer-for-120-minutes">120 minutes</a> is the standard length of many written exams.</p><p>At the far end, a <a href="/timer/set-timer-for-150-minutes">150-minute countdown</a> handles slow braises, long mock exams, and film-length focus sessions. For anything this long, decide your break point before you start — a checkpoint at the halfway mark keeps quality from sliding. See our guides to <a href="/guides/exam-prep-timer">exam prep timers</a> and <a href="/guides/slow-cooker-timing-guide">slow cooker timing</a> for how to structure multi-hour sessions. Hydrate and stand briefly at your checkpoint; returning takes seconds, but skipping it costs focus in the final stretch.</p>',
                'meta_description' => 'Extended 61-161 minute timers for lectures, mock exams, 90-minute focus cycles and slow cooking. Pick 75, 90, 120 or 150 minutes and start instantly.',
            ],
            'timer_bucket:seconds_short' => [
                'h1' => 'Short Second Timers: 1–10 Second Countdowns',
                'title' => '1–10 Second Timers — The Best Instant Countdown Durations',
                'intro_html' => '<p>One-to-ten-second timers are cues, not sessions — they mark a single rep, breath, or transition. A <a href="/timer/set-timer-for-3-seconds">3-second timer</a> paces the lowering phase of a slow rep, a <a href="/timer/set-timer-for-4-seconds">4-second countdown</a> is one side of a box-breathing square, and a <a href="/timer/set-timer-for-5-seconds">5-second timer</a> covers sprint starts and reaction drills.</p><p>The <a href="/timer/set-timer-for-10-seconds">10-second timer</a> is the most versatile of the range: a full isometric hold, a quick kitchen check, or the countdown before a lift. Because these timers repeat constantly, the alert matters more than the display — pick a sound you can hear mid-exercise. Our guides to <a href="/guides/breathing-timers">breathing timers</a> and <a href="/guides/hiit-interval-timers">HIIT intervals</a> show how to chain second-level cues into complete routines. If you need the cue to repeat on a fixed cycle, restart on the beep rather than counting in your head — accuracy drifts surprisingly fast.</p>',
                'meta_description' => 'Instant 1-10 second countdown timers for reps, reaction drills and breathing cues. Start a 3, 4, 5 or 10-second timer with one click — free online.',
            ],
            'timer_bucket:seconds_medium' => [
                'h1' => 'Medium Second Timers: 11–30 Second Countdowns',
                'title' => '11–30 Second Timers — The Best Interval Countdown Durations',
                'intro_html' => '<p>The 11–30 second range is the engine room of interval training. Tabata\'s famous protocol alternates a <a href="/timer/set-timer-for-20-seconds">20-second work burst</a> with a <a href="/timer/set-timer-for-10-seconds">10-second rest</a>, while a <a href="/timer/set-timer-for-30-seconds">30-second timer</a> is the default for HIIT efforts, planks, and side holds. A <a href="/timer/set-timer-for-15-seconds">15-second countdown</a> paces stretches held per side, and <a href="/timer/set-timer-for-25-seconds">25 seconds</a> makes a fair progression target between the two classics.</p><p>These lengths also pace breathing patterns — try fifteen seconds per extended exhale — and quick kitchen steps like blooming coffee. If you repeat an interval more than a few times, reset speed matters; every timer here restarts with a single tap. See our <a href="/guides/tabata-timer-guide">Tabata timer guide</a> and <a href="/guides/breathwork-timer">breathwork timer guide</a> for ready-made interval structures. Keep work and rest lengths honest — shaving rests is the fastest way to turn measured intervals into an unmeasured grind.</p>',
                'meta_description' => '11-30 second countdown timers for Tabata, HIIT and breathing drills. Start a 15, 20, 25 or 30-second interval timer with one click — free online.',
            ],
            'timer_bucket:seconds_long' => [
                'h1' => 'Long Second Timers: 31–90 Second Countdowns',
                'title' => '31–90 Second Timers — The Best Hold & Rest Durations',
                'intro_html' => '<p>Timers from 31 to 90 seconds bridge quick cues and full multi-minute sessions. A <a href="/timer/set-timer-for-40-seconds">40-second timer</a> suits extended HIIT work intervals, a <a href="/timer/set-timer-for-45-seconds">45-second countdown</a> is a strong plank target for intermediate exercisers, and the <a href="/timer/set-timer-for-60-seconds">60-second timer</a> covers short strength rests, breathing rounds, and the classic one-minute plank, while the <a href="/timer/set-timer-for-90-seconds">90-second timer</a> handles common between-set rest intervals in strength training.</p><p>A <a href="/timer/set-timer-for-50-seconds">50-second timer</a> works well for near-minute intervals where a full sixty feels arbitrary, and <a href="/timer/set-timer-for-35-seconds">35 seconds</a> splits the difference when progressing holds. When a duration in this bucket starts to feel easy, add five seconds rather than jumping ranges. Our guides on <a href="/guides/how-long-to-hold-a-plank">how long to hold a plank</a> and <a href="/guides/rest-timer-strength-training">rest timers for strength</a> give progression targets by level. Time both sides of paired holds separately so left and right develop evenly, and log your best hold each week to see progress.</p>',
                'meta_description' => '31-90 second countdown timers for planks, holds, rests and near-minute intervals. Start a 40, 45, 50 or 60-second timer with one click — free online.',
            ],
            'timer_bucket:hours_short' => [
                'h1' => 'Short Hour Timers: 1–3 Hour Countdowns',
                'title' => '1–3 Hour Timers — The Best Long Block Durations',
                'intro_html' => '<p>One-to-three-hour timers cover the sessions minute timers cannot: a <a href="/timer/set-timer-for-1-hour">1-hour timer</a> caps meetings, laundry cycles, and paid-parking windows; a <a href="/timer/set-timer-for-2-hours">2-hour countdown</a> matches written exams, braised dinners, and half-day study splits; and a <a href="/timer/set-timer-for-3-hours">3-hour timer</a> handles slow roasts and long creative sessions.</p><p>For focus work inside this range, the <a href="/timer/set-timer-for-90-minutes">90-minute block</a> is often the better unit — it tracks your natural ultradian rhythm, after which a real break beats pushing on. These countdowns keep running in a background tab, so you can set one and get on with the task. See our guides on <a href="/guides/how-long-to-nap">how long to nap</a> and <a href="/guides/slow-cooker-timing-guide">slow cooker timing</a> for hour-scale timing done right. If you tend to ignore long timers, set the alert sound louder than usual — after two quiet hours, a soft chime is easy to miss.</p>',
                'meta_description' => '1, 2 and 3-hour online countdown timers for exams, cooking, naps and long work blocks. Set an hour timer in one click — runs reliably in the background.',
            ],
            'timer_bucket:hours_long' => [
                'h1' => 'Long Hour Timers: 4–12 Hour Countdowns',
                'title' => '4–12 Hour Timers — The Best Shift & Slow Cook Durations',
                'intro_html' => '<p>Timers from four to twelve hours act as background deadline trackers rather than attention tools. A <a href="/timer/set-timer-for-4-hours">4-hour timer</a> covers marinating meat and half a workday; a <a href="/timer/set-timer-for-6-hours">6-hour countdown</a> suits slow-cooker recipes on high and long travel legs; and the <a href="/timer/set-timer-for-8-hours">8-hour timer</a> maps to a full shift, a night\'s sleep target, or low-and-slow barbecue.</p><p>At the top, a <a href="/timer/set-timer-for-12-hours">12-hour countdown</a> tracks overnight proofing, fasting windows, and split-day schedules. Leave the tab open — the countdown continues accurately in the background and alerts you when time is up. Our <a href="/guides/marinating-timer">marinating timer guide</a> and <a href="/guides/slow-cooker-timing-guide">slow cooker timing guide</a> list exact hour targets by cut, dish, and setting. For anything involving food safety, set the timer for the minimum recommended time and check doneness properly before extending it.</p>',
                'meta_description' => '4 to 12-hour online countdown timers for shifts, slow cooking, marinating and overnight tracking. Set a long timer once and get alerted when it ends.',
            ],
            'timer_bucket:hours_extended' => [
                'h1' => 'Extended Hour Timers: Day-Length Countdowns',
                'title' => '13–24 Hour Timers — The Best Day-Length Countdown Durations',
                'intro_html' => '<p>Day-length timers are pure deadline trackers: set one and let it count while life happens. The <a href="/timer/set-timer-for-24-hours">24-hour timer</a> is the anchor of this range — one full day for fridge-defrosting a chicken, a 24-hour fast, or an unmissable deadline. Below it, a <a href="/timer/set-timer-for-12-hours">12-hour countdown</a> splits the day in half and a <a href="/timer/set-timer-for-10-hours">10-hour timer</a> covers extended shifts and long-haul flights.</p><p>An <a href="/timer/set-timer-for-8-hours">8-hour timer</a> handles overnight checkpoints before the full-day mark, like cold-proofing dough you will shape in the morning. Countdowns this long are about not forgetting rather than precision — pair the timer with a note of what it is for, since you will not remember tomorrow. See <a href="/guides/how-long-to-defrost-chicken">how long to defrost chicken</a> and our <a href="/guides/sourdough-proofing-timer">sourdough proofing guide</a> for jobs that genuinely take a day.</p>',
                'meta_description' => '13-24 hour countdown timers for fasting, defrosting, proofing and day-long deadlines. Set a 24-hour timer once — it counts down reliably in the background.',
            ],
            'timer_unit:minutes' => [
                'h1' => 'Minute Timers: Every Countdown from 1 to 161 Minutes',
                'title' => 'Minute Timers — The Best Timer Durations for Every Task',
                'intro_html' => '<p>Minutes are the natural unit of everyday timing — long enough to finish something, short enough to stay urgent. This archive holds a dedicated page for every duration from 1 to 161 minutes. The most used are the <a href="/timer/set-timer-for-5-minutes">5-minute timer</a> for quick starts and breaks, the <a href="/timer/set-timer-for-10-minutes">10-minute timer</a> for tidy-ups and meditation, and the classic <a href="/timer/set-timer-for-25-minutes">25-minute Pomodoro</a>.</p><p>Beyond those, <a href="/timer/set-timer-for-30-minutes">30 minutes</a> covers workouts and weeknight cooking, <a href="/timer/set-timer-for-45-minutes">45 minutes</a> matches lessons and roasts, and the full <a href="/timer/set-timer-for-60-minutes">60-minute hour</a> anchors deep work. Browse by range below — short, medium, long, and extended — or jump straight to a use case. New to timed work? The <a href="/guides/pomodoro-technique">Pomodoro Technique guide</a> and our <a href="/guides/best-online-timers">comparison of online timers</a> are the right starting points. Every duration page starts with a single click and keeps counting accurately even when the tab sits in the background.</p>',
                'meta_description' => 'Free online minute timers for every duration from 1 to 161 minutes. One-click 5, 10, 25, 30, 45 and 60-minute countdowns for work, cooking and workouts.',
            ],
            'timer_unit:seconds' => [
                'h1' => 'Second Timers: Precise 1–60 Second Countdowns',
                'title' => 'Second Timers — The Best Precise Countdown Durations',
                'intro_html' => '<p>When the exact moment matters, you need seconds, not minutes. This archive has a page for every countdown from 1 to 60 seconds. Interval athletes live in the <a href="/timer/set-timer-for-20-seconds">20-second</a> and <a href="/timer/set-timer-for-30-seconds">30-second timers</a> — the building blocks of Tabata and HIIT — while a <a href="/timer/set-timer-for-10-seconds">10-second countdown</a> cues holds, starts, and transitions.</p><p>The <a href="/timer/set-timer-for-45-seconds">45-second timer</a> is a classic plank target, and the <a href="/timer/set-timer-for-60-seconds">60-second timer</a> rounds out the range for one-minute rests, breathing rounds, and speed drills. Every page starts with one click and restarts instantly, which matters when you repeat an interval twenty times. See the <a href="/guides/tabata-timer-guide">Tabata guide</a> and <a href="/guides/breathing-timers">breathing timer guide</a> for structured second-by-second routines. For repeated rounds, decide your total round count before you start — a target like eight rounds keeps the session honest when fatigue argues otherwise.</p>',
                'meta_description' => 'Free online second timers from 1 to 60 seconds. One-click 10, 20, 30, 45 and 60-second countdowns for HIIT intervals, planks, rests and breathing drills.',
            ],
            'timer_unit:hours' => [
                'h1' => 'Hour Timers: Long Countdowns from 1 to 24 Hours',
                'title' => 'Hour Timers — The Best Long Countdown Durations',
                'intro_html' => '<p>Hour timers are set-and-forget countdowns for jobs measured in large blocks of the day. The <a href="/timer/set-timer-for-1-hour">1-hour timer</a> caps meetings and parking; <a href="/timer/set-timer-for-2-hours">2 hours</a> matches exams and braises; and the <a href="/timer/set-timer-for-4-hours">4-hour</a> and <a href="/timer/set-timer-for-8-hours">8-hour timers</a> track marinating, shifts, and sleep.</p><p>The <a href="/timer/set-timer-for-12-hours">12-hour</a> and <a href="/timer/set-timer-for-24-hours">24-hour countdowns</a> handle overnight proofing, fasting windows, and day-long deadlines. All hour timers keep counting accurately in a background tab and alert you when time is up, so you can set one and close the lid on the task. For hour-scale timing details, start with our <a href="/guides/slow-cooker-timing-guide">slow cooker timing guide</a> and <a href="/guides/how-long-to-nap">nap length guide</a>. Longer countdowns pair well with a written note of what the alarm means — set it, label it, and forget it until the alert brings you back.</p>',
                'meta_description' => 'Free online hour timers from 1 to 24 hours. One-click 1, 2, 4, 8, 12 and 24-hour countdowns for cooking, shifts, fasting and deadlines — reliable in background.',
            ],
        ];
    }
}

if (!function_exists('blogtimer_taxhub_copyblocks_overrides')) {
    /**
     * Optional per-term overrides from datasets/copyblocks.json ("taxonomyHubs").
     * Path fallbacks mirror Timer_Content_Loader::get_datasets_path().
     */
    function blogtimer_taxhub_copyblocks_overrides()
    {
        static $overrides = null;

        if ($overrides !== null) {
            return $overrides;
        }

        $overrides = [];
        $paths = [
            '/var/www/datasets/copyblocks.json',
            ABSPATH . '../datasets/copyblocks.json',
            ABSPATH . 'datasets/copyblocks.json',
        ];

        foreach ($paths as $path) {
            if (!is_readable($path)) {
                continue;
            }
            $data = json_decode((string) file_get_contents($path), true);
            if (is_array($data) && isset($data['taxonomyHubs']) && is_array($data['taxonomyHubs'])) {
                $overrides = $data['taxonomyHubs'];
            }
            break;
        }

        return $overrides;
    }
}

if (!function_exists('blogtimer_taxhub_copy')) {
    /**
     * Resolve hub copy for a term: copyblocks.json overrides win, built-in
     * library is the fallback. Returns null when the term has no hub copy.
     */
    function blogtimer_taxhub_copy($taxonomy, $slug)
    {
        $key = $taxonomy . ':' . $slug;
        $library = blogtimer_taxhub_copy_library();
        $copy = $library[$key] ?? null;

        $overrides = blogtimer_taxhub_copyblocks_overrides();
        if (isset($overrides[$key]) && is_array($overrides[$key])) {
            $copy = array_merge(is_array($copy) ? $copy : [], $overrides[$key]);
        }

        return $copy;
    }
}

if (!function_exists('blogtimer_taxhub_intro_kses')) {
    function blogtimer_taxhub_intro_kses($html)
    {
        return wp_kses((string) $html, [
            'p' => [],
            'a' => ['href' => [], 'title' => []],
            'strong' => [],
            'em' => [],
        ]);
    }
}

if (!function_exists('blogtimer_taxhub_is_hub')) {
    function blogtimer_taxhub_is_hub()
    {
        return is_tax(['timer_usecase', 'timer_bucket', 'timer_unit']);
    }
}

// ==========================================
// TAXONOMY HUB SEO HEAD OVERRIDES
// ==========================================
// This file is required by the taxonomy templates BEFORE get_header(), so the
// hooks below register ahead of wp_head / title rendering. They only ever act
// on the three timer taxonomies and are no-ops everywhere else.

// Descriptive document title, no brand suffix ("<Hub Name> — The Best Timer
// Durations for <use case>"). Paginated pages get a " - Page N" suffix.
add_filter('pre_get_document_title', function ($title) {
    if (!blogtimer_taxhub_is_hub()) {
        return $title;
    }

    $term = get_queried_object();
    if (!$term instanceof WP_Term) {
        return $title;
    }

    $copy = blogtimer_taxhub_copy($term->taxonomy, $term->slug);
    if (empty($copy['title'])) {
        return $title;
    }

    $hub_title = (string) $copy['title'];
    $paged = max(1, (int) get_query_var('paged'));
    if ($paged > 1) {
        $hub_title .= sprintf(' - Page %d', $paged);
    }

    return $hub_title;
}, 20);

// Per-term meta description. timer-engine.php emits a generic taxonomy meta
// description at wp_head priority 1; on these hubs only, we remove it and emit
// the curated per-term copy instead so exactly one description tag ships.
add_action('wp_head', function () {
    if (!blogtimer_taxhub_is_hub()) {
        return;
    }

    $term = get_queried_object();
    if (!$term instanceof WP_Term) {
        return;
    }

    $copy = blogtimer_taxhub_copy($term->taxonomy, $term->slug);
    if (empty($copy['meta_description'])) {
        return;
    }

    if (class_exists('Timer_Engine')) {
        remove_action('wp_head', [Timer_Engine::get_instance(), 'output_seo_meta'], 1);
    }

    echo '<meta name="description" content="' . esc_attr($copy['meta_description']) . '">' . "\n";
}, 0);

// rel prev/next for paginated hub archives (/page/2 ranked at position 77-99
// in GSC); the intro + curated sections render on page 1 only in the templates.
add_action('wp_head', function () {
    if (!blogtimer_taxhub_is_hub()) {
        return;
    }

    global $wp_query;
    $max_pages = isset($wp_query->max_num_pages) ? (int) $wp_query->max_num_pages : 0;
    if ($max_pages < 2) {
        return;
    }

    $paged = max(1, (int) get_query_var('paged'));
    if ($paged > 1) {
        echo '<link rel="prev" href="' . esc_url(get_pagenum_link($paged - 1, false)) . '">' . "\n";
    }
    if ($paged < $max_pages) {
        echo '<link rel="next" href="' . esc_url(get_pagenum_link($paged + 1, false)) . '">' . "\n";
    }
}, 2);
