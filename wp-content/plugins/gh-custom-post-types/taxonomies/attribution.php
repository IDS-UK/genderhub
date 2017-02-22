<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 11:13
 */

function fetch_args_attribution() {

	$labels = array(
		'name'                      => _x( 'Attribution', 'Taxonomy General Name', 'genderhub' ),
		'singular_name'             => _x( 'Attribution', 'Taxonomy Singular Name', 'genderhub' ),
		'menu_name'                 => __( 'Attribution', 'genderhub' ),
		'all_items'                 => __( 'All sources', 'genderhub' ),
		'parent_item'               => __( 'Parent Attribution', 'genderhub' ),
		'parent_item_colon'         => __( 'Parent Attribution:', 'genderhub' ),
		'new_item_name'             => __( 'New attribution information', 'genderhub' ),
		'add_new_item'              => __( 'Add New Attribution information', 'genderhub' ),
		'edit_item'                 => __( 'Edit Attribution', 'genderhub' ),
		'update_item'               => __( 'Update Attribution', 'genderhub' ),
		'separate_items_with_commas'=> __( 'Separate Attribution with commas', 'genderhub' ),
		'search_items'              => __( 'Search Attribution', 'genderhub' ),
		'add_or_remove_items'       => __( 'Add or remove Attribution', 'genderhub' ),
		'choose_from_most_used'     => __( 'Choose from the most used Attribution information', 'genderhub' ),
		'not_found'                 => __( 'GenderHub', 'genderhub' ),
	);

	$t['args'] = array(
		'labels'                    => $labels,
		'hierarchical'              => true,
		'public'                    => true,
		'show_ui'                   => true,
		'show_admin_column'         => true,
		'show_in_nav_menus'         => false,
		'show_tagcloud'             => false,
	);

	$t['post_types'] = array( 'ids_documents', 'practical_tools' );

	return $t;

}
