<?php
/**
 * Tour Reviews — star-rating extension for WordPress comments on vagra_tour.
 *
 * - Adds _review_rating comment meta (1-5)
 * - Saves rating on comment submit
 * - Recalculates average rating → updates _tour_rating post meta
 * - Provides helper functions for templates
 * - Admin column for rating in comments list
 *
 * @package TourVice_Core
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TourVice_Reviews {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		/* Front-end: inject star field into comment form */
		add_filter( 'comment_form_fields', array( __CLASS__, 'add_rating_field' ) );

		/* Save rating when comment is posted */
		add_action( 'comment_post', array( __CLASS__, 'save_rating' ), 10, 2 );

		/* Recalculate average after insert, status change, or delete */
		add_action( 'comment_post',             array( __CLASS__, 'recalculate_average' ), 20 );
		add_action( 'wp_set_comment_status',    array( __CLASS__, 'recalculate_on_status' ), 10, 2 );
		add_action( 'delete_comment',           array( __CLASS__, 'recalculate_on_delete' ), 10, 2 );
		add_action( 'edit_comment',             array( __CLASS__, 'recalculate_average' ) );

		/* Admin: show rating in comments table */
		add_filter( 'manage_edit-comments_columns',       array( __CLASS__, 'admin_column' ) );
		add_action( 'manage_comments_custom_column',      array( __CLASS__, 'admin_column_content' ), 10, 2 );

		/* Admin: rating field in comment edit screen */
		add_action( 'add_meta_boxes_comment', array( __CLASS__, 'comment_meta_box' ) );
		add_action( 'edit_comment',           array( __CLASS__, 'save_admin_rating' ) );

		/* Enqueue front-end review CSS/JS */
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/* ================================================================
	   FRONT-END: Star Field in Comment Form
	   ================================================================ */

	/**
	 * Inject a star-rating field before the comment textarea.
	 *
	 * @param array $fields Comment form fields.
	 * @return array
	 */
	public static function add_rating_field( $fields ) {
		if ( ! is_singular( 'vagra_tour' ) ) {
			return $fields;
		}

		$star_field = '<div class="tourvice-review-rating-field">'
			. '<label>' . esc_html__( 'Your Rating', 'tourvice' ) . ' <span class="required">*</span></label>'
			. '<div class="tourvice-star-input" id="tourvice-star-input">';

		for ( $i = 1; $i <= 5; $i++ ) {
			$star_field .= sprintf(
				'<button type="button" class="tourvice-star-input__star" data-value="%1$d" aria-label="%2$s">'
				. '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">'
				. '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'
				. '</svg>'
				. '</button>',
				$i,
				/* translators: %d: number of stars */
				sprintf( esc_attr__( '%d stars', 'tourvice' ), $i )
			);
		}

		$star_field .= '</div>'
			. '<input type="hidden" name="tourvice_rating" id="tourvice-rating-value" value="" />'
			. '<p class="tourvice-star-input__error" id="tourvice-rating-error" hidden>'
			. esc_html__( 'Please select a rating', 'tourvice' )
			. '</p>'
			. '</div>';

		/* Insert rating field before the comment textarea */
		$new_fields = array();
		foreach ( $fields as $key => $field ) {
			if ( 'comment' === $key ) {
				$new_fields['rating'] = $star_field;
			}
			$new_fields[ $key ] = $field;
		}

		return $new_fields;
	}

	/* ================================================================
	   SAVE RATING
	   ================================================================ */

	/**
	 * Save the star rating as comment meta.
	 *
	 * @param int        $comment_id Comment ID.
	 * @param int|string $approved   Approval status.
	 */
	public static function save_rating( $comment_id, $approved ) {
		if ( ! isset( $_POST['tourvice_rating'] ) ) {
			return;
		}

		$rating = absint( $_POST['tourvice_rating'] );
		if ( $rating < 1 || $rating > 5 ) {
			return;
		}

		update_comment_meta( $comment_id, '_review_rating', $rating );
	}

	/* ================================================================
	   RECALCULATE AVERAGE
	   ================================================================ */

	/**
	 * Recalculate and store the average rating on the tour post.
	 *
	 * @param int $comment_id Comment ID.
	 */
	public static function recalculate_average( $comment_id ) {
		$comment = get_comment( $comment_id );
		if ( ! $comment ) {
			return;
		}

		self::update_tour_rating( $comment->comment_post_ID );
	}

	/**
	 * Recalculate on status change.
	 *
	 * @param int    $comment_id Comment ID.
	 * @param string $status     New status.
	 */
	public static function recalculate_on_status( $comment_id, $status ) {
		self::recalculate_average( $comment_id );
	}

	/**
	 * Recalculate when a comment is deleted.
	 *
	 * @param int        $comment_id Comment ID.
	 * @param WP_Comment $comment    Comment object.
	 */
	public static function recalculate_on_delete( $comment_id, $comment ) {
		if ( $comment ) {
			self::update_tour_rating( $comment->comment_post_ID );
		}
	}

	/**
	 * Calculate average from approved comments and update post meta.
	 *
	 * @param int $post_id Tour post ID.
	 */
	public static function update_tour_rating( $post_id ) {
		if ( get_post_type( $post_id ) !== 'vagra_tour' ) {
			return;
		}

		$comments = get_comments( array(
			'post_id' => $post_id,
			'status'  => 'approve',
			'type'    => 'comment',
		) );

		$total  = 0;
		$count  = 0;

		foreach ( $comments as $c ) {
			$r = (int) get_comment_meta( $c->comment_ID, '_review_rating', true );
			if ( $r >= 1 && $r <= 5 ) {
				$total += $r;
				$count++;
			}
		}

		if ( $count > 0 ) {
			$avg = round( $total / $count, 1 );
			update_post_meta( $post_id, '_tour_rating', $avg );
			update_post_meta( $post_id, '_tour_review_count', $count );
		}
	}

	/* ================================================================
	   HELPERS (for templates)
	   ================================================================ */

	/**
	 * Get the review count for a tour.
	 *
	 * @param int $post_id Tour post ID.
	 * @return int
	 */
	public static function get_review_count( $post_id = 0 ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$count = get_post_meta( $post_id, '_tour_review_count', true );
		return $count ? (int) $count : 0;
	}

	/**
	 * Render star icons for a given rating.
	 *
	 * @param float $rating Rating value (1-5).
	 * @param bool  $echo   Whether to echo or return.
	 * @return string|void
	 */
	public static function render_stars( $rating, $echo = true ) {
		$rating = floatval( $rating );
		$html   = '<span class="tourvice-stars" aria-label="' . esc_attr( sprintf( __( '%s out of 5 stars', 'tourvice' ), $rating ) ) . '">';

		for ( $i = 1; $i <= 5; $i++ ) {
			if ( $i <= floor( $rating ) ) {
				$fill = 'var(--sage-500, #7aaa7a)';
				$cls  = 'tourvice-stars__star--full';
			} elseif ( $i - $rating < 1 && $i - $rating > 0 ) {
				$fill = 'var(--sage-300, #c0d5c0)';
				$cls  = 'tourvice-stars__star--half';
			} else {
				$fill = 'var(--earth-200, #e8dcd2)';
				$cls  = 'tourvice-stars__star--empty';
			}

			$html .= '<svg class="tourvice-stars__star ' . $cls . '" width="16" height="16" viewBox="0 0 24 24" fill="' . $fill . '" stroke="none">'
				. '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'
				. '</svg>';
		}

		$html .= '</span>';

		if ( $echo ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — SVG is hardcoded
		}
		return $html;
	}

	/* ================================================================
	   ADMIN
	   ================================================================ */

	/**
	 * Add Rating column to comments admin table.
	 */
	public static function admin_column( $columns ) {
		$columns['tour_rating'] = __( 'Rating', 'tourvice' );
		return $columns;
	}

	/**
	 * Display rating in admin column.
	 */
	public static function admin_column_content( $column, $comment_id ) {
		if ( 'tour_rating' !== $column ) {
			return;
		}
		$rating = get_comment_meta( $comment_id, '_review_rating', true );
		if ( $rating ) {
			echo str_repeat( '&#11088;', (int) $rating );
		} else {
			echo '&mdash;';
		}
	}

	/**
	 * Add meta box to comment edit screen.
	 */
	public static function comment_meta_box() {
		add_meta_box(
			'tourvice_review_rating',
			__( 'Tour Rating', 'tourvice' ),
			array( __CLASS__, 'render_comment_meta_box' ),
			'comment',
			'normal'
		);
	}

	/**
	 * Render the comment meta box.
	 *
	 * @param WP_Comment $comment The comment object.
	 */
	public static function render_comment_meta_box( $comment ) {
		$rating = get_comment_meta( $comment->comment_ID, '_review_rating', true );
		wp_nonce_field( 'tourvice_review_rating', 'tourvice_review_nonce' );
		?>
		<label for="tourvice-admin-rating"><?php esc_html_e( 'Stars (1-5):', 'tourvice' ); ?></label>
		<input type="number" id="tourvice-admin-rating" name="tourvice_admin_rating"
			value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" step="1" style="width: 60px;" />
		<?php
	}

	/**
	 * Save rating from admin comment edit.
	 *
	 * @param int $comment_id Comment ID.
	 */
	public static function save_admin_rating( $comment_id ) {
		if ( ! isset( $_POST['tourvice_review_nonce'] ) ||
			! wp_verify_nonce( $_POST['tourvice_review_nonce'], 'tourvice_review_rating' ) ) {
			return;
		}

		if ( isset( $_POST['tourvice_admin_rating'] ) ) {
			$rating = absint( $_POST['tourvice_admin_rating'] );
			if ( $rating >= 1 && $rating <= 5 ) {
				update_comment_meta( $comment_id, '_review_rating', $rating );
			}
		}
	}

	/* ================================================================
	   ASSETS
	   ================================================================ */

	/**
	 * Enqueue review CSS/JS on single tour pages.
	 */
	public static function enqueue_assets() {
		if ( ! is_singular( 'vagra_tour' ) ) {
			return;
		}

		wp_enqueue_style(
			'tourvice-reviews',
			TOURVICE_CORE_URL . 'assets/css/reviews.css',
			array(),
			TOURVICE_CORE_VERSION
		);

		wp_enqueue_script(
			'tourvice-reviews',
			TOURVICE_CORE_URL . 'assets/js/reviews.js',
			array(),
			TOURVICE_CORE_VERSION,
			true
		);
	}
}

TourVice_Reviews::init();
