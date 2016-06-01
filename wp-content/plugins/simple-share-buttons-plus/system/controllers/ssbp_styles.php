<?php
defined('ABSPATH') or die('No direct access permitted');

    // get (or generate then get) SSBP_CSS file
    function ssbp_stylesheets()
    {
        // if css file doesn't exist
        if (!@file_exists(SSBP_CSS)) {
            // create and save settings.json file
            $fp = @fopen(SSBP_CSS, 'wb');

            // unable to create the file
            if ($fp === false) {
                // add CSS to the head
                add_action('wp_head', 'ssbp_style_head');
            }
            // file created successfully
            else {
                // get, collate and minify all needed CSS
                $css = ssbp_get_css();
                @fwrite($fp, $css);
                @fclose($fp);

                // make sure we can delete the file when changes are made
                chmod(SSBP_CSS, 0755);

                // enqueue the created stylesheet
                wp_enqueue_style('ssbp_styles', plugins_url('ssbp.min.css', SSBP_FILE));
            }
        }
        // file exists
        else {
            // enqueue the created stylesheet
            wp_enqueue_style('ssbp_styles', plugins_url('ssbp.min.css', SSBP_FILE));
        }
    }

    // add ssbp font in head
    function ssbp_font_in_head()
    {

        // css style
        $htmlStyle = '<style type="text/css">';

            // get ssbp font
            $htmlStyle .= ssbp_get_font_family();

        // close style tag
        $htmlStyle .= '</style>';

        // output to head
        echo $htmlStyle;
    }

    // add css to head
    function ssbp_style_head()
    {

        // css style
        $htmlStyle = '<style type="text/css">';

            // get, collate and minify all needed CSS
            $htmlStyle .= ssbp_get_css();

        // close style tag
        $htmlStyle .= '</style>';

        // output to head
        echo $htmlStyle;
    }

    // get, collate and minify all needed css
    function ssbp_get_css()
    {
        // define css variables
        $css = '';

        // get ssbp settings
        $ssbp_settings = get_ssbp_settings();

        // if some custom styles have been set
        if ($ssbp_settings['custom_styles_enabled'] == 'Y') {
            // use custom css only
            return ssbp_minify_css($ssbp_settings['custom_styles']);
        }

        // if we haven't set to load the font in the head
        if ($ssbp_settings['load_font_in_head'] != 'Y') {
            // add it to the custom CSS file
            $css .= ssbp_get_font_family();
        }

        // if custom images are not enabled
        if ($ssbp_settings['custom_images'] != 'Y') {
            // base style file
            $base = SSBP_ROOT.'/sharebuttons/assets/css/ssbp-base.css';

            // read css contents and add to css
            $fileCSS = fopen($base, 'r');
            $css .= fread($fileCSS, filesize($base));
            fclose($fileCSS);

            // theme style file
            $theme = SSBP_ROOT.'/sharebuttons/assets/css/themes/'.$ssbp_settings['default_style'].'.css';

            // read css contents and add to css
            $fileCSS = fopen($theme, 'r');
            $css .= fread($fileCSS, filesize($theme));
            fclose($fileCSS);

            // if the first set has been set as responsive
            if ($ssbp_settings['one_responsive'] == 'Y') {
                // mobile style file
                $mobile = SSBP_ROOT.'/sharebuttons/assets/css/ssbp-mobile.css';

                // read css contents and add to css
                $fileCSS = fopen($mobile, 'r');
                $css .= fread($fileCSS, filesize($mobile));
                fclose($fileCSS);
            }

            // if a second set is enabled
            if ($ssbp_settings['two_style'] != '') {
                // theme style file
                $theme = SSBP_ROOT.'/sharebuttons/assets/css/themes/'.$ssbp_settings['two_style'].'.css';

                // read css contents and add to css
                $fileCSS = fopen($theme, 'r');
                $css .= fread($fileCSS, filesize($theme));
                fclose($fileCSS);
            }
        }

        // get extra style
        $css .= get_ssbp_settings_styles();

        // add additional css last to take priority over all other css
        $css .= $ssbp_settings['additional_css'];

        // return all the css
        return $css;

        return ssbp_minify_css($css);
    }

    // add ssbp_ga_onclick to footer
    function ssbp_ga_onclick()
    {
        echo "<script>
var ssbpTrackGA = function(url,network) {
ga('send', 'event', 'share_buttons', 'Share to '+network, url, {'hitCallback': null});
console.log('Share click pushed to Google Analytics');
}
</script>";
    }

    // add scripts for page/post use
    function ssbp_page_scripts()
    {
        // get ssbp settings
        $ssbp_settings = get_ssbp_settings();

        // if lazy load is enabled
        if ($ssbp_settings['lazy_load'] == 'Y') {
            // lazy load stuff
            wp_enqueue_script('ssbp_lazy_callback', plugins_url('js/ssbp_lazy.min.js', SSBP_FILE), array('jquery'), false, true);
            wp_localize_script('ssbp_lazy_callback', 'ssbpLazy', array(

                // URL to wp-admin/admin-ajax.php to process the request
                'ajax_url' => admin_url('admin-ajax.php'),

                // generate a nonce with a unique ID
                'security' => wp_create_nonce('ssbp-lazy-nonce'),
            ));

            // ajax stuff
            wp_enqueue_script('ssbp_tracking_callback', plugins_url('js/ssbp_page.js', SSBP_FILE), array('jquery'), false, true);
            wp_localize_script('ssbp_tracking_callback', 'ssbpAjax', array(

                // URL to wp-admin/admin-ajax.php to process the request
                'ajax_url' => admin_url('admin-ajax.php'),

                // generate a nonce with a unique ID
                'security' => wp_create_nonce('ssbp-ajax-nonce'),
            ));
        }
        // not lazy loading
        else {
            // ajax stuff
            wp_register_script('ssbp_standard_callback', plugins_url('js/ssbp_standard.min.js', SSBP_FILE), array('jquery'), false, true);
            wp_localize_script('ssbp_standard_callback', 'ssbpAjax', array(

                // URL to wp-admin/admin-ajax.php to process the request
                'ajax_url' => admin_url('admin-ajax.php'),

                // generate a nonce with a unique ID
                'security' => wp_create_nonce('ssbp-ajax-nonce'),
            ));
            wp_enqueue_script('ssbp_standard_callback');
        }

        // if a font family is set
        if ($ssbp_settings['font_family'] != '') {
            // register and enqueue the font family
            wp_register_style('ssbpFont', '//fonts.googleapis.com/css?family='.$ssbp_settings['font_family']);
            wp_enqueue_style('ssbpFont');
        }
    }

    // generate style
    function get_ssbp_settings_styles()
    {
        // get ssbp settings
        $ssbp_settings = get_ssbp_settings();

        // define empty css variable
        $css = '';

        // if there's some share text
        if ($ssbp_settings['share_text'] != '') {
            // share text margin depending on its placement
            switch ($ssbp_settings['text_placement']) {
                // above
                case 'above':
                    $ssbpTextMargin = 'margin:0 0 10px 0;';
                    break;

                // below
                case 'below':
                    $ssbpTextMargin = 'margin:10px 0 0 0;';
                    break;

                // right
                case 'right':
                    $ssbpTextMargin = 'margin:0 0 10px 0;';
                    break;

                // left
                case 'left':
                    $ssbpTextMargin = 'margin:0 15px 0 0;';
                    break;
            }

            // share text weight as chosen
            switch ($ssbp_settings['font_weight']) {
                // light
                case 'light':
                    $ssbpFontWeight = 'font-weight:light;';
                    break;

                // normal
                case 'normal':
                    $ssbpFontWeight = 'font-weight:normal;';
                    break;

                // bold
                case 'bold':
                    $ssbpFontWeight = 'font-weight:bold;';
                    break;
            }

            $font_family = (str_replace('+', ' ', $ssbp_settings['font_family']));

            // add share text css
            $css .= '.ssbp-share-text{'.$ssbpFontWeight.$ssbpTextMargin.($ssbp_settings['font_family'] != '' ? 'font-family:'.$font_family.';' : null).'font-size:'.($ssbp_settings['font_size'] != '' ? $ssbp_settings['font_size'] : 20).'px;color:'.$ssbp_settings['font_color'].'}';
        }

        // if custom images are not enabled
        if ($ssbp_settings['custom_images'] != 'Y') {
            // SET ONE
            // if style one is fixed
            if (in_array($ssbp_settings['set_one_position'], array(
                'fixed-left',
                'fixed-right',
                'fixed-bottom',
            ))) {
                // hide the share text
                $css .= '.ssbp-set--one .ssbp-share-text{display:none!important;}';
            }

            // if any custom colours are set for set one
            if (
                ($ssbp_settings['icon_color']        != '') ||
                ($ssbp_settings['color_main']        != '')
            ) {
                // open button class
                $css .= '.ssbp-set--one .ssbp-btn{';

                // if an icon colour is set, use it
                if ($ssbp_settings['icon_color'] != '') {
                    $css .= 'color:'.$ssbp_settings['icon_color'].';';
                }

                // if a button colour is set, use it
                if ($ssbp_settings['color_main'] != '') {
                    $css .= 'background-color:'.$ssbp_settings['color_main'].';';
                }

                // close button class
                $css .= '}';
            }

            // if any custom hover colours are set for set one
            if (
                ($ssbp_settings['icon_color_hover'] != '') ||
                ($ssbp_settings['color_hover']        != '')
            ) {
                // open button hover class
                $css .= '.ssbp-set--one .ssbp-btn:hover{';

                // if a button hover colour is set, use it
                if ($ssbp_settings['color_hover'] != '') {
                    $css .= 'background-color:'.$ssbp_settings['color_hover'].'!important;';
                }

                // if an icon hover colour is set, use it
                if ($ssbp_settings['icon_color_hover'] != '') {
                    $css .= 'color:'.$ssbp_settings['icon_color_hover'].'!important;';
                }

                // close button hover class
                $css .= '}';
            }

            // if any custom sizes are set for set one
            if (
                ($ssbp_settings['button_width']    != '') ||
                ($ssbp_settings['button_height']    != '') ||
                ($ssbp_settings['icon_size']        != '') ||
                ($ssbp_settings['button_margin']    != '')
            ) {
                // open button hover class
                $css .= '.ssbp-set--one .ssbp-btn{';

                // if a button margin is set, use it
                if ($ssbp_settings['button_margin'] != '') {
                    $css .= 'margin:'.$ssbp_settings['button_margin'].'px!important;';
                }

                // if a button width is set, use it
                if ($ssbp_settings['button_width'] != '') {
                    $css .= 'width:'.$ssbp_settings['button_width'].'em!important;';
                }

                // if a button height is set, use it
                if ($ssbp_settings['button_height'] != '') {
                    // add btn height
                    $css .= 'height:'.$ssbp_settings['button_height'].'em!important;';

                    // close btn class
                    $css .= '}';

                    // add line height
                    $css .= '.ssbp-set--one .ssbp-btn{';
                    $css .= 'line-height:'.$ssbp_settings['button_height'].'em!important;';
                    $css .= '}';
                } else {
                    // close btn class - sizes
                    $css .= '}';
                }

                // if an icon size is set, use it
                if ($ssbp_settings['icon_size'] != '') {
                    $css .= '.ssbp-set--one .ssbp-btn:before{';
                }
                $css .= 'font-size:'.$ssbp_settings['icon_size'].'px!important;';
                $css .= '}';
            }

            // SET TWO
            // if a second set is enabled
            if ($ssbp_settings['two_style'] != '') {
                // if style two is fixed
                if (in_array($ssbp_settings['set_two_position'], array(
                    'fixed-left',
                    'fixed-right',
                    'fixed-bottom',
                ))) {
                    // hide the share text
                    $css .= '.ssbp-set--two .ssbp-share-text{display:none!important;}';
                }
                // if any custom colours are set for set two
                if (
                    ($ssbp_settings['icon_color_two']        != '') ||
                    ($ssbp_settings['color_main_two']        != '')
                ) {
                    // open button class
                    $css .= '.ssbp-set--two .ssbp-btn{';

                    // if an icon colour is set, use it
                    if ($ssbp_settings['icon_color_two'] != '') {
                        $css .= 'color:'.$ssbp_settings['icon_color_two'].';';
                    }

                    // if a button colour is set, use it
                    if ($ssbp_settings['color_main_two'] != '') {
                        $css .= 'background-color:'.$ssbp_settings['color_main_two'].';';
                    }

                    // close button class
                    $css .= '}';
                }

                // if any custom hover colours are set for set two
                if (
                    ($ssbp_settings['icon_color_hover_two'] != '') ||
                    ($ssbp_settings['color_hover_two']        != '')
                ) {
                    // open button hover class
                    $css .= '.ssbp-set--two .ssbp-btn:hover{';

                    // if a button hover colour is set, use it
                    if ($ssbp_settings['color_hover_two'] != '') {
                        $css .= 'background-color:'.$ssbp_settings['color_hover_two'].'!important;';
                    }

                    // if an icon hover colour is set, use it
                    if ($ssbp_settings['icon_color_hover_two'] != '') {
                        $css .= 'color:'.$ssbp_settings['icon_color_hover_two'].'!important;';
                    }

                    // close button hover class
                    $css .= '}';
                }

                // if any custom sizes are set for set two
                if (
                    ($ssbp_settings['button_two_width']    != '') ||
                    ($ssbp_settings['button_two_height']    != '') ||
                    ($ssbp_settings['icon_two_size']        != '') ||
                    ($ssbp_settings['button_two_margin']    != '')
                ) {
                    // open button hover class
                    $css .= '.ssbp-set--two .ssbp-btn{';

                    // if a button margin is set, use it
                    if ($ssbp_settings['button_two_margin'] != '') {
                        $css .= 'margin:'.$ssbp_settings['button_two_margin'].'px!important;';
                    }

                    // if a button width is set, use it
                    if ($ssbp_settings['button_two_width'] != '') {
                        $css .= 'width:'.$ssbp_settings['button_two_width'].'em!important;';
                    }

                    // if a button height is set, use it
                    if ($ssbp_settings['button_two_height'] != '') {
                        // add btn height
                        $css .= 'height:'.$ssbp_settings['button_two_height'].'em!important;';

                        // close btn class
                        $css .= '}';

                        // add line height
                        $css .= '.ssbp-set--two .ssbp-btn{';
                        $css .= 'line-height:'.$ssbp_settings['button_two_height'].'em!important;';
                        $css .= '}';
                    } else {
                        // close btn class - sizes
                        $css .= '}';
                    }

                    // if an icon size is set, use it
                    if ($ssbp_settings['icon_two_size'] != '') {
                        $css .= '.ssbp-set--two .ssbp-btn:before{';
                        $css .= 'font-size:'.$ssbp_settings['icon_two_size'].'px!important;';
                        $css .= '}';
                    }
                }
            }
            // return the css
            return $css;
        }// end set two enabled
        // custom images are enabled

        // important overrides of base
        $css .= '.ssbp-toggle-switch{display:none!important}';
        $css .= '.ssbp-input-url{display:none!important}';
        $css .= '.ssbp-list{list-style:none!important;}';
        $css .= '.ssbp-list li{display: inline !important;}';

        // if share counts are not set to display
        if ($ssbp_settings['one_share_counts'] != 'Y') {
            // hide them
            $css .= '.ssbp-each-share{display:none!important;}';
        }

        // if total share counts are not set to display
        if ($ssbp_settings['one_total_share_counts'] != 'Y') {
            // hide them
            $css .= '.ssbp-total-shares{display:none!important;}';
        }

        // image css
        $css .= '.ssbp-container img
					{
						width: '.$ssbp_settings['image_width'].'px !important;
						height: '.$ssbp_settings['image_height'].'px !important;
						margin: '.$ssbp_settings['image_padding'].'px;
						border:  0;
						box-shadow: none !important;
						vertical-align: middle;
						display:inline!important;
					}
					.ssbp-container a
					{
						border:0!important;
					}
					.ssbp-container img:after {
					    content:"\A";
					    position:absolute;
					    width:100%; height:100%;
					    top:0; left:0;
					    background:rgba(0,0,0,0.6);
					    opacity:0;
					    transition: all 0.5s;
					    -webkit-transition: all 0.5s;
					}
					.ssbp-container img:hover:after {
					    opacity:1;
					}';

        $css .= '.ssbp-container {margin-bottom:10px;}';

        // strip out spaces to keep tidy
        $css = ssbp_minify_css($css);

        // return
        return $css;
    }

    // get ssbp font family
    function ssbp_get_font_family()
    {
        $plugins_url = plugins_url();
        $plugins_url = str_replace('https:', '', $plugins_url);
        $plugins_url = str_replace('http:', '', $plugins_url);

        return "@font-face {
					font-family: 'ssbp';
					src:url('".$plugins_url."/simple-share-buttons-plus/sharebuttons/assets/fonts/ssbp.eot?xj3ol1');
					src:url('".$plugins_url."/simple-share-buttons-plus/sharebuttons/assets/fonts/ssbp.eot?#iefixxj3ol1') format('embedded-opentype'),
						url('".$plugins_url."/simple-share-buttons-plus/sharebuttons/assets/fonts/ssbp.woff?xj3ol1') format('woff'),
						url('".$plugins_url."/simple-share-buttons-plus/sharebuttons/assets/fonts/ssbp.ttf?xj3ol1') format('truetype'),
						url('".$plugins_url."/simple-share-buttons-plus/sharebuttons/assets/fonts/ssbp.svg?xj3ol1#ssbp') format('svg');
					font-weight: normal;
					font-style: normal;

					/* Better Font Rendering =========== */
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
				}";
    }

    // minify css on the fly
    function ssbp_minify_css($ssbpCSS)
    {
        // Remove comments
        $ssbpCSS = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $ssbpCSS);

        // search and replace arrays
        $ssbpSearch = array(': ',', ',' {','; ',' ;');
        $ssbpReplace = array(':',',','{',';',';');

        // Remove space after colons
        $ssbpCSS = str_replace($ssbpSearch, $ssbpReplace, $ssbpCSS);

        // Remove whitespace
        $ssbpCSS = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ssbpCSS);

        // return it
        return $ssbpCSS;
    }
