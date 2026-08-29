<?php
/**
 * Template Name: Pomodoro Planner Page
 * Description: Plan a work block into pomodoros and get the real finish time including breaks
 */

get_header();

/**
 * Single source of truth for the FAQ copy.
 * Rendered as visible HTML below and re-used verbatim in the FAQPage JSON-LD
 * so the structured data can never drift from what the visitor reads.
 */
$planner_faqs = [
    [
        'q' => 'How many pomodoros do I need for 4 hours of work?',
        'a' => 'Four hours of focused work is 240 minutes, which is 10 pomodoros at the classic 25-minute length. The part people miss is the gaps: 9 breaks sit between those 10 pomodoros, and with a long break after every 4th that adds 65 minutes. So 4 hours of work occupies 5 hours 5 minutes of clock time. Start at 9:00 and you finish at 14:05, not at 13:00.',
    ],
    [
        'q' => 'Why is my finish time later than the amount of work I entered?',
        'a' => 'Because breaks are real clock time. Eight pomodoros is 200 minutes of focus, but the 7 breaks between them add 45 minutes at the classic 25/5/15 settings, so the block actually runs 4 hours 5 minutes. Planning against focus minutes alone is the single most common reason a pomodoro day overruns.',
    ],
    [
        'q' => 'Where does the 25 minute and 5 minute split come from?',
        'a' => 'The Pomodoro Technique was created by Francesco Cirillo in the late 1980s, when he was a university student in Italy, and it is named after the tomato-shaped kitchen timer he used. The 25/5 rhythm with a longer break after four pomodoros is the structure Cirillo published. It came out of his own experimenting with a timer, not out of a laboratory, so treat it as a well-tested default rather than a measured optimum.',
    ],
    [
        'q' => 'Should I use 25, 50 or 90 minute focus blocks?',
        'a' => 'The intervals are a starting point, not a rule. Many people work better in 50-minute or 90-minute blocks, especially on work with a long warm-up such as writing, debugging or design. Shorter 15 to 25 minute blocks tend to suit admin, revision and tasks you are avoiding. Change the focus length in the planner and watch the finish time move, then keep whichever length you can actually repeat all day.',
    ],
    [
        'q' => 'Do I take a break after the last pomodoro?',
        'a' => 'This planner does not schedule one. The finish time it gives you is the end of the final focus block, because a break after you have stopped working is just the rest of your day. If you are chaining a second block later, add the long break yourself before the next session starts.',
    ],
    [
        'q' => 'Can I plan backwards from a deadline instead?',
        'a' => 'Yes. Switch the planner to "I need to finish by" and enter the clock time you have to be done. It fits as many whole pomodoros as will fit between your start time and that deadline, including every break, and tells you how much slack is left over. Schedules that cross midnight are handled correctly and marked with a next-day tag.',
    ],
];
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Pomodoro Planner &mdash; How Many Pomodoros, and What Time You Actually Finish</h1>
        <p class="page-intro">Enter how much work you have, or the time you need to be done, and this planner returns the number of pomodoros plus a full printable timeline with the real clock finish time &mdash; breaks included.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" style="color:var(--color-accent);text-decoration:none;font-weight:600;" rel="author">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#5b6478);margin-top:2px;">Last updated: 2026-08-29 &middot; ~7 min read &middot; Interval structure per Francesco Cirillo's Pomodoro Technique</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Divide your focus minutes by your pomodoro length to get the number of pomodoros, then add every break back in to get the real finish time. Eight classic pomodoros is 200 minutes of work but <strong>4 hours 5 minutes of clock time</strong> &mdash; the 7 breaks (three short, one long, three short) add 45 minutes. Start at 09:00 and you finish at 13:05, not 12:20. The planner below does that arithmetic live and prints the timeline. The 25/5 split comes from Francesco Cirillo's Pomodoro Technique; the intervals are a starting point, not a rule, and plenty of people work better in 50-minute or 90-minute blocks.</p>
        </div>
    </div>

    <style>
        /* ===========================================================
           Pomodoro Planner tool — scoped to #pp-tool.
           Uses only existing theme design tokens (no new colour values).
           =========================================================== */
        #pp-tool [hidden] { display: none !important; }

        .pp-panel {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: var(--space-5);
            margin-top: var(--space-6);
        }

        .pp-legend {
            display: block;
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            color: var(--color-text-muted);
            margin-bottom: var(--space-3);
        }

        /* Mode switch (segmented control built from radios) */
        .pp-modes {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            margin-bottom: var(--space-5);
        }
        .pp-seg { position: relative; flex: 1 1 220px; }
        .pp-seg input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
            margin: 0;
        }
        .pp-seg span {
            display: block;
            text-align: center;
            padding: 0.7rem 0.9rem;
            min-height: 44px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background: var(--color-bg);
            color: var(--color-text-secondary);
            font-size: var(--text-sm);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-base, 0.2s ease);
        }
        .pp-seg span:hover { border-color: var(--color-accent); color: var(--color-text-primary); }
        .pp-seg input:checked + span {
            background: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-text-inverse);
        }
        .pp-seg input:focus-visible + span { outline: 2px solid var(--color-border-focus); outline-offset: 2px; }

        /* Input grid */
        .pp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: var(--space-4);
        }
        .pp-field { display: flex; flex-direction: column; gap: 0.3rem; min-width: 0; }
        .pp-field > label {
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--color-text-secondary);
        }
        .pp-field .pp-hint { font-size: 0.75rem; color: var(--color-text-muted); }
        .pp-input,
        .pp-select {
            width: 100%;
            box-sizing: border-box;
            min-height: 44px;
            padding: 0.55rem 0.75rem;
            font-size: 1rem;
            font-family: inherit;
            color: var(--color-text-primary);
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }
        .pp-input:focus,
        .pp-select:focus {
            outline: 2px solid var(--color-border-focus);
            outline-offset: 1px;
            border-color: var(--color-accent);
        }
        .pp-row { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
        .pp-row > .pp-input { flex: 1 1 100px; }
        .pp-row > .pp-select { flex: 1 1 110px; }

        .pp-presets { display: flex; flex-wrap: wrap; gap: var(--space-2); margin-top: var(--space-5); }
        .pp-presets .btn { min-height: 44px; }

        .pp-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: var(--space-4);
            font-size: var(--text-sm);
            color: var(--color-text-secondary);
            cursor: pointer;
        }
        .pp-check input { width: 18px; height: 18px; accent-color: var(--color-accent); }

        /* Result */
        .pp-headline {
            font-size: clamp(1.15rem, 3.4vw, 1.6rem);
            font-weight: 700;
            line-height: 1.35;
            color: var(--color-text-primary);
            margin: 0 0 var(--space-4);
        }
        .pp-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: var(--space-3);
        }
        .pp-stat {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: var(--space-3) var(--space-4);
        }
        .pp-stat dt {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--color-text-muted);
            margin: 0 0 0.2rem;
        }
        .pp-stat dd {
            margin: 0;
            font-size: var(--text-xl);
            font-weight: 700;
            color: var(--color-text-primary);
            font-variant-numeric: tabular-nums;
        }
        .pp-stat--hero { background: var(--color-accent-soft); border-color: var(--color-accent); }
        .pp-stat--hero dd { color: var(--color-accent); }

        .pp-notes {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            margin-top: var(--space-3);
            line-height: 1.5;
        }

        /* Timeline table — scrolls inside its own wrapper, never the page */
        .pp-tablewrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: var(--space-5);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }
        .pp-tablewrap:focus-visible { outline: 2px solid var(--color-border-focus); outline-offset: 2px; }
        .pp-table {
            width: 100%;
            min-width: 440px;
            border-collapse: collapse;
            font-size: var(--text-sm);
        }
        .pp-table caption {
            caption-side: top;
            text-align: left;
            padding: var(--space-3) var(--space-4);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--color-text-muted);
        }
        .pp-table th {
            text-align: left;
            padding: var(--space-3) var(--space-4);
            background: var(--color-bg-card);
            border-bottom: 2px solid var(--color-accent);
            color: var(--color-text-primary);
            font-weight: 600;
            white-space: nowrap;
        }
        .pp-table td {
            padding: var(--space-3) var(--space-4);
            border-bottom: 1px solid var(--color-border);
            color: var(--color-text-secondary);
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }
        .pp-table tr:last-child td { border-bottom: 0; }

        .pp-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .pp-badge--focus { background: var(--color-accent-soft); color: var(--color-accent); }
        .pp-badge--short { background: var(--color-surface); color: var(--color-text-secondary); }
        .pp-badge--long { background: var(--color-success-soft); color: var(--color-success); }

        .pp-actions { display: flex; flex-wrap: wrap; gap: var(--space-2); margin-top: var(--space-4); }
        .pp-actions .btn { min-height: 44px; }
        .pp-status {
            font-size: var(--text-sm);
            color: var(--color-accent);
            margin-top: var(--space-3);
            min-height: 1.2em;
            line-height: 1.45;
        }
        .pp-fallback {
            width: 100%;
            box-sizing: border-box;
            margin-top: var(--space-3);
            min-height: 160px;
            padding: var(--space-3);
            font-family: var(--font-mono);
            font-size: 0.8125rem;
            line-height: 1.5;
            color: var(--color-text-primary);
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }

        @media (max-width: 480px) {
            .pp-panel { padding: var(--space-4); }
            .pp-actions .btn, .pp-presets .btn { flex: 1 1 100%; }
        }

        @media print {
            .pp-noprint { display: none !important; }
            .pp-panel { border: 0; padding: 0; }
            .pp-tablewrap { overflow: visible; border: 0; }
            .pp-table { min-width: 0; }
        }
    </style>

    <!-- POMODORO PLANNER TOOL -->
    <div class="container">
        <div id="pp-tool">

            <!-- Inputs -->
            <div class="pp-panel pp-noprint">
                <span class="pp-legend" id="pp-mode-legend">What are you planning?</span>
                <div class="pp-modes" role="radiogroup" aria-labelledby="pp-mode-legend">
                    <label class="pp-seg">
                        <input type="radio" name="pp-mode" value="work" checked>
                        <span>I have this much work</span>
                    </label>
                    <label class="pp-seg">
                        <input type="radio" name="pp-mode" value="deadline">
                        <span>I need to finish by</span>
                    </label>
                </div>

                <div id="pp-group-work" class="pp-grid">
                    <div class="pp-field">
                        <label for="pp-amount">Amount of work</label>
                        <div class="pp-row">
                            <input class="pp-input" type="number" id="pp-amount" value="2" min="1" max="5000" step="1" inputmode="numeric">
                            <select class="pp-select" id="pp-unit">
                                <option value="hours" selected>hours</option>
                                <option value="minutes">minutes</option>
                            </select>
                        </div>
                        <span class="pp-hint">Focus time only &mdash; breaks are added for you.</span>
                    </div>
                    <div class="pp-field">
                        <label for="pp-start">Start time</label>
                        <input class="pp-input" type="time" id="pp-start">
                        <button type="button" class="btn btn--secondary" id="pp-now" style="margin-top:0.35rem;min-height:44px;">Use current time</button>
                    </div>
                </div>

                <div id="pp-group-deadline" class="pp-grid" hidden>
                    <div class="pp-field">
                        <label for="pp-start-2">Start time</label>
                        <input class="pp-input" type="time" id="pp-start-2" aria-describedby="pp-deadline-hint">
                        <span class="pp-hint" id="pp-deadline-hint">Kept in sync with the start time above.</span>
                    </div>
                    <div class="pp-field">
                        <label for="pp-deadline">Finish by</label>
                        <input class="pp-input" type="time" id="pp-deadline">
                        <span class="pp-hint">A time earlier than the start is read as tomorrow.</span>
                    </div>
                </div>

                <div class="pp-grid" style="margin-top:var(--space-5);">
                    <div class="pp-field">
                        <label for="pp-focus">Focus length (min)</label>
                        <input class="pp-input" type="number" id="pp-focus" value="25" min="1" max="240" step="1" inputmode="numeric">
                    </div>
                    <div class="pp-field">
                        <label for="pp-short">Short break (min)</label>
                        <input class="pp-input" type="number" id="pp-short" value="5" min="0" max="120" step="1" inputmode="numeric">
                    </div>
                    <div class="pp-field">
                        <label for="pp-long">Long break (min)</label>
                        <input class="pp-input" type="number" id="pp-long" value="15" min="0" max="240" step="1" inputmode="numeric">
                    </div>
                    <div class="pp-field">
                        <label for="pp-every">Long break after every</label>
                        <input class="pp-input" type="number" id="pp-every" value="4" min="1" max="12" step="1" inputmode="numeric">
                        <span class="pp-hint">pomodoros</span>
                    </div>
                </div>

                <div class="pp-presets">
                    <button type="button" class="btn btn--secondary" data-focus="25" data-short="5" data-long="15" data-every="4">Classic 25 / 5 / 15</button>
                    <button type="button" class="btn btn--secondary" data-focus="50" data-short="10" data-long="20" data-every="2">Extended 50 / 10 / 20</button>
                    <button type="button" class="btn btn--secondary" data-focus="90" data-short="20" data-long="30" data-every="2">Deep work 90 / 20 / 30</button>
                </div>

                <label class="pp-check" for="pp-12h">
                    <input type="checkbox" id="pp-12h">
                    Show times on a 12-hour clock
                </label>
            </div>

            <!-- Results -->
            <div class="pp-panel">
                <span class="pp-legend">Your plan</span>
                <p class="pp-headline" id="pp-headline" role="status" aria-live="polite">Building your schedule&hellip;</p>

                <dl class="pp-stats" id="pp-stats" hidden>
                    <div class="pp-stat pp-stat--hero">
                        <dt>Pomodoros</dt>
                        <dd id="pp-stat-count">&mdash;</dd>
                    </div>
                    <div class="pp-stat pp-stat--hero">
                        <dt>You finish at</dt>
                        <dd id="pp-stat-finish">&mdash;</dd>
                    </div>
                    <div class="pp-stat">
                        <dt>Total focus</dt>
                        <dd id="pp-stat-focus">&mdash;</dd>
                    </div>
                    <div class="pp-stat">
                        <dt>Total breaks</dt>
                        <dd id="pp-stat-breaks">&mdash;</dd>
                    </div>
                    <div class="pp-stat">
                        <dt>Clock time</dt>
                        <dd id="pp-stat-clock">&mdash;</dd>
                    </div>
                </dl>

                <p class="pp-notes" id="pp-notes"></p>

                <div class="pp-tablewrap" id="pp-tablewrap" tabindex="0" role="region" aria-label="Pomodoro session timeline" hidden>
                    <table class="pp-table">
                        <caption>Every session with its clock start and end time</caption>
                        <thead>
                            <tr>
                                <th scope="col">Session</th>
                                <th scope="col">Starts</th>
                                <th scope="col">Ends</th>
                                <th scope="col">Length</th>
                            </tr>
                        </thead>
                        <tbody id="pp-rows"></tbody>
                    </table>
                </div>

                <div class="pp-actions pp-noprint" id="pp-actions" hidden>
                    <button type="button" class="btn btn--primary" id="pp-copy">Copy schedule</button>
                    <button type="button" class="btn btn--secondary" id="pp-print">Print schedule</button>
                    <a class="btn btn--secondary" href="<?php echo esc_url(home_url('/pomodoro')); ?>">Run the actual timer</a>
                </div>

                <p class="pp-status pp-noprint" id="pp-status" role="status" aria-live="polite"></p>
                <textarea class="pp-fallback pp-noprint" id="pp-fallback-text" readonly aria-label="Plain-text schedule to copy manually" hidden></textarea>
            </div>

        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Arithmetic Everyone Gets Wrong</h2>
            <p>Eight pomodoros is not "about three and a half hours." Eight pomodoros of work is 200 minutes, but the seven gaps between them are real time on the clock. At the classic settings that is three short breaks, one long break, then three more short breaks: 15 + 15 + 15 = 45 minutes. The block runs <strong>245 minutes, or 4 hours 5 minutes</strong>. Start at 09:00 and you are done at 13:05.</p>

            <p>The error compounds with the size of the day. Plan a 6-hour block of focus in pomodoros and you have quietly committed to 7 hours 40 minutes of desk time: 15 pomodoros, 14 breaks, 1 hour 40 minutes of them. That is the difference between finishing before dinner and finishing after it, and it is why so many pomodoro days end with the last two sessions abandoned.</p>

            <h2 class="section-title">Focus Time vs Clock Time at Classic Settings</h2>
            <p>Every row below uses a 25-minute focus block, a 5-minute short break, and a 15-minute long break after every 4 pomodoros, with no break scheduled after the final pomodoro.</p>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Pomodoros</th>
                        <th>Focus time</th>
                        <th>Break time</th>
                        <th>Clock time</th>
                        <th>Start 09:00, finish at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>2</strong></td><td>50 min</td><td>5 min</td><td>55 min</td><td>09:55</td></tr>
                    <tr><td><strong>4</strong></td><td>1 hr 40 min</td><td>15 min</td><td>1 hr 55 min</td><td>10:55</td></tr>
                    <tr><td><strong>6</strong></td><td>2 hr 30 min</td><td>35 min</td><td>3 hr 5 min</td><td>12:05</td></tr>
                    <tr><td><strong>8</strong></td><td>3 hr 20 min</td><td>45 min</td><td>4 hr 5 min</td><td>13:05</td></tr>
                    <tr><td><strong>10</strong></td><td>4 hr 10 min</td><td>1 hr 5 min</td><td>5 hr 15 min</td><td>14:15</td></tr>
                    <tr><td><strong>12</strong></td><td>5 hr</td><td>1 hr 15 min</td><td>6 hr 15 min</td><td>15:15</td></tr>
                    <tr><td><strong>16</strong></td><td>6 hr 40 min</td><td>1 hr 45 min</td><td>8 hr 25 min</td><td>17:25</td></tr>
                </tbody>
            </table>
            <p style="font-size:var(--text-sm);color:var(--color-text-muted);">Read the last two columns together: the gap between them is the tax the technique charges, and it grows from 5 minutes to 1 hour 45 minutes across a full day.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Where the 25/5 Split Comes From</h2>
            <p>The classic 25/5 split comes from Francesco Cirillo's Pomodoro Technique, developed in the late 1980s when Cirillo was a university student in Italy and timed his study sessions with a tomato-shaped kitchen timer &mdash; <em>pomodoro</em> is Italian for tomato. His published structure is the one this planner defaults to: a 25-minute focused interval, a 5-minute break, and a longer 15 to 30 minute break after every fourth pomodoro.</p>

            <p><strong>The intervals are a starting point, not a rule.</strong> Cirillo's numbers came from his own experimenting with a kitchen timer, not from a controlled study, and there is nothing special about 25 minutes as a unit of human attention. Many people work better in 50-minute or 90-minute blocks, particularly on work with a long warm-up: writing, debugging, design, analysis. Others do better under 25 minutes when the task is one they are avoiding, because a short committed block is easier to start.</p>

            <p>Treat the four number fields in the planner as the actual controls. Change the focus length, watch the finish time move, and keep the setting you can repeat tomorrow. The technique's value is the enforced stop, not the specific integer.</p>

            <h2 class="section-title">Picking an Interval Length</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Block</th>
                        <th>Break</th>
                        <th>Long break</th>
                        <th>Suits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>15 / 3</strong></td><td>3 min</td><td>10 min after 4</td><td>Tasks you are avoiding, admin, email triage, getting unstuck</td></tr>
                    <tr><td><strong>25 / 5 (classic)</strong></td><td>5 min</td><td>15 min after 4</td><td>Studying, revision, mixed task lists, the default to start from</td></tr>
                    <tr><td><strong>50 / 10</strong></td><td>10 min</td><td>20 min after 2</td><td>Writing, coding, work with a slow warm-up and few interruptions</td></tr>
                    <tr><td><strong>90 / 20</strong></td><td>20 min</td><td>30 min after 2</td><td>Deep single-project work, research, design; usually 2&ndash;3 blocks a day maximum</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">How to Use the Planner</h2>
            <ul>
                <li><strong>Plan forward from a workload.</strong> Leave the switch on "I have this much work," enter your focus hours, and read the finish time. If the last pomodoro is shorter than a full block, the planner shows it as a part block rather than rounding your day up.</li>
                <li><strong>Plan backwards from a deadline.</strong> Switch to "I need to finish by" and enter the clock time you must be done. The planner fits as many whole pomodoros as the window allows, breaks included, and reports the slack left over.</li>
                <li><strong>Set the real start time.</strong> "Use current time" fills in the clock now. If you are planning tomorrow morning, type the time instead.</li>
                <li><strong>Copy or print the timeline.</strong> "Copy schedule" puts the plain-text version on your clipboard for a notebook, a task list or a shared doc. "Print schedule" prints just the plan, without the controls.</li>
                <li><strong>Then run the clock elsewhere.</strong> This page plans; it does not tick. Open the <a href="<?php echo esc_url(home_url('/pomodoro')); ?>">Pomodoro timer</a> in a second tab and work the schedule.</li>
            </ul>

            <h2 class="section-title">Planning Mistakes That Blow Up the Schedule</h2>

            <h3>Counting focus minutes as the workday</h3>
            <p>The whole reason this tool exists. Six hours of pomodoro focus is not a six-hour day. Always plan against clock time, then decide whether that block still fits.</p>

            <h3>Scheduling meetings inside a block</h3>
            <p>A pomodoro block only works if it is uninterrupted. Slot meetings against the plan's long breaks, or split the day into two blocks with the meeting between them &mdash; run the planner twice.</p>

            <h3>Planning nine hours of pomodoros</h3>
            <p>Ten to twelve pomodoros is a heavy but achievable day for most people; anything past that tends to be aspiration rather than a plan. If the planner is returning 16+ pomodoros, cut scope before you cut break length.</p>

            <h3>Shrinking the breaks to finish sooner</h3>
            <p>It works arithmetically and fails in practice: the breaks are what make the later pomodoros usable. If the finish time is too late, take a pomodoro out of the plan rather than minutes out of the breaks.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Related Focus Tools</h2>
            <div class="timer-grid">
                <a href="<?php echo esc_url(home_url('/pomodoro')); ?>" class="btn btn--secondary">
                    <strong>Pomodoro Timer</strong>
                    <span>Run the 25/5 clock</span>
                </a>
                <a href="<?php echo esc_url(home_url('/focus-timer')); ?>" class="btn btn--secondary">
                    <strong>Focus Timer</strong>
                    <span>Single deep-work block</span>
                </a>
                <a href="<?php echo esc_url(home_url('/study-timer')); ?>" class="btn btn--secondary">
                    <strong>Study Timer</strong>
                    <span>Revision sessions</span>
                </a>
                <a href="<?php echo esc_url(home_url('/study-work-timers')); ?>" class="btn btn--secondary">
                    <strong>Study &amp; Work Timers</strong>
                    <span>All focus timers</span>
                </a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Pomodoro Planner FAQ</h2>
            <?php blogtimer_render_faq($planner_faqs); ?>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script>
