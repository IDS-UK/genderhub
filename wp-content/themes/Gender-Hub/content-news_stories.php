<?php
global $more; $more=1;
$source = get_field('source');
$publisher = get_field('author');
$image_credit_text = get_post_meta(get_post_thumbnail_id(), '_image_credit_text', true);
$image_credit_url = get_post_meta(get_post_thumbnail_id(), '_image_credit_url', true);
$slide_link_text = get_post_meta(get_the_ID(), '_pa_slide_link_text', true);
$slide_link_url = get_post_meta(get_the_ID(), '_pa_slide_link_url', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php $source = get_field('source');?>
	
	<header class="entry-header">

        <h1 class="entry-title">

            <?php	if( !empty($source) ): ?>
				
				<a href="<?php echo $source; ?>" style="padding: 4px 10px 4px 34px; display: block; background-position:0em 0.25em;background-repeat: no-repeat; background-size: 24px auto;background-image: url('http://www.google.com/s2/favicons?domain=<?php echo $source; ?>'); ">
					<?php if ( is_search() ) :  ?><span class="search-content-type">NEWS: </span><?php endif; ?>
                    <?php the_title(); ?>
				</a>
			<?php endif; ?>
		</h1>
				
		<?php if ( is_home() || is_archive()  || is_search() || is_single() ) : // Only display Excerpts for Home / Archive / Search ?>

            <h6>
            
                <?php if  ($publisher) {
                    echo '<span>Publisher: </span><strong>'.$publisher.'</strong> ';
				 } elseif(get_the_author() != '') {
					 echo '<span>Publisher: </span><strong>'.get_the_author().'</strong> ';
                } ?>

                <?php
                if (($timestamp = strtotime(get_field('date_published'))) || ($timestamp = get_post_meta(get_the_ID(), 'wprss_item_date', TRUE))) {
                    $date_published = date('d/m/Y', $timestamp);
                    echo '<span>Published on: </span><strong>'.$date_published.'</strong>';
                } ?>
 
					 
			<?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) );
if ($terms_as_text != ''): echo '<span>Content type(s): </span><strong>'.$terms_as_text.'</strong>'; endif;
?>
	<span class="floatright"><img src="/wp-content/uploads/2015/06/bell-icon.png" /></span>
</h6>

		<?php endif; ?>

	</header><!-- .entry-header -->
	
	
	<!-- EXCERPT -->
	
	<?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>
		
	<div class="entry-summary group">

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
			<?php echo the_content(); ?>
        </div>
			
	<p><?php 
		if( !empty($source) ): ?>
			<a class="button external" href="<?php echo $source; ?>">Read more<?php echo ( !empty($publisher) ? ' at '.$publisher : '') ?></a>
		<?php endif; ?>
	</p>

	</div><!-- .entry-summary -->
	
	
	
	
	
	<?php else : ?>
	
	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<div class="entry-featured-image">
				<?php print (!empty($source) ? '<a href="'. $source . '" title="' . $title . '">' : ''); ?>
				<?php the_post_thumbnail('medium');
                                echo '<span>'.get_post(get_post_thumbnail_id())->post_excerpt.'</span>'; ?>
				<?php print (!empty($source) ? '</a>' : ''); ?>
			</div>
		<?php endif; ?>
	
		<?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'genderhub' ) ); ?>
		
		
		<h6><?php 
			if( !empty($source) ): ?>
				<a class="button external" href="<?php echo $source; ?>">Read more<?php echo ( !empty($publisher) ? ' at '.$publisher : '') ?></a>
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
