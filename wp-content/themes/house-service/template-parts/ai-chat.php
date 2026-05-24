<?php
/**
 * Template Part: AI Chat Widget
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<!-- Chat Toggle -->
<button class="hs-chat-toggle" id="hs-chat-toggle" aria-label="<?php esc_attr_e( 'Open chat assistant', 'house-service' ); ?>" aria-expanded="false">
	<?php echo hs_icon( 'house', 26 ); ?>
</button>

<!-- Chat Window -->
<div class="hs-chat-window" id="hs-chat-window" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Chat assistant', 'house-service' ); ?>">
	<div class="hs-chat-header">
		<h4><?php esc_html_e( 'House Service Assistant', 'house-service' ); ?></h4>
		<button class="hs-chat-close" id="hs-chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'house-service' ); ?>">
			<?php echo hs_icon( 'x', 18 ); ?>
		</button>
	</div>
	<div class="hs-chat-messages" id="hs-chat-messages">
		<div class="hs-chat-msg hs-chat-msg--bot">
			<?php esc_html_e( 'Hi! I can help you find the right service provider. What do you need help with?', 'house-service' ); ?>
		</div>
	</div>
	<div class="hs-chat-chips">
		<button class="hs-chat-chip" data-msg="<?php esc_attr_e( 'I need a cleaning service', 'house-service' ); ?>"><?php esc_html_e( 'Cleaning', 'house-service' ); ?></button>
		<button class="hs-chat-chip" data-msg="<?php esc_attr_e( 'I\'m planning a move', 'house-service' ); ?>"><?php esc_html_e( 'Moving', 'house-service' ); ?></button>
		<button class="hs-chat-chip" data-msg="<?php esc_attr_e( 'I need something repaired', 'house-service' ); ?>"><?php esc_html_e( 'Repair', 'house-service' ); ?></button>
		<button class="hs-chat-chip" data-msg="<?php esc_attr_e( 'I need furniture assembled', 'house-service' ); ?>"><?php esc_html_e( 'Assembly', 'house-service' ); ?></button>
	</div>
	<form class="hs-chat-form" id="hs-chat-form">
		<input type="text" class="hs-chat-input" id="hs-chat-input" placeholder="<?php esc_attr_e( 'Type a message...', 'house-service' ); ?>" aria-label="<?php esc_attr_e( 'Chat message', 'house-service' ); ?>" autocomplete="off">
		<button type="submit" class="hs-chat-send" aria-label="<?php esc_attr_e( 'Send message', 'house-service' ); ?>">
			<?php echo hs_icon( 'arrow', 18 ); ?>
		</button>
	</form>
</div>
