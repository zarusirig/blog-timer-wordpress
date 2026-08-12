/**
 * Gestation / pregnancy countdown widget.
 * Hydrates elements matching: .bt-gestation-widget
 *   data-species = "cat" | "dog" | ...   (label)
 *   data-days    = total gestation length in days (e.g. 65)
 *   data-event   = "mating" | "breeding"  (label for the start event)
 *
 * The user enters the mating/breeding date; the widget computes days elapsed,
 * days remaining until the estimated due date, current week, and a progress bar.
 * State persists in localStorage so a breeder can leave and come back. Vanilla,
 * no dependencies, CSP-safe (loaded as a deferred external file). If JS is off,
 * the <noscript> fallback in the guide content remains visible.
 */
(function () {
    'use strict';

    var SPECIES_LABEL = {
        cat: 'Cat', dog: 'Dog', rabbit: 'Rabbit', hamster: 'Hamster',
        guinea: 'Guinea Pig', horse: 'Horse', goat: 'Goat', pig: 'Pig'
    };

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    function fmt(d) {
        return d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
    }

    function startOfDay(d) { d.setHours(0, 0, 0, 0); return d; }

    function daysBetween(a, b) { // whole days from a to b
        return Math.round((startOfDay(b) - startOfDay(a)) / 86400000);
    }

    function build(el) {
        var species = el.getAttribute('data-species') || 'pet';
        var total = parseInt(el.getAttribute('data-days'), 10) || 63;
        var event = el.getAttribute('data-event') || 'mating';
        var label = SPECIES_LABEL[species] || (species.charAt(0).toUpperCase() + species.slice(1));
        var storeKey = 'bt_gestation_' + species;

        el.innerHTML = '';

        var card = document.createElement('div');
        card.className = 'gestation-card';
        card.setAttribute('role', 'group');
        card.setAttribute('aria-label', label + ' pregnancy countdown');

        var h = document.createElement('h3');
        h.className = 'gestation-card__title';
        h.textContent = label + ' Pregnancy Countdown';
        card.appendChild(h);

        var sub = document.createElement('p');
        sub.className = 'gestation-card__sub';
        sub.textContent = 'Enter the ' + event + ' date to track day-by-day through the ~' + total + '-day pregnancy.';
        card.appendChild(sub);

        var row = document.createElement('div');
        row.className = 'gestation-card__input-row';
        var lbl = document.createElement('label');
        lbl.setAttribute('for', 'gw-' + species);
        lbl.textContent = event.charAt(0).toUpperCase() + event.slice(1) + ' date';
        var input = document.createElement('input');
        input.type = 'date';
        input.id = 'gw-' + species;
        input.className = 'gestation-card__date';
        row.appendChild(lbl);
        row.appendChild(input);
        card.appendChild(row);

        var out = document.createElement('div');
        out.className = 'gestation-card__out';
        card.appendChild(out);

        var barWrap = document.createElement('div');
        barWrap.className = 'gestation-card__bar-wrap';
        barWrap.setAttribute('hidden', 'true');
        var bar = document.createElement('div');
        bar.className = 'gestation-card__bar';
        barWrap.appendChild(bar);
        var barLabel = document.createElement('div');
        barLabel.className = 'gestation-card__bar-label';
        barWrap.appendChild(barLabel);
        card.appendChild(barWrap);

        var note = document.createElement('p');
        note.className = 'gestation-card__note';
        card.appendChild(note);

        el.appendChild(card);

        // Restore saved date
        try {
            var saved = localStorage.getItem(storeKey);
            if (saved) input.value = saved;
        } catch (e) {}

        function render() {
            var v = input.value;
            if (v) {
                try { localStorage.setItem(storeKey, v); } catch (e) {}
            }
            if (!v) {
                out.innerHTML = '';
                barWrap.hidden = true;
                note.textContent = '';
                return;
            }
            barWrap.hidden = false;
            var mate = new Date(v + 'T00:00:00');
            if (isNaN(mate.getTime())) { out.innerHTML = ''; barWrap.hidden = true; return; }
            var today = new Date();
            var elapsed = daysBetween(mate, today);
            var due = new Date(mate.getTime() + total * 86400000);
            var remaining = total - elapsed;

            var statusLine, statusClass;
            if (elapsed < 0) {
                statusLine = 'That date is in the future. Pick the date the ' + event + ' occurred.';
                statusClass = 'is-wait';
                bar.style.width = '0%';
                barLabel.textContent = '';
            } else if (elapsed >= total) {
                statusLine = 'Past the average ' + total + '-day mark. Watch closely for signs of labor; contact your vet if nothing happens within a few days.';
                statusClass = 'is-due';
                bar.style.width = '100%';
                barLabel.textContent = 'Day ' + elapsed + ' • past due';
            } else {
                var week = Math.min(9, Math.floor(elapsed / 7) + 1);
                statusLine = 'Day ' + elapsed + ' of ~' + total + ' • Week ' + week + ' • about ' +
                    Math.max(0, remaining) + ' day' + (remaining === 1 ? '' : 's') + ' to go.';
                statusClass = 'is-progress';
                bar.style.width = Math.max(2, Math.min(100, Math.round((elapsed / total) * 100))) + '%';
                barLabel.textContent = 'Estimated due ' + fmt(due);
            }
            out.className = 'gestation-card__out ' + statusClass;
            out.innerHTML =
                '<div class="gestation-stat"><span class="gestation-stat__n">' + (elapsed < 0 ? '—' : elapsed) + '</span><span class="gestation-stat__l">days along</span></div>' +
                '<div class="gestation-stat"><span class="gestation-stat__n">' + (elapsed < 0 ? '—' : (remaining < 0 ? '0' : remaining)) + '</span><span class="gestation-stat__l">days to due</span></div>' +
                '<div class="gestation-stat"><span class="gestation-stat__n">' + fmt(due) + '</span><span class="gestation-stat__l">est. due date</span></div>';
            out.insertAdjacentHTML('beforeend', '<p class="gestation-status">' + statusLine + '</p>');
            note.textContent = 'Estimate only. Individual pregnancies vary; confirm with your veterinarian.';
        }

        input.addEventListener('input', render);
        input.addEventListener('change', render);
        render();
    }

    ready(function () {
        var nodes = document.querySelectorAll('.bt-gestation-widget');
        for (var i = 0; i < nodes.length; i++) build(nodes[i]);
        // Re-run if content is injected late (defensive).
        var mo = (window.MutationObserver) ? new MutationObserver(function () {
            var fresh = document.querySelectorAll('.bt-gestation-widget:not(.bt-gestation-widget--done)');
            for (var j = 0; j < fresh.length; j++) { build(fresh[j]); fresh[j].classList.add('bt-gestation-widget--done'); }
        }) : null;
        if (mo) mo.observe(document.body, { childList: true, subtree: true });
        for (var k = 0; k < nodes.length; k++) nodes[k].classList.add('bt-gestation-widget--done');
    });
})();
