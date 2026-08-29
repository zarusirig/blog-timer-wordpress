<?php
/**
 * Template Name: Sleep Calculator Page
 * Description: Bedtime / wake-up calculator built on 90-minute sleep cycles plus 15 minutes of sleep latency
 */
get_header();

// Single source of truth for the visible FAQ block AND the FAQPage JSON-LD below,
// so the schema mirrors the on-page text exactly (Google's requirement).
$sleep_calc_faqs = [
    [
        'q' => 'How does this sleep calculator work?',
        'a' => 'It counts in 90-minute sleep cycles and adds 15 minutes of sleep latency (the time it takes to actually fall asleep). In wake-up mode it subtracts 3, 4, 5 or 6 full cycles plus those 15 minutes from your alarm time to give four candidate bedtimes. In bedtime mode it adds the 15 minutes first, then stacks whole cycles on top to give four candidate wake-up times.',
    ],
    [
        'q' => 'What time should I go to bed if I need to wake up at 7:00 AM?',
        'a' => 'Counting back in 90-minute cycles and allowing 15 minutes to fall asleep: 9:45 PM (6 cycles, 9 hours of sleep), 11:15 PM (5 cycles, 7 hours 30 minutes), 12:45 AM (4 cycles, 6 hours) or 2:15 AM (3 cycles, 4 hours 30 minutes). The first two land inside the 7 to 9 hour range recommended for adults.',
    ],
    [
        'q' => 'How many hours of sleep do adults need?',
        'a' => 'The CDC, following the joint consensus recommendation of the American Academy of Sleep Medicine and the Sleep Research Society, advises that adults aged 18 to 60 sleep 7 or more hours per night on a regular basis; 7 to 9 hours is the range usually quoted for healthy adults. That maps to 5 or 6 sleep cycles, which is why those two options are marked as the recommended range on this page.',
    ],
    [
        'q' => 'Is a sleep cycle always 90 minutes?',
        'a' => 'No. Ninety minutes is a population average, not a fixed clock. Real cycles run roughly 70 to 120 minutes and vary from person to person and from one cycle to the next within a single night. Early-night cycles tend to be shorter and heavier in deep slow-wave sleep, while later cycles lengthen and carry more REM. Treat every time this calculator shows as a target with a margin of 20 to 30 minutes either side.',
    ],
    [
        'q' => 'Why does the calculator add 15 minutes before sleep starts?',
        'a' => 'Because going to bed is not the same as being asleep. Most healthy adults take somewhere between 10 and 20 minutes to fall asleep, so 15 minutes is used as the midpoint. If you know you routinely drop off in 5 minutes, or that it regularly takes you 40 minutes, shift the suggested times accordingly.',
    ],
    [
        'q' => 'Is it better to sleep 6 hours or 7 hours 30 minutes?',
        'a' => 'Seven and a half hours. Total sleep time matters more than landing neatly on a cycle boundary. Finishing 4 cycles at exactly the right moment does not make a 6-hour night equivalent to a 7.5-hour night, and chronically sleeping under 7 hours is what the adult recommendation is designed to prevent. Use the 4-cycle and 3-cycle options as damage control for a bad night, not as a plan.',
    ],
];
?>

