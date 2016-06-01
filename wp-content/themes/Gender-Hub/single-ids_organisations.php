<?php
/**
 * The Template for displaying all single posts.
*/

get_header(); ?>

<div class="section group main_content">
<div class="col span_3_of_4 archive_content padding10">


		<?php while ( have_posts() ) : the_post(); ?>

      <!-- We include 'content-ids_organisations' here, instead of 'content'. -->
      <?php get_template_part( 'content-ids_organisations', get_post_format() ); ?>

      <!-- If we want to, we can include the Edit link here, instead of in the content-ids_organisations template.
           It's not really necessary, as there is an Edit link in the admin bar -->
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="ids-edit-link">', '</span>' ); ?>

				<!--<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>
		

</div><!--/col span_3_of_4 padding10-->




<div class="col span_1_of_4 sidebar padding10">


<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>