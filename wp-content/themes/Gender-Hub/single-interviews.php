<?php get_header(); ?>
	
	<div class="section group main_content">

<?php if ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', 'interviews' ); ?>

<?php endif; ?>

	</div>

<?php get_footer(); ?>