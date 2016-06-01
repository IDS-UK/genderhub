<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>





<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">

<h1><?php _e( 'Oops, you seem to be lost', 'twentythirteen' ); ?></h1>


<p><?php _e( 'It looks like nothing was found at this location. Please use the navigation above or maybe try a search to find your way.', 'twentythirteen' ); ?></p>

<p><?php _e( 'Alternatively, please <a href="<?php echo site_url(); ?>/connect-and-discuss/contact-us/">contact us here with any questions</a>.', 'twentythirteen' ); ?></p>

					<?php get_search_form(); ?>




</div><!--/col span_3_of_4-->




<div class="col span_1_of_4 sidebar padding10">

<?php get_sidebar(); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>