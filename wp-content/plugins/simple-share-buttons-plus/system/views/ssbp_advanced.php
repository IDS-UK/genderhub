<?php

defined('ABSPATH') or die('No direct access permitted');

function ssbp_admin_advanced()
{

    // make sure we have settings ready
    $ssbp_settings = get_ssbp_settings();

    // ssbp header
    $htmlShareButtonsForm = ssbp_admin_header();

    // heading
    $htmlShareButtonsForm .= '<h2>Advanced Settings</h2>';

    // initiate forms helper
    $ssbpForm = new ssbpForms();

    // opening form tag
    $htmlShareButtonsForm .= $ssbpForm->open(false);

     // tabs
    $htmlShareButtonsForm .= '<ul class="nav nav-tabs">
							  <li class="active"><a href="#misc" data-toggle="tab">Misc</a></li>
							  <li><a href="#google_analytics" data-toggle="tab">Google Analytics</a></li>
							  <li><a href="#short_urls" data-toggle="tab">Short URLs</a></li>
							  <li><a href="#twitter" data-toggle="tab">Twitter</a></li>
							  <li><a href="#pinterest" data-toggle="tab">Pinterest</a></li>
							  <li><a href="#others" data-toggle="tab">Others</a></li>
							</ul>';
    // tab content div
    $htmlShareButtonsForm .= '<div id="ssbpTabContent" class="tab-content">';

        //======================================================================
        // 		MISC
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade active in" id="misc">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>You\'ll find a number of advanced and miscellaneous options below, to get your share buttons functioning just how you would like.</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

                // content priority
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'number',
                    'placeholder'   => '10',
                    'name'          => 'ssbp_content_priority',
                    'label'         => 'Content Priority',
                    'tooltip'       => 'Set the priority for your share buttons within your content. 1-10, default is 10',
                    'value'         => $ssbp_settings['ssbp_content_priority'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // load_font_in_head
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'load_font_in_head',
                    'label'        => 'Load SSBP font in head',
                    'tooltip'        => 'Enable this option to allow for the use of Async CSS loading',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['load_font_in_head'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // lazy loading
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'lazy_load',
                    'label'        => 'Lazy Loading',
                    'tooltip'        => 'Buttons will appear after page loads, strongly recommended if counters are enabled',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['lazy_load'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // use ssba
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'use_ssba',
                    'label'        => 'Use [ssba]',
                    'tooltip'        => 'Disable Simple Share Buttons Adder first! Use [ssba] instead of [ssbp]',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['use_ssba'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // nofollow
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'rel_nofollow',
                    'label'        => 'Nofollow',
                    'tooltip'        => 'Switch on to add nofollow to links',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['rel_nofollow'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // widget share text
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'Keeping sharing simple...',
                    'name'            => 'widget_text',
                    'label'        => 'Widget Share Text',
                    'tooltip'        => 'Add custom share text when used as a widget',
                    'value'            => $ssbp_settings['widget_text'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // show tracking page to admins only
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'checkbox',
                    'name'          => 'admin_only_tracking',
                    'label'         => 'Admin Only Tracking Access',
                    'tooltip'       => 'Enable this option to hide tracking to all users that are not Admins',
                    'value'         => 'Y',
                    'checked'       => ($ssbp_settings['admin_only_tracking'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close misc
        $htmlShareButtonsForm .= '</div>';

        //======================================================================
        // 		GOOGLE ANALYTICS
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade" id="google_analytics">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>Enable Google Analytics event tracking to see share clicks in your Analytics.</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

            // ga event tracking
            $opts = array(
                'form_group'    => false,
                'type'            => 'checkbox',
                'name'            => 'ga_onclick',
                'label'        => 'Google Analytics Event Tracking',
                'tooltip'        => 'Will show share button clicks within your Google Analytics Events, requires Google Analytics core tracking code to be present',
                'value'            => 'Y',
                'checked'        => ($ssbp_settings['ga_onclick'] == 'Y'  ? 'checked' : null),
            );
            $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // ga tracking
            $opts = array(
                'form_group'    => false,
                'type'          => 'text',
                'placeholder'   => 'UA-3823XX74-X',
                'name'          => 'ga_tracking_id',
                'label'         => 'Google Analytics Tracking ID',
                'tooltip'       => 'Enable Google Analytics tracking by entering your Tracking ID here',
                'value'         => $ssbp_settings['ga_tracking_id'],
            );
            $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // google track logged in users
            $opts = array(
                'form_group'    => false,
                'type'          => 'checkbox',
                'name'          => 'ga_track_logged_in',
                'label'         => 'Track Logged In Users',
                'tooltip'       => 'Switch on to track logged in users',
                'value'         => 'Y',
                'checked'       => ($ssbp_settings['ga_track_logged_in'] == 'Y'  ? 'checked' : null),
            );
            $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close google analytics
        $htmlShareButtonsForm .= '</div>';

        //======================================================================
        // 		SHORT URLS
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade" id="short_urls">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>Short URL settings, including third-party URL shorteners</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

                // use shortlinks
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'use_shortlinks',
                    'label'        => 'Use WP Shortlinks',
                    'tooltip'        => 'Your WP shortlinks will be used when sharing',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['use_shortlinks'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                 // bitly login
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'simplesharebuttons',
                    'name'            => 'bitly_login',
                    'label'        => 'Bitly Login',
                    'tooltip'        => 'Enter your Bitly login username',
                    'value'            => $ssbp_settings['bitly_login'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // bitly api key
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'E186C1237B6F1AC822EA62CE5EB95',
                    'name'            => 'bitly_api_key',
                    'label'        => 'Bitly API Key',
                    'tooltip'        => 'Your Bitly API Key from your registered application',
                    'value'            => $ssbp_settings['bitly_api_key'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close pinterest
        $htmlShareButtonsForm .= '</div>';

        //======================================================================
        // 		TWITTER
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade" id="twitter">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>Various extra options, especially for Twitter</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

                // twitter username
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text_prefix',
                    'prefix'        => '@',
                    'placeholder'    => 'fairtoshare',
                    'name'            => 'twitter_username',
                    'label'        => 'Twitter Username',
                    'tooltip'        => 'Add your username to tweets, will appear as \'via @fairtoshare\' for example',
                    'value'            => $ssbp_settings['twitter_username'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // twitter text
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'Simple Share Buttons',
                    'name'            => 'twitter_text',
                    'label'        => 'Twitter Text',
                    'tooltip'        => 'Add some custom text for when people share via Twitter',
                    'value'            => $ssbp_settings['twitter_text'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // twitter tags
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'fairtoshare,simplesharebuttons',
                    'name'            => 'twitter_tags',
                    'label'        => 'Twitter Tags',
                    'tooltip'        => 'Add hashtags for when people share via Twitter, comma-separated',
                    'value'            => $ssbp_settings['twitter_tags'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close twitter
        $htmlShareButtonsForm .= '</div>';

        //======================================================================
        // 		PINTEREST
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade" id="pinterest">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>Various extra options, especially for Pinterest</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

                // feature image pinning
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'pinterest_use_featured',
                    'label'        => 'Featured Image Pinning',
                    'tooltip'        => 'Enable to force the use of your Featured images for users when \'Pinning\'',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['pinterest_use_featured'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // feature image pinning
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'checkbox',
                    'name'            => 'pinterest_use_ssbp_meta',
                    'label'        => 'SSBP Meta Image Pinning',
                    'tooltip'        => 'Enable to force the use of your chosen SSBP Meta Images for users when \'Pinning\', requries SSBP meta information to be set',
                    'value'            => 'Y',
                    'checked'        => ($ssbp_settings['pinterest_use_ssbp_meta'] == 'Y'  ? 'checked' : null),
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close pinterest
        $htmlShareButtonsForm .= '</div>';

        //======================================================================
        // 		OTHERS
        //======================================================================
        $htmlShareButtonsForm .= '<div class="tab-pane fade" id="others">';

            // intro info
            $htmlShareButtonsForm .= '<blockquote><p>Various extra options, for any other social networks</p></blockquote>';

            // column for padding
            $htmlShareButtonsForm .= '<div class="col-sm-12">';

                // email message
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'I saw this and thought of you...',
                    'name'            => 'email_message',
                    'label'        => 'Email Text',
                    'tooltip'        => 'Add some text included in the email when people share that way',
                    'value'            => $ssbp_settings['email_message'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // flattr user id
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'davidsneal',
                    'name'            => 'flattr_user_id',
                    'label'        => 'Flattr User ID',
                    'tooltip'        => 'Enter your Flattr ID',
                    'value'            => $ssbp_settings['flattr_user_id'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // flattr url
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'https://simplesharebuttons.com',
                    'name'            => 'flattr_url',
                    'label'        => 'Flattr User ID',
                    'tooltip'        => 'This option is perfect for dedicated sites',
                    'value'            => $ssbp_settings['flattr_url'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

                // custom buffer text
                $opts = array(
                    'form_group'    => false,
                    'type'            => 'text',
                    'placeholder'    => 'This was shared via Buffer...',
                    'name'            => 'buffer_text',
                    'label'        => 'Custom Buffer Text',
                    'tooltip'        => 'Add some custom text for when people share via Buffer',
                    'value'            => $ssbp_settings['buffer_text'],
                );
                $htmlShareButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlShareButtonsForm .= '</div>';

        // close others
        $htmlShareButtonsForm .= '</div>';

    // close tab content div
    $htmlShareButtonsForm .= '</div>';

    // close off form with save button
    $htmlShareButtonsForm .= $ssbpForm->close();

    // ssbp footer
    $htmlShareButtonsForm .= ssbp_admin_footer();

    echo $htmlShareButtonsForm;
}
