<?php
/**
 * /* Template Name: Join the conversation Archive page 

The template for displaying Practical Tools Archive pages
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

<h1><span>Connect and discuss</span></h1>

<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">


<?php if (have_posts() ) : ?>
			<header class="archive-header"><span>
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'twentythirteen' ), get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
					else :
						_e( 'Join the conversation', 'twentythirteen' );
					endif;
				?></span></h1>
			</header><!-- .archive-header -->

	<!--<h6><?php global $wp_query; echo $wp_query->found_posts; ?> post(s) in this section</h6>-->
		
	<?php genderhub_pagination(); ?>
			
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
<br /><br />
	<?php genderhub_pagination(); ?>


<?php else : ?>
		<?php // get_template_part( 'content', 'none' ); ?>
		<?php 
			$my_postid = 37;//This is page id or post id
			$content_post = get_post($my_postid);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			echo $content;
			
?>
<?php endif; ?>

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "connect-discuss-content" ); ?> 


</div><!--/col span_3_of_4-->

<div class="col span_1_of_4 sidebar padding10">

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "connect-discuss-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>