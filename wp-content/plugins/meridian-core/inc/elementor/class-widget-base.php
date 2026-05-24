<?php
namespace Meridian\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Meridian_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'meridian' ];
    }
}
