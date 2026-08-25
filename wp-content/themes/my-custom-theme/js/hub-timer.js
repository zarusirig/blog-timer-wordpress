/**
 * Shared Hub Timer Engine — The Blog Timer
 *
 * Drives the CLASS-BASED timer markup used by the niche hub pages
 * (egg-timer, coffee-timer, hiit-timer, pasta-timer, ...):
 *
 *   <div class="timer-widget" data-duration="360" data-mode="standard">
 *     <div class="timer-display">6:00</div>
 *     <div class="timer-progress"><div class="timer-progress-bar"></div></div>
 *     <div class="timer-controls">
 *       <button class="start-timer">Start</button>
 *       <button class="reset-timer" style="display:none;">Reset</button>
 *     </div>
 *     <div class="timer-complete-banner" style="display:none;">...</div>
 *   </div>
 *
 * These pages shipped this markup with NO JavaScript, so every Start button
 * was dead. This engine is enqueued ONLY on those pages (see functions.php),
 * so it never collides with the ID-based timer-widget.js or the bespoke
 * inline scripts on stopwatch/tabata/countdown/etc.
 *
 * Timestamp-based (survives tab sleep). Idempotent per widget.
 */
(function () {
    'use strict';

    function pad(n) { return String(n).padStart(2, '0'); }

    function format(total, useHours) {
        total = Math.max(0, Math.floor(total));
        var h = Math.floor(total / 3600);
        var m = Math.floor((total % 3600) / 60);
        var s = total % 60;
        return useHours ? (pad(h) + ':' + pad(m) + ':' + pad(s)) : (pad(m) + ':' + pad(s));
    }

    var TITLE_PREFIX = /^\d{1,3}:\d{2}\s+—\s+/;

    function stripTitle() {
        return document.title.replace(TITLE_PREFIX, '');
    }

    function initWidget(widget) {
        if (widget.getAttribute('data-hub-timer') === 'on') return;
        widget.setAttribute('data-hub-timer', 'on');

        var display = widget.querySelector('.timer-display');
        var startBtns = Array.prototype.slice.call(widget.querySelectorAll('.start-timer'));
        var resetBtn = widget.querySelector('.reset-timer');
        var progressBar = widget.querySelector('.timer-progress-bar');
        var banner = widget.querySelector('.timer-complete-banner');

        if (!display || startBtns.length === 0) return;

        var duration = parseInt(widget.getAttribute('data-duration'), 10);
        if (!duration || duration < 1) duration = 300;
        var useHours = duration >= 3600;

        var primaryBtn = startBtns[0];
        var primaryLabel = (primaryBtn.textContent || 'Start').trim();

        var running = false, complete = false, endTs = null, remaining = duration, intervalId = null;

        // Audio: localized URL if present, else a short WebAudio beep.
        var audio = null;
        var audioUrl = (typeof blogTimerData !== 'undefined' && blogTimerData.audioUrl) ? blogTimerData.audioUrl : '';
        function ensureAudio() { if (!audio && audioUrl) { try { audio = new Audio(audioUrl); audio.preload = 'auto'; } catch (e) {} } }
        function playSound() {
            ensureAudio();
            if (audio) { try { audio.currentTime = 0; audio.play().catch(function () {}); return; } catch (e) {} }
            var AC = window.AudioContext || window.webkitAudioContext;
            if (AC) {
                try {
                    var ac = new AC(), o = ac.createOscillator(), g = ac.createGain();
                    o.connect(g); g.connect(ac.destination);
                    o.type = 'sine'; o.frequency.value = 880; g.gain.value = 0.12;
                    o.start();
                    setTimeout(function () { o.stop(); ac.close(); }, 600);
                } catch (e) {}
            }
        }

        function render(rem) {
            display.textContent = format(rem, useHours);
            if (progressBar) progressBar.style.width = (Math.max(0, Math.min(1, rem / duration)) * 100) + '%';
        }
        function setPrimary(text) { primaryBtn.textContent = text; }

        function start() {
            ensureAudio();
            endTs = Date.now() + remaining * 1000;
            running = true; complete = false;
            setPrimary('Pause');
            if (resetBtn) resetBtn.style.display = '';
            if (banner) banner.style.display = 'none';
            display.classList.remove('timer-complete');
            if (window.BT) BT.keepAwake(true);
            clearInterval(intervalId);
            intervalId = setInterval(tick, 200);
        }
        function pause() {
            running = false;
            remaining = Math.max(0, Math.ceil((endTs - Date.now()) / 1000));
            endTs = null;
            clearInterval(intervalId);
            if (window.BT) BT.keepAwake(false);
            setPrimary('Resume');
        }
        function reset() {
            running = false; complete = false; endTs = null;
            clearInterval(intervalId);
            if (window.BT) BT.keepAwake(false);
            // Re-read data-duration: preset buttons (e.g. the Pomodoro 50/10
            // preset) rewrite the attribute after this engine initialized.
            var attrDuration = parseInt(widget.getAttribute('data-duration'), 10);
            if (attrDuration && attrDuration > 0) duration = attrDuration;
            remaining = duration;
            render(duration);
            setPrimary(primaryLabel);
            if (resetBtn) resetBtn.style.display = 'none';
            if (banner) banner.style.display = 'none';
            display.classList.remove('timer-complete');
            document.title = stripTitle();
        }
        function finish() {
            running = false; complete = true; endTs = null; remaining = 0;
            clearInterval(intervalId);
            render(0);
            display.classList.add('timer-complete');
            setPrimary('Restart');
            if (banner) banner.style.display = '';
            document.title = stripTitle();
            if (window.BT) {
                BT.keepAwake(false);
                BT.announce('Timer complete');
            }
            playSound();
            // Same contract as timer-widget.js: pages (e.g. the Pomodoro
            // session counter) listen for this to react to completion.
            document.dispatchEvent(new CustomEvent('timerComplete'));
        }
        function tick() {
            if (!running || !endTs) return;
            var rem = Math.max(0, Math.ceil((endTs - Date.now()) / 1000));
            render(rem);
            if (rem > 0) {
                document.title = pad(Math.floor(rem / 60)) + ':' + pad(rem % 60) + ' — ' + stripTitle();
            }
            if (rem <= 0) finish();
        }
        function onPrimary() {
            if (complete) { reset(); start(); return; }
            if (running) pause(); else start();
        }

        primaryBtn.addEventListener('click', onPrimary);
        // Extra start buttons (e.g. "Start Break" / "Start Next Round" inside
        // the complete banner) restart the interval — honoring an optional
        // data-duration on the button itself so a follow-up phase can run a
        // different length than the phase that just finished.
        for (var i = 1; i < startBtns.length; i++) {
            startBtns[i].addEventListener('click', function () {
                var d = parseInt(this.getAttribute('data-duration'), 10);
                if (d && d > 0) widget.setAttribute('data-duration', String(d));
                reset();
                start();
            });
        }
        if (resetBtn) resetBtn.addEventListener('click', reset);

        // Keyboard: Space toggles, R resets. Ignored while typing in a field OR
        // while another interactive control (button/link/etc.) is focused so the
        // shortcut never hijacks Space meant for FAQ toggles, cookie banner, etc.
        widget.setAttribute('tabindex', widget.getAttribute('tabindex') || '-1');
        document.addEventListener('keydown', function (e) {
            var tag = (e.target.tagName || '').toLowerCase();
            if (tag === 'input' || tag === 'textarea' || tag === 'select') return;
            if (e.target.isContentEditable) return;
            var isInteractive = tag === 'button' || tag === 'a' || tag === 'summary' ||
                e.target.getAttribute('role') === 'button';
            if (isInteractive) return;
            if (e.code === 'Space') { e.preventDefault(); onPrimary(); }
            else if (e.code === 'KeyR') { e.preventDefault(); reset(); }
        });

        render(duration);
        if (resetBtn) resetBtn.style.display = 'none';
    }

    function initAll() {
        var widgets = document.querySelectorAll('.timer-widget');
        Array.prototype.forEach.call(widgets, function (w) {
            // Only class-based widgets (have a .start-timer button). ID-based widgets
            // belong to timer-widget.js, which is never enqueued alongside this file.
            if (w.querySelector('.start-timer')) initWidget(w);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
