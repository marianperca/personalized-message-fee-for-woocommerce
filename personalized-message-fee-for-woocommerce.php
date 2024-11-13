<?php

/**
 * @link              https://marianperca.com
 * @since             1.0.0
 * @package           Personalized_Message_Fee_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Personalized message fee for Woocommerce
 * Plugin URI:        https://marianperca.com/personalized-message-fee-for-woocommerce
 * Description:       Personalized messages for Woocommerce. You can setup a fee and for which categories to use it.
 * Version:           1.0.0
 * Author:            Marian Perca
 * Author URI:        https://marianperca.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       personalized-message-fee-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PERSONALIZED_MESSAGE_FEE_FOR_WOOCOMMERCE_VERSION', '1.0.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-personalized-message-fee-for-woocommerce-activator.php
 */
function activate_personalized_message_fee_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personalized-message-fee-for-woocommerce-activator.php';
	Personalized_Message_Fee_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-personalized-message-fee-for-woocommerce-deactivator.php
 */
function deactivate_personalized_message_fee_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personalized-message-fee-for-woocommerce-deactivator.php';
	Personalized_Message_Fee_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_personalized_message_fee_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_personalized_message_fee_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-personalized-message-fee-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_personalized_message_fee_for_woocommerce() {

	$plugin = new Personalized_Message_Fee_For_Woocommerce();
	$plugin->run();

}
run_personalized_message_fee_for_woocommerce();
