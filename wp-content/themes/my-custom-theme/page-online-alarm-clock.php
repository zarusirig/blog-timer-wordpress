<?php
/**
 * Template Name: Online Alarm Clock Page
 * Description: Free browser-based alarm clock with snooze, repeat, and OS notifications
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Alarm Clock &mdash; Set Wake-Up Alarms in Your Browser</h1>
        <p class="page-intro">Set a wake-up or reminder alarm that fires in your browser at the exact target time. Uses the Web Audio API for reliable sound and the Notification API for system-level alerts. No install, no signup.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~10 min read &middot; References: Mednick (Nature Neuroscience 2002), Reyner &amp; Horne (Psychophysiology 1997), MDN Notification API</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Type a target time in HH:MM (24-hour) and press Set Alarm. When the clock reaches that time, your browser plays a configurable tone and shows a system notification. Includes snooze, repeat, and a live current-time display. Best used on a desktop with the tab kept open; for nightly wake-up, pair with the OS-level alarm on your phone for redundancy.</p>
        </div>
    </div>

    <!-- ALARM WIDGET -->
    <div class="container">
        <div class="timer-widget" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid rgba(99,102,241,0.15);margin-top:var(--space-6);">
            <p style="font-size:var(--text-sm);text-transform:uppercase;letter-spacing:0.1em;color:var(--color-text-muted);margin-bottom:var(--space-2);">Current time</p>
            <div id="ac-clock" style="font-size:clamp(2.5rem,7vw,5rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);">--:--:--</div>

            <div style="margin-top:var(--space-5);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);align-items:end;">
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Target time
                    <input type="time" id="ac-time" value="07:00" style="padding:0.5rem 0.75rem;font-size:1.25rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);">
                </label>
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Tone
                    <select id="ac-tone" style="padding:0.5rem 0.75rem;font-size:1rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);">
                        <option value="beep">Beep (sine)</option>
                        <option value="gentle">Gentle chime</option>
                        <option value="urgent">Urgent triple beep</option>
                    </select>
                </label>
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--color-text-secondary);align-self:flex-end;padding-bottom:0.5rem;">
                    <input type="checkbox" id="ac-repeat"> Repeat daily
                </label>
            </div>

            <div style="margin-top:var(--space-5);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);">
                <button class="btn btn--primary btn--large" id="ac-set" onclick="alarmClock.set()">Set Alarm</button>
                <button class="btn btn--secondary btn--large" id="ac-cancel" onclick="alarmClock.cancel()" disabled>Cancel</button>
                <button class="btn btn--secondary btn--large" id="ac-test" onclick="alarmClock.test()">Test Sound</button>
            </div>

            <p id="ac-status" style="margin-top:var(--space-4);color:var(--color-text-muted);font-size:0.875rem;min-height:1.25rem;"></p>

            <div id="ac-ringing" style="display:none;margin-top:var(--space-5);padding:var(--space-5);background:var(--color-accent-soft);border-radius:var(--radius-md);border:2px solid var(--color-accent);">
                <h3 style="margin:0 0 var(--space-3);color:var(--color-accent);">Alarm! Wake up.</h3>
                <button class="btn btn--success" onclick="alarmClock.snooze()">Snooze 9 minutes</button>
                <button class="btn btn--secondary" onclick="alarmClock.dismiss()" style="margin-left:0.5rem;">Dismiss</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">When to Use an Online Alarm Clock vs. Your Phone</h2>
            <p>A browser alarm clock is best when you are already at your desk and want a single discoverable surface for a quick reminder. A 25-minute deep-work block, a 7am stand-up reminder, a "stop reading this article in 30 minutes" prompt &mdash; the friction of opening a phone, finding the clock app, setting a time, and dismissing the lock screen makes a desktop alarm faster.</p>
            <p>The phone alarm wins for two cases. First, anything that must wake you from sleep: the phone's alarm runs from a low-level OS service that survives the device sleeping, while a browser alarm requires the tab to stay open and the laptop to stay awake. Second, anything mobile: alarms while commuting, walking, or otherwise away from a screen. For nightly wake-up alarms, treat the browser as a secondary alert and your phone as primary.</p>

            <h2 class="section-title">How This Alarm Works Under the Hood</h2>
            <p>The current time is read from the system clock and rendered on the page every second using <code>setInterval</code>. When you set an alarm, the page computes the absolute timestamp of the target time. On every tick, it checks whether the current time has crossed that timestamp.</p>
            <p>When the alarm fires, two things happen in parallel. A tone is synthesized using the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API" rel="nofollow noopener" target="_blank">Web Audio API</a> &mdash; no audio file is downloaded, so there is no playback delay or codec issue. Simultaneously, a system notification is requested through the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Notification" rel="nofollow noopener" target="_blank">Notification API</a> (you must grant permission once). The notification surfaces above other windows even if the browser is in the background, increasing the chance that you actually notice the alarm.</p>
            <p>Browser timer throttling is the main accuracy concern. Modern browsers throttle background tabs to one timer fire per second or less, which is more than enough resolution for a wake-up alarm (target accuracy: about &plusmn;1 second). When the tab is in the foreground, accuracy is sub-second. For details, see Chrome's <a href="https://developer.chrome.com/blog/timer-throttling-in-chrome-88/" rel="nofollow noopener" target="_blank">timer throttling documentation</a>.</p>

            <h2 class="section-title">Sleep Science and Alarm Timing</h2>
            <p>How you time your wake-up matters as much as whether the alarm fires. Most adults cycle through four to six 90-minute sleep cycles per night, each containing light sleep, deep sleep, and REM. Waking from deep sleep (stage N3) produces severe sleep inertia &mdash; the groggy "drugged" feeling that can persist for an hour. Waking at the end of a cycle, in light sleep or REM, is dramatically easier.</p>
            <p>If you reliably sleep 7.5 hours, you wake at the end of a fifth cycle. Six hours wakes you at the end of a fourth cycle. Avoid lengths like 6h 30m or 7h 15m &mdash; they leave you mid-deep-sleep. The most-cited modern researcher on sleep timing is <a href="https://en.wikipedia.org/wiki/Sara_Mednick" rel="nofollow noopener" target="_blank">Sara Mednick</a>, whose 2002 <em>Nature Neuroscience</em> paper (<a href="https://www.nature.com/articles/nn864" rel="nofollow noopener" target="_blank">DOI 10.1038/nn864</a>) established the modern framework for short-sleep alertness recovery.</p>

            <h2 class="section-title">Wake-Up Alarm Strategies</h2>
            <h3>Gradual light alarms</h3>
            <p>Dawn-simulator lamps gradually brighten the bedroom over 30 minutes to mimic natural sunrise. Cortisol naturally rises in response to morning light, easing wake. A 2014 BMC Psychiatry trial found dawn-simulator light improved morning alertness compared to standard alarms. This browser alarm cannot drive a lamp, but pairing the two is the gentlest wake-up combination.</p>
            <h3>Sound versus vibration</h3>
            <p>Loud sound alarms wake more reliably but produce a sharper cortisol spike and a worse first 30 minutes. Vibration-only alarms (wearable or pillow-puck) wake gently but are less reliable for heavy sleepers. A two-stage approach &mdash; light or vibration first, sound as fallback after five minutes &mdash; is the gold standard.</p>
            <h3>Sleep-cycle-aware alarms</h3>
            <p>Some apps use phone accelerometers or watch heart-rate to detect light sleep within a 30-minute window before your target time, then fire when they sense you are nearest to wake. Evidence for these apps is mixed; the accelerometer signal is a noisy proxy for sleep stage. They are likely better than a fixed-time alarm but worse than a lab-grade EEG-triggered alarm (which is not consumer-available).</p>

            <h2 class="section-title">The Science of Snooze</h2>
            <p>The cultural verdict on snoozing is harsh, but the evidence is more nuanced. Reyner and Horne's research in <em>Psychophysiology</em> on sleep inertia (1997, <a href="https://pubmed.ncbi.nlm.nih.gov/9401427/" rel="nofollow noopener" target="_blank">PMID 9401427</a>) showed that fragmenting sleep right before wake-up generally <em>increases</em> inertia. But a 2022 paper from Stockholm University (Sundelin et al., <em>Journal of Sleep Research</em>) found that ~30 minutes of snoozing did not impair cognitive performance after fully waking and may have helped habitual snoozers exit deep sleep before their final wake.</p>
            <p>Practical guidance: if you are a habitual non-snoozer, set the alarm for the time you actually need to be up. If you snooze, set the first alarm 20 to 30 minutes earlier and accept the snooze period as your gradual wake protocol. Our snooze button defaults to nine minutes &mdash; the same interval Apple, Android, and traditional clock radios all use, originating from the mechanical clock gear constraints of mid-20th-century snooze designs.</p>

            <h2 class="section-title">Apple iOS Clock vs. Android Clock vs. Browser Alarm</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Feature</th><th>iOS Clock</th><th>Android Clock</th><th>This browser alarm</th></tr>
                </thead>
                <tbody>
                    <tr><td>Survives device sleep</td><td>Yes</td><td>Yes</td><td>No (laptop must stay awake)</td></tr>
                    <tr><td>Bedtime / sleep schedule</td><td>Yes (Health app)</td><td>Yes (Bedtime mode)</td><td>No</td></tr>
                    <tr><td>Repeating daily</td><td>Yes</td><td>Yes</td><td>Yes (while tab open)</td></tr>
                    <tr><td>Custom tones</td><td>System sounds + music</td><td>System + music</td><td>3 built-in tones</td></tr>
                    <tr><td>Snooze interval</td><td>9 min (fixed)</td><td>5&ndash;30 min adjustable</td><td>9 min (fixed)</td></tr>
                    <tr><td>OS notifications</td><td>Yes</td><td>Yes</td><td>Yes (with permission)</td></tr>
                    <tr><td>Volume escalation</td><td>Yes (over time)</td><td>Yes (over time)</td><td>No</td></tr>
                    <tr><td>Setup time</td><td>~10 sec</td><td>~10 sec</td><td>~3 sec (already in browser)</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Alarm Tone Comparison</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Tone</th><th>Frequency</th><th>Best for</th></tr>
                </thead>
                <tbody>
                    <tr><td>Beep (sine 880 Hz)</td><td>Single tone, ~1 sec on, 0.5 sec off</td><td>Clear, unmistakable, classic alarm feel</td></tr>
                    <tr><td>Gentle chime</td><td>523 Hz / 659 Hz / 784 Hz arpeggio</td><td>Reminders, meeting alerts, soft wake</td></tr>
                    <tr><td>Urgent triple</td><td>Three 1000 Hz pulses, 200 ms each</td><td>Critical wake-ups, deadline alarms</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Use Cases for a Browser Alarm</h2>
            <ul>
                <li><strong>Meeting reminders</strong> &mdash; set a 9:55am alarm for a 10am call.</li>
                <li><strong>Stop-work alarms</strong> &mdash; set an end-of-day alarm to leave work on time.</li>
                <li><strong>Cooking timers with absolute time</strong> &mdash; "the bread is done at 4:45" rather than "cook for 35 minutes."</li>
                <li><strong>Medication reminders</strong> &mdash; daily at the same time. Use the repeat-daily option.</li>
                <li><strong>Public-transit alarms</strong> &mdash; "leave the desk at 17:42 for the 18:00 train."</li>
                <li><strong>Late-shift wake</strong> &mdash; secondary alarm when napping during a long evening shift.</li>
            </ul>
            <p>For shorter, duration-based reminders see the <a href="/countdown-timer/">countdown timer</a>. For deep-work sessions, see <a href="/pomodoro/">Pomodoro</a>. For wake-up after a nap, see <a href="/nap-timer/">nap timer</a>. For ambient wind-down before bed, see <a href="/sleep-timer/">sleep timer</a>.</p>

            <h2 class="section-title">Alarm Clock FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'Does the alarm work if my browser is closed?', 'a' => 'No. A browser-based alarm requires the tab to remain open. The tab can be in the background or minimized, but the browser process must be running and the operating system must not be asleep. For nightly wake-up, use your phone alarm as primary.'],
                ['q' => 'Will the alarm fire if my laptop is asleep?', 'a' => 'No. When the laptop sleeps, the browser stops executing JavaScript. Keep the laptop awake or use a system-level alarm app. On macOS you can use the built-in Clock app; on Windows, Alarms & Clock.'],
                ['q' => 'Why does the alarm need notification permission?', 'a' => 'Notifications surface above other windows and can wake you when the browser tab is in the background. Without permission only the in-tab visual alert and the sound will fire, and you may miss the visual alert if you have minimized the browser.'],
                ['q' => 'How loud is the alarm?', 'a' => 'The Web Audio API generates the tone at full system volume; control loudness with your operating system volume control. Test with the "Test Sound" button before relying on the alarm for an important wake-up.'],
                ['q' => 'How accurate is the alarm time?', 'a' => 'When the tab is in the foreground, accuracy is sub-second. When in a throttled background tab, accuracy is within one to two seconds. This is sufficient for any human-scheduled alarm.'],
                ['q' => 'Can I set multiple alarms?', 'a' => 'This widget currently supports one alarm at a time. To run multiple alarms, open the alarm clock in multiple browser tabs and set each independently. We may add multi-alarm support in a future update.'],
                ['q' => 'Does snoozing the alarm reschedule it?', 'a' => 'Snooze adds nine minutes to the current time and fires once. The original target time is replaced. If repeat-daily is enabled, the original time still fires the next day.'],
                ['q' => 'Will the alarm work on my phone browser?', 'a' => 'Mobile browsers aggressively suspend background tabs to save battery. Keep the tab in the foreground and the screen unlocked. For mobile wake-up alarms, always prefer the native iOS or Android Clock app.'],
            ]);
            ?>
        </div>
    </section>

    <script>
    const alarmClock = (function() {
        const clock = document.getElementById('ac-clock');
        const timeInput = document.getElementById('ac-time');
        const toneSelect = document.getElementById('ac-tone');
        const repeatChk = document.getElementById('ac-repeat');
        const setBtn = document.getElementById('ac-set');
        const cancelBtn = document.getElementById('ac-cancel');
        const status = document.getElementById('ac-status');
        const ringing = document.getElementById('ac-ringing');

        let target = null;       // Date object for next fire
        let firedToday = false;
        let audioCtx = null;
        let ringingTimer = null;

        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function tick() {
            const now = new Date();
            clock.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
            if (target && now >= target && !firedToday) {
                firedToday = true;
                fire();
                if (repeatChk.checked) {
                    target = new Date(target.getTime() + 24 * 60 * 60 * 1000);
                    firedToday = false;
                    updateStatus();
                } else {
                    target = null;
                    setBtn.disabled = false;
                    cancelBtn.disabled = true;
                }
            }
        }

        function set() {
            const val = timeInput.value;
            if (!val) { status.textContent = 'Pick a time first.'; return; }
            const [hh, mm] = val.split(':').map(Number);
            const now = new Date();
            target = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hh, mm, 0, 0);
            if (target <= now) target = new Date(target.getTime() + 24 * 60 * 60 * 1000);
            firedToday = false;
            setBtn.disabled = true;
            cancelBtn.disabled = false;
            updateStatus();
            requestNotificationPermission();
            ensureAudio();
        }

        function updateStatus() {
            if (!target) { status.textContent = ''; return; }
            const ms = target - new Date();
            const totalMin = Math.round(ms / 60000);
            const h = Math.floor(totalMin / 60);
            const m = totalMin % 60;
            status.textContent = 'Alarm set for ' + target.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'}) + ' (in ' + (h ? h + 'h ' : '') + m + 'm)' + (repeatChk.checked ? ' &mdash; repeats daily' : '');
        }

        function cancel() {
            target = null;
            firedToday = false;
            setBtn.disabled = false;
            cancelBtn.disabled = true;
            status.textContent = 'Alarm cancelled.';
            stopRinging();
        }

        function ensureAudio() {
            if (!audioCtx) {
                try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
                catch (e) { audioCtx = null; }
            }
            if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
        }

        function playTone() {
            ensureAudio();
            if (!audioCtx) return;
            const tone = toneSelect.value;
            const now = audioCtx.currentTime;
            if (tone === 'beep') beep(880, now, 1.0);
            else if (tone === 'gentle') { beep(523.25, now, 0.4); beep(659.25, now + 0.45, 0.4); beep(783.99, now + 0.9, 0.6); }
            else if (tone === 'urgent') { beep(1000, now, 0.2); beep(1000, now + 0.3, 0.2); beep(1000, now + 0.6, 0.2); }
        }

        function beep(freq, when, dur) {
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.value = freq;
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            gain.gain.setValueAtTime(0, when);
            gain.gain.linearRampToValueAtTime(0.4, when + 0.02);
            gain.gain.setValueAtTime(0.4, when + dur - 0.05);
            gain.gain.linearRampToValueAtTime(0, when + dur);
            osc.start(when);
            osc.stop(when + dur + 0.05);
        }

        function fire() {
            ringing.style.display = 'block';
            playTone();
            ringingTimer = setInterval(playTone, 2500);
            if ('Notification' in window && Notification.permission === 'granted') {
                try { new Notification('Alarm', { body: 'It is ' + new Date().toLocaleTimeString() }); }
                catch (e) {}
            }
            const origTitle = document.title;
            document.title = '🔔 ALARM — ' + origTitle;
            ringing.dataset.origTitle = origTitle;
        }

        function stopRinging() {
            ringing.style.display = 'none';
            clearInterval(ringingTimer);
            ringingTimer = null;
            if (ringing.dataset.origTitle) document.title = ringing.dataset.origTitle;
        }

        function snooze() {
            stopRinging();
            target = new Date(Date.now() + 9 * 60 * 1000);
            firedToday = false;
            setBtn.disabled = true;
            cancelBtn.disabled = false;
            updateStatus();
        }

        function dismiss() { stopRinging(); }

        function test() {
            ensureAudio();
            playTone();
        }

        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        setInterval(tick, 250);
        tick();

        return { set, cancel, snooze, dismiss, test };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Alarm Clock — Set Wake-Up Alarms in Your Browser",
  "description": "Browser-based alarm clock with snooze, repeat, custom tones, and OS-level notifications. Uses Web Audio API and Notification API. No install required.",
  "url": "<?php echo esc_url(home_url('/online-alarm-clock/')); ?>",
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
