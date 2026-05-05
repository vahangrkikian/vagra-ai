<?php
/**
 * Template Part: AI Chat Widget
 *
 * Renders the chat toggle button and chat window.
 *
 * @package Vagra_Legal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Vagra_Legal_Chat' ) ) {
    return;
}

$vagra_chat = new Vagra_Legal_Chat();

if ( ! $vagra_chat->is_enabled() ) {
    return;
}

$vagra_chat_title      = $vagra_chat->get_chat_title();
$vagra_chat_disclaimer = $vagra_chat->get_disclaimer();
?>

<div class="vagra-chat" id="vagra-chat"
     data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>"
     data-rest-url="<?php echo esc_url( rest_url( 'vagra/v1/chat' ) ); ?>"
     data-disclaimer="<?php echo esc_attr( $vagra_chat_disclaimer ); ?>">

    <button class="vagra-chat__toggle" aria-label="<?php esc_attr_e( 'Open chat', 'vagra-legal' ); ?>" aria-expanded="false">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M21 11.5C21 16.75 16.75 21 11.5 21C10.15 21 8.87 20.72 7.72 20.22L3 21L3.78 16.28C3.28 15.13 3 13.85 3 12.5C3 7.25 7.25 3 12.5 3C17.75 3 21 7.25 21 11.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <path d="M8 11H8.01M12 11H12.01M16 11H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>

    <div class="vagra-chat__window" aria-hidden="true">
        <div class="vagra-chat__header">
            <span class="vagra-chat__title"><?php echo esc_html( $vagra_chat_title ); ?></span>
            <button class="vagra-chat__close" aria-label="<?php esc_attr_e( 'Close chat', 'vagra-legal' ); ?>">&times;</button>
        </div>
        <div class="vagra-chat__messages" role="log" aria-live="polite">
        </div>
        <form class="vagra-chat__input-form">
            <input type="text" class="vagra-chat__input" placeholder="<?php esc_attr_e( 'Type your question...', 'vagra-legal' ); ?>" />
            <button type="submit" class="vagra-chat__send" aria-label="<?php esc_attr_e( 'Send', 'vagra-legal' ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>
</div>
