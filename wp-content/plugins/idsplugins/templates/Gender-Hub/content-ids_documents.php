<?php
/**
 * The default template for displaying content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<?php if ( is_single() ) : ?>
		
		<h1 class="entry-title"><?php the_title(); ?></h1>
		  	
	 <h6><?php if (ids_get_authors()) : ?><span>By: </span><?php ids_authors(); ?>.<?php endif; ?> <span>Document type:</span> <?php printf(__(get_field('document_type') ? get_field('document_type') : 'Article')); ?></h6>
		 		 
		 <?php else : ?>
				
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		  <h6><?php if (ids_get_authors()) : ?><span>By: </span><?php ids_authors(); ?>.<?php endif; ?> <span>Document type:</span> <?php printf(__(get_field('document_type') ? get_field('document_type') : 'Article')); ?></h6>
		<?php endif; // is_single() ?>
			</header><!-- .entry-header -->
		
	<?php if ( is_home() || is_archive() || is_search() ) : // Only display Excerpts for Home / Archive / Search ?>
			
	<div class="entry-summary">
		
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>
		
				<?php the_excerpt(); ?>
		
		<p><a class="button" href="<?php the_permalink(); ?>">Click to read more &rarr;</a></p>

	</div><!-- .entry-summary -->
		
	<?php else : ?>
		
	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail('medium'); ?>
		</div>
		<?php endif; ?>

		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
			
			<div class="col span_1_of_4">
		<?php 

$image = get_field('organisiation_logo');

if( !empty($image) ): ?>

	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

<?php endif; ?>

		</div><!--span_1_of_4-->
			
      <!-- Example of a simple way in which these fields can be displayed. -->
			<?php if ( is_single() ) : ?>
      <div class="ids-fields">
       <ul>
         <?php ids_authors('<li class="ids-field">' . __('Authors: ')); ?>
         <li class="ids-field"><?php printf(__('Document type: %s'), (get_field('document_type') ? get_field('document_type') : 'Article')); ?>
          <?php ids_date_updated('<li class="ids-field">' . __('Updated on: ')); ?>
          <?php ids_external_urls('<li class="ids-field">' . __('External URLs: ')); ?>
          <?php ids_countries('<li class="ids-field">' . __('Countries: '), ', ', '', site_url('knowledge/resource-library/')); ?>
          <?php ids_regions('<li class="ids-field">' . __('Regions: '), ', ', '', site_url('knowledge/resource-library/')); ?>
          <?php ids_themes('<li class="ids-field">' . __('Themes: '), ', ', '', site_url('knowledge/resource-library/')); ?>
        </ul>
      </div>
			<?php endif; // is_single() ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
	
	<!--footer class="entry-meta">
	</footer--><!-- .entry-meta -->
</article><!-- #post -->
