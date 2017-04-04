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

                <?php
                $author = get_field('author');
                $idsauthor = ids_get_field('authors');
                $blogauthor = get_field('blog_author');
	
                if  ($idsauthor) {
                    echo '<span>Publisher: </span><strong>'.$idsauthor.'</strong> ';
                } elseif  ($blogauthor) {
                    echo '<span>Publisher: </span><strong>'.$blogauthor.'</strong> ';
                } elseif  ($author) {
                    echo '<span>Publisher: </span><strong>'.$author.'</strong> ';
                } elseif(get_the_author() != '') {
                    echo '<span>Publisher: </span><strong>'.get_the_author().'</strong> ';
                }

                if (($timestamp = strtotime(get_field('date_published'))) || ($timestamp = get_post_meta(get_the_ID(), 'wprss_item_date', TRUE))) {
                    $date_published = date('d/m/Y', $timestamp);
                    echo '<span>Published on: </span><strong>'.$date_published.'</strong>';
                }

                ?>

            </h6>

        <?php endif; ?>

    </header>
	
    <?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>

        <div class="entry-summary">

            <?php if ( has_post_thumbnail()) : ?>

            <div class="archive-image wp-caption">
                <?php has_post_thumbnail('archive-listings') ? the_post_thumbnail('archive-listings') : the_post_thumbnail('blog_featured'); ?>
                <p class="wp-caption-text"><?php the_post_thumbnail_caption(); ?></p>
                <?php if(!empty($image_credit_text)) : ?>
                    <p class="photo-credit"><b>Photo:</b> <?php echo !empty($image_credit_url) ? '<a href="'.$image_credit_url.'" target="_blank">'.$image_credit_text.'</a>' : $image_credit_text; ?></p>
				<?php endif; ?>
            </div>

		<?php endif; ?>

        <div class="archive-text">
	        <?php the_excerpt(); ?>
        </div>

		<p><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>

	</div>

	<?php else : ?>
	
        <div class="entry-content group">

            <?php if ( has_post_thumbnail()) : ?>

                <div class="featured-image wp-caption">

                    <div class="featured-image-container">

                        <?php the_post_thumbnail('blog_featured'); ?>
                        <?php if(!empty($image_credit_text)) : ?>
                            <p class="photo-credit"><b>Photo:</b> <?php echo !empty($image_credit_url) ? '<a href="'.$image_credit_url.'" target="_blank">'.$image_credit_text.'</a>' : $image_credit_text; ?></p>
                        <?php endif; ?>

                    </div>

                    <p class="wp-caption-text"><?php the_post_thumbnail_caption(); ?></p>

                </div>

            <?php endif; ?>

            <?php the_content( ); ?>
		
            <h6>
                <?php

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

            </div>
		
            <?php echo do_shortcode('[ssbp]'); ?>

            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?></div>

    <?php endif; ?>

</article>
