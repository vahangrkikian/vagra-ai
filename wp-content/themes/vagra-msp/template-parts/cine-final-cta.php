<?php
/**
 * Template part: Cinematic final CTA band.
 *
 * Dark closing CTA band with heading, primary button, and optional secondary button.
 *
 * Expected variables (via $args):
 *   $heading    string  — Main heading text (may contain HTML).
 *   $sub        string  — Optional subtitle text.
 *   $cta        string  — Primary button label.
 *   $href       string  — Primary button URL (default '#').
 *   $secondary  array   — Optional secondary button [ 'label' => '', 'href' => '' ].
 *
 * @package Vagra_MSP
 */

$heading   = $args['heading']   ?? '';
$sub       = $args['sub']       ?? '';
$cta       = $args['cta']       ?? '';
$href      = $args['href']      ?? '#';
$secondary = $args['secondary'] ?? array();
?>

<section class="cine-final-cta">
	<div class="cine-final-cta__gradient" aria-hidden="true"></div>
	<div class="site-container cine-final-cta__inner">
		<h2 class="cine-final-cta__heading"><?php echo wp_kses_post( $heading ); ?></h2>

		<?php if ( ! empty( $sub ) ) : ?>
			<p class="cine-final-cta__sub"><?php echo esc_html( $sub ); ?></p>
		<?php endif; ?>

		<div class="cine-final-cta__actions">
			<a href="<?php echo esc_url( $href ); ?>" class="vagra-button vagra-button--white vagra-button--lg"><?php echo esc_html( $cta ); ?></a>
			<?php if ( ! empty( $secondary ) ) : ?>
				<a href="<?php echo esc_url( $secondary['href'] ?? '#' ); ?>" class="vagra-button vagra-button--ghost vagra-button--lg"><?php echo esc_html( $secondary['label'] ?? '' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
