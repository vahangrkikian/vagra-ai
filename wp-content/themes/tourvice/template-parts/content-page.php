<?php
/**
 * Template part for displaying page content.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="tourvice-page__header">
		<?php the_title( '<h1 class="tourvice-page__title">', '</h1>' ); ?>
	</header>
	<div class="tourvice-page__content entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tourvice' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>
