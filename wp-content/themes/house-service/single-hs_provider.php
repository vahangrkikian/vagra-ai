<?php
/**
 * Single Provider Template
 *
 * @package House_Service
 */

get_header();

$provider_id = get_the_ID();
$tagline     = get_post_meta( $provider_id, '_hs_tagline', true );
$category    = get_post_meta( $provider_id, '_hs_category', true );
$price       = get_post_meta( $provider_id, '_hs_price', true );
$price_level = get_post_meta( $provider_id, '_hs_price_level', true );
$rating      = get_post_meta( $provider_id, '_hs_rating', true );
$reviews     = get_post_meta( $provider_id, '_hs_reviews', true );
$location    = get_post_meta( $provider_id, '_hs_location', true );
$verified    = get_post_meta( $provider_id, '_hs_verified', true );
$tags_str    = get_post_meta( $provider_id, '_hs_tags', true );
$jobs        = get_post_meta( $provider_id, '_hs_jobs', true );
$years       = get_post_meta( $provider_id, '_hs_years', true );

$badge       = get_post_meta( $provider_id, '_hs_badge', true );
$response    = get_post_meta( $provider_id, '_hs_response_time', true );
$completed   = get_post_meta( $provider_id, '_hs_completed_jobs', true );
$serving     = get_post_meta( $provider_id, '_hs_serving_area', true );
$founded     = get_post_meta( $provider_id, '_hs_founded', true );
$stored_init = get_post_meta( $provider_id, '_hs_initial', true );

$tags    = $tags_str ? array_map( 'trim', explode( ',', $tags_str ) ) : array();
$name    = get_the_title();
$initial = $stored_init ? $stored_init : mb_substr( $name, 0, 2 );
?>

<!-- Cover Photo -->
<section class="profile-hero">
	<div class="profile-hero__cover">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hs-hero' ); ?>
		<?php else : ?>
			<div class="ph"></div>
		<?php endif; ?>
		<div class="profile-hero__tint"></div>
	</div>
	<div class="shell">
		<div class="profile-hero__inner">

			<!-- Breadcrumbs -->
			<nav class="profile-hero__breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'house-service' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'house-service' ); ?></a>
				<span>/</span>
				<?php if ( $category ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'hs_cat', sanitize_title( $category ), get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ) ); ?>"><?php echo esc_html( $category ); ?></a>
					<span>/</span>
				<?php endif; ?>
				<span><?php echo esc_html( $name ); ?></span>
			</nav>

			<!-- Profile Card -->
			<div class="profile-card">
				<div class="profile-card__avatar"><?php echo esc_html( $initial ); ?></div>
				<div class="profile-card__info">
					<h1 class="profile-card__name"><?php echo esc_html( $name ); ?></h1>
					<?php if ( $tagline ) : ?>
						<p class="profile-card__tagline"><?php echo esc_html( $tagline ); ?></p>
					<?php endif; ?>
					<div class="profile-card__meta">
						<?php if ( $rating ) : ?>
						<span class="profile-card__meta-item">
							<?php echo hs_render_stars( floatval( $rating ), 16 ); ?>
							<strong><?php echo esc_html( $rating ); ?></strong>
							<?php if ( $reviews ) : ?>
								(<?php echo esc_html( $reviews ); ?> <?php esc_html_e( 'reviews', 'house-service' ); ?>)
							<?php endif; ?>
						</span>
						<?php endif; ?>
						<?php if ( $price ) : ?>
						<span class="profile-card__meta-item">
							<?php
							printf(
								/* translators: %s = price amount */
								esc_html__( 'From $%s', 'house-service' ),
								esc_html( $price )
							);
							?>
						</span>
						<?php endif; ?>
						<?php if ( $location ) : ?>
						<span class="profile-card__meta-item">
							<?php echo hs_icon( 'pin', 16 ); ?>
							<?php echo esc_html( $location ); ?>
						</span>
						<?php endif; ?>
						<?php if ( $verified ) : ?>
						<span class="profile-card__verified-badge">
							<?php echo hs_icon( 'shield', 14 ); ?>
							<?php esc_html_e( 'Verified', 'house-service' ); ?>
						</span>
						<?php endif; ?>
					</div>
				</div>
				<div class="profile-card__actions">
					<a href="#quote-form" class="btn btn-primary">
						<?php esc_html_e( 'Request quote', 'house-service' ); ?>
						<?php echo hs_icon( 'arrow', 18 ); ?>
					</a>
					<a href="tel:" class="btn btn-secondary">
						<?php echo hs_icon( 'phone', 18 ); ?>
						<?php esc_html_e( 'Call', 'house-service' ); ?>
					</a>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- Profile Content -->
