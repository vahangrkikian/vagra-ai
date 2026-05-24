<?php
/**
 * Main template file.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="tourvice-main" role="main">
	<div class="container">
		<?php
		if ( have_posts() ) :
			echo '<div class="tourvice-grid">';
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			echo '</div>';
			the_posts_pagination(
				array(
					'prev_text' => '&laquo; ' . esc_html__( 'Previous', 'tourvice' ),
					'next_text' => esc_html__( 'Next', 'tourvice' ) . ' &raquo;',
				)
			);
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
	</div>
</main>
<?php
get_footer();
