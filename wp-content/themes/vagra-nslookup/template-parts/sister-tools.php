<?php
/**
 * Template part: Sister tools cross-link cards.
 *
 * Displays cards linking to SPF/DKIM/DMARC/BIMI checker sister sites.
 *
 * Expected variables (via $args):
 *   $heading   string  — Optional section heading (default: 'Pair DNS with deliverability.').
 *   $eyebrow   string  — Optional eyebrow text (default: 'Email suite').
 *   $tools     array   — Optional override array of tool items.
 *                        Each: [ 'title' => '', 'desc' => '', 'href' => '' ]
 *
 * Ported from: nslookup/project/shared/page-cine-tools.jsx — sister tools section
 *
 * @package Vagra_NSLookup
 */

$eyebrow = $args['eyebrow'] ?? __( 'Email suite', 'vagra-nslookup' );
$heading = $args['heading'] ?? __( 'Pair DNS with deliverability.', 'vagra-nslookup' );

$default_tools = array(
	array(
		'title' => __( 'SPF Checker', 'vagra-nslookup' ),
		'desc'  => __( 'Syntax + lookup-count.', 'vagra-nslookup' ),
		'href'  => 'https://spf-checker.org/',
	),
	array(
		'title' => __( 'DKIM Checker', 'vagra-nslookup' ),
		'desc'  => __( 'Public-key retrieval.', 'vagra-nslookup' ),
		'href'  => 'https://dkim-checker.org/',
	),
	array(
		'title' => __( 'DMARC Checker', 'vagra-nslookup' ),
		'desc'  => __( 'Policy + alignment.', 'vagra-nslookup' ),
		'href'  => 'https://dmarc-checker.org/',
	),
	array(
		'title' => __( 'BIMI Checker', 'vagra-nslookup' ),
		'desc'  => __( 'BIMI + VMC verification.', 'vagra-nslookup' ),
		'href'  => 'https://bimi-checker.org/',
	),
);

$tools = $args['tools'] ?? $default_tools;
?>

<section class="cine-section" style="background:#F7F8FC">
	<div class="cine-head-wrap" style="text-align:left">
		<span class="cine-section-eyebrow reveal"><?php echo esc_html( $eyebrow ); ?></span>
		<h2 class="cine-big-head reveal reveal-delay-1">
			<?php echo wp_kses_post( $heading ); ?>
		</h2>
		<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:24px; margin-top:64px">
			<?php foreach ( $tools as $i => $tool ) : ?>
				<a href="<?php echo esc_url( $tool['href'] ); ?>" target="_blank" rel="noopener" class="reveal nsl-sister-card"
				   style="transition-delay:<?php echo esc_attr( 60 * $i ); ?>ms; padding:28px 24px; border-radius:20px; background:#fff; border:1px solid rgba(11,13,20,0.08); display:block; transition:transform 300ms, box-shadow 300ms">
					<div style="font-size:22px; font-weight:600; letter-spacing:-0.01em"><?php echo esc_html( $tool['title'] ); ?></div>
					<div style="margin-top:10px; color:rgba(11,13,20,0.55); font-size:14px"><?php echo esc_html( $tool['desc'] ); ?></div>
					<div style="margin-top:18px; color:var(--nsl-primary-600); font-size:13px; font-weight:600"><?php echo esc_html__( 'Visit', 'vagra-nslookup' ) . ' &rarr;'; ?></div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
