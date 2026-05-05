<?php
/**
 * The template for displaying pages.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main site-container">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', 'page' );

        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    endwhile;
    ?>
</main>

<?php
get_footer();
