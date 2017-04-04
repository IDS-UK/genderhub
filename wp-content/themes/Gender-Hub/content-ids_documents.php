<?php
/**
 * Template for displaying IDS Documents content parts
 */

/* Build attribution content */
$attribution = '';

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
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

        <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>

            <div class="entry-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
		
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
            <span class="floatright"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-document.png" /></span>

            <?php if (ids_get_field('publisher') != '') { echo '<span>Publisher: </span><strong>'.ids_get_field('publisher').'</strong>'; } ?>
            <?php if (ids_get_field('publication_year') != '') { echo '<!--span>Published in: </span--><strong>'.ids_get_field('publication_year').'</strong>'; } ?>
            <br />
            <?php if ($authors = ids_get_field('authors')) { echo '<span>Author: </span><strong>'.str_ireplace("false", "", $authors).'</strong>'; } ?>
            <br />
	        <?php if ($terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, 'resource_type', '', ' , ' ) )) { echo '<span>Resource type(s): </span><strong>'.str_ireplace(';',', ',$terms_as_text).'</strong>'; } ?>
        </h6>
	
    </header>
						
    <?php if ( is_home() || is_archive() || is_search() ) : ?>
			
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

        </div>
		
    <?php else : ?>
		
        <div class="entry-content">

            <div class="featured-image">
	                <?php ids_field('urls', '<img src="http://ims.ids.ac.uk/thumbnail/?url=', '" />'); ?>
                </div>

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

            </div>

            <?php if ( is_single() ) : ?>

                <div class="ids-fields">

                    <?php ids_field('urls', '<div class="list-of-buttons">', '</div>', array('link', 'Read document')); ?>

                    <p><strong>Themes:</strong>

                    <?php

                    $sep = '';
                    $sfid = $_SERVER['SERVER_NAME'] == 'genderhub.org' ? '279' : '1903'; // id of the Search and Filter Pro form, depending on whether we're on live or dev (respectively)

                    foreach((get_the_category()) as $category) {
                        echo $sep . '<a href="/?unonce=34668a7887&sfid='.$sfid.'&taxo%5B0%5D%5Bname%5D=category&taxo%5B0%5D%5Bopt%5D=&taxo%5B0%5D%5Bterm%5D='.$category->slug.'&taxo%5B1%5D%5Bname%5D=bridge_countries&taxo%5B1%5D%5Bopt%5D=&taxo%5B1%5D%5Bterm%5D=uwpqsftaxoall&skeyword=">'.$category->cat_name.'</a>'; $sep = ', ';
                    } ?>
                    </p>
                </div>
      
                <?php echo do_shortcode('[ssbp]'); ?>
      
            <?php endif; ?>

            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'genderhub' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

        </div>

    <?php endif; ?>

</article>