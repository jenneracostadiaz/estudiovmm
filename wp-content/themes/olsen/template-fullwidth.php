<?php
/*
* Template Name: Fullwidth Page
*/
?>

<?php get_header(); ?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<main id="content">
			<div class="row">
				<div class="col-md-12">

					<?php while ( have_posts() ) : the_post(); ?>
						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-featured">
									<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
										<?php the_post_thumbnail( 'post-thumbnail' ); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>

							<?php if ( get_theme_mod( 'page_signature', 1 ) ) {
								get_template_part( 'part', 'signature' );
							} ?>

							<div class="entry-utils group">
								<?php if ( get_theme_mod( 'page_social_sharing', 1 ) ) {
									get_template_part( 'part-social-sharing' );
								} ?>
							</div>

							<?php comments_template(); ?>

						</article>
					<?php endwhile; ?>

				</div>
			</div>
		</main>
	</div>
</div>

<?php get_footer(); ?>
