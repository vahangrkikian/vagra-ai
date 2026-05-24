<?php
/**
 * Single branch detail template.
 *
 * Displays breadcrumb, hero image, branch info, map placeholder,
 * available cars, and nearby branches.
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
<?php
while ( have_posts() ) :
	the_post();

	$branch_id      = get_the_ID();
	$address        = get_post_meta( $branch_id, '_branch_address', true );
	$phone          = get_post_meta( $branch_id, '_branch_phone', true );
	$email          = get_post_meta( $branch_id, '_branch_email', true );
	$hours_weekday  = get_post_meta( $branch_id, '_branch_hours_weekday', true );
	$hours_weekend  = get_post_meta( $branch_id, '_branch_hours_weekend', true );
	$is_24h         = get_post_meta( $branch_id, '_branch_is_24h', true );
	$latitude       = get_post_meta( $branch_id, '_branch_latitude', true );
	$longitude      = get_post_meta( $branch_id, '_branch_longitude', true );

	$branches_url = get_post_type_archive_link( 'driveease_branch' );
	$fleet_url    = get_post_type_archive_link( 'driveease_car' );

	$thumbnail = get_the_post_thumbnail_url( $branch_id, 'full' );
	if ( ! $thumbnail ) {
		$thumbnail = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
	}
	?>

	<!-- BREADCRUMB -->
	<div class="breadcrumb-bar">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-i18n="nav_home"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<a href="<?php echo esc_url( $branches_url ); ?>" data-i18n="nav_branches"><?php esc_html_e( 'Branches', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
		</div>
	</div>

	<!-- HERO IMAGE -->
	<section class="branch-hero">
		<div class="container">
			<div class="branch-hero__img-wrap">
				<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
				<?php if ( $is_24h ) : ?>
					<span class="branch-badge branch-badge--24h"><?php esc_html_e( '24/7', 'driveease' ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- BRANCH INFO -->
	<section class="branch-detail">
		<div class="container">
			<div class="branch-detail__layout">
				<!-- Main info -->
				<div class="branch-detail__main">
					<h1 class="branch-detail__title"><?php the_title(); ?></h1>

					<?php if ( get_the_content() ) : ?>
						<div class="branch-detail__desc">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>

					<div class="branch-info-grid">
						<?php if ( $address ) : ?>
							<div class="branch-info-item">
								<div class="branch-info-icon"><i class="fa-solid fa-location-dot"></i></div>
								<div>
									<div class="branch-info-label"><?php esc_html_e( 'Address', 'driveease' ); ?></div>
									<div class="branch-info-value"><?php echo esc_html( $address ); ?></div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $phone ) : ?>
							<div class="branch-info-item">
								<div class="branch-info-icon"><i class="fa-solid fa-phone"></i></div>
								<div>
									<div class="branch-info-label"><?php esc_html_e( 'Phone', 'driveease' ); ?></div>
									<div class="branch-info-value">
										<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $email ) : ?>
							<div class="branch-info-item">
								<div class="branch-info-icon"><i class="fa-solid fa-envelope"></i></div>
								<div>
									<div class="branch-info-label"><?php esc_html_e( 'Email', 'driveease' ); ?></div>
									<div class="branch-info-value">
										<a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_html( $email ); ?></a>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<div class="branch-info-item">
							<div class="branch-info-icon"><i class="fa-regular fa-clock"></i></div>
							<div>
								<div class="branch-info-label"><?php esc_html_e( 'Hours', 'driveease' ); ?></div>
								<div class="branch-info-value">
									<?php if ( $is_24h ) : ?>
										<span class="hours-badge hours-badge--open"><?php esc_html_e( 'Open 24/7', 'driveease' ); ?></span>
									<?php else : ?>
										<?php if ( $hours_weekday ) : ?>
											<div class="branch-hours-row">
												<strong><?php esc_html_e( 'Mon-Fri:', 'driveease' ); ?></strong> <?php echo esc_html( $hours_weekday ); ?>
											</div>
										<?php endif; ?>
										<?php if ( $hours_weekend ) : ?>
											<div class="branch-hours-row">
												<strong><?php esc_html_e( 'Sat-Sun:', 'driveease' ); ?></strong> <?php echo esc_html( $hours_weekend ); ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Map placeholder -->
				<div class="branch-detail__map">
					<div class="branch-map-placeholder"
						data-lat="<?php echo esc_attr( $latitude ); ?>"
						data-lng="<?php echo esc_attr( $longitude ); ?>">
						<div class="branch-map-inner">
							<i class="fa-solid fa-map-location-dot"></i>
							<p><?php esc_html_e( 'Map', 'driveease' ); ?></p>
							<?php if ( $address ) : ?>
								<span class="branch-map-address"><?php echo esc_html( $address ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- AVAILABLE CARS -->
	<?php
	$cars = new WP_Query(
		array(
			'post_type'      => 'driveease_car',
			'posts_per_page' => 6,
			'post_status'    => 'publish',
			'orderby'        => 'rand',
		)
	);

	if ( $cars->have_posts() ) :
	?>
	<section class="branch-fleet">
		<div class="container">
			<div class="branch-fleet__header">
				<div class="section-label" data-i18n="branch_fleet_label"><?php esc_html_e( 'Available Vehicles', 'driveease' ); ?></div>
				<h2 class="section-title" data-i18n="branch_fleet_title"><?php esc_html_e( 'Cars at This Branch', 'driveease' ); ?></h2>
			</div>
			<div class="branch-fleet__grid">
				<?php
				while ( $cars->have_posts() ) :
					$cars->the_post();

					$car_id       = get_the_ID();
					$price        = get_post_meta( $car_id, '_car_price_per_day', true );
					$seats        = get_post_meta( $car_id, '_car_seats', true );
					$transmission = get_post_meta( $car_id, '_car_transmission', true );
					$fuel         = get_post_meta( $car_id, '_car_fuel_type', true );

					$car_cats = get_the_terms( $car_id, 'car_category' );
					$cat_name = '';
					if ( ! is_wp_error( $car_cats ) && ! empty( $car_cats ) ) {
						$cat_name = $car_cats[0]->name;
					}

					$car_thumb = get_the_post_thumbnail_url( $car_id, 'medium_large' );
					if ( ! $car_thumb ) {
						$car_thumb = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
					}
					?>
					<div class="car-card">
						<div class="car-img-wrap">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $car_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
							</a>
							<?php if ( $cat_name ) : ?>
								<span class="car-badge" style="background:var(--accent)"><?php echo esc_html( $cat_name ); ?></span>
							<?php endif; ?>
						</div>
						<div class="car-body">
							<a href="<?php the_permalink(); ?>" class="car-name-link"><?php the_title(); ?></a>
							<div class="car-specs">
								<?php if ( $seats ) : ?>
									<div class="spec"><i class="fa-solid fa-user-group"></i> <?php echo esc_html( $seats ); ?></div>
								<?php endif; ?>
								<?php if ( $transmission ) : ?>
									<div class="spec"><i class="fa-solid fa-gears"></i> <?php echo esc_html( $transmission ); ?></div>
								<?php endif; ?>
								<?php if ( $fuel ) : ?>
									<div class="spec"><i class="fa-solid fa-gas-pump"></i> <?php echo esc_html( $fuel ); ?></div>
								<?php endif; ?>
							</div>
							<div class="car-footer">
								<div class="price" data-usd="<?php echo esc_attr( $price ); ?>">$<?php echo esc_html( $price ); ?><span class="price-suf" data-i18n="per_day"><?php esc_html_e( '/day', 'driveease' ); ?></span></div>
								<a href="<?php the_permalink(); ?>" class="btn btn-primary" style="padding:10px 20px;font-size:.85rem" data-i18n="det_view"><?php esc_html_e( 'View Car', 'driveease' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- CTA -->
	<section class="branch-cta">
		<div class="container">
			<div class="branch-cta__box">
				<h2 data-i18n="branch_cta_title"><?php esc_html_e( 'Ready to Book from This Branch?', 'driveease' ); ?></h2>
				<p data-i18n="branch_cta_sub"><?php esc_html_e( 'Browse our full fleet and reserve your perfect ride today.', 'driveease' ); ?></p>
				<a href="<?php echo esc_url( $fleet_url ); ?>" class="btn btn-primary" data-i18n="btn_browse_fleet"><?php esc_html_e( 'Browse Fleet', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></a>
			</div>
		</div>
	</section>

	<!-- NEARBY BRANCHES -->
	<?php
	$nearby = new WP_Query(
		array(
			'post_type'      => 'driveease_branch',
			'posts_per_page' => 3,
			'post__not_in'   => array( $branch_id ),
			'post_status'    => 'publish',
			'orderby'        => 'rand',
		)
	);

	if ( $nearby->have_posts() ) :
	?>
	<section class="branch-nearby">
		<div class="container">
			<div class="branch-nearby__header">
				<div class="section-label" data-i18n="nearby_label"><?php esc_html_e( 'Nearby Locations', 'driveease' ); ?></div>
				<h2 class="section-title" data-i18n="nearby_title"><?php esc_html_e( 'Other Branches', 'driveease' ); ?></h2>
			</div>
			<div class="branch-nearby__grid">
				<?php
				while ( $nearby->have_posts() ) :
					$nearby->the_post();

					$nb_id      = get_the_ID();
					$nb_address = get_post_meta( $nb_id, '_branch_address', true );
					$nb_phone   = get_post_meta( $nb_id, '_branch_phone', true );
					$nb_is_24h  = get_post_meta( $nb_id, '_branch_is_24h', true );

					$nb_thumb = get_the_post_thumbnail_url( $nb_id, 'medium_large' );
					if ( ! $nb_thumb ) {
						$nb_thumb = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
					}
					?>
					<div class="branch-card">
						<div class="branch-card__img">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $nb_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
							</a>
							<?php if ( $nb_is_24h ) : ?>
								<span class="branch-badge branch-badge--24h"><?php esc_html_e( '24/7', 'driveease' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="branch-card__body">
							<a href="<?php the_permalink(); ?>" class="branch-card__name"><?php the_title(); ?></a>
							<?php if ( $nb_address ) : ?>
								<div class="branch-card__detail">
									<i class="fa-solid fa-location-dot"></i>
									<span><?php echo esc_html( $nb_address ); ?></span>
								</div>
							<?php endif; ?>
							<?php if ( $nb_phone ) : ?>
								<div class="branch-card__detail">
									<i class="fa-solid fa-phone"></i>
									<span><?php echo esc_html( $nb_phone ); ?></span>
								</div>
							<?php endif; ?>
							<a href="<?php the_permalink(); ?>" class="btn btn-primary branch-card__cta" style="margin-top:auto"><?php esc_html_e( 'View Branch', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></a>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

<?php
endwhile;
?>
</main>
<?php
get_footer();
