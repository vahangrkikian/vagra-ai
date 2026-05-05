<?php
/**
 * Template Name: DNS Tools
 *
 * Tool hub grid with 12 tool cards + sister tools.
 * Ported from: nslookup/project/shared/page-cine-tools.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-tools">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Toolkit', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'One query away', 'vagra-nslookup' ), esc_html__( 'from every answer.', 'vagra-nslookup' ) ),
		'lede'    => __( 'A complete DNS diagnostic suite. Every lookup runs across our 30+ global resolvers. No accounts, no rate-walls, no signup.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Tools', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<?php // ─── 12-card tool grid ─── ?>
	<section class="cine-section cine-section-dark" style="padding-top:40px">
		<div class="cine-head-wrap">
			<div class="cine-features" style="margin-top:0; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr))">
				<?php
				$tools = array(
					array( 'tag' => 'NS',    'title' => __( 'NS Lookup', 'vagra-nslookup' ),               'desc' => __( 'Authoritative nameservers, resolved.', 'vagra-nslookup' ),       'href' => home_url( '/ns-lookup/' ), 'live' => true ),
					array( 'tag' => 'DNS',   'title' => __( 'DNS Propagation Checker', 'vagra-nslookup' ), 'desc' => __( 'Watch changes land globally.', 'vagra-nslookup' ),               'href' => home_url( '/propagation/' ), 'live' => true ),
					array( 'tag' => 'A',     'title' => __( 'A Record Lookup', 'vagra-nslookup' ),         'desc' => __( 'IPv4 resolution, compared globally.', 'vagra-nslookup' ),        'href' => '#', 'live' => false ),
					array( 'tag' => 'AAAA',  'title' => __( 'AAAA Lookup', 'vagra-nslookup' ),             'desc' => __( 'IPv6 addressing, per region.', 'vagra-nslookup' ),                'href' => '#', 'live' => false ),
					array( 'tag' => 'CNAME', 'title' => __( 'CNAME Lookup', 'vagra-nslookup' ),            'desc' => __( 'Chain follow and loop detection.', 'vagra-nslookup' ),            'href' => '#', 'live' => false ),
					array( 'tag' => 'MX',    'title' => __( 'MX Lookup', 'vagra-nslookup' ),               'desc' => __( 'Mail exchangers with priority.', 'vagra-nslookup' ),              'href' => '#', 'live' => false ),
					array( 'tag' => 'TXT',   'title' => __( 'TXT Lookup', 'vagra-nslookup' ),              'desc' => __( 'Raw text, SPF, verification.', 'vagra-nslookup' ),                'href' => '#', 'live' => false ),
					array( 'tag' => 'SOA',   'title' => __( 'SOA Lookup', 'vagra-nslookup' ),              'desc' => __( 'Zone authority, serial, refresh.', 'vagra-nslookup' ),             'href' => '#', 'live' => false ),
					array( 'tag' => 'CAA',   'title' => __( 'CAA Lookup', 'vagra-nslookup' ),              'desc' => __( 'Certificate Authority Authorization.', 'vagra-nslookup' ),        'href' => '#', 'live' => false ),
					array( 'tag' => 'PTR',   'title' => __( 'Reverse DNS', 'vagra-nslookup' ),             'desc' => __( 'IP back to hostname.', 'vagra-nslookup' ),                        'href' => '#', 'live' => false ),
					array( 'tag' => 'SRV',   'title' => __( 'SRV Lookup', 'vagra-nslookup' ),              'desc' => __( 'Service records, priority, weight.', 'vagra-nslookup' ),          'href' => '#', 'live' => false ),
					array( 'tag' => 'WHOIS', 'title' => __( 'WHOIS Lookup', 'vagra-nslookup' ),            'desc' => __( 'Ownership, expiry, delegation.', 'vagra-nslookup' ),              'href' => '#', 'live' => false ),
				);
				foreach ( $tools as $i => $tool ) :
					$delay       = 40 * $i;
					$live_class  = $tool['live'] ? '#34D399' : 'rgba(255,255,255,0.35)';
					$live_label  = $tool['live'] ? __( '&#9679; Live', 'vagra-nslookup' ) : __( '&#9675; Soon', 'vagra-nslookup' );
					$action_text = $tool['live'] ? __( 'Open tool &rarr;', 'vagra-nslookup' ) : __( 'Notify me &rarr;', 'vagra-nslookup' );
				?>
					<a href="<?php echo esc_url( $tool['href'] ); ?>" class="cine-feature reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
						<div style="display:flex; justify-content:space-between; align-items:center">
							<span class="cine-feature-num"><?php echo esc_html( $tool['tag'] ); ?></span>
							<span style="font-size:11px; font-family:var(--nsl-font-mono); color:<?php echo esc_attr( $live_class ); ?>; text-transform:uppercase; letter-spacing:0.1em">
								<?php echo $live_label; // phpcs:ignore -- trusted HTML entities ?>
							</span>
						</div>
						<h3><?php echo esc_html( $tool['title'] ); ?></h3>
						<p><?php echo esc_html( $tool['desc'] ); ?></p>
						<span style="margin-top:16px; color:#A5B4FC; font-size:13px; font-weight:600"><?php echo $action_text; // phpcs:ignore -- trusted HTML ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── Sister tools ─── ?>
	<?php get_template_part( 'template-parts/sister-tools' ); ?>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Need a tool', 'vagra-nslookup' ), esc_html__( 'we don\'t have yet?', 'vagra-nslookup' ) ),
		'sub'       => __( 'Tell us what would save you time. We build based on real debugging pain.', 'vagra-nslookup' ),
		'cta'       => __( 'Request a tool', 'vagra-nslookup' ),
		'href'      => home_url( '/contact/' ),
	) );
	?>

</main>

<?php get_footer(); ?>
