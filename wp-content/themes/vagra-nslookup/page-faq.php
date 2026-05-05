<?php
/**
 * Template Name: FAQ
 *
 * FAQ page with 4-category accordion.
 * Ported from: nslookup/project/shared/page-cine-faq.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-faq">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'FAQ', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'The questions', 'vagra-nslookup' ), esc_html__( 'we actually get asked.', 'vagra-nslookup' ) ),
		'lede'    => __( 'If your question isn\'t here, email us — we\'ll answer and add it.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'FAQ', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<?php
	$faq_categories = array(
		array(
			'cat'   => __( 'The basics', 'vagra-nslookup' ),
			'items' => array(
				array( 'q' => __( 'Is nslookup.am really free?', 'vagra-nslookup' ), 'a' => __( 'Yes. Free forever, no signup, no rate walls, no "free trial." We cover the compute. If we ever need to charge, we will say so loudly — not hide it behind a credit card form.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Do I need an account?', 'vagra-nslookup' ), 'a' => __( 'No. No account, no cookies beyond a single preference cookie for dark mode. Your queries are not logged to any profile.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'What record types do you support?', 'vagra-nslookup' ), 'a' => __( 'Thirteen: A, AAAA, CNAME, MX, NS, SOA, TXT, CAA, PTR, SRV, TLSA, DNSKEY, DS. Coverage is adding as people request more.', 'vagra-nslookup' ) ),
			),
		),
		array(
			'cat'   => __( 'How it works', 'vagra-nslookup' ),
			'items' => array(
				array( 'q' => __( 'Where do your resolvers live?', 'vagra-nslookup' ), 'a' => __( 'Thirty-plus public and private resolvers across six continents: Ashburn, San Francisco, Frankfurt, Tokyo, Singapore, São Paulo, Johannesburg, Sydney, Mumbai, and more. Full list on the propagation page.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'How fast is a lookup?', 'vagra-nslookup' ), 'a' => __( 'Sub-second globally for cached answers, 1.5s worst-case for cold queries that have to walk the tree.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Do you query authoritative or recursive nameservers?', 'vagra-nslookup' ), 'a' => __( 'Both, depending on the tool. NS Lookup pulls authoritative. Propagation Checker queries recursive resolvers so you see what real users see.', 'vagra-nslookup' ) ),
			),
		),
		array(
			'cat'   => __( 'Privacy & security', 'vagra-nslookup' ),
			'items' => array(
				array( 'q' => __( 'Do you log my queries?', 'vagra-nslookup' ), 'a' => __( 'We keep aggregate volume metrics (how many queries per hour, per tool) for capacity planning. We do not associate queries with your IP, email, or anything identifying.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Do you share data with third parties?', 'vagra-nslookup' ), 'a' => __( 'No. We have no advertisers, no analytics vendors, no data brokers in the pipeline.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Can I self-host?', 'vagra-nslookup' ), 'a' => __( 'An open-source resolver-fanout server is on the roadmap for Q3 2026. Email us if you need it sooner.', 'vagra-nslookup' ) ),
			),
		),
		array(
			'cat'   => __( 'For developers', 'vagra-nslookup' ),
			'items' => array(
				array( 'q' => __( 'Is there an API?', 'vagra-nslookup' ), 'a' => __( 'Yes, a free JSON API mirroring every tool on the site. Docs at api.nslookup.am. Rate limit is 60 req/min per IP — email us for higher if you are building something real.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Do you have webhooks?', 'vagra-nslookup' ), 'a' => __( 'Not yet. Monitor-style webhooks for record changes are on the roadmap.', 'vagra-nslookup' ) ),
				array( 'q' => __( 'Can I link directly to results?', 'vagra-nslookup' ), 'a' => __( 'Yes. Every query is URL-addressable, e.g. nslookup.am/ns/example.com — shareable, bookmarkable, safe.', 'vagra-nslookup' ) ),
			),
		),
	);

	get_template_part( 'template-parts/faq-accordion', null, array( 'categories' => $faq_categories ) );
	?>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => esc_html__( 'Still curious?', 'vagra-nslookup' ),
		'sub'       => __( 'We answer everything, even bad questions.', 'vagra-nslookup' ),
		'cta'       => __( 'Email us', 'vagra-nslookup' ),
		'href'      => home_url( '/contact/' ),
	) );
	?>

</main>

<?php get_footer(); ?>
