<?php get_header(); ?>

<?php
	$blog_layout_option = '';

	if ( is_tag() || is_category() ) {
		$layout = ci_theme_get_layout_classes( 'layout_terms' );
	} else {
		$layout = ci_theme_get_layout_classes( 'layout_blog' );
	}

	$content_col       = $layout['content_col'];
	$sidebar_right_col = $layout['sidebar_right_col'];
	$sidebar_left_col  = $layout['sidebar_left_col'];
	$main_class        = $layout['main_class'];
	$post_col          = $layout['post_col'];
	$masonry           = $layout['masonry'];
?>

<div class="row <?php echo $layout['layout'] === 'classic_2side_right' ? 'sidebars-right' : ''; ?>">
	<div class="<?php echo esc_attr( $content_col ); ?>">
		<main id="content" class="<?php echo esc_attr( $main_class ); ?>">

			<div class="row">
				<div class="col-md-12">

					<?php if ( is_search() ) : ?>
						<?php
							global $wp_query;

							$found = $wp_query->found_posts;
							$none  = __( 'No results found. Please broaden your terms and search again.', 'ci-theme' );
							$one   = __( 'Just one result found. We either nailed it, or you might want to broaden your terms and search again.', 'ci-theme' );
							$many  = sprintf( _n( '%d result found.', '%d results found.', $found, 'ci-theme' ), $found );
						?>
						<article class="entry">
							<h2 class="entry-title">
								<?php _e( 'Search results' , 'ci-theme' ); ?>
							</h2>

							<div class="entry-content">
								<p><?php ci_theme_e_inflect( $found, $none, $one, $many ); ?></p>
								<?php if ( $found < 2 ) {
									get_search_form();
								} ?>
							</div>

							<div class="entry-utils group"></div>
						</article>
					<?php endif; ?>

					<?php if ( ! empty( $post_col ) ) : ?>
						<div class="row <?php echo esc_attr( $masonry ? 'entries-masonry' : '' ); ?>">
					<?php endif; ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'entry' ); ?>
					<?php endwhile; ?>

					<?php if ( ! empty( $post_col ) ) : ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php ci_theme_pagination(); ?>
		</main>
	</div>

	<?php if ( ! empty( $sidebar_left_col ) ) : ?>
		<div class="<?php echo esc_attr( $sidebar_left_col ); ?>">
			<div class="sidebar sidebar-left">
				<?php dynamic_sidebar( 'blog-left' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $sidebar_right_col ) ) : ?>
		<div class="<?php echo esc_attr( $sidebar_right_col ); ?>">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div><!-- /row -->

<?php get_footer(); ?>