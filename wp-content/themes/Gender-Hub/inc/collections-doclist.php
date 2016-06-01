<?php

include('wp-load.php');   ?>

<?php
$docs_post_types = array('ids_documents', 'practical_tools','programme_alerts','other_training');



$f = 'term_id';
$t = $topics;
if($_GET['topics'] != ''):
    $t = $_GET['topics'];
endif;


	$args = array(
        'numberposts' => 100,
        'post_type' => $docs_post_types,
        'orderby' => 'post_date',
        'order' => 'DESC' ,
        'tax_query' => array(

		array(
			'taxonomy' => 'topics',
			'field'    => $f,
			'operator' => 'IN',
			'terms'    => $t,
		)) );

$myposts = get_posts( $args );
foreach ( $myposts as $s ) : $c = get_post_custom($s->ID);

?>
<div class="item <?php echo $s->post_type ;?>">
  <figure>

<div>
<h4><?php echo get_the_title($s->ID);?></h4>


</div>


</figure>
  </div>

<?php
 endforeach; 
wp_reset_postdata();?>


 <script>
    jQuery(document).ready(function() {



		jQuery("a.docfilter").click(function(){

            var loc = '/wp-content/themes/Gender-Hub/inc/collections-doclist.php';
            jQuery.ajax({
                url: loc+"?"+jQuery(this).attr("rel"),
                success: function(result){
                    jQuery("#docs").html(result);
                }

            });
        });






    });
    </script>