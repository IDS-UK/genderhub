<?php 

include('wp-load.php');   ?>

<div id="owl-demo" class="owl-carousel owl-theme">

<?php
$pt = array('blogs_opinions','events','other_training','news_stories');

if(isset($_GET['ptype']) && $_GET['ptype'] != ''):
    $pt =$_GET['ptype'];
endif;

$args = array(
    'numberposts' => 100,
    'post_type'=> $pt,
    'orderby' => 'post_date',
    'order' => 'DESC'
);


$f = 'term_id';
$t = $topics;
if($_GET['topics'] != ''):
    $f = 'id';
    $t = $_GET['topics'];
endif;



if($t != ''):

	$args = array(
        'numberposts' => 100,
        'post_type' => $pt,
        'orderby' => 'post_date',
        'order' => 'DESC' ,
        'tax_query' => array(

            array(
                'taxonomy' => 'topics',
                'field'    => $f,
                'operator' => 'IN',
                'terms'    => $t,
		))
    );
endif;

$myposts = get_posts( $args );
foreach ( $myposts as $s ) : $c = get_post_custom($s->ID);

       setup_postdata($s);

	$img = get_the_post_thumbnail( $s->ID, 'full' ); 
	//error_log('XXX'.print_r(get_the_post_thumbnail( $s->ID, 'full' ),true).'YYY');

	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($s->ID), 'medium' );
	$url = $thumb['0'];

?>
<div class="item <?php echo (strlen($img) ? 'with-image' : 'no-image'); ?> <?php echo $s->post_type ;?>">
  <figure>
<div class="icon">
<?php if ($s->post_type == 'events'):?><img src="/wp-content/uploads/2015/05/event-icon.png" /><span> Event</span>
<?php elseif ($s->post_type == 'blogs_opinions'):?><img src="/wp-content/uploads/2015/05/blog-icon.png" /><span> Blog</span>
<?php elseif ($s->post_type == 'other_training'):?><img src="/wp-content/uploads/2015/05/training-icon.png" /><span> Training</span>
<?php elseif ($s->post_type == 'news_stories'):?><img src="/wp-content/uploads/2015/05/news-icon.png" /><span> News</span>
<?php endif;?>
</div>


<div class="item-top" style="background-image: url('<?php echo (strlen($img) ? $url : ''); ?>');">
	<div class="item-top-inner">
		<?php if (strlen($img)==0) { ?>
			<h4><span><?php echo get_the_title($s->ID);?></span></h4>
		<?php } ?>
	</div>
</div>
<div class="text">
	<?php if (strlen($img)) { ?>
		<h4><span><?php echo get_the_title($s->ID);?></span></h4>
	<?php } ?>
<?php 
$this_excerpt = wp_filter_nohtml_kses(get_the_excerpt());
echo '<p>'.get_words($this_excerpt,  (strlen($img) ? 20 : 30)).'...</p>';?>
</div>

<p class="pleftright">
<?php if ($s->post_type == 'events'): ?>
<strong>Event Date:</strong> <?php echo date('jS M',strtotime(substr($c['start_date'][0],0,4).'-'.substr($c['start_date'][0],4,2).'-'.substr($c['start_date'][0],6,2)));?> to the <?php echo date('jS M',strtotime(substr($c['end_date'][0],0,4).'-'.substr($c['end_date'][0],4,2).'-'.substr($c['end_date'][0],6,2)));?>
<?php elseif($c['date_published'][0] != ''):?>
<strong><?php echo $c['author'][0];?></strong> <?php echo date('jS M Y',strtotime(substr($c['date_published'][0],0,4).'-'.substr($c['date_published'][0],4,2).'-'.substr($c['date_published'][0],6,2))); ?>
<?php else:?>
<strong><?php echo $c['author'][0];?></strong> <?php echo get_the_date( 'jS M Y', $s->ID ); ?>
<?php endif;?>
</p>
<div class="item-link">
	<a href="<?php echo get_permalink($s->ID);?>" class="readmore">
	<?php if ($s->post_type == 'events'):?>Full event details
	<?php elseif ($s->post_type == 'blogs_opinions'):?>View blog post
	<?php elseif ($s->post_type == 'other_training'):?>Read article
	<?php elseif ($s->post_type == 'news_stories'):?>Read article
	<?php endif;?>
	</a>
</div>

</figure>
  </div>

<?php
 endforeach; 
wp_reset_postdata();?>

</div>

<script src="/wp-content/themes/Gender-Hub/js/owl.carousel.js"></script>

 <script>
    jQuery(document).ready(function() {
	
	if (jQuery(".owl-overlay").length) {} else { jQuery("#insp").append('<div class="owl-overlay"></div>');}
	jQuery(".owl-overlay").hide();
	jQuery("a.filter").click(function(){
	       jQuery(".owl-overlay").fadeIn();
       	jQuery.ajax({
                url: "/ajax.php?ptype="+jQuery(this).attr("rel"),
                success: function(result){
       		jQuery("#insp").html(result);
			jQuery(".owl-overlay").hide();
                }

            });
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