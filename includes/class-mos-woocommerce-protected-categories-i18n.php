<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.mdmostakshahid.com
 * @since      1.0.0
 *
 * @package    Mos_Woocommerce_Protected_Categories
 * @subpackage Mos_Woocommerce_Protected_Categories/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mos_Woocommerce_Protected_Categories
 * @subpackage Mos_Woocommerce_Protected_Categories/includes
 * @author     Md. Mostak Shahid <mostak.shahid@gmail.com>
 */
class Mos_Woocommerce_Protected_Categories_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mos-woocommerce-protected-categories',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
