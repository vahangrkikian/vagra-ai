<?php
/**
 * Meta Boxes for all page templates.
 *
 * Registers meta boxes that expose editable content fields for every
 * page template in the theme.  Each meta key follows the naming convention:
 *   _vagra_nsl_{template}_{section}_{field}
 *
 * Repeater-style data (FAQs, team, stats, tools, etc.) is stored as
 * serialized arrays in a single meta key per group.
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper: get a post-meta value with a fallback default.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function vagra_nsl_meta( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );
	if ( '' === $value || false === $value ) {
		return $default;
	}
	return $value;
}

/* ──────────────────────────────────────────────────────────────
 * 1.  Register meta boxes based on page template.
 * ────────────────────────────────────────────────────────────── */

add_action( 'add_meta_boxes', 'vagra_nsl_register_meta_boxes' );

function vagra_nsl_register_meta_boxes() {
	global $post;

	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$template = get_page_template_slug( $post->ID );
	$is_front = ( (int) get_option( 'page_on_front' ) === $post->ID );

	// front-page.php is used when a static page is set as front page.
	if ( $is_front ) {
		vagra_nsl_add_front_page_meta_boxes();
	}

	$map = array(
		'page-about.php'       => 'vagra_nsl_add_about_meta_boxes',
		'page-contact.php'     => 'vagra_nsl_add_contact_meta_boxes',
		'page-faq.php'         => 'vagra_nsl_add_faq_meta_boxes',
		'page-tools.php'       => 'vagra_nsl_add_tools_meta_boxes',
		'page-ns-lookup.php'   => 'vagra_nsl_add_ns_lookup_meta_boxes',
		'page-propagation.php' => 'vagra_nsl_add_propagation_meta_boxes',
		'page-privacy.php'     => 'vagra_nsl_add_privacy_meta_boxes',
		'page-terms.php'       => 'vagra_nsl_add_terms_meta_boxes',
	);

	if ( isset( $map[ $template ] ) ) {
		call_user_func( $map[ $template ] );
	}
}

/* ──────────────────────────────────────────────────────────────
 * 2.  Meta-box registration helpers per template.
 * ────────────────────────────────────────────────────────────── */

// --- Front Page ------------------------------------------------

function vagra_nsl_add_front_page_meta_boxes() {
	add_meta_box( 'vagra_nsl_fp_hero',      'Front Page — Hero Section',      'vagra_nsl_fp_hero_cb',      'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_fp_statement',  'Front Page — Statement Section', 'vagra_nsl_fp_statement_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_fp_why',        'Front Page — Why Section',       'vagra_nsl_fp_why_cb',       'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_fp_faq',        'Front Page — FAQ Section',       'vagra_nsl_fp_faq_cb',       'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_fp_blog',       'Front Page — Blog Section',      'vagra_nsl_fp_blog_cb',      'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_fp_cta',        'Front Page — Final CTA',         'vagra_nsl_fp_cta_cb',       'page', 'normal', 'default' );
}

// --- About -----------------------------------------------------

function vagra_nsl_add_about_meta_boxes() {
	add_meta_box( 'vagra_nsl_about_hero',       'About — Hero',       'vagra_nsl_about_hero_cb',       'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_about_manifesto',  'About — Manifesto',  'vagra_nsl_about_manifesto_cb',  'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_about_principles', 'About — Principles', 'vagra_nsl_about_principles_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_about_stats',      'About — Stats',      'vagra_nsl_about_stats_cb',      'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_about_team',       'About — Team',       'vagra_nsl_about_team_cb',       'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_about_cta',        'About — Final CTA',  'vagra_nsl_about_cta_cb',        'page', 'normal', 'default' );
}

// --- Contact ---------------------------------------------------

function vagra_nsl_add_contact_meta_boxes() {
	add_meta_box( 'vagra_nsl_contact_hero', 'Contact — Hero',    'vagra_nsl_contact_hero_cb', 'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_contact_info', 'Contact — Info',    'vagra_nsl_contact_info_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_contact_cta',  'Contact — Final CTA', 'vagra_nsl_contact_cta_cb',  'page', 'normal', 'default' );
}

// --- FAQ -------------------------------------------------------

function vagra_nsl_add_faq_meta_boxes() {
	add_meta_box( 'vagra_nsl_faq_hero',  'FAQ — Hero',  'vagra_nsl_faq_hero_cb',  'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_faq_items', 'FAQ — Items', 'vagra_nsl_faq_items_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_faq_cta',   'FAQ — Final CTA', 'vagra_nsl_faq_cta_cb',   'page', 'normal', 'default' );
}

// --- Tools -----------------------------------------------------

function vagra_nsl_add_tools_meta_boxes() {
	add_meta_box( 'vagra_nsl_tools_hero',  'Tools — Hero',  'vagra_nsl_tools_hero_cb',  'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_tools_grid',  'Tools — Grid',  'vagra_nsl_tools_grid_cb',  'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_tools_cta',   'Tools — Final CTA', 'vagra_nsl_tools_cta_cb',   'page', 'normal', 'default' );
}

// --- NS Lookup -------------------------------------------------

function vagra_nsl_add_ns_lookup_meta_boxes() {
	add_meta_box( 'vagra_nsl_ns_hero',     'NS Lookup — Hero',     'vagra_nsl_ns_hero_cb',     'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_ns_features', 'NS Lookup — Features', 'vagra_nsl_ns_features_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_ns_faq',      'NS Lookup — FAQ',      'vagra_nsl_ns_faq_cb',      'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_ns_cta',      'NS Lookup — Final CTA','vagra_nsl_ns_cta_cb',      'page', 'normal', 'default' );
}

