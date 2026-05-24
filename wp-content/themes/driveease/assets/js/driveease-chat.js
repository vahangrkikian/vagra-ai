/**
 * DriveEase AI Chat Widget — frontend logic.
 *
 * Handles toggle, message history (sessionStorage), typing indicator,
 * AJAX communication with the REST API, and quick-action chips.
 *
 * @package DriveEase
 * @since   1.0.2
 */

( function () {
	'use strict';

	/* ── DOM References ── */
	var root     = document.getElementById( 'driveease-chat' );
	if ( ! root ) return;

	var toggle   = document.getElementById( 'chat-toggle' );
	var panel    = document.getElementById( 'chat-panel' );
	var closeBtn = root.querySelector( '.driveease-chat__close' );
	var messages = document.getElementById( 'chat-messages' );
	var typing   = document.getElementById( 'chat-typing' );
	var form     = document.getElementById( 'chat-form' );
	var input    = document.getElementById( 'chat-input' );
	var chips    = root.querySelectorAll( '.driveease-chat__chip' );

	/* ── Config from data attributes ── */
	var restUrl = root.dataset.restUrl;
	var nonce   = root.dataset.nonce;

	/* ── State ── */
	var STORAGE_KEY = 'driveease_chat_history';
	var MAX_HISTORY = 50;
	var isOpen      = false;
	var isSending   = false;

	/**
	 * Load history from sessionStorage.
	 * @return {Array<{role:string, content:string}>}
	 */
	function loadHistory() {
		try {
			var raw = sessionStorage.getItem( STORAGE_KEY );
			return raw ? JSON.parse( raw ) : [];
		} catch ( e ) {
			return [];
		}
	}

	/**
	 * Save history to sessionStorage.
	 * @param {Array} history
	 */
	function saveHistory( history ) {
		if ( history.length > MAX_HISTORY ) {
			history = history.slice( -MAX_HISTORY );
		}
		try {
			sessionStorage.setItem( STORAGE_KEY, JSON.stringify( history ) );
		} catch ( e ) { /* quota exceeded — silently ignore */ }
	}

	/* ── UI Helpers ── */

	function openChat() {
		isOpen = true;
		panel.style.display = 'flex';
		panel.setAttribute( 'aria-hidden', 'false' );
		toggle.setAttribute( 'aria-expanded', 'true' );
		root.classList.add( 'is-open' );
		input.focus();
		scrollToBottom();
	}

	function closeChat() {
		isOpen = false;
		panel.style.display = 'none';
		panel.setAttribute( 'aria-hidden', 'true' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		root.classList.remove( 'is-open' );
	}

	function toggleChat() {
		isOpen ? closeChat() : openChat();
	}

	function scrollToBottom() {
		messages.scrollTop = messages.scrollHeight;
	}

	/**
	 * Append a message bubble to the chat.
	 * @param {string} text    Message content.
	 * @param {string} role    'user' or 'assistant'.
	 */
	function appendMessage( text, role ) {
		var wrapper = document.createElement( 'div' );
		wrapper.className = 'driveease-chat__message driveease-chat__message--' + role;

		var bubble = document.createElement( 'div' );
		bubble.className = 'driveease-chat__bubble';
		bubble.textContent = text;

		wrapper.appendChild( bubble );
		messages.appendChild( wrapper );
		scrollToBottom();
	}

	function showTyping() {
		typing.style.display = 'block';
		typing.setAttribute( 'aria-hidden', 'false' );
		scrollToBottom();
	}

	function hideTyping() {
		typing.style.display = 'none';
		typing.setAttribute( 'aria-hidden', 'true' );
	}

	/* ── Send Message ── */

	/**
	 * Send a message to the REST API.
	 * @param {string} text User message text.
	 */
	function sendMessage( text ) {
		if ( isSending || ! text.trim() ) return;

		text = text.trim();
		isSending = true;

		// Show user message.
		appendMessage( text, 'user' );
		input.value = '';

		// Save to history.
		var history = loadHistory();
		history.push( { role: 'user', content: text } );
		saveHistory( history );

		showTyping();

		// Build request.
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST', restUrl, true );
		xhr.setRequestHeader( 'Content-Type', 'application/json' );
		xhr.setRequestHeader( 'X-WP-Nonce', nonce );

		xhr.onload = function () {
			hideTyping();
			isSending = false;

			var data;
			try {
				data = JSON.parse( xhr.responseText );
			} catch ( e ) {
				appendMessage( 'Sorry, something went wrong. Please try again.', 'assistant' );
				return;
			}

			if ( xhr.status === 200 && data.reply ) {
				appendMessage( data.reply, 'assistant' );
				history = loadHistory();
				history.push( { role: 'assistant', content: data.reply } );
				saveHistory( history );
			} else if ( xhr.status === 429 ) {
				appendMessage( data.message || 'Too many requests. Please wait a moment.', 'assistant' );
			} else {
				var msg = ( data.message || data.data && data.data.message ) || 'Unable to process your request. Please try again.';
				appendMessage( msg, 'assistant' );
			}
		};

		xhr.onerror = function () {
			hideTyping();
			isSending = false;
			appendMessage( 'Network error. Please check your connection and try again.', 'assistant' );
		};

		// Send history (last 20) + current message.
		var sendHistory = history.slice( -21, -1 ); // exclude the just-pushed message.
		xhr.send( JSON.stringify( {
			message: text,
			history: sendHistory,
		} ) );
	}

	/* ── Restore Session ── */

	function restoreSession() {
		var history = loadHistory();
		if ( history.length === 0 ) return;

		// Clear the default greeting and re-render from history.
		messages.innerHTML = '';

		// Re-add greeting.
		var greeting = document.createElement( 'div' );
		greeting.className = 'driveease-chat__message driveease-chat__message--assistant';
		greeting.innerHTML = '<div class="driveease-chat__bubble">Hi! I\'m the DriveEase assistant. How can I help you today?</div>';
		messages.appendChild( greeting );

		history.forEach( function ( entry ) {
			appendMessage( entry.content, entry.role );
		} );
	}

	/* ── Event Listeners ── */

	toggle.addEventListener( 'click', toggleChat );
	closeBtn.addEventListener( 'click', closeChat );

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();
		sendMessage( input.value );
	} );

	// Quick action chips.
	chips.forEach( function ( chip ) {
		chip.addEventListener( 'click', function () {
			var msg = this.dataset.message || this.textContent.trim();
			sendMessage( msg );
		} );
	} );

	// Escape key closes chat.
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && isOpen ) {
			closeChat();
		}
	} );

	/* ── Init ── */
	restoreSession();

} )();
