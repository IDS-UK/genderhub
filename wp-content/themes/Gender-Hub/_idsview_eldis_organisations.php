<?php
/**
 * Template Name: IDS View Organisations Template
*/
get_header(); ?>

<div class="section group main_content">
<div class="col span_3_of_4 padding10">
<?php while ( have_posts() ) : the_post(); ?>
      <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'twentytwelve' ) ); ?>
      </div>
    <?php endwhile; ?>

    <!-- Call the API and populate the loop with IDS organisations -->
    <?php idsview_assets('eldis', 'organisations'); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content-ids_organisations', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php twentytwelve_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?></div><!--/col span_3_of_4-->
<div class="col span_1_of_4 sidebar padding10">
<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 
</div><!--/col span_1_of_4-->
</div><!--/section group-->
<?php get_footer(); ?>