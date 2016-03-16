<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://pressbuilt.com
 * @since      1.0.0
 *
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pressbuilt_Place_Locator
 * @subpackage Pressbuilt_Place_Locator/public
 * @author     Aaron Forgue <aaron@pressbuilt.com>
 */
class Pressbuilt_Place_Locator_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pressbuilt-place-locator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_register_script( 'googlemaps', 'https://maps.googleapis.com/maps/api/js?libraries=places' );
		wp_enqueue_script( 'googlemaps' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pressbuilt-place-locator-public.js', array( 'jquery', 'googlemaps' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));

	}

	public function shortcode_locator_display( $atts ) {

		
		$facilities = Pressbuilt_Place_Locator::fetch_facilities();

		$insurance_plans = Pressbuilt_Place_Locator::fetch_insurance_plans();

		$services = Pressbuilt_Place_Locator::fetch_services();

		$counties = $this->fetch_counties();

		ob_start();

		require( dirname( __FILE__) . '/partials/shortcode-locator-display.php' );

		return ob_get_clean();
	}

	public function fetch_counties()
	{
		return [
			'FL-Florida' => 'FL-Florida',
			'IN-Allen' => 'IN-Allen',
			'IN-Floyd' => 'IN-Floyd',
			'KY-Boone' => 'KY-Boone',
			'KY-Campbell' => 'KY-Campbell',
			'KY-Jefferson' => 'KY-Jefferson',
			'KY-Kenton' => 'KY-Kenton',
			'NC-' => 'NC-',
			'NC-New Hanover' => 'NC-New Hanover',
			'OH-' => 'OH-',
			'OH-Adams' => 'OH-Adams',
			'OH-Allen' => 'OH-Allen',
			'OH-Ashland' => 'OH-Ashland',
			'OH-Ashtabula' => 'OH-Ashtabula',
			'OH-Athens' => 'OH-Athens',
			'OH-Auglaize' => 'OH-Auglaize',
			'OH-Belmont' => 'OH-Belmont',
			'OH-Brown' => 'OH-Brown',
			'OH-Butler' => 'OH-Butler',
			'OH-Carroll' => 'OH-Carroll',
			'OH-Champaign' => 'OH-Champaign',
			'OH-Clark' => 'OH-Clark',
			'OH-Clermont' => 'OH-Clermont',
			'OH-Clinton' => 'OH-Clinton',
			'OH-Columbiana' => 'OH-Columbiana',
			'OH-Coshocton' => 'OH-Coshocton',
			'OH-Crawford' => 'OH-Crawford',
			'OH-Cuyahoga' => 'OH-Cuyahoga',
			'OH-Darke' => 'OH-Darke',
			'OH-Defiance' => 'OH-Defiance',
			'OH-Delaware' => 'OH-Delaware',
			'OH-Erie' => 'OH-Erie',
			'OH-Fairfield' => 'OH-Fairfield',
			'OH-Franklin' => 'OH-Franklin',
			'OH-Fulton' => 'OH-Fulton',
			'OH-Geagua' => 'OH-Geagua',
			'OH-Geauga' => 'OH-Geauga',
			'OH-Greene' => 'OH-Greene',
			'OH-Guernsey' => 'OH-Guernsey',
			'OH-Hamilton' => 'OH-Hamilton',
			'OH-Harrison' => 'OH-Harrison',
			'OH-Henry' => 'OH-Henry',
			'OH-Highland' => 'OH-Highland',
			'OH-Hocking' => 'OH-Hocking',
			'OH-Holmes ' => 'OH-Holmes ',
			'OH-Huron' => 'OH-Huron',
			'OH-Jefferson' => 'OH-Jefferson',
			'OH-Kenton' => 'OH-Kenton',
			'OH-Knox' => 'OH-Knox',
			'OH-Lake' => 'OH-Lake',
			'OH-Lawrence' => 'OH-Lawrence',
			'OH-Licking' => 'OH-Licking',
			'OH-Logan' => 'OH-Logan',
			'OH-Lorain' => 'OH-Lorain',
			'OH-Lucas' => 'OH-Lucas',
			'OH-Mahoning' => 'OH-Mahoning',
			'OH-Marion' => 'OH-Marion',
			'OH-Medina' => 'OH-Medina',
			'OH-Mercer' => 'OH-Mercer',
			'OH-Miami' => 'OH-Miami',
			'OH-Montgomery' => 'OH-Montgomery',
			'OH-Ottawa' => 'OH-Ottawa',
			'OH-Paulding' => 'OH-Paulding',
			'OH-Perry' => 'OH-Perry',
			'OH-Pickaway' => 'OH-Pickaway',
			'OH-Portage' => 'OH-Portage',
			'OH-Preble' => 'OH-Preble',
			'OH-Putnam' => 'OH-Putnam',
			'OH-Richland' => 'OH-Richland',
			'OH-Ross' => 'OH-Ross',
			'OH-Sandusky' => 'OH-Sandusky',
			'OH-Scioto' => 'OH-Scioto',
			'OH-Seneca' => 'OH-Seneca',
			'OH-Shelby' => 'OH-Shelby',
			'OH-Stark' => 'OH-Stark',
			'OH-Summit' => 'OH-Summit',
			'OH-Trumbull' => 'OH-Trumbull',
			'OH-Tuscarawas' => 'OH-Tuscarawas',
			'OH-Union' => 'OH-Union',
			'OH-Van Wert' => 'OH-Van Wert',
			'OH-Warren' => 'OH-Warren',
			'OH-Wayne' => 'OH-Wayne',
			'OH-Williams' => 'OH-Williams',
			'OH-Wood' => 'OH-Wood',
			'PA-Lackawanna' => 'PA-Lackawanna',
			'PA-Lawrence' => 'PA-Lawrence',
			'VA-' => 'VA-',
			'VA-Scott' => 'VA-Scott',
			'VA-VA' => 'VA-VA',
			'VA-Virginia' => 'VA-Virginia',
		];
	}

	public function update_latlng() {
		$postId = $_POST['postId'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];

		if ( isset($postId) && isset($latitude) && isset($longitude) ) {
			$post = get_post( $postId );

			if ( $post ) {
				update_post_meta( $postId, 'pressbuilt_place_locator_latitude', $latitude );
				update_post_meta( $postId, 'pressbuilt_place_locator_longitude', $longitude );

				return 'success';
			} else {
				return 'no post';
			}
		} else {
			return 'no data';
		}
	}

	public function myStartSession() {
		if(!session_id()) {
			session_start();
		}
	}

}