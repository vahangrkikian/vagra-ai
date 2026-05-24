<?php
/**
 * Vagra MSP Admin Settings Page
 *
 * Provides a tabbed theme options page using the WordPress Settings API.
 * Settings are stored in a single serialized option for efficiency.
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Vagra_MSP_Admin {

    const OPTION_KEY = 'vagra_msp_options';
    const CAPABILITY = 'manage_options';
    const PAGE_SLUG  = 'vagra-msp-settings';

    /**
     * Default option values.
     *
     * @var array
     */
    private $defaults = array(
        // General.
        'company_name'     => '',
        'company_phone'    => '',
        'company_email'    => '',
        'company_address'  => '',
        // CTA.
        'cta_text'         => 'Free Security Assessment',
        'cta_url'          => '/contact/',
        // Social.
        'social_linkedin'  => '',
        'social_twitter'   => '',
        'social_facebook'  => '',
        'social_youtube'   => '',
        'social_github'    => '',
        // Footer.
        'footer_text'      => '',
        // Security features.
        'show_security_headers' => 0,
        'show_ssl_badge'        => 0,
    );

    /**
     * Tab definitions.
     *
     * @var array
     */
    private $tabs = array();

    /**
     * Constructor.
     */
    public function __construct() {
        $this->tabs = array(
            'general'  => array(
                'label' => __( 'General', 'vagra-msp' ),
                'icon'  => 'dashicons-admin-home',
            ),
            'social'   => array(
                'label' => __( 'Social Links', 'vagra-msp' ),
                'icon'  => 'dashicons-share',
            ),
            'security' => array(
                'label' => __( 'Security', 'vagra-msp' ),
                'icon'  => 'dashicons-lock',
            ),
            'api'      => array(
                'label' => __( 'API Keys', 'vagra-msp' ),
                'icon'  => 'dashicons-admin-network',
            ),
            'advanced' => array(
                'label' => __( 'Advanced', 'vagra-msp' ),
                'icon'  => 'dashicons-admin-tools',
            ),
        );

        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
    }

    /**
     * Retrieve a single option value.
     *
     * @param string $key Option key.
     * @return mixed
     */
    public function get_option( $key ) {
        $options = get_option( self::OPTION_KEY, $this->defaults );
        if ( isset( $options[ $key ] ) ) {
            return $options[ $key ];
        }
        return isset( $this->defaults[ $key ] ) ? $this->defaults[ $key ] : '';
    }

    /**
     * Add top-level admin menu page.
     */
    public function add_menu_page() {
        add_menu_page(
            __( 'Vagra MSP Settings', 'vagra-msp' ),
            __( 'Vagra MSP', 'vagra-msp' ),
            self::CAPABILITY,
            self::PAGE_SLUG,
            array( $this, 'render_settings_page' ),
            'dashicons-shield',
            59
        );
    }

    /**
     * Register settings, sections, and fields.
     */
    public function register_settings() {
        register_setting(
            'vagra_msp_settings_group',
            self::OPTION_KEY,
            array( $this, 'sanitize_options' )
        );

        // --- Tab: General ---
        add_settings_section(
            'vagra_msp_company',
            __( 'Company Information', 'vagra-msp' ),
            array( $this, 'render_section_company' ),
            self::PAGE_SLUG . '-general'
        );

        add_settings_field( 'company_name', __( 'Company Name', 'vagra-msp' ), array( $this, 'render_text_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_company', array(
            'field'       => 'company_name',
            'description' => __( 'Your MSP business name as shown in the header and footer.', 'vagra-msp' ),
        ) );

        add_settings_field( 'company_phone', __( 'Phone Number', 'vagra-msp' ), array( $this, 'render_text_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_company', array(
            'field'       => 'company_phone',
            'type'        => 'tel',
            'placeholder' => '+1 (555) 123-4567',
        ) );

        add_settings_field( 'company_email', __( 'Email Address', 'vagra-msp' ), array( $this, 'render_text_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_company', array(
            'field'       => 'company_email',
            'type'        => 'email',
            'placeholder' => 'info@example.com',
        ) );

        add_settings_field( 'company_address', __( 'Address', 'vagra-msp' ), array( $this, 'render_textarea_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_company', array(
            'field' => 'company_address',
            'rows'  => 2,
        ) );

        // CTA sub-section within General.
        add_settings_section(
            'vagra_msp_cta',
            __( 'Call to Action', 'vagra-msp' ),
            array( $this, 'render_section_cta' ),
            self::PAGE_SLUG . '-general'
        );

        add_settings_field( 'cta_text', __( 'Button Text', 'vagra-msp' ), array( $this, 'render_text_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_cta', array(
            'field'       => 'cta_text',
            'placeholder' => 'Free Security Assessment',
        ) );

        add_settings_field( 'cta_url', __( 'Button URL', 'vagra-msp' ), array( $this, 'render_text_field' ), self::PAGE_SLUG . '-general', 'vagra_msp_cta', array(
            'field'       => 'cta_url',
            'type'        => 'url',
            'placeholder' => '/contact/',
        ) );

        // --- Tab: Social ---
        add_settings_section(
            'vagra_msp_social',
            __( 'Social Media Profiles', 'vagra-msp' ),
            array( $this, 'render_section_social' ),
            self::PAGE_SLUG . '-social'
        );

        $social_fields = array(
            'social_linkedin' => array( 'label' => 'LinkedIn',  'placeholder' => 'https://linkedin.com/company/...' ),
            'social_twitter'  => array( 'label' => 'X / Twitter', 'placeholder' => 'https://x.com/...' ),
            'social_facebook' => array( 'label' => 'Facebook',  'placeholder' => 'https://facebook.com/...' ),
            'social_youtube'  => array( 'label' => 'YouTube',   'placeholder' => 'https://youtube.com/@...' ),
            'social_github'   => array( 'label' => 'GitHub',    'placeholder' => 'https://github.com/...' ),
        );

        foreach ( $social_fields as $key => $meta ) {
            add_settings_field( $key, $meta['label'], array( $this, 'render_text_field' ), self::PAGE_SLUG . '-social', 'vagra_msp_social', array(
                'field'       => $key,
                'type'        => 'url',
                'placeholder' => $meta['placeholder'],
            ) );
        }

        // --- Tab: Security ---
        add_settings_section(
            'vagra_msp_security',
            __( 'Security Features', 'vagra-msp' ),
            array( $this, 'render_section_security' ),
            self::PAGE_SLUG . '-security'
        );

        add_settings_field( 'show_security_headers', __( 'Security Headers Notice', 'vagra-msp' ), array( $this, 'render_checkbox_field' ), self::PAGE_SLUG . '-security', 'vagra_msp_security', array(
            'field'       => 'show_security_headers',
            'label'       => __( 'Show security headers status in the admin bar', 'vagra-msp' ),
            'description' => __( 'Displays a quick indicator of whether recommended HTTP security headers are present.', 'vagra-msp' ),
        ) );

        add_settings_field( 'show_ssl_badge', __( 'SSL Trust Badge', 'vagra-msp' ), array( $this, 'render_checkbox_field' ), self::PAGE_SLUG . '-security', 'vagra_msp_security', array(
            'field'       => 'show_ssl_badge',
            'label'       => __( 'Show SSL secured badge in footer', 'vagra-msp' ),
            'description' => __( 'Displays a small SSL-secured badge next to the footer copyright text.', 'vagra-msp' ),
        ) );

        // Chat status display.
        add_settings_field( 'chat_status', __( 'AI Chat Widget', 'vagra-msp' ), array( $this, 'render_chat_status_field' ), self::PAGE_SLUG . '-security', 'vagra_msp_security' );

        // --- Tab: API Keys ---
        add_settings_section(
            'vagra_msp_api',
            __( 'API Configuration', 'vagra-msp' ),
            array( $this, 'render_section_api' ),
            self::PAGE_SLUG . '-api'
        );

        add_settings_field( 'chat_api_key', __( 'Claude API Key', 'vagra-msp' ), array( $this, 'render_api_key_field' ), self::PAGE_SLUG . '-api', 'vagra_msp_api' );

        // --- Tab: Advanced ---
        add_settings_section(
            'vagra_msp_footer_section',
            __( 'Footer', 'vagra-msp' ),
            null,
            self::PAGE_SLUG . '-advanced'
        );

        add_settings_field( 'footer_text', __( 'Footer Copyright Text', 'vagra-msp' ), array( $this, 'render_textarea_field' ), self::PAGE_SLUG . '-advanced', 'vagra_msp_footer_section', array(
            'field'       => 'footer_text',
            'description' => __( 'Supports basic HTML. Use %year% for the current year.', 'vagra-msp' ),
        ) );

        add_settings_section(
            'vagra_msp_customizer_link',
            __( 'Appearance', 'vagra-msp' ),
            array( $this, 'render_section_customizer_link' ),
            self::PAGE_SLUG . '-advanced'
        );
    }

    // -------------------------------------------------------------------------
    // Section descriptions.
    // -------------------------------------------------------------------------

    public function render_section_company() {
        echo '<p class="vagra-section-description">' . esc_html__( 'Enter your MSP business contact details. These are used in the header, footer, and structured data.', 'vagra-msp' ) . '</p>';
    }

    public function render_section_cta() {
        echo '<p class="vagra-section-description">' . esc_html__( 'Configure the primary call-to-action button shown in the site header.', 'vagra-msp' ) . '</p>';
    }

    public function render_section_social() {
        echo '<p class="vagra-section-description">' . esc_html__( 'Add your social media profile URLs. Leave blank to hide a platform icon.', 'vagra-msp' ) . '</p>';
    }

    public function render_section_security() {
        echo '<p class="vagra-section-description">' . esc_html__( 'Toggle security-related visual features for your MSP site.', 'vagra-msp' ) . '</p>';
    }

    public function render_section_api() {
        echo '<p class="vagra-section-description">' . esc_html__( 'Manage API keys for the AI chat feature. Keys are stored securely in wp_options and are never exposed to the front end.', 'vagra-msp' ) . '</p>';
    }

    public function render_section_customizer_link() {
        printf(
            '<div class="vagra-info-box"><strong>%s</strong> %s <a href="%s">%s &rarr;</a></div>',
            esc_html__( 'Brand Colors & Typography', 'vagra-msp' ),
            esc_html__( 'are managed in the WordPress Customizer for live preview.', 'vagra-msp' ),
            esc_url( admin_url( 'customize.php?autofocus[panel]=vagra_msp_panel' ) ),
            esc_html__( 'Open Customizer', 'vagra-msp' )
        );
    }

    // -------------------------------------------------------------------------
    // Field renderers.
    // -------------------------------------------------------------------------

    public function render_text_field( $args ) {
        $value       = $this->get_option( $args['field'] );
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
        printf(
            '<input type="%s" name="%s[%s]" value="%s" class="regular-text" placeholder="%s" />',
            esc_attr( $type ),
            esc_attr( self::OPTION_KEY ),
            esc_attr( $args['field'] ),
            esc_attr( $value ),
            esc_attr( $placeholder )
        );
        if ( ! empty( $args['description'] ) ) {
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }
    }

    public function render_textarea_field( $args ) {
        $value = $this->get_option( $args['field'] );
        $rows  = isset( $args['rows'] ) ? $args['rows'] : 4;
        printf(
            '<textarea name="%s[%s]" rows="%d" class="large-text">%s</textarea>',
            esc_attr( self::OPTION_KEY ),
            esc_attr( $args['field'] ),
            absint( $rows ),
            esc_textarea( $value )
        );
        if ( ! empty( $args['description'] ) ) {
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }
    }

    public function render_checkbox_field( $args ) {
        $value = $this->get_option( $args['field'] );
        $label = isset( $args['label'] ) ? $args['label'] : __( 'Enabled', 'vagra-msp' );
        printf(
            '<label><input type="checkbox" name="%s[%s]" value="1" %s /> %s</label>',
            esc_attr( self::OPTION_KEY ),
            esc_attr( $args['field'] ),
            checked( $value, 1, false ),
            esc_html( $label )
        );
        if ( ! empty( $args['description'] ) ) {
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }
    }

    public function render_api_key_field() {
        $key    = get_option( 'vagra_msp_chat_api_key', '' );
        $masked = ! empty( $key ) ? str_repeat( '*', 8 ) . substr( $key, -4 ) : '';
        printf(
            '<input type="password" name="%s[chat_api_key]" value="" class="regular-text" placeholder="%s" autocomplete="off" />',
            esc_attr( self::OPTION_KEY ),
            esc_attr( $masked ? $masked : __( 'Enter API key', 'vagra-msp' ) )
        );
        if ( ! empty( $key ) ) {
            echo '<p class="description">' . esc_html__( 'A key is already saved. Enter a new one to replace it, or leave blank to keep the current key.', 'vagra-msp' ) . '</p>';
        }
    }

    public function render_chat_status_field() {
        $enabled = get_theme_mod( 'vagra_msp_chat_enabled', true );
        $status  = $enabled ? esc_html__( 'Enabled', 'vagra-msp' ) : esc_html__( 'Disabled', 'vagra-msp' );
        $class   = $enabled ? 'vagra-status--ok' : 'vagra-status--warn';
        printf(
            '<span class="%s">%s</span> &mdash; <a href="%s">%s</a>',
            esc_attr( $class ),
            $status,
            esc_url( admin_url( 'customize.php?autofocus[section]=vagra_msp_chat' ) ),
            esc_html__( 'Configure in Customizer', 'vagra-msp' )
        );
    }

    // -------------------------------------------------------------------------
    // Sanitization.
    // -------------------------------------------------------------------------

    public function sanitize_options( $input ) {
        $s = array();

        // Text fields.
        $s['company_name']    = sanitize_text_field( isset( $input['company_name'] ) ? $input['company_name'] : '' );
        $s['company_phone']   = sanitize_text_field( isset( $input['company_phone'] ) ? $input['company_phone'] : '' );
        $s['company_email']   = sanitize_email( isset( $input['company_email'] ) ? $input['company_email'] : '' );
        $s['company_address'] = sanitize_textarea_field( isset( $input['company_address'] ) ? $input['company_address'] : '' );

        // CTA.
        $s['cta_text'] = sanitize_text_field( isset( $input['cta_text'] ) ? $input['cta_text'] : 'Free Security Assessment' );
        $s['cta_url']  = esc_url_raw( isset( $input['cta_url'] ) ? $input['cta_url'] : '/contact/' );

        // Social links.
        $social_keys = array( 'social_linkedin', 'social_twitter', 'social_facebook', 'social_youtube', 'social_github' );
        foreach ( $social_keys as $skey ) {
            $s[ $skey ] = esc_url_raw( isset( $input[ $skey ] ) ? $input[ $skey ] : '' );
        }

        // Footer.
        $s['footer_text'] = wp_kses_post( isset( $input['footer_text'] ) ? $input['footer_text'] : '' );

        // Checkboxes.
        $s['show_security_headers'] = ! empty( $input['show_security_headers'] ) ? 1 : 0;
        $s['show_ssl_badge']        = ! empty( $input['show_ssl_badge'] ) ? 1 : 0;

        // API key — stored separately for security.
        if ( isset( $input['chat_api_key'] ) && ! empty( $input['chat_api_key'] ) ) {
            update_option( 'vagra_msp_chat_api_key', sanitize_text_field( $input['chat_api_key'] ) );
        }

        return $s;
    }

    // -------------------------------------------------------------------------
    // Settings page renderer.
    // -------------------------------------------------------------------------

    public function render_settings_page() {
        if ( ! current_user_can( self::CAPABILITY ) ) {
            return;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only tab switching.
        $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
        if ( ! array_key_exists( $active_tab, $this->tabs ) ) {
            $active_tab = 'general';
        }
        ?>
        <div class="wrap vagra-admin-wrap">
            <div class="vagra-admin-header">
                <h1><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'Vagra MSP Settings', 'vagra-msp' ); ?></h1>
                <p class="vagra-admin-version"><?php printf( esc_html__( 'Version %s', 'vagra-msp' ), esc_html( VAGRA_MSP_VERSION ) ); ?></p>
            </div>

            <?php settings_errors(); ?>

            <nav class="vagra-admin-tabs nav-tab-wrapper">
                <?php foreach ( $this->tabs as $slug => $tab ) : ?>
                    <a href="<?php echo esc_url( add_query_arg( 'tab', $slug, admin_url( 'admin.php?page=' . self::PAGE_SLUG ) ) ); ?>"
                       class="nav-tab <?php echo $active_tab === $slug ? 'nav-tab-active' : ''; ?>">
                        <span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
                        <?php echo esc_html( $tab['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <form method="post" action="options.php" class="vagra-admin-form">
                <?php settings_fields( 'vagra_msp_settings_group' ); ?>

                <?php foreach ( array_keys( $this->tabs ) as $slug ) : ?>
                    <div class="vagra-tab-panel <?php echo $active_tab === $slug ? 'vagra-tab-active' : ''; ?>">
                        <?php do_settings_sections( self::PAGE_SLUG . '-' . $slug ); ?>
                    </div>
                <?php endforeach; ?>

                <?php submit_button( __( 'Save Settings', 'vagra-msp' ) ); ?>
            </form>
        </div>
        <?php
    }

    // -------------------------------------------------------------------------
    // Admin assets.
    // -------------------------------------------------------------------------

    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_' . self::PAGE_SLUG !== $hook ) {
            return;
        }
        wp_enqueue_style(
            'vagra-msp-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            array(),
            VAGRA_MSP_VERSION
        );
    }

    // -------------------------------------------------------------------------
    // Dashboard widget.
    // -------------------------------------------------------------------------

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'vagra_msp_status_widget',
            __( 'Vagra MSP Theme Status', 'vagra-msp' ),
            array( $this, 'render_dashboard_widget' )
        );
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
                        <td>
                            <?php
                            $chat_enabled = get_theme_mod( 'vagra_msp_chat_enabled', true );
                            echo $chat_enabled ? esc_html__( 'Yes', 'vagra-msp' ) : esc_html__( 'No', 'vagra-msp' );
                            ?>
                        </td>
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
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=' . self::PAGE_SLUG ) ); ?>"><?php esc_html_e( 'Go to Settings', 'vagra-msp' ); ?> &rarr;</a>
            </p>
        </div>
        <?php
    }
}
