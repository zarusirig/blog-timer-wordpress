<?php
/**
 * Template Name: Coffee Timer Page
 * Description: Coffee brewing timer for pour-over, French press, espresso, and cold brew
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Coffee Brew Timer &mdash; Pour Over, French Press, Espresso, Cold Brew</h1>
        <p class="byline" style="font-size: 0.875rem; color: #666; margin: 0.5rem 0;">
            By <a href="<?php echo esc_url(home_url('/author-suraj-giri')); ?>" rel="author">Suraj Giri</a>
            &middot; Home barista &amp; coffee researcher &middot; <em>Last updated: 2026-05-27</em>
        </p>
        <p class="page-intro">Brew better coffee with method-specific timing. Use the presets for pour-over, French press, espresso, AeroPress, cold brew, and Chemex &mdash; each tuned to the SCA brew guideline and the recipes published by James Hoffmann.</p>
        <div class="tldr-box" style="background:#f5f8fb;border-left:4px solid #2563eb;padding:1rem 1.25rem;margin:1rem 0;border-radius:6px;">
            <strong>TL;DR:</strong> Pour-over and French press both target 4 minutes of contact time. Espresso is a 25&ndash;30 second extraction at 9 bars of pressure. AeroPress runs 1 to 2 minutes depending on the recipe. Cold brew steeps 12 to 24 hours in the refrigerator. Chemex is slightly longer at 4 to 5 minutes due to the thicker filter. The <a href="https://sca.coffee/" target="_blank" rel="noopener">Specialty Coffee Association</a> defines the target brew strength at 1.15&ndash;1.35% TDS with 18&ndash;22% extraction.
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="240"
             data-unit="minutes"
             data-value="4"
             data-mode="standard">
            <div class="timer-display">4:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Coffee Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Coffee Is Ready!</h3>
                <p>Decant immediately to stop extraction. Serve.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Brewing Method Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-30-seconds" class="btn btn--secondary"><strong>Espresso Shot</strong><span>25&ndash;30 seconds</span></a>
                <a href="/timer/set-timer-for-1-minutes" class="btn btn--secondary"><strong>AeroPress (fast)</strong><span>1&ndash;2 minutes</span></a>
                <a href="/timer/set-timer-for-3-minutes" class="btn btn--secondary"><strong>Moka Pot</strong><span>3&ndash;5 minutes</span></a>
                <a href="/timer/set-timer-for-4-minutes" class="btn btn--secondary"><strong>Pour Over / V60</strong><span>3&ndash;4 minutes</span></a>
                <a href="/timer/set-timer-for-4-minutes" class="btn btn--secondary"><strong>French Press</strong><span>4 minutes</span></a>
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary"><strong>Chemex</strong><span>4&ndash;5 minutes</span></a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Coffee Brewing Time Chart</h2>
            <p>Each method below has its own ideal brew ratio (coffee-to-water) and contact time. The ratios reflect the SCA Golden Cup standard, refined by recipes from <a href="https://www.jameshoffmann.co.uk/" target="_blank" rel="noopener">James Hoffmann's</a> YouTube channel and his book <em>The World Atlas of Coffee</em>.</p>

            <table style="width:100%;border-collapse:collapse;margin:var(--space-6) 0;">
                <thead>
                    <tr style="border-bottom:2px solid var(--color-border);">
                        <th style="text-align:left;padding:var(--space-3);">Method</th>
                        <th style="text-align:left;padding:var(--space-3);">Brew Time</th>
                        <th style="text-align:left;padding:var(--space-3);">Coffee : Water</th>
                        <th style="text-align:left;padding:var(--space-3);">Grind Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Espresso</td><td style="padding:var(--space-3);">25&ndash;30 seconds</td><td style="padding:var(--space-3);">1:2 (18 g in, 36 g out)</td><td style="padding:var(--space-3);">Fine</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">AeroPress (standard)</td><td style="padding:var(--space-3);">1:30&ndash;2:00 minutes</td><td style="padding:var(--space-3);">1:14 (15 g : 210 g)</td><td style="padding:var(--space-3);">Medium-fine</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Moka Pot</td><td style="padding:var(--space-3);">3&ndash;5 minutes</td><td style="padding:var(--space-3);">Fills the basket</td><td style="padding:var(--space-3);">Fine to medium-fine</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">V60 Pour Over (Hoffmann recipe)</td><td style="padding:var(--space-3);">3:30 minutes</td><td style="padding:var(--space-3);">1:16.6 (15 g : 250 g)</td><td style="padding:var(--space-3);">Medium</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Kalita Wave</td><td style="padding:var(--space-3);">3:30 minutes</td><td style="padding:var(--space-3);">1:16 (25 g : 400 g)</td><td style="padding:var(--space-3);">Medium</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chemex (6-cup)</td><td style="padding:var(--space-3);">4&ndash;5 minutes</td><td style="padding:var(--space-3);">1:15 (42 g : 630 g)</td><td style="padding:var(--space-3);">Medium-coarse</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">French Press</td><td style="padding:var(--space-3);">4 minutes (then plunge)</td><td style="padding:var(--space-3);">1:15 (50 g : 750 g)</td><td style="padding:var(--space-3);">Coarse</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Siphon (vacuum)</td><td style="padding:var(--space-3);">1&ndash;2 minutes brew</td><td style="padding:var(--space-3);">1:15</td><td style="padding:var(--space-3);">Medium</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Cold Brew (concentrate)</td><td style="padding:var(--space-3);">12&ndash;16 hours</td><td style="padding:var(--space-3);">1:8 to 1:10</td><td style="padding:var(--space-3);">Coarse</td></tr>
                    <tr><td style="padding:var(--space-3);">Cold Brew (ready-to-drink)</td><td style="padding:var(--space-3);">16&ndash;24 hours</td><td style="padding:var(--space-3);">1:15</td><td style="padding:var(--space-3);">Coarse</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Science of Coffee Extraction</h2>
            <p>Brewing coffee is a controlled extraction: hot water dissolves soluble compounds from ground coffee in a predictable order. The first compounds to extract are acids and fruity esters &mdash; the brightness and citrus notes. Next come the caramelized sugars and Maillard products that give body and sweetness. Last come the bitter compounds, particularly chlorogenic acid lactones and trigonelline degradation products. A perfect brew stops mid-curve, after the sweetness has been pulled out but before the bitterness takes over.</p>

            <p>The Specialty Coffee Association formalized this in the Golden Cup standard: <strong>18&ndash;22% extraction yield</strong> (the percentage of soluble mass dissolved from the coffee) at <strong>1.15&ndash;1.35% TDS</strong> (total dissolved solids in the final cup). Below 18% extraction, the brew is under-extracted: sour, thin, salty. Above 22%, it is over-extracted: bitter, hollow, astringent. Time, grind size, and water temperature are the three levers that control where you land on that curve.</p>

            <p>This framework is rigorously documented in Scott Rao's <em>The Professional Barista's Handbook</em> and updated in his <em>Coffee Brewing Handbook</em>, which together remain the standard references for commercial extraction theory. The cafe-driven refinement of these recipes is captured in James Hoffmann's <em>The World Atlas of Coffee</em>, and the broader food-science underpinnings appear in Harold McGee's <em>On Food and Cooking</em>.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Method-by-Method Brew Notes</h2>

            <h3>Pour Over (V60, Origami, Kalita Wave)</h3>
            <p>Hoffmann's "best V60 technique" recipe pours 50 g of bloom water on 15 g of grounds, waits 45 seconds, then adds water in two more pulses to reach 250 g total. Total brew time is 3:30. Use 95&deg;C water, a medium grind, and tap the dripper to settle the bed before the final drawdown.</p>

            <h3>Chemex</h3>
            <p>The thicker bonded paper filter Chemex uses (20&ndash;30% heavier than V60 paper) traps more oils and fines, producing a cleaner, brighter cup but also slowing flow. Grind one notch coarser than for V60. Total brew time runs 4 to 5 minutes for a 6-cup setup.</p>

            <h3>French Press</h3>
            <p>The Hoffmann method: 60 g coffee in 1 L of water, coarse grind, stir at 4 minutes to break the crust, skim the floating grounds, then leave it for another 4 to 5 minutes without plunging. Decant carefully without disturbing the sediment. This yields a cleaner cup than the traditional plunge method.</p>

            <h3>Espresso</h3>
            <p>The standard double shot pulls 36 g of espresso from 18 g of finely ground coffee in 25 to 30 seconds at 9 bars of pressure (the standard set by Achille Gaggia's 1947 lever machine and codified by every commercial machine since). Water temperature is 92&ndash;96&deg;C. The crema layer on top is colloidal CO&#8322; foam from the high-pressure extraction.</p>

            <h3>AeroPress</h3>
            <p>The 2008 Tim Wendelboe recipe is the canonical inverted method: 15 g coffee, 220 g water at 80&deg;C, stir, steep 1:30, then press for 30 seconds. The 2017 World AeroPress Championship winning recipe uses a finer grind and shorter steep. Both produce a clean, low-acid cup.</p>

            <h3>Cold Brew</h3>
            <p>The Toddy method (patented 1964) uses a 1:8 coffee-to-water ratio and 12&ndash;16 hours at room temperature. The Hario Mizudashi and most home methods steep in the refrigerator for 16 to 24 hours. Cold brew has roughly 67% less acidity than hot-brewed coffee because the cold water does not extract chlorogenic acids efficiently.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Coffee Brewing Mistakes</h2>

            <h3>Using Pre-Ground Coffee</h3>
            <p>Ground coffee loses 60% of its aromatic compounds within 15 minutes of grinding. Buy whole beans and grind immediately before brewing. The difference is more dramatic than any other variable.</p>

            <h3>Wrong Grind Size for the Method</h3>
            <p>Espresso needs fine. French press needs coarse. Using one grind for everything produces unbalanced extraction every time. A burr grinder is the single most impactful upgrade for home brewers.</p>

            <h3>Water Too Hot or Too Cool</h3>
            <p>Boiling water (212&deg;F) is too hot for direct brewing &mdash; it scalds the grounds and accelerates bitter extraction. Target 195&ndash;205&deg;F (90&ndash;96&deg;C). Below 185&deg;F, extraction stalls and the cup is sour.</p>

            <h3>Inconsistent Pouring</h3>
            <p>For pour-over methods, an uneven pour creates channels through the bed where water bypasses the grounds. A gooseneck kettle and a slow, controlled spiral pour solve this. The <a href="https://en.wikipedia.org/wiki/Hario_V60" target="_blank" rel="noopener">Hario Buono</a> and Fellow Stagg EKG are the most cited gooseneck kettles in the specialty coffee community.</p>

            <h3>Skipping the Bloom</h3>
            <p>Fresh coffee releases CO&#8322; on contact with water, which physically pushes water away from the grounds. A 30 to 45 second bloom &mdash; pouring about 2x the coffee weight in water and waiting &mdash; degasses the bed so the main pour extracts evenly.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Caffeine, Safety, and Storage</h2>
            <p>A 12 oz cup of brewed coffee contains roughly 95&ndash;200 mg of caffeine; a double espresso, 60&ndash;130 mg; cold brew, 150&ndash;250 mg per 12 oz. The <a href="https://www.fda.gov/consumers/consumer-updates/spilling-beans-how-much-caffeine-too-much" target="_blank" rel="noopener">FDA</a> identifies 400 mg daily as the upper limit for healthy adults. Pure caffeine powder is dangerous; the FDA has issued repeated consumer warnings against unmeasured caffeine supplements.</p>

            <p>Whole-bean coffee is best within 2 to 4 weeks of roast date for peak flavor, though it remains safe to drink for months. Store in an airtight, opaque container at room temperature &mdash; not in the refrigerator (humidity damages the beans) and not in the freezer for short-term use (condensation cycles cause flavor loss). Cold brew concentrate keeps in the fridge for 2 weeks; ready-to-drink cold brew, 7 to 10 days.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Coffee Timer FAQ</h2>

            <div class="faq-list">
                <div class="faq-item"><button class="faq-question" type="button"><span>How long should I brew a French press?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Four minutes from the moment hot water touches the grounds. Stir at the 4-minute mark, then either plunge immediately (traditional) or leave it for 4 more minutes to settle and decant (Hoffmann method).</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What is the right water temperature for pour-over?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>95&deg;C / 203&deg;F is the SCA-recommended midpoint. Lighter roasts can handle the high end (96&ndash;98&deg;C); darker roasts taste smoother at 90&ndash;92&deg;C because they extract more aggressively.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How long does an espresso shot take?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>25 to 30 seconds from the moment the pump engages until you stop the shot. Anything shorter is under-extracted and sour; anything longer is over-extracted and bitter. Adjust the grind, not the time.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How long should cold brew steep?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>12 to 24 hours in the refrigerator. At 12 hours you get a brighter, more acidic cup; at 24 hours, deeper and heavier. Beyond 24 hours, extraction continues to pull bitter compounds. Most home recipes settle on 16 to 18 hours.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Why does my coffee taste sour or bitter?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Sour means under-extracted: grind finer, brew longer, or use hotter water. Bitter means over-extracted: grind coarser, brew shorter, or use slightly cooler water. The cup should taste sweet, balanced, and full.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Is AeroPress espresso real espresso?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>No. Real espresso requires 9 bars of pressure, which an AeroPress cannot generate. AeroPress produces a concentrated coffee that approximates espresso flavor in some recipes, but it lacks the pressure-driven crema and emulsification.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Should I weigh my coffee?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes. Volume measurements (scoops, tablespoons) vary by roast, grind, and bean density. A scale gives you a reliable brew ratio and is the single biggest accuracy improvement after a burr grinder.</p></div></div>
            </div>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Recipe",
  "name": "How to Brew Pour-Over Coffee",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "datePublished": "2026-05-27",
  "description": "Brew a balanced pour-over coffee using the SCA Golden Cup ratio and James Hoffmann's V60 technique.",
  "prepTime": "PT2M",
  "cookTime": "PT4M",
  "totalTime": "PT6M",
  "recipeYield": "1 cup",
  "recipeCategory": "Beverage",
  "recipeIngredient": ["15 g freshly ground coffee (medium grind)", "250 g filtered water at 95°C"],
  "recipeInstructions": [
    {"@type": "HowToStep", "text": "Rinse the paper filter with hot water and discard."},
    {"@type": "HowToStep", "text": "Add 15 g coffee to the dripper and tare the scale."},
    {"@type": "HowToStep", "text": "Pour 50 g water for the bloom; wait 45 seconds."},
    {"@type": "HowToStep", "text": "Pour to 150 g over 30 seconds, then to 250 g over the next 30 seconds."},
    {"@type": "HowToStep", "text": "Total drawdown finishes around 3:30 to 4:00."}
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Coffee Brew Timer — Pour Over, French Press, Espresso, Cold Brew",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>

<?php get_footer(); ?>
