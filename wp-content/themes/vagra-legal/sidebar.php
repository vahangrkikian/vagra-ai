<?php
/**
 * Sidebar Template
 *
 * @package Vagra_Legal
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<div class="vagra-sidebar__inner">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
