<?php
/**
 * Template part: no results found.
 *
 * @package Meridian
 */

?>
<section class="no-results">
    <header class="no-results__header">
        <h1 class="no-results__title"><?php esc_html_e( 'Nothing found', 'meridian' ); ?></h1>
    </header>

    <div class="no-results__content">
        <?php if ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, no results matched your search terms. Please try again with different keywords.', 'meridian' ); ?></p>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Try using the search below.', 'meridian' ); ?></p>
        <?php endif; ?>

        <?php get_search_form(); ?>
    </div>
</section>
