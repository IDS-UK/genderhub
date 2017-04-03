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

    <section id="slider">

        <div class="inner paddingleftright">

            <ul id="lightSlider">

                <?php echo GenderHub_2017::gh_get_slider_posts('programme_alerts'); ?>

            </ul>

        </div>

    </section>

	<section id="content">

		<article id="inspiring">

            <div class="inner blue">

                <div class="paddingleftright">

                    <h3>What's inspiring us</h3>

                    <?php echo GenderHub_2017::gh_get_carousel(array('blogs_opinions','events','other_training','news_stories', 'interviews'), $topics=null, $exclude=null, true); ?>

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