<?php
/**
 * Homepage template.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- Hero -->
<section id="hero" role="main">
<span id="main-content"></span>
	<div class="container hero-content">
		<div class="hero-badge"><i class="fa-solid fa-star"></i> &nbsp;<span data-i18n="hero_badge"><?php esc_html_e( '#1 Rated Car Rental Service', 'driveease' ); ?></span></div>
		<h1 class="hero-title" data-i18n="hero_title"><?php
			printf(
				/* translators: %s: styled word "Ride" */
				esc_html__( 'Find Your Perfect %s for Any Journey', 'driveease' ),
				'<span>' . esc_html__( 'Ride', 'driveease' ) . '</span>'
			);
		?></h1>
		<p class="hero-sub" data-i18n="hero_sub"><?php esc_html_e( 'Premium vehicles, unbeatable rates, and seamless booking — wherever your destination takes you.', 'driveease' ); ?></p>

		<div class="booking-widget">
			<div class="widget-title"><i class="fa-solid fa-magnifying-glass"></i> &nbsp;<span data-i18n="widget_title"><?php esc_html_e( 'Search Available Cars', 'driveease' ); ?></span></div>
			<div class="booking-grid" id="heroBookingGrid">
				<div class="field-group">
					<label data-i18n="label_pickup"><?php esc_html_e( 'Pick-Up Location', 'driveease' ); ?></label>
					<?php
					$branch_query = new WP_Query(
						array(
							'post_type'      => 'driveease_branch',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						)
					);
					$branch_names = array();
					if ( $branch_query->have_posts() ) {
						while ( $branch_query->have_posts() ) {
							$branch_query->the_post();
							$branch_names[] = get_the_title();
						}
						wp_reset_postdata();
					}
					?>
					<select id="heroPickup">
						<option value=""><?php esc_html_e( 'Select branch…', 'driveease' ); ?></option>
						<?php foreach ( $branch_names as $branch_name ) : ?>
							<option><?php echo esc_html( $branch_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="field-group">
					<label data-i18n="label_dropoff"><?php esc_html_e( 'Drop-Off Location', 'driveease' ); ?></label>
					<select id="heroDropoff">
						<option value=""><?php esc_html_e( 'Same as Pick-Up', 'driveease' ); ?></option>
						<?php foreach ( $branch_names as $branch_name ) : ?>
							<option><?php echo esc_html( $branch_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="field-group">
					<label data-i18n="label_pickdate"><?php esc_html_e( 'Pick-Up Date', 'driveease' ); ?></label>
					<input type="date" id="heroPickDate"/>
				</div>
				<div class="field-group">
					<label data-i18n="label_dropdate"><?php esc_html_e( 'Drop-Off Date', 'driveease' ); ?></label>
					<input type="date" id="heroDropDate"/>
				</div>
				<button class="btn btn-primary" id="heroSearchBtn"><i class="fa-solid fa-search"></i> <span data-i18n="btn_search"><?php esc_html_e( 'Search', 'driveease' ); ?></span></button>
			</div>
		</div>
	</div>
</section>

<!-- Fleet -->
<section id="fleet">
	<div class="container">
		<div class="fleet-header">
			<div>
				<div class="section-label" data-i18n="fleet_label"><?php esc_html_e( 'Our Vehicles', 'driveease' ); ?></div>
				<h2 class="section-title" data-i18n="fleet_title"><?php esc_html_e( 'Choose Your Vehicle', 'driveease' ); ?></h2>
			</div>
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
		</div>

		<div class="fleet-grid" id="fleetGrid">
			<?php
			$featured_cars = new WP_Query(
				array(
					'post_type'      => 'driveease_car',
					'posts_per_page' => 12,
					'meta_query'     => array(
						array(
							'key'   => '_car_featured',
							'value' => '1',
						),
					),
				)
			);

			if ( $featured_cars->have_posts() ) :
				while ( $featured_cars->have_posts() ) :
					$featured_cars->the_post();

					$car_id       = get_the_ID();
					$price        = get_post_meta( $car_id, '_car_price_per_day', true );
					$seats        = get_post_meta( $car_id, '_car_seats', true );
					$transmission = get_post_meta( $car_id, '_car_transmission', true );
					$fuel         = get_post_meta( $car_id, '_car_fuel_type', true );
					$year         = get_post_meta( $car_id, '_car_year', true );

					$car_cats    = get_the_terms( $car_id, 'car_category' );
					$cat_name    = '';
					$cat_slug    = '';
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
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<!-- Why DriveEase -->
<section id="why">
	<div class="container">
		<div class="section-label" data-i18n="why_label"><?php esc_html_e( 'Why DriveEase', 'driveease' ); ?></div>
		<h2 class="section-title" data-i18n="why_title"><?php
			printf(
				'%s<br>%s',
				esc_html__( 'Everything You Need,', 'driveease' ),
				esc_html__( "Nothing You Don't", 'driveease' )
			);
		?></h2>
		<div class="why-grid">
			<div class="why-card">
				<div class="why-icon"><i class="fa-solid fa-rotate-left"></i></div>
				<h3 data-i18n="why1_title"><?php esc_html_e( 'Free Cancellation', 'driveease' ); ?></h3>
				<p data-i18n="why1_desc"><?php esc_html_e( 'Plans change. Cancel up to 24 hours before pick-up at no cost, no questions asked.', 'driveease' ); ?></p>
			</div>
			<div class="why-card">
				<div class="why-icon"><i class="fa-solid fa-headset"></i></div>
				<h3 data-i18n="why2_title"><?php esc_html_e( '24/7 Support', 'driveease' ); ?></h3>
				<p data-i18n="why2_desc"><?php esc_html_e( 'Our team is available around the clock via phone, chat, or email whenever you need us.', 'driveease' ); ?></p>
			</div>
			<div class="why-card">
				<div class="why-icon"><i class="fa-solid fa-location-crosshairs"></i></div>
				<h3 data-i18n="why3_title"><?php esc_html_e( 'GPS Included', 'driveease' ); ?></h3>
				<p data-i18n="why3_desc"><?php esc_html_e( 'Every vehicle comes equipped with a built-in GPS navigation system at no extra charge.', 'driveease' ); ?></p>
			</div>
			<div class="why-card">
				<div class="why-icon"><i class="fa-solid fa-shield-halved"></i></div>
				<h3 data-i18n="why4_title"><?php esc_html_e( 'Full Insurance', 'driveease' ); ?></h3>
				<p data-i18n="why4_desc"><?php esc_html_e( 'Comprehensive insurance coverage included with every rental — drive with complete peace of mind.', 'driveease' ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- How It Works -->
<section id="how">
	<div class="container">
		<div class="how-header">
			<div class="section-label" data-i18n="how_label"><?php esc_html_e( 'Simple Process', 'driveease' ); ?></div>
			<h2 class="section-title" data-i18n="how_title"><?php esc_html_e( 'On the Road in 3 Steps', 'driveease' ); ?></h2>
		</div>
		<div class="steps">
			<div class="step">
				<div class="step-num"><i class="fa-solid fa-magnifying-glass"></i></div>
				<h3 data-i18n="how1_title"><?php esc_html_e( 'Search', 'driveease' ); ?></h3>
				<p data-i18n="how1_desc"><?php esc_html_e( 'Enter your pick-up location, dates, and preferred vehicle class to browse availability.', 'driveease' ); ?></p>
			</div>
			<div class="step">
				<div class="step-num"><i class="fa-regular fa-credit-card"></i></div>
				<h3 data-i18n="how2_title"><?php esc_html_e( 'Book', 'driveease' ); ?></h3>
				<p data-i18n="how2_desc"><?php esc_html_e( 'Select your car, add any extras, and confirm your booking in under two minutes.', 'driveease' ); ?></p>
			</div>
			<div class="step">
				<div class="step-num"><i class="fa-solid fa-car-side"></i></div>
				<h3 data-i18n="how3_title"><?php esc_html_e( 'Drive', 'driveease' ); ?></h3>
				<p data-i18n="how3_desc"><?php esc_html_e( "Pick up the keys at your chosen branch and hit the road — it's that simple.", 'driveease' ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Testimonials -->
<section id="testimonials">
	<div class="container">
		<div class="test-header">
			<div class="section-label" data-i18n="rev_label"><?php esc_html_e( 'Customer Reviews', 'driveease' ); ?></div>
			<h2 class="section-title" data-i18n="rev_title"><?php esc_html_e( 'What Our Customers Say', 'driveease' ); ?></h2>
		</div>
		<div class="test-grid">
			<div class="test-card">
				<div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
				<blockquote>&ldquo;<?php esc_html_e( 'Booking was seamless and the car was in perfect condition. Pick-up at the airport branch took less than five minutes. Will definitely use again on my next trip.', 'driveease' ); ?>&rdquo;</blockquote>
				<div class="reviewer">
					<span class="avatar avatar--initials" aria-hidden="true">AJ</span>
					<div class="reviewer-info"><strong>A. Johnson</strong><span><?php esc_html_e( 'Business Traveller', 'driveease' ); ?></span></div>
				</div>
			</div>
			<div class="test-card">
				<div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
				<blockquote>&ldquo;<?php esc_html_e( 'We rented an SUV for a family road trip. Spacious, clean, and the GPS saved us countless times. The free cancellation policy gave us peace of mind.', 'driveease' ); ?>&rdquo;</blockquote>
				<div class="reviewer">
					<span class="avatar avatar--initials" aria-hidden="true">MF</span>
					<div class="reviewer-info"><strong>M. Fernandez</strong><span><?php esc_html_e( 'Family Traveller', 'driveease' ); ?></span></div>
				</div>
			</div>
			<div class="test-card">
				<div class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
				<blockquote>&ldquo;<?php esc_html_e( 'Great selection of vehicles and very transparent pricing. The 24/7 support team helped me sort out a minor issue within minutes. Highly recommend.', 'driveease' ); ?>&rdquo;</blockquote>
				<div class="reviewer">
					<span class="avatar avatar--initials" aria-hidden="true">SN</span>
					<div class="reviewer-info"><strong>S. Nakamura</strong><span><?php esc_html_e( 'Frequent Renter', 'driveease' ); ?></span></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
