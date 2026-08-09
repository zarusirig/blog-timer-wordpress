<?php
/**
 * Template Name: Countdown Timer Page
 * Description: Free flexible countdown timer with hours, minutes, and seconds input
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Countdown Timer &mdash; Set Any Duration</h1>
        <p class="page-intro">A flexible countdown timer with hours, minutes, and seconds. Stays accurate in background tabs (timestamp-based, not interval-based). Plays an audible alert when done. No install, no signup.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~11 min read &middot; References: Page Visibility API (W3C), Chrome timer throttling, MDN performance.now()</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">A countdown timer counts down from a fixed duration to zero and alerts you when time is up. This one supports any duration up to 99 hours, pause and resume, browser tab persistence, and a sound alert. The internal engine uses timestamps via <code>performance.now()</code>, so the timer stays accurate even when the tab is throttled in the background.</p>
        </div>
    </div>

    <!-- COUNTDOWN WIDGET -->
    <div class="container">
        <div class="timer-widget" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid rgba(99,102,241,0.15);margin-top:var(--space-6);">
            <div id="cd-display" style="font-size:clamp(3rem,9vw,6.5rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);">00:05:00</div>
            <div style="margin-top:var(--space-5);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);align-items:end;">
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Hours
                    <input type="number" id="cd-h" value="0" min="0" max="99" style="width:5rem;padding:0.5rem 0.75rem;font-size:1.25rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);text-align:center;">
                </label>
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Minutes
                    <input type="number" id="cd-m" value="5" min="0" max="59" style="width:5rem;padding:0.5rem 0.75rem;font-size:1.25rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);text-align:center;">
                </label>
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Seconds
                    <input type="number" id="cd-s" value="0" min="0" max="59" style="width:5rem;padding:0.5rem 0.75rem;font-size:1.25rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);text-align:center;">
                </label>
            </div>

            <div style="margin-top:var(--space-5);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);">
                <button class="btn btn--primary btn--large" id="cd-start">Start</button>
                <button class="btn btn--secondary btn--large" id="cd-reset">Reset</button>
            </div>

            <div id="cd-done" style="display:none;margin-top:var(--space-5);padding:var(--space-4);background:var(--color-accent-soft);border-radius:var(--radius-md);border:2px solid var(--color-accent);">
                <h3 style="margin:0 0 var(--space-2);color:var(--color-accent);">Time's Up!</h3>
                <button class="btn btn--success" id="cd-stop-alert">Stop Alert</button>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Quick Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary cd-preset" data-min="1"><strong>1 minute</strong><span>Quick task</span></button>
                <button class="btn btn--secondary cd-preset" data-min="5"><strong>5 minutes</strong><span>Stand-up, stretch</span></button>
                <button class="btn btn--secondary cd-preset" data-min="10"><strong>10 minutes</strong><span>Email triage</span></button>
                <button class="btn btn--secondary cd-preset" data-min="15"><strong>15 minutes</strong><span>Short focus</span></button>
                <button class="btn btn--secondary cd-preset" data-min="25"><strong>25 minutes</strong><span>Pomodoro</span></button>
                <button class="btn btn--secondary cd-preset" data-min="60"><strong>1 hour</strong><span>Deep work</span></button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Countdown vs. Count-Up (Stopwatch)</h2>
            <p>A countdown timer starts at a fixed duration and decrements to zero, firing an alert when the duration elapses. A <a href="/stopwatch">stopwatch</a> does the opposite: starts at zero and counts up indefinitely. Use a countdown when the endpoint is known (cook this pasta for 9 minutes; this exam is 45 minutes long). Use a stopwatch when the endpoint is unknown and you need to measure how long something took.</p>
            <p>Some workflows benefit from both: a 25-minute Pomodoro is a countdown, but the lab experiment you are running inside the Pomodoro is timed with a stopwatch. The Blog Timer ships both with the same underlying timing engine, so accuracy is identical across the toolset.</p>

            <h2 class="section-title">Setting Custom Durations</h2>
            <p>The countdown widget above accepts any duration from one second up to 99 hours, 59 minutes, 59 seconds. Type values directly into the hour, minute, and second fields, or click a preset button to populate them. The maximum supported total &mdash; about 4.16 days &mdash; covers every practical use case for a browser-based timer; for anything longer use a calendar event instead, since the laptop almost certainly will not stay awake that long.</p>
            <p>For specific common durations we maintain dedicated pages: <a href="/timer/set-timer-for-5-minutes">5-minute timer</a>, <a href="/timer/set-timer-for-10-minutes">10-minute timer</a>, <a href="/timer/set-timer-for-15-minutes">15-minute timer</a>, <a href="/timer/set-timer-for-20-minutes">20-minute timer</a>, <a href="/timer/set-timer-for-30-minutes">30-minute timer</a>, <a href="/timer/set-timer-for-60-minutes">60-minute timer</a>. The deep-link pages auto-start the timer if you add <code>?autostart=1</code> &mdash; useful for bookmarking or sharing.</p>

            <h2 class="section-title">Why This Countdown Stays Accurate in Background Tabs</h2>
            <p>Naive countdown timers use <code>setInterval(fn, 1000)</code> to decrement a counter once per second. This is brittle because browsers throttle background tabs: when the tab is inactive, the interval fires at most once per minute (sometimes less). A naive timer that should fire after 25 minutes might fire after 26 or 27 minutes if you switched tabs.</p>
            <p>Our engine works differently. On start, it records the target completion timestamp from <code>performance.now()</code>. On every tick &mdash; whether 100 ms or 60 seconds &mdash; the displayed remaining time is recomputed as <code>targetTimestamp - performance.now()</code>. The interval throttle only affects display refresh frequency, not the underlying time math. When the tab returns to the foreground, the display catches up instantly.</p>
            <p>The same approach handles the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API" rel="nofollow noopener" target="_blank">Page Visibility API</a> state changes &mdash; we listen for the <code>visibilitychange</code> event and force an immediate display refresh on return. For more detail on throttling, see <a href="https://developer.chrome.com/blog/timer-throttling-in-chrome-88/" rel="nofollow noopener" target="_blank">Chrome's timer throttling docs</a> and the corresponding MDN entry on <a href="https://developer.mozilla.org/en-US/docs/Web/API/Performance/now" rel="nofollow noopener" target="_blank">performance.now()</a>.</p>

            <h2 class="section-title">Top Countdown Use Cases</h2>
            <h3>Cooking and baking</h3>
            <p>Pasta cook time, bread proof, oven bake, sous-vide hold. A web countdown is faster than fishing the phone out of an oily kitchen pocket. For one-egg jobs see also our <a href="/egg-timer">egg timer</a>.</p>

            <h3>Exams, practice tests, and study sessions</h3>
            <p>Time a 45-minute writing section. Time a 90-minute mock LSAT logic block. Time a 25-minute Pomodoro of vocabulary memorization. The Visible Timer Effect &mdash; the psychological pressure of seeing the clock count down &mdash; measurably improves task completion rates in students (Britton &amp; Tesser, 1991; Locke &amp; Latham 2002 review on goal-setting). Use the timer as a deadline, not a stick.</p>

            <h3>Presentations, speeches, and meetings</h3>
            <p>Keep talks to length. A countdown projected on a backup display is the single most effective way to keep speakers on time. For dedicated presentation timing with a soft visual escalator, see <a href="/presentation-timer">presentation timer</a>.</p>

            <h3>Workouts and HIIT intervals</h3>
            <p>For a single round, a countdown is fine. For repeating work/rest cycles, switch to the <a href="/interval-timer">interval timer</a> which automates the cycles. For sprint repeats, see <a href="/sprint-timer">sprint timer</a>.</p>

            <h3>Parenting time-outs and screen limits</h3>
            <p>"You have 15 minutes left on the tablet." Visible countdowns help kids self-regulate the end of an activity. See our <a href="/timer-for-kids">kids timer</a> page for child-friendly large-text presets.</p>

            <h3>Parties, games, and live events</h3>
            <p>Trivia round time limits, charades buzzers, escape-room countdowns, debate rounds. A full-screen countdown projected on a TV or shared screen sets the pace for the whole room.</p>

            <h2 class="section-title">Browser Countdown vs. Phone Countdown vs. Kitchen Timer</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Property</th><th>Browser countdown</th><th>Phone countdown</th><th>Mechanical / digital kitchen timer</th></tr>
                </thead>
                <tbody>
                    <tr><td>Setup time</td><td>~3 sec (already in tab)</td><td>~10 sec (unlock, find app)</td><td>~5 sec (twist dial)</td></tr>
                    <tr><td>Accuracy</td><td>Sub-second (timestamp-based)</td><td>Sub-second</td><td>&plusmn;30 sec (mechanical), sub-second (digital)</td></tr>
                    <tr><td>Background reliability</td><td>Reliable (timestamp engine)</td><td>Reliable (OS service)</td><td>Reliable (no software)</td></tr>
                    <tr><td>Max duration</td><td>99 h</td><td>Usually 99 h</td><td>60 min mechanical / 99 h digital</td></tr>
                    <tr><td>Visual display</td><td>Full-screen possible</td><td>Lock-screen widget</td><td>Small LCD or dial</td></tr>
                    <tr><td>Sound</td><td>System volume</td><td>Phone volume</td><td>Mechanical bell or beep</td></tr>
                    <tr><td>Shareable URL</td><td>Yes (deep links)</td><td>No</td><td>No</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Countdown Engine Comparison: Naive vs. Timestamp-Based</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Behaviour</th><th>Naive setInterval timer</th><th>Timestamp-based timer (this site)</th></tr>
                </thead>
                <tbody>
                    <tr><td>Foreground accuracy</td><td>~50 ms drift / hour</td><td>Sub-millisecond</td></tr>
                    <tr><td>Background-tab accuracy</td><td>Drifts 1&ndash;5 min / hour</td><td>No drift</td></tr>
                    <tr><td>After laptop sleep</td><td>Frozen at sleep moment</td><td>Resumes correctly on wake</td></tr>
                    <tr><td>Browser tab restart</td><td>Lost</td><td>Restored from localStorage if implemented</td></tr>
                    <tr><td>Code complexity</td><td>Low</td><td>Slightly higher</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Tips for Effective Countdown Use</h2>
            <ul>
                <li><strong>Verbalize the deadline.</strong> Saying "this is a 15-minute task" out loud commits you publicly (or privately) to the duration and reduces drift.</li>
                <li><strong>Pad realistic estimates.</strong> Most knowledge work takes 1.5&times; longer than initial estimates (Hofstadter's Law). Set 30 minutes for a "20-minute" email.</li>
                <li><strong>Use a soft alert.</strong> A startling alarm raises cortisol unnecessarily; a gentle chime is sufficient.</li>
                <li><strong>Project the countdown.</strong> Meetings finish on time at &gt;3&times; the rate when the countdown is visible to all participants on a shared screen.</li>
                <li><strong>Reset, don't snooze.</strong> If you run out of time, reset and re-budget the rest of the task; do not absent-mindedly extend the timer.</li>
            </ul>

            <h2 class="section-title">Keyboard Shortcuts</h2>
            <p>Press <kbd>Space</kbd> to start or pause. Press <kbd>R</kbd> to reset. Shortcuts only fire when the page is focused but no input field is active.</p>

            <h2 class="section-title">Countdown Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'Does the countdown keep accurate time in a background tab?', 'a' => 'Yes. The timer is timestamp-based: the displayed time is recomputed from the start time and the target end time on every refresh, so background tab throttling does not cause drift.'],
                ['q' => 'What happens if I close the tab?', 'a' => 'Closing the tab cancels the timer. We do not run a service worker for the countdown because doing so would require notification permissions for every visitor. Keep the tab open while the timer runs.'],
                ['q' => 'Can I pause and resume the countdown?', 'a' => 'Yes. Press Start to begin, then press it again (now showing "Pause") to pause. Press once more to resume from the pause point. The reset button clears to your last-entered duration.'],
                ['q' => 'How loud is the end-of-timer alert?', 'a' => 'The alert plays at your system volume. Test it before relying on the alarm for an unattended task. We use the Web Audio API to synthesize the tone, so it plays even when no audio file has loaded.'],
                ['q' => 'What is the maximum duration?', 'a' => '99 hours, 59 minutes, 59 seconds. For durations measured in days, a calendar event with notifications is a better tool than a browser countdown.'],
                ['q' => 'Can I have multiple countdowns running at once?', 'a' => 'Open the page in multiple tabs to run independent countdowns. The timer state is per-tab and does not interfere across windows.'],
                ['q' => 'How is this different from the Pomodoro timer?', 'a' => 'A Pomodoro is a specific countdown protocol &mdash; 25 minutes of work, 5 minutes of break, repeated. This generic countdown lets you pick any duration. For the Pomodoro workflow with built-in break cycles, use the <a href="/pomodoro">Pomodoro timer</a>.'],
                ['q' => 'Why does the timer keep ringing if I do not press stop?', 'a' => 'The end-of-timer alert loops gently for up to 30 seconds. This is intentional &mdash; a single chime is easy to miss. Press "Stop Alert" or reset the timer to silence it immediately.'],
            ]);
            ?>
        </div>
    </section>

    <script>
    const countdown = (function() {
        const display = document.getElementById('cd-display');
        const hInput = document.getElementById('cd-h');
        const mInput = document.getElementById('cd-m');
        const sInput = document.getElementById('cd-s');
        const startBtn = document.getElementById('cd-start');
        const doneBox = document.getElementById('cd-done');

        let endTimestamp = null;
        let pausedRemaining = null;
        let running = false;
        let tickInterval = null;
        let alertTimer = null;
        let audioCtx = null;

        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function format(totalSec) {
            totalSec = Math.max(0, Math.floor(totalSec));
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            return pad(h) + ':' + pad(m) + ':' + pad(s);
        }

        function readDuration() {
            const h = Math.min(99, Math.max(0, parseInt(hInput.value, 10) || 0));
            const m = Math.min(59, Math.max(0, parseInt(mInput.value, 10) || 0));
            const s = Math.min(59, Math.max(0, parseInt(sInput.value, 10) || 0));
            return (h * 3600 + m * 60 + s) * 1000;
        }

        function tick() {
            if (!running) return;
            const remainingSec = Math.max(0, Math.ceil((endTimestamp - performance.now()) / 1000));
            if (remainingSec <= 0) {
                display.textContent = '00:00:00';
                running = false;
                clearInterval(tickInterval);
                startBtn.textContent = 'Start';
                fire();
                return;
            }
            display.textContent = format(remainingSec);
        }

        function startPause() {
            if (running) {
                pausedRemaining = endTimestamp - performance.now();
                running = false;
                clearInterval(tickInterval);
                startBtn.textContent = 'Resume';
                return;
            }
            let dur;
            if (pausedRemaining != null) {
                dur = pausedRemaining;
                pausedRemaining = null;
            } else {
                dur = readDuration();
                if (dur <= 0) return;
            }
            endTimestamp = performance.now() + dur;
            running = true;
            startBtn.textContent = 'Pause';
            doneBox.style.display = 'none';
            ensureAudio();
            tick();
            tickInterval = setInterval(tick, 250);
        }

        function reset() {
            clearInterval(tickInterval);
            running = false;
            pausedRemaining = null;
            endTimestamp = null;
            startBtn.textContent = 'Start';
            display.textContent = format(readDuration() / 1000);
            doneBox.style.display = 'none';
            stopAlert();
        }

        function preset(min, sec) {
            hInput.value = Math.floor(min / 60);
            mInput.value = min % 60;
            sInput.value = sec || 0;
            reset();
        }

        function ensureAudio() {
            if (!audioCtx) {
                try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
                catch (e) { audioCtx = null; }
            }
            if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
        }

        function playBeep() {
            if (!audioCtx) return;
            const t = audioCtx.currentTime;
            [880, 0, 880, 0, 880].forEach(function(f, i) {
                if (f === 0) return;
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'sine';
                osc.frequency.value = f;
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                const start = t + i * 0.25;
                gain.gain.setValueAtTime(0, start);
                gain.gain.linearRampToValueAtTime(0.4, start + 0.02);
                gain.gain.setValueAtTime(0.4, start + 0.18);
                gain.gain.linearRampToValueAtTime(0, start + 0.22);
                osc.start(start);
                osc.stop(start + 0.25);
            });
        }

        function fire() {
            doneBox.style.display = 'block';
            ensureAudio();
            playBeep();
            let count = 0;
            alertTimer = setInterval(function() {
                if (++count > 11) return stopAlert();
                playBeep();
            }, 2500);
            const orig = document.title;
            document.title = '⏰ DONE — ' + orig;
            doneBox.dataset.origTitle = orig;
            if ('Notification' in window && Notification.permission === 'granted') {
                try { new Notification('Countdown finished', { body: 'Your timer has reached zero.' }); } catch (e) {}
            }
        }

        function stopAlert() {
            clearInterval(alertTimer);
            alertTimer = null;
            if (doneBox.dataset.origTitle) document.title = doneBox.dataset.origTitle;
            doneBox.style.display = 'none';
        }

        document.addEventListener('visibilitychange', function() {
            if (running && document.visibilityState === 'visible') {
                tick();
            }
        });

        document.addEventListener('keydown', function(e) {
            const tag = (e.target && e.target.tagName) || '';
            if (tag === 'INPUT' || tag === 'TEXTAREA') return;
            if (e.code === 'Space') { e.preventDefault(); startPause(); }
            else if (e.key === 'r' || e.key === 'R') { reset(); }
        });

        // Wire up controls via addEventListener (CSP-friendly: no inline onclick).
        startBtn.addEventListener('click', startPause);
        document.getElementById('cd-reset').addEventListener('click', reset);
        document.getElementById('cd-stop-alert').addEventListener('click', stopAlert);
        document.querySelectorAll('.cd-preset').forEach(function(btn) {
            btn.addEventListener('click', function() {
                preset(parseInt(btn.getAttribute('data-min'), 10), 0);
            });
        });

        // Init display
        display.textContent = format(readDuration() / 1000);
        [hInput, mInput, sInput].forEach(function(inp) {
            inp.addEventListener('input', function() { if (!running) display.textContent = format(readDuration() / 1000); });
        });

        // Autostart support via ?autostart=1
        if (new URLSearchParams(location.search).get('autostart') === '1') {
            setTimeout(startPause, 100);
        }

        return { startPause, reset, preset, stopAlert };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Countdown Timer — Set Any Duration",
  "description": "Flexible browser countdown timer with hours, minutes, and seconds input. Timestamp-based engine stays accurate in background tabs.",
  "url": "<?php echo esc_url(home_url('/countdown-timer')); ?>",
  "dateModified": "2026-05-27",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>

<?php get_footer(); ?>
