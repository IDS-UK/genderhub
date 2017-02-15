<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 02/06/16
 * Time: 13:19
 * Calls the class on the page edit screen.
 */
function GenderHubPageMetaClass() {
    new GenderHubMetaClass();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'GenderHubPageMetaClass' );
    add_action( 'load-post-new.php', 'GenderHubPageMetaClass' );
}

class GenderHubMetaClass {
	
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_page_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }
	
    public function add_page_meta_boxes( $post_type ) {

        if (in_array($post_type, array('blogs_opinions'))) { // Blogs only

            add_meta_box(
                'gh_opinion_post_mb',
                'Opinion Post',
                array($this, 'opinion_post_mb'),
                $post_type,
                'side',
                'high'
            );
        }
    }

    public function opinion_post_mb( $post ) {

        $is_opinion_post = get_post_meta( $post->ID, '_is_opinion_post', true );

        wp_nonce_field( 'gh_inner_custom_box', 'gh_inner_custom_box_nonce' );
        ?>

        <p>
            <label for="_is_opinion_post">Add to opinion posts?</label>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="_is_opinion_post" id="_is_opinion_post" value="1" <?php checked(1, $is_opinion_post); ?>/>

        </p>
        <?php
    }

    public function save( $post_id ) {

        if ( ! isset( $_POST['gh_inner_custom_box_nonce'] ) )
            return $post_id;

        $nonce = $_POST['gh_inner_custom_box_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'gh_inner_custom_box' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        if ( 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) )
                return $post_id;

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        if( isset( $_POST['_is_opinion_post'] ) ) {
            update_post_meta($post_id, '_is_opinion_post', true);
        } else {
            update_post_meta($post_id, '_is_opinion_post', false);
        }

    }

}