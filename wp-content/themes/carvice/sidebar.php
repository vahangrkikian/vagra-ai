<?php
/**
 * Sidebar template.
 *
 * @package Carvice
 */

if ( ! is_active_sidebar( 'carvice-sidebar' ) ) {
    return;
}
?>

<aside id="secondary" class="carvice-sidebar">
    <?php dynamic_sidebar( 'carvice-sidebar' ); ?>
</aside>
