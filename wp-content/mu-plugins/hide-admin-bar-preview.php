<?php
/**
 * Hide the WordPress admin bar when pages are loaded in demo preview iframes.
 *
 * Triggered by ?hide_admin_bar=1 query parameter.
 *
 * @package vagra-showcase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_GET['hide_admin_bar'] ) && '1' === $_GET['hide_admin_bar'] ) {
	add_filter( 'show_admin_bar', '__return_false' );
}
