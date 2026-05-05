<?php
/**
 * Template part: Cinematic final CTA band.
 *
 * Dark closing CTA band with large heading, primary button, and optional ghost button.
 * Used at the bottom of every page for rhythm.
 *
 * Expected variables (via $args):
 *   $heading    string  — Main heading text (may contain HTML).
 *   $sub        string  — Optional subtitle text.
 *   $cta        string  — Primary button label.
 *   $href       string  — Primary button URL (default '#').
 *   $secondary  array   — Optional secondary button [ 'label' => '', 'href' => '' ].
 *
 * Ported from: nslookup/project/shared/page-cine-parts.jsx — CineFinalCTA
 *
 * @package Vagra_NSLookup
 */

$heading   = $args['heading']   ?? '';
$sub       = $args['sub']       ?? '';
$cta       = $args['cta']       ?? '';
$href      = $args['href']      ?? '#';
$secondary = $args['secondary'] ?? array();
?>

<section class="cine-final">
	<h2 class="cine-final-h reveal"><?php echo wp_kses_post( $heading ); ?></h2>

	<?php if ( ! empty( $sub ) ) : ?>
		<p class="reveal reveal-delay-1"><?php echo esc_html( $sub ); ?></p>
	<?php endif; ?>

	<div class="cine-cta-row reveal reveal-delay-2">
		<a href="<?php echo esc_url( $href ); ?>" class="cine-btn cine-btn-primary"><?php echo esc_html( $cta ); ?></a>
		<?php if ( ! empty( $secondary ) ) : ?>
			<a href="<?php echo esc_url( $secondary['href'] ?? '#' ); ?>" class="cine-btn cine-btn-ghost"><?php echo esc_html( $secondary['label'] ?? '' ); ?></a>
		<?php endif; ?>
	</div>
</section>
