<?php
/** Template Name: Food Storage & Shelf Life Hub */
get_header(); ?>
<main id="main" tabindex="-1" class="site-main content-page">
  <div class="container container--narrow">
    <?php blogtimer_render_breadcrumb_nav([['label'=>'Home','url'=>home_url('/')],['label'=>'Food Storage Timers','url'=>null]]); ?>
    <h1 class="page-h1">How Long Does Food Last? Fridge &amp; Pantry Shelf Life</h1>
    <p class="page-intro">USDA-cited storage times for the foods people actually google: hard-boiled eggs, raw eggs, cooked chicken, rice, cheesecake, rotisserie chicken, flour, honey, butter, coffee and peanut butter &mdash; plus the spoilage signs and food-safety rules that decide toss-versus-eat.</p>
    <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);flex-shrink:0;">FS</div>
      <div style="flex:1;min-width:240px;">
        <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a></div>
        <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-08-28 &middot; Curated food-storage hub</div>
      </div>
    </div>
    <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
      <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR</strong>
      <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">Two numbers run every kitchen: the 2-hour rule (perishables out of the fridge) and the 3&ndash;4 day rule (most cooked leftovers). Hard-boiled eggs beat that at about a week; honey never spoils at all. When in doubt, the smell test is not a safety test &mdash; toss on doubt, and check the per-food guide below for the USDA numbers.</p>
    </div>
  </div>

  <section class="section"><div class="container">
    <h2 class="section-title">Fridge &amp; pantry guides</h2>
    <div class="usecase-grid">
      <a class="card usecase-card" href="/guides/how-long-do-hard-boiled-eggs-last-in-the-fridge" style="text-decoration:none;"><div class="usecase-card-icon">BE</div><h3>Hard-Boiled Eggs</h3><p>Up to 1 week refrigerated &mdash; peeled or unpeeled.</p></a>
      <a class="card usecase-card" href="/guides/how-long-do-eggs-last-in-the-fridge" style="text-decoration:none;"><div class="usecase-card-icon">RE</div><h3>Raw Eggs</h3><p>3&ndash;5 weeks in shell; the float test, explained honestly.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-cooked-chicken-last-in-the-fridge" style="text-decoration:none;"><div class="usecase-card-icon">CC</div><h3>Cooked Chicken</h3><p>3&ndash;4 days refrigerated; 2 hours max on the counter.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-rice-last-in-the-fridge" style="text-decoration:none;"><div class="usecase-card-icon">RI</div><h3>Cooked Rice</h3><p>3&ndash;4 days &mdash; and why rice needs fast cooling.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-a-rotisserie-chicken-last" style="text-decoration:none;"><div class="usecase-card-icon">RC</div><h3>Rotisserie Chicken</h3><p>3&ndash;4 days from purchase; carve it off the bones.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-cheesecake-last" style="text-decoration:none;"><div class="usecase-card-icon">CK</div><h3>Cheesecake</h3><p>5&ndash;7 days refrigerated; freeze for 2&ndash;3 months.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-flour-last" style="text-decoration:none;"><div class="usecase-card-icon">FL</div><h3>Flour</h3><p>White 1&ndash;2 years; whole wheat just 3&ndash;6 months.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-honey-last" style="text-decoration:none;"><div class="usecase-card-icon">HN</div><h3>Honey</h3><p>Indefinite &mdash; crystallization is not spoilage.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-butter-last" style="text-decoration:none;"><div class="usecase-card-icon">BU</div><h3>Butter</h3><p>1&ndash;3 months in the fridge; up to a year frozen.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-coffee-last" style="text-decoration:none;"><div class="usecase-card-icon">CO</div><h3>Coffee</h3><p>Beans peak 2&ndash;4 weeks post-roast; ground fades faster.</p></a>
      <a class="card usecase-card" href="/guides/how-long-does-peanut-butter-last" style="text-decoration:none;"><div class="usecase-card-icon">PB</div><h3>Peanut Butter</h3><p>Opened jar 2&ndash;3 months in the pantry; natural needs the fridge.</p></a>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <h2 class="section-title">Shelf life at a glance</h2>
    <table class="comparison-table">
      <thead><tr><th>Food</th><th>Fridge</th><th>Counter</th><th>Freezer</th><th>Spoils by</th></tr></thead>
      <tbody>
        <tr><td>Hard-boiled eggs</td><td>1 week</td><td>2 hours</td><td>Not recommended</td><td>Smell, sulfur, sliminess</td></tr>
        <tr><td>Raw eggs (in shell)</td><td>3&ndash;5 weeks</td><td>&mdash; (wash rules)</td><td>1 year (beaten)</td><td>Off-smell, off-color</td></tr>
        <tr><td>Cooked chicken</td><td>3&ndash;4 days</td><td>2 hours</td><td>3&ndash;4 months</td><td>Smell, slime, mold</td></tr>
        <tr><td>Cooked rice</td><td>3&ndash;4 days</td><td>1 hour (cool fast)</td><td>1&ndash;2 months</td><td>Hard, dry, off-smell</td></tr>
        <tr><td>Rotisserie chicken</td><td>3&ndash;4 days</td><td>2 hours</td><td>3&ndash;4 months</td><td>Smell, slime</td></tr>
        <tr><td>Cheesecake</td><td>5&ndash;7 days</td><td>2 hours</td><td>2&ndash;3 months</td><td>Sour smell, weeping, mold</td></tr>
        <tr><td>White flour</td><td>&mdash;</td><td>1&ndash;2 years sealed</td><td>Extends life</td><td>Rancid smell, weevils</td></tr>
        <tr><td>Honey</td><td>&mdash;</td><td>Indefinite</td><td>&mdash;</td><td>Never (crystals are fine)</td></tr>
      </tbody>
    </table>
  </div></section>

  <?php $cg = new WP_Query(['post_type'=>'guide','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC','no_found_rows'=>true,'tax_query'=>[['taxonomy'=>'guide_cluster','field'=>'slug','terms'=>['foodstorage']]]]);
  if ($cg->have_posts()): ?>
  <section class="section"><div class="container">
    <h2 class="section-title">All food-storage guides</h2>
    <div class="usecase-grid">
      <?php while ($cg->have_posts()): $cg->the_post(); ?>
        <a class="card usecase-card guide-card" href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration:none;"><div class="usecase-card-icon">FD</div><h3><?php the_title(); ?></h3><?php if (get_the_excerpt()): ?><p><?php echo esc_html(wp_trim_words(get_the_excerpt(),16)); ?></p><?php endif; ?></a>
      <?php endwhile; ?>
    </div>
  </div></section>
  <?php endif; wp_reset_postdata(); ?>

  <section class="section"><div class="container container--narrow">
    <h2 class="section-title">Food storage FAQ</h2>
    <?php $faqs=[
      ['q'=>'What is the 2-hour rule?','a'=>'Perishable food should not sit between 4&deg;C and 60&deg;C (40&ndash;140&deg;F) for more than 2 hours &mdash; 1 hour if the room is above 32&deg;C. That window is when bacteria multiply fastest. After it, USDA guidance says discard, even if the food looks and smells fine.'],
      ['q'=>'Is the egg float test reliable?','a'=>'It tells you an egg is OLD, not that it is UNSAFE. Old eggs float because air cells grow inside the shell. An old egg that has stayed refrigerated is usually still safe; a fresh-looking egg that was left out is not. Use the float test for freshness, refrigeration history for safety.'],
      ['q'=>'Why is cooked rice riskier than other leftovers?','a'=>'Bacillus cereus spores survive normal cooking temperatures. If cooked rice sits warm for hours, those spores can multiply and form toxins that reheating does not destroy. Cool rice within an hour, refrigerate, and reheat once, steaming hot.'],
      ['q'=>'Can I freeze leftovers to restart the clock?','a'=>'Freezing pauses bacterial growth almost completely, so yes &mdash; freeze within the safe fridge window and most cooked foods keep 2&ndash;4 months at good quality (safe indefinitely, quality declines). Thaw in the fridge, never on the counter, and do not refreeze thawed cooked food.'],
    ]; echo blogtimer_render_faq($faqs); ?>
  </div></section>

  <section class="section"><div class="container"><div class="cta-banner">
    <h2>Check it before you smell it.</h2>
    <p>USDA-cited storage times for the foods in your fridge right now.</p>
    <a href="/guides/how-long-do-hard-boiled-eggs-last-in-the-fridge" class="btn btn--primary btn--large">Start with eggs</a>
  </div></div></section>
</main>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Article","headline":"How Long Does Food Last? Fridge & Pantry Shelf Life","author":{"@id":"<?php echo home_url('/author-suraj-giri'); ?>#person"},"publisher":{"@id":"<?php echo home_url('/#organization'); ?>"},"datePublished":"2026-08-25","dateModified":"2026-08-25","mainEntityOfPage":"<?php echo esc_url(get_permalink()); ?>","description":"USDA-cited fridge and pantry storage times for eggs, cooked chicken, rice, cheesecake, flour, honey and more — with spoilage signs and the 2-hour rule."}
</script>
<?php get_footer(); ?>