// --- Propagation -----------------------------------------------

function vagra_nsl_add_propagation_meta_boxes() {
	add_meta_box( 'vagra_nsl_prop_hero',      'Propagation — Hero',      'vagra_nsl_prop_hero_cb',      'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_prop_explainer', 'Propagation — Explainer', 'vagra_nsl_prop_explainer_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_prop_faq',       'Propagation — FAQ',       'vagra_nsl_prop_faq_cb',       'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_prop_cta',       'Propagation — Final CTA', 'vagra_nsl_prop_cta_cb',       'page', 'normal', 'default' );
}

// --- Privacy ---------------------------------------------------

function vagra_nsl_add_privacy_meta_boxes() {
	add_meta_box( 'vagra_nsl_privacy_hero',     'Privacy — Hero',     'vagra_nsl_privacy_hero_cb',     'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_privacy_sections', 'Privacy — Sections', 'vagra_nsl_privacy_sections_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_privacy_cta',      'Privacy — Final CTA','vagra_nsl_privacy_cta_cb',      'page', 'normal', 'default' );
}

// --- Terms -----------------------------------------------------

function vagra_nsl_add_terms_meta_boxes() {
	add_meta_box( 'vagra_nsl_terms_hero',     'Terms — Hero',     'vagra_nsl_terms_hero_cb',     'page', 'normal', 'high' );
	add_meta_box( 'vagra_nsl_terms_sections', 'Terms — Sections', 'vagra_nsl_terms_sections_cb', 'page', 'normal', 'default' );
	add_meta_box( 'vagra_nsl_terms_cta',      'Terms — Final CTA','vagra_nsl_terms_cta_cb',      'page', 'normal', 'default' );
}

/* ──────────────────────────────────────────────────────────────
 * 3.  Render helpers.
 * ────────────────────────────────────────────────────────────── */

/**
 * Render a text input field inside a meta box.
 */
function vagra_nsl_field_text( $post_id, $key, $label, $default = '' ) {
	$value = vagra_nsl_meta( $post_id, $key, $default );
	printf(
		'<p><label><strong>%s</strong><br/><input type="text" name="%s" value="%s" class="widefat" /></label></p>',
		esc_html( $label ),
		esc_attr( $key ),
		esc_attr( $value )
	);
}

/**
 * Render a textarea field inside a meta box.
 */
function vagra_nsl_field_textarea( $post_id, $key, $label, $default = '', $rows = 3 ) {
	$value = vagra_nsl_meta( $post_id, $key, $default );
	printf(
		'<p><label><strong>%s</strong><br/><textarea name="%s" class="widefat" rows="%d">%s</textarea></label></p>',
		esc_html( $label ),
		esc_attr( $key ),
		(int) $rows,
		esc_textarea( $value )
	);
}

/**
 * Render a repeater field stored as JSON.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param string $label   Section label.
 * @param array  $fields  Array of sub-field definitions: array( 'key' => 'q', 'label' => 'Question', 'type' => 'text' ).
 * @param array  $default Default rows.
 */
function vagra_nsl_field_repeater( $post_id, $key, $label, $fields, $default = array() ) {
	$rows = vagra_nsl_meta( $post_id, $key, '' );
	if ( is_string( $rows ) && '' !== $rows ) {
		$rows = json_decode( $rows, true );
	}
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		$rows = $default;
	}

	$fields_json  = esc_attr( wp_json_encode( $fields ) );
	$repeater_id  = esc_attr( $key );
	?>
	<div class="vagra-repeater" data-key="<?php echo $repeater_id; ?>" data-fields="<?php echo $fields_json; ?>">
		<h4><?php echo esc_html( $label ); ?></h4>
		<div class="vagra-repeater-rows">
			<?php foreach ( $rows as $ri => $row ) : ?>
				<div class="vagra-repeater-row" style="border:1px solid #ddd; padding:12px; margin-bottom:8px; background:#fafafa; position:relative;">
					<button type="button" class="vagra-repeater-remove" style="position:absolute; top:4px; right:4px; cursor:pointer;">&times;</button>
					<?php foreach ( $fields as $f ) :
						$fname = esc_attr( $key ) . '[' . $ri . '][' . esc_attr( $f['key'] ) . ']';
						$fval  = isset( $row[ $f['key'] ] ) ? $row[ $f['key'] ] : '';
					?>
						<p>
							<label><strong><?php echo esc_html( $f['label'] ); ?></strong><br/>
							<?php if ( 'textarea' === ( $f['type'] ?? 'text' ) ) : ?>
								<textarea name="<?php echo esc_attr( $fname ); ?>" class="widefat" rows="2"><?php echo esc_textarea( $fval ); ?></textarea>
							<?php else : ?>
								<input type="text" name="<?php echo esc_attr( $fname ); ?>" value="<?php echo esc_attr( $fval ); ?>" class="widefat" />
							<?php endif; ?>
							</label>
						</p>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<button type="button" class="button vagra-repeater-add"><?php esc_html_e( '+ Add Row', 'vagra-nslookup' ); ?></button>
	</div>
	<?php
}

/**
 * Output nonce field (once per save action).
 */
