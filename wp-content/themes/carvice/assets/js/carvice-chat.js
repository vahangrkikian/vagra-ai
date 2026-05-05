/**
 * Carvice AI Chat Widget
 *
 * @package Carvice
 */
(function () {
    'use strict';

    var root      = document.getElementById('carvice-chat');
    var toggle    = document.getElementById('carvice-chat-toggle');
    var win       = document.getElementById('carvice-chat-window');
    var closeBtn  = document.getElementById('carvice-chat-close');
    var form      = document.getElementById('carvice-chat-form');
    var input     = document.getElementById('carvice-chat-input');
    var msgArea   = document.getElementById('carvice-chat-messages');
    var typing    = document.getElementById('carvice-chat-typing');

    if (!root || !toggle || !win) return;

    var config    = window.carviceChat || {};
    var restUrl   = config.restUrl || '/wp-json/carvice/v1/chat';
    var nonce     = config.nonce || '';
    var history   = [];
    var sending   = false;
    var MAX_HISTORY = 50;

    /* --- Open / Close --------------------------------------------------- */

    function openChat() {
        root.classList.add('carvice-chat--open');
        win.setAttribute('aria-hidden', 'false');
        input.focus();
    }

    function closeChat() {
        root.classList.remove('carvice-chat--open');
        win.setAttribute('aria-hidden', 'true');
    }

    function isOpen() {
        return root.classList.contains('carvice-chat--open');
    }

    toggle.addEventListener('click', openChat);
    closeBtn.addEventListener('click', closeChat);

    /* --- Cmd+K shortcut ------------------------------------------------- */

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

    /* --- AI Bar integration --------------------------------------------- */
    // Clicking the AI bar input or chips on the front page opens the chat.
    var aiBarInput = document.querySelector('.carvice-ai-bar__input');
    if (aiBarInput) {
        aiBarInput.addEventListener('click', function () {
            openChat();
        });
    }

    var aiBarChips = document.querySelectorAll('.carvice-ai-bar__chip');
    for (var i = 0; i < aiBarChips.length; i++) {
        (function (chip) {
            chip.style.cursor = 'pointer';
            chip.addEventListener('click', function () {
                openChat();
                var text = chip.textContent.trim();
                sendMessage(text);
            });
        })(aiBarChips[i]);
    }

    var aiBarShortcut = document.querySelector('.carvice-ai-bar__shortcut');
    if (aiBarShortcut) {
        aiBarShortcut.style.cursor = 'pointer';
        aiBarShortcut.addEventListener('click', openChat);
    }

    /* --- Quick action chips --------------------------------------------- */

    var chips = document.querySelectorAll('.carvice-chat__chip');
    for (var c = 0; c < chips.length; c++) {
        (function (chip) {
            chip.addEventListener('click', function () {
                var msg = chip.getAttribute('data-message');
                if (msg) sendMessage(msg);
            });
        })(chips[c]);
    }

    /* --- Send message --------------------------------------------------- */

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var text = input.value.trim();
        if (!text) return;
        input.value = '';
        sendMessage(text);
    });

    function sendMessage(text) {
        if (sending) return;

        appendBubble(text, 'user');
        history.push({ role: 'user', content: text });
        trimHistory();

        sending = true;
        typing.hidden = false;
        scrollToBottom();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', restUrl, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        if (nonce) {
            xhr.setRequestHeader('X-WP-Nonce', nonce);
        }

        xhr.onload = function () {
            typing.hidden = true;
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
            typing.hidden = true;
            sending = false;
            appendBubble('Network error. Please check your connection.', 'ai');
        };

        xhr.send(JSON.stringify({
            message: text,
            history: history.slice(0, -1) // exclude the message we just added
        }));
    }

    /* --- DOM helpers ----------------------------------------------------- */

    function appendBubble(text, sender) {
        var msg = document.createElement('div');
        msg.className = 'carvice-chat__message carvice-chat__message--' + sender;

        var bubble = document.createElement('div');
        bubble.className = 'carvice-chat__bubble carvice-chat__bubble--' + sender;
        bubble.textContent = text;

        msg.appendChild(bubble);
        msgArea.appendChild(msg);
        scrollToBottom();
    }

    function scrollToBottom() {
        requestAnimationFrame(function () {
            msgArea.scrollTop = msgArea.scrollHeight;
        });
    }

    function trimHistory() {
        if (history.length > MAX_HISTORY) {
            history = history.slice(-MAX_HISTORY);
        }
    }

})();
