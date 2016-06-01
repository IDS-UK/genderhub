<?php

/*
 * Plugin Name: WP RSS Aggregator - Full Text RSS Feeds
 * Plugin URI: http://www.wprssaggregator.com
 * Description: Adds a premium, unlimited full text RSS service, provided by WP RSS Aggregator, to Feed to Post.
 * Version: 1.1
 * Author: Jean Galea
 * Author URI: http://www.wprssaggregator.com
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */


// Plugin Version
if ( !defined('WPRSS_FTR_VERSION') ) {
	define( 'WPRSS_FTR_VERSION', '1.1' );
}

// EDD Licensing Item Name
if ( !defined('WPRSS_FTR_SL_ITEM_NAME') ) {
	define( 'WPRSS_FTR_SL_ITEM_NAME', 'Full Text RSS Feeds' );
}
// EDD Licensing Server
if ( !defined( 'WPRSS_FTR_SL_STORE_URL' ) ) {
	define( 'WPRSS_FTR_SL_STORE_URL', 'http://www.wprssaggregator.com' ); 
}

// WordPress Minimum Required Version
if ( !defined('WPRSS_FTR_WP_MIN_VERSION') ) {
	define( 'WPRSS_FTR_WP_MIN_VERSION', '3.7' );
}
// WP RSS Aggregator Core Minimum Required Version
if ( !defined('WPRSS_FTR_CORE_MIN_VERSION') ) {
	define( 'WPRSS_FTR_CORE_MIN_VERSION', '4.3' );
}
// Feed to Post Minimum Required Version
if ( !defined('WPRSS_FTR_FTP_MIN_VERSION') ) {
	define( 'WPRSS_FTR_FTP_MIN_VERSION', '2.9.4' );
}

// Plugin File
if ( !defined('WPRSS_FTR_FILE') ) {
	define( 'WPRSS_FTR_FILE', __FILE__ );
}
// Set constant path to the plugin directory. 
if( !defined( 'WPRSS_FTR_DIR' ) ) {
	define( 'WPRSS_FTR_DIR', plugin_dir_path( __FILE__ ) );
}
// Set constant URI to the plugin URL. 
if( !defined( 'WPRSS_FTR_URI' ) ) {
	define( 'WPRSS_FTR_URI', plugin_dir_url( __FILE__ ) );
}

// Includes Directory
if ( !defined('WPRSS_FTR_INC') ) {
	define( 'WPRSS_FTR_INC', WPRSS_FTR_DIR . trailingslashit('includes') );
}

// Full Text RSS
if ( !defined('WPRSS_FTR_FULL_TEXT_URL') ) {
	define( 'WPRSS_FTR_FULL_TEXT_URL', 'http://fulltext-premium.wprssaggregator.com/makefulltextfeed.php?url={{url}}&license={{license}}&site={{site}}' );
}


// Admin Messages & Notices
require WPRSS_FTR_INC . 'wprss-ftr-messages.php';
// Settings
require WPRSS_FTR_INC . 'wprss-ftr-settings.php';
// Licensing
require WPRSS_FTR_INC . 'licensing.php';


/**
 * WPRSS Full Text RSS Plugin Class.
 * The class is meant to be used as a singleton instance. The singleton is
 * instantiated automatically, and can be retrieved using the ::instance()
 * method.
 * 
 * @since 1.0
 * @package WP RSS Aggregator
 * @subpackage Full Text RSS
 */