function vagra_nsl_nonce_field() {
	wp_nonce_field( 'vagra_nsl_save_meta', '_vagra_nsl_meta_nonce' );
}

/* ──────────────────────────────────────────────────────────────
 * 4.  Meta-box callbacks — FRONT PAGE.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_fp_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_eyebrow', 'Eyebrow', '30+ resolvers · live now' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_h1_line1', 'Heading line 1', 'DNS propagation, checked' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_h1_accent', 'Heading accent word', 'globally.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_fp_hero_lede', 'Lead paragraph', 'Query thirteen DNS record types across thirty public resolvers on six continents. Watch propagation roll out in real time. Free, instant, zero signup.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_cta_primary', 'Primary CTA label', 'Check DNS Now' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_cta_secondary', 'Secondary CTA label', 'How it works' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_trust_1', 'Trust badge 1', 'No signup' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_trust_2', 'Trust badge 2', 'No rate limits' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_hero_trust_3', 'Trust badge 3', '13 record types' );
}

function vagra_nsl_fp_statement_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_stmt_eyebrow', 'Eyebrow', 'The method' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_fp_stmt_heading', 'Heading (HTML allowed for <span> tags)', 'One query. Thirty answers. A complete picture of your DNS, everywhere at once.' );
}

function vagra_nsl_fp_why_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_why_eyebrow', 'Eyebrow', 'Why nslookup.am' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_fp_why_heading', 'Heading', 'The DNS tool you wanted the last time you were stuck at 2am.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_fp_why_items', 'Why Items', array(
		array( 'key' => 'icon',  'label' => 'Icon (HTML entity)', 'type' => 'text' ),
		array( 'key' => 'title', 'label' => 'Title',              'type' => 'text' ),
		array( 'key' => 'body',  'label' => 'Description',        'type' => 'textarea' ),
	), array(
		array( 'icon' => '&#9889;',  'title' => 'Instant results',  'body' => 'Parallel queries return in under 2 seconds. No waiting, no polling.' ),
		array( 'icon' => '&#127758;','title' => 'Global coverage',  'body' => '30+ public DNS servers across 6 continents, updated continuously.' ),
		array( 'icon' => '&#8734;',  'title' => 'Free forever',     'body' => 'Every record, every region, no paid tier, no account required.' ),
		array( 'icon' => '&#9702;',  'title' => 'No setup',         'body' => 'Browser-only. Paste a domain, hit lookup, see the world answer.' ),
	) );
}

function vagra_nsl_fp_faq_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_fp_faq_items', 'Home FAQ Items', array(
		array( 'key' => 'cat', 'label' => 'Category', 'type' => 'text' ),
		array( 'key' => 'q',   'label' => 'Question', 'type' => 'text' ),
		array( 'key' => 'a',   'label' => 'Answer',   'type' => 'textarea' ),
	), array(
		array( 'cat' => 'General',   'q' => 'What is nslookup.am?', 'a' => 'A free, browser-based DNS lookup and propagation checker. Enter any domain and instantly query 13 record types across 30+ global resolvers.' ),
		array( 'cat' => 'General',   'q' => 'Is it really free?',   'a' => 'Yes. No signup, no rate limits, no paid tier. Every feature is available to everyone.' ),
		array( 'cat' => 'General',   'q' => 'How many resolvers do you query?', 'a' => 'Over 30 public DNS resolvers spread across 6 continents, queried in parallel for speed.' ),
		array( 'cat' => 'Technical', 'q' => 'What record types are supported?', 'a' => 'A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, and SRV — 13 in total.' ),
		array( 'cat' => 'Technical', 'q' => 'How does propagation checking work?', 'a' => 'We query every resolver simultaneously and compare results. You see which resolvers have the current record and which are still caching an older value.' ),
	) );
}

function vagra_nsl_fp_blog_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_blog_eyebrow', 'Eyebrow', 'Field notes' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_blog_heading', 'Heading', 'From the blog' );
}

function vagra_nsl_fp_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_cta_heading_line1', 'Heading line 1', 'Check DNS' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_cta_heading_accent', 'Heading accent', "like it's 2026." );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_fp_cta_sub', 'Sub-text', 'Free. Instant. Worldwide. The DNS diagnostic tool built for the ones shipping at 2am.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_cta_label', 'CTA button label', 'Start a lookup' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_fp_cta_secondary_label', 'Secondary link label', 'Read the field notes' );
}

/* ──────────────────────────────────────────────────────────────
 * 5.  Meta-box callbacks — ABOUT.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_about_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_hero_eyebrow', 'Eyebrow', 'About' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_hero_title_line1', 'Title line 1', 'Built by people' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_hero_title_accent', 'Title accent', 'who live in the terminal.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_about_hero_lede', 'Lead paragraph', "nslookup.am is a small team of infrastructure engineers who got tired of DNS tools that hide their work behind paywalls, newsletter prompts, and rate limits. So we built one that doesn't." );
}

function vagra_nsl_about_manifesto_cb( $post ) {
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_about_manifesto_text', 'Manifesto text', 'DNS is the substrate. When it breaks, everything breaks. The tools that diagnose it should be as fast, free, and reliable as the protocol itself.', 4 );
}

function vagra_nsl_about_principles_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_principles_eyebrow', 'Eyebrow', 'Principles' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_principles_heading_line1', 'Heading line 1', 'Four things' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_principles_heading_muted', 'Heading muted', 'we refuse to compromise.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_about_principles_items', 'Principles', array(
		array( 'key' => 'n', 'label' => 'Number', 'type' => 'text' ),
		array( 'key' => 't', 'label' => 'Title',  'type' => 'text' ),
		array( 'key' => 'd', 'label' => 'Description', 'type' => 'textarea' ),
	), array(
		array( 'n' => '01', 't' => 'Free forever',                  'd' => 'No rate walls, no signup, no "enter your email to continue." If it costs us compute, we cover it.' ),
		array( 'n' => '02', 't' => 'Accurate by default',            'd' => 'We fan every query out across 30+ resolvers and show you the raw variance, not a summary.' ),
		array( 'n' => '03', 't' => 'No dark patterns',               'd' => 'No newsletter modals, no autoplay video, no affiliate "recommendations." Just the lookup.' ),
		array( 'n' => '04', 't' => 'Fast enough to use constantly',  'd' => 'Sub-second response globally. The tool should feel like a terminal command, not a webapp.' ),
	) );
}

function vagra_nsl_about_stats_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_about_stats_items', 'Stats', array(
		array( 'key' => 'n', 'label' => 'Number/Value', 'type' => 'text' ),
		array( 'key' => 'l', 'label' => 'Label',        'type' => 'text' ),
	), array(
		array( 'n' => '30+',  'l' => 'Global resolvers' ),
		array( 'n' => '6',    'l' => 'Continents covered' ),
		array( 'n' => '2.1M', 'l' => 'Queries per month' ),
		array( 'n' => '0',    'l' => 'Ads, ever' ),
	) );
}

function vagra_nsl_about_team_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_team_eyebrow', 'Eyebrow', 'Team' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_team_heading_line1', 'Heading line 1', 'Small, senior,' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_team_heading_muted', 'Heading muted', 'focused.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_about_team_members', 'Team Members', array(
		array( 'key' => 'n',  'label' => 'Name',       'type' => 'text' ),
		array( 'key' => 'r',  'label' => 'Role',       'type' => 'text' ),
		array( 'key' => 'i',  'label' => 'Initials',   'type' => 'text' ),
		array( 'key' => 'bg', 'label' => 'Gradient CSS', 'type' => 'text' ),
	), array(
		array( 'n' => 'Ana Vartanian',       'r' => 'Infrastructure',  'i' => 'AV', 'bg' => 'linear-gradient(135deg,#4F46E5,#818CF8)' ),
		array( 'n' => 'Marek Holl&oacute;s', 'r' => 'Backend & APIs', 'i' => 'MH', 'bg' => 'linear-gradient(135deg,#0E7490,#22D3EE)' ),
		array( 'n' => 'Priya Iyer',          'r' => 'Frontend & UX',  'i' => 'PI', 'bg' => 'linear-gradient(135deg,#059669,#34D399)' ),
		array( 'n' => 'Tom&aacute;s del Campo','r' => 'DNS Research', 'i' => 'TC', 'bg' => 'linear-gradient(135deg,#D97706,#FCD34D)' ),
	) );
}

function vagra_nsl_about_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_cta_heading_line1', 'Heading line 1', 'Questions,' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_cta_heading_accent', 'Heading accent', 'ideas, or bugs?' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_about_cta_sub', 'Sub-text', 'We read every message. No support ticket system, no AI chatbot.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_cta_label', 'CTA label', 'Get in touch' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_about_cta_secondary_label', 'Secondary label', 'Read the blog' );
}

/* ──────────────────────────────────────────────────────────────
 * 6.  Meta-box callbacks — CONTACT.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_contact_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_hero_eyebrow', 'Eyebrow', 'Contact' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_hero_title_line1', 'Title line 1', 'Say hello.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_hero_title_accent', 'Title accent', 'A real human replies.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_contact_hero_lede', 'Lead paragraph', "No ticketing system, no AI chatbot, no \"we'll get back to you in 3–5 business days.\" Send us a note — one of the four of us reads it, usually within a day." );
}

function vagra_nsl_contact_info_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_email', 'Contact email', 'hello@nslookup.am' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_security_email', 'Security email', 'security@nslookup.am' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_pgp', 'PGP fingerprint', 'PGP: 0x9F3A 1E2C 88BD' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_link_1', 'Link 1', 'github.com/nslookup-am' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_link_2', 'Link 2', '@nslookup_am' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_link_3', 'Link 3', 'status.nslookup.am' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_reply_general', 'General reply time', 'General — within 24h weekdays.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_reply_security', 'Security reply time', 'Security — within 4h, always.' );
}

function vagra_nsl_contact_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_cta_heading', 'CTA heading', 'Rather read first?' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_contact_cta_sub', 'Sub-text', 'The blog answers most common questions.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_cta_label', 'CTA label', 'Visit the blog' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_contact_cta_secondary_label', 'Secondary label', 'See the FAQ' );
}

/* ──────────────────────────────────────────────────────────────
 * 7.  Meta-box callbacks — FAQ.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_faq_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_faq_hero_eyebrow', 'Eyebrow', 'FAQ' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_faq_hero_title_line1', 'Title line 1', 'The questions' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_faq_hero_title_accent', 'Title accent', 'we actually get asked.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_faq_hero_lede', 'Lead paragraph', "If your question isn't here, email us — we'll answer and add it." );
}

function vagra_nsl_faq_items_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_faq_items', 'FAQ Items (grouped by category)', array(
		array( 'key' => 'cat', 'label' => 'Category',  'type' => 'text' ),
		array( 'key' => 'q',   'label' => 'Question',  'type' => 'text' ),
		array( 'key' => 'a',   'label' => 'Answer',    'type' => 'textarea' ),
	), array(
		array( 'cat' => 'The basics',         'q' => 'Is nslookup.am really free?',        'a' => 'Yes. Free forever, no signup, no rate walls, no "free trial." We cover the compute.' ),
		array( 'cat' => 'The basics',         'q' => 'Do I need an account?',               'a' => 'No. No account, no cookies beyond a single preference cookie for dark mode.' ),
		array( 'cat' => 'The basics',         'q' => 'What record types do you support?',   'a' => 'Thirteen: A, AAAA, CNAME, MX, NS, SOA, TXT, CAA, PTR, SRV, TLSA, DNSKEY, DS.' ),
		array( 'cat' => 'How it works',       'q' => 'Where do your resolvers live?',       'a' => 'Thirty-plus public and private resolvers across six continents.' ),
		array( 'cat' => 'How it works',       'q' => 'How fast is a lookup?',               'a' => 'Sub-second globally for cached answers, 1.5s worst-case for cold queries.' ),
		array( 'cat' => 'How it works',       'q' => 'Do you query authoritative or recursive nameservers?', 'a' => 'Both, depending on the tool.' ),
		array( 'cat' => 'Privacy & security', 'q' => 'Do you log my queries?',              'a' => 'We keep aggregate volume metrics for capacity planning. We do not associate queries with your IP.' ),
		array( 'cat' => 'Privacy & security', 'q' => 'Do you share data with third parties?','a' => 'No. We have no advertisers, no analytics vendors, no data brokers.' ),
		array( 'cat' => 'Privacy & security', 'q' => 'Can I self-host?',                    'a' => 'An open-source resolver-fanout server is on the roadmap for Q3 2026.' ),
		array( 'cat' => 'For developers',     'q' => 'Is there an API?',                    'a' => 'Yes, a free JSON API mirroring every tool on the site. Rate limit is 60 req/min per IP.' ),
		array( 'cat' => 'For developers',     'q' => 'Do you have webhooks?',               'a' => 'Not yet. Monitor-style webhooks for record changes are on the roadmap.' ),
		array( 'cat' => 'For developers',     'q' => 'Can I link directly to results?',     'a' => 'Yes. Every query is URL-addressable.' ),
	) );
}

function vagra_nsl_faq_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_faq_cta_heading', 'CTA heading', 'Still curious?' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_faq_cta_sub', 'Sub-text', 'We answer everything, even bad questions.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_faq_cta_label', 'CTA label', 'Email us' );
}

/* ──────────────────────────────────────────────────────────────
 * 8.  Meta-box callbacks — TOOLS.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_tools_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_hero_eyebrow', 'Eyebrow', 'Toolkit' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_hero_title_line1', 'Title line 1', 'One query away' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_hero_title_accent', 'Title accent', 'from every answer.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_tools_hero_lede', 'Lead paragraph', 'A complete DNS diagnostic suite. Every lookup runs across our 30+ global resolvers. No accounts, no rate-walls, no signup.' );
}

function vagra_nsl_tools_grid_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_tools_grid_items', 'Tool Cards', array(
		array( 'key' => 'tag',   'label' => 'Tag/Badge',    'type' => 'text' ),
		array( 'key' => 'title', 'label' => 'Title',        'type' => 'text' ),
		array( 'key' => 'desc',  'label' => 'Description',  'type' => 'text' ),
		array( 'key' => 'href',  'label' => 'URL (# if not live)', 'type' => 'text' ),
		array( 'key' => 'live',  'label' => 'Live? (1=yes, 0=no)', 'type' => 'text' ),
	), array(
		array( 'tag' => 'NS',    'title' => 'NS Lookup',                'desc' => 'Authoritative nameservers, resolved.',      'href' => '/ns-lookup/', 'live' => '1' ),
		array( 'tag' => 'DNS',   'title' => 'DNS Propagation Checker',  'desc' => 'Watch changes land globally.',              'href' => '/propagation/', 'live' => '1' ),
		array( 'tag' => 'A',     'title' => 'A Record Lookup',          'desc' => 'IPv4 resolution, compared globally.',       'href' => '#', 'live' => '0' ),
		array( 'tag' => 'AAAA',  'title' => 'AAAA Lookup',              'desc' => 'IPv6 addressing, per region.',               'href' => '#', 'live' => '0' ),
		array( 'tag' => 'CNAME', 'title' => 'CNAME Lookup',             'desc' => 'Chain follow and loop detection.',           'href' => '#', 'live' => '0' ),
		array( 'tag' => 'MX',    'title' => 'MX Lookup',                'desc' => 'Mail exchangers with priority.',             'href' => '#', 'live' => '0' ),
		array( 'tag' => 'TXT',   'title' => 'TXT Lookup',               'desc' => 'Raw text, SPF, verification.',               'href' => '#', 'live' => '0' ),
		array( 'tag' => 'SOA',   'title' => 'SOA Lookup',               'desc' => 'Zone authority, serial, refresh.',            'href' => '#', 'live' => '0' ),
		array( 'tag' => 'CAA',   'title' => 'CAA Lookup',               'desc' => 'Certificate Authority Authorization.',       'href' => '#', 'live' => '0' ),
		array( 'tag' => 'PTR',   'title' => 'Reverse DNS',              'desc' => 'IP back to hostname.',                       'href' => '#', 'live' => '0' ),
		array( 'tag' => 'SRV',   'title' => 'SRV Lookup',               'desc' => 'Service records, priority, weight.',          'href' => '#', 'live' => '0' ),
		array( 'tag' => 'WHOIS', 'title' => 'WHOIS Lookup',             'desc' => 'Ownership, expiry, delegation.',             'href' => '#', 'live' => '0' ),
	) );
}

function vagra_nsl_tools_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_cta_heading_line1', 'Heading line 1', 'Need a tool' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_cta_heading_accent', 'Heading accent', "we don't have yet?" );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_tools_cta_sub', 'Sub-text', 'Tell us what would save you time. We build based on real debugging pain.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_tools_cta_label', 'CTA label', 'Request a tool' );
}

/* ──────────────────────────────────────────────────────────────
 * 9.  Meta-box callbacks — NS LOOKUP.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_ns_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_hero_eyebrow', 'Eyebrow', 'Tool · NS' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_hero_title_line1', 'Title line 1', 'Authoritative nameservers,' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_hero_title_accent', 'Title accent', 'resolved in one query.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_ns_hero_lede', 'Lead paragraph', 'Every NS record your domain publishes, pulled from the authority and cross-checked against global resolvers. Copy, CSV, JSON — free, no signup.' );
}

function vagra_nsl_ns_features_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_ns_features_items', 'Feature Cards', array(
		array( 'key' => 'n',     'label' => 'Letter/Number', 'type' => 'text' ),
		array( 'key' => 'title', 'label' => 'Title',         'type' => 'text' ),
		array( 'key' => 'body',  'label' => 'Description',   'type' => 'textarea' ),
	), array(
		array( 'n' => 'A', 'title' => 'Hostname',   'body' => 'Human-readable address of each authoritative server — typically 2–4 per zone.' ),
		array( 'n' => 'B', 'title' => 'Glue IP',    'body' => 'A/AAAA record for the nameserver, published at the parent to break the bootstrap loop.' ),
		array( 'n' => 'C', 'title' => 'TTL',        'body' => 'How long resolvers may cache the NS answer. 3600s is standard for production zones.' ),
		array( 'n' => 'D', 'title' => 'Delegation', 'body' => 'Subdomain zones can delegate to different authorities — common for multi-team setups.' ),
	) );
}

function vagra_nsl_ns_faq_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_faq_eyebrow', 'FAQ Eyebrow', 'NS records — FAQ' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_faq_heading_line1', 'FAQ Heading', 'Everything about' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_faq_heading_muted', 'FAQ Heading muted', 'nameservers.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_ns_faq_items', 'NS FAQ Items', array(
		array( 'key' => 'q', 'label' => 'Question', 'type' => 'text' ),
		array( 'key' => 'a', 'label' => 'Answer',   'type' => 'textarea' ),
	), array(
		array( 'q' => 'What is an NS record?',                   'a' => 'An NS (nameserver) record points your domain at the authoritative DNS servers that host the rest of your zone. Every domain needs at least two.' ),
		array( 'q' => 'Why do I have multiple nameservers?',     'a' => 'Redundancy. If one fails, resolvers fall back to the others. Most providers ship 2–4 on anycast for geographic speed.' ),
		array( 'q' => 'What happens when I change nameservers?', 'a' => 'The registry updates the NS record at the TLD zone. TLD caches for 24–48 hours, so traffic keeps hitting the old NS until they expire.' ),
		array( 'q' => 'How long does nameserver propagation take?', 'a' => 'Usually 24–48 hours, bounded by the TLD zone TTL. Lower your zone TTLs in advance to shorten the perceived cutover.' ),
		array( 'q' => 'Can I delegate subdomains to different NS?', 'a' => 'Yes — publish NS records for sub.example.com in your main zone pointing to a different authority.' ),
	) );
}

function vagra_nsl_ns_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_cta_heading_line1', 'Heading line 1', 'Check DNS' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_cta_heading_accent', 'Heading accent', "like it's 2026." );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_ns_cta_sub', 'Sub-text', 'Free. Instant. Worldwide.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_cta_label', 'CTA label', 'Start a lookup' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_ns_cta_secondary_label', 'Secondary label', 'Propagation check' );
}

/* ──────────────────────────────────────────────────────────────
 * 10. Meta-box callbacks — PROPAGATION.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_prop_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_hero_eyebrow', 'Eyebrow', 'Tool · Propagation' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_hero_title_line1', 'Title line 1', 'Your DNS changes,' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_hero_title_accent', 'Title accent', 'landing worldwide.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_prop_hero_lede', 'Lead paragraph', "Query 30+ public resolvers across six continents, in parallel. Watch each resolver's cache expire and converge on the new answer, live." );
}

function vagra_nsl_prop_explainer_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_expl_eyebrow', 'Eyebrow', 'Understanding propagation' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_prop_expl_heading', 'Heading', "Propagation isn't a push. It's thousands of caches expiring in sequence." );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_prop_expl_body', 'Body paragraph', 'Every caching resolver on the internet keeps its own copy of your records. The change is instant at your authority — what takes time is every other machine noticing. nslookup.am shows that rolling wave in real time.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_prop_expl_stats', 'Propagation Stats', array(
		array( 'key' => 'n', 'label' => 'Value', 'type' => 'text' ),
		array( 'key' => 'l', 'label' => 'Label', 'type' => 'text' ),
	), array(
		array( 'n' => '5 min',  'l' => 'Minimum propagation' ),
		array( 'n' => '48 h',   'l' => 'Typical ceiling' ),
		array( 'n' => '3600s',  'l' => 'Standard TTL' ),
		array( 'n' => '∞',      'l' => 'Patience required' ),
	) );
}

function vagra_nsl_prop_faq_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_faq_eyebrow', 'FAQ Eyebrow', 'Propagation — FAQ' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_faq_heading_line1', 'FAQ Heading', 'DNS propagation,' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_faq_heading_muted', 'FAQ Heading muted', 'answered.' );
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_prop_faq_items', 'Propagation FAQ Items', array(
		array( 'key' => 'q', 'label' => 'Question', 'type' => 'text' ),
		array( 'key' => 'a', 'label' => 'Answer',   'type' => 'textarea' ),
	), array(
		array( 'q' => 'How long does DNS propagation take?',       'a' => 'Usually 5 minutes to 48 hours, bounded by your record TTL plus resolver caches. Lower TTL before a change to speed it up.' ),
		array( 'q' => "Why isn't my DNS propagating?",             'a' => 'Common causes: change not published, high TTL still cached, registrar delegation issue, or DNSSEC mismatch rejecting answers.' ),
		array( 'q' => 'What is TTL and how does it affect propagation?', 'a' => 'TTL is how long resolvers may cache the record. Lower = faster propagation, more authority load. Higher = slower but lighter.' ),
		array( 'q' => 'How do I flush my DNS cache?',              'a' => 'Windows: ipconfig /flushdns — macOS: sudo dscacheutil -flushcache; sudo killall -HUP mDNSResponder — Linux: sudo systemd-resolve --flush-caches' ),
		array( 'q' => 'Why do different servers show different records?', 'a' => 'Stale cache, geo-DNS routing, or split-horizon zones. The propagation checker makes the differences visible.' ),
	) );
}

function vagra_nsl_prop_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_cta_heading_line1', 'Heading line 1', 'Watch DNS' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_cta_heading_accent', 'Heading accent', 'converge in real time.' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_prop_cta_sub', 'Sub-text', '30+ resolvers, 6 continents, one click.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_cta_label', 'CTA label', 'Run a check' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_prop_cta_secondary_label', 'Secondary label', 'NS Lookup' );
}

/* ──────────────────────────────────────────────────────────────
 * 11. Meta-box callbacks — PRIVACY.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_privacy_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_hero_eyebrow', 'Eyebrow', 'Privacy' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_hero_title_line1', 'Title line 1', 'What we collect' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_hero_title_accent', 'Title accent', '(almost nothing).' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_privacy_hero_lede', 'Lead paragraph', "We run DNS tools. We don't build profiles, we don't sell data, and we don't use analytics trackers. Here's the detailed version." );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_last_updated', 'Last updated date', 'March 1, 2026' );
}

function vagra_nsl_privacy_sections_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_privacy_sections', 'Privacy Sections', array(
		array( 'key' => 't', 'label' => 'Title',          'type' => 'text' ),
		array( 'key' => 'c', 'label' => 'Content (HTML)', 'type' => 'textarea' ),
	), array(
		array( 't' => 'What we collect',      'c' => 'When you use nslookup.am, our servers receive standard HTTP request metadata: your IP address, user agent, and the query you ran.' ),
		array( 't' => 'How long we retain it', 'c' => 'Request logs are retained for 72 hours and then permanently deleted.' ),
		array( 't' => 'What we never do',      'c' => 'Sell data. Share logs with advertisers. Track you across the web. Require an account.' ),
		array( 't' => 'Cookies',               'c' => 'We set exactly one cookie: nsl_theme, storing whether you prefer dark or light mode.' ),
		array( 't' => 'Legal requests',        'c' => 'If law enforcement contacts us with a valid subpoena, we can only provide what we have — which is very little.' ),
		array( 't' => 'Contact',               'c' => 'Privacy questions: privacy@nslookup.am' ),
	) );
}

function vagra_nsl_privacy_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_cta_heading', 'CTA heading', 'Questions?' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_privacy_cta_sub', 'Sub-text', "We're happy to clarify anything here." );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_privacy_cta_label', 'CTA label', 'Email us' );
}

/* ──────────────────────────────────────────────────────────────
 * 12. Meta-box callbacks — TERMS.
 * ────────────────────────────────────────────────────────────── */

