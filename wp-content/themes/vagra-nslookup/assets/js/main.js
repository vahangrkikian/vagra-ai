/**
 * Vagra NSLookup - Main JS
 *
 * Vanilla JavaScript, no dependencies.
 * 1. Scroll reveal (IntersectionObserver)
 * 2. Mobile menu toggle with aria-expanded
 * 3. Feature card mouse-tracking gradient glow
 * 4. Reduced motion support
 * 5. Counter animations for stat numbers
 *
 * @package Vagra_NSLookup
 */
(function () {
	'use strict';

	var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* -------------------------------------------------------
	 * 1. Scroll Reveal
	 * ------------------------------------------------------- */
	function initScrollReveal() {
		var reveals = document.querySelectorAll('.reveal, .reveal-scale');
		if (!reveals.length || !('IntersectionObserver' in window)) {
			// Fallback: show everything immediately
			reveals.forEach(function (el) { el.classList.add('in'); });
			return;
		}

		if (prefersReducedMotion) {
			reveals.forEach(function (el) { el.classList.add('in'); });
			return;
		}

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('in');
					io.unobserve(entry.target);

					// Trigger counter animation if this element contains stat numbers
					animateCounters(entry.target);
				}
			});
		}, { threshold: 0.12 });

		reveals.forEach(function (el) { io.observe(el); });
	}

	/* -------------------------------------------------------
	 * 2. Mobile Menu Toggle
	 * ------------------------------------------------------- */
	function initMobileMenu() {
		var burger = document.querySelector('.nsl-nav-burger');
		if (!burger) return;

		var mobileMenu = document.getElementById('nsl-mobile-menu');
		if (!mobileMenu) {
			var nav = burger.closest('.nsl-nav');
			mobileMenu = nav && nav.querySelector('.nsl-nav-mobile');
		}
		if (!mobileMenu) return;

		burger.addEventListener('click', function () {
			var isOpen = burger.getAttribute('aria-expanded') === 'true';
			burger.setAttribute('aria-expanded', String(!isOpen));
			mobileMenu.setAttribute('aria-hidden', String(isOpen));
			mobileMenu.style.display = isOpen ? 'none' : 'flex';
		});
	}

	/* -------------------------------------------------------
	 * 3. Feature Card Mouse Tracking
	 * ------------------------------------------------------- */
	function initMouseGlow() {
		if (prefersReducedMotion) return;

		var cards = document.querySelectorAll('.cine-feature');
		if (!cards.length) return;

		cards.forEach(function (card) {
			card.addEventListener('mousemove', function (e) {
				var rect = card.getBoundingClientRect();
				var x = e.clientX - rect.left;
				var y = e.clientY - rect.top;
				card.style.setProperty('--mx', x + 'px');
				card.style.setProperty('--my', y + 'px');
			});
		});
	}

	/* -------------------------------------------------------
	 * 5. Counter Animations
	 * ------------------------------------------------------- */
	function animateCounters(container) {
		if (prefersReducedMotion) return;

		var statNums = container.querySelectorAll('.cine-stat-num, .cine-stat-n');
		if (!statNums.length) return;

		statNums.forEach(function (el) {
			if (el.dataset.counted) return;
			el.dataset.counted = '1';

			var text = el.textContent.trim();
			// Extract numeric part, prefix (e.g. nothing), and suffix (e.g. '+', '%', 'M+')
			var match = text.match(/^([^\d]*)([\d,]+(?:\.\d+)?)(.*)/);
			if (!match) return;

			var prefix = match[1];
			var targetStr = match[2].replace(/,/g, '');
			var suffix = match[3];
			var target = parseFloat(targetStr);
			if (isNaN(target) || target === 0) return;

			var hasDecimal = targetStr.indexOf('.') !== -1;
			var decimalPlaces = hasDecimal ? targetStr.split('.')[1].length : 0;
			var useCommas = match[2].indexOf(',') !== -1;
			var duration = 1200;
			var startTime = null;

			function formatNumber(n) {
				var str = hasDecimal ? n.toFixed(decimalPlaces) : Math.round(n).toString();
				if (useCommas) {
					var parts = str.split('.');
					parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
					str = parts.join('.');
				}
				return str;
			}

			function step(timestamp) {
				if (!startTime) startTime = timestamp;
				var progress = Math.min((timestamp - startTime) / duration, 1);
				// Ease out cubic
				var eased = 1 - Math.pow(1 - progress, 3);
				var current = eased * target;
				el.textContent = prefix + formatNumber(current) + suffix;
				if (progress < 1) {
					requestAnimationFrame(step);
				}
			}

			el.textContent = prefix + formatNumber(0) + suffix;
			requestAnimationFrame(step);
		});
	}

	/* -------------------------------------------------------
	 * 6. Sticky Nav Scroll State
	 * ------------------------------------------------------- */
	function initNavScroll() {
		var nav = document.querySelector('.nsl-nav');
		if (!nav) return;

		function onScroll() {
			nav.classList.toggle('is-scrolled', window.scrollY > 40);
		}
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* -------------------------------------------------------
	 * Init
	 * ------------------------------------------------------- */
	initScrollReveal();
	initMobileMenu();
	initMouseGlow();
	initNavScroll();
})();
