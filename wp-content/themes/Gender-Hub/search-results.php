<?php
/**
 * The template for displaying Search Results pages
 *
 */

get_header(); ?>





<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">
<?php
if (have_posts()) {
    if($_GET['sfid']=='1903'){

            include(get_query_template('search-results-resources'));

    } else {
        include(get_query_template('search-results-regular'));
    }
} else {
    get_template_part( 'content', 'none' );
}
?>


</div><!--/col span_3_of_4 padding10-->




<div class="col span_1_of_4 sidebar padding10">

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>