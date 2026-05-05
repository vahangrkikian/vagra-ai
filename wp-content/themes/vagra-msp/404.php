<?php
/**
 * The template for displaying 404 pages.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main site-container">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'vagra-msp' ); ?></h1>
        </header>

        <div class="page-content">
            <p><?php esc_html_e( 'The page you are looking for could not be found. It may have been moved or deleted.', 'vagra-msp' ); ?></p>

            <?php get_search_form(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
