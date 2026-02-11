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

            // Custom input change
            if (this.customInput) {
                this.customInput.addEventListener('change', function() {
                    var val = parseInt(self.customInput.value, 10);
                    if (isNaN(val) || val < 1) val = 1;
                    if (val > 100) val = 100;
                    self.customInput.value = val;

                    // Check unit
                    var activeUnit = document.querySelector('.timer-unit-toggle button.active');
                    var unit = activeUnit ? activeUnit.getAttribute('data-unit') : 'minutes';
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

            this.saveState();

            this.intervalId = setInterval(function() {
                self.tick();
            }, 100); // check every 100ms for smooth updates
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

            this.updateDisplay(this.durationSeconds);
            this.updateProgress(1);
            this.startBtn.textContent = 'Start';
            if (this.completeBanner) this.completeBanner.classList.remove('visible');
            this.display.classList.remove('timer-complete');
            document.title = document.title.replace(/^\d{2}:\d{2} — /, '');
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

            // Update document title
            var mins = Math.floor(remaining / 60);
            var secs = remaining % 60;
            var timeStr = String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
            var baseTitle = document.title.replace(/^\d{2}:\d{2} — /, '');
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

            // Restore document title
            document.title = document.title.replace(/^\d{2}:\d{2} — /, '');

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
            if (this.audio) {
                this.audio.currentTime = 0;
                this.audio.play().catch(function() {
                    // Browser autoplay policy — user gesture required
                });
            }
        },

        /**
         * Update the display digits.
         */
        updateDisplay: function(totalSeconds) {
            if (!this.display) return;
            var mins = Math.floor(totalSeconds / 60);
            var secs = totalSeconds % 60;
            this.display.textContent = String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
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
                        this.intervalId = setInterval(function() { self.tick(); }, 100);
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
                // Ignore when typing in inputs/textareas
                var tag = e.target.tagName.toLowerCase();
                if (tag === 'input' || tag === 'textarea' || tag === 'select') return;

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
            document.body.style.overflow = 'hidden';

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
            document.body.style.overflow = '';
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
