<?php
/**
 * Vagra MSP Admin Settings Page
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Vagra_MSP_Admin {

    const OPTION_KEY = 'vagra_msp_options';
    const CAPABILITY = 'manage_options';

    private $defaults = array(
        'company_name'  => '',
        'company_phone' => '',
        'company_email' => '',
        'cta_text'      => 'Free Assessment',
        'cta_url'       => '/contact/',
        'footer_text'   => '',
    );

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
    }

    public function get_option( $key ) {
        $options = get_option( self::OPTION_KEY, $this->defaults );
        return isset( $options[ $key ] ) ? $options[ $key ] : ( isset( $this->defaults[ $key ] ) ? $this->defaults[ $key ] : '' );
    }

    public function add_menu_page() {
        add_menu_page(
            __( 'Vagra MSP Settings', 'vagra-msp' ),
            __( 'Vagra MSP', 'vagra-msp' ),
            self::CAPABILITY,
            'vagra-msp-settings',
            array( $this, 'render_settings_page' ),
            'dashicons-shield',
            59
        );
    }

    public function register_settings() {
        register_setting(
            'vagra_msp_settings_group',
            self::OPTION_KEY,
            array( $this, 'sanitize_options' )
        );

        add_settings_section( 'vagra_msp_company', __( 'Company Information', 'vagra-msp' ), array( $this, 'render_company_description' ), 'vagra-msp-settings' );
        add_settings_field( 'company_name', __( 'Company Name', 'vagra-msp' ), array( $this, 'render_text_field' ), 'vagra-msp-settings', 'vagra_msp_company', array( 'field' => 'company_name' ) );
        add_settings_field( 'company_phone', __( 'Phone Number', 'vagra-msp' ), array( $this, 'render_text_field' ), 'vagra-msp-settings', 'vagra_msp_company', array( 'field' => 'company_phone' ) );
        add_settings_field( 'company_email', __( 'Email Address', 'vagra-msp' ), array( $this, 'render_text_field' ), 'vagra-msp-settings', 'vagra_msp_company', array( 'field' => 'company_email', 'type' => 'email' ) );

        add_settings_section( 'vagra_msp_cta', __( 'Call to Action', 'vagra-msp' ), array( $this, 'render_cta_description' ), 'vagra-msp-settings' );
        add_settings_field( 'cta_text', __( 'Button Text', 'vagra-msp' ), array( $this, 'render_text_field' ), 'vagra-msp-settings', 'vagra_msp_cta', array( 'field' => 'cta_text' ) );
        add_settings_field( 'cta_url', __( 'Button URL', 'vagra-msp' ), array( $this, 'render_text_field' ), 'vagra-msp-settings', 'vagra_msp_cta', array( 'field' => 'cta_url' ) );

        add_settings_section( 'vagra_msp_footer_section', __( 'Footer', 'vagra-msp' ), null, 'vagra-msp-settings' );
        add_settings_field( 'footer_text', __( 'Footer Text', 'vagra-msp' ), array( $this, 'render_textarea_field' ), 'vagra-msp-settings', 'vagra_msp_footer_section', array( 'field' => 'footer_text' ) );

        add_settings_section( 'vagra_msp_features', __( 'Features', 'vagra-msp' ), null, 'vagra-msp-settings' );
        add_settings_field( 'chat_status', __( 'AI Chat Widget', 'vagra-msp' ), array( $this, 'render_chat_status_field' ), 'vagra-msp-settings', 'vagra_msp_features' );
    }

    public function render_company_description() {
        echo '<p>' . esc_html__( 'Enter your MSP business details.', 'vagra-msp' ) . '</p>';
    }

    public function render_cta_description() {
        echo '<p>' . esc_html__( 'Configure the header CTA button.', 'vagra-msp' ) . '</p>';
    }

    public function sanitize_options( $input ) {
        $s = array();
        $s['company_name']  = sanitize_text_field( isset( $input['company_name'] ) ? $input['company_name'] : '' );
        $s['company_phone'] = sanitize_text_field( isset( $input['company_phone'] ) ? $input['company_phone'] : '' );
        $s['company_email'] = sanitize_email( isset( $input['company_email'] ) ? $input['company_email'] : '' );
        $s['cta_text']      = sanitize_text_field( isset( $input['cta_text'] ) ? $input['cta_text'] : 'Free Assessment' );
        $s['cta_url']       = esc_url_raw( isset( $input['cta_url'] ) ? $input['cta_url'] : '/contact/' );
        $s['footer_text']   = wp_kses_post( isset( $input['footer_text'] ) ? $input['footer_text'] : '' );
        return $s;
    }

    public function render_text_field( $args ) {
        $value = $this->get_option( $args['field'] );
        $type  = isset( $args['type'] ) ? $args['type'] : 'text';
        printf( '<input type="%s" name="%s[%s]" value="%s" class="regular-text" />', esc_attr( $type ), esc_attr( self::OPTION_KEY ), esc_attr( $args['field'] ), esc_attr( $value ) );
    }

    public function render_textarea_field( $args ) {
        $value = $this->get_option( $args['field'] );
        printf( '<textarea name="%s[%s]" rows="4" class="large-text">%s</textarea>', esc_attr( self::OPTION_KEY ), esc_attr( $args['field'] ), esc_textarea( $value ) );
    }

    public function render_checkbox_field( $args ) {
        $value = $this->get_option( $args['field'] );
        printf( '<label><input type="checkbox" name="%s[%s]" value="1" %s /> %s</label>', esc_attr( self::OPTION_KEY ), esc_attr( $args['field'] ), checked( $value, 1, false ), esc_html__( 'Enabled', 'vagra-msp' ) );
    }

    public function render_chat_status_field() {
        $enabled = get_theme_mod( 'vagra_msp_chat_enabled', true );
        $status  = $enabled ? esc_html__( 'Enabled', 'vagra-msp' ) : esc_html__( 'Disabled', 'vagra-msp' );
        $class   = $enabled ? 'vagra-status--ok' : 'vagra-status--warn';
        printf( '<span class="%s">%s</span> &mdash; <a href="%s">%s</a>', esc_attr( $class ), $status, esc_url( admin_url( 'customize.php?autofocus[section]=vagra_msp_chat' ) ), esc_html__( 'Configure in Customizer', 'vagra-msp' ) );
    }

    public function render_settings_page() {
        if ( ! current_user_can( self::CAPABILITY ) ) {
            return;
        }
        ?>
        <div class="wrap vagra-admin-wrap">
            <div class="vagra-admin-header">
                <h1><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'Vagra MSP Settings', 'vagra-msp' ); ?></h1>
                <p class="vagra-admin-version"><?php printf( esc_html__( 'Version %s', 'vagra-msp' ), esc_html( VAGRA_MSP_VERSION ) ); ?></p>
            </div>
            <?php settings_errors(); ?>
            <form method="post" action="options.php" class="vagra-admin-form">
                <?php
                settings_fields( 'vagra_msp_settings_group' );
                do_settings_sections( 'vagra-msp-settings' );
                submit_button( __( 'Save Settings', 'vagra-msp' ) );
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_vagra-msp-settings' !== $hook ) {
            return;
        }
        wp_enqueue_style( 'vagra-msp-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), VAGRA_MSP_VERSION );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget( 'vagra_msp_status_widget', __( 'Vagra MSP Theme Status', 'vagra-msp' ), array( $this, 'render_dashboard_widget' ) );
    }

    public function render_dashboard_widget() {
        $options    = get_option( self::OPTION_KEY, $this->defaults );
        $theme      = wp_get_theme( 'vagra-msp' );
        $chat_ok    = class_exists( 'Vagra_MSP_Chat' );
        $chat_class = $chat_ok ? 'vagra-status--ok' : 'vagra-status--warn';
        $chat_label = $chat_ok ? __( 'Active', 'vagra-msp' ) : __( 'Not loaded', 'vagra-msp' );
        ?>
        <div class="vagra-dashboard-widget">
            <table class="widefat striped">
                <tbody>
                    <tr>
                        <td><strong><?php esc_html_e( 'Theme Version', 'vagra-msp' ); ?></strong></td>
                        <td><?php echo esc_html( $theme->get( 'Version' ) ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'AI Chat Widget', 'vagra-msp' ); ?></strong></td>
                        <td><span class="<?php echo esc_attr( $chat_class ); ?>"><?php echo esc_html( $chat_label ); ?></span></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'Chat Enabled', 'vagra-msp' ); ?></strong></td>
                        <td><?php $chat_enabled = get_theme_mod( 'vagra_msp_chat_enabled', true ); echo $chat_enabled ? esc_html__( 'Yes', 'vagra-msp' ) : esc_html__( 'No', 'vagra-msp' ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'Company', 'vagra-msp' ); ?></strong></td>
                        <td><?php echo esc_html( ! empty( $options['company_name'] ) ? $options['company_name'] : '---' ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'CTA Button', 'vagra-msp' ); ?></strong></td>
                        <td><?php echo esc_html( ! empty( $options['cta_text'] ) ? $options['cta_text'] : '---' ); ?></td>
                    </tr>
                </tbody>
            </table>
            <p class="vagra-dashboard-widget__link">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=vagra-msp-settings' ) ); ?>"><?php esc_html_e( 'Go to Settings', 'vagra-msp' ); ?> &rarr;</a>
            </p>
        </div>
        <?php
    }
}
