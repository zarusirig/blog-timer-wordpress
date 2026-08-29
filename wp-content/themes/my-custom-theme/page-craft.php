<?php
/** Template Name: Craft & Fermentation Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Craft &amp; Fermentation','url'=>null]]); ?>
    <h1 class="page-h1">How Long Does Fermentation Take? &mdash; Craft &amp; Ferment Timers</h1>
        <?php btt_hero_image(get_post_field('post_name', get_the_ID()), get_the_title() . ' — illustration', true); ?>
    <p class="page-intro">Fermentation times by product &mdash; from yogurt (hours) to sauerkraut and lager beer (weeks) &mdash; with the variables that speed it up or slow it down, and the food-safety signs that tell you when it is done.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">SG</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-13 &middot; Curated fermentation hub</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Fermentation time is set by the microbe, the temperature, and the sugar or starch available &mdash; not by a clock you choose. Yogurt is done in hours; ale beer in 1&ndash;2 weeks; sauerkraut and lager in 3&ndash;4 weeks; kombucha in 1&ndash;2 weeks; wine in months. Cooler temperatures slow everything down, sometimes deliberately.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Fermentation guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-does-fermentation-take" style="text-decoration:none;"><div class="usecase-card-icon">F</div><h3>How Long Does Fermentation Take?</h3><p>Times for beer, bread, yogurt, kombucha, sauerkraut, kimchi and wine &mdash; by product, with the factors that change them.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Fermentation times at a glance</h2>
    <table class="comparison-table">
      <thead><tr><th>Product</th><th>Typical time</th><th>Main driver</th></tr></thead>
      <tbody>
        <tr><td>Yogurt</td><td>4&ndash;12 hours</td><td>Temperature (110&ndash;115&deg;F), starter culture</td></tr>
        <tr><td>Sourdough (bulk ferment)</td><td>4&ndash;12 hours</td><td>Room temperature, hydration</td></tr>
        <tr><td>Ale beer (primary)</td><td>3&ndash;7 days (+ conditioning)</td><td>Yeast strain, gravity, temperature</td></tr>
        <tr><td>Lager beer</td><td>10&ndash;14 days (+ cold lagering)</td><td>Cold fermentation with lager yeast</td></tr>
        <tr><td>Kombucha (1st ferment)</td><td>7&ndash;14 days</td><td>SCOBY, sugar, temperature</td></tr>
        <tr><td>Sauerkraut / kimchi</td><td>1&ndash;4 weeks</td><td>Salt concentration, temperature</td></tr>
        <tr><td>Wine</td><td>Weeks to months</td><td>Variety, yeast, desired style</td></tr>
      </tbody>
    </table>
    <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">Ranges drawn from the food-science sources cited on the fermentation guide.</p>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['craft']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container"><h2 class="section-title">All craft &amp; fermentation guides</h2><div class="usecase-grid">
    <?php while ($cg->have_posts()): $cg->the_post(); ?><a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">C</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a><?php endwhile; ?>
  </div></div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Fermentation FAQ</h2>
    <?php $faqs=[
      ['q'=>'Why does sauerkraut take weeks but yogurt takes hours?','a'=>'Different microbes work at different speeds. Lactic-acid bacteria in sauerkraut work slowly at cool room temperature in a salt brine, while yogurt&rsquo;s thermophilic bacteria work fast at a warm 110&ndash;115&deg;F. Temperature and the microbe set the clock.'],
      ['q'=>'How can I tell when fermentation is done?','a'=>'It depends on the product, but common signs are a stable specific gravity (beer/wine), the expected drop in pH and tart flavor (kraut/kombucha), or a set texture (yogurt). When in doubt, rely on a recipe&rsquo;s time-and-signal cues, not the calendar alone.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"How Long Does Fermentation Take? — Craft & Ferment Timers","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-13","dateModified":"2026-08-13","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"Fermentation times by product — yogurt, sourdough, beer, kombucha, sauerkraut, kimchi, wine — with the factors that change them."}
</script>
<?php get_footer(); ?>
