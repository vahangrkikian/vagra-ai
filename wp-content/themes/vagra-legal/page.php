<?php
/**
 * Page Template
 *
 * @package Vagra_Legal
 */

// Elementor: if built with Elementor, let it render.
if ( defined( 'ELEMENTOR_VERSION' )
     && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    get_header();
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    get_footer();
    return;
}

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
