<?php
/**
 * Template part: Cinematic 4-card feature grid with mouse-tracking gradient glow.
 *
 * Expected variables (via $args):
 *   $features  array  — Optional override array of feature items.
 *                       Each: [ 'num' => '01', 'title' => '', 'body' => '', 'icon' => '' (SVG markup) ]
 *                       Defaults to the standard 4-step DNS lookup flow.
 *
 * Ported from: nslookup/project/shared/page-cine-home.jsx — CineStatement features block
 *
 * @package Vagra_NSLookup
 */

$default_features = array(
	array(
		'num'   => '01',
		'title' => __( 'Enter domain', 'vagra-nslookup' ),
		'body'  => __( 'Any domain, subdomain, or hostname. No account, no signup.', 'vagra-nslookup' ),
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="3" y="6" width="14" height="8" rx="1.5" stroke="currentColor" stroke-width="1.6"/><path d="M7 10h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
	),
	array(
		'num'   => '02',
		'title' => __( 'Pick a record', 'vagra-nslookup' ),
		'body'  => __( '13 types — A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, SRV.', 'vagra-nslookup' ),
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 10l3 3 9-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	),
	array(
		'num'   => '03',
		'title' => __( 'Query globally', 'vagra-nslookup' ),
		'body'  => __( '30+ public resolvers on 6 continents. Parallel, not sequential.', 'vagra-nslookup' ),
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.6"/><path d="M3 10h14M10 3c3 4 3 10 0 14M10 3c-3 4-3 10 0 14" stroke="currentColor" stroke-width="1.2"/></svg>',
	),
	array(
		'num'   => '04',
		'title' => __( 'See propagation', 'vagra-nslookup' ),
		'body'  => __( 'Per-resolver TTL, live or stale, full answer breakdown.', 'vagra-nslookup' ),
		'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.6"/><path d="M10 6v4l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
	),
);

$features = $args['features'] ?? $default_features;
?>

<div class="cine-features">
	<?php foreach ( $features as $i => $feature ) : ?>
		<div class="cine-feature reveal" style="transition-delay:<?php echo esc_attr( 80 * $i ); ?>ms" data-mouse-glow>
			<div class="cine-feature-icon"><?php echo $feature['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG markup ?></div>
			<div class="cine-feature-num"><?php echo esc_html( $feature['num'] ); ?></div>
			<h3><?php echo esc_html( $feature['title'] ); ?></h3>
			<p><?php echo esc_html( $feature['body'] ); ?></p>
		</div>
	<?php endforeach; ?>
</div>
