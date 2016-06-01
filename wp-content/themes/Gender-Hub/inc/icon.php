<?php 
if( has_term( 'Event', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/event-icon.png" /></span>';
elseif( has_term( 'Blog', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/blog-icon.png" /></span>';
elseif( has_term( 'News', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/news-icon.png" /></span>';
elseif( has_term( 'Training', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/05/training-icon.png" /></span>';
elseif( has_term( 'Alert', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/bell-icon.png" /></span>';
elseif( has_term( 'Document', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/document-icon.png" /></span>';
elseif( has_term( 'Story', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/speech-bubbles-icon.png" /></span>';
elseif( has_term( 'Tool', 'content_type',$post->ID ) ):
echo '<span class="floatright"><img src="/wp-content/uploads/2015/06/presentation-icon.png" /></span>';
endif;