<?php
/**
 * /* Template Name: Programme Alerts Archive page 

The template for displaying Programme Alerts Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <div class="section group main_content">

        <div class="col span_3_of_4 archive_content padding10">

            <?php if ( have_posts() ) : ?>
                <header class="archive-header">

                    <h1 class="archive-title"><span>
                            <div class="rss_socials">

                                <ul>

                                    <li class="rssNav"><a title="RSS Feed" href="<?php echo current_page_url(); ?>feed"><span>RSS Feed</span></a></li>
                                </ul>

                            </div>

                            <?php

                            if ( is_day() ) :
                                printf( __( 'Daily Archives: %s', 'genderhub' ), get_the_date() );
                            elseif ( is_month() ) :
                                printf( __( 'Monthly Archives: %s', 'genderhub' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'genderhub' ) ) );
                            elseif ( is_year() ) :
                                printf( __( 'Yearly Archives: %s', 'genderhub' ), get_the_date( _x( 'Y', 'yearly archives date format', 'genderhub' ) ) );
                            else :
                                _e( 'Programme activities', 'genderhub' );
                            endif; ?>

                        </span></h1>

                </header><!-- .archive-header -->

                <span class="count-items"><?php echo $wp_query->found_posts; ?> post(s) for this section</span>
		
                <?php genderhub_pagination(); ?>

                <?php if(get_option($wp_query->query['post_type'].'-description') != ''):
                    echo '<p class="introtext">'.get_option($wp_query->query['post_type'].'-description').'</p>';
                endif;?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', get_post_type() ); ?>

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