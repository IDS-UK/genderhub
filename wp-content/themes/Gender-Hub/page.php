<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php the_title('<h1><span>', '</span></h1>');?>

	<div class="section group main_content">
		<div class="col span_3_of_4 archive_content padding10">
		<article>
			<?php the_content();?>
		</article>
		</div><!--/col span_3_of_4 padding10-->
`		<div class="col span_1_of_4 padding10">
			<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "generic-sidebar" ); ?>
		</div><!--/col span_1_of_4-->

	</div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>