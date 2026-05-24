<?php
/**
 * TourVice AI Chat Widget template.
 *
 * Rendered in footer.php. Provides a floating chat toggle and panel.
 *
 * @package TourVice
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TourVice_Chat' ) || ! TourVice_Chat::is_enabled() ) {
	return;
}

$chat_title = TourVice_Chat::get_title();
?>

<div class="tourvice-chat" id="tourvice-chat"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>"
	data-rest-url="<?php echo esc_url( rest_url( 'tourvice/v1/chat' ) ); ?>"
	aria-label="<?php esc_attr_e( 'Chat with TourVice Assistant', 'tourvice' ); ?>">

	<!-- Toggle Button -->
	<button class="tourvice-chat__toggle" id="tourvice-chat-toggle" type="button"
		aria-expanded="false"
		aria-controls="tourvice-chat-panel"
		aria-label="<?php esc_attr_e( 'Open chat', 'tourvice' ); ?>">
		<svg class="tourvice-chat__icon-chat" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
		</svg>
		<svg class="tourvice-chat__icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
		</svg>
	</button>

	<!-- Chat Panel -->
	<div class="tourvice-chat__panel" id="tourvice-chat-panel" aria-hidden="true">

		<!-- Header -->
		<div class="tourvice-chat__header">
			<div class="tourvice-chat__header-info">
				<div class="tourvice-chat__avatar">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
				</div>
				<div>
					<span class="tourvice-chat__title"><?php echo esc_html( $chat_title ); ?></span>
					<span class="tourvice-chat__status"><?php esc_html_e( 'Online', 'tourvice' ); ?></span>
				</div>
			</div>
			<button class="tourvice-chat__close" type="button" aria-label="<?php esc_attr_e( 'Close chat', 'tourvice' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
		</div>

		<!-- Quick Action Chips -->
		<div class="tourvice-chat__chips">
			<button type="button" class="tourvice-chat__chip" data-message="<?php esc_attr_e( 'What are the best tours in Armenia?', 'tourvice' ); ?>">
				<?php esc_html_e( 'Best tours in Armenia?', 'tourvice' ); ?>
			</button>
			<button type="button" class="tourvice-chat__chip" data-message="<?php esc_attr_e( 'How do group discounts work?', 'tourvice' ); ?>">
				<?php esc_html_e( 'Group discount info', 'tourvice' ); ?>
			</button>
			<button type="button" class="tourvice-chat__chip" data-message="<?php esc_attr_e( 'Can you help me plan a trip to Armenia?', 'tourvice' ); ?>">
				<?php esc_html_e( 'Help me plan a trip', 'tourvice' ); ?>
			</button>
		</div>

		<!-- Messages -->
		<div class="tourvice-chat__messages" id="tourvice-chat-messages" role="log" aria-live="polite">
			<div class="tourvice-chat__message tourvice-chat__message--assistant">
				<div class="tourvice-chat__bubble">
					<?php esc_html_e( 'Hi! I\'m the TourVice travel assistant. How can I help you plan your Armenian adventure?', 'tourvice' ); ?>
				</div>
			</div>
		</div>

		<!-- Typing Indicator -->
		<div class="tourvice-chat__typing" id="tourvice-chat-typing" aria-hidden="true">
			<div class="tourvice-chat__bubble">
				<span class="tourvice-chat__dot"></span>
				<span class="tourvice-chat__dot"></span>
				<span class="tourvice-chat__dot"></span>
			</div>
		</div>

		<!-- Input -->
		<form class="tourvice-chat__input" id="tourvice-chat-form">
			<input type="text" id="tourvice-chat-input"
				placeholder="<?php esc_attr_e( 'Type your message...', 'tourvice' ); ?>"
				autocomplete="off"
				aria-label="<?php esc_attr_e( 'Chat message', 'tourvice' ); ?>">
			<button type="submit" class="tourvice-chat__send" aria-label="<?php esc_attr_e( 'Send message', 'tourvice' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
				</svg>
			</button>
		</form>
	</div>
</div>
