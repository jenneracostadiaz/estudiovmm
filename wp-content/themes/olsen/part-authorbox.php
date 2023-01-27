<div class="entry-author group">
	<figure class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 90, 'avatar_default', esc_attr( get_the_author_meta( 'display_name' ) ) ); ?>
	</figure>

	<div class="author-details">
		<h4><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h4>

		<?php if ( get_the_author_meta( 'description' ) ): ?>
			<p class="author-excerpt">
				<?php echo esc_html( get_the_author_meta( 'description' ) ); ?>
			</p>
		<?php else: ?>
			<p class="author-excerpt">
				<?php _e( 'In this area you can display your biographic info. Just visit <em>Users > Your Profile > Biographic info</em>', 'ci-theme' ); ?>
			</p>
		<?php endif; ?>

		<?php get_template_part( 'part-social-icons' ); ?>
	</div>
</div>