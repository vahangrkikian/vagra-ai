<?php
/**
 * Search Results Template
 *
 * @package House_Service
 */

get_header();
?>

<section class="page-hero">
	<div class="shell">
		<h1 class="page-hero__title">
			<?php
			printf(
				/* translators: %s = search query */
				esc_html__( 'Results for "%s"', 'house-service' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
		<p class="page-hero__desc">
			<?php
			printf(
				/* translators: %d = number of results */
				esc_html( _n( '%d result found', '%d results found', (int) $wp_query->found_posts, 'house-service' ) ),
				(int) $wp_query->found_posts
			);
			?>
		</p>
	</div>
</section>

<section class="content-area">
	<div class="shell">
		<?php if ( have_posts() ) : ?>
			<div class="co-grid">
				<?php
				while ( have_posts() ) :
					the_post();

					if ( 'hs_provider' === get_post_type() ) :
						get_template_part( 'template-parts/provider-card' );
					else :
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'co-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="co-card__image">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'hs-card' ); ?>
						</a>
					</div>
					<?php endif; ?>
					<div class="co-card__body">
						<h3 class="co-card__name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="co-card__tagline"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
					</div>
					<div class="co-card__foot">
						<span class="co-card__location">
							<?php echo hs_icon( 'calendar', 14 ); ?>
							<?php echo esc_html( get_the_date() ); ?>
						</span>
						<a href="<?php the_permalink(); ?>" class="co-card__link">
							<?php esc_html_e( 'Read more', 'house-service' ); ?>
							<?php echo hs_icon( 'arrow', 16 ); ?>
						</a>
					</div>
				</article>
				<?php
					endif;
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => hs_icon( 'chevron', 18 ),
				'next_text' => hs_icon( 'chevron', 18 ),
			) );
			?>
		<?php else : ?>
			<div class="empty-state">
				<div class="empty-state__icon"><?php echo hs_icon( 'search', 28 ); ?></div>
				<h3><?php esc_html_e( 'No results found', 'house-service' ); ?></h3>
				<p><?php esc_html_e( 'Try different keywords or browse our provider categories.', 'house-service' ); ?></p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn btn-secondary">
					<?php esc_html_e( 'Browse providers', 'house-service' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
