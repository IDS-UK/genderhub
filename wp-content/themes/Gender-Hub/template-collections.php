<?php
/**
 * Slkr -
 * Template Name: Collections Page Template
 */
get_header(); 
?>

<?php if(have_posts()):
    while ( have_posts() ) : the_post(); ?>
        <h1><span><?php the_title();?></span></h1>
        <?php
        the_content();
    endwhile;
endif; ?>
<?php get_footer(); ?>
