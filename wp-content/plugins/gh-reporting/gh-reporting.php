<?php
/*
Plugin Name: GH Reporting
Plugin URI: https://www.slikkr.com/
Description: Content reports
Version: 0.8
Author: Sarah Cox
Author URI: https://www.slikkr.com
Text Domain: genderhub
*/
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 04/06/2016
 * Time: 01:19
 */

if ( !defined( 'ABSPATH' ) ) exit;
require_once 'inc/gh-report-class.php';

function gh_reporting_menu() {

	$page_title = 'Content Reports';
	$menu_title = 'Content Reports';
	$capability = 'edit_others_posts';
	$menu_slug  = 'gh-reports';
	$function   = 'gh_reports_page';

	add_dashboard_page (
		$page_title,
		$menu_title,
		$capability,
		$menu_slug,
		$function
	);
}
add_action('admin_menu', 'gh_reporting_menu');

function gh_add_dash_widgets() {
	//wp_add_dashboard_widget('gh_dashboard_widget', 'Gender Hub Content Reports', 'gh_reports_dash_widget');
	add_meta_box('gh_dashboard_widget', 'Gender Hub Content Reports', 'gh_reports_dash_widget', 'dashboard', 'side', 'high');
}
add_action('wp_dashboard_setup', 'gh_add_dash_widgets' );

function gh_reports_dash_widget( $post, $callback_args ) {

	$query  = new GenderHub_Report_Class();
	
	$count = $query->do_post_count($year=null, $month=null, $types=null);

	$html = '';

	$html .= '<table width="100%">';
	$html .= '	<tr>';
	$html .= '		<td style="width:80%"><p>Total content items so far this month:</p></td>';
	$html .= '		<td><p>'.$count.'</p></td>';
	$html .= '	</tr>';

	$html .= '</table>';

	$html .= '<p><a href="'.get_bloginfo('url').'/wp-admin/index.php?page=gh-reports" title="See more reports">See detailed reports</a></p>';

	echo $html;
}

function gh_reports_page() {

	$query = new GenderHub_Report_Class();

	$year       = $_GET['year']?:null;
	$month      = $_GET['month']?:null;
	$types      = $_GET['types']?:null;

	$options = get_option( 'gh_custom_misc_settings' );

	$reports_narrative = '';
	if( isset( $options['gh_reports_narrative'] ) ) {
		$reports_narrative = $options['gh_reports_narrative'];
	}
	
	$html = '';

	$html .= '<div class="wrap">';
	$html .= '<h1>Gender Hub Content Report</h1>';

	$html .= wpautop($reports_narrative);

	$html .= $query->fetch_report_tablerows($year, $month, $types);

	$html .= '</div>';

	echo $html;

}