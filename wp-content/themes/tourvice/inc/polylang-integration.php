<?php
/**
 * Polylang integration for TourVice.
 *
 * Registers translatable strings, enables CPT/taxonomy translation,
 * and provides a proper language switcher function.
 *
 * @package TourVice
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme strings for translation via Polylang.
 */
function tourvice_polylang_register_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$strings = array(
		'site_name'          => 'TourVice',
		'site_tagline'       => 'Luxury Armenian tourism experiences.',
		'hero_title'         => 'Discover Armenia',
		'hero_subtitle'      => 'Unforgettable luxury experiences in the heart of the Caucasus',
		'hero_cta'           => 'Browse Tours',
		'featured_eyebrow'   => 'Curated for you',
		'featured_title'     => 'Featured Tours',
		'featured_desc'      => 'Handpicked destinations for unforgettable experiences',
		'browse_all'         => 'Browse All Tours',
		'discounts_eyebrow'  => 'Save more together',
		'discounts_title'    => 'Group Discounts',
		'testimonials_title' => 'Guest Testimonials',
		'newsletter_title'   => 'Stay Updated',
		'newsletter_desc'    => 'Get exclusive deals and travel inspiration delivered to your inbox',
		'subscribe'          => 'Subscribe',
		'book_now'           => 'Book Now',
		'book_tour'          => 'Book Tour',
		'search_tours'       => 'Search tours...',
		'explore_tours'      => 'Explore Tours',
		'per_person'         => 'per person',
		'group_size'         => 'Group Size',
		'overview'           => 'Overview',
		'highlights'         => 'Highlights',
		'itinerary'          => 'Itinerary',
		'guest_reviews'      => 'Guest Reviews',
		'write_review'       => 'Write a Review',
		'contact_title'      => 'Get In Touch',
		'contact_subtitle'   => "We'd love to hear from you",
		'send_message'       => 'Send Message',
		'all_rights'         => 'All rights reserved.',
	);

	foreach ( $strings as $key => $value ) {
		pll_register_string( 'tourvice_' . $key, $value, 'TourVice Theme' );
	}
}
add_action( 'init', 'tourvice_polylang_register_strings' );

/**
 * Enable Polylang translation for TourVice CPTs.
 *
 * @param array $post_types Translatable post types.
 * @param bool  $is_settings Whether called from settings page.
 * @return array
 */
function tourvice_polylang_post_types( $post_types, $is_settings ) {
	if ( $is_settings ) {
		$post_types['vagra_tour']    = 'vagra_tour';
		$post_types['vagra_booking'] = 'vagra_booking';
	}
	return $post_types;
}
add_filter( 'pll_get_post_types', 'tourvice_polylang_post_types', 10, 2 );

/**
 * Enable Polylang translation for TourVice taxonomies.
 *
 * @param array $taxonomies Translatable taxonomies.
 * @param bool  $is_settings Whether called from settings page.
 * @return array
 */
function tourvice_polylang_taxonomies( $taxonomies, $is_settings ) {
	if ( $is_settings ) {
		$taxonomies['tour_location'] = 'tour_location';
		$taxonomies['tour_type']     = 'tour_type';
	}
	return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'tourvice_polylang_taxonomies', 10, 2 );

/**
 * Output the Polylang language switcher.
 *
 * Uses real URLs for each language, SEO-friendly with hreflang.
 * Falls back gracefully if Polylang is not active.
 *
 * @param string $btn_class CSS class for each language button/link.
 */
function tourvice_polylang_switcher( $btn_class = 'tourvice-header__lang-btn' ) {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}

	$languages = pll_the_languages( array(
		'raw'                    => 1,
		'hide_if_no_translation' => 0,
	) );

	if ( empty( $languages ) ) {
		return;
	}

	$i = 0;
	foreach ( $languages as $lang ) {
		if ( $i > 0 ) {
			echo '<span class="tourvice-header__lang-sep">|</span>';
		}
		$active = ! empty( $lang['current_lang'] ) ? ' active' : '';
		printf(
			'<a href="%s" class="%s%s" hreflang="%s" lang="%s">%s</a>',
			esc_url( $lang['url'] ),
			esc_attr( $btn_class ),
			esc_attr( $active ),
			esc_attr( $lang['slug'] ),
			esc_attr( $lang['slug'] ),
			esc_html( strtoupper( $lang['slug'] ) )
		);
		$i++;
	}
}

/**
 * Sync Polylang language with client-side i18n.
 *
 * Outputs a small script to set the JS language from Polylang's detected locale.
 */
function tourvice_polylang_sync_js() {
	if ( ! function_exists( 'pll_current_language' ) ) {
		return;
	}

	$lang = pll_current_language( 'slug' );
	if ( $lang ) {
		printf(
			'<script>document.addEventListener("DOMContentLoaded",function(){if(typeof setLang==="function"){setLang("%s");}});</script>',
			esc_js( $lang )
		);
	}
}
add_action( 'wp_head', 'tourvice_polylang_sync_js', 99 );
