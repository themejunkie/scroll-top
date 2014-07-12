<?php
/**
 * Settings functions for the plugin.
 *
 * @package    Scroll_Top
 * @since      0.1.0
 * @author     Satrya
 * @copyright  Copyright (c) 2014, Satrya
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Plugin settings setup. */
add_action( 'admin_menu', 'scroll_top_admin_menu' );

/* Register the plugin settings. */
add_action( 'admin_init', 'scroll_top_register_settings' );

/* Register the setting sections and fields. */
add_action( 'admin_init', 'scroll_top_setting_sections_fields' );

/**
 * Sets up the plugin settings page and registers the plugin settings.
 *
 * @since  0.1
 * @link   http://codex.wordpress.org/Function_Reference/add_options_page
 */
function scroll_top_admin_menu() {

	$settings = add_options_page( 
		__( 'Scroll Top Settings', 'scrolltop' ),
		__( 'Scroll Top', 'scrolltop' ),
		'manage_options',
		'scroll_top_settings_page',
		'scroll_top_plugin_settings_render_page' 
	);

	if ( ! $settings )
		return;

	/* Provided hook_suffix that's returned to add scripts only on settings page. */
    add_action( 'load-' . $settings, 'scroll_top_styles_scripts' );

}

/**
 * Registers the Scroll Top settings.
 *
 * @since  0.1
 * @link   http://codex.wordpress.org/Function_Reference/register_setting
 */
function scroll_top_register_settings() {

	register_setting(
		'scroll_top_settings',
		'scroll_top_plugin_settings',
		'scroll_top_plugin_settings_validate'
	);

}

/**
 * Register the setting sections and fields.
 *
 * @since  0.1
 * @link   http://codex.wordpress.org/Function_Reference/add_settings_section
 * @link   http://codex.wordpress.org/Function_Reference/add_settings_field
 */
