<?php
/**
 * Vagra Legal Admin Settings Page
 *
 * @package Vagra_Legal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Vagra_Legal_Admin {

    const OPTION_KEY = 'vagra_legal_options';
    const CAPABILITY = 'manage_options';

    private $defaults = array(
        'firm_name'    => '',
        'firm_phone'   => '',
        'firm_email'   => '',
        'cta_text'     => 'Free Consultation',
        'cta_url'      => '/contact/',
        'footer_text'  => '',
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
            __( 'Vagra Legal Settings', 'vagra-legal' ),
            __( 'Vagra Legal', 'vagra-legal' ),
            self::CAPABILITY,
            'vagra-legal-settings',
            array( $this, 'render_settings_page' ),
            'dashicons-building',
            59
        );
    }

    public function register_settings() {
        register_setting(
            'vagra_legal_settings_group',
            self::OPTION_KEY,
            array( $this, 'sanitize_options' )
        );

        add_settings_section( 'vagra_legal_firm', __( 'Firm Information', 'vagra-legal' ), array( $this, 'render_firm_description' ), 'vagra-legal-settings' );
        add_settings_field( 'firm_name', __( 'Firm Name', 'vagra-legal' ), array( $this, 'render_text_field' ), 'vagra-legal-settings', 'vagra_legal_firm', array( 'field' => 'firm_name' ) );
        add_settings_field( 'firm_phone', __( 'Phone Number', 'vagra-legal' ), array( $this, 'render_text_field' ), 'vagra-legal-settings', 'vagra_legal_firm', array( 'field' => 'firm_phone' ) );
        add_settings_field( 'firm_email', __( 'Email Address', 'vagra-legal' ), array( $this, 'render_text_field' ), 'vagra-legal-settings', 'vagra_legal_firm', array( 'field' => 'firm_email', 'type' => 'email' ) );

        add_settings_section( 'vagra_legal_cta', __( 'Call to Action', 'vagra-legal' ), array( $this, 'render_cta_description' ), 'vagra-legal-settings' );
        add_settings_field( 'cta_text', __( 'Button Text', 'vagra-legal' ), array( $this, 'render_text_field' ), 'vagra-legal-settings', 'vagra_legal_cta', array( 'field' => 'cta_text' ) );
        add_settings_field( 'cta_url', __( 'Button URL', 'vagra-legal' ), array( $this, 'render_text_field' ), 'vagra-legal-settings', 'vagra_legal_cta', array( 'field' => 'cta_url' ) );

        add_settings_section( 'vagra_legal_footer_section', __( 'Footer', 'vagra-legal' ), null, 'vagra-legal-settings' );
        add_settings_field( 'footer_text', __( 'Footer Text', 'vagra-legal' ), array( $this, 'render_textarea_field' ), 'vagra-legal-settings', 'vagra_legal_footer_section', array( 'field' => 'footer_text' ) );

        add_settings_section( 'vagra_legal_features', __( 'Features', 'vagra-legal' ), null, 'vagra-legal-settings' );
        add_settings_field( 'chat_status', __( 'AI Chat Widget', 'vagra-legal' ), array( $this, 'render_chat_status_field' ), 'vagra-legal-settings', 'vagra_legal_features' );
    }

    public function render_firm_description() {
        echo '<p>' . esc_html__( 'Enter your law firm details.', 'vagra-legal' ) . '</p>';
    }

    public function render_cta_description() {
        echo '<p>' . esc_html__( 'Configure the header CTA button.', 'vagra-legal' ) . '</p>';
    }

    public function sanitize_options( $input ) {
        $s = array();
        $s['firm_name']   = sanitize_text_field( isset( $input['firm_name'] ) ? $input['firm_name'] : '' );
        $s['firm_phone']  = sanitize_text_field( isset( $input['firm_phone'] ) ? $input['firm_phone'] : '' );
        $s['firm_email']  = sanitize_email( isset( $input['firm_email'] ) ? $input['firm_email'] : '' );
        $s['cta_text']    = sanitize_text_field( isset( $input['cta_text'] ) ? $input['cta_text'] : 'Free Consultation' );
        $s['cta_url']     = esc_url_raw( isset( $input['cta_url'] ) ? $input['cta_url'] : '/contact/' );
        $s['footer_text'] = wp_kses_post( isset( $input['footer_text'] ) ? $input['footer_text'] : '' );
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

    public function render_chat_status_field() {
        $enabled = get_theme_mod( 'vagra_legal_chat_enabled', true );
        $status  = $enabled ? esc_html__( 'Enabled', 'vagra-legal' ) : esc_html__( 'Disabled', 'vagra-legal' );
        $class   = $enabled ? 'vagra-status--ok' : 'vagra-status--warn';
        printf( '<span class="%s">%s</span> &mdash; <a href="%s">%s</a>', esc_attr( $class ), $status, esc_url( admin_url( 'customize.php?autofocus[section]=vagra_legal_chat' ) ), esc_html__( 'Configure in Customizer', 'vagra-legal' ) );
    }

    public function render_settings_page() {
        if ( ! current_user_can( self::CAPABILITY ) ) {
            return;
        }
        ?>
        <div class="wrap vagra-admin-wrap">
            <div class="vagra-admin-header">
                <h1><span class="dashicons dashicons-building"></span> <?php esc_html_e( 'Vagra Legal Settings', 'vagra-legal' ); ?></h1>
                <p class="vagra-admin-version"><?php printf( esc_html__( 'Version %s', 'vagra-legal' ), esc_html( VAGRA_LEGAL_VERSION ) ); ?></p>
            </div>
            <?php settings_errors(); ?>
            <form method="post" action="options.php" class="vagra-admin-form">
                <?php
                settings_fields( 'vagra_legal_settings_group' );
                do_settings_sections( 'vagra-legal-settings' );
                submit_button( __( 'Save Settings', 'vagra-legal' ) );
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_vagra-legal-settings' !== $hook ) {
            return;
        }
        wp_enqueue_style( 'vagra-legal-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), VAGRA_LEGAL_VERSION );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget( 'vagra_legal_status_widget', __( 'Vagra Legal Theme Status', 'vagra-legal' ), array( $this, 'render_dashboard_widget' ) );
    }

    public function render_dashboard_widget() {
        $options    = get_option( self::OPTION_KEY, $this->defaults );
        $theme      = wp_get_theme( 'vagra-legal' );
        $chat_ok    = class_exists( 'Vagra_Legal_Chat' );
        $chat_class = $chat_ok ? 'vagra-status--ok' : 'vagra-status--warn';
        $chat_label = $chat_ok ? __( 'Active', 'vagra-legal' ) : __( 'Not loaded', 'vagra-legal' );
        ?>
        <div class="vagra-dashboard-widget">
            <table class="widefat striped">
                <tbody>
                    <tr>
                        <td><strong><?php esc_html_e( 'Theme Version', 'vagra-legal' ); ?></strong></td>
                        <td><?php echo esc_html( $theme->get( 'Version' ) ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'AI Chat Widget', 'vagra-legal' ); ?></strong></td>
                        <td><span class="<?php echo esc_attr( $chat_class ); ?>"><?php echo esc_html( $chat_label ); ?></span></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'Chat Enabled', 'vagra-legal' ); ?></strong></td>
                        <td><?php echo get_theme_mod( 'vagra_legal_chat_enabled', true ) ? esc_html__( 'Yes', 'vagra-legal' ) : esc_html__( 'No', 'vagra-legal' ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'Firm', 'vagra-legal' ); ?></strong></td>
                        <td><?php echo esc_html( ! empty( $options['firm_name'] ) ? $options['firm_name'] : '---' ); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php esc_html_e( 'CTA Button', 'vagra-legal' ); ?></strong></td>
                        <td><?php echo esc_html( ! empty( $options['cta_text'] ) ? $options['cta_text'] : '---' ); ?></td>
                    </tr>
                </tbody>
            </table>
            <p class="vagra-dashboard-widget__link">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=vagra-legal-settings' ) ); ?>"><?php esc_html_e( 'Go to Settings', 'vagra-legal' ); ?> &rarr;</a>
            </p>
        </div>
        <?php
    }
}
