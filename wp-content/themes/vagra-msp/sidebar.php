<?php
/**
 * The sidebar template.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'vagra-msp' ); ?>">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
