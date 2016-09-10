<?php
/**
 * Sets up custom filters for the plugin's output.
 */

/**
 * Return the default plugin settings.
 */
function scroll_top_get_default_settings() {

	$default_settings = array(
		'scroll_top_enable'     => 1,
		'scroll_top_type'       => 'icon',
		'scroll_top_text'       => esc_html__( 'Back to Top', 'scroll-top' ),
		'scroll_top_position'   => 'right',
		'scroll_top_color'      => '#ffffff',
		'scroll_top_bg_color'   => '#000000',
		'scroll_top_radius'     => 'rounded',
		'scroll_top_animation'  => 'fade',
		'scroll_top_speed'      => 300,
		'scroll_top_distance'   => 300,
		'scroll_top_css'        => "#scrollUp {\npadding: 0px 10px;\n}"
	);

	// Allow dev to filter the default settings.
	return apply_filters( 'scroll_top_default_settings', $default_settings );
}

/**
 * Function for quickly grabbing settings for the plugin without having to call get_option()
 * every time we need a setting.
 */
function scroll_top_get_plugin_settings( $option = '' ) {
	$settings = get_option( 'scroll_top_plugin_settings', scroll_top_get_default_settings() );
	return $settings[$option];
}

/**
 * Loads the scripts for the plugin.
 */
function scroll_top_load_scripts() {

	// Get the enable option.
	$enable = scroll_top_get_plugin_settings( 'scroll_top_enable' );

	// Check if scroll top enable.
	if ( $enable ) {

		// Load the plugin front-end style.
		wp_enqueue_style( 'scroll-top-css', trailingslashit( ST_ASSETS ) . 'css/scroll-top.css', null, null );

		// Load the jQuery plugin.
		wp_enqueue_script( 'scroll-top-js', trailingslashit( ST_ASSETS ) . 'js/jquery.scrollUp.min.js', array( 'jquery' ), null, true );
	}

}
add_action( 'wp_enqueue_scripts', 'scroll_top_load_scripts' );

/**
 * Initialize the scrollup jquery plugin.
 */
function scroll_top_scrollup_init() {

	// Get the plugin settings value
	$enable  = scroll_top_get_plugin_settings( 'scroll_top_enable' );
	$speed   = absint( scroll_top_get_plugin_settings( 'scroll_top_speed' ) );
	$dist    = absint( scroll_top_get_plugin_settings( 'scroll_top_distance' ) );
	$animate = esc_attr( scroll_top_get_plugin_settings( 'scroll_top_animation' ) );
	$type    = esc_attr( scroll_top_get_plugin_settings( 'scroll_top_type' ) );
	$text    = sanitize_text_field( scroll_top_get_plugin_settings( 'scroll_top_text' ) );

	// Scroll top type
	$scrolltype = '';
	if ( $type === 'text' ) {
		$scrolltype = $text;
	} else {
		$scrolltype = '<span class="scroll-top"><i class="icon-up-open"></i></span>';
	}

	// Loads the scroll top
	if ( $enable ) {

		echo '
		<script id="scrolltop-custom-js">
		jQuery(document).ready(function($){
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
add_action( 'wp_footer', 'scroll_top_scrollup_init', 99 );

/**
 * Custom inline css for plugin usage.
 */
function scroll_top_custom_css() {

	// Get the plugin settings value
	$enable   = scroll_top_get_plugin_settings( 'scroll_top_enable' );
	$color    = scroll_top_get_plugin_settings( 'scroll_top_color' );
	$bgcolor  = scroll_top_get_plugin_settings( 'scroll_top_bg_color' );
	$radius   = scroll_top_get_plugin_settings( 'scroll_top_radius' );
	$position = scroll_top_get_plugin_settings( 'scroll_top_position' );
	$type     = scroll_top_get_plugin_settings( 'scroll_top_type' );
	$css      = scroll_top_get_plugin_settings( 'scroll_top_css' );

	// Border radius.
	$scroll_radius = '0';
	if ( $radius === 'rounded' ){
		$scroll_radius = '3px';
	} elseif ( $radius === 'circle' ) {
		$scroll_radius = '50%';
	}

	// Scroll top position.
	$scroll_position = '';
	if ( $position === 'right' ) {
		$scroll_position = 'right:20px;';
	} else {
		$scroll_position = 'left:20px;';
	}

	// Scroll top font-size.
	$scroll_fontsize = '';
	if ( $type === 'icon' ) {
		$scroll_fontsize = '25px';
	} else {
		$scroll_fontsize = '15px';
	}

	if ( $enable ) {

		echo '<!-- Scroll Top -->' . "\n";
		echo '<style id="scrolltop-custom-style">
		#scrollUp{border-radius:' . $scroll_radius . ';-webkit-border-radius:' . $scroll_radius . ';-moz-border-radius:' . $scroll_radius . ';font-size:' . $scroll_fontsize . ';opacity:0.8;filter:alpha(opacity=80);bottom:20px;' . $scroll_position . 'color:' . $color . ';background:' . $bgcolor . '; visibility: hidden;}
		#scrollUp:hover{opacity:1;filter:alpha(opacity=100);}
		@media (min-width: 600px) { #scrollUp { visibility: visible; } }
		' . $css . '
		</style>' . "\n";
		echo '<!-- End Scroll Top - https://wordpress.org/plugins/scroll-top/ -->' . "\n";

	}

}
add_action( 'wp_head', 'scroll_top_custom_css' );
