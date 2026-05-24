/**
 * DriveEase — Main UI JavaScript
 *
 * Mobile hamburger toggle, currency dropdown, fleet category filtering,
 * smooth scroll for anchor links, car-detail gallery thumbnail switching,
 * sidebar price calculator, and date input constraints.
 *
 * Depends on: i18n.js (DriveEaseI18n), currency.js (DriveEaseCurrency).
 *
 * @package DriveEase
 * @since   1.0.0
 */

'use strict';

/* global DriveEaseI18n, DriveEaseCurrency */

( function () {

	/* ══════════════════════════════════════
	   HELPERS
	══════════════════════════════════════ */

	/** Today in YYYY-MM-DD format (for date-input min values). */
	function today() {
		return new Date().toISOString().split( 'T' )[ 0 ];
	}

	/** Safely get an element by ID (returns null instead of throwing). */
	function $id( id ) {
		return document.getElementById( id );
	}

	/* ══════════════════════════════════════
	   MOBILE NAVIGATION
	══════════════════════════════════════ */

	var menuBtn    = $id( 'menuBtn' );
	var mobileMenu = $id( 'mobileMenu' );

	if ( menuBtn && mobileMenu ) {
		menuBtn.addEventListener( 'click', function () {
			mobileMenu.classList.toggle( 'open' );
			menuBtn.innerHTML = mobileMenu.classList.contains( 'open' )
				? '<i class="fa-solid fa-xmark"></i>'
				: '<i class="fa-solid fa-bars"></i>';
		} );

		mobileMenu.querySelectorAll( 'a' ).forEach( function ( a ) {
			a.addEventListener( 'click', function () {
				mobileMenu.classList.remove( 'open' );
				menuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
			} );
		} );
	}

	/* ══════════════════════════════════════
	   CURRENCY DROPDOWN
	══════════════════════════════════════ */

	var currWrap = $id( 'currWrap' );
	var currMenu = $id( 'currMenu' );

	window.toggleCurrMenu = function () {
		if ( currMenu ) {
			currMenu.classList.toggle( 'open' );
		}
	};

	document.addEventListener( 'click', function ( e ) {
		if ( currMenu && ! e.target.closest( '#currWrap' ) ) {
			currMenu.classList.remove( 'open' );
		}
	} );

	/* Wire up currency option buttons inside the dropdown. */
	document.querySelectorAll( '[data-curr]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			DriveEaseCurrency.setCurrency( btn.dataset.curr );
			if ( currMenu ) {
				currMenu.classList.remove( 'open' );
			}
		} );
	} );

	/* Wire up language buttons. */
	document.querySelectorAll( '.lang-btn, [data-lang]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			if ( btn.dataset.lang ) {
				DriveEaseI18n.setLang( btn.dataset.lang );
			}
		} );
	} );

	/* ══════════════════════════════════════
	   FLEET CATEGORY FILTERING
	══════════════════════════════════════ */

	document.querySelectorAll( '.filter-btn' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			document.querySelectorAll( '.filter-btn' ).forEach( function ( b ) {
				b.classList.remove( 'active' );
			} );
			btn.classList.add( 'active' );

			var f = btn.dataset.filter;
			document.querySelectorAll( '.car-card' ).forEach( function ( c ) {
				c.classList.toggle( 'hidden', f !== 'all' && c.dataset.category !== f );
			} );
		} );
	} );

	/* ══════════════════════════════════════
	   SMOOTH SCROLL FOR ANCHOR LINKS
	══════════════════════════════════════ */

	document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var targetId = link.getAttribute( 'href' );
			if ( targetId.length < 2 ) {
				return; /* Skip bare "#" links. */
			}
			var target = document.querySelector( targetId );
			if ( target ) {
				e.preventDefault();
				target.scrollIntoView( { behavior: 'smooth' } );
			}
		} );
	} );

	/* ══════════════════════════════════════
	   DATE INPUT CONSTRAINTS
	══════════════════════════════════════ */

	[ 'heroPickDate', 'heroDropDate', 'sb-pickdate', 'sb-dropdate',
	  'm-pickdate', 'm-dropdate' ].forEach( function ( id ) {
		var el = $id( id );
		if ( el ) {
			el.min = today();
		}
	} );

	/* Link pick-up → drop-off min date. */
	var pickDropPairs = [
		[ 'heroPickDate', 'heroDropDate' ],
		[ 'sb-pickdate',  'sb-dropdate' ],
		[ 'm-pickdate',   'm-dropdate' ],
	];

	pickDropPairs.forEach( function ( pair ) {
		var pick = $id( pair[ 0 ] );
		var drop = $id( pair[ 1 ] );
		if ( pick && drop ) {
			pick.addEventListener( 'change', function () {
				drop.min = pick.value;
			} );
		}
	} );

	/* ══════════════════════════════════════
	   CAR DETAIL — GALLERY THUMBNAIL SWAP
	══════════════════════════════════════ */

	window.swapImg = function ( thumb, url ) {
		var mainImg = $id( 'mainImg' );
		if ( mainImg ) {
			mainImg.src = url;
		}
		document.querySelectorAll( '.thumb' ).forEach( function ( t ) {
			t.classList.remove( 'active' );
		} );
		if ( thumb ) {
			thumb.classList.add( 'active' );
		}
	};

	/* ══════════════════════════════════════
	   CAR DETAIL — SIDEBAR PRICE CALCULATOR
	══════════════════════════════════════ */

	var sbPickDate = $id( 'sb-pickdate' );
	var sbDropDate = $id( 'sb-dropdate' );

	function getSbDays() {
		if ( ! sbPickDate || ! sbDropDate ) {
			return 1;
		}
		var p = sbPickDate.value;
		var d = sbDropDate.value;
		if ( ! p || ! d ) {
			return 1;
		}
		var diff = ( new Date( d ) - new Date( p ) ) / 86400000;
		return diff > 0 ? diff : 1;
	}

	/**
	 * Recalculate and display the sidebar price breakdown.
	 * Exposed on `window` so i18n.js / currency.js can call it after switching.
	 */
	window.updateSidebar = function () {
		if ( typeof window.driveeaseCar === 'undefined' ) {
			return;
		}
		var days  = getSbDays();
		var price = window.driveeaseCar.price;

		var sbBase  = $id( 'sb-base' );
		var sbTotal = $id( 'sb-total' );

		if ( sbBase ) {
			sbBase.textContent = DriveEaseCurrency.fmtP( price ) +
				' \u00d7 ' + days + ' day' + ( days !== 1 ? 's' : '' );
		}
		if ( sbTotal ) {
			sbTotal.textContent = DriveEaseCurrency.fmtP( price * days );
		}
	};

	if ( sbPickDate ) {
		sbPickDate.addEventListener( 'change', function () {
			if ( sbDropDate ) {
				sbDropDate.min = sbPickDate.value;
			}
			window.updateSidebar();
		} );
	}
	if ( sbDropDate ) {
		sbDropDate.addEventListener( 'change', window.updateSidebar );
	}

	/* ══════════════════════════════════════
	   HERO SEARCH (front page)
	══════════════════════════════════════ */

	var heroSearchBtn = $id( 'heroSearchBtn' );
	if ( heroSearchBtn ) {
		heroSearchBtn.addEventListener( 'click', function () {
			var pickup = $id( 'heroPickup' );
			var pick   = $id( 'heroPickDate' );
			var drop   = $id( 'heroDropDate' );

			if ( pickup && ! pickup.value ) {
				pickup.focus();
				return;
			}
			if ( pick && ! pick.value ) {
				pick.focus();
				return;
			}

			/* Pre-fill modal fields from hero search widget. */
			var mPickup   = $id( 'm-pickup' );
			var mPickDate = $id( 'm-pickdate' );
			var mDropDate = $id( 'm-dropdate' );

			if ( mPickup && pickup )  { mPickup.value   = pickup.value; }
			if ( mPickDate && pick )  { mPickDate.value  = pick.value; }
			if ( mDropDate && drop )  { mDropDate.value  = drop.value; }

			/* Open the booking modal (provided by booking.js). */
			if ( typeof window.openModal === 'function' ) {
				window.openModal( null );
			}
		} );
	}

	/* ══════════════════════════════════════
	   INITIALISE — apply saved preferences
	══════════════════════════════════════ */

	DriveEaseI18n.setLang( DriveEaseI18n.getLang() );
	DriveEaseCurrency.setCurrency( DriveEaseCurrency.getCurrency() );

	if ( typeof window.driveeaseCar !== 'undefined' ) {
		window.updateSidebar();
	}

} )();
