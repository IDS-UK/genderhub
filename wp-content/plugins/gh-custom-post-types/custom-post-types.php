<?php
/*
Plugin Name: GH Custom Post Types
Plugin URI: https://www.slikkr.com/
Description: Installs theme-independent custom post types
Version: 1.6
Author: Sarah Cox
Author URI: http://www.slikkr.com
Text Domain: genderhub
*/
namespace Slikkr_Custom_Post_Types;

function genderhub_post_types() {

    $types = array(
        'collections',
        'interviews',
        'contact_point'
    );

    foreach($types as $type) {

        // include the specifications for this post type ...
        include_once ('types/'.$type.'.php' );
        // slkr - ... and register it
        register_post_type( $type , $args=call_user_func('fetch_args_' . $type) );
    }
    
}

add_action( 'init', '\Slikkr_Custom_Post_Types\genderhub_post_types' );