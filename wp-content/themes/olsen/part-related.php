<?php $related = ci_get_related_posts( get_the_ID(), 3 ); ?>
<?php if ( $related->have_posts() ): ?>
	<div class="entry-related aquafondo">
		<?php if ( get_theme_mod( 'single_related_title', __( 'You may also like', 'ci-theme' ) ) ): ?>
			<h4><?php echo esc_html( get_theme_mod( 'single_related_title', __( 'You may also like', 'ci-theme' ) ) ); ?></h4>
		<?php endif; ?>

		<div class="row">
			<?php while ( $related->have_posts() ): $related->the_post(); ?>
				<div class="col-sm-4">
					<?php get_template_part( 'content', 'entry-widget' ); ?>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<div class="volver"><a href="/noticias">Volver a noticias</a></div>
	</div>
<?php endif; ?>
