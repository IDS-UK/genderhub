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
if ( !defined( 'ABSPATH' ) ) exit;

class GH_Site_Settings {

    public function __construct() {

	    add_action( 'admin_init', array($this, 'gh_admin_init') );
	    add_action( 'admin_menu', array($this, 'gh_admin_menu') );
	    add_action( 'admin_enqueue_scripts', array($this, 'gh_settings_script') );

    }

	public static function gh_plugin_activated() {

		delete_option('gh_custom_general_settings');
		delete_option('gh_other_custom_settings');
    }

	public static function gh_plugin_deactivated() {
		delete_option('gh_custom_main_settings');
		delete_option('gh_custom_header_settings');
		delete_option('gh_custom_footer_settings');
		delete_option('gh_custom_misc_settings');
    }

	public static function gh_plugin_uninstalled() {}

	function gh_admin_menu() {

		add_menu_page('Custom Site Settings', 'Custom Site Settings', 'administrator', 'gh_site_settings', array($this, 'gh_main_page'), 'dashicons-admin-appearance', 4);
		add_submenu_page('gh_site_settings', 'Main Settings', 'Main Settings', 'administrator', 'gh_site_settings');
		add_submenu_page('gh_site_settings', 'Site Header', 'Header Settings', 'administrator', 'gh_header_settings', array($this, 'gh_header_settings'));
		add_submenu_page('gh_site_settings', 'Site Footer', 'Footer Settings', 'administrator', 'gh_footer_settings', array($this, 'gh_footer_settings'));
		add_submenu_page('gh_site_settings', 'Miscellaneous', 'Miscellaneous Settings', 'administrator', 'gh_misc_settings', array($this, 'gh_misc_settings'));

	}

    function gh_admin_init() {

	    // SECTIONS
	    add_settings_section('main_settings_section',   'Main Settings',            array($this, 'gh_main_settings_callback'),      'gh_custom_main_settings');
	    add_settings_section('social_settings_section', 'Social Media Settings',    array($this, 'gh_social_settings_callback'),    'gh_custom_main_settings');
	    add_settings_section('header_settings_section', 'Header Settings',          array($this, 'gh_header_settings_callback'),    'gh_custom_header_settings');
	    add_settings_section('footer_settings_section', 'Footer Settings',          array($this, 'gh_footer_settings_callback'),    'gh_custom_footer_settings');
	    add_settings_section('misc_settings_section',   'Miscellaneous Settings',   array($this, 'gh_misc_settings_callback'),      'gh_custom_misc_settings');

	    // MAIN SETTINGS FIELDS
	    add_settings_field('site_logo',         'Site Logo',            array($this, 'gh_site_logo'),               'gh_custom_main_settings',      'main_settings_section',    array('The logo for Gender Hub.'));

	    // SOCIAL SETTINGS FIELDS
	    add_settings_field('twitter_handle',    'Twitter Handle',       array($this, 'gh_twitter_handle'),          'gh_custom_main_settings',    'social_settings_section',  array());
	    add_settings_field('facebook_pagename', 'Facebook Page Name',   array($this, 'gh_facebook_pagename'),       'gh_custom_main_settings',    'social_settings_section',  array());

        // SITE HEADER SETTINGS FIELDS
	    add_settings_field('strapline',         'Strapline',            array($this, 'gh_strapline'),               'gh_custom_header_settings',    'header_settings_section',  array());

	    // SITE FOOTER SETTINGS FIELDS
	    add_settings_field('fundedby_logo',     'Funded By',            array($this, 'gh_fundedby_logo'),           'gh_custom_footer_settings',    'footer_settings_section',  array());
	    add_settings_field('deliveredby_logo',  'Delivered By',         array($this, 'gh_deliveredby_logo'),        'gh_custom_footer_settings',    'footer_settings_section',  array());

	    // MISC SETTINGS FIELDS
	    add_settings_field('reports_narrative', 'Reports Narrative',    array($this, 'gh_reports_narrative_text'),  'gh_custom_misc_settings',      'misc_settings_section',    array('Text to be displayed on the Content Reports page.'));

        // REGISTER THE SETTINGS
	    register_setting( 'gh_custom_main_settings',    'gh_custom_main_settings',      array($this, 'gh_sanitize_input'));
	    register_setting( 'gh_custom_header_settings',  'gh_custom_header_settings',    array($this, 'gh_sanitize_input'));
	    register_setting( 'gh_custom_footer_settings',  'gh_custom_footer_settings',    array($this, 'gh_sanitize_input'));
	    register_setting( 'gh_custom_misc_settings',    'gh_custom_misc_settings',      array($this, 'gh_sanitize_input'));

	    $default_main_settings          = array(
		    'gh_site_logo'              => get_stylesheet_directory_uri().'/img/gender-hub-logo.png',
		    'gh_twitter_handle'         => 'gender_hub',
		    'gh_facebook_pagename'      => 'GenderHubNigeria'
        );

	    $default_header_settings        = array(
		    'gh_strapline'              => "SHARING KNOWLEDGE FOR\nGENDER JUSTICE IN NIGERIA",
        );

	    $default_footer_settings        = array(
		    'gh_fundedby_logo'          => get_stylesheet_directory_uri().'/img/ukaid.jpg',
		    'gh_deliveredby_logo'       => get_stylesheet_directory_uri().'/img/voicesforchange.jpg',
        );

	    $default_misc_settings          = array(
		    'gh_reports_narrative_text' => '',
        );


        add_option( 'gh_custom_main_settings', $default_main_settings );
        add_option( 'gh_custom_header_settings', $default_header_settings );
        add_option( 'gh_custom_footer_settings', $default_footer_settings );
        add_option( 'gh_custom_misc_settings', $default_misc_settings );

    }

