<?php
/**
 * Uninstall procedure for the plugin.
 *
 * @package    Scroll_Top
 * @since      0.1.0
 * @author     Satrya
 * @copyright  Copyright (c) 2014, Satrya
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* If uninstall not called from WordPress exit. */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

/* Delete plugin settings. */
delete_option( 'scroll_top_plugin_settings' );