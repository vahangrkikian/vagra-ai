<?php
/**
 * Front Page Template
 *
 * Renders Gutenberg blocks (Meta Field Block sections) via the_content().
 * All section content is powered by ACF fields + MFB dynamic hooks.
 *
 * @package TourVice
 * @since 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="tourvice-front">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
