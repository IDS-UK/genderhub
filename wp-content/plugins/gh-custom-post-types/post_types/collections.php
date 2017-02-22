<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 01/06/2016
 * Time: 11:26
 */

function fetch_args_collections() {
    
    $labels = array(
        'name'                  => _x('Collections', 'post type general name', 'genderhub'),
        'singular_name'         => _x('Collection', 'post type singular name', 'genderhub'),
        'add_new'               => _x('Add New', 'genderhub'),
        'add_new_item'          => __('Add New Collection', 'genderhub'),
        'edit_item'             => __('Edit Collection', 'genderhub'),
        'new_item'              => __('New Collection', 'genderhub'),
        'view_item'             => __('View Collection', 'genderhub'),
        'search_items'          => __('Search Collections', 'genderhub'),
        'not_found'             => __('Nothing found', 'genderhub'),
        'not_found_in_trash'    => __('Nothing found in Trash', 'genderhub'),
        'parent_item_colon'     => ''
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'query_var'             => true,
        'menu_icon'             => '/wp-content/themes/Gender-Hub/img/collection_icon.png',
        'rewrite'               => array( 'slug' => 'collections', 'with_front' => false ),
        'capability_type'       => 'post',
        'hierarchical'          => true,
        'menu_position'         => null,
        'supports'              => array('title', 'editor', 'thumbnail', 'page-attributes', 'comments', 'excerpt'),
        'taxonomies'            => array('topics')
    );
    
    return $args;
}