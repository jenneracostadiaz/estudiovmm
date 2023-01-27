<?php
	add_action( 'admin_init', 'ci_theme_cpt_post_add_metaboxes' );
	add_action( 'save_post', 'ci_theme_cpt_post_update_meta' );

	function ci_theme_cpt_post_add_metaboxes() {
		add_meta_box( 'ci-layout-box', __( 'Post Utilities', 'ci-theme' ), 'ci_theme_add_cpt_post_layout_meta_box', 'post', 'normal', 'high' );
		add_meta_box( 'ci-gallery-box', __( 'Gallery Details', 'ci-theme' ), 'ci_theme_add_cpt_post_gallery_meta_box', 'post', 'normal', 'high' );
	}

	function ci_theme_cpt_post_update_meta( $post_id ) {

		if ( ! ci_theme_can_save_meta( 'post' ) ) {
			return;
		}

		update_post_meta( $post_id, 'layout', in_array( $_POST['layout'], array( 'sidebar', 'full', 'full_wide' ) ) ? $_POST['layout'] : '' );
		update_post_meta( $post_id, 'secondary_featured_id', intval( $_POST['secondary_featured_id'] ) );
		update_post_meta( $post_id, 'gallery_layout', in_array( $_POST['gallery_layout'], array( 'tiled', 'slider' ) ) ? $_POST['gallery_layout'] : '' );
		ci_theme_metabox_gallery_save( $_POST );
		update_post_meta( $post_id, 'post_disable_featured_image', ci_theme_sanitize_checkbox_ref( $_POST['post_disable_featured_image'] ) );
		update_post_meta( $post_id, 'post_disable_affiliate_link', ci_theme_sanitize_checkbox_ref( $_POST['post_disable_affiliate_link'] ) );
	}

	function ci_theme_add_cpt_post_layout_meta_box( $object, $box ) {
		ci_theme_prepare_metabox( 'post' );

		?><div class="ci-cf-wrap"><?php
			ci_theme_metabox_open_tab( __( 'Layout', 'ci-theme' ) );
				$options = array(
					'sidebar' => _x( 'With sidebar', 'post layout', 'ci-theme' ),
					'full'    => _x( 'Full width narrow', 'post layout', 'ci-theme' ),
					'full_wide'    => _x( 'Full width wide', 'post layout', 'ci-theme' ),
				);
				ci_theme_metabox_dropdown( 'layout', $options, __( 'Post layout:', 'ci-theme' ) );

				ci_theme_metabox_checkbox( 'post_disable_featured_image', 1, esc_html__( 'Hide the featured image of this post', 'ci-theme' ) );
				ci_theme_metabox_checkbox( 'post_disable_affiliate_link', 1, esc_html__( 'Hide the affiliate disclosure link (Set in Customizer > Posts Options)', 'ci-theme' ) );

			ci_theme_metabox_close_tab();

			ci_theme_metabox_open_tab( __( 'Secondary image', 'ci-theme' ) );
				ci_theme_metabox_guide( __( 'The <em>Looks</em> page template uses images in portrait (tall) orientation. If the Featured Image of this post is in landscape (wide) orientation, you may want to provide a portrait image to be used instead, otherwise an automatically cropped image (based on the Featured Image) will be used.', 'ci-theme' ) );

				$secondary_featured_id = get_post_meta( $object->ID, 'secondary_featured_id', true );
				?>
				<div class="ci-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $secondary_featured_id ) ): ?>
							<?php
								$image_url = ci_theme_get_image_src( $secondary_featured_id, 'ci_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( __('Remove image', 'ci-theme') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="ci-uploaded-id" name="secondary_featured_id" value="<?php echo esc_attr( $secondary_featured_id ); ?>" />
					<input type="button" class="button ci-media-button" value="<?php esc_attr_e( 'Select Image', 'ci-theme' ); ?>" />
				</div>
				<?php
			ci_theme_metabox_close_tab();
		?></div><?php
	}

	function ci_theme_add_cpt_post_gallery_meta_box( $object, $box ) {
		ci_theme_prepare_metabox( 'post' );

		?><div class="ci-cf-wrap"><?php
			ci_theme_metabox_open_tab( '' );
				$options = array(
					'tiled' => _x( 'Tiled', 'gallery layout', 'ci-theme' ),
					'slider'  => _x( 'Slider', 'gallery layout', 'ci-theme' ),
				);
				ci_theme_metabox_dropdown( 'gallery_layout', $options, __( 'Gallery layout:', 'ci-theme' ) );

				ci_theme_metabox_gallery();
			ci_theme_metabox_close_tab();
		?></div><?php

		ci_theme_bind_metabox_to_post_format( 'ci-gallery-box', 'gallery', 'mb_format_gallery_box' );
	}
