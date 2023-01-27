<?php
/**
 * Album Design 1 HTML
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>
<div class="<?php echo esc_attr( $wrpper_cls ); ?>">
	<div class="aigpl-inr-wrp">

		<div class="aigpl-img-wrp" style="<?php echo esc_attr( $album_height_css ); ?>">
			<a class="aigpl-img-link" href="<?php echo esc_url( $album_image ); ?>" target="<?php echo esc_attr( $album_link_target ); ?>">
				<?php if( $image_link ) { ?>
				<img class="aigpl-img" <?php if( $lazyload ) { ?>data-lazy="<?php echo esc_url( $image_link ); ?>" <?php } ?> src="<?php if( empty( $lazyload ) ) { echo esc_url( $image_link ); } ?>" alt="<?php the_title_attribute(); ?>" />
				<?php } ?>
			</a>
		</div>

		<?php if( $album_title ) { ?>
			<a class="aigpl-img-link" href="<?php echo esc_url( $album_image ); ?>" target="<?php echo esc_attr( $album_link_target ); ?>">
				<div class="aigpl-img-title aigpl-center"><?php echo wp_kses_post( $post->post_title ); ?></div>
			</a>
		<?php }

		if( ! empty( $total_photo_lbl ) ) { ?>
		<div class="aigpl-img-count aigpl-center"><?php echo esc_attr( $total_photo_lbl ); ?></div>
		<?php }

		if( $album_description ) {
		if( $album_full_content ) { ?>
			<div class="aigpl-img-desc aigpl-center"><?php echo wp_kses_post( wpautop( wptexturize( $post->post_content ) ) ); ?></div>
		<?php } else { ?>
			<div class="aigpl-img-desc aigpl-center"><?php echo aigpl_get_post_excerpt( $post->ID, get_the_content(), $words_limit, $content_tail ); ?></div>
		<?php } } ?>
	</div>
</div>