<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 01/06/2016
 * Time: 11:26
 */

function fetch_args_programme_alerts() {

	$labels = array(
		'name'                  => _x( 'Programme Alerts', 'Post Type General Name', 'genderhub' ),
		'singular_name'         => _x( 'Programme Alert', 'Post Type Singular Name', 'genderhub' ),
		'menu_name'             => __( 'Programme Alerts', 'genderhub' ),
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
		'label'                 => __( 'programme-alerts', 'genderhub' ),
		'description'           => __( 'Programme Alert Description', 'genderhub' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
		'hierarchical'          => true,
		'rewrite'               => array( 'slug'  => 'be-inspired/programme-alerts' ),
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'menu_position'         => 6,
		'menu_icon'             => '/wp-content/uploads/2015/06/bell-icon.png',
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
    
    return $args;
}

add_action( 'add_meta_boxes', 'add_programme_alerts_meta_boxes' );
add_action( 'save_post', 'save_programme_alert_meta_boxes' );

function add_programme_alerts_meta_boxes() {

	add_meta_box(
		'programme-alert-slide-details-mb',
		'Home Page Slide Details',
		'programme_alert_slide_details',
		'programme_alerts',
		'side',
		'high'
	);

}

function programme_alert_slide_details( $post ) {

	$pa_sinc    = get_post_meta( $post->ID, '_pa_slide_include', true );
	$pa_sbg     = get_post_meta( $post->ID, '_pa_slide_bg', true );
	$pa_slurl   = get_post_meta( $post->ID, '_pa_slide_link_url', true );
	$pa_sltext  = get_post_meta( $post->ID, '_pa_slide_link_text', true );

	$colors = array(
		array('name' => 'Green', 'value' => 'greenbg'),
		array('name' => 'Pink', 'value' => 'pinkbg'),
		array('name' => 'Purple', 'value' => 'purplebg'),
		array('name' => 'Orange', 'value' => 'orangebg'),
	);

	wp_nonce_field( 'my_meta_box_nonce', 'slikkr_meta_box_nonce' ); ?>

    <p>
        <label for="_pa_slide_include">Include in slider?</label>&nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="_pa_slide_include" id="_pa_slide_include" value="1" <?php checked(1, $pa_sinc); ?>/>
    </p>
	<p>
		<label for="_pa_slide_bg">Background Color</label><br />
		<select name="_pa_slide_bg" id="_pa_slide_bg" class="ltr">
			<option value = ""> - select - </option>
			<?php
			foreach ($colors as $color) {

				echo '<option value="'.$color['value'].'"'.selected($pa_sbg, $color['value']).'>'.ucwords($color['name']).'</option>';
			}

			?>
		</select>
	</p>
	<p>
		<label for="_pa_slide_link_url">Link URL :</label><br />
		<input type="text" id="_pa_slide_link_url" name="_pa_slide_link_url" class="widefat" value="<?php _e($pa_slurl); ?>" />
	</p>
	<p>
		<label for="_pa_slide_link_text">Link Text :</label><br />
		<input type="text" id="_pa_slide_link_text" name="_pa_slide_link_text" class="widefat" value="<?php _e($pa_sltext); ?>" />
	</p>
	<?php
}

function save_programme_alert_meta_boxes( $post_id ) {

	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if( !isset( $_POST['slikkr_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['slikkr_meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	if( !current_user_can( 'edit_post', $post_id ) ) return;

	if( isset( $_POST['_pa_slide_include'] ) ) {
		update_post_meta($post_id, '_pa_slide_include', true);
	} else {
		update_post_meta($post_id, '_pa_slide_include', false);
	}

	if( isset( $_POST['_pa_slide_bg'] ) )
		update_post_meta( $post_id, '_pa_slide_bg', $_POST['_pa_slide_bg'] );

	if( isset( $_POST['_pa_slide_link_url'] ) )
		update_post_meta( $post_id, '_pa_slide_link_url', $_POST['_pa_slide_link_url'] );

	if( isset( $_POST['_pa_slide_link_text'] ) )
		update_post_meta( $post_id, '_pa_slide_link_text', $_POST['_pa_slide_link_text'] );

}