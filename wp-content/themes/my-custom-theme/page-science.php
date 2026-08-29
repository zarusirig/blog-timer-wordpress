<?php
/** Template Name: Space & Science Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Space &amp; Science','url'=>null]]); ?>
    <h1 class="page-h1">Space &amp; Science Timers &mdash; How Long Things Take</h1>
        <?php btt_hero_image(get_post_field('post_name', get_the_ID()), get_the_title() . ' — illustration', true); ?>
    <p class="page-intro">How long it takes to get to the Moon and Mars, how long light takes to reach Earth from the Sun, and the launch windows and trajectories that decide every mission&rsquo;s clock.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">SG</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-13 &middot; Cited space-science hub</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Travel time in space is set by the trajectory and propulsion, not just the distance. A crewed Apollo-style Moon trip takes about 3 days; the fastest probe reached lunar orbit in 8.5 hours. Mars takes roughly 7&ndash;9 months on an efficient transfer that is only available every ~26 months.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Space &amp; science guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-does-it-take-to-get-to-the-moon" style="text-decoration:none;"><div class="usecase-card-icon">M</div><h3>To the Moon</h3><p>~3 days crewed (Apollo); fastest probe 8.5 hours. Trajectories compared.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-it-take-to-get-to-mars" style="text-decoration:none;"><div class="usecase-card-icon">MA</div><h3>To Mars</h3><p>~7&ndash;9 months on a Hohmann transfer, every ~26-month launch window.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Destination travel times at a glance</h2>
    <table class="comparison-table">
      <thead><tr><th>Destination</th><th>Typical travel time</th><th>Decided by</th></tr></thead>
      <tbody>
        <tr><td>International Space Station (LEO)</td><td>~3&ndash;6 hours (crewed)</td><td>Orbital phasing</td></tr>
        <tr><td>Moon (crewed, Apollo-style)</td><td>~3 days</td><td>Free-return / translunar trajectory</td></tr>
        <tr><td>Moon (fastest probe, New Horizons pace)</td><td>8.5 hours to fly by</td><td>High-energy launch</td></tr>
        <tr><td>Mars (efficient transfer)</td><td>~7&ndash;9 months (~200&ndash;300 days)</td><td>Hohmann transfer + 26-mo window</td></tr>
        <tr><td>Sun&rsquo;s light to Earth</td><td>~8 minutes 20 seconds</td><td>Speed of light over 1 AU</td></tr>
      </tbody>
    </table>
    <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">From NASA/ESA sources cited on each guide; ISS and light-time figures are standard astronomical values.</p>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['science']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container"><h2 class="section-title">All space &amp; science guides</h2><div class="usecase-grid">
    <?php while ($cg->have_posts()): $cg->the_post(); ?><a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">S</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a><?php endwhile; ?>
  </div></div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Space travel FAQ</h2>
    <?php $faqs=[
      ['q'=>'Why does Mars take months when the Moon takes days?','a'=>'Distance is part of it, but the bigger factor is trajectory. You cannot point a rocket straight at Mars; you travel along a Hohmann transfer arc that meets Mars on its orbit, which is only efficient during a launch window that opens about every 26 months and takes roughly 7&ndash;9 months each way.'],
      ['q'=>'Could we get to Mars faster?','a'=>'Yes, with more propulsion. Higher-energy trajectories or future nuclear/thermal engines could cut the trip, but they require far more fuel (or new technology) and are not how current Mars missions fly.'],
      ['q'=>'How long does light take to reach Earth from the Sun?','a'=>'About 8 minutes 20 seconds &mdash; the Sun&rsquo;s light travels the average 150 million km (1 astronomical unit) to Earth at the speed of light.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"Space & Science Timers — How Long Things Take","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-13","dateModified":"2026-08-13","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"How long it takes to get to the Moon and Mars, how long light takes from the Sun, and the trajectories and launch windows that decide each mission."}
</script>
<?php get_footer(); ?>
