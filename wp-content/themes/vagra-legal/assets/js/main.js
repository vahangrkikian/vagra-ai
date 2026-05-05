/**
 * Vagra MSP Cybersecurity Theme - Main JavaScript
 * Modern UI/UX with scroll animations, micro-interactions, and smooth transitions.
 *
 * @package Vagra_MSP
 */

(function () {
    'use strict';

    // ========================================
    // Mobile Menu Toggle
    // ========================================
    var toggle = document.querySelector('.vagra-header__toggle');
    var nav = document.querySelector('.vagra-header__nav');

    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!expanded));
            nav.classList.toggle('is-open');
            toggle.classList.toggle('is-active');
        });
    }

    // ========================================
    // Scroll Reveal Animation (IntersectionObserver)
    // ========================================
    var revealElements = document.querySelectorAll(
        '.vagra-hero__content, .vagra-hero__visual, ' +
        '.vagra-service-card, .vagra-practice-card, ' +
        '.vagra-stat, .vagra-case-stat, ' +
        '.vagra-testimonial, .vagra-attorney-card, ' +
        '.vagra-section-header, .vagra-cta__content, ' +
        '.vagra-entry'
    );

    if ('IntersectionObserver' in window && revealElements.length > 0) {
        // Add initial hidden state
        for (var i = 0; i < revealElements.length; i++) {
            revealElements[i].classList.add('vagra-reveal');
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    // Stagger children
                    var parent = entry.target.parentElement;
                    if (parent) {
                        var siblings = parent.querySelectorAll('.vagra-reveal');
                        var index = 0;
                        for (var j = 0; j < siblings.length; j++) {
                            if (siblings[j] === entry.target) {
                                index = j;
                                break;
                            }
                        }
                        entry.target.style.transitionDelay = (index * 0.1) + 's';
                    }
                    entry.target.classList.add('vagra-reveal--visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        for (var k = 0; k < revealElements.length; k++) {
            observer.observe(revealElements[k]);
        }
    }

    // ========================================
    // Header Scroll Effect
    // ========================================
    var header = document.querySelector('.vagra-header');
    var lastScroll = 0;

    if (header) {
        window.addEventListener('scroll', function () {
            var currentScroll = window.pageYOffset;

            if (currentScroll > 60) {
                header.classList.add('vagra-header--scrolled');
            } else {
                header.classList.remove('vagra-header--scrolled');
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    // ========================================
    // Counter Animation for Stats
    // ========================================
    var stats = document.querySelectorAll('.vagra-stat__number, .vagra-case-stat__number');

    if ('IntersectionObserver' in window && stats.length > 0) {
        var statsObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        for (var s = 0; s < stats.length; s++) {
            statsObserver.observe(stats[s]);
        }
    }

    function animateCounter(el) {
        var text = el.textContent.trim();
        var match = text.match(/^([<>$]?)(\d+\.?\d*)(.*)/);
        if (!match) return;

        var prefix = match[1];
        var target = parseFloat(match[2]);
        var suffix = match[3];
        var isDecimal = text.indexOf('.') !== -1;
        var duration = 1500;
        var start = 0;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            var current = start + (target - start) * eased;

            if (isDecimal) {
                el.textContent = prefix + current.toFixed(1) + suffix;
            } else {
                el.textContent = prefix + Math.floor(current) + suffix;
            }

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = text; // restore original
            }
        }

        requestAnimationFrame(step);
    }

    // ========================================
    // Parallax Effect for Hero
    // ========================================
    var heroVisual = document.querySelector('.vagra-hero__visual');

    if (heroVisual) {
        window.addEventListener('scroll', function () {
            var scroll = window.pageYOffset;
            if (scroll < 800) {
                heroVisual.style.transform = 'translateY(' + (scroll * 0.15) + 'px)';
            }
        }, { passive: true });
    }

    // ========================================
    // Smooth Scroll for Anchor Links
    // ========================================
    var anchors = document.querySelectorAll('a[href^="#"]');

    for (var a = 0; a < anchors.length; a++) {
        anchors[a].addEventListener('click', function (e) {
            var href = this.getAttribute('href');
            if (href.length <= 1) return;

            var target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // ========================================
    // Magnetic Button Effect
    // ========================================
    var magneticBtns = document.querySelectorAll('.vagra-btn--primary, .vagra-btn--cta, .vagra-hero__cta');

    for (var m = 0; m < magneticBtns.length; m++) {
        (function(btn) {
            btn.addEventListener('mousemove', function (e) {
                var rect = btn.getBoundingClientRect();
                var x = e.clientX - rect.left - rect.width / 2;
                var y = e.clientY - rect.top - rect.height / 2;
                btn.style.transform = 'translate(' + (x * 0.15) + 'px, ' + (y * 0.15) + 'px)';
            });

            btn.addEventListener('mouseleave', function () {
                btn.style.transform = '';
            });
        })(magneticBtns[m]);
    }

    // ========================================
    // Tilt Effect for Cards
    // ========================================
    var tiltCards = document.querySelectorAll('.vagra-service-card, .vagra-practice-card');

    for (var t = 0; t < tiltCards.length; t++) {
        (function(card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var x = (e.clientX - rect.left) / rect.width;
                var y = (e.clientY - rect.top) / rect.height;
                var rotateX = (0.5 - y) * 8;
                var rotateY = (x - 0.5) * 8;
                card.style.transform = 'perspective(800px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale(1.02)';
            });

            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
            });
        })(tiltCards[t]);
    }

    // ========================================
    // Page Load Animation
    // ========================================
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('vagra-loaded');
    });

})();
