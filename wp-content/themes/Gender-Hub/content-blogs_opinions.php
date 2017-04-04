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

<article id="post-<?php the_ID(); ?>" <?php (get_field('_is_opinion_post') == TRUE) ? post_class('post-type-opinion') : post_class(); ?>>
	
<!-- HEADER -->
	<header class="entry-header">
	<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
	<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
                           <?php if ( is_search() && has_term( 'Blog', 'content_type',$wp_query->post->ID ) ) :  ?><span class="search-content-type">BLOG POST: </span><?php endif; ?>
                           <?php the_title(); ?>
                        </a>
		</h1>
	<?php endif; // is_single() ?>
		

<!-- CONTENT -->		
		
<?php if ( is_home() || is_archive()  || is_search() || is_single() || is_page('opinions') ) : // Only display Excerpts for Home / Archive / Search ?>

	<h6>
	<?php
	if( has_term( 'Blog', 'content_type',$wp_query->post->ID ) ):
		echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/blog-icon.png" /></span>';
	endif;
        //print_r(get_fields($wp_query->post->ID));
        ?>
    <?php $author = get_field('blog_author');
		if  ($author) {
			echo '<span>Author: </span><strong>'.$author.'</strong> ';
		} elseif(get_the_author() != '') {
			echo '<span>Author: </span><strong>'.get_the_author().'</strong> ';
		} ?> 
	<?php 
	if(get_field('blog_original_date')) { 
		$date = DateTime::createFromFormat('Ymd', get_field('blog_original_date'));
		echo '<span>Published on: </span><strong>'.$date->format('d/m/Y').'</strong>';
	}
	?>
 	<?php
	$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) );
	// Don't need to show content type! if ($terms_as_text != ''): echo '<span>Content type(s): </span><strong>'.$terms_as_text.'</strong>'; endif;
	?>
	
	</h6>
<?php endif; ?>



</header><!-- .entry-header -->
	

<!-- for Blog posts don't display the EXCERPT as we have some INTRO text instead. Always display this. -->
	
	<?php if ( is_home() || is_archive() || is_search() || is_page('opinions') ) :
		// Only display Excerpts for Home / Archive / Search
		// We have the intro - we don't need anything else here.
	?>
	<div class="entry-summary entry-content group">

		<?php if ( has_post_thumbnail()) : ?>
            <div class="archive-image wp-caption">
				<?php the_post_thumbnail('blog_featured'); ?>
                <p class="wp-caption-text"><?php the_post_thumbnail_caption(); ?></p>
				<?php if(!empty($image_credit_text)) : ?>
                    <p class="photo-credit"><b>Photo:</b> <?php echo !empty($image_credit_url) ? '<a href="'.$image_credit_url.'" target="_blank">'.$image_credit_text.'</a>' : $image_credit_text; ?></p>
				<?php endif; ?>
            </div>

		<?php endif; ?>

        <div class="archive-text">
			<?php printf(__(get_field('blog_intro_blurb') ? get_field('blog_intro_blurb') : '')); ?>
        </div>

		<p><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>

	</div><!-- .entry-summary -->


	<?php else : ?>

	<div class="entry-summary entry-content group">

			<div class="intro_blurb_meta">


				<?php printf(__(get_field('blog_original_author_info') ? get_field('blog_original_author_info') : '')); ?>
				
				<?php //printf(__( get_field('blog_original_date') ? '<strong>Date: </strong>'.date_format(date_create(get_field('blog_original_date')), 'd M Y') : '')) ?>
				
				<p>
                            <?php if (get_field('blog_source_url')) : ?>
				    <strong>Sourced from: </strong><?php print format_link(get_field('blog_source_url'), get_field('blog_source_name')); ?><br />
				<?php endif; ?>
				<strong>Copyright: </strong><?php printf(__(get_field('blog_copyright') ? wp_strip_all_tags(get_field('blog_copyright')) : 'Not Known')); ?>
                                </p>
				
			</div><!--intro_blurb_meta-->

		<div class="entry-content">

			<?php 
				$image = get_field('blog_logo');
				if( !empty($image) ): ?>
					<div class="blog_logo"><a href="http://<?php the_field('blog_source_url'); ?>"><img class="blog_logo" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a></div>
				<?php endif; ?>

		<?php if (! is_single() ) : ?>
			<h2 class="blog-title"><a href="http://<?php the_field('blog_source_url'); ?>"><span><?php the_title(); ?></span></a></h2>
		<?php endif; ?>


		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<!--div class="entry-featured-image">
				<?php the_post_thumbnail(); 
				echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
			</div-->
		<?php endif; ?>
		
		<?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'twentythirteen' ) ); ?>
		
		
		<h6><?php 
			$source = get_field('source');
			if( !empty($source) ): ?>
				<a class="button" href="http://<?php echo $source; ?>">Click for external source</a>
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
		
	<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	

	</div><!-- .entry-content -->
		</div>
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
	</footer>--><!-- .entry-meta -->
</article><!-- #post -->
