<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 11:13
 */

function fetch_args_content_type() {

	$labels = array(
		'name'                      => _x( 'Content Types', 'Taxonomy General Name', 'genderhub' ),
		'singular_name'             => _x( 'Content Type', 'Taxonomy Singular Name', 'genderhub' ),
		'menu_name'                 => __( 'Content Type', 'genderhub' ),
		'all_items'                 => __( 'All Content Types', 'genderhub' ),
		'parent_item'               => __( 'Parent Content Type', 'genderhub' ),
		'parent_item_colon'         => __( 'Parent Content Type:', 'genderhub' ),
		'new_item_name'             => __( 'New Content Type', 'genderhub' ),
		'add_new_item'              => __( 'Add New Content Type', 'genderhub' ),
		'edit_item'                 => __( 'Edit Content Type', 'genderhub' ),
		'update_item'               => __( 'Update Content Type', 'genderhub' ),
		'separate_items_with_commas'=> __( 'Separate Content Types with commas', 'genderhub' ),
		'search_items'              => __( 'Search Content Types', 'genderhub' ),
		'add_or_remove_items'       => __( 'Add or remove Content Types', 'genderhub' ),
		'choose_from_most_used'     => __( 'Choose from the most used Content Types', 'genderhub' ),
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

	$t['post_types'] = array( 'events', 'other_training', 'news_stories', 'blogs_opinions', 'contact_point','practical_tools','ids_documents' );

	return $t;

}
