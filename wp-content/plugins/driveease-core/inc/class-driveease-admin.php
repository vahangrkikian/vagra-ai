<?php
/**
 * DriveEase Admin — meta boxes for Car, Booking, and Branch CPTs.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Admin
 */
class DriveEase_Admin {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_driveease_car', array( __CLASS__, 'save_car_meta' ) );
		add_action( 'save_post_driveease_booking', array( __CLASS__, 'save_booking_meta' ) );
		add_action( 'save_post_driveease_branch', array( __CLASS__, 'save_branch_meta' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );

		// Booking list-table columns.
		add_filter( 'manage_driveease_booking_posts_columns', array( __CLASS__, 'booking_columns' ) );
		add_action( 'manage_driveease_booking_posts_custom_column', array( __CLASS__, 'booking_column_content' ), 10, 2 );
		add_filter( 'manage_edit-driveease_booking_sortable_columns', array( __CLASS__, 'booking_sortable_columns' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'booking_columns_orderby' ) );

		// Quick row actions.
		add_filter( 'post_row_actions', array( __CLASS__, 'booking_row_actions' ), 10, 2 );
		add_action( 'admin_init', array( __CLASS__, 'handle_booking_row_action' ) );

		// Dashboard widget.
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'register_dashboard_widget' ) );

		// CSV export sub-page.
		add_action( 'admin_menu', array( __CLASS__, 'register_csv_export_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_csv_export' ) );
	}

	/**
	 * Enqueue media uploader on car edit screens.
	 *
	 * @param string $hook_suffix Current admin page.
	 */
	public static function enqueue_admin_scripts( $hook_suffix ) {
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen && 'driveease_car' === $screen->post_type ) {
			wp_enqueue_media();

			wp_add_inline_script(
				'jquery-core',
				"
				jQuery( document ).ready( function( $ ) {
					var frame;
					$( '#driveease-gallery-upload' ).on( 'click', function( e ) {
						e.preventDefault();
						if ( frame ) { frame.open(); return; }
						frame = wp.media({
							title: '" . esc_js( __( 'Select Gallery Images', 'driveease' ) ) . "',
							button: { text: '" . esc_js( __( 'Add to Gallery', 'driveease' ) ) . "' },
							multiple: true
						});
						frame.on( 'select', function() {
							var ids = [];
							frame.state().get( 'selection' ).each( function( attachment ) {
								ids.push( attachment.id );
							});
							var existing = $( '#driveease-car-gallery' ).val();
							if ( existing ) {
								ids = existing.split( ',' ).concat( ids );
							}
							$( '#driveease-car-gallery' ).val( ids.join( ',' ) );
							driveease_refresh_preview( ids.join( ',' ) );
						});
						frame.open();
					});
					$( '#driveease-gallery-clear' ).on( 'click', function( e ) {
						e.preventDefault();
						$( '#driveease-car-gallery' ).val( '' );
						$( '#driveease-gallery-preview' ).html( '' );
					});
					function driveease_refresh_preview( val ) {
						if ( ! val ) { $( '#driveease-gallery-preview' ).html( '' ); return; }
						var container = $( '#driveease-gallery-preview' );
						container.html( '' );
						val.split( ',' ).forEach( function( id ) {
							id = parseInt( id, 10 );
							if ( ! id ) return;
							var img = $( '<img />' ).css({ width: '60px', height: '60px', objectFit: 'cover', marginRight: '4px', marginBottom: '4px' });
							wp.media.attachment( id ).fetch().then( function() {
								var url = wp.media.attachment( id ).get( 'url' );
								img.attr( 'src', url );
							});
							container.append( img );
						});
					}
					driveease_refresh_preview( $( '#driveease-car-gallery' ).val() );
				});
				"
			);
		}
	}

	/**
	 * Register all meta boxes.
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'driveease_car_details',
			esc_html__( 'Car Details', 'driveease' ),
			array( __CLASS__, 'render_car_meta_box' ),
			'driveease_car',
			'normal',
			'high'
		);

		add_meta_box(
			'driveease_booking_details',
			esc_html__( 'Booking Details', 'driveease' ),
			array( __CLASS__, 'render_booking_meta_box' ),
			'driveease_booking',
			'normal',
			'high'
		);

		add_meta_box(
			'driveease_branch_details',
			esc_html__( 'Branch Details', 'driveease' ),
			array( __CLASS__, 'render_branch_meta_box' ),
			'driveease_branch',
			'normal',
			'high'
		);
	}

	/*--------------------------------------------------------------
	 * CAR META BOX
	 *------------------------------------------------------------*/

	/**
	 * Render the Car Details meta box.
	 *
	 * @param \WP_Post $post Current post object.
	 */
	public static function render_car_meta_box( $post ) {
		wp_nonce_field( 'driveease_car_meta', 'driveease_car_nonce' );

		// Current values.
		$year              = get_post_meta( $post->ID, '_car_year', true );
		$seats             = get_post_meta( $post->ID, '_car_seats', true );
		$doors             = get_post_meta( $post->ID, '_car_doors', true );
		$transmission      = get_post_meta( $post->ID, '_car_transmission', true );
		$fuel_type         = get_post_meta( $post->ID, '_car_fuel_type', true );
		$engine            = get_post_meta( $post->ID, '_car_engine', true );
		$mileage_limit     = get_post_meta( $post->ID, '_car_mileage_limit', true );
		$trunk_capacity    = get_post_meta( $post->ID, '_car_trunk_capacity', true );
		$price_per_day     = get_post_meta( $post->ID, '_car_price_per_day', true );
		$availability      = get_post_meta( $post->ID, '_car_availability_status', true );
		$air_conditioning  = get_post_meta( $post->ID, '_car_air_conditioning', true );
		$gps               = get_post_meta( $post->ID, '_car_gps_included', true );
		$bluetooth         = get_post_meta( $post->ID, '_car_bluetooth', true );
		$usb               = get_post_meta( $post->ID, '_car_usb_charging', true );
		$cruise            = get_post_meta( $post->ID, '_car_cruise_control', true );
		$backup_camera     = get_post_meta( $post->ID, '_car_backup_camera', true );
		$featured          = get_post_meta( $post->ID, '_car_featured', true );
		$gallery_raw       = get_post_meta( $post->ID, '_car_gallery', true );
		$gallery           = is_array( $gallery_raw ) ? implode( ',', $gallery_raw ) : '';

		$transmissions = array(
			''          => __( '-- Select --', 'driveease' ),
			'automatic' => __( 'Automatic', 'driveease' ),
			'manual'    => __( 'Manual', 'driveease' ),
			'cvt'       => __( 'CVT', 'driveease' ),
		);

		$fuel_types = array(
			''         => __( '-- Select --', 'driveease' ),
			'gasoline' => __( 'Gasoline', 'driveease' ),
			'diesel'   => __( 'Diesel', 'driveease' ),
			'electric' => __( 'Electric', 'driveease' ),
			'hybrid'   => __( 'Hybrid', 'driveease' ),
		);

		$availability_options = array(
			''            => __( '-- Select --', 'driveease' ),
			'available'   => __( 'Available', 'driveease' ),
			'rented'      => __( 'Rented', 'driveease' ),
			'maintenance' => __( 'Maintenance', 'driveease' ),
		);
		?>

		<style>
			.driveease-meta-section { margin-bottom: 20px; }
			.driveease-meta-section h4 { margin: 0 0 10px; padding: 8px 0; border-bottom: 1px solid #ddd; }
			.driveease-meta-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 8px; }
			.driveease-meta-field { flex: 1; min-width: 180px; }
			.driveease-meta-field label { display: block; font-weight: 600; margin-bottom: 4px; }
			.driveease-meta-field input[type="text"],
			.driveease-meta-field input[type="number"],
			.driveease-meta-field select { width: 100%; }
			.driveease-checkbox-group { display: flex; flex-wrap: wrap; gap: 16px; }
			.driveease-checkbox-group label { font-weight: 400; cursor: pointer; }
			#driveease-gallery-preview { margin-top: 8px; display: flex; flex-wrap: wrap; }
			#driveease-gallery-preview img { border: 1px solid #ddd; border-radius: 2px; }
		</style>

		<!-- Specs Section -->
		<div class="driveease-meta-section">
			<h4><?php esc_html_e( 'Specifications', 'driveease' ); ?></h4>
			<div class="driveease-meta-row">
				<div class="driveease-meta-field">
					<label for="driveease-car-year"><?php esc_html_e( 'Year', 'driveease' ); ?></label>
					<input type="text" id="driveease-car-year" name="_car_year" value="<?php echo esc_attr( $year ); ?>" />
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-seats"><?php esc_html_e( 'Seats', 'driveease' ); ?></label>
					<input type="number" id="driveease-car-seats" name="_car_seats" value="<?php echo esc_attr( $seats ); ?>" min="1" max="20" />
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-doors"><?php esc_html_e( 'Doors', 'driveease' ); ?></label>
					<input type="number" id="driveease-car-doors" name="_car_doors" value="<?php echo esc_attr( $doors ); ?>" min="1" max="10" />
				</div>
			</div>
			<div class="driveease-meta-row">
				<div class="driveease-meta-field">
					<label for="driveease-car-transmission"><?php esc_html_e( 'Transmission', 'driveease' ); ?></label>
					<select id="driveease-car-transmission" name="_car_transmission">
						<?php foreach ( $transmissions as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $transmission, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-fuel-type"><?php esc_html_e( 'Fuel Type', 'driveease' ); ?></label>
					<select id="driveease-car-fuel-type" name="_car_fuel_type">
						<?php foreach ( $fuel_types as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $fuel_type, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="driveease-meta-row">
				<div class="driveease-meta-field">
					<label for="driveease-car-engine"><?php esc_html_e( 'Engine', 'driveease' ); ?></label>
					<input type="text" id="driveease-car-engine" name="_car_engine" value="<?php echo esc_attr( $engine ); ?>" placeholder="<?php esc_attr_e( 'e.g. 2.0L Turbo', 'driveease' ); ?>" />
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-mileage"><?php esc_html_e( 'Mileage Limit', 'driveease' ); ?></label>
					<input type="text" id="driveease-car-mileage" name="_car_mileage_limit" value="<?php echo esc_attr( $mileage_limit ); ?>" placeholder="<?php esc_attr_e( 'e.g. Unlimited', 'driveease' ); ?>" />
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-trunk"><?php esc_html_e( 'Trunk Capacity', 'driveease' ); ?></label>
					<input type="text" id="driveease-car-trunk" name="_car_trunk_capacity" value="<?php echo esc_attr( $trunk_capacity ); ?>" placeholder="<?php esc_attr_e( 'e.g. 450L', 'driveease' ); ?>" />
				</div>
			</div>
		</div>

		<!-- Features Section -->
		<div class="driveease-meta-section">
			<h4><?php esc_html_e( 'Features', 'driveease' ); ?></h4>
			<div class="driveease-checkbox-group">
				<label>
					<input type="checkbox" name="_car_air_conditioning" value="1" <?php checked( $air_conditioning ); ?> />
					<?php esc_html_e( 'Air Conditioning', 'driveease' ); ?>
				</label>
				<label>
					<input type="checkbox" name="_car_gps_included" value="1" <?php checked( $gps ); ?> />
					<?php esc_html_e( 'GPS', 'driveease' ); ?>
				</label>
				<label>
					<input type="checkbox" name="_car_bluetooth" value="1" <?php checked( $bluetooth ); ?> />
					<?php esc_html_e( 'Bluetooth', 'driveease' ); ?>
				</label>
				<label>
					<input type="checkbox" name="_car_usb_charging" value="1" <?php checked( $usb ); ?> />
					<?php esc_html_e( 'USB Charging', 'driveease' ); ?>
				</label>
				<label>
					<input type="checkbox" name="_car_cruise_control" value="1" <?php checked( $cruise ); ?> />
					<?php esc_html_e( 'Cruise Control', 'driveease' ); ?>
				</label>
				<label>
					<input type="checkbox" name="_car_backup_camera" value="1" <?php checked( $backup_camera ); ?> />
					<?php esc_html_e( 'Backup Camera', 'driveease' ); ?>
				</label>
			</div>
		</div>

		<!-- Pricing Section -->
		<div class="driveease-meta-section">
			<h4><?php esc_html_e( 'Pricing', 'driveease' ); ?></h4>
			<div class="driveease-meta-row">
				<div class="driveease-meta-field">
					<label for="driveease-car-price"><?php esc_html_e( 'Price Per Day ($)', 'driveease' ); ?></label>
					<input type="number" id="driveease-car-price" name="_car_price_per_day" value="<?php echo esc_attr( $price_per_day ); ?>" min="0" step="0.01" />
				</div>
				<div class="driveease-meta-field">
					<label for="driveease-car-availability"><?php esc_html_e( 'Availability', 'driveease' ); ?></label>
					<select id="driveease-car-availability" name="_car_availability_status">
						<?php foreach ( $availability_options as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $availability, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>

		<!-- Gallery Section -->
		<div class="driveease-meta-section">
			<h4><?php esc_html_e( 'Gallery', 'driveease' ); ?></h4>
			<div class="driveease-meta-field">
				<input type="hidden" id="driveease-car-gallery" name="_car_gallery" value="<?php echo esc_attr( $gallery ); ?>" />
				<button type="button" id="driveease-gallery-upload" class="button"><?php esc_html_e( 'Add Images', 'driveease' ); ?></button>
				<button type="button" id="driveease-gallery-clear" class="button"><?php esc_html_e( 'Clear Gallery', 'driveease' ); ?></button>
				<div id="driveease-gallery-preview"></div>
			</div>
		</div>

		<!-- Featured -->
		<div class="driveease-meta-section">
			<label>
				<input type="checkbox" name="_car_featured" value="1" <?php checked( $featured ); ?> />
				<strong><?php esc_html_e( 'Featured Car', 'driveease' ); ?></strong>
			</label>
		</div>
		<?php
	}

	/**
	 * Save car meta box data.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function save_car_meta( $post_id ) {
		if ( ! isset( $_POST['driveease_car_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['driveease_car_nonce'] ) ), 'driveease_car_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// String fields.
		$string_fields = array(
			'_car_year',
			'_car_transmission',
			'_car_fuel_type',
			'_car_engine',
			'_car_mileage_limit',
			'_car_trunk_capacity',
			'_car_availability_status',
		);

		foreach ( $string_fields as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}

		// Integer fields.
		$integer_fields = array( '_car_seats', '_car_doors' );
		foreach ( $integer_fields as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, absint( $_POST[ $key ] ) );
			}
		}

		// Number field.
		if ( isset( $_POST['_car_price_per_day'] ) ) {
			update_post_meta( $post_id, '_car_price_per_day', (float) $_POST['_car_price_per_day'] );
		}

		// Boolean fields.
		$boolean_fields = array(
			'_car_air_conditioning',
			'_car_gps_included',
			'_car_bluetooth',
			'_car_usb_charging',
			'_car_cruise_control',
			'_car_backup_camera',
			'_car_featured',
		);

		foreach ( $boolean_fields as $key ) {
			update_post_meta( $post_id, $key, ! empty( $_POST[ $key ] ) );
		}

		// Gallery — comma-separated IDs to array of integers.
		if ( isset( $_POST['_car_gallery'] ) ) {
			$raw = sanitize_text_field( wp_unslash( $_POST['_car_gallery'] ) );
			if ( '' === $raw ) {
				update_post_meta( $post_id, '_car_gallery', array() );
			} else {
				$ids = array_map( 'absint', explode( ',', $raw ) );
				$ids = array_filter( $ids );
				update_post_meta( $post_id, '_car_gallery', array_values( $ids ) );
			}
		}
	}

	/*--------------------------------------------------------------
	 * BOOKING META BOX
	 *------------------------------------------------------------*/

	/**
	 * Render the Booking Details meta box.
	 *
	 * @param \WP_Post $post Current post object.
	 */
	public static function render_booking_meta_box( $post ) {
		wp_nonce_field( 'driveease_booking_meta', 'driveease_booking_nonce' );

		$reference       = get_post_meta( $post->ID, '_booking_reference', true );
		$car_id          = get_post_meta( $post->ID, '_booking_car_id', true );
		$customer_name   = get_post_meta( $post->ID, '_booking_customer_name', true );
		$customer_email  = get_post_meta( $post->ID, '_booking_customer_email', true );
		$customer_phone  = get_post_meta( $post->ID, '_booking_customer_phone', true );
		$driver_license  = get_post_meta( $post->ID, '_booking_driver_license', true );
		$pickup_location = get_post_meta( $post->ID, '_booking_pickup_location', true );
		$dropoff_location = get_post_meta( $post->ID, '_booking_dropoff_location', true );
		$pickup_date     = get_post_meta( $post->ID, '_booking_pickup_date', true );
		$dropoff_date    = get_post_meta( $post->ID, '_booking_dropoff_date', true );
		$extras          = get_post_meta( $post->ID, '_booking_extras', true );
		$total_price     = get_post_meta( $post->ID, '_booking_total_price', true );
		$currency        = get_post_meta( $post->ID, '_booking_currency', true );
		$status          = get_post_meta( $post->ID, '_booking_status', true );
		$payment_status  = get_post_meta( $post->ID, '_booking_payment_status', true );

		$car_title = '';
		$car_link  = '';
		if ( $car_id ) {
			$car_post = get_post( $car_id );
			if ( $car_post ) {
				$car_title = $car_post->post_title;
				$car_link  = get_edit_post_link( $car_id );
			}
		}

		$status_options = array(
			''          => __( '-- Select --', 'driveease' ),
			'pending'   => __( 'Pending', 'driveease' ),
			'confirmed' => __( 'Confirmed', 'driveease' ),
			'active'    => __( 'Active', 'driveease' ),
			'completed' => __( 'Completed', 'driveease' ),
			'cancelled' => __( 'Cancelled', 'driveease' ),
		);

		$payment_options = array(
			''         => __( '-- Select --', 'driveease' ),
			'unpaid'   => __( 'Unpaid', 'driveease' ),
			'paid'     => __( 'Paid', 'driveease' ),
			'refunded' => __( 'Refunded', 'driveease' ),
		);
		?>

		<style>
			.driveease-booking-table { width: 100%; border-collapse: collapse; }
			.driveease-booking-table th { text-align: left; padding: 8px 12px; background: #f9f9f9; border-bottom: 1px solid #eee; width: 160px; }
			.driveease-booking-table td { padding: 8px 12px; border-bottom: 1px solid #eee; }
		</style>

		<table class="driveease-booking-table">
			<tr>
				<th><?php esc_html_e( 'Reference', 'driveease' ); ?></th>
				<td><?php echo esc_html( $reference ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Car', 'driveease' ); ?></th>
				<td>
					<?php if ( $car_link ) : ?>
						<a href="<?php echo esc_url( $car_link ); ?>"><?php echo esc_html( $car_title ); ?></a>
					<?php elseif ( $car_id ) : ?>
						<?php echo esc_html( '#' . $car_id ); ?>
					<?php else : ?>
						&mdash;
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Customer Name', 'driveease' ); ?></th>
				<td><?php echo esc_html( $customer_name ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Customer Email', 'driveease' ); ?></th>
				<td><?php echo esc_html( $customer_email ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Customer Phone', 'driveease' ); ?></th>
				<td><?php echo esc_html( $customer_phone ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Driver License', 'driveease' ); ?></th>
				<td><?php echo esc_html( $driver_license ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Pickup Location', 'driveease' ); ?></th>
				<td><?php echo esc_html( $pickup_location ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Dropoff Location', 'driveease' ); ?></th>
				<td><?php echo esc_html( $dropoff_location ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Pickup Date', 'driveease' ); ?></th>
				<td><?php echo esc_html( $pickup_date ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Dropoff Date', 'driveease' ); ?></th>
				<td><?php echo esc_html( $dropoff_date ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Extras', 'driveease' ); ?></th>
				<td><?php echo esc_html( $extras ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Total Price', 'driveease' ); ?></th>
				<td><?php echo esc_html( $total_price ? number_format( (float) $total_price, 2 ) : '' ); ?><?php echo $currency ? ' ' . esc_html( $currency ) : ''; ?></td>
			</tr>
		</table>

		<h4 style="margin: 16px 0 8px;"><?php esc_html_e( 'Status Management', 'driveease' ); ?></h4>

		<table class="driveease-booking-table">
			<tr>
				<th><label for="driveease-booking-status"><?php esc_html_e( 'Booking Status', 'driveease' ); ?></label></th>
				<td>
					<select id="driveease-booking-status" name="_booking_status">
						<?php foreach ( $status_options as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="driveease-payment-status"><?php esc_html_e( 'Payment Status', 'driveease' ); ?></label></th>
				<td>
					<select id="driveease-payment-status" name="_booking_payment_status">
						<?php foreach ( $payment_options as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $payment_status, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Save booking meta box data (only editable fields: status, payment_status).
	 *
	 * @param int $post_id Post ID.
	 */
	public static function save_booking_meta( $post_id ) {
		if ( ! isset( $_POST['driveease_booking_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['driveease_booking_nonce'] ) ), 'driveease_booking_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['_booking_status'] ) ) {
			update_post_meta( $post_id, '_booking_status', sanitize_text_field( wp_unslash( $_POST['_booking_status'] ) ) );
		}

		if ( isset( $_POST['_booking_payment_status'] ) ) {
			update_post_meta( $post_id, '_booking_payment_status', sanitize_text_field( wp_unslash( $_POST['_booking_payment_status'] ) ) );
		}
	}

	/*--------------------------------------------------------------
	 * BRANCH META BOX
	 *------------------------------------------------------------*/

	/**
	 * Render the Branch Details meta box.
	 *
	 * @param \WP_Post $post Current post object.
	 */
	public static function render_branch_meta_box( $post ) {
		wp_nonce_field( 'driveease_branch_meta', 'driveease_branch_nonce' );

		$address       = get_post_meta( $post->ID, '_branch_address', true );
		$phone         = get_post_meta( $post->ID, '_branch_phone', true );
		$email         = get_post_meta( $post->ID, '_branch_email', true );
		$hours_weekday = get_post_meta( $post->ID, '_branch_hours_weekday', true );
		$hours_weekend = get_post_meta( $post->ID, '_branch_hours_weekend', true );
		$is_24h        = get_post_meta( $post->ID, '_branch_is_24h', true );
		$latitude      = get_post_meta( $post->ID, '_branch_latitude', true );
		$longitude     = get_post_meta( $post->ID, '_branch_longitude', true );
		?>

		<style>
			.driveease-branch-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 12px; }
			.driveease-branch-field { flex: 1; min-width: 200px; }
			.driveease-branch-field label { display: block; font-weight: 600; margin-bottom: 4px; }
			.driveease-branch-field input[type="text"],
			.driveease-branch-field input[type="email"] { width: 100%; }
		</style>

		<div class="driveease-branch-row">
			<div class="driveease-branch-field" style="flex: 2;">
				<label for="driveease-branch-address"><?php esc_html_e( 'Address', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-address" name="_branch_address" value="<?php echo esc_attr( $address ); ?>" />
			</div>
		</div>

		<div class="driveease-branch-row">
			<div class="driveease-branch-field">
				<label for="driveease-branch-phone"><?php esc_html_e( 'Phone', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-phone" name="_branch_phone" value="<?php echo esc_attr( $phone ); ?>" />
			</div>
			<div class="driveease-branch-field">
				<label for="driveease-branch-email"><?php esc_html_e( 'Email', 'driveease' ); ?></label>
				<input type="email" id="driveease-branch-email" name="_branch_email" value="<?php echo esc_attr( $email ); ?>" />
			</div>
		</div>

		<div class="driveease-branch-row">
			<div class="driveease-branch-field">
				<label for="driveease-branch-hours-weekday"><?php esc_html_e( 'Hours (Weekday)', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-hours-weekday" name="_branch_hours_weekday" value="<?php echo esc_attr( $hours_weekday ); ?>" placeholder="<?php esc_attr_e( 'e.g. 8:00 AM - 6:00 PM', 'driveease' ); ?>" />
			</div>
			<div class="driveease-branch-field">
				<label for="driveease-branch-hours-weekend"><?php esc_html_e( 'Hours (Weekend)', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-hours-weekend" name="_branch_hours_weekend" value="<?php echo esc_attr( $hours_weekend ); ?>" placeholder="<?php esc_attr_e( 'e.g. 9:00 AM - 4:00 PM', 'driveease' ); ?>" />
			</div>
		</div>

		<div class="driveease-branch-row">
			<div class="driveease-branch-field">
				<label>
					<input type="checkbox" name="_branch_is_24h" value="1" <?php checked( $is_24h ); ?> />
					<?php esc_html_e( 'Open 24 Hours', 'driveease' ); ?>
				</label>
			</div>
		</div>

		<div class="driveease-branch-row">
			<div class="driveease-branch-field">
				<label for="driveease-branch-lat"><?php esc_html_e( 'Latitude', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-lat" name="_branch_latitude" value="<?php echo esc_attr( $latitude ); ?>" placeholder="<?php esc_attr_e( 'e.g. 40.7128', 'driveease' ); ?>" />
			</div>
			<div class="driveease-branch-field">
				<label for="driveease-branch-lng"><?php esc_html_e( 'Longitude', 'driveease' ); ?></label>
				<input type="text" id="driveease-branch-lng" name="_branch_longitude" value="<?php echo esc_attr( $longitude ); ?>" placeholder="<?php esc_attr_e( 'e.g. -74.0060', 'driveease' ); ?>" />
			</div>
		</div>
		<?php
	}

	/**
	 * Save branch meta box data.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function save_branch_meta( $post_id ) {
		if ( ! isset( $_POST['driveease_branch_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['driveease_branch_nonce'] ) ), 'driveease_branch_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// String fields.
		$string_fields = array(
			'_branch_address',
			'_branch_phone',
			'_branch_hours_weekday',
			'_branch_hours_weekend',
			'_branch_latitude',
			'_branch_longitude',
		);

		foreach ( $string_fields as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}

		// Email field.
		if ( isset( $_POST['_branch_email'] ) ) {
			update_post_meta( $post_id, '_branch_email', sanitize_email( wp_unslash( $_POST['_branch_email'] ) ) );
		}

		// Boolean.
		update_post_meta( $post_id, '_branch_is_24h', ! empty( $_POST['_branch_is_24h'] ) );
	}
	/*--------------------------------------------------------------
	 * BOOKING LIST-TABLE COLUMNS
	 *------------------------------------------------------------*/

	/**
	 * Define custom columns for the Bookings list table.
	 *
	 * @param array $columns Default columns.
	 * @return array
	 */
	public static function booking_columns( $columns ) {
		$new = array();
		$new['cb']                    = $columns['cb'];
		$new['booking_reference']     = esc_html__( 'Reference', 'driveease' );
		$new['booking_car']           = esc_html__( 'Car', 'driveease' );
		$new['booking_customer']      = esc_html__( 'Customer', 'driveease' );
		$new['booking_pickup_date']   = esc_html__( 'Pickup Date', 'driveease' );
		$new['booking_dropoff_date']  = esc_html__( 'Dropoff Date', 'driveease' );
		$new['booking_status']        = esc_html__( 'Status', 'driveease' );
		$new['booking_total']         = esc_html__( 'Total', 'driveease' );
		return $new;
	}

	/**
	 * Render custom column content for Bookings.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public static function booking_column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'booking_reference':
				echo esc_html( get_post_meta( $post_id, '_booking_reference', true ) );
				break;

			case 'booking_car':
				$car_id = (int) get_post_meta( $post_id, '_booking_car_id', true );
				if ( $car_id ) {
					$car = get_post( $car_id );
					if ( $car ) {
						printf(
							'<a href="%s">%s</a>',
							esc_url( get_edit_post_link( $car_id ) ),
							esc_html( $car->post_title )
						);
					} else {
						echo esc_html( '#' . $car_id );
					}
				} else {
					echo '&mdash;';
				}
				break;

			case 'booking_customer':
				echo esc_html( get_post_meta( $post_id, '_booking_customer_name', true ) );
				break;

			case 'booking_pickup_date':
				echo esc_html( get_post_meta( $post_id, '_booking_pickup_date', true ) );
				break;

			case 'booking_dropoff_date':
				echo esc_html( get_post_meta( $post_id, '_booking_dropoff_date', true ) );
				break;

			case 'booking_status':
				$status = get_post_meta( $post_id, '_booking_status', true );
				$colors = array(
					'pending'   => '#f0ad4e',
					'confirmed' => '#5bc0de',
					'active'    => '#0275d8',
					'completed' => '#5cb85c',
					'cancelled' => '#d9534f',
				);
				$color = isset( $colors[ $status ] ) ? $colors[ $status ] : '#999';
				$label = ucfirst( $status );
				printf(
					'<span style="display:inline-block;padding:3px 10px;border-radius:3px;color:#fff;background:%s;font-size:12px;">%s</span>',
					esc_attr( $color ),
					esc_html( $label )
				);
				break;

			case 'booking_total':
				$total    = get_post_meta( $post_id, '_booking_total_price', true );
				$currency = get_post_meta( $post_id, '_booking_currency', true );
				if ( $total ) {
					echo esc_html( number_format( (float) $total, 2 ) );
					if ( $currency ) {
						echo ' ' . esc_html( $currency );
					}
				} else {
					echo '&mdash;';
				}
				break;
		}
	}

	/**
	 * Make pickup date, dropoff date, and status columns sortable.
	 *
	 * @param array $columns Sortable columns.
	 * @return array
	 */
	public static function booking_sortable_columns( $columns ) {
		$columns['booking_pickup_date']  = 'booking_pickup_date';
		$columns['booking_dropoff_date'] = 'booking_dropoff_date';
		$columns['booking_status']       = 'booking_status';
		return $columns;
	}

	/**
	 * Handle orderby for custom sortable columns.
	 *
	 * @param \WP_Query $query Current query.
	 */
	public static function booking_columns_orderby( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( 'driveease_booking' !== $query->get( 'post_type' ) ) {
			return;
		}

		$orderby = $query->get( 'orderby' );

		if ( 'booking_pickup_date' === $orderby ) {
			$query->set( 'meta_key', '_booking_pickup_date' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'booking_dropoff_date' === $orderby ) {
			$query->set( 'meta_key', '_booking_dropoff_date' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'booking_status' === $orderby ) {
			$query->set( 'meta_key', '_booking_status' );
			$query->set( 'orderby', 'meta_value' );
		}
	}

	/*--------------------------------------------------------------
	 * QUICK ROW ACTIONS
	 *------------------------------------------------------------*/

	/**
	 * Add Confirm / Complete / Cancel quick actions to booking rows.
	 *
	 * @param array    $actions Existing row actions.
	 * @param \WP_Post $post    Current post.
	 * @return array
	 */
	public static function booking_row_actions( $actions, $post ) {
		if ( 'driveease_booking' !== $post->post_type ) {
			return $actions;
		}

		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $actions;
		}

		$status     = get_post_meta( $post->ID, '_booking_status', true );
		$base_url   = admin_url( 'edit.php?post_type=driveease_booking' );

		$transitions = array(
			'pending'   => array( 'confirm' => __( 'Confirm', 'driveease' ) ),
			'confirmed' => array( 'complete' => __( 'Complete', 'driveease' ) ),
			'active'    => array( 'complete' => __( 'Complete', 'driveease' ) ),
		);

		if ( isset( $transitions[ $status ] ) ) {
			foreach ( $transitions[ $status ] as $action_key => $label ) {
				$url = wp_nonce_url(
					add_query_arg(
						array(
							'driveease_action' => $action_key,
							'booking_id'       => $post->ID,
						),
						$base_url
					),
					'driveease_booking_action_' . $post->ID
				);
				$actions[ 'driveease_' . $action_key ] = sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
			}
		}

		// Cancel is available for all non-completed, non-cancelled statuses.
		if ( ! in_array( $status, array( 'completed', 'cancelled' ), true ) ) {
			$url = wp_nonce_url(
				add_query_arg(
					array(
						'driveease_action' => 'cancel',
						'booking_id'       => $post->ID,
					),
					$base_url
				),
				'driveease_booking_action_' . $post->ID
			);
			$actions['driveease_cancel'] = sprintf(
				'<a href="%s" style="color:#a00;">%s</a>',
				esc_url( $url ),
				esc_html__( 'Cancel', 'driveease' )
			);
		}

		return $actions;
	}

	/**
	 * Process quick row action for bookings.
	 */
	public static function handle_booking_row_action() {
		if ( empty( $_GET['driveease_action'] ) || empty( $_GET['booking_id'] ) ) {
			return;
		}

		$action     = sanitize_text_field( wp_unslash( $_GET['driveease_action'] ) );
		$booking_id = absint( $_GET['booking_id'] );

		if ( ! in_array( $action, array( 'confirm', 'complete', 'cancel' ), true ) ) {
			return;
		}

		check_admin_referer( 'driveease_booking_action_' . $booking_id );

		if ( ! current_user_can( 'edit_post', $booking_id ) ) {
			wp_die( esc_html__( 'You do not have permission to perform this action.', 'driveease' ) );
		}

		$status_map = array(
			'confirm'  => 'confirmed',
			'complete' => 'completed',
			'cancel'   => 'cancelled',
		);

		update_post_meta( $booking_id, '_booking_status', $status_map[ $action ] );

		wp_safe_redirect( admin_url( 'edit.php?post_type=driveease_booking&driveease_updated=1' ) );
		exit;
	}

	/*--------------------------------------------------------------
	 * DASHBOARD WIDGET
	 *------------------------------------------------------------*/

	/**
	 * Register DriveEase dashboard widget.
	 */
	public static function register_dashboard_widget() {
		wp_add_dashboard_widget(
			'driveease_dashboard_overview',
			esc_html__( 'DriveEase — Today\'s Overview', 'driveease' ),
			array( __CLASS__, 'render_dashboard_widget' )
		);
	}

	/**
	 * Render the dashboard widget content.
	 */
	public static function render_dashboard_widget() {
		$today     = wp_date( 'Y-m-d' );
		$week_start = wp_date( 'Y-m-d', strtotime( 'monday this week' ) );
		$week_end   = wp_date( 'Y-m-d', strtotime( 'sunday this week' ) );

		// Today's pickups.
		$pickups = get_posts(
			array(
				'post_type'      => 'driveease_booking',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_booking_pickup_date',
						'value'   => $today,
						'compare' => 'LIKE',
					),
					array(
						'key'     => '_booking_status',
						'value'   => array( 'confirmed', 'active' ),
						'compare' => 'IN',
					),
				),
			)
		);

		// Today's returns.
		$returns = get_posts(
			array(
				'post_type'      => 'driveease_booking',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_booking_dropoff_date',
						'value'   => $today,
						'compare' => 'LIKE',
					),
					array(
						'key'     => '_booking_status',
						'value'   => array( 'confirmed', 'active' ),
						'compare' => 'IN',
					),
				),
			)
		);

		// Pending bookings.
		$pending = get_posts(
			array(
				'post_type'      => 'driveease_booking',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => '_booking_status',
						'value' => 'pending',
					),
				),
			)
		);

		// Week revenue.
		$week_bookings = get_posts(
			array(
				'post_type'      => 'driveease_booking',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_booking_pickup_date',
						'value'   => array( $week_start, $week_end ),
						'compare' => 'BETWEEN',
						'type'    => 'DATE',
					),
					array(
						'key'     => '_booking_status',
						'value'   => array( 'confirmed', 'active', 'completed' ),
						'compare' => 'IN',
					),
				),
			)
		);

		$week_revenue = 0;
		foreach ( $week_bookings as $wb ) {
			$week_revenue += (float) get_post_meta( $wb->ID, '_booking_total_price', true );
		}
		?>
		<style>
			.driveease-dash-stats { display: flex; gap: 12px; margin-bottom: 16px; }
			.driveease-dash-stat { flex: 1; text-align: center; background: #f6f7f7; padding: 12px 8px; border-radius: 4px; }
			.driveease-dash-stat .num { font-size: 24px; font-weight: 700; display: block; }
			.driveease-dash-stat .lbl { font-size: 11px; color: #666; text-transform: uppercase; }
			.driveease-dash-list { margin: 0; padding: 0; list-style: none; }
			.driveease-dash-list li { padding: 6px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; }
			.driveease-dash-list li:last-child { border-bottom: none; }
		</style>

		<div class="driveease-dash-stats">
			<div class="driveease-dash-stat">
				<span class="num"><?php echo count( $pickups ); ?></span>
				<span class="lbl"><?php esc_html_e( 'Pickups Today', 'driveease' ); ?></span>
			</div>
			<div class="driveease-dash-stat">
				<span class="num"><?php echo count( $returns ); ?></span>
				<span class="lbl"><?php esc_html_e( 'Returns Today', 'driveease' ); ?></span>
			</div>
			<div class="driveease-dash-stat">
				<span class="num"><?php echo count( $pending ); ?></span>
				<span class="lbl"><?php esc_html_e( 'Pending', 'driveease' ); ?></span>
			</div>
			<div class="driveease-dash-stat">
				<span class="num">$<?php echo esc_html( number_format( $week_revenue, 2 ) ); ?></span>
				<span class="lbl"><?php esc_html_e( 'Week Revenue', 'driveease' ); ?></span>
			</div>
		</div>

		<?php if ( $pickups ) : ?>
			<h4 style="margin: 0 0 4px;"><?php esc_html_e( 'Pickups Today', 'driveease' ); ?></h4>
			<ul class="driveease-dash-list">
				<?php foreach ( $pickups as $p ) : ?>
					<li>
						<a href="<?php echo esc_url( get_edit_post_link( $p->ID ) ); ?>">
							<?php echo esc_html( get_post_meta( $p->ID, '_booking_reference', true ) ); ?>
						</a>
						<span><?php echo esc_html( get_post_meta( $p->ID, '_booking_customer_name', true ) ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $returns ) : ?>
			<h4 style="margin: 12px 0 4px;"><?php esc_html_e( 'Returns Today', 'driveease' ); ?></h4>
			<ul class="driveease-dash-list">
				<?php foreach ( $returns as $r ) : ?>
					<li>
						<a href="<?php echo esc_url( get_edit_post_link( $r->ID ) ); ?>">
							<?php echo esc_html( get_post_meta( $r->ID, '_booking_reference', true ) ); ?>
						</a>
						<span><?php echo esc_html( get_post_meta( $r->ID, '_booking_customer_name', true ) ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( ! $pickups && ! $returns ) : ?>
			<p style="color:#666;"><?php esc_html_e( 'No pickups or returns scheduled for today.', 'driveease' ); ?></p>
		<?php endif; ?>
		<?php
	}

	/*--------------------------------------------------------------
	 * CSV EXPORT
	 *------------------------------------------------------------*/

	/**
	 * Register the CSV Export sub-menu page under Bookings.
	 */
	public static function register_csv_export_page() {
		add_submenu_page(
			'edit.php?post_type=driveease_booking',
			esc_html__( 'Export Bookings', 'driveease' ),
			esc_html__( 'CSV Export', 'driveease' ),
			'edit_posts',
			'driveease-csv-export',
			array( __CLASS__, 'render_csv_export_page' )
		);
	}

	/**
	 * Render the CSV export page with date range filter.
	 */
	public static function render_csv_export_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Export Bookings to CSV', 'driveease' ); ?></h1>

			<form method="post" action="">
				<?php wp_nonce_field( 'driveease_csv_export', 'driveease_csv_nonce' ); ?>

				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="driveease-csv-from"><?php esc_html_e( 'From Date', 'driveease' ); ?></label>
						</th>
						<td>
							<input type="date" id="driveease-csv-from" name="driveease_csv_from" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="driveease-csv-to"><?php esc_html_e( 'To Date', 'driveease' ); ?></label>
						</th>
						<td>
							<input type="date" id="driveease-csv-to" name="driveease_csv_to" class="regular-text" />
						</td>
					</tr>
				</table>

				<p class="description">
					<?php esc_html_e( 'Leave dates empty to export all bookings. Filters by pickup date.', 'driveease' ); ?>
				</p>

				<?php submit_button( esc_html__( 'Download CSV', 'driveease' ), 'primary', 'driveease_csv_submit' ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Handle CSV export form submission — streams file to browser.
	 */
	public static function handle_csv_export() {
		if ( empty( $_POST['driveease_csv_submit'] ) ) {
			return;
		}

		if ( ! isset( $_POST['driveease_csv_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['driveease_csv_nonce'] ) ), 'driveease_csv_export' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$from = ! empty( $_POST['driveease_csv_from'] ) ? sanitize_text_field( wp_unslash( $_POST['driveease_csv_from'] ) ) : '';
		$to   = ! empty( $_POST['driveease_csv_to'] ) ? sanitize_text_field( wp_unslash( $_POST['driveease_csv_to'] ) ) : '';

		$args = array(
			'post_type'      => 'driveease_booking',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		if ( $from || $to ) {
			$meta_query = array();
			if ( $from && $to ) {
				$meta_query[] = array(
					'key'     => '_booking_pickup_date',
					'value'   => array( $from, $to ),
					'compare' => 'BETWEEN',
					'type'    => 'DATE',
				);
			} elseif ( $from ) {
				$meta_query[] = array(
					'key'     => '_booking_pickup_date',
					'value'   => $from,
					'compare' => '>=',
					'type'    => 'DATE',
				);
			} else {
				$meta_query[] = array(
					'key'     => '_booking_pickup_date',
					'value'   => $to,
					'compare' => '<=',
					'type'    => 'DATE',
				);
			}
			$args['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		}

		$bookings = get_posts( $args );

		$filename = 'driveease-bookings-' . wp_date( 'Y-m-d' ) . '.csv';

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$output = fopen( 'php://output', 'w' );

		// Header row.
		fputcsv(
			$output,
			array(
				__( 'Reference', 'driveease' ),
				__( 'Car', 'driveease' ),
				__( 'Customer Name', 'driveease' ),
				__( 'Customer Email', 'driveease' ),
				__( 'Customer Phone', 'driveease' ),
				__( 'Pickup Location', 'driveease' ),
				__( 'Pickup Date', 'driveease' ),
				__( 'Dropoff Location', 'driveease' ),
				__( 'Dropoff Date', 'driveease' ),
				__( 'Extras', 'driveease' ),
				__( 'Total Price', 'driveease' ),
				__( 'Currency', 'driveease' ),
				__( 'Status', 'driveease' ),
				__( 'Payment Status', 'driveease' ),
			)
		);

		foreach ( $bookings as $booking ) {
			$car_id    = (int) get_post_meta( $booking->ID, '_booking_car_id', true );
			$car_title = '';
			if ( $car_id ) {
				$car = get_post( $car_id );
				if ( $car ) {
					$car_title = $car->post_title;
				}
			}

			fputcsv(
				$output,
				array(
					get_post_meta( $booking->ID, '_booking_reference', true ),
					$car_title,
					get_post_meta( $booking->ID, '_booking_customer_name', true ),
					get_post_meta( $booking->ID, '_booking_customer_email', true ),
					get_post_meta( $booking->ID, '_booking_customer_phone', true ),
					get_post_meta( $booking->ID, '_booking_pickup_location', true ),
					get_post_meta( $booking->ID, '_booking_pickup_date', true ),
					get_post_meta( $booking->ID, '_booking_dropoff_location', true ),
					get_post_meta( $booking->ID, '_booking_dropoff_date', true ),
					get_post_meta( $booking->ID, '_booking_extras', true ),
					get_post_meta( $booking->ID, '_booking_total_price', true ),
					get_post_meta( $booking->ID, '_booking_currency', true ),
					get_post_meta( $booking->ID, '_booking_status', true ),
					get_post_meta( $booking->ID, '_booking_payment_status', true ),
				)
			);
		}

		fclose( $output );
		exit;
	}
}

DriveEase_Admin::init();
