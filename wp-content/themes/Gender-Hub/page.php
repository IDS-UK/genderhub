<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */


get_header(); 

?>

<?php while ( have_posts() ) : the_post(); global $post;global  $wpdb; $custom = get_post_custom();  ?>

<?php if(is_front_page()):?>

<?php if(get_the_content() != ''): $i = 1; $tc = 0;?>
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
<?php #the_content();?>
</div></section>
<?php endif;?>
<section id="content">
<article id="inspiring">
<div class="inner blue">

<div class="paddingleftright">
<h3>What's inspiring us</h3>
<aside id="filter">
Filter: <a rel="news_stories" class="filter"><img src="/wp-content/uploads/2015/05/news-icon.png" /> News</a><a rel="other_training"  class="filter"><img src="/wp-content/uploads/2015/05/training-icon.png" /> Training</a><a rel="events" class="filter"><img src="/wp-content/uploads/2015/05/event-icon.png" /> Event</a><a rel="blogs_opinions" class="filter"><img src="/wp-content/uploads/2015/05/blog-icon.png" /> Blog</a>

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
<div class="right news"><a href="/be-inspired/news-stories/">Read more
news</a></div>




</div>
</section>
<section id="connect">
<div class="paddingleftright inner purple">
<h3>Connect and discuss</h3>
<?php



$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$oauth_access_token = "2706849379-ivqXHZFXqwPMY3QcJcKiXr3IHH1ggHpUrsD7n21";
$oauth_access_token_secret = "wxOr9YOT6D3VzPSNEV6ZvnIKrfXsYUdlO1xBRx5X6h96S";
$consumer_key = "yfgWxDx1rbt4hpPV17EWcEowW";
$consumer_secret = "jKqjAaAb2vPVD7fcxmCxKYwOsAbeIj5JC9G5CtxSmssiTHSJdd";

$oauth = array( 'oauth_consumer_key' => $consumer_key,
                'oauth_nonce' => time(),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_token' => $oauth_access_token,
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0');

$base_info = buildBaseString($url, 'GET', $oauth);
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// Make Requests
$header = array(buildAuthorizationHeader($oauth), 'Expect:');
$options = array( CURLOPT_HTTPHEADER => $header,
                  //CURLOPT_POSTFIELDS => $postfields,
                  CURLOPT_HEADER => false,
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_SSL_VERIFYPEER => false);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$twitter_data = json_decode($json);
$allitems = array();
$i = 1;
foreach($twitter_data as $tw):
if ($i < 5):

$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a href="$2" target="_blank">$2</a> ', $tw->text." ");
$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank">$2</a> ', $content." ");
$allitems[strtotime($tw->created_at)] = array('content' =>$content, 'user' => $tw->user->screen_name);

endif;
$i++;
endforeach;
$args = array( 'numberposts' => 4, 'post_type'=> 'facebook', 'orderby' => 'post_date', 'order' => 'DESC' );
$myposts = get_posts( $args );
foreach ( $myposts as $s ) : 

$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a href="$2" target="_blank">$2</a> ', $s->post_title.'<br /><br />'.$s->post_content." ");
$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank">$2</a> ', $content." ");
$text = $s->post_title.'<br /><br />'.$s->post_content;
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";


// Check if there is a url in the text
if(preg_match($reg_exUrl, $text, $url)) {
       // make the urls hyper links
	$text = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a> ', $text);
} else {
}

$allitems[strtotime($s->post_date)] = array('content' =>$text, 'user' => '');

 endforeach; 
wp_reset_postdata();

krsort($allitems);

$i = 1;
foreach($allitems as $key => $si):
	if ($i < 5):
?>
<figure class="col4">

<div class="text">
	<div class="icon">
	<?php if($si['user'] == ''):?><img src="/wp-content/uploads/2015/05/facebook-icon-large.png"/><span>Facebook post</span>
	<?php else:?><img src="/wp-content/uploads/2015/05/twitter-icon-large.png"/><span>Twitter post</span>
	<?php endif;?>
	</div>
	<p><?php echo $si['content'];?></p>
</div>
<img src="/wp-content/uploads/2015/05/bubble1.png" class="bubble"/>
<small><?php echo '<strong>@'.$si['user'].'</strong> '. date('d M Y',$key);?></small>

</figure>
<?php
endif;
$i++;
endforeach;?>

</div>
</section>
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
$args = array( 'numberposts' => 100, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 5 );
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
$args = array( 'numberposts' => 100, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 7 );
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
$args = array( 'numberposts' => 100, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 9 );
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
$args = array( 'numberposts' => 100, 'post_type'=> 'page', 'orderby' => 'menu_order', 'post_parent' => 11 );
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

<?php else: // Default page layout ?>


<h1><span><?php the_title();?></span></h1>

<div class="section group main_content">
	<div class="col span_3_of_4 archive_content padding10">
		<?php the_content();?>
	</div><!--/col span_3_of_4 padding10-->

	<div class="col span_1_of_4 padding10">
		<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "generic-sidebar" ); ?> 
	</div><!--/col span_1_of_4-->

</div>

<?php endif;?>

<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>