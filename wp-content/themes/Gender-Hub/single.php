<?php get_header(); ?>





<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">


		<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_type() ); ?>
									
		<?php edit_post_link(); ?>	
				<?php comments_template(); ?>
									
	




		<!--<nav class="nav-single">
							<h4 class="assistive-text center"><?php _e( 'Navigate below to view more posts...', 'twentythirteen' ); ?></h4>
							<span class="nav-previous"><?php previous_post_smart( '%link', '<span class="meta-nav">' . _x( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowL.png" /><br />', 'Previous post link', 'twentythirteen' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_smart( '%link', '<span class="meta-nav">' . _x( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />', 'Next post link', 'twentythirteen' ) . '</span> %title' ); ?></span>						</nav><!-- .nav-single -->
		
			

			<?php endwhile; ?>		 
		 
		

</div><!--/col span_3_of_4 padding10-->




<div class="col span_1_of_4 sidebar padding10">

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>