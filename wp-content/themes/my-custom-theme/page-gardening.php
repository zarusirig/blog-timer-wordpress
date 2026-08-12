<?php
/** Template Name: Gardening Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Gardening Timers','url'=>null]]); ?>
    <h1 class="page-h1">Gardening Timers &mdash; How Long Seeds Take to Grow</h1>
    <p class="page-intro">How long grass seed takes to germinate and grow &mdash; by grass type &mdash; with the soil-temperature and moisture variables that decide whether you see green in 5 days or 30.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">SG</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-13 &middot; Curated gardening hub</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Germination speed is a function of species, soil temperature, and steady moisture. Ryegrass can sprout in under a week; Kentucky bluegrass needs two to four. Most lawns are ready for a first mow about 8 weeks after seeding, and a mature lawn takes a full growing season.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Gardening guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-do-grass-seeds-take-to-grow" style="text-decoration:none;"><div class="usecase-card-icon">G</div><h3>How Long Do Grass Seeds Take to Grow?</h3><p>Germination by grass type, time to first mow, and what a seed needs to sprout.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Grass-seed timing at a glance</h2>
    <table class="comparison-table">
      <thead><tr><th>Grass type</th><th>Germination</th><th>Needs</th></tr></thead>
      <tbody>
        <tr><td>Perennial ryegrass</td><td>5&ndash;10 days</td><td>Cool soil, steady moisture</td></tr>
        <tr><td>Fescue</td><td>7&ndash;14 days</td><td>Cool soil, consistent damp</td></tr>
        <tr><td>Kentucky bluegrass</td><td>14&ndash;30 days</td><td>Patient moisture; slower to establish</td></tr>
        <tr><td>Bermuda / warm-season</td><td>~10&ndash;30 days</td><td>Warm soil (65&deg;F+); late spring sowing</td></tr>
      </tbody>
    </table>
    <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">Ranges from the university-extension sources cited on the grass-seed guide. First mow typically ~8 weeks; mature lawn a full season.</p>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['gardening']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container"><h2 class="section-title">All gardening guides</h2><div class="usecase-grid">
    <?php while ($cg->have_posts()): $cg->the_post(); ?><a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">G</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a><?php endwhile; ?>
  </div></div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Gardening FAQ</h2>
    <?php $faqs=[
      ['q'=>'Why is my grass seed not germinating?','a'=>'The three usual causes are dry surface soil (seed must stay damp daily), soil that is too cold for the species (warm-season grasses need ~65&deg;F+), and seed sitting on top of the soil rather than in contact with it. Fix moisture, temperature, and seed-soil contact and most seed sprouts.'],
      ['q'=>'How often should I water new grass seed?','a'=>'Keep the top inch of soil consistently moist &mdash; usually light watering 1&ndash;3 times a day until germination, then gradually deeper, less frequent watering as roots establish. Letting it dry out even once in the first week can kill the sprouting seed.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"Gardening Timers — How Long Seeds Take to Grow","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-13","dateModified":"2026-08-13","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"How long grass seed takes to germinate and grow, by grass type, with the soil-temperature and moisture variables that decide it."}
</script>
<?php get_footer(); ?>
