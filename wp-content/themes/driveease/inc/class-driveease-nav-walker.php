<?php
/**
 * Custom nav walkers for DriveEase theme.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Desktop nav walker — outputs anchor-only list items for .nav-links <ul>.
 */
class Driveease_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_string = join( ' ', array_filter( $classes ) );

		$output .= '<li class="' . esc_attr( $class_string ) . '">';

		$atts = array();
		$atts['href']  = ! empty( $item->url ) ? $item->url : '';
		$atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';

		if ( ! empty( $item->target ) ) {
			$atts['target'] = $item->target;
		}
		if ( ! empty( $item->xfn ) ) {
			$atts['rel'] = $item->xfn;
		}

		$i18n_key = get_post_meta( $item->ID, '_driveease_i18n_key', true );
		if ( $i18n_key ) {
			$atts['data-i18n'] = $i18n_key;
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$output .= '<a' . $attributes . '>' . esc_html( $item->title ) . '</a>';
	}
}

/**
 * Mobile nav walker — outputs bare <a> tags (no <ul>/<li> wrapper) for .mobile-menu.
 */
class Driveease_Mobile_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Don't output <ul>.
	 *
	 * @param string   $output Passed by reference.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// No wrapper for mobile menu.
	}

	/**
	 * Don't close <ul>.
	 *
	 * @param string   $output Passed by reference.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		// No wrapper for mobile menu.
	}

	/**
	 * Don't output <li>.
	 *
	 * @param string   $output Passed by reference.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		// No closing li.
	}

	/**
	 * Output bare <a> element.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$atts = array();
		$atts['href']  = ! empty( $item->url ) ? $item->url : '';

		if ( ! empty( $item->target ) ) {
			$atts['target'] = $item->target;
		}

		$i18n_key = get_post_meta( $item->ID, '_driveease_i18n_key', true );
		if ( $i18n_key ) {
			$atts['data-i18n'] = $i18n_key;
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$output .= '<a' . $attributes . '>' . esc_html( $item->title ) . '</a>';
	}
}
