<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

<div class="section group main_content">

    <div class="col col1_3 sidebar blockheaders purple">

        <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( 'search-sidebar' ); ?>

    </div>

    <div class="col col2_3 archive_content padding10">

        <h1><?php _e( 'Oops, you seem to be lost', 'genderhub' ); ?></h1>

        <p><?php _e( 'It looks like nothing was found at this location. Please use the navigation above or maybe try a search to find your way.', 'genderhub' ); ?></p>

        <p><?php _e( 'Alternatively, please <a href="'. site_url().'/connect-and-discuss/contact-us/">contact us here with any questions</a>.', 'genderhub' ); ?></p>

    </div>

</div><!--/section group-->

<?php get_footer(); ?>