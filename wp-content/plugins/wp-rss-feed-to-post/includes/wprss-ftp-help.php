<?php

if ( ! defined( 'WPRSS_FTP_HELP_PREFIX' ) ) {
    define( 'WPRSS_FTP_HELP_PREFIX', 'field_f2p_' );
}

if ( class_exists('WPRSS_Help') ) {
    $help = WPRSS_Help::get_instance();

    $enclosure = $help->get_tooltip( 'field_wprss_enclosure' );
    $enc_text_arr = explode( "\n", $enclosure[WPRSS_Help::TOOLTIP_DATA_KEY_TEXT] );
    unset( $enc_text_arr[0] );
    $enc_text = 'Check this box to include a link to the enclosure tag in the content of imported posts.' . implode( "\n", $enc_text_arr );
    $help->set_tooltip( 'field_wprss_enclosure', $enc_text );

    $tooltips = array(
    	// General
    	'post_site'					=>	"Choose the site where the posts from the source will be imported.\n\nThis option can only be changed if you are on the main site of your multisite network.",
    	'post_type'					=>	"Choose the post type you want to import the imported feeds to.\n\nChanging this option will affect your taxonomy options further down this page.",
    	'post_status'				=>	"Choose the status for imported posts.",
    	'post_format'				=>	"Choose the post format to assign to imported feeds.",
    	'post_date'					=>	"Choose the date to use for imported posts.",
    	'comment_status'			=>	"Tick this box to enable comments for imported posts from this source",
		'force_full_content'		=>	"Check this box to forcefully attempt to retrieve the full feed content, if the feed only provides excerpts.",
		'allow_embedded_content'	=>	"Check this box to allow embedded content in posts (<code>iframe</code>, <code>embed</code> and <code>object</code> content).",
		'source_link'				=>	"Tick this box to add a link back to the original post, at the end of the post's content",
		'source_link_text'			=>	"Enter the text to use when linking back to the original post source.

										Wrap a phrase in asterisk symbols (<strong>*link to post*</strong>) to turn it into the link to the <strong>original post</strong>,
										or in double asterisk symbols (<strong>**link to source**</strong>) to turn it into a link to the post <strong>feed source</strong>",
		'canonical_link'			=>	'Check this box to add a rel="canonical" link to the head of imported posts.',
		'allow_local_requests'		=>	'Check this box if having trouble saving feed item images locally. This allows requests to local IPs.',
		'full_text_rss_service'		=>	'Choose the service to use for converting your RSS feeds into full text RSS feeds.

										Free services are available for use instantly, with no registration required, but are known to occasionally be unreliable and slow.
										Paid and premium services provide maximum reliability and performance, and will require you to obtain an <strong>API key</strong>.',

		// Images
		'save_images_locally'		=>	"Check this box to import the images from the post into your local media library.",
		'image_min_dimensions'		=>	"Set the minimum size that you would like for imported images (in pixels).\n\nThis option applies to images saved in the media library, as well as the featured image.",
		'use_featured_image'		=>	"Check this box to enable featured images for imported posts.",
		'featured_image'			=>	"Choose which image in the post to use as a featured image.",
        'fallback_to_feed_image'	=>	"Check this box to use the feed channel's image, if available, before resorting to the source fallback image",
		'remove_ft_image'			=>	"Check this box to remove the featured image from imported posts' content.

                                        This is particularly useful if you are retrieving the featured image from the post's content and your theme is showing the image twice. This option will remove the image in the post content, and leave the featured image.",

        // Authors
        'post_author'				=>	"Choose the author to assign to the post.\n\nYou can choose to use an existing user on your site as the author, or use the original author from the feed item.",
		'fallback_author'			=>	"This user is used if the plugin fails to determine an author or user.",

		// Taxonomies
        'taxonomies'                =>  'Click the <strong>Add New</strong> button to add a taxonomy section. In each section:

                                        <ol>
                                            <li>Choose the <strong>Taxonomy</strong> to use - such as <em>Category</em> or <em>Tags</em></li>
                                            <li>Then choose the <strong>terms</strong> to assign to imported posts</li>
                                            <li>If you want to import the terms from feed items, tick the <q>auto create</q> checkbox.</li>
                                        </ol>',

        // Extraction Rules
        'extraction_rules'          =>  'For each extraction rule, you\'ll need to enter the:

                                        <ul id="wprss-ftp-extraction-rules-desc">
                                            <li>
                                                <strong>CSS Selector:</strong>
                                                Enter the CSS selector(s) for the HTML element(s) you want to manipulate
                                            </li>
                                            <li>
                                                <strong>Manipulation:</strong>
                                                Choose what you want to do with the matching element(s)
                                            </li>
                                        </ul>',

        // Custom Fields
        'custom_fields'             =>  'For each mapping, you will need to enter the:

                                        <ul id="wprss-ftp-custom-fields-desc">
                                            <li>
                                                <strong>Namespace:</strong>
                                                Choose the namespace of the tag that you wish to read.
                                            </li>

                                            <li>
                                                <strong>RSS Tag:</strong>
                                                Enter the name of the tag in the RSS feed, excluding the namespace prefix.<br/>
                                                <em>For instance,</em> for iTunes artist tag, use just <code>artist</code>, <strong>not</strong> <code>im:artist</code>.
                                            </li>

                                            <li>
                                                <strong>Meta field name:</strong>
                                                Enter the name of the post meta field, where you wish to store the data.
                                            </li>
                                        </ul>',
        'namespace_detector'        =>  'Use this button to detect the namespaces being used by this feed source.',
        'user_namespaces'			=>	"These namespaces are used for mapping RSS data into imported posts' meta data, in the <strong>Custom Fields</strong> section when creating/editing feed sources.",

        // Legacy Feed Items
        'legacy_enabled'			=>	"Tick this box to re-enable the <strong>Feed Items</strong> and turn off post conversion for some feed sources.
										
										This will also allow you to activate the <strong>Categories</strong> and <strong>Excerpts &amp; Thumbnails</strong> add-ons.",

		// URL Shortening
		'url_shortening_method'		=>	"The service or algorithm to use for shortening",
		'google_api_key'			=>	"This key will be used for requests to the Google URL Shortener API",

    );

    $help->add_tooltips( $tooltips, WPRSS_FTP_HELP_PREFIX );
}