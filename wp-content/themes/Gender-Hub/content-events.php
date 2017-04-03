<?php
/**
 * The template for displaying events content
 * Used for both single and index/archive/search.
 */
 if(get_the_ID() != 0 && get_the_ID() != ''):
 if( has_term( 'Event', 'content_type',$wp_query->post->ID ) ):
$bgcolour = 'pink';
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($bgcolour); ?>>
	
	<header class="entry-header">
		
		<?php if ( is_single() ) : ?>
		
			<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
			
		<?php else : ?>
		
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
                                <?php if ( is_search() ) :  ?><span class="search-content-type">EVENT: </span><?php endif; ?>
                                    <?php the_title(); ?>
                                </a>
			</h1>
		
		<?php endif; ?>
		
		<?php if ( is_home() || is_archive()  || is_search() || is_single() ) : // Only display Excerpts for Home / Archive / Search / Single ?>

			<h6>

				 <?php	
				$dates = ids_pretty_date(strtotime(get_field('start_date')), strtotime(get_field('end_date')));
				 if ($dates) {
					print '<span>Date(s): </span><strong>'.$dates.'</strong>';
				}			
				?>
		 
				<?php
				$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) );
				?>
		
				<?php
				echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/event-icon.png" /></span>';
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

	</div>
		
	<?php else : ?>
	
	<div class="entry-content">
	
	


	<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail('full'); ?>
		</div>
	<?php endif; ?>

	<?php if(get_field('location')) { ?>

        <div id="event-map">
            <div id="map"></div>
            <div class="marker" data-lat="<?php echo $location['value']['lat']; ?>" data-lng="<?php echo $location['value']['lng']; ?>"><?php echo $location['value']['address']; ?></div>
        </div>
	<?php } ?>

		<?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'twentythirteen' ) ); ?>
		
		
		<?php $source = get_field('source');
		if( !empty($source) ): ?>
			<h6>
				<a class="button" href="http://<?php echo $source; ?>">Click for external source</a>
			</h6>
		<?php endif; ?>

		<?php $link = get_field('link');
		if( !empty($link) ): ?>
			<div class="event-link">
				<a class="button" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
			</div>
		<?php endif; ?>	
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
<?php endif;?>