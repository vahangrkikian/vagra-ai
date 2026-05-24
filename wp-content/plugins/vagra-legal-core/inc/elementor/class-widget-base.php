<?php
namespace VagraLegal\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Legal_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'vagra-legal' ];
    }
}
