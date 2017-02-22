<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 21/02/2017
 * Time: 11:13
 */

function fetch_args_topics() {

	$labels = array(
		'name'                      => _x( 'Topics', 'Taxonomy General Name', 'genderhub' ),
		'singular_name'             => _x( 'Topic', 'Taxonomy Singular Name', 'genderhub' ),
		'menu_name'                 => __( 'Topics', 'genderhub' ),
		'all_items'                 => __( 'All Topics', 'genderhub' ),
		'parent_item'               => __( 'Parent Topic', 'genderhub' ),
		'parent_item_colon'         => __( 'Parent Topic:', 'genderhub' ),
		'new_item_name'             => __( 'New Topic', 'genderhub' ),
		'add_new_item'              => __( 'Add New Topic', 'genderhub' ),
		'edit_item'                 => __( 'Edit Topic', 'genderhub' ),
		'update_item'               => __( 'Update Topic', 'genderhub' ),
		'separate_items_with_commas'=> __( 'Separate Topics with commas', 'genderhub' ),
		'search_items'              => __( 'Search Topics', 'genderhub' ),
		'add_or_remove_items'       => __( 'Add or remove Topic', 'genderhub' ),
		'choose_from_most_used'     => __( 'Choose from the most used Topics', 'genderhub' ),
		'not_found'                 => __( 'Not Found', 'genderhub' ),
	);

	$t['args'] = array(
		'labels'                    => $labels,
		'hierarchical'              => true,
		'public'                    => true,
		'show_ui'                   => true,
		'show_admin_column'         => true,
		'show_in_nav_menus'         => true,
		'show_tagcloud'             => true,
	);

	$t['post_types'] = array( 'ids_documents','contact_point','events','blogs_opinions','other_training','programme_alerts','practical_tools','news_stories','collections' );

	return $t;

}
