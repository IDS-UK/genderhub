<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 04/06/2016
 * Time: 12:12
 */
if ( !defined( 'ABSPATH' ) ) exit;
class GenderHub_Report_Class {

	public function __construct() {

		// todo slikkr - tidy variables
		
	}
	
	public function do_post_count($y, $m, $t) {

		$today  = date('Y m');
		$date   = explode(' ', $today);

		$year   = $y?:$date[0];
		$month  = $m?:$date[1];

		$types  = $t?:array('blogs_opinions', 'events', 'other_training', 'news_stories', 'practical_tools', 'interviews', 'ids_documents');

		$args = array(

			'date_query' => array(
				array(
					'year'  => $year,
					'month' => $month,
				),
			),
			'post_type'     => $types,
			'post_status'   => 'publish'
		);

		if ($types == 'practical_tools') {

			$args['post_type'] = 'ids_documents';

			$args['tax_query'] = array(
				array(
					'taxonomy' => 'content_type',
					'field'    => 'slug',
					'terms'    => 'tool',
				),
			);

		}
		
		$query = new WP_Query( $args );

		//$count = $query->post_count
                $count = $query->found_posts;

		return $count;

	}

	public function fetch_report_tablerows($y, $m, $t) {

		$today          = date('Y n');
		$date           = explode(' ', $today);

		$cal_months     = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for ($year=2002; $year<2020; $year++) {
			$cal_years[] = $year;
		} //      = array(2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016);

		$year           = $y?:$date[0];
		$month          = $m?:$date[1];
		$month_name     = date("F", mktime(0, 0, 0, $month, 10));

		$types          = $t?:array('blogs_opinions', 'events', 'other_training', 'news_stories', 'practical_tools', 'interviews', 'ids_documents');

		$html = '';


		$html .= '<form>';
		$html .= '<h2 style="margin:20px 0;">'.$month_name.' '.$year.'</h2>';

		$html .= '<label style="margin: 20px 0;">Show report for </label>';

		$html .= '<select name="month">';

		$i=1;
		foreach ($cal_months as $cal_month) {
			$html .= '<option value="'.$i.'"'.selected($month, $i, false).'>'.$cal_month.'</option>';
			$i++;
		}

		$html .= '</select>';

		$html .= '<select name="year">';

		foreach ($cal_years as $cal_year) {
			$html .= '<option value="'.$cal_year.'"'.selected($year, $cal_year, false).'>'.$cal_year.'</option>';
		}

		$html .= '</select>';

		$html .= '<input type="hidden" name="page" value="gh-reports" />';
		$html .= '<input type="submit" value="Go">';
		$html .= '</form>';

		$html .= '<table class="wp-list-table widefat striped">';
		$html .= '<thead><tr>';
		$html .= '<th scope="col" class="manage-column column-primary">Content type</th>';
		$html .= '<th scope="col" class="manage-column">No.</th>';
		$html .= '</tr></thead>';
		$html .= '<tbody id="the-list" class="ui-sortable">';

		foreach ($types as $type) {

			$obj = get_post_type_object( $type );
			$type_name = $obj->labels->name;
			$slug = $obj->rewrite['slug'];
                        //$html .= '<pre>'.print_r($obj->rewrite,true).'</pre>';
                        $count  = $this->do_post_count($year, $month, $type);

			$html .= '	<tr>';
			$html .= '	<td>'.'<a href="/'.$slug.'">'.$type_name.'</a></td>';
			$html .= '	<td>'.$count.'</td>';
			$html .= '	</tr>';

		}

		$html .= '</tbody></table>';

		return $html;

	}
	
}