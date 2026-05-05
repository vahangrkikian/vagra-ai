<?php
/**
 * Template part for displaying a message when no posts are found.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'vagra-msp' ); ?></h1>
    </header>

    <div class="page-content">
        <?php if ( is_search() ) : ?>
            <p><?php esc_html_e( 'No results matched your search terms. Please try again with different keywords.', 'vagra-msp' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'vagra-msp' ); ?></p>
        <?php endif; ?>
    </div>
</section>
