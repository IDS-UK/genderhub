<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 01/06/2016
 * Time: 11:26
 */

function fetch_args_interviews() {
    
    $labels = array(
        'name'              => _x('Interviews', 'post type general name'),
        'singular_name'     => _x('Interview', 'post type singular name'),
        'add_new'           => _x('Add New', 'Interview'),
        'add_new_item'      => __('Add New Interview'),
        'edit_item'         => __('Edit Interview'),
        'new_item'          => __('New Interview'),
        'view_item'         => __('View Interview'),
        'search_items'      => __('Search Interviews'),
        'not_found'         =>  __('Nothing found'),
        'not_found_in_trash'=> __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true,
        'query_var'         => true,
        'menu_icon'         => 'dashicons-microphone',
        'rewrite'           => array('slug'  => 'be-inspired/interviews', 'with_front' => false ),
        'capability_type'   => 'post',
        'hierarchical'      => true,
        'menu_position'     => null,
        'supports'          => array('title', 'editor', 'thumbnail', 'comments', 'excerpt'),
        'taxonomies'        => array('topics')
    );
    
    return $args;
}

function add_interviews_meta_boxes() {

    add_meta_box(
        'interview-additional-mb',
        'Additional Information',
        'additional_fields',
        'interviews',
        'normal',
        'high'
    );

    add_meta_box(
        'interview-interviewee-mb',
        'An interview with...',
        'interviewee_fields',
        'interviews',
        'normal',
        'high'
    );

    add_meta_box(
        'interview-interviewer-mb',
        'The Interviewer',
        'interviewer_fields',
        'interviews',
        'side',
        'high'
    );

    add_meta_box(
        'interview-date-mb',
        'Interview Date',
        'interview_date',
        'interviews',
        'side',
        'high'
    );

}
add_action( 'add_meta_boxes', 'add_interviews_meta_boxes' );

function additional_fields( $post ) {

    $interview_teaser = get_post_meta( $post->ID, '_interview_additional_teaser', true );

    wp_nonce_field( 'my_meta_box_nonce', 'slikkr_meta_box_nonce' ); ?>

    <p>
        <label for="_interview_additional_teaser">Teaser Text</label><br />
        <textarea id="_interview_additional_teaser" name="_interview_additional_teaser" class="widefat ltr"><?php echo $interview_teaser; ?></textarea>
    <p>

    <?php
}

function interviewee_fields( $post ) {


    $interview_interviewee_name = get_post_meta( $post->ID, '_interview_interviewee_name', true );
    $interview_interviewee_org = get_post_meta( $post->ID, '_interview_interviewee_org', true );
    $interview_interviewee_org_url = get_post_meta( $post->ID, '_interview_interviewee_org_url', true );
    $interview_interviewee_role = get_post_meta( $post->ID, '_interview_interviewee_role', true );
    $interview_interviewee_email = get_post_meta( $post->ID, '_interview_interviewee_email', true );
    $interview_interviewee_twitter = get_post_meta( $post->ID, '_interview_interviewee_twitter', true );
    $interview_interviewee_bio = get_post_meta( $post->ID, '_interview_interviewee_bio', true );

    wp_nonce_field( 'my_meta_box_nonce', 'slikkr_meta_box_nonce' ); ?>

    <div style="padding: 10px 10px 20px; border:1px solid grey; background-color:ghostwhite; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;margin-bottom: 15px;">

        <p>
            <label for="_interview_interviewee_name">Interviewee Name</label><br />
            <input type="text" id="_interview_interviewee_name" name="_interview_interviewee_name" value="<?php echo $interview_interviewee_name; ?>" class="regular-text" />
        </p>

        <p>
            <label for="_interview_interviewee_org">Interviewee Organisation</label><br />
            <input type="text" id="_interview_interviewee_org" name="_interview_interviewee_org" value="<?php echo $interview_interviewee_org; ?>" class="regular-text" /><br />
        </p>

        <p>
            <label for="_interview_interviewee_org_url">Interviewee Organisation URL</label><br />
            <input type="text" id="_interview_interviewee_org_url" name="_interview_interviewee_org_url" value="<?php echo $interview_interviewee_org_url; ?>" class="regular-text" /><br />
        </p>

        <p>
            <label for="_interview_interviewee_role">Interviewee Role</label><br />
            <input type="text" id="_interview_interviewee_role" name="_interview_interviewee_role" value="<?php echo $interview_interviewee_role; ?>" class="regular-text" /><br />
        </p>

        <p>
            <label for="_interview_interviewee_email">Interviewee Email</label><br />
            <input type="text" id="_interview_interviewee_email" name="_interview_interviewee_email" value="<?php echo $interview_interviewee_email; ?>" class="regular-text" /><br />
        </p>

        <p>
            <label for="_interview_interviewee_twitter">Interviewee Twitter</label><br />
            <input type="text" id="_interview_interviewee_twitter" name="_interview_interviewee_twitter" value="<?php echo $interview_interviewee_twitter? '@'.$interview_interviewee_twitter :''; ?>" class="regular-text" /><br />
        </p>

    </div>

    <div style="padding: 10px 10px 20px; border:1px solid grey; background-color:ghostwhite; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;margin-bottom: 15px;">

        <p>
            <label for="_interview_interviewee_bio">Interviewee Bio</label><br />
            <textarea id="_interview_interviewee_bio" cols="60" rows="13" name="_interview_interviewee_bio" class="regular-text"><?php echo $interview_interviewee_bio; ?></textarea><br />
        </p>
    </div>

    <?php
}

