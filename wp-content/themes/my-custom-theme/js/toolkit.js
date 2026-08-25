/**
 * BT Toolkit — shared enhancement layer for every interactive tool.
 *
 * One small file, loaded sitewide (deferred), giving each tool the features
 * that used to be implemented ad-hoc (or not at all):
 *
 *   BT.beep()        — WebAudio chime (no asset needed) for completion/alerts.
 *   BT.keepAwake()   — Screen Wake Lock while a timer runs, so phones and
 *                      laptops do not sleep mid-countdown. Re-acquired on
 *                      visibility change; silently ignored where unsupported.
 *   BT.announce()    — polite aria-live announcement for phase changes
 *                      ("Work period complete") for screen-reader users.
 *   BT.title()       — tab-title countdown prefix with strip support.
 *   BT.bindKeys()    — the standard keyboard-shortcut guard set (skip when
 *                      typing or when a button/link has focus).
 *
 * Every helper is defensive: pages call them without checking support, and
 * nothing throws if an API is missing. Tools keep their own logic; this file
 * never auto-binds to the DOM, so it cannot collide with page scripts.
 */
(function () {
    'use strict';

    var baseTitle = null;
    var wakeLock = null;
    var liveRegion = null;

    var TITLE_PREFIX = /^\d{1,3}:\d{2}(:\d{2})?(\.\d{1,3})?\s+—\s+/;

    function stripTitle() {
        if (baseTitle === null) baseTitle = document.title.replace(TITLE_PREFIX, '');
        return baseTitle;
    }

    var BT = {
        /**
         * Two-tone completion chime (E6 → A6). Volume ramps in and out so
         * there is no click. Mirrors the fallback beep used by the timer
         * engines, but richer — used by tools that had no sound at all.
         */
        beep: function () {
            try {
                var AC = window.AudioContext || window.webkitAudioContext;
                if (!AC) return;
                var ac = new AC();
                var now = ac.currentTime;
                [1318.5, 1760].forEach(function (freq, i) {
                    var o = ac.createOscillator();
                    var g = ac.createGain();
                    o.connect(g);
                    g.connect(ac.destination);
                    o.type = 'sine';
                    o.frequency.value = freq;
                    var t0 = now + i * 0.18;
                    g.gain.setValueAtTime(0.0001, t0);
                    g.gain.exponentialRampToValueAtTime(0.12, t0 + 0.02);
                    g.gain.exponentialRampToValueAtTime(0.0001, t0 + 0.35);
                    o.start(t0);
                    o.stop(t0 + 0.4);
                });
                setTimeout(function () { ac.close(); }, 1200);
            } catch (e) { /* WebAudio unavailable */ }
        },

        /**
         * Hold a screen wake lock while a tool runs. Call with true when the
         * timer starts, false when it pauses/completes/resets.
         */
        keepAwake: function (on) {
            BT.wantsWakeLock = !!on;
            if (!('wakeLock' in navigator)) return;
            if (on) {
                navigator.wakeLock.request('screen').then(function (lock) {
                    wakeLock = lock;
                    wakeLock.addEventListener('release', function () {
                        wakeLock = null;
                    });
                }).catch(function () { /* denied or unsupported — ignore */ });
            } else if (wakeLock) {
                wakeLock.release().catch(function () {});
                wakeLock = null;
            }
        },

        /** True while a tool has requested a wake lock (set by keepAwake). */
        wantsWakeLock: false,

        /**
         * Announce a phase change to assistive tech via a polite live region.
         */
        announce: function (message) {
            if (!liveRegion) {
                liveRegion = document.createElement('div');
                liveRegion.setAttribute('aria-live', 'polite');
                liveRegion.setAttribute('role', 'status');
                liveRegion.className = 'sr-only';
                document.body.appendChild(liveRegion);
            }
            liveRegion.textContent = '';
            // Setting text in a fresh frame re-triggers the announcement.
            setTimeout(function () { liveRegion.textContent = message; }, 30);
        },

        /**
         * Show a countdown in the tab title: BT.title('04:59'). Call with no
         * args (or '') to restore the page's base title.
         */
        title: function (prefix) {
            if (!prefix) {
                document.title = stripTitle();
                return;
            }
            document.title = prefix + ' — ' + stripTitle();
        },

        /**
         * Standard key handler guard: true when the event target is a text
         * field or an interactive control, i.e. when a shortcut must NOT fire.
         */
        keysBlocked: function (e) {
            var el = e.target;
            if (!el) return true;
            var tag = (el.tagName || '').toLowerCase();
            if (tag === 'input' || tag === 'textarea' || tag === 'select') return true;
            if (el.isContentEditable) return true;
            if (tag === 'button' || tag === 'a' || tag === 'summary') return true;
            if (el.getAttribute && el.getAttribute('role') === 'button') return true;
            return false;
        }
    };

    // Re-acquire the wake lock when the tab becomes visible again while a
    // tool still considers itself running (the lock auto-releases on hide).
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible' && wakeLock === null && BT.wantsWakeLock) {
            BT.keepAwake(true);
        }
    });

    window.BT = BT;
})();
