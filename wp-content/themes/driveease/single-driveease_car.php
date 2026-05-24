<?php
/**
 * Single car detail template.
 *
 * Displays breadcrumb, image gallery, specs grid, included features,
 * sticky sidebar with price calculator, and similar vehicles.
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

	$car_id     = get_the_ID();
	$price      = get_post_meta( $car_id, '_car_price_per_day', true );
	$year       = get_post_meta( $car_id, '_car_year', true );
	$seats      = get_post_meta( $car_id, '_car_seats', true );
	$doors      = get_post_meta( $car_id, '_car_doors', true );
	$trans      = get_post_meta( $car_id, '_car_transmission', true );
	$fuel       = get_post_meta( $car_id, '_car_fuel_type', true );
	$engine     = get_post_meta( $car_id, '_car_engine', true );
	$mileage    = get_post_meta( $car_id, '_car_mileage_limit', true );
	$trunk      = get_post_meta( $car_id, '_car_trunk_capacity', true );
	$ac         = get_post_meta( $car_id, '_car_air_conditioning', true );
	$gps        = get_post_meta( $car_id, '_car_gps_included', true );
	$bluetooth  = get_post_meta( $car_id, '_car_bluetooth', true );
	$usb        = get_post_meta( $car_id, '_car_usb_charging', true );
	$cruise     = get_post_meta( $car_id, '_car_cruise_control', true );
	$camera     = get_post_meta( $car_id, '_car_backup_camera', true );
	$gallery    = get_post_meta( $car_id, '_car_gallery', true );

	$car_cats = get_the_terms( $car_id, 'car_category' );
	$cat_name = '';
	$cat_slug = '';
	if ( ! is_wp_error( $car_cats ) && ! empty( $car_cats ) ) {
		$cat_name = $car_cats[0]->name;
		$cat_slug = $car_cats[0]->slug;
	}

	// Build gallery images array: featured image first, then gallery meta.
	$gallery_images = array();
	$featured_id    = get_post_thumbnail_id( $car_id );
	if ( $featured_id ) {
		$gallery_images[] = $featured_id;
	}
	if ( is_array( $gallery ) ) {
		foreach ( $gallery as $att_id ) {
			$att_id = (int) $att_id;
			if ( $att_id && $att_id !== (int) $featured_id ) {
				$gallery_images[] = $att_id;
			}
		}
	}

	$fleet_url = get_post_type_archive_link( 'driveease_car' );
	?>

	<!-- BREADCRUMB -->
	<div class="breadcrumb-bar">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-i18n="nav_home"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<a href="<?php echo esc_url( $fleet_url ); ?>" data-i18n="nav_fleet"><?php esc_html_e( 'Fleet', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
		</div>
	</div>

	<!-- GALLERY -->
	<section class="gallery-section">
		<div class="container">
			<?php if ( ! empty( $gallery_images ) ) : ?>
				<div class="main-img-wrap">
					<?php
					$main_src = wp_get_attachment_image_url( $gallery_images[0], 'full' );
					?>
					<img id="mainImg" src="<?php echo esc_url( $main_src ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
					<?php if ( $cat_name ) : ?>
						<span class="car-badge-det"><?php echo esc_html( $cat_name ); ?></span>
					<?php endif; ?>
				</div>
				<?php if ( count( $gallery_images ) > 1 ) : ?>
					<div class="thumbs">
						<?php foreach ( $gallery_images as $idx => $att_id ) :
							$thumb_src = wp_get_attachment_image_url( $att_id, 'medium' );
							$full_src  = wp_get_attachment_image_url( $att_id, 'full' );
							?>
							<div class="thumb<?php echo 0 === $idx ? ' active' : ''; ?>" onclick="swapImg(this,'<?php echo esc_url( $full_src ); ?>')">
								<img src="<?php echo esc_url( $thumb_src ); ?>" alt=""/>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<div class="main-img-wrap">
					<img id="mainImg" src="<?php echo esc_url( DRIVEEASE_URI . '/assets/images/car-placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
					<?php if ( $cat_name ) : ?>
						<span class="car-badge-det"><?php echo esc_html( $cat_name ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- DETAIL -->
	<section class="detail-section">
		<div class="container">
			<div class="detail-layout">
				<!-- MAIN COLUMN -->
				<div class="detail-main">
					<!-- Specs -->
					<div class="specs-box">
						<h3 data-i18n="det_specs"><?php esc_html_e( 'Vehicle Specifications', 'driveease' ); ?></h3>
						<div class="specs-grid">
							<?php if ( $seats ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_seats"><?php esc_html_e( 'Seats', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $seats ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $doors ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_doors"><?php esc_html_e( 'Doors', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $doors ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $trans ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_trans"><?php esc_html_e( 'Transmission', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $trans ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $fuel ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_fuel"><?php esc_html_e( 'Fuel Type', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $fuel ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $engine ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_engine"><?php esc_html_e( 'Engine', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $engine ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $mileage ) : ?>
								<div class="spec-row">
									<div class="spec-label"><?php esc_html_e( 'Mileage Limit', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $mileage ); ?></div>
								</div>
							<?php endif; ?>
							<?php if ( $trunk ) : ?>
								<div class="spec-row">
									<div class="spec-label" data-i18n="spec_boot"><?php esc_html_e( 'Trunk', 'driveease' ); ?></div>
									<div class="spec-val"><?php echo esc_html( $trunk ); ?></div>
								</div>
							<?php endif; ?>
							<div class="spec-row">
								<div class="spec-label"><?php esc_html_e( 'A/C', 'driveease' ); ?></div>
								<div class="spec-val"><?php echo $ac ? esc_html__( 'Yes', 'driveease' ) : esc_html__( 'No', 'driveease' ); ?></div>
							</div>
						</div>
					</div>

					<!-- Features -->
					<?php
					$features = array();
					if ( $gps ) {
						$features[] = array( 'icon' => 'fa-solid fa-location-dot', 'label' => __( 'GPS Navigation', 'driveease' ) );
					}
					if ( $bluetooth ) {
						$features[] = array( 'icon' => 'fa-brands fa-bluetooth', 'label' => __( 'Bluetooth Audio', 'driveease' ) );
					}
					if ( $usb ) {
						$features[] = array( 'icon' => 'fa-solid fa-plug', 'label' => __( 'USB Charging', 'driveease' ) );
					}
					if ( $cruise ) {
						$features[] = array( 'icon' => 'fa-solid fa-gauge-high', 'label' => __( 'Cruise Control', 'driveease' ) );
					}
					if ( $camera ) {
						$features[] = array( 'icon' => 'fa-solid fa-camera', 'label' => __( 'Backup Camera', 'driveease' ) );
					}
					if ( $ac ) {
						$features[] = array( 'icon' => 'fa-solid fa-wind', 'label' => __( 'Air Conditioning', 'driveease' ) );
					}

					if ( ! empty( $features ) ) :
					?>
					<div class="features-box">
						<h3 data-i18n="det_features"><?php esc_html_e( 'Included Features', 'driveease' ); ?></h3>
						<div class="features-list">
							<?php foreach ( $features as $feat ) : ?>
								<div class="feature-item">
									<div class="feature-icon"><i class="<?php echo esc_attr( $feat['icon'] ); ?>"></i></div>
									<span><?php echo esc_html( $feat['label'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>

				<!-- SIDEBAR -->
				<div class="sidebar">
					<div class="sidebar-card">
						<div class="sidebar-price">
							<span class="sb-price-val" data-usd="<?php echo esc_attr( $price ); ?>">$<?php echo esc_html( $price ); ?></span><span data-i18n="per_day"><?php esc_html_e( '/day', 'driveease' ); ?></span>
						</div>
						<div class="sidebar-sub" data-i18n="sidebar_incl"><?php esc_html_e( 'GPS & basic insurance included', 'driveease' ); ?></div>
						<hr class="sidebar-divider"/>

						<div class="sb-field">
							<label data-i18n="label_pickdate"><?php esc_html_e( 'Pick-Up Date', 'driveease' ); ?></label>
							<input type="date" id="sb-pickdate"/>
						</div>
						<div class="sb-field">
							<label data-i18n="label_dropdate"><?php esc_html_e( 'Drop-Off Date', 'driveease' ); ?></label>
							<input type="date" id="sb-dropdate"/>
						</div>

						<hr class="sidebar-divider"/>
						<p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--gray);margin-bottom:10px"><?php esc_html_e( 'Optional Extras', 'driveease' ); ?></p>

						<label class="extra-item" style="display:flex;align-items:center;gap:10px;padding:10px 0;cursor:pointer;border:none">
							<input type="checkbox" class="sb-extra" data-price="8" style="accent-color:var(--accent);width:16px;height:16px"/>
							<span style="flex:1;font-size:.88rem;font-weight:500"><?php esc_html_e( 'GPS Navigation', 'driveease' ); ?></span>
							<span style="font-size:.85rem;font-weight:700;color:var(--accent)">+$8/<?php esc_html_e( 'day', 'driveease' ); ?></span>
						</label>
						<label class="extra-item" style="display:flex;align-items:center;gap:10px;padding:10px 0;cursor:pointer;border:none">
							<input type="checkbox" class="sb-extra" data-price="12" style="accent-color:var(--accent);width:16px;height:16px"/>
							<span style="flex:1;font-size:.88rem;font-weight:500"><?php esc_html_e( 'Child Seat', 'driveease' ); ?></span>
							<span style="font-size:.85rem;font-weight:700;color:var(--accent)">+$12/<?php esc_html_e( 'day', 'driveease' ); ?></span>
						</label>
						<label class="extra-item" style="display:flex;align-items:center;gap:10px;padding:10px 0;cursor:pointer;border:none">
							<input type="checkbox" class="sb-extra" data-price="6" style="accent-color:var(--accent);width:16px;height:16px"/>
							<span style="flex:1;font-size:.88rem;font-weight:500"><?php esc_html_e( 'Wi-Fi Hotspot', 'driveease' ); ?></span>
							<span style="font-size:.85rem;font-weight:700;color:var(--accent)">+$6/<?php esc_html_e( 'day', 'driveease' ); ?></span>
						</label>
						<label class="extra-item" style="display:flex;align-items:center;gap:10px;padding:10px 0;cursor:pointer;border:none">
							<input type="checkbox" class="sb-extra" data-price="18" style="accent-color:var(--accent);width:16px;height:16px"/>
							<span style="flex:1;font-size:.88rem;font-weight:500"><?php esc_html_e( 'Premium Insurance', 'driveease' ); ?></span>
							<span style="font-size:.85rem;font-weight:700;color:var(--accent)">+$18/<?php esc_html_e( 'day', 'driveease' ); ?></span>
						</label>

						<div class="total-box">
							<div class="total-row"><span data-i18n="sum_base"><?php esc_html_e( 'Vehicle cost', 'driveease' ); ?></span><span id="sb-base">$<?php echo esc_html( $price ); ?> &times; 1 <?php esc_html_e( 'day', 'driveease' ); ?></span></div>
							<div class="total-row" id="sb-extras-row" style="display:none"><span data-i18n="sum_extras"><?php esc_html_e( 'Extras', 'driveease' ); ?></span><span id="sb-extras-val">$0</span></div>
							<div class="total-row grand"><span data-i18n="sum_total"><?php esc_html_e( 'Total', 'driveease' ); ?></span><span id="sb-total">$<?php echo esc_html( $price ); ?>.00</span></div>
						</div>

						<button class="btn btn-primary open-booking" data-car="<?php echo esc_attr( $car_id ); ?>" data-car-name="<?php echo esc_attr( get_the_title() ); ?>" data-car-price="<?php echo esc_attr( $price ); ?>" data-i18n="btn_reserve_car"><?php esc_html_e( 'Book This Car', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></button>
						<div class="sidebar-note"><i class="fa-solid fa-rotate-left"></i><span data-i18n="sidebar_cancel"><?php esc_html_e( 'Free cancellation up to 24h before pick-up', 'driveease' ); ?></span></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- REVIEWS SECTION -->
	<section class="reviews-section">
		<div class="container">
			<?php
			$avg_rating   = DriveEase_Reviews::get_average_rating( $car_id );
			$review_count = DriveEase_Reviews::get_review_count( $car_id );
			$reviews      = get_approved_comments( $car_id );
			?>

			<?php if ( $review_count > 0 ) : ?>
				<div class="reviews-summary">
					<div class="reviews-summary-score"><?php echo esc_html( number_format( $avg_rating, 1 ) ); ?></div>
					<div class="reviews-summary-detail">
						<?php DriveEase_Reviews::render_stars( $avg_rating ); ?>
						<span class="reviews-summary-count">
							<?php
							printf(
								/* translators: %d: number of reviews */
								esc_html( _n( '%d review', '%d reviews', $review_count, 'driveease' ) ),
								$review_count
							);
							?>
						</span>
					</div>
				</div>
			<?php endif; ?>

			<!-- Reviews List -->
			<div class="reviews-box">
				<h3 data-i18n="reviews_title"><?php esc_html_e( 'Customer Reviews', 'driveease' ); ?></h3>
				<?php if ( ! empty( $reviews ) ) : ?>
					<div class="reviews-list">
						<?php foreach ( $reviews as $review ) :
							$r_rating = (int) get_comment_meta( $review->comment_ID, '_review_rating', true );
							if ( ! $r_rating ) continue;
						?>
							<div class="review-item">
								<div class="review-header">
									<span class="review-author"><?php echo esc_html( $review->comment_author ); ?></span>
									<span class="review-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $review->comment_date ) ) ); ?></span>
								</div>
								<div class="review-rating">
									<?php DriveEase_Reviews::render_stars( $r_rating ); ?>
								</div>
								<div class="review-content"><?php echo esc_html( $review->comment_content ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="reviews-empty">
						<?php esc_html_e( 'No reviews yet. Be the first to review this car!', 'driveease' ); ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Review Form -->
			<div class="review-form-box">
				<h3 data-i18n="review_form_title"><?php esc_html_e( 'Write a Review', 'driveease' ); ?></h3>
				<?php if ( ! is_user_logged_in() ) : ?>
					<div class="review-form-message">
						<?php
						printf(
							/* translators: %s: login URL */
							wp_kses(
								__( 'Please <a href="%s">log in</a> to leave a review. Only customers with a completed booking can review.', 'driveease' ),
								array( 'a' => array( 'href' => array() ) )
							),
							esc_url( wp_login_url( get_permalink() ) )
						);
						?>
					</div>
				<?php elseif ( DriveEase_Reviews::user_has_reviewed( $car_id ) ) : ?>
					<div class="review-form-message">
						<?php esc_html_e( 'You have already submitted a review for this car. Thank you!', 'driveease' ); ?>
					</div>
				<?php elseif ( ! DriveEase_Reviews::user_can_review( $car_id ) ) : ?>
					<div class="review-form-message">
						<?php esc_html_e( 'Only customers who have completed a booking for this car can leave a review.', 'driveease' ); ?>
					</div>
				<?php else : ?>
					<div class="review-form-inner">
						<form id="driveease-review-form"
							data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'driveease_review_nonce' ) ); ?>"
							data-car-id="<?php echo esc_attr( $car_id ); ?>">

							<div class="review-field">
								<label class="star-picker-label"><?php esc_html_e( 'Your Rating', 'driveease' ); ?></label>
								<div class="star-picker">
									<button type="button" class="star-pick" aria-label="1 star"><i class="fa-solid fa-star"></i></button>
									<button type="button" class="star-pick" aria-label="2 stars"><i class="fa-solid fa-star"></i></button>
									<button type="button" class="star-pick" aria-label="3 stars"><i class="fa-solid fa-star"></i></button>
									<button type="button" class="star-pick" aria-label="4 stars"><i class="fa-solid fa-star"></i></button>
									<button type="button" class="star-pick" aria-label="5 stars"><i class="fa-solid fa-star"></i></button>
								</div>
								<input type="hidden" id="driveease-rating-input" name="driveease_rating" value="0"/>
							</div>

							<div class="review-field">
								<label class="star-picker-label" for="review-comment-text"><?php esc_html_e( 'Your Review', 'driveease' ); ?></label>
								<textarea id="review-comment-text" name="review_comment" placeholder="<?php esc_attr_e( 'Share your experience with this car…', 'driveease' ); ?>"></textarea>
							</div>

							<button type="submit" class="btn btn-primary" data-label="<?php esc_attr_e( 'Submit Review', 'driveease' ); ?>" data-loading="<?php esc_attr_e( 'Submitting…', 'driveease' ); ?>">
								<?php esc_html_e( 'Submit Review', 'driveease' ); ?> <i class="fa-solid fa-paper-plane"></i>
							</button>
							<div id="review-form-notice" class="review-form-notice" style="display:none"></div>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- SIMILAR CARS -->
	<?php
	if ( $cat_slug ) :
		$similar = new WP_Query(
			array(
				'post_type'      => 'driveease_car',
				'posts_per_page' => 2,
				'post__not_in'   => array( $car_id ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'car_category',
						'field'    => 'slug',
						'terms'    => $cat_slug,
					),
				),
			)
		);

		if ( $similar->have_posts() ) :
	?>
	<section class="similar-section">
		<div class="container">
			<div class="similar-header">
				<div style="font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--accent);margin-bottom:8px" data-i18n="similar_label"><?php esc_html_e( 'Similar Vehicles', 'driveease' ); ?></div>
				<h2 data-i18n="similar_title"><?php esc_html_e( 'You Might Also Like', 'driveease' ); ?></h2>
			</div>
			<div class="similar-grid">
				<?php
				while ( $similar->have_posts() ) :
					$similar->the_post();

					$s_id    = get_the_ID();
					$s_price = get_post_meta( $s_id, '_car_price_per_day', true );
					$s_seats = get_post_meta( $s_id, '_car_seats', true );
					$s_trans = get_post_meta( $s_id, '_car_transmission', true );
					$s_fuel  = get_post_meta( $s_id, '_car_fuel_type', true );
					$s_year  = get_post_meta( $s_id, '_car_year', true );

					$s_cats     = get_the_terms( $s_id, 'car_category' );
					$s_cat_name = '';
					if ( ! is_wp_error( $s_cats ) && ! empty( $s_cats ) ) {
						$s_cat_name = $s_cats[0]->name;
					}

					$s_thumb = get_the_post_thumbnail_url( $s_id, 'medium_large' );
					if ( ! $s_thumb ) {
						$s_thumb = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
					}

					$s_class = $s_cat_name ? $s_cat_name . ' Class' : '';
					if ( $s_year ) {
						$s_class .= ' &middot; ' . esc_html( $s_year );
					}
					?>
					<div class="car-card">
						<div class="car-img-wrap">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $s_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
							</a>
							<?php if ( $s_cat_name ) : ?>
								<span class="car-badge-s" style="background:var(--accent)"><?php echo esc_html( $s_cat_name ); ?></span>
							<?php endif; ?>
						</div>
						<div class="car-body">
							<a href="<?php the_permalink(); ?>" class="car-name-link"><?php the_title(); ?></a>
							<div class="car-class-s"><?php echo wp_kses_post( $s_class ); ?></div>
							<div class="car-specs-s">
								<?php if ( $s_seats ) : ?>
									<div class="spec-s"><i class="fa-solid fa-user-group"></i> <?php echo esc_html( $s_seats ); ?></div>
								<?php endif; ?>
								<?php if ( $s_trans ) : ?>
									<div class="spec-s"><i class="fa-solid fa-gears"></i> <span data-i18n="auto"><?php echo esc_html( $s_trans ); ?></span></div>
								<?php endif; ?>
								<?php if ( $s_fuel ) : ?>
									<div class="spec-s"><i class="fa-solid fa-gas-pump"></i> <?php echo esc_html( $s_fuel ); ?></div>
								<?php endif; ?>
							</div>
							<div class="car-footer-s">
								<div class="price-s" data-usd="<?php echo esc_attr( $s_price ); ?>">$<?php echo esc_html( $s_price ); ?><span data-i18n="per_day"><?php esc_html_e( '/day', 'driveease' ); ?></span></div>
								<a href="<?php the_permalink(); ?>" class="btn btn-primary" style="padding:9px 18px;font-size:.82rem" data-i18n="det_view"><?php esc_html_e( 'View Car', 'driveease' ); ?></a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
	<?php
		endif;
		wp_reset_postdata();
	endif;
	?>

	<script>
	(function(){
		const CAR_PRICE = <?php echo (float) $price; ?>;

		// Gallery swap.
		window.swapImg = function(thumb, url) {
			document.getElementById('mainImg').src = url;
			document.querySelectorAll('.thumb').forEach(function(t){ t.classList.remove('active'); });
			thumb.classList.add('active');
		};

		// Sidebar calculator.
		var pickEl = document.getElementById('sb-pickdate');
		var dropEl = document.getElementById('sb-dropdate');
		var today  = new Date().toISOString().split('T')[0];
		if (pickEl) pickEl.min = today;
		if (dropEl) dropEl.min = today;

		function getDays() {
			if (!pickEl || !dropEl || !pickEl.value || !dropEl.value) return 1;
			var diff = (new Date(dropEl.value) - new Date(pickEl.value)) / 86400000;
			return diff > 0 ? diff : 1;
		}

		function getExtras() {
			var total = 0;
			document.querySelectorAll('.sb-extra:checked').forEach(function(cb) {
				total += parseFloat(cb.dataset.price) * getDays();
			});
			return total;
		}

		function updateSidebar() {
			if (typeof fmtP !== 'function') {
				// Fallback if main.js currency helper not loaded yet.
				var fmt = function(v) { return '$' + v.toFixed(2); };
			} else {
				var fmt = fmtP;
			}
			var days   = getDays();
			var base   = CAR_PRICE * days;
			var extras = getExtras();
			var total  = base + extras;

			var baseEl = document.getElementById('sb-base');
			if (baseEl) baseEl.textContent = fmt(CAR_PRICE) + ' × ' + days + ' day' + (days !== 1 ? 's' : '');

			var extrasRow = document.getElementById('sb-extras-row');
			var extrasVal = document.getElementById('sb-extras-val');
			if (extrasRow) {
				if (extras > 0) {
					extrasRow.style.display = '';
					if (extrasVal) extrasVal.textContent = fmt(extras);
				} else {
					extrasRow.style.display = 'none';
				}
			}

			var totalEl = document.getElementById('sb-total');
			if (totalEl) totalEl.textContent = fmt(total);
		}

		if (pickEl) pickEl.addEventListener('change', function() {
			if (dropEl) dropEl.min = pickEl.value;
			updateSidebar();
		});
		if (dropEl) dropEl.addEventListener('change', updateSidebar);
		document.querySelectorAll('.sb-extra').forEach(function(cb) {
			cb.addEventListener('change', updateSidebar);
		});
	})();
	</script>

<?php
endwhile;
?>
</main>
<?php
get_footer();
