<?php
	$signoff_text    = get_the_author_meta( 'user_greeting_text' );
	$signature_text  = get_the_author_meta( 'user_signature_text' );
	$signature_image = get_the_author_meta( 'user_signature_image' );
?>
<?php if ( ! empty( $signoff_text ) || ! empty( $signature_text ) || ! empty( $signature_image ) ): ?>
	<div class="entry-sig">
		<p>
			<?php echo esc_html( $signoff_text ); ?>
			<?php if ( ! empty( $signature_image ) ): ?>
				<?php echo wp_get_attachment_image( $signature_image, 'ci_masonry' ); ?>
			<?php elseif ( ! empty( $signature_text ) ): ?>
				<span><?php echo esc_html( $signature_text ); ?></span>
			<?php endif; ?>
		</p>
	</div>
<?php endif; ?>