(function () {
    'use strict';

    var root = document.getElementById('pp-tool');
    if (!root) { return; }

    var PLANNER_URL = '<?php echo esc_js(home_url('/pomodoro-planner')); ?>';
    var MAX_POMODOROS = 40;
    var MINUTES_PER_DAY = 1440;

    function el(id) { return document.getElementById(id); }
    function pad(n) { return (n < 10 ? '0' : '') + n; }

    /* ---------- input reading ---------- */

    function readInt(id, def, min, max) {
        var node = el(id);
        if (!node) { return def; }
        var v = parseInt(node.value, 10);
        if (isNaN(v)) { return def; }
        if (v < min) { v = min; }
        if (v > max) { v = max; }
        return v;
    }

    function parseClock(value) {
        if (!value) { return null; }
        var parts = String(value).split(':');
        if (parts.length < 2) { return null; }
        var h = parseInt(parts[0], 10);
        var m = parseInt(parts[1], 10);
        if (isNaN(h) || isNaN(m)) { return null; }
        if (h < 0 || h > 23 || m < 0 || m > 59) { return null; }
        return h * 60 + m;
    }

    function currentMinutes() {
        var d = new Date();
        return d.getHours() * 60 + d.getMinutes();
    }

    function clockValue(total) {
        var m = ((total % MINUTES_PER_DAY) + MINUTES_PER_DAY) % MINUTES_PER_DAY;
        return pad(Math.floor(m / 60)) + ':' + pad(m % 60);
    }

    /* ---------- formatting (all maths stays in integer minutes) ---------- */

    function use12h() {
        var c = el('pp-12h');
        return !!(c && c.checked);
    }

    function formatClock(total) {
        var m = ((total % MINUTES_PER_DAY) + MINUTES_PER_DAY) % MINUTES_PER_DAY;
        var h = Math.floor(m / 60);
        var mm = m % 60;
        if (use12h()) {
            var suffix = h < 12 ? 'AM' : 'PM';
            var h12 = h % 12;
            if (h12 === 0) { h12 = 12; }
            return h12 + ':' + pad(mm) + ' ' + suffix;
        }
        return pad(h) + ':' + pad(mm);
    }

    function dayTag(total) {
        var d = Math.floor(total / MINUTES_PER_DAY);
        return d > 0 ? ' (+' + d + 'd)' : '';
    }

    function formatDuration(mins) {
        if (mins < 60) { return mins + ' min'; }
        var h = Math.floor(mins / 60);
        var m = mins % 60;
        return m === 0 ? h + ' hr' : h + ' hr ' + m + ' min';
    }

    /* ---------- schedule maths ---------- */

    function breakMinutesFor(gapIndex, shortB, longB, every) {
        return (every > 0 && gapIndex % every === 0) ? longB : shortB;
    }

    function elapsedFor(n, focus, shortB, longB, every) {
        if (n <= 0) { return 0; }
        var total = n * focus;
        for (var i = 1; i <= n - 1; i++) {
            total += breakMinutesFor(i, shortB, longB, every);
        }
        return total;
    }

    function currentMode() {
        var picked = root.querySelector('input[name="pp-mode"]:checked');
        return picked ? picked.value : 'work';
    }

    function build() {
        var focus = readInt('pp-focus', 25, 1, 240);
        var shortB = readInt('pp-short', 5, 0, 120);
        var longB = readInt('pp-long', 15, 0, 240);
        var every = readInt('pp-every', 4, 1, 12);
        var mode = currentMode();

        var plan = {
            ok: false, message: '', notes: [], segments: [],
            mode: mode, focus: focus, shortB: shortB, longB: longB, every: every,
            start: 0, finish: 0, elapsed: 0, focusTotal: 0, breakTotal: 0,
            count: 0, spare: null
        };

        var startNode = (mode === 'work') ? el('pp-start') : el('pp-start-2');
        var start = parseClock(startNode ? startNode.value : '');
        if (start === null) {
            plan.message = 'Enter a start time to build the schedule.';
            return plan;
        }
        plan.start = start;

        var n = 0;
        var lastLen = focus;
        var capped = false;
        var i;

        if (mode === 'work') {
            var amount = readInt('pp-amount', 2, 1, 5000);
            var unitNode = el('pp-unit');
            var unit = unitNode ? unitNode.value : 'hours';
            var workMin = (unit === 'hours') ? amount * 60 : amount;
            if (workMin < 1) { workMin = 1; }
            if (workMin > MINUTES_PER_DAY) {
                workMin = MINUTES_PER_DAY;
                plan.notes.push('Work capped at 24 hours of focus.');
            }
            n = Math.ceil(workMin / focus);
            if (n > MAX_POMODOROS) {
                n = MAX_POMODOROS;
                capped = true;
                lastLen = focus;
            } else {
                lastLen = workMin - (n - 1) * focus;
            }
        } else {
            var end = parseClock(el('pp-deadline') ? el('pp-deadline').value : '');
            if (end === null) {
                plan.message = 'Enter the time you need to finish by.';
                return plan;
            }
            var avail = end - start;
            if (avail <= 0) { avail += MINUTES_PER_DAY; }

            var fit = 0;
            for (i = 1; i <= MAX_POMODOROS; i++) {
                if (elapsedFor(i, focus, shortB, longB, every) <= avail) {
                    fit = i;
                } else {
                    break;
                }
            }
            if (fit === 0) {
                plan.message = 'There is not enough time before that deadline for a single ' + focus + '-minute pomodoro. Shorten the focus block or move the deadline.';
                return plan;
            }
            if (fit === MAX_POMODOROS) { capped = true; }
            n = fit;
            lastLen = focus;
            plan.spare = avail - elapsedFor(n, focus, shortB, longB, every);
        }

        if (capped) {
            plan.notes.push('Capped at ' + MAX_POMODOROS + ' pomodoros; plan anything beyond that as a second block.');
        }

        /* Build the segment list. No break is scheduled after the final pomodoro. */
        var segs = [];
        for (i = 1; i <= n; i++) {
            var len = (i === n) ? lastLen : focus;
            if (len > 0) {
                segs.push({
                    kind: 'focus',
                    label: 'Focus ' + i,
                    minutes: len,
                    partial: (i === n && len < focus)
                });
            }
            if (i < n) {
                var bm = breakMinutesFor(i, shortB, longB, every);
                var isLong = (every > 0 && i % every === 0);
                if (bm > 0) {
                    segs.push({
                        kind: isLong ? 'long' : 'short',
                        label: isLong ? 'Long break' : 'Short break',
                        minutes: bm,
                        partial: false
                    });
                }
            }
        }

        /* Accumulate integer minutes; clock formatting happens only at render time. */
        var cursor = start;
        for (i = 0; i < segs.length; i++) {
            segs[i].start = cursor;
            cursor += segs[i].minutes;
            segs[i].end = cursor;
            if (segs[i].kind === 'focus') {
                plan.focusTotal += segs[i].minutes;
            } else {
                plan.breakTotal += segs[i].minutes;
            }
        }

        plan.segments = segs;
        plan.count = n;
        plan.finish = cursor;
        plan.elapsed = cursor - start;
        plan.ok = segs.length > 0;
        return plan;
    }

    /* ---------- rendering ---------- */

    function setText(id, value) {
        var node = el(id);
        if (node) { node.textContent = String(value); }
    }

    function cell(text) {
        var td = document.createElement('td');
        td.textContent = text;
        return td;
    }

    function render() {
        var plan = build();
        var body = el('pp-rows');
        var status = el('pp-status');
        var fallback = el('pp-fallback-text');

        if (status) { status.textContent = ''; }
        if (fallback) { fallback.hidden = true; }
        while (body.firstChild) { body.removeChild(body.firstChild); }

        if (!plan.ok) {
            setText('pp-headline', plan.message || 'Adjust the inputs to build a schedule.');
            el('pp-stats').hidden = true;
            el('pp-tablewrap').hidden = true;
            el('pp-actions').hidden = true;
            setText('pp-notes', '');
            return;
        }

        el('pp-stats').hidden = false;
        el('pp-tablewrap').hidden = false;
        el('pp-actions').hidden = false;

        setText('pp-headline',
            plan.count + (plan.count === 1 ? ' pomodoro' : ' pomodoros') +
            ', finishing at ' + formatClock(plan.finish) + dayTag(plan.finish) +
            ' — ' + formatDuration(plan.elapsed) + ' of clock time for ' +
            formatDuration(plan.focusTotal) + ' of focus.');

        setText('pp-stat-count', plan.count);
        setText('pp-stat-finish', formatClock(plan.finish) + dayTag(plan.finish));
        setText('pp-stat-focus', formatDuration(plan.focusTotal));
        setText('pp-stat-breaks', formatDuration(plan.breakTotal));
        setText('pp-stat-clock', formatDuration(plan.elapsed));

        var notes = plan.notes.slice(0);
        if (plan.mode === 'deadline' && plan.spare !== null) {
            if (plan.spare === 0) {
                notes.push('You finish exactly on the deadline.');
            } else {
                notes.push(formatDuration(plan.spare) + ' of slack left before your deadline.');
            }
        }
        if (plan.finish >= MINUTES_PER_DAY) {
            notes.push('This block runs past midnight; times marked (+1d) are the following day.');
        }
        setText('pp-notes', notes.join(' '));

        for (var i = 0; i < plan.segments.length; i++) {
            var s = plan.segments[i];
            var tr = document.createElement('tr');
            var first = document.createElement('td');
            var badge = document.createElement('span');
            badge.className = 'pp-badge pp-badge--' + s.kind;
            badge.textContent = s.label;
            first.appendChild(badge);
            tr.appendChild(first);
            tr.appendChild(cell(formatClock(s.start) + dayTag(s.start)));
            tr.appendChild(cell(formatClock(s.end) + dayTag(s.end)));
            tr.appendChild(cell(s.minutes + ' min' + (s.partial ? ' (part block)' : '')));
            body.appendChild(tr);
        }
    }

    /* ---------- copy to clipboard ---------- */

    function planToText(plan) {
        var lines = [];
        lines.push('Pomodoro plan');
        lines.push(plan.count + ' pomodoros | ' + formatClock(plan.start) + ' to ' +
            formatClock(plan.finish) + dayTag(plan.finish) + ' | ' +
            formatDuration(plan.elapsed) + ' of clock time');
        lines.push('Focus ' + plan.focus + ' min | short break ' + plan.shortB +
            ' min | long break ' + plan.longB + ' min after every ' + plan.every);
        lines.push('');
        for (var i = 0; i < plan.segments.length; i++) {
            var s = plan.segments[i];
            lines.push(formatClock(s.start) + ' - ' + formatClock(s.end) + dayTag(s.end) +
                '  ' + s.label + ' (' + s.minutes + ' min)');
        }
        lines.push('');
        lines.push('Focus ' + formatDuration(plan.focusTotal) +
            ' | breaks ' + formatDuration(plan.breakTotal) +
            ' | clock time ' + formatDuration(plan.elapsed));
        lines.push(PLANNER_URL);
        return lines.join('\n');
    }

    function showCopyFallback(text) {
        var box = el('pp-fallback-text');
        if (box) {
            box.value = text;
            box.hidden = false;
            try { box.focus(); box.select(); } catch (e) { /* selection is best-effort */ }
        }
        setText('pp-status', 'Clipboard access is not available in this browser. The schedule is in the box below — select it and press Ctrl+C or Cmd+C.');
    }

    function copySchedule() {
        var plan = build();
        if (!plan.ok) {
            setText('pp-status', 'There is no schedule to copy yet.');
            return;
        }
        var text = planToText(plan);
        if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
            navigator.clipboard.writeText(text).then(function () {
                setText('pp-status', 'Schedule copied to your clipboard.');
            }).catch(function () {
                showCopyFallback(text);
            });
        } else {
            showCopyFallback(text);
        }
    }

    /* ---------- wiring ---------- */

    function syncMode() {
        var mode = currentMode();
        el('pp-group-work').hidden = (mode !== 'work');
        el('pp-group-deadline').hidden = (mode === 'work');
    }

    function mirrorStart(source) {
        var a = el('pp-start');
        var b = el('pp-start-2');
        if (!a || !b) { return; }
        if (source === 'pp-start-2') { a.value = b.value; } else { b.value = a.value; }
    }

    function detect12h() {
        try {
            var opts = new Intl.DateTimeFormat(undefined, { hour: 'numeric' }).resolvedOptions();
            if (typeof opts.hour12 === 'boolean') { return opts.hour12; }
            if (typeof opts.hourCycle === 'string') {
                return opts.hourCycle === 'h11' || opts.hourCycle === 'h12';
            }
        } catch (e) { /* Intl unavailable — fall through */ }
        return true;
    }

    function onInput(e) {
        var t = e.target;
        if (t && (t.id === 'pp-start' || t.id === 'pp-start-2')) { mirrorStart(t.id); }
        syncMode();
        render();
    }

    root.addEventListener('input', onInput);
    root.addEventListener('change', onInput);

    root.addEventListener('click', function (e) {
        var t = e.target;
        var btn = (t && t.closest) ? t.closest('button') : null;
        if (!btn) { return; }

        if (btn.id === 'pp-now') {
            var now = clockValue(currentMinutes());
            el('pp-start').value = now;
            el('pp-start-2').value = now;
            render();
            return;
        }
        if (btn.id === 'pp-copy') { copySchedule(); return; }
        if (btn.id === 'pp-print') { window.print(); return; }

        if (btn.getAttribute('data-focus')) {
            el('pp-focus').value = btn.getAttribute('data-focus');
            el('pp-short').value = btn.getAttribute('data-short');
            el('pp-long').value = btn.getAttribute('data-long');
            el('pp-every').value = btn.getAttribute('data-every');
            render();
        }
    });

    /* ---------- init ---------- */

    var startNow = clockValue(currentMinutes());
    if (!el('pp-start').value) { el('pp-start').value = startNow; }
    if (!el('pp-start-2').value) { el('pp-start-2').value = el('pp-start').value; }
    if (!el('pp-deadline').value) { el('pp-deadline').value = clockValue(currentMinutes() + 180); }
    el('pp-12h').checked = detect12h();

    syncMode();
    render();
}());
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Pomodoro Planner",
  "description": "Free Pomodoro planner that turns a block of work, or a deadline, into a full pomodoro schedule with the clock start and end time of every focus session and break, plus the real finish time including breaks.",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Any web browser",
  "browserRequirements": "Requires JavaScript",
  "url": "<?php echo esc_url(home_url('/pomodoro-planner')); ?>",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
  },
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>
<script type="application/ld+json">
<?php
$planner_faq_schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'url'      => home_url('/pomodoro-planner'),
    'mainEntity' => array_map(function ($faq) {
        return [
            '@type' => 'Question',
            'name'  => $faq['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $faq['a'],
            ],
        ];
    }, $planner_faqs),
];
echo wp_json_encode($planner_faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
</script>

<?php get_footer(); ?>
