<?php
/** Template Name: Healing Timers Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Healing Timers','url'=>null]]); ?>
    <h1 class="page-h1">How Long to Heal &mdash; Injury Recovery Timelines</h1>
        <?php btt_hero_image(get_post_field('post_name', get_the_ID()), get_the_title() . ' — illustration', true); ?>
    <p class="page-intro">How long a sprained ankle takes to heal (by grade) and how long broken ribs take to recover &mdash; grade-by-grade recovery timelines, what to expect at each stage, and the red-flag symptoms that mean see a doctor now.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">SG</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-13 &middot; Health information, not medical advice</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Healing time depends on severity, not just the injury type. A mild sprained ankle can be back to normal in 1&ndash;2 weeks; a complete ligament tear takes months. Most broken ribs heal on their own in about 6 weeks, but pain often lingers longer. This is health information, not medical advice.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Injury recovery guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-does-a-sprained-ankle-take-to-heal" style="text-decoration:none;"><div class="usecase-card-icon">A</div><h3>Sprained Ankle</h3><p>Grade I: 1&ndash;2 weeks; Grade II: 3&ndash;6; Grade III: months. Recovery by grade.</p></a>
      <a class="card usecase-card" href="/guides/how-long-do-broken-ribs-take-to-heal" style="text-decoration:none;"><div class="usecase-card-icon">R</div><h3>Broken Ribs</h3><p>Most heal in ~6 weeks; pain can linger months. Hairline vs displaced + red flags.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Recovery timelines at a glance</h2>
    <table class="comparison-table">
      <thead><tr><th>Injury</th><th>Severity</th><th>Typical heal time</th><th>Red flags (see a doctor)</th></tr></thead>
      <tbody>
        <tr><td rowspan="3">Sprained ankle</td><td>Grade I (mild)</td><td>1&ndash;3 weeks</td><td rowspan="3">Cannot bear weight, severe swelling, numbness, no improvement after a week</td></tr>
        <tr><td>Grade II (partial tear)</td><td>3&ndash;6 weeks</td></tr>
        <tr><td>Grade III (complete tear)</td><td>Several months</td></tr>
        <tr><td rowspan="2">Rib fracture</td><td>Hairline / undisplaced</td><td>~6 weeks (pain eases sooner)</td><td rowspan="2">Difficulty breathing, coughing blood, severe chest pain</td></tr>
        <tr><td>Displaced / multiple</td><td>6&ndash;12+ weeks</td></tr>
      </tbody>
    </table>
    <p style="font-size:0.8rem;color:var(--color-text-muted,#7c87a8);margin-top:.5rem;">Timelines drawn from AAOS OrthoInfo and other sources cited on each guide. Individual recovery varies; follow your clinician&rsquo;s advice.</p>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['health']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container">
    <h2 class="section-title">All healing &amp; recovery guides</h2>
    <div class="usecase-grid">
      <?php while ($cg->have_posts()): $cg->the_post(); ?>
        <a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">H</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a>
      <?php endwhile; ?>
    </div>
  </div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Healing FAQ</h2>
    <?php $faqs=[
      ['q'=>'Why does the same injury heal at very different speeds?','a'=>'Severity is the biggest factor. A &ldquo;sprained ankle&rdquo; ranges from a stretched ligament (Grade I, 1&ndash;2 weeks) to a complete tear (Grade III, months). Age, health, and how well you rehab also change the timeline substantially.'],
      ['q'=>'Can I walk on a broken rib?','a'=>'Usually yes &mdash; most rib fractures are treated with pain control and gentle activity, not immobilization. But difficulty breathing, coughing up blood, or severe pain are red flags that need urgent care. This is general information, not medical advice.'],
      ['q'=>'How do I know if an ankle is broken or just sprained?','a'=>'You often cannot tell without an X-ray. Signs that favor a fracture include being unable to bear any weight immediately after the injury, a visible deformity, and pain directly over a bone. Get imaging if in doubt.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"How Long to Heal — Injury Recovery Timelines","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-13","dateModified":"2026-08-13","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"Hub of injury recovery guides: how long a sprained ankle and broken ribs take to heal, by severity."}
</script>
<?php get_footer(); ?>
