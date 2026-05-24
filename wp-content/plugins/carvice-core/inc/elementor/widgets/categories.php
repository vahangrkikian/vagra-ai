<?php
namespace Carvice\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Categories extends Carvice_Widget_Base {

    public function get_name()  { return 'carvice_categories'; }
    public function get_title() { return __( 'Service Categories', 'carvice' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'carvice' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Category', 'carvice' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ] );

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'carvice' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'body-repair' => __( 'Body Repair', 'carvice' ),
                'engine'      => __( 'Engine', 'carvice' ),
                'electrical'  => __( 'Electrical', 'carvice' ),
                'chassis'     => __( 'Chassis', 'carvice' ),
                'wheels'      => __( 'Wheels / Tires', 'carvice' ),
                'interior'    => __( 'Interior', 'carvice' ),
            ],
            'default' => 'engine',
        ] );

        $repeater->add_control( 'count', [
            'label'   => __( 'Count', 'carvice' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 0,
        ] );

        $this->add_control( 'categories', [
            'label'   => __( 'Categories', 'carvice' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'title' => 'Car Body',    'description' => 'Body repair / dent fixing',  'icon_name' => 'body-repair', 'count' => 0 ],
                [ 'title' => 'Engine',      'description' => 'Motor specialist',            'icon_name' => 'engine',      'count' => 0 ],
                [ 'title' => 'Electrical',  'description' => 'Diagnostics / electrician',   'icon_name' => 'electrical',  'count' => 0 ],
                [ 'title' => 'Chassis',     'description' => 'Body / chassis',              'icon_name' => 'chassis',     'count' => 0 ],
                [ 'title' => 'Wheels / Tires', 'description' => 'Vulcanization / tire service', 'icon_name' => 'wheels', 'count' => 0 ],
                [ 'title' => 'Interior',    'description' => 'Cabin servicing',             'icon_name' => 'interior',    'count' => 0 ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'carvice' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'carvice' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .carvice-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'carvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .carvice-category-card__name' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'carvice' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'carvice' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'carvice' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'carvice' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .carvice-categories' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'grid_columns', [
            'label'   => __( 'Columns', 'carvice' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .carvice-categories__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'carvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .carvice-categories__grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="carvice-categories">
            <div class="carvice-categories__bg"></div>
            <div class="carvice-container carvice-categories__inner">
                <div class="carvice-categories__grid">
                    <?php foreach ( $s['categories'] as $cat ) : ?>
                        <div class="carvice-category-card" data-category="<?php echo esc_attr( sanitize_title( $cat['title'] ) ); ?>">
                            <div class="carvice-category-card__icon">
                                <?php echo $this->get_category_icon( $cat['icon_name'] ); ?>
                            </div>
                            <h3 class="carvice-category-card__name"><?php echo esc_html( $cat['title'] ); ?></h3>
                            <p class="carvice-category-card__desc"><?php echo esc_html( $cat['description'] ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_category_icon( $name ) {
        $icons = [
            'body-repair' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="6" y="18" width="36" height="16" rx="4" stroke="currentColor" stroke-width="2.5" fill="none"/><circle cx="14" cy="38" r="4" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="34" cy="38" r="4" stroke="currentColor" stroke-width="2" fill="none"/><path d="M10 18L16 8h16l6 10" stroke="currentColor" stroke-width="2.5" fill="none"/></svg>',
            'engine'      => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="14" stroke="currentColor" stroke-width="2.5" fill="none"/><circle cx="24" cy="24" r="6" stroke="currentColor" stroke-width="2" fill="none"/><path d="M24 10v4M24 34v4M10 24h4M34 24h4M13 13l3 3M32 32l3 3M13 35l3-3M32 16l3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
            'electrical'  => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M28 6L18 24h12L20 42" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>',
            'chassis'     => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="8" y="16" width="32" height="4" rx="2" stroke="currentColor" stroke-width="2.5" fill="none"/><path d="M12 20v12M36 20v12M12 32h24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" fill="none"/><circle cx="12" cy="36" r="3" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="36" cy="36" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
            'wheels'      => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="16" stroke="currentColor" stroke-width="2.5" fill="none"/><circle cx="24" cy="24" r="8" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="24" cy="24" r="3" fill="currentColor"/></svg>',
            'interior'    => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M12 12h24v24H12z" stroke="currentColor" stroke-width="2.5" fill="none" rx="3"/><path d="M18 18v12M30 18v12M18 24h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        ];
        return $icons[ $name ] ?? '';
    }
}
