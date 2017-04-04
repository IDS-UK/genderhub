<?php
/**
 * The Template for displaying all single posts.
*/

get_header(); ?>

    <div class="section group main_content">

        <div class="col col1_3 sidebar blockheaders green">

            <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( 'knowledge-sidebar' ); ?>

            <?php

            $topics = wp_get_post_terms(get_the_ID(), 'topics', array('fields' => 'all','orderby' => 't.term_id'));
            foreach($topics as $topic) {
                $topic_list[] = $topic->term_id;
            }

            $posts_array = get_posts(

                array( 'showposts' => -1,
                       'post_type' => 'collections',
                       'tax_query' => array(
                           array(
                               'taxonomy' => 'topics',
                               'field' => 'term_id',
                               'terms' => $topic_list,
                           )
                       )
                )
            );

            if (count($posts_array) > 0) {
                echo '<div class="document-collections-wrapper">';
                echo '<h3>Collections</h3>';
                echo '<div class="textwidget">';
	            echo '<p>'.'Find more like this in our collections'.'</p><ul>';
                foreach ($posts_array as $collection) {
                    $collection_date = new DateTime(get_field('date', $collection->ID));
                    echo '<li>';
                    echo '<a href="'.get_the_permalink($collection->ID).'">'.$collection->post_title.' ('.$collection_date->format('F Y').')</a><br/>'.  get_the_excerpt($collection->ID);
                    echo '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            } ?>

        </div><!--/col span_1_of_4-->

        <div class="col col2_3 archive_content padding10">

            <h1 class="maintitle"><span><a href="/get-in-the-know/resource-library/">Documents</a></span></h1>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content-ids_documents', get_post_format() ); ?>
                <?php edit_post_link(); ?>
								
                <?php comments_template(); ?>

                <span class="nav-previous"><?php previous_post_link( '%link', 'Previous post in category', TRUE, ' ', 'post_format' ); ?> </span>
                <span class="nav-previous"><?php next_post_link( '%link', 'Next post in category', TRUE, ' ', 'post_format' ); ?> </span>

			<?php endwhile; ?>		 
		 
    </div>

</div>

<?php get_footer(); ?>