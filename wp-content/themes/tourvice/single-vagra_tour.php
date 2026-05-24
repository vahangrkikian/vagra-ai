<?php
/**
 * Single: vagra_tour (Tour Detail)
 *
 * Hero image, overview, highlights, itinerary, booking sidebar.
 * Converts TourDetail.jsx.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$tour_id       = get_the_ID();
	$tour_price    = get_post_meta( $tour_id, '_tour_price', true );
	$tour_rating   = get_post_meta( $tour_id, '_tour_rating', true );
	$tour_duration = get_post_meta( $tour_id, '_tour_duration', true );
	$tour_group_min = (int) get_post_meta( $tour_id, '_tour_group_min', true );
	$tour_group_max = (int) get_post_meta( $tour_id, '_tour_group_max', true );
	$tour_discount = (float) get_post_meta( $tour_id, '_tour_discount', true );
	$tour_highlights = get_post_meta( $tour_id, '_tour_highlights', true );
	$tour_itinerary  = get_post_meta( $tour_id, '_tour_itinerary', true );

	/* Price numeric */
	$price_numeric = (float) preg_replace( '/[^0-9.]/', '', $tour_price );
	$price_display = $tour_price ? '$' . number_format( $price_numeric ) : '';

	/* Group size display */
	$group_display = '';
	if ( $tour_group_min && $tour_group_max ) {
		$group_display = $tour_group_min . '-' . $tour_group_max . ' ' . __( 'people', 'tourvice' );
	} elseif ( $tour_group_max ) {
		$group_display = __( 'Up to', 'tourvice' ) . ' ' . $tour_group_max . ' ' . __( 'people', 'tourvice' );
	}

	/* Location */
	$location_terms = get_the_terms( $tour_id, 'tour_location' );
	$location_name  = '';
	if ( $location_terms && ! is_wp_error( $location_terms ) ) {
		$location_name = $location_terms[0]->name;
	}

	/* Highlights: stored as newline-separated string or serialized array */
	if ( is_string( $tour_highlights ) ) {
		$highlights_arr = array_filter( array_map( 'trim', explode( "\n", $tour_highlights ) ) );
	} elseif ( is_array( $tour_highlights ) ) {
		$highlights_arr = $tour_highlights;
	} else {
		$highlights_arr = array();
	}

	/* Itinerary: stored as serialized array of [ 'day' => int, 'title' => string ] */
	if ( is_string( $tour_itinerary ) ) {
		$itinerary_arr = maybe_unserialize( $tour_itinerary );
		if ( ! is_array( $itinerary_arr ) ) {
			/* Fallback: newline-separated */
			$lines = array_filter( array_map( 'trim', explode( "\n", $tour_itinerary ) ) );
			$itinerary_arr = array();
			foreach ( $lines as $i => $line ) {
				$itinerary_arr[] = array(
					'day'   => $i + 1,
					'title' => $line,
				);
			}
		}
	} elseif ( is_array( $tour_itinerary ) ) {
		$itinerary_arr = $tour_itinerary;
	} else {
		$itinerary_arr = array();
	}

	/* Hero image */
	$hero_url = has_post_thumbnail()
		? get_the_post_thumbnail_url( $tour_id, 'tourvice-hero' )
		: TOURVICE_URI . '/assets/images/placeholder-tour.jpg';

	/* Group size select options (min to max) */
	$select_min = max( 1, $tour_group_min ? $tour_group_min : 2 );
	$select_max = $tour_group_max ? $tour_group_max : 15;
?>