class WPRSS_FTR {
	
	
	/**
	 * The singleton instance
	 * 
	 * @type WPRSS_FTR
	 */
	protected static $instance = NULL;
	
	
	/**
	 * The settings singleton instance
	 * 
	 * @type WPRSS_FTR_Settings
	 */
	protected static $settings = NULL;
	
	
	/**
	 * Constructor
	 * 
	 * @since 1.0
	 */
	public function __construct() {
		// Check the singleton instance
		if ( self::$instance !== NULL ) {
			wp_die( 'WPRSS_FTR class is singleton class, and cannot be instantiated more than once!' );
		}
		
		// Initialize other classes
		self::$settings = WPRSS_FTR_Settings::instance();
		
		// Activation action
		register_activation_hook( __FILE__, array( $this, 'on_activate' ) );
		// Plugin dependancy checks
		add_action( 'plugins_loaded', array( $this, 'check_dependancies' ) );
		
		// Full Text RSS URL Changer
		add_filter( 'wprss_ftp_misc_full_text_url', array( $this, 'full_text_url' ), 10, 3 );
	}
	
	
	/**
	 * Returns the singleton instance
	 * 
	 * @since 1.0
	 * @return WPRSS_FTR The singleton instance
	 */
	public static function instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new WPRSS_FTR();
		}
		return self::$instance;
	}
	
	
	/**
	 * Deactivates the plugin.
	 * 
	 * @since 1.0
	 */
	public function deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	
	
	/**
	 * Activation action. Checks WordPress version.
	 * 
	 * @since 1.0
	 */
	public function on_activate() {
		// Check WordPress Minimum Version
		if ( version_compare( get_bloginfo( 'version' ), WPRSS_FTR_WP_MIN_VERSION, '<' ) ) {
			// Show the message
			wprss_ftr_min_wp_msg();
			// Deactivate the plugin
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}
	
	
	/**
	 * On plugins loaded, checks for other plugin dependancies.
	 */
	public function check_dependancies() {
		// If Core is not present, or Core version is less than the required minimum version
		if ( !defined( 'WPRSS_VERSION' ) || version_compare( WPRSS_VERSION, WPRSS_FTR_CORE_MIN_VERSION, '<' ) ) {
			// Show the message
			add_action( 'admin_notices', 'wprss_ftr_min_core_msg' );
			// Deactivate this plugin
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			// stop
			return;
		}
		
		// If Feed to Post is not present, or Feed to Post version is less than the required minimum version
		if ( !defined( 'WPRSS_FTP_VERSION' ) || version_compare( WPRSS_FTP_VERSION, WPRSS_FTR_FTP_MIN_VERSION, '<' ) ) {
			// Show the message
			add_action( 'admin_notices', 'wprss_ftr_min_ftp_msg' );
			// Deactivate this plugin
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			// stop
			return;
		}
	}
	
	
	
	/**
	 * Changes the given URL into the full text URL
	 * 
	 * @since 1.0
	 * @param string $feed_url The URL of the feed to fetch
	 * @param int|string $feed_ID The ID of the feed source
	 * @return string The URL of the full text RSS feed
	 */
	public function full_text_url( $feed_url, $feed_ID, $service ) {
		if ( $service !== 'ftpr' ) return $feed_url;
		
		// Encode the feed URL
		$encoded_url = urlencode( $feed_url );
		// Get this license key
		$license_key = $this->get_license_key();
		// Get this site's URL and encode it
		$site_url = urlencode( get_site_url() );
		
		// Generate the URL to the full text rss feed
		$full_text_url = WPRSS_FTP_Utils::template(
			WPRSS_FTR_FULL_TEXT_URL,
			array(
				'url'		=>	$encoded_url,
				'license'	=>	$license_key,
				'site'		=>	$site_url
			)
		);
		
		// Attempt to fetch the feed
		$feed = wprss_fetch_feed( $full_text_url, $feed_ID );

		// If an error was encountered
		if ( is_wp_error( $feed ) || $feed->error() ) {
			// Request the error message and log it
			$response = wp_remote_get( $full_text_url );
			wprss_log("Full Text RSS Service Error: \"{$response['body']}\"");
			// Return the original parameter url
			return $feed_url;
		}
		
		// If successful, return the full text RSS feed URL
		return $full_text_url;
	}
	
	
	
	
	/**
	 * Returns an array of the default license settings. Used for plugin activation.
	 *
	 * @since 1.0
	 */
	public function get_default_license_settings() {
		// Set up the default license settings
		$settings = apply_filters( 
			'wprss_ftr_get_default_settings_licenses',
			array(
				'ftr_license_key'		=> '',  
				'ftr_license_status'	=> 'invalid'
			)
		);

		// Return the default settings
		return $settings;
	}
	
	
	/**
	 * Returns the saved license code.
	 * 
	 * @since 1.0
	 */
	public function get_license_key() {
		$defaults = $this->get_default_license_settings();
		$keys = get_option( 'wprss_settings_license_keys', array() );
		$ftr_license = ( isset( $keys['ftr_license_key'] ) )? $keys['ftr_license_key'] : $defaults['ftr_license_key'];
		return $ftr_license;
	}
	
	
	/**
	 * Returns the saved license code.
	 * 
	 * @since 1.0
	 */
	public function get_license_status_from_db() {
		$defaults = $this->get_default_license_settings();
		$statuses = get_option( 'wprss_settings_license_statuses', array() );
		$ftr_status = ( isset( $statuses['ftr_license_status'] ) ) ? $statuses['ftr_license_status'] : $defaults['ftr_license_status'];
		return $ftr_status;
	}
	
	
	/**
	 * Returns the license status. Also updates the status in the DB.
	 * 
	 * @since 1.0
	 */
	public function get_license_status() {
		// Get the license key
		$license_key = $this->get_license_key();
		// Get the license status from the DB
		$license_status = $this->get_license_status_from_db();
		// Get all license statuses
		$license_statuses = get_option( 'wprss_settings_license_statuses' );
		if ( !is_array($license_statuses) ) $license_statuses = array();
		
		// data to send in our API request
		$api_params = array(
			'edd_action'	=> 'check_license',
			'license'		=> $license_key,
			'item_name'		=> urlencode( WPRSS_FTR_SL_ITEM_NAME )
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, WPRSS_FTR_SL_STORE_URL ) );

		// If the response is an error, return the value in the DB
		if ( is_wp_error( $response ) ) return $license_status;
		
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Update the DB option
		$license_statuses['ftr_license_status'] = $license_data->license;
		update_option( 'wprss_settings_license_statuses', $license_statuses );
		
		// Return TRUE if it is 'active', FALSE otherwise
		return $license_data->license;
	}
	
}


// Create the singleton instance
$wprss_ftr = WPRSS_FTR::instance();
