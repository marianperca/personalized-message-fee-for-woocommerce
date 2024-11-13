<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://marianperca.com
 * @since      1.0.0
 *
 * @package    Personalized_Message_Fee_For_Woocommerce
 * @subpackage Personalized_Message_Fee_For_Woocommerce/includes
 */
class Personalized_Message_Fee_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'personalized-message-fee-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
