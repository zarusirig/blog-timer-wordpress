<?php
/**
 * Template Name: Tea Timer Page
 * Description: Tea steeping timer with steep times by tea variety
 */
get_header();
?>

<main class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">Free Online Tea Timer &mdash; Perfect Steep Times for Every Variety</h1>
        <p class="byline" style="font-size: 0.875rem; color: #666; margin: 0.5rem 0;">
            By <a href="<?php echo esc_url(home_url('/author-suraj-giri/')); ?>" rel="author">Suraj Giri</a>
            &middot; Tea drinker &amp; cooking researcher &middot; <em>Last updated: 2026-05-27</em>
        </p>
        <p class="page-intro">Steep tea correctly the first time with this free timer. Use the chart below to match the right time and water temperature to your tea &mdash; green, black, oolong, white, pu-erh, or herbal.</p>
        <div class="tldr-box" style="background:#f5f8fb;border-left:4px solid #2563eb;padding:1rem 1.25rem;margin:1rem 0;border-radius:6px;">
            <strong>TL;DR:</strong> Steep times depend on oxidation level. Delicate green and white teas need 1&ndash;3 minutes in 160&ndash;180&deg;F water. Oolongs steep 2&ndash;4 minutes at 185&deg;F. Black teas tolerate full boiling water for 3&ndash;5 minutes. Herbal infusions need 5&ndash;7 minutes at a full boil to extract flavor. Over-steeping releases tannins (catechins and theaflavins) that make tea bitter, so a precise timer matters more than most drinkers realize.
        </div>
    </div>

    <div class="container">
        <div class="timer-widget timer-widget--hero"
             data-duration="180"
             data-unit="minutes"
             data-value="3"
             data-mode="standard">
            <div class="timer-display">3:00</div>
            <div class="timer-progress">
                <div class="timer-progress-bar" style="width: 0%"></div>
            </div>
            <div class="timer-controls">
                <button class="btn btn--primary btn--large start-timer">Start Tea Timer</button>
                <button class="btn btn--secondary reset-timer" style="display:none;">Reset</button>
            </div>
            <div class="timer-complete-banner" style="display:none;">
                <h3>Tea Is Ready!</h3>
                <p>Remove the leaves or teabag immediately to prevent over-extraction.</p>
            </div>
        </div>

        <div class="pomodoro-presets" style="margin-top:var(--space-6);">
            <h3 class="section-subtitle">Steep Time Presets</h3>
            <div class="timer-grid">
                <a href="/timer/set-timer-for-1-minute" class="btn btn--secondary"><strong>White Tea</strong><span>1&ndash;3 minutes</span></a>
                <a href="/timer/set-timer-for-2-minutes" class="btn btn--secondary"><strong>Green Tea</strong><span>1&ndash;3 minutes</span></a>
                <a href="/timer/set-timer-for-3-minutes" class="btn btn--secondary"><strong>Oolong</strong><span>2&ndash;4 minutes</span></a>
                <a href="/timer/set-timer-for-4-minutes" class="btn btn--secondary"><strong>Black Tea</strong><span>3&ndash;5 minutes</span></a>
                <a href="/timer/set-timer-for-5-minutes" class="btn btn--secondary"><strong>Pu-erh</strong><span>3&ndash;5 minutes</span></a>
                <a href="/timer/set-timer-for-6-minutes" class="btn btn--secondary"><strong>Herbal / Tisane</strong><span>5&ndash;7 minutes</span></a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Tea Steeping Time and Temperature Chart</h2>
            <p>Every tea below except herbal infusions comes from a single plant: <em>Camellia sinensis</em>. The differences between green, white, oolong, black, and pu-erh are entirely a function of oxidation, drying, and post-processing. The International Tea Committee (ITC) standardizes basic processing categories, and each category responds differently to heat and time.</p>

            <table style="width:100%;border-collapse:collapse;margin:var(--space-6) 0;">
                <thead>
                    <tr style="border-bottom:2px solid var(--color-border);">
                        <th style="text-align:left;padding:var(--space-3);">Tea Type</th>
                        <th style="text-align:left;padding:var(--space-3);">Water Temp</th>
                        <th style="text-align:left;padding:var(--space-3);">Steep Time</th>
                        <th style="text-align:left;padding:var(--space-3);">Re-steeps</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">White (Silver Needle, Bai Mu Dan)</td><td style="padding:var(--space-3);">160&ndash;175&deg;F / 70&ndash;80&deg;C</td><td style="padding:var(--space-3);">2&ndash;5 minutes</td><td style="padding:var(--space-3);">3&ndash;5</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Japanese Green (Sencha, Gyokuro)</td><td style="padding:var(--space-3);">160&ndash;170&deg;F / 70&ndash;77&deg;C</td><td style="padding:var(--space-3);">1&ndash;2 minutes</td><td style="padding:var(--space-3);">2&ndash;3</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Chinese Green (Longjing, Bi Luo Chun)</td><td style="padding:var(--space-3);">175&ndash;185&deg;F / 80&ndash;85&deg;C</td><td style="padding:var(--space-3);">2&ndash;3 minutes</td><td style="padding:var(--space-3);">2&ndash;4</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Matcha (whisked)</td><td style="padding:var(--space-3);">175&deg;F / 80&deg;C</td><td style="padding:var(--space-3);">N/A (whisk 30 seconds)</td><td style="padding:var(--space-3);">1</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Oolong (light, Tieguanyin)</td><td style="padding:var(--space-3);">185&deg;F / 85&deg;C</td><td style="padding:var(--space-3);">2&ndash;3 minutes</td><td style="padding:var(--space-3);">4&ndash;7</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Oolong (dark, Da Hong Pao)</td><td style="padding:var(--space-3);">195&deg;F / 90&deg;C</td><td style="padding:var(--space-3);">3&ndash;5 minutes</td><td style="padding:var(--space-3);">4&ndash;6</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Black (Assam, Ceylon, English Breakfast)</td><td style="padding:var(--space-3);">200&ndash;212&deg;F / 93&ndash;100&deg;C</td><td style="padding:var(--space-3);">3&ndash;5 minutes</td><td style="padding:var(--space-3);">1&ndash;2</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Black (Darjeeling, first flush)</td><td style="padding:var(--space-3);">190&deg;F / 88&deg;C</td><td style="padding:var(--space-3);">3 minutes</td><td style="padding:var(--space-3);">2&ndash;3</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Pu-erh (raw / sheng)</td><td style="padding:var(--space-3);">195&deg;F / 90&deg;C</td><td style="padding:var(--space-3);">3&ndash;5 minutes (rinse first)</td><td style="padding:var(--space-3);">5&ndash;10</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Pu-erh (ripe / shou)</td><td style="padding:var(--space-3);">212&deg;F / 100&deg;C</td><td style="padding:var(--space-3);">3&ndash;5 minutes (rinse first)</td><td style="padding:var(--space-3);">5&ndash;8</td></tr>
                    <tr style="border-bottom:1px solid var(--color-border);"><td style="padding:var(--space-3);">Herbal: Chamomile / Rooibos</td><td style="padding:var(--space-3);">212&deg;F / 100&deg;C</td><td style="padding:var(--space-3);">5&ndash;7 minutes</td><td style="padding:var(--space-3);">1</td></tr>
                    <tr><td style="padding:var(--space-3);">Herbal: Peppermint / Ginger</td><td style="padding:var(--space-3);">212&deg;F / 100&deg;C</td><td style="padding:var(--space-3);">5&ndash;10 minutes</td><td style="padding:var(--space-3);">1&ndash;2</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">The Chemistry of a Proper Steep</h2>
            <p>Steeping is solvent extraction. Hot water dissolves three families of compounds from the tea leaf in roughly this order: caffeine and L-theanine first, then aromatic volatile oils, then tannins (catechins in green and white tea; theaflavins and thearubigins in oxidized black tea). The first 30 seconds release most of the caffeine. The next 60&ndash;120 seconds release flavor. After that, tannin extraction dominates and the cup grows astringent and bitter.</p>

            <p>This is why short, hot steeps for unoxidized teas and longer steeps for oxidized ones work better than the reverse. Green tea catechins &mdash; particularly <a href="https://en.wikipedia.org/wiki/Epigallocatechin_gallate" target="_blank" rel="noopener">epigallocatechin gallate (EGCG)</a> &mdash; are highly soluble and extract aggressively at boiling temperatures. Use boiling water on Sencha and you brew bitterness. Black tea, by contrast, has had its catechins polymerized into theaflavins during fermentation; those larger molecules need higher temperatures and longer extraction to develop the brisk, malty cup that defines a proper English Breakfast.</p>

            <p>The chemistry is documented in detail by Mary Lou Heiss and Robert Heiss in <em>The Story of Tea: A Cultural History and Drinking Guide</em>, the most comprehensive English-language reference on tea production. Their work draws on regional standards from the China National Tea Industry Standards (Q/CTC) and Japan's Tea Industry Central Council. The botanical reference point for <em>Camellia sinensis</em> varieties &mdash; the small-leaf <em>sinensis</em> for Chinese-style processing, the broad-leaf <em>assamica</em> for Indian and African production &mdash; is established in the <a href="https://www.kew.org/" target="_blank" rel="noopener">Kew Botanical Garden's</a> plant taxonomic database.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Why Water Temperature Matters More Than Time</h2>
            <p>If you remember one thing from this guide: <strong>under-steeping is recoverable; over-temperature is not</strong>. A teabag pulled too early can be re-steeped. Green tea brewed with 212&deg;F water is bitter from the first sip and cannot be saved.</p>

            <p>The reason is that boiling water shocks the delicate enzymes and volatile aromatics in low-oxidation teas. The grassy, vegetal notes that define a good Sencha or Longjing are heat-sensitive compounds &mdash; primarily 2-pentenal, hexanal, and (Z)-3-hexenol &mdash; that vaporize and break down above 180&deg;F. At the same time, catechin extraction at boiling temperature is rapid and indiscriminate, producing the harsh astringency that turns first-time green tea drinkers away.</p>

            <p>To get the right temperature without a thermometer, use this rule of thumb: bring the kettle to a boil, then let it sit. After 30 seconds it is around 200&deg;F (perfect for black tea). After 90 seconds it is around 180&deg;F (good for oolong and white). After 2 to 3 minutes it is around 170&deg;F (right for most greens). Variable-temperature electric kettles &mdash; the Cuisinart CPK-17 and the Fellow Stagg EKG are the most cited models in food media &mdash; remove the guesswork.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Common Tea-Steeping Mistakes</h2>

            <h3>Pouring Boiling Water on Green Tea</h3>
            <p>This is the single most common mistake among Western drinkers. Bring the water to a boil, then wait two minutes before pouring. Boiling water on green or white tea scorches the leaves, releases tannins immediately, and locks in bitterness.</p>

            <h3>Squeezing the Teabag</h3>
            <p>Squeezing a teabag to "get more flavor" presses concentrated tannins into the cup. The result is a darker, harsher brew &mdash; the opposite of what you want. Let the teabag drip and discard it.</p>

            <h3>Leaving Leaves in the Cup</h3>
            <p>If you steep loose-leaf tea directly in a mug without a strainer or infuser, the leaves continue to extract as you drink. By the bottom of the cup, the last sip is bitter. Use an infuser basket, gaiwan, or built-in strainer.</p>

            <h3>Reusing Boiled Water Repeatedly</h3>
            <p>Water that has been boiled repeatedly loses dissolved oxygen, which dulls the tea's flavor. Use fresh, cold water and bring it to a boil once. Refilling a kettle that has been sitting hot for hours produces a flat, lifeless cup.</p>

            <h3>Steeping by the Clock Without Tasting</h3>
            <p>Steep times in any chart, including this one, are starting points. Leaf size, age of harvest, mineral content of your water, and personal preference all shift the optimal time. Pull a small sip at the midpoint, and adjust.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Caffeine, Safety, and Storage</h2>
            <p>An 8-ounce cup of black tea contains roughly 40&ndash;70 mg of caffeine; green tea, 25&ndash;45 mg; white tea, 15&ndash;30 mg; matcha, 60&ndash;80 mg per teaspoon. The <a href="https://www.fda.gov/consumers/consumer-updates/spilling-beans-how-much-caffeine-too-much" target="_blank" rel="noopener">FDA's caffeine safety guidance</a> identifies 400 mg daily as the threshold above which adverse effects typically appear in healthy adults. Pregnant individuals should consult the <a href="https://www.acog.org/" target="_blank" rel="noopener">American College of Obstetricians and Gynecologists</a> guideline of 200 mg per day.</p>

            <p>Loose-leaf tea is shelf-stable for one to two years in an airtight, opaque container away from light, heat, and moisture. Green tea degrades fastest because its catechins oxidize on contact with air; consume within six to nine months for peak flavor. Pu-erh is the exception &mdash; properly stored, it improves over decades, which is why aged pu-erh cakes can sell at auction for prices that rival fine wine.</p>
        </div>
    </section>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">Tea Timer FAQ</h2>

            <div class="faq-list">
                <div class="faq-item"><button class="faq-question" type="button"><span>Can I re-steep tea leaves?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes &mdash; in fact, most premium loose-leaf teas are designed for it. Oolongs and pu-erhs reveal new flavor notes across 4 to 10 infusions. Add 30 to 60 seconds to each subsequent steep. Tea-bag teas are not designed to re-steep; they release nearly everything on the first pass.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How much tea per cup should I use?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>The Western standard is 1 teaspoon (2&ndash;3 g) of loose tea per 8 oz cup. Chinese gongfu style uses 5 to 8 g per 100 ml gaiwan with very short, repeated infusions. Larger leaves like white tea need more by volume; finely cut blacks need less.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Does decaffeinated tea steep the same way?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes. Caffeine removal does not significantly change the extraction profile of the remaining compounds, so steep at the same temperature and time as the original variety.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>What is the difference between herbal tea and "real" tea?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>"Real" tea comes from <em>Camellia sinensis</em>. Herbal infusions &mdash; technically called tisanes &mdash; are made from any other plant: chamomile, mint, rooibos, hibiscus, ginger. Tisanes have no caffeine (with some exceptions like yerba mate) and tolerate long, hot extraction without becoming bitter.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Should I cover the cup while steeping?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Yes, for hot teas. A lid or saucer holds in heat and traps aromatic volatiles that would otherwise escape with the steam. This is why traditional Chinese gaiwans come with lids.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>Why does my tea taste different at home than at a tea shop?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Water. Tea is roughly 99% water, and the mineral content of your tap water significantly affects extraction. Hard water (high calcium) flattens flavor; soft or filtered water reveals subtleties. Many tea masters recommend Volvic or filtered tap water.</p></div></div>

                <div class="faq-item"><button class="faq-question" type="button"><span>How long does brewed tea stay good?</span><span class="faq-icon">+</span></button>
                <div class="faq-answer"><p>Brewed tea is best consumed within an hour. Refrigerated, it keeps about 24 hours. Iced tea brewed by cold infusion (overnight in the fridge) is safe for 2 to 3 days. Tea left at room temperature for more than 8 hours can grow bacteria and should be discarded.</p></div></div>
            </div>
        </div>
    </section>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Recipe",
  "name": "How to Steep Tea Correctly",
  "author": {"@type": "Person", "name": "Suraj Giri", "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"},
  "datePublished": "2026-05-27",
  "description": "Steep tea to the correct strength using the right water temperature and steep time for each tea variety.",
  "prepTime": "PT1M",
  "cookTime": "PT3M",
  "totalTime": "PT4M",
  "recipeYield": "1 cup",
  "recipeCategory": "Beverage",
  "recipeIngredient": ["1 teaspoon loose tea or 1 teabag", "8 oz filtered water"],
  "recipeInstructions": [
    {"@type": "HowToStep", "text": "Bring fresh cold water to the appropriate temperature for your tea type."},
    {"@type": "HowToStep", "text": "Place loose tea in an infuser or teabag in the cup."},
    {"@type": "HowToStep", "text": "Pour water over the leaves and start the timer."},
    {"@type": "HowToStep", "text": "Remove leaves or teabag promptly when the timer ends."}
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Free Online Tea Timer — Perfect Steep Times for Every Variety",
  "author": {"@type": "Person", "name": "Suraj Giri", "url": "<?php echo esc_url(home_url('/author-suraj-giri/')); ?>"},
  "datePublished": "2026-05-27",
  "dateModified": "2026-05-27",
  "publisher": {"@type": "Organization", "name": "The Blog Timer", "url": "<?php echo esc_url(home_url('/')); ?>"}
}
</script>

<?php get_footer(); ?>
