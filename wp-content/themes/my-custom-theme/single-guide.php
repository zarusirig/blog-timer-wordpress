<?php
/**
 * Template: Single Guide Page
 *
 * Renders: Breadcrumbs → H1 → Intro/Excerpt → Main Content → Recommended Timers → Related Guides → Hub CTA → FAQ → Schema
 */
get_header();

$loader = Timer_Content_Loader::get_instance();
$post_id = get_the_ID();

// Get Meta Data
$primary_hub_id = get_post_meta($post_id, 'guide_primary_hub', true);
$timer_refs = get_post_meta($post_id, 'guide_timers', true);
$related_guide_slugs = get_post_meta($post_id, 'guide_related', true);
$faq_keys = get_post_meta($post_id, 'guide_faqs', true);
$cluster_terms = get_the_terms($post_id, 'guide_cluster');

// Resolve Hub Data
$hubs = [
    'hub_minutes' => ['url' => '/minute-timers/', 'label' => 'Minute Timers'],
    'hub_seconds' => ['url' => '/second-timers/', 'label' => 'Second Timers'],
    'hub_pomodoro' => ['url' => '/pomodoro/', 'label' => 'Pomodoro Timers'],
    'hub_usecases' => ['url' => '/use-cases/', 'label' => 'Timer Use Cases'],
];
$hub = $hubs[$primary_hub_id] ?? $hubs['hub_minutes'];

// Resolve Timers
$recommended_timers = [];
if (!empty($timer_refs) && is_array($timer_refs)) {
    foreach ($timer_refs as $ref) {
        $args = [
            'post_type' => 'timer',
            'posts_per_page' => 1,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_timer_value',
                    'value' => $ref['value'],
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ],
                [
                    'key' => '_timer_unit',
                    'value' => $ref['unit'],
                    'compare' => '='
                ]
            ]
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $recommended_timers[] = $query->posts[0];
        }
    }
}

// Resolve Related Guides
$related_guides = [];
if (!empty($related_guide_slugs) && is_array($related_guide_slugs)) {
    foreach ($related_guide_slugs as $slug) {
        $guide = get_page_by_path($slug, OBJECT, 'guide');
        if ($guide) {
            $related_guides[] = $guide;
        }
    }
}

// Resolve FAQs
$faqs = [];
if (!empty($faq_keys) && is_array($faq_keys)) {
    $copyblocks_path = ABSPATH . '../datasets/copyblocks.json';
    if (file_exists($copyblocks_path)) {
        $cb = json_decode(file_get_contents($copyblocks_path), true);
        foreach ($faq_keys as $key) {
            if (isset($cb['faqs'][$key]['en'])) {
                $faqs[] = $cb['faqs'][$key]['en'];
            }
        }
    }
}
?>

<main class="site-main">
    <div class="container container--narrow">

        <!-- BREADCRUMBS -->
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <ol>
                <li><a href="<?php echo esc_url(home_url('')); ?>">Home</a></li>
                <li><a href="<?php echo esc_url(home_url($hub['url'])); ?>">
                        <?php echo esc_html($hub['label']); ?>
                    </a></li>
                <li><a href="<?php echo esc_url(home_url('/guides/')); ?>">Guides</a></li>
                <li aria-current="page">
                    <?php the_title(); ?>
                </li>
            </ol>
        </nav>

        <!-- H1 -->
        <header class="page-header custom-guide-header">
            <h1 class="page-h1">
                <?php the_title(); ?>
            </h1>
            <?php if (has_excerpt()): ?>
                <p class="page-intro">
                    <?php echo get_the_excerpt(); ?>
                </p>
            <?php endif; ?>
        </header>

        <!-- MAIN CONTENT -->
        <div class="guide-content content-page">
            <?php
            if (get_the_content()) {
                the_content();
            } else {
                // Rich fallback content for guide posts without custom content
                ?>
                <h2>Understanding the Basics</h2>
                <p>This comprehensive guide explores the best practices and timing strategies for your specific needs. Proper timing is not just about watching a clock — it is about structuring your activities in a way that maximizes both efficiency and quality of output. Whether you are managing work sessions, cooking meals, training for fitness goals, or building a meditation practice, the right timer transforms vague intentions into concrete, measurable action.</p>

                <p>The science behind effective timing is well-established. Research in cognitive psychology shows that humans perform best when tasks have clear boundaries. Open-ended work sessions lead to diminishing returns, while timed intervals create a healthy sense of urgency that sustains focus and motivation. This guide will help you understand which timer durations work best for different activities and why.</p>

                <h3>Key Takeaways</h3>
                <ul>
                    <li><strong>Match the timer to the task.</strong> Short bursts work for simple or physical tasks, while longer intervals suit complex cognitive work. A 5-minute timer serves a completely different purpose than a 45-minute one.</li>
                    <li><strong>Consistency builds habits.</strong> Using the same timer duration for similar activities trains your brain to enter focus mode automatically when the countdown begins. Over time, the timer becomes a trigger for deep concentration.</li>
                    <li><strong>Breaks are essential, not optional.</strong> Research shows that regular breaks improve both the quality and sustainability of your work. The break is part of the system, not an interruption of it.</li>
                    <li><strong>Experiment with durations.</strong> The ideal interval varies by person and task. Start with standard durations (25 minutes for work, 5 minutes for breaks) and adjust based on when your concentration naturally starts to fade.</li>
                </ul>

                <h2>Why Timer Accuracy Matters</h2>
                <p>Not all timers are created equal. Basic timer implementations that rely on simple JavaScript intervals can drift significantly over time, especially when browser tabs are backgrounded or devices enter power-saving mode. This drift might seem minor — a few seconds here and there — but it compounds over longer sessions and can undermine the structure that makes timed work effective.</p>

                <p>The Blog Timer uses timestamp-based calculation to ensure accuracy regardless of system conditions. Instead of counting down from a number, our timers calculate the target end time when you press start and continuously compare the current time against that target. This approach maintains precision even when your browser tab goes to sleep, your computer hibernates, or system resources are strained by other applications.</p>

                <p>When you return to a timer that has been running in a background tab, you will find it shows the correct remaining time — not an approximation. This reliability makes The Blog Timer suitable for time-critical applications where accuracy genuinely matters, from professional Pomodoro sessions to precise cooking intervals.</p>

                <h2>Getting the Most from Your Timer</h2>
                <p>A timer is only as effective as the intention behind it. Before starting your countdown, take a moment to define what you will work on during the session. Write it down if possible. Clear task definition is the foundation of productive timed sessions — vague goals like "work on the project" produce worse results than specific ones like "draft the introduction section."</p>

                <p>Eliminate distractions before pressing start. Close unnecessary browser tabs, silence your phone, and let others know you are in a focused session. The timer creates external structure, but you need to protect that structure from interruptions. If a thought or task pops into your head during the session, jot it down quickly and return to your primary focus immediately.</p>

                <p>When the timer ends, respect the boundary. If you are in a flow state and want to continue, that is fine — but take at least a brief 2-minute break to stretch and reset before starting another session. The breaks are what make sustained focus possible over hours, not just minutes.</p>
                <?php
            }
            ?>
        </div>

        <!-- RECOMMENDED TIMERS -->
        <?php if (!empty($recommended_timers)): ?>
            <section class="section related-section">
                <h2 class="section-title">Recommended Timers</h2>
                <div class="timer-grid">
                    <?php foreach ($recommended_timers as $rt):
                        $rt_value = (int) get_post_meta($rt->ID, '_timer_value', true);
                        $rt_unit = get_post_meta($rt->ID, '_timer_unit', true) ?: 'minutes';
                        blogtimer_render_timer_card([
                            'value' => $rt_value,
                            'unit'  => $rt_unit,
                            'post'  => $rt,
                        ]);
                    endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- RELATED GUIDES -->
        <?php if (!empty($related_guides)): ?>
            <section class="section related-guides-section">
                <h2 class="section-title">Related Guides</h2>
                <div class="usecase-grid"> <!-- Reusing usecase grid for cards -->
                    <?php foreach ($related_guides as $rg): ?>
                        <a href="<?php echo esc_url(get_permalink($rg->ID)); ?>" class="card usecase-card">
                            <div class="usecase-card-icon">📖</div>
                            <h3>
                                <?php echo esc_html($rg->post_title); ?>
                            </h3>
                            <p>
                                <?php echo esc_html($rg->post_excerpt); ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($cluster_terms) && !is_wp_error($cluster_terms)): ?>
            <section class="section">
                <h2 class="section-title">Browse Related Guide Topics</h2>
                <div class="taxonomy-hub-grid">
                    <?php foreach ($cluster_terms as $cluster_term): ?>
                        <?php $cluster_url = get_term_link($cluster_term); ?>
                        <?php if (is_wp_error($cluster_url)) {
                            continue;
                        } ?>
                        <article class="card taxonomy-link-card">
                            <h3><a href="<?php echo esc_url($cluster_url); ?>"><?php echo esc_html($cluster_term->name); ?> cluster</a></h3>
                            <p>See all guides tagged in the <?php echo esc_html(strtolower($cluster_term->name)); ?> topic cluster.</p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- HUB CTA -->
        <div class="hub-cta" style="margin-top: 3rem; text-align: center;">
            <a href="<?php echo esc_url(home_url($hub['url'])); ?>" class="btn btn--primary">
                Return to
                <?php echo esc_html($hub['label']); ?> →
            </a>
        </div>

        <!-- FAQ -->
        <?php if (!empty($faqs)): ?>
            <section class="section">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <?php blogtimer_render_faq($faqs); ?>
            </section>
        <?php endif; ?>

    </div>
</main>

<?php
// Output FAQ Schema
if (!empty($faqs)) {
    $faq_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [],
    ];
    foreach ($faqs as $faq) {
        $faq_schema['mainEntity'][] = [
            '@type' => 'Question',
            'name' => $faq['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['a'],
            ],
        ];
    }
    echo '<script type="application/ld+json">' . wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

get_footer();
?>
