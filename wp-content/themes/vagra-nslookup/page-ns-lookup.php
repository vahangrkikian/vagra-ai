<?php
/**
 * Template Name: NS Lookup
 *
 * NS record lookup tool page.
 * Ported from: nslookup/project/shared/page-cine-ns.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-ns">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Tool &middot; NS', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Authoritative nameservers,', 'vagra-nslookup' ), esc_html__( 'resolved in one query.', 'vagra-nslookup' ) ),
		'lede'    => __( 'Every NS record your domain publishes, pulled from the authority and cross-checked against global resolvers. Copy, CSV, JSON — free, no signup.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'NS Lookup', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<?php // ─── React island: NS tool ─── ?>
	<section class="cine-section cine-section-dark" style="padding-top:20px">
		<div class="cine-head-wrap">
			<div id="nsl-ns-tool"></div>

			<div class="cine-features" style="margin-top:100px">
				<?php
				$ns_features = array(
					array( 'n' => 'A', 'title' => __( 'Hostname', 'vagra-nslookup' ),   'body' => __( 'Human-readable address of each authoritative server — typically 2–4 per zone.', 'vagra-nslookup' ) ),
					array( 'n' => 'B', 'title' => __( 'Glue IP', 'vagra-nslookup' ),     'body' => __( 'A/AAAA record for the nameserver, published at the parent to break the bootstrap loop.', 'vagra-nslookup' ) ),
					array( 'n' => 'C', 'title' => __( 'TTL', 'vagra-nslookup' ),          'body' => __( 'How long resolvers may cache the NS answer. 3600s is standard for production zones.', 'vagra-nslookup' ) ),
					array( 'n' => 'D', 'title' => __( 'Delegation', 'vagra-nslookup' ),   'body' => __( 'Subdomain zones can delegate to different authorities — common for multi-team setups.', 'vagra-nslookup' ) ),
				);
				foreach ( $ns_features as $i => $feat ) :
					$delay = 80 * $i;
				?>
					<div class="cine-feature reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
						<div class="cine-feature-num"><?php echo esc_html( $feat['n'] ); ?></div>
						<h3><?php echo esc_html( $feat['title'] ); ?></h3>
						<p><?php echo esc_html( $feat['body'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── NS records FAQ ─── ?>
	<section class="cine-section" style="background:#F7F8FC">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'NS records — FAQ', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s <span class="muted">%s</span>',
					esc_html__( 'Everything about', 'vagra-nslookup' ),
					esc_html__( 'nameservers.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<div class="nsl-faq-list reveal reveal-delay-2" style="margin-top:48px; max-width:780px">
				<?php
				$ns_faq = array(
					array( 'q' => __( 'What is an NS record?', 'vagra-nslookup' ), 'a' => __( 'An NS (nameserver) record points your domain at the authoritative DNS servers that host the rest of your zone. Every domain needs at least two.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'Why do I have multiple nameservers?', 'vagra-nslookup' ), 'a' => __( 'Redundancy. If one fails, resolvers fall back to the others. Most providers ship 2–4 on anycast for geographic speed.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'What happens when I change nameservers?', 'vagra-nslookup' ), 'a' => __( 'The registry updates the NS record at the TLD zone. TLD caches for 24–48 hours, so traffic keeps hitting the old NS until they expire.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'How long does nameserver propagation take?', 'vagra-nslookup' ), 'a' => __( 'Usually 24–48 hours, bounded by the TLD zone TTL. Lower your zone TTLs in advance to shorten the perceived cutover.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'Can I delegate subdomains to different NS?', 'vagra-nslookup' ), 'a' => __( 'Yes — publish NS records for sub.example.com in your main zone pointing to a different authority.', 'vagra-nslookup' ) ),
				);
				foreach ( $ns_faq as $i => $item ) :
					$open = 0 === $i ? ' open' : '';
				?>
					<details class="faq-item"<?php echo $open; ?>>
						<summary>
							<span style="font-size:20px; font-weight:500; letter-spacing:-0.01em; color:var(--nsl-ink)"><?php echo esc_html( $item['q'] ); ?></span>
							<span class="faq-toggle" style="font-size:24px; color:rgba(11,13,20,0.35)">+</span>
						</summary>
						<div class="faq-body">
							<p style="font-size:16px; line-height:1.65; color:rgba(11,13,20,0.7); max-width:680px"><?php echo esc_html( $item['a'] ); ?></p>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Check DNS', 'vagra-nslookup' ), esc_html__( 'like it\'s 2026.', 'vagra-nslookup' ) ),
		'sub'       => __( 'Free. Instant. Worldwide.', 'vagra-nslookup' ),
		'cta'       => __( 'Start a lookup', 'vagra-nslookup' ),
		'href'      => home_url( '/' ),
		'secondary' => array(
			'label' => __( 'Propagation check', 'vagra-nslookup' ),
			'href'  => home_url( '/propagation/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
