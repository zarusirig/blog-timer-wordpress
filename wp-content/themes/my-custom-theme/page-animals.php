<?php
/**
 * Template Name: Animals Hub
 * Description: Cluster hub for animal lifespan & gestation guides (blue-ocean cluster)
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <?php blogtimer_render_breadcrumb_nav([
            ['label' => 'Home', 'url' => home_url('/')],
            ['label' => 'Animal Timers', 'url' => null],
        ]); ?>
        <h1 class="page-h1">Animal Timers &mdash; Lifespans, Gestation &amp; Pregnancy Countdowns</h1>
        <p class="page-intro">How long do cats, dogs, horses, rabbits, and fish live &mdash; and how long are they pregnant? Vet-cited lifespans and gestation timelines for every common pet and animal, plus a pregnancy countdown you can set to your own mating or breeding date.</p>

        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-12 &middot; Vet-cited hub page</div>
            </div>
        </div>

        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Most animal lifespans and gestation lengths are surprisingly specific, well-documented numbers &mdash; cats are pregnant for about 63&ndash;65 days, dogs about 63 days, an indoor cat commonly lives 13&ndash;17 years. This hub collects those timelines in one place, each traced to veterinary sources, and adds the tool the reference sites lack: a <strong>countdown timer</strong> you can start from a mating or breeding date to track day-by-day through a pregnancy.</p>
        </div>
    </div>

    <!-- WHY IT MATTERS -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why a timer belongs on an animal page</h2>
            <p>Pet and livestock timing questions come in two shapes. <strong>Lifespan</strong> questions &mdash; &ldquo;how long do cats live&rdquo; &mdash; are reference facts best answered with a cited average, a breed or size breakdown, and the factors that extend or shorten it. <strong>Gestation</strong> questions &mdash; &ldquo;how long are cats pregnant&rdquo; &mdash; are different: an owner or breeder has a <em>specific</em> mating date and wants to know where they are <em>today</em> in that pregnancy, what to expect this week, and when labor is likely.</p>
            <p>That second shape is exactly what a countdown is for. Enter the date your cat or dog mated and the widget counts the days remaining, estimates the due date, and shows the current week of pregnancy &mdash; something no static reference page can do. Each guide below pairs the cited reference with that live timer.</p>
        </div>
    </section>

    <!-- GESTATION / PREGNANCY -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Gestation &amp; pregnancy countdowns</h2>
            <p class="section-subtitle">Guides with a set-it-to-your-date pregnancy countdown.</p>
            <div class="usecase-grid">
                <a class="card usecase-card" href="/guides/cat-gestation" style="text-decoration:none;">
                    <div class="usecase-card-icon">C</div>
                    <h3>Cat Pregnancy &mdash; How Long Are Cats Pregnant?</h3>
                    <p>Cats are pregnant for about 63&ndash;65 days. Week-by-week fetal development, signs of pregnancy, labor stages, and a countdown from mating.</p>
                </a>
                <a class="card usecase-card" href="/guides/dog-gestation" style="text-decoration:none;">
                    <div class="usecase-card-icon">D</div>
                    <h3>Dog Pregnancy &mdash; How Long Are Dogs Pregnant?</h3>
                    <p>Dogs are pregnant about 63 days (58&ndash;72 from breeding). Week-by-week, whelping stages, litter size by breed, and a countdown.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- LIFESPAN -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Lifespan guides</h2>
            <p class="section-subtitle">How long do they live? Cited averages, breed/size tables, and the factors that matter.</p>
            <div class="usecase-grid">
                <a class="card usecase-card" href="/guides/cat-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">C</div><h3>How Long Do Cats Live?</h3>
                    <p>Indoor cats commonly live 13&ndash;17 years, often into their 20s. Breed table, indoor vs outdoor, and life-stage &ldquo;human years.&rdquo;</p>
                </a>
                <a class="card usecase-card" href="/guides/dog-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">D</div><h3>How Long Do Dogs Live?</h3>
                    <p>Lifespan by size &mdash; small breeds 10&ndash;15 yrs, giant breeds 7&ndash;10 &mdash; with a breed table and the factors that extend it.</p>
                </a>
                <a class="card usecase-card" href="/guides/horse-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">H</div><h3>How Long Do Horses Live?</h3>
                    <p>Average 25&ndash;30 years; ponies longer, draft breeds shorter. Life stages, &ldquo;horse years,&rdquo; and care factors.</p>
                </a>
                <a class="card usecase-card" href="/guides/rabbit-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">R</div><h3>How Long Do Rabbits Live?</h3>
                    <p>Pet rabbits live 8&ndash;12 years (wild rabbits far less). Breed variation, the spay/neuter effect, and indoor vs outdoor.</p>
                </a>
                <a class="card usecase-card" href="/guides/betta-fish-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">B</div><h3>How Long Do Betta Fish Live?</h3>
                    <p>Bettas average 3&ndash;5 years in captivity. Tank size, temperature, diet, and the factors that reach the top of that range.</p>
                </a>
                <a class="card usecase-card" href="/guides/hamster-lifespan" style="text-decoration:none;">
                    <div class="usecase-card-icon">HM</div><h3>How Long Do Hamsters Live?</h3>
                    <p>Hamsters live about 2&ndash;3 years, varying by species (Syrian, dwarf, Roborovski). Genetics, housing, and life stages.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- COMPARISON TABLE -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Animal timelines at a glance</h2>
            <table class="comparison-table">
                <thead><tr><th>Animal</th><th>Average lifespan</th><th>Gestation length</th><th>Guide</th></tr></thead>
                <tbody>
                    <tr><td>Cat (indoor)</td><td>13&ndash;17 yrs (into 20s)</td><td>63&ndash;65 days</td><td><a href="/guides/cat-lifespan">Lifespan</a> &middot; <a href="/guides/cat-gestation">Pregnancy</a></td></tr>
                    <tr><td>Dog</td><td>7&ndash;15 yrs (by size)</td><td>~63 days</td><td><a href="/guides/dog-lifespan">Lifespan</a> &middot; <a href="/guides/dog-gestation">Pregnancy</a></td></tr>
                    <tr><td>Horse</td><td>25&ndash;30 yrs</td><td>~340 days</td><td><a href="/guides/horse-lifespan">Lifespan</a></td></tr>
                    <tr><td>Rabbit (pet)</td><td>8&ndash;12 yrs</td><td>~31 days</td><td><a href="/guides/rabbit-lifespan">Lifespan</a></td></tr>
                    <tr><td>Betta fish</td><td>3&ndash;5 yrs</td><td>&mdash;</td><td><a href="/guides/betta-fish-lifespan">Lifespan</a></td></tr>
                    <tr><td>Hamster</td><td>2&ndash;3 yrs</td><td>~16&ndash;22 days</td><td><a href="/guides/hamster-lifespan">Lifespan</a></td></tr>
                </tbody>
            </table>
            <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">Averages drawn from the veterinary sources cited on each guide. Individual animals vary; confirm specifics with your veterinarian.</p>
        </div>
    </section>

    <!-- ALL ANIMAL-CLUSTER GUIDES (auto) -->
    <?php
    $cluster_guides = new WP_Query([
        'post_type'      => 'guide',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
        'tax_query'      => [[
            'taxonomy' => 'guide_cluster',
            'field'    => 'slug',
            'terms'    => ['animals'],
        ]],
    ]);
    if ($cluster_guides->have_posts()): ?>
        <section class="section">
            <div class="container">
                <h2 class="section-title">All animal &amp; pet guides</h2>
                <div class="usecase-grid">
                    <?php while ($cluster_guides->have_posts()): $cluster_guides->the_post(); ?>
                        <a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;">
                            <div class="usecase-card-icon">A</div>
                            <h3><?php the_title(); ?></h3>
                            <?php $g_excerpt = get_the_excerpt(); if ($g_excerpt): ?>
                                <p><?php echo esc_html(wp_trim_words($g_excerpt, 18)); ?></p>
                            <?php endif; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif;
    wp_reset_postdata();
    ?>

    <!-- FAQ -->
    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Animal timing FAQ</h2>
            <?php
            $faqs = [
                ['q' => 'How accurate is the pregnancy countdown?', 'a' => 'The countdown counts actual calendar days from the mating or breeding date you enter and compares them to the average gestation length for that species. It is an estimate &mdash; individual pregnancies vary by several days, so treat the due date as a window, not a deadline, and confirm timing with your veterinarian.'],
                ['q' => 'Why do indoor cats live longer than outdoor cats?', 'a' => 'Outdoor cats face traffic, predators, parasites, infectious disease, and fights that indoor cats avoid. Veterinary sources consistently place average indoor-cat lifespan around 13&ndash;17 years (often into the 20s) versus only a few years for outdoor cats.'],
                ['q' => 'Do small dogs really live longer than large dogs?', 'a' => 'Yes. Across breeds, smaller dogs commonly live 10&ndash;15 years while giant breeds average closer to 7&ndash;10. The size-to-lifespan inverse is one of the better-documented patterns in canine health data.'],
                ['q' => 'Can I use the countdown for livestock or other species?', 'a' => 'The widget accepts any species and day-count, so it works for horses (~340 days), goats, sheep, or rabbits once we publish those guides. Enter the mating date and the species-average length to get a day-by-day count.'],
            ];
            echo blogtimer_render_faq($faqs);
            ?>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <h2>Track a pregnancy, day by day.</h2>
                <p>Pick the species, enter the mating date, and watch the countdown to the due date.</p>
                <a href="/guides/cat-gestation" class="btn btn--primary btn--large">Open the Cat Pregnancy Countdown</a>
            </div>
        </div>
    </section>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Animal Timers — Lifespans, Gestation & Pregnancy Countdowns",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"},
  "datePublished": "2026-08-12",
  "dateModified": "2026-08-12",
  "mainEntityOfPage": "<?php echo esc_url(get_permalink()); ?>",
  "description": "Hub of vet-cited animal lifespan and gestation guides — cats, dogs, horses, rabbits, fish, hamsters — with a pregnancy countdown timer."
}
</script>

<?php get_footer(); ?>
