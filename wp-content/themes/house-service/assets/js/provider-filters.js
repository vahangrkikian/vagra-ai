/**
 * House Service — Provider Archive Filters
 *
 * Client-side filtering of provider cards by category, price level, search text, and sort.
 *
 * @package House_Service
 */

(function () {
    'use strict';

    var grid = document.getElementById('provider-grid');
    if (!grid) return;

    var cards = Array.from(grid.querySelectorAll('.co-card'));
    var tabs = document.querySelectorAll('.filter-tab');
    var priceBtns = document.querySelectorAll('.filter-price');
    var searchInput = document.getElementById('filter-search-input');
    var sortSelect = document.getElementById('filter-sort');
    var resetBtn = document.getElementById('reset-filters');
    var emptyState = document.getElementById('empty-state');

    var activeCat = 'all';
    var activePrice = null;
    var searchTerm = '';

    /* -----------------------------------------------------------------------
       Category Tabs
       ----------------------------------------------------------------------- */
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');
            activeCat = tab.getAttribute('data-cat') || 'all';
            applyFilters();
        });
    });

    /* -----------------------------------------------------------------------
       Price Level Buttons
       ----------------------------------------------------------------------- */
    priceBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var price = btn.getAttribute('data-price');
            if (activePrice === price) {
                // Toggle off.
                btn.classList.remove('is-active');
                activePrice = null;
            } else {
                priceBtns.forEach(function (b) { b.classList.remove('is-active'); });
                btn.classList.add('is-active');
                activePrice = price;
            }
            applyFilters();
        });
    });

    /* -----------------------------------------------------------------------
       Search Input
       ----------------------------------------------------------------------- */
    if (searchInput) {
        var debounceTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                searchTerm = searchInput.value.trim().toLowerCase();
                applyFilters();
            }, 250);
        });
    }

    /* -----------------------------------------------------------------------
       Sort Select
       ----------------------------------------------------------------------- */
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            applyFilters();
        });
    }

    /* -----------------------------------------------------------------------
       Reset Filters
       ----------------------------------------------------------------------- */
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            activeCat = 'all';
            activePrice = null;
            searchTerm = '';

            tabs.forEach(function (t) { t.classList.remove('is-active'); });
            if (tabs.length) tabs[0].classList.add('is-active');
            priceBtns.forEach(function (b) { b.classList.remove('is-active'); });
            if (searchInput) searchInput.value = '';
            if (sortSelect) sortSelect.value = 'rating';

            applyFilters();
        });
    }

    /* -----------------------------------------------------------------------
       Apply Filters
       ----------------------------------------------------------------------- */
    function applyFilters() {
        var visible = [];

        cards.forEach(function (card) {
            var cat = card.getAttribute('data-cat') || '';
            var price = card.getAttribute('data-price') || '';
            var name = card.getAttribute('data-name') || '';

            var show = true;

            // Category filter.
            if (activeCat !== 'all' && cat !== activeCat) {
                show = false;
            }

            // Price filter.
            if (activePrice && price !== activePrice) {
                show = false;
            }

            // Search filter.
            if (searchTerm && name.indexOf(searchTerm) === -1) {
                show = false;
            }

            card.style.display = show ? '' : 'none';
            if (show) visible.push(card);
        });

        // Sort visible cards.
        if (sortSelect) {
            var sortVal = sortSelect.value;
            visible.sort(function (a, b) {
                switch (sortVal) {
                    case 'rating':
                        return parseFloat(b.getAttribute('data-rating') || 0) -
                               parseFloat(a.getAttribute('data-rating') || 0);
                    case 'reviews':
                        return parseInt(b.getAttribute('data-reviews') || 0, 10) -
                               parseInt(a.getAttribute('data-reviews') || 0, 10);
                    case 'price-asc':
                        return parseInt(a.getAttribute('data-price') || 0, 10) -
                               parseInt(b.getAttribute('data-price') || 0, 10);
                    case 'price-desc':
                        return parseInt(b.getAttribute('data-price') || 0, 10) -
                               parseInt(a.getAttribute('data-price') || 0, 10);
                    case 'newest':
                    default:
                        return 0;
                }
            });

            // Reorder in DOM.
            visible.forEach(function (card) {
                grid.appendChild(card);
            });
        }

        // Empty state.
        if (emptyState) {
            emptyState.style.display = visible.length === 0 ? '' : 'none';
        }

        // If there's a separate empty-state element outside the grid, handle that.
        var gridEmpty = grid.querySelector('.empty-state');
        if (gridEmpty) {
            gridEmpty.style.display = visible.length === 0 ? '' : 'none';
        }
    }

    /* -----------------------------------------------------------------------
       Scroll Reveal (also on archive)
       ----------------------------------------------------------------------- */
    var reveals = document.querySelectorAll('[data-reveal]');
    if (reveals.length && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(
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
        reveals.forEach(function (el) {
            el.classList.add('is-visible');
        });
    }

    /* -----------------------------------------------------------------------
       Sticky Nav (also on archive)
       ----------------------------------------------------------------------- */
    var nav = document.getElementById('site-nav');
    if (nav) {
        var ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    nav.classList.toggle('nav--scrolled', window.scrollY > 20);
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
})();
