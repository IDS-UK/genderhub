<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
if(get_the_ID() != 0 && get_the_ID() != ''):
?>
<?php 
// Pulls in the relevant background colour
include('inc/bg-colour.php');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($bgcolour); ?>>
    <!-- HEADER -->
    <header class="entry-header">
    <?php if ( is_single()) : ?>
    	<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
    <?php else : ?>
        <h1 class="entry-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1>
    <?php endif; // is_single() ?>
   
        <h6>
        <?php 
        if (is_single() && get_field('date') != '') {
        echo '<span>Date: </span><strong>'.get_field('date').'</strong>';
        }
        ?>
        
        </h6>


    </header><!-- .entry-header -->
    <!-- EXCERPT -->
    <?php if ( is_home() || is_archive() || is_search() || !is_single() ) : // Only display Excerpts for Home / Archive / Search ?>
    <div class="entry-summary">
  <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
        <div class="entry-featured-image">aaa
        <?php the_post_thumbnail('thumbnail'); ?>
        </div>
        <?php endif; ?>
		<?php the_excerpt(); ?>
        <p><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>
    </div><!-- .entry-summary -->
    <?php else : ?>
    
    <div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
        <div class="entry-featured-image">
        <?php the_post_thumbnail('full'); ?>
        </div>
        <?php endif; ?>
        <?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'twentythirteen' ) ); ?>
        
       
		<?php
		// Pull in the contact point
		$term_list = wp_get_post_terms($post->ID, 'topics', array("fields" => "ids"));
		
		 $args = array( 'numberposts' => 1,'post_type' => array('contact_point'), 'tax_query' => array(
		
		array(
			'taxonomy' => 'topics',
			'field'    => 'term_id',
			'operator' => 'IN',
			'terms'    => $term_list,
		)) );
			
#$args = array( 'numberposts' => 6,'post_type' => 'topic-guides');
$myposts = get_posts( $args );
if(count($myposts)>0):
echo '<div class="profile">';
foreach ( $myposts as $profile ) : 


 ?>
	<div class="profile-item">
    		<?php 
            $image = get_field('organisiation_logo');
        	if( !empty($image) ): ?>
        	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
        	<?php endif; ?>
            <?php echo apply_filters('the_content',$profile->post_content);?>
			<p><strong><a href="<?php echo get_permalink($profile->ID);?>"><?php echo $profile->post_title;?></a></strong></p>
    
	</div>
<?php endforeach; 
wp_reset_postdata();
echo ' </div>';
		endif; 
		
		
		?>
        
        <?php echo do_shortcode('[ssbp]'); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>
</article><!-- #post -->
<?php endif;?>