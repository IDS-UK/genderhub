<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 00:06
 */

function fetch_args_news_stories() {

	$labels = array(
		'name'                  => _x( 'News & Stories', 'Post Type General Name', 'genderhub' ),
		'singular_name'         => _x( 'News & Story', 'Post Type Singular Name', 'genderhub' ),
		'menu_name'             => __( 'News & Stories', 'genderhub' ),
		'parent_item_colon'     => __( 'Parent Item:', 'genderhub' ),
		'all_items'             => __( 'All Items', 'genderhub' ),
		'view_item'             => __( 'View Item', 'genderhub' ),
		'add_new_item'          => __( 'Add New Item', 'genderhub' ),
		'add_new'               => __( 'Add New', 'genderhub' ),
		'edit_item'             => __( 'Edit Item', 'genderhub' ),
		'update_item'           => __( 'Update Item', 'genderhub' ),
		'search_items'          => __( 'Search Item', 'genderhub' ),
		'not_found'             => __( 'Not found', 'genderhub' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'genderhub' ),
	);
	$args = array(
		'label'                 => __( 'News & Stories', 'genderhub' ),
		'description'           => __( 'News & Stories Description', 'genderhub' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes', 'topics' ),
		'hierarchical'          => true,
		'rewrite'               => array( 'slug'  => 'be-inspired/news-stories' ),
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'menu_position'         => 10,
		'menu_icon'             => '/wp-content/uploads/2015/05/bell-icon.png',
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
    
    return $args;
}