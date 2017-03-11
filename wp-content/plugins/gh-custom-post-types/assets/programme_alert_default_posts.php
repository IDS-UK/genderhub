<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 11/03/2017
 * Time: 02:00
 */

$wp_upload_dir = wp_upload_dir();
$default_posts = array(

	array(
		'post_data'     => array(
			'post_type'         => 'programme_alerts',
			'post_status'       => 'publish',
			'post_excerpt'      => 'Why environment and climate change is a gender issue',
			'post_title'        => 'Interview: Nguavese Tracy Ogbonna',
			'post_content'      => '',
			'post_author'       => 1,
		),
		'post_meta'     => array(
			'link_text'         => 'Read more',
			'link_url'          => home_url().'/be-inspired/interviews/interview-nguavese-tracy-ogbonna/',
			'in_slider'         => 1,
			'slider_color'      => 'orangebg'
		),
		'image_data'    => array (
			'guid'              => $wp_upload_dir['url'].'/7826332218_cb85abdabb_k-e1472560151463.jpg',
			'post_content'      => 'Why environment and climate change is a gender issue',
			'post_status'       => 'inherit'
		),
		'image_meta'    => array (
			'credit_text'       => 'WorldBank',
			'credit_url'        => 'https://www.flickr.com/photos/worldbank/7826332218/in/album-72157631164602748/'
		)
	),


	array(
		'post_data'     => array(
			'post_type'         => 'programme_alerts',
			'post_status'       => 'publish',
			'post_excerpt'      => 'Building on V4C\'s ‘Being a Man in Nigeria’  research report, this e-learning course will help participants to explore further why we should and how best to engage men towards gender equality. ',
			'post_title'        => 'Free e-learning course: Engaging men for gender equality',
			'post_content'      => '',
			'post_author'       => 1,
		),
		'post_meta'     => array(
			'link_text'         => 'Find out more',
			'link_url'          => home_url().'/build-capacity/elearning-from-us/',
			'in_slider'         => 1,
			'slider_color'      => 'pinkbg'
		),
		'image_data'    => array (
			'guid'              => $wp_upload_dir['url'].'/gender-hub-JAN2017-homepage-1.jpg',
			'post_content'      => 'Building on V4C\'s ‘Being a Man in Nigeria’  research report, this e-learning course will help participants to explore further why we should and how best to engage men towards gender equality. ',
			'post_status'       => 'inherit'
		),
		'image_meta'    => array (
			'credit_text'       => NULL,
			'credit_url'        => NULL
		)
	),


	array(
		'post_data'     => array(
			'post_type'         => 'programme_alerts',
			'post_status'       => 'publish',
			'post_excerpt'      => 'Four Christian and Muslim girls who escaped the kidnapping by Boko Harram of nearly two hundred schoolgirls from their school in Chibok.',
			'post_title'        => 'Resource Collection: Gender, Youth and Education',
			'post_content'      => '',
			'post_author'       => 1,
		),
		'post_meta'     => array(
			'link_text'         => 'Explore the Collection',
			'link_url'          => home_url().'/collections/gender-youth-and-education/',
			'in_slider'         => 1,
			'slider_color'      => 'greenbg'
		),
		'image_data'    => array (
			'guid'              => $wp_upload_dir['url'].'/Panos-purchased-image-00186763.jpg',
			'post_content'      => 'What are the main barriers faced by girls in getting an education? This Collection highlights teaching approaches, policies and practices supporting young women to move into employment and further education.',
			'post_status'       => 'inherit'
		),
		'image_meta'    => array (
			'credit_text'       => 'Panos | Sven Torfinn',
			'credit_url'        => NULL
		)
	),


	array(
		'post_data'     => array(
			'post_type'         => 'programme_alerts',
			'post_status'       => 'publish',
			'post_excerpt'      => 'Fashion designer Ejiro Amos Tafiri, 28, in her busy workshop as she and her team work hard producing her latest collection that will hit the runway at the Lagos Fashion and and Design',
			'post_title'        => 'Resource Collection: Gender and Livelihoods',
			'post_content'      => '',
			'post_author'       => 1,
		),
		'post_meta'     => array(
			'link_text'         => 'Read more',
			'link_url'          => home_url().'/collections/gender-and-livelihoods/',
			'in_slider'         => 1,
			'slider_color'      => 'greenbg'
		),
		'image_data'    => array (
			'guid'              => $wp_upload_dir['url'].'/170217-panos-00209626-720px-v2.jpg',
			'post_content'      => 'Why is the experience of the world of paid work in Nigeria a gendered one? This Collection explores the challenges faced by Nigerian women in the labour market, & how they attempt to make paid work work for them.',
			'post_status'       => 'inherit'
		),
		'image_meta'    => array (
			'credit_text'       => 'Panos | Andrew Esiebo',
			'credit_url'        => NULL
		)
	),


	array(
		'post_data'     => array(
			'post_type'         => 'programme_alerts',
			'post_status'       => 'publish',
			'post_excerpt'      => 'On March 8th we celebrate the social, economic, cultural and political achievements of Nigerian women. Yet we also must bring the masses together and #BeBoldForChange - to forge a more inclusive, gender equal world.',
			'post_title'        => 'Event: March 8th is International Women\'s Day!',
			'post_content'      => '',
			'post_author'       => 1,
		),
		'post_meta'     => array(
			'link_text'         => 'Take Action...',
			'link_url'          => home_url().'/build-capacity/events/international-womens-day-2/',
			'in_slider'         => 1,
			'slider_color'      => 'pinkbg'
		),
		'image_data'    => array (
			'guid'              => $wp_upload_dir['url'].'/bus-driver-cropped2-hashtags.jpg',
			'post_content'      => 'A woman drives a bus with male and female passengers',
			'post_status'       => 'inherit'
		),
		'image_meta'    => array (
			'credit_text'       => NULL,
			'credit_url'        => NULL
		)
	),


);

return $default_posts;