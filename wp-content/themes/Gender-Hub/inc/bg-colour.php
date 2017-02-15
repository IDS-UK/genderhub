<?php 
$bgcolour = 'green'; // Default
if( has_term( 'Event', 'content_type',$post->ID ) || $post->post_type == 'events'):
$bgcolour = 'pink';
elseif( has_term( 'Blog', 'content_type',$post->ID ) || $post->post_type == 'blogs_opinions' ):
$bgcolour = 'orange';
elseif( has_term( 'News', 'content_type',$post->ID ) || $post->post_type == 'news_stories'):
$bgcolour = 'orange';
elseif( has_term( 'Training', 'content_type',$post->ID ) || $post->post_type == 'other_training'):
$bgcolour = 'pink';
elseif( has_term( 'Alert', 'content_type',$post->ID ) ):
$bgcolour = 'green';
elseif( has_term( 'Document', 'content_type',$post->ID ) ):
$bgcolour = 'green';
elseif( has_term( 'Story', 'content_type',$post->ID ) ):
$bgcolour = 'green';
elseif( has_term( 'Tool', 'content_type',$post->ID ) ):
$bgcolour = 'green';
endif;

