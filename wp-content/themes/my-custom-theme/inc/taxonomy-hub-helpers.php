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
