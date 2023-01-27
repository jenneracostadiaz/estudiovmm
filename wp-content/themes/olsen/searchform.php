<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'ci-theme' ); ?></label>
		<input type="text" placeholder="<?php echo esc_attr_x( 'Search', 'search box placeholder', 'ci-theme' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
		<button class="searchsubmit" type="submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'ci-theme' ); ?></span></button>
	</div>
</form>