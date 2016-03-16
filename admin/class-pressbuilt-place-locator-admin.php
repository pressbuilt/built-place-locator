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
			'pressbuilt_display_locator_soap_url',
			__( 'SOAP URL', $this->plugin_name ),
			array( $this, 'settings_field_soap_url' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_soap_url' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_facility_list',
			__( 'Facility List Method', $this->plugin_name ),
			array( $this, 'settings_field_facility_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_facility_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_insurance_list',
			__( 'Insurance List Method', $this->plugin_name ),
			array( $this, 'settings_field_insurance_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_insurance_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_service_list',
			__( 'Service List Method', $this->plugin_name ),
			array( $this, 'settings_field_service_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_service_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_facility_insurance_list',
			__( 'Facility-Insurance List Method', $this->plugin_name ),
			array( $this, 'settings_field_facility_insurance_list' ),
			'pressbuilt-display-locator',
			'pressbuilt_display_locator_settings_general',
			array( 'label_for' => 'pressbuilt_display_locator_facility_insurance_list' )
		);
		
		add_settings_field(
			'pressbuilt_display_locator_facility_service_list',
			__( 'Facility-Service List Method', $this->plugin_name ),
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
	function settings_field_soap_url( $args ) {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		$soap_url = '';
		if ( isset( $options['pressbuilt_display_locator_soap_url'] ) ) {
			$soap_url = $options['pressbuilt_display_locator_soap_url'];
		}

 		?>
 		<input type="text" name="pressbuilt_display_locator_settings[pressbuilt_display_locator_soap_url]" id="pressbuilt_display_locator_soap_url" class="regular-text" value="<?php echo $soap_url; ?>">
 		<p><small>e.g., <code>http://facilityservice.cpanohio.com/FacilityService.svc?wsdl</code></small></p>
		<?php
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
 		<p><small>e.g., <code>GetFacilities</code></small></p>
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
 		<p><small>e.g., <code>GetInsCompanies</code></small></p>
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
 		<p><small>e.g., <code>GetServices</code></small></p>
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
 		<p><small>e.g., <code>GetFacilityInsCompanies</code></small></p>
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
 		<p><small>e.g., <code>GetFacilityServices</code></small></p>
		<?php
	}

	/**
	 * Sanitize settings values
	 *
	 * @since    1.0.0
	 */
	public function sanitize_setting_values( $data ) {

		foreach ( $data as $option_name => &$option_value ) {
			switch ( $option_name ) {
				case 'pressbuilt_display_locator_soap_url':
					if ( filter_var( $option_value, FILTER_SANITIZE_URL ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_soap_url' ),
							__( 'Invalid URL for SOAP URL setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_facility_list':
					if ( filter_var( $option_value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_list' ),
							__( 'Invalid characters for Facility List Method setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_insurance_list':
					if ( filter_var( $option_value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_insurance_list' ),
							__( 'Invalid characters for Insurance List Method setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_service_list':
					if ( filter_var( $option_value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_service_list' ),
							__( 'Invalid characters for Service List Method setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_facility_insurance_list':
					if ( filter_var( $option_value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_insurance_list' ),
							__( 'Invalid characters for Facility-Insurance List Method setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
				case 'pressbuilt_display_locator_facility_service_list':
					if ( filter_var( $option_value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH ) === false ) {
						add_settings_error(
							$option_name,
							esc_attr( 'pressbuilt_display_locator_facility_service_list' ),
							__( 'Invalid characters for Facility-Service List Method setting. Please remove special characters or spaces', $this->plugin_name ),
							'error'
						);
					}
					break;
			}
			$option_value = trim( $option_value );
		}

		return $data;

	}

	/**
	 * Main settings page
	 *
	 * @since    1.0.1
	 */
	public function main_settings() {

		$options = get_option( 'pressbuilt_display_locator_settings' );
		?>
		<div class="wrap">
			<h2>
				<?php echo __( 'Settings', $this->plugin_name ); ?>
			</h2>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'pressbuilt-display-locator' ); ?>
				<?php do_settings_sections( 'pressbuilt-display-locator' ); ?>
				<?php submit_button( 'Save and Update Data' ); ?>
				<h3>Clicking Save and Update will store any changes above (if applicable) and also re-run all data imports from the SOAP URL.</h3>
			</form>

		</div>
		<?php
		date_default_timezone_set(get_option('timezone_string'));
		echo 'register_custom_terms_last_run '.date( "Y-m-d h:i:s A", $options['register_custom_terms_last_run'] ).($options['register_custom_terms_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'facility_list_last_run '.date( "Y-m-d h:i:s A", $options['facility_list_last_run'] ).($options['facility_list_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'insurances_list_last_run '.date( "Y-m-d h:i:s A", $options['insurances_list_last_run'] ).($options['insurances_list_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'services_list_last_run '.date( "Y-m-d h:i:s A", $options['services_list_last_run'] ).($options['services_list_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'facility_insurance_last_run '.date( "Y-m-d h:i:s A", $options['facility_insurance_last_run'] ).($options['facility_insurance_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'facility_service_last_run '.date( "Y-m-d h:i:s A", $options['facility_service_last_run'] ).($options['facility_service_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
		echo 'import_facilities_last_run '.date( "Y-m-d h:i:s A", $options['import_facilities_last_run'] ).($options['import_facilities_last_run_lock'] ? ' <em>*locked*</em>' : '').'<br>';
	}

	/**
	 * Facilities Custom Post Type
	 *
	 * @since    1.0.0
	 */
	public function custom_post_type_facility() {

		if ( !post_type_exists( 'facilities' ) ) {

			$labels = array(
				'name'                => _x( 'Facilities', 'Post Type General Name', 'pressbuilt_display_locator' ),
				'singular_name'       => _x( 'Facility', 'Post Type Singular Name', 'pressbuilt_display_locator' ),
				'menu_name'           => __( 'Facilities', 'pressbuilt_display_locator' ),
				'parent_item_colon'   => __( 'Parent Facility', 'pressbuilt_display_locator' ),
				'all_items'           => __( 'All Facilities', 'pressbuilt_display_locator' ),
				'view_item'           => __( 'View Facility', 'pressbuilt_display_locator' ),
				'add_new_item'        => __( 'Add New Facility', 'pressbuilt_display_locator' ),
				'add_new'             => __( 'Add Facility', 'pressbuilt_display_locator' ),
				'edit_item'           => __( 'Edit Facility', 'pressbuilt_display_locator' ),
				'update_item'         => __( 'Update Facility', 'pressbuilt_display_locator' ),
				'search_items'        => __( 'Search Facility', 'pressbuilt_display_locator' ),
				'not_found'           => __( 'Not Found', 'pressbuilt_display_locator' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'pressbuilt_display_locator' ),
			);

			$args = array(
				'label'               => __( 'facilities', 'pressbuilt_display_locator' ),
				'description'         => __( 'Facilities', 'pressbuilt_display_locator' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', ),
				'taxonomies'          => array( 'county', 'insurance', 'service' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);

			register_post_type( 'facilities', $args );

		}
	}

	/**
	 * Facilities Custom Taxonomy
	 *
	 * @since    1.0.0
	 */
	public function create_facility_taxonomies() {

		// County
		if ( !taxonomy_exists( 'county' ) ) {
			$labels = array(
				'name'              => _x( 'Counties', 'taxonomy general name' ),
				'singular_name'     => _x( 'County', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Counties' ),
				'all_items'         => __( 'All Counties' ),
				'parent_item'       => __( 'Parent County' ),
				'parent_item_colon' => __( 'Parent County:' ),
				'edit_item'         => __( 'Edit County' ),
				'update_item'       => __( 'Update County' ),
				'add_new_item'      => __( 'Add New County' ),
				'new_item_name'     => __( 'New County Name' ),
				'menu_name'         => __( 'Counties' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'sort'				=> true,
				'rewrite'           => array( 'facility' => 'county' ),
			);

			register_taxonomy( 'county', array( 'facilities' ), $args );
		}

		// Insurance
		if ( !taxonomy_exists( 'insurance' ) ) {
			$labels = array(
				'name'                       => _x( 'Insurance Plans', 'taxonomy general name' ),
				'singular_name'              => _x( 'Insurance Plan', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Insurance Plans' ),
				'popular_items'              => __( 'Popular Insurance Plans' ),
				'all_items'                  => __( 'All Insurance Plans' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Insurance Plan' ),
				'update_item'                => __( 'Update Insurance Plan' ),
				'add_new_item'               => __( 'Add New Insurance Plan' ),
				'new_item_name'              => __( 'New Insurance Plan Name' ),
				'separate_items_with_commas' => __( 'Separate insurance plans with commas' ),
				'add_or_remove_items'        => __( 'Add or remove insurance plans' ),
				'choose_from_most_used'      => __( 'Choose from the most used insurance plans' ),
				'not_found'                  => __( 'No insurance plans found.' ),
				'menu_name'                  => __( 'Insurance Plans' ),
			);

			$args = array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'insurance' ),
			);

			register_taxonomy( 'insurance', 'facilities', $args );
		}

		// Service
		if ( !taxonomy_exists( 'service' ) ) {
			$labels = array(
				'name'                       => _x( 'Services', 'taxonomy general name' ),
				'singular_name'              => _x( 'Service', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Services' ),
				'popular_items'              => __( 'Popular Services' ),
				'all_items'                  => __( 'All Services' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Service' ),
				'update_item'                => __( 'Update Service' ),
				'add_new_item'               => __( 'Add New Service' ),
				'new_item_name'              => __( 'New Service Name' ),
				'separate_items_with_commas' => __( 'Separate services with commas' ),
				'add_or_remove_items'        => __( 'Add or remove services' ),
				'choose_from_most_used'      => __( 'Choose from the most used services' ),
				'not_found'                  => __( 'No services found.' ),
				'menu_name'                  => __( 'Services' ),
			);

			$args = array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'service' ),
			);

			register_taxonomy( 'service', 'facilities', $args );
		}
	}

	/**
	 * Register Custom Terms
	 *
	 * @since    1.0.0
	 */
	public function register_custom_terms() {

		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $options['register_custom_terms_last_run'] ) ) {

			$options['register_custom_terms_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['register_custom_terms_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['register_custom_terms_last_run'] ) > 86400 && $options['register_custom_terms_last_run_lock'] === false ) {

			$options['register_custom_terms_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			if ( taxonomy_exists( 'insurance' ) ) {
				$insurance_plans = Pressbuilt_Place_Locator::fetch_insurance_plans();
				if ( is_array( $insurance_plans ) ) {
					foreach ( $insurance_plans as $id => $plan ) {
						wp_insert_term( $plan, 'insurance', array( 'slug' => sanitize_title( $plan ), 'description' => 'InsID: '.$id ) );
					}
				}
			}

			if ( taxonomy_exists( 'service' ) ) {
				$services = Pressbuilt_Place_Locator::fetch_services();
				if ( is_array( $services ) ) {
					foreach ( $services as $id => $service ) {
						wp_insert_term( $service, 'service', array( 'slug' => sanitize_title( $service ), 'description' => 'ServiceID: '.$id ) );
					}
				}
			}

			if ( taxonomy_exists( 'county' ) ) {
				$facilities = Pressbuilt_Place_Locator::fetch_facilities();
				if ( is_array( $facilities ) ) {
					foreach ( $facilities as $id => $facility ) {
						if ( !empty( $facility['State'] ) ) {
							$parent_term = term_exists( $facility['State'], 'county' );
							if ( !$parent_term['term_id'] ) {
								$parent_term = wp_insert_term( $facility['State'], 'county', array( 'slug' => sanitize_title( $facility['State'] ) ) );
							}
							if (!empty( $facility['County'] ) && !empty( $parent_term['term_id'] ) ) {
								wp_insert_term( $facility['State'].'-'.$facility['County'], 'county', array( 'parent' => $parent_term['term_id'], 'slug' => sanitize_title( $facility['State'].'-'.$facility['County'] ) ) );
							}
						}
					}
				}
			}

			$options['register_custom_terms_last_run'] = time();
			$options['register_custom_terms_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}
	}

	public function update_data() {
		Pressbuilt_Place_Locator::fetch_facilities();
		Pressbuilt_Place_Locator::fetch_insurance_plans();
		Pressbuilt_Place_Locator::fetch_services();
		Pressbuilt_Place_Locator::fetch_facility_insurance_list();
		Pressbuilt_Place_Locator::fetch_facility_service_list();
	}

	/**
	 * Import Facilities
	 *
	 * @since    1.0.0
	 */
	public function import_facilities() {

		global $wpdb;

		ini_set('max_execution_time', 600);
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $options['import_facilities_last_run'] ) ) {

			$options['import_facilities_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['import_facilities_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['import_facilities_last_run'] ) > 86400 && $options['import_facilities_last_run_lock'] === false ) {

			$options['import_facilities_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$wpdb->query("UPDATE `wp_posts` SET `post_status` = 'draft' WHERE `post_type` = 'facilities'");

			$facilities = Pressbuilt_Place_Locator::fetch_facilities();
			$insurance_plans = Pressbuilt_Place_Locator::fetch_insurance_plans();
			$services = Pressbuilt_Place_Locator::fetch_services();

			$facility_insurances = Pressbuilt_Place_Locator::fetch_facility_insurance_list();
			$facility_services = Pressbuilt_Place_Locator::fetch_facility_service_list();

			foreach ( $facilities as $id => $facility ) {
				
				$post_status = strtolower($facility['Active']) == '1' ? 'publish' : 'draft';
				$post_title = str_replace('&nbsp;', '', $facility['FacilityName']);

				$post_args = array(
					'post_type' => 'facilities',
					'post_title' => trim($post_title),
					'post_content' => '',
					'post_status' => $post_status,
					'post_author' => 1,
					'comment_status' => 'closed',
					'ping_status' => 'closed'
				);

				$search_args = array(
					'post_type' => 'facilities',
					'meta_query' => array(
						array(
							'key' => 'pressbuilt_place_locator_facility_id',
							'value' => $facility['FacilityID']
						)
					)
				);
				$post_query = new WP_Query( $search_args );

				if ( $post_query->have_posts() ) {
					$post_args['ID'] = $post_query->post->ID;
				}

				$post_id = wp_insert_post( $post_args );

				if ( $post_id ) {
					if ( !empty( $facility['Address'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_address1', $facility['Address'] );
					if ( !empty( $facility['Address2'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_address2', $facility['Address2'] );
					if ( !empty( $facility['CLIANumber'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_clia_number', $facility['CLIANumber'] );
					if ( !empty( $facility['City'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_city', $facility['City'] );
					if ( !empty( $facility['CorpDate'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_corp_date', $facility['CorpDate'] );
					if ( !empty( $facility['CorpID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_corp_id', $facility['CorpID'] );
					if ( !empty( $facility['County'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_county', $facility['County'] );
					if ( !empty( $facility['CreatedBy'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_created_by', $facility['CreatedBy'] );
					if ( !empty( $facility['CreatedDate'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_created_date', $facility['CreatedDate'] );
					if ( !empty( $facility['Email'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_email', $facility['Email'] );
					if ( !empty( $facility['FacilityID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_facility_id', $facility['FacilityID'] );
					if ( !empty( $facility['Fax1'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_fax1', $facility['Fax1'] );
					if ( !empty( $facility['Fax2'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_fax2', $facility['Fax2'] );
					if ( !empty( $facility['Fax3'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_fax2', $facility['Fax3'] );
					if ( !empty( $facility['LastModifiedBy'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_last_modified_by', $facility['LastModifiedBy'] );
					if ( !empty( $facility['LastModifiedDate'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_last_modified_date', $facility['LastModifiedDate'] );
					if ( !empty( $facility['LegalName'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_legal_name', $facility['LegalName'] );
					if ( !empty( $facility['MedicaidID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_medicaid_id', $facility['MedicaidID'] );
					if ( !empty( $facility['MedicareID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_medicare_id', $facility['MedicareID'] );
					if ( !empty( $facility['NPI'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_npi', $facility['NPI'] );
					if ( !empty( $facility['NumBeds'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_num_beds', $facility['NumBeds'] );
					if ( !empty( $facility['Phone'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_phone', $facility['Phone'] );
					if ( !empty( $facility['State'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_state', $facility['State'] );
					if ( !empty( $facility['StateCorp'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_state_corp', $facility['StateCorp'] );
					if ( !empty( $facility['StateID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_state_id', $facility['StateID'] );
					if ( !empty( $facility['TaxID'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_tax_id', $facility['TaxID'] );
					if ( !empty( $facility['Zip'] ) ) update_post_meta( $post_id, 'pressbuilt_place_locator_zip', $facility['Zip'] );

					$county_terms = array();
					if ( !empty( $facility['State'] ) ) {
						$state_slug = sanitize_title( $facility['State'] );
						$state_cat = get_term_by( 'slug', $state_slug, 'county' );
						if ( $state_cat->term_id ) {
							$county_terms[] = $state_cat->term_id;
						}
					}

					if ( !empty( $facility['County'] ) ) {
						$county_slug = sanitize_title( $facility['State'].'-'.$facility['County'] );
						$county_cat = get_term_by( 'slug', $county_slug, 'county' );
						if ( $county_cat->term_id ) {
							$county_terms[] = $county_cat->term_id;
						}
					}
					if ( !empty( $county_terms ) ) {
						$county_terms = array_map( 'intval', $county_terms );
						$county_terms = array_unique( $county_terms );
						wp_set_object_terms( $post_id, $county_terms, 'county' );
					}

					$fac_insurance_plan_ids = array();
					if ( array_key_exists( $id, $facility_insurances ) ) {
						foreach ( $facility_insurances[$id] as $insurance_id ) {
							if ( !empty ( $insurance_plans[$insurance_id] ) ) {
								$tag_slug = sanitize_title( $insurance_plans[$insurance_id] );
								$tag = get_term_by( 'slug', $tag_slug, 'insurance' );
								if ( $tag->term_id ) {
									$fac_insurance_plan_ids[] = $tag->term_id;
								}
							}
						}

						if ( !empty( $fac_insurance_plan_ids ) ) {
							$fac_insurance_plan_ids = array_map( 'intval', $fac_insurance_plan_ids );
							$fac_insurance_plan_ids = array_unique( $fac_insurance_plan_ids );
							wp_set_object_terms( $post_id, $fac_insurance_plan_ids, 'insurance' );
						}
					}

					$fac_service_ids = array();
					if ( array_key_exists( $id, $facility_services ) ) {
						foreach ( $facility_services[$id] as $service_id ) {
							if ( !empty ( $services[$service_id] ) ) {
								$tag_slug = sanitize_title( $services[$service_id] );
								$tag = get_term_by( 'slug', $tag_slug, 'service' );
								if ( $tag->term_id ) {
									$fac_service_ids[] = $tag->term_id;
								}
							}
						}

						if ( !empty( $fac_service_ids ) ) {
							$fac_service_ids = array_map( 'intval', $fac_service_ids );
							$fac_service_ids = array_unique( $fac_service_ids );
							wp_set_object_terms( $post_id, $fac_service_ids, 'service' );
						}
					}
				}
			}

			$options['import_facilities_last_run'] = time();
			$options['import_facilities_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );
		}
	}

}
