<?php
namespace DriveEase\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class DriveEase_Widget_Base extends Widget_Base {
    public function get_categories() {
        return [ 'driveease' ];
    }
}
