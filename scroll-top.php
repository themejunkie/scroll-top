<?php
/**
 * Plugin Name:  Scroll Top
 * Plugin URI:   https://github.com/satrya/scroll-top
 * Description:  Adds a flexible Scroll to Top button to any post/page of your WordPress website.
 * Version:      0.1
 * Author:       Satrya
 * Author URI:   http://themephe.com/
 * Author Email: satrya@themephe.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @author    Satrya
 * @copyright Copyright (c) 2013, Satrya & ThemePhe
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Scroll_Top' ) ) :

class Scroll_Top {

	/**
	 * PHP5 constructor method.
	 *
	 * @since 0.1
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );
		
		/* Load the admin files. */
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 4 );

	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 0.1
	 */
	public function constants() {

		/* Set constant path to the plugin directory. */
		define( 'ST_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set the constant path to the plugin directory URI. */
		define( 'ST_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Set the constant path to the inc directory. */
		define( 'ST_INCLUDES', ST_DIR . trailingslashit( 'inc' ) );

		/* Set the constant path to the admin directory. */
		define( 'ST_ADMIN', ST_DIR . trailingslashit( 'admin' ) );

		/* Set the constant path to the aseets directory. */
		define( 'ST_ASSETS', ST_URI . trailingslashit( 'assets' ) );

	}

	/**
	 * Loads the translation files.
	 *
	 * @since 0.1
	 */
	public function i18n() {
		load_plugin_textdomain( 'scrolltop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 0.1
	 */
	public function includes() {
		require_once( ST_INCLUDES . 'functions.php' );
	}

	/**
	 * Loads the admin functions and files.
	 *
	 * @since  0.1
	 */
	public function admin() {
		if ( is_admin() )
			require_once( ST_ADMIN . 'admin.php' );
	}

}

new Scroll_Top;
endif;
?>