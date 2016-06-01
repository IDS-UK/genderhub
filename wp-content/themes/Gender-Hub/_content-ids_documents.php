<?php
/**
 * 
 * IDS Bridge Documents Template
 */
?>


<?php 


/* Build attribution content */
  $attribution = '';
  //if (current_user_can('publish_pages')) {
	$terms = wp_get_post_terms(get_the_ID(), 'attribution');

	foreach ($terms as $term){
		$attribution .= '<div class="attribution-group">';

		$attribution .= '<a class="attribution-link" href="'.get_tax_meta($term->term_id,'ba_website_link_field_id').'">';
	
		$attribution .= '<span class="attribution-text">';
		$attribution .= get_tax_meta($term->term_id,'ba_attribution_text_field_id');
		$attribution .= '&nbsp;'.get_tax_meta($term->term_id,'ba_display_name_field_id');
		$attribution .= '</span>';
		$img = get_tax_meta($term->term_id,'ba_attribution_image_field_id');
		$img = vt_resize($img['id'], '', 140, 110, true);
		$attribution .= '<img class="attribution-image" src="'.$img['url'].'" />';
		//$attribution .= print_r(get_tax_meta($term->term_id,'ba_attribution_image_field_id'),true);
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
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>

<h6>
<span>Author:</span> <?php printf(__(ids_get_field('authors') ? ids_get_field('authors') : 'Not known')); ?>
<span> - </span>
<!---<span>Content type(s): </span><?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'content_type', '', ', ' ) );
echo $terms_as_text; ?>
<span> - </span>--->

<?php
$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'resource_type', '', ', ' ) );
if (!empty($terms_as_text)) {
	echo '<span>Resource Type(s): </span>'. (empty($terms_as_text)) ? $terms_as_text : '';
}
?>

<br />
<span>Published in:</span> <?php printf(__(ids_get_field('publication_year') ? ids_get_field('publication_year') : 'Not known')); ?>
<span> - </span>
<span>Publisher:</span> <?php printf(__(ids_get_field('publisher') ? ids_get_field('publisher') : 'Not known')); ?>

<!-- only show if the date exists
<?php ids_field('publisher', '<span> - </span>' . __('<span>Publisher:</span> '), ''); ?>-->

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
		
		<p><a class="button" href="<?php the_permalink(); ?>">Read more &rarr;</a></p>

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

		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
			
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
      
      <h3>Document details</h4>
      
   
  
      
       <?php ids_field('urls', '<div class="list-of-buttons">', '</div>', array('link', 'Read document &rarr;')); ?>
             
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
echo $sep . $category->cat_name; $sep = ', ';
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

