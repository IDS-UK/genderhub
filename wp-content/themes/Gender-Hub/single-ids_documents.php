<?php
/**
 * The Template for displaying all single posts.
*/

get_header(); ?>

<div class="section group main_content">

    <div class="col col1_3 sidebar blockheaders green">

		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( 'knowledge-sidebar' ); ?>

    </div><!--/col span_1_of_4-->

    <div class="col col2_3 archive_content padding10">

        <h1 class="maintitle"><span><a href="/get-in-the-know/resource-library/">Documents</a></span></h1>

		<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
                <!-- We include 'content-ids_documents' here, instead of 'content'. -->
                <?php get_template_part( 'content-ids_documents', get_post_format() ); ?>
							
                <?php edit_post_link(); ?>
								
                <?php comments_template(); ?>
									
                <!--	<nav class="nav-single">
							<h4 class="assistive-text center"><?php _e( 'Navigate below to view more posts...', 'twentythirteen' ); ?></h4>
							<span class="nav-previous"><?php previous_post_smart( '%link', '<span class="meta-nav">' . _x( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowL.png" /><br />', 'Previous post link', 'twentythirteen' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_smart( '%link', '<span class="meta-nav">' . _x( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />', 'Next post link', 'twentythirteen' ) . '</span> %title' ); ?></span>						</nav><!-- .nav-single -->
                <span class="nav-previous"><?php previous_post_link( '%link', 'Previous post in category', TRUE, ' ', 'post_format' ); ?> </span>
                <span class="nav-previous"><?php next_post_link( '%link', 'Next post in category', TRUE, ' ', 'post_format' ); ?> </span>

			<?php endwhile; ?>		 
		 
    </div><!--/col span_3_of_4 padding10-->

</div><!--/section group-->

<?php get_footer(); ?>