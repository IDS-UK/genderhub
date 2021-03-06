<?php
/**
 * /* Template Name: News & Stories Archive page
 */

get_header(); ?>

<div class="section group main_content">

    <div class="col span_3_of_4 archive_content padding10">

        <?php if ( have_posts() ) : ?>

            <header class="archive-header">

                <h1 class="archive-title"><span>
				
                        <?php if ( is_day() ) :
                            printf( __( 'Daily Archives: %s', 'twentythirteen' ), get_the_date() );
                        elseif ( is_month() ) :
                            printf( __( 'Monthly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
                        elseif ( is_year() ) :
                            printf( __( 'Yearly Archives: %s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
                        else :
                            _e( 'News & stories', 'twentythirteen' );
                        endif; ?>

                    </span>

                </h1>

            </header><!-- .archive-header -->

            <span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> article<?php echo (($wp_query->found_posts == 1) ? '' : 's'); ?></span>
		
            <?php genderhub_pagination(); ?>

            <?php if(get_option($wp_query->query['post_type'].'-description') != ''): echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>'; endif;?>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'news_stories' ); ?>

            <?php endwhile; ?>

            <br /><br />

            <?php genderhub_pagination(); ?>

        <?php else : ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

    </div><!--/col span_3_of_4-->

    <div class="col span_1_of_4 sidebar padding10">

        <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "inspiration-sidebar" ); ?>

    </div><!--/col span_1_of_4-->

</div><!--/section group-->

<?php get_footer(); ?>