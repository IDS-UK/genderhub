<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 09/06/2016
 * Time: 14:38
 */

function fetch_args_contact_point() {

    $labels = array(
        'name'                  => _x( 'Contact Points', 'Post Type General Name', 'genderhub' ),
        'singular_name'         => _x( 'Contact Point', 'Post Type Singular Name', 'genderhub' ),
        'menu_name'             => __( 'Contact Point', 'genderhub' ),
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
        'label'                 => __( 'contact_point', 'text_domain' ),
        'description'           => __( 'Contact Point Description', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', ),
        'taxonomies'            => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
        'hierarchical'          => true,
        //'rewrite' => array( 'slug'  => 'connect-and-discuss/join-the-conversation' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_in_admin_bar'     => true,
        'menu_position'         => 5,
        'menu_icon'             => 'http://genderhub.org/wp-content/themes/genderhub/images/contactpoint_icons16.png',
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    
    return $args;
}

add_action( 'add_meta_boxes', 'add_contact_point_meta_boxes' );
add_action( 'save_post', 'save_contact_point_meta_boxes' );

function add_contact_point_meta_boxes() {

	add_meta_box(
		'contact-point-additional-mb',
		'Additional Information',
		'cp_additional_fields',
		'contact_point',
		'normal',
		'high'
	);

}

function cp_additional_fields( $post ) {

	$cp_email = get_post_meta( $post->ID, '_contact_point_email', true );
	$cp_url = get_post_meta( $post->ID, '_contact_point_url', true );
	$cp_twitter = get_post_meta( $post->ID, '_contact_point_twitter', true );
	$cp_facebook = get_post_meta( $post->ID, '_contact_point_facebook', true );

	wp_nonce_field( 'my_meta_box_nonce', 'slikkr_meta_box_nonce' ); ?>

	<p>
		<label for="_contact_point_email">Email address :</label><br />
		<input type="text" id="_contact_point_email" name="_contact_point_email" class="regular-text" value="<?php echo $cp_email; ?>" />
	</p>

	<p>
		<label for="_contact_point_url">Website URL :</label><br />
		<input type="text" id="_contact_point_url" name="_contact_point_url" class="regular-text" value="<?php echo $cp_url; ?>" />
	</p>

	<p>
		<label for="_contact_point_twitter">Twitter :</label><br />
		<input type="text" id="_contact_point_twitter" name="_contact_point_twitter" class="regular-text" value="<?php echo $cp_twitter ? '@'.$cp_twitter : ''; ?>" />
	</p>

	<p>
		<label for="_contact_point_facebook">Facebook :</label><br />
		<input type="text" id="_contact_point_facebook" name="_contact_point_facebook" class="regular-text" value="<?php echo $cp_facebook; ?>" />
	</p>

	<?php
}

function save_contact_point_meta_boxes( $post_id ) {

	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if( !isset( $_POST['slikkr_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['slikkr_meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	if( !current_user_can( 'edit_post', $post_id ) ) return;

	if( isset( $_POST['_contact_point_email'] ) )
		update_post_meta( $post_id, '_contact_point_email', $_POST['_contact_point_email'] );

	if( isset( $_POST['_contact_point_url'] ) )
		update_post_meta( $post_id, '_contact_point_url', $_POST['_contact_point_url'] );

	if(isset($_POST['_contact_point_twitter']))
		update_post_meta($post_id, '_contact_point_twitter', str_replace('@', '', $_POST['_contact_point_twitter']) );

	if(isset($_POST['_contact_point_facebook']))
		update_post_meta($post_id, '_contact_point_facebook', $_POST['_contact_point_facebook'] );

}