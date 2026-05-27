<?php
/**
 * Template Name: Sleep Timer Page
 * Description: Ambient sleep timer with fading white/brown/pink noise and rain/ocean loops
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Sleep Timer &mdash; Drift Off Without Worrying About the Clock</h1>
        <p class="page-intro">A bedtime timer with built-in ambient noise (white, pink, brown, rain, ocean). The sound gradually fades to silence in the last two minutes so it does not wake you when it ends. Set it, lie down, sleep.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri/" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~14 min read &middot; References: Mednick (Nature Neuroscience 2002), Cordi et al. (Scientific Reports 2019), Riedy et al. (Sleep Medicine Reviews 2021)</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Pick a duration (15, 30, 45, 60, 90 minutes, or custom), pick a sound (white, pink, brown noise, rain, or ocean), and press Start. The timer counts down and the audio loops at a steady comfortable level until the last two minutes, when it fades smoothly to silence so it does not jolt you awake. For naps under 30 minutes use the <a href="/nap-timer/">nap timer</a> instead &mdash; the sleep-cycle science is different.</p>
        </div>
    </div>

    <!-- SLEEP TIMER WIDGET -->
    <div class="container">
        <div class="timer-widget" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid rgba(99,102,241,0.15);margin-top:var(--space-6);">
            <div id="st-display" style="font-size:clamp(3rem,9vw,6.5rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);">30:00</div>

            <div style="margin-top:var(--space-4);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);align-items:end;">
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Sound
                    <select id="st-sound" style="padding:0.5rem 0.75rem;font-size:1rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);">
                        <option value="white">White noise</option>
                        <option value="pink">Pink noise</option>
                        <option value="brown" selected>Brown noise</option>
                        <option value="rain">Rain</option>
                        <option value="ocean">Ocean waves</option>
                        <option value="silent">No sound</option>
                    </select>
                </label>
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Volume
                    <input type="range" id="st-vol" min="0" max="100" value="40" style="width:8rem;">
                </label>
                <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);">
                    Custom minutes
                    <input type="number" id="st-custom" min="1" max="480" placeholder="e.g. 45" style="width:6rem;padding:0.5rem 0.75rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);text-align:center;">
                </label>
            </div>

            <div style="margin-top:var(--space-5);display:flex;flex-wrap:wrap;justify-content:center;gap:var(--space-3);">
                <button class="btn btn--primary btn--large" id="st-start" onclick="sleepTimer.startPause()">Start</button>
                <button class="btn btn--secondary btn--large" onclick="sleepTimer.reset()">Reset</button>
                <button class="btn btn--secondary btn--large" onclick="sleepTimer.setCustom()">Use Custom</button>
            </div>

            <p id="st-status" style="margin-top:var(--space-4);color:var(--color-text-muted);font-size:0.875rem;min-height:1.25rem;"></p>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Sleep Timer Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary" onclick="sleepTimer.preset(15)"><strong>15 min</strong><span>Falling asleep</span></button>
                <button class="btn btn--secondary" onclick="sleepTimer.preset(30)"><strong>30 min</strong><span>Light reading + sleep</span></button>
                <button class="btn btn--secondary" onclick="sleepTimer.preset(45)"><strong>45 min</strong><span>Audiobook chapter</span></button>
                <button class="btn btn--secondary" onclick="sleepTimer.preset(60)"><strong>60 min</strong><span>Meditation + drift</span></button>
                <button class="btn btn--secondary" onclick="sleepTimer.preset(90)"><strong>90 min</strong><span>One sleep cycle</span></button>
                <button class="btn btn--secondary" onclick="sleepTimer.preset(120)"><strong>2 hours</strong><span>Long drift</span></button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why Sleep Timers Work</h2>
            <p>A sleep timer solves a small but real problem: the audio you use to fall asleep should not still be playing eight hours later. Continuous overnight sound can fragment sleep, drain device batteries, and (for shared bedrooms) annoy a partner who has fallen asleep faster than you have. The sleep timer ends the audio at a sensible point, after you are almost certainly asleep, without requiring you to wake up to dismiss it.</p>
            <p>The duration matters because of how sleep onset works. Healthy adults take 10 to 20 minutes to fall asleep (the "sleep latency"). Falling asleep faster suggests sleep deprivation; taking much longer suggests insomnia or hyperarousal. A 30-minute sleep timer covers the entire normal-range latency for most people, and the fade-out in the last two minutes prevents the abrupt end from re-rousing you. Sara Mednick's foundational 2002 paper in <em>Nature Neuroscience</em> (<a href="https://www.nature.com/articles/nn864" rel="nofollow noopener" target="_blank">DOI 10.1038/nn864</a>) on naps and recovery established the modern sleep-cycle framework that informs our duration presets.</p>

            <h2 class="section-title">Music and Sound for Falling Asleep</h2>
            <p>Cordi, Ackermann, and Rasch's 2019 paper in <em>Scientific Reports</em> ("Effects of relaxing music on healthy sleep," <a href="https://www.nature.com/articles/s41598-019-45608-y" rel="nofollow noopener" target="_blank">DOI 10.1038/s41598-019-45608-y</a>) found that relaxing music at 60 to 80 beats per minute reduced sleep onset latency and increased sleep efficiency in healthy adults. The mechanism is two-fold: rhythmic entrainment of heart rate toward the music tempo, and the masking of intrusive thoughts that delay sleep onset.</p>
            <p>Crucially, the music must be sub-lexical (no lyrics that pull attention) and harmonically simple (no surprising chord changes that re-engage cortical processing). This is why ambient generative drones outperform classical sonatas in most empirical sleep-music studies, and why "lo-fi" beats and binaural drone tracks have become the dominant genre on YouTube and Spotify sleep playlists.</p>

            <h2 class="section-title">Background Noise Types Compared</h2>
            <p>The "noise color" classification describes the power spectral density &mdash; how much energy sits at each frequency. Different shapes feel different to the ear and have different physiological effects.</p>
            <table class="comparison-table">
                <thead>
                    <tr><th>Noise type</th><th>Spectrum</th><th>Subjective feel</th><th>Best for</th></tr>
                </thead>
                <tbody>
                    <tr><td>White noise</td><td>Flat (equal energy per Hz)</td><td>Hissy, high-pitched, like static</td><td>Masking high-frequency disturbances (voices, beeps)</td></tr>
                    <tr><td>Pink noise</td><td>&minus;3 dB / octave (equal energy per octave)</td><td>Like steady rain, balanced</td><td>General-purpose sleep, most popular</td></tr>
                    <tr><td>Brown noise</td><td>&minus;6 dB / octave (bass-heavy)</td><td>Like a distant waterfall or large fan</td><td>Sensitive ears, masking low rumble</td></tr>
                    <tr><td>Rain</td><td>Broadband, irregular transients</td><td>Familiar, calming</td><td>Reduces anxiety; familiar nature sound</td></tr>
                    <tr><td>Ocean / waves</td><td>Slow modulation envelope on broadband</td><td>Rhythmic, breathing-rate</td><td>Pairs with paced breathing</td></tr>
                </tbody>
            </table>
            <p>A 2021 review by Riedy and colleagues in <em>Sleep Medicine Reviews</em> ("Noise as a sleep aid," <a href="https://pubmed.ncbi.nlm.nih.gov/33007473/" rel="nofollow noopener" target="_blank">PMID 33007473</a>) concluded that broadband noise can improve sleep continuity in noisy environments but found no consistent benefit for healthy sleepers in quiet rooms. Translation: noise helps if your bedroom is loud or your mind is loud. Otherwise silence is fine.</p>

            <h2 class="section-title">The 4-7-8 Breathing Technique Tied to the Sleep Timer</h2>
            <p>Andrew Weil's 4-7-8 breathing technique: inhale through the nose for 4 seconds, hold for 7 seconds, exhale through the mouth for 8 seconds. One cycle takes 19 seconds; four cycles take 76 seconds. Practitioners report falling asleep faster, attributed to vagal-tone shifts that downshift the sympathetic nervous system.</p>
            <p>To pair with this sleep timer: pick brown noise at low volume, set a 30-minute duration, and run four cycles of 4-7-8 within the first three minutes. By the time the breathing exercise ends, the audio is still steady and your body is in the parasympathetic state ideal for sleep onset. The timer's fade-out in the last two minutes ensures the audio does not rouse you during early-night sleep.</p>

            <h2 class="section-title">ASMR and Guided Meditation Timing</h2>
            <p>ASMR (autonomous sensory meridian response) and guided meditation tracks typically run 10 to 60 minutes. Set the sleep timer for slightly longer than the track you are listening to outside this widget &mdash; if the track ends and silence resumes, the silence itself can feel sudden. Cross-fading from a guided track into the steady noise from this widget is a smooth handoff that many sleep-meditation apps now build in by default (Calm, Headspace, Insight Timer).</p>
            <p>For nap-length sessions (under 30 minutes) the <a href="/nap-timer/">nap timer</a> is the better tool because it is calibrated to wake you cleanly at the end. Use the sleep timer when you do <em>not</em> want to be woken &mdash; when your goal is "fall asleep and stay asleep through the night."</p>

            <h2 class="section-title">Smart Speakers and Phone Sleep Apps Compared</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Feature</th><th>This browser sleep timer</th><th>Phone Clock app / Apple Bedtime</th><th>Smart speaker (Echo, Google Home)</th></tr>
                </thead>
                <tbody>
                    <tr><td>Built-in ambient noise</td><td>5 sounds + silent</td><td>Whatever app is playing</td><td>Limited (rain, ocean, white)</td></tr>
                    <tr><td>Audio fade-out</td><td>Last 2 minutes (smooth)</td><td>No</td><td>No (abrupt cutoff)</td></tr>
                    <tr><td>Setup speed</td><td>~5 sec (browser)</td><td>~15 sec (find app)</td><td>~3 sec (voice command)</td></tr>
                    <tr><td>Bedside compatible</td><td>Phone or laptop</td><td>Phone only</td><td>Hands-free</td></tr>
                    <tr><td>Custom duration</td><td>1&ndash;480 minutes</td><td>Usually presets only</td><td>Voice-specified</td></tr>
                    <tr><td>Always-on listening</td><td>None</td><td>None</td><td>Yes (privacy concern)</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Sleep Timer Use Cases</h2>
            <h3>Falling asleep to podcasts and audiobooks</h3>
            <p>Set the sleep timer for slightly longer than your nightly listening session so the audio fades out and silence holds for the rest of the night. Many podcast players have a built-in sleep timer with abrupt end &mdash; this widget pairs well as a follow-up "ambient pad" that masks the silence transition.</p>

            <h3>Travel and unfamiliar rooms</h3>
            <p>Hotel rooms, AirBNBs, and friends' couches have unpredictable noise profiles. Brown noise at moderate volume masks the unfamiliar sounds (hallway voices, HVAC clicks, traffic) that wake light sleepers in new environments.</p>

            <h3>Babies and shared bedrooms</h3>
            <p>Pink noise at low volume masks parent movements and household sounds for sleeping infants. Most pediatric sleep specialists recommend keeping the audio &lt;65 dB at the crib (an AAP guideline) and never running it continuously overnight at high volume &mdash; the fade-out is particularly relevant here.</p>

            <h3>Daytime focus sessions</h3>
            <p>This same audio engine works as a focus background. For deep work, use a longer duration (90&ndash;120 minutes) at slightly higher volume. The fade-out at the end signals the natural break point. See also our <a href="/pomodoro/">Pomodoro timer</a> for structured work cycles.</p>

            <h2 class="section-title">Sleep Hygiene Pairings</h2>
            <p>The sleep timer is one tool in a larger sleep-hygiene stack. Pair it with: dark room (curtains or eye mask), cool temperature (60&ndash;67&deg;F / 15&ndash;19&deg;C is optimal per the Sleep Foundation), no screens for 30 minutes before bed, no caffeine after 2pm, no alcohol within 3 hours of bed. The CDC's 2022 sleep report identifies blue-light screen exposure within 2 hours of bed as the single most disruptive modern factor in adult sleep onset.</p>

            <h2 class="section-title">Sleep Timer FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'What is the best duration for a sleep timer?', 'a' => '30 minutes is the most popular default and works for most people. If you have insomnia or take longer to fall asleep, try 45 to 60 minutes. For sleep cycle awareness (waking at a full-cycle boundary) 90 minutes maps to one full cycle &mdash; useful for naps but less relevant for nighttime sleep.'],
                ['q' => 'Why does the audio fade out instead of stopping suddenly?', 'a' => 'A sudden cut to silence can cause partial arousal even during light sleep. A gradual two-minute fade is below the perceptual threshold for most sleepers, so the room transitions to silence without disturbing you.'],
                ['q' => 'What is the difference between white, pink, and brown noise?', 'a' => 'White noise has equal energy at every frequency &mdash; it sounds hissy and bright. Pink noise has equal energy per octave &mdash; it sounds like steady rain, balanced. Brown noise rolls off faster &mdash; it sounds like a distant waterfall, bassy and gentle. Sensitive ears usually prefer brown; general-purpose use favors pink.'],
                ['q' => 'Does sleeping with noise damage hearing?', 'a' => 'Continuous sound below 70 dB is considered safe for unlimited duration by the WHO. Most sleep noise should sit between 40 and 60 dB &mdash; about the level of a quiet refrigerator hum. Avoid headphones at full volume for hours.'],
                ['q' => 'Will this work on my phone?', 'a' => 'Yes, but keep the browser tab in the foreground and disable auto-lock. Mobile browsers aggressively pause background tabs to save battery; the Web Audio API can be silenced when the tab is hidden.'],
                ['q' => 'Why does my battery drain while using this?', 'a' => 'Continuous audio playback is a significant energy draw on any device. Plug in your laptop or phone before bed. The Web Audio API itself is efficient, but the audio output stage and display will consume battery.'],
                ['q' => 'Can I use my own audio file?', 'a' => 'Not currently. The built-in sounds are synthesized via the Web Audio API, which avoids the bandwidth cost of streaming an audio file overnight and ensures glitch-free looping. We may add file-upload support in a future version.'],
                ['q' => 'Is this the same as a nap timer?', 'a' => 'No. A sleep timer is designed to end without waking you. A <a href="/nap-timer/">nap timer</a> is designed to wake you at the end, ideally before deep sleep sets in. Use the nap timer for sessions under 30 minutes when you need to wake up clear-headed.'],
            ]);
            ?>
        </div>
    </section>

    <script>
    const sleepTimer = (function() {
        const display = document.getElementById('st-display');
        const soundSelect = document.getElementById('st-sound');
        const volSlider = document.getElementById('st-vol');
        const customInput = document.getElementById('st-custom');
        const startBtn = document.getElementById('st-start');
        const status = document.getElementById('st-status');

        let durationMs = 30 * 60 * 1000;
        let endTimestamp = null;
        let running = false;
        let rafId = null;
        let audioCtx = null;
        let noiseNode = null;
        let gainNode = null;
        let oceanLfo = null;
        const FADE_SECONDS = 120;

        function pad(n) { return n < 10 ? '0' + n : '' + n; }
        function format(ms) {
            ms = Math.max(0, ms);
            const totalSec = Math.ceil(ms / 1000);
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            return h > 0 ? pad(h) + ':' + pad(m) + ':' + pad(s) : pad(m) + ':' + pad(s);
        }

        function tick() {
            if (!running) return;
            const remaining = endTimestamp - performance.now();
            if (remaining <= 0) {
                display.textContent = format(0);
                stopAudio();
                running = false;
                startBtn.textContent = 'Start';
                status.textContent = 'Sleep timer complete. Sweet dreams.';
                return;
            }
            display.textContent = format(remaining);
            // Update fade
            applyFade(remaining);
            rafId = requestAnimationFrame(tick);
        }

        function applyFade(remainingMs) {
            if (!gainNode || !audioCtx) return;
            const targetVol = parseInt(volSlider.value, 10) / 100;
            const remainingSec = remainingMs / 1000;
            let scale = 1;
            if (remainingSec < FADE_SECONDS) {
                scale = Math.max(0, remainingSec / FADE_SECONDS);
            }
            gainNode.gain.setTargetAtTime(targetVol * 0.5 * scale, audioCtx.currentTime, 0.5);
        }

        function ensureAudio() {
            if (!audioCtx) {
                try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
                catch (e) { return null; }
            }
            if (audioCtx.state === 'suspended') audioCtx.resume();
            return audioCtx;
        }

        function makeNoiseBuffer(type) {
            const sampleRate = audioCtx.sampleRate;
            const bufferSize = sampleRate * 2; // 2-second loop
            const buffer = audioCtx.createBuffer(1, bufferSize, sampleRate);
            const data = buffer.getChannelData(0);
            let lastOut = 0; // for brown
            let b0=0, b1=0, b2=0, b3=0, b4=0, b5=0, b6=0; // for pink
            for (let i = 0; i < bufferSize; i++) {
                const white = Math.random() * 2 - 1;
                if (type === 'white') {
                    data[i] = white * 0.5;
                } else if (type === 'pink') {
                    // Paul Kellet's pink-noise filter
                    b0 = 0.99886 * b0 + white * 0.0555179;
                    b1 = 0.99332 * b1 + white * 0.0750759;
                    b2 = 0.96900 * b2 + white * 0.1538520;
                    b3 = 0.86650 * b3 + white * 0.3104856;
                    b4 = 0.55000 * b4 + white * 0.5329522;
                    b5 = -0.7616 * b5 - white * 0.0168980;
                    data[i] = (b0 + b1 + b2 + b3 + b4 + b5 + b6 + white * 0.5362) * 0.11;
                    b6 = white * 0.115926;
                } else if (type === 'brown' || type === 'ocean') {
                    lastOut = (lastOut + (0.02 * white)) / 1.02;
                    data[i] = lastOut * 3.5;
                } else if (type === 'rain') {
                    // Pink noise + occasional high-frequency droplets
                    b0 = 0.99886 * b0 + white * 0.0555179;
                    b1 = 0.99332 * b1 + white * 0.0750759;
                    b2 = 0.96900 * b2 + white * 0.1538520;
                    b3 = 0.86650 * b3 + white * 0.3104856;
                    const pink = (b0 + b1 + b2 + b3) * 0.18;
                    const drop = Math.random() < 0.002 ? (Math.random() * 0.6 - 0.3) : 0;
                    data[i] = pink + drop;
                } else {
                    data[i] = 0;
                }
            }
            return buffer;
        }

        function startAudio() {
            const ctx = ensureAudio();
            if (!ctx) return;
            stopAudio();
            const sound = soundSelect.value;
            if (sound === 'silent') return;
            const buffer = makeNoiseBuffer(sound);
            noiseNode = ctx.createBufferSource();
            noiseNode.buffer = buffer;
            noiseNode.loop = true;
            gainNode = ctx.createGain();
            const targetVol = parseInt(volSlider.value, 10) / 100;
            gainNode.gain.value = targetVol * 0.5;
            noiseNode.connect(gainNode);
            // Ocean: amplitude modulate at 0.1 Hz (10 sec wave cycle)
            if (sound === 'ocean') {
                oceanLfo = ctx.createOscillator();
                oceanLfo.frequency.value = 0.1;
                const lfoGain = ctx.createGain();
                lfoGain.gain.value = 0.4;
                oceanLfo.connect(lfoGain);
                lfoGain.connect(gainNode.gain);
                oceanLfo.start();
            }
            gainNode.connect(ctx.destination);
            noiseNode.start();
        }

        function stopAudio() {
            try { if (noiseNode) noiseNode.stop(); } catch (e) {}
            try { if (oceanLfo) oceanLfo.stop(); } catch (e) {}
            noiseNode = null;
            oceanLfo = null;
            gainNode = null;
        }

        function startPause() {
            if (running) {
                // pause
                running = false;
                cancelAnimationFrame(rafId);
                stopAudio();
                startBtn.textContent = 'Resume';
                return;
            }
            const remaining = endTimestamp ? Math.max(0, endTimestamp - performance.now()) : durationMs;
            endTimestamp = performance.now() + (remaining || durationMs);
            running = true;
            startBtn.textContent = 'Pause';
            status.textContent = 'Sleep timer running. Audio fades in last 2 minutes.';
            startAudio();
            tick();
        }

        function reset() {
            cancelAnimationFrame(rafId);
            running = false;
            endTimestamp = null;
            stopAudio();
            startBtn.textContent = 'Start';
            display.textContent = format(durationMs);
            status.textContent = '';
        }

        function preset(minutes) {
            durationMs = minutes * 60 * 1000;
            reset();
        }

        function setCustom() {
            const m = parseInt(customInput.value, 10);
            if (m > 0 && m <= 480) preset(m);
        }

        volSlider.addEventListener('input', function() {
            if (gainNode && running) {
                const remaining = endTimestamp - performance.now();
                applyFade(remaining);
            }
        });

        soundSelect.addEventListener('change', function() {
            if (running) startAudio();
        });

        // Init
        display.textContent = format(durationMs);

        return { startPause, reset, preset, setCustom };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Sleep Timer — Drift Off Without Worrying About the Clock",
  "description": "Browser sleep timer with built-in white, pink, brown, rain, and ocean noise. Audio fades out gracefully in the last two minutes so it does not wake you.",
  "url": "<?php echo esc_url(home_url('/sleep-timer/')); ?>",
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
