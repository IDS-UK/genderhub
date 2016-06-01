<?php
//Twitter Fuctions
function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
$r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}
function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
$values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}
//Twitter Fuctions End

// Generic functiona and theme options
function get_words($sentence, $count = 30) {
  preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
  return $matches[0];
}
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
   add_post_type_support( 'page', 'excerpt' );
}

function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since GenderHub 1.0
 */




// Generic functions and theme options end

// Custom post types end
//add_action("admin_init", "admin_initB");
// stop error message for incorrect logins
add_filter('login_errors',create_function('$a', "return null;"));

// Only load contact form 7 css and js on pages where it is needed
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

function genderhub_scripts() {
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/genderhub.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'genderhub_scripts' );

// change comments template title
function comment_reform ($arg) {
  $arg['title_reply'] = __('Comment on this');
  return $arg;
}
add_filter('comment_form_defaults','comment_reform');

// current page url
function current_page_url() {
  $pageURL = 'http';
  if( isset($_SERVER["HTTPS"]) ) {
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  }
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}
/**
* STOP WORDPRESS publishing version info
*/
remove_action('wp_head','wp_generator');

/**
* Custom CSS for WYSIWYG Editor – TinyMCE
*/
add_editor_style('css/editor-style.css');

// paging nav
if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
* Display navigation to next/previous set of posts when applicable.
*
* @since Twenty Thirteen 1.0
*/
function twentythirteen_paging_nav() {
  global $wp_query;

  // Don't print empty markup if there's only one page.
  if ( $wp_query->max_num_pages < 2 )
  return;
  ?>
  <nav class="navigation paging-navigation" role="navigation">
  <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
  <div class="nav-links">

  <?php if ( get_next_posts_link() ) : ?>
  <div class="nav-previous"><?php next_posts_link( __( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowL.png" /><br />  Older posts', 'twentythirteen' ) ); ?></div>
  <?php endif; ?>

  <?php if ( get_previous_posts_link() ) : ?>
  <div class="nav-next"><?php previous_posts_link( __( '<img class="prev_next_arrows" alt=Next Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />Newer posts', 'twentythirteen' ) ); ?></div>
  <?php endif; ?>

  </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;

if ( ! function_exists( 'twentythirteen_post_nav' ) ) :
/**
* Display navigation to next/previous post when applicable.
** @since Twenty Thirteen 1.0
*/
function twentythirteen_post_nav() {
  global $post;

  // Don't print empty markup if there's nowhere to navigate.
  $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $previous )
  return;
  ?>
  <nav class="navigation post-navigation" role="navigation">
      <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'twentythirteen' ); ?></h1>
      <div class="nav-links">
    
      <?php previous_post_link( '%link', _x( '<img class="prev_next_arrows" alt="Previous Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowL.png" /><br /> %title', 'Previous post link', 'twentythirteen' ) ); ?>
      <?php next_post_link( '%link', _x( '<img class="prev_next_arrows" alt=Next Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />%title ', 'Next post link', 'twentythirteen' ) ); ?>
    
      </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;

// Numbered Pagination
if ( !function_exists( 'genderhub_pagination' ) ) {
  function genderhub_pagination() {  
    $prev_arrow = is_rtl() ? '' : '&larr;';
    $next_arrow = is_rtl() ? '' : '&rarr;';    
    global $wp_query;
    $total = $wp_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    if( $total > 1 )  {
      if( !$current_page = get_query_var('paged') )
$current_page = 1;
      if( get_option('permalink_structure') ) {
$format = 'page/%#%/';
      } else {
$format = '&paged=%#%';
      }
      echo paginate_links(array(
      'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format'		=> $format,
      'current'		=> max( 1, get_query_var('paged') ),
      'total' 		=> $total,
      'mid_size'		=> 3,
      'type' 			=> 'list',
      'prev_text'		=> $prev_arrow,
      'next_text'		=> $next_arrow,
      ) );
    }
  }
}

// canonical urls for comments to avoid duplicate content

function canonical_for_comments() {
  global $cpage, $post;
  if ( $cpage > 1 ) :
	  echo "n";
	  echo "<link rel='canonical' href='";
	  echo get_permalink( $post->ID );
	  echo "' />n";
  endif;
}
add_action( 'wp_head', 'canonical_for_comments' );

// Add Formats Dropdown Menu To MCE
if ( ! function_exists( 'genderhub_style_select' ) ) {
  function genderhub_style_select( $buttons ) {
    array_push( $buttons, 'styleselect' );
    return $buttons;
  }
}
add_filter( 'mce_buttons', 'genderhub_style_select' );

// Add new styles to the TinyMCE "formats" menu dropdown
if ( ! function_exists( 'genderhub_styles_dropdown' ) ) {
  function genderhub_styles_dropdown( $settings ) {

    // Create array of new styles
    $new_styles = array(
    array(
    'title'	=> __( 'Custom Styles', 'genderhub' ),
    'items'	=> array(
    array(
    'title'		=> __('Button','genderhub'),
    'selector'	=> 'a',
    'classes'	=> 'button'
    ),
    array(
    'title'		=> __('Highlight','genderhub'),
    'inline'	=> 'span',
    'classes'	=> 'highlight',
    ),
    ),
    ),
    );

    // Merge old & new styles
    $settings['style_formats_merge'] = true;

    // Add new styles
    $settings['style_formats'] = json_encode( $new_styles );

    // Return New Settings
    return $settings;

  }
}
add_filter( 'tiny_mce_before_init', 'genderhub_styles_dropdown' );

// recent posts shortcode
function my_recent_posts_shortcode( $atts ) {
  extract( shortcode_atts( array( 'limit' => 5 ), $atts ) );

  return '<ul class="my-recent-posts">' . wp_get_archives('type=postbypost&limit=' . $limit . '&echo=0') . '</ul>';
}
add_shortcode( 'recent-posts', 'my_recent_posts_shortcode' );

// Change login page logo

function my_custom_login_logo() {
  echo '<style type="text/css">
h1 a { background-image:url("http://www.genderhub.org/wp-content/themes/genderhub/images/GenderHub_login.gif") !important; }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'google_fonts' );
function google_fonts() {
  wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic', array(), 20131111 );
}//* CSS Style for Google fonts - font-family: 'Asap', sans-serif;

//* Enqueue font-awesome fonts
add_action( 'wp_enqueue_scripts', 'prefix_enqueue_awesome' );
/**
* Register and load font awesome CSS files using a CDN.
*
* @link   http://www.bootstrapcdn.com/#fontawesome
* @author FAT Media
*/
function prefix_enqueue_awesome() {
  wp_enqueue_style( 'prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.1' );
  
    function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
}// Add new image sizes
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );
add_action( 'after_setup_theme', 'setup' );  
function setup() {
  // ...  


  add_theme_support( 'menus' );
  add_theme_support( 'post-thumbnails' ); // This feature enables post-thumbnail support for a theme  
  // To enable only for posts:  
  //add_theme_support( 'post-thumbnails', array( 'post' ) );  
  // To enable only for posts and custom post types:  
  //add_theme_support( 'post-thumbnails', array( 'post', 'movie' ) );  
  // Register a new image size.  
  // This means that WordPress will create a copy of the post image with the specified dimensions  
  // when you upload a new image. Register as many as needed.  
  // Adding custom image sizes (name, width, height, crop)  
  add_image_size( 'square_220', 220, 220, true ); //(cropped)
  add_image_size( 'square_120', 120, 120, true ); //(cropped)
  add_image_size( 'custom-thumb', 220, 180, true ); // 220 pixels wide by 180 pixels tall, soft proportional crop mode
  add_image_size( 'gallery', 720, 362, true );
  add_image_size( 'gallery-thumb', 80, 50, true );
  add_image_size( 'box', 237, 155, true );
  add_image_size ( 'collection', 300, 200, false);
  add_image_size ( 'blog_featured', 500, 300);
// ...  
}

add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );  
function custom_image_sizes_choose( $sizes ) {  
  $custom_sizes = array(  
  'square_220' => 'square_220px' ,
  'square_120' => 'square_120px'
  );  
  return array_merge( $sizes, $custom_sizes );  
}

