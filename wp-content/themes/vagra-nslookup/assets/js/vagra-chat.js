/**
 * Vagra NSLookup Chat Widget
 *
 * Vanilla JS chat UI for the DNS assistant.
 *
 * @package Vagra_NSLookup
 */

(function () {
	'use strict';

	var MAX_HISTORY = 50;
	var STORAGE_KEY = 'vagra_nsl_chat_history';

	var chat = document.getElementById('vagra-chat');
	if (!chat) {
		return;
	}

	var toggle = chat.querySelector('.vagra-chat__toggle');
	var window_ = chat.querySelector('.vagra-chat__window');
	var closeBtn = chat.querySelector('.vagra-chat__close');
	var form = chat.querySelector('.vagra-chat__input-form');
	var input = chat.querySelector('.vagra-chat__input');
	var messages = chat.querySelector('.vagra-chat__messages');
	var nonce = chat.dataset.nonce || '';
	var restUrl = chat.dataset.restUrl || '';

	var history = [];
	var isOpen = false;
	var isWaiting = false;

	/**
	 * Initialize chat history from sessionStorage.
	 */
	function init() {
		try {
			var stored = sessionStorage.getItem(STORAGE_KEY);
			if (stored) {
				history = JSON.parse(stored);
				history.forEach(function (msg) {
					appendMessage(msg.role, msg.content, false);
				});
			}
		} catch (e) {
			history = [];
		}

		// Welcome message if no history.
		if (history.length === 0) {
			appendMessage('assistant', 'Hi! I\'m the nslookup.am DNS assistant. Ask me anything about DNS records, propagation, or how to use our tools.', true);
		}
	}

	/**
	 * Save history to sessionStorage.
	 */
	function saveHistory() {
		try {
			sessionStorage.setItem(STORAGE_KEY, JSON.stringify(history));
		} catch (e) {
			// sessionStorage full or unavailable.
		}
	}

	/**
	 * Trim history to max length.
	 */
	function trimHistory() {
		while (history.length > MAX_HISTORY) {
			history.shift();
		}
	}

	/**
	 * Append a message to the chat UI.
	 */
	function appendMessage(role, content, addToHistory) {
		var div = document.createElement('div');
		div.className = 'vagra-chat__message vagra-chat__message--' + role;
		div.textContent = content;
		messages.appendChild(div);
		messages.scrollTop = messages.scrollHeight;

		if (addToHistory !== false) {
			history.push({ role: role, content: content });
			trimHistory();
			saveHistory();
		}
	}

	/**
	 * Show typing indicator.
	 */
	function showTyping() {
		var div = document.createElement('div');
		div.className = 'vagra-chat__message vagra-chat__message--typing';
		div.id = 'vagra-chat-typing';
		div.innerHTML = '<span class="vagra-chat__dot"></span><span class="vagra-chat__dot"></span><span class="vagra-chat__dot"></span>';
		div.setAttribute('aria-label', 'Assistant is typing');
		messages.appendChild(div);
		messages.scrollTop = messages.scrollHeight;
	}

	/**
	 * Remove typing indicator.
	 */
	function removeTyping() {
		var el = document.getElementById('vagra-chat-typing');
		if (el) {
			el.parentNode.removeChild(el);
		}
	}

	/**
	 * Send message to REST API.
	 */
	function sendMessage(text) {
		if (isWaiting || !text.trim()) {
			return;
		}

		appendMessage('user', text.trim());
		input.value = '';
		isWaiting = true;
		showTyping();

		var xhr = new XMLHttpRequest();
		xhr.open('POST', restUrl, true);
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.setRequestHeader('X-WP-Nonce', nonce);

		xhr.onreadystatechange = function () {
			if (xhr.readyState !== 4) {
				return;
			}

			removeTyping();
			isWaiting = false;

			if (xhr.status >= 200 && xhr.status < 300) {
				try {
					var data = JSON.parse(xhr.responseText);
					appendMessage('assistant', data.reply || 'Sorry, I could not process that request.');
				} catch (e) {
					appendMessage('assistant', 'Sorry, something went wrong. Please try again.');
				}
			} else {
				appendMessage('assistant', 'Sorry, I\'m having trouble connecting. Please try again in a moment.');
			}

			input.focus();
		};

		xhr.send(JSON.stringify({
			message: text.trim(),
			history: history.slice(0, -1)
		}));
	}

	/**
	 * Toggle chat window.
	 */
	function openChat() {
		isOpen = true;
		window_.setAttribute('aria-hidden', 'false');
		chat.classList.add('vagra-chat--open');
		toggle.setAttribute('aria-expanded', 'true');
		input.focus();
	}

	function closeChat() {
		isOpen = false;
		window_.setAttribute('aria-hidden', 'true');
		chat.classList.remove('vagra-chat--open');
		toggle.setAttribute('aria-expanded', 'false');
	}

	// Event listeners.
	toggle.addEventListener('click', function () {
		if (isOpen) {
			closeChat();
		} else {
			openChat();
		}
	});

	closeBtn.addEventListener('click', function () {
		closeChat();
	});

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		sendMessage(input.value);
	});

	input.addEventListener('keydown', function (e) {
		if (e.key === 'Enter' && !e.shiftKey) {
			e.preventDefault();
			sendMessage(input.value);
		}
	});

	// Keyboard: Escape closes chat.
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && isOpen) {
			closeChat();
		}
	});

	// Initialize.
	init();

})();