	function gh_settings_script() {

		wp_register_script( 'gh-settings-script', plugin_dir_url(__FILE__) . '/js/gh-settings-script.js', array('jquery'), '1.0', true);
		wp_enqueue_script( 'gh-settings-script' );
		wp_enqueue_media();
	}

    function gh_settings_page_tabs($active_tab) { ?>

        <div id="icon-themes" class="icon32"></div>
                <h1>Gender Hub Site Settings</h1>
        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=gh_site_settings" class="nav-tab <?php echo $active_tab == 'gh_main_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Main Settings', 'genderhub' ); ?></a>
            <a href="?page=gh_header_settings" class="nav-tab <?php echo $active_tab == 'gh_header_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Header', 'genderhub' ); ?></a>
            <a href="?page=gh_footer_settings" class="nav-tab <?php echo $active_tab == 'gh_footer_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Footer', 'genderhub' ); ?></a>
            <a href="?page=gh_misc_settings" class="nav-tab <?php echo $active_tab == 'gh_misc_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Miscellaneous', 'genderhub' ); ?></a>
        </h2>

        <?php

    }

	function gh_main_page() {

		echo '<div class="wrap">';
		$this->gh_settings_page_tabs('gh_main_settings');

		echo '<form method="post" action="options.php" enctype="multipart/form-data">';

		do_settings_sections( 'gh_custom_main_settings' );

		settings_fields( 'gh_custom_main_settings' );

		submit_button();

		echo '</form>';

		echo '</div>';

	}

	function gh_header_settings() {

		echo '<div class="wrap">';
		$this->gh_settings_page_tabs('gh_header_settings');

		echo '<form method="post" action="options.php" enctype="multipart/form-data">';

		settings_fields( 'gh_custom_header_settings' );
		do_settings_sections( 'gh_custom_header_settings' );

		submit_button();

		echo '</form>';

		echo '</div>';

	}

	function gh_footer_settings() {

		echo '<div class="wrap">';
		$this->gh_settings_page_tabs('gh_footer_settings');

		echo '<form method="post" action="options.php" enctype="multipart/form-data">';

		settings_fields( 'gh_custom_footer_settings' );
		do_settings_sections( 'gh_custom_footer_settings' );

		submit_button();

		echo '</form>';

		echo '</div>';

	}

	function gh_misc_settings() {

		echo '<div class="wrap">';
		$this->gh_settings_page_tabs('gh_misc_settings');

		echo '<form method="post" action="options.php" enctype="multipart/form-data">';

		settings_fields( 'gh_custom_misc_settings' );
		do_settings_sections( 'gh_custom_misc_settings' );

		submit_button();

		echo '</form>';

		echo '</div>';

	}

	function gh_site_logo($args) {

		$options = get_option( 'gh_custom_main_settings' );

		$logo = '';
		if( isset( $options['gh_site_logo'] ) ) {
			$logo = $options['gh_site_logo'];
		}

		$html = '<label for="gh_site_logo">'.$args[0].'</label><br />';
		$html .= '<input type="text" id="gh_site_logo" size="36" name="gh_custom_main_settings[gh_site_logo]" value="'.$logo.'" class="regular-text ltr uploaded-image sitelogoimage" />';
		$html .= '<input id="sitelogoimage" type="button" data-target="gh_site_logo" class="upload-button button" value="Choose Image" />';

		$html .= !empty($logo) ? '<p style="max-width: 300px;"><img src="'.$logo.'" style="width: 100%; height=auto; margin-top: 1em;" /></p>' : '' ;

		echo $html;

    }

	function gh_twitter_handle() {

		$options = get_option( 'gh_custom_main_settings' );

		$twitter_handle = '';
		if( isset( $options['gh_twitter_handle'] ) ) {
			$twitter_handle = $options['gh_twitter_handle'];
		}

		$html = '<input type="text" id="gh_twitter_handle" size="36" name="gh_custom_main_settings[gh_twitter_handle]" value="'.$twitter_handle.'" class="regular-text ltr" />';

		echo $html;

    }

	function gh_facebook_pagename() {

		$options = get_option( 'gh_custom_main_settings' );

		$facebook_pagename = '';
		if( isset( $options['gh_facebook_pagename'] ) ) {
			$facebook_pagename = $options['gh_facebook_pagename'];
		}

		$html = '<input type="text" id="gh_facebook_pagename" size="36" name="gh_custom_main_settings[gh_facebook_pagename]" value="'.$facebook_pagename.'" class="regular-text ltr" />';

		echo $html;

	}

	function gh_strapline($args) {

		$options = get_option( 'gh_custom_header_settings' );

		$gh_strapline = '';
		if( isset( $options['gh_strapline'] ) ) {
			$gh_strapline = $options['gh_strapline'];
		}

		$html = '<label for="gh_strapline">'.$args[0].'</label><br />';
		$html .= '<textarea id="gh_strapline" name="gh_custom_header_settings[gh_strapline]" class="regular-text ltr" rows="6" cols="60">' . $gh_strapline . '</textarea>';

		echo $html;

	}

	function gh_fundedby_logo() {

		$options = get_option( 'gh_custom_footer_settings' );

		$fundedby_logo = '';
		if( isset( $options['gh_fundedby_logo'] ) ) {
			$fundedby_logo = $options['gh_fundedby_logo'];
		}

		$html = '<input type="text" id="gh_fundedby_logo" size="36" name="gh_custom_footer_settings[gh_fundedby_logo]" value="'.$fundedby_logo.'" class="regular-text ltr uploaded-image fundedbylogoimage" />';
		$html .= '<input id="fundedbylogoimage" type="button" data-target="gh_fundedby_logo" class="upload-button button" value="Choose Image" />';

		$html .= !empty($fundedby_logo) ? '<p style="max-width: 50px;"><img src="'.$fundedby_logo.'" style="width: 100%; height=auto; margin-top: 1em;" /></p>' : '' ;

		echo $html;

	}

	function gh_deliveredby_logo() {

		$options = get_option( 'gh_custom_footer_settings' );

		$deliveredby_logo = '';
		if( isset( $options['gh_deliveredby_logo'] ) ) {
			$deliveredby_logo = $options['gh_deliveredby_logo'];
		}

		$html = '<input type="text" id="gh_deliveredby_logo" size="36" name="gh_custom_footer_settings[gh_deliveredby_logo]" value="'.$deliveredby_logo.'" class="regular-text ltr uploaded-image deliveredbylogoimage" />';
		$html .= '<input id="deliveredbylogoimage" type="button" data-target="gh_deliveredby_logo" class="upload-button button" value="Choose Image" />';

		$html .= !empty($deliveredby_logo) ? '<p style="max-width: 50px;"><img src="'.$deliveredby_logo.'" style="width: 100%; height=auto; margin-top: 1em;" /></p>' : '' ;

		echo $html;

	}

	function gh_reports_narrative_text($args) {

		$options = get_option( 'gh_custom_misc_settings' );

		$reports_narrative = '';
		if( isset( $options['gh_reports_narrative'] ) ) {
			$reports_narrative = $options['gh_reports_narrative'];
		}

		$html = '<label for="gh_reports_narrative">&nbsp;'  . $args[0] . '</label><br />';
		$html .= '<textarea id="gh_reports_narrative" name="gh_custom_misc_settings[gh_reports_narrative]" class="regular-text ltr" rows="6" cols="60">' . $reports_narrative . '</textarea>';

		echo $html;

	}

	function gh_main_settings_callback() {}

	function gh_social_settings_callback() {}

	function gh_header_settings_callback() {}

	function gh_footer_settings_callback() {}

	function gh_sanitize_input( $input ) {

		$output = array();

		foreach( $input as $key => $val ) {

			if( isset( $input['image_url'] ) ){
				$new_input['image_url'] = esc_url_raw( self::gh_validate_image_upload( $input['image_url'] ) );
			}

			if( isset ( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[$key] ) );
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

					$options = get_option('gh_custom_main_settings');
					$input[$keys[$i]] = $options['gh_site_logo'];
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

	public static function gh_funded_by() {

		$options = get_option( 'gh_custom_footer_settings' );

		$html = !empty( $options['gh_fundedby_logo'] ) ? '<h5>Funded by</h5><image src="'.$options['gh_fundedby_logo'].'" />' : NULL;

		return $html;

    }

	public static function gh_delivered_by() {

		$options = get_option( 'gh_custom_footer_settings' );

		$html = !empty( $options['gh_deliveredby_logo'] ) ? '<h5>Delivered by</h5><image src="'.$options['gh_deliveredby_logo'].'" />' : NULL;

		return $html;

    }

	public static function gh_social_media_links($html = null) {

		$options = get_option( 'gh_custom_main_settings' );

		$twitter_icon = '<img src="'.get_stylesheet_directory_uri().'/img/icon-twitter.png'.'" />';
		$facebook_icon = '<img src="'.get_stylesheet_directory_uri().'/img/icon-facebook.png'.'" />';

		$twitter_handle = !empty( $options['gh_twitter_handle'] ) ? $options['gh_twitter_handle'] : '';
		$facebook_pagename = !empty( $options['gh_facebook_pagename'] ) ? $options['gh_facebook_pagename'] : '';

		$html .= !empty($facebook_pagename) ? '<a href="https://www.facebook.com/'.$facebook_pagename.'" class="social_link" target="_blank">'.(!empty($facebook_icon) ? $facebook_icon : $facebook_pagename).'</a>' : NULL;
		$html .= !empty($twitter_handle) ? '<a href="https://twitter.com/'.$twitter_handle.'" class="social_link" target="_blank">'.(!empty($twitter_icon) ? $twitter_icon : $twitter_handle).'</a>' : NULL;

		return $html;
    }

}
new GH_Site_Settings;

register_activation_hook( __FILE__, array( 'GH_Site_Settings', 'gh_plugin_activated' ) );

register_deactivation_hook( __FILE__, array( 'GH_Site_Settings', 'gh_plugin_deactivated' ) );

register_uninstall_hook(__FILE__, array( 'GH_Site_Settings', 'gh_plugin_uninstalled') );