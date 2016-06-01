<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */
?>
<?php if(!is_front_page()):?>
</div>
</div>

</section>
<?php endif;?>
<footer>
<div class="paddingleftright inner outer">
<?php

$t = get_post(30290);
$c = get_post_custom($t->ID);

?>
<div class="col4"><?php echo $t->post_content;?></div>
<div class="col4"><?php echo $c['_secondary_html_30294'][0];?></div>
<div class="col4 more"><?php echo $c['_secondary_html_30295'][0];?></div>
<div class="col4 more"><?php echo $c['_secondary_html_30296'][0];?></div>
<div class="col4"><?php echo $c['_secondary_html_30297'][0];?></div>
<?php wp_reset_postdata();?>

</div>
</footer>



<?php
wp_footer();?>
<script type="text/javascript">
jQuery( "nav li a" ).not( "nav li li a" ).each(function( index ) {
jQuery( this ).attr('href','#');
});
jQuery('#searchicon').click(function(){
jQuery('#searchform	').toggleClass('active');
});
jQuery('.menuicon').click(function(){
jQuery('nav').toggleClass('active');
jQuery('nav').toggleClass('mobnav');
});

jQuery( "nav li a" ).not( "nav li li a" ).click(function( event ) {
  event.preventDefault();
  
 

});


jQuery( "#arealinks .col4" ).click(function(){
	jQuery(this).toggleClass('active');
});
jQuery( "nav.mobnav li" ).click(function(){
	jQuery(this).toggleClass('active');
});
jQuery( "header" ).hover(function(){
jQuery( "nav li" ).removeClass('active');
});
jQuery( "nav li" ).not( "nav li li, nav.mobnav li" ).hover(function(){
     jQuery(this).addClass('active');
    }, function(){
    
 jQuery(this).removeClass('active');
    });

       jQuery( "nav" ).not( "nav.mobnav" ).hover(function(){
      jQuery('nav').toggleClass('active');
    }, function(){
    
 jQuery('nav').toggleClass('active');
    });
</script>
</body>
</html>