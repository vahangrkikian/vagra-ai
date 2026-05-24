<?php
/**
 * Search results template.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main" role="main">

	<!-- Search Hero -->
	<section class="search-hero">
		<div class="container">
			<h1>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Results for: %s', 'driveease' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
			<p>
				<?php
				printf(
					/* translators: %d: number of results */
					esc_html( _n( '%d result found', '%d results found', (int) $wp_query->found_posts, 'driveease' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
		</div>
	</section>

	<!-- Search Results -->
	<section class="search-results-section">
		<div class="container">
			<!-- Search Again -->
			<div class="search-again-box">
				<?php get_search_form(); ?>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="search-results-list">
					<?php
					while ( have_posts() ) :
						the_post();
						$post_type = get_post_type();
						$type_label = '';
						if ( 'driveease_car' === $post_type ) {
							$type_label = __( 'Vehicle', 'driveease' );
						} elseif ( 'driveease_branch' === $post_type ) {
							$type_label = __( 'Branch', 'driveease' );
						} elseif ( 'page' === $post_type ) {
							$type_label = __( 'Page', 'driveease' );
						} else {
							$type_label = __( 'Post', 'driveease' );
						}
						?>
						<article class="search-result-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="search-result-image">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							<?php endif; ?>
							<div class="search-result-body">
								<span class="search-result-type"><?php echo esc_html( $type_label ); ?></span>
								<?php the_title( '<h2 class="search-result-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
								<div class="search-result-excerpt">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="search-result-link">
									<?php esc_html_e( 'Read more', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
								</a>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>
				<?php the_posts_pagination( array(
					'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'driveease' ),
					'next_text' => esc_html__( 'Next', 'driveease' ) . ' <i class="fa-solid fa-chevron-right"></i>',
				) ); ?>
			<?php else : ?>
				<div class="no-results-box">
					<div class="no-results-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
					<h2><?php esc_html_e( 'No Results Found', 'driveease' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, nothing matched your search. Try different keywords or browse our fleet directly.', 'driveease' ); ?></p>
					<div class="no-results-actions">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'driveease_car' ) ); ?>" class="btn btn-primary">
							<i class="fa-solid fa-car"></i> <?php esc_html_e( 'Browse Fleet', 'driveease' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline">
							<?php esc_html_e( 'Back to Home', 'driveease' ); ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>
<?php
get_footer();
