<?php
/**
 * Theme footer template.
 *
 * Dark footer with 4-column grid: About (logo + desc), Quick Links (wp_nav_menu footer),
 * Our Branches (WP_Query driveease_branch), Contact Info. Social icons row.
 * Copyright bar with dynamic year. Includes booking-modal and driveease-chat partials.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<footer id="footer">
	<div class="container">
		<div class="footer-grid">

			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"><?php esc_html_e( 'Drive', 'driveease' ); ?><span><?php esc_html_e( 'Ease', 'driveease' ); ?></span></a>
				<p><?php esc_html_e( 'Premium car rental services for every journey. Quality vehicles, transparent pricing, and exceptional support.', 'driveease' ); ?></p>
				<div class="socials">
					<a href="#" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
					<a href="#" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
					<a href="#" class="social-btn" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
					<a href="#" class="social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Quick Links', 'driveease' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => '',
						'items_wrap'     => '<ul>%3$s</ul>',
						'fallback_cb'    => 'driveease_footer_menu_fallback',
						'depth'          => 1,
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Our Branches', 'driveease' ); ?></h4>
				<ul>
					<?php
					$branches = new WP_Query(
						array(
							'post_type'      => 'driveease_branch',
							'posts_per_page' => 6,
							'post_status'    => 'publish',
							'orderby'        => 'title',
							'order'          => 'ASC',
						)
					);

					if ( $branches->have_posts() ) :
						while ( $branches->have_posts() ) :
							$branches->the_post();
							?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Contact Us', 'driveease' ); ?></h4>
				<div class="contact-item">
					<i class="fa-solid fa-location-dot"></i>
					<span>123 Placeholder Street,<br><?php esc_html_e( 'City Name, Country', 'driveease' ); ?></span>
				</div>
				<div class="contact-item">
					<i class="fa-solid fa-phone"></i>
					<span>+X (XXX) XXX-XXXX</span>
				</div>
				<div class="contact-item">
					<i class="fa-solid fa-envelope"></i>
					<span>info@driveease.example</span>
				</div>
			</div>

		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'driveease' ); ?></span>
			<span>
				<?php
				$privacy_page = get_page_by_path( 'privacy-policy' );
				$terms_page   = get_page_by_path( 'terms-of-service' );
				if ( $privacy_page ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $privacy_page ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'driveease' ); ?></a>
				<?php else : ?>
					<?php esc_html_e( 'Privacy Policy', 'driveease' ); ?>
				<?php endif; ?>
				&middot;
				<?php if ( $terms_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $terms_page ) ); ?>"><?php esc_html_e( 'Terms of Service', 'driveease' ); ?></a>
				<?php else : ?>
					<?php esc_html_e( 'Terms of Service', 'driveease' ); ?>
				<?php endif; ?>
				&middot;
				<?php esc_html_e( 'Cookie Policy', 'driveease' ); ?>
			</span>
		</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/booking-modal' ); ?>
<?php get_template_part( 'template-parts/driveease-chat' ); ?>

<?php wp_footer(); ?>
</body>
</html>
