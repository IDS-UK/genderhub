<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 09/06/2016
 * Time: 17:38
 */

get_header(); ?>

<div class="section group main_content">

	<div class="col span_3_of_4 archive_content padding10">

		<header class="archive-header">
			<h1 class="archive-title"><span>Contact points</span></h1>
		</header>

	<?php if (have_posts() ) : ?>

		<?php genderhub_pagination(); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_type() ); ?>
			<?php endwhile; ?>

		<?php genderhub_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>
		
	</div><!--/col span_3_of_4-->

	<div class="col span_1_of_4 sidebar padding10">

	<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "connect-discuss-sidebar" ); ?>

	</div><!--/col span_1_of_4-->

</div><!--/section group-->

<?php get_footer(); ?>