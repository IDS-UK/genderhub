<?php
/**
 * The template for displaying Category pages
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
			<header class="archive-header">
				<h1 class="archive-title"><span>
				
				<div class="rss_socials">
<ul>
<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
</ul>
</div>

<?php printf( __( 'Category Archives: %s', 'twentythirteen' ), single_cat_title( '', false ) ); ?></span></h1>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->

<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> post(s) for this category</span>
		
		
<?php genderhub_pagination(); ?>
			
			
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
<br /><br />
			<?php genderhub_pagination(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	
		


</div><!--/col span_3_of_4 padding10-->




<div class="col span_1_of_4 sidebar padding10">

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "knowledge-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>