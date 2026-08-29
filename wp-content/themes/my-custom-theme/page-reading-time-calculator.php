<?php
/**
 * Template Name: Reading Time Calculator Page
 * Description: Reading time calculator — paste text or enter a word count, pick a
 *              reading speed (238 wpm silent / 183 wpm aloud, from Brysbaert 2019),
 *              get minutes, seconds, a human "min read" phrasing and Pomodoro blocks.
 *
 * Tool page convention: NO visible hero banner (btt_hero_image() is deliberately not
 * called) so the calculator sits directly under the H1. All markup, CSS and JS for the
 * tool live in this file; nothing here touches functions.php, style.css or js/.
 */
get_header();

/**
 * Single source of truth for the FAQ. The same array feeds the visible FAQ block
 * (blogtimer_render_faq) and the FAQPage JSON-LD at the bottom of this file, so the
 * structured data can never drift from the on-page text.
 *
 * Straight apostrophes are avoided in favour of U+2019 so these can stay single-quoted
 * PHP strings; blogtimer_render_faq() runs esc_html() on them, so no HTML entities here.
 */
$rtc_faqs = [
    [
        'q' => 'How is reading time calculated?',
        'a' => 'Reading time is word count divided by reading speed. This calculator counts the words in your text, divides by the words-per-minute figure you choose (238 by default), and shows the result in minutes and seconds. A 1,000-word article at 238 words per minute takes 4 minutes 12 seconds, which most sites would label a 4 min read.',
    ],
    [
        'q' => 'What is the average reading speed for adults?',
        'a' => 'For silent reading of English non-fiction, a meta-analysis of reading-rate studies by Brysbaert (2019), published in the Journal of Memory and Language, put the average at about 238 words per minute. For reading aloud, the same review put the average at about 183 words per minute. Both are population averages, and individual readers vary widely around them.',
    ],
    [
        'q' => 'How long does it take to read 1,000 words?',
        'a' => 'About 4 minutes 12 seconds silently at 238 words per minute, or about 5 minutes 28 seconds read aloud at 183 words per minute. A slower reader at 150 words per minute would need about 6 minutes 40 seconds, and a fast reader at 350 words per minute about 2 minutes 51 seconds.',
    ],
    [
        'q' => 'How long does it take to read a book?',
        'a' => 'A 60,000-word nonfiction book takes about 4 hours 12 minutes of silent reading at 238 words per minute, and a 90,000-word novel about 6 hours 18 minutes. Split into 25-minute focus blocks, that is roughly 11 blocks for the nonfiction book and 16 blocks for the novel.',
    ],
    [
        'q' => 'Should I use the silent reading speed or the reading-aloud speed?',
        'a' => 'Use 238 words per minute for anything a reader will read on a screen or page: a blog post, an article, a report. Use 183 words per minute when the words will be spoken out loud — a presentation script, a podcast intro, a video voiceover, a speech. Speaking is slower than silent reading, so scripting a talk at the silent rate is the usual reason a talk runs long.',
    ],
    [
        'q' => 'Does the calculator count numbers and punctuation as words?',
        'a' => 'Numbers count as words; standalone punctuation does not. The counter trims the text, splits it on any run of whitespace including line breaks and tabs, treats em dashes and double hyphens as separators, then ignores any token with no letters or digits in it. So well-known counts as one word, 2026 counts as one word, and a lone dash counts as none.',
    ],
];
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Reading Time Calculator &mdash; How Long Will This Take to Read?</h1>
        <p class="page-intro">Paste any text or type in a word count and this calculator gives you the reading time instantly &mdash; 238 words per minute for silent reading, 183 words per minute for reading aloud.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-29 &middot; ~8 min read &middot; Reading rates from Brysbaert&rsquo;s 2019 meta-analysis of reading-rate research</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Divide the word count by the reading speed. At the average adult silent-reading rate of <strong>238 words per minute</strong>, 1,000 words takes <strong>4 minutes 12 seconds</strong> &mdash; what most sites would print as &ldquo;about 4 min read&rdquo;. Read the same 1,000 words <strong>aloud at 183 words per minute</strong> and it takes 5 minutes 28 seconds. Both averages come from a meta-analysis of reading-rate studies by Brysbaert (2019) in the <em>Journal of Memory and Language</em>. Paste your own text below for an exact figure, in minutes, seconds and 25-minute Pomodoro blocks.</p>
        </div>
    </div>

    <style id="rtc-css">
        /* ===========================================================
           Reading Time Calculator — page-scoped styles.
           Every colour, space and radius below is an existing theme
           token from style.css; no new palette values are introduced.
           Owned entirely by page-reading-time-calculator.php.
           =========================================================== */

        .rtc {
            margin: var(--space-8) 0 var(--space-6);
        }

        /* Two-column on desktop: inputs left, live output right.
           min-width:0 on the tracks stops long pasted words from
           forcing the grid (and the page) to scroll horizontally. */
        .rtc-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
            gap: var(--space-6);
            align-items: start;
        }

        .rtc-panel {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: var(--space-5);
            min-width: 0;
        }

        /* --- Input mode switch (paste text vs. enter a word count) --- */
        .rtc-modes {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            margin-bottom: var(--space-4);
        }

        .rtc-mode,
        .rtc-preset {
            flex: 1 1 140px;
            min-width: 0;
            min-height: 44px; /* tappable target on mobile */
            padding: var(--space-3) var(--space-4);
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            color: var(--color-text-secondary);
            font-family: var(--font-sans);
            font-size: var(--text-sm);
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: border-color var(--transition-fast), background var(--transition-fast), color var(--transition-fast);
        }

        .rtc-mode:hover,
        .rtc-preset:hover {
            border-color: var(--color-accent);
            color: var(--color-text-primary);
        }

        .rtc-mode.is-active,
        .rtc-preset.is-active {
            background: var(--color-accent-soft);
            border-color: var(--color-accent);
            color: var(--color-accent);
        }

        .rtc-mode {
            text-align: center;
        }

        .rtc-preset {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .rtc-preset span {
            font-size: var(--text-xs);
            font-weight: 500;
            color: var(--color-text-muted);
        }

        .rtc-preset.is-active span {
            color: var(--color-accent);
        }

        .rtc-presets {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            margin-bottom: var(--space-4);
        }

        /* --- Fields --- */
        .rtc-label {
            display: block;
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: var(--space-2);
        }

        .rtc-hint {
            font-size: var(--text-xs);
            color: var(--color-text-muted);
            line-height: 1.55;
            margin: 0 0 var(--space-3);
        }

        /* box-sizing + max-width keep the textarea inside the card on
           every viewport; the theme's .form-* rules supply the rest. */
        .rtc textarea,
        .rtc input[type="number"] {
            box-sizing: border-box;
            width: 100%;
            max-width: 100%;
        }

        .rtc textarea {
            min-height: 190px;
            resize: vertical;
            font-size: var(--text-base);
            line-height: 1.6;
        }

        .rtc input[type="number"] {
            min-height: 44px;
            font-size: var(--text-base);
            font-variant-numeric: tabular-nums;
        }

        .rtc-speed {
            margin-top: var(--space-6);
            padding-top: var(--space-5);
            border-top: 1px solid var(--color-border-light);
        }

        /* --- Live output --- */
        .rtc-out-label {
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--color-text-muted);
            margin: 0 0 var(--space-2);
        }

        .rtc-time {
            font-size: clamp(2rem, 7vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            font-variant-numeric: tabular-nums;
            color: var(--color-text-primary);
            margin: 0;
            overflow-wrap: anywhere;
        }

        .rtc-human {
            font-size: var(--text-lg);
            font-weight: 600;
            color: var(--color-accent);
            margin: var(--space-2) 0 var(--space-5);
        }

        .rtc-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: var(--space-3);
            margin: 0 0 var(--space-4);
        }

        .rtc-stat {
            background: var(--color-surface);
            border-radius: var(--radius-sm);
            padding: var(--space-3);
            min-width: 0;
        }

        .rtc-stat dt {
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--color-text-muted);
        }

        .rtc-stat dd {
            margin: 2px 0 0;
            font-size: var(--text-xl);
            font-weight: 700;
            color: var(--color-text-primary);
            font-variant-numeric: tabular-nums;
            overflow-wrap: anywhere;
        }

        .rtc-stat-note {
            display: block;
            font-size: var(--text-xs);
            font-weight: 500;
            color: var(--color-text-muted);
            margin-top: 2px;
        }

        .rtc-speed-note {
            font-size: var(--text-sm);
            color: var(--color-text-secondary);
            margin: 0 0 var(--space-4);
        }

        .rtc-caveat {
            margin: var(--space-6) 0 0;
            padding: var(--space-4) var(--space-5);
            border-left: 3px solid var(--color-warning);
            background: var(--color-warning-soft);
            border-radius: var(--radius-sm);
            color: var(--color-text-secondary);
            font-size: var(--text-sm);
            line-height: 1.65;
        }

        /* Wide tables scroll inside their own box, never the page. */
        .rtc-table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .rtc :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        @media (max-width: 860px) {
            .rtc-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .rtc-panel {
                padding: var(--space-4);
            }
            .rtc-mode,
            .rtc-preset {
                flex: 1 1 100%;
            }
        }
    </style>

    <div class="container">
        <div class="rtc" id="rtc">
            <div class="rtc-grid">

                <!-- INPUTS -->
                <div class="rtc-panel">
                    <div class="rtc-modes" role="group" aria-label="Input mode">
                        <button type="button" class="rtc-mode is-active" data-rtc-mode="text" aria-pressed="true">Paste text</button>
                        <button type="button" class="rtc-mode" data-rtc-mode="count" aria-pressed="false">Enter word count</button>
                    </div>

                    <div id="rtc-pane-text">
                        <label class="rtc-label" for="rtc-text">Paste or type your text</label>
                        <textarea id="rtc-text" class="form-textarea" rows="10" spellcheck="false" placeholder="Paste an article, a draft, an email, a script&hellip;"></textarea>
                        <p class="rtc-hint">Nothing you paste leaves your browser &mdash; the count runs locally as you type.</p>
                    </div>

                    <div id="rtc-pane-count" hidden>
                        <label class="rtc-label" for="rtc-words">Word count</label>
                        <input id="rtc-words" class="form-input" type="number" inputmode="numeric" min="0" max="10000000" step="1" value="1000">
                        <p class="rtc-hint">Use this when you already know the length &mdash; a 60,000-word manuscript, a 1,200-word draft your editor counted for you.</p>
                    </div>

                    <div class="rtc-speed">
                        <span class="rtc-label" id="rtc-speed-heading">Reading speed</span>
                        <p class="rtc-hint">Averages from a meta-analysis of reading-rate studies by Brysbaert (2019), published in the <em>Journal of Memory and Language</em>.</p>
                        <div class="rtc-presets" role="group" aria-labelledby="rtc-speed-heading">
                            <button type="button" class="rtc-preset is-active" data-wpm="238" data-label="silent reading" aria-pressed="true">Silent reading<span>238 wpm</span></button>
                            <button type="button" class="rtc-preset" data-wpm="183" data-label="reading aloud" aria-pressed="false">Reading aloud<span>183 wpm</span></button>
                        </div>

                        <p class="rtc-hint">Rough pace bands &mdash; rounded rules of thumb for a slower or faster reader, not figures from the meta-analysis:</p>
                        <div class="rtc-presets" role="group" aria-label="Rough pace bands">
                            <button type="button" class="rtc-preset" data-wpm="150" data-label="a slower pace" aria-pressed="false">Slow<span>150 wpm</span></button>
                            <button type="button" class="rtc-preset" data-wpm="240" data-label="an average pace" aria-pressed="false">Average<span>240 wpm</span></button>
                            <button type="button" class="rtc-preset" data-wpm="350" data-label="a fast pace" aria-pressed="false">Fast<span>350 wpm</span></button>
                        </div>

                        <label class="rtc-label" for="rtc-wpm">Or set your own speed (words per minute)</label>
                        <input id="rtc-wpm" class="form-input" type="number" inputmode="numeric" min="20" max="2000" step="1" value="238">
                    </div>
                </div>

                <!-- OUTPUT -->
                <div class="rtc-panel">
                    <div aria-live="polite">
                        <p class="rtc-out-label">Reading time</p>
                        <p class="rtc-time" id="rtc-time">0 min 0 sec</p>
                        <p class="rtc-human" id="rtc-human">Paste some text to start</p>

                        <dl class="rtc-stats">
                            <div class="rtc-stat">
                                <dt>Words</dt>
                                <dd id="rtc-stat-words">0</dd>
                            </div>
                            <div class="rtc-stat">
                                <dt>Characters</dt>
                                <dd id="rtc-stat-chars">0<span class="rtc-stat-note" id="rtc-stat-chars-note">0 without spaces</span></dd>
                            </div>
                            <div class="rtc-stat">
                                <dt>Pomodoros</dt>
                                <dd id="rtc-stat-pom">0<span class="rtc-stat-note">25-min blocks, rounded up</span></dd>
                            </div>
                        </dl>

                        <p class="rtc-speed-note" id="rtc-speed-note">At 238 words per minute (silent reading).</p>
                    </div>
                    <button type="button" class="btn btn--secondary" id="rtc-clear" style="width:100%;">Clear text</button>
                </div>
            </div>

            <p class="rtc-caveat"><strong>Read this before you trust the number.</strong> Reading speed varies enormously from person to person, and for the same person across different texts. A dense legal contract, a language you learned as an adult, unfamiliar technical vocabulary, or reading to memorise rather than to skim can all halve the rate. Light fiction or a familiar topic can push it well above 300 words per minute. The 238 and 183 figures are population averages drawn from studies of adults reading English &mdash; they are a planning estimate, never a target to hit or a score to beat.</p>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How the Reading Time Is Worked Out</h2>
            <p>The formula is deliberately simple: <strong>reading time = word count &divide; words per minute</strong>. Everything else is presentation. The calculator counts the words in whatever you paste, divides by the speed you picked, then reports the result three ways &mdash; exact minutes and seconds, a rounded &ldquo;about N min read&rdquo; phrase of the kind you see at the top of articles, and the number of 25-minute Pomodoro blocks the reading would fill.</p>

            <h3>What counts as a word</h3>
            <p>Word counting sounds trivial until you feed it real prose. This counter trims leading and trailing whitespace first, then splits on any run of whitespace &mdash; so multiple spaces, tabs, line breaks and blank lines between paragraphs all collapse into a single separator instead of inflating the count. Em dashes, en dashes and double hyphens are treated as separators too, so <em>time&mdash;and money</em> counts as three words rather than one. Finally, any token with no letter or digit in it is discarded, which is how a lone bullet, a stray quotation mark or an isolated dash avoids being counted as a word. Hyphenated compounds such as <em>well-known</em> stay as one word, and numerals such as <em>2026</em> count as one word, which matches how word processors behave.</p>

            <h3>Minutes, seconds, and the rounded phrase</h3>
            <p>The exact figure is the raw division rounded to the nearest second. The human phrase rounds to the nearest whole minute, with a one-minute floor, because &ldquo;about 0 min read&rdquo; helps nobody. Once the total passes an hour the phrase switches to hours and minutes. That is why 1,000 words at 238 words per minute shows as both <strong>4 min 12 sec</strong> and <strong>about 4 min read</strong>.</p>

            <h2 class="section-title">Where 238 and 183 Words Per Minute Come From</h2>
            <p>Most reading-time widgets on the web quietly use 200 or 250 words per minute with no source at all. This one uses the figures from Marc Brysbaert&rsquo;s meta-analysis of reading-rate studies, published in the <em>Journal of Memory and Language</em> in 2019, which pooled the results of a large body of published reading-rate research rather than relying on any single experiment.</p>
            <ul>
                <li><strong>238 words per minute &mdash; silent reading.</strong> The pooled average rate for adults reading English non-fiction silently. This is the default here and the right choice for articles, reports, emails and anything read from a screen or page.</li>
                <li><strong>183 words per minute &mdash; reading aloud.</strong> The pooled average rate for adults reading English aloud. Speech is meaningfully slower than silent reading, which is why a script timed at the silent rate always overruns when it is actually delivered.</li>
            </ul>
            <p>The gap between those two numbers is the single most useful thing on this page. A 1,500-word conference talk is a <strong>6 minute 18 second</strong> read on screen but an <strong>8 minute 12 second</strong> delivery out loud &mdash; a two-minute overrun that has ended a lot of talks mid-slide.</p>

            <h3>The slow, average and fast bands</h3>
            <p>The 150 / 240 / 350 buttons are rounded convenience settings, not values from the meta-analysis, and they are labelled that way in the tool. They exist because most people want to sanity-check a range rather than a single point estimate: how long would this take a slower reader, and how long for someone skimming quickly? If you know your own measured rate, type it into the manual field instead &mdash; that will always beat any band.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Reading Time for Common Lengths</h2>
            <p>All figures below are silent reading at 238 words per minute. The last column is the number of 25-minute Pomodoro blocks the reading fills, rounded up.</p>

            <div class="rtc-table-wrap">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Length</th>
                            <th>Typical example</th>
                            <th>Reading time at 238 wpm</th>
                            <th>Rounded</th>
                            <th>25-min blocks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>250 words</strong></td><td>News brief, LinkedIn post</td><td>1 min 3 sec</td><td>about 1 min read</td><td>1</td></tr>
                        <tr><td><strong>500 words</strong></td><td>Short blog post</td><td>2 min 6 sec</td><td>about 2 min read</td><td>1</td></tr>
                        <tr><td><strong>800 words</strong></td><td>Newspaper column</td><td>3 min 22 sec</td><td>about 3 min read</td><td>1</td></tr>
                        <tr><td><strong>1,000 words</strong></td><td>Standard article</td><td>4 min 12 sec</td><td>about 4 min read</td><td>1</td></tr>
                        <tr><td><strong>1,500 words</strong></td><td>In-depth article</td><td>6 min 18 sec</td><td>about 6 min read</td><td>1</td></tr>
                        <tr><td><strong>3,000 words</strong></td><td>Long-form feature</td><td>12 min 36 sec</td><td>about 13 min read</td><td>1</td></tr>
                        <tr><td><strong>5,000 words</strong></td><td>White paper, dissertation chapter</td><td>21 min 1 sec</td><td>about 21 min read</td><td>1</td></tr>
                        <tr><td><strong>10,000 words</strong></td><td>Research report, long essay</td><td>42 min 1 sec</td><td>about 42 min read</td><td>2</td></tr>
                        <tr><td><strong>40,000 words</strong></td><td>Short novel, novella</td><td>2 hr 48 min 4 sec</td><td>about 2 hr 48 min read</td><td>7</td></tr>
                        <tr><td><strong>60,000 words</strong></td><td>Typical nonfiction book</td><td>4 hr 12 min 6 sec</td><td>about 4 hr 12 min read</td><td>11</td></tr>
                        <tr><td><strong>90,000 words</strong></td><td>Full-length novel</td><td>6 hr 18 min 9 sec</td><td>about 6 hr 18 min read</td><td>16</td></tr>
                    </tbody>
                </table>
            </div>

            <h3>The same lengths read aloud</h3>
            <p>At 183 words per minute the same texts take roughly 30 percent longer. A 500-word script is <strong>2 min 44 sec</strong> spoken instead of 2 min 6 sec silent; 1,000 words is <strong>5 min 28 sec</strong> instead of 4 min 12 sec; a 3,000-word keynote is <strong>16 min 24 sec</strong> instead of 12 min 36 sec. If you are writing to a hard time limit, switch the tool to <em>Reading aloud</em> before you trust the number.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Turning Reading Time Into Focus Blocks</h2>
            <p>Knowing a report is a 42-minute read is only half useful. The other half is knowing it will not fit in one sitting. That is why this calculator also reports Pomodoro blocks: a 42-minute read needs two 25-minute focus sessions with a break in between, and a 60,000-word book is an eleven-session project &mdash; roughly a fortnight at one session a day.</p>
            <p>Long reading sessions degrade in the same way as any other sustained attention task: comprehension and recall fall off well before the words run out. Splitting a long read into timed blocks with deliberate breaks tends to preserve more of it than pushing straight through, particularly for dense or unfamiliar material where the effective reading rate is already below average.</p>

            <div class="pomodoro-presets" style="margin-top:var(--space-6);">
                <h3 class="section-subtitle">Timers to Run Your Reading Sessions</h3>
                <div class="timer-grid">
                    <a href="<?php echo esc_url(home_url('/study-timer')); ?>" class="btn btn--secondary">
                        <strong>Study Timer</strong>
                        <span>Time reading and revision sessions</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/focus-timer')); ?>" class="btn btn--secondary">
                        <strong>Focus Timer</strong>
                        <span>Uninterrupted deep-work blocks</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/pomodoro')); ?>" class="btn btn--secondary">
                        <strong>Pomodoro Timer</strong>
                        <span>25 minutes on, 5 minutes off</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/study-work-timers')); ?>" class="btn btn--secondary">
                        <strong>All Study &amp; Work Timers</strong>
                        <span>Browse every focus preset</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Reading Time Calculator FAQ</h2>
            <?php blogtimer_render_faq($rtc_faqs); ?>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>

    <script>
    /* ===========================================================
       Reading Time Calculator — vanilla JS, no dependencies.
       CSP-safe: inline script only, no eval / new Function, no
       external sources, no inline event-handler attributes.
       =========================================================== */
    (function () {
        'use strict';

        var root = document.getElementById('rtc');
        if (!root) return;

        var textarea   = document.getElementById('rtc-text');
        var wordsInput = document.getElementById('rtc-words');
        var wpmInput   = document.getElementById('rtc-wpm');
        var paneText   = document.getElementById('rtc-pane-text');
        var paneCount  = document.getElementById('rtc-pane-count');
        var clearBtn   = document.getElementById('rtc-clear');

        var outTime      = document.getElementById('rtc-time');
        var outHuman     = document.getElementById('rtc-human');
        var outWords     = document.getElementById('rtc-stat-words');
        var outChars     = document.getElementById('rtc-stat-chars');
        var outCharsNote = document.getElementById('rtc-stat-chars-note');
        var outPom       = document.getElementById('rtc-stat-pom');
        var outSpeedNote = document.getElementById('rtc-speed-note');

        var modeButtons   = root.querySelectorAll('[data-rtc-mode]');
        var presetButtons = root.querySelectorAll('.rtc-preset');

        var DEFAULT_WPM = 238;
        var POMODORO_MINUTES = 25;
        var mode = 'text';

        /* A token is a word if it contains at least one letter or digit.
           Unicode property escapes cover accented, Greek, Cyrillic, CJK and
           other scripts; built with RegExp() (never Function/eval) inside a
           try/catch so an engine without \p{...} support degrades instead of
           throwing a parse error and killing the whole script. */
        var WORD_RE;
        try {
            WORD_RE = new RegExp('[\\p{L}\\p{N}]', 'u');
        } catch (e) {
            WORD_RE = /[0-9A-Za-z\u00C0-\u024F]/;
        }

        function countWords(raw) {
            if (!raw) return 0;

            var s = String(raw);
            // Dashes used as separators become spaces so "time—and money"
            // is three words, not one. Covers figure/en/em/horizontal bars
            // and the ASCII "--" convention.
            s = s.replace(/[\u2012\u2013\u2014\u2015]/g, ' ');
            s = s.replace(/--+/g, ' ');
            // Non-breaking and other exotic spaces behave like spaces.
            s = s.replace(/[\u00A0\u1680\u2000-\u200A\u202F\u205F\u3000\uFEFF]/g, ' ');
            s = s.trim();
            if (!s) return 0;

            var tokens = s.split(/\s+/);
            var n = 0;
            for (var i = 0; i < tokens.length; i++) {
                if (WORD_RE.test(tokens[i])) n++;
            }
            return n;
        }

        function readWpm() {
            var v = parseFloat(wpmInput.value);
            if (!isFinite(v) || v <= 0) return DEFAULT_WPM;
            if (v > 20000) return 20000;
            return v;
        }

        function readWordCountField() {
            var v = parseInt(wordsInput.value, 10);
            if (!isFinite(v) || v < 0) return 0;
            if (v > 10000000) return 10000000;
            return v;
        }

        function fmt(n) {
            return Math.round(n).toLocaleString('en-US');
        }

        // Exact duration, e.g. "4 min 12 sec" / "4 hr 12 min 6 sec".
        function formatExact(totalSeconds) {
            var h = Math.floor(totalSeconds / 3600);
            var m = Math.floor((totalSeconds % 3600) / 60);
            var s = totalSeconds % 60;
            if (h > 0) return h + ' hr ' + m + ' min ' + s + ' sec';
            return m + ' min ' + s + ' sec';
        }

        // Human phrasing, rounded to the nearest minute with a 1-minute floor.
        function formatHuman(minutesFloat) {
            var mins = Math.max(1, Math.round(minutesFloat));
            if (mins < 60) return 'about ' + mins + ' min read';
            var h = Math.floor(mins / 60);
            var m = mins % 60;
            if (m === 0) return 'about ' + h + ' hr read';
            return 'about ' + h + ' hr ' + m + ' min read';
        }

        function activePresetLabel(wpm) {
            for (var i = 0; i < presetButtons.length; i++) {
                if (parseFloat(presetButtons[i].getAttribute('data-wpm')) === wpm) {
                    return presetButtons[i].getAttribute('data-label');
                }
            }
            return null;
        }

        function syncPresetState(wpm) {
            for (var i = 0; i < presetButtons.length; i++) {
                var on = parseFloat(presetButtons[i].getAttribute('data-wpm')) === wpm;
                presetButtons[i].classList.toggle('is-active', on);
                presetButtons[i].setAttribute('aria-pressed', on ? 'true' : 'false');
            }
        }

        function recalc() {
            var wpm = readWpm();
            var words, chars, charsNoSpaces;

            if (mode === 'text') {
                var text = textarea.value;
                words = countWords(text);
                chars = text.length;
                charsNoSpaces = text.replace(/\s+/g, '').length;
            } else {
                words = readWordCountField();
                chars = null;
                charsNoSpaces = null;
            }

            var minutesFloat = words > 0 ? words / wpm : 0;
            var totalSeconds = Math.round(minutesFloat * 60);

            outTime.textContent = formatExact(totalSeconds);
            outHuman.textContent = words > 0
                ? formatHuman(minutesFloat)
                : (mode === 'text' ? 'Paste some text to start' : 'Enter a word count to start');

            outWords.textContent = fmt(words);

            if (chars === null) {
                outChars.firstChild.nodeValue = '—';
                outCharsNote.textContent = 'not available in word-count mode';
            } else {
                outChars.firstChild.nodeValue = fmt(chars);
                outCharsNote.textContent = fmt(charsNoSpaces) + ' without spaces';
            }

            var pomodoros = words > 0 ? Math.max(1, Math.ceil(minutesFloat / POMODORO_MINUTES)) : 0;
            outPom.firstChild.nodeValue = fmt(pomodoros);

            var label = activePresetLabel(wpm);
            outSpeedNote.textContent = 'At ' + fmt(wpm) + ' words per minute' +
                (label ? ' (' + label + ').' : ' (your own setting).');

            syncPresetState(wpm);
        }

        function setMode(next) {
            mode = next;
            for (var i = 0; i < modeButtons.length; i++) {
                var on = modeButtons[i].getAttribute('data-rtc-mode') === next;
                modeButtons[i].classList.toggle('is-active', on);
                modeButtons[i].setAttribute('aria-pressed', on ? 'true' : 'false');
            }
            paneText.hidden = (next !== 'text');
            paneCount.hidden = (next !== 'count');
            clearBtn.textContent = (next === 'text') ? 'Clear text' : 'Reset count';
            recalc();
        }

        // --- Bindings (no inline handlers; CSP-safe) ---
        for (var i = 0; i < modeButtons.length; i++) {
            (function (btn) {
                btn.addEventListener('click', function () {
                    setMode(btn.getAttribute('data-rtc-mode'));
                });
            })(modeButtons[i]);
        }

        for (var j = 0; j < presetButtons.length; j++) {
            (function (btn) {
                btn.addEventListener('click', function () {
                    wpmInput.value = btn.getAttribute('data-wpm');
                    recalc();
                });
            })(presetButtons[j]);
        }

        textarea.addEventListener('input', recalc);
        wordsInput.addEventListener('input', recalc);
        wpmInput.addEventListener('input', recalc);
        wpmInput.addEventListener('change', recalc);

        clearBtn.addEventListener('click', function () {
            if (mode === 'text') {
                textarea.value = '';
                textarea.focus();
            } else {
                wordsInput.value = '0';
                wordsInput.focus();
            }
            recalc();
        });

        recalc();
    })();
    </script>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Reading Time Calculator",
  "description": "Free reading time calculator. Paste text or enter a word count and get the reading time in minutes and seconds at 238 words per minute for silent reading or 183 words per minute for reading aloud, plus word count, character count and 25-minute Pomodoro blocks.",
  "applicationCategory": "UtilitiesApplication",
  "operatingSystem": "Any modern web browser",
  "browserRequirements": "Requires JavaScript",
  "url": "<?php echo esc_url(home_url('/reading-time-calculator')); ?>",
  "isPartOf": {"@id": "<?php echo esc_url(home_url('/')); ?>#website"},
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  }
}
</script>
<?php
// FAQPage schema — built from the SAME $rtc_faqs array that blogtimer_render_faq()
// rendered above, so the structured data mirrors the visible text exactly.
$rtc_faq_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [],
];
foreach ($rtc_faqs as $rtc_faq) {
    $rtc_faq_schema['mainEntity'][] = [
        '@type' => 'Question',
        'name' => $rtc_faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $rtc_faq['a'],
        ],
    ];
}
echo '<script type="application/ld+json">' . wp_json_encode($rtc_faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
?>

<?php get_footer(); ?>