<main id="main-content" class="tourvice-single">

	<!-- Back button -->
	<a href="<?php echo esc_url( get_post_type_archive_link( 'vagra_tour' ) ); ?>" class="tourvice-tour-hero__back" data-i18n="single_back">
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<line x1="19" y1="12" x2="5" y2="12"></line>
			<polyline points="12 19 5 12 12 5"></polyline>
		</svg>
		<?php esc_html_e( 'Back', 'tourvice' ); ?>
	</a>

	<!-- ════════ HERO ════════ -->
	<section class="tourvice-tour-hero">
		<img
			class="tourvice-tour-hero__image"
			src="<?php echo esc_url( $hero_url ); ?>"
			alt="<?php the_title_attribute(); ?>"
		/>
		<div class="tourvice-tour-hero__overlay" aria-hidden="true"></div>
		<div class="tourvice-tour-hero__content">
			<h1 class="tourvice-tour-hero__title"><?php the_title(); ?></h1>
			<div class="tourvice-tour-hero__meta">
				<?php if ( $location_name ) : ?>
					<span class="tourvice-tour-hero__meta-item">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
							<circle cx="12" cy="10" r="3"></circle>
						</svg>
						<?php echo esc_html( $location_name ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $tour_rating ) : ?>
					<span class="tourvice-tour-hero__meta-item">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="tourvice-tour-hero__star-icon">
							<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
						</svg>
						<?php echo esc_html( $tour_rating ); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- ════════ CONTENT + SIDEBAR ════════ -->
	<div class="tourvice-tour-layout container">

		<!-- Content Column (2/3) -->
		<div class="tourvice-tour-content">

			<!-- Overview -->
			<div class="tourvice-tour-overview">
				<h2 class="tourvice-tour-overview__title" data-i18n="single_overview"><?php esc_html_e( 'Overview', 'tourvice' ); ?></h2>
				<div class="tourvice-tour-overview__text">
					<?php the_content(); ?>
				</div>

				<div class="tourvice-stat-grid">
					<?php if ( $tour_duration ) : ?>
						<div class="tourvice-stat-item">
							<p class="tourvice-stat-item__label" data-i18n="single_duration"><?php esc_html_e( 'Duration', 'tourvice' ); ?></p>
							<p class="tourvice-stat-item__value"><?php echo esc_html( $tour_duration ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( $group_display ) : ?>
						<div class="tourvice-stat-item">
							<p class="tourvice-stat-item__label" data-i18n="single_group_size"><?php esc_html_e( 'Group Size', 'tourvice' ); ?></p>
							<p class="tourvice-stat-item__value"><?php echo esc_html( $group_display ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( $tour_rating ) : ?>
						<div class="tourvice-stat-item">
							<p class="tourvice-stat-item__label" data-i18n="single_rating"><?php esc_html_e( 'Rating', 'tourvice' ); ?></p>
							<p class="tourvice-stat-item__value"><?php echo esc_html( $tour_rating ); ?>&#11088;</p>
						</div>
					<?php endif; ?>

					<?php if ( $price_display ) : ?>
						<div class="tourvice-stat-item">
							<p class="tourvice-stat-item__label" data-i18n="single_base_price"><?php esc_html_e( 'Base Price', 'tourvice' ); ?></p>
							<p class="tourvice-stat-item__value" data-usd="<?php echo esc_attr( $price_numeric ); ?>"><?php echo esc_html( $price_display ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Highlights -->
			<?php if ( ! empty( $highlights_arr ) ) : ?>
				<div class="tourvice-highlights">
					<h2 class="tourvice-highlights__title" data-i18n="single_highlights"><?php esc_html_e( 'Highlights', 'tourvice' ); ?></h2>
					<div class="tourvice-highlights__grid">
						<?php foreach ( $highlights_arr as $highlight ) : ?>
							<div class="tourvice-highlight-item">
								<span class="tourvice-highlight-item__dot" aria-hidden="true"></span>
								<span class="tourvice-highlight-item__text"><?php echo esc_html( $highlight ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Itinerary -->
			<?php if ( ! empty( $itinerary_arr ) ) : ?>
				<div class="tourvice-itinerary">
					<h2 class="tourvice-itinerary__title" data-i18n="single_itinerary"><?php esc_html_e( 'Itinerary', 'tourvice' ); ?></h2>
					<div class="tourvice-itinerary__list">
						<?php foreach ( $itinerary_arr as $idx => $item ) :
							$day   = isset( $item['day'] ) ? $item['day'] : ( $idx + 1 );
							$title = isset( $item['title'] ) ? $item['title'] : '';
						?>
							<div class="tourvice-itinerary-item">
								<div class="tourvice-itinerary-item__badge"><?php echo absint( $day ); ?></div>
								<?php if ( $idx < count( $itinerary_arr ) - 1 ) : ?>
									<div class="tourvice-itinerary-item__connector" aria-hidden="true"></div>
								<?php endif; ?>
								<div class="tourvice-itinerary-item__content">
									<p class="tourvice-itinerary-item__text"><?php echo esc_html( $title ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Reviews Section -->
			<?php
			$review_count = 0;
			if ( class_exists( 'TourVice_Reviews' ) ) {
				$review_count = TourVice_Reviews::get_review_count( $tour_id );
			}
			$rating_display = $tour_rating ?: 0;
			?>
			<div class="tourvice-reviews" id="tourvice-reviews">
				<div class="tourvice-reviews__header">
					<h2 class="tourvice-reviews__title" data-i18n="single_reviews">
						<?php esc_html_e( 'Guest Reviews', 'tourvice' ); ?>
					</h2>
					<?php if ( $rating_display > 0 ) : ?>
						<div class="tourvice-reviews__summary">
							<span class="tourvice-reviews__avg"><?php echo esc_html( $rating_display ); ?></span>
							<?php
							if ( class_exists( 'TourVice_Reviews' ) ) {
								TourVice_Reviews::render_stars( $rating_display );
							}
							?>
							<span class="tourvice-reviews__count">
								<?php
								printf(
									/* translators: %d: number of reviews */
									esc_html( _n( '(%d review)', '(%d reviews)', $review_count, 'tourvice' ) ),
									absint( $review_count )
								);
								?>
							</span>
						</div>
					<?php endif; ?>
				</div>

				<?php
				$reviews = get_comments( array(
					'post_id' => $tour_id,
					'status'  => 'approve',
					'type'    => 'comment',
					'orderby' => 'comment_date',
					'order'   => 'DESC',
				) );

				if ( $reviews ) :
					foreach ( $reviews as $review ) :
						$r_rating = (int) get_comment_meta( $review->comment_ID, '_review_rating', true );
						$initials = mb_strtoupper( mb_substr( $review->comment_author, 0, 1 ) );
					?>
						<div class="tourvice-review">
							<div class="tourvice-review__header">
								<div class="tourvice-review__avatar"><?php echo esc_html( $initials ); ?></div>
								<span class="tourvice-review__author"><?php echo esc_html( $review->comment_author ); ?></span>
								<?php if ( $r_rating > 0 && class_exists( 'TourVice_Reviews' ) ) : ?>
									<div class="tourvice-review__stars">
										<?php TourVice_Reviews::render_stars( $r_rating ); ?>
									</div>
								<?php endif; ?>
								<span class="tourvice-review__date">
									<?php echo esc_html( human_time_diff( strtotime( $review->comment_date ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'tourvice' ) ); ?>
								</span>
							</div>
							<div class="tourvice-review__text">
								<?php echo wp_kses_post( wpautop( $review->comment_content ) ); ?>
							</div>
						</div>
					<?php
					endforeach;
				else :
				?>
					<p class="tourvice-reviews__empty">
						<?php esc_html_e( 'No reviews yet. Be the first to share your experience!', 'tourvice' ); ?>
					</p>
				<?php endif; ?>

				<!-- Review Form -->
				<?php if ( comments_open( $tour_id ) ) : ?>
					<div class="tourvice-review-form">
						<h3 class="tourvice-review-form__title" data-i18n="single_write_review">
							<?php esc_html_e( 'Write a Review', 'tourvice' ); ?>
						</h3>
						<?php
						comment_form( array(
							'title_reply'          => '',
							'title_reply_before'   => '',
							'title_reply_after'    => '',
							'label_submit'         => __( 'Submit Review', 'tourvice' ),
							'comment_field'        => '<div class="comment-form-comment">'
								. '<label for="comment">' . esc_html__( 'Your Review', 'tourvice' ) . ' <span class="required">*</span></label>'
								. '<textarea id="comment" name="comment" rows="5" required></textarea>'
								. '</div>',
							'logged_in_as'         => '',
							'comment_notes_before' => '',
							'comment_notes_after'  => '',
						), $tour_id );
						?>
					</div>
				<?php endif; ?>
			</div>

		</div>

		<!-- Booking Sidebar (1/3) -->
		<aside class="tourvice-booking-sidebar">
			<div
				class="tourvice-booking-card"
				id="tourvice-booking-card"
				data-base-price="<?php echo esc_attr( $price_numeric ); ?>"
				data-discount="<?php echo esc_attr( $tour_discount ); ?>"
				data-group-min="<?php echo esc_attr( $select_min ); ?>"
				data-group-max="<?php echo esc_attr( $select_max ); ?>"
			>
				<h3 class="tourvice-booking-card__title" data-i18n="single_book_now"><?php esc_html_e( 'Book Now', 'tourvice' ); ?></h3>

				<!-- Group size selector -->
				<div class="tourvice-booking-card__field">
					<label class="tourvice-booking-card__group-label" for="tourvice-group-size">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
							<circle cx="9" cy="7" r="4"></circle>
							<path d="M23 21v-2a4 4 0 00-3-3.87"></path>
							<path d="M16 3.13a4 4 0 010 7.75"></path>
						</svg>
						<span data-i18n="single_group_size"><?php esc_html_e( 'Group Size', 'tourvice' ); ?></span>
					</label>
					<select class="tourvice-booking-card__select" id="tourvice-group-size">
						<?php for ( $n = $select_min; $n <= $select_max; $n++ ) : ?>
							<option value="<?php echo absint( $n ); ?>"<?php selected( $n, 2 ); ?>>
								<?php
								printf(
									/* translators: %d: number of people */
									esc_html( _n( '%d person', '%d people', $n, 'tourvice' ) ),
									absint( $n )
								);
								?>
							</option>
						<?php endfor; ?>
					</select>
				</div>

				<!-- Discount alert -->
				<?php if ( $tour_discount > 0 ) : ?>
					<div class="tourvice-discount-alert" id="tourvice-discount-alert">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<line x1="19" y1="5" x2="5" y2="19"></line>
							<circle cx="6.5" cy="6.5" r="2.5"></circle>
							<circle cx="17.5" cy="17.5" r="2.5"></circle>
						</svg>
						<span>
							<span id="tourvice-discount-value"><?php echo esc_html( $tour_discount ); ?></span>%
							<span data-i18n="single_discount_applied"><?php esc_html_e( 'discount applied!', 'tourvice' ); ?></span>
						</span>
					</div>
				<?php endif; ?>

				<!-- Price breakdown -->
				<div class="tourvice-price-breakdown">
					<div class="tourvice-price-row">
						<span data-i18n="single_price_per_person"><?php esc_html_e( 'Price per person', 'tourvice' ); ?></span>
						<span id="tourvice-price-person" data-usd="<?php echo esc_attr( $price_numeric * ( 1 - $tour_discount / 100 ) ); ?>">
							$<?php echo esc_html( number_format( $price_numeric * ( 1 - $tour_discount / 100 ) ) ); ?>
						</span>
					</div>
					<div class="tourvice-price-row">
						<span>
							<span data-i18n="single_group"><?php esc_html_e( 'Group', 'tourvice' ); ?></span>
							(<span id="tourvice-group-count">2</span> <span data-i18n="single_people"><?php esc_html_e( 'people', 'tourvice' ); ?></span>)
						</span>
						<span id="tourvice-price-group" data-usd="">
							$<?php echo esc_html( number_format( $price_numeric * ( 1 - $tour_discount / 100 ) * 2 ) ); ?>
						</span>
					</div>
					<div class="tourvice-price-total">
						<span data-i18n="single_total"><?php esc_html_e( 'Total', 'tourvice' ); ?></span>
						<span class="tourvice-price-total__value" id="tourvice-price-total" data-usd="">
							$<?php echo esc_html( number_format( $price_numeric * ( 1 - $tour_discount / 100 ) * 2 ) ); ?>
						</span>
					</div>
				</div>

				<!-- Book button -->
				<button
					type="button"
					class="tourvice-booking-card__btn"
					id="tourvice-book-btn"
					data-open-booking
					data-tour-id="<?php echo absint( $tour_id ); ?>"
					data-tour-name="<?php the_title_attribute(); ?>"
					data-tour-image="<?php echo esc_attr( $hero_url ); ?>"
					data-i18n="single_book_tour"
				>
					<?php esc_html_e( 'Book Tour', 'tourvice' ); ?>
				</button>
			</div>
		</aside>

	</div>
</main>

<?php get_template_part( 'template-parts/booking-modal' ); ?>

<?php
endwhile;

get_footer();
?>
