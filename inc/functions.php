<?php
/**
 * Sets up custom filters for the plugin's output.
 *
 * @package    Scroll_Top
 * @since      0.1.0
 * @author     Satrya
 * @copyright  Copyright (c) 2014, Satrya
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Load the scripts for the plugin. */
add_action( 'wp_enqueue_scripts', 'scroll_top_load_scripts' );

/* Initialize the scrollup jquery plugin. */
add_action( 'wp_footer', 'scroll_top_scrollup_init' );

/* Custom CSS for the scrollup. */
add_action( 'wp_head', 'scroll_top_custom_css' );

/**
 * Return the default plugin settings.
 *
 * @since  0.1
 * @return array
 */
function scroll_top_get_default_settings() {

	$default_settings = array(
		'scroll_top_enable'     => 1,
		'scroll_top_type'       => 'icon',
		'scroll_top_text'       => __( 'Back to Top', 'scrolltop' ),
		'scroll_top_position'   => 'right',
		'scroll_top_color'      => '#ffffff',
		'scroll_top_bg_color'   => '#000000',
		'scroll_top_radius'     => 'rounded',
		'scroll_top_animation'  => 'fade',
		'scroll_top_speed'      => 300,
		'scroll_top_distance'   => 300,
		'scroll_top_css'        => "#scrollUp {\npadding: 0px 10px;\n}"
	);

	/* Allow dev to filter the default settings. */
	return apply_filters( 'scroll_top_default_settings', $default_settings );
}

/**
 * Function for quickly grabbing settings for the plugin without having to call get_option() 
 * every time we need a setting.
 *
 * @since  0.1
 * @return array
 */
function scroll_top_get_plugin_settings( $option = '' ) {
	$settings = get_option( 'scroll_top_plugin_settings', scroll_top_get_default_settings() );
	return $settings[$option];
}

/**
 * Loads the scripts for the plugin.
 *
 * @since  0.1
 */
function scroll_top_load_scripts() {

	/* Get the enable option. */
	$enable  = scroll_top_get_plugin_settings( 'scroll_top_enable' );

	/* Check if scroll top enable. */
	if( $enable == '1' ) {

		/* Load the plugin front-end style. */
		wp_enqueue_style( 'scroll-top-css', trailingslashit( ST_ASSETS ) . 'css/scroll-top.css', null, null );

		/* Load the jQuery plugin. */
		wp_enqueue_script( 'scroll-top-js', trailingslashit( ST_ASSETS ) . 'js/jquery.scrollUp.min.js', array( 'jquery' ), null, true );
	}

}

/**
 * Initialize the scrollup jquery plugin.
 *
 * @since 0.1
 */
function scroll_top_scrollup_init() {
	$enable  = scroll_top_get_plugin_settings( 'scroll_top_enable' );
	$speed   = absint( scroll_top_get_plugin_settings( 'scroll_top_speed' ) );
	$dist    = absint( scroll_top_get_plugin_settings( 'scroll_top_distance' ) );
	$animate = scroll_top_get_plugin_settings( 'scroll_top_animation' );
	$type    = scroll_top_get_plugin_settings( 'scroll_top_type' );
	$text    = strip_tags( scroll_top_get_plugin_settings( 'scroll_top_text' ) );

	$scrolltype = '';
	if( $type == 'text' ) {
		$scrolltype = $text;
	} else {
		$scrolltype = '<span class="scroll-top"><i class="icon-up-open"></i></span>';
	}

	if( $enable == '1' ) {

		echo '
		<script id="scrolltop-custom-js">
		var $ = jQuery.noConflict();
		$(document).ready(function(){
			$.scrollUp({
				scrollSpeed: ' . $speed . ',
				animation: \'' . $animate . '\',
				scrollText: \'' . $scrolltype . '\',
				scrollDistance: ' . $dist . '
			});
		});
		</script>' . "\n";

	}

}

/**
 * Custom inline css for plugin usage.
 *
 * @since  0.1
 */
function scroll_top_custom_css() {
	$enable   = scroll_top_get_plugin_settings( 'scroll_top_enable' );
	$color    = scroll_top_get_plugin_settings( 'scroll_top_color' );
	$bgcolor  = scroll_top_get_plugin_settings( 'scroll_top_bg_color' );
	$radius   = scroll_top_get_plugin_settings( 'scroll_top_radius' );
	$position = scroll_top_get_plugin_settings( 'scroll_top_position' );
	$type     = scroll_top_get_plugin_settings( 'scroll_top_type' );
	$css      = scroll_top_get_plugin_settings( 'scroll_top_css' );

	/* border radius. */
	$scroll_radius = '';
	if ( $radius == 'rounded' ){
		$scroll_radius = '3px';
	} else {
		$scroll_radius = '0';
	}

	/* Scroll top position. */
	$scroll_position = '';
	if ( $position == 'right' ) {
		$scroll_position = 'right:20px;';
	} else {
		$scroll_position = 'left:20px;';
	}

	/* Scroll top font-size. */
	$scroll_fontsize = '';
	if ( $type == 'icon' ) {
		$scroll_fontsize = '25px';
	} else {
		$scroll_fontsize = '15px';
	}

	if( $enable == '1' ) {

echo '<style id="scrolltop-custom-style">
#scrollUp{border-radius:' . $scroll_radius . ';-webkit-border-radius:' . $scroll_radius . ';-moz-border-radius:' . $scroll_radius . ';font-size:' . $scroll_fontsize . ';opacity:0.8;filter:alpha(opacity=80);bottom:20px;' . $scroll_position . 'color:' . $color . ';background:' . $bgcolor . ';}
#scrollUp:hover{opacity:1;filter:alpha(opacity=100);}
@media screen and (max-width: 600px) {#scrollUp{display:none}}
' . $css . '
</style>';

	}

}