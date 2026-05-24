<?php
/**
 * Template Name: Fleet
 *
 * Fleet page template — displays all cars with category filters.
 * Used when the /fleet/ URL is a WordPress page rather than the CPT archive.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" role="main">
<!-- Fleet Hero -->
<section class="fleet-hero">
	<div class="container">
		<div class="section-label" data-i18n="fleet_hero_label"><?php esc_html_e( 'Our Fleet', 'driveease' ); ?></div>
		<h1 class="fleet-hero__title" data-i18n="fleet_hero_title"><?php esc_html_e( 'Browse Our Complete Collection', 'driveease' ); ?></h1>
		<p class="fleet-hero__sub" data-i18n="fleet_hero_sub"><?php esc_html_e( 'Find the perfect vehicle for every journey — from compact city cars to spacious SUVs.', 'driveease' ); ?></p>
	</div>
</section>

<!-- Fleet Grid -->
<section id="fleet" class="fleet-archive">
	<div class="container">
		<div class="fleet-filters">
			<button class="filter-btn active" data-filter="all" data-i18n="filter_all"><?php esc_html_e( 'All', 'driveease' ); ?></button>
			<?php
			$categories = get_terms(
				array(
					'taxonomy'   => 'car_category',
					'hide_empty' => false,
				)
			);
			if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) :
				foreach ( $categories as $cat ) :
					printf(
						'<button class="filter-btn" data-filter="%s" data-i18n="filter_%s">%s</button>',
						esc_attr( sanitize_title( $cat->name ) ),
						esc_attr( sanitize_title( $cat->name ) ),
						esc_html( $cat->name )
					);
				endforeach;
			endif;
			?>
		</div>

		<?php
		$paged    = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$car_query = new WP_Query(
			array(
				'post_type'      => 'driveease_car',
				'posts_per_page' => 12,
				'paged'          => $paged,
				'post_status'    => 'publish',
			)
		);

		if ( $car_query->have_posts() ) :
		?>
			<div class="fleet-grid" id="fleetGrid">
				<?php
				while ( $car_query->have_posts() ) :
					$car_query->the_post();

					$car_id       = get_the_ID();
					$price        = get_post_meta( $car_id, '_car_price_per_day', true );
					$seats        = get_post_meta( $car_id, '_car_seats', true );
					$transmission = get_post_meta( $car_id, '_car_transmission', true );
					$fuel         = get_post_meta( $car_id, '_car_fuel_type', true );
					$year         = get_post_meta( $car_id, '_car_year', true );

					$car_cats = get_the_terms( $car_id, 'car_category' );
					$cat_name = '';
					$cat_slug = '';
					if ( ! is_wp_error( $car_cats ) && ! empty( $car_cats ) ) {
						$cat_name = $car_cats[0]->name;
						$cat_slug = sanitize_title( $car_cats[0]->name );
					}

					$car_class = $cat_name ? $cat_name . ' Class' : '';
					if ( $year ) {
						$car_class .= ' &middot; ' . esc_html( $year );
					}

					$thumbnail = get_the_post_thumbnail_url( $car_id, 'medium_large' );
					if ( ! $thumbnail ) {
						$thumbnail = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
					}
					?>
					<div class="car-card" data-category="<?php echo esc_attr( $cat_slug ); ?>" data-name="<?php echo esc_attr( get_the_title() ); ?>" data-price="<?php echo esc_attr( $price ); ?>">
						<div class="car-img-wrap">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
							</a>
							<?php if ( $cat_name ) : ?>
								<span class="car-badge" style="background:var(--accent)"><?php echo esc_html( $cat_name ); ?></span>
							<?php endif; ?>
						</div>
						<div class="car-body">
							<a href="<?php the_permalink(); ?>" class="car-name-link"><?php the_title(); ?></a>
							<div class="car-class"><?php echo wp_kses_post( $car_class ); ?></div>
							<div class="car-specs">
								<?php if ( $seats ) : ?>
									<div class="spec"><i class="fa-solid fa-user-group"></i> <?php echo esc_html( $seats ); ?> <span data-i18n="seats"><?php esc_html_e( 'Seats', 'driveease' ); ?></span></div>
								<?php endif; ?>
								<?php if ( $transmission ) : ?>
									<div class="spec"><i class="fa-solid fa-gears"></i> <span data-i18n="auto"><?php echo esc_html( $transmission ); ?></span></div>
								<?php endif; ?>
								<?php if ( $fuel ) : ?>
									<div class="spec"><i class="fa-solid fa-gas-pump"></i> <?php echo esc_html( $fuel ); ?></div>
								<?php endif; ?>
							</div>
							<div class="car-footer">
								<div class="price" data-usd="<?php echo esc_attr( $price ); ?>">$<?php echo esc_html( $price ); ?><span class="price-suf" data-i18n="per_day"><?php esc_html_e( '/day', 'driveease' ); ?></span></div>
								<button class="btn btn-primary open-booking" style="padding:10px 20px;font-size:.85rem" data-i18n="btn_reserve"><?php esc_html_e( 'Reserve', 'driveease' ); ?></button>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				?>
			</div>

			<?php
			$total_pages = $car_query->max_num_pages;
			if ( $total_pages > 1 ) :
			?>
			<nav class="navigation pagination" aria-label="<?php esc_attr_e( 'Cars', 'driveease' ); ?>">
				<div class="nav-links">
					<?php
					echo paginate_links(
						array(
							'total'     => $total_pages,
							'current'   => $paged,
							'mid_size'  => 2,
							'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'driveease' ),
							'next_text' => esc_html__( 'Next', 'driveease' ) . ' <i class="fa-solid fa-chevron-right"></i>',
						)
					);
					?>
				</div>
			</nav>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<div class="fleet-empty">
				<p><?php esc_html_e( 'No vehicles found. Please check back soon!', 'driveease' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
</main>

<?php
get_footer();
