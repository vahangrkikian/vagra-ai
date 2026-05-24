<?php
/**
 * Archive: vagra_tour (Tours Gallery)
 *
 * Search, location filters, 4-column tour grid. Converts Gallery.jsx.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/* ── Fetch all tour_location terms for filters ────────────────── */
$locations = get_terms(
	array(
		'taxonomy'   => 'tour_location',
		'hide_empty' => true,
	)
);
if ( is_wp_error( $locations ) ) {
	$locations = array();
}

/* ── Tour count ───────────────────────────────────────────────── */
$tour_count = $wp_query->found_posts;
?>

<main id="main-content" class="tourvice-archive">

	<!-- ════════ PAGE HEADER + FILTERS ════════ -->
	<div class="tourvice-archive-hero">
		<div class="tourvice-archive__header-inner container">
			<h1 class="tourvice-archive-hero__title" data-i18n="archive_title">
				<?php esc_html_e( 'Explore Tours', 'tourvice' ); ?>
			</h1>

			<!-- Search -->
			<div class="tourvice-search-bar">
				<svg class="tourvice-search-bar__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<circle cx="11" cy="11" r="8"></circle>
					<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
				</svg>
				<input
					type="text"
					class="tourvice-search-bar__input"
					id="tourvice-tour-search"
					placeholder="<?php esc_attr_e( 'Search tours...', 'tourvice' ); ?>"
					data-i18n-placeholder="archive_search_placeholder"
				/>
			</div>

			<!-- Location Filters -->
			<?php if ( ! empty( $locations ) ) : ?>
				<div class="tourvice-filters">
					<div class="tourvice-filters__label">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
						</svg>
						<span data-i18n="archive_filter_location"><?php esc_html_e( 'Location:', 'tourvice' ); ?></span>
					</div>
					<div class="tourvice-filters__pills">
						<button
							class="tourvice-filter-pill tourvice-filter-pill--active"
							data-location="all"
							data-i18n="archive_filter_all"
						>
							<?php esc_html_e( 'All', 'tourvice' ); ?>
						</button>
						<?php foreach ( $locations as $loc_term ) : ?>
							<button
								class="tourvice-filter-pill"
								data-location="<?php echo esc_attr( $loc_term->slug ); ?>"
							>
								<?php echo esc_html( $loc_term->name ); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Tour count -->
			<div class="tourvice-tour-count" id="tourvice-tour-count">
				<span data-count="<?php echo absint( $tour_count ); ?>">
					<?php
					printf(
						/* translators: %d: number of tours */
						esc_html( _n( '%d tour found', '%d tours found', $tour_count, 'tourvice' ) ),
						absint( $tour_count )
					);
					?>
				</span>
			</div>
		</div>
	</div>

	<!-- ════════ TOUR GRID ════════ -->
	<section class="tourvice-tour-listing">
		<div class="tourvice-archive__grid-inner container">

			<?php if ( have_posts() ) : ?>
				<div class="tourvice-tour-grid" id="tourvice-tour-grid">
					<?php
					while ( have_posts() ) :
						the_post();

						/* Attach data attributes for JS filtering */
						$card_location_terms = get_the_terms( get_the_ID(), 'tour_location' );
						$card_location_slug  = '';
						if ( $card_location_terms && ! is_wp_error( $card_location_terms ) ) {
							$slugs = wp_list_pluck( $card_location_terms, 'slug' );
							$card_location_slug = implode( ' ', $slugs );
						}
						?>
						<div
							class="tourvice-archive__card-wrap"
							data-location="<?php echo esc_attr( $card_location_slug ); ?>"
							data-title="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>"
							data-description="<?php echo esc_attr( strtolower( wp_strip_all_tags( get_the_excerpt() ) ) ); ?>"
						>
							<?php get_template_part( 'template-parts/tour-card' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="tourvice-empty-state">
					<p data-i18n="archive_no_tours"><?php esc_html_e( 'No tours found. Try different filters.', 'tourvice' ); ?></p>
				</div>
			<?php endif; ?>

			<!-- Empty state (shown by JS when no results match filter) -->
			<div class="tourvice-empty-state tourvice-empty-state--js" id="tourvice-no-results" hidden>
				<p data-i18n="archive_no_tours"><?php esc_html_e( 'No tours found. Try different filters.', 'tourvice' ); ?></p>
			</div>

		</div>
	</section>

	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
		)
	);
	?>

</main>

<?php get_footer(); ?>
