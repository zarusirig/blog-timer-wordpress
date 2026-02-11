/**
 * Mobile Navigation Toggle
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('mobile-toggle');
        var nav = document.getElementById('primary-nav');

        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            toggle.querySelector('span').textContent = isOpen ? '✕' : '☰';
        });

        // Close nav on link click (mobile)
        var links = nav.querySelectorAll('a');
        links.forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    nav.classList.remove('open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.querySelector('span').textContent = '☰';
                }
            });
        });
    });
})();
