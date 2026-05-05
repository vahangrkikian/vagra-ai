<?php
/**
 * Vagra NSLookup Admin Settings Page
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vagra_NSL_Admin {

	const OPTION_KEY = 'vagra_nsl_options';
	const CAPABILITY = 'manage_options';

	private $defaults = array(
		'site_name'    => 'nslookup.am',
		'footer_text'  => '',
		'cta_text'     => 'Check DNS',
		'cta_url'      => '/ns-lookup/',
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
			__( 'nslookup.am Settings', 'vagra-nslookup' ),
			__( 'nslookup.am', 'vagra-nslookup' ),
			self::CAPABILITY,
			'vagra-nsl-settings',
			array( $this, 'render_settings_page' ),
			'dashicons-networking',
			59
		);
	}

	public function register_settings() {
		register_setting(
			'vagra_nsl_settings_group',
			self::OPTION_KEY,
			array( $this, 'sanitize_options' )
		);

		add_settings_section( 'vagra_nsl_general', __( 'General Settings', 'vagra-nslookup' ), array( $this, 'render_general_description' ), 'vagra-nsl-settings' );
		add_settings_field( 'site_name', __( 'Site Name', 'vagra-nslookup' ), array( $this, 'render_text_field' ), 'vagra-nsl-settings', 'vagra_nsl_general', array( 'field' => 'site_name' ) );

		add_settings_section( 'vagra_nsl_cta', __( 'Call to Action', 'vagra-nslookup' ), null, 'vagra-nsl-settings' );
		add_settings_field( 'cta_text', __( 'Button Text', 'vagra-nslookup' ), array( $this, 'render_text_field' ), 'vagra-nsl-settings', 'vagra_nsl_cta', array( 'field' => 'cta_text' ) );
		add_settings_field( 'cta_url', __( 'Button URL', 'vagra-nslookup' ), array( $this, 'render_text_field' ), 'vagra-nsl-settings', 'vagra_nsl_cta', array( 'field' => 'cta_url' ) );

		add_settings_section( 'vagra_nsl_footer_section', __( 'Footer', 'vagra-nslookup' ), null, 'vagra-nsl-settings' );
		add_settings_field( 'footer_text', __( 'Footer Text', 'vagra-nslookup' ), array( $this, 'render_textarea_field' ), 'vagra-nsl-settings', 'vagra_nsl_footer_section', array( 'field' => 'footer_text' ) );

		add_settings_section( 'vagra_nsl_api_section', __( 'API Keys', 'vagra-nslookup' ), array( $this, 'render_api_description' ), 'vagra-nsl-settings' );
		add_settings_field( 'chat_api_key', __( 'Claude API Key', 'vagra-nslookup' ), array( $this, 'render_api_key_field' ), 'vagra-nsl-settings', 'vagra_nsl_api_section' );

		add_settings_section( 'vagra_nsl_features', __( 'Features', 'vagra-nslookup' ), null, 'vagra-nsl-settings' );
		add_settings_field( 'chat_status', __( 'AI Chat Widget', 'vagra-nslookup' ), array( $this, 'render_chat_status_field' ), 'vagra-nsl-settings', 'vagra_nsl_features' );
	}

	public function render_general_description() {
		echo '<p>' . esc_html__( 'Configure your nslookup.am theme settings.', 'vagra-nslookup' ) . '</p>';
	}

	public function render_api_description() {
		echo '<p>' . esc_html__( 'Manage API keys for the AI chat feature. Keys are stored securely in wp_options.', 'vagra-nslookup' ) . '</p>';
	}

	public function sanitize_options( $input ) {
		$s = array();
		$s['site_name']   = sanitize_text_field( isset( $input['site_name'] ) ? $input['site_name'] : 'nslookup.am' );
		$s['cta_text']    = sanitize_text_field( isset( $input['cta_text'] ) ? $input['cta_text'] : 'Check DNS' );
		$s['cta_url']     = esc_url_raw( isset( $input['cta_url'] ) ? $input['cta_url'] : '/ns-lookup/' );
		$s['footer_text'] = wp_kses_post( isset( $input['footer_text'] ) ? $input['footer_text'] : '' );

		// Handle API key separately — store in its own option.
		if ( isset( $input['chat_api_key'] ) && ! empty( $input['chat_api_key'] ) ) {
			update_option( 'vagra_nsl_chat_api_key', sanitize_text_field( $input['chat_api_key'] ) );
		}

		return $s;
	}

	public function render_text_field( $args ) {
		$value = $this->get_option( $args['field'] );
		$type  = isset( $args['type'] ) ? $args['type'] : 'text';
		printf(
			'<input type="%s" name="%s[%s]" value="%s" class="regular-text" />',
			esc_attr( $type ),
			esc_attr( self::OPTION_KEY ),
			esc_attr( $args['field'] ),
			esc_attr( $value )
		);
	}

	public function render_textarea_field( $args ) {
		$value = $this->get_option( $args['field'] );
		printf(
			'<textarea name="%s[%s]" rows="4" class="large-text">%s</textarea>',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $args['field'] ),
			esc_textarea( $value )
		);
	}

	public function render_api_key_field() {
		$key    = get_option( 'vagra_nsl_chat_api_key', '' );
		$masked = ! empty( $key ) ? str_repeat( '*', 8 ) . substr( $key, -4 ) : '';
		printf(
			'<input type="password" name="%s[chat_api_key]" value="" class="regular-text" placeholder="%s" />',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $masked ? $masked : __( 'Enter API key', 'vagra-nslookup' ) )
		);
		if ( ! empty( $key ) ) {
			echo '<p class="description">' . esc_html__( 'A key is already saved. Enter a new one to replace it, or leave blank to keep the current key.', 'vagra-nslookup' ) . '</p>';
		}
	}

	public function render_chat_status_field() {
		$enabled = get_theme_mod( 'vagra_nsl_chat_enabled', true );
		$status  = $enabled ? esc_html__( 'Enabled', 'vagra-nslookup' ) : esc_html__( 'Disabled', 'vagra-nslookup' );
		$class   = $enabled ? 'vagra-status--ok' : 'vagra-status--warn';
		printf(
			'<span class="%s">%s</span> &mdash; <a href="%s">%s</a>',
			esc_attr( $class ),
			$status,
			esc_url( admin_url( 'customize.php?autofocus[section]=vagra_nsl_chat' ) ),
			esc_html__( 'Configure in Customizer', 'vagra-nslookup' )
		);
	}

	public function render_settings_page() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			return;
		}
		?>
		<div class="wrap vagra-admin-wrap">
			<div class="vagra-admin-header">
				<h1><span class="dashicons dashicons-networking"></span> <?php esc_html_e( 'nslookup.am Settings', 'vagra-nslookup' ); ?></h1>
				<p class="vagra-admin-version"><?php printf( esc_html__( 'Version %s', 'vagra-nslookup' ), esc_html( VAGRA_NSL_VERSION ) ); ?></p>
			</div>
			<?php settings_errors(); ?>
			<form method="post" action="options.php" class="vagra-admin-form">
				<?php
				settings_fields( 'vagra_nsl_settings_group' );
				do_settings_sections( 'vagra-nsl-settings' );
				submit_button( __( 'Save Settings', 'vagra-nslookup' ) );
				?>
			</form>
		</div>
		<?php
	}

	public function enqueue_admin_assets( $hook ) {
		if ( 'toplevel_page_vagra-nsl-settings' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'vagra-nsl-admin',
			get_template_directory_uri() . '/assets/css/admin.css',
			array(),
			VAGRA_NSL_VERSION
		);
	}

	public function add_dashboard_widget() {
		wp_add_dashboard_widget(
			'vagra_nsl_status_widget',
			__( 'nslookup.am Theme Status', 'vagra-nslookup' ),
			array( $this, 'render_dashboard_widget' )
		);
	}

	public function render_dashboard_widget() {
		$options    = get_option( self::OPTION_KEY, $this->defaults );
		$theme      = wp_get_theme( 'vagra-nslookup' );
		$chat_ok    = class_exists( 'Vagra_NSL_Chat' );
		$chat_class = $chat_ok ? 'vagra-status--ok' : 'vagra-status--warn';
		$chat_label = $chat_ok ? __( 'Active', 'vagra-nslookup' ) : __( 'Not loaded', 'vagra-nslookup' );
		?>
		<div class="vagra-dashboard-widget">
			<table class="widefat striped">
				<tbody>
					<tr>
						<td><strong><?php esc_html_e( 'Theme Version', 'vagra-nslookup' ); ?></strong></td>
						<td><?php echo esc_html( $theme->get( 'Version' ) ); ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'AI Chat Widget', 'vagra-nslookup' ); ?></strong></td>
						<td><span class="<?php echo esc_attr( $chat_class ); ?>"><?php echo esc_html( $chat_label ); ?></span></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Chat Enabled', 'vagra-nslookup' ); ?></strong></td>
						<td><?php $chat_enabled = get_theme_mod( 'vagra_nsl_chat_enabled', true ); echo $chat_enabled ? esc_html__( 'Yes', 'vagra-nslookup' ) : esc_html__( 'No', 'vagra-nslookup' ); ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'DNS API', 'vagra-nslookup' ); ?></strong></td>
						<td><span class="vagra-status--ok"><?php esc_html_e( 'Active', 'vagra-nslookup' ); ?></span></td>
					</tr>
				</tbody>
			</table>
			<p class="vagra-dashboard-widget__link">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vagra-nsl-settings' ) ); ?>"><?php esc_html_e( 'Go to Settings', 'vagra-nslookup' ); ?> &rarr;</a>
			</p>
		</div>
		<?php
	}
}
