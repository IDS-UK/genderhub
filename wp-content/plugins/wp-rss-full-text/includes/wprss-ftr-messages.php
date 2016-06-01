<?php


/**
 * Message for WordPress version not being suitable
 * 
 * @since 1.0
 */
function wprss_ftr_min_wp_msg() {
	wp_die( "The WP RSS Aggregator - Full Text RSS add-on requires WordPress version " . WPRSS_FTR_WP_MIN_VERSION . " or higher." );
}


/**
 * Message for WP RSS Aggregator core not present, or version too low.
 * 
 * @since 1.0
 */
function wprss_ftr_min_core_msg() {
	?>
	<div class="error">
		<p>
			The <strong>WP RSS Aggregator - Full Text RSS</strong> add-on
			requires the WP RSS Aggregator plugin to be installed and activated, at version
			<strong><?php echo WPRSS_FTR_CORE_MIN_VERSION; ?></strong> or higher.
		</p>
	</div>
	<?php
}


/**
 * Message for WP RSS Aggregator Feed to Post not present, or version too low.
 * 
 * @since 1.0
 */
function wprss_ftr_min_ftp_msg() {
	?>
	<div class="error">
		<p>
			The <strong>WP RSS Aggregator - Full Text RSS</strong> add-on
			requires the WP RSS Aggregator - <strong>Feed to Post</strong> plugin to be installed and activated, at version
			<strong><?php echo WPRSS_FTR_FTP_MIN_VERSION; ?></strong> or higher.
		</p>
	</div>
	<?php
}