function vagra_nsl_terms_hero_cb( $post ) {
	vagra_nsl_nonce_field();
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_hero_eyebrow', 'Eyebrow', 'Terms' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_hero_title_line1', 'Title line 1', 'Use the tools.' );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_hero_title_accent', 'Title accent', "Don't abuse them." );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_terms_hero_lede', 'Lead paragraph', "These terms are intentionally short. The spirit is: use nslookup.am for legitimate DNS diagnostics, don't weaponize it, don't overload it." );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_last_updated', 'Last updated date', 'March 1, 2026' );
}

function vagra_nsl_terms_sections_cb( $post ) {
	vagra_nsl_field_repeater( $post->ID, '_vagra_nsl_terms_sections', 'Terms Sections', array(
		array( 'key' => 't', 'label' => 'Title',          'type' => 'text' ),
		array( 'key' => 'c', 'label' => 'Content (HTML)', 'type' => 'textarea' ),
	), array(
		array( 't' => 'Service',                'c' => 'nslookup.am provides a web and API interface to DNS diagnostic tools. It is provided free of charge, as-is.' ),
		array( 't' => 'Acceptable use',         'c' => 'You may use the service for any legitimate DNS diagnostic purpose.' ),
		array( 't' => 'No warranty',            'c' => 'The service is provided "as is." We make no warranty that results are accurate, timely, complete, or fit for any purpose.' ),
		array( 't' => 'Limitation of liability','c' => 'Under no circumstances will nslookup.am or its operators be liable for damages arising from use or inability to use the service.' ),
		array( 't' => 'Changes',                'c' => 'We may update these terms. Material changes will be noted at the top of this page.' ),
		array( 't' => 'Contact',                'c' => 'Legal: legal@nslookup.am' ),
	) );
}

