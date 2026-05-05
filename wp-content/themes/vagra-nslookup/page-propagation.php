<?php
/**
 * Template Name: DNS Propagation Checker
 *
 * DNS propagation checker tool page.
 * Ported from: nslookup/project/shared/page-cine-prop.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-propagation">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Tool &middot; Propagation', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Your DNS changes,', 'vagra-nslookup' ), esc_html__( 'landing worldwide.', 'vagra-nslookup' ) ),
		'lede'    => __( 'Query 30+ public resolvers across six continents, in parallel. Watch each resolver\'s cache expire and converge on the new answer, live.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'DNS Propagation', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<?php // ─── React island: Propagation tool ─── ?>
	<section class="cine-section cine-section-dark" style="padding-top:20px">
		<div class="cine-head-wrap">
			<div id="nsl-prop-tool"></div>
		</div>
	</section>

	<?php // ─── Explainer section ─── ?>
	<section class="cine-section cine-section-mid">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Understanding propagation', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s<br/><span class="muted">%s</span> %s',
					esc_html__( 'Propagation isn\'t a push.', 'vagra-nslookup' ),
					esc_html__( 'It\'s thousands of caches', 'vagra-nslookup' ),
					esc_html__( 'expiring in sequence.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<p class="cine-lede reveal reveal-delay-2" style="margin-top:32px; max-width:720px">
				<?php esc_html_e( 'Every caching resolver on the internet keeps its own copy of your records. The change is instant at your authority — what takes time is every other machine noticing. nslookup.am shows that rolling wave in real time.', 'vagra-nslookup' ); ?>
			</p>

			<div class="cine-stats reveal reveal-delay-3">
				<?php
				$prop_stats = array(
					array( 'n' => __( '5 min', 'vagra-nslookup' ),  'l' => __( 'Minimum propagation', 'vagra-nslookup' ) ),
					array( 'n' => __( '48 h', 'vagra-nslookup' ),   'l' => __( 'Typical ceiling', 'vagra-nslookup' ) ),
					array( 'n' => __( '3600s', 'vagra-nslookup' ),  'l' => __( 'Standard TTL', 'vagra-nslookup' ) ),
					array( 'n' => '&infin;',                        'l' => __( 'Patience required', 'vagra-nslookup' ) ),
				);
				foreach ( $prop_stats as $stat ) :
				?>
					<div class="cine-stat">
						<div class="cine-stat-num"><?php echo $stat['n']; // phpcs:ignore -- trusted entity ?></div>
						<div class="cine-stat-lbl"><?php echo esc_html( $stat['l'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── Propagation FAQ ─── ?>
	<section class="cine-section" style="background:#F7F8FC">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Propagation — FAQ', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s <span class="muted">%s</span>',
					esc_html__( 'DNS propagation,', 'vagra-nslookup' ),
					esc_html__( 'answered.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<div class="nsl-faq-list reveal reveal-delay-2" style="margin-top:48px; max-width:780px">
				<?php
				$prop_faq = array(
					array( 'q' => __( 'How long does DNS propagation take?', 'vagra-nslookup' ), 'a' => __( 'Usually 5 minutes to 48 hours, bounded by your record TTL plus resolver caches. Lower TTL before a change to speed it up.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'Why isn\'t my DNS propagating?', 'vagra-nslookup' ), 'a' => __( 'Common causes: change not published, high TTL still cached, registrar delegation issue, or DNSSEC mismatch rejecting answers.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'What is TTL and how does it affect propagation?', 'vagra-nslookup' ), 'a' => __( 'TTL is how long resolvers may cache the record. Lower = faster propagation, more authority load. Higher = slower but lighter.', 'vagra-nslookup' ) ),
					array( 'q' => __( 'How do I flush my DNS cache?', 'vagra-nslookup' ), 'a' => __( 'Windows: ipconfig /flushdns — macOS: sudo dscacheutil -flushcache; sudo killall -HUP mDNSResponder — Linux: sudo systemd-resolve --flush-caches', 'vagra-nslookup' ) ),
					array( 'q' => __( 'Why do different servers show different records?', 'vagra-nslookup' ), 'a' => __( 'Stale cache, geo-DNS routing, or split-horizon zones. The propagation checker makes the differences visible.', 'vagra-nslookup' ) ),
				);
				foreach ( $prop_faq as $i => $item ) :
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
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Watch DNS', 'vagra-nslookup' ), esc_html__( 'converge in real time.', 'vagra-nslookup' ) ),
		'sub'       => __( '30+ resolvers, 6 continents, one click.', 'vagra-nslookup' ),
		'cta'       => __( 'Run a check', 'vagra-nslookup' ),
		'href'      => home_url( '/' ),
		'secondary' => array(
			'label' => __( 'NS Lookup', 'vagra-nslookup' ),
			'href'  => home_url( '/ns-lookup/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
