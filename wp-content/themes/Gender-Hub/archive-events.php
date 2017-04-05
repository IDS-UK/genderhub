<?php
/**
 * Template Name: Events Archive page
 * The template for displaying Events Archive pages
 */

get_header();

if (isset($_GET['e']) && $_GET['e'] == 'past') :
    $span = 'past';
else :
    $span = 'current';
endif;

if ($span === 'past') :
	$compare = '<=';
    $orderby = 'DESC';

else :
    $compare = '>=';
    $orderby = 'ASC';
endif;

$args = array(
	'post_type'  => 'events',
	'relation' => 'AND',
	'meta_query' => array(
		array(
			'key'       => 'end_date',
			'compare'   => $compare,
			'value'     => current_time('Ymd'),
		),
	),
	'orderby'   => array( 'end_date' => $orderby )
);
$wp_query = new WP_Query( $args );
?>

<div class="section group main_content">

	<div class="col span_3_of_4 archive_content padding10">
		
		<header class="archive-header">

			<h1 class="archive-title"><span><?php echo $span === 'past' ? 'Past ' : 'Current and upcoming ' ?>events</span></h1>

		</header>

		<div class="rss_socials">
			<ul>
				<li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
			</ul>
		</div>

		<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> resources(s)</span>

	<?php genderhub_pagination(); ?>

		<?php if(get_option($wp_query->query['post_type'].'-description') != ''): echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>'; endif;?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php get_post_format(); get_template_part( 'content', 'events' ); ?>

		<?php endwhile; ?>

	<?php genderhub_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

	</div>

	<div class="col span_1_of_4 sidebar padding10 blockheaders pink">

        <aside class="widget widget_text">
            <h3 class="widget-title">More events</h3>
            <div class="textwidget">
	        <?php
	        if ($span === 'past') :
		        echo '<p>See information about <a href="'.home_url().'/build-capacity/events/">current and upcoming events</a></p>';
	        else :
		        $link = add_query_arg( 'e', 'past', home_url().'/build-capacity/events/' );
		        echo '<p>See <a href="'.$link.'">past events</a></p>';
	        endif;
	        ?>
            </div>
        </aside>

		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "build-capacity-sidebar" ); ?>

	</div><!--/col span_1_of_4-->

</div><!--/section group-->

<?php get_footer(); ?>