function vagra_nsl_terms_cta_cb( $post ) {
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_cta_heading', 'CTA heading', 'Questions?' );
	vagra_nsl_field_textarea( $post->ID, '_vagra_nsl_terms_cta_sub', 'Sub-text', "We're happy to clarify anything here." );
	vagra_nsl_field_text( $post->ID, '_vagra_nsl_terms_cta_label', 'CTA label', 'Email us' );
}

/* ──────────────────────────────────────────────────────────────
 * 13. Save meta data.
 * ────────────────────────────────────────────────────────────── */

add_action( 'save_post_page', 'vagra_nsl_save_meta_boxes', 10, 2 );

function vagra_nsl_save_meta_boxes( $post_id, $post ) {
	// Nonce check.
	if ( ! isset( $_POST['_vagra_nsl_meta_nonce'] )
		|| ! wp_verify_nonce( $_POST['_vagra_nsl_meta_nonce'], 'vagra_nsl_save_meta' ) ) {
		return;
	}

	// Autosave / capability check.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	// Collect all _vagra_nsl_ keys from POST.
	foreach ( $_POST as $key => $value ) {
		if ( 0 !== strpos( $key, '_vagra_nsl_' ) ) {
			continue;
		}

		// Repeater arrays → JSON encode.
		if ( is_array( $value ) ) {
			// Re-index the array (numeric keys).
			$clean = array();
			foreach ( $value as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$clean_row = array();
				foreach ( $row as $rk => $rv ) {
					$clean_row[ sanitize_key( $rk ) ] = wp_kses_post( $rv );
				}
				$clean[] = $clean_row;
			}
			update_post_meta( $post_id, $key, wp_json_encode( $clean, JSON_UNESCAPED_UNICODE ) );
		} else {
			// Text/textarea — sanitize.
			update_post_meta( $post_id, $key, wp_kses_post( wp_unslash( $value ) ) );
		}
	}
}

