<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class FAQ_Accordion extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_faq_accordion';
    }

    public function get_title() {
        return __( 'FAQ Accordion', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Common questions', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'category', [
            'label'   => __( 'Category', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'General', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'question', [
            'label'   => __( 'Question', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What is nslookup.am?', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'answer', [
            'label'   => __( 'Answer', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'A free, browser-based DNS lookup and propagation checker.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'faq_items', [
            'label'       => __( 'FAQ Items', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'category' => __( 'General', 'vagra-nslookup' ),
                    'question' => __( 'What is nslookup.am?', 'vagra-nslookup' ),
                    'answer'   => __( 'A free, browser-based DNS lookup and propagation checker. Enter any domain and instantly query 13 record types across 30+ global resolvers.', 'vagra-nslookup' ),
                ],
                [
                    'category' => __( 'General', 'vagra-nslookup' ),
                    'question' => __( 'Is it really free?', 'vagra-nslookup' ),
                    'answer'   => __( 'Yes. No signup, no rate limits, no paid tier. Every feature is available to everyone.', 'vagra-nslookup' ),
                ],
                [
                    'category' => __( 'Technical', 'vagra-nslookup' ),
                    'question' => __( 'What record types are supported?', 'vagra-nslookup' ),
                    'answer'   => __( 'A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, and SRV — 13 in total.', 'vagra-nslookup' ),
                ],
                [
                    'category' => __( 'Technical', 'vagra-nslookup' ),
                    'question' => __( 'How does propagation checking work?', 'vagra-nslookup' ),
                    'answer'   => __( 'We query every resolver simultaneously and compare results. You see which resolvers have the current record and which are still caching an older value.', 'vagra-nslookup' ),
                ],
            ],
            'title_field' => '[{{{ category }}}] {{{ question }}}',
        ] );

        $this->add_control( 'first_open', [
            'label'        => __( 'First item open', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'question_color', [
            'label'     => __( 'Question Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .faq-item summary' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'answer_color', [
            'label'     => __( 'Answer Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .faq-body' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'border_color', [
            'label'     => __( 'Border Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .faq-item' => 'border-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'icon_color', [
            'label'     => __( 'Toggle Icon Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .faq-item summary::after' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'category_color', [
            'label'     => __( 'Category Label Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .faq-cat' => 'color: {{VALUE}}' ],
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
            'selectors'  => [ '{{WRAPPER}} .section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
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
            'selectors' => [ '{{WRAPPER}} .section' => 'text-align: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        // Group items by category
        $grouped  = array();
        $cat_order = array();
        if ( ! empty( $s['faq_items'] ) ) {
            foreach ( $s['faq_items'] as $item ) {
                $cat = ! empty( $item['category'] ) ? $item['category'] : __( 'General', 'vagra-nslookup' );
                if ( ! isset( $grouped[ $cat ] ) ) {
                    $grouped[ $cat ] = array();
                    $cat_order[]     = $cat;
                }
                $grouped[ $cat ][] = $item;
            }
        }

        $is_first = true;
        ?>
        <section class="section" data-reveal>
            <div class="container">
                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <div class="nsl-section-head">
                        <h2 class="reveal"><?php echo esc_html( $s['heading'] ); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="nsl-faq">
                    <?php foreach ( $cat_order as $cat ) : ?>
                        <div style="margin-bottom:40px">
                            <p class="mono reveal" style="font-size:var(--fs-12);text-transform:uppercase;letter-spacing:0.12em;color:var(--nsl-primary-600);margin-bottom:16px;font-weight:600">
                                <?php echo esc_html( $cat ); ?>
                            </p>
                            <div class="nsl-faq-list">
                                <?php foreach ( $grouped[ $cat ] as $item ) :
                                    $open = ( $is_first && 'yes' === $s['first_open'] ) ? ' open' : '';
                                    $is_first = false;
                                ?>
                                    <details class="faq-item reveal"<?php echo $open; ?>>
                                        <summary><?php echo esc_html( $item['question'] ); ?></summary>
                                        <div class="faq-body"><?php echo wp_kses_post( $item['answer'] ); ?></div>
                                    </details>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
