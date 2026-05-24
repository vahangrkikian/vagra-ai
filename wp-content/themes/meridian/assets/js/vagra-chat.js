/**
 * Meridian AI Chat Widget
 *
 * Toggle chat panel, send messages via REST API, display responses.
 *
 * @package Meridian
 */
(function () {
    'use strict';

    var root      = document.getElementById('meridian-chat');
    var toggle    = document.getElementById('meridian-chat-toggle');
    var win       = document.getElementById('meridian-chat-window');
    var closeBtn  = document.getElementById('meridian-chat-close');
    var form      = document.getElementById('meridian-chat-form');
    var input     = document.getElementById('meridian-chat-input');
    var msgArea   = document.getElementById('meridian-chat-messages');
    var typing    = document.getElementById('meridian-chat-typing');

    if (!root || !toggle || !win) return;

    var config    = window.vagraChat || {};
    var restUrl   = config.restUrl || '/wp-json/meridian/v1/chat';
    var nonce     = config.nonce || '';
    var history   = [];
    var sending   = false;
    var MAX_HISTORY = 50;

    /* --- Open / Close --------------------------------------------------- */

    function openChat() {
        root.classList.add('meridian-chat--open');
        win.setAttribute('aria-hidden', 'false');
        if (input) input.focus();
    }

    function closeChat() {
        root.classList.remove('meridian-chat--open');
        win.setAttribute('aria-hidden', 'true');
    }

    function isOpen() {
        return root.classList.contains('meridian-chat--open');
    }

    toggle.addEventListener('click', openChat);
    if (closeBtn) closeBtn.addEventListener('click', closeChat);

    /* --- Keyboard shortcuts --------------------------------------------- */

    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            if (isOpen()) {
                closeChat();
            } else {
                openChat();
            }
        }
        if (e.key === 'Escape' && isOpen()) {
            closeChat();
        }
    });

    /* --- Quick action chips --------------------------------------------- */

    var chips = document.querySelectorAll('.meridian-chat__chip');
    for (var c = 0; c < chips.length; c++) {
        (function (chip) {
            chip.addEventListener('click', function () {
                var msg = chip.getAttribute('data-message');
                if (msg) sendMessage(msg);
            });
        })(chips[c]);
    }

    /* --- Send message --------------------------------------------------- */

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var text = input.value.trim();
            if (!text) return;
            input.value = '';
            sendMessage(text);
        });
    }

    function sendMessage(text) {
        if (sending) return;

        // Ensure the chat is open when sending via chip.
        if (!isOpen()) openChat();

        appendBubble(text, 'user');
        history.push({ role: 'user', content: text });
        trimHistory();

        sending = true;
        if (typing) typing.hidden = false;
        scrollToBottom();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', restUrl, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        if (nonce) {
            xhr.setRequestHeader('X-WP-Nonce', nonce);
        }

        xhr.onload = function () {
            if (typing) typing.hidden = true;
            sending = false;

            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    var reply = data.reply || 'Sorry, I could not process that.';
                    appendBubble(reply, 'ai');
                    history.push({ role: 'assistant', content: reply });
                    trimHistory();
                } catch (e) {
                    appendBubble('Something went wrong. Please try again.', 'ai');
                }
            } else if (xhr.status === 429) {
                appendBubble('You\'re sending messages too quickly. Please wait a moment.', 'ai');
            } else {
                appendBubble('Something went wrong. Please try again.', 'ai');
            }
        };

        xhr.onerror = function () {
            if (typing) typing.hidden = true;
            sending = false;
            appendBubble('Network error. Please check your connection.', 'ai');
        };

        xhr.send(JSON.stringify({
            message: text,
            history: history.slice(0, -1)
        }));
    }

    /* --- DOM helpers ----------------------------------------------------- */

    function appendBubble(text, sender) {
        var msg = document.createElement('div');
        msg.className = 'meridian-chat__message meridian-chat__message--' + sender;

        var bubble = document.createElement('div');
        bubble.className = 'meridian-chat__bubble meridian-chat__bubble--' + sender;
        bubble.textContent = text;

        msg.appendChild(bubble);
        msgArea.appendChild(msg);
        scrollToBottom();
    }

    function scrollToBottom() {
        requestAnimationFrame(function () {
            if (msgArea) msgArea.scrollTop = msgArea.scrollHeight;
        });
    }

    function trimHistory() {
        if (history.length > MAX_HISTORY) {
            history = history.slice(-MAX_HISTORY);
        }
    }

})();
