<?php
/**
 * Template for displaying IDS Documents content parts
 */
//require_once("Tax-meta-class/Tax-meta-class.php");

?>

<?php 
/* Build attribution content */
  $attribution = '';
  //if (current_user_can('publish_pages')) {
	$terms = wp_get_post_terms(get_the_ID(), 'attribution');

	foreach ($terms as $term){
		//$attribution .= '<pre>'.print_r($term,true).'</pre>';
		$title = get_term_meta($term->term_id,'ba_attribution_text_field_id', true);
		
                $attribution .= '<div class="attribution-group">';
                $attribution .= '<a class="attribution-link" title="'.$title.'" href="'.get_term_meta($term->term_id,'ba_website_link_field_id',true).'">';
		//$attribution .= '<span class="attribution-text">';
		//$attribution .= '&nbsp;'.get_term_meta($term->term_id,'ba_display_name_field_id', true);
		//$attribution .= '</span>';
                //$attribution .= print_r(get_term_meta($term->term_id,'ba_attribution_image_field_id'),true);
		$img = get_term_meta($term->term_id,'ba_attribution_image_field_id',true);  
            	$img = vt_resize($img['id'], '', 140, 110, true);
		$attribution .= '<img class="attribution-image" src="'.$img['url'].'" />';
		
		$attribution .= '</a></div>';
                 
	}
  //}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<!-- Main single page -->
		
		
		<?php if ( is_single() ) : ?>
		
			<h1 class="entry-title"><?php the_title(); ?></h1>
  
		  <?php else : ?>
				
			
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php if ( is_search() ) :  ?><span class="search-content-type">DOCUMENT: </span><?php endif; ?>
                                    <?php the_title(); ?>
                                </a>
			</h1>
		<?php endif; // is_single() ?>

	<h6>
		<span class="floatright"><img src="/wp-content/uploads/2015/05/document-icon.png" /></span>

		<?php 
		if (ids_get_field('publisher') != '') { echo '<span>Publisher: </span><strong>'.ids_get_field('publisher').'</strong>'; } 
		?>
		<?php 
		if (ids_get_field('publication_year') != '') { echo '<!--span>Published in: </span--><strong>'.ids_get_field('publication_year').'</strong>'; }
		?>
		<br />
		<?php 
		if ($authors = ids_get_field('authors')) { echo '<span>Author: </span><strong>'.str_ireplace("false", "", $authors).'</strong>'; }
		?>
		<?php
		if ($terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'resource_type', '', ' , ' ) )) { echo '<span>Resource type(s): </span><strong>'.str_ireplace(';',', ',$terms_as_text).'</strong>'; } 
		?>
		
		<?php
		// if ($terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ' , ' ) )) { echo '<!--span>Content type(s): </span><strong>'.$terms_as_text.'</strong-->'; }
		?>
            </h6>
	
	
	 </header><!-- .entry-header -->

	

		<!-- Main IDS resources list page -->
						
	<?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>
			


	<div class="entry-summary">



		<?php if ($attribution) { ?>
			<div class="attribution">
				<?php echo $attribution; ?>
			</div>
		<?php } ?>
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail('medium'); ?>
		</div>
		<?php endif; ?>
		
				<?php the_excerpt(); ?>
		
		<p><a class="button" href="<?php the_permalink(); ?>">Read more</a></p>

	</div><!-- .entry-summary -->
		
	<?php else : ?>
		
	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail('medium'); ?>
		</div>
		<?php endif; ?>

		<?php if ($attribution) { ?>
			<div class="attribution">
				<?php echo $attribution; ?>
			</div>
		<?php } ?>

		<?php the_content( __( 'Continue reading <span class="meta-nav"></span>', 'twentythirteen' ) ); ?>
			
			<div class="col span_1_of_4">
		<?php 

$image = get_field('organisiation_logo');

if( !empty($image) ): ?>

	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

