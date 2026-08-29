<?php
/** Template Name: Parenting & Baby Sleep Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Parenting Timers','url'=>null]]); ?>
    <h1 class="page-h1">Parenting &amp; Baby Sleep Timers &mdash; Naps, Wake Windows &amp; Feeds</h1>
        <?php btt_hero_image(get_post_field('post_name', get_the_ID()), get_the_title() . ' — illustration', true); ?>
    <p class="page-intro">Baby nap schedules and wake windows by age, how long newborns and toddlers should sleep at night, and how often to feed &mdash; the timing reference for new parents. Health information, not medical advice.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">SG</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-13 &middot; Health information, not medical advice</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Baby sleep needs change fast in the first year. A 6-month-old typically takes 2&ndash;3 naps (about 3&ndash;3.5 hours of day sleep), sleeps 11&ndash;12 hours at night, and is awake for roughly 2&ndash;2.5 hours between naps. Total daily sleep falls from ~14&ndash;17 hours as a newborn toward 12&ndash;14 hours by the first birthday. This is general guidance; always follow your pediatrician.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Parenting &amp; sleep guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/6-month-old-nap-schedule" style="text-decoration:none;"><div class="usecase-card-icon">6</div><h3>6-Month-Old Nap Schedule</h3><p>2&ndash;3 naps (~3&ndash;3.5h day sleep), 11&ndash;12h night, 2&ndash;2.5h wake windows. Sample day + cues.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Baby sleep needs by age (at a glance)</h2>
    <table class="comparison-table">
      <thead><tr><th>Age</th><th>Total sleep / 24h</th><th>Naps</th><th>Typical wake window</th></tr></thead>
      <tbody>
        <tr><td>Newborn (0&ndash;3 mo)</td><td>14&ndash;17 hours</td><td>4&ndash;5 (irregular)</td><td>45&ndash;90 min</td></tr>
        <tr><td>Infant (4&ndash;11 mo)</td><td>12&ndash;15 hours</td><td>2&ndash;3</td><td>1.5&ndash;2.5 h</td></tr>
        <tr><td>Toddler (1&ndash;2 yr)</td><td>11&ndash;14 hours</td><td>1&ndash;2</td><td>3&ndash;6 h</td></tr>
      </tbody>
    </table>
    <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">Ranges reflect American Academy of Pediatrics / National Sleep Foundation consensus totals. Individual babies vary; discuss your child&rsquo;s pattern with your pediatrician.</p>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['parenting']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container"><h2 class="section-title">All parenting &amp; sleep guides</h2><div class="usecase-grid">
    <?php while ($cg->have_posts()): $cg->the_post(); ?><a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">P</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a><?php endwhile; ?>
  </div></div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Parenting FAQ</h2>
    <?php $faqs=[
      ['q'=>'How do I know my baby is ready for a nap?','a'=>'Common sleep cues include eye-rubbing, yawning, staring blankly, fussiness, and losing interest in play. The goal is to start the wind-down at the first signs, before overtiredness sets in &mdash; which makes falling asleep harder.'],
      ['q'=>'When do babies drop to two naps?','a'=>'Most babies move from three naps to two somewhere between 6 and 8 months, and from two naps to one between 12 and 18 months. Signs a nap is ready to drop: prolonged sleep onset, shortened naps, or resisting a nap entirely for two weeks.'],
      ['q'=>'Is this a schedule I have to follow exactly?','a'=>'No. Wake windows and totals are ranges, not rules. Use them as a starting point and adjust to your baby&rsquo;s cues and your pediatrician&rsquo;s guidance. This is health information, not medical advice.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"Parenting & Baby Sleep Timers — Naps, Wake Windows & Feeds","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-13","dateModified":"2026-08-13","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"Baby nap schedules and wake windows by age, how long newborns and toddlers sleep, and how often to feed — the timing reference for new parents."}
</script>
<?php get_footer(); ?>
