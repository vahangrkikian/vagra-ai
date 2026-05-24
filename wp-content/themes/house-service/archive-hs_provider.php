<?php
/**
 * Provider Archive Template
 *
 * @package House_Service
 */

get_header();
?>

<section class="page-hero">
	<div class="shell">
		<h1 class="page-hero__title"><?php esc_html_e( 'Browse Service Providers', 'house-service' ); ?></h1>
		<p class="page-hero__desc"><?php esc_html_e( 'Find background-checked, reviewed professionals for every home project. Filter by category, price, or search by name.', 'house-service' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="shell">

		<!-- Filter Bar -->
		<div class="filter-bar" id="provider-filters">
			<div class="filter-tabs">
				<button class="filter-tab is-active" data-cat="all"><?php esc_html_e( 'All', 'house-service' ); ?></button>
				<?php
				if ( taxonomy_exists( 'hs_service_cat' ) ) {
					$terms = get_terms( array(
						'taxonomy'   => 'hs_service_cat',
						'hide_empty' => false,
					) );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							printf(
								'<button class="filter-tab" data-cat="%s">%s</button>',
								esc_attr( $term->slug ),
								esc_html( $term->name )
							);
						}
					}
				}

				// Fallback categories if taxonomy doesn't exist yet.
				if ( ! taxonomy_exists( 'hs_service_cat' ) || empty( $terms ) || is_wp_error( $terms ) ) :
				?>
					<button class="filter-tab" data-cat="cleaning"><?php esc_html_e( 'Cleaning', 'house-service' ); ?></button>
					<button class="filter-tab" data-cat="moving"><?php esc_html_e( 'Moving', 'house-service' ); ?></button>
					<button class="filter-tab" data-cat="repair"><?php esc_html_e( 'Repair', 'house-service' ); ?></button>
					<button class="filter-tab" data-cat="assembly"><?php esc_html_e( 'Assembly', 'house-service' ); ?></button>
				<?php endif; ?>
			</div>

			<div class="filter-sep"></div>

			<div class="filter-prices">
				<button class="filter-price" data-price="1">$</button>
				<button class="filter-price" data-price="2">$$</button>
				<button class="filter-price" data-price="3">$$$</button>
			</div>

			<div class="filter-search">
				<?php echo hs_icon( 'search', 16 ); ?>
				<input type="text" id="filter-search-input" placeholder="<?php esc_attr_e( 'Search providers...', 'house-service' ); ?>" aria-label="<?php esc_attr_e( 'Search providers', 'house-service' ); ?>">
			</div>

			<select class="filter-sort" id="filter-sort" aria-label="<?php esc_attr_e( 'Sort providers', 'house-service' ); ?>">
				<option value="rating"><?php esc_html_e( 'Top rated', 'house-service' ); ?></option>
				<option value="reviews"><?php esc_html_e( 'Most reviewed', 'house-service' ); ?></option>
				<option value="price-asc"><?php esc_html_e( 'Price: low to high', 'house-service' ); ?></option>
				<option value="price-desc"><?php esc_html_e( 'Price: high to low', 'house-service' ); ?></option>
				<option value="newest"><?php esc_html_e( 'Newest', 'house-service' ); ?></option>
			</select>
		</div>

		<!-- Provider Grid -->
		<div class="co-grid" id="provider-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/provider-card' );
				endwhile;
			else :
			?>
			<div class="empty-state" id="empty-state">
				<div class="empty-state__icon"><?php echo hs_icon( 'search', 28 ); ?></div>
				<h3><?php esc_html_e( 'No providers found', 'house-service' ); ?></h3>
				<p><?php esc_html_e( 'Try adjusting your filters or search terms to find what you\'re looking for.', 'house-service' ); ?></p>
				<button class="btn btn-secondary" id="reset-filters"><?php esc_html_e( 'Reset filters', 'house-service' ); ?></button>
			</div>
			<?php endif; ?>
		</div>

		<?php
		// Pagination.
		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => hs_icon( 'chevron', 18 ),
			'next_text' => hs_icon( 'chevron', 18 ),
		) );
		?>

	</div>
</section>

<?php get_footer(); ?>
