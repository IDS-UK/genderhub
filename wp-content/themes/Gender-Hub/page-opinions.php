<?php
/**
 * Page template for blogs_opinions marked as 'opinion' posts
 */

get_header();

$args = array(
	'post_type'  => 'blogs_opinions',
	'meta_query' => array(
		array(
			'key'     => 'blog_original_date',
		),
		array(
			'key' => '_is_opinion_post',
			'value'   => 1,
		),
	),
	'orderby'   => array( 'blog_original_date' => 'DESC' ),
	'paged'     => $paged
);
$wp_query = new WP_Query( $args );
?>

<div class="section group main_content">

	<div class="col span_3_of_4 archive_content padding10">

<?php if ( $wp_query->have_posts() ) : ?>

	<header class="archive-header">

		<h1 class="archive-title">
			<span><?php the_title();?></span>
		</h1>

	</header>

	<div class="rss_socials">
		<ul>
			<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
		</ul>
	</div>

	<span class="count-items"><?php echo $wp_query->found_posts; ?> post(s) </span>

	<?php genderhub_pagination(); ?>

	<?php the_content(); ?>

	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		<?php get_template_part( 'content', 'blog' ); ?>
	<?php endwhile; ?>

	<?php genderhub_pagination(); ?>
	
<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>
	
	</div><!--/col span_3_of_4-->

	<div class="col span_1_of_4 sidebar padding10">

		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "inspiration-sidebar" ); ?>

	</div><!--/col span_1_of_4-->
	
</div><!--/section group-->

<?php get_footer(); ?>