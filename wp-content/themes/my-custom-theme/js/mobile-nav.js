/**
 * Mobile Navigation — accessible off-canvas drawer + silo accordion.
 *
 * Drawer:  toggle button (aria-expanded) drives .open on #primary-nav.
 *          Escape closes, click-outside closes, body scroll locked while open,
 *          focus moves into the drawer on open and returns to the toggle on close,
 *          Tab is trapped within the drawer.
 * Accordion: each silo's caret button toggles .submenu-open on its parent <li>
 *          (submenus are collapsed by default in CSS, so the menu is no longer a
 *          ~48-link wall). Parent <a> links still navigate to their hub page.
 */
(function () {
    'use strict';

    var MOBILE_MAX = 1320; // must match the nav drawer CSS breakpoint
    var FOCUSABLE = 'a[href], button:not([disabled])';

    function isMobile() { return window.innerWidth <= MOBILE_MAX; }

    function visible(item) { return item.offsetParent !== null; }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('mobile-toggle');
        var nav = document.getElementById('primary-nav');
        if (!toggle || !nav) return;

        var lastFocused = null;

        function open() {
            lastFocused = document.activeElement;
            nav.classList.add('open');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Close menu');
            document.body.style.overflow = 'hidden';   // lock background scroll
            var first = Array.prototype.slice.call(nav.querySelectorAll(FOCUSABLE)).filter(visible)[0];
            if (first) first.focus();
        }

        function close() {
            nav.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Open menu');
            document.body.style.overflow = '';
            // Collapse any open silos so the drawer reopens clean.
            Array.prototype.forEach.call(nav.querySelectorAll('.nav-item--has-submenu.submenu-open'), function (li) {
                li.classList.remove('submenu-open');
            });
            Array.prototype.forEach.call(nav.querySelectorAll('.nav-submenu-toggle'), function (btn) {
                btn.setAttribute('aria-expanded', 'false');
            });
            if (lastFocused && lastFocused.focus) lastFocused.focus();
        }

        function isOpen() { return nav.classList.contains('open'); }

        toggle.addEventListener('click', function () {
            if (isOpen()) { close(); } else { open(); }
        });

        // Escape closes.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen()) {
                e.preventDefault();
                close();
            }
        });

        // Click outside the drawer closes it.
        document.addEventListener('click', function (e) {
            if (!isOpen()) return;
            if (nav.contains(e.target) || toggle.contains(e.target)) return;
            close();
        });

        // Tab is trapped within the drawer while open.
        nav.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab' || !isOpen()) return;
            var items = Array.prototype.slice.call(nav.querySelectorAll(FOCUSABLE)).filter(visible);
            if (!items.length) return;
            var first = items[0], last = items[items.length - 1];
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault(); last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault(); first.focus();
            }
        });

        // Silo accordion: caret toggles each silo independently.
        Array.prototype.forEach.call(nav.querySelectorAll('.nav-submenu-toggle'), function (caret) {
            caret.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var li = caret.closest('.nav-item--has-submenu');
                if (!li) return;
                var expanded = li.classList.toggle('submenu-open');
                caret.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            });
        });

        // Closing the drawer when a leaf link is clicked (mobile) lets the
        // destination page render cleanly. Parent links navigate normally.
        Array.prototype.forEach.call(nav.querySelectorAll('a'), function (link) {
            link.addEventListener('click', function () {
                if (isMobile() && isOpen()) close();
            });
        });

        // Reset if the viewport grows past the breakpoint.
        window.addEventListener('resize', function () {
            if (!isMobile() && isOpen()) close();
        });
    });
})();
