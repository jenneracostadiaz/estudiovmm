<?php
/**
 * Image Data Popup
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="aigpl-img-data-wrp aigpl-hide">
	<div class="aigpl-img-data-cnt">

		<div class="aigpl-img-cnt-block">
			<div class="aigpl-popup-close aigpl-popup-close-wrp"><img src="<?php echo AIGPL_URL; ?>assets/images/close.png" alt="<?php esc_html_e('Close (Esc)', 'album-and-image-gallery-plus-lightbox'); ?>" title="<?php esc_html_e('Close (Esc)', 'album-and-image-gallery-plus-lightbox'); ?>" /></div>

			<div class="aigpl-popup-body-wrp">
			</div><!-- end .aigpl-popup-body-wrp -->

			<div class="aigpl-img-loader"><?php esc_html_e('Please Wait', 'album-and-image-gallery-plus-lightbox'); ?> <span class="spinner"></span></div>

		</div><!-- end .aigpl-img-cnt-block -->

	</div><!-- end .aigpl-img-data-cnt -->
</div><!-- end .aigpl-img-data-wrp -->
<div class="aigpl-popup-overlay"></div>