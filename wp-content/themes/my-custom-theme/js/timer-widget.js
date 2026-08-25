/**
 * Timer Widget Engine — The Blog Timer
 *
 * Timestamp-based countdown (handles tab sleep correctly).
 * Features: Start/Pause toggle, Reset, timer name input, custom duration,
 *           localStorage persistence, audio alert, document title update.
 */

(function() {
    'use strict';

    var BlogTimer = {
        // State
        isRunning: false,
        endTimestamp: null,
        durationSeconds: 300, // default 5 min
        remainingAtPause: null,
        intervalId: null,
        audio: null,
        isComplete: false,

        // DOM elements (resolved in init)
        display: null,
        startBtn: null,
        resetBtn: null,
        progressBar: null,
        nameInput: null,
        completeBanner: null,
        replayBtn: null,
        customInput: null,
        unitToggle: null,

        /**
         * Initialize the timer.
         */
        init: function() {
            // Find timer widget
            var widget = document.querySelector('.timer-widget');
            if (!widget) return;

            // Resolve DOM elements
            this.display = document.getElementById('timer-display');
            this.startBtn = document.getElementById('timer-start');
            this.resetBtn = document.getElementById('timer-reset');
            this.progressBar = document.getElementById('timer-progress-bar');
            this.nameInput = document.getElementById('timer-name');
            this.completeBanner = document.getElementById('timer-complete-banner');
            this.replayBtn = document.getElementById('timer-replay-sound');
            this.customInput = document.getElementById('timer-custom-value');
            this.unitToggle = document.querySelectorAll('.timer-unit-toggle button');

            if (!this.display || !this.startBtn || !this.resetBtn) return;

            // Read duration from widget data attribute
            var dataDuration = widget.getAttribute('data-duration');
            if (dataDuration) {
                this.durationSeconds = parseInt(dataDuration, 10);
            } else if (typeof blogTimerData !== 'undefined' && blogTimerData.durationSeconds) {
                this.durationSeconds = blogTimerData.durationSeconds;
            }

            // Set initial remaining
            this.remainingAtPause = this.durationSeconds;

            // Pre-load audio
            this.initAudio();

            // Bind events
            this.bindEvents();

            // Restore state from localStorage
            this.restoreState();

            // Initial display update
            if (!this.isRunning) {
                this.updateDisplay(this.remainingAtPause || this.durationSeconds);
            }
        },

        /**
         * Initialize audio element.
         */
        initAudio: function() {
            var audioUrl = (typeof blogTimerData !== 'undefined' && blogTimerData.audioUrl)
                ? blogTimerData.audioUrl
                : '';
            if (audioUrl) {
                this.audio = new Audio(audioUrl);
                this.audio.preload = 'auto';
            }
        },

        /**
         * Bind UI event listeners.
         */
        bindEvents: function() {
            var self = this;

            this.startBtn.addEventListener('click', function() {
                if (self.isComplete) {
                    self.reset();
                    return;
                }
                if (self.isRunning) {
                    self.pause();
                } else {
                    self.start();
                }
            });

            this.resetBtn.addEventListener('click', function() {
                self.reset();
            });

            if (this.replayBtn) {
                this.replayBtn.addEventListener('click', function() {
                    self.playSound();
                });
            }

            // Custom input change. Clamp by unit so the homepage tool matches the
            // advertised range (1 second to 161 minutes), not a flat cap of 100.
            if (this.customInput) {
                this.customInput.addEventListener('change', function() {
                    var activeUnit = document.querySelector('.timer-unit-toggle button.active');
                    var unit = activeUnit ? activeUnit.getAttribute('data-unit') : 'minutes';
                    var max = unit === 'minutes' ? 161 : 60;
                    var val = parseInt(self.customInput.value, 10);
                    if (isNaN(val) || val < 1) val = 1;
                    if (val > max) val = max;
                    self.customInput.value = val;

                    var newDuration = unit === 'minutes' ? val * 60 : val;
                    self.setDuration(newDuration);
                });
            }

            // Unit toggle
            if (this.unitToggle.length > 0) {
                this.unitToggle.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        self.unitToggle.forEach(function(b) { b.classList.remove('active'); });
                        btn.classList.add('active');
                        // Re-apply custom value with new unit
                        if (self.customInput) {
                            var val = parseInt(self.customInput.value, 10) || 5;
                            var unit = btn.getAttribute('data-unit');
                            var newDuration = unit === 'minutes' ? val * 60 : val;
                            self.setDuration(newDuration);
                        }
                    });
                });
            }

            // Timer name persistence
            if (this.nameInput) {
                // Restore name
                var savedName = localStorage.getItem('blogtimer_name');
                if (savedName) this.nameInput.value = savedName;

                this.nameInput.addEventListener('input', function() {
                    localStorage.setItem('blogtimer_name', self.nameInput.value);
                });
            }
        },

        /**
         * Set a new duration (in seconds) and reset.
         */
        setDuration: function(seconds) {
            this.durationSeconds = seconds;
            this.remainingAtPause = seconds;
            this.isRunning = false;
            this.isComplete = false;
            this.endTimestamp = null;
            clearInterval(this.intervalId);
            if (window.BT) BT.keepAwake(false);
            this.updateDisplay(seconds);
            this.updateProgress(1);
            this.startBtn.textContent = 'Start';
            if (this.completeBanner) this.completeBanner.classList.remove('visible');
            this.display.classList.remove('timer-complete');
            this.clearState();
        },

        /**
         * Start the countdown.
         */
        start: function() {
            var self = this;
            var remaining = this.remainingAtPause || this.durationSeconds;
            this.endTimestamp = Date.now() + (remaining * 1000);
            this.isRunning = true;
            this.isComplete = false;

            this.startBtn.textContent = 'Pause';
            if (this.completeBanner) this.completeBanner.classList.remove('visible');
            this.display.classList.remove('timer-complete');

            // Keep the screen awake while counting down (phones/tablets).
            if (window.BT) BT.keepAwake(true);

            this.saveState();

            this.intervalId = setInterval(function() {
                self.tick();
            }, 250); // 250ms — smooth for a seconds-precision display, lighter on CPU/battery
        },

        /**
         * Pause the countdown.
         */
        pause: function() {
            this.isRunning = false;
            var remaining = Math.max(0, Math.ceil((this.endTimestamp - Date.now()) / 1000));
            this.remainingAtPause = remaining;
            this.endTimestamp = null;
            clearInterval(this.intervalId);

            if (window.BT) BT.keepAwake(false);

            this.startBtn.textContent = 'Start';
            this.saveState();
        },

        /**
         * Reset the countdown.
         */
        reset: function() {
            this.isRunning = false;
            this.isComplete = false;
            this.endTimestamp = null;
            this.remainingAtPause = this.durationSeconds;
            clearInterval(this.intervalId);
            if (window.BT) BT.keepAwake(false);

            this.updateDisplay(this.durationSeconds);
            this.updateProgress(1);
            this.startBtn.textContent = 'Start';
            if (this.completeBanner) this.completeBanner.classList.remove('visible');
            this.display.classList.remove('timer-complete');
            document.title = this.stripTitlePrefix();
            this.clearState();
        },

        /**
         * Timer tick — called every 100ms.
         */
        tick: function() {
            if (!this.isRunning || !this.endTimestamp) return;

            var now = Date.now();
            var remaining = Math.max(0, Math.ceil((this.endTimestamp - now) / 1000));

            this.updateDisplay(remaining);
            this.updateProgress(remaining / this.durationSeconds);

            // Update document title (HH:MM:SS for >=1h so the strip regex always matches)
            var timeStr = this.titleTimeFormat(remaining);
            var baseTitle = this.stripTitlePrefix();
            if (remaining > 0) {
                document.title = timeStr + ' — ' + baseTitle;
            }

            // Sync fullscreen display
            if (this.isFullscreen && this.fullscreenDisplay) {
                this.fullscreenDisplay.textContent = this.display.textContent;
            }

            if (remaining <= 0) {
                this.complete();
            }
        },

        /**
         * Timer completion.
         */
        complete: function() {
            this.isRunning = false;
            this.isComplete = true;
            clearInterval(this.intervalId);

            this.display.classList.add('timer-complete');
            this.startBtn.textContent = 'Restart';
            if (this.completeBanner) this.completeBanner.classList.add('visible');

            if (window.BT) {
                BT.keepAwake(false);
                BT.announce('Timer complete');
            }

            // Restore document title
            document.title = this.stripTitlePrefix();

            this.playSound();
            this.clearState();

            // Update fullscreen display if active
            if (this.fullscreenDisplay) {
                this.fullscreenDisplay.textContent = '00:00';
                this.fullscreenDisplay.classList.add('timer-complete');
            }

            // Dispatch custom event for Pomodoro session tracking
            document.dispatchEvent(new CustomEvent('timerComplete'));

            // Increment Pomodoro session count if applicable
            var sessionsEl = document.getElementById('pomodoro-sessions');
            if (sessionsEl) {
                var count = parseInt(sessionsEl.textContent, 10) || 0;
                sessionsEl.textContent = count + 1;
            }
        },

        /**
         * Play completion sound.
         */
        playSound: function() {
            var self = this;
            if (this.audio) {
                this.audio.currentTime = 0;
                this.audio.play().catch(function() {
                    // Browser autoplay policy / load failure — fall back to WebAudio beep.
                    self.beep();
                });
            } else {
                self.beep();
            }
        },

        /**
         * WebAudio fallback beep (no asset needed). Mirrors hub-timer.js.
         */
        beep: function() {
            try {
                var AC = window.AudioContext || window.webkitAudioContext;
                if (!AC) return;
                var ac = new AC(), o = ac.createOscillator(), g = ac.createGain();
                o.connect(g); g.connect(ac.destination);
                o.type = 'sine'; o.frequency.value = 880; g.gain.value = 0.12;
                o.start();
                setTimeout(function() { o.stop(); ac.close(); }, 600);
            } catch (e) { /* WebAudio unavailable */ }
        },

        /**
         * Format remaining seconds for the document title.
         * Uses HH:MM:SS for >=1h durations so the strip regex always matches
         * (the old MM:SS builder produced 3-digit minutes for >=1h, which broke
         * the strip and made the title accumulate a new prefix every tick).
         */
        titleTimeFormat: function(totalSeconds) {
            totalSeconds = Math.max(0, Math.floor(totalSeconds));
            var useHours = (this.durationSeconds >= 3600) || (totalSeconds >= 3600);
            function p(n) { return String(n).padStart(2, '0'); }
            if (useHours) {
                return p(Math.floor(totalSeconds / 3600)) + ':' +
                       p(Math.floor((totalSeconds % 3600) / 60)) + ':' +
                       p(totalSeconds % 60);
            }
            return p(Math.floor(totalSeconds / 60)) + ':' + p(totalSeconds % 60);
        },

        /**
         * Remove any leading "MM:SS — " / "HH:MM:SS — " countdown prefix from the title.
         */
        stripTitlePrefix: function() {
            return document.title.replace(/^\d{1,3}:\d{2}(:\d{2})? — /, '');
        },

        /**
         * Update the display digits.
         */
        updateDisplay: function(totalSeconds) {
            if (!this.display) return;
            totalSeconds = Math.max(0, Math.floor(totalSeconds));
            // Use HH:MM:SS when the original duration was an hour or longer,
            // so display format stays stable as the countdown ticks toward zero.
            var useHours = (this.durationSeconds >= 3600) || (totalSeconds >= 3600);
            if (useHours) {
                var hrs = Math.floor(totalSeconds / 3600);
                var mins = Math.floor((totalSeconds % 3600) / 60);
                var secs = totalSeconds % 60;
                this.display.textContent =
                    String(hrs).padStart(2, '0') + ':' +
                    String(mins).padStart(2, '0') + ':' +
                    String(secs).padStart(2, '0');
            } else {
                var mins2 = Math.floor(totalSeconds / 60);
                var secs2 = totalSeconds % 60;
                this.display.textContent = String(mins2).padStart(2, '0') + ':' + String(secs2).padStart(2, '0');
            }
        },

        /**
         * Update the progress bar.
         */
        updateProgress: function(fraction) {
            if (!this.progressBar) return;
            this.progressBar.style.width = (Math.max(0, Math.min(1, fraction)) * 100) + '%';
        },

        /**
         * Save state to localStorage for persistence.
         */
        saveState: function() {
            try {
                localStorage.setItem('blogtimer_state', JSON.stringify({
                    endTimestamp: this.endTimestamp,
                    durationSeconds: this.durationSeconds,
                    remainingAtPause: this.remainingAtPause,
                    isRunning: this.isRunning,
                    url: window.location.pathname,
                }));
            } catch (e) { /* localStorage full or unavailable */ }
        },

        /**
         * Restore state from localStorage.
         */
        restoreState: function() {
            try {
                var saved = localStorage.getItem('blogtimer_state');
                if (!saved) return;

                var state = JSON.parse(saved);

                // Only restore if on the same page
                if (state.url !== window.location.pathname) {
                    this.clearState();
                    return;
                }

                this.durationSeconds = state.durationSeconds;

                if (state.isRunning && state.endTimestamp) {
                    var remaining = Math.max(0, Math.ceil((state.endTimestamp - Date.now()) / 1000));
                    if (remaining > 0) {
                        this.endTimestamp = state.endTimestamp;
                        this.isRunning = true;
                        this.startBtn.textContent = 'Pause';
                        var self = this;
                        if (window.BT) BT.keepAwake(true);
                        this.intervalId = setInterval(function() { self.tick(); }, 250);
                    } else {
                        // Timer already completed while away
                        this.complete();
                    }
                } else if (state.remainingAtPause) {
                    this.remainingAtPause = state.remainingAtPause;
                    this.updateDisplay(state.remainingAtPause);
                    this.updateProgress(state.remainingAtPause / state.durationSeconds);
                }
            } catch (e) {
                this.clearState();
            }
        },

        /**
         * Clear saved state.
         */
        clearState: function() {
            try { localStorage.removeItem('blogtimer_state'); } catch (e) {}
        },

        /**
         * Initialize keyboard shortcuts.
         * Space = start/pause, R = reset, F = fullscreen, Esc = exit fullscreen.
         */
        initKeyboardShortcuts: function() {
            var self = this;
            document.addEventListener('keydown', function(e) {
                // Ignore when typing in inputs/textareas/contenteditable
                var tag = e.target.tagName.toLowerCase();
                if (tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable) return;

                // Don't hijack Space/R/F while another interactive control is focused
                // (FAQ toggles, cookie banner, scroll-top, links, etc.) — let it act natively.
                var isInteractive = tag === 'button' || tag === 'a' || tag === 'summary' ||
                    e.target.getAttribute('role') === 'button';
                if (isInteractive && (e.code === 'Space' || e.code === 'KeyR' || e.code === 'KeyF')) return;

                switch (e.code) {
                    case 'Space':
                        e.preventDefault();
                        if (self.isComplete) {
                            self.reset();
                        } else if (self.isRunning) {
                            self.pause();
                        } else {
                            self.start();
                        }
                        break;
                    case 'KeyR':
                        e.preventDefault();
                        self.reset();
                        break;
                    case 'KeyF':
                        e.preventDefault();
                        self.enterFullscreen();
                        break;
                    case 'Escape':
                        if (self.isFullscreen) {
                            e.preventDefault();
                            self.exitFullscreen();
                        }
                        break;
                }
            });
        },

        // Fullscreen state
        isFullscreen: false,
        fullscreenOverlay: null,
        fullscreenDisplay: null,
        fullscreenCloseBtn: null,

        /**
         * Initialize fullscreen elements.
         */
        initFullscreen: function() {
            var self = this;
            this.fullscreenOverlay = document.getElementById('timer-fullscreen-overlay');
            this.fullscreenDisplay = document.getElementById('fullscreen-display');
            this.fullscreenCloseBtn = document.getElementById('fullscreen-close');

            var fullscreenBtn = document.getElementById('timer-fullscreen');
            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', function() {
                    self.enterFullscreen();
                });
            }

            if (this.fullscreenCloseBtn) {
                this.fullscreenCloseBtn.addEventListener('click', function() {
                    self.exitFullscreen();
                });
            }
        },

        /**
         * Enter fullscreen mode.
         */
        enterFullscreen: function() {
            if (!this.fullscreenOverlay) return;
            this.isFullscreen = true;
            this.fullscreenOverlay.classList.add('active');
            this.fullscreenOverlay.setAttribute('role', 'dialog');
            this.fullscreenOverlay.setAttribute('aria-modal', 'true');
            this.fullscreenOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            // Move focus into the dialog (close button) for keyboard/SR users.
            if (this.fullscreenCloseBtn) this.fullscreenCloseBtn.focus();

            // Sync current display
            if (this.fullscreenDisplay && this.display) {
                this.fullscreenDisplay.textContent = this.display.textContent;
                if (this.isComplete) {
                    this.fullscreenDisplay.classList.add('timer-complete');
                } else {
                    this.fullscreenDisplay.classList.remove('timer-complete');
                }
            }
        },

        /**
         * Exit fullscreen mode.
         */
        exitFullscreen: function() {
            if (!this.fullscreenOverlay) return;
            this.isFullscreen = false;
            this.fullscreenOverlay.classList.remove('active');
            this.fullscreenOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            // Return focus to the trigger so keyboard users keep their place.
            var trigger = document.getElementById('timer-fullscreen');
            if (trigger) trigger.focus();
        }
    };

    // Expose globally for Pomodoro preset integration
    window.BlogTimer = BlogTimer;

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        BlogTimer.init();
        BlogTimer.initKeyboardShortcuts();
        BlogTimer.initFullscreen();
    });
})();