<?php endif; ?>

		</div><!--span_1_of_4-->
			
      <!-- DISPLAY THE IDS FIELD META -->
			<?php if ( is_single() ) : ?>



      <div class="ids-fields">
      
      <h3>Document details</h3>
      
   
  
      
       <?php ids_field('urls', '<div class="list-of-buttons">', '</div>', array('link', 'Read document')); ?>
             
        
   
<?php 
    /* Get the collections this is part of */

        $topics = wp_get_post_terms(get_the_ID(), 'topics', array('fields' => 'all','orderby' => 't.term_id'));
        foreach($topics as $topic) {
            $topic_list[] = $topic->term_id;
        }
        //print 'xxx'.print_r($topic_list,true);
        
        $posts_array = get_posts(
            array( 'showposts' => -1,
            'post_type' => 'collections',
            'tax_query' => array(
                array(
                    'taxonomy' => 'topics',
                    'field' => 'term_id',
                    'terms' => $topic_list,
                    )
                )
            )
        );
        //print 'xxx'.print_r($posts_array,true);
        if (count($posts_array) > 0) {
            print '<div class="document-collections-wrapper">';
            print '<h3>'.'<span>Collections</span>'.'</h3>';
            print '<p>'.'Find more like this in our collections'.'</p><ul>';
            foreach ($posts_array as $collection) {
                //print get_field('date', $collection->ID);
                $collection_date = new DateTime(get_field('date', $collection->ID));
                //print 'xxx'.print_r($collection,true);
                print '<li>';
                print '<a href="'.$collection->guid.'">'.$collection->post_title.' ('.$collection_date->format('F Y').')</a><br/>'.  get_the_excerpt($collection->ID);
                print '</li>';
            }
            print '</ul>';
            print '</div>';
        }

?>
      <ul>
        <?php ids_field('publisher', '<li class="ids-field">' . __('<strong>Publisher:</strong> '), '</li>'); ?>      
        <?php ids_field('authors', '<li class="ids-field">' . __('<strong>Author:</strong> '), '</li>'); ?> 

        <?php ids_field('publication_year', '<li class="ids-field">' . __('<strong>Publication year:</strong> '), '</li>'); ?>

        <?php ids_field('date_updated', '<li class="ids-field">' . __('<strong>Updated on:</strong> '), '</li>', 'date'); ?>
       
        <!-- categories list with links 
        <li class="ids-field"><strong>Themes:</strong><br /> <?php the_category(', '); ?></li>
        -->
       
        <!-- categories list with no link -->
        <li class="ids-field"><strong>Themes:</strong> <?php
$sep = '';
foreach((get_the_category()) as $category) {
    echo $sep . '<a href="/?unonce=34668a7887&uformid=1930&s=uwpsfsearchtrg&taxo%5B0%5D%5Bname%5D=category&taxo%5B0%5D%5Bopt%5D=&taxo%5B0%5D%5Bterm%5D='.$category->slug.'&taxo%5B1%5D%5Bname%5D=bridge_countries&taxo%5B1%5D%5Bopt%5D=&taxo%5B1%5D%5Bterm%5D=uwpqsftaxoall&skeyword=">'.$category->cat_name.'</a>'; $sep = ', ';
}
?></li>

    
       <li><strong>Content type(s): </strong><?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ', ' ) );
echo $terms_as_text; ?>
       </li>
       
       <li>
<strong>Resource Type(s): </strong><?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'resource_type', '', ', ' ) );
if(!empty($terms_as_text)) {
echo $terms_as_text;
}
else if(empty($terms_as_text)) {
echo 'Not Known';
}
?>
       </li>


       
       
      </ul>
      </div>
      
      
        <?php echo do_shortcode('[ssbp]'); ?>
      
      
				<?php endif; // is_single() ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
	
	<!--footer class="entry-meta">
	</footer--><!-- .entry-meta -->
</article><!-- #post -->