<style>
.sc-tool {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    margin-top: var(--space-6);
}
.sc-modes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--space-3);
}
.sc-mode {
    font: inherit;
    font-weight: 600;
    text-align: left;
    white-space: normal;
    line-height: 1.35;
    min-height: 52px;
    padding: var(--space-3) var(--space-4);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-elevated);
    color: var(--color-text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast);
}
.sc-mode:hover { border-color: var(--color-accent); color: var(--color-text-primary); }
.sc-mode:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 2px; }
.sc-mode[aria-pressed="true"] {
    border-color: var(--color-accent);
    background: var(--color-accent-soft);
    color: var(--color-text-primary);
    box-shadow: inset 0 0 0 1px var(--color-accent);
}
.sc-mode small {
    display: block;
    margin-top: 2px;
    font-size: var(--text-xs);
    font-weight: 500;
    color: var(--color-text-muted);
}
.sc-controls {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: var(--space-4);
    margin-top: var(--space-5);
}
.sc-field {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    font-size: var(--text-sm);
    font-weight: 600;
    color: var(--color-text-secondary);
}
.sc-field input[type="time"] {
    font-family: var(--font-mono);
    font-size: var(--text-xl);
    min-height: 48px;
    width: 100%;
    max-width: 12rem;
    padding: var(--space-2) var(--space-4);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-elevated);
    color: var(--color-text-primary);
}
.sc-field input[type="time"]:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 1px; }
.sc-now { min-height: 48px; }
.sc-check {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    min-height: 48px;
    font-size: var(--text-sm);
    color: var(--color-text-secondary);
    cursor: pointer;
}
.sc-check input { width: 1.1rem; height: 1.1rem; accent-color: var(--color-accent); }
.sc-lead {
    margin: var(--space-5) 0 var(--space-3);
    font-weight: 600;
    color: var(--color-text-primary);
}
.sc-results {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--space-3);
}
.sc-result {
    display: flex;
    flex-direction: column;
    gap: var(--space-1);
    padding: var(--space-4);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-elevated);
}
.sc-result--best { border-color: var(--color-accent); background: var(--color-accent-subtle); }
.sc-result-time {
    font-size: var(--text-2xl);
    font-weight: 700;
    color: var(--color-text-primary);
    font-variant-numeric: tabular-nums;
}
.sc-result-meta { font-size: var(--text-sm); color: var(--color-text-secondary); }
.sc-badge {
    align-self: flex-start;
    margin-top: var(--space-2);
    padding: 2px var(--space-3);
    font-size: var(--text-xs);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--color-accent);
    background: var(--color-accent-soft);
    border-radius: var(--radius-full);
}
.sc-note {
    margin: var(--space-4) 0 0;
    font-size: var(--text-sm);
    line-height: 1.6;
    color: var(--color-text-muted);
}
.sc-links {
    list-style: none;
    margin: var(--space-4) 0 0;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: var(--space-3);
}
.sc-links a {
    display: block;
    padding: var(--space-4);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-card);
    text-decoration: none;
    transition: all var(--transition-fast);
}
.sc-links a:hover { border-color: var(--color-accent); box-shadow: var(--shadow-sm); }
.sc-links strong { display: block; color: var(--color-text-primary); }
.sc-links span { display: block; margin-top: 2px; font-size: var(--text-sm); color: var(--color-text-secondary); }
@media (max-width: 480px) {
    .sc-tool { padding: var(--space-4); }
    .sc-controls { gap: var(--space-3); }
    .sc-field input[type="time"] { max-width: 100%; }
}
</style>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Sleep Calculator &mdash; What Time Should You Go to Bed or Wake Up?</h1>
        <p class="page-intro">Enter the time you need to wake up (or the time you are heading to bed) and this calculator counts back or forward in 90-minute sleep cycles, plus 15 minutes to fall asleep, so your alarm lands between cycles instead of in the middle of one.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-29 &middot; ~9 min read &middot; Built on the CDC adult sleep recommendation and the joint American Academy of Sleep Medicine / Sleep Research Society consensus</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Count backward from your alarm in 90-minute cycles and add 15 minutes to fall asleep. To wake at <strong>7:00 AM</strong>, go to bed at <strong>9:45 PM</strong> (6 cycles, 9 hours), <strong>11:15 PM</strong> (5 cycles, 7 hours 30 minutes), <strong>12:45 AM</strong> (4 cycles, 6 hours) or <strong>2:15 AM</strong> (3 cycles, 4 hours 30 minutes). Aim for 5 or 6 cycles &mdash; that 7.5 to 9 hour window sits inside the 7 to 9 hours recommended for adults by the CDC and the American Academy of Sleep Medicine / Sleep Research Society consensus. Ninety minutes is an average, so treat every time below as a target with 20 to 30 minutes of slack either side.</p>
        </div>
    </div>

    <!-- SLEEP CALCULATOR TOOL -->
    <div class="container">
        <div class="sc-tool" id="sc-tool">
            <div class="sc-modes" role="group" aria-label="Choose what you want to calculate">
                <button type="button" class="sc-mode" id="sc-mode-wake" data-mode="wake" aria-pressed="true">
                    I want to wake up at&hellip;
                    <small>Shows the bedtimes to aim for</small>
                </button>
                <button type="button" class="sc-mode" id="sc-mode-bed" data-mode="bed" aria-pressed="false">
                    I am going to bed at&hellip;
                    <small>Shows the times you should wake up</small>
                </button>
            </div>

            <div class="sc-controls">
                <label class="sc-field" for="sc-time">
                    <span id="sc-time-label">Wake-up time</span>
                    <input type="time" id="sc-time" value="07:00" step="60" autocomplete="off">
                </label>
                <button type="button" class="btn btn--secondary sc-now" id="sc-now" hidden>Use current time</button>
                <label class="sc-check" for="sc-24h">
                    <input type="checkbox" id="sc-24h"> 24-hour clock
                </label>
            </div>

            <p class="sc-lead" id="sc-lead" role="status">To wake up at 7:00 AM, go to bed at one of these times:</p>
            <ul class="sc-results" id="sc-results" aria-live="polite"></ul>

            <p class="sc-note">Every time above already includes <strong>15 minutes to fall asleep</strong> on top of whole 90-minute cycles. Five or six cycles (7 hours 30 minutes to 9 hours of sleep) is the recommended range for adults. Four cycles is a short night, and three cycles is emergency-only.</p>
            <noscript>
                <p class="sc-note">JavaScript is disabled, so the interactive calculator cannot run. The table in &ldquo;Sleep cycle options at a glance&rdquo; below gives the same numbers: subtract 15 minutes plus 4 hours 30 minutes, 6 hours, 7 hours 30 minutes or 9 hours from your wake-up time.</p>
            </noscript>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How the Sleep Cycle Maths Works</h2>
            <p>Sleep is not a flat block of unconsciousness. It moves through repeating cycles of light sleep (stages N1 and N2), deep slow-wave sleep (N3) and REM sleep. One full pass through those stages averages about 90 minutes, which is why sleep calculators &mdash; this one included &mdash; work in 90-minute blocks.</p>
            <p>The reason the boundary matters is <strong>sleep inertia</strong>: the groggy, thick-headed feeling you get when an alarm pulls you out of deep slow-wave sleep. Waking at the end of a cycle, when you are already in light sleep, generally feels cleaner than waking 25 minutes into a deep-sleep stage. That is the entire premise of a bedtime calculator.</p>
            <p>The second ingredient is <strong>sleep latency</strong> &mdash; the gap between lights out and actually being asleep. Most healthy adults need roughly 10 to 20 minutes, so this calculator adds a flat 15 minutes. Going to bed at 11:15 PM does not mean sleep starts at 11:15 PM, and a calculator that ignores that gap sends you to bed 15 minutes late every night.</p>

            <h2 class="section-title">Where the 90-Minute Rule Breaks Down</h2>
            <p>Ninety minutes is a population average, not a personal constant. In real recordings, cycles run roughly <strong>70 to 120 minutes</strong>. They vary between people, and they vary within one night for the same person: the first cycles of the night are typically shorter and dominated by deep slow-wave sleep, while later cycles stretch out and carry proportionally more REM. Alcohol, caffeine, stress, illness, shift work and sleep debt all shift the pattern further.</p>
            <p>So use these times the way you would use a route estimate, not a train timetable. If a suggested bedtime is 11:15 PM, anywhere in the 10:45 PM to 11:45 PM window is doing the same job. And if you have to choose between hitting a cycle boundary and getting more total sleep, choose the sleep &mdash; a 6-hour night does not become a 7.5-hour night just because it ends neatly.</p>

            <h2 class="section-title">How Much Sleep Adults Actually Need</h2>
            <p>The CDC, following the joint consensus recommendation issued by the <strong>American Academy of Sleep Medicine and the Sleep Research Society</strong>, advises that adults aged 18 to 60 should sleep <strong>7 or more hours per night</strong> on a regular basis; 7 to 9 hours is the range most commonly quoted for healthy adults. Teenagers and children need more. That is the reason this calculator flags 5 and 6 cycles as the recommended range and treats 3 and 4 cycles as fallbacks rather than plans.</p>
            <p>The number is about the habitual average, not one perfect night. Missing your target occasionally is normal; running a 6-hour night as your standing schedule is the pattern the recommendation exists to discourage.</p>

            <h2 class="section-title">Sleep Cycle Options at a Glance</h2>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Cycles</th>
                        <th>Sleep time</th>
                        <th>Time in bed (with 15 min latency)</th>
                        <th>Verdict</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>6 cycles</strong></td><td>9 hours</td><td>9 hours 15 minutes</td><td>Recommended &mdash; top of the adult range, good for recovery and sleep debt</td></tr>
                    <tr><td><strong>5 cycles</strong></td><td>7 hours 30 minutes</td><td>7 hours 45 minutes</td><td>Recommended &mdash; the realistic everyday target for most adults</td></tr>
                    <tr><td><strong>4 cycles</strong></td><td>6 hours</td><td>6 hours 15 minutes</td><td>Short &mdash; below the 7-hour floor; fine occasionally, not as a routine</td></tr>
                    <tr><td><strong>3 cycles</strong></td><td>4 hours 30 minutes</td><td>4 hours 45 minutes</td><td>Emergency only &mdash; expect measurable next-day impairment</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Hitting the Bedtime the Calculator Gives You</h2>
            <ul>
                <li><strong>Work backward from lights out, not from bedtime.</strong> If the calculator says 11:15 PM, start winding down at 10:45 PM. Screens, admin and difficult conversations all extend latency.</li>
                <li><strong>Keep the wake time fixed before you fix the bedtime.</strong> A stable wake time anchors your circadian rhythm; a stable bedtime alone does not.</li>
                <li><strong>Do not chase a missed boundary.</strong> If you get to bed 40 minutes late, do not stay up another 50 minutes to hit the next cycle. Sleep the shortfall instead.</li>
                <li><strong>Use a wind-down timer.</strong> Our <a href="<?php echo esc_url(home_url('/sleep-timer')); ?>">sleep timer</a> fades ambient noise out after you have fallen asleep, so audio does not run all night.</li>
                <li><strong>Treat naps separately.</strong> A daytime nap follows different rules &mdash; see the <a href="<?php echo esc_url(home_url('/nap-timer')); ?>">nap timer</a> for 10 to 20 minute power naps and the single 90-minute full-cycle nap.</li>
            </ul>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Related Sleep and Focus Tools</h2>
            <ul class="sc-links">
                <li>
                    <a href="<?php echo esc_url(home_url('/sleep-timer')); ?>">
                        <strong>Sleep Timer</strong>
                        <span>Ambient noise that fades to silence so it does not wake you</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/nap-timer')); ?>">
                        <strong>Nap Timer</strong>
                        <span>10, 20 and 90-minute naps that avoid sleep inertia</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/sleep-meditation-timers')); ?>">
                        <strong>Sleep &amp; Meditation Timers</strong>
                        <span>The full hub of wind-down, breathing and meditation timers</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/pomodoro')); ?>">
                        <strong>Pomodoro Timer</strong>
                        <span>Protect the daytime focus blocks a good night makes possible</span>
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sleep Calculator FAQ</h2>
            <?php blogtimer_render_faq($sleep_calc_faqs); ?>
        </div>
    </section>

    <script>
    (function () {
        'use strict';

        var CYCLE_MINUTES = 90;
        var LATENCY_MINUTES = 15;
        var CYCLE_OPTIONS = [6, 5, 4, 3];
        var RECOMMENDED = [6, 5];

        var root = document.getElementById('sc-tool');
        if (!root) { return; }

        var timeInput = document.getElementById('sc-time');
        var timeLabel = document.getElementById('sc-time-label');
        var nowBtn = document.getElementById('sc-now');
        var clock24 = document.getElementById('sc-24h');
        var lead = document.getElementById('sc-lead');
        var results = document.getElementById('sc-results');
        var modeButtons = root.querySelectorAll('.sc-mode');

        var mode = 'wake';
        var stored = { wake: '07:00', bed: '' };

        function pad(n) { return n < 10 ? '0' + n : String(n); }

        function currentValue() {
            var d = new Date();
            return pad(d.getHours()) + ':' + pad(d.getMinutes());
        }

        function parseMinutes(value) {
            if (!value) { return null; }
            var parts = String(value).split(':');
            if (parts.length < 2) { return null; }
            var h = parseInt(parts[0], 10);
            var m = parseInt(parts[1], 10);
            if (isNaN(h) || isNaN(m) || h < 0 || h > 23 || m < 0 || m > 59) { return null; }
            return (h * 60) + m;
        }

        function wrapDay(total) { return ((total % 1440) + 1440) % 1440; }

        function formatClock(total) {
            var mins = wrapDay(total);
            var h = Math.floor(mins / 60);
            var m = mins % 60;
            if (clock24.checked) { return pad(h) + ':' + pad(m); }
            var suffix = h < 12 ? 'AM' : 'PM';
            var h12 = h % 12;
            if (h12 === 0) { h12 = 12; }
            return h12 + ':' + pad(m) + ' ' + suffix;
        }

        function formatSleep(cycles) {
            var total = cycles * CYCLE_MINUTES;
            var h = Math.floor(total / 60);
            var m = total % 60;
            return m === 0 ? h + ' hours' : h + ' hours ' + m + ' minutes';
        }

        function buildRow(cycles, minutes) {
            var best = RECOMMENDED.indexOf(cycles) !== -1;
            var li = document.createElement('li');
            li.className = best ? 'sc-result sc-result--best' : 'sc-result';

            var time = document.createElement('span');
            time.className = 'sc-result-time';
            time.textContent = formatClock(minutes);
            li.appendChild(time);

            var meta = document.createElement('span');
            meta.className = 'sc-result-meta';
            meta.textContent = cycles + ' cycles \u00B7 ' + formatSleep(cycles) + ' of sleep';
            li.appendChild(meta);

            if (best) {
                var badge = document.createElement('span');
                badge.className = 'sc-badge';
                badge.textContent = 'Recommended';
                li.appendChild(badge);
            }
            return li;
        }

        function render() {
            var base = parseMinutes(timeInput.value);

            while (results.firstChild) { results.removeChild(results.firstChild); }

            if (base === null) {
                lead.textContent = mode === 'wake'
                    ? 'Enter the time you need to wake up to see your bedtimes.'
                    : 'Enter the time you are going to bed to see your wake-up times.';
                return;
            }

            // Chronological order in both modes: bedtimes ascend as cycles fall,
            // wake-up times ascend as cycles rise.
            var order = mode === 'wake' ? CYCLE_OPTIONS.slice() : CYCLE_OPTIONS.slice().reverse();
            var fragment = document.createDocumentFragment();

            for (var i = 0; i < order.length; i++) {
                var cycles = order[i];
                var minutes = mode === 'wake'
                    ? base - (cycles * CYCLE_MINUTES) - LATENCY_MINUTES
                    : base + LATENCY_MINUTES + (cycles * CYCLE_MINUTES);
                fragment.appendChild(buildRow(cycles, minutes));
            }

            results.appendChild(fragment);

            lead.textContent = mode === 'wake'
                ? 'To wake up at ' + formatClock(base) + ', go to bed at one of these times:'
                : 'Going to bed at ' + formatClock(base) + ', wake up at one of these times:';
        }

        function setMode(next) {
            if (next !== 'wake' && next !== 'bed') { return; }
            if (next === mode) { return; }

            stored[mode] = timeInput.value;
            mode = next;

            var value = stored[mode];
            if (!value) { value = mode === 'bed' ? currentValue() : '07:00'; }
            timeInput.value = value;

            for (var i = 0; i < modeButtons.length; i++) {
                modeButtons[i].setAttribute('aria-pressed', modeButtons[i].getAttribute('data-mode') === mode ? 'true' : 'false');
            }

            timeLabel.textContent = mode === 'wake' ? 'Wake-up time' : 'Bedtime';
            nowBtn.hidden = mode !== 'bed';

            render();
        }

        for (var i = 0; i < modeButtons.length; i++) {
            modeButtons[i].addEventListener('click', function (e) {
                setMode(e.currentTarget.getAttribute('data-mode'));
            });
        }

        timeInput.addEventListener('input', render);
        timeInput.addEventListener('change', render);
        clock24.addEventListener('change', render);
        nowBtn.addEventListener('click', function () {
            timeInput.value = currentValue();
            render();
        });

        render();
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "@id": "<?php echo esc_url(home_url('/sleep-calculator')); ?>#webapp",
  "name": "Sleep Calculator",
  "description": "Free browser sleep calculator. Enter a wake-up time to get the bedtimes to aim for, or a bedtime to get the times you should wake up, based on 90-minute sleep cycles plus 15 minutes of sleep latency.",
  "applicationCategory": "HealthApplication",
  "operatingSystem": "Any modern web browser",
  "browserRequirements": "Requires JavaScript",
  "url": "<?php echo esc_url(home_url('/sleep-calculator')); ?>",
  "isAccessibleForFree": true,
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  },
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>
<script type="application/ld+json">
<?php
$sleep_calc_faq_entities = [];
foreach ($sleep_calc_faqs as $sleep_calc_faq) {
    $sleep_calc_faq_entities[] = [
        '@type' => 'Question',
        'name' => $sleep_calc_faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $sleep_calc_faq['a'],
        ],
    ];
}
echo wp_json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => home_url('/sleep-calculator') . '#faq',
    'mainEntity' => $sleep_calc_faq_entities,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
</script>

<?php get_footer(); ?>
