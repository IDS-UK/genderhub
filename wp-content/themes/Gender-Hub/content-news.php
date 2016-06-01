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
?>
<?php global $more; $more=1; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	

	<!-- HEADER -->
	
	<header class="entry-header">
		<h1 class="entry-title">
			<?php $source = get_field('source');
			if( !empty($source) ): ?>
				
				<a href="<?php echo $source; ?>" style="padding: 4px 10px 4px 24px; display: block; background-position:0em 0.5em;background-repeat: no-repeat; background-image: url('http://www.google.com/s2/favicons?domain=<?php echo $source; ?>'); ">
					<?php the_title(); ?>
				</a>
			<?php endif; ?>
		</h1>
				
		<?php if ( is_home() || is_archive()  || is_search() || is_single() ) : // Only display Excerpts for Home / Archive / Search ?>
			<h6>
            
                     
                     <?php	$author = get_field('author');
			 if  ($author) {
				 echo '<span>Publisher: </span><strong>'.$author.'</strong> ';
				 } elseif(get_the_author() != '') {
					 echo '<span>Publisher: </span><strong>'.get_the_author().'</strong> ';
					 } ?> 
			
 
 <?php 
	if (($timestamp = strtotime(get_field('date_published'))) || ($timestamp = get_post_meta(get_the_ID(), 'wprss_item_date', TRUE))) 
		{
			 $date_published = date('d/m/Y', $timestamp);
			echo '<span>Published on: </span><strong>'.$date_published.'</strong>';
		}
		
			 	 
?>
 
					 
			<?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) );
if ($terms_as_text != ''): echo '<span>Content type(s): </span><strong>'.$terms_as_text.'</strong>'; endif;
?>
	<?php

if( has_term( 'Event', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/event-icon.png" /></span>';
elseif( has_term( 'Blog', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/blog-icon.png" /></span>';
elseif( has_term( 'News', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/news-icon.png" /></span>';
elseif( has_term( 'Training', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/training-icon.png" /></span>';
elseif( has_term( 'Alert', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/bell-icon.png" /></span>';
elseif( has_term( 'Document', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/document-icon.png" /></span>';
elseif( has_term( 'Story', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/speech-bubbles-icon.png" /></span>';
elseif( has_term( 'Tool', 'content_type',$wp_query->post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/presentation-icon.png" /></span>';
endif;
?>		</h6>

		<?php endif; ?>

	</header><!-- .entry-header -->
	
	
	<!-- EXCERPT -->
	
	<?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>
		
	<div class="entry-summary group">
	
		<div class="news_photo">
				<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
					<a href="<?php echo $source; ?>">
					<?php the_post_thumbnail('custom-thumb'); 
					echo '<p class="wp-caption-text">'.get_post(get_post_thumbnail_id())->post_excerpt.'</p>'; ?>
					</a>
				<?php endif; ?>
		</div>
			
			
			
	<!--<div class="news_photo">
	<?php 
		$image = get_field('blog_image');
		if( !empty($image) ): 
			// vars
			$url = $image['url'];
			$title = $image['title'];
			$alt = $image['alt'];
			$caption = $image['caption'];
			// thumbnail
			$size = 'medium';
			$thumb = $image['sizes'][ $size ];
			$width = $image['sizes'][ $size . '-width' ];
			$height = $image['sizes'][ $size . '-height' ];
		
			if( $caption ): ?>
				<div class="wp-caption">
			<?php endif; ?>

			<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
				<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
			</a>

			<?php if( $caption ): ?>
				<p class="wp-caption-text"><?php echo $caption; ?></p>
			</div>
		<?php endif; ?>

	<?php endif; ?>

	</div>-->
		
		
	<?php 
		//the_excerpt(); 
		$x = get_post(get_the_ID(), OBJECT, 'display');
		print wpautop($x->post_content);
	?>
			
	<p><?php 
		$source = get_field('source');
		if( !empty($source) ): ?>
			<a class="button" href="<?php echo $source; ?>">Read full article</a>
		<?php endif; ?>
	</p>

	</div><!-- .entry-summary -->
	
	
	
	
	
	<?php else : ?>
	
	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<div class="entry-featured-image">
				<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
				<?php the_post_thumbnail(); 
				echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
				</a>
			</div>
		<?php endif; ?>
	
		<?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'genderhub' ) ); ?>
		
		
		<h6><?php 
			$source = get_field('source');
			if( !empty($source) ): ?>
				<a class="button" href="<?php echo $source; ?>">Click for external source</a>
			<?php endif; ?>
		</h6>

		<!--<div class="col span_1_of_4">
		<?php 
			$image = get_field('organisiation_logo');
			if( !empty($image) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
			<?php endif; ?>
		</div><!--span_1_of_4-->
		
		
		<?php echo do_shortcode('[ssbp]'); ?>
			
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'genderhub' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

	</div><!-- .entry-content -->
	<?php endif; ?>
	
	
	<!--<footer class="entry-meta">
	
	
			<p>This post was created on <?php the_time('F jS, Y'); ?>. <br />
			In categories: <?php the_category(', '); ?>. By <?php the_author_posts_link() ?></p>
		
		
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'genderhub' ) . '</span>', __( 'One comment so far', 'genderhub' ), __( 'View all % comments', 'genderhub' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
