<?php
/**
 * Theme footer.
 *
 * Ported from: nslookup/project/shared/sections.jsx — Footer component
 *
 * @package Vagra_NSLookup
 */
?>

<footer class="nsl-footer" id="contact">
	<div class="container nsl-footer-grid">
		<!-- Brand column -->
		<div class="nsl-footer-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nsl-logo" aria-label="<?php bloginfo( 'name' ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
						<rect width="32" height="32" rx="8" fill="var(--nsl-primary-500)"/>
						<circle cx="10" cy="10" r="2.4" fill="#fff"/>
						<circle cx="22" cy="10" r="2.4" fill="#fff" opacity="0.75"/>
						<circle cx="10" cy="22" r="2.4" fill="#fff" opacity="0.75"/>
						<circle cx="22" cy="22" r="2.4" fill="#fff"/>
						<path d="M10 10 L22 22 M22 10 L10 22" stroke="#fff" stroke-width="1.4" stroke-linecap="round" opacity="0.6"/>
					</svg>
					<span class="nsl-logo-word">nslookup<span class="nsl-logo-dot">.am</span></span>
				<?php endif; ?>
			</a>
			<p style="margin-top:16px; max-width:320px;">
				<?php esc_html_e( 'Free DNS propagation and record lookup across 30+ global resolvers. Made for engineers, by engineers.', 'vagra-nslookup' ); ?>
			</p>
			<div style="margin-top:20px; display:flex; gap:8px; flex-wrap:wrap;">
				<span class="badge badge-mono">A &middot; AAAA &middot; CNAME</span>
				<span class="badge badge-mono">MX &middot; NS &middot; TXT</span>
			</div>
		</div>

		<!-- Tools column -->
		<div>
			<h4><?php esc_html_e( 'Other tools', 'vagra-nslookup' ); ?></h4>
			<?php if ( has_nav_menu( 'footer-tools' ) ) : ?>
				<?php wp_nav_menu( array(
					'theme_location' => 'footer-tools',
					'container'      => false,
					'depth'          => 1,
				) ); ?>
			<?php else : ?>
				<ul>
					<li><a href="https://spf-checker.org/" target="_blank" rel="noopener"><?php esc_html_e( 'SPF Checker', 'vagra-nslookup' ); ?></a></li>
					<li><a href="https://dkim-checker.org/" target="_blank" rel="noopener"><?php esc_html_e( 'DKIM Checker', 'vagra-nslookup' ); ?></a></li>
					<li><a href="https://dmarc-checker.org/" target="_blank" rel="noopener"><?php esc_html_e( 'DMARC Checker', 'vagra-nslookup' ); ?></a></li>
					<li><a href="https://bimi-checker.org/" target="_blank" rel="noopener"><?php esc_html_e( 'BIMI Checker', 'vagra-nslookup' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Company column -->
		<div>
			<h4><?php esc_html_e( 'Company', 'vagra-nslookup' ); ?></h4>
			<?php if ( has_nav_menu( 'footer-company' ) ) : ?>
				<?php wp_nav_menu( array(
					'theme_location' => 'footer-company',
					'container'      => false,
					'depth'          => 1,
				) ); ?>
			<?php else : ?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'vagra-nslookup' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'vagra-nslookup' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'vagra-nslookup' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'vagra-nslookup' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Discover more column -->
		<div>
			<h4><?php esc_html_e( 'Discover more', 'vagra-nslookup' ); ?></h4>
			<?php if ( has_nav_menu( 'footer-discover' ) ) : ?>
				<?php wp_nav_menu( array(
					'theme_location' => 'footer-discover',
					'container'      => false,
					'depth'          => 1,
				) ); ?>
			<?php else : ?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'vagra-nslookup' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQ', 'vagra-nslookup' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php esc_html_e( 'Other DNS Tools', 'vagra-nslookup' ); ?></a></li>
					<li><a href="https://www.rfc-editor.org/rfc/rfc1035" target="_blank" rel="noopener"><?php esc_html_e( 'RFC 1035 — DNS', 'vagra-nslookup' ); ?></a></li>
					<li><a href="https://www.rfc-editor.org/rfc/rfc8499" target="_blank" rel="noopener"><?php esc_html_e( 'RFC 8499 — Terminology', 'vagra-nslookup' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>
	</div>

	<div class="container nsl-footer-bottom">
		<span>&copy; <?php echo esc_html( get_bloginfo( 'name' ) ); ?> <?php echo esc_html( gmdate( 'Y' ) ); ?> &mdash; <?php esc_html_e( 'All rights reserved.', 'vagra-nslookup' ); ?></span>
		<span class="mono" style="color:var(--nsl-subtle)"><?php esc_html_e( 'built for the ones shipping at 2am', 'vagra-nslookup' ); ?></span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
