<?php
namespace TourVice\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class TourVice_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'tourvice' ];
    }
}
