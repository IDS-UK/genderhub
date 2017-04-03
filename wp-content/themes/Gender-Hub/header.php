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

$main_options = get_option( 'gh_custom_main_settings' );
$header_options = get_option( 'gh_custom_header_settings' );

$logo = !empty( $main_options['gh_site_logo'] ) ? '<img src="'.$main_options['gh_site_logo'].'" />' : $logo = get_bloginfo('name');
$strapline = !empty( $header_options['gh_strapline'] ) ? wpautop($header_options['gh_strapline']) : $strapline = '';
$social_media_links = method_exists('GH_Site_Settings', 'gh_social_media_links') ? GH_Site_Settings::gh_social_media_links() : NULL;

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
	<?php wp_head(); ?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->
</head>

<body <?php body_class();?>>
<!---h3 style="background: red; color:#fff; position: fixed; padding: 10px;font-weight: bold; z-index: 10000; left: 50%; top: 10%; text-align; center; opacity: 0.7;" >NEW LIVE SITE</h3--->
    <header class="site">
    <div class="inner paddingleftright">

        <a href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-home.png" class="home-icon" /></a>
        <a href="<?php echo home_url(); ?>" class="site-logo"><?php echo $logo; ?></a>
        <span class="strapline"><?php echo $strapline;?></span>
        <?php echo $social_media_links; ?>
        <a id="searchicon"><img class="header-search" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-search.png" alt="search icon" width="18" height="18"></a>
        <form action="/" id="searchform" method="get" ><input type="text" name="s" id="s" placeholder="Search"><input type="hidden" name="search_loc" value="all" /><input type="submit" value="Go" /></form>

        <a class="menuicon">
            <div class="hamburger">
                <div class="menui top-menu"></div>
                <div class="menui mid-menu"></div>
                <div class="menui bottom-menu"></div>
            </div>
        </a>
    </div>

</header>

<nav class="">
    <div class="inner paddingleftright">
        <?php
        if ( has_nav_menu( 'primary' ) ) :
	        wp_nav_menu( array( 'theme_location' => 'primary' ) );
        else :
	        wp_nav_menu( array('menu' => 'Main Sections Menu'));
        endif;
        ?>
    </div>
</nav>

<?php if(!is_front_page()):?>
<section id="main">

<div class="inner ">
<div class="paddingleftright">
<?php endif;?>