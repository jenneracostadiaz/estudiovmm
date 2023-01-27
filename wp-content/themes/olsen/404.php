<?php get_header(); ?>

<?php $sidebar = get_theme_mod( 'layout_other', 'side' ) === 'side' ? true : false; ?>

<div class="row">

	<div class="col-md-8 <?php echo esc_attr( $sidebar ? '' : 'col-md-offset-2' ); ?>">
		<main id="content">
			<div class="row">
				<div class="col-md-12">
					<article class="entry">
						<h2 class="entry-title">
							<?php _e( 'Page not found' , 'ci-theme' ); ?>
						</h2>

						<div class="entry-content">
							<p><?php _e( 'The page you were looking for can not be found! Perhaps try searching?', 'ci-theme' ); ?></p>
							<?php get_search_form(); ?>
						</div>
					</article>
				</div>
			</div>
		</main>
	</div>

	<?php if ( $sidebar ) : ?>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
