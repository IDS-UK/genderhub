<?php
/**
 * The template for displaying Resources Search Results Content
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

    <header class="page-header">

        <h1 class="maintitle"><span><?php printf('Search results for: <strong>%s</strong>', get_search_query() ); ?></span></h1>

    </header>

    <span class="count-items"><?php global $wp_query; echo $wp_query->found_posts; ?> items found</span>
		
    <?php genderhub_pagination(); ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', get_post_type() ); ?>

    <?php endwhile; ?>

    <?php genderhub_pagination(); ?>

<?php else : ?>

    <?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>