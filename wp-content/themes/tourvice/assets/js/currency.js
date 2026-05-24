/**
 * TourVice — Currency Conversion & Formatting
 *
 * Handles multi-currency display (USD / EUR / AMD), price formatting,
 * and live updates of all `[data-usd]` price elements on the page.
 * Persists the chosen currency in localStorage key `tv_curr`.
 *
 * Depends on: i18n.js (TourviceI18n) for per_person translation.
 *
 * @package TourVice
 * @since   1.0.0
 */

'use strict';

/* global TourviceI18n */

var TourviceCurrency = ( function () {

  /** Exchange rates relative to 1 USD. */
  var RATES = { usd: 1, eur: 0.92, amd: 387 };

  /** Currency symbols. */
  var SYMS = { usd: '$', eur: '\u20ac', amd: '\u058f' };

  /** Display names. */
  var CNAMES = { usd: 'USD', eur: 'EUR', amd: 'AMD' };

  /** Currently active currency code. */
  var curr = localStorage.getItem( 'tv_curr' ) || 'usd';

  /**
   * Format a USD amount in the given (or current) currency.
   *
   * @param {number} usd  Amount in US dollars.
   * @param {string} [c]  Target currency code (defaults to current).
   * @return {string} Formatted price string.
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
    localStorage.setItem( 'tv_curr', c );

    /* Update all price elements. */
    document.querySelectorAll( '[data-usd]' ).forEach( function ( el ) {
      var usd = parseFloat( el.dataset.usd );
      Array.prototype.slice.call( el.childNodes ).forEach( function ( n ) {
        if ( n.nodeType === 3 ) {
          n.textContent = fmtP( usd );
        }
      } );
    } );

    /* Update currency toggle button text. */
    var tb = document.getElementById( 'tourviceCurrToggle' );
    if ( tb ) {
      tb.innerHTML = SYMS[ c ] + ' ' + CNAMES[ c ] + ' <svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor"><path d="M1 1l4 4 4-4"/></svg>';
    }

    /* Update selected state on currency menu items. */
    document.querySelectorAll( '[data-curr]' ).forEach( function ( btn ) {
      btn.classList.toggle( 'selected', btn.dataset.curr === c );
      btn.classList.toggle( 'active', btn.dataset.curr === c );
    } );

    /* Update booking sidebar price. */
    var sbPrice = document.querySelector( '.tourvice-price-total__value' );
    if ( sbPrice && sbPrice.dataset.usd ) {
      sbPrice.textContent = fmtP( parseFloat( sbPrice.dataset.usd ) );
    }

    /* Update tour card prices. */
    document.querySelectorAll( '.tourvice-card__price-badge[data-usd]' ).forEach( function ( el ) {
      var usd = parseFloat( el.dataset.usd );
      el.textContent = fmtP( usd );
    } );

    /* Update price breakdown rows by ID. */
    var ppEl = document.getElementById( 'tourvice-price-person' );
    if ( ppEl && ppEl.dataset.usd ) {
      ppEl.textContent = fmtP( parseFloat( ppEl.dataset.usd ) );
    }

    var gpEl = document.getElementById( 'tourvice-price-group' );
    if ( gpEl && gpEl.dataset.usd ) {
      gpEl.textContent = fmtP( parseFloat( gpEl.dataset.usd ) );
    }

    var ttEl = document.getElementById( 'tourvice-price-total' );
    if ( ttEl && ttEl.dataset.usd ) {
      ttEl.textContent = fmtP( parseFloat( ttEl.dataset.usd ) );
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

  /**
   * Update all prices on the page using the current currency.
   * Useful after dynamic content is loaded.
   */
  function updatePrices() {
    setCurrency( curr );
  }

  /* -- Public API -- */
  window.setCurrency = setCurrency;

  return {
    RATES:       RATES,
    SYMS:        SYMS,
    CNAMES:      CNAMES,
    fmtP:        fmtP,
    setCurrency: setCurrency,
    getCurrency: getCurrency,
    updatePrices: updatePrices,
  };

} )();
