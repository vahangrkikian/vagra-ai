<?php
namespace Carvice\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Carvice_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'carvice' ];
    }
}
