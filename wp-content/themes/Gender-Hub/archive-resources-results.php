<?php
/**
 * The template for displaying Resources Results Archive pages
 *
 * slikkr - no idea what this might be for
 */

get_header(); ?>

<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">

<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h1>
				
			</header>
	
<?php genderhub_pagination(); ?>
	
			<?php while ( have_posts() ) : the_post(); ?>
        <?php if (is_post_type_archive( 'ids_documents' )) { ?>
          <!-- IDS DOCUMENT -->
          <?php get_template_part( 'content-ids_documents' ); ?>
        <?php } else { ?>
          <!-- REGULAR POST -->
          <?php get_template_part( 'content', get_post_type() ); ?>
        <?php } ?>
			<?php endwhile; ?>

	
<br /><br />
<?php genderhub_pagination(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	
</div><!--/col span_3_of_4-->

<div class="col span_1_of_4 sidebar padding10">

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 

</div><!--/col span_1_of_4-->

</div><!--/section group-->


<?php get_footer(); ?>