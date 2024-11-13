<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * Remove all the data that the plugin has created.
 *
 * @link       https://marianperca.com
 * @since      1.0.0
 *
 * @package    Personalized_Message_Fee_For_Woocommerce
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}