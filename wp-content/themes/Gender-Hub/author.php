<?php
/**
 * The template for displaying Author archive pages
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

			<?php
				/*
				 * Queue the first post, that way we know what author
				 * we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<header class="archive-header">
				<h1 class="archive-title"><span>
				
				<div class="rss_socials">
<ul>
<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
</ul>
</div><?php printf( __( 'All posts by %s', 'twentythirteen' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></span></h1>


			</header><!-- .archive-header -->

<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> post(s) for this author</span>
		
		
<?php genderhub_pagination(); ?>
		
			<?php
				/*
				 * Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php endif; ?>

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

<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "news-sidebar" ); ?> 

</div><!--/col span_1_of_4-->


	
	

</div><!--/section group-->




<?php get_footer(); ?>