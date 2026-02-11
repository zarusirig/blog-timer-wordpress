/**
 * FAQ Accordion
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(function (item) {
            var question = item.querySelector('.faq-question');
            if (!question) return;

            question.addEventListener('click', function () {
                // Close other open items
                faqItems.forEach(function (other) {
                    if (other !== item) other.classList.remove('open');
                });
                // Toggle current
                item.classList.toggle('open');
            });
        });
    });
})();
