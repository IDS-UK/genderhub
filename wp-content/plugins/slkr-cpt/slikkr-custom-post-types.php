<?php
/*
Plugin Name: Slikkr Custom Post Types for GenderHub.org
Plugin URI: http://www.slikkr.com/
Description: Install theme-independent custom post types
Version: 1.1
Author: Sarah Cox
Author URI: http://www.slikkr.com
Text Domain: slikkr
*/

/* CUSTOM POST TYPES */
function slkr_cpts() {

    function slkr_unregister_post_type( $post_type )
    {
        global $wp_post_types;
        if (isset($wp_post_types[$post_type])) {
            unset($wp_post_types[$post_type]);
            return true;
        }
        return false;
    }

    slkr_unregister_post_type('collection');

    $labels = array(
        'name'              => _x('Collections', 'post type general name'),
        'singular_name'     => _x('Collection', 'post type singular name'),
        'add_new'           => _x('Add New', 'Collection'),
        'add_new_item'      => __('Add New Collection'),
        'edit_item'         => __('Edit Collection'),
        'new_item'          => __('New Collection'),
        'view_item'         => __('View Collection'),
        'search_items'      => __('Search Collections'),
        'not_found'         =>  __('Nothing found'),
        'not_found_in_trash'=> __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true,
        'query_var'         => true,
        'menu_icon'         => '/wp-content/uploads/2015/07/collection-icon.png',
        'rewrite'           => array( 'slug' => 'collections', 'with_front' => false ),
        'capability_type'   => 'post',
        'hierarchical'      => true,
        'menu_position'     => null,
        'supports'          => array('title','editor','thumbnail', 'page-attributes','comments','excerpt'),
        'taxonomies'        => array('topics')
    );

    register_post_type( 'collections' , $args );

}
add_action( 'init', 'slkr_cpts' );

function slkr_flush_rewrite_rules() {
    slkr_cpts();

    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'slkr_flush_rewrite_rules' );