// Stop multiple image sizes
//add_filter('intermediate_image_sizes_advanced', 'filter_image_sizes');
//function filter_image_sizes( $sizes) {
//   unset( $sizes['medium']);
//   unset( $sizes['large']);
//   return $sizes;
// }

/*enable custom menu //////*/

// This theme uses wp_nav_menu() in one location.

function GenderHubChild_setup() {
  register_nav_menu( 'primary', __( 'Primary Menu', 'GenderHubChild' ) );
  register_nav_menu( 'secondary', __( 'Second Menu', 'GenderHubChild' ) );
}
add_action( 'after_setup_theme', 'GenderHubChild_setup' );

// Truncates the blog page post content

function my_excerpt_length($length) {
  return 55;
}
add_filter('excerpt_length', 'my_excerpt_length');

/*remove image p tags //////*/

function filter_ptags_on_images($content){
  return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

function GenderHubChild_widgets_init() {
  register_sidebar( array(
  'name' => __( 'Generic Sidebar', 'GenderHubChild' ),
  'id' => 'generic-sidebar',
  'description' => __( 'generic-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Events Sidebar', 'GenderHubChild' ),
  'id' => 'events-sidebar',
  'description' => __( 'events-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Training Sidebar', 'GenderHubChild' ),
  'id' => 'training-sidebar',
  'description' => __( 'training-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Blogs Sidebar', 'GenderHubChild' ),
  'id' => 'blogs-sidebar',
  'description' => __( 'blogs-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Alerts Sidebar', 'GenderHubChild' ),
  'id' => 'alerts-sidebar',
  'description' => __( 'alerts-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'News Sidebar', 'GenderHubChild' ),
  'id' => 'news-sidebar',
  'description' => __( 'news-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Search Sidebar', 'GenderHubChild' ),
  'id' => 'search-sidebar',
  'description' => __( 'search-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Knowledge Sidebar', 'GenderHubChild' ),
  'id' => 'knowledge-sidebar',
  'description' => __( 'knowledge-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Build Capacity Sidebar', 'GenderHubChild' ),
  'id' => 'build-capacity-sidebar',
  'description' => __( 'build-capacity-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Collection Sidebar', 'GenderHubChild' ),
  'id' => 'collection-sidebar',
  'description' => __( 'collection-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Connect and Discuss Content', 'GenderHubChild' ),
  'id' => 'connect-discuss-content',
  'description' => __( 'connect-discuss-content', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Connect and Discuss Sidebar', 'GenderHubChild' ),
  'id' => 'connect-discuss-sidebar',
  'description' => __( 'connect-discuss-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Inspiration Sidebar', 'GenderHubChild' ),
  'id' => 'inspiration-sidebar',
  'description' => __( 'inspiration-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Footer 1', 'GenderHubChild' ),
  'id' => 'footer-1',
  'description' => __( 'footer-1', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Footer 2', 'GenderHubChild' ),
  'id' => 'footer-2',
  'description' => __( 'footer-2', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Footer 3', 'GenderHubChild' ),
  'id' => 'footer-3',
  'description' => __( 'footer-3', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Footer 4', 'GenderHubChild' ),
  'id' => 'footer-4',
  'description' => __( 'footer-4', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Sub Footer', 'GenderHubChild' ),
  'id' => 'subfooter',
  'description' => __( 'subfooter', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );
  register_sidebar( array(
  'name' => __( 'Test Sidebar', 'GenderHubChild' ),
  'id' => 'test-sidebar',
  'description' => __( 'test-sidebar', 'GenderHubChild' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h3 class="widget-title white">',
  'after_title' => '</h3>',
  ) );  

}
add_action( 'widgets_init', 'GenderHubChild_widgets_init' );

// Register Custom Post Types

add_action('init', 'blocks_register');
 
function blocks_register() {
 
	$labels = array(
		'name' => _x('Blocks', 'post type general name'),
		'singular_name' => _x('Block Item', 'post type singular name'),
		'add_new' => _x('Add New', 'Block item'),
		'add_new_item' => __('Add New Block Item'),
		'edit_item' => __('Edit Block Item'),
		'new_item' => __('New Block Item'),
		'view_item' => __('View Block Item'),
		'search_items' => __('Search Block'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon'   => '/wp-content/uploads/2015/07/block-icon.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail', 'page-attributes')
	  ); 
 
	register_post_type( 'blocks' , $args );
}

//add_action('init', 'collection_register');
// slkr - collection post type moved to plugin (as it should be!)
// slkr - todo: move all other CPTs to plugin!

add_action('init', 'facebook_register');
 
function facebook_register() {
 
	$labels = array(
		'name' => _x('Facebook', 'post type general name'),
		'singular_name' => _x('Facebook Item', 'post type singular name'),
		'add_new' => _x('Add New', 'Facebook item'),
		'add_new_item' => __('Add New Facebook Item'),
		'edit_item' => __('Edit Facebook Item'),
		'new_item' => __('New Facebook Item'),
		'view_item' => __('View Facebook Item'),
		'search_items' => __('Search Facebook'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon'   => '/wp-content/uploads/2015/07/facebook-icon.png',
		
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'hierarchical'=> true,
	  'rewrite' => false,
	  'public'      => true,
	  'show_ui'     => true,
	  'show_in_menu'=> true,
	  'show_in_nav_menus'   => true,
	  'show_in_admin_bar'   => true,
	
	 
	  'can_export'  => true,
	  'has_archive' => true,
	  'exclude_from_search' => false,
	  'publicly_queryable'  => true,
		'supports' => array('title','editor','thumbnail', 'page-attributes','comments')
	  ); 
 
	register_post_type( 'facebook' , $args );
}

/// Register Custom Post Type
function contact_point_post_type() {

  $labels = array(
  'name'=> _x( 'Contact Points', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Contact Point', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Contact Point', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'contact_point', 'text_domain' ),
  'description' => __( 'Contact Point Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'custom-fields', 'post-formats', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
  'hierarchical'=> true,
  //'rewrite' => array( 'slug'  => 'connect-and-discuss/join-the-conversation' ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 5,
  'menu_icon'   => 'http://genderhub.org/wp-content/themes/genderhub/images/contactpoint_icons16.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'contact_point', $args );

}

// Hook into the 'init' action
add_action( 'init', 'contact_point_post_type', 0 );

function custom_rewrite_basic() {
  add_rewrite_rule('^csw60/?', 'index.php?page_id=30914', 'top');
}
add_action('init', 'custom_rewrite_basic');

// Programme alerts
function programme_alerts_post_type() {

  $labels = array(
  'name'=> _x( 'Programme Alerts', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Programme Alert', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Programme Alerts', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'programme-alerts', 'text_domain' ),
  'description' => __( 'Programme Alert Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'be-inspired/programme-alerts'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 6,
  'menu_icon'   => '/wp-content/uploads/2015/06/bell-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'programme_alerts', $args );

}

// Hook into the 'init' action
add_action( 'init', 'programme_alerts_post_type', 0 );

// Blogs + Opinions
function blogs_opinions_post_type() {

  $labels = array(
  'name'=> _x( 'Blogs & Opinions', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Blogs & Opinions', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Blogs & Opinions', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'blogs-opinions', 'text_domain' ),
  'description' => __( 'Blogs & Opinions Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes', 'topics' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'be-inspired/blogs-opinion'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 7,
  'menu_icon'   => '/wp-content/uploads/2015/05/blog-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'blogs_opinions', $args );

}

// Hook into the 'init' action
add_action( 'init', 'blogs_opinions_post_type', 0 );

// Events
function events_post_type() {

  $labels = array(
  'name'=> _x( 'Events', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Events', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'Events', 'text_domain' ),
  'description' => __( 'Events Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes', 'topics' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'build-capacity/events'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 8,
  'menu_icon'   => '/wp-content/uploads/2015/05/event-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'events', $args );

}

// Hook into the 'init' action
add_action( 'init', 'events_post_type', 0 );

// Other Training
function other_training_post_type() {

  $labels = array(
  'name'=> _x( 'Other Training', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Other Training', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Other Training', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'Other Training', 'text_domain' ),
  'description' => __( 'Other Training Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes', 'topics' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'build-capacity/other-training'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 9,
  'menu_icon'   => '/wp-content/uploads/2015/05/training-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'other_training', $args );

}

// Hook into the 'init' action
add_action( 'init', 'other_training_post_type', 0 );

// News & Stories
function news_stories_post_type() {

  $labels = array(
  'name'=> _x( 'News & Stories', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'News & Story', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'News & Stories', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'News & Stories', 'text_domain' ),
  'description' => __( 'News & Stories Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes', 'topics' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'be-inspired/news-stories'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 10,
  'menu_icon'   => '/wp-content/uploads/2015/05/news-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'news_stories', $args );

}

// Hook into the 'init' action
add_action( 'init', 'news_stories_post_type', 0 );

function process_found_posts($posts) {
  $post_types = get_query_var('post_type');
  if (!is_admin() && is_archive() && (is_array($post_types) && in_array('practical_tools', $post_types)) ) {
    $dummy_post = new WP_Post((object)array('ID'=> 0,'post_title'   => 'Bla blah'));
    $dummy_post->post_type = 'practical_tools';
    $dummy_post->filter = 'raw';
    array_unshift($posts, $dummy_post);
  }
  return $posts;  
}
add_filter('the_posts', 'process_found_posts');
add_filter( 'default_hidden_meta_boxes', 'enable_custom_fields_per_default', 20, 1 );

function enable_custom_fields_per_default( $hidden )
{
    foreach ( $hidden as $i => $metabox )
    {
if ( 'postcustom' == $metabox )
{
    unset ( $hidden[$i] );
}
    }
    return $hidden;
}

// Change the query in practical-tools to include ids_documents.
function practical_tools_filter($query) {
  if (!is_admin() && is_post_type_archive('practical_tools')) {
    $tax_query = array(
  array(
    'taxonomy' => 'content_type',
    'field'    => 'slug',
    'terms'    => 'tool',
  ),
);
    $query->set('post_type', array('ids_documents', 'practical_tools'));
    $query->set('tax_query', $tax_query);
  }
}
add_action('pre_get_posts','practical_tools_filter');

// Practical Tools
function practical_tools_post_type() {

  $labels = array(
  'name'=> _x( 'Practical Tools', 'Post Type General Name', 'text_domain' ),
  'singular_name'       => _x( 'Practical Tool', 'Post Type Singular Name', 'text_domain' ),
  'menu_name'   => __( 'Practical Tools', 'text_domain' ),
  'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
  'all_items'   => __( 'All Items', 'text_domain' ),
  'view_item'   => __( 'View Item', 'text_domain' ),
  'add_new_item'=> __( 'Add New Item', 'text_domain' ),
  'add_new'     => __( 'Add New', 'text_domain' ),
  'edit_item'   => __( 'Edit Item', 'text_domain' ),
  'update_item' => __( 'Update Item', 'text_domain' ),
  'search_items'=> __( 'Search Item', 'text_domain' ),
  'not_found'   => __( 'Not found', 'text_domain' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
  );
  $args = array(
  'label'       => __( 'Practical Tools', 'text_domain' ),
  'description' => __( 'Practical Tools Description', 'text_domain' ),
  'labels'      => $labels,
  'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'  => array( 'category', 'post_tag', 'bridge_themes', 'gender_hub_themes' ),
  'hierarchical'=> true,
  'rewrite' => array(
  'slug'  => 'build-capacity/practical-tools'
  ),
  'public'      => true,
  'show_ui'     => true,
  'show_in_menu'=> true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 10,
  'menu_icon'   => '/wp-content/uploads/2015/06/presentation-icon.png',
  'can_export'  => true,
  'has_archive' => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
  );
  register_post_type( 'practical_tools', $args );

}

// Hook into the 'init' action
add_action( 'init', 'practical_tools_post_type', 0 );
// Register Resource Types Custom Taxonomy
function resource_type_custom_taxonomy() {

  $labels = array(
  'name'       => _x( 'Resource Types', 'Taxonomy General Name', 'text_domain' ),
  'singular_name'      => _x( 'Resource Type', 'Taxonomy Singular Name', 'text_domain' ),
  'menu_name'  => __( 'Resource Type', 'text_domain' ),
  'all_items'  => __( 'All Resource Types', 'text_domain' ),
  'parent_item'=> __( 'Parent Resource Type', 'text_domain' ),
  'parent_item_colon'  => __( 'Parent Resource Type:', 'text_domain' ),
  'new_item_name'      => __( 'New Resource Type', 'text_domain' ),
  'add_new_item'       => __( 'Add New Resource Type', 'text_domain' ),
  'edit_item'  => __( 'Edit Resource Type', 'text_domain' ),
  'update_item'=> __( 'Update Resource Type', 'text_domain' ),
  'separate_items_with_commas' => __( 'Separate Resource Types with commas', 'text_domain' ),
  'search_items'       => __( 'Search Resource Types', 'text_domain' ),
  'add_or_remove_items'=> __( 'Add or remove Resource Types', 'text_domain' ),
  'choose_from_most_used'      => __( 'Choose from the most used Resource Types', 'text_domain' ),
  'not_found'  => __( 'Not Found', 'text_domain' ),
  );
  $args = array(
  'labels'     => $labels,
  'hierarchical'       => false,
  'public'     => true,
  'show_ui'    => true,
  'show_admin_column'  => true,
  'show_in_nav_menus'  => true,
  'show_tagcloud'      => true,
  );
  register_taxonomy( 'resource_type', array( 'ids_documents' ), $args );

}



// Hook into the 'init' action
add_action( 'init', 'resource_type_custom_taxonomy', 0 );

// Register Collection Custom Taxonomy
function topics_custom_taxonomy() {

  $labels = array(
  'name'       => _x( 'Topics', 'Taxonomy General Name', 'text_domain' ),
  'singular_name'      => _x( 'Topic', 'Taxonomy Singular Name', 'text_domain' ),
  'menu_name'  => __( 'Topics', 'text_domain' ),
  'all_items'  => __( 'All Topics', 'text_domain' ),
  'parent_item'=> __( 'Parent Topic', 'text_domain' ),
  'parent_item_colon'  => __( 'Parent Topic:', 'text_domain' ),
  'new_item_name'      => __( 'New Topic', 'text_domain' ),
  'add_new_item'       => __( 'Add New Topic', 'text_domain' ),
  'edit_item'  => __( 'Edit Topic', 'text_domain' ),
  'update_item'=> __( 'Update Topic', 'text_domain' ),
  'separate_items_with_commas' => __( 'Separate Topics with commas', 'text_domain' ),
  'search_items'       => __( 'Search Topics', 'text_domain' ),
  'add_or_remove_items'=> __( 'Add or remove Topic', 'text_domain' ),
  'choose_from_most_used'      => __( 'Choose from the most used Topics', 'text_domain' ),
  'not_found'  => __( 'Not Found', 'text_domain' ),
  );
  $args = array(
  'labels'     => $labels,
  'hierarchical'       => true,
  'public'     => true,
  'show_ui'    => true,
  'show_admin_column'  => true,
  'show_in_nav_menus'  => true,
  'show_tagcloud'      => true,
  );
  register_taxonomy( 'topics', array( 'ids_documents','contact_point','events','blogs_opinions','other_training','programme_alerts','practical_tools','news_stories','collections' ), $args );

}
// Hook into the 'init' action
add_action( 'init', 'topics_custom_taxonomy', 0 );

global $wp_taxonomies;
if( isset( $wp_taxonomies[ 'collections' ] ) ) {

    unset( $wp_taxonomies[ 'collections' ] );
}



function content_type_custom_taxonomy() {

  $labels = array(
  'name'       => _x( 'Content Types', 'Taxonomy General Name', 'text_domain' ),
  'singular_name'      => _x( 'Content Type', 'Taxonomy Singular Name', 'text_domain' ),
  'menu_name'  => __( 'Content Type', 'text_domain' ),
  'all_items'  => __( 'All Content Types', 'text_domain' ),
  'parent_item'=> __( 'Parent Content Type', 'text_domain' ),
  'parent_item_colon'  => __( 'Parent Content Type:', 'text_domain' ),
  'new_item_name'      => __( 'New Content Type', 'text_domain' ),
  'add_new_item'       => __( 'Add New Content Type', 'text_domain' ),
  'edit_item'  => __( 'Edit Content Type', 'text_domain' ),
  'update_item'=> __( 'Update Content Type', 'text_domain' ),
  'separate_items_with_commas' => __( 'Separate Content Types with commas', 'text_domain' ),
  'search_items'       => __( 'Search Content Types', 'text_domain' ),
  'add_or_remove_items'=> __( 'Add or remove Content Types', 'text_domain' ),
  'choose_from_most_used'      => __( 'Choose from the most used Content Types', 'text_domain' ),
  'not_found'  => __( 'Not Found', 'text_domain' ),
  );
  $args = array(
  'labels'     => $labels,
  'hierarchical'       => false,
  'public'     => true,
  'show_ui'    => true,
  'show_admin_column'  => true,
  'show_in_nav_menus'  => true,
  'show_tagcloud'      => true,
  );
  register_taxonomy( 'content_type', array( 'events', 'other_training', 'news_stories', 'blogs_opinions', 'programme_alerts', 'contact_point','practical_tools','ids_documents' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'content_type_custom_taxonomy', 0 );
// Register Attribution Custom Taxonomy
function attribution_custom_taxonomy() {

  $labels = array(
  'name'       => _x( 'Attribution', 'Taxonomy General Name', 'text_domain' ),
  'singular_name'      => _x( 'Attribution', 'Taxonomy Singular Name', 'text_domain' ),
  'menu_name'  => __( 'Attribution', 'text_domain' ),
  'all_items'  => __( 'All sources', 'text_domain' ),
  'parent_item'=> __( 'Parent Attribution', 'text_domain' ),
  'parent_item_colon'  => __( 'Parent Attribution:', 'text_domain' ),
  'new_item_name'      => __( 'New attribution information', 'text_domain' ),
  'add_new_item'       => __( 'Add New Attribution information', 'text_domain' ),
  'edit_item'  => __( 'Edit Attribution', 'text_domain' ),
  'update_item'=> __( 'Update Attribution', 'text_domain' ),
  'separate_items_with_commas' => __( 'Separate Attribution with commas', 'text_domain' ),
  'search_items'       => __( 'Search Attribution', 'text_domain' ),
  'add_or_remove_items'=> __( 'Add or remove Attribution', 'text_domain' ),
  'choose_from_most_used'      => __( 'Choose from the most used Attribution information', 'text_domain' ),
  'not_found'  => __( 'GenderHub', 'text_domain' ),
  );
  $args = array(
  'labels'     => $labels,
  'hierarchical'       => true,
  'public'     => true,
  'show_ui'    => true,
  'show_admin_column'  => true,
  'show_in_nav_menus'  => false,
  'show_tagcloud'      => false,
  );
  register_taxonomy( 'attribution', array( 'ids_documents', 'practical_tools' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'attribution_custom_taxonomy', 0 );
add_filter( 'pre_get_posts', 'genderhub_cpt_search' );
/**
* This function modifies the main WordPress query to include an array of post types instead of the default 'post' post type.
*
* @param mixed $query The original query
* @return $query The amended query
*/
function genderhub_cpt_search( $query ) {
  if ( !is_admin() && $query->is_search() )
  $query->set('post_type', array( 'post', 'news_stories', 'other_training', 'events', 'blogs_opinions', 'programme_alerts', 'contact_point', 'practical_tools' ));
  return $query;
};

add_filter( 'posts_search', 'whole_words_search', 20, 2 );
function whole_words_search( $search, $wp_query ) {
  global $wpdb;
  if ( empty( $search ) )
    return $search;
  $q = $wp_query->query_vars;
  $n = !empty( $q['exact'] ) ? '' : '%';
  $search = $searchand = '';
  foreach ( (array) $q['search_terms'] as $term ) {
    $term = esc_sql( like_escape( $term ) );
    $search .= "{$searchand}($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]') OR ($wpdb->posts.post_content REGEXP '[[:<:]]{$term}[[:>:]]')";
    $searchand = ' AND ';
  }
  if ( ! empty( $search ) ) {
    $search = " AND ({$search}) ";
    if ( ! is_user_logged_in() )
      $search .= " AND ($wpdb->posts.post_password = '') ";
  }
  return $search;
}

// Add IDS Import categories in the edit.php post columns
add_filter('manage_events_posts_columns', 'idsimport_posts_columns');
add_action('manage_events_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_news_stories_posts_columns', 'idsimport_posts_columns');
add_action('manage_news_stories_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_contact_point_posts_columns', 'idsimport_posts_columns');
add_action('manage_contact_point_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_programme_alerts_posts_columns', 'idsimport_posts_columns');
add_action('manage_programme_alerts_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_blogs_opinions_posts_columns', 'idsimport_posts_columns');
add_action('manage_blogs_opinions_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_other_training_posts_columns', 'idsimport_posts_columns');
add_action('manage_other_training_posts_custom_column', 'idsimport_populate_posts_columns');

add_filter('manage_practical_tools_posts_columns', 'idsimport_posts_columns');
add_action('manage_practical_tools_posts_custom_column', 'idsimport_populate_posts_columns');

// Ultimate WP Query Search Filter heirarchy in drop downs + POST COUNT
//Display parent categories only

add_filter('uwpqsf_taxonomy_arg', 'custom_term_output','',1);
function custom_term_output($args){
  $args['parent'] = '0';
  return $args;
}

//MODIFY TAXFIELD DROPDOWN OUTPUT TO IDENTIFY AND STYLE CHILD CATEGORIES
add_filter('uwpqsf_tax_field_dropdown','custom_dropdown_output','',12);
function custom_dropdown_output($html,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass,$eid=''){
  $args = array('hide_empty'=>$hide,'exclude'=>$eid );
  $taxoargs = apply_filters('uwpqsf_taxonomy_arg',$args,$taxname,$formid);
  $terms = get_terms($taxname,$taxoargs); $count = count($terms);
  if($type == 'dropdown'){
    $html  = '<div class="'.$defaultclass.' '.$divclass.' tax-select-'.$c.'"><span class="taxolabel-'.$c.'">'.$taxlabel.'</span>';
    $html .= '<input  type="hidden" name="taxo['.$c.'][name]" value="'.$taxname.'">';
    $html .= '<input  type="hidden" name="taxo['.$c.'][opt]" value="'.$opt.'">';
    $html .=  '<select id="tdp-'.$c.'" name="taxo['.$c.'][term]">';
    if(!empty($taxall)){
      $html .= '<option selected value="uwpqsftaxoall">'.$taxall.'</option>';
    }
    if ( $count > 0 ){
      $terms = apply_filters('nyasro_dropdown_sort', $terms, $taxname ); //nyasro added filter
      foreach ( $terms as $term ) {
$term_obj = get_term( $term->term_id, $taxname );
				$selected = (isset($_GET['taxo'][$c]['term']) && $_GET['taxo'][$c]['term'] == $term->slug) ? 'selected="selected"' : '';
  			$html .= '<option value="'.$term->slug.'" '.$selected.'>'.$term->name.' ('.$term_obj->count.' documents)</option>';

$args = array(
'hide_empty'    => true,
'hierarchical'  => true,
'parent'=> $term->term_id
);
$childterms = get_terms($taxname, $args);

foreach ( $childterms as $childterm ) {
  $selected = (isset($_GET['taxo'][$c]['term']) && $_GET['taxo'][$c]['term'] == $childterm->slug) ? 'selected="selected"' : '';
  $term_obj = get_term( $childterm->term_id, $taxname );
  $html .= '<option value="'.$childterm->slug.'" '.$selected.'> &nbsp;&nbsp; - &nbsp;'  . $childterm->name . ' ('.$term_obj->count.' documents)</option>';

}}
    }
    $html .= '</select>';
    $html .= '</div>';
    return $html;
  }

}

// add post count to search drop downs - Ultimate WP Query Search Filter
// http://9-sec.com/support-forum/?mingleforumaction=viewtopic&t=221


// add query terms to search results - Ultimate WP Query Search Filter

add_filter( 'get_search_query', 'uwpqsf_var', 20, 1 );
function uwpqsf_var($s){
  if(is_search() && isset($_GET['s']) && $_GET['s'] == 'uwpsfsearchtrg' && isset($_GET['uformid']) ){
    if(isset($_GET['taxo'])){
      foreach($_GET['taxo'] as $v){
if(isset($v['term'])){
  if($v['term'] == 'uwpqsftaxoall'){

  }else{
    $termname = get_term_by('slug',$v['term'],$v['name']);
    $var[] = $termname->name;
  }
}
      }
      if(!empty($_GET['skeyword'])){
$var[] = $_GET['skeyword'];
      }
      $return = '';
      if(!empty($var)){
$return = implode(' | ', $var);
      }
      return $return;
    }
  }else{
    return $s;
  }
}


//add_filter('body_class','filter_body');
function filter_body($classes){
  if(count($_GET)===1 && isset($_GET['s'])) $classes[] = 'ny_highlight';
  return $classes;
}

add_filter('nav_menu_css_class','hide_submenu',100,3);
function hide_submenu( $classes, $item, $args )
{  if($args->menu_id !== 'ubermenu-nav-main-2-primary') return $classes;
  if(count($_GET)===1 && isset($_GET['s']))
  {
    $c = array();
    foreach($classes as $id=>$l)
    {
      if($l==='ubermenu-current-menu-ancestor' || $l === 'ubermenu-active')
      {
$c[] = 'ny_hide';
continue;
      }
      $c[]  = $l;
    }
    return $c;
  }
  return $classes;
}

// nyasro sort countries //

add_filter('nyasro_dropdown_sort','nyasro_terms_sort','',2);
function nyasro_terms_sort( $terms, $taxname )
{ 
  if($taxname === 'bridge_countries')
  {   
    $_a   = array();
    $_n   = array();
    foreach( $terms as $lterm )
    {
      if($lterm->name === 'Nigeria')
      {
$_n[$lterm->name] = $lterm;
continue;
      }
      $_a[$lterm->name] = $lterm;
    }
    ksort($_a);
    return ($_n + $_a); 
  }
  return $terms;
}// end of nyasro sort countries //

///////////////// updated to remove bridge- string from urls already in databse /////////////////////

//////////////// Stop selected categories appearing at the top of categories list in metabox, keep it all in correct heirachy order ///////////////
add_filter( 'wp_terms_checklist_args', 'genderhub_wp_terms_checklist_args', 1, 2 );
function genderhub_wp_terms_checklist_args( $args, $post_id ) {

   $args[ 'checked_ontop' ] = false;

   return $args;

}

///// ADD NEW META BOX ///
/**
 * Adds a meta box to the post editing screen
 */
function genderhub_custom_meta() {
    add_meta_box( 'genderhub_meta', __( 'Current Active Categories', 'genderhub-textdomain' ), 'genderhub_meta_callback', 'ids_documents', 'side', 'high'  );
}
add_action( 'add_meta_boxes', 'genderhub_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function genderhub_meta_callback( $post ) {
    echo $sep = '';
foreach((get_the_category()) as $category) {
echo $sep . $category->cat_name; $sep = ', ';
};  
}
/// place RSS Aggregator Images to Custom Field ///
add_filter( 'wprss_ftp_featured_image_meta', 'save_url_custom_field' );
function save_url_custom_field() {
   return 'publisher_logo'; // Replace with name of desired meta key
}
/// This error appears in the plugin’s Error Log when an image was not imported due to WordPress’ security check for the image’s extension. Some sites will deliver images without extensions in the URL, but will still send the correct MIME type. The filter below will allow the plugin to bypass this security check, and import images correctly: ///
add_filter( 'wprss_ftp_override_upload_security', '__return_true' );

/*
* http://wordpress.stackexchange.com/questions/35055/how-to-dynamically-resize-wordpress-image-on-the-fly-custom-field-theme-option
* Resize images dynamically using wp built in functions
* Victor Teixeira
*
* php 5.2+
*
* Exemplo de uso:
*
* <?php
* $thumb = get_post_thumbnail_id();
* $image = vt_resize($thumb, '', 140, 110, true);
* ?>
* <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
*
* @param int $attach_id
* @param string $img_url
* @param int $width
* @param int $height
* @param bool $crop
* @return array
*/
if(!function_exists('vt_resize')){
    function vt_resize($attach_id = null, $img_url = null, $width, $height, $crop = false){
    if($attach_id){
// this is an attachment, so we have the ID
$image_src = wp_get_attachment_image_src($attach_id, 'full');
$file_path = get_attached_file($attach_id);
    } elseif($img_url){
// this is not an attachment, let's use the image url
$file_path = parse_url($img_url);
$file_path = $_SERVER['DOCUMENT_ROOT'].$file_path['path'];
// Look for Multisite Path
if(file_exists($file_path) === false){
    global $blog_id;
    $file_path = parse_url($img_url);
    if(preg_match('/files/', $file_path['path'])){
$path = explode('/', $file_path['path']);
foreach($path as $k => $v){
    if($v == 'files'){
$path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
    }
}
$path = implode('/', $path);
    }
    $file_path = $_SERVER['DOCUMENT_ROOT'].$path;
}
//$file_path = ltrim( $file_path['path'], '/' );
//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
$orig_size = getimagesize($file_path);
$image_src[0] = $img_url;
$image_src[1] = $orig_size[0];
$image_src[2] = $orig_size[1];
    }
    $file_info = pathinfo($file_path);
    // check if file exists
    $base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
    if(!file_exists($base_file))
    return;
    $extension = '.'. $file_info['extension'];
    // the image path without the extension
    $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
    // checking if the file size is larger than the target size
    // if it is smaller or the same size, stop right here and return
    if($image_src[1] > $width){
// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
if(file_exists($cropped_img_path)){
    $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
    $vt_image = array(
'url'   => $cropped_img_url,
'width' => $width,
'height'    => $height
    );
    return $vt_image;
}
// $crop = false or no height set
if($crop == false OR !$height){
    // calculate the size proportionaly
    $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
    $resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;
    // checking if the file already exists
    if(file_exists($resized_img_path)){
$resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);
$vt_image = array(
    'url'   => $resized_img_url,
    'width' => $proportional_size[0],
    'height'    => $proportional_size[1]
);
return $vt_image;
    }
}
// check if image width is smaller than set width
$img_size = getimagesize($file_path);
if($img_size[0] <= $width) $width = $img_size[0];
    // Check if GD Library installed
    if(!function_exists('imagecreatetruecolor')){
echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
return;
    }
    // no cache files - let's finally resize it
    $new_img_path = image_resize($file_path, $width, $height, $crop);
    $new_img_size = getimagesize($new_img_path);
    $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);
    // resized output
    $vt_image = array(
'url'   => $new_img,
'width' => $new_img_size[0],
'height'    => $new_img_size[1]
    );
    return $vt_image;
}
// default output - without resizing
$vt_image = array(
    'url'   => $image_src[0],
    'width' => $width,
    'height'    => $height
);
return $vt_image;
    }
}
add_action('admin_menu', 'add_content_intros');
function add_content_intros()  
{  
    add_options_page('Content intros', 'Content intros', 'manage_options', 'functions','add_content_intros_page');  
}  
function add_content_intros_page()  
{  

?>  
<div class="wrap">  
    <h2>Content intros</h2>  
    <form method="post" action="options.php">  
        <?php wp_nonce_field('update-options') ?>  
        <?php
    $nf = '';
    $post_types = get_post_types(array('public'   => true, '_builtin' => false), 'names' ); 
    
    foreach ( $post_types as $post_type ) {
    if($post_type != 'contact_point' && $post_type != 'wprss_feed' && $post_type != 'wprss_feed_item' && $post_type != 'blocks' && $post_type != 'facebook'):
    ?>
     <p><strong><?php echo ucfirst(str_replace('-',' ',str_replace('_',' ',$post_type)));?>:</strong><br />  
     <?php
     wp_editor( get_option($post_type.'-description'), $post_type.'-description', $settings = array() );
     ?>
    
        </p>  
<?php
$nf = $nf.$post_type.'-description,';
endif;
}

?>
   
   
    <input type="hidden" name="action" value="update" />  
    <input type="hidden" name="page_options" value="<?php echo $nf;?>" />  
      <p><input type="submit" name="Submit" value="Store Options" /></p>  
</form>  
    </div>  
<?php  
}  

/**
 * Add  fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 function slide_background_colour_dropdown($post,$value){
	 $options = array(
			array('name' => 'Green', 'value' => 'greenbg'),
			array('name' => 'Orange', 'value' => 'orangebg'),
			array('name' => 'Pink', 'value' => 'pinkbg'),
			array('name' => 'Purple', 'value' => 'purplebg')
			);
		$dropdown = '<select name="attachments['.$post->ID.'][slide-colour]">
		<option value="" selected="">None</option>';
		foreach($options as $op):
		if($value==$op['value']):$s=' selected="selected"'; else: $s = ''; endif;
		$dropdown .= '<option value="'.$op['value'].'" '.$s.'>'.$op['name'].'</option>';
		endforeach;
		$dropdown .= '</select>';	
		return $dropdown;	
	 
 }
function be_attachment_field_credit( $form_fields, $post ) {
	$form_fields['slide-colour'] = array(
		'label' => 'Slide colour',
		'input'      => 'html',
		'html'       => slide_background_colour_dropdown($post,get_post_meta( $post->ID, 'slide_colour', true )),
		
		'value' => get_post_meta( $post->ID, 'slide_colour', true ),
		'helps' => 'Sets the background button and title colour',
	);

	$form_fields['slide-link'] = array(
		'label' => 'Slide Link',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'slide_link', true ),
		'helps' => 'Add Slide URL',
	);
	$form_fields['slide-link-text'] = array(
		'label' => 'Slide Link Text',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'slide_link_text', true ),
		'helps' => 'Add Slide Link Text',
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

/**
 * Save values of fields in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function be_attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment['slide-colour'] ) )
	update_post_meta( $post['ID'], 'slide_colour', $attachment['slide-colour'] );

	if( isset( $attachment['slide-link'] ) )
	update_post_meta( $post['ID'], 'slide_link',  $attachment['slide-link']  );

	if( isset( $attachment['slide-link-text'] ) )
	update_post_meta( $post['ID'], 'slide_link_text',  $attachment['slide-link-text'] );
	return $post;
	}

add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

// slkr - what on earth is going on under here?!
// Trigger insert prev / next
add_filter( 'loop_end', 'prev_next' );

function prev_next( $post ) {
	global $post;
	if (!is_front_page()):
		if (is_single() ) {
			if(get_post_type() == 'collection'):     
      			endif;
		}
	endif;
}

// slkr - new functions

/* AUTOMATICALLY SELECT PARENT TERMS WHEN A POST IS ADDED TO A TOPIC */
function slikkr_select_parent_terms($post_ID, $post) {
    if(!wp_is_post_revision($post_ID)) {
        $taxonomies = get_taxonomies(array('_builtin' => false));
        foreach ($taxonomies as $taxonomy ) {
            $terms = wp_get_object_terms($post->ID, $taxonomy);
            foreach ($terms as $term) {
                $parenttags = get_ancestors($term->term_id,$taxonomy);
                wp_set_object_terms( $post->ID, $parenttags, $taxonomy, true );
            }
        }
    }
}
add_action('publish_ids_documents', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_contact_point', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_events', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_blogs_opinions', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_other_training', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_programme_alerts', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_practical_tools', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_news_stories', 'slikkr_select_parent_terms', 10, 2);
add_action('publish_collections', 'slikkr_select_parent_terms', 10, 2);

function slikkr_footer_loadscripts() {

    wp_register_script( 'slikkr_frontend_jquery', get_stylesheet_directory_uri() . '/js/slikkr-custom-front.js', array( 'jquery'), null, true);

    wp_enqueue_script('slikkr_frontend_jquery');
}
add_action( 'wp_footer', 'slikkr_footer_loadscripts' );

function slikkr_excerpt_label( $new, $original ) {
    global $post_type;
    if ( 'Excerpt' == $original && $post_type == 'collections') {
        return 'Explain why this collection was created';
    }else{
        $pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
        if ($pos !== false) {
            return  '';
        }
    }
    return $new;
}

add_filter( 'gettext', 'slikkr_excerpt_label', 10, 2 );


if(!function_exists('slikkr_collections_list')) {
    function slikkr_collections_list($atts) {


        if($atts == NULL) {
            $atts =
                shortcode_atts(
                    array(
                        'type'  => ''
                    ), $atts, 'ghcollections'
                );
        }

        $html = '';
        $args = array(
            'numberposts' => 100,
            'post_type'=> 'collections',
            'orderby' => 'meta_value',
            'meta_key' => 'date',
            'order' => 'DESC'
        );
        $colls = new WP_Query( $args );

	if ( $colls->have_posts() ) :

            $html .= '<div class="collections-shortcode">';

            while ($colls->have_posts()) : $colls->the_post();

                global $wp;
                $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
                $current_url = strtok($current_url, '?').'/';

                $date = new DateTime(get_field('date'));

                if(($atts['type'] == 'sidebar')) {

                    if ($current_url != get_the_permalink()) {

                        $html .= '<div class="collection">';
                        $html .= '<p><a href="'.get_the_permalink().'">'.get_the_title();
                        $html .= !empty($date) ? ' ('.$date->format('M Y').')</a></p>' : '</a></p>';
                        $html .= '</div>';
                    } else {
                        $html .= '';
                    }

                } else {

                    $html .= '<div class="collection">';
                    $html .= '<div class="image"><a href="'.get_the_permalink().'">'.get_the_post_thumbnail($colls->id).'</a></div>';
                    $html .= '<div class="details"><h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
                    $html .= !empty($date) ? '<p>'.$date->format('M Y').'</p>' : '';
                    $html .= '<p>'.wp_trim_words( get_the_excerpt(), 200 ).'</p></div>';
                    $html .= '</div>';

                }

            endwhile;

            $html .= '</div>';
	endif; ?>

<?php wp_reset_postdata();

    return $html;
    }
    
}

add_shortcode('ghcollections', 'slikkr_collections_list');

function slikkr_excerpt_meta_box($post) {
    remove_meta_box( 'postexcerpt' , $post->post_type , 'normal' );  ?>
    <div class="postbox" style="margin-bottom: 0;">
        <h3 class="hndle"><span>Explain why this collection was created</span></h3>
        <div class="inside">
            <label class="screen-reader-text" for="excerpt"><?php _e('Excerpt') ?></label>
             <textarea rows="1" cols="40" name="excerpt" id="excerpt">
                  <?php echo $post->post_excerpt; ?>
             </textarea>
        </div>
    </div>
<?php }
// IDS: Removed as it is affecting all forms 
// add_action('edit_form_after_title', 'slikkr_excerpt_meta_box');

/**
 * Takes one or two TIMESTAMPs, and an optional formatting array of the form ($year, $month, $day),
 * and returns a date that is appropriate to the situation
 * @param int $start
 * @param int $end
 * @param array $fmt
 * @return boolean|string
 */
function ids_pretty_date( $start, $end = NULL, $fmt = NULL ) {
    if( ! isset( $start ) ) {
	return false;
    }
    
    if( ! isset( $fmt ) ) {
	// default formatting
	$fmt = array( 'Y', 'M', 'j' );
    }
    list( $yr, $mon, $day ) = $fmt;
    
    if( ! isset( $end) || $start == $end ) {
	return( date( "$mon $day, $yr", $start ) );
    }
    if( date( 'M-j-Y', $start ) == date( 'M-j-Y', $end ) ) {
	// close enough
	return date( "$mon $day, $yr", $start );
    }
    
    
    // ok, so $end != $start
		    
    // let's look at the YMD individually, and make a pretty string
    $dates = array( 
	's_year' => date( $yr, $start ),
	'e_year' => date( $yr, $end ),

	's_month' => date( $mon, $start ),
	'e_month' => date( $mon, $end ),

	's_day' => date( $day, $start ),
	'e_day' => date( $day, $end ),

    );
    // init dates
    $start_date = '';
    $end_date = '';

    $start_date .= $dates['s_month'];
    if( $dates['s_month'] != $dates['e_month'] ) {
	$end_date .= $dates['e_month'];
    }

    $start_date .= ' '. $dates['s_day'];
    if( $dates['s_day'] != $dates['e_day'] || $dates['s_month'] != $dates['e_month'] ) {
	$end_date .= ' ' . $dates['e_day'];
    }

    if( $dates['s_year'] != $dates['e_year'] ) {
	$start_date .= ', ' . $dates['s_year'];
	if( $dates['s_month'] == $dates['e_month'] ) {
	    if( $dates['s_day'] == $dates['e_day'] ) {
		// same day, same month, different year
		$end_date = ' ' . $dates['e_day'] . $end_date;
	    }
	    // same month, but a different year
	    
	    $end_date = $dates['e_month'] . $end_date;
	}
    }
    $end_date .= ', ' . $dates['e_year'];

    $complete_date = trim( $start_date ) . '&ndash;' . trim( $end_date );
    
    return $complete_date;
}
