<?php
/**
 * Template part: Cinematic sub-page hero.
 *
 * Dark cinematic hero used by every non-homepage page for consistent Apple energy.
 *
 * Expected variables (via $args or extract):
 *   $eyebrow  string  — Eyebrow text above the heading.
 *   $title    string  — Main h1 text (may contain HTML).
 *   $lede     string  — Optional lead paragraph below the heading.
 *   $crumb    array   — Optional breadcrumb array of [ 'label' => '', 'href' => '' ] items.
 *
 * Ported from: nslookup/project/shared/page-cine-parts.jsx — CineSubHero
 *
 * @package Vagra_NSLookup
 */

$eyebrow = $args['eyebrow'] ?? '';
$title   = $args['title']   ?? '';
$lede    = $args['lede']    ?? '';
$crumb   = $args['crumb']   ?? array();
?>

<section class="cine-hero" style="min-height:auto">
	<div class="container cine-hero-inner" style="grid-template-columns:1fr; padding:120px 0 72px; max-width:960px">
		<div>
			<?php if ( ! empty( $crumb ) ) : ?>
				<div class="reveal" style="margin-bottom:28px">
					<nav class="nsl-crumb" style="color:rgba(255,255,255,0.5)" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-nslookup' ); ?>">
						<?php foreach ( $crumb as $i => $item ) : ?>
							<?php if ( $i > 0 ) : ?>
								<span class="nsl-crumb-sep" style="color:rgba(255,255,255,0.2)">&rsaquo;</span>
							<?php endif; ?>
							<?php if ( ! empty( $item['href'] ) ) : ?>
								<a href="<?php echo esc_url( $item['href'] ); ?>" style="color:rgba(255,255,255,0.6)"><?php echo esc_html( $item['label'] ); ?></a>
							<?php else : ?>
								<span style="color:#fff"><?php echo esc_html( $item['label'] ); ?></span>
							<?php endif; ?>
						<?php endforeach; ?>
					</nav>
				</div>
			<?php endif; ?>

			<span class="cine-eyebrow reveal"><span class="dot"></span> <?php echo esc_html( $eyebrow ); ?></span>

			<h1 class="cine-h1 reveal reveal-delay-1" style="margin-top:24px; font-size:clamp(40px, 5.6vw, 76px)">
				<?php echo wp_kses_post( $title ); ?>
			</h1>

			<?php if ( ! empty( $lede ) ) : ?>
				<p class="cine-lede reveal reveal-delay-2" style="max-width:680px; margin-top:28px">
					<?php echo esc_html( $lede ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
