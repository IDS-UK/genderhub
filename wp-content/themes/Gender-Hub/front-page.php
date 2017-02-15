<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 02/06/2016
 * Time: 17:15
 * 
 * The template for the home page of the site
 * 
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
	// slider
	if(get_the_content() != ''): $i = 1; $tc = 0;?>
		<section id="slider"><div class="inner paddingleftright">
				<?php
				$start_limiter = '[gallery';
				$end_limiter = ']';
				$haystack = get_the_content();
				$start_pos = strpos($haystack,$start_limiter);
				$end_pos = strpos($haystack,$end_limiter,$start_pos);
				$galldata = substr($haystack, $start_pos+1, ($end_pos-1)-$start_pos);
				$ng = explode('ids="',$galldata);
				?>

				<?php
				if(!empty($ng) && count($ng) > 1):
					echo ' <ul id="lightSlider">';
					$toget = array_reverse(explode(',',str_replace('"','',$ng[1])));

					$args =  array (
						'include' => $toget,
						'post_type' => 'attachment',
						'post_mime_type' => 'image',
						'orderby' => 'post__in',


					);

					$j = 0;$slider_count = 0;
					$myposts = get_posts( $args );
					foreach ( $myposts as $image ) : setup_postdata( $image ); $ic =get_post_custom($image->ID); $tc++;
						$img = wp_get_attachment_image_src( $image->ID, 'gallery' );
						$imgt = wp_get_attachment_image_src( $image->ID, 'gallery-thumb' );
						?>

						<li class="slide-<?php echo $slider_count++; ?>" data-thumb="<?php echo $imgt[0];?>" data-thumb-text="<?php echo get_the_title($image->ID);?>" title="<?php echo $image->post_excerpt;?>">
							<div class="slide <?php echo $ic['slide_colour'][0];?>">
								<div class="title"><h3 class="<?php echo $ic['slide_colour'][0];?>"><span><?php echo get_the_title($image->ID);?></span></h3></div>
								<img src="<?php echo $img[0];?>" />
								<div class="text"><p><?php echo get_the_content($image->ID);?></p><p><a href="<?php echo  $ic['slide_link'][0];?>" class="<?php echo $ic['slide_colour'][0];?>"><?php echo  $ic['slide_link_text'][0];?></a></p></div>
							</div>
						</li>




						<?php

					endforeach;
					echo '</ul>';
				endif;
				?>
			</div></section>
	<?php endif;?>


	<section id="content">
		<article id="inspiring">
			<div class="inner blue">

				<div class="paddingleftright">
					<h3>What's inspiring us</h3>
					<aside id="filter">
						Filter: <a rel="news_stories" class="filter"><img src="/wp-content/uploads/2015/05/bell-icon.png" /> News</a><a rel="other_training"  class="filter"><img src="/wp-content/uploads/2015/05/training-icon.png" /> Training</a><a rel="events" class="filter"><img src="/wp-content/uploads/2015/05/event-icon.png" /> Event</a><a rel="blogs_opinions" class="filter"><img src="/wp-content/uploads/2015/05/blog-icon.png" /> Blog</a>

					</aside>

					<div id="insp"><?php include($_SERVER['DOCUMENT_ROOT'].'/ajax.php');?></div>

				</div>

			</div>
			</div>
		</article>

	</section>

	<section id="getmore" class="bluebg">
		<div class="paddingleftright inner blue outer">
			<h2>Get more</h2>
			<div class="right left subscribe"><?php echo do_shortcode( '[contact-form-7 id="30306" title="Email Signup New"]' ); ?>
			</div>
			<div class="right email"><a href="/connect-and-discuss/contact-us/">Email us</a></div>
			<div class="right blog"><a href="/be-inspired/blogs-opinion/">Read the latest blog posts</a></div>
			<div class="right news"><a href="/be-inspired/news-stories/">Read more news</a></div>
		</div>
	</section>

	<?php echo gh_fetch_social_media_posts(); ?>
	
	<section id="social">
		<div class="paddingleftright inner outer">

			<h2>Get more</h2>


			<div class=" right see"><a href="/build-capacity/events/">See more of what's going on</a></div>
			<div class=" right join"><a href="/connect-and-discuss/join-the-conversation/">Join the conversation</a></div>

			<div class=" right facebook"><a href="https://www.facebook.com/GenderHubNigeria" target="_blank">Follow us on Facebook</a></div>
			<div class=" right twitter"><a href="https://twitter.com/gender_hub" target="_blank">Follow us on Twitter</a></div>

		</div>
	</section>
	


