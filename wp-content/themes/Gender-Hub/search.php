<?php
/**
 * The template for displaying regular search results (in the site header and regular search results page sidebar)
 * Results for the search and filter boxes are displayed by search-results.php
 *
 */

get_header(); ?>

    <div class="section group main_content search">

        <div class="col col1_3 sidebar blockheaders purple">

            <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( 'search-sidebar' ); ?>

        </div><!--/col span_1_of_4-->

        <div class="col col2_3 archive_content padding10">

            <?php if (have_posts()) {

                include(get_query_template('search-results-regular'));

            } else {

                get_template_part( 'content', 'none' );

            } ?>

        </div><!--/col span_3_of_4 padding10-->

    </div><!--/section group-->

<?php get_footer(); ?>