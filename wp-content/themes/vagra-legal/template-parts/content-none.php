<?php
/**
 * Template Part: No Content
 *
 * @package Vagra_Legal
 */
?>

<section class="vagra-no-results">
    <header class="vagra-page-header">
        <h1 class="vagra-page-header__title"><?php esc_html_e( 'Nothing Found', 'vagra-legal' ); ?></h1>
    </header>

    <div class="vagra-entry__content">
        <?php if ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, no results matched your search terms. Please try again with different keywords.', 'vagra-legal' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'vagra-legal' ); ?></p>
        <?php endif; ?>
    </div>
</section>
