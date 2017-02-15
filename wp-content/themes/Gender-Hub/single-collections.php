<?php
/*
  * Slkr -
  * Collections are dated snapshots, containing posts,
  * articles, tools, documents, etc. relating to a topic
  */

get_header(); ?>

				<div class="section group main_content">

				<?php if ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'collections' ); ?>

				</div>
			<!-- slkr - close 2 x <div>, 1 x <section> opened in header.php -->
			</div>
		</div>
	</section>

	<section id="content">
		<article id="inspiring">
			<div class="inner blue">
				<div class="paddingleftright">
					<h3>More on this topic</h3>

					<div id="insp">
                        <?php 
                        $topic_list = array();
                        $topics = wp_get_post_terms(get_the_ID(), 'topics', array('fields' => 'all','orderby' => 't.term_id'));
                        foreach($topics as $topic) {
                            $topic_list[] = $topic->term_id;
                        }?>
						<?php //print 'xxx'.print_r($topic_list,true);
                                                $path = $_SERVER['DOCUMENT_ROOT'].'/ajax.php';
                                                $topics = implode(',',$topic_list);
						include($path);
						?>

					</div>
				</div>
			</div>
		</article>
	</section>

	<section>
		<div class="inner">
			<div class="paddingleftright">

				<div class="section group main_content">

				<div class="row">

					<div class="col col1_3"><?php echo do_shortcode( '[contact-form-7 id="11686" title="Email Signup New"]' ); ?></div>
					<div class="col col2_3"><?php echo do_shortcode('[ssbp]'); ?></div>

				</div>

				<div class="row nbm">

					<div class="col col1_3"></div>

					<div class="col col2_3">

						<?php

						$pagelist = get_pages('post_type=collections&sort_column=menu_order&sort_order=asc');
						$pages = array();
						foreach ($pagelist as $page) {
							$pages[] += $page->ID;
						}
						$current = array_search($post->ID, $pages);
						$prevID = $pages[$current-1];
						$nextID = $pages[$current+1];
						?>

						<div class="next-prev-links">
							<?php if (!empty($prevID)) { ?>
								<div class="left"><a href="<?php echo get_permalink($prevID); ?>" title="<?php echo get_the_title($prevID); ?>">« <?php echo get_the_title($prevID); ?></a></div>
							<?php }
							if (!empty($nextID)) { ?>
								<div class="right"><a href="<?php echo get_permalink($nextID); ?>" title="<?php echo get_the_title($nextID); ?>"> <?php echo get_the_title($nextID); ?> »</a></div>
							<?php } ?>
						</div>

					</div>

				</div>

				<div class="row">

					<div class="col col1_3"></div>
					<div class="col col2_3">

						<?php comments_template(); ?>

					</div>

				</div>


    <?php endif; ?>

<?php get_footer(); ?>