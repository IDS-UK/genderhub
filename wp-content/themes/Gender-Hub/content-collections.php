<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 08/06/16
 * Time: 17:39
 *
 * Content template for Collections
 */
?>


<?php if(get_the_ID() != 0 && get_the_ID() != ''): ?>
	<?php include('inc/bg-colour.php'); ?>
<?php endif;?>


	<?php
/**
 * layout for an archive page
 */
if ( is_home() || is_archive() || is_search() || !is_single() ) : ?>

	<?php $date = new DateTime(get_field('date')); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class($bgcolour); ?>>

		<div class="archive-summary-container">
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
				<div class="archive-summary-image">
					<?php the_post_thumbnail('thumbnail'); ?>
				</div>
			<?php endif; ?>
			<div class="archive-summary-details">
				<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
				<?php echo !empty($date) ? '<p>'.$date->format('M Y').'</p>' : ''; ?>
				<?php the_excerpt(); ?>
			</div>
		</div>

	</article>

<?php
/**
 * layout for a single collection
 */
else : ?>

	<article id="post-<?php the_ID(); ?>">
		
		<?php
		$term_id_list = wp_get_post_terms($post->ID, 'topics', array('fields' => 'ids'));
		$topics = implode(',',$term_id_list);
		?>

		<div class="col col1_3">

			<div class="entry-featured-image">
				<a class="captioned-image"><?php the_post_thumbnail('collection'); ?>
					<?php
					$thumbnail = get_post( get_post_thumbnail_id() );
					echo '<div class="image-text image-caption">'.apply_filters('the_content',$thumbnail->post_excerpt) .'</div>'; ?>
				</a>
				<?php echo '<div class="image-text image-credit">'.$thumbnail->post_content .'</div>'; ?>
			</div>

			<div class="sidebar-section section-highlight">

				<?php the_excerpt(); ?>

			</div>

			<?php

			$coll_cp = GH_Custom_Post_Types::gh_get_contact_point($id=NULL, $terms=$term_id_list);

			if (!empty($coll_cp)) : ?>

				<div class="sidebar-section nbm">

					<h3>Contact Point</h3>

					<?php echo $coll_cp; ?>

				</div>

			<?php
				endif;
			?>
			
			<div class="sidebar-section section-highlight">

				<h3>Subscribe</h3>
				<?php echo do_shortcode( '[contact-form-7 id="11686" title="Email Signup New"]' ); ?>

			</div>

			<div class="sidebar-section">

				<h3>Other Collections</h3>
				<?php echo do_shortcode( '[ghcollections type=sidebar]' ); ?>

			</div>

			<div class="sidebar-section">

				<?php edit_post_link('Edit this collection', '<p>', '</p>'); ?>

			</div>

		</div> <!-- slkr - /col1_3 -->

		<div class="col col2_3">

			<h1><span><?php echo ucwords($post->post_type); ?></span> </h1>
			<?php the_title('<h2>', '</h2>');?>

			<?php $collection_date = new DateTime(get_field('date')); ?>
			<?php echo get_field('date') != '' ? '<div class="collection-date">'.$collection_date->format('F Y').'</div>' : ''; ?>


			<?php the_content(); ?>

			<?php

			// slkr - Documents tabs
			$docs_post_types = array('ids_documents', 'practical_tools','programme_alerts','other_training');
			$topic_list = wp_get_post_terms($post->ID, 'topics', array(
				'fields' => 'all',
				'orderby' => 't.term_id'
			));
			?>

			<?php if (count($topic_list)>1) { ?>
				<div id="documents">
					<aside class="filter">
						<?php
						foreach($topic_list as $topic) : ?>
							<a rel="<?php echo $topic->term_id;?>" class="docfilter<?php echo $topic->parent === 0 ? ' active' : '' ;?>"><?php echo $topic->parent === 0 ? 'Topics' : $topic->name; ?></a>
						<?php endforeach;
						?>
					</aside>

					<div id="doc-container">
						<?php	$docsetcount = 1;
						foreach($topic_list as $topic) : ?>
							<div id="<?php echo $topic->term_id;?>" class="doclist"<?php echo $docsetcount > 1 ? ' style="display:none;"' : ''; ?>>
								<?php if ($docsetcount ===1) :
									echo '<p><br />In this collection:</p>';
									foreach($topic_list as $t) :
										echo $t->parent > 0 ? '<p class="topiclist"><a rel="'.$t->term_id.'" class="topicfilter">'.$t->name.'</a></p><p>'.$t->description.'</p>' : '';
									endforeach;
									$docsetcount++;
								else: ?>
								<div class="doc-topic-desc section-highlight">
									<?php echo $topic->description; ?>
								</div>
								<?php
								$args = array(
									'numberposts' => 100,
									'post_type' => $docs_post_types,
									'orderby' => 'post_date',
									'order' => 'DESC' ,
									'tax_query' => array(
										array('taxonomy' => 'topics',
										      'field'    => 'term_id',
										      'operator' => 'IN',
										      'terms'    => $topic->term_id,
										)
									)
								);
								$doc_posts = get_posts( $args );
								print '<p class="floatright"><em>'.count($doc_posts). ' documents</em></p>';
								foreach ( $doc_posts as $post ) :
								$c = get_post_custom($post->ID);
								$publisher = get_field('publisher');
								$publication_year = get_field('publication_year');
								?>
								<p class="doctitle"><span class="dtitle"><a href="<?php echo get_the_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></span>
									<?php if (!(empty($publisher) && empty($publication_year))) { ?>
										<?php echo '<span class="dpublisher">('; ?>
										<?php echo !empty($publisher) ? $publisher : ''; ?>
										<?php echo !empty($publication_year) ? (!empty($publisher) ? ' - ': '') .$publication_year : '';?>
										<?php echo ')</span>'; ?>
									<?php } ?>
									<?php echo wpautop(wp_trim_words(get_the_excerpt(), 70)); ?>
									<?php echo '</p>';?>
									<?php endforeach;
									$docsetcount++;
									wp_reset_postdata();?>

									<?php endif; ?>
							</div> <!-- slkr - /docs -->
						<?php endforeach; ?>
					</div>
				</div> <!-- slkr - /documents -->

			<?php } else {   // No sub-topics, just one top-level ?>

				<div id="documents">

					<div id="doc-container">

						<div class="doclist doclist-single">
							<?php
							wp_reset_postdata();
							$args = array(
								'numberposts' => 100,
								'post_type' => $docs_post_types,
								'orderby' => 'post_date',
								'order' => 'DESC',
								'tax_query' => array(
									array('taxonomy' => 'topics',
									      'field'    => 'term_id',
									      'operator' => 'IN',
									      'terms'   => $topics
									)
								)
							);
							?>
							<?php foreach($topic_list as $topic) : ?>
								<div class="doc-topic-desc section-highlight">
									<?php echo $topic->description; ?>
								</div>
							<?php endforeach; ?>
							<?php $doc_posts = get_posts( $args );
							print '<p><em>'.count($doc_posts). ' documents</em></p>';
							foreach ( $doc_posts as $post ) :
							$c = get_post_custom($post->ID);
							$publisher = get_field('publisher');
							$publication_year = get_field('publication_year');
							?>
							<p class="doctitle"><span class="dtitle"><a href="<?php echo get_the_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></span>
								<?php if (!(empty($publisher) && empty($publication_year))) { ?>
									<?php echo '<span class="dpublisher">(';
									print(!empty($publisher) ? $publisher : '');
									print(!empty($publication_year) ? (!empty($publisher) ? ' - ': '') .$publication_year : '');
									print(')</span>'); ?>
								<?php } ?>
								<?php echo wpautop(wp_trim_words(get_the_excerpt(), 50)); ?>
								<?php endforeach;
								$docsetcount++;

								wp_reset_postdata();?>
						</div>

					</div>

				</div>
			<?php }

			$featured=maybe_unserialize(get_post_meta($post->ID,'featured_content',true));

			if ($featured):
				$args = array(
					'numberposts' => 10,
					'post_type' => 'any',
					'include' => $featured
				);

				$myposts = get_posts( $args );

				if(count($myposts)>0): ?>

					<h3>Featured content</h3>
					<div id="featured_content">

						<?php
						$i = 1;
						foreach ( $myposts as $post ) :
							$post_type=get_post_type($post->ID);
							$idsarray = array('news_stories', 'events', 'programme_alerts','blogs_opinions','practical_tools','other_training');
							if(in_array($post_type,$idsarray)):
								$post_type='ids_documents';
							endif;
							$type='content-'.$post_type;

							setup_postdata($post);

							//$wp_query->post->ID = $post->ID; // slkr - this was breaking ALL the things
							include('inc/bg-colour.php');

							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class($bgcolour); ?> <?php if($i==2||$i==4||$i==6||$i==8||$i==10): echo 'style="clear:right"'; endif;?> >
								<!-- HEADER -->
								<header class="entry-header">

									<h6 class="entry-title">
										<?php
										// Pulls in the relevant icon
										include('inc/icon.php');
										?><?php the_title(); ?><?php
										// Pulls in the relevant icon
										include('inc/icon.php');
										?>
									</h6>

								</header><!-- .entry-header -->

								<?php the_post_thumbnail('thumbnail');?>
								<?php the_excerpt();?>
								<p><a class="button" href="<?php the_permalink();?>">Read more</a></p>
							</article>

							<?php $i++; endforeach;
						wp_reset_postdata();
						?>
					</div>

				<?php endif; ?>
			<?php endif; ?>
		</div>

	</article>

<?php endif; ?>