<?php
/**
 * Template Name: Terms of Use
 *
 * Terms of use page with numbered sections.
 * Ported from: nslookup/project/shared/page-cine-legal.jsx (kind=terms)
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-terms">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Terms', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Use the tools.', 'vagra-nslookup' ), esc_html__( 'Don\'t abuse them.', 'vagra-nslookup' ) ),
		'lede'    => __( 'These terms are intentionally short. The spirit is: use nslookup.am for legitimate DNS diagnostics, don\'t weaponize it, don\'t overload it.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Terms', 'vagra-nslookup' ) ),
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
				$terms_sections = array(
					array(
						't' => __( 'Service', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'nslookup.am provides a web and API interface to DNS diagnostic tools. It is provided free of charge, as-is, with no guarantees of uptime or accuracy, though we try hard.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'Acceptable use', 'vagra-nslookup' ),
						'c' => '<p>' . sprintf( '%s <strong>%s</strong>', esc_html__( 'You may use the service for any legitimate DNS diagnostic purpose. You may', 'vagra-nslookup' ), esc_html__( 'not:', 'vagra-nslookup' ) ) . '</p>'
							 . '<ul>'
							 . '<li>' . esc_html__( 'Run automated bulk queries that degrade service for others (the rate limit is 60/min per IP — respect it).', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Use the service as part of an attack, reconnaissance, or credential-stuffing pipeline against domains you do not own or are not authorized to test.', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Resell access to the service without written permission.', 'vagra-nslookup' ) . '</li>'
							 . '<li>' . esc_html__( 'Scrape or mirror the site at scale.', 'vagra-nslookup' ) . '</li>'
							 . '</ul>',
					),
					array(
						't' => __( 'No warranty', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'The service is provided "as is." We make no warranty that results are accurate, timely, complete, or fit for any purpose. DNS is a distributed system — cached, lagged, and occasionally lying — and our tools reflect that reality.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'Limitation of liability', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'Under no circumstances will nslookup.am or its operators be liable for damages arising from use or inability to use the service.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'Changes', 'vagra-nslookup' ),
						'c' => '<p>' . esc_html__( 'We may update these terms. Material changes will be noted at the top of this page with a new "updated" date.', 'vagra-nslookup' ) . '</p>',
					),
					array(
						't' => __( 'Contact', 'vagra-nslookup' ),
						'c' => '<p>' . sprintf( '%s <a href="mailto:legal@nslookup.am">legal@nslookup.am</a>', esc_html__( 'Legal:', 'vagra-nslookup' ) ) . '</p>',
					),
				);
				foreach ( $terms_sections as $i => $section ) :
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
