<?php
/**
 * Template Name: Privacy Policy
 *
 * Privacy policy page with numbered sections.
 * Ported from: nslookup/project/shared/page-cine-legal.jsx (kind=privacy)
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-privacy">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Privacy', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'What we collect', 'vagra-nslookup' ), esc_html__( '(almost nothing).', 'vagra-nslookup' ) ),
		'lede'    => __( 'We run DNS tools. We don\'t build profiles, we don\'t sell data, and we don\'t use analytics trackers. Here\'s the detailed version.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Privacy', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<section class="cine-section" style="background:#fff; padding-top:40px">
		<div class="container" style="max-width:820px; padding:0 32px">
			<div class="reveal" style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.14em; color:rgba(11,13,20,0.4); margin-bottom:40px">
				<?php esc_html_e( 'Last updated', 'vagra-nslookup' ); ?> &middot; <?php esc_html_e( 'March 1, 2026', 'vagra-nslookup' ); ?>
			</div>

			<div class="nsl-article-body">
				<?php
				$privacy_sections = array(
					array(
						't' => __( 'What we collect', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'When you use nslookup.am, our servers receive standard HTTP request metadata: your IP address, user agent, and the query you ran. This is necessary to return a result.', 'vagra-nslookup' ) . '</p>'
							 . '<p>' . esc_html__( 'We do not set tracking cookies, fingerprint your browser, or integrate third-party analytics (no Google Analytics, no Plausible, no Mixpanel, nothing).', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'How long we retain it', 'vagra-nslookup' ),
						'c' => '<p>' . sprintf( esc_html__( 'Request logs are retained for %s72 hours%s and then permanently deleted. This window exists solely for abuse-mitigation and capacity planning.', 'vagra-nslookup' ), '<strong>', '</strong>' ) . '</p>'
							 . '<p>' . esc_html__( 'Aggregated, non-identifying metrics (e.g. "queries per hour across all users") are retained indefinitely for capacity work.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'What we never do', 'vagra-nslookup' ),
						'c' => '<ul>'
							 . '<li>' . esc_html__( 'Sell data. To anyone. Ever.', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Share logs with advertisers, data brokers, or "partners."', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Track you across the web.', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Require an account, email, or phone number.', 'vagra-nslookup' ) . '</li>'
							 . '</ul>',
					),
					array(
						't' => __( 'Cookies', 'vagra-nslookup' ),
						'c' => '<p>' . sprintf( esc_html__( 'We set exactly one cookie: %snsl_theme%s, storing whether you prefer dark or light mode. It\'s local to your browser and sent with no requests except to our origin.', 'vagra-nslookup' ), '<code>', '</code>' ) . '</p>',
					),
					array(
						't' => __( 'Legal requests', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'If law enforcement contacts us with a valid subpoena, we can only provide what we have — which, thanks to our 72-hour retention, is very little. We publish a transparency report annually.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'Contact', 'vagra-nslookup' ),
						'c' => '<p>' . sprintf( '%s <a href="mailto:privacy@nslookup.am">privacy@nslookup.am</a>', esc_html__( 'Privacy questions:', 'vagra-nslookup' ) ) . '</p>',
					),
				);
				foreach ( $privacy_sections as $i => $section ) :
					$delay = 40 * $i;
				?>
					<div class="reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms; margin-bottom:48px">
						<div style="display:flex; gap:20px; align-items:baseline">
							<span style="font-size:13px; font-family:var(--nsl-font-mono); color:rgba(11,13,20,0.35); min-width:24px"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<h2 style="font-size:28px; font-weight:600; letter-spacing:-0.02em; margin:0"><?php echo esc_html( $section['t'] ); ?></h2>
						</div>
						<div style="margin-left:44px; margin-top:12px; font-size:16px; line-height:1.7; color:rgba(11,13,20,0.75)">
							<?php echo wp_kses_post( $section['c'] ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => esc_html__( 'Questions?', 'vagra-nslookup' ),
		'sub'       => __( 'We\'re happy to clarify anything here.', 'vagra-nslookup' ),
		'cta'       => __( 'Email us', 'vagra-nslookup' ),
		'href'      => home_url( '/contact/' ),
	) );
	?>

</main>

<?php get_footer(); ?>
