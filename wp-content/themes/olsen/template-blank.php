<?php
/*
* Template Name: Distraction Free
*/
?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php $padding_disabled = get_post_meta( get_the_ID(), 'blank_template_padding', true );?>
	<div class="row">
	<div class="col-xs-12">
		<main id="content" style="<?php echo ! empty( $padding_disabled ) ? '' : 'padding: 70px 0';?>">
			<div class="row">
				<div class="col-md-12">

						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-featured">
									<a class="ci-lightbox" href="<?php echo esc_url( ci_theme_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>">
										<?php the_post_thumbnail( 'ci_slider' ); ?>
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

							<?php comments_template(); ?>

						</article>

				</div>
			</div>
		</main>
	</div>
		
</div>
<?php endwhile; ?>

<?php get_footer(); ?>
