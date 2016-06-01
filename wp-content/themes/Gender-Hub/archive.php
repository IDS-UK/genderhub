<?php
/**
 * The template for displaying Archive pages
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

<div class="section group main_content">

<div class="col span_3_of_4 archive_content padding10">

<?php
  $post_types = array_filter((array) get_query_var('post_type'));
?>

<?php if ( have_posts() ) : ?>

	<header class="archive-header">
    <h1 class="archive-title">
    <!--<div class="rss_socials">
      <ul>
        <li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>/feed"><span>RSS Feed</span></a></li>
      </ul>
    </div>-->
    <span>
    <?php
      if ( is_day() ) :
        printf( __( 'Daily Archives: %s', 'twentythirteen' ), get_the_date() );
      elseif ( is_month() ) :
        printf( __( 'Monthly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
      elseif ( is_year() ) :
        printf( __( 'Yearly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
      elseif ( is_category() || is_tax() ) :
        printf( __('Results for: '));
        single_cat_title( '', true );
      elseif ( in_array( 'practical_tools', $post_types ) ) :
        printf( __('Practical tools'));
      elseif ( is_post_type_archive( 'ids_documents' ) ) :
        _e( 'Documents', 'twentythirteen' );
      else :
        _e( 'Archives', 'twentythirteen' );
      endif;
    ?>
    </span>
    </h1>
	</header><!-- .archive-header -->
<span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> resources(s) </span>
 
		<?php if(get_option($wp_query->query['post_type'].'-description') != ''): echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>'; endif;?>
  <?php
  genderhub_pagination();	
  wp_reset_query(); 
	
	/* The loop */
    while ( have_posts() ) : the_post();
      
	//if (is_post_type_archive( 'ids_documents' )) { // IDS DOCUMENT
       if (get_post_type() == 'ids_documents') {
	 get_template_part( 'content-ids_documents' );
        //echo 'ppp'.get_post_type();
	} else { // REGULAR POST
        get_template_part( 'content', get_post_format() );
        //echo 'qqq'.get_post_type();
      }
		endwhile;
  genderhub_pagination();

else : 
  get_template_part( 'content', 'none' );
endif;

?>
</div><!--/col span_3_of_4-->

<?php 
  if ( in_array( 'practical_tools', $post_types ) ) {
    $dynamic_sidebar = 'build-capacity-sidebar';
  }
  else {
    $dynamic_sidebar = 'knowledge-sidebar';
  }
?>

  <div class="col span_1_of_4 sidebar padding10">
    <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( $dynamic_sidebar ); ?>
  </div><!--/col span_1_of_4-->
	
</div><!--/section group-->

<?php get_footer(); ?>
