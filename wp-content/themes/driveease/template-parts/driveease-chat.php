<?php
/**
 * DriveEase AI Chat Widget template.
 *
 * Rendered in footer.php. Provides a floating chat toggle and panel.
 *
 * @package DriveEase
 * @since   1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DriveEase_Chat' ) || ! DriveEase_Chat::is_enabled() ) {
	return;
}

$chat_title = DriveEase_Chat::get_title();
?>

<div class="driveease-chat" id="driveease-chat"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>"
	data-rest-url="<?php echo esc_url( rest_url( 'driveease/v1/chat' ) ); ?>"
	aria-label="<?php esc_attr_e( 'Chat with DriveEase Assistant', 'driveease' ); ?>">

	<!-- Toggle Button -->
	<button class="driveease-chat__toggle" id="chat-toggle" type="button"
		aria-expanded="false"
		aria-controls="chat-panel"
		aria-label="<?php esc_attr_e( 'Open chat', 'driveease' ); ?>">
		<svg class="icon-chat" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
		</svg>
		<svg class="icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
		</svg>
	</button>

	<!-- Chat Panel -->
	<div class="driveease-chat__panel" id="chat-panel" aria-hidden="true">

		<!-- Header -->
		<div class="driveease-chat__header">
			<div class="driveease-chat__header-info">
				<div class="driveease-chat__avatar">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
				</div>
				<div>
					<span class="driveease-chat__title"><?php echo esc_html( $chat_title ); ?></span>
					<span class="driveease-chat__status"><?php esc_html_e( 'Online', 'driveease' ); ?></span>
				</div>
			</div>
			<button class="driveease-chat__close" type="button" aria-label="<?php esc_attr_e( 'Close chat', 'driveease' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
		</div>

		<!-- Quick Action Chips -->
		<div class="driveease-chat__chips">
			<button type="button" class="driveease-chat__chip" data-message="<?php esc_attr_e( 'How do I book a car?', 'driveease' ); ?>">
				<?php esc_html_e( 'How to book', 'driveease' ); ?>
			</button>
			<button type="button" class="driveease-chat__chip" data-message="<?php esc_attr_e( 'What documents do I need?', 'driveease' ); ?>">
				<?php esc_html_e( 'Documents needed', 'driveease' ); ?>
			</button>
			<button type="button" class="driveease-chat__chip" data-message="<?php esc_attr_e( 'What is your cancellation policy?', 'driveease' ); ?>">
				<?php esc_html_e( 'Cancellation policy', 'driveease' ); ?>
			</button>
		</div>

		<!-- Messages -->
		<div class="driveease-chat__messages" id="chat-messages" role="log" aria-live="polite">
			<div class="driveease-chat__message driveease-chat__message--assistant">
				<div class="driveease-chat__bubble">
					<?php esc_html_e( 'Hi! I\'m the DriveEase assistant. How can I help you today?', 'driveease' ); ?>
				</div>
			</div>
		</div>

		<!-- Typing Indicator -->
		<div class="driveease-chat__typing" id="chat-typing" aria-hidden="true">
			<div class="driveease-chat__bubble">
				<span class="driveease-chat__dot"></span>
				<span class="driveease-chat__dot"></span>
				<span class="driveease-chat__dot"></span>
			</div>
		</div>

		<!-- Input -->
		<form class="driveease-chat__input" id="chat-form">
			<input type="text" id="chat-input"
				placeholder="<?php esc_attr_e( 'Type your message...', 'driveease' ); ?>"
				autocomplete="off"
				aria-label="<?php esc_attr_e( 'Chat message', 'driveease' ); ?>">
			<button type="submit" class="driveease-chat__send" aria-label="<?php esc_attr_e( 'Send message', 'driveease' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
				</svg>
			</button>
		</form>
	</div>
</div>
