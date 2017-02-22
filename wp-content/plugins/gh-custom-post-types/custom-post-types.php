<?php
/*
Plugin Name: GH Custom Post Types
Plugin URI: https://www.slikkr.com/
Description: Installs theme-independent custom post types
Version: 1.6
Author: Sarah Cox
Author URI: http://www.slikkr.com
Text Domain: genderhub
*/
class GH_Custom_Post_Types {

	function __construct() {

		add_action('init', array($this, 'init'));

		add_action('admin_menu', array($this, 'add_content_intros'));

		add_action('publish_ids_documents', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_contact_point', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_events', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_blogs_opinions', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_other_training', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_programme_alerts', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_practical_tools', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_news_stories', array($this, 'gh_select_parent_terms'), 10, 2);
		add_action('publish_collections', array($this, 'gh_select_parent_terms'), 10, 2);

		add_shortcode('ghcollections', array($this, 'gh_archive_shortcode'));
		add_shortcode('ghinterviews', array($this, 'gh_archive_shortcode'));
		add_shortcode('ghcontact_point', array($this, 'gh_archive_shortcode'));

	}

	function init() {

		$post_types = array(
			'blocks',
			'blogs_opinions',
			'collections',
			'contact_point',
			'events',
			'facebook',
			'interviews',
			'news_stories',
			'other_training',
			'practical_tools',
			'programme_alerts',
		);

		foreach($post_types as $post_type) {

			// slkr - include the specifications for this post type ...
			include_once ('post_types/'.$post_type.'.php' );
			// slkr - ... and register it
			register_post_type( $post_type , $args=call_user_func('fetch_args_' . $post_type) );
		}

		$taxonomies = array(
			'topics',
			'resource_type',
			'content_type',
			'attribution',
		);

		foreach($taxonomies as $taxonomy) {

			// slkr - include the specifications for this taxonomy ...
			include_once ('taxonomies/'.$taxonomy.'.php' );
			$t=call_user_func('fetch_args_' . $taxonomy);
			// slkr - ... and register it
			register_taxonomy( $taxonomy, $t['post_types'], $t['args']);

		}

	}

	function add_content_intros() {
		add_options_page('Content intros', 'Content intros', 'manage_options', 'functions', array($this, 'add_content_intros_page'));
	}

	function add_content_intros_page() {

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

	function gh_select_parent_terms($post_ID, $post) {
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

	function gh_archive_shortcode($atts, $content, $tag) {

		$type = str_replace('gh', '', $tag);

		ob_start();

		if($atts == NULL) {
			$atts =
				shortcode_atts(
					array(
						'type'  => ''
					), $atts, $tag
				);
		}

		$args = array(
			'numberposts' => 20,
			'post_type' => $type,
			'order'     => 'DESC'
		);

		$items = new WP_Query( $args );

		if(($atts['type'] == 'sidebar')) {

			$html = '';

			$html .= '<div class="archive-summary-container">';
			$html .= '<ul class="linklist '.$type.'">';

			if ( $items->have_posts() ) : while ($items->have_posts()) : $items->the_post();

				$html .= '<li><a href="'.get_the_permalink().'">'.$items->post->post_title;
				$html .= !empty($date) ? ' ('.$date->format('M Y').')</a></p>' : '</a></li>';

			endwhile;

			endif;

			$html .= '</ul>';

			$html .= '</div>';

			wp_reset_postdata();
			wp_reset_query();

			return $html;

		} else {

			if ( $items->have_posts() ) : while ($items->have_posts()) : $items->the_post();

				get_template_part( 'content', $type );

			endwhile;

			endif;

		}

		return ob_get_clean();

	}

	/**
	 * @param $id
	 * @param $terms
	 *
	 * @return string
	 *
	 * Can return a contact_point based on either
	 * an array of terms (e.g. via single-collections.php)
	 * or a specific contact_point id (e.g. via single-interviews.php)
	 */
	public static function gh_get_contact_point($id, $terms) {

		if ($id) {

			ob_start();

			$args = array(
				'numberposts' => 1,
				'post_type' => array('contact_point'),
				'p' => $id
			);

			$query = new WP_query( $args );

			if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

				get_template_part( 'content', 'contact_point' );

			endwhile;

			endif;

			wp_reset_postdata();
			wp_reset_query();

			return ob_get_clean();

		} else {

			ob_start();

			$args = array(
				'numberposts' => 1,
				'post_type' => array('contact_point'),
				'tax_query' => array(

					array(
						'taxonomy' => 'topics',
						'field'    => 'term_id',
						'operator' => 'IN',
						'terms'    => $terms,
					))
			);

			$query = new WP_query( $args );

			if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

				get_template_part( 'content', 'contact_point' );

			endwhile;

			endif;

			wp_reset_postdata();
			wp_reset_query();

			return ob_get_clean();

		}

	}
}

new GH_Custom_Post_Types;