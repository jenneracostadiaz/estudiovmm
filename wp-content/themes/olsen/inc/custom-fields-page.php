<?php
	add_action( 'admin_init', 'ci_theme_cpt_page_add_metaboxes' );
	add_action( 'save_post', 'ci_theme_cpt_page_update_meta' );

	function ci_theme_cpt_page_add_metaboxes() {
		add_meta_box( 'ci-tpl-looks-box', __( 'Looks Details', 'ci-theme' ), 'ci_theme_add_cpt_page_looks_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'ci-tpl-blank-box', __( 'Distraction Free Details', 'ci-theme' ), 'ci_theme_add_cpt_page_blank_meta_box', 'page', 'normal', 'high' );
	}

	function ci_theme_cpt_page_update_meta( $post_id ) {

		if ( ! ci_theme_can_save_meta( 'page' ) ) {
			return;
		}

		update_post_meta( $post_id, 'looks_base_category', intval( $_POST['looks_base_category'] ) );
		update_post_meta( $post_id, 'looks_posts_per_page', ci_theme_sanitize_intval_or_empty( $_POST['looks_posts_per_page'] ) );
		update_post_meta( $post_id, 'looks_layout', in_array( $_POST['looks_layout'], array( '2cols_side', '3cols_full' ) ) ? $_POST['looks_layout'] : '2cols_side' );

		update_post_meta( $post_id, 'blank_template_padding', ci_theme_sanitize_checkbox_ref( $_POST['blank_template_padding'] ) );
	}

	function ci_theme_add_cpt_page_looks_meta_box( $object, $box ) {
		ci_theme_prepare_metabox( 'page' );

		?><div class="ci-cf-wrap"><?php
			ci_theme_metabox_open_tab( '' );

				$options = array(
					'2cols_side' => __( '2 Columns - With sidebar', 'ci-theme' ),
					'3cols_full' => __( '3 Columns - Full width', 'ci-theme' ),
				);
				ci_theme_metabox_dropdown( 'looks_layout', $options, __( 'Layout:', 'ci-theme' ), array( 'default' => '2cols_side' ) );

				$category = get_post_meta( $object->ID, 'looks_base_category', true );
				ci_theme_metabox_guide( __( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'ci-theme' ) );
				?><p><label for="base_looks_category"><?php _e( 'Base Looks category:', 'ci-theme' ); ?></label><?php
				wp_dropdown_categories( array(
					'taxonomy'          => 'category',
					'selected'          => $category,
					'id'                => 'looks_base_category',
					'name'              => 'looks_base_category',
					'show_option_none'  => ' ',
					'option_none_value' => 0,
					'hierarchical'      => 1,
					'show_count'        => 1,
				) );
				?><p><?php

				ci_theme_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <em>all items</em>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings > Reading</em>, currently set to <strong>%s items per page</strong>.', 'ci-theme' ), get_option( 'posts_per_page' ) ) );
				ci_theme_metabox_input( 'looks_posts_per_page', __( 'Items per page:', 'ci-theme' ) );

			ci_theme_metabox_close_tab();
		?></div><?php

		ci_theme_bind_metabox_to_page_template( 'ci-tpl-looks-box', 'template-listing-looks.php', 'tpl_looks' );
	}

	function ci_theme_add_cpt_page_blank_meta_box( $object, $box ) {
		ci_theme_prepare_metabox( 'page' );

		?><div class="ci-cf-wrap"><?php
			ci_theme_metabox_open_tab( '' );

				ci_theme_metabox_checkbox( 'blank_template_padding', 1, esc_html__( 'Disable top and bottom padding for this page', 'ci-theme' ) );

			ci_theme_metabox_close_tab();
		?></div><?php

		ci_theme_bind_metabox_to_page_template( 'ci-tpl-blank-box', 'template-blank.php', 'tpl_blank' );
	}