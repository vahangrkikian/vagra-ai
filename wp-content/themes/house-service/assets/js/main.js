/**
 * House Service — Main JS (front page)
 *
 * @package House_Service
 */

(function () {
    'use strict';

    /* -----------------------------------------------------------------------
       Sticky Nav Transparency
       ----------------------------------------------------------------------- */
    const nav = document.getElementById('site-nav');
    if (nav) {
        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    if (window.scrollY > 20) {
                        nav.classList.add('nav--scrolled');
                    } else {
                        nav.classList.remove('nav--scrolled');
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    /* -----------------------------------------------------------------------
       Mobile Menu Toggle
       ----------------------------------------------------------------------- */
    const hamburger = document.getElementById('nav-hamburger');
    const mobileNav = document.getElementById('nav-mobile');
    const mobileClose = document.getElementById('nav-mobile-close');

    function openMobile() {
        if (mobileNav) {
            mobileNav.classList.add('is-open');
            mobileNav.setAttribute('aria-hidden', 'false');
            if (hamburger) hamburger.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobile() {
        if (mobileNav) {
            mobileNav.classList.remove('is-open');
            mobileNav.setAttribute('aria-hidden', 'true');
            if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }

    if (hamburger) hamburger.addEventListener('click', openMobile);
    if (mobileClose) mobileClose.addEventListener('click', closeMobile);
    if (mobileNav) {
        mobileNav.addEventListener('click', function (e) {
            if (e.target === mobileNav) closeMobile();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMobile();
    });

    /* -----------------------------------------------------------------------
       Scroll Reveal (IntersectionObserver)
       ----------------------------------------------------------------------- */
    const reveals = document.querySelectorAll('[data-reveal]');
    if (reveals.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
        );
        reveals.forEach(function (el) {
            observer.observe(el);
        });
    } else {
        // Fallback: show all.
        reveals.forEach(function (el) {
            el.classList.add('is-visible');
        });
    }

    /* -----------------------------------------------------------------------
       Hero Search Form
       ----------------------------------------------------------------------- */
    const heroSearch = document.getElementById('hero-search');
    if (heroSearch) {
        heroSearch.addEventListener('submit', function (e) {
            var q = heroSearch.querySelector('[name="hs_q"]');
            var loc = heroSearch.querySelector('[name="hs_loc"]');
            // Allow empty search to go to browse page.
            if (q && !q.value.trim() && loc && !loc.value.trim()) {
                // Remove empty params from URL.
                e.preventDefault();
                window.location.href = heroSearch.action;
            }
        });
    }

    /* -----------------------------------------------------------------------
       Stats Counter Animation
       ----------------------------------------------------------------------- */
    var statValues = document.querySelectorAll('[data-count]');
    if (statValues.length && 'IntersectionObserver' in window) {
        var statsObserver = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        animateCount(entry.target);
                        statsObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.5 }
        );
        statValues.forEach(function (el) {
            statsObserver.observe(el);
        });
    }

    function animateCount(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target)) return;

        var duration = 1500;
        var start = 0;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            // Ease out quad.
            var eased = 1 - (1 - progress) * (1 - progress);
            var current = Math.floor(eased * target);
            el.textContent = current + '+';
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        }

        window.requestAnimationFrame(step);
    }
})();
