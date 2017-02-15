<?php
/**
 * Template for displaying posts of type 'other_training'
 *
 * Used for both single and index/archive/search.
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">

		<?php if ( is_single() ) : ?>

			<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
		
		<?php else : ?>
		
			<h1 class="entry-title">
                                <?php if ( is_search() ) :  ?><span class="search-content-type">TRAINING: </span><?php endif; ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>

			</h1>
		
		<?php endif; ?>

		<?php if ( is_home() || is_archive()  || is_search() || is_single() ) : // Only display Excerpts for Home / Archive / Search / Single ?>

<h6>
    <span class="floatright"><img src="/wp-content/uploads/2015/06/presentation-icon.png" /></span>
		 <?php	$author = get_field('author');
		 		$idsauthor = ids_get_field('authors');
		 		$blogauthor = get_field('blog_author');
	
				 if  ($idsauthor) {
				 echo '<span>Publisher: </span><strong>'.$idsauthor.'</strong> ';
				 }
				 elseif  ($blogauthor) {
				 echo '<span>Publisher: </span><strong>'.$blogauthor.'</strong> ';
				 } 
				 elseif  ($author) {
				 echo '<span>Publisher: </span><strong>'.$author.'</strong> ';
				 }
				 elseif(get_the_author() != '') {
					 echo '<span>Publisher: </span><strong>'.get_the_author().'</strong> ';
					 } ?> 


<?php 
	if (($timestamp = strtotime(get_field('date_published'))) || ($timestamp = get_post_meta(get_the_ID(), 'wprss_item_date', TRUE))) {
    $date_published = date('d/m/Y', $timestamp);
			echo '<span>Published on: </span><strong>'.$date_published.'</strong>';
		}
		
			 	 
?>
 

<?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) );
if ($terms_as_text != ''): echo '<span>Content type(s): </span><strong>'.$terms_as_text.'</strong>'; endif;
?>


					 
</h6>


<?php endif; ?>



</header>
	
	<?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>
	

	
	<div class="entry-summary">
	
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<!--<?php the_post_thumbnail('custom-thumb'); ?>-->
		
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
		
		
		<h6><?php 

$source = get_field('source');

if( !empty($source) ): ?>

	<a class="button external" href="<?php echo (!preg_match("~^(?:f|ht)tps?://~i", $source)) ? "http://" . $source : $source; ?>">Read more</a>

<?php endif; ?>

		</h6>
		
		
		<div class="col span_1_of_4">
		<?php 

$image = get_field('organisiation_logo');

if( !empty($image) ): ?>

	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

<?php endif; ?>

		</div><!--span_1_of_4-->
		
		
		
		   <?php echo do_shortcode('[ssbp]'); ?>


<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
	
	<!--<footer class="entry-meta">
	
	
			<p>This post was created on <?php the_time('F jS, Y'); ?>. <br />
			In categories: <?php the_category(', '); ?>. By <?php the_author_posts_link() ?></p>
		
		
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'twentythirteen' ) . '</span>', __( 'One comment so far', 'twentythirteen' ), __( 'View all % comments', 'twentythirteen' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