/* ──────────────────────────────────────────────────────────────
 * 14. Admin scripts for repeater UI.
 * ────────────────────────────────────────────────────────────── */

add_action( 'admin_footer', 'vagra_nsl_meta_boxes_admin_js' );

function vagra_nsl_meta_boxes_admin_js() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}
	?>
	<script>
	(function(){
		document.addEventListener('click', function(e) {
			// Add row
			if (e.target.classList.contains('vagra-repeater-add')) {
				var wrap   = e.target.closest('.vagra-repeater');
				var rows   = wrap.querySelector('.vagra-repeater-rows');
				var key    = wrap.dataset.key;
				var fields = JSON.parse(wrap.dataset.fields);
				var idx    = rows.querySelectorAll('.vagra-repeater-row').length;

				var div = document.createElement('div');
				div.className = 'vagra-repeater-row';
				div.style.cssText = 'border:1px solid #ddd; padding:12px; margin-bottom:8px; background:#fafafa; position:relative;';

				var removeBtn = '<button type="button" class="vagra-repeater-remove" style="position:absolute;top:4px;right:4px;cursor:pointer;">&times;</button>';
				var html = removeBtn;
				fields.forEach(function(f) {
					var name = key + '[' + idx + '][' + f.key + ']';
					html += '<p><label><strong>' + f.label + '</strong><br/>';
					if (f.type === 'textarea') {
						html += '<textarea name="' + name + '" class="widefat" rows="2"></textarea>';
					} else {
						html += '<input type="text" name="' + name + '" value="" class="widefat" />';
					}
					html += '</label></p>';
				});
				div.innerHTML = html;
				rows.appendChild(div);
			}

			// Remove row
			if (e.target.classList.contains('vagra-repeater-remove')) {
				var row = e.target.closest('.vagra-repeater-row');
				if (row) {
					row.remove();
					// Re-index names
					var wrap = e.target.closest('.vagra-repeater');
					if (wrap) {
						var allRows = wrap.querySelectorAll('.vagra-repeater-row');
						var key = wrap.dataset.key;
						allRows.forEach(function(r, i) {
							r.querySelectorAll('input, textarea').forEach(function(inp) {
								var oldName = inp.name;
								inp.name = oldName.replace(/\[\d+\]/, '[' + i + ']');
							});
						});
					}
				}
			}
		});
	})();
	</script>
	<style>
		.vagra-repeater { margin-bottom: 16px; }
		.vagra-repeater-row { transition: background 0.2s; }
		.vagra-repeater-row:hover { background: #f0f0f1 !important; }
		.vagra-repeater-remove { background: none; border: none; font-size: 18px; color: #b32d2e; }
	</style>
	<?php
}
