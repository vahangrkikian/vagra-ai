<?php
/**
 * Template part: FAQ accordion using <details>/<summary> (pure CSS animation).
 *
 * Expected variables (via $args):
 *   $categories  array  — Array of FAQ categories.
 *                         Each: [ 'cat' => 'Category name', 'items' => [ [ 'q' => '', 'a' => '' ], ... ] ]
 *
 * Ported from: nslookup/project/shared/page-cine-faq.jsx — CINE_FAQS accordion
 *
 * @package Vagra_NSLookup
 */

$categories = $args['categories'] ?? array();

if ( empty( $categories ) ) {
	return;
}
?>

<section class="cine-section" style="background:#fff; padding-top:40px">
	<div class="container" style="max-width:880px; padding:0 32px">
		<?php foreach ( $categories as $ci => $cat ) : ?>
			<div class="reveal" style="transition-delay:<?php echo esc_attr( $ci * 80 ); ?>ms; margin-bottom:56px">
				<div style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.14em; color:rgba(11,13,20,0.4); margin-bottom:20px">
					<?php echo esc_html( str_pad( (string) ( $ci + 1 ), 2, '0', STR_PAD_LEFT ) ); ?> &mdash; <?php echo esc_html( $cat['cat'] ); ?>
				</div>
				<div style="display:flex; flex-direction:column">
					<?php foreach ( $cat['items'] as $item ) : ?>
						<details class="faq-item">
							<summary>
								<span style="font-size:20px; font-weight:500; letter-spacing:-0.01em; color:var(--nsl-ink)"><?php echo esc_html( $item['q'] ); ?></span>
							</summary>
							<div class="faq-body">
								<p style="font-size:16px; line-height:1.65; color:rgba(11,13,20,0.7); max-width:680px">
									<?php echo wp_kses_post( $item['a'] ); ?>
								</p>
							</div>
						</details>
					<?php endforeach; ?>
					<div style="border-top:1px solid rgba(11,13,20,0.08)"></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
