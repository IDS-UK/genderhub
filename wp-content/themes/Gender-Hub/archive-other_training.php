<?php
/**
 * Template Name: Other Training Archive page
 * The template for displaying Other Training Archive pages
 */

get_header(); ?>

<div class="section group main_content">

	<div class="col span_3_of_4 archive_content padding10">

	<?php if ( have_posts() ) : ?>

		<header class="archive-header">

			<h1 class="archive-title"><span>Training opportunities</span></h1>

		</header><!-- .archive-header -->

		<div class="rss_socials">
			<ul>
				<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
			</ul>
		</div>

		<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> post(s) </span>

		<?php genderhub_pagination(); ?>

			<?php if(get_option($wp_query->query['post_type'].'-description') != ''): echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>'; endif;?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'other_training' ); ?>

			<?php endwhile; ?>

		<?php genderhub_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

	</div>

	<div class="col span_1_of_4 sidebar padding10">

		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "build-capacity-sidebar" ); ?>

	</div>

</div><!--/section group-->

<?php get_footer(); ?>