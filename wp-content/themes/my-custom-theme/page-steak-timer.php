<?php
/**
 * Template Name: Steak Timer Page
 * Description: Steak cooking and resting timer by cut, thickness, doneness, and method
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Steak Timer &mdash; Perfect Doneness for Every Cut</h1>
        <p class="byline" style="font-size: 0.875rem; color: #666; margin: 0.5rem 0;">
            By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a>
            &middot; Home cook &amp; culinary researcher &middot; <em>Last updated: 2026-05-27</em>
        </p>
        <p class="page-intro">Cook steak to your exact target temperature and rest it properly. Use the chart below to match cooking time to cut, thickness, doneness, and method (grill, pan-sear, sous vide, reverse-sear, oven).</p>
        <div class="tldr-box" style="background:#f5f8fb;border-left:4px solid #2563eb;padding:1rem 1.25rem;margin:1rem 0;border-radius:6px;">
            <strong>TL;DR:</strong> A 1-inch steak takes 3&ndash;4 minutes per side over high heat for medium-rare (130&ndash;135&deg;F internal). Always pull the steak 5&deg;F below your target &mdash; carryover cooking finishes the job during the rest. Rest at least 5 minutes for a 1-inch cut, 10 minutes for thick-cut. The <a href="https://www.fsis.usda.gov/food-safety/safe-food-handling-and-preparation/meat" target="_blank" rel="noopener">USDA</a> safety minimum is 145&deg;F with a 3-minute rest; below that is a personal-preference call, not a safety guarantee.
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
                <button class="btn btn--primary btn--large start-timer">Start Steak Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Time to Flip or Rest!</h3>
                <p>Pull the steak when internal temp is 5&deg;F below target. Rest 5&ndash;10 minutes before slicing.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Doneness Presets (1-inch steak, per side)</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-2-minutes" class="btn btn--secondary"><strong>Rare</strong><span>2&ndash;3 min/side</span></a>
                <a href="/timer/set-timer-for-3-minutes" class="btn btn--secondary"><strong>Medium-Rare</strong><span>3&ndash;4 min/side</span></a>
                <a href="/timer/set-timer-for-4-minutes" class="btn btn--secondary"><strong>Medium</strong><span>4&ndash;5 min/side</span></a>
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary"><strong>Medium-Well</strong><span>5&ndash;6 min/side</span></a>
                <a href="/timer/set-timer-for-7-minutes" class="btn btn--secondary"><strong>Well Done</strong><span>6&ndash;7 min/side</span></a>
                <a href="/timer/set-timer-for-10-minutes" class="btn btn--secondary"><strong>Rest Time</strong><span>5&ndash;10 minutes</span></a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Steak Internal Temperature and Time Chart</h2>
            <p>Times below are for a 1-inch thick steak (about 2.5 cm) cooked on a preheated cast-iron pan or grill over high heat. Internal temperatures are the pull temperatures &mdash; the steak should hit the final target temperature during the rest, after about 5&deg;F of carryover cooking.</p>

            <table style="width:100%;border-collapse:collapse;margin:var(--space-6) 0;">
                <thead>
                    <tr style="border-bottom:2px solid var(--color-border);">
                        <th style="text-align:left;padding:var(--space-3);">Doneness</th>
                        <th style="text-align:left;padding:var(--space-3);">Pull Temp</th>
                        <th style="text-align:left;padding:var(--space-3);">Final Temp</th>
                        <th style="text-align:left;padding:var(--space-3);">Time per Side</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Rare</td><td style="padding:var(--space-3);">120&deg;F / 49&deg;C</td><td style="padding:var(--space-3);">125&deg;F / 52&deg;C</td><td style="padding:var(--space-3);">2&ndash;3 minutes</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Medium-Rare</td><td style="padding:var(--space-3);">125&deg;F / 52&deg;C</td><td style="padding:var(--space-3);">130&ndash;135&deg;F / 54&ndash;57&deg;C</td><td style="padding:var(--space-3);">3&ndash;4 minutes</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Medium</td><td style="padding:var(--space-3);">135&deg;F / 57&deg;C</td><td style="padding:var(--space-3);">140&ndash;145&deg;F / 60&ndash;63&deg;C</td><td style="padding:var(--space-3);">4&ndash;5 minutes</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Medium-Well</td><td style="padding:var(--space-3);">145&deg;F / 63&deg;C</td><td style="padding:var(--space-3);">150&deg;F / 66&deg;C</td><td style="padding:var(--space-3);">5&ndash;6 minutes</td></tr>
                    <tr><td style="padding:var(--space-3);">Well Done</td><td style="padding:var(--space-3);">155&deg;F / 68&deg;C</td><td style="padding:var(--space-3);">160&deg;F+ / 71&deg;C+</td><td style="padding:var(--space-3);">6&ndash;7 minutes</td></tr>
                </tbody>
            </table>

            <h3>Times by Cut and Thickness (Medium-Rare)</h3>
            <table style="width:100%;border-collapse:collapse;margin:var(--space-6) 0;">
                <thead>
                    <tr style="border-bottom:2px solid var(--color-border);">
                        <th style="text-align:left;padding:var(--space-3);">Cut</th>
                        <th style="text-align:left;padding:var(--space-3);">Thickness</th>
                        <th style="text-align:left;padding:var(--space-3);">Pan-Sear / Grill</th>
                        <th style="text-align:left;padding:var(--space-3);">Sous Vide</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Ribeye</td><td style="padding:var(--space-3);">1 inch</td><td style="padding:var(--space-3);">3&ndash;4 min/side</td><td style="padding:var(--space-3);">1&ndash;2 hours at 130&deg;F</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Ribeye</td><td style="padding:var(--space-3);">1.5 inch</td><td style="padding:var(--space-3);">4&ndash;5 min/side + 5 min indirect</td><td style="padding:var(--space-3);">1.5&ndash;2.5 hours at 130&deg;F</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">New York Strip</td><td style="padding:var(--space-3);">1 inch</td><td style="padding:var(--space-3);">3&ndash;4 min/side</td><td style="padding:var(--space-3);">1&ndash;2 hours at 130&deg;F</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Filet Mignon</td><td style="padding:var(--space-3);">1.5 inch</td><td style="padding:var(--space-3);">4 min/side + 5 min indirect</td><td style="padding:var(--space-3);">1&ndash;2 hours at 130&deg;F</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">T-Bone / Porterhouse</td><td style="padding:var(--space-3);">1.5&ndash;2 inch</td><td style="padding:var(--space-3);">5 min/side + 8 min indirect</td><td style="padding:var(--space-3);">2&ndash;3 hours at 130&deg;F</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Flank / Skirt</td><td style="padding:var(--space-3);">3/4 inch</td><td style="padding:var(--space-3);">3 min/side over very high heat</td><td style="padding:var(--space-3);">1 hour at 130&deg;F (not common)</td></tr>
                    <tr><td style="padding:var(--space-3);">Tomahawk</td><td style="padding:var(--space-3);">2&ndash;2.5 inch</td><td style="padding:var(--space-3);">Reverse-sear method only</td><td style="padding:var(--space-3);">3&ndash;4 hours at 130&deg;F</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Science of Cooking Steak</h2>
            <p>Steak cookery is the controlled application of three things: heat, time, and protein denaturation. The Maillard reaction &mdash; a non-enzymatic browning between amino acids and reducing sugars that begins around 285&deg;F and accelerates above 350&deg;F &mdash; is what gives a properly seared steak its deep brown crust and roasted-meat flavor. The reaction is named for French chemist <a href="https://en.wikipedia.org/wiki/Louis_Camille_Maillard" target="_blank" rel="noopener">Louis-Camille Maillard</a> who described it in 1912 and remains one of the most studied reactions in food chemistry.</p>

            <p>Inside the steak, muscle proteins denature in stages: myosin around 122&deg;F, the connective tissue collagen begins to shrink at 140&deg;F, and actin at 150&deg;F. Each stage squeezes out moisture. This is why a medium-rare steak (130&ndash;135&deg;F) holds its juices &mdash; only myosin has denatured. Past 150&deg;F you have lost the moisture battle, which is why well-done steak feels dry no matter how good the cut.</p>

            <p>The definitive modern reference is Nathan Myhrvold's <em>Modernist Cuisine</em> (2011), which documents the temperature curves for every common cut with laboratory precision. <a href="https://www.seriouseats.com/" target="_blank" rel="noopener">Kenji L&oacute;pez-Alt's</a> work at Serious Eats, particularly <em>The Food Lab</em>, translated those findings into practical home-kitchen technique. Both authors converge on the same conclusion: temperature, not time, is the only reliable indicator of doneness. A leave-in probe thermometer (the ThermoWorks Smoke or DOT, or the Meater wireless probe) eliminates the guessing entirely.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Cooking Methods Compared</h2>

            <h3>Pan-Sear</h3>
            <p>Heat a cast-iron pan over high heat until smoking. Add neutral oil with a high smoke point (avocado, grapeseed, or refined safflower). Dry the steak with paper towels, salt generously, and lay it away from you in the pan. For 1-inch steaks, 3&ndash;4 minutes per side gets you medium-rare. Add a knob of butter, a smashed garlic clove, and thyme in the last minute and baste constantly &mdash; a technique called arrosage. Total time: 8&ndash;10 minutes plus rest.</p>

            <h3>Grill (Direct Heat)</h3>
            <p>Get the grill blazing hot &mdash; 500&deg;F or higher. Oil the grates with a tongs-held paper towel dipped in oil. Same 3&ndash;4 minutes per side for medium-rare on a 1-inch steak. For thicker cuts, sear over direct heat for 2 minutes per side, then move to indirect heat to finish.</p>

            <h3>Reverse Sear</h3>
            <p>For steaks 1.5 inches or thicker, the reverse sear delivers more consistent doneness edge-to-edge. Place the steak on a wire rack in a low oven (225&ndash;275&deg;F) until the internal temperature is 10&ndash;15&deg;F below your target &mdash; about 30 to 45 minutes for a 1.5-inch steak. Then sear in a screaming hot pan or grill for 60&ndash;90 seconds per side to develop the crust. Kenji L&oacute;pez-Alt popularized this method for home cooks; it is now standard at steakhouses too.</p>

            <h3>Sous Vide</h3>
            <p>The most foolproof method. Vacuum-seal the steak, drop it in a water bath set to your final target temperature (130&deg;F for medium-rare), and leave it for 1 to 3 hours. The steak cannot overcook because the water is at the target temperature. Finish in a screaming hot pan or with a torch for the crust. Douglas Baldwin's <em>A Practical Guide to Sous Vide Cooking</em> is the technical reference for time-temperature combinations.</p>

            <h3>Oven Broil</h3>
            <p>Use as a backup when you cannot grill. Position the rack 3&ndash;4 inches below the broiler, preheat for 10 minutes, then broil 4&ndash;5 minutes per side for a 1-inch medium-rare. Crust development is inferior to pan or grill but adequate.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Resting and Carving</h2>
            <p>Resting is non-negotiable. During cooking, the proteins contract and force juices toward the center of the steak. If you slice immediately, those juices spill out onto the cutting board. A proper rest lets the proteins relax and reabsorb the moisture. The <a href="https://www.seriouseats.com/the-food-lab-resting-steak" target="_blank" rel="noopener">Serious Eats experiment</a> measuring juice loss showed that a 1-inch steak rested for 5 minutes retains roughly 40% more moisture than one sliced immediately.</p>

            <p>Rest times: 5 minutes for a 1-inch steak, 7&ndash;8 minutes for 1.5-inch, 10&ndash;12 minutes for 2-inch and thicker. Tent loosely with foil if your kitchen is cold; otherwise let it rest uncovered to keep the crust crisp. Carve against the grain &mdash; perpendicular to the muscle fibers &mdash; for the tenderest bite. This matters especially for flank, skirt, and hanger steaks where the grain is pronounced.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Steak Mistakes</h2>

            <h3>Cooking Cold Steak Straight from the Fridge</h3>
            <p>Let the steak sit at room temperature for 30 to 45 minutes before cooking. A cold center extends cooking time and creates a larger gray band of overcooked meat beneath the crust. (Food-safety note: the USDA two-hour rule applies &mdash; do not leave meat out longer than that.)</p>

            <h3>Under-Seasoning</h3>
            <p>Salt generously at least 40 minutes before cooking &mdash; or right before cooking. The middle zone (5 to 30 minutes) draws moisture to the surface without enough time to reabsorb, producing a steamy sear. Use kosher salt; iodized table salt over-seasons quickly and tastes metallic on a hot crust.</p>

            <h3>Cooking by Time Instead of Temperature</h3>
            <p>Time charts (including this one) are starting points. The only reliable indicator of doneness is internal temperature measured with an instant-read thermometer (Thermapen ONE or Thermoworks Classic).</p>

            <h3>Flipping Too Often</h3>
            <p>Counter-intuitive but tested: flipping a steak every 30 seconds actually produces more even cooking with a thinner gray band. The "flip once" rule is more about presentation than chemistry. Both methods work; the multi-flip method works better for thicker cuts.</p>

            <h3>Skipping the Rest</h3>
            <p>The most damaging mistake. A perfectly cooked steak sliced immediately is a worse steak than one cooked 5&deg;F over and rested properly.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Food Safety</h2>
            <p>The <a href="https://www.fsis.usda.gov/food-safety/safe-food-handling-and-preparation/meat/safe-minimum-internal-temperatures" target="_blank" rel="noopener">USDA's safe minimum internal temperature for beef steaks</a> is 145&deg;F (63&deg;C) with a 3-minute rest. Below that, you are accepting a small (whole-muscle steaks are very low risk) but nonzero pathogen risk &mdash; primarily <em>E. coli</em> O157:H7 contamination on the surface. Searing the exterior to 165&deg;F kills surface pathogens, so a rare or medium-rare steak from a reputable source is generally considered safe by food scientists, but the USDA does not officially endorse this temperature for at-risk populations (pregnant individuals, young children, elderly, immunocompromised).</p>

            <p>Ground beef is a different story: bacteria from the surface are distributed throughout the grind, so burgers must reach 160&deg;F internal. The same applies to mechanically tenderized "blade-tenderized" steaks &mdash; the perforation pushes surface bacteria inside.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Steak Timer FAQ</h2>

            <div class="faq-list">
                <div class="faq-item"><button class="faq-question" type="button"><span>How long do I cook a 1-inch steak for medium-rare?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>3 to 4 minutes per side over high heat, plus a 5-minute rest. Pull at 125&deg;F internal; it will rise to 130&ndash;135&deg;F during the rest.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What is the difference between rare, medium-rare, and medium?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Rare is 125&deg;F final &mdash; cool red center, very juicy. Medium-rare is 130&ndash;135&deg;F &mdash; warm red center, optimal texture for most cuts. Medium is 140&ndash;145&deg;F &mdash; warm pink center, firmer and noticeably drier.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Should I let the steak rest after cooking?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Always. Rest 5 minutes for a 1-inch steak, 10 minutes for thicker cuts. Resting lets the proteins relax and the juices redistribute, so slicing does not produce a puddle on the cutting board.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How do I know when a steak is done without a thermometer?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>You really should use one. The finger test &mdash; comparing the firmness of the steak to the flesh at the base of your thumb &mdash; is imprecise and varies by cut. A $30 instant-read thermometer pays for itself the first time you cook a $40 steak.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What is reverse-sear and when should I use it?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Reverse-sear bakes the steak slowly in a low oven (225&ndash;275&deg;F) until it is 10&ndash;15&deg;F below the target, then finishes with a hot sear for 60&ndash;90 seconds per side. Use it for steaks 1.5 inches and thicker; it produces edge-to-edge doneness with no gray band.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Can I cook steak from frozen?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes, and Kenji L&oacute;pez-Alt's Serious Eats testing actually preferred frozen-cooked steak in some cases &mdash; the colder interior allows for a longer, deeper sear before the center overcooks. Skip the room-temperature rest; sear straight from frozen, then finish in a 275&deg;F oven.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What is sous vide and is it worth it?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Sous vide cooks the steak in a temperature-controlled water bath at the exact target temperature. It is foolproof, produces edge-to-edge doneness, and is forgiving on timing. A circulator costs $80&ndash;$200; if you cook steak more than a few times a year, it is worth it.</p></div></div>
            </div>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Recipe",
  "name": "How to Cook a Perfect Steak",
  "author": {"@type": "Person", "name": "Suraj Giri", "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"},
  "datePublished": "2026-05-27",
  "description": "Cook a steak to your target doneness using time, temperature, and the reverse-sear or pan-sear method.",
  "prepTime": "PT30M",
  "cookTime": "PT10M",
  "totalTime": "PT45M",
  "recipeYield": "1 serving",
  "recipeCategory": "Main Course",
  "recipeIngredient": ["1 inch thick ribeye or strip steak", "Kosher salt", "Black pepper", "High smoke-point oil", "Butter", "Thyme", "Garlic"],
  "recipeInstructions": [
    {"@type": "HowToStep", "text": "Bring steak to room temperature for 30 to 45 minutes. Pat dry and salt generously."},
    {"@type": "HowToStep", "text": "Preheat a cast-iron pan over high heat until smoking."},
    {"@type": "HowToStep", "text": "Sear 3 to 4 minutes per side for medium-rare."},
    {"@type": "HowToStep", "text": "Pull steak at 125°F internal temperature."},
    {"@type": "HowToStep", "text": "Rest 5 minutes before slicing against the grain."}
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Steak Timer — Perfect Doneness for Every Cut",
  "author": {"@type": "Person", "name": "Suraj Giri", "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"},
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "publisher": {"@type": "Organization", "name": "The Blog Timer", "url": "<?php echo esc_url(home_url('/')); ?>"}
}
</script>

<?php get_footer(); ?>
