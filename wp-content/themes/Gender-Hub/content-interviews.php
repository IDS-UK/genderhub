<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 07/06/16
 * Time: 13:19
 *
 * Content template for Interviews
 */

$interviewee_name = get_post_meta( $post->ID, '_interview_interviewee_name', true );
$interviewee_org = get_post_meta( $post->ID, '_interview_interviewee_org', true );
$interviewee_org_url = get_post_meta( $post->ID, '_interview_interviewee_org_url', true );
$interviewee_role = get_post_meta( $post->ID, '_interview_interviewee_role', true );
$interviewee_email = get_post_meta( $post->ID, '_interview_interviewee_email', true );
$interviewee_twitter = get_post_meta( $post->ID, '_interview_interviewee_twitter', true );
$interviewee_bio = get_post_meta( $post->ID, '_interview_interviewee_bio', true );
$interview_teaser = get_post_meta( $post->ID, '_interview_additional_teaser', true );
$interview_contact_point = get_post_meta( $post->ID, '_interview_contact_point', true );
$interview_date = get_post_meta($post->ID, '_interview_date', true);
?>

<?php
/**
 * layout for an archive page
 */
if ( is_home() || is_archive() || is_search() || !is_single() ) : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="archive-summary-container entry-summary ">

			<div class="archive-summary-image">
				<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
					<?php the_post_thumbnail('blog_featured'); ?>
				<?php endif; ?>
			</div>

			<div class="archive-summary-details">

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<p>
				<?php if($interviewee_name): ?>
				<strong><?php echo $interviewee_name; ?> </strong>
				<?php endif; ?>
				<?php if($interviewee_org): ?>
					(<strong><?php echo $interviewee_org; ?></strong>)<br/>
				<?php endif; ?>
					<strong><?php the_date(); ?></strong></p>
				<?php echo wpautop($interview_teaser)?:''; ?>
			</div>

		</div>

	</article>

<?php
/**
 * layout for a single interview
 */
else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="col col1_3">

			<div class="entry-featured-image">

				<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
					<a class="captioned-image"><?php the_post_thumbnail('blog_featured'); ?>
					<?php if ($interviewee_bio) : echo '<div class="image-text image-caption">'.wpautop($interviewee_bio).'</div>'; endif; ?>
					</a>
				<?php endif; ?>

			</div>

			<div class="sidebar-section section-highlight">

				<?php if($interviewee_name): ?>
					<p><?php echo $interviewee_name; ?>
				<?php endif; ?>
				<?php if($interviewee_org && $interviewee_org_url) : ?>
					<?php echo ' (<a href="'.$interviewee_org_url.'" target="_blank">'.$interviewee_org.'</a>)'; ?>
				<?php else : ?>
					<?php echo ' ('.$interviewee_org.')' ?>
				<?php endif; ?>
				<?php if($interviewee_role): ?>
					<?php echo ' - '.$interviewee_role; ?>
				<?php endif; ?>
				<?php if($interviewee_email): ?>
					<p>Email: <?php echo '<a href="mailto:'.$interviewee_email.'">'.$interviewee_email.'</a>'; ?></p>
				<?php endif; ?>
				<?php if($interviewee_twitter): ?>
					<p>Twitter: <?php echo '<a href="https://www.twitter.com/'.$interviewee_twitter.'" target="_blank">@'.$interviewee_twitter.'</a>'; ?></p>
				<?php endif; ?>

			</div>

			<?php if(!empty($interview_contact_point)): ?>

				<div class="sidebar-section nbm">

					<h3>Contact Point</h3>

					<?php echo GH_Custom_Post_Types::gh_get_contact_point($id=$interview_contact_point, $terms=NULL); ?>
					
				</div>

			<?php endif; ?>

			<div class="sidebar-section">
				<?php edit_post_link('Edit this interview', '<p>', '</p>'); ?>
			</div>

		</div>

		<div class="col col2_3">

			<header class="entry-header">

				<h1>
					<span><?php echo ucwords($post->post_type); ?></span>
				</h1>

				<?php the_title('<h2>', '</h2>'); ?>

				<p><strong><?php the_date(); ?></strong></p>

			</header>

			<div>

				<?php the_content(); ?>

				<?php echo do_shortcode('[ssbp]'); ?>

			</div>

			<?php comments_template(); ?>

		</div>

	</article>

<?php endif; ?>