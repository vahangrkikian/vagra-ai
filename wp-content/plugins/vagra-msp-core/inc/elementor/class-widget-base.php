<?php
namespace VagraMSP\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class MSP_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'vagra-msp' ];
    }
}
