<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage GenderHub
 * @since GenderHub 1.0
 */
global $post;
global $wpdb;
$c = get_post_custom($post->ID);
#echo $post->ID;
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link href='http://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

<link rel='stylesheet'  href='/wp-content/themes/Gender-Hub/style.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet'  href='/wp-content/themes/Gender-Hub/css/lightslider.css?ver=1.0' type='text/css' media='all' />
<script src="/wp-content/themes/Gender-Hub/js/lightslider.js"></script>
<script type="text/javascript">

jQuery(document).ready(function() {
	jQuery("#slider li.active").fadeIn();
	jQuery("#lightSlider").lightSlider({
		gallery:true,
		item:1,
		//vertical:true,
		//verticalHeight:500,
		//vThumbWidth:200,
		thumbItem:6,
		thumbMargin:4,
		thumbWidth:100,
		thumbItem:6,
		thumbMargin:4,
		slideMargin:0
		}); 
	jQuery("#slider li.lslide").fadeIn();
	
 
}); 

  </script>
</head>

<body <?php body_class();?>>

<!---h3 style="background: red; color:#fff; position: fixed; padding: 10px;font-weight: bold; z-index: 10000; left: 50%; top: 10%; text-align; center; opacity: 0.7;" >NEW LIVE SITE</h3--->
<header class="site">
<div class="inner paddingright">
<?php
$args = array( 'numberposts' => 1, 'post_type'=> 'blocks', 'orderby' => 'menu_order', 'include' => 11640 );
$t = get_post(30288);
$c = get_post_custom($t->ID);

?>

<?php echo $t->post_content; echo $c['_secondary_html_30294'][0];?><span class="strapline"><?php echo $c['_secondary_html_30295'][0];?></span><?php echo $c['_secondary_html_30296'][0];?>
<form action="/" id="searchform" method="get" ><input type="text" name="s" id="s" placeholder="Search"></form>
<?php

wp_reset_postdata();?>
<a class="menuicon">
	  <div class="hamburger">
	    <div class="menui top-menu"></div>
	    <div class="menui mid-menu"></div>
	    <div class="menui bottom-menu"></div>
	  </div>
	</a>
</div>

</header>
<nav class=""><div class="inner paddingleftright"><?php wp_nav_menu( array('menu' => 'Main Sections Menu'));?></div></nav>

<?php if(!is_front_page()):?>
<section id="main">

<div class="inner ">
<div class="paddingleftright">
<?php endif;?>

