<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */

get_header(); ?>

	

			<?php while ( have_posts() ) : the_post(); ?>
 <h1><?php the_title();?></h1>
			
			<?php the_content();?>
			<?php endwhile; // end of the loop. ?>

	
<?php get_footer(); ?>