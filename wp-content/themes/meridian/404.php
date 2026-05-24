<?php
/**
 * 404 — Page Not Found.
 *
 * @package Meridian
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="section section--404">
        <div class="container" style="text-align: center; padding: 80px 20px;">
            <h1 class="section__title"><?php esc_html_e( 'Page not found', 'meridian' ); ?></h1>
            <p class="section__text">
                <?php esc_html_e( 'The page you are looking for might have been moved or no longer exists. Try searching below.', 'meridian' ); ?>
            </p>
            <?php get_search_form(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
