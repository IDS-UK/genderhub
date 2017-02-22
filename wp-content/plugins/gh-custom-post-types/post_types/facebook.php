<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 13:04
 */

function fetch_args_facebook() {

	$labels = array(
		'name'                  => _x( 'Facebook', 'post type general name', 'genderhub' ),
		'singular_name'         => _x( 'Facebook Item', 'post type singular name', 'genderhub' ),
		'add_new'               => _x( 'Add New', 'Facebook item', 'genderhub' ),
		'add_new_item'          => __( 'Add New Facebook Item', 'genderhub' ),
		'edit_item'             => __( 'Edit Facebook Item', 'genderhub' ),
		'new_item'              => __( 'New Facebook Item', 'genderhub' ),
		'view_item'             => __( 'View Facebook Item', 'genderhub' ),
		'search_items'          => __( 'Search Facebook', 'genderhub' ),
		'not_found'             => __( 'Nothing found', 'genderhub' ),
		'not_found_in_trash'    => __( 'Nothing found in Trash', 'genderhub' ),
		'parent_item_colon'     => ''
	);

	$args = array(
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'query_var'             => true,
		'menu_icon'             => '/wp-content/uploads/2015/07/facebook-icon.png',
		'capability_type'       => 'post',
		'menu_position'         => null,
		'hierarchical'          => true,
		'rewrite'               => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'supports'              => array('title','editor','thumbnail', 'page-attributes','comments')
	);

	return $args;
}