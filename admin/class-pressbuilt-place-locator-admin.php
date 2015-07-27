<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://pressbuilt.com
 * @since      1.0.0
 *
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/admin
 * @author     Aaron Forgue <aaron@pressbuilt.com>
 */
class Pressbuilt_Place_Locator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbuilt_Place_Locator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbuilt_Place_Locator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pressbuilt-place-locator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbuilt_Place_Locator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbuilt_Place_Locator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pressbuilt-place-locator-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create admin area menus and sub-menus
	 *
	 * @since    1.0.0
	 */
	public function admin_menus() {

		// Top level menu
		add_menu_page( 'Pressbuilt Place Locator', 'Pressbuilt Place Locator', 'manage_options', 'pressbuilt-display-locator' );

		// Sub-menus
		add_submenu_page( 'pressbuilt-display-locator', 'Settings', 'Settings', 'manage_options', 'pressbuilt-display-locator', array( $this, 'main_settings' ) );

	}

	/**
	 * Create plugin settings sections, fields and callbacks
	 *
	 * @since    1.0.0
	 */
	function register_plugin_settings() {
		// General settings section
		add_settings_section(
			'pressbuilt_display_locator_settings_general',
			__( 'General', $this->plugin_name ),
			array( $this, 'settings_section_general' ),
			'pressbuilt-display-locator'
		);
		
		// General settings fields
		add_settings_field(
			'pressbuilt_display_locator_facility_list',
			__( 'Facility List', $this->plugin_name ),
			array( $this, 'settings_field_facility_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_facility_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_insurance_list',
			__( 'Insurance List', $this->plugin_name ),
			array( $this, 'settings_field_insurance_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_insurance_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_service_list',
			__( 'Service List', $this->plugin_name ),
			array( $this, 'settings_field_service_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_service_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_facility_insurance_list',
			__( 'Facility-Insurance List', $this->plugin_name ),
			array( $this, 'settings_field_facility_insurance_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_facility_insurance_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_facility_service_list',
			__( 'Facility-Service List', $this->plugin_name ),
			array( $this, 'settings_field_facility_service_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_facility_service_list' )
		);
		
		// Register settings so that $_POST is handled
		register_setting( 'pressbuilt-display-locator', 'pressbuilt_display_locator_settings', array( $this, 'sanitize_setting_values' ) );
	}

	/**
	 * Output general section intro text
	 *
	 * @since    1.0.0
	 */
	function settings_section_general() {
 		echo '<p>' . __( 'Settings that control the behavior of the plugin.', $this->plugin_name ) . '</p>';
	}

	/**
	 * Output Facility List setting field
	 *
	 * @since    1.0.0
	 */
	function settings_field_facility_list( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$facility_list = '';
		if ( isset( $options['pressbuilt_display_locator_facility_list'] ) ) {
			$facility_list = $options['pressbuilt_display_locator_facility_list'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_facility_list]" id="pressbuilt_display_locator_facility_list" class="regular-text" value="<?php echo $facility_list; ?>">
 		<p><small>e.g., <code>http://example.com/facility_list.xml</code></small></p>
		<?php
	}

	/**
	 * Output Insurance List setting field
	 *
	 * @since    1.0.0
	 */
	function settings_field_insurance_list( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$insurance_list = '';
		if ( isset( $options['pressbuilt_display_locator_insurance_list'] ) ) {
			$insurance_list = $options['pressbuilt_display_locator_insurance_list'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_insurance_list]" id="pressbuilt_display_locator_insurance_list" class="regular-text" value="<?php echo $insurance_list; ?>">
 		<p><small>e.g., <code>http://example.com/insurance_list.xml</code></small></p>
		<?php
	}

	/**
	 * Output Service List setting field
	 *
	 * @since    1.0.0
	 */
	function settings_field_service_list( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$service_list = '';
		if ( isset( $options['pressbuilt_display_locator_service_list'] ) ) {
			$service_list = $options['pressbuilt_display_locator_service_list'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_service_list]" id="pressbuilt_display_locator_service_list" class="regular-text" value="<?php echo $service_list; ?>">
 		<p><small>e.g., <code>http://example.com/service_list.xml</code></small></p>
		<?php
	}

	/**
	 * Output Facility-Insurance List setting field
	 *
	 * @since    1.0.0
	 */
	function settings_field_facility_insurance_list( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$facility_insurance_list = '';
		if ( isset( $options['pressbuilt_display_locator_facility_insurance_list'] ) ) {
			$facility_insurance_list = $options['pressbuilt_display_locator_facility_insurance_list'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_facility_insurance_list]" id="pressbuilt_display_locator_facility_insurance_list" class="regular-text" value="<?php echo $facility_insurance_list; ?>">
 		<p><small>e.g., <code>http://example.com/facility_insurance_list.xml</code></small></p>
		<?php
	}

	/**
	 * Output Facility-Service List setting field
	 *
	 * @since    1.0.0
	 */
	function settings_field_facility_service_list( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$facility_service_list = '';
		if ( isset( $options['pressbuilt_display_locator_facility_service_list'] ) ) {
			$facility_service_list = $options['pressbuilt_display_locator_facility_service_list'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_facility_service_list]" id="pressbuilt_display_locator_facility_service_list" class="regular-text" value="<?php echo $facility_service_list; ?>">
 		<p><small>e.g., <code>http://example.com/facility_service_list.xml</code></small></p>
		<?php
	}

	/**
	 * Sanitize settings values
	 *
	 * @since    1.0.0
	 */
	public function sanitize_setting_values( $data ) {

		foreach ( $data as $option_name => $option_value ) {
			switch ( $option_name ) {
				case 'pressbuilt_display_locator_facility_list':
					if ( filter_var( $option_value, FILTER_VALIDATE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_list' ),
							__( 'Invalid characters for Facility List setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_insurance_list':
					if ( filter_var( $option_value, FILTER_VALIDATE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_insurance_list' ),
							__( 'Invalid characters for Insurance List setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_service_list':
					if ( filter_var( $option_value, FILTER_VALIDATE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_service_list' ),
							__( 'Invalid characters for Service List setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_facility_insurance_list':
					if ( filter_var( $option_value, FILTER_VALIDATE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_insurance_list' ),
							__( 'Invalid characters for Facility-Insurance List setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_facility_service_list':
					if ( filter_var( $option_value, FILTER_VALIDATE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_service_list' ),
							__( 'Invalid characters for Facility-Service List setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
			}
		}

		return $data;

	}

	/**
	 * Main settings page
	 *
	 * @since    1.0.0
	 */
	public function main_settings() {
		?>
		<div class="wrap">
			<h2>
				<?php echo __( 'Settings', $this->plugin_name ); ?>
			</h2>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'pressbuilt-display-locator' ); ?>
				<?php do_settings_sections( 'pressbuilt-display-locator' ); ?>
				<?php submit_button(); ?>
			</form>

		</div>
		<?php
	}

}
