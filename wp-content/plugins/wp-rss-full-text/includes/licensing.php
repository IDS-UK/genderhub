<?php

    // retrieve our license key from the DB
    $licenses = get_option( 'wprss_settings_license_keys' );
    $ftr_license_key = ( isset( $licenses['ftr_license_key'] ) ) ? $licenses['ftr_license_key'] : FALSE; 
     
    // setup the updater
    if ( !class_exists( 'EDD_SL_Plugin_Updater' ) )
        // load our custom updater
        include ( WPRSS_FTR_INC . 'libraries/EDD_licensing/EDD_SL_Plugin_Updater.php' ); 
		// Create the updater
        $edd_updater = new EDD_SL_Plugin_Updater( WPRSS_FTR_SL_STORE_URL, WPRSS_FTR_FILE, array( 
            'version'   => WPRSS_FTR_VERSION,
            'license'   => $ftr_license_key,
            'item_name' => WPRSS_FTR_SL_ITEM_NAME,
            'author'    => 'Jean Galea'
        )
    );


    add_action( 'admin_init', 'wprss_ftr_activate_deactivate_license' );    
    /**
     * Handles the activation/deactivation process 
     * 
     * @since 1.0
     */
    function wprss_ftr_activate_deactivate_license() {

        // listen for our activate button to be clicked
        if( isset( $_POST['wprss_ftr_license_activate'] ) || isset( $_POST['wprss_ftr_license_deactivate'] ) ) {

            // Check nonce to verify that the request came from the Active/Deactivate button
            if( ! check_admin_referer( 'wprss_ftr_license_nonce', 'wprss_ftr_license_nonce' ) ) {
                return;
			}

            // retrieve the license keys and statuses from the database
            $license_keys = get_option( 'wprss_settings_license_keys' );
            $ftr_license = trim( $license_keys['ftr_license_key'] );
            $license_statuses = get_option( 'wprss_settings_license_statuses' );
            if ( !is_array( $license_statuses ) ) $license_statuses = array();
			
			// data to send in our API request
			$api_params = array( 
				'license'   => $ftr_license, 
				'item_name' => urlencode( WPRSS_FTR_SL_ITEM_NAME )
			);
			// Activate action
            if ( isset( $_POST['wprss_ftr_license_activate'] ) ) {
                $api_params['edd_action'] = 'activate_license';
            }
			// Deactivate action
            elseif ( isset( $_POST['wprss_ftr_license_deactivate'] ) ) {
                $api_params['edd_action'] = 'deactivate_license';
            }
			// No action
			else return;

            // Call the custom API.
            $response = wp_remote_get( add_query_arg( $api_params, WPRSS_FTR_SL_STORE_URL ) );

            // make sure the response came back okay
            if ( is_wp_error( $response ) ) {
				return false;
			}
            
            // decode the license data
            $license_data = json_decode( wp_remote_retrieve_body( $response ) );
     
            // $license_data->license will be either "active" or "inactive"
            $license_statuses['ftr_license_status'] = $license_data->license;
            update_option( 'wprss_settings_license_statuses', $license_statuses );
        }
    }    


    /**
     * Initialize settings to default ones if they are not yet set
     *
     * @since 1.0
     */
    function wprss_ftr_licenses_settings_initialize() {
        // Get the settings from the database, if they exist
        $license_keys = get_option( 'wprss_settings_license_keys' );
        $license_statuses = get_option( 'wprss_settings_license_statuses' );
        $default_ftr_license_settings = WPRSS_FTR::instance()->get_default_license_settings();

        if ( FALSE == $license_keys && FALSE == $license_statuses ) { 
            $license_keys['ftr_license_key'] = $default_ftr_license_settings['ftr_license_key'];
            $license_statuses['ftr_license_status'] = $default_ftr_license_settings['ftr_license_status'];
            
            update_option( 'wprss_settings_license_keys', $license_keys );
            update_option( 'wprss_settings_license_statuses', $license_statuses );
        }

        else {
            if ( ! isset( $license_keys['ftr_license_key'] ) ) {
                $license_keys['ftr_license_key'] = $default_ftr_license_settings['ftr_license_key']; 
            }
            if ( ! isset( $license_statuses['ftr_license_status'] ) ) {
                $license_statuses['ftr_license_status'] = $default_ftr_license_settings['ftr_license_status']; 
            }

            // Update the plugin settings.
            update_option( 'wprss_settings_license_keys', $license_keys );  
            update_option( 'wprss_settings_license_statuses', $license_statuses );  
        }     
    }
