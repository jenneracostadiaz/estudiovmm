<div class="sidebar sidebar-right">
	<?php
		if( is_page_template( 'template-listing-looks.php' ) ) {
			dynamic_sidebar( 'blog' );
		} elseif( is_page() && is_active_sidebar( 'page' ) ) {
			dynamic_sidebar( 'page' );
		} else {
			dynamic_sidebar( 'blog' );
		}
	?>
</div><!-- /sidebar -->
