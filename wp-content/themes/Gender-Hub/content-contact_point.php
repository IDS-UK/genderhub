<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 09/06/2016
 * Time: 10:47
 *
 * Content template for Contact Points
 */

$cp_url = get_post_meta( $post->ID, '_contact_point_url', true );
$cp_email = get_post_meta( $post->ID, '_contact_point_email', true );
$cp_twitter = get_post_meta( $post->ID, '_contact_point_twitter', true );
$cp_facebook = get_post_meta( $post->ID, '_contact_point_facebook', true );
?>

<?php
/**
 * layout for an archive page
 */
if ( is_home() || is_archive() || is_search() || is_singular() ) : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="archive-summary-container entry-summary ">

			<div class="archive-summary-image">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('blog_featured'); ?>
				<?php endif; ?>
			</div>

			<div class="archive-summary-details">

				<h2 class="entry-title">
					<?php the_title(); ?>
				</h2>

				<?php echo $cp_url ? '<p><a href="'.$cp_url.'" target="_blank">'.$cp_url.'</a></p>' : ''; ?>
				<?php echo $cp_email ? '<p><a href="mailto:'.$cp_email.'" target="_blank">'.$cp_email.'</a></p>' : ''; ?>
				<?php echo $cp_twitter ? '<p><a href="https://www.twitter.com/'.$cp_twitter.'" target="_blank">'.$cp_twitter.'</a></p>' : ''; ?>
				<?php echo $cp_facebook ? '<p><a href="'.$cp_facebook.'" target="_blank">'.$cp_facebook.'</a></p>' : ''; ?>
				
			</div>

		</div>

	</article>

	<?php
/**
 * layout for a single contact point
 */
else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="entry-featured-image">

				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail('blog_featured'); ?>
				<?php endif; ?>

			</div>

			<div>

				<?php the_title('<h2>', '</h2>'); ?>

				<?php echo $cp_url ? '<p><a href="'.$cp_url.'" target="_blank">'.$cp_url.'</a></p>' : ''; ?>
				<?php echo $cp_email ? '<p><a href="mailto:'.$cp_email.'" target="_blank">'.$cp_email.'</a></p>' : ''; ?>
				<?php echo $cp_twitter ? '<p><a href="https://www.twitter.com/'.$cp_twitter.'" target="_blank">'.$cp_twitter.'</a></p>' : ''; ?>
				<?php echo $cp_facebook ? '<p><a href="'.$cp_facebook.'" target="_blank">'.$cp_facebook.'</a></p>' : ''; ?>

			</div>

			<?php the_content(); ?>

	</article>

<?php endif; ?>