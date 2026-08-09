<?php
/**
 * Template Name: Site Index
 *
 * A crawlable HTML sitemap — the grouper-of-groupers. Every public URL on the
 * site is reachable in <=1 click from here, as a real server-rendered <a> link.
 * No JavaScript, no pagination, no caps.
 *
 * Guides are linked DIRECTLY via get_permalink() (/guides/{slug}/). The
 * guide_cluster archive (/guide-cluster/{term}/) is NEVER linked because it
 * 404s / 301-redirects.
 */
get_header();

$related = Timer_Related::get_instance();

// Full timer enumerations, ordered by value.
$minute_timers = $related->get_all_by_unit('minutes'); // 1–161
$second_timers = $related->get_all_by_unit('seconds');  // 1–60
$hour_timers = $related->get_all_by_unit('hours');      // 1–24

/**
 * Render a flat <ul> of timer links from a get_all_by_unit() result set.
 * Each item is ['post' => WP_Post, 'value' => int, 'unit' => string, 'slug' => string].
 */
function blogtimer_sitemap_timer_list($timers, $unit_singular)
{
    if (empty($timers)) {
        echo '<p>No ' . esc_html($unit_singular) . ' timers found.</p>';
        return;
    }

    /*
     * Progressive rendering for mobile DOM weight: every link stays in the
     * server-rendered HTML (fully crawlable for SEO), but off-screen groups
     * are skipped by the browser's paint pipeline via content-visibility.
     * No JS, no pagination, no caps. The first group renders normally; later
     * groups reserve a placeholder (contain-intrinsic-size) and only paint
     * when scrolled near the viewport.
     */
    $groups = array_chunk($timers, 40);
    foreach ($groups as $index => $group) {
        $chunk_style = ($index > 0)
            ? 'content-visibility:auto;contain-intrinsic-size:auto 600px;margin-top:var(--space-5,1.5rem);'
            : '';
        ?>
        <div class="sitemap-chunk"<?php echo $chunk_style ? ' style="' . esc_attr($chunk_style) . '"' : ''; ?>>
            <ul class="sitemap-list" style="columns:200px;column-gap:var(--space-6,2rem);list-style:none;padding:0;margin:0;">
                <?php foreach ($group as $t):
                    $post  = $t['post'];
                    $value = (int) $t['value'];
                    $label = $value . ' ' . $unit_singular . ($value === 1 ? '' : 's'); ?>
                    <li style="break-inside:avoid;margin-bottom:0.35rem;">
                        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo esc_html($label); ?> timer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

/**
 * Render a <ul> of {label => url} links.
 */
function blogtimer_sitemap_link_list($links)
{
    echo '<ul class="sitemap-list" style="list-style:none;padding:0;">';
    foreach ($links as $label => $url) {
        printf(
            '<li style="margin-bottom:0.35rem;"><a href="%s">%s</a></li>',
            esc_url($url),
            esc_html($label)
        );
    }
    echo '</ul>';
}

// ----------------------------------------------------------------------------
// SILO DEFINITIONS (6). Each silo lists its hub + child page hubs as real links.
// These are static WordPress hub pages, linked by their known slugs.
// ----------------------------------------------------------------------------
$silos = [
    'Focus &amp; Productivity' => [
        'Study &amp; Work Timers (hub)' => home_url('/study-work-timers'),
        'Pomodoro Timer'              => home_url('/pomodoro'),
        'Focus Timer'                 => home_url('/focus-timer'),
        'Deep Work Timers (guide)'    => home_url('/guides/deep-work-timers'),
        'Study Timer'                 => home_url('/study-timer'),
        'Sprint Timer'                => home_url('/sprint-timer'),
        'Timer for Remote Workers'    => home_url('/timer-for-remote-workers'),
        'Timer for Kids'              => home_url('/timer-for-kids'),
        'Presentation Timer'          => home_url('/presentation-timer'),
        'Timers by Use Case'          => home_url('/use-cases'),
    ],
    'Timers by Duration' => [
        'Minute Timers (1&ndash;161, hub)' => home_url('/minute-timers'),
        'Second Timers (1&ndash;60, hub)'  => home_url('/second-timers'),
        'Hour Timers (1&ndash;24, hub)'    => home_url('/hour-timers'),
        'Countdown Timer'                  => home_url('/countdown-timer'),
    ],
    'Cooking' => [
        'Cooking Timers (hub)' => home_url('/cooking-timers'),
        'Egg Timer'            => home_url('/egg-timer'),
        'Pasta Timer'         => home_url('/pasta-timer'),
        'Rice Timer'          => home_url('/rice-timer'),
        'Tea Timer'           => home_url('/tea-timer'),
        'Coffee Timer'        => home_url('/coffee-timer'),
        'Steak Timer'         => home_url('/steak-timer'),
        'Turkey Timer'        => home_url('/turkey-timer'),
        'Bread Baking Timer'  => home_url('/bread-baking-timer'),
        'Sous Vide Timer'     => home_url('/sous-vide-timer'),
        'BBQ Timer'           => home_url('/bbq-timer'),
        'Microwave Popcorn Timer' => home_url('/microwave-popcorn-timer'),
        'Baby Bottle Timer'   => home_url('/baby-bottle-timer'),
    ],
    'Workout &amp; Fitness' => [
        'Workout Timers (hub)'    => home_url('/workout-timers'),
        'HIIT Timer'              => home_url('/hiit-timer'),
        'Tabata Timer'            => home_url('/tabata-timer'),
        'Interval Timer'          => home_url('/interval-timer'),
        'EMOM Timer'              => home_url('/emom-timer'),
        'CrossFit AMRAP Timer'    => home_url('/crossfit-amrap-timer'),
        'Boxing Round Timer'      => home_url('/boxing-round-timer'),
        'Running Interval Timer'  => home_url('/running-interval-timer'),
        'Jump Rope Timer'         => home_url('/jump-rope-timer'),
        'Plank Timer'             => home_url('/plank-timer'),
        'Stretching Timer'        => home_url('/stretching-timer'),
        'Yoga Timer'              => home_url('/yoga-timer'),
    ],
    'Sleep &amp; Meditation' => [
        'Sleep &amp; Meditation Timers (hub)' => home_url('/sleep-meditation-timers'),
        'Sleep Timer'        => home_url('/sleep-timer'),
        'Nap Timer'          => home_url('/nap-timer'),
        'Meditation Timer (guide)'   => home_url('/guides/meditation-timers-beginners'),
        'Breathing Timer (guide)'    => home_url('/guides/breathing-timers'),
        'White Noise Timer (guide)'  => home_url('/guides/white-noise-timer'),
    ],
    'Clocks &amp; Tools' => [
        'Stopwatch &amp; Clock Tools (hub)' => home_url('/stopwatch-clock-tools'),
        'Stopwatch'           => home_url('/stopwatch'),
        'Online Alarm Clock'  => home_url('/online-alarm-clock'),
        'World Clock'         => home_url('/world-clock'),
        'Chess Clock'         => home_url('/chess-clock'),
        'Countdown Timer'     => home_url('/countdown-timer'),
    ],
];

// ----------------------------------------------------------------------------
// TRUST & LEGAL PAGES — actual slugs confirmed from the footer/templates.
// ----------------------------------------------------------------------------
$trust_pages = [
    'Methodology'        => home_url('/methodology'),
    'Sources'            => home_url('/sources'),
    'About'              => home_url('/about'),
    'Editorial Policy'   => home_url('/editorial-policy'),
    'Changelog'          => home_url('/changelog'),
    'Author: Suraj Giri' => home_url('/author-suraj-giri'),
    'Contact'            => home_url('/contact'),
    'FAQ'                => home_url('/faq'),
    'Privacy Policy'     => home_url('/privacy-policy'),
    'Terms of Service'   => home_url('/terms-of-service'),
];
?>

<main id="main" tabindex="-1" class="site-main">
    <div class="container">
        <?php
        blogtimer_render_breadcrumb_nav([
            ['label' => 'Home', 'url' => home_url('/')],
            ['label' => 'Site Index', 'url' => null],
        ]);
        ?>

        <h1 class="page-h1">Site Index</h1>
        <p class="page-intro">
            A complete, crawlable map of The Blog Timer. Every hub, every timer, every guide, and every
            trust page is linked below as a direct, server-rendered link &mdash; so any page on the site is
            reachable in a single click from here. Use it to find a specific duration, browse a topic silo,
            or jump straight to an evidence-based timing guide.
        </p>

        <!-- ============================ BY SILO ============================ -->
        <section class="section">
            <h2 class="section-title">Browse by Topic</h2>
            <p class="section-subtitle">The six content silos and their hub and child pages.</p>
            <?php foreach ($silos as $silo_name => $silo_links): ?>
                <div class="content-page" style="margin-bottom:var(--space-6,2rem);">
                    <h3><?php echo wp_kses_post($silo_name); ?></h3>
                    <?php blogtimer_sitemap_link_list($silo_links); ?>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- ===================== ALL MINUTE TIMERS ===================== -->
        <section class="section">
            <h2 class="section-title">All Minute Timers (1&ndash;161)</h2>
            <p class="section-subtitle">Every minute-based timer page, ordered by duration.</p>
            <?php blogtimer_sitemap_timer_list($minute_timers, 'minute'); ?>
        </section>

        <!-- ===================== ALL SECOND TIMERS ===================== -->
        <section class="section">
            <h2 class="section-title">All Second Timers (1&ndash;60)</h2>
            <p class="section-subtitle">Every second-based timer page, ordered by duration.</p>
            <?php blogtimer_sitemap_timer_list($second_timers, 'second'); ?>
        </section>

        <!-- ====================== ALL HOUR TIMERS ====================== -->
        <section class="section">
            <h2 class="section-title">All Hour Timers</h2>
            <p class="section-subtitle">Every hour-based timer page, ordered by duration.</p>
            <?php blogtimer_sitemap_timer_list($hour_timers, 'hour'); ?>
        </section>

        <!-- =================== ALL GUIDES BY CLUSTER =================== -->
        <section class="section">
            <h2 class="section-title">All Guides by Cluster</h2>
            <p class="section-subtitle">Evidence-based timing guides, grouped by topic cluster. Each guide links directly.</p>
            <?php
            // Loop ALL guide_cluster terms (including empty, so nothing is hidden),
            // and under each, list every guide via its direct /guides/{slug}/ permalink.
            $clusters = get_terms([
                'taxonomy'   => 'guide_cluster',
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ]);

            $listed_guide_ids = [];

            if (!is_wp_error($clusters) && !empty($clusters)) {
                foreach ($clusters as $cluster) {
                    $cluster_guides = get_posts([
                        'post_type'        => 'guide',
                        'posts_per_page'   => -1,
                        'orderby'          => 'title',
                        'order'            => 'ASC',
                        'suppress_filters' => false,
                        'tax_query'        => [
                            [
                                'taxonomy' => 'guide_cluster',
                                'field'    => 'term_id',
                                'terms'    => $cluster->term_id,
                            ],
                        ],
                    ]);

                    if (empty($cluster_guides)) {
                        continue; // no heading for an empty cluster
                    }
                    ?>
                    <div class="content-page" style="margin-bottom:var(--space-6,2rem);content-visibility:auto;contain-intrinsic-size:auto 600px;">
                        <h3><?php echo esc_html($cluster->name); ?></h3>
                        <ul class="sitemap-list" style="list-style:none;padding:0;">
                            <?php foreach ($cluster_guides as $guide):
                                $listed_guide_ids[] = $guide->ID; ?>
                                <li style="margin-bottom:0.35rem;">
                                    <a href="<?php echo esc_url(get_permalink($guide->ID)); ?>"><?php echo esc_html($guide->post_title); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                }
            }

            // Catch any guides that have no cluster assigned, so nothing is unreachable.
            $unclustered = get_posts([
                'post_type'      => 'guide',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'post__not_in'   => !empty($listed_guide_ids) ? array_unique($listed_guide_ids) : [0],
            ]);
            if (!empty($unclustered)): ?>
                <div class="content-page" style="margin-bottom:var(--space-6,2rem);content-visibility:auto;contain-intrinsic-size:auto 600px;">
                    <h3>Other Guides</h3>
                    <ul class="sitemap-list" style="list-style:none;padding:0;">
                        <?php foreach ($unclustered as $guide): ?>
                            <li style="margin-bottom:0.35rem;">
                                <a href="<?php echo esc_url(get_permalink($guide->ID)); ?>"><?php echo esc_html($guide->post_title); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <p style="margin-top:var(--space-4,1rem);">
                <a href="<?php echo esc_url(home_url('/guides')); ?>">Browse the full guides archive &rarr;</a>
            </p>
        </section>

        <!-- ==================== TRUST & LEGAL PAGES ==================== -->
        <section class="section">
            <h2 class="section-title">Trust &amp; Legal</h2>
            <p class="section-subtitle">Our methodology, sources, and policy pages.</p>
            <?php blogtimer_sitemap_link_list($trust_pages); ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
