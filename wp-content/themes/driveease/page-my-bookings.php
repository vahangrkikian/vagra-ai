<?php
/**
 * Template Name: My Bookings
 *
 * Front-end dashboard where logged-in customers can view their booking history.
 *
 * @package DriveEase
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" role="main">
<!-- My Bookings Hero -->
<section class="mybookings-hero">
	<div class="container">
		<div class="section-label" data-i18n="mybookings_label"><?php esc_html_e( 'My Bookings', 'driveease' ); ?></div>
		<h1 class="mybookings-hero__title" data-i18n="mybookings_title"><?php esc_html_e( 'Your Booking History', 'driveease' ); ?></h1>
		<p class="mybookings-hero__sub" data-i18n="mybookings_sub"><?php esc_html_e( 'View and track all your reservations in one place.', 'driveease' ); ?></p>
	</div>
</section>

<section class="mybookings-content">
	<div class="container">
	<?php if ( ! is_user_logged_in() ) : ?>
		<div class="mybookings-login">
			<div class="mybookings-login__icon">
				<i class="fa-solid fa-lock"></i>
			</div>
			<h2><?php esc_html_e( 'Please Log In', 'driveease' ); ?></h2>
			<p><?php esc_html_e( 'You need to be logged in to view your bookings.', 'driveease' ); ?></p>
			<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Log In', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
			</a>
		</div>
	<?php else :
		$current_user  = wp_get_current_user();
		$customer_email = $current_user->user_email;

		// Check if viewing a single booking detail.
		$detail_ref = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( $_GET['ref'] ) ) : '';

		if ( $detail_ref ) :
			// ── Single Booking Detail View ──
			$detail_query = new WP_Query(
				array(
					'post_type'      => 'driveease_booking',
					'posts_per_page' => 1,
					'post_status'    => 'any',
					'meta_query'     => array(
						'relation' => 'AND',
						array(
							'key'   => '_booking_customer_email',
							'value' => $customer_email,
						),
						array(
							'key'   => '_booking_reference',
							'value' => $detail_ref,
						),
					),
				)
			);

			if ( $detail_query->have_posts() ) :
				$detail_query->the_post();
				$booking_id = get_the_ID();

				$reference       = get_post_meta( $booking_id, '_booking_reference', true );
				$status          = get_post_meta( $booking_id, '_booking_status', true );
				$car_id          = get_post_meta( $booking_id, '_booking_car_id', true );
				$car_name        = $car_id ? get_the_title( $car_id ) : __( 'N/A', 'driveease' );
				$pickup_loc      = get_post_meta( $booking_id, '_booking_pickup_location', true );
				$dropoff_loc     = get_post_meta( $booking_id, '_booking_dropoff_location', true );
				$pickup_date     = get_post_meta( $booking_id, '_booking_pickup_date', true );
				$dropoff_date    = get_post_meta( $booking_id, '_booking_dropoff_date', true );
				$customer_name   = get_post_meta( $booking_id, '_booking_customer_name', true );
				$customer_phone  = get_post_meta( $booking_id, '_booking_customer_phone', true );
				$driver_license  = get_post_meta( $booking_id, '_booking_driver_license', true );
				$extras          = get_post_meta( $booking_id, '_booking_extras', true );
				$total_price     = get_post_meta( $booking_id, '_booking_total_price', true );
				$currency        = get_post_meta( $booking_id, '_booking_currency', true );
				$payment_status  = get_post_meta( $booking_id, '_booking_payment_status', true );

				$status_class = 'status--' . sanitize_html_class( strtolower( $status ) );

				// Format currency symbol.
				$currency_symbols = array( 'USD' => '$', 'EUR' => '€', 'AMD' => '֏' );
				$curr_symbol      = isset( $currency_symbols[ $currency ] ) ? $currency_symbols[ $currency ] : '$';
				?>
				<a href="<?php echo esc_url( remove_query_arg( 'ref' ) ); ?>" class="mybookings-back">
					<i class="fa-solid fa-arrow-left"></i> <?php esc_html_e( 'Back to All Bookings', 'driveease' ); ?>
				</a>

				<div class="booking-detail">
					<div class="booking-detail__header">
						<div>
							<h2 class="booking-detail__ref"><?php echo esc_html( $reference ); ?></h2>
							<p class="booking-detail__car"><?php echo esc_html( $car_name ); ?></p>
						</div>
						<span class="booking-status <?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( $status ); ?></span>
					</div>

					<div class="booking-detail__grid">
						<div class="booking-detail__section">
							<h3><i class="fa-solid fa-car"></i> <?php esc_html_e( 'Rental Details', 'driveease' ); ?></h3>
							<dl class="booking-dl">
								<dt><?php esc_html_e( 'Pick-up Location', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $pickup_loc ); ?></dd>
								<dt><?php esc_html_e( 'Drop-off Location', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $dropoff_loc ); ?></dd>
								<dt><?php esc_html_e( 'Pick-up Date', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $pickup_date ); ?></dd>
								<dt><?php esc_html_e( 'Drop-off Date', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $dropoff_date ); ?></dd>
							</dl>
						</div>

						<div class="booking-detail__section">
							<h3><i class="fa-solid fa-user"></i> <?php esc_html_e( 'Customer Info', 'driveease' ); ?></h3>
							<dl class="booking-dl">
								<dt><?php esc_html_e( 'Name', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $customer_name ); ?></dd>
								<dt><?php esc_html_e( 'Email', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $customer_email ); ?></dd>
								<dt><?php esc_html_e( 'Phone', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $customer_phone ); ?></dd>
								<?php if ( $driver_license ) : ?>
								<dt><?php esc_html_e( 'Driver License', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $driver_license ); ?></dd>
								<?php endif; ?>
							</dl>
						</div>

						<div class="booking-detail__section">
							<h3><i class="fa-solid fa-receipt"></i> <?php esc_html_e( 'Payment', 'driveease' ); ?></h3>
							<dl class="booking-dl">
								<dt><?php esc_html_e( 'Total Price', 'driveease' ); ?></dt>
								<dd class="booking-dl__price"><?php echo esc_html( $curr_symbol . number_format( (float) $total_price, 2 ) ); ?></dd>
								<dt><?php esc_html_e( 'Payment Status', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $payment_status ); ?></dd>
								<?php if ( $extras ) : ?>
								<dt><?php esc_html_e( 'Extras', 'driveease' ); ?></dt>
								<dd><?php echo esc_html( $extras ); ?></dd>
								<?php endif; ?>
							</dl>
						</div>
					</div>
				</div>
				<?php
				wp_reset_postdata();
			else :
				?>
				<div class="mybookings-empty">
					<i class="fa-solid fa-circle-exclamation"></i>
					<p><?php esc_html_e( 'Booking not found or you do not have access to this booking.', 'driveease' ); ?></p>
					<a href="<?php echo esc_url( remove_query_arg( 'ref' ) ); ?>" class="btn btn-outline">
						<?php esc_html_e( 'Back to All Bookings', 'driveease' ); ?>
					</a>
				</div>
				<?php
			endif;

		else :
			// ── Booking List View ──
			$bookings_query = new WP_Query(
				array(
					'post_type'      => 'driveease_booking',
					'posts_per_page' => -1,
					'post_status'    => 'any',
					'meta_key'       => '_booking_pickup_date',
					'orderby'        => 'meta_value',
					'order'          => 'DESC',
					'meta_query'     => array(
						array(
							'key'   => '_booking_customer_email',
							'value' => $customer_email,
						),
					),
				)
			);

			if ( $bookings_query->have_posts() ) :
				?>
				<div class="mybookings-summary">
					<span class="mybookings-summary__count">
						<?php
						printf(
							/* translators: %d: number of bookings */
							esc_html( _n( '%d booking', '%d bookings', $bookings_query->found_posts, 'driveease' ) ),
							(int) $bookings_query->found_posts
						);
						?>
					</span>
				</div>

				<div class="mybookings-table-wrap">
					<table class="mybookings-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Reference', 'driveease' ); ?></th>
								<th><?php esc_html_e( 'Vehicle', 'driveease' ); ?></th>
								<th><?php esc_html_e( 'Pick-up', 'driveease' ); ?></th>
								<th><?php esc_html_e( 'Drop-off', 'driveease' ); ?></th>
								<th><?php esc_html_e( 'Status', 'driveease' ); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php
						while ( $bookings_query->have_posts() ) :
							$bookings_query->the_post();
							$b_id       = get_the_ID();
							$b_ref      = get_post_meta( $b_id, '_booking_reference', true );
							$b_car_id   = get_post_meta( $b_id, '_booking_car_id', true );
							$b_car_name = $b_car_id ? get_the_title( $b_car_id ) : __( 'N/A', 'driveease' );
							$b_pickup   = get_post_meta( $b_id, '_booking_pickup_date', true );
							$b_dropoff  = get_post_meta( $b_id, '_booking_dropoff_date', true );
							$b_status   = get_post_meta( $b_id, '_booking_status', true );
							$b_status_class = 'status--' . sanitize_html_class( strtolower( $b_status ) );
							$detail_url = add_query_arg( 'ref', rawurlencode( $b_ref ), get_permalink() );
							?>
							<tr>
								<td data-label="<?php esc_attr_e( 'Reference', 'driveease' ); ?>">
									<strong><?php echo esc_html( $b_ref ); ?></strong>
								</td>
								<td data-label="<?php esc_attr_e( 'Vehicle', 'driveease' ); ?>">
									<?php echo esc_html( $b_car_name ); ?>
								</td>
								<td data-label="<?php esc_attr_e( 'Pick-up', 'driveease' ); ?>">
									<?php echo esc_html( $b_pickup ); ?>
								</td>
								<td data-label="<?php esc_attr_e( 'Drop-off', 'driveease' ); ?>">
									<?php echo esc_html( $b_dropoff ); ?>
								</td>
								<td data-label="<?php esc_attr_e( 'Status', 'driveease' ); ?>">
									<span class="booking-status <?php echo esc_attr( $b_status_class ); ?>"><?php echo esc_html( $b_status ); ?></span>
								</td>
								<td>
									<a href="<?php echo esc_url( $detail_url ); ?>" class="btn btn-outline mybookings-view-btn">
										<?php esc_html_e( 'View', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
									</a>
								</td>
							</tr>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
						</tbody>
					</table>
				</div>

				<!-- Mobile card layout -->
				<div class="mybookings-cards">
				<?php
				$bookings_query->rewind_posts();
				while ( $bookings_query->have_posts() ) :
					$bookings_query->the_post();
					$b_id       = get_the_ID();
					$b_ref      = get_post_meta( $b_id, '_booking_reference', true );
					$b_car_id   = get_post_meta( $b_id, '_booking_car_id', true );
					$b_car_name = $b_car_id ? get_the_title( $b_car_id ) : __( 'N/A', 'driveease' );
					$b_pickup   = get_post_meta( $b_id, '_booking_pickup_date', true );
					$b_dropoff  = get_post_meta( $b_id, '_booking_dropoff_date', true );
					$b_status   = get_post_meta( $b_id, '_booking_status', true );
					$b_status_class = 'status--' . sanitize_html_class( strtolower( $b_status ) );
					$detail_url = add_query_arg( 'ref', rawurlencode( $b_ref ), get_permalink() );
					?>
					<div class="mybooking-card">
						<div class="mybooking-card__header">
							<strong><?php echo esc_html( $b_ref ); ?></strong>
							<span class="booking-status <?php echo esc_attr( $b_status_class ); ?>"><?php echo esc_html( $b_status ); ?></span>
						</div>
						<div class="mybooking-card__body">
							<div class="mybooking-card__row">
								<i class="fa-solid fa-car"></i>
								<span><?php echo esc_html( $b_car_name ); ?></span>
							</div>
							<div class="mybooking-card__row">
								<i class="fa-solid fa-calendar"></i>
								<span><?php echo esc_html( $b_pickup ); ?> &rarr; <?php echo esc_html( $b_dropoff ); ?></span>
							</div>
						</div>
						<a href="<?php echo esc_url( $detail_url ); ?>" class="btn btn-outline mybookings-view-btn">
							<?php esc_html_e( 'View Details', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
				</div>

			<?php else : ?>
				<div class="mybookings-empty">
					<i class="fa-solid fa-calendar-xmark"></i>
					<h2><?php esc_html_e( 'No Bookings Yet', 'driveease' ); ?></h2>
					<p><?php esc_html_e( 'You haven\'t made any reservations yet. Browse our fleet to find the perfect car!', 'driveease' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/fleet/' ) ); ?>" class="btn btn-primary">
						<?php esc_html_e( 'Browse Fleet', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
					</a>
				</div>
			<?php endif; ?>

		<?php endif; // detail_ref ?>
	<?php endif; // is_user_logged_in ?>
	</div>
</section>
</main>

<?php
get_footer();
