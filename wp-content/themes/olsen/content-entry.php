<?php
	if ( is_tag() || is_category() ) {
		$layout = ci_theme_get_layout_classes( 'layout_terms' );
	} else {
		$layout = ci_theme_get_layout_classes( 'layout_blog' );
	}
	$post_class  = $layout['post_class'];
	$post_col    = $layout['post_col'];
	$masonry     = $layout['masonry'];
	$blog_layout = $layout['layout'];
	$is_classic  = false;

	global $wp_query;
	if( in_array( $layout['layout'], array( 'small_side', '2cols_side' ) ) && is_main_query() && $wp_query->current_post == 0 ) {
		$post_class = '';
		$post_col   = $layout['layout'] === '2cols_side' ? 'col-xs-12' : '';
		$masonry    = false;
		$is_classic = true;
	}

	if ( in_array( $blog_layout, array( 'classic_2side', 'classic_2side_right', 'classic_full', 'classic_1side' ) ) ) {
		$is_classic = true;
	}

	$hide_featured_image = get_post_meta( get_the_ID(), 'post_disable_featured_image', true );
?>

<?php if ( ! empty( $post_col ) ) : ?>
	<div class="<?php echo esc_attr( $post_col ); ?> <?php echo esc_attr( $masonry ? 'entry-masonry' : '' ); ?>">
<?php endif; ?>

<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry ' . $post_class ); ?>>
	<?php if ( get_post_type() === 'post' ) : ?>
		<div class="entry-meta entry-meta-top">
			<p class="entry-categories">
				<?php the_category( ', ' ); ?>
			</p>
		</div>
	<?php endif; ?>

	<h2 class="entry-title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>

	<?php if ( get_post_type() === 'post' ) : ?>
		<div class="entry-meta entry-meta-bottom">
			<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<a href="<?php echo esc_url( get_comments_link() ); ?>" class="entry-comments-no"><?php comments_number(); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( $is_classic && get_post_format() === 'gallery' ) : ?>
		<div class="entry-featured">
			<?php
				$gallery      = ci_theme_featgal_get_attachments( get_the_ID() );
				$gallery_type = get_post_meta( get_the_ID(), 'gallery_layout', true );
			?>
			<?php if ( $gallery->have_posts() ): ?>
				<?php if ( $gallery_type === 'tiled' ) : ?>
					<div class="entry-justified" data-height='150'>
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'large' ) ); ?>">
								<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
								<img src="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'ci_wide' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
							</a>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php else : ?>
					<div class="feature-slider slick-slider">
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<div class="slide">
								<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'large' ) ); ?>">
									<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
									<img src="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
								</a>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php elseif ( $is_classic && ( get_post_format() === 'audio' || get_post_format() === 'video' )) : ?>
		<?php // We don't want anything to appear here ?>
	<?php else : ?>
		<?php if ( has_post_thumbnail() && ! $hide_featured_image ) : ?>
			<div class="entry-featured">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $masonry ? 'ci_masonry' : 'post-thumbnail' ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( $is_classic && ! get_theme_mod( 'excerpt_on_classic_layout' ) ) {
			the_content( '' );
		} else {
			the_excerpt();
		} ?>
	</div>

	<div class="entry-utils group">
		<?php if ( ! $is_classic || ( $is_classic && get_theme_mod( 'excerpt_on_classic_layout' ) ) || ( $is_classic && ! get_theme_mod( 'excerpt_on_classic_layout' ) && ci_theme_has_more_tag() ) ): ?>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Continue Reading', 'ci-theme' ); ?></a>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'single_social_sharing', 1 ) ) {
			get_template_part( 'part-social-sharing' );
		} ?>
	</div>
</article>

<?php if ( ! empty( $post_col ) ) : ?>
	</div>
<?php endif; ?>