function scroll_top_setting_sections_fields() {

	/* Add General section. */
	add_settings_section(
		'scroll_top_general_settings', 
		'', 
		'__return_false',
		'scroll_top_settings_page'
	);

	/* Add enable/disable checkbox setting field. */
	add_settings_field(
		'scroll_top_enable',
		__( 'Enable', 'scrolltop' ),
		'scroll_top_enable_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'type' selectbox setting field. */
	add_settings_field(
		'scroll_top_type',
		__( 'Type', 'scrolltop' ),
		'scroll_top_type_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'text' input setting field. */
	add_settings_field(
		'scroll_top_text',
		__( 'Text', 'scrolltop' ),
		'scroll_top_text_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'position' selectbox setting field. */
	add_settings_field(
		'scroll_top_position',
		__( 'Position', 'scrolltop' ),
		'scroll_top_position_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'color' input setting field. */
	add_settings_field(
		'scroll_top_color',
		__( 'Color', 'scrolltop' ),
		'scroll_top_color_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'background color' input setting field. */
	add_settings_field(
		'scroll_top_bg_color',
		__( 'Background Color', 'scrolltop' ),
		'scroll_top_bg_color_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'radius' radio setting field. */
	add_settings_field(
		'scroll_top_radius',
		__( 'Radius', 'scrolltop' ),
		'scroll_top_radius_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'animation' radio setting field. */
	add_settings_field(
		'scroll_top_animation',
		__( 'Scroll to top animation', 'scrolltop' ),
		'scroll_top_animation_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'speed' input setting field. */
	add_settings_field(
		'scroll_top_speed',
		__( 'Scroll to top speed', 'scrolltop' ),
		'scroll_top_speed_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	/* Add 'Distance' input setting field. */
	add_settings_field(
		'scroll_top_distance',
		__( 'Scroll to top distance', 'scrolltop' ),
		'scroll_top_distance_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

	// Add 'Custom CSS' textarea setting field.
	add_settings_field(
		'scroll_top_css',
		__( 'Custom CSS', 'scrolltop' ),
		'scroll_top_css_field',
		'scroll_top_settings_page',
		'scroll_top_general_settings'
	);

}

/**
 * Enable/disable field fallback.
 *
 * @since  0.1
 */
function scroll_top_enable_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_enable' );

	$output = '<label for="enable_scroll_top">';
		$output .= '<input id="enable_scroll_top" type="checkbox" name="scroll_top_plugin_settings[scroll_top_enable]" value="1" ' . checked( 1, $settings, false ) . ' />';
		$output .= __( 'Enable scroll top?', 'scrolltop' );
	$output .= '</label>';

	echo $output;

}

/**
 * Type field fallback.
 *
 * @since  0.1
 */
function scroll_top_type_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_type' );
	
	$output = '<p><label>';
		$output .= '<input class="scroll-top-type" type="radio" name="scroll_top_plugin_settings[scroll_top_type]" value="text" ' . checked( 'text', $settings, false ) . ' />';
		$output .= __( 'Text', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p><label>';
		$output .= '<input class="scroll-top-type" type="radio" name="scroll_top_plugin_settings[scroll_top_type]" value="icon" ' . checked( 'icon', $settings, false ) . ' />';
		$output .= __( 'Icon Font', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p class="description">' . __( 'Select the type of the scroll to top.', 'scrolltop' ) . '</p>';

	echo $output;
	
}

/**
 * Text field fallback.
 *
 * @since  0.1
 */
function scroll_top_text_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_text' );

	$output = '<input class="regular-text" id="scroll-top-text" type="text" name="scroll_top_plugin_settings[scroll_top_text]" value="' . $settings . '" />';

	$output .= '<p class="description">' . __( 'If you choose the Text type, then please type the text here.', 'scrolltop' ) . '</p>';

	echo $output;

}

/**
 * Position field fallback.
 *
 * @since  0.1
 */
function scroll_top_position_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_position' );

	$output = '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_position]" value="left" ' . checked( 'left', $settings, false ) . ' />';
		$output .= __( 'Left Side', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_position]" value="right" ' . checked( 'right', $settings, false ) . ' />';
		$output .= __( 'Right Side', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p class="description">' . __( 'Select the position of the scroll to top button/text.', 'scrolltop' ) . '</p>';

	echo $output;

}

/**
 * Color field fallback.
 *
 * @since  0.1
 */
function scroll_top_color_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_color' );

	$output = '<input class="color-scroll" type="text" name="scroll_top_plugin_settings[scroll_top_color]" value="' . $settings . '" />';

	$output .= '<p class="description">' . __( 'Select the color for the scroll top button.', 'scrolltop' ) . '</p>';

	echo $output;
}

/**
 * Background Color field fallback.
 *
 * @since  0.1
 */
function scroll_top_bg_color_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_bg_color' );

	$output = '<input class="color-scroll" type="text" name="scroll_top_plugin_settings[scroll_top_bg_color]" value="' . $settings . '" />';

	$output .= '<p class="description">' . __( 'Select the background color for the scroll top button.', 'scrolltop' ) . '</p>';

	echo $output;
}

/**
 * Radius field fallback.
 *
 * @since  0.1
 */
function scroll_top_radius_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_radius' );

	$output = '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_radius]" value="square" ' . checked( 'square', $settings, false ) . ' />';
		$output .= __( 'Square', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_radius]" value="rounded" ' . checked( 'rounded', $settings, false ) . ' />';
		$output .= __( 'Rounded', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p class="description">' . __( 'The border radius type.', 'scrolltop' ) . '</p>';

	echo $output;
}

/**
 * Animation field fallback.
 *
 * @since  0.1
 */
function scroll_top_animation_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_animation' );

	$output = '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_animation]" value="fade" ' . checked( 'fade', $settings, false ) . ' />';
		$output .= __( 'Fade', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_animation]" value="slide" ' . checked( 'slide', $settings, false ) . ' />';
		$output .= __( 'Slide', 'scrolltop' );
	$output .= '</p></label>';

	$output .= '<p><label>';
		$output .= '<input type="radio" name="scroll_top_plugin_settings[scroll_top_animation]" value="none" ' . checked( 'none', $settings, false ) . ' />';
		$output .= __( 'None', 'scrolltop' );
	$output .= '</p></label>';

	echo $output;
}

/**
 * Speed field fallback.
 *
 * @since  0.1
 */
function scroll_top_speed_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_speed' );

	$output = '<input name="scroll_top_plugin_settings[scroll_top_speed]" type="number" step="50" min="50" id="scroll_top_speed" value="' . $settings . '" class="small-text" />';
	$output .= __( ' millisecond', 'scrolltop' );

	echo $output;
}

/**
 * Distance field fallback.
 *
 * @since  0.1
 */
function scroll_top_distance_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_distance' );

	$output = '<input name="scroll_top_plugin_settings[scroll_top_distance]" type="number" step="100" min="100" id="scroll_top_distance" value="' . $settings . '" class="small-text" />';
	$output .= __( ' px', 'scrolltop' );

	echo $output;
}

/**
 * Custom CSS fallback.
 *
 * @since  0.1
 */
function scroll_top_css_field() {
	$settings = scroll_top_get_plugin_settings( 'scroll_top_css' );

	$output = '<textarea name="scroll_top_plugin_settings[scroll_top_css]" id="scroll_top_css" cols="50" rows="12">' . $settings . '</textarea>';

	echo $output;
}

/**
 * Render the plugin settings page.
 *
 * @since  0.1
 */
function scroll_top_plugin_settings_render_page() { ?>
	
	<div class="wrap">
			
		<h2><?php _e( 'Scroll Top Settings', 'scrolltop' ); ?></h2>
		
		<div id="post-body" class="scroll-top-settings metabox-holder columns-2">
			
			<div id="post-body-content">
				<form method="post" action="options.php">
					<?php settings_fields( 'scroll_top_settings' ); ?>
					<?php do_settings_sections( 'scroll_top_settings_page' ); ?>
					<?php submit_button( esc_attr__( 'Update Settings', 'scrolltop' ), 'primary large' ); ?>
				</form>
			</div><!-- .post-body-content -->

			<div id="postbox-container-1" class="postbox-container">
				<div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Plugin Info', 'scrolltop' ); ?></span></h3>
						<div class="inside">
							<ul class="ul-square">
								<li><a href="http://satrya.me/" target="_blank"><?php _e( 'Author Website', 'scrolltop' ); ?></a></li>
								<li><a href="http://wordpress.org/support/plugin/scroll-top" target="_blank"><?php _e( 'Support', 'scrolltop' ); ?></a></li>
								<li><a href="http://wordpress.org/support/view/plugin-reviews/scroll-top" target="_blank"><?php _e( 'Rate plugin', 'scrolltop' ); ?></a></li>
							</ul>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'More Plugins', 'scrolltop' ); ?></span></h3>
						<div class="inside">
							<ul class="ul-square">
								<li><a href="http://wordpress.org/plugins/recent-posts-widget-extended/" target="_blank">Recent Posts Widget Extended</a></li>
								<li><a href="http://wordpress.org/plugins/advanced-random-posts-widget/" target="_blank">Advanced Random Posts Widget</a></li>
								<li><a href="http://wordpress.org/plugins/metro-buttons/" target="_blank">Metro Buttons</a></li>
								<li><a href="http://wordpress.org/plugins/easy-alert-shortcode/" target="_blank">Easy Alert Shortcode</a></li>
								<li><a href="http://wordpress.org/plugins/images-beautifier/" target="_blank">Images Beautifier</a></li>
							</ul>
						</div>
					</div>

				</div>
			</div><!-- .postbox-container -->

		</div><!-- .scroll-top-settings -->
		
	</div>

	<?php
}

/**
 * Validates/sanitizes the plugins settings after they've been submitted.
 *
 * @since  0.1
 * @return array
 */
function scroll_top_plugin_settings_validate( $settings ) {

	/* Set up an array of valid settings. */
	$valid_type     = array( 'text', 'icon' );
	$valid_position = array( 'left', 'right' );
	$valid_radius   = array( 'square', 'rounded' );
	$valid_animate  = array( 'fade', 'slide', 'none' );

	/* If the option is NOT in the array, set it to a default option. Do nothing if the option is valid. */
	if ( !in_array( $settings['scroll_top_type'], $valid_type ) )
		$settings['scroll_top_type'] = 'icon';

	if ( !in_array( $settings['scroll_top_position'], $valid_position ) )
		$settings['scroll_top_position'] = 'right';

	if ( !in_array( $settings['scroll_top_radius'], $valid_radius ) )
		$settings['scroll_top_radius'] = 'rounded';

	if ( !in_array( $settings['scroll_top_animation'], $valid_animate ) )
		$settings['scroll_top_animation'] = 'fade';
	
	$settings['scroll_top_enable']   = ( isset( $settings['scroll_top_enable'] ) && 1 == $settings['scroll_top_enable'] ? 1 : 0 );
	$settings['scroll_top_text']     = sanitize_text_field( $settings['scroll_top_text'] );
	$settings['scroll_top_color']    = sanitize_text_field( $settings['scroll_top_color'] );
	$settings['scroll_top_bg_color'] = sanitize_text_field( $settings['scroll_top_bg_color'] );
	$settings['scroll_top_speed']    = absint( $settings['scroll_top_speed'] );
	$settings['scroll_top_distance'] = absint( $settings['scroll_top_distance'] );
	$settings['scroll_top_css ']     = wp_filter_nohtml_kses( $settings['scroll_top_css '] );

	return $settings;
}

/**
 * Enqueue custom styles & scripts for plugin usage.
 *
 * @since  0.1
 */
function scroll_top_styles_scripts() {

	/* Load plugin admin style. */
	wp_enqueue_style( 'scroll-top-css', trailingslashit( ST_ASSETS ) . 'css/scroll-top-admin.css', array( 'wp-color-picker' ), null );

	/* Load plugin admin script. */
	wp_enqueue_script( 'scroll-top-scripts', trailingslashit( ST_ASSETS ) . 'js/scroll-top-admin.js', array( 'jquery', 'wp-color-picker' ), null, true );
}