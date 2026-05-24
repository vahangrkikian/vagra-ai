<?php
namespace HouseService\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class HS_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'house-service' ];
    }
}