function interviewer_fields( $post ) {

    $interview_contact_point = get_post_meta( $post->ID, '_interview_contact_point', true );
    $contact_points = gh_get_post_list('contact_point'); // fetches id, title

    wp_nonce_field( 'my_meta_box_nonce', 'slikkr_meta_box_nonce' ); ?>

    <p>
        <label for="_interview_contact_point">Interview by...</label><br />
        <select name="_interview_contact_point" id="_interview_contact_point" class="ltr">
            <option value = ""> - select - </option>
            <?php
            foreach ($contact_points as $contact_point) {

                echo '<option value="'.$contact_point['id'].'"'.selected($interview_contact_point, $contact_point['id']).'>'.ucwords($contact_point['name']).'</option>';
            }

            ?>
        </select>
    </p>
    <?php
}

function interview_date( $post ) {

    $interview_date = get_post_meta($post->ID, '_interview_date', true);

    wp_nonce_field('my_meta_box_nonce', 'slikkr_meta_box_nonce'); ?>

        <p>
            <label for="_interview_date"></label>
            <input type="text" id="_interview_date" name="_interview_date" value="<?php echo $interview_date; ?>" class="pickadate" /><br/>
        </p>

    <?php
}

function save_interviews_meta_boxes( $post_id ) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['slikkr_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['slikkr_meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
    // now we can actually save the data

    if( isset( $_POST['_interview_interviewee_name'] ) )
        update_post_meta( $post_id, '_interview_interviewee_name', $_POST['_interview_interviewee_name'] );

    if( isset( $_POST['_interview_interviewee_org'] ) )
        update_post_meta( $post_id, '_interview_interviewee_org', $_POST['_interview_interviewee_org'] );

    if(isset($_POST['_interview_interviewee_org_url']))
        update_post_meta($post_id, '_interview_interviewee_org_url', $_POST['_interview_interviewee_org_url'] );

    if(isset($_POST['_interview_interviewee_role']))
        update_post_meta($post_id, '_interview_interviewee_role', $_POST['_interview_interviewee_role'] );

    if( isset( $_POST['_interview_interviewee_email'] ) )
        update_post_meta( $post_id, '_interview_interviewee_email', $_POST['_interview_interviewee_email'] );

    if( isset( $_POST['_interview_interviewee_twitter'] ) )
        update_post_meta( $post_id, '_interview_interviewee_twitter', str_replace('@', '', $_POST['_interview_interviewee_twitter']) );

    if(isset($_POST['_interview_interviewee_bio']))
        update_post_meta($post_id, '_interview_interviewee_bio', $_POST['_interview_interviewee_bio'] );

    if(isset($_POST['_interview_contact_point']))
        update_post_meta($post_id, '_interview_contact_point', $_POST['_interview_contact_point'] );

    if(isset($_POST['_interview_date']))
        update_post_meta($post_id, '_interview_date', $_POST['_interview_date'] );

    if(isset($_POST['_interview_additional_teaser']))
        update_post_meta($post_id, '_interview_additional_teaser', $_POST['_interview_additional_teaser'] );


    if( isset( $_POST['_is_sticky'] ) ) {
        update_post_meta($post_id, '_is_sticky', true);
    } else {
        update_post_meta($post_id, '_is_sticky', false); // necessary for checkbox clearing
    }
}
add_action( 'save_post', 'save_interviews_meta_boxes' );

function gh_get_post_list($type) {
    $args = array(
        'posts_per_page'   => -1,
        'offset'           => 0,
        'category'         => '',
        'orderby'          => 'menu_order',
        'order'            => 'ASC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => $type,
        'post_mime_type'   => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'suppress_filters' => true );

    $posts = get_posts( $args );
    $values = array();
    foreach ($posts as $post) : setup_postdata($post); {

        $values[] = array(
            'id'    => $post->ID,
            'name'  => $post->post_title
        );
    }

    endforeach;

    return $values;
}