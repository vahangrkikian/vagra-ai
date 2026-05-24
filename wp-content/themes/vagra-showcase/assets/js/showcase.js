/**
 * vagra.ai Showcase – Front-end JS
 *
 * @package vagra-showcase
 */
(function () {
    'use strict';

    /* ── Sticky nav scroll detection ── */
    var nav = document.querySelector('.site-nav');
    if (nav) {
        var onScroll = function () {
            nav.setAttribute('data-scrolled', window.scrollY > 40 ? 'true' : 'false');
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ── Scroll reveal (IntersectionObserver) ── */
    var reveals = document.querySelectorAll('[data-reveal]');
    if (reveals.length && 'IntersectionObserver' in window) {
        var revealObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-visible', 'true');
                    revealObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(function (el) { revealObs.observe(el); });
    } else {
        // Fallback: show everything
        reveals.forEach(function (el) { el.setAttribute('data-visible', 'true'); });
    }

    /* ── Hero mouse tracking ── */
    var hero = document.querySelector('.hero');
    var heroMouse = document.querySelector('.hero-mouse');
    if (hero && heroMouse) {
        hero.addEventListener('mousemove', function (e) {
            var rect = hero.getBoundingClientRect();
            heroMouse.style.left = (e.clientX - rect.left) + 'px';
            heroMouse.style.top = (e.clientY - rect.top) + 'px';
        });
    }

    /* ── Theme grid filter ── */
    var filterBar = document.querySelector('.filter-bar');
    if (filterBar) {
        var chips = filterBar.querySelectorAll('.filter-chip');
        var cards = document.querySelectorAll('.theme-card');

        filterBar.addEventListener('click', function (e) {
            var chip = e.target.closest('.filter-chip');
            if (!chip) return;

            chips.forEach(function (c) { c.classList.remove('active'); });
            chip.classList.add('active');

            var filter = chip.getAttribute('data-filter');
            cards.forEach(function (card) {
                if (filter === 'all' || card.getAttribute('data-category') === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    /* ── Chat demo tab switching ── */
    var chatTabs = document.querySelectorAll('.chat-tab');
    var chatPanels = document.querySelectorAll('.chat-panel');
    if (chatTabs.length) {
        chatTabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var target = tab.getAttribute('data-chat');
                chatTabs.forEach(function (t) { t.classList.remove('active'); });
                chatPanels.forEach(function (p) { p.classList.remove('active'); });
                tab.classList.add('active');
                var panel = document.getElementById('chat-' + target);
                if (panel) panel.classList.add('active');
            });
        });
    }

    /* ── Smooth scroll for anchor links ── */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var id = a.getAttribute('href');
            if (id.length < 2) return;
            var target = document.querySelector(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
