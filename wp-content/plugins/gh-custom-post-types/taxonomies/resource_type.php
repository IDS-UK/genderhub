<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 11:13
 */

function fetch_args_resource_type() {

	$labels = array(
		'name'                      => _x( 'Resource Types', 'Taxonomy General Name', 'genderhub' ),
		'singular_name'             => _x( 'Resource Type', 'Taxonomy Singular Name', 'genderhub' ),
		'menu_name'                 => __( 'Resource Type', 'genderhub' ),
		'all_items'                 => __( 'All Resource Types', 'genderhub' ),
		'parent_item'               => __( 'Parent Resource Type', 'genderhub' ),
		'parent_item_colon'         => __( 'Parent Resource Type:', 'genderhub' ),
		'new_item_name'             => __( 'New Resource Type', 'genderhub' ),
		'add_new_item'              => __( 'Add New Resource Type', 'genderhub' ),
		'edit_item'                 => __( 'Edit Resource Type', 'genderhub' ),
		'update_item'               => __( 'Update Resource Type', 'genderhub' ),
		'separate_items_with_commas'=> __( 'Separate Resource Types with commas', 'genderhub' ),
		'search_items'              => __( 'Search Resource Types', 'genderhub' ),
		'add_or_remove_items'       => __( 'Add or remove Resource Types', 'genderhub' ),
		'choose_from_most_used'     => __( 'Choose from the most used Resource Types', 'genderhub' ),
		'not_found'                 => __( 'Not Found', 'genderhub' ),
	);

	$t['args'] = array(
		'labels'                    => $labels,
		'hierarchical'              => false,
		'public'                    => true,
		'show_ui'                   => true,
		'show_admin_column'         => true,
		'show_in_nav_menus'         => true,
		'show_tagcloud'             => true,
	);

	$t['post_types'] = array( 'ids_documents' );

	return $t;

}
