<?php
/**
 * Template part: Cinematic stat strip.
 *
 * Displays key metrics in a horizontal stat band (30+ resolvers, 6 continents, 13 types, $0).
 *
 * Expected variables (via $args):
 *   $stats  array  — Optional override array of [ 'number' => '', 'label' => '' ] items.
 *                    Defaults to the standard 4-stat set.
 *
 * Ported from: nslookup/project/shared/page-cine-home.jsx — CineStatement stats block
 *
 * @package Vagra_NSLookup
 */

$default_stats = array(
	array( 'number' => '30+', 'label' => __( 'Global resolvers', 'vagra-nslookup' ) ),
	array( 'number' => '6',   'label' => __( 'Continents', 'vagra-nslookup' ) ),
	array( 'number' => '13',  'label' => __( 'Record types', 'vagra-nslookup' ) ),
	array( 'number' => '0',   'label' => __( 'Dollars to use', 'vagra-nslookup' ) ),
);

$stats = $args['stats'] ?? $default_stats;
?>

<div class="cine-stats">
	<?php foreach ( $stats as $stat ) : ?>
		<div class="cine-stat reveal">
			<div class="cine-stat-num"><?php echo esc_html( $stat['number'] ); ?></div>
			<div class="cine-stat-lbl"><?php echo esc_html( $stat['label'] ); ?></div>
		</div>
	<?php endforeach; ?>
</div>
