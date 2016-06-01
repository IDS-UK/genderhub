<?php
/**
 * The template for displaying Resources Results Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">

<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h1>
				
			</header>

		
		
<?php genderhub_pagination(); ?>
			
								
				<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
        <?php if (is_post_type_archive( 'ids_documents' )) { ?>
          <!-- IDS DOCUMENT -->
          <?php get_template_part( 'content-ids_documents' ); ?>
        <?php } else { ?>
          <!-- REGULAR POST -->
          <?php get_template_part( 'content', get_post_format() ); ?>
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