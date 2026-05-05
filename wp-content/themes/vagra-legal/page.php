<?php
/**
 * Page Template
 *
 * @package Vagra_Legal
 */

get_header();
?>

<div class="vagra-content-area">
    <div class="vagra-container">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', 'page' ); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php
get_footer();
