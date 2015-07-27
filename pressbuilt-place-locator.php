<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pressbuilt.com
 * @since             1.0.0
 * @package           Pressbuilt_Place_Locator
 *
 * @wordpress-plugin
 * Plugin Name:       Pressbuilt Place Locator
 * Plugin URI:        https://pressbuilt.com
 * Description:       Displays locations on a Google Map based on specified criteria
 * Version:           1.0.0
 * Author:            Pressbuilt
 * Author URI:        https://pressbuilt.com
 * Text Domain:       pressbuilt-place-locator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pressbuilt-place-locator-activator.php
 */
function activate_pressbuilt_place_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressbuilt-place-locator-activator.php';
	Pressbuilt_Place_Locator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pressbuilt-place-locator-deactivator.php
 */
function deactivate_pressbuilt_place_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressbuilt-place-locator-deactivator.php';
	Pressbuilt_Place_Locator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pressbuilt_place_locator' );
register_deactivation_hook( __FILE__, 'deactivate_pressbuilt_place_locator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pressbuilt-place-locator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pressbuilt_place_locator() {

	$plugin = new Pressbuilt_Place_Locator();
	$plugin->run();

}
run_pressbuilt_place_locator();
