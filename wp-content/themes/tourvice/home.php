<?php
/**
 * Blog listing page template.
 *
 * WordPress uses home.php for the posts page.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" class="tourvice-blog" role="main">

	<!-- ════════ BLOG HERO ════════ -->
	<section class="tourvice-blog-hero">
		<div class="tourvice-blog-hero__pattern" aria-hidden="true"></div>
		<div class="tourvice-blog-hero__content container">
			<p class="tourvice-blog-hero__eyebrow"><?php esc_html_e( 'Stories & Insights', 'tourvice' ); ?></p>
			<h1 class="tourvice-blog-hero__title"><?php esc_html_e( 'Travel Journal', 'tourvice' ); ?></h1>
			<p class="tourvice-blog-hero__subtitle"><?php esc_html_e( 'Discover hidden gems, travel tips, and stories from the heart of Armenia', 'tourvice' ); ?></p>
		</div>
	</section>

	<?php if ( have_posts() ) : ?>

		<?php
		/* ── Featured / Latest Post (first post, full-width) ──────── */
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		if ( 1 === $paged ) :
			the_post();
			$feat_cats = get_the_category();
			?>
			<section class="tourvice-blog-featured container" aria-label="<?php esc_attr_e( 'Featured article', 'tourvice' ); ?>">
				<a href="<?php the_permalink(); ?>" class="tourvice-blog-featured__card">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="tourvice-blog-featured__image">
							<?php the_post_thumbnail( 'tourvice-hero', array( 'class' => 'tourvice-blog-featured__img' ) ); ?>
							<div class="tourvice-blog-featured__overlay" aria-hidden="true"></div>
						</div>
					<?php endif; ?>
					<div class="tourvice-blog-featured__body">
						<?php if ( ! empty( $feat_cats ) ) : ?>
							<span class="tourvice-blog-featured__badge"><?php echo esc_html( $feat_cats[0]->name ); ?></span>
						<?php endif; ?>
						<h2 class="tourvice-blog-featured__title"><?php the_title(); ?></h2>
						<p class="tourvice-blog-featured__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<div class="tourvice-blog-featured__meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php if ( function_exists( 'tourvice_reading_time' ) ) : ?>
								<span class="tourvice-blog-featured__dot" aria-hidden="true">&middot;</span>
								<span><?php echo esc_html( tourvice_reading_time( get_the_ID() ) ); ?></span>
							<?php endif; ?>
						</div>
						<span class="tourvice-blog-featured__cta tourvice-btn tourvice-btn--outline">
							<?php esc_html_e( 'Read Article', 'tourvice' ); ?>
						</span>
					</div>
				</a>
			</section>
		<?php endif; ?>

		<!-- ════════ POSTS GRID + SIDEBAR ════════ -->
		<section class="tourvice-blog-grid container">
			<div class="tourvice-blog-grid__main">
				<div class="tourvice-blog-grid__posts">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content' );
					endwhile;
					?>
				</div>

				<!-- Pagination -->
				<nav class="tourvice-blog-pagination" aria-label="<?php esc_attr_e( 'Blog pagination', 'tourvice' ); ?>">
					<?php
					$pagination = paginate_links(
						array(
							'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg><span>' . esc_html__( 'Prev', 'tourvice' ) . '</span>',
							'next_text' => '<span>' . esc_html__( 'Next', 'tourvice' ) . '</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>',
							'type'      => 'list',
							'mid_size'  => 2,
						)
					);

					if ( $pagination ) {
						echo wp_kses_post( $pagination );
					}
					?>
				</nav>
			</div>

			<aside class="tourvice-blog-grid__sidebar">
				<?php get_sidebar(); ?>
			</aside>
		</section>

	<?php else : ?>

		<section class="tourvice-blog-empty container">
			<h2><?php esc_html_e( 'No articles found', 'tourvice' ); ?></h2>
			<p><?php esc_html_e( 'Check back soon for travel stories, tips, and Armenian insights.', 'tourvice' ); ?></p>
		</section>

	<?php endif; ?>

</main>

<?php get_footer(); ?>
