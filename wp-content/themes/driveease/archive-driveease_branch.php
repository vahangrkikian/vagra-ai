<?php
/**
 * Branch archive template — displays all branch locations.
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
<!-- Branches Hero -->
<section class="branches-hero">
	<div class="container">
		<div class="section-label" data-i18n="branches_hero_label"><?php esc_html_e( 'Our Locations', 'driveease' ); ?></div>
		<h1 class="branches-hero__title" data-i18n="branches_hero_title"><?php esc_html_e( 'Find a Branch Near You', 'driveease' ); ?></h1>
		<p class="branches-hero__sub" data-i18n="branches_hero_sub"><?php esc_html_e( 'Visit any of our conveniently located branches for premium car rental service.', 'driveease' ); ?></p>
	</div>
</section>

<!-- Branches Grid -->
<section class="branches-archive">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="branches-grid">
				<?php
				while ( have_posts() ) :
					the_post();

					$branch_id      = get_the_ID();
					$address        = get_post_meta( $branch_id, '_branch_address', true );
					$phone          = get_post_meta( $branch_id, '_branch_phone', true );
					$hours_weekday  = get_post_meta( $branch_id, '_branch_hours_weekday', true );
					$hours_weekend  = get_post_meta( $branch_id, '_branch_hours_weekend', true );
					$is_24h         = get_post_meta( $branch_id, '_branch_is_24h', true );

					$thumbnail = get_the_post_thumbnail_url( $branch_id, 'medium_large' );
					if ( ! $thumbnail ) {
						$thumbnail = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
					}
					?>
					<div class="branch-card">
						<div class="branch-card__img">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
							</a>
							<?php if ( $is_24h ) : ?>
								<span class="branch-badge branch-badge--24h"><?php esc_html_e( '24/7', 'driveease' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="branch-card__body">
							<a href="<?php the_permalink(); ?>" class="branch-card__name"><?php the_title(); ?></a>

							<?php if ( $address ) : ?>
								<div class="branch-card__detail">
									<i class="fa-solid fa-location-dot"></i>
									<span><?php echo esc_html( $address ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $phone ) : ?>
								<div class="branch-card__detail">
									<i class="fa-solid fa-phone"></i>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</div>
							<?php endif; ?>

							<div class="branch-card__hours">
								<?php if ( $is_24h ) : ?>
									<span class="hours-badge hours-badge--open"><?php esc_html_e( 'Open 24/7', 'driveease' ); ?></span>
								<?php else : ?>
									<?php if ( $hours_weekday ) : ?>
										<span class="hours-badge"><i class="fa-regular fa-clock"></i> <?php echo esc_html( $hours_weekday ); ?></span>
									<?php endif; ?>
									<?php if ( $hours_weekend ) : ?>
										<span class="hours-badge hours-badge--weekend"><i class="fa-regular fa-calendar"></i> <?php echo esc_html( $hours_weekend ); ?></span>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<a href="<?php the_permalink(); ?>" class="btn btn-primary branch-card__cta" data-i18n="btn_view_branch"><?php esc_html_e( 'View Branch', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></a>
						</div>
					</div>
					<?php
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'driveease' ),
					'next_text' => esc_html__( 'Next', 'driveease' ) . ' <i class="fa-solid fa-chevron-right"></i>',
				)
			);
			?>

		<?php else : ?>
			<div class="branches-empty">
				<p><?php esc_html_e( 'No branch locations found. Please check back soon!', 'driveease' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
</main>

<?php
get_footer();
