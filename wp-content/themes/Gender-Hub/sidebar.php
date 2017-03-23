<?php
/**
 * The sidebar containing the widget area
 */

if ( !is_active_sidebar( 'knowledge-sidebar' ) ) {
	return;
}
?>

	<div id="tertiary" class="sidebar-container" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'knowledge-sidebar' ); ?>
			</div>
		</div>
	</div>