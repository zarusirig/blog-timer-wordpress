<?php
/**
 * Template Name: Pomodoro Timer Page
 * Description: Free Pomodoro timer with presets and session tracking
 */

get_header();

$loader = Timer_Content_Loader::get_instance();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1"><?php echo esc_html($loader->get_string('hub.pomodoro.h1')); ?></h1>
        <p class="page-intro"><?php echo esc_html($loader->get_string('hub.pomodoro.intro')); ?></p>
    </div>

    <!-- Hero Timer Widget -->
    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="1500"
             data-unit="minutes"
             data-value="25"
             data-mode="pomodoro">
            <div class="timer-display">25:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Pomodoro</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Pomodoro Complete!</h3>
                <p>Take a 5-minute break before your next session.</p>
                <button class="btn btn--success start-timer">Start Break</button>
            </div>
        </div>

        <!-- Pomodoro Presets -->
        <div class="pomodoro-presets">
            <h3 class="section-subtitle">Quick Presets</h3>
            <div class="timer-grid">
                <button class="btn btn--secondary pomodoro-preset" data-work="25" data-break="5">
                    <strong>Classic</strong>
                    <span>25 min work / 5 min break</span>
                </button>
                <button class="btn btn--secondary pomodoro-preset" data-work="50" data-break="10">
                    <strong>Extended</strong>
                    <span>50 min work / 10 min break</span>
                </button>
                <button class="btn btn--secondary pomodoro-preset" data-work="45" data-break="15">
                    <strong>Deep Focus</strong>
                    <span>45 min work / 15 min break</span>
                </button>
            </div>
        </div>

        <!-- Session Counter -->
        <div class="pomodoro-session-count">
            <h4>Sessions Completed Today: <span class="session-count-number">0</span></h4>
            <button class="btn btn--secondary reset-sessions">Reset Sessions</button>
        </div>
    </div>

    <!-- What Is Pomodoro -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">What Is the Pomodoro Technique?</h2>
            <p>The Pomodoro Technique is a time management method developed by Francesco Cirillo in the late 1980s while he was a university student in Italy. Struggling to focus on his studies and feeling overwhelmed by assignments, Cirillo challenged himself to commit to just ten minutes of focused study time. He found a tomato-shaped kitchen timer, which in Italian is called a "pomodoro," and the iconic productivity method was born.</p>

            <p>The technique is elegantly simple: break your work into focused intervals of 25 minutes, separated by short breaks. Each 25-minute work session is called a "pomodoro." After completing four pomodoros, you take a longer break of 15 to 30 minutes. This rhythm creates a sustainable workflow that prevents burnout while maximizing productivity.</p>

            <p>What makes the Pomodoro Technique so effective is its ability to transform abstract tasks into concrete time-bound intervals. The 25-minute limit creates a sense of urgency that helps you overcome procrastination and maintain laser focus. The regular breaks ensure your mind stays fresh and prevent decision fatigue. The tomato timer became a physical representation of commitment to focused work, and decades later, millions of people worldwide use this method to accomplish their most important tasks.</p>

            <p>Unlike vague productivity advice to "work harder" or "focus better," Pomodoro gives you a clear, actionable structure. The ticking timer creates accountability. The defined endpoint makes even daunting projects feel manageable. And the frequent breaks reward your brain, making it easier to return to challenging work with renewed energy and clarity.</p>
        </div>
    </section>

    <!-- How It Works -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">How the Pomodoro Technique Works</h2>
            <p class="section-subtitle">Follow these six steps to implement the Pomodoro method effectively</p>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Choose Your Task</h3>
                    <p>Select a specific task or project you want to work on. Write it down to clarify your intention. If the task will take more than four pomodoros, break it into smaller, actionable components. Clear task definition is the foundation of productive pomodoro sessions.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Set the Timer</h3>
                    <p>Set the timer for 25 minutes using our pomodoro timer above. This creates a time boundary that helps you commit fully to the task. The timer serves as an external commitment device, making it easier to resist distractions and stay focused on your chosen work.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Work With Full Focus</h3>
                    <p>Work on your task with complete concentration until the timer rings. If a distraction pops into your head, quickly jot it down on paper and immediately return to your task. Protect your pomodoro from interruptions. This single-tasking approach is where the magic happens.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Take a Short Break</h3>
                    <p>When the timer rings, stop working immediately and take a 5-minute break. Step away from your workspace. Stretch, grab water, look out the window, or do breathing exercises. Avoid checking email or social media. This break is crucial for mental recovery and sustained productivity.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">5</div>
                    <h3>Mark Your Progress</h3>
                    <p>Put a checkmark on paper or use our session counter above to track your completed pomodoro. This visual record of progress provides motivation and helps you estimate how long different types of work actually take. Tracking builds self-awareness and improves future planning.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">6</div>
                    <h3>Take a Longer Break</h3>
                    <p>After completing four pomodoros, take a longer break of 15 to 30 minutes. This extended rest period allows your brain to consolidate learning, process information, and fully recharge. Use this time for a walk, light exercise, lunch, or genuine relaxation before starting your next set of pomodoros.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- The Science Behind Pomodoro -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Science Behind the Pomodoro Technique</h2>

            <p>Neuroscience research confirms what Francesco Cirillo discovered through trial and error: our brains work better in focused bursts with regular breaks. Studies on attention span show that sustained concentration naturally begins to wane after 20 to 30 minutes. The 25-minute pomodoro interval aligns perfectly with this cognitive rhythm, allowing you to harness your peak focus before mental fatigue sets in.</p>

            <p>The technique also leverages the psychological principle of timeboxing. When you know there is a defined endpoint, your brain releases dopamine and norepinephrine, neurochemicals that enhance focus and motivation. This creates a mild sense of urgency that helps you overcome the initial resistance to starting difficult tasks. The Zeigarnik effect explains why incomplete tasks stay on our minds, and completing discrete pomodoros provides regular psychological closure that reduces anxiety.</p>

            <p>Regular breaks are equally important from a neurological perspective. Research on cognitive performance demonstrates that brief diversions from a task can dramatically improve your ability to maintain focus on that task for prolonged periods. The breaks allow your prefrontal cortex to rest, preventing decision fatigue and maintaining high-quality output throughout your work session.</p>

            <p>Additionally, the Pomodoro Technique helps you enter flow states more reliably. By eliminating decision-making about when to work and when to break, you reduce cognitive load. The ritual of starting a timer becomes a trigger that signals to your brain it is time to focus. Over time, this conditioning makes it progressively easier to achieve deep concentration on demand.</p>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Pomodoro vs Other Time Management Techniques</h2>

            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Technique</th>
                        <th>Work Interval</th>
                        <th>Break Interval</th>
                        <th>Best For</th>
                        <th>Flexibility</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Pomodoro</strong></td>
                        <td>25 minutes</td>
                        <td>5 minutes (15-30 after 4 sessions)</td>
                        <td>Overcoming procrastination, maintaining focus</td>
                        <td>Structured, moderate</td>
                    </tr>
                    <tr>
                        <td><strong>Time Blocking</strong></td>
                        <td>60-120 minutes</td>
                        <td>Flexible</td>
                        <td>Deep work, complex projects</td>
                        <td>High, self-directed</td>
                    </tr>
                    <tr>
                        <td><strong>52-17 Rule</strong></td>
                        <td>52 minutes</td>
                        <td>17 minutes</td>
                        <td>Balancing productivity and rest</td>
                        <td>Moderate, rhythm-based</td>
                    </tr>
                    <tr>
                        <td><strong>Flowtime</strong></td>
                        <td>Until natural break point</td>
                        <td>Proportional to work time</td>
                        <td>Creative work, flow states</td>
                        <td>Very high, intuitive</td>
                    </tr>
                    <tr>
                        <td><strong>Timeboxing</strong></td>
                        <td>Varies by task</td>
                        <td>Not prescribed</td>
                        <td>Task completion, deadline management</td>
                        <td>Very high, task-driven</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Tips for Success -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Tips for Pomodoro Success</h2>

            <div class="highlight-box highlight-box--accent">
                <h3>Maximize Your Pomodoro Productivity</h3>
                <ul>
                    <li><strong>Eliminate distractions before starting:</strong> Put your phone on airplane mode, close unnecessary browser tabs, and tell colleagues you will be unavailable for 25 minutes. Creating a distraction-free environment is essential for true focus.</li>

                    <li><strong>Plan your pomodoros in advance:</strong> At the start of each day, list the specific tasks you will tackle during each pomodoro. This removes decision-making friction and ensures you make progress on important priorities rather than urgent busywork.</li>

                    <li><strong>Respect the break time:</strong> Never skip breaks, even when you feel motivated to continue. The breaks are not optional. They are what make the technique sustainable over hours and days. Your brain needs recovery time to maintain peak performance.</li>

                    <li><strong>Use breaks intentionally:</strong> Stand up, move your body, hydrate, and look at distant objects to rest your eyes. Avoid switching to other cognitively demanding tasks like checking email. True rest allows your subconscious to process the work you just completed.</li>

                    <li><strong>Track and reflect on your pomodoros:</strong> Keep a log of what you accomplish in each session. Over time, you will develop an intuitive sense of how long different types of work actually require, improving your planning and reducing overcommitment.</li>

                    <li><strong>Adjust for your work style:</strong> While 25 minutes is the classic interval, some people work better with 45 or 50-minute sessions. Experiment with different durations using our preset buttons above, but always maintain the core principle of focused work followed by genuine breaks.</li>

                    <li><strong>Batch similar tasks:</strong> Use consecutive pomodoros for related work to minimize context switching. For example, dedicate two pomodoros to writing, then two to responding to emails, rather than alternating between different types of tasks.</li>

                    <li><strong>Start small and build consistency:</strong> If you are new to Pomodoro, begin with just two or three sessions per day. As the habit becomes established, gradually increase to six or eight pomodoros daily. Consistency matters more than intensity when building productive routines.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Who Benefits Most -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Who Benefits Most from the Pomodoro Technique</h2>

            <p>The Pomodoro Technique is remarkably versatile, but certain groups find it especially transformative. Students preparing for exams benefit enormously from the structured study intervals. The technique prevents the common trap of marathon study sessions that produce diminishing returns. By breaking study time into focused 25-minute blocks, students retain information more effectively and avoid burnout during intensive preparation periods.</p>

            <p>Software developers and programmers often struggle with the tension between deep focus and frequent interruptions. Pomodoro sessions create protected time for complex problem-solving and coding, while the breaks provide natural moments to check messages and collaborate with teammates. The technique helps developers make consistent progress on challenging technical problems without sacrificing team communication.</p>

            <p>Writers and content creators face the unique challenge of maintaining creative flow while meeting deadlines. The Pomodoro method helps overcome the blank-page paralysis that derails writing projects. By committing to just 25 minutes of writing, the task feels less daunting. Many writers find they enter flow states during pomodoros and produce their best work when they know a break is coming soon.</p>

            <p>Remote workers and freelancers who manage their own schedules benefit from the external accountability the timer provides. Without the structure of an office environment, it is easy to drift between tasks or succumb to home distractions. Pomodoro sessions impose discipline and help remote workers maintain professional productivity standards while working independently.</p>

            <p>People who struggle with ADHD or attention challenges often discover that Pomodoro is uniquely compatible with how their brains work. The short intervals align with natural attention spans, the timer provides external structure, and the frequent breaks prevent the restlessness that undermines longer work sessions. The technique transforms abstract time into concrete, manageable chunks.</p>
        </div>
    </section>

    <!-- Related Timers -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Related Timers for Different Work Intervals</h2>
            <p class="section-subtitle">Try these timers for different productivity intervals</p>

            <div class="timer-grid">
                <?php
                $related_values = array(5, 15, 25, 30, 45, 50);
                foreach ($related_values as $value) {
                    $q = new WP_Query([
                        'post_type' => 'timer',
                        'posts_per_page' => 1,
                        'meta_query' => [
                            'relation' => 'AND',
                            ['key' => '_timer_value', 'value' => $value, 'type' => 'NUMERIC'],
                            ['key' => '_timer_unit', 'value' => 'minutes'],
                        ],
                        'no_found_rows' => true,
                    ]);
                    if ($q->have_posts()) {
                        blogtimer_render_timer_card([
                            'value' => $value,
                            'unit' => 'minutes',
                            'post' => $q->posts[0],
                        ]);
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Pomodoro Technique FAQ</h2>
            <?php echo blogtimer_render_faq($loader->get_pomodoro_faqs()); ?>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>Ready to Transform Your Productivity?</h2>
                <p>Join millions of people who use the Pomodoro Technique to accomplish more with less stress. Start your first pomodoro session now with our free timer.</p>
                <a href="#top" class="btn btn--primary btn--large">Start Pomodoro Timer</a>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sessionCountElement = document.querySelector('.session-count-number');
    const resetSessionsBtn = document.querySelector('.reset-sessions');
    const presetButtons = document.querySelectorAll('.pomodoro-preset');

    // Load session count from localStorage
    let sessionCount = parseInt(localStorage.getItem('pomodoroSessions') || '0');
    sessionCountElement.textContent = sessionCount;

    // Increment session count when timer completes
    document.addEventListener('timerComplete', function() {
        sessionCount++;
        sessionCountElement.textContent = sessionCount;
        localStorage.setItem('pomodoroSessions', sessionCount.toString());
    });

    // Reset sessions
    resetSessionsBtn.addEventListener('click', function() {
        sessionCount = 0;
        sessionCountElement.textContent = sessionCount;
        localStorage.setItem('pomodoroSessions', '0');
    });

    // Preset buttons
    presetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const workMinutes = parseInt(this.dataset.work);
            const breakMinutes = parseInt(this.dataset.break);
            const timerWidget = document.querySelector('.timer-widget--hero');
            const timerDisplay = timerWidget.querySelector('.timer-display');

            // Update timer
            timerWidget.dataset.duration = (workMinutes * 60).toString();
            timerWidget.dataset.value = workMinutes.toString();
            timerDisplay.textContent = workMinutes + ':00';

            // Reset timer if running
            const resetBtn = timerWidget.querySelector('.reset-timer');
            if (resetBtn.style.display !== 'none') {
                resetBtn.click();
            }

            // Visual feedback
            presetButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>

<?php get_footer(); ?>
