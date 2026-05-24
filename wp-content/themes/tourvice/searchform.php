<?php
/**
 * Search form template.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="tourvice-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="tourvice-search-input"><?php esc_html_e( 'Search for:', 'tourvice' ); ?></label>
	<input type="search"
		id="tourvice-search-input"
		class="tourvice-search-form__input"
		placeholder="<?php esc_attr_e( 'Search tours, destinations...', 'tourvice' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s" />
	<button type="submit" class="tourvice-search-form__submit">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
		</svg>
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'tourvice' ); ?></span>
	</button>
</form>
