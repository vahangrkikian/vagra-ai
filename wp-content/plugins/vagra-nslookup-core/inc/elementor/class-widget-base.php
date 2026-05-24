<?php
namespace VagraNSL\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NSL_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'vagra-nslookup' ];
    }
}
