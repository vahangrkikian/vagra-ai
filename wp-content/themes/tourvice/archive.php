<?php
/**
 * Archive template for categories, tags, dates, and authors.
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

	<!-- Archive Hero -->
	<section class="tourvice-archive-hero">
		<div class="container">
			<span class="tourvice-archive-hero__label"><?php esc_html_e( 'Archive', 'tourvice' ); ?></span>
			<?php the_archive_title( '<h1 class="tourvice-archive-hero__title">', '</h1>' ); ?>
			<?php the_archive_description( '<p class="tourvice-archive-hero__desc">', '</p>' ); ?>
		</div>
	</section>

	<!-- Archive Grid -->
	<section class="tourvice-archive-section">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="tourvice-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div>
				<?php
				the_posts_pagination(
					array(
						'prev_text' => '&laquo; ' . esc_html__( 'Previous', 'tourvice' ),
						'next_text' => esc_html__( 'Next', 'tourvice' ) . ' &raquo;',
					)
				);
				?>
			<?php else : ?>
				<div class="tourvice-empty">
					<h2><?php esc_html_e( 'No Posts Found', 'tourvice' ); ?></h2>
					<p><?php esc_html_e( 'There are no posts in this archive yet.', 'tourvice' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tourvice-btn tourvice-btn--primary">
						<?php esc_html_e( 'Back to Home', 'tourvice' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>
<?php
get_footer();
