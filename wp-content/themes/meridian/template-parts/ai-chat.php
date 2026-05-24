<?php
/**
 * AI Chat Widget Template.
 *
 * Expandable/collapsible chat overlay that communicates with the Meridian AI REST endpoint.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="meridian-chat" id="meridian-chat" aria-label="<?php esc_attr_e( 'AI Concierge', 'meridian' ); ?>">

    <!-- Toggle Button (fixed bottom-right) -->
    <button class="meridian-chat__toggle" id="meridian-chat-toggle" aria-label="<?php esc_attr_e( 'Open chat', 'meridian' ); ?>">
        <svg class="meridian-chat__toggle-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
        </svg>
    </button>

    <!-- Chat Window -->
    <div class="meridian-chat__window" id="meridian-chat-window" aria-hidden="true">

        <!-- Header -->
        <div class="meridian-chat__header">
            <span class="meridian-chat__title"><?php esc_html_e( 'Meridian Concierge', 'meridian' ); ?></span>
            <button class="meridian-chat__close" id="meridian-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'meridian' ); ?>">&times;</button>
        </div>

        <!-- Quick Action Chips -->
        <div class="meridian-chat__chips">
            <button class="meridian-chat__chip" data-message="<?php esc_attr_e( 'What rooms are available?', 'meridian' ); ?>">
                <?php esc_html_e( 'Available rooms', 'meridian' ); ?>
            </button>
            <button class="meridian-chat__chip" data-message="<?php esc_attr_e( 'I need help with a reservation', 'meridian' ); ?>">
                <?php esc_html_e( 'Reservations', 'meridian' ); ?>
            </button>
            <button class="meridian-chat__chip" data-message="<?php esc_attr_e( 'What amenities does the hotel offer?', 'meridian' ); ?>">
                <?php esc_html_e( 'Amenities', 'meridian' ); ?>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="meridian-chat__messages" id="meridian-chat-messages" role="log" aria-live="polite">
            <div class="meridian-chat__message meridian-chat__message--ai">
                <div class="meridian-chat__bubble meridian-chat__bubble--ai">
                    <?php esc_html_e( 'Welcome to The Meridian. I\'m your virtual concierge. How may I assist you today?', 'meridian' ); ?>
                </div>
            </div>
        </div>

        <!-- Typing Indicator (hidden by default) -->
        <div class="meridian-chat__typing" id="meridian-chat-typing" hidden>
            <span></span><span></span><span></span>
        </div>

        <!-- Input Form -->
        <form class="meridian-chat__input-form" id="meridian-chat-form">
            <input
                type="text"
                class="meridian-chat__input"
                id="meridian-chat-input"
                placeholder="<?php esc_attr_e( 'Ask the concierge...', 'meridian' ); ?>"
                autocomplete="off"
            />
            <button type="submit" class="meridian-chat__send" aria-label="<?php esc_attr_e( 'Send', 'meridian' ); ?>">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                </svg>
            </button>
        </form>

    </div>
</div>
