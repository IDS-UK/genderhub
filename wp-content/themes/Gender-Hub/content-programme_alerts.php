<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( is_single() ) : ?>

        <header class="entry-header">

            <h1 class="entry-title"><span><?php the_title(); ?></span></h1>

        <?php else : ?>

            <h1 class="entry-title">

                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>

            </h1>

        <?php endif; // is_single() ?>

        <?php if ( is_home() || is_archive()  || is_search() || is_single() ) : // Only display Excerpts for Home / Archive / Search ?>
		
            <h6>
                <span>Author: </span><strong><?php the_author(); ?></strong>
                <span class="floatright"><img src="/wp-content/uploads/2015/06/bell-icon.png" /></span>
            </h6>

        </header><!-- .entry-header -->

    <?php endif; ?>
	
	<?php if ( is_home() || is_archive() || is_search() ) : ?>

        <div class="entry-summary entry-content group">

            <div class="intro_blurb group">
                <div class="news_photo">
                    <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
                        <div class="news_photo-inner">
                            <?php the_post_thumbnail('blog_featured');
                            echo '<div class="news_photo-text">'.get_post(get_post_thumbnail_id())->post_excerpt.'</div>'; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="intro_blurb_header">
                    <?php the_excerpt(); ?>
                </div><!--intro_blurb_header-->

            </div><!--intro_blurb-->

            <p><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>

        </div><!-- .entry-summary -->

	<?php else : ?>

        <div class="entry-summary entry-content group">

            <?php the_post_thumbnail('gallery'); ?>
            <?php the_content(); ?>
            <p><a class="button" href="<?php echo get_post_meta(get_the_ID(), '_pa_slide_link_url', true); ?>"><?php echo get_post_meta(get_the_ID(), '_pa_slide_link_text', true); ?></a></p>

            <?php echo do_shortcode('[ssbp]'); ?>
		
            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'genderhub' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

        </div><!-- .entry-content -->

    <?php endif; ?>

</article><!-- #post -->