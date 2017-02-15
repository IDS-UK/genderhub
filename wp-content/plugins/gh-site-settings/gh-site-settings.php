<?php
/*
Plugin Name: GH Custom Site Settings
Plugin URI: https://www.slikkr.com/
Description: To enable management of custom site options and settings
Version: 0.5
Author: Sarah Cox
Author URI: https://www.slikkr.com
Text Domain: genderhub
*/
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 09/06/2016
 * Time: 11:26
 */
function gh_options_menu() {

	add_menu_page(
		'Custom Site Settings',
		'Custom Site Settings',
		'administrator',
		'gh-site-settings-menu',
		'gh_custom_settings_menu',
		'dashicons-admin-appearance',
		4
	);

	add_submenu_page(
		'General Settings',
		'General Settings',
		'administrator',
		'gh_custom_general_settings',
		'gh_custom_display'
	);

	add_submenu_page(
		'gh_site_settings_menu',
		__( 'Contact Information', 'genderhub' ),
		__( 'Contact Information', 'genderhub' ),
		'administrator',
		'gh_other_custom_settings',
		create_function( null, 'gh_custom_display( "other_settings" );' )
	);

} // end gh_options_menu
add_action( 'admin_menu', 'gh_options_menu' );


function gh_custom_settings_menu( $active_tab = '' ) {
	?>
	<div class="wrap">

		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Custom Site Settings For GenderHub', 'genderhub' ); ?></h2>
		<?php settings_errors(); ?>

		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if( $active_tab == 'other_settings' ) {
			$active_tab = 'other_settings';
		} else {
			$active_tab = 'general_settings';
		} ?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=gh-site-settings-menu&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General Options', 'genderhub' ); ?></a>
			<a href="?page=gh-site-settings-menu&tab=other_settings" class="nav-tab <?php echo $active_tab == 'other_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Other Settings', 'genderhub' ); ?></a>
		</h2>

		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php

			if( $active_tab == 'general_settings' ) {

				settings_fields( 'gh_custom_general_settings' );
				do_settings_sections( 'gh_custom_general_settings' );

			} elseif( $active_tab == 'other_settings' ) {

				settings_fields( 'gh_other_custom_settings' );
				do_settings_sections( 'gh_other_custom_settings' );

			}

			submit_button();

			?>
		</form>

	</div>
	<?php
}

function gh_default_general_settings() {

	$defaults = array(
		'gh_reports_narrative'  => '',
	);

	return apply_filters( 'gh_default_general_settings', $defaults );

}

function gh_default_other_settings() {

	$defaults = array();

	return apply_filters( 'gh_default_other_settings', $defaults );

}

function gh_initialize_general_settings() {
	if( false == get_option( 'gh_custom_general_settings' ) ) {
		add_option( 'gh_custom_general_settings', apply_filters( 'gh_default_general_settings', gh_default_general_settings() ) );
	}

	add_settings_section(
		'misc_settings_section',
		'Miscellaneous Settings',
		'gh_misc_settings_callback',
		'gh_custom_general_settings'
	);

	// miscellaneous settings fields
	add_settings_field(
		'reports_narrative',
		'Reports Narrative',
		'gh_reports_narrative_callback',
		'gh_custom_general_settings',
		'misc_settings_section',
		array('Text to be displayed on the Content Reports page.')
	);

	register_setting(
		'gh_custom_general_settings',
		'gh_custom_general_settings',
		'gh_validate_image_upload'
	);

}
add_action( 'admin_init', 'gh_initialize_general_settings' );

function gh_initialize_other_settings() {
	if( false == get_option( 'gh_other_custom_settings' ) ) {
		add_option( 'gh_other_custom_settings', apply_filters( 'gh_default_other_settings', gh_default_other_settings() ) );
	}

	add_settings_section(
		'other_settings_section',
		'Other Settings',
		'gh_other_settings_callback',
		'gh_other_custom_settings'
	);

	register_setting(
		'gh_other_custom_settings',
		'gh_other_custom_settings'
	);

}
add_action( 'admin_init', 'gh_initialize_other_settings' );

function gh_misc_settings_callback() {

}

function gh_other_settings_callback() {

	echo '<p>This section is not yet active</p>';

}

// MISCELLANEOUS SETTINGS FIELDS


function gh_reports_narrative_callback($args) {

	$options = get_option( 'gh_custom_general_settings' );

	$reports_narrative = '';
	if( isset( $options['gh_reports_narrative'] ) ) {
		$reports_narrative = $options['gh_reports_narrative'];
	}

	$html = '<label for="gh_reports_narrative">&nbsp;'  . $args[0] . '</label><br />';
	$html .= '<textarea id="gh_reports_narrative" name="gh_custom_general_settings[gh_reports_narrative]" class="regular-text ltr" rows="6" cols="60">' . $reports_narrative . '</textarea>';

	echo $html;

}

function gh_sanitize_input( $input ) {

	$output = array();

	foreach( $input as $key => $val ) {

		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		}

	}

	return apply_filters( 'gh_sanitize_input', $output, $input );
}

function gh_validate_image_upload($input) {

	$keys = array_keys($_FILES);
	$i = 0; foreach ( $_FILES as $image ) {

		if ($image['size']) {

			if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {
				$override = array('test_form' => false);
				//
				$file = wp_handle_upload( $image, $override );
				$input[$keys[$i]] = $file['url'];
			} else {       // Not an image.

				$options = get_option('gh_custom_general_settings');
				$input[$keys[$i]] = $options['logo'];
				wp_die('No image was uploaded.');
			}
		}

		else {
			$options = get_option('plugin_options');
			$input[$keys[$i]] = $options[$keys[$i]];
		}   $i++;
	}
	return $input;
}