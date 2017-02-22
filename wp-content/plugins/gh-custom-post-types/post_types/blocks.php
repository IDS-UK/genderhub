<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 13:04
 */

function fetch_args_blocks() {

	$labels = array(
		'name'                  => _x( 'Blocks', 'post type general name', 'genderhub' ),
		'singular_name'         => _x( 'Block Item', 'post type singular name', 'genderhub' ),
		'add_new'               => _x( 'Add New', 'Block item', 'genderhub' ),
		'add_new_item'          => __( 'Add New Block Item', 'genderhub' ),
		'edit_item'             => __( 'Edit Block Item', 'genderhub' ),
		'new_item'              => __( 'New Block Item', 'genderhub' ),
		'view_item'             => __( 'View Block Item', 'genderhub' ),
		'search_items'          => __( 'Search Block', 'genderhub' ),
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
		'menu_icon'             => '/wp-content/uploads/2015/07/block-icon.png',
		'rewrite'               => true,
		'capability_type'       => 'post',
		'hierarchical'          => false,
		'menu_position'         => null,
		'supports'              => array('title','editor','thumbnail', 'page-attributes')
	);

	return $args;
}