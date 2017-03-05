<?php
$image_credit_text = get_post_meta(get_post_thumbnail_id(), '_image_credit_text', true);
$image_credit_url = get_post_meta(get_post_thumbnail_id(), '_image_credit_url', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">

        <?php if ( is_single() ) : ?>

            <h1 class="entry-title"><span><?php the_title(); ?></span></h1>

            <?php else : ?>

            <h1 class="entry-title">

                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>

            </h1>

        <?php endif; ?>

        <?php if ( is_home() || is_archive()  || is_search() || is_single() ) : ?>
		
            <h6>
                <span>Author: </span><strong><?php the_author(); ?></strong>
                <span class="floatright"><img src="/wp-content/uploads/2015/06/bell-icon.png" /></span>
            </h6>

        <?php endif; ?>

    </header>
	
	<?php if ( is_home() || is_archive() || is_search() ) : ?>

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
                <?php echo get_the_excerpt(); ?>
            </div>

            <p class="button-container"><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>

        </div>

	<?php else : ?>

        <div class="entry-content group">

	        <?php if ( has_post_thumbnail()) : ?>
                <div class="featured-image wp-caption">
                    <div class="featured-image-container">
			        <?php the_post_thumbnail('gallery'); ?>
	                <?php if(!empty($image_credit_text)) : ?>
                        <p class="photo-credit"><b>Photo:</b> <?php echo !empty($image_credit_url) ? '<a href="'.$image_credit_url.'" target="_blank">'.$image_credit_text.'</a>' : $image_credit_text; ?></p>
	                <?php endif; ?>
                    </div>
                    <p class="wp-caption-text"><?php the_post_thumbnail_caption(); ?></p>
                </div>

	        <?php endif; ?>

            <?php the_content(); ?>

            <?php if (!empty(get_post_meta(get_the_ID(), '_pa_slide_link_url'))) : ?>
                <p class="button-container"><a class="button" href="<?php echo get_post_meta(get_the_ID(), '_pa_slide_link_url', true); ?>"><?php echo get_post_meta(get_the_ID(), '_pa_slide_link_text', true); ?></a></p>
            <?php endif; ?>

            <?php echo do_shortcode('[ssbp]'); ?>
		
            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'genderhub' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

        </div>

    <?php endif; ?>

</article>