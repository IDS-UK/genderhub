<?php get_header(); ?>

    <div class="section group main_content">

        <div class="col span_3_of_4 archive_content padding10">

            <h1 class="maintitle"><span><a href="/build-capacity/other-training/">Training opportunities</a></span></h1>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'other_training' ); ?>
									
                <?php edit_post_link(); ?>
		
                <?php comments_template(); ?>
									
            <?php endwhile; ?>
		 
        </div>

        <div class="col span_1_of_4 sidebar padding10 blockheaders pink">

            <?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "training-sidebar" ); ?>

        </div><!--/col span_1_of_4-->

    </div><!--/section group-->

<?php get_footer(); ?>