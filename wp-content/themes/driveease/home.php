<?php
/**
 * Blog index template.
 *
 * Displays a styled grid of blog posts with thumbnails, excerpts,
 * dates, and categories in the DriveEase design language.
 *
 * @package DriveEase
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main" role="main">

	<!-- Blog Hero -->
	<section class="blog-hero">
		<div class="container">
			<span class="section-label"><?php esc_html_e( 'Our Blog', 'driveease' ); ?></span>
			<h1 class="section-title"><?php esc_html_e( 'News & Travel Tips', 'driveease' ); ?></h1>
			<p class="blog-hero-sub"><?php esc_html_e( 'Road trip guides, car rental tips, and the latest from DriveEase.', 'driveease' ); ?></p>
		</div>
	</section>

	<!-- Blog Grid -->
	<section class="blog-section">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="blog-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="blog-card-image">
									<?php the_post_thumbnail( 'medium_large' ); ?>
								</a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>" class="blog-card-image blog-card-image--placeholder">
									<i class="fa-solid fa-newspaper"></i>
								</a>
							<?php endif; ?>
							<div class="blog-card-body">
								<div class="blog-card-meta">
									<?php
									$categories = get_the_category();
									if ( ! empty( $categories ) ) :
										?>
										<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="blog-card-category">
											<?php echo esc_html( $categories[0]->name ); ?>
										</a>
									<?php endif; ?>
									<span class="blog-card-date">
										<i class="fa-regular fa-calendar"></i>
										<?php echo esc_html( get_the_date() ); ?>
									</span>
								</div>
								<?php the_title( '<h2 class="blog-card-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
								<div class="blog-card-excerpt">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="blog-card-link">
									<?php esc_html_e( 'Read More', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
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
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'driveease' ),
						'next_text' => esc_html__( 'Next', 'driveease' ) . ' <i class="fa-solid fa-chevron-right"></i>',
					)
				);
				?>
			<?php else : ?>
				<div class="blog-empty">
					<div class="blog-empty-icon"><i class="fa-solid fa-pen-to-square"></i></div>
					<h2><?php esc_html_e( 'No Posts Yet', 'driveease' ); ?></h2>
					<p><?php esc_html_e( 'Check back soon for travel tips, road trip guides, and the latest DriveEase news.', 'driveease' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
						<?php esc_html_e( 'Back to Home', 'driveease' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>
<?php
get_footer();
