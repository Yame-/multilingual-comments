<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Yame.be
 * @since             1.0.0
 * @package           Multilingual_Comments
 *
 * @wordpress-plugin
 * Plugin Name:       Multilingual Comments
 * Plugin URI:        https://yame.be
 * Description:       Shows Multilingual Comments & Reviews 
 * Version:           1.0.0
 * Author:            Yame 
 * Author URI:        Yame.be
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multilingual-comments
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-multilingual-comments-activator.php
 */
function activate_multilingual_comments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multilingual-comments-activator.php';
	Multilingual_Comments_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-multilingual-comments-deactivator.php
 */
function deactivate_multilingual_comments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multilingual-comments-deactivator.php';
	Multilingual_Comments_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_multilingual_comments' );
register_deactivation_hook( __FILE__, 'deactivate_multilingual_comments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-multilingual-comments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_multilingual_comments() {

	$plugin = new Multilingual_Comments();
	$plugin->run();

}
run_multilingual_comments();
