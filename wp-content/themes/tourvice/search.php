<?php
/**
 * Search results template.
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

	<!-- Search Hero -->
	<section class="tourvice-search-hero">
		<div class="container">
			<h1>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Results for: %s', 'tourvice' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
			<p>
				<?php
				printf(
					/* translators: %d: number of results */
					esc_html( _n( '%d result found', '%d results found', (int) $wp_query->found_posts, 'tourvice' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
		</div>
	</section>

	<!-- Search Results -->
	<section class="tourvice-search-results">
		<div class="container">
			<div class="tourvice-search-results__form">
				<?php get_search_form(); ?>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="tourvice-search-results__list">
					<?php
					while ( have_posts() ) :
						the_post();
						$post_type  = get_post_type();
						$type_label = '';
						if ( 'tourvice_tour' === $post_type ) {
							$type_label = __( 'Tour', 'tourvice' );
						} elseif ( 'page' === $post_type ) {
							$type_label = __( 'Page', 'tourvice' );
						} else {
							$type_label = __( 'Post', 'tourvice' );
						}
						?>
						<article class="tourvice-search-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="tourvice-search-card__image">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							<?php endif; ?>
							<div class="tourvice-search-card__body">
								<span class="tourvice-search-card__type"><?php echo esc_html( $type_label ); ?></span>
								<?php the_title( '<h2 class="tourvice-search-card__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
								<div class="tourvice-search-card__excerpt">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="tourvice-search-card__link">
									<?php esc_html_e( 'Read more', 'tourvice' ); ?> &rarr;
								</a>
							</div>
						</article>
						<?php
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
					<h2><?php esc_html_e( 'No Results Found', 'tourvice' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, nothing matched your search. Try different keywords or browse our tours directly.', 'tourvice' ); ?></p>
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
