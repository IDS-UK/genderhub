<?php

class GenderHub_2017 {

    function __construct() {

	    include('inc/gh-page-meta.php');
	    include('inc/gh-social-media-posts.php');

	    add_action( 'after_setup_theme', array($this, 'setup') );
	    add_action( 'wp_enqueue_scripts', array($this, 'gh_header_loadscripts') );
	    add_action( 'wp_footer', array($this, 'gh_footer_loadscripts') );
	    add_action( 'admin_enqueue_scripts', array($this, 'gh_admin_loadscripts') );
	    add_action( 'widgets_init', array($this, 'gh_sidebars') );
	    add_action( 'pre_get_posts', array($this, 'practical_tools_filter') );
	    add_action( 'login_enqueue_scripts', array($this, 'gh_custom_login_logo') );

	    add_filter( 'image_size_names_choose', array($this, 'custom_image_sizes_choose') );
	    add_filter( 'body_class', array($this, 'gh_body_classes') );
	    add_filter( 'login_errors', create_function('$a', "return null;") );
	    add_filter( 'wpcf7_load_js', '__return_false' );
	    add_filter( 'wpcf7_load_css', '__return_false' );
	    add_filter( 'gettext', array($this, 'gh_excerpt_label'), 10, 2 );
	    add_filter( 'excerpt_length', array($this, 'gh_excerpt_length') );
	    add_filter( 'tiny_mce_before_init', array($this, 'gh_styles_dropdown') );
	    add_filter( 'mce_buttons', array($this, 'gh_style_select') );
	    add_filter( 'the_content', array($this, 'filter_ptags_on_images') );

	    remove_action( 'wp_head','wp_generator' );

	    add_editor_style( 'css/editor-style.css' );

	    add_shortcode( 'recent-posts', array($this, 'gh_recent_posts_shortcode') );

    }

	function setup() {

		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' ); // This feature enables post-thumbnail support for a theme

		add_image_size( 'square_220', 220, 220, true ); //(cropped)
		add_image_size( 'square_120', 120, 120, true ); //(cropped)
		add_image_size( 'custom-thumb', 220, 180, true ); // 220 pixels wide by 180 pixels tall, soft proportional crop mode
		add_image_size( 'gallery', 720, 362, true );
		add_image_size( 'gallery-thumb', 80, 50, true );
		add_image_size( 'box', 237, 155, true );
		add_image_size( 'collection', 300, 200, false);
		add_image_size( 'blog_featured', 500, 300 );

		register_nav_menu( 'primary', __( 'Primary Menu', 'genderhub' ) );
		register_nav_menu( 'secondary', __( 'Second Menu', 'genderhub' ) );

	}

	function gh_header_loadscripts() {

		wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/genderhub.js', array(), '1.0.0', true );
		wp_enqueue_style( 'gh-style', get_template_directory_uri() . '/style.css', NULL, false, 'all' );
		wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic', array(), 20131111 );
		wp_enqueue_style( 'prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.1' );

		if(is_front_page()) {

			wp_enqueue_style( 'lightslider-style', get_template_directory_uri() . '/css/lightslider.css', NULL, false, 'all' );
			wp_enqueue_script( 'lightslider-script', get_stylesheet_directory_uri() . '/js/lightslider.js', array(), '1.0.0', true );

        }
	}

	function gh_footer_loadscripts() {

		wp_register_script( 'gh-frontend-jquery', get_stylesheet_directory_uri() . '/js/gh-custom-front.js', array( 'jquery'), null, true);
		wp_enqueue_script( 'gh-frontend-jquery');
	}

