<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Record_Types extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_record_types';
    }

    public function get_title() {
        return __( 'Record Types', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Supported types', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( '13 record types. One interface.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'lede', [
            'label'   => __( 'Lead text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'From basic A records to advanced DKIM selectors, query them all in a single lookup.', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'tag', [
            'label'   => __( 'Tag', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'A',
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'IPv4 address mapping', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'url', [
            'label' => __( 'URL', 'vagra-nslookup' ),
            'type'  => Controls_Manager::URL,
        ] );

        $repeater->add_control( 'is_external', [
            'label'        => __( 'External link', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => '',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->add_control( 'types', [
            'label'       => __( 'Record types', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'tag' => 'A',     'description' => __( 'IPv4 address mapping', 'vagra-nslookup' ) ],
                [ 'tag' => 'AAAA',  'description' => __( 'IPv6 address mapping', 'vagra-nslookup' ) ],
                [ 'tag' => 'CNAME', 'description' => __( 'Canonical name alias', 'vagra-nslookup' ) ],
                [ 'tag' => 'MX',    'description' => __( 'Mail exchange servers', 'vagra-nslookup' ) ],
                [ 'tag' => 'NS',    'description' => __( 'Authoritative nameservers', 'vagra-nslookup' ) ],
                [ 'tag' => 'TXT',   'description' => __( 'Text verification records', 'vagra-nslookup' ) ],
                [ 'tag' => 'SPF',   'description' => __( 'Sender policy framework', 'vagra-nslookup' ) ],
                [ 'tag' => 'DKIM',  'description' => __( 'Email authentication keys', 'vagra-nslookup' ) ],
                [ 'tag' => 'DMARC', 'description' => __( 'Domain-based auth policy', 'vagra-nslookup' ) ],
                [ 'tag' => 'SOA',   'description' => __( 'Start of authority', 'vagra-nslookup' ) ],
                [ 'tag' => 'PTR',   'description' => __( 'Reverse DNS pointer', 'vagra-nslookup' ) ],
                [ 'tag' => 'CAA',   'description' => __( 'Certificate authority auth', 'vagra-nslookup' ) ],
                [ 'tag' => 'SRV',   'description' => __( 'Service locator', 'vagra-nslookup' ) ],
            ],
            'title_field' => '{{{ tag }}}',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'tag_bg', [
            'label'     => __( 'Tag Background', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#EEF2FF',
            'selectors' => [ '{{WRAPPER}} .nsl-type-tag' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'tag_color', [
            'label'     => __( 'Tag Text Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .nsl-type-tag' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'tag_hover_bg', [
            'label'     => __( 'Tag Hover BG', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .nsl-type:hover .nsl-type-tag' => 'background-color: {{VALUE}}; color: #fff;' ],
        ] );

        $this->add_control( 'description_color', [
            'label'     => __( 'Description Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-type-d' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => __( 'Heading Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} h2' => 'color: {{VALUE}}' ],
        ] );

        $this->end_controls_section();

        /* ── Responsive ── */
        $this->start_controls_section( 'section_responsive', [
            'label' => __( 'Responsive', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .cine-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} h2' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-nslookup' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-nslookup' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-nslookup' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-nslookup' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .cine-section' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'grid_columns', [
            'label'   => __( 'Columns', 'vagra-nslookup' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .nsl-types' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .nsl-types' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="cine-section" data-reveal>
            <div class="cine-head-wrap">
                <div class="nsl-section-head">
                    <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <span class="eyebrow reveal"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['heading'] ) ) : ?>
                        <h2 class="reveal reveal-delay-1"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['lede'] ) ) : ?>
                        <p class="lead reveal reveal-delay-2"><?php echo esc_html( $s['lede'] ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $s['types'] ) ) : ?>
                    <div class="nsl-types">
                        <?php foreach ( $s['types'] as $i => $type ) :
                            $has_url = ! empty( $type['url']['url'] );
                            $tag     = $has_url ? 'a' : 'div';
                            $href    = $has_url ? ' href="' . esc_url( $type['url']['url'] ) . '"' : '';
                            $target  = ( $has_url && 'yes' === $type['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
                        ?>
                            <<?php echo $tag; ?> class="nsl-type reveal" style="transition-delay:<?php echo esc_attr( $i * 40 ); ?>ms"<?php echo $href . $target; ?>>
                                <span class="nsl-type-tag"><?php echo esc_html( $type['tag'] ); ?></span>
                                <span class="nsl-type-d"><?php echo esc_html( $type['description'] ); ?></span>
                                <?php if ( $has_url && 'yes' === $type['is_external'] ) : ?>
                                    <span class="nsl-type-ext">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 3H3v10h10v-3M9 2h5v5M14 2L7 9"/></svg>
                                    </span>
                                <?php endif; ?>
                            </<?php echo $tag; ?>>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
