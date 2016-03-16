<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://pressbuilt.com
 * @since      1.0.0
 *
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/includes
 * @author     Aaron Forgue <aaron@pressbuilt.com>
 */
class Pressbuilt_Place_Locator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pressbuilt_Place_Locator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'pressbuilt-place-locator';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pressbuilt_Place_Locator_Loader. Orchestrates the hooks of the plugin.
	 * - Pressbuilt_Place_Locator_i18n. Defines internationalization functionality.
	 * - Pressbuilt_Place_Locator_Admin. Defines all hooks for the admin area.
	 * - Pressbuilt_Place_Locator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pressbuilt-place-locator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pressbuilt-place-locator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pressbuilt-place-locator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pressbuilt-place-locator-public.php';

		$this->loader = new Pressbuilt_Place_Locator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pressbuilt_Place_Locator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pressbuilt_Place_Locator_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pressbuilt_Place_Locator_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Administration menus
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menus', 15 );

		// Plugin settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_plugin_settings' );

		// Custom Post Types
		$this->loader->add_action( 'init', $plugin_admin, 'custom_post_type_facility' );

		// Custom Taxonomies
		$this->loader->add_action( 'init', $plugin_admin, 'create_facility_taxonomies' );

		// Update Custom Terms
		$this->loader->add_action( 'init', $plugin_admin, 'register_custom_terms' );

		// Update Data
		$this->loader->add_action( 'init', $plugin_admin, 'update_data', 10 );

		// Import Facilities
		$this->loader->add_action( 'init', $plugin_admin, 'import_facilities', 99 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pressbuilt_Place_Locator_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_update_latlng', $plugin_public, 'update_latlng' );
		$this->loader->add_action( 'wp_ajax_nopriv_update_latlng', $plugin_public, 'update_latlng' );

		add_shortcode( 'locator-display', array( $plugin_public, 'shortcode_locator_display' ) );

		$this->loader->add_action( 'init', $plugin_public, 'myStartSession', 1 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pressbuilt_Place_Locator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public static function fetch_facilities()
	{

		$data = get_option( 'pressbuilt_display_locator_data' );
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $data['facility_list'] ) || !isset( $options['facility_list_last_run'] ) ) {

			$options['facility_list_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['facility_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['facility_list_last_run'] ) > 86400 && $options['facility_list_last_run_lock'] === false && isset( $options['pressbuilt_display_locator_soap_url'] ) ) {

			$options['facility_list_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$facilities = [];

			try {
				$client = new SoapClient( $options['pressbuilt_display_locator_soap_url'] );

				$facility_list_method = $options['pressbuilt_display_locator_facility_list'];
				$facility_list_array = $client->$facility_list_method();
				foreach ( $facility_list_array->GetFacilitiesResult->Facility as $f )
				{
					unset($f->InsuranceList);
					unset($f->ServiceList);
					$f = array_map('htmlentities', (array) $f);
					$facilities[ (int) $f['FacilityID'] ] = $f;
				}

				$data['facility_list'] = $facilities;
				update_option( 'pressbuilt_display_locator_data', $data );

			} catch ( Exception $e ){
				echo $e->getMessage();
			}

			$options['facility_list_last_run'] = time();
			$options['facility_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

			return $facilities;

		} else {

			return $data['facility_list'];

		}
	}

	public static function fetch_services()
	{

		$data = get_option( 'pressbuilt_display_locator_data' );
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $data['services_list'] ) || !isset( $options['services_list_last_run'] ) ) {

			$options['services_list_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['services_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['services_list_last_run'] ) > 86400 && $options['services_list_last_run_lock'] === false && isset( $options['pressbuilt_display_locator_soap_url'] ) ) {

			$options['services_list_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$services = [];

			try {
				$client = new SoapClient( $options['pressbuilt_display_locator_soap_url'] );

				$service_list_method = $options['pressbuilt_display_locator_service_list'];
				$service_list_array = $client->$service_list_method();
				foreach ( $service_list_array->GetServicesResult->Service as $s )
				{
					$s = array_map('htmlentities', (array) $s);
					$services[ (int) $s['ServiceID'] ] = (string) $s['ServiceName'];
				}

				$data['services_list'] = $services;
				update_option( 'pressbuilt_display_locator_data', $data );

			} catch ( Exception $e ){
				echo $e->getMessage();
			}

			$options['services_list_last_run'] = time();
			$options['services_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

			return $services;

		} else {

			return $data['services_list'];

		}
	}

	public static function fetch_insurance_plans()
	{

		$data = get_option( 'pressbuilt_display_locator_data' );
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $data['insurances_list'] ) || !isset( $options['insurances_list_last_run'] ) ) {

			$options['insurances_list_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['insurances_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['insurances_list_last_run'] ) > 86400 && $options['insurances_list_last_run_lock'] === false && isset( $options['pressbuilt_display_locator_soap_url'] ) ) {

			$options['insurances_list_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$insurance_plans = [];

			try {
				$client = new SoapClient( $options['pressbuilt_display_locator_soap_url'] );

				$insurance_plan_list_method = $options['pressbuilt_display_locator_insurance_list'];
				$insurance_plan_list_array = $client->$insurance_plan_list_method();
				foreach ( $insurance_plan_list_array->GetInsCompaniesResult->Insurance as $i )
				{
					$i = array_map('htmlentities', (array) $i);
					$insurance_plans[ (int) $i['InsID'] ] = (string) $i['InsName'];
				}

				$data['insurances_list'] = $insurance_plans;
				update_option( 'pressbuilt_display_locator_data', $data );

			} catch ( Exception $e ){
				echo $e->getMessage();
			}

			$options['insurances_list_last_run'] = time();
			$options['insurances_list_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

			return $insurance_plans;

		} else {

			return $data['insurances_list'];

		}
	}

	public static function fetch_facility_insurance_list()
	{

		$data = get_option( 'pressbuilt_display_locator_data' );
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $data['facility_insurance'] ) || !isset( $options['facility_insurance_last_run'] ) ) {

			$options['facility_insurance_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['facility_insurance_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['facility_insurance_last_run'] ) > 86400 && $options['facility_insurance_last_run_lock'] === false && isset( $options['pressbuilt_display_locator_soap_url'] ) ) {

			$options['facility_insurance_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$facility_insurance = [];

			try {
				$client = new SoapClient( $options['pressbuilt_display_locator_soap_url'] );

				$facility_insurance_list_method = $options['pressbuilt_display_locator_facility_insurance_list'];
				$facility_insurance_list_array = $client->$facility_insurance_list_method();
				foreach ( $facility_insurance_list_array->GetFacilityInsCompaniesResult->FacilityInsurance as $fi )
				{
					$facility_insurance[ (int) $fi->FacilityID ][] = (int) $fi->InsID;
				}

				$data['facility_insurance'] = $facility_insurance;
				update_option( 'pressbuilt_display_locator_data', $data );

			} catch ( Exception $e ){
				echo $e->getMessage();
			}

			$options['facility_insurance_last_run'] = time();
			$options['facility_insurance_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

			return $facility_insurance;

		} else {

			return $data['facility_insurance'];

		}
	}

	public static function fetch_facility_service_list()
	{

		$data = get_option( 'pressbuilt_display_locator_data' );
		$options = get_option( 'pressbuilt_display_locator_settings' );

		if ( !isset( $data['facility_service'] ) || !isset( $options['facility_service_last_run'] ) ) {

			$options['facility_service_last_run'] = strtotime( "Yesterday 12:01 AM" );
			$options['facility_service_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

		}

		if ( ( time() - $options['facility_service_last_run'] ) > 86400 && $options['facility_service_last_run_lock'] === false && isset( $options['pressbuilt_display_locator_soap_url'] ) ) {

			$options['facility_service_last_run_lock'] = true;
			update_option( 'pressbuilt_display_locator_settings', $options );

			$facility_service = [];

			try {
				$client = new SoapClient( $options['pressbuilt_display_locator_soap_url'] );

				$facility_service_list_method = $options['pressbuilt_display_locator_facility_service_list'];
				$facility_service_list_array = $client->$facility_service_list_method();
				foreach ( $facility_service_list_array->GetFacilityServicesResult->FacilityService as $fs )
				{
					$facility_service[ (int) $fs->FacilityID ][] = (int) $fs->ServiceID;
				}

				$data['facility_service'] = $facility_service;
				update_option( 'pressbuilt_display_locator_data', $data );

			} catch ( Exception $e ){
				echo $e->getMessage();
			}

			$options['facility_service_last_run'] = time();
			$options['facility_service_last_run_lock'] = false;
			update_option( 'pressbuilt_display_locator_settings', $options );

			return $facility_service;

		} else {

			return $data['facility_service'];

		}
	}

}
