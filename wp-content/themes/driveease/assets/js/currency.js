/**
 * DriveEase — Currency Conversion & Formatting
 *
 * Handles multi-currency display (USD / EUR / AMD), price formatting,
 * and live updates of all `[data-usd]` price elements on the page.
 * Persists the chosen currency in localStorage key `de_curr`.
 *
 * Depends on: i18n.js (DriveEaseI18n) for per_day translation.
 *
 * @package DriveEase
 * @since   1.0.0
 */

'use strict';

/* global DriveEaseI18n */

const DriveEaseCurrency = ( function () {

	/** Exchange rates relative to 1 USD. */
	const RATES = { usd: 1, eur: 0.92, amd: 387 };

	/** Currency symbols. */
	const SYMS = { usd: '$', eur: '\u20ac', amd: '\u058f' };

	/** Display names. */
	const CNAMES = { usd: 'USD', eur: 'EUR', amd: 'AMD' };

	/** Currently active currency code. */
	let curr = localStorage.getItem( 'de_curr' ) || 'usd';

	/**
	 * Format a USD amount in the given (or current) currency.
	 *
	 * @param {number} usd  Amount in US dollars.
	 * @param {string} [c]  Target currency code (defaults to current).
	 * @return {string} Formatted price string, e.g. "$45.00" or "֏17,415".
	 */
	function fmtP( usd, c ) {
		c = c || curr;
		var v = usd * RATES[ c ];
		if ( c === 'amd' ) {
			return SYMS[ c ] + Math.round( v ).toLocaleString();
		}
		return SYMS[ c ] + v.toFixed( 2 );
	}

	/**
	 * Switch the active currency, persist to localStorage,
	 * and update every element carrying a `data-usd` attribute.
	 *
	 * @param {string} c Currency code ('usd' | 'eur' | 'amd').
	 */
	function setCurrency( c ) {
		curr = c;
		localStorage.setItem( 'de_curr', c );

		/* Update all price elements. */
		document.querySelectorAll( '[data-usd]' ).forEach( function ( el ) {
			var usd = parseFloat( el.dataset.usd );
			/* Replace text nodes only, preserving child elements like .price-suf. */
			Array.prototype.slice.call( el.childNodes ).forEach( function ( n ) {
				if ( n.nodeType === 3 ) {
					n.textContent = fmtP( usd );
				}
			} );
		} );

		/* Update currency toggle button text. */
		var tb = document.getElementById( 'currToggle' );
		if ( tb ) {
			tb.innerHTML = SYMS[ c ] + ' ' + CNAMES[ c ] +
				' <i class="fa-solid fa-chevron-down fa-xs"></i>';
		}

		/* Update selected state on currency menu items. */
		document.querySelectorAll( '[data-curr]' ).forEach( function ( btn ) {
			btn.classList.toggle( 'selected', btn.dataset.curr === c );
		} );

		/* Update sidebar price on single-car pages. */
		var sbPrice = document.querySelector( '.sb-price-val' );
		if ( sbPrice && typeof window.driveeaseCar !== 'undefined' ) {
			sbPrice.textContent = fmtP( window.driveeaseCar.price );
		}

		/* Update modal preview price if a car is selected. */
		var pp = document.getElementById( 'previewPrice' );
		if ( pp && typeof window.driveeaseCar !== 'undefined' ) {
			var lang = DriveEaseI18n.getLang();
			pp.textContent = fmtP( window.driveeaseCar.price ) +
				DriveEaseI18n.t( 'per_day', lang );
		}

		/* Let other modules react. */
		if ( typeof window.updateSummary === 'function' ) {
			window.updateSummary();
		}
		if ( typeof window.updateSidebar === 'function' ) {
			window.updateSidebar();
		}
	}

	/**
	 * Return the current currency code.
	 *
	 * @return {string}
	 */
	function getCurrency() {
		return curr;
	}

	/* ── Public API ── */
	window.setCurrency = setCurrency;

	return {
		RATES:       RATES,
		SYMS:        SYMS,
		CNAMES:      CNAMES,
		fmtP:        fmtP,
		setCurrency: setCurrency,
		getCurrency: getCurrency,
	};

} )();
