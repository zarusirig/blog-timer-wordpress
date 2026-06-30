/**
 * FAQ Accordion — accessible disclosure widgets.
 * Toggles .open on the .faq-item and mirrors the state to aria-expanded on the
 * .faq-question button (so screen readers announce open/closed).
 */
(function () {
    'use strict';

    function setOpen(item, open) {
        item.classList.toggle('open', open);
        var q = item.querySelector('.faq-question');
        if (q) q.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var faqItems = document.querySelectorAll('.faq-item');
        Array.prototype.forEach.call(faqItems, function (item) {
            var question = item.querySelector('.faq-question');
            if (!question) return;
            question.addEventListener('click', function () {
                var willOpen = !item.classList.contains('open');
                Array.prototype.forEach.call(faqItems, function (other) {
                    if (other !== item) setOpen(other, false);
                });
                setOpen(item, willOpen);
            });
        });
    });
})();
