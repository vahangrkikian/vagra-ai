/**
 * House Service — AI Chat Widget
 *
 * @package House_Service
 */

(function () {
    'use strict';

    var toggle = document.getElementById('hs-chat-toggle');
    var chatWindow = document.getElementById('hs-chat-window');
    var closeBtn = document.getElementById('hs-chat-close');
    var form = document.getElementById('hs-chat-form');
    var input = document.getElementById('hs-chat-input');
    var messages = document.getElementById('hs-chat-messages');
    var chips = document.querySelectorAll('.hs-chat-chip');

    if (!toggle || !chatWindow) return;

    /* -----------------------------------------------------------------------
       Toggle Chat
       ----------------------------------------------------------------------- */
    function openChat() {
        chatWindow.classList.add('is-open');
        chatWindow.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
        if (input) input.focus();
    }

    function closeChat() {
        chatWindow.classList.remove('is-open');
        chatWindow.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function () {
        if (chatWindow.classList.contains('is-open')) {
            closeChat();
        } else {
            openChat();
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', closeChat);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && chatWindow.classList.contains('is-open')) {
            closeChat();
        }
    });

    /* -----------------------------------------------------------------------
       Append Message
       ----------------------------------------------------------------------- */
    function addMessage(text, type) {
        if (!messages) return;
        var msg = document.createElement('div');
        msg.className = 'hs-chat-msg hs-chat-msg--' + type;
        msg.textContent = text;
        messages.appendChild(msg);
        messages.scrollTop = messages.scrollHeight;
    }

    /* -----------------------------------------------------------------------
       Quick Action Chips
       ----------------------------------------------------------------------- */
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            var text = chip.getAttribute('data-msg') || chip.textContent;
            addMessage(text, 'user');
            respondToMessage(text);
        });
    });

    /* -----------------------------------------------------------------------
       Form Submission
       ----------------------------------------------------------------------- */
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!input) return;
            var text = input.value.trim();
            if (!text) return;
            addMessage(text, 'user');
            input.value = '';
            respondToMessage(text);
        });
    }

    /* -----------------------------------------------------------------------
       Bot Responses (demo)
       ----------------------------------------------------------------------- */
    var responses = {
        clean: 'We have 64+ verified cleaning companies available. I can help you compare quotes! What type of cleaning do you need - deep clean, regular maintenance, or move-out?',
        move: 'Moving is stressful, but we make it easier! We have 38 vetted moving companies. Are you planning a local move or long-distance?',
        repair: 'We have 92 repair pros ready to help. What needs fixing - plumbing, electrical, appliances, or general handyman work?',
        assembl: 'Our assembly pros handle everything from IKEA furniture to TV mounting. What do you need assembled?',
        default: 'I can help you find the right service provider! Try asking about cleaning, moving, repairs, or assembly. Or browse our providers to see everyone available.',
    };

    function respondToMessage(text) {
        var lower = text.toLowerCase();
        var reply = responses.default;

        if (lower.indexOf('clean') !== -1) {
            reply = responses.clean;
        } else if (lower.indexOf('mov') !== -1) {
            reply = responses.move;
        } else if (lower.indexOf('repair') !== -1 || lower.indexOf('fix') !== -1 || lower.indexOf('plumb') !== -1 || lower.indexOf('electric') !== -1) {
            reply = responses.repair;
        } else if (lower.indexOf('assembl') !== -1 || lower.indexOf('mount') !== -1 || lower.indexOf('ikea') !== -1) {
            reply = responses.assembl;
        }

        // Simulate typing delay.
        setTimeout(function () {
            addMessage(reply, 'bot');
        }, 600);
    }
})();
