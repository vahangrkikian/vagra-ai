<?php
/**
 * Page Template
 *
 * @package House_Service
 */

get_header();

// If Elementor is active and has content for this page, render Elementor output only.
if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() )->is_built_with_elementor() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	get_footer();
	return;
}
?>

<section class="page-hero">
	<div class="shell">
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
	</div>
</section>

<section class="content-area">
	<div class="shell">
		<?php
		while ( have_posts() ) :
			the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