	function gh_admin_scripts($hook) {

		wp_enqueue_media();

		wp_enqueue_style( 'jquery-ui-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);

		wp_register_script( 'genderhub-admin-js', get_stylesheet_directory_uri() . '/js/genderhub-custom-admin.js', array('jquery'), null, true );
		wp_enqueue_script( 'genderhub-admin-js' );

		$jquery_ui = array(
			"jquery-ui-core",			//UI Core - do not remove this one
			"jquery-ui-sortable",
			"jquery-ui-draggable",
			"jquery-ui-droppable",
			"jquery-ui-selectable",
			"jquery-ui-position",
			"jquery-ui-datepicker"
		);
		foreach($jquery_ui as $script){
			wp_enqueue_script($script);
		}

	}

	function gh_body_classes( $classes ) {

		global $post;

		if ( isset( $post ) ) {
			$classes[] = $post->post_name;

			$this_template = get_post_meta($post->ID, '_wp_page_template', true);
			$classes[] = $this_template;
		}

		foreach ( $classes as $k =>  $v ) {
			if ( substr($v, 0, 21) == 'page-template-archive' ) {
				$classes[ $k ] = substr( $v, 22 );
			}
		}

		return $classes;
	}

	function gh_sidebars() {

		register_sidebar( array(
			'name' => __( 'Generic Sidebar', 'genderhub' ),
			'id' => 'generic-sidebar',
			'description' => __( 'generic-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Events Sidebar', 'genderhub' ),
			'id' => 'events-sidebar',
			'description' => __( 'events-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Training Sidebar', 'genderhub' ),
			'id' => 'training-sidebar',
			'description' => __( 'training-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Blogs Sidebar', 'genderhub' ),
			'id' => 'blogs-sidebar',
			'description' => __( 'blogs-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Alerts Sidebar', 'genderhub' ),
			'id' => 'alerts-sidebar',
			'description' => __( 'alerts-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'News Sidebar', 'genderhub' ),
			'id' => 'news-sidebar',
			'description' => __( 'news-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Search Sidebar', 'genderhub' ),
			'id' => 'search-sidebar',
			'description' => __( 'search-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Knowledge Sidebar', 'genderhub' ),
			'id' => 'knowledge-sidebar',
			'description' => __( 'knowledge-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Build Capacity Sidebar', 'genderhub' ),
			'id' => 'build-capacity-sidebar',
			'description' => __( 'build-capacity-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Collection Sidebar', 'genderhub' ),
			'id' => 'collection-sidebar',
			'description' => __( 'collection-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Connect and Discuss Content', 'genderhub' ),
			'id' => 'connect-discuss-content',
			'description' => __( 'connect-discuss-content', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Connect and Discuss Sidebar', 'genderhub' ),
			'id' => 'connect-discuss-sidebar',
			'description' => __( 'connect-discuss-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Inspiration Sidebar', 'genderhub' ),
			'id' => 'inspiration-sidebar',
			'description' => __( 'inspiration-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer 1', 'genderhub' ),
			'id' => 'footer-1',
			'description' => __( 'footer-1', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer 2', 'genderhub' ),
			'id' => 'footer-2',
			'description' => __( 'footer-2', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer 3', 'genderhub' ),
			'id' => 'footer-3',
			'description' => __( 'footer-3', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer 4', 'genderhub' ),
			'id' => 'footer-4',
			'description' => __( 'footer-4', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Sub Footer', 'genderhub' ),
			'id' => 'subfooter',
			'description' => __( 'subfooter', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Test Sidebar', 'genderhub' ),
			'id' => 'test-sidebar',
			'description' => __( 'test-sidebar', 'genderhub' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title white">',
			'after_title' => '</h3>',
		) );

	}

	function custom_image_sizes_choose( $sizes ) {

		return array_merge( $sizes, array(

			'square_220'        => 'square_220px',
			'square_120'        => 'square_120px',
			'gallery'           => 'Slider Image',
			'gallery-thumb'     => 'Slider Thumbnail',
		));
	}

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

	function gh_excerpt_label( $new, $original ) {
		global $post_type;
		if ( 'Excerpt' == $original && $post_type == 'collections') {
			return 'Explain why this collection was created';
		} else {
			$pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
			if ($pos !== false) {
				return  '';
			}
		}
		return $new;
	}

	function gh_excerpt_length($length) {
		return 55;
	}

	function gh_custom_login_logo() { ?>

        <style type="text/css">
            h1 a { background-image:url("http://www.genderhub.org/wp-content/themes/genderhub/images/GenderHub_login.gif") !important; }
            </style>

        <?php
	}

	function gh_styles_dropdown( $settings ) {

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

	function gh_style_select( $buttons ) {
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}

	function gh_recent_posts_shortcode( $atts ) {

        extract( shortcode_atts( array( 'limit' => 5 ), $atts ) );

		return '<ul class="my-recent-posts">' . wp_get_archives('type=postbypost&limit=' . $atts['limit'] . '&echo=0') . '</ul>';
	}

	function filter_ptags_on_images($content){
		return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
	}

	public static function gh_get_slider_posts($type) {

		$args = array(
			'post_type'		    => $type,
			'post_status'       => 'publish',

			'meta_query'        => array(
				array(
					'key'       => '_pa_slide_include',
					'value'     => '1',
					'compare'   => '=',
				),
			),
		);

		$output = '';
		$pa_query = new WP_Query( $args );

		if ( $pa_query->have_posts() ) :

			while ( $pa_query->have_posts() ) : $pa_query->the_post();

				$slide_color = get_post_meta($pa_query->post->ID, '_pa_slide_bg', true);
				$slide_link_url = get_post_meta($pa_query->post->ID, '_pa_slide_link_url', true);
				$slide_link_text = get_post_meta($pa_query->post->ID, '_pa_slide_link_text', true);
				$image_credit_url = get_post_meta($pa_query->post->ID, '_pa_image_credit_url', true);
				$image_credit_text = get_post_meta($pa_query->post->ID, '_pa_image_credit_text', true);

				$desc = esc_html(get_post(get_post_thumbnail_id())->post_content);

				$output .= '<li class="slide-'.$pa_query->post->ID.'" data-thumb="'.wp_get_attachment_image_src( get_post_thumbnail_id(), 'gallery-thumb' )[0].'" data-thumb-text="'.$pa_query->post->post_title.'" title="'.get_the_excerpt().'">';
                $output .= '<div class="slide '.$slide_color.'">';

				$output .= '<div class="title"><h3 class="'.$slide_color.'"><span>'.$pa_query->post->post_title.'</span></h3></div>';
				$output .= '<a href="'.$slide_link_url.'">'.get_the_post_thumbnail($post = null, 'gallery').'</a>';
				$output .= '<div class="text"><p>'.$desc.'</p>';
				$output .= '<p>';
				$output .= '<a href="'.$slide_link_url.'" class="'.$slide_color.'">'.$slide_link_text.'</a>';

				if(!empty($image_credit_text)) :

				    $output .= '<span class="image-credit">Photo: '.(!empty($image_credit_url) ? '<a href="'.$image_credit_url.'">'.$image_credit_text.'</a>' : $image_credit_text).'</span>';

				endif;

				$output .= '</p>';
				$output .= '</div>';

				$output .= '</div>';
				$output .= '</li>';

			endwhile;

			wp_reset_postdata();

		endif;

		return $output;

	}
}

new GenderHub_2017;

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
  <div class="nav-next"><?php previous_posts_link( __( '<img class="prev_next_arrows" alt="Next Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />Newer posts', 'twentythirteen' ) ); ?></div>
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
      <?php next_post_link( '%link', _x( '<img class="prev_next_arrows" alt="Next Post" src="http://genderhub.org/wp-content/themes/genderhub/images/arrowR.png" /><br />%title ', 'Next post link', 'twentythirteen' ) ); ?>
    
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



function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
//add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );


function custom_rewrite_basic() {
  add_rewrite_rule('^csw60/?', 'index.php?page_id=30914', 'top');
}
//add_action('init', 'custom_rewrite_basic');


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
add_filter( 'default_hidden_meta_boxes', 'enable_custom_fields_per_default', 20, 1 );


global $wp_taxonomies;
if( isset( $wp_taxonomies[ 'collections' ] ) ) {

    unset( $wp_taxonomies[ 'collections' ] );
}

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
add_filter( 'pre_get_posts', 'genderhub_cpt_search' );

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
add_filter( 'posts_search', 'whole_words_search', 20, 2 );

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
add_filter('uwpqsf_tax_field_dropdown','custom_dropdown_output','',12);

// add post count to search drop downs - Ultimate WP Query Search Filter
// http://9-sec.com/support-forum/?mingleforumaction=viewtopic&t=221


// add query terms to search results - Ultimate WP Query Search Filter

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
add_filter( 'get_search_query', 'uwpqsf_var', 20, 1 );

// nyasro sort countries //

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
add_filter('nyasro_dropdown_sort','nyasro_terms_sort','',2);

///////////////// updated to remove bridge- string from urls already in databse /////////////////////

//////////////// Stop selected categories appearing at the top of categories list in metabox, keep it all in correct heirachy order ///////////////
function genderhub_wp_terms_checklist_args( $args, $post_id ) {

   $args[ 'checked_ontop' ] = false;

   return $args;

}
add_filter( 'wp_terms_checklist_args', 'genderhub_wp_terms_checklist_args', 1, 2 );


/**
 * this belongs in ids documents post type
 */
function genderhub_custom_meta() {
    add_meta_box( 'genderhub_meta', __( 'Current Active Categories', 'genderhub' ), 'genderhub_meta_callback', 'ids_documents', 'side', 'high'  );
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

add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
    return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}

function format_link($url, $title = '', $scheme = 'http://') {
  if ($title == '') { $title = $url; }
  return '<a href="'. (parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url) . '">'.sanitize_title($title).'</a>';
}

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

add_filter( 'searchwp_short_circuit', '__return_true' );