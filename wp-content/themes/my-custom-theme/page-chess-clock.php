<?php
/**
 * Template Name: Chess Clock Page
 * Description: Two-player chess clock timer
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Chess Clock — Two-Player Timer</h1>
        <p class="page-intro">A simple two-player countdown clock for chess, board games, debates, and any turn-based activity. Each player controls their own time.</p>
    </div>

    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin:var(--space-8) 0;">
            <div class="timer-widget" id="player1-clock" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:3px solid var(--color-primary);">
                <p style="font-size:var(--text-sm);text-transform:uppercase;letter-spacing:0.1em;color:var(--color-text-muted);margin-bottom:var(--space-3);">Player 1</p>
                <div class="timer-display" id="p1-display" style="font-size:clamp(3rem,8vw,6rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);">10:00</div>
                <button class="btn btn--primary btn--large" id="p1-btn" style="margin-top:var(--space-4);width:100%;" onclick="chessClock.tap(1)">Tap to Start / End Turn</button>
            </div>
            <div class="timer-widget" id="player2-clock" style="text-align:center;padding:var(--space-6);background:var(--color-surface);border-radius:var(--radius-lg);border:3px solid var(--color-text-muted);">
                <p style="font-size:var(--text-sm);text-transform:uppercase;letter-spacing:0.1em;color:var(--color-text-muted);margin-bottom:var(--space-3);">Player 2</p>
                <div class="timer-display" id="p2-display" style="font-size:clamp(3rem,8vw,6rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-text-muted);">10:00</div>
                <button class="btn btn--secondary btn--large" id="p2-btn" style="margin-top:var(--space-4);width:100%;" disabled>Waiting...</button>
            </div>
        </div>

        <div style="text-align:center;margin-bottom:var(--space-8);">
            <button class="btn btn--secondary" onclick="chessClock.reset()" style="margin-right:var(--space-3);">Reset Clock</button>
        </div>

        <div class="pomodoro-presets">
            <h3 class="section-subtitle">Time Control Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary" onclick="chessClock.setTime(60)"><strong>Bullet</strong><span>1 minute</span></button>
                <button class="btn btn--secondary" onclick="chessClock.setTime(180)"><strong>Blitz</strong><span>3 minutes</span></button>
                <button class="btn btn--secondary" onclick="chessClock.setTime(300)"><strong>Blitz</strong><span>5 minutes</span></button>
                <button class="btn btn--secondary" onclick="chessClock.setTime(600)"><strong>Rapid</strong><span>10 minutes</span></button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How to Use the Chess Clock</h2>
            <p>Select your time control from the presets above. Player 1 presses their button to start the clock and begin Player 2's timer at the end of each turn. The clock automatically switches between players with each tap. When a player's time runs out, the game is over by time forfeit.</p>

            <p>This chess clock works for any turn-based game or activity where each participant has a personal time budget: chess, checkers, Go, Scrabble, debate rounds, or any meeting where you want to ensure equal speaking time.</p>

            <h2 class="section-title">Chess Time Controls Explained</h2>

            <h3>Bullet Chess (1-2 minutes)</h3>
            <p>The fastest chess format. Each player has 1-2 minutes for the entire game, forcing rapid intuitive play. Mistakes are common but the pace is thrilling. Not recommended for learning — the time pressure prevents thoughtful analysis.</p>

            <h3>Blitz Chess (3-5 minutes)</h3>
            <p>The most popular online chess format. 3-5 minutes per player allows for some tactical thinking while maintaining high energy. Most competitive online platforms use 3+2 (3 minutes plus 2-second increment per move) or 5+0 (5 minutes flat) as standard blitz controls.</p>

            <h3>Rapid Chess (10-25 minutes)</h3>
            <p>Rapid chess strikes the balance between speed and quality. With 10-15 minutes per player, games are substantial enough to play complete openings and middlegames without feeling rushed. This format is ideal for casual competitive play and learning new openings.</p>

            <h3>Classical Chess (30+ minutes)</h3>
            <p>Standard tournament chess uses 30+ minutes per player, with some championship games lasting 6+ hours. At these time controls, deep strategic thinking and endgame precision become decisive factors. Use a custom 30 or 45-minute setting for classical study games.</p>
        </div>
    </section>

    <script>
    const chessClock = (function() {
        let times = [600, 600]; // default 10 minutes in seconds
        let active = -1; // -1 = not started, 0 = player 1, 1 = player 2
        let interval = null;
        let displays = [document.getElementById('p1-display'), document.getElementById('p2-display')];
        let buttons = [document.getElementById('p1-btn'), document.getElementById('p2-btn')];
        let clocks = [document.getElementById('player1-clock'), document.getElementById('player2-clock')];

        function formatTime(s) {
            const m = Math.floor(s / 60);
            const sec = s % 60;
            return m + ':' + (sec < 10 ? '0' : '') + sec;
        }

        function updateDisplays() {
            displays[0].textContent = formatTime(times[0]);
            displays[1].textContent = formatTime(times[1]);
        }

        function tap(player) {
            const p = player - 1;
            if (active === p) {
                // Switch to other player
                clearInterval(interval);
                active = 1 - p;
                startTicking();
                updateActiveUI();
            } else if (active === -1) {
                // Start for first time - player 1 taps to start player 2's clock
                active = 1 - p;
                startTicking();
                updateActiveUI();
            }
        }

        function startTicking() {
            interval = setInterval(function() {
                if (times[active] <= 0) {
                    clearInterval(interval);
                    displays[active].textContent = '0:00';
                    displays[active].style.color = '#ef4444';
                    buttons[active].textContent = 'Time\'s Up!';
                    return;
                }
                times[active]--;
                displays[active].textContent = formatTime(times[active]);
            }, 1000);
        }

        function updateActiveUI() {
            clocks[0].style.borderColor = active === 0 ? 'var(--color-primary)' : 'var(--color-text-muted)';
            clocks[1].style.borderColor = active === 1 ? 'var(--color-primary)' : 'var(--color-text-muted)';
            displays[0].style.color = active === 0 ? 'var(--color-primary)' : 'var(--color-text-muted)';
            displays[1].style.color = active === 1 ? 'var(--color-primary)' : 'var(--color-text-muted)';
            buttons[0].textContent = active === 0 ? 'Tap When Your Turn Ends' : 'Waiting...';
            buttons[1].textContent = active === 1 ? 'Tap When Your Turn Ends' : 'Waiting...';
            buttons[0].disabled = active !== 0;
            buttons[1].disabled = active !== 1;
            if (active === -1) {
                buttons[0].textContent = 'Tap to Start / End Turn';
                buttons[0].disabled = false;
            }
        }

        function reset() {
            clearInterval(interval);
            active = -1;
            times = [times[0], times[0]]; // preserve current time control
            updateDisplays();
            displays[0].style.color = 'var(--color-primary)';
            displays[1].style.color = 'var(--color-text-muted)';
            buttons[0].textContent = 'Tap to Start / End Turn';
            buttons[1].textContent = 'Waiting...';
            buttons[0].disabled = false;
            buttons[1].disabled = true;
            clocks[0].style.borderColor = 'var(--color-primary)';
            clocks[1].style.borderColor = 'var(--color-text-muted)';
        }

        function setTime(seconds) {
            times = [seconds, seconds];
            reset();
        }

        return { tap, reset, setTime };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<?php get_footer(); ?>
