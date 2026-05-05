<?php
/**
 * Sidebar template.
 *
 * @package Vagra_NSLookup
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside class="nsl-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'vagra-nslookup' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
