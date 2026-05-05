<?php
/**
 * AI Chat Widget Template.
 *
 * Expandable/collapsible chat overlay that communicates with the Carvice AI REST endpoint.
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="carvice-chat" id="carvice-chat" aria-label="<?php esc_attr_e( 'AI Chat Assistant', 'carvice' ); ?>">

    <!-- Toggle Button (fixed bottom-right) -->
    <button class="carvice-chat__toggle" id="carvice-chat-toggle" aria-label="<?php esc_attr_e( 'Open chat', 'carvice' ); ?>">
        <svg class="carvice-chat__toggle-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
        </svg>
    </button>

    <!-- Chat Window -->
    <div class="carvice-chat__window" id="carvice-chat-window" aria-hidden="true">

        <!-- Header -->
        <div class="carvice-chat__header">
            <span class="carvice-chat__title"><?php esc_html_e( 'Carvice AI', 'carvice' ); ?></span>
            <button class="carvice-chat__close" id="carvice-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'carvice' ); ?>">&times;</button>
        </div>

        <!-- Quick Action Chips -->
        <div class="carvice-chat__chips">
            <button class="carvice-chat__chip" data-message="<?php esc_attr_e( 'Find a service center near me', 'carvice' ); ?>">
                <?php esc_html_e( 'Find a service', 'carvice' ); ?>
            </button>
            <button class="carvice-chat__chip" data-message="<?php esc_attr_e( 'I need to call a specialist', 'carvice' ); ?>">
                <?php esc_html_e( 'Call a specialist', 'carvice' ); ?>
            </button>
            <button class="carvice-chat__chip" data-message="<?php esc_attr_e( 'How much does an oil change cost?', 'carvice' ); ?>">
                <?php esc_html_e( 'Check price', 'carvice' ); ?>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="carvice-chat__messages" id="carvice-chat-messages" role="log" aria-live="polite">
            <div class="carvice-chat__message carvice-chat__message--ai">
                <div class="carvice-chat__bubble carvice-chat__bubble--ai">
                    <?php esc_html_e( 'Hello! I\'m Carvice AI, your car service assistant. How can I help you today?', 'carvice' ); ?>
                </div>
            </div>
        </div>

        <!-- Typing Indicator (hidden by default) -->
        <div class="carvice-chat__typing" id="carvice-chat-typing" hidden>
            <span></span><span></span><span></span>
        </div>

        <!-- Input Form -->
        <form class="carvice-chat__input-form" id="carvice-chat-form">
            <input
                type="text"
                class="carvice-chat__input"
                id="carvice-chat-input"
                placeholder="<?php esc_attr_e( 'Type your question...', 'carvice' ); ?>"
                autocomplete="off"
            />
            <button type="submit" class="carvice-chat__send" aria-label="<?php esc_attr_e( 'Send', 'carvice' ); ?>">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                </svg>
            </button>
        </form>

    </div>
</div>
