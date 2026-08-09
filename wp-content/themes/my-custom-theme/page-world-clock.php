<?php
/**
 * Template Name: World Clock Page
 * Description: Live multi-timezone world clock with add-city feature using Intl.DateTimeFormat
 */
get_header();
?>

<main id="main" tabindex="-1" class="site-main content-page">
    <div class="container container--narrow">
        <h1 class="page-h1">World Clock &mdash; Live Time in Any City, Any Timezone</h1>
        <p class="page-intro">A live world clock showing current time in any IANA timezone. Six default cities, add your own, every clock updates every second. Uses <code>Intl.DateTimeFormat</code> with the official tz database &mdash; no API key, no signup.</p>

        <!-- AUTHOR BYLINE -->
        <div class="card" style="display:flex;flex-wrap:wrap;gap:var(--space-4);align-items:center;padding:var(--space-5);margin-top:var(--space-6);">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--color-accent-soft);border:1px solid rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--color-accent);font-size:1.25rem;flex-shrink:0;">SG</div>
            <div style="flex:1;min-width:240px;">
                <div style="font-size:var(--text-sm);color:var(--color-text-secondary);">By <a href="/author-suraj-giri" style="color:var(--color-accent);text-decoration:none;font-weight:600;">Suraj Giri</a>, Productivity Researcher</div>
                <div style="font-size:0.8125rem;color:var(--color-text-muted,#7c87a8);margin-top:2px;">Last updated: 2026-05-27 &middot; ~10 min read &middot; References: IANA tz database, MDN Intl.DateTimeFormat, Sir Sandford Fleming 1879 paper</div>
            </div>
        </div>

        <!-- TL;DR -->
        <div class="card" style="padding:var(--space-5);border-left:3px solid var(--color-accent);margin-top:var(--space-5);">
            <strong style="display:block;text-transform:uppercase;letter-spacing:0.08em;font-size:0.75rem;color:var(--color-accent);margin-bottom:var(--space-2);">TL;DR &mdash; Direct answer</strong>
            <p style="margin:0;color:var(--color-text-secondary);line-height:1.65;">This world clock shows current local time in any of 300+ IANA timezones. Click a default city to remove it. Use the search box to add a city by name. Each clock updates every second using your browser's built-in <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat" rel="nofollow noopener" target="_blank">Intl.DateTimeFormat</a> with timezone option &mdash; no external API. Saved cities persist in <code>localStorage</code>.</p>
        </div>
    </div>

    <style>
        .world-clock-msg{font-size:0.8125rem;color:#ff6b6b;margin-top:0.35rem;min-height:1.1em;line-height:1.3;}
    </style>
    <!-- WORLD CLOCK WIDGET -->
    <div class="container">
        <div style="margin-top:var(--space-6);display:flex;flex-wrap:wrap;gap:var(--space-3);align-items:end;">
            <label style="display:flex;flex-direction:column;align-items:flex-start;gap:0.25rem;font-size:0.875rem;color:var(--color-text-secondary);flex:1;min-width:240px;">
                Add a city
                <input list="wc-cities" id="wc-search" placeholder="Type a city or timezone..." style="width:100%;padding:0.5rem 0.75rem;font-size:1rem;border:1px solid rgba(99,102,241,0.25);background:var(--color-bg,#0b0e1a);color:var(--color-text);border-radius:var(--radius-md);">
                <datalist id="wc-cities"></datalist>
            </label>
            <button class="btn btn--primary" onclick="worldClock.addFromInput()">Add City</button>
            <button class="btn btn--secondary" onclick="worldClock.resetDefaults()">Reset to Defaults</button>
        </div>

        <div id="wc-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:var(--space-4);margin-top:var(--space-5);"></div>
    </div>

    <section class="section">
        <div class="container container--narrow">
            <h2 class="section-title">How Timezones Work</h2>
            <p>Coordinated Universal Time (UTC) is the global reference; every other timezone is defined as an offset from UTC. New York in winter is UTC&minus;5 (Eastern Standard Time); London is UTC&plusmn;0 in winter, UTC+1 in summer (British Summer Time); Tokyo is UTC+9 year-round. The offsets are the easy part. The complications are when they change.</p>
            <p>Daylight Saving Time (DST), local political adjustments, and historical reforms mean the timezone of any given location is not a static number but a piecewise function over time. The same city can have observed three or four different UTC offsets in the past century. The <a href="https://en.wikipedia.org/wiki/Tz_database" rel="nofollow noopener" target="_blank">IANA tz database</a> (also called zoneinfo or "the Olson database") tracks every one of these transitions back to 1970, with best-effort historical records before that. This world clock uses the version of the tz database compiled into your browser, which is updated with each browser release.</p>

            <h2 class="section-title">UTC, GMT, Zulu Time, and Unix Timestamps</h2>
            <ul>
                <li><strong>UTC</strong> &mdash; Coordinated Universal Time. The modern global reference. Defined by atomic clocks, with occasional leap seconds to align with Earth's rotation.</li>
                <li><strong>GMT</strong> &mdash; Greenwich Mean Time. The historical mean solar time at the Royal Observatory in Greenwich, London. Functionally identical to UTC for civilian purposes but technically defined differently.</li>
                <li><strong>Zulu time (Z)</strong> &mdash; UTC, in aviation and military notation. "Zero" hour offset; the "Z" comes from the NATO phonetic alphabet for the letter Z, used because Z is the last letter of the time zone naming convention starting with A=+1.</li>
                <li><strong>Unix timestamp</strong> &mdash; Seconds elapsed since 1970-01-01T00:00:00Z (the "Unix epoch"). Used internally by most computing systems. JavaScript's <code>Date.now()</code> returns milliseconds since this epoch.</li>
                <li><strong>IANA timezone name</strong> &mdash; Strings like <code>America/New_York</code>, <code>Europe/Paris</code>, <code>Asia/Tokyo</code>. The canonical identifier for a location's timezone history.</li>
            </ul>

            <h2 class="section-title">The History of Timezone Standardization</h2>
            <p>Before 1880, every town in the world used local solar time. Noon was when the sun reached its highest point overhead, which differs by four minutes for every degree of longitude east or west of your neighbor. This was fine when travel was by horse but became absurd as railways spread &mdash; a train schedule had to specify dozens of different local times along a single route.</p>
            <p>The Canadian railway engineer <a href="https://en.wikipedia.org/wiki/Sandford_Fleming" rel="nofollow noopener" target="_blank">Sir Sandford Fleming</a> proposed a worldwide system of 24 standard one-hour-wide time zones in 1879, presenting the idea to the Royal Canadian Institute. The proposal was formalized at the International Meridian Conference in Washington, D.C. in 1884, which adopted the Greenwich meridian as 0&deg; longitude and defined Greenwich Mean Time as the universal reference.</p>
            <p>National adoption was uneven. The U.S. railroads switched to "Railway Standard Time" on November 18, 1883 ("the Day of Two Noons" &mdash; locals had to set their watches at the moment standard time aligned with their solar time). The British Empire converted in 1880. France held out on Paris Mean Time until 1911. Saudi Arabia used local solar time until 1962. Liberia did not adopt standard time until 1972.</p>
            <p>The international time standard switched from GMT to UTC in 1972, when UTC was redefined as a hybrid of atomic time (TAI) and astronomical time (UT1), with leap seconds added to keep the two within 0.9 seconds of each other.</p>

            <h2 class="section-title">Daylight Saving Time: The Most-Debated Timekeeping Decision</h2>
            <p>DST shifts clocks forward by one hour in spring and back in autumn, ostensibly to make better use of evening daylight. Benjamin Franklin floated the idea satirically in 1784; George Hudson proposed a serious version in 1895; Germany first implemented it nationally in 1916 during World War I to save fuel. The U.S. and U.K. followed within the year.</p>
            <p>The energy-saving rationale is weak in modern economies. A 2008 Department of Energy study found U.S. DST saved roughly 0.5% of electricity, and a 2017 meta-analysis in <em>Energy Policy</em> found the savings approached zero or were even negative in some regions (the cooling load from longer evening daylight offsets lighting savings).</p>
            <p>The medical case against DST is stronger. The spring-forward transition is associated with a transient ~24% increase in heart-attack incidence (Sandhu et al., <em>Open Heart</em> 2014), increased fatal-car-accident rates for several days, and measurable productivity drops. The European Parliament voted in 2019 to abolish DST across the EU; the U.S. Senate passed the Sunshine Protection Act in 2022 to make DST permanent year-round, though the bill stalled in the House. As of 2026, most of the world still observes DST, but the political momentum is toward abolition.</p>

            <h2 class="section-title">Best Practices for Scheduling Across Timezones</h2>
            <ul>
                <li><strong>Quote the timezone explicitly.</strong> "3pm" is ambiguous; "3pm Eastern Time / 12pm Pacific / 8pm UTC" is unambiguous.</li>
                <li><strong>Use IANA names in code.</strong> <code>America/New_York</code> handles DST automatically; "EST" does not (EST is specifically the non-DST winter offset of UTC&minus;5).</li>
                <li><strong>Send calendar invites with floating times rejected.</strong> A Google Calendar or Outlook invite carries the timezone with it &mdash; the meeting will appear at the correct local time for every attendee.</li>
                <li><strong>Watch for DST mismatch windows.</strong> For about three weeks each year, the U.S. and Europe are on different DST schedules; transatlantic meetings shift by an hour during this gap.</li>
                <li><strong>For recurring meetings, pin one timezone.</strong> A meeting that is "Tuesday 9am Pacific" stays at 9am for the Pacific team and moves with DST for everyone else.</li>
                <li><strong>Use a focus timer per side.</strong> For deep work blocks aligned across timezones, pair this world clock with the <a href="/pomodoro">Pomodoro timer</a> or the <a href="/presentation-timer">presentation timer</a>.</li>
            </ul>

            <h2 class="section-title">Major Cities by UTC Offset</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>UTC offset (standard)</th><th>Cities</th><th>Notes</th></tr>
                </thead>
                <tbody>
                    <tr><td>UTC&minus;12</td><td>(Uninhabited Pacific islands)</td><td>Lowest standard offset</td></tr>
                    <tr><td>UTC&minus;10</td><td>Honolulu</td><td>No DST in Hawaii</td></tr>
                    <tr><td>UTC&minus;8</td><td>Los Angeles, Vancouver, San Francisco</td><td>Pacific Time; DST observed</td></tr>
                    <tr><td>UTC&minus;5</td><td>New York, Toronto, Bogot&aacute;</td><td>Eastern Time; DST in US, not Colombia</td></tr>
                    <tr><td>UTC&plusmn;0</td><td>London, Lisbon, Dakar</td><td>GMT in winter, BST in summer</td></tr>
                    <tr><td>UTC+1</td><td>Paris, Berlin, Madrid, Rome, Lagos</td><td>Central Europe; CEST in summer</td></tr>
                    <tr><td>UTC+3</td><td>Moscow, Istanbul, Nairobi, Riyadh</td><td>No DST in Russia (abolished 2014) or Turkey</td></tr>
                    <tr><td>UTC+4</td><td>Dubai, Tbilisi, Baku</td><td>No DST in UAE</td></tr>
                    <tr><td>UTC+5:30</td><td>Mumbai, Delhi, Kolkata</td><td>India uses a single offset for the entire country</td></tr>
                    <tr><td>UTC+8</td><td>Beijing, Singapore, Hong Kong, Perth</td><td>China uses a single offset across 5 geographic zones</td></tr>
                    <tr><td>UTC+9</td><td>Tokyo, Seoul, Pyongyang</td><td>No DST in Japan or Korea</td></tr>
                    <tr><td>UTC+10</td><td>Sydney, Melbourne, Brisbane</td><td>DST in southeastern Australia, not Queensland</td></tr>
                    <tr><td>UTC+12</td><td>Auckland, Fiji</td><td>DST in NZ; first to see new day</td></tr>
                    <tr><td>UTC+13</td><td>Samoa, Tonga, Kiribati</td><td>Highest standard offset; Samoa moved from UTC&minus;11 to +13 in 2011</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Unusual and Half-Hour Timezones</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Location</th><th>Offset</th><th>Why it is unusual</th></tr>
                </thead>
                <tbody>
                    <tr><td>India</td><td>UTC+5:30</td><td>Single 30-minute offset for entire 3000 km wide country</td></tr>
                    <tr><td>Nepal</td><td>UTC+5:45</td><td>15-minute offset, set to align with Kathmandu's longitude</td></tr>
                    <tr><td>Newfoundland (Canada)</td><td>UTC&minus;3:30</td><td>One of the few half-hour offsets in North America</td></tr>
                    <tr><td>Iran</td><td>UTC+3:30</td><td>Half-hour offset year-round</td></tr>
                    <tr><td>Chatham Islands (NZ)</td><td>UTC+12:45</td><td>Quarter-hour offset</td></tr>
                    <tr><td>China (all of it)</td><td>UTC+8</td><td>Single offset for 5000 km east-west span</td></tr>
                </tbody>
            </table>

            <h2 class="section-title">Time-Related Entities and Glossary</h2>
            <ul>
                <li><strong>IANA tz database</strong> &mdash; The canonical source of timezone data, maintained by IANA and updated several times a year. Also called the Olson database.</li>
                <li><strong>UTC offset</strong> &mdash; The signed difference between local time and UTC, like &minus;05:00 or +09:00.</li>
                <li><strong>DST</strong> &mdash; Daylight Saving Time, the seasonal one-hour clock shift.</li>
                <li><strong>ISO 8601</strong> &mdash; The international standard date and time format: <code>2026-05-27T14:30:00Z</code>.</li>
                <li><strong>Unix epoch</strong> &mdash; 1970-01-01T00:00:00Z, the zero point for Unix timestamps.</li>
                <li><strong>Leap second</strong> &mdash; A second occasionally added to UTC to keep it within 0.9 sec of astronomical UT1. Likely to be abolished by 2035 per a 2022 BIPM resolution.</li>
                <li><strong>Solar noon</strong> &mdash; The instant when the sun is highest in the sky at a given location. The original reference for "12pm" before standardization.</li>
                <li><strong>Sidereal time</strong> &mdash; Time measured relative to fixed stars rather than the sun. Used in astronomy; about 4 minutes shorter per day than solar time.</li>
            </ul>

            <h2 class="section-title">World Clock FAQ</h2>
            <?php
            blogtimer_render_faq([
                ['q' => 'Where does the time data come from?', 'a' => 'Your browser. The Intl.DateTimeFormat API uses the IANA timezone database compiled into the browser (typically updated with each browser release). There is no external API call, no rate limit, and no network requirement once the page has loaded.'],
                ['q' => 'How accurate is the displayed time?', 'a' => 'As accurate as your system clock. The browser reads the OS clock, applies the timezone offset from the tz database for the requested IANA zone, and formats the result. If your computer clock is correct (synced via NTP, which most operating systems do automatically), the displayed time is correct to the second.'],
                ['q' => 'Does the clock handle daylight saving time correctly?', 'a' => 'Yes. The IANA timezone database includes every DST transition rule, and Intl.DateTimeFormat applies them automatically. When a region springs forward or falls back, the displayed time shifts at the correct moment.'],
                ['q' => 'Can I save my custom city list?', 'a' => 'Yes. Cities you add are saved in your browser localStorage and persist across sessions on the same device. Clearing site data will erase the list. We do not sync cities across devices.'],
                ['q' => 'What timezones are supported?', 'a' => 'All 300+ IANA timezones supported by your browser. The autocomplete list includes the largest cities; for less-common zones, type the IANA name (like Atlantic/Reykjavik or Pacific/Marquesas) directly.'],
                ['q' => 'Why are some cities ahead of others by half an hour or 15 minutes?', 'a' => 'Some countries use offsets that are not whole hours from UTC. India is UTC+5:30, Nepal is UTC+5:45, Chatham Islands (New Zealand) are UTC+12:45. These reflect historical political decisions that prioritized geographic or cultural fit over global alignment.'],
                ['q' => 'Does the clock work offline?', 'a' => 'Yes. Once the page has loaded, the world clock runs entirely from your browser. You can disconnect from the internet and it will continue to update every second indefinitely.'],
                ['q' => 'What is the difference between EST and America/New_York?', 'a' => 'EST is specifically the winter standard offset (UTC&minus;5). It does not change with DST. America/New_York is the full IANA timezone definition, which automatically switches between EST in winter and EDT (UTC&minus;4) in summer. Always use the IANA name in software; reserve EST/EDT for human-readable display.'],
            ]);
            ?>
        </div>
    </section>

    <script>
    const worldClock = (function() {
        const DEFAULTS = [
            { city: 'New York', tz: 'America/New_York' },
            { city: 'London', tz: 'Europe/London' },
            { city: 'Paris', tz: 'Europe/Paris' },
            { city: 'Tokyo', tz: 'Asia/Tokyo' },
            { city: 'Sydney', tz: 'Australia/Sydney' },
            { city: 'Dubai', tz: 'Asia/Dubai' }
        ];
        const CITY_LIST = [
            { city: 'New York', tz: 'America/New_York' },
            { city: 'Los Angeles', tz: 'America/Los_Angeles' },
            { city: 'Chicago', tz: 'America/Chicago' },
            { city: 'Toronto', tz: 'America/Toronto' },
            { city: 'Vancouver', tz: 'America/Vancouver' },
            { city: 'Mexico City', tz: 'America/Mexico_City' },
            { city: 'Sao Paulo', tz: 'America/Sao_Paulo' },
            { city: 'Buenos Aires', tz: 'America/Argentina/Buenos_Aires' },
            { city: 'London', tz: 'Europe/London' },
            { city: 'Dublin', tz: 'Europe/Dublin' },
            { city: 'Paris', tz: 'Europe/Paris' },
            { city: 'Berlin', tz: 'Europe/Berlin' },
            { city: 'Madrid', tz: 'Europe/Madrid' },
            { city: 'Rome', tz: 'Europe/Rome' },
            { city: 'Amsterdam', tz: 'Europe/Amsterdam' },
            { city: 'Zurich', tz: 'Europe/Zurich' },
            { city: 'Stockholm', tz: 'Europe/Stockholm' },
            { city: 'Athens', tz: 'Europe/Athens' },
            { city: 'Istanbul', tz: 'Europe/Istanbul' },
            { city: 'Moscow', tz: 'Europe/Moscow' },
            { city: 'Dubai', tz: 'Asia/Dubai' },
            { city: 'Riyadh', tz: 'Asia/Riyadh' },
            { city: 'Tehran', tz: 'Asia/Tehran' },
            { city: 'Karachi', tz: 'Asia/Karachi' },
            { city: 'Mumbai', tz: 'Asia/Kolkata' },
            { city: 'Delhi', tz: 'Asia/Kolkata' },
            { city: 'Kathmandu', tz: 'Asia/Kathmandu' },
            { city: 'Dhaka', tz: 'Asia/Dhaka' },
            { city: 'Bangkok', tz: 'Asia/Bangkok' },
            { city: 'Jakarta', tz: 'Asia/Jakarta' },
            { city: 'Singapore', tz: 'Asia/Singapore' },
            { city: 'Hong Kong', tz: 'Asia/Hong_Kong' },
            { city: 'Shanghai', tz: 'Asia/Shanghai' },
            { city: 'Beijing', tz: 'Asia/Shanghai' },
            { city: 'Taipei', tz: 'Asia/Taipei' },
            { city: 'Tokyo', tz: 'Asia/Tokyo' },
            { city: 'Seoul', tz: 'Asia/Seoul' },
            { city: 'Manila', tz: 'Asia/Manila' },
            { city: 'Sydney', tz: 'Australia/Sydney' },
            { city: 'Melbourne', tz: 'Australia/Melbourne' },
            { city: 'Brisbane', tz: 'Australia/Brisbane' },
            { city: 'Perth', tz: 'Australia/Perth' },
            { city: 'Auckland', tz: 'Pacific/Auckland' },
            { city: 'Honolulu', tz: 'Pacific/Honolulu' },
            { city: 'Anchorage', tz: 'America/Anchorage' },
            { city: 'Cape Town', tz: 'Africa/Johannesburg' },
            { city: 'Johannesburg', tz: 'Africa/Johannesburg' },
            { city: 'Nairobi', tz: 'Africa/Nairobi' },
            { city: 'Cairo', tz: 'Africa/Cairo' },
            { city: 'Lagos', tz: 'Africa/Lagos' },
            { city: 'Reykjavik', tz: 'Atlantic/Reykjavik' }
        ];

        const grid = document.getElementById('wc-grid');
        const searchInput = document.getElementById('wc-search');
        const datalist = document.getElementById('wc-cities');
        let cities = loadCities();

        function loadCities() {
            try {
                const stored = localStorage.getItem('wc.cities');
                if (stored) return JSON.parse(stored);
            } catch (e) {}
            return DEFAULTS.slice();
        }

        function saveCities() {
            try { localStorage.setItem('wc.cities', JSON.stringify(cities)); } catch (e) {}
        }

        function populateDatalist() {
            datalist.innerHTML = CITY_LIST.map(function(c) {
                return '<option value="' + c.city + '">' + c.tz + '</option>';
            }).join('');
        }

        function format(date, tz) {
            try {
                return new Intl.DateTimeFormat([], {
                    timeZone: tz,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).format(date);
            } catch (e) {
                return '??:??:??';
            }
        }

        function formatDate(date, tz) {
            try {
                return new Intl.DateTimeFormat([], {
                    timeZone: tz,
                    weekday: 'short',
                    day: '2-digit',
                    month: 'short'
                }).format(date);
            } catch (e) {
                return '';
            }
        }

        function getOffset(tz) {
            try {
                const fmt = new Intl.DateTimeFormat('en-US', {
                    timeZone: tz,
                    timeZoneName: 'shortOffset'
                });
                const parts = fmt.formatToParts(new Date());
                const offsetPart = parts.find(p => p.type === 'timeZoneName');
                return offsetPart ? offsetPart.value : '';
            } catch (e) { return ''; }
        }

        function render() {
            grid.innerHTML = cities.map(function(c, i) {
                return '<div class="card" style="padding:var(--space-4);text-align:center;position:relative;">'
                    + '<button data-remove="' + i + '" style="position:absolute;top:0.5rem;right:0.5rem;background:none;border:none;color:var(--color-text-muted);cursor:pointer;font-size:1.25rem;line-height:1;padding:0.5rem;" title="Remove city" aria-label="Remove ' + escapeHtml(c.city) + '">&times;</button>'
                    + '<div style="font-size:0.875rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--color-text-muted);">' + escapeHtml(c.city) + '</div>'
                    + '<div class="wc-time" data-tz="' + escapeHtml(c.tz) + '" style="font-size:clamp(1.75rem,4vw,2.25rem);font-weight:700;font-variant-numeric:tabular-nums;color:var(--color-primary);margin:0.25rem 0;">--:--:--</div>'
                    + '<div class="wc-date" data-tz="' + escapeHtml(c.tz) + '" style="font-size:0.8125rem;color:var(--color-text-secondary);"></div>'
                    + '<div style="font-size:0.75rem;color:var(--color-text-muted);margin-top:0.25rem;">' + escapeHtml(getOffset(c.tz)) + '</div>'
                    + '</div>';
            }).join('');
            updateAll();
        }

        function updateAll() {
            const now = new Date();
            grid.querySelectorAll('.wc-time').forEach(function(el) {
                el.textContent = format(now, el.dataset.tz);
            });
            grid.querySelectorAll('.wc-date').forEach(function(el) {
                el.textContent = formatDate(now, el.dataset.tz);
            });
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function addFromInput() {
            const val = searchInput.value.trim();
            if (!val) return;
            // Try CITY_LIST first
            const match = CITY_LIST.find(function(c) {
                return c.city.toLowerCase() === val.toLowerCase() || c.tz.toLowerCase() === val.toLowerCase();
            });
            let entry = null;
            if (match) {
                entry = { city: match.city, tz: match.tz };
            } else {
                // Treat as IANA tz directly
                try {
                    new Intl.DateTimeFormat([], { timeZone: val });
                    entry = { city: val.split('/').pop().replace(/_/g, ' '), tz: val };
                } catch (e) {
                    showMsg('Unknown city or timezone: ' + val);
                    return;
                }
            }
            if (cities.find(c => c.tz === entry.tz)) {
                showMsg('That city is already on the list.');
                return;
            }
            cities.push(entry);
            saveCities();
            render();
            searchInput.value = '';
        }

        function remove(idx) {
            cities.splice(idx, 1);
            saveCities();
            render();
        }

        function resetDefaults() {
            cities = DEFAULTS.slice();
            saveCities();
            render();
        }

        // Inline status message (replaces blocking alert()).
        var msgEl = document.createElement('div');
        msgEl.setAttribute('role', 'alert');
        msgEl.setAttribute('aria-live', 'assertive');
        msgEl.style.cssText = 'color:var(--color-error,#ef4444);font-size:0.875rem;margin-top:0.5rem;min-height:1.25em;';
        searchInput.parentNode.insertBefore(msgEl, searchInput.nextSibling);
        var msgTimer = null;
        function showMsg(text) {
            msgEl.textContent = text;
            clearTimeout(msgTimer);
            msgTimer = setTimeout(function () { msgEl.textContent = ''; }, 4000);
        }

        // Event delegation for remove buttons (no inline onclick).
        grid.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-remove]');
            if (!btn) return;
            var idx = parseInt(btn.getAttribute('data-remove'), 10);
            if (!isNaN(idx)) remove(idx);
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); addFromInput(); }
        });

        populateDatalist();
        render();
        setInterval(updateAll, 1000);

        return { addFromInput, remove, resetDefaults };
    })();
    </script>

    <?php blogtimer_render_see_also('page'); ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "World Clock — Live Time in Any City, Any Timezone",
  "description": "Free browser world clock with live time in 300+ IANA timezones. Add and save custom cities. Uses Intl.DateTimeFormat and the official tz database.",
  "url": "<?php echo esc_url(home_url('/world-clock')); ?>",
  "dateModified": "2026-05-27",
  "author": {"@id": "<?php echo home_url('/author-suraj-giri'); ?>#person"},
  "publisher": {"@id": "<?php echo home_url('/#organization'); ?>"}
}
</script>

<?php get_footer(); ?>