<section id="arealinks">
		<div class="paddingleftright inner">

			<figure class="col4 green">
				<?php
				$args = array( 'numberposts' => 1, 'post_type'=> 'page', 'orderby' => 'menu_order', 'include' => 5 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $t ) : $c = get_post_custom($t->ID);
					?>
					<div class="title"><?php echo get_the_title($t->ID);?></div>
					<div class="image"><?php echo get_the_post_thumbnail( $t->ID, 'box' ); ?> </div>
					<div class="text">
						<?php echo apply_filters('the_content',$t->post_excerpt);?>
						<p class="links">
							<?php
							$args = array( 'numberposts' => 20, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 5 );
							$myposts = get_posts( $args );
							foreach ( $myposts as $s ) :
								?>
								<a href="<?php echo get_permalink($s->ID);?>"><?php echo get_the_title($s->ID);?></a>
								<?php
							endforeach;
							wp_reset_postdata();?>
						</p>
					</div>
					<?php
				endforeach;
				wp_reset_postdata();?>
			</figure>
			<figure class="col4 pink">
				<?php
				$args = array( 'numberposts' => 1, 'post_type'=> 'page', 'orderby' => 'menu_order', 'include' => 7 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $t ) : $c = get_post_custom($t->ID);
					?>
					<div class="title"><?php echo get_the_title($t->ID);?></div>
					<div class="image"><?php echo get_the_post_thumbnail( $t->ID, 'full' ); ?> </div>
					<div class="text">
						<?php echo apply_filters('the_content',$t->post_excerpt);?>
						<p class="links">
							<?php
							$args = array( 'numberposts' => 20, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 7 );
							$myposts = get_posts( $args );
							foreach ( $myposts as $s ) :
								?>
								<a href="<?php echo get_permalink($s->ID);?>"><?php echo get_the_title($s->ID);?></a>
								<?php
							endforeach;
							wp_reset_postdata();?>
						</p>
					</div>
					<?php
				endforeach;
				wp_reset_postdata();?>
			</figure>
			<figure class="col4 purple">
				<?php
				$args = array( 'numberposts' => 1, 'post_type'=> 'page', 'orderby' => 'menu_order', 'include' => 9 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $t ) : $c = get_post_custom($t->ID);
					?>
					<div class="title"><?php echo get_the_title($t->ID);?></div>
					<div class="image"><?php echo get_the_post_thumbnail( $t->ID, 'full' ); ?> </div>
					<div class="text">
						<?php echo apply_filters('the_content',$t->post_excerpt);?>
						<p class="links">
							<?php
							$args = array( 'numberposts' => 20, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 9 );
							$myposts = get_posts( $args );
							foreach ( $myposts as $s ) :
								?>
								<a href="<?php echo get_permalink($s->ID);?>"><?php echo get_the_title($s->ID);?></a>
								<?php
							endforeach;
							wp_reset_postdata();?>
						</p>
					</div>
					<?php
				endforeach;
				wp_reset_postdata();?>
			</figure>
			<figure class="col4 orange">
				<?php
				$args = array( 'numberposts' => 1, 'post_type'=> 'page', 'orderby' => 'menu_order', 'include' => 11 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $t ) : $c = get_post_custom($t->ID);
					?>
					<div class="title"><?php echo get_the_title($t->ID);?></div>
					<div class="image"><?php echo get_the_post_thumbnail( $t->ID, 'full' ); ?> </div>
					<div class="text">
						<?php echo apply_filters('the_content',$t->post_excerpt);?>
						<p class="links">
							<?php
							$args = array( 'numberposts' => 20, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 11 );
							$myposts = get_posts( $args );
							foreach ( $myposts as $s ) :
								?>
								<a href="<?php echo get_permalink($s->ID);?>"><?php echo get_the_title($s->ID);?></a>
								<?php
							endforeach;
							wp_reset_postdata();?>
						</p>
					</div>
					<?php
				endforeach;
				wp_reset_postdata();?>
			</figure>
		</div>
	</section>


<?php endwhile; // loop ?>

<?php
get_footer();