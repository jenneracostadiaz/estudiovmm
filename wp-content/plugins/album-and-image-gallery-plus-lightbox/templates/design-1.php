<?php
/**
 * Design 1 HTML
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>
<div class="<?php echo esc_attr( $wrpper_cls ); ?>" data-item-index="<?php echo esc_attr( $loop_count ); ?>">
	<div class="aigpl-inr-wrp">
		<div class="aigpl-img-wrp" style="<?php echo esc_attr( $height_css ); ?>">
			<?php if( $image_link ) {
				if( $popup == 'true' ) { ?>
					<a class="aigpl-img-link" data-mfp-src="<?php echo esc_url( $image_link ); ?>" href="javascript:void(0);" target="<?php echo esc_attr( $link_target ); ?>">
						<img class="aigpl-img" <?php if( $lazyload ) { ?>data-lazy="<?php echo esc_url( $gallery_img_src ); ?>" <?php } ?> src="<?php if( empty( $lazyload ) ) { echo esc_url( $gallery_img_src ); } ?>" alt="<?php echo esc_attr( $image_alt_text ); ?>" />
					</a>
				<?php } else { ?>
					<a class="aigpl-img-link" href="<?php echo esc_url( $image_link ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
						<img class="aigpl-img" <?php if( $lazyload ) { ?>data-lazy="<?php echo esc_url($gallery_img_src); ?>" <?php } ?> src="<?php if(empty($lazyload)) { echo esc_url( $gallery_img_src ); } ?>" alt="<?php echo esc_attr( $image_alt_text ); ?>" />
					</a>
				<?php }
			} else { ?>
				<img class="aigpl-img" <?php if( $lazyload ) { ?>data-lazy="<?php echo esc_url( $gallery_img_src ); ?>" <?php } ?> src="<?php if( empty( $lazyload ) ) { echo esc_url( $gallery_img_src ); } ?>" alt="<?php echo esc_attr( $image_alt_text ); ?>" />
			<?php }

			if( $show_caption && $gallery_post->post_excerpt ) { ?>
				<div class="aigpl-img-caption">
					<?php echo wp_kses_post( $gallery_post->post_excerpt ); ?>
				</div>
			<?php } ?>
		</div>

		<?php if( $show_title ) { ?>
		<div class="aigpl-img-title aigpl-center"><?php echo wp_kses_post( $gallery_post->post_title ); ?></div>
		<?php }

		if( $show_description && ! empty( $gallery_post->post_content ) ) { ?>
			<div class="aigpl-img-desc aigpl-center"><?php echo wp_kses_post( wpautop( wptexturize( $gallery_post->post_content ) ) ); ?></div>
		<?php } ?>
	</div>
</div>