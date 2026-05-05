<?php
/**
 * Template Name: Contact
 *
 * Contact page with form mount point and sidebar info.
 * Ported from: nslookup/project/shared/page-cine-contact.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-contact">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Contact', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Say hello.', 'vagra-nslookup' ), esc_html__( 'A real human replies.', 'vagra-nslookup' ) ),
		'lede'    => __( 'No ticketing system, no AI chatbot, no "we\'ll get back to you in 3–5 business days." Send us a note — one of the four of us reads it, usually within a day.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Contact', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<section class="cine-section" style="background:#fff; padding-top:40px">
		<div class="container" style="max-width:1100px; padding:0 32px; display:grid; grid-template-columns:1.3fr 1fr; gap:64px">
			<?php // ─── React island: Contact form ─── ?>
			<div id="nsl-contact-form" class="reveal">
				<?php // Fallback static form for no-JS / SEO ?>
				<noscript>
					<form method="post" style="padding:40px; background:#fff; border-radius:24px; border:1px solid rgba(11,13,20,0.08); box-shadow:0 20px 50px rgba(11,13,20,0.05)">
						<p><label for="nsl-contact-name"><?php esc_html_e( 'Name', 'vagra-nslookup' ); ?></label><br/><input type="text" id="nsl-contact-name" name="name" required /></p>
						<p><label for="nsl-contact-email"><?php esc_html_e( 'Email', 'vagra-nslookup' ); ?></label><br/><input type="email" id="nsl-contact-email" name="email" required /></p>
						<p><label for="nsl-contact-message"><?php esc_html_e( 'Message', 'vagra-nslookup' ); ?></label><br/><textarea id="nsl-contact-message" name="message" rows="6" required></textarea></p>
						<p><button type="submit" class="cine-btn cine-btn-primary"><?php esc_html_e( 'Send message', 'vagra-nslookup' ); ?></button></p>
					</form>
				</noscript>
			</div>

			<?php // ─── Side info ─── ?>
			<aside class="reveal reveal-delay-1" style="display:flex; flex-direction:column; gap:28px">
				<div>
					<div style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.12em; color:rgba(11,13,20,0.45)"><?php esc_html_e( 'DIRECT', 'vagra-nslookup' ); ?></div>
					<a href="mailto:hello@nslookup.am" style="margin-top:10px; display:block; font-size:22px; font-weight:600; color:var(--nsl-ink); letter-spacing:-0.01em">hello@nslookup.am</a>
				</div>
				<div>
					<div style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.12em; color:rgba(11,13,20,0.45)"><?php esc_html_e( 'SECURITY', 'vagra-nslookup' ); ?></div>
					<a href="mailto:security@nslookup.am" style="margin-top:10px; display:block; font-size:16px; font-weight:600; color:var(--nsl-ink)">security@nslookup.am</a>
					<div style="margin-top:6px; font-size:13px; color:rgba(11,13,20,0.55)">PGP: 0x9F3A 1E2C 88BD</div>
				</div>
				<div>
					<div style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.12em; color:rgba(11,13,20,0.45)"><?php esc_html_e( 'ELSEWHERE', 'vagra-nslookup' ); ?></div>
					<div style="margin-top:10px; display:flex; flex-direction:column; gap:8px">
						<a href="#" style="color:var(--nsl-ink); font-size:14px">&rarr; github.com/nslookup-am</a>
						<a href="#" style="color:var(--nsl-ink); font-size:14px">&rarr; @nslookup_am</a>
						<a href="#" style="color:var(--nsl-ink); font-size:14px">&rarr; status.nslookup.am</a>
					</div>
				</div>
				<div style="margin-top:auto; padding:20px; background:#F7F8FC; border-radius:16px; font-size:13px; color:rgba(11,13,20,0.65); line-height:1.55">
					<strong style="color:var(--nsl-ink)"><?php esc_html_e( 'Typical reply times.', 'vagra-nslookup' ); ?></strong><br/>
					<?php esc_html_e( 'General — within 24h weekdays.', 'vagra-nslookup' ); ?><br/>
					<?php esc_html_e( 'Security — within 4h, always.', 'vagra-nslookup' ); ?>
				</div>
			</aside>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => esc_html__( 'Rather read first?', 'vagra-nslookup' ),
		'sub'       => __( 'The blog answers most common questions.', 'vagra-nslookup' ),
		'cta'       => __( 'Visit the blog', 'vagra-nslookup' ),
		'href'      => home_url( '/blog/' ),
		'secondary' => array(
			'label' => __( 'See the FAQ', 'vagra-nslookup' ),
			'href'  => home_url( '/faq/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
