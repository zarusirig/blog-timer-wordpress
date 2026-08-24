<?php
/** Template Name: Entertainment Durations Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Entertainment Timers','url'=>null]]); ?>
    <h1 class="page-h1">How Long Is It? Concerts, Movies &amp; Shows</h1>
    <p class="page-intro">Runtime intelligence before you buy the ticket: how long Hamilton runs, what a typical concert set lasts, average movie lengths by genre, and how long a Broadway show keeps you in your seat &mdash; with intermissions, encores and credits accounted for.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">EN</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-25 &middot; Curated entertainment-duration hub</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Plan the evening, not just the event. A pop concert is a 2&ndash;3 hour commitment including the opener; Hamilton runs about 2 hours 45 minutes with one intermission; the average movie now sits near two hours, with blockbusters pushing three. Every guide below gives the runtime, the breaks, and the total time you need a babysitter for.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Runtimes &mdash; by event type</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-is-hamilton" style="text-decoration:none;"><div class="usecase-card-icon">H</div><h3>Hamilton</h3><p>~2h 45m including intermission &mdash; act-by-act breakdown.</p></a>
      <a class="card usecase-card" href="/guides/how-long-is-a-concert" style="text-decoration:none;"><div class="usecase-card-icon">C</div><h3>Concerts</h3><p>Headline set 90&ndash;150 minutes; with opener, plan 2&ndash;3 hours.</p></a>
      <a class="card usecase-card" href="/guides/how-long-is-a-movie" style="text-decoration:none;"><div class="usecase-card-icon">M</div><h3>Movies</h3><p>Average feature ~2 hours; blockbusters run longer, by genre.</p></a>
      <a class="card usecase-card" href="/guides/how-long-is-a-broadway-show" style="text-decoration:none;"><div class="usecase-card-icon">B</div><h3>Broadway Shows</h3><p>Typically 2&ndash;3 hours with one 15&ndash;20 minute intermission.</p></a>
    </div>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['entertainment']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container">
    <h2 class="section-title">All entertainment-duration guides</h2>
    <div class="usecase-grid">
      <?php while ($cg->have_posts()): $cg->the_post(); ?>
        <a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">ET</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a>
      <?php endwhile; ?>
    </div>
  </div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Entertainment timing FAQ</h2>
    <?php $faqs=[
      ['q'=>'How long is a typical concert?','a'=>'A headline set usually runs 90&ndash;150 minutes. Add an opening act (30&ndash;45 minutes) and changeover, and most arena or theater concerts keep you there 2&ndash;3 hours total. Festivals are their own animal &mdash; full-day events.'],
      ['q'=>'Do movies include the credits in the runtime?','a'=>'Yes &mdash; the listed runtime includes credits. Credits typically run 5&ndash;10 minutes, so the story itself ends slightly earlier. Post-credit scenes can add a few more minutes for superhero releases.'],
      ['q'=>'How early should I arrive for a Broadway show?','a'=>'Arrive 20&ndash;30 minutes before curtain. Latecomers are often held in the lobby until a suitable break, which for some shows means missing the entire first scene.'],
      ['q'=>'Why are runtimes getting longer?','a'=>'Streaming-era economics reward &ldquo;event&rdquo; releases, so blockbusters have stretched toward 2.5&ndash;3 hours, and superstar tours pack 40+ songs into 2.5-hour sets. Musicals stay near 2.5 hours because intermission logistics cap the evening.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>

  <section class="section"><div class="container"><div class="cta-banner">
    <h2>Know the runtime. Plan the night.</h2>
    <p>Every guide gives the runtime, the breaks, and the full door-to-door commitment.</p>
    <a href="/guides/how-long-is-hamilton" class="btn btn--primary btn--large">Start with Hamilton</a>
  </div></div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"How Long Is It? Concerts, Movies & Shows","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-25","dateModified":"2026-08-25","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"How long Hamilton runs, typical concert lengths, average movie runtimes, and Broadway show durations — with intermissions and encores accounted for."}
</script>
<?php get_footer(); ?>
