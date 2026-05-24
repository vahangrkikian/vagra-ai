<?php
/**
 * DriveEase Reviews — star-rating system built on WordPress comments.
 *
 * @package DriveEase
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Reviews
 */
class DriveEase_Reviews {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'comment_post', array( __CLASS__, 'save_rating' ), 10, 3 );
		add_filter( 'preprocess_comment', array( __CLASS__, 'validate_rating' ) );
		add_action( 'wp_ajax_driveease_submit_review', array( __CLASS__, 'ajax_submit_review' ) );
	}

	/**
	 * Check whether a user has completed a booking for a given car.
	 *
	 * @param int $car_id  Car post ID.
	 * @param int $user_id WordPress user ID.
	 * @return bool
	 */
	public static function user_can_review( $car_id, $user_id = 0 ) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		if ( ! $user_id ) {
			return false;
		}

		$user  = get_userdata( $user_id );
		$email = $user ? $user->user_email : '';
		if ( ! $email ) {
			return false;
		}

		$bookings = get_posts( array(
			'post_type'      => 'driveease_booking',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => '_booking_car_id',
					'value'   => $car_id,
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
				array(
					'key'     => '_booking_status',
					'value'   => 'completed',
					'compare' => '=',
				),
				array(
					'key'     => '_booking_customer_email',
					'value'   => $email,
					'compare' => '=',
				),
			),
		) );

		return ! empty( $bookings );
	}

	/**
	 * Check if a user has already reviewed a car.
	 *
	 * @param int $car_id  Car post ID.
	 * @param int $user_id WordPress user ID.
	 * @return bool
	 */
	public static function user_has_reviewed( $car_id, $user_id = 0 ) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		if ( ! $user_id ) {
			return false;
		}

		$existing = get_comments( array(
			'post_id' => $car_id,
			'user_id' => $user_id,
			'count'   => true,
		) );

		return $existing > 0;
	}

	/**
	 * Validate that a star rating is present for car comments.
	 *
	 * @param array $commentdata Comment data.
	 * @return array
	 */
	public static function validate_rating( $commentdata ) {
		if ( isset( $commentdata['comment_post_ID'] ) && 'driveease_car' === get_post_type( $commentdata['comment_post_ID'] ) ) {
			if ( empty( $_POST['driveease_rating'] ) || (int) $_POST['driveease_rating'] < 1 || (int) $_POST['driveease_rating'] > 5 ) {
				wp_die(
					esc_html__( 'Please select a star rating between 1 and 5.', 'driveease' ),
					esc_html__( 'Rating Required', 'driveease' ),
					array( 'back_link' => true )
				);
			}
		}
		return $commentdata;
	}

	/**
	 * Save the star rating as comment meta after a comment is inserted.
	 *
	 * @param int        $comment_id       Comment ID.
	 * @param int|string $comment_approved  1 if approved, 0 if not, 'spam' if spam.
	 * @param array      $commentdata       Comment data.
	 */
	public static function save_rating( $comment_id, $comment_approved, $commentdata ) {
		if ( isset( $_POST['driveease_rating'] ) && 'driveease_car' === get_post_type( $commentdata['comment_post_ID'] ) ) {
			$rating = max( 1, min( 5, (int) $_POST['driveease_rating'] ) );
			update_comment_meta( $comment_id, '_review_rating', $rating );
			// Bust cached average.
			delete_post_meta( $commentdata['comment_post_ID'], '_reviews_avg_rating' );
			delete_post_meta( $commentdata['comment_post_ID'], '_reviews_count' );
		}
	}

	/**
	 * AJAX handler for review submission.
	 */
	public static function ajax_submit_review() {
		check_ajax_referer( 'driveease_review_nonce', 'nonce' );

		$car_id  = isset( $_POST['car_id'] ) ? absint( $_POST['car_id'] ) : 0;
		$rating  = isset( $_POST['driveease_rating'] ) ? absint( $_POST['driveease_rating'] ) : 0;
		$comment = isset( $_POST['comment'] ) ? sanitize_textarea_field( wp_unslash( $_POST['comment'] ) ) : '';

		if ( ! $car_id || 'driveease_car' !== get_post_type( $car_id ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid car.', 'driveease' ) ) );
		}

		if ( $rating < 1 || $rating > 5 ) {
			wp_send_json_error( array( 'message' => __( 'Please select a rating between 1 and 5.', 'driveease' ) ) );
		}

		if ( empty( $comment ) ) {
			wp_send_json_error( array( 'message' => __( 'Please write a review comment.', 'driveease' ) ) );
		}

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			wp_send_json_error( array( 'message' => __( 'You must be logged in to submit a review.', 'driveease' ) ) );
		}

		if ( ! self::user_can_review( $car_id, $user_id ) ) {
			wp_send_json_error( array( 'message' => __( 'Only customers who have completed a booking for this car can leave a review.', 'driveease' ) ) );
		}

		if ( self::user_has_reviewed( $car_id, $user_id ) ) {
			wp_send_json_error( array( 'message' => __( 'You have already reviewed this car.', 'driveease' ) ) );
		}

		$user = get_userdata( $user_id );

		$comment_id = wp_insert_comment( array(
			'comment_post_ID' => $car_id,
			'comment_content'  => $comment,
			'comment_author'   => $user->display_name,
			'comment_author_email' => $user->user_email,
			'user_id'          => $user_id,
			'comment_approved' => 1,
		) );

		if ( ! $comment_id ) {
			wp_send_json_error( array( 'message' => __( 'Failed to submit review. Please try again.', 'driveease' ) ) );
		}

		update_comment_meta( $comment_id, '_review_rating', $rating );
		delete_post_meta( $car_id, '_reviews_avg_rating' );
		delete_post_meta( $car_id, '_reviews_count' );

		wp_send_json_success( array(
			'message' => __( 'Thank you for your review!', 'driveease' ),
		) );
	}

	/**
	 * Get average rating for a car.
	 *
	 * @param int $car_id Car post ID.
	 * @return float Average rating (0 if no reviews).
	 */
	public static function get_average_rating( $car_id ) {
		$cached = get_post_meta( $car_id, '_reviews_avg_rating', true );
		if ( '' !== $cached ) {
			return (float) $cached;
		}

		$comments = get_approved_comments( $car_id );
		if ( empty( $comments ) ) {
			update_post_meta( $car_id, '_reviews_avg_rating', 0 );
			update_post_meta( $car_id, '_reviews_count', 0 );
			return 0;
		}

		$total = 0;
		$count = 0;
		foreach ( $comments as $c ) {
			$r = get_comment_meta( $c->comment_ID, '_review_rating', true );
			if ( $r ) {
				$total += (int) $r;
				$count++;
			}
		}

		$avg = $count > 0 ? round( $total / $count, 1 ) : 0;
		update_post_meta( $car_id, '_reviews_avg_rating', $avg );
		update_post_meta( $car_id, '_reviews_count', $count );

		return $avg;
	}

	/**
	 * Get review count for a car.
	 *
	 * @param int $car_id Car post ID.
	 * @return int
	 */
	public static function get_review_count( $car_id ) {
		$cached = get_post_meta( $car_id, '_reviews_count', true );
		if ( '' !== $cached ) {
			return (int) $cached;
		}
		// Calling get_average_rating populates both caches.
		self::get_average_rating( $car_id );
		return (int) get_post_meta( $car_id, '_reviews_count', true );
	}

	/**
	 * Render star icons for a given rating.
	 *
	 * @param float $rating  The rating value.
	 * @param bool  $echo    Whether to echo or return.
	 * @return string HTML output.
	 */
	public static function render_stars( $rating, $echo = true ) {
		$html  = '<span class="driveease-stars" aria-label="' . esc_attr( sprintf( __( '%s out of 5 stars', 'driveease' ), $rating ) ) . '">';
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( $rating >= $i ) {
				$html .= '<i class="fa-solid fa-star"></i>';
			} elseif ( $rating >= $i - 0.5 ) {
				$html .= '<i class="fa-solid fa-star-half-stroke"></i>';
			} else {
				$html .= '<i class="fa-regular fa-star"></i>';
			}
		}
		$html .= '</span>';

		if ( $echo ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return $html;
	}
}

DriveEase_Reviews::init();
