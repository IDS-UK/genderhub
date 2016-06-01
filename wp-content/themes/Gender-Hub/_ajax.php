<?php 

include('wp-load.php'); ?>

<div id="owl-demo" class="owl-carousel owl-theme">

<?php
$pt = array('blogs_opinions','events','other_training','news_stories');
if(isset($_GET['ptype']) && $_GET['ptype'] != ''):$pt =$_GET['ptype']; endif;


$args = array( 'numberposts' => 100, 'post_type'=> $pt, 'orderby' => 'post_date', 'order' => 'DESC' );
$myposts = get_posts( $args );
foreach ( $myposts as $s ) : $c = get_post_custom($s->ID);
?>
<div class="item <?php echo $s->post_type ;?>">
  <figure>
<div class="icon">
<?php if ($s->post_type == 'events'):?><img src="/wp-content/uploads/2015/05/event-icon.png" />
<?php elseif ($s->post_type == 'blogs_opinions'):?><img src="/wp-content/uploads/2015/05/blog-icon.png" />
<?php elseif ($s->post_type == 'other_training'):?><img src="/wp-content/uploads/2015/05/training-icon.png" />
<?php elseif ($s->post_type == 'news_stories'):?><img src="/wp-content/uploads/2015/05/news-icon.png" />
<?php endif;?>
</div>

$first_img = get_the_post_thumbnail( $s->ID, 'full' );
if ($first_img == '') {
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $s->post_content, $matches);
  $first_img = '<img src="'.$matches[1][0].'" />' ;
}

<div class="image"><?php echo $first_img; ?> </div>
<div class="text">
<h4><?php echo get_the_title($s->ID);?></h4>
<?php if ($s->post_excerpt != ''): echo '<p>'.$s->post_excerpt.'</p>'; else: echo '<p>'.wp_trim_words(wp_strip_all_tags(apply_filters('the_content', $s->post_content), 40), '...').'</p>'; endif;?>


</div>
<p>
<?php if ($s->post_type == 'events'): ?>
<strong>Event Date:</strong> <?php echo date('jS M',strtotime(substr($c['start_date'][0],0,4).'-'.substr($c['start_date'][0],4,2).'-'.substr($c['start_date'][0],6,2)));?> to the <?php echo date('jS M',strtotime(substr($c['end_date'][0],0,4).'-'.substr($c['end_date'][0],4,2).'-'.substr($c['end_date'][0],6,2)));?>
<?php else:?>
<strong><?php echo $c['author'][0];?></strong> <?php echo date('jS M Y',strtotime(substr($c['date_published'][0],0,4).'-'.substr($c['date_published'][0],4,2).'-'.substr($c['date_published'][0],6,2))); ?>
<?php endif;?>
</p>
<a href="<?php echo get_permalink($s->ID);?>" class="readmore">
<?php if ($s->post_type == 'events'):?>Full event details
<?php elseif ($s->post_type == 'blogs_opinions'):?>View blog post
<?php elseif ($s->post_type == 'other_training'):?>Read article
<?php elseif ($s->post_type == 'news_stories'):?>Read article
<?php endif;?>
</a>

</figure>
  </div>

<?php
 endforeach; 
wp_reset_postdata();?>

</div>

<script src="/wp-content/themes/Gender-Hub/js/owl.carousel.js"></script>

 <script>
    jQuery(document).ready(function() {
		jQuery("a.filter").click(function(){
			
			 jQuery.ajax({url: "/ajax.php?ptype="+jQuery(this).attr("rel"), success: function(result){
			jQuery("#insp").html(result);
		}});
			
			
		});
		

      var owl =jQuery("#owl-demo");

      owl.owlCarousel({

        // Define custom and unlimited items depending from the width
        // If this option is set, itemsDeskop, itemsDesktopSmall, itemsTablet, itemsMobile etc. are disabled
        // For better preview, order the arrays by screen size, but it's not mandatory
        // Don't forget to include the lowest available screen size, otherwise it will take the default one for screens lower than lowest available.
        // In the example there is dimension with 0 with which cover screens between 0 and 450px
        
        itemsCustom : [
          [0, 1],
		  [450, 1],
          [640, 2],
          [960, 4]
        
        ],
        navigation : true,
		navigationText: ["<img src='/wp-content/uploads/2015/05/arrow-left.png'>","<img src='/wp-content/uploads/2015/05/arrow-right.png'>"]

      });



    });
    </script>