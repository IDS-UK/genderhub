<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 00:06
 */

function fetch_args_practical_tools() {

	$labels = array(
		'name'                  => _x( 'Practical Tools', 'Post Type General Name', 'genderhub' ),
		'singular_name'         => _x( 'Practical Tool', 'Post Type Singular Name', 'genderhub' ),
		'menu_name'             => __( 'Practical Tools', 'genderhub' ),
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
		'label'                 => __( 'Practical Tools', 'genderhub' ),
		'description'           => __( 'Practical Tools Description', 'genderhub' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
		'hierarchical'          => true,
		'rewrite'               => array( 'slug'  => 'build-capacity/practical-tools' ),
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'menu_position'         => 10,
		'menu_icon'             => '/wp-content/uploads/2015/06/presentation-icon.png',
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
    
    return $args;
}