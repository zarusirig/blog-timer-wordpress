<?php
/**
 * Template Name: Sous Vide Timer Page
 * Description: Sous vide cooking timer by food type, temperature, and doneness
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Sous Vide Timer &mdash; Precision Times for Every Food</h1>
        <p class="byline" style="font-size: 0.875rem; color: #666; margin: 0.5rem 0;">
            By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" rel="author">Suraj Giri</a>
            &middot; Home cook &amp; culinary researcher &middot; <em>Last updated: 2026-05-27</em>
        </p>
        <p class="page-intro">Set time and temperature for sous vide steak, chicken, pork, fish, eggs, and vegetables. Includes pasteurization tables for safe extended cooks and reference to Douglas Baldwin's <em>A Practical Guide to Sous Vide Cooking</em>.</p>
        <div class="tldr-box" style="background:#f5f8fb;border-left:4px solid #2563eb;padding:1rem 1.25rem;margin:1rem 0;border-radius:6px;">
            <strong>TL;DR:</strong> Sous vide cooks food in a temperature-controlled water bath at the exact target temperature, eliminating overcooking. Steak takes 1 to 3 hours at 130&deg;F for medium-rare. Chicken breast: 1.5 to 4 hours at 145&deg;F. Salmon: 30 to 45 minutes at 120&deg;F. Sous vide eggs: 45 minutes at 167&deg;F for the famous 63-degree onsen egg. Pasteurization happens over time as well as temperature &mdash; Douglas Baldwin's <em>A Practical Guide to Sous Vide Cooking</em> is the technical reference for safe time-temperature combinations.
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="7200"
             data-unit="minutes"
             data-value="120"
             data-mode="standard">
            <div class="timer-display">2:00:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Sous Vide Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Food Is Ready!</h3>
                <p>Remove the bag, dry the food thoroughly, then sear in a hot pan or with a torch to finish.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Common Sous Vide Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-45-minutes" class="btn btn--secondary"><strong>Salmon (120&deg;F)</strong><span>30&ndash;45 minutes</span></a>
                <a href="/timer/set-timer-for-45-minutes" class="btn btn--secondary"><strong>Sous Vide Egg (167&deg;F)</strong><span>45 minutes</span></a>
                <a href="/timer/set-timer-for-2-hours" class="btn btn--secondary"><strong>Steak (130&deg;F)</strong><span>1&ndash;3 hours</span></a>
                <a href="/timer/set-timer-for-2-hours" class="btn btn--secondary"><strong>Chicken Breast (145&deg;F)</strong><span>1.5&ndash;4 hours</span></a>
                <a href="/timer/set-timer-for-12-hours" class="btn btn--secondary"><strong>Pork Shoulder (165&deg;F)</strong><span>12&ndash;24 hours</span></a>
                <a href="/timer/set-timer-for-12-hours" class="btn btn--secondary"><strong>Short Ribs (155&deg;F)</strong><span>24&ndash;72 hours</span></a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sous Vide Time and Temperature Chart</h2>
            <p>Sous vide unsticks time from temperature. Below the cooking temperature, food cannot overcook in the traditional sense &mdash; meat just becomes more tender as collagen converts to gelatin over hours. The minimum times below are when the food has reached temperature throughout (heat-up time for a 1-inch piece). The maximums are when texture begins to degrade (proteins go mushy).</p>

            <h3>Beef</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-4) 0;">
                <thead><tr style="border-bottom:2px solid var(--color-border);"><th style="text-align:left;padding:var(--space-3);">Cut</th><th style="text-align:left;padding:var(--space-3);">Temperature</th><th style="text-align:left;padding:var(--space-3);">Time</th></tr></thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Steak (rare)</td><td style="padding:var(--space-3);">125&deg;F / 52&deg;C</td><td style="padding:var(--space-3);">1&ndash;2 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Steak (medium-rare)</td><td style="padding:var(--space-3);">130&deg;F / 54&deg;C</td><td style="padding:var(--space-3);">1&ndash;3 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Steak (medium)</td><td style="padding:var(--space-3);">140&deg;F / 60&deg;C</td><td style="padding:var(--space-3);">1&ndash;3 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Short Ribs (steak-like)</td><td style="padding:var(--space-3);">133&deg;F / 56&deg;C</td><td style="padding:var(--space-3);">48&ndash;72 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Short Ribs (braise-like)</td><td style="padding:var(--space-3);">165&deg;F / 74&deg;C</td><td style="padding:var(--space-3);">12&ndash;24 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Brisket (steak-like)</td><td style="padding:var(--space-3);">135&deg;F / 57&deg;C</td><td style="padding:var(--space-3);">36&ndash;72 hours</td></tr>
                    <tr><td style="padding:var(--space-3);">Brisket (traditional)</td><td style="padding:var(--space-3);">155&deg;F / 68&deg;C</td><td style="padding:var(--space-3);">24&ndash;36 hours</td></tr>
                </tbody>
            </table>

            <h3>Poultry</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-4) 0;">
                <thead><tr style="border-bottom:2px solid var(--color-border);"><th style="text-align:left;padding:var(--space-3);">Cut</th><th style="text-align:left;padding:var(--space-3);">Temperature</th><th style="text-align:left;padding:var(--space-3);">Time</th></tr></thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chicken Breast (juicy)</td><td style="padding:var(--space-3);">140&deg;F / 60&deg;C</td><td style="padding:var(--space-3);">1.5&ndash;4 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chicken Breast (traditional)</td><td style="padding:var(--space-3);">150&deg;F / 66&deg;C</td><td style="padding:var(--space-3);">1&ndash;4 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chicken Thighs (tender)</td><td style="padding:var(--space-3);">165&deg;F / 74&deg;C</td><td style="padding:var(--space-3);">1&ndash;4 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chicken Thighs (confit)</td><td style="padding:var(--space-3);">170&deg;F / 77&deg;C</td><td style="padding:var(--space-3);">4&ndash;8 hours</td></tr>
                    <tr><td style="padding:var(--space-3);">Turkey Breast</td><td style="padding:var(--space-3);">145&deg;F / 63&deg;C</td><td style="padding:var(--space-3);">2&ndash;4 hours</td></tr>
                </tbody>
            </table>

            <h3>Pork</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-4) 0;">
                <thead><tr style="border-bottom:2px solid var(--color-border);"><th style="text-align:left;padding:var(--space-3);">Cut</th><th style="text-align:left;padding:var(--space-3);">Temperature</th><th style="text-align:left;padding:var(--space-3);">Time</th></tr></thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Pork Chop (medium)</td><td style="padding:var(--space-3);">140&deg;F / 60&deg;C</td><td style="padding:var(--space-3);">1&ndash;4 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Pork Tenderloin</td><td style="padding:var(--space-3);">135&deg;F / 57&deg;C</td><td style="padding:var(--space-3);">1&ndash;4 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Pork Shoulder (pulled)</td><td style="padding:var(--space-3);">165&deg;F / 74&deg;C</td><td style="padding:var(--space-3);">24&ndash;36 hours</td></tr>
                    <tr><td style="padding:var(--space-3);">Pork Belly</td><td style="padding:var(--space-3);">170&deg;F / 77&deg;C</td><td style="padding:var(--space-3);">8&ndash;12 hours</td></tr>
                </tbody>
            </table>

            <h3>Fish &amp; Eggs</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-4) 0;">
                <thead><tr style="border-bottom:2px solid var(--color-border);"><th style="text-align:left;padding:var(--space-3);">Food</th><th style="text-align:left;padding:var(--space-3);">Temperature</th><th style="text-align:left;padding:var(--space-3);">Time</th></tr></thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Salmon (silky)</td><td style="padding:var(--space-3);">115&deg;F / 46&deg;C</td><td style="padding:var(--space-3);">30&ndash;45 min</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Salmon (medium)</td><td style="padding:var(--space-3);">125&deg;F / 52&deg;C</td><td style="padding:var(--space-3);">30&ndash;45 min</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Cod / White Fish</td><td style="padding:var(--space-3);">130&deg;F / 54&deg;C</td><td style="padding:var(--space-3);">30&ndash;45 min</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Onsen Egg (63&deg;)</td><td style="padding:var(--space-3);">145&deg;F / 63&deg;C</td><td style="padding:var(--space-3);">45 min</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Soft-Set Egg</td><td style="padding:var(--space-3);">167&deg;F / 75&deg;C</td><td style="padding:var(--space-3);">13 min</td></tr>
                    <tr><td style="padding:var(--space-3);">Hard-Set Egg</td><td style="padding:var(--space-3);">194&deg;F / 90&deg;C</td><td style="padding:var(--space-3);">11 min</td></tr>
                </tbody>
            </table>

            <h3>Vegetables</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-4) 0;">
                <thead><tr style="border-bottom:2px solid var(--color-border);"><th style="text-align:left;padding:var(--space-3);">Vegetable</th><th style="text-align:left;padding:var(--space-3);">Temperature</th><th style="text-align:left;padding:var(--space-3);">Time</th></tr></thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Carrots / Parsnips / Beets</td><td style="padding:var(--space-3);">185&deg;F / 85&deg;C</td><td style="padding:var(--space-3);">1&ndash;2 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Potatoes (whole, baby)</td><td style="padding:var(--space-3);">185&deg;F / 85&deg;C</td><td style="padding:var(--space-3);">1&ndash;2 hours</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Asparagus</td><td style="padding:var(--space-3);">185&deg;F / 85&deg;C</td><td style="padding:var(--space-3);">10&ndash;15 min</td></tr>
                    <tr><td style="padding:var(--space-3);">Broccoli</td><td style="padding:var(--space-3);">185&deg;F / 85&deg;C</td><td style="padding:var(--space-3);">20&ndash;30 min</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How Sous Vide Works</h2>
            <p>Sous vide &mdash; French for "under vacuum" &mdash; cooks food sealed in a plastic bag, submerged in water held at the food's target final temperature. The food cannot exceed the water temperature, so unlike pan-searing or roasting, there is no overshoot. A steak cooked sous vide at 130&deg;F finishes at exactly 130&deg;F internal, edge to edge.</p>

            <p>The method was developed in the 1970s by French chefs <a href="https://fr.wikipedia.org/wiki/Georges_Pralus" target="_blank" rel="noopener">Georges Pralus</a> and Bruno Goussault, originally for foie gras at Restaurant Troisgros and for industrial food production. It entered home kitchens with the launch of the Anova circulator (2014) and Joule (2016), which brought temperature-controlled water baths under $200. The technique is now mainstream &mdash; Modernist Cuisine treats it as standard equipment, and Kenji L&oacute;pez-Alt's <em>The Food Lab</em> has detailed sous-vide guides for every major protein.</p>

            <p>The technical reference is <a href="https://douglasbaldwin.com/sous-vide.html" target="_blank" rel="noopener">Douglas Baldwin's <em>A Practical Guide to Sous Vide Cooking</em></a>, freely available online and used as the safety reference by ChefSteps, Anova, and most commercial sous-vide producers. Baldwin's pasteurization tables, derived from FDA Food Code thermal-process calculations, are the standard for safe long-cook timing.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Pasteurization: Time as a Safety Variable</h2>
            <p>The USDA's instant-kill temperature for <em>Salmonella</em> is 165&deg;F. But pasteurization is also a function of time at lower temperatures. At 145&deg;F, chicken is pasteurized after about 8.5 minutes once the entire piece reaches temperature; at 140&deg;F, after about 27 minutes; at 135&deg;F, after about 89 minutes. This is why sous vide chicken at 145&deg;F for 90 minutes is safer than oven-roasted chicken at 165&deg;F for 20 minutes &mdash; the lower temperature kills the same pathogens with extended exposure, and the meat is dramatically juicier.</p>

            <p>Baldwin's pasteurization tables (downloadable as a free PDF from his website) show the time-at-temperature required to achieve a 6.5-log reduction in <em>Salmonella</em> for poultry and a 6.5-log reduction in <em>Listeria</em> and <em>E. coli</em> for beef. For at-risk eaters (pregnant individuals, young children, elderly, immunocompromised) the safer choice is the higher-temperature/shorter-time combinations &mdash; these provide the same kill rate with less reliance on extended hold times.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Equipment and Technique</h2>

            <h3>Circulator</h3>
            <p>An immersion circulator clamps to any pot, heats the water with a resistive coil, and circulates it with a small impeller. The Anova Precision Cooker and the Breville Joule are the two best-known consumer models. Both are accurate to 0.1&deg;F and hold temperature for days.</p>

            <h3>Bag Sealing</h3>
            <p>A chamber vacuum sealer is the gold standard, but a $40 Foodsaver or a zipper bag with the water-displacement method works fine. To displace air with a zipper bag: place food in the bag, lower into the water bath until the air is squeezed out by water pressure, then seal at the surface. This is the most common home method.</p>

            <h3>Finishing</h3>
            <p>Sous vide does not produce a brown crust because the water temperature is well below the Maillard threshold (285&deg;F+). The finishing sear is essential. Pat the food completely dry with paper towels, then sear 60&ndash;90 seconds per side in a screaming hot cast-iron pan with high-smoke-point oil. A butane torch (the Iwatani Torch is the food-publication favorite) is also effective, especially for tricky shapes.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Sous Vide Mistakes</h2>

            <h3>Not Drying Before Searing</h3>
            <p>Water on the surface steams instead of browning. Pat the food completely dry with paper towels (some chefs even use a hair dryer on cold setting) before searing.</p>

            <h3>Searing Too Long</h3>
            <p>The food is already cooked. The sear only needs to develop color &mdash; 60 to 90 seconds per side, no more. Longer cooking pushes the gray band of overcooked meat back into the perfectly-cooked interior.</p>

            <h3>Cooking Below 130&deg;F for Extended Times</h3>
            <p>Bacterial growth zone is 40&ndash;130&deg;F. Cooking below 130&deg;F is considered safe only for short cooks (under 4 hours) of intact-muscle proteins (steak, fish). For poultry and ground meat, follow Baldwin's pasteurization tables.</p>

            <h3>Reusing Bags</h3>
            <p>Standard zipper and vacuum bags are food-safe for one cook. The plastic stresses under heat over long cooks; do not reuse for multiple sessions.</p>

            <h3>Overcrowding the Bath</h3>
            <p>Water needs to circulate around each bag. If you stack bags or pack them tightly, the centers cook slower and the timing in the chart no longer applies.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Sous Vide Timer FAQ</h2>

            <div class="faq-list">
                <div class="faq-item"><button class="faq-question" type="button"><span>How long do I sous vide a steak?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>1 to 3 hours at 130&deg;F for medium-rare on a 1- to 1.5-inch steak. The 1-hour minimum is the time for the center to reach temperature; 3 hours is the maximum before the texture starts to soften from extended heat.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What temperature for sous vide chicken breast?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>145&deg;F for juicy modern-style chicken breast (cook for 1.5 to 4 hours), 150&deg;F for traditional texture. The USDA's 165&deg;F instant-kill threshold is not necessary when the chicken is held at 145&deg;F for the time required by Baldwin's pasteurization table.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Is sous vide chicken safe at 145&deg;F?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes &mdash; provided the chicken is held at 145&deg;F for at least 8.5 minutes after reaching temperature throughout. This achieves the same pasteurization as 165&deg;F instantaneously. Baldwin's tables document the science.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Can I sous vide frozen meat?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes. Add about 60 minutes to the cook time to allow for thawing in the bath. The water bath thaws and cooks in a single step.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How long can I leave food in the water bath?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Up to the maximum time in the chart above. For steak, 3 hours; for tough cuts like short ribs and chuck, up to 72 hours. Beyond the maximum, the texture becomes unpleasantly mushy as proteins continue to break down.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Why does sous vide food need to be seared?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Sous vide cooks at temperatures well below the 285&deg;F threshold for the Maillard browning reaction, so the surface stays pale and lacks the roasted-flavor compounds that come from high-heat searing. The finishing sear is what gives sous vide steak its complete flavor profile.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Do I need a vacuum sealer?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>No. Zipper bags with the water-displacement method work fine for cooks under 4 hours. For multi-day cooks, a vacuum sealer is more reliable because it eliminates the small bubbles that can compromise the seal.</p></div></div>
            </div>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Recipe",
  "name": "How to Sous Vide a Steak",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "datePublished": "2026-05-27",
  "description": "Cook a perfect medium-rare steak using sous vide and a finishing sear.",
  "prepTime": "PT5M",
  "cookTime": "PT2H",
  "totalTime": "PT2H10M",
  "recipeYield": "1 serving",
  "recipeCategory": "Main Course",
  "recipeIngredient": ["1 inch thick ribeye or strip steak", "Kosher salt", "Black pepper", "Garlic and thyme (optional)", "High smoke-point oil for searing"],
  "recipeInstructions": [
    {"@type": "HowToStep", "text": "Preheat sous vide bath to 130°F (54°C)."},
    {"@type": "HowToStep", "text": "Season steak and seal in bag with aromatics."},
    {"@type": "HowToStep", "text": "Submerge for 1 to 3 hours."},
    {"@type": "HowToStep", "text": "Remove, pat completely dry with paper towels."},
    {"@type": "HowToStep", "text": "Sear 60 to 90 seconds per side in screaming hot cast iron with neutral oil."}
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Sous Vide Timer — Precision Times for Every Food",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>

<?php get_footer(); ?>
