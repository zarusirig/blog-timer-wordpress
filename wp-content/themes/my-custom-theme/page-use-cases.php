<?php
/**
 * Template Name: Use Cases Hub
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$related = Timer_Related::get_instance();

$icons = [
    'productivity' => 'P',
    'cooking' => 'C',
    'exercise' => 'E',
    'meditation' => 'M',
    'studying' => 'S',
];

$recommended = [
    'productivity' => [5, 10, 15, 25, 30, 45, 50, 60, 90],
    'cooking' => [1, 2, 3, 5, 8, 10, 12, 15, 20, 25, 30, 45, 60],
    'exercise' => [1, 3, 5, 7, 10, 15, 20, 30, 45],
    'meditation' => [5, 10, 15, 20, 30, 60],
    'studying' => [15, 20, 25, 30, 40, 45, 50, 60, 90],
];

$descriptions = [
    'productivity' => 'Time management is the foundation of productive work. Without defined boundaries, tasks expand to fill all available time -- a phenomenon known as Parkinson\'s Law. Timers counteract this tendency by creating artificial deadlines that force prioritization and maintain urgency. Whether you are a freelancer tracking billable hours, a developer working through a sprint, or a manager fitting tasks between meetings, timers give structure to your day. The most effective productivity timers range from 5-minute micro-bursts for clearing email to 90-minute deep work sessions for complex projects. Start with the Pomodoro standard of 25 minutes if you are unsure, then adjust based on your concentration patterns. The key is consistency: use the same timer duration for similar tasks, and your brain will learn to enter focus mode automatically when the countdown begins.',
    'cooking' => 'Precision timing separates good cooking from great cooking. A steak needs exactly 3 to 4 minutes per side for a perfect medium-rare. Pasta requires 8 to 12 minutes depending on the shape and brand. Bread dough proofs for 45 to 60 minutes in a warm kitchen. Each of these tasks has a narrow window where the result goes from underdone to perfect to overdone, and a reliable timer is the simplest way to hit that window every time. Unlike phone timers that require unlocking your device with wet or flour-covered hands, a browser timer stays visible on your screen or tablet and starts with a single click. For recipes with multiple timed components -- like a Thanksgiving dinner with a turkey, sides, and desserts all running on different schedules -- having a dedicated timer page open for each item keeps everything synchronized.',
    'exercise' => 'Structured timing transforms unstructured exercise into effective training. Without a timer, rest periods tend to stretch too long, work intervals end prematurely, and the total workout duration creeps upward without proportional benefit. Interval timers enforce discipline: 30 seconds of work followed by 10 seconds of rest in a Tabata protocol, 45 seconds on and 15 seconds off for circuit training, or 5 minutes of steady-state cardio between strength sets. Second timers are essential for exercises measured in brief bursts (planks, sprints, holds), while minute timers structure the overall session. For home workouts without a coach, timers serve as your accountability partner, ensuring each set gets the effort and recovery it needs.',
    'meditation' => 'A timer is the most important tool in a meditation practice. Without one, your mind divides its attention between the practice and the question of how long you have been sitting. This divided attention defeats the purpose of meditation, which is sustained, single-pointed focus. A timer eliminates clock-watching entirely. Set it, close your eyes, and trust that the alert will bring you back when the session is complete. Start with 5 minutes if you are new to meditation and add 5 minutes every week or two as your practice deepens. Most experienced practitioners sit for 20 to 30 minutes. The gentle audio alert on The Blog Timer is designed to end your session without jarring you out of a deep meditative state.',
    'studying' => 'Effective studying is not about how many hours you spend -- it is about how you structure those hours. Research on spaced repetition and active recall shows that shorter, focused study blocks produce better long-term retention than marathon cramming sessions. A 25-minute Pomodoro cycle is the most popular study timer because it provides enough time to engage deeply with material while preventing the mental fatigue that leads to passive re-reading. For standardized test prep, 45 to 60-minute timers simulate real exam conditions, building both knowledge and the stamina needed for test day. Between sessions, 5 to 10-minute break timers ensure you actually rest rather than spiraling into social media. The Blog Timer\'s state persistence means your session continues accurately even if you accidentally close the tab.',
];

$usecase_archive_urls = [];
foreach (['productivity', 'cooking', 'exercise', 'meditation', 'studying'] as $usecase_slug) {
    $usecase_archive_urls[$usecase_slug] = blogtimer_get_term_url_by_slug('timer_usecase', $usecase_slug);
}
?>

<main class="site-main">
    <div class="container">
        <h1 class="page-h1">
            <?php echo esc_html($loader->get_string('hub.usecases.h1')); ?>
        </h1>
        <p class="page-intro">
            <?php echo esc_html($loader->get_string('hub.usecases.intro')); ?>
        </p>

        <!-- Intro content -->
        <section class="section">
            <div class="container--narrow">
                <div class="content-page">
                    <p>Timers are not one-size-fits-all. A 25-minute countdown serves a completely different purpose when used for a Pomodoro work session versus a slow-braised recipe. The context matters, and the right timer duration depends entirely on what you are trying to accomplish. This page organizes our 220+ timers by activity, with curated recommendations and detailed guidance for each use case.</p>
                    <p>Click any timer below to start a countdown instantly. Every timer on The Blog Timer features timestamp-based accuracy, audio alerts, keyboard shortcuts, and fullscreen mode -- regardless of the duration or use case you choose.</p>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Use-Case Archives</h2>
            <div class="taxonomy-hub-grid">
                <?php foreach ($usecase_archive_urls as $slug => $archive_url): ?>
                    <article class="card taxonomy-link-card">
                        <h3><a href="<?php echo esc_url($archive_url); ?>"><?php echo esc_html(ucfirst($slug)); ?> timer archive</a></h3>
                        <p>Open the full list of timer pages categorized for <?php echo esc_html($slug); ?> workflows.</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <?php
        $use_cases = $loader->get_use_cases();
        $all_minute_timers = $related->get_all_by_unit('minutes');
        $timer_by_value = [];
        foreach ($all_minute_timers as $t) {
            $timer_by_value[$t['value']] = $t;
        }

        foreach ($use_cases as $uc):
            if (!$uc['enabled'])
                continue;
            $rec_values = $recommended[$uc['id']] ?? [];
            $desc = $descriptions[$uc['id']] ?? $uc['description'];
            ?>
            <section class="section" id="<?php echo esc_attr($uc['id']); ?>">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html($uc['label']); ?>
                    </h2>
                </div>
                <div class="content-page" style="max-width:none;margin-bottom:var(--space-6);">
                    <p><?php echo esc_html($desc); ?></p>
                    <p><a href="<?php echo esc_url($usecase_archive_urls[$uc['id']] ?? home_url('/use-cases/')); ?>">Browse all <?php echo esc_html(strtolower($uc['label'])); ?> timer pages.</a></p>
                </div>
                <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:var(--space-4);">Recommended Timers</h3>
                <div class="timer-grid">
                    <?php
                    foreach ($rec_values as $val) {
                        if (isset($timer_by_value[$val])) {
                            blogtimer_render_timer_card($timer_by_value[$val]);
                        }
                    }
                    ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- RELATED CATEGORIES -->
        <?php blogtimer_render_related_categories('use-cases'); ?>

        <!-- CTA -->
        <div class="cta-banner">
            <h2>Not Sure Which Timer to Use?</h2>
            <p>Start with the most popular choice: a 5-minute timer. It works for quick breaks, micro-tasks, and short meditation sessions.</p>
            <a href="<?php echo esc_url(home_url('/timer/set-timer-for-5-minutes/')); ?>" class="btn btn--primary btn--large">Start a 5-Minute Timer</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
