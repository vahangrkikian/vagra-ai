/**
 * DriveEase Contact Form — AJAX submission handler.
 *
 * @package DriveEase
 * @since 1.0.2
 */

( function () {
	'use strict';

	var form    = document.getElementById( 'driveease-contact-form' );
	var success = document.getElementById( 'contactSuccess' );

	if ( ! form || ! window.driveease_contact ) {
		return;
	}

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();

		var btn = form.querySelector( 'button[type="submit"]' );
		btn.disabled  = true;
		btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + ( window.DriveEaseI18n ? DriveEaseI18n.t( 'sending' ) : 'Sending...' );

		var data = new FormData( form );
		data.append( 'action', 'driveease_contact' );
		data.append( 'nonce', window.driveease_contact.nonce );

		fetch( window.driveease_contact.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			body: data,
		} )
			.then( function ( res ) { return res.json(); } )
			.then( function ( res ) {
				if ( res.success ) {
					form.style.display    = 'none';
					success.style.display = 'flex';
				} else {
					alert( res.data && res.data.message ? res.data.message : 'Something went wrong.' );
				}
			} )
			.catch( function () {
				alert( 'Network error. Please try again.' );
			} )
			.finally( function () {
				btn.disabled  = false;
				btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> ' + ( window.DriveEaseI18n ? DriveEaseI18n.t( 'send_message' ) : 'Send Message' );
			} );
	} );
} )();
