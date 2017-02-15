<?php
/**
 * Template Name: Blogs & Opinions Archive page
 * The template for displaying Blogs & Opinions Archive pages
 */

get_header(); 

query_posts(
    array(
		'post_type' => 'blogs_opinions',
		'order'     => 'DESC',
		'meta_key' => 'blog_original_date',
		'orderby'   => 'meta_value', //or 'meta_value_num'
		'paged'		=> $paged,
    )
);
?>

<div class="section group main_content">

	<div class="col span_3_of_4 archive_content padding10">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">

				<h1 class="archive-title"><span>Blogs & opinion</span></h1>

			</header>

			<div class="rss_socials">

				<ul>
					<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
				</ul>

			</div>

			<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> post(s) </span>

			<?php genderhub_pagination(); ?>

			<?php if(get_option($wp_query->query['post_type'].'-description') != ''): echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>'; endif;?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'blogs_opinions' ); ?>

				<?php endwhile; ?>

			<?php genderhub_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</div>

	<div class="col span_1_of_4 sidebar padding10">

		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "inspiration-sidebar" ); ?>

	</div>

</div>

<?php get_footer(); ?>