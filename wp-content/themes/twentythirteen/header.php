<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	
	 <!-- styles -->
    <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
    
    
	<?php wp_head(); ?>
	
	
	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php echo site_url(); ?>/favicon.ico">
	
	<!-- non-retina iPhone pre iOS 7 -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-57x57.png">
	<!-- non-retina iPad pre iOS 7 -->
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-72x72.png">
	<!-- non-retina iPad iOS 7 -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-76x76.png">
	<!-- retina iPhone pre iOS 7 -->
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-114x114.png">
	<!-- retina iPhone iOS 7 -->
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-120x120.png">
	<!-- retina iPad pre iOS 7 -->
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-144x144.png">
	<!-- retina iPad iOS 7 -->
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon-152x152.png">
	
	
	
	
	
</head>

<body>
	
	
	 <div id="container">
  



	<div class="section group banner">
	
	
	
	<!--SEARCH BAR-------------------------------------------------------------->
	<div class="section group searchbar">
	
		<div class="innerpage">
				
				<?php if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "search-sidebar" ); ?> 
	
			
		</div><!--/innerpage-->
	</div><!--/section group-->
	
	
	
	
	
	<!--LOGO + NAV BAR-------------------------------------------------------------->
	<div class="section group navbar">
		<div class="innerpage">
	
		<div class="col nomargin span_1_of_4">
		<a class="logo" href="<?php echo site_url(); ?>"><img alt="Gender Hub" src="<?php echo get_stylesheet_directory_uri(); ?>/images/GenderHub_Logo.png" /></a>
		</div><!--/col span_1_of_4-->
		
		
		<div class="col nomargin span_3_of_4">
		<nav class="access" role="navigation">				
		<!-- Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. -->
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
</nav><!-- #access -->
		</div><!--/col span_3_of_4-->
		
		
		</div><!--/innerpage-->
	</div><!--/section group-->
	
	
	
	


	</div><!--/section group banner-->
	
	
	


	<div id="page_content">
