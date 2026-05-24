<?php
/**
 * Template part for displaying a "no content" message.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="tourvice-no-results">
	<h2 class="tourvice-no-results__title">
		<?php if ( is_search() ) : ?>
			<?php esc_html_e( 'No results found', 'tourvice' ); ?>
		<?php else : ?>
			<?php esc_html_e( 'Nothing here yet', 'tourvice' ); ?>
		<?php endif; ?>
	</h2>
	<div class="tourvice-no-results__content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'tourvice' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'tourvice' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