<section class="section">
	<div class="shell">
		<div class="profile-grid">

			<!-- About -->
			<div class="profile-about">
				<h3><?php esc_html_e( 'About', 'house-service' ); ?></h3>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<!-- Key stats -->
				<div class="profile-kvs">
					<?php if ( $response ) : ?>
					<div class="profile-kv">
						<div class="profile-kv__key"><?php esc_html_e( 'Response time', 'house-service' ); ?></div>
						<div class="profile-kv__val"><?php echo esc_html( $response ); ?></div>
					</div>
					<?php endif; ?>
					<?php if ( $completed ) : ?>
					<div class="profile-kv">
						<div class="profile-kv__key"><?php esc_html_e( 'Completed', 'house-service' ); ?></div>
						<div class="profile-kv__val"><?php echo esc_html( $completed ); ?></div>
					</div>
					<?php endif; ?>
					<?php if ( $founded ) : ?>
					<div class="profile-kv">
						<div class="profile-kv__key"><?php esc_html_e( 'Founded', 'house-service' ); ?></div>
						<div class="profile-kv__val"><?php echo esc_html( $founded ); ?></div>
					</div>
					<?php endif; ?>
					<?php if ( $category ) : ?>
					<div class="profile-kv">
						<div class="profile-kv__key"><?php esc_html_e( 'Category', 'house-service' ); ?></div>
						<div class="profile-kv__val"><?php echo esc_html( $category ); ?></div>
					</div>
					<?php endif; ?>
				</div>

				<!-- Services -->
				<?php if ( ! empty( $tags ) ) : ?>
				<div class="profile-services">
					<h3><?php esc_html_e( 'Services offered', 'house-service' ); ?></h3>
					<div class="profile-services__list">
						<?php foreach ( $tags as $tag ) : ?>
							<span class="tag"><?php echo esc_html( $tag ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Demo Reviews -->
				<div class="profile-reviews">
					<h3><?php esc_html_e( 'Client reviews', 'house-service' ); ?></h3>

					<div class="review-card">
						<div class="review-card__head">
							<div class="review-card__avatar">JM</div>
							<div>
								<div class="review-card__name"><?php esc_html_e( 'Jessica M.', 'house-service' ); ?></div>
								<div class="review-card__date"><?php esc_html_e( '2 weeks ago', 'house-service' ); ?></div>
							</div>
							<?php echo hs_render_stars( 5, 14 ); ?>
						</div>
						<p class="review-card__text"><?php esc_html_e( 'Fantastic job! The team arrived on time, was professional, and left everything spotless. Already booked them for next month.', 'house-service' ); ?></p>
					</div>

					<div class="review-card">
						<div class="review-card__head">
							<div class="review-card__avatar">DP</div>
							<div>
								<div class="review-card__name"><?php esc_html_e( 'David P.', 'house-service' ); ?></div>
								<div class="review-card__date"><?php esc_html_e( '1 month ago', 'house-service' ); ?></div>
							</div>
							<?php echo hs_render_stars( 4, 14 ); ?>
						</div>
						<p class="review-card__text"><?php esc_html_e( 'Great communication and fair pricing. They went above and beyond to fix an issue we didn\'t even ask about. Highly recommend.', 'house-service' ); ?></p>
					</div>
				</div>
			</div>

			<!-- Quote Form Sidebar -->
			<div id="quote-form">
				<?php get_template_part( 'template-parts/quote-form' ); ?>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
