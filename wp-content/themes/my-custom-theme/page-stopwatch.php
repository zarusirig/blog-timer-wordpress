<?php
/**
 * Template Name: Stopwatch Page
 * Description: Free online stopwatch with lap, split, and millisecond timing
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Stopwatch &mdash; Lap, Split, and Millisecond Timing</h1>
        <p class="page-intro">A precision browser stopwatch with millisecond accuracy via <code>performance.now()</code>, lap and split tracking, copy-to-clipboard export, and zero install. Works offline once loaded.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~13 min read &middot; References: W3C High Resolution Time, MDN Web Docs, FINA Swimming Rules</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">A stopwatch counts up from zero to measure elapsed time, unlike a countdown timer that counts down to zero. This browser stopwatch uses <a href="https://developer.mozilla.org/en-US/docs/Web/API/Performance/now" rel="nofollow noopener" target="_blank">performance.now()</a> for sub-millisecond resolution and remains accurate even when the tab is throttled. Use it for sports timing, science experiments, debate rounds, and any task where you need precise elapsed time with lap and split functionality.</p>
        </div>
    </div>

    <!-- STOPWATCH WIDGET -->
    <div class="container">
        <div class="timer-widget" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid rgba(99,102,241,0.15);margin-top:var(--space-6);">
            <div id="sw-display" style="font-size:clamp(3rem,9vw,6.5rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);letter-spacing:0.02em;">00:00:00.000</div>
            <div id="sw-controls" style="display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);margin-top:var(--space-5);">
                <button class="btn btn--primary btn--large" id="sw-startstop" onclick="stopwatch.toggle()">Start</button>
                <button class="btn btn--secondary btn--large" id="sw-lap" onclick="stopwatch.lap()" disabled>Lap</button>
                <button class="btn btn--secondary btn--large" id="sw-reset" onclick="stopwatch.reset()">Reset</button>
                <button class="btn btn--secondary btn--large" id="sw-copy" onclick="stopwatch.copyLaps()" disabled>Copy Laps</button>
            </div>
        </div>

        <div id="sw-laps-wrap" style="margin-top:var(--space-6);display:none;">
            <h3 class="section-subtitle">Lap &amp; Split Times</h3>
            <table class="comparison-table" id="sw-laps-table">
                <thead>
                    <tr><th>Lap #</th><th>Lap time</th><th>Split (total)</th><th>vs. best</th></tr>
                </thead>
                <tbody id="sw-laps-body"></tbody>
            </table>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How a Stopwatch Differs from a Countdown Timer</h2>
            <p>A stopwatch and a countdown timer are mirror images. A stopwatch starts at zero and counts up indefinitely until you stop it &mdash; it answers the question "how long did that take?" A countdown timer starts at a fixed duration and counts down to zero &mdash; it answers "how much time is left?" Both share the same underlying clock, but the user interface and the cognitive frame are different.</p>
            <p>Use a stopwatch when the endpoint is unknown: timing a sprint, a science experiment, a presentation rehearsal, or a debugging session. Use a <a href="/countdown-timer/">countdown timer</a> when the endpoint is fixed: a 25-minute <a href="/pomodoro/">Pomodoro</a>, a five-minute speech limit, an oven bake time. The Blog Timer's stopwatch and <a href="/interval-timer/">interval timer</a> share the same timing engine, so accuracy is identical across tools.</p>

            <h2 class="section-title">A Short History of the Stopwatch</h2>
            <p>The mechanical stopwatch is an offshoot of the chronograph, a complication added to pocket watches in the early 19th century. Louis Moinet, a French watchmaker, built what is now recognized as the first chronograph in 1816 with a 60-Hz beat rate &mdash; capable of resolving 1/60th of a second. Nicolas Mathieu Rieussec patented an inked-recording chronograph in 1821, used at the Champ de Mars horse races to record finishing times.</p>
            <p>The marine chronometer pioneer <a href="https://en.wikipedia.org/wiki/John_Harrison" rel="nofollow noopener" target="_blank">John Harrison</a> had already established that mechanical timepieces could be made portable and precise enough for navigation; the stopwatch is essentially that engineering discipline applied to elapsed-time measurement. By the 1860s, split-second chronographs with two seconds hands &mdash; one stoppable independently &mdash; let timekeepers record intermediate times without losing the running total. That dual-hand design is the direct ancestor of the modern "lap and split" button on every digital stopwatch and every browser stopwatch widget.</p>
            <p>The transition from mechanical to quartz stopwatches in the 1970s pushed resolution from 1/10th of a second to 1/100th, and the move to digital integrated circuits in the 1980s brought 1/1000th of a second to consumer devices. Sport-grade Omega and Seiko electronic timers used at the 1968 Mexico City Olympics resolved to 1/1000th and became the FINA and World Athletics reference. Today, a typical web stopwatch using <code>performance.now()</code> resolves to roughly 0.005 ms on a modern desktop browser, though browsers deliberately quantize the value to 100 microseconds or 1 ms to mitigate timing side-channel attacks like Spectre.</p>

            <h2 class="section-title">Lap Times vs. Split Times Explained</h2>
            <p>The two terms are routinely confused, even by experienced athletes. They measure different things.</p>
            <ul>
                <li><strong>Lap time</strong> is the time for a single segment &mdash; the duration of one lap of the track, one length of the pool, one inning. If lap 1 takes 1:20 and lap 2 takes 1:18, those are the lap times.</li>
                <li><strong>Split time</strong> is the cumulative time at the end of a segment &mdash; the total elapsed time from the start. After lap 2 in the example above, the split is 2:38.</li>
            </ul>
            <p>Track and pool timing displays usually show both: the split running on the main display, the lap time recorded for each segment in a memory list. Our stopwatch above records both columns for every lap you press, plus a third column showing how the lap compares to your fastest lap so far &mdash; useful for pacing analysis.</p>

            <h2 class="section-title">Top Use Cases for a Browser Stopwatch</h2>
            <h3>Sports and athletics timing</h3>
            <p>For interval running on a track, lap-based swimming sets, cycling efforts, or rowing pieces, a stopwatch with lap memory is essential. Coaches use the lap delta (how each lap differs from the fastest) to identify pacing problems. FINA, the world swim federation, requires automatic timing to 0.01 second resolution in finals (FINA Swimming Rule SW 13). A browser stopwatch is not FINA-certified but is more than accurate enough for training, club meets, and personal records.</p>

            <h3>Lab and science class experiments</h3>
            <p>Pendulum period measurements, free-fall timing, chemical reaction durations, biology behavioural studies. A stopwatch with sub-millisecond resolution and exportable lap data is more useful than the analog wall clock in most school labs. The W3C High Resolution Time specification (<a href="https://www.w3.org/TR/hr-time-3/" rel="nofollow noopener" target="_blank">HR-Time Level 3</a>) defines the monotonic clock used here, which never goes backwards even if the system clock is adjusted &mdash; a property analog stopwatches cannot offer.</p>

            <h3>Presentation and debate timing</h3>
            <p>Track total speaking time while logging each speaker as a lap. Debate formats like British Parliamentary, Lincoln-Douglas, and policy debate all have strict per-speaker limits. Press "Lap" when a speaker finishes; the split tells you total round time, the lap tells you that speaker's duration. For team-based formats, see also our <a href="/chess-clock/">chess clock</a> for per-player budgets.</p>

            <h3>Cooking, brewing, and fermentation</h3>
            <p>Steeping tea, brewing coffee, timing a sourdough fold cycle, measuring pasta cook time. For fixed durations a countdown timer is cleaner, but a stopwatch is unbeatable when you don't know how long something will take and need to record the total &mdash; for example "how long did the dough rise to double its volume?"</p>

            <h3>Debugging and performance work</h3>
            <p>Engineers timing manual workflows, QA staff timing user journeys, or anyone benchmarking a hand-operated process. For code-level benchmarking use <code>performance.now()</code> directly in the console; for human-process timing, a visible stopwatch is more honest about start-stop reaction time.</p>

            <h2 class="section-title">How Accurate Is This Stopwatch?</h2>
            <p>The stopwatch uses <code>performance.now()</code> from the W3C High Resolution Time API (<a href="https://www.w3.org/TR/hr-time-3/" rel="nofollow noopener" target="_blank">HR-Time Level 3</a>, <a href="https://developer.mozilla.org/en-US/docs/Web/API/Performance/now" rel="nofollow noopener" target="_blank">MDN reference</a>). This is a monotonic clock that returns elapsed time from a fixed origin with at least 1 ms resolution in all modern browsers, often higher.</p>
            <ul>
                <li>The displayed time is computed from the difference between the current <code>performance.now()</code> reading and the start timestamp, not by incrementing a counter on each frame. This means the displayed time stays correct even if the browser drops frames or you minimize the window.</li>
                <li>Reaction-time delay between the physical event and your button press dominates the total error. Human reaction time averages 200 to 250 ms for visual stimuli (Welford, 1980), so a hand-operated stopwatch &mdash; mechanical or digital &mdash; is realistically accurate to about &plusmn;0.25 second per start/stop pair, regardless of internal resolution.</li>
                <li>Browser timer throttling in background tabs does not affect this stopwatch because the elapsed time is recomputed from the wall-clock difference, not accumulated from setInterval ticks. See Chrome's <a href="https://developer.chrome.com/blog/timer-throttling-in-chrome-88/" rel="nofollow noopener" target="_blank">timer throttling documentation</a>.</li>
            </ul>

            <h2 class="section-title">Browser Stopwatch vs. Phone Stopwatch vs. Hardware Timer</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Property</th><th>Browser stopwatch</th><th>Phone stopwatch (iOS / Android)</th><th>Hardware sport timer</th></tr>
                </thead>
                <tbody>
                    <tr><td>Resolution</td><td>~1 ms (quantized)</td><td>~10 ms</td><td>1 ms (FINA-grade: 1 ms)</td></tr>
                    <tr><td>Lap memory</td><td>Unlimited (RAM)</td><td>~100 laps typical</td><td>10&ndash;300 laps</td></tr>
                    <tr><td>Export</td><td>Copy to clipboard, share URL</td><td>Manual screenshot</td><td>Print or memory dump</td></tr>
                    <tr><td>Offline</td><td>Yes (once loaded)</td><td>Yes</td><td>Yes</td></tr>
                    <tr><td>Cost</td><td>Free</td><td>Free (bundled)</td><td>$15&ndash;$400</td></tr>
                    <tr><td>Lock-screen access</td><td>No (tab must be open)</td><td>Yes (control center)</td><td>N/A (single-purpose)</td></tr>
                    <tr><td>Reaction-time floor</td><td>~250 ms (human)</td><td>~250 ms (human)</td><td>~250 ms (human, manual)</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Stopwatch Modes Compared</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Mode</th><th>What it does</th><th>Use case</th></tr>
                </thead>
                <tbody>
                    <tr><td>Standard stopwatch</td><td>Counts up from zero, single elapsed reading</td><td>Single event timing</td></tr>
                    <tr><td>Lap mode</td><td>Records discrete segment times alongside running total</td><td>Track laps, swim lengths</td></tr>
                    <tr><td>Split mode</td><td>Records cumulative times at intermediate points</td><td>Marathon split tracking, ultra running</td></tr>
                    <tr><td>Countdown</td><td>Counts down from fixed duration to zero</td><td><a href="/countdown-timer/">Use the countdown timer</a></td></tr>
                    <tr><td>Interval</td><td>Alternates work and rest periods automatically</td><td><a href="/interval-timer/">Use the interval timer</a></td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Keyboard Shortcuts</h2>
            <p>This stopwatch is fully keyboard-driven: press <kbd>Space</kbd> to start or stop, <kbd>L</kbd> to record a lap, <kbd>R</kbd> to reset, and <kbd>C</kbd> to copy the lap list to your clipboard. Shortcuts work when the page is focused but no input field is active.</p>

            <h2 class="section-title">How to Use the Stopwatch on This Page</h2>
            <ol>
                <li>Press <strong>Start</strong> or hit <kbd>Space</kbd>. The display starts counting up at millisecond resolution.</li>
                <li>Press <strong>Lap</strong> or <kbd>L</kbd> at each segment endpoint. Each lap appears in the table below with its lap time, split time, and delta versus your fastest lap.</li>
                <li>Press <strong>Stop</strong> (the same Start button) to freeze the clock. Press it again to resume from where it stopped.</li>
                <li>Press <strong>Copy Laps</strong> to put a tab-separated list of all laps on your clipboard for pasting into a spreadsheet.</li>
                <li>Press <strong>Reset</strong> when finished to clear the display and lap history.</li>
            </ol>

            <h2 class="section-title">Stopwatch FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'How accurate is this online stopwatch?', 'a' => 'The internal timing is accurate to about 1 millisecond, the resolution exposed by the W3C High Resolution Time API in browsers. Human reaction time on button presses adds about 200 to 250 milliseconds of error per start or stop, which dominates the total inaccuracy for any hand-operated timing.'],
                ['q' => 'Does the stopwatch keep running if I switch tabs?', 'a' => 'Yes. The elapsed time is computed from timestamps, not from frame counters, so background tab throttling does not cause drift. When you return to the tab the display catches up immediately.'],
                ['q' => 'What is the difference between a lap and a split?', 'a' => 'A lap is the duration of one segment alone. A split is the cumulative elapsed time at the end of that segment. If lap 1 is 1:20 and lap 2 is 1:18, the split after lap 2 is 2:38.'],
                ['q' => 'Can I save my lap times?', 'a' => 'Yes. Click "Copy Laps" to put a tab-separated table on your clipboard. Paste into a spreadsheet for further analysis. We do not store lap data on any server.'],
                ['q' => 'Does this stopwatch work offline?', 'a' => 'Yes. Once the page has loaded, the stopwatch JavaScript runs entirely client-side. You can disconnect from the internet and it will continue to work until you close the tab.'],
                ['q' => 'Why does the stopwatch show milliseconds but most sports only use hundredths?', 'a' => 'Most sports officially time to 0.01 second (hundredths) because human reaction time makes finer resolution meaningless for manual operation. We show milliseconds because they are the native resolution of the browser API and useful for some lab and engineering contexts.'],
                ['q' => 'Can I use this stopwatch for official race timing?', 'a' => 'No. Official races require certified electronic timing equipment with photoelectric start and finish detection. This stopwatch is appropriate for training, training-camp time trials, school sports, and any context where manual operation is acceptable.'],
                ['q' => 'How do I time something that runs for hours?', 'a' => 'The display rolls into hours after 59:59.999 minutes and supports up to 99 hours, 59 minutes, 59 seconds. Browser performance.now() itself has no practical upper limit for any human-relevant duration.'],
            ]);
            ?>
        </div>
    </section>

    <script>
    const stopwatch = (function() {
        let startTime = 0;       // performance.now() at most recent start
        let elapsedBefore = 0;   // accumulated ms from previous run segments
        let running = false;
        let rafId = null;
        let laps = [];           // {n, lapMs, splitMs}
        let lastLapSplit = 0;

        const display = document.getElementById('sw-display');
        const startBtn = document.getElementById('sw-startstop');
        const lapBtn = document.getElementById('sw-lap');
        const resetBtn = document.getElementById('sw-reset');
        const copyBtn = document.getElementById('sw-copy');
        const lapsWrap = document.getElementById('sw-laps-wrap');
        const lapsBody = document.getElementById('sw-laps-body');

        function format(ms) {
            ms = Math.max(0, ms);
            const totalSec = Math.floor(ms / 1000);
            const milli = Math.floor(ms % 1000);
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            const pad = (n, w) => String(n).padStart(w, '0');
            return pad(h, 2) + ':' + pad(m, 2) + ':' + pad(s, 2) + '.' + pad(milli, 3);
        }

        function currentElapsed() {
            return running ? (elapsedBefore + (performance.now() - startTime)) : elapsedBefore;
        }

        function tick() {
            display.textContent = format(currentElapsed());
            if (running) rafId = requestAnimationFrame(tick);
        }

        function toggle() {
            if (running) {
                elapsedBefore += performance.now() - startTime;
                running = false;
                cancelAnimationFrame(rafId);
                startBtn.textContent = 'Resume';
                lapBtn.disabled = true;
            } else {
                startTime = performance.now();
                running = true;
                startBtn.textContent = 'Stop';
                lapBtn.disabled = false;
                tick();
            }
        }

        function lap() {
            if (!running) return;
            const total = currentElapsed();
            const lapMs = total - lastLapSplit;
            laps.push({ n: laps.length + 1, lapMs: lapMs, splitMs: total });
            lastLapSplit = total;
            renderLaps();
            copyBtn.disabled = false;
        }

        function renderLaps() {
            lapsWrap.style.display = 'block';
            const bestLap = laps.reduce((b, l) => Math.min(b, l.lapMs), Infinity);
            lapsBody.innerHTML = laps.map(function(l) {
                const delta = l.lapMs - bestLap;
                const deltaStr = delta === 0 ? '<strong style="color:var(--color-success,#10b981);">best</strong>' : '+' + format(delta).replace(/^00:0?/, '');
                return '<tr><td>' + l.n + '</td><td>' + format(l.lapMs) + '</td><td>' + format(l.splitMs) + '</td><td>' + deltaStr + '</td></tr>';
            }).join('');
        }

        function reset() {
            cancelAnimationFrame(rafId);
            running = false;
            startTime = 0;
            elapsedBefore = 0;
            lastLapSplit = 0;
            laps = [];
            display.textContent = '00:00:00.000';
            startBtn.textContent = 'Start';
            lapBtn.disabled = true;
            copyBtn.disabled = true;
            lapsBody.innerHTML = '';
            lapsWrap.style.display = 'none';
        }

        function copyLaps() {
            if (!laps.length) return;
            const header = 'Lap\tLap time\tSplit time\n';
            const rows = laps.map(l => l.n + '\t' + format(l.lapMs) + '\t' + format(l.splitMs)).join('\n');
            const text = header + rows;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    const original = copyBtn.textContent;
                    copyBtn.textContent = 'Copied!';
                    setTimeout(() => copyBtn.textContent = original, 1200);
                });
            } else {
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            const tag = (e.target && e.target.tagName) || '';
            if (tag === 'INPUT' || tag === 'TEXTAREA') return;
            if (e.code === 'Space') { e.preventDefault(); toggle(); }
            else if (e.key === 'l' || e.key === 'L') { lap(); }
            else if (e.key === 'r' || e.key === 'R') { reset(); }
            else if (e.key === 'c' || e.key === 'C') { copyLaps(); }
        });

        return { toggle, lap, reset, copyLaps };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Stopwatch — Lap, Split, and Millisecond Timing",
  "description": "Browser-based precision stopwatch with millisecond timing, lap and split tracking, and copy-to-clipboard export. Uses W3C High Resolution Time API.",
  "url": "<?php echo esc_url(home_url('/stopwatch/')); ?>",
  "dateModified": "2026-05-27",
  "author": {
    "@type": "Person",
    "name": "Suraj Giri",
    "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Blog Timer",
    "url": "<?php echo esc_url(home_url('/')); ?>"
  }
}
</script>

<?php get_footer(); ?>
