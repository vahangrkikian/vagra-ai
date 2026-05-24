/**
 * DriveEase — Booking Modal Wizard
 *
 * 3-step booking modal: Rental Details, Personal Info, Extras & Payment.
 * Opens from "Book Now" / "Reserve" buttons, pre-fills car data on single
 * car pages, validates each step, formats payment fields, submits via
 * fetch() to the WP AJAX endpoint, and shows a confirmation screen.
 *
 * Depends on: i18n.js (DriveEaseI18n), currency.js (DriveEaseCurrency).
 * Reads: window.driveease_booking (inline from booking-modal.php).
 *        window.driveease_car_data (optional, set on single-car pages).
 *
 * @package DriveEase
 * @since   1.0.0
 */

'use strict';

/* global DriveEaseI18n, DriveEaseCurrency, driveease_booking, driveease_car_data */

( function () {

	/* ══════════════════════════════════════
	   REFERENCES
	══════════════════════════════════════ */

	var overlay     = document.getElementById( 'bookingOverlay' );
	var modal       = document.getElementById( 'bookingModal' );
	var bookingForm = document.getElementById( 'bookingForm' );
	var successScr  = document.getElementById( 'successScreen' );

	if ( ! overlay || ! modal ) {
		return; // Modal markup not present on this page.
	}

	var currentCar  = null;
	var currentStep = 1;
	var bookedDates = []; // Array of { start, end } ISO date strings.

	/* ══════════════════════════════════════
	   HELPERS
	══════════════════════════════════════ */

	function $id( id ) {
		return document.getElementById( id );
	}

	function today() {
		return new Date().toISOString().split( 'T' )[ 0 ];
	}

	/**
	 * Format a USD price using DriveEaseCurrency if available, else plain $.
	 */
	function fmtPrice( usd ) {
		if ( typeof DriveEaseCurrency !== 'undefined' && DriveEaseCurrency.fmtP ) {
			return DriveEaseCurrency.fmtP( usd );
		}
		return '$' + parseFloat( usd ).toFixed( 2 );
	}

	/**
	 * Get the current currency code.
	 */
	function getCurrency() {
		if ( typeof DriveEaseCurrency !== 'undefined' && DriveEaseCurrency.getCurrency ) {
			return DriveEaseCurrency.getCurrency();
		}
		return 'USD';
	}

	/**
	 * Get a translated string by key, with fallback.
	 */
	function t( key, fallback ) {
		if ( typeof DriveEaseI18n !== 'undefined' && DriveEaseI18n.t ) {
			return DriveEaseI18n.t( key ) || fallback;
		}
		return fallback;
	}

	/* ══════════════════════════════════════
	   DATE CONSTRAINTS
	══════════════════════════════════════ */

	/** Set min dates so users cannot pick dates in the past. */
	function enforceDateMins() {
		var d = today();
		var pickEl = $id( 'm-pickdate' );
		var dropEl = $id( 'm-dropdate' );
		if ( pickEl ) {
			pickEl.setAttribute( 'min', d );
		}
		if ( dropEl ) {
			dropEl.setAttribute( 'min', d );
		}
	}

	/**
	 * Check whether a given ISO date string falls within any booked period.
	 */
	function isDateBooked( dateStr ) {
		var ts = new Date( dateStr ).getTime();
		for ( var i = 0; i < bookedDates.length; i++ ) {
			var s = new Date( bookedDates[ i ].start ).getTime();
			var e = new Date( bookedDates[ i ].end ).getTime();
			if ( ts >= s && ts <= e ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Fetch booked periods for a car from the REST API and store them.
	 */
	function fetchAvailability( carId ) {
		if ( ! carId ) {
			bookedDates = [];
			return;
		}
		var base = ( typeof driveease_booking !== 'undefined' && driveease_booking.rest_url )
			? driveease_booking.rest_url
			: '/wp-json/driveease/v1/availability/';

		fetch( base + carId )
			.then( function ( r ) { return r.json(); } )
			.then( function ( periods ) {
				if ( Array.isArray( periods ) ) {
					bookedDates = periods;
				}
			} )
			.catch( function () {
				bookedDates = [];
			} );
	}

	/* ══════════════════════════════════════
	   MODAL OPEN / CLOSE
	══════════════════════════════════════ */

	function openModal( cardEl ) {
		// Pre-fill car data from card element (fleet grid) or single-car page.
		if ( cardEl && cardEl.dataset && cardEl.dataset.price ) {
			currentCar = {
				id:    cardEl.dataset.carId || 0,
				name:  cardEl.dataset.name  || '',
				cls:   cardEl.dataset.class || '',
				img:   cardEl.dataset.img   || '',
				price: parseInt( cardEl.dataset.price, 10 ) || 0
			};
		} else if ( typeof driveease_car_data !== 'undefined' && driveease_car_data.id ) {
			currentCar = {
				id:    driveease_car_data.id,
				name:  driveease_car_data.name  || '',
				cls:   driveease_car_data.category || '',
				img:   driveease_car_data.image || '',
				price: parseInt( driveease_car_data.price, 10 ) || 0
			};
		} else if ( ! currentCar ) {
			currentCar = {
				id:    0,
				name:  t( 'any_car', 'Any Available Car' ),
				cls:   t( 'subject_avail', 'Subject to availability' ),
				img:   '',
				price: 0
			};
		}

		// Populate preview.
		var imgEl = $id( 'previewImg' );
		if ( imgEl ) {
			imgEl.src = currentCar.img;
			imgEl.alt = currentCar.name;
		}
		var nameEl = $id( 'previewName' );
		if ( nameEl ) {
			nameEl.textContent = currentCar.name;
		}
		var clsEl = $id( 'previewClass' );
		if ( clsEl ) {
			clsEl.textContent = currentCar.cls;
		}
		var priceEl = $id( 'previewPrice' );
		if ( priceEl ) {
			priceEl.textContent = currentCar.price
				? fmtPrice( currentCar.price ) + t( 'per_day', '/day' )
				: t( 'from', 'From ' ) + fmtPrice( 38 ) + t( 'per_day', '/day' );
		}

		// Carry sidebar dates into modal fields.
		var sbPick = document.getElementById( 'sb-pickdate' );
		var sbDrop = document.getElementById( 'sb-dropdate' );
		if ( sbPick && sbPick.value ) {
			var mPick = $id( 'm-pickdate' );
			if ( mPick ) {
				mPick.value = sbPick.value;
			}
		}
		if ( sbDrop && sbDrop.value ) {
			var mDrop = $id( 'm-dropdate' );
			if ( mDrop ) {
				mDrop.value = sbDrop.value;
			}
		}

		// Carry sidebar extras into modal extras (match by data-price).
		var sbExtras = document.querySelectorAll( '.sb-extra' );
		for ( var ei = 0; ei < sbExtras.length; ei++ ) {
			var price    = sbExtras[ ei ].dataset.price;
			var modalCb  = modal.querySelector( '.extra-item input[data-price="' + price + '"]' );
			if ( modalCb ) {
				modalCb.checked = sbExtras[ ei ].checked;
				var label = modalCb.closest( '.extra-item' );
				if ( label ) {
					label.classList.toggle( 'selected', modalCb.checked );
				}
			}
		}

		// Fetch availability for this car.
		fetchAvailability( currentCar.id );

		// Reset to step 1.
		goToStep( 1 );
		clearErrors();
		enforceDateMins();

		if ( bookingForm ) {
			bookingForm.style.display = '';
		}
		if ( successScr ) {
			successScr.style.display = 'none';
			successScr.classList.remove( 'show' );
		}

		overlay.classList.add( 'open' );
		document.body.style.overflow = 'hidden';
	}

	function closeModal() {
		overlay.classList.remove( 'open' );
		document.body.style.overflow = '';
	}

	/* ══════════════════════════════════════
	   STEP NAVIGATION
	══════════════════════════════════════ */

	function goToStep( n ) {
		currentStep = n;
		[ 1, 2, 3 ].forEach( function ( i ) {
			var page = $id( 'step-' + i );
			if ( page ) {
				page.classList.toggle( 'active', i === n );
			}
			var ind = $id( 'step-ind-' + i );
			if ( ind ) {
				ind.classList.remove( 'active', 'done' );
				if ( i === n ) {
					ind.classList.add( 'active' );
				}
				if ( i < n ) {
					ind.classList.add( 'done' );
				}
			}
		} );
		updateSummary();
		modal.scrollTop = 0;
	}

	/* ══════════════════════════════════════
	   VALIDATION
	══════════════════════════════════════ */

	function clearErrors() {
		var errEls = document.querySelectorAll( '.field-error' );
		for ( var i = 0; i < errEls.length; i++ ) {
			errEls[ i ].classList.remove( 'show' );
		}
		var inputEls = document.querySelectorAll( '.form-group input, .form-group select' );
		for ( var j = 0; j < inputEls.length; j++ ) {
			inputEls[ j ].classList.remove( 'error' );
		}
	}

	function showErr( fieldId, errId ) {
		var f = $id( fieldId );
		var e = $id( errId );
		if ( f ) {
			f.classList.add( 'error' );
		}
		if ( e ) {
			e.classList.add( 'show' );
		}
	}

	/**
	 * Step 1: Pickup location required, pickup date required,
	 * dropoff date must be after pickup date, dates must not be booked.
	 */
	function validateStep1() {
		clearErrors();
		var ok = true;

		if ( ! $id( 'm-pickup' ).value ) {
			showErr( 'm-pickup', 'err-pickup' );
			ok = false;
		}

		var pickVal = $id( 'm-pickdate' ).value;
		if ( ! pickVal ) {
			showErr( 'm-pickdate', 'err-pickdate' );
			ok = false;
		}

		var dropVal = $id( 'm-dropdate' ).value;
		if ( ! dropVal ) {
			showErr( 'm-dropdate', 'err-dropdate' );
			ok = false;
		} else if ( pickVal && dropVal <= pickVal ) {
			showErr( 'm-dropdate', 'err-dropdate' );
			ok = false;
		}

		// Check against booked dates.
		if ( ok && bookedDates.length ) {
			if ( isDateBooked( pickVal ) ) {
				showErr( 'm-pickdate', 'err-pickdate' );
				ok = false;
			}
			if ( isDateBooked( dropVal ) ) {
				showErr( 'm-dropdate', 'err-dropdate' );
				ok = false;
			}
		}

		return ok;
	}

	/**
	 * Step 2: First name, last name, valid email, phone, licence all required.
	 */
	function validateStep2() {
		clearErrors();
		var ok = true;

		if ( ! $id( 'm-fname' ).value.trim() ) {
			showErr( 'm-fname', 'err-fname' );
			ok = false;
		}
		if ( ! $id( 'm-lname' ).value.trim() ) {
			showErr( 'm-lname', 'err-lname' );
			ok = false;
		}
		if ( ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( $id( 'm-email' ).value ) ) {
			showErr( 'm-email', 'err-email' );
			ok = false;
		}
		if ( ! $id( 'm-phone' ).value.trim() ) {
			showErr( 'm-phone', 'err-phone' );
			ok = false;
		}
		if ( ! $id( 'm-licence' ).value.trim() ) {
			showErr( 'm-licence', 'err-licence' );
			ok = false;
		}

		return ok;
	}

	/**
	 * Step 3: Card name, 16-digit card number, MM/YY expiry, 3-4 digit CVV.
	 */
	function validateStep3() {
		clearErrors();
		var ok = true;

		if ( ! $id( 'm-card-name' ).value.trim() ) {
			showErr( 'm-card-name', 'err-card-name' );
			ok = false;
		}
		if ( ! /^\d{16}$/.test( $id( 'm-card-num' ).value.replace( /\s/g, '' ) ) ) {
			showErr( 'm-card-num', 'err-card-num' );
			ok = false;
		}
		if ( ! /^\d{2}\/\d{2}$/.test( $id( 'm-expiry' ).value ) ) {
			showErr( 'm-expiry', 'err-expiry' );
			ok = false;
		}
		if ( ! /^\d{3,4}$/.test( $id( 'm-cvv' ).value ) ) {
			showErr( 'm-cvv', 'err-cvv' );
			ok = false;
		}

		return ok;
	}

	/* ══════════════════════════════════════
	   PRICE SUMMARY
	══════════════════════════════════════ */

	function getDays() {
		var p = $id( 'm-pickdate' ).value;
		var d = $id( 'm-dropdate' ).value;
		if ( ! p || ! d ) {
			return 1;
		}
		var diff = ( new Date( d ) - new Date( p ) ) / 86400000;
		return diff > 0 ? diff : 1;
	}

	function getExtrasUSD() {
		var total = 0;
		var checked = modal.querySelectorAll( '.extra-item input:checked' );
		for ( var i = 0; i < checked.length; i++ ) {
			total += parseFloat( checked[ i ].dataset.price ) * getDays();
		}
		return total;
	}

	function updateSummary() {
		if ( ! currentCar ) {
			return;
		}
		var days   = getDays();
		var base   = currentCar.price * days;
		var extras = getExtrasUSD();
		var total  = base + extras;

		var sumVehicle = $id( 'sum-vehicle' );
		if ( sumVehicle ) {
			sumVehicle.textContent = currentCar.name;
		}

		var sumDays = $id( 'sum-days' );
		if ( sumDays ) {
			sumDays.textContent = days + ' day' + ( days !== 1 ? 's' : '' );
		}

		var sumBase = $id( 'sum-base' );
		if ( sumBase ) {
			sumBase.textContent = fmtPrice( base );
		}

		var extrasRow = $id( 'sum-extras-row' );
		if ( extrasRow ) {
			if ( extras > 0 ) {
				extrasRow.style.display = '';
				var sumExtras = $id( 'sum-extras' );
				if ( sumExtras ) {
					sumExtras.textContent = fmtPrice( extras );
				}
			} else {
				extrasRow.style.display = 'none';
			}
		}

		var sumTotal = $id( 'sum-total' );
		if ( sumTotal ) {
			sumTotal.textContent = fmtPrice( total );
		}
	}

	/* ══════════════════════════════════════
	   PAYMENT FIELD FORMATTING
	══════════════════════════════════════ */

	/** Card number: groups of 4 digits. */
	function formatCardNumber( e ) {
		var v = e.target.value.replace( /\D/g, '' ).slice( 0, 16 );
		e.target.value = v.replace( /(.{4})/g, '$1 ' ).trim();
	}

	/** Expiry: MM/YY auto-slash. */
	function formatExpiry( e ) {
		var v = e.target.value.replace( /\D/g, '' ).slice( 0, 4 );
		if ( v.length >= 3 ) {
			v = v.slice( 0, 2 ) + '/' + v.slice( 2 );
		}
		e.target.value = v;
	}

	/** CVV: digits only, max 3. */
	function formatCVV( e ) {
		e.target.value = e.target.value.replace( /\D/g, '' ).slice( 0, 3 );
	}

	/* ══════════════════════════════════════
	   FORM SUBMISSION
	══════════════════════════════════════ */

	function collectExtrasLabels() {
		var labels = [];
		var checked = modal.querySelectorAll( '.extra-item input:checked' );
		for ( var i = 0; i < checked.length; i++ ) {
			labels.push( checked[ i ].dataset.label || '' );
		}
		return labels.join( ', ' );
	}

	function submitBooking() {
		if ( ! validateStep3() ) {
			return;
		}

		var btn = $id( 'confirmBtn' );
		btn.disabled = true;
		btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + t( 'processing', 'Processing\u2026' );

		var ajaxUrl = ( typeof driveease_booking !== 'undefined' && driveease_booking.ajax_url )
			? driveease_booking.ajax_url
			: '/wp-admin/admin-ajax.php';

		var nonce = ( typeof driveease_booking !== 'undefined' && driveease_booking.nonce )
			? driveease_booking.nonce
			: '';

		var dropoffLoc = $id( 'm-dropoff' ).value || $id( 'm-pickup' ).value;
		var customerName = $id( 'm-fname' ).value.trim() + ' ' + $id( 'm-lname' ).value.trim();

		var body = new FormData();
		body.append( 'action', 'driveease_submit_booking' );
		body.append( 'nonce', nonce );
		body.append( 'car_id', currentCar.id || 0 );
		body.append( 'pickup_date', $id( 'm-pickdate' ).value );
		body.append( 'dropoff_date', $id( 'm-dropdate' ).value );
		body.append( 'pickup_location', $id( 'm-pickup' ).value );
		body.append( 'dropoff_location', dropoffLoc );
		body.append( 'customer_name', customerName );
		body.append( 'customer_email', $id( 'm-email' ).value );
		body.append( 'customer_phone', $id( 'm-phone' ).value );
		body.append( 'driver_license', $id( 'm-licence' ).value );
		body.append( 'extras', collectExtrasLabels() );
		body.append( 'total_price', ( currentCar.price * getDays() + getExtrasUSD() ).toFixed( 2 ) );
		body.append( 'currency', getCurrency() );

		fetch( ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		} )
			.then( function ( res ) { return res.json(); } )
			.then( function ( data ) {
				if ( data.success ) {
					// Show confirmation screen.
					var refEl = $id( 'bookingRef' );
					if ( refEl ) {
						refEl.textContent = data.data.reference || 'DE-000000';
					}
					if ( bookingForm ) {
						bookingForm.style.display = 'none';
					}
					if ( successScr ) {
						successScr.style.display = '';
						successScr.classList.add( 'show' );
					}
				} else {
					showInlineError( ( data.data && data.data.message ) || t( 'booking_error', 'Booking failed. Please try again.' ) );
				}
			} )
			.catch( function () {
				showInlineError( t( 'network_error', 'Network error. Please check your connection and try again.' ) );
			} )
			.finally( function () {
				btn.disabled = false;
				btn.innerHTML = '<i class="fa-solid fa-lock"></i> ' + t( 'btn_confirm', 'Confirm Booking' );
			} );
	}

	/**
	 * Show an inline error message above the confirm button.
	 */
	function showInlineError( msg ) {
		var existing = modal.querySelector( '.booking-inline-error' );
		if ( existing ) {
			existing.textContent = msg;
			return;
		}
		var el = document.createElement( 'div' );
		el.className = 'booking-inline-error';
		el.style.cssText = 'color:#e74c3c;background:#fdf0ef;border:1px solid #e74c3c;border-radius:8px;padding:10px 14px;margin:12px 0;font-size:.88rem;text-align:center;';
		el.textContent = msg;

		var footer = $id( 'step-3' );
		if ( footer ) {
			var footerEl = footer.querySelector( '.modal-footer' );
			if ( footerEl ) {
				footer.insertBefore( el, footerEl );
			} else {
				footer.appendChild( el );
			}
		}
	}

	/* ══════════════════════════════════════
	   EVENT LISTENERS
	══════════════════════════════════════ */

	// Extras checkboxes — toggle selected class + update summary.
	var extraInputs = modal.querySelectorAll( '.extra-item input' );
	for ( var i = 0; i < extraInputs.length; i++ ) {
		extraInputs[ i ].addEventListener( 'change', function () {
			this.closest( '.extra-item' ).classList.toggle( 'selected', this.checked );
			updateSummary();
		} );
	}

	// Payment field formatting.
	var cardNumEl = $id( 'm-card-num' );
	if ( cardNumEl ) {
		cardNumEl.addEventListener( 'input', formatCardNumber );
	}

	var expiryEl = $id( 'm-expiry' );
	if ( expiryEl ) {
		expiryEl.addEventListener( 'input', formatExpiry );
	}

	var cvvEl = $id( 'm-cvv' );
	if ( cvvEl ) {
		cvvEl.addEventListener( 'input', formatCVV );
	}

	// Date change — update summary.
	var pickDateEl = $id( 'm-pickdate' );
	if ( pickDateEl ) {
		pickDateEl.addEventListener( 'change', updateSummary );
	}

	var dropDateEl = $id( 'm-dropdate' );
	if ( dropDateEl ) {
		dropDateEl.addEventListener( 'change', updateSummary );
	}

	// Step navigation.
	var toStep2Btn = $id( 'toStep2' );
	if ( toStep2Btn ) {
		toStep2Btn.addEventListener( 'click', function () {
			if ( validateStep1() ) {
				goToStep( 2 );
			}
		} );
	}

	var toStep3Btn = $id( 'toStep3' );
	if ( toStep3Btn ) {
		toStep3Btn.addEventListener( 'click', function () {
			if ( validateStep2() ) {
				goToStep( 3 );
			}
		} );
	}

	var backTo1Btn = $id( 'backTo1' );
	if ( backTo1Btn ) {
		backTo1Btn.addEventListener( 'click', function () {
			goToStep( 1 );
		} );
	}

	var backTo2Btn = $id( 'backTo2' );
	if ( backTo2Btn ) {
		backTo2Btn.addEventListener( 'click', function () {
			goToStep( 2 );
		} );
	}

	// Confirm / submit.
	var confirmBtn = $id( 'confirmBtn' );
	if ( confirmBtn ) {
		confirmBtn.addEventListener( 'click', submitBooking );
	}

	// Close modal — X button, success close, overlay click, Escape key.
	var modalCloseBtn = $id( 'modalClose' );
	if ( modalCloseBtn ) {
		modalCloseBtn.addEventListener( 'click', closeModal );
	}

	var successCloseBtn = $id( 'successClose' );
	if ( successCloseBtn ) {
		successCloseBtn.addEventListener( 'click', closeModal );
	}

	overlay.addEventListener( 'click', function ( e ) {
		if ( e.target === overlay ) {
			closeModal();
		}
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' ) {
			closeModal();
		}
	} );

	// Delegate clicks on .open-booking buttons (Book Now / Reserve).
	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.open-booking' );
		if ( ! btn ) {
			return;
		}
		e.preventDefault();
		var card = btn.closest( '.car-card' );
		openModal( card || null );
	} );

	// Expose openModal globally for use from other scripts (e.g. search widget).
	window.DriveEaseBooking = {
		open:  openModal,
		close: closeModal
	};

} )();
