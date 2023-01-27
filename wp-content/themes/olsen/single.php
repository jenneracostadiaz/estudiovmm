<?php get_header(); ?>
<style>
.cerra {
    position: inherit !important;
    background-color: #004a80 !important;
}
</style>
<?php
	$layout              = get_post_meta( get_queried_object_id(), 'layout', true );
	$hide_featured_image = get_post_meta( get_queried_object_id(), 'post_disable_featured_image', true );
	$hide_affiliate_link = get_post_meta( get_queried_object_id(), 'post_disable_affiliate_link', true );
	$image_size          = $layout === 'full_wide' ? 'ci_slider' : 'post-thumbnail';
?>

<div class="row">

	<div class="<?php echo $layout === 'full_wide' ? 'col-xs-12' : 'col-md-8' ?> <?php echo esc_attr( $layout === 'full' ? 'col-md-offset-2' : '' ); ?>">
		<main id="content">
			<div class="row">
				<div class="col-md-12">

					<?php while ( have_posts() ) : the_post(); ?>
						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

							<?php if ( get_theme_mod( 'single_categories', 1 ) ) : ?>
								<div class="entry-meta entry-meta-top">
									<p class="entry-categories">
										<?php the_category( ', ' ); ?>
									</p>
								</div>
							<?php endif; ?>
                            <div class="entry-meta entry-meta-bottom aquafondo">
								<?php if ( get_theme_mod( 'single_date', 1 ) ) : ?>
									<time class="entry-date aquafondo" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<?php endif; ?>
							</div>
							<h2 class="entry-title aquafondo">
								<?php the_title(); ?>
							</h2>

							

							<div class="entry-featured">
								<?php
									$gallery      = ci_theme_featgal_get_attachments( get_the_ID() );
									$gallery_type = get_post_meta( get_the_ID(), 'gallery_layout', true );
								?>
								<?php if ( 'gallery' === get_post_format() && $gallery->have_posts() ) : ?>
									<?php if ( $gallery_type === 'tiled' ) : ?>
										<div class="entry-justified" data-height="150">
											<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
												<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'large' ) ); ?>">
													<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
													<img src="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'ci_wide' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
												</a>
											<?php endwhile; ?>
											<?php wp_reset_postdata(); ?>
										</div>
									<?php else : ?>
										<div class="slick-slider home-slider">
											<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
												<div class="slide">
													<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), 'large' ) ); ?>">
														<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
														<img src="<?php echo esc_url( ci_theme_get_image_src( get_the_ID(), $image_size ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
													</a>
												</div>
											<?php endwhile; ?>
											<?php wp_reset_postdata(); ?>
										</div>
									<?php endif; ?>
								<?php elseif ( has_post_thumbnail() && get_theme_mod( 'single_featured', 1 ) && ( get_post_format() !== 'video' ) && ( get_post_format() !== 'audio' && ! $hide_featured_image ) ) : ?>
									<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
										<?php the_post_thumbnail( $image_size ); ?>
									</a>
								<?php endif; ?>
							</div>


							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>

							<?php if ( get_theme_mod( 'single_tags', 1 ) && has_tag() ) : ?>
								<div class="entry-tags">
									<?php the_tags( '', '' ); ?>
								</div>
							<?php endif; ?>
							
							<?php if ( get_theme_mod( 'single_brands', 1 ) && has_term( '', 'brand' ) ) : ?>
								<div class="entry-brands">
									<?php the_terms( $post->ID, 'brand', '', '' ); ?>
								</div>
							<?php endif; ?>	
							
							<?php if ( ( get_theme_mod( 'single_affiliate_title' ) && get_theme_mod( 'single_affiliate_link' ) ) && !$hide_affiliate_link ) : ?>
									<div class="entry-affiliate">
										<a href="<?php echo esc_url( get_theme_mod( 'single_affiliate_link' ) ); ?>">
											<?php echo esc_html( get_theme_mod( 'single_affiliate_title' ) ); ?>
										</a>
									</div>
							<?php endif; ?>


							<?php if ( get_theme_mod( 'single_signature', 1 ) ) {
								get_template_part( 'part', 'signature' );
							} ?>

							<?php if ( get_theme_mod( 'single_social_sharing', 1 ) ) : ?>
							<div class="entry-utils group">
								<?php get_template_part( 'part-social-sharing' ); ?>
							</div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'single_nextprev', 1 ) ) : ?>
								<div id="paging" class="group">
									<?php
										$prev_post = get_previous_post();
										$next_post = get_next_post();
									?>
									<?php if( ! empty( $next_post ) ): ?>
										<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="antena paging-standard paging-older"><?php _e( 'Anterior', 'ci-theme' ); ?></a>
									<?php endif; ?>
									<?php if( ! empty( $prev_post ) ): ?>
										<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="antena paging-standard paging-newer"><?php _e( 'Siguiente', 'ci-theme' ); ?></a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'single_authorbox', 1 ) ) {
								get_template_part( 'part', 'authorbox' );
							} ?>

							<?php if ( get_theme_mod( 'single_related', 1 ) ) {
								get_template_part( 'part', 'related' );
							} ?>

							<?php if( get_theme_mod( 'single_comments', 1 ) ) {
								comments_template();
							} ?>

						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</main>
	</div>

	<?php if ( $layout === 'sidebar' ) : ?>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>
</div><!-- /row -->
<?php get_footer(); ?>

