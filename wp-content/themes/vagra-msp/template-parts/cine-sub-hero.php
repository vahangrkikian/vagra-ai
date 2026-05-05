<?php
/**
 * Template part: Cinematic sub-page hero.
 *
 * Dark cinematic hero used by every non-homepage page.
 *
 * Expected variables (via $args):
 *   $eyebrow  string  — Eyebrow text above the heading.
 *   $title    string  — Main h1 text (may contain HTML).
 *   $lede     string  — Optional lead paragraph below the heading.
 *   $crumb    array   — Optional breadcrumb array of [ 'label' => '', 'href' => '' ] items.
 *
 * @package Vagra_MSP
 */

$eyebrow = $args['eyebrow'] ?? '';
$title   = $args['title']   ?? '';
$lede    = $args['lede']    ?? '';
$crumb   = $args['crumb']   ?? array();
?>

<section class="cine-sub-hero" aria-label="<?php echo esc_attr( $eyebrow ); ?>">
	<div class="cine-sub-hero__gradient" aria-hidden="true"></div>
	<div class="cine-sub-hero__grid" aria-hidden="true"></div>
	<div class="site-container cine-sub-hero__inner">
		<?php if ( ! empty( $crumb ) ) : ?>
			<nav class="vagra-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-msp' ); ?>">
				<?php foreach ( $crumb as $i => $item ) : ?>
					<?php if ( $i > 0 ) : ?>
						<span class="vagra-crumb__sep">&rsaquo;</span>
					<?php endif; ?>
					<?php if ( ! empty( $item['href'] ) ) : ?>
						<a href="<?php echo esc_url( $item['href'] ); ?>" class="vagra-crumb__link"><?php echo esc_html( $item['label'] ); ?></a>
					<?php else : ?>
						<span class="vagra-crumb__current"><?php echo esc_html( $item['label'] ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<span class="cine-sub-hero__eyebrow"><span class="cine-sub-hero__dot"></span> <?php echo esc_html( $eyebrow ); ?></span>

		<h1 class="cine-sub-hero__title">
			<?php echo wp_kses_post( $title ); ?>
		</h1>

		<?php if ( ! empty( $lede ) ) : ?>
			<p class="cine-sub-hero__lede">
				<?php echo esc_html( $lede ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
