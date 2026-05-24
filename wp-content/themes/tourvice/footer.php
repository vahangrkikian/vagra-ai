<?php
/**
 * Theme footer template.
 *
 * 3-column widget areas, quick links (footer menu), contact info,
 * newsletter signup, copyright, AI chat widget.
 * Background image with dark overlay (parallax).
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<footer class="tourvice-footer" id="tourvice-footer">
	<div class="tourvice-footer__bg" aria-hidden="true"></div>
	<div class="tourvice-footer__overlay" aria-hidden="true"></div>

	<div class="tourvice-footer__inner container">
		<div class="tourvice-footer__grid">

			<!-- Column 1: Brand -->
			<div class="tourvice-footer__brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tourvice-footer__logo-text">
						<?php esc_html_e( 'Tour', 'tourvice' ); ?><span><?php esc_html_e( 'Vice', 'tourvice' ); ?></span>
					</a>
				<?php endif; ?>
				<p class="tourvice-footer__brand-desc">
					<?php esc_html_e( 'Luxury Armenian tourism experiences. Discover ancient monasteries, breathtaking landscapes, and vibrant culture with expert-guided tours.', 'tourvice' ); ?>
				</p>
				<div class="tourvice-footer__socials">
					<a href="#" class="tourvice-footer__social-btn" aria-label="Facebook">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
					</a>
					<a href="#" class="tourvice-footer__social-btn" aria-label="Instagram">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
					</a>
					<a href="#" class="tourvice-footer__social-btn" aria-label="Twitter">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
					</a>
				</div>
			</div>

			<!-- Column 2: Quick Links -->
			<div class="tourvice-footer__col">
				<h4 class="tourvice-footer__heading"><?php esc_html_e( 'Quick Links', 'tourvice' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => '',
						'items_wrap'     => '<ul>%3$s</ul>',
						'fallback_cb'    => 'tourvice_footer_menu_fallback',
						'depth'          => 1,
					)
				);
				?>
			</div>

			<!-- Column 3: Contact Info + Newsletter -->
			<div class="tourvice-footer__col">
				<h4 class="tourvice-footer__heading"><?php esc_html_e( 'Contact Us', 'tourvice' ); ?></h4>
				<div class="tourvice-footer__contact-item">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<span><?php esc_html_e( 'Yerevan, Armenia', 'tourvice' ); ?></span>
				</div>
				<div class="tourvice-footer__contact-item">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
					<span>+374 (XX) XXX-XXX</span>
				</div>
				<div class="tourvice-footer__contact-item">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					<span>info@tourvice.example</span>
				</div>

				<!-- Newsletter -->
				<div class="tourvice-footer__newsletter">
					<h4 class="tourvice-footer__heading"><?php esc_html_e( 'Newsletter', 'tourvice' ); ?></h4>
					<p><?php esc_html_e( 'Subscribe to get travel tips and special offers.', 'tourvice' ); ?></p>
					<form class="tourvice-footer__newsletter-form" action="#" method="post">
						<input type="email" name="email" class="tourvice-footer__newsletter-input" placeholder="<?php esc_attr_e( 'Your email address', 'tourvice' ); ?>" required>
						<button type="submit" class="tourvice-footer__newsletter-btn"><?php esc_html_e( 'Subscribe', 'tourvice' ); ?></button>
					</form>
				</div>
			</div>

		</div>

		<div class="tourvice-footer__bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'tourvice' ); ?></span>
			<span>
				<?php
				$privacy_page = get_page_by_path( 'privacy-policy' );
				$terms_page   = get_page_by_path( 'terms-of-service' );
				if ( $privacy_page ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $privacy_page ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'tourvice' ); ?></a>
				<?php else : ?>
					<?php esc_html_e( 'Privacy Policy', 'tourvice' ); ?>
				<?php endif; ?>
				&middot;
				<?php if ( $terms_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $terms_page ) ); ?>"><?php esc_html_e( 'Terms of Service', 'tourvice' ); ?></a>
				<?php else : ?>
					<?php esc_html_e( 'Terms of Service', 'tourvice' ); ?>
				<?php endif; ?>
			</span>
		</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/tourvice-chat' ); ?>

<?php wp_footer(); ?>
</body>
</html>
