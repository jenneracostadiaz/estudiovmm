<?php
/**
 * Blocks Initializer
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function aigpl_register_guten_block() {

	// Block Editor Script
	wp_register_script( 'aigpl-block-js', AIGPL_URL.'assets/js/blocks.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-block-editor', 'wp-components' ), AIGPL_VERSION, true );
	wp_localize_script( 'aigpl-block-js', 'Aigplf_Block', array(
																'pro_demo_link'		=> 'https://demo.essentialplugin.com/prodemo/album-and-image-gallery-plus-lightbox-pro/',
																'free_demo_link'	=> 'https://demo.essentialplugin.com/album-and-image-gallery-plus-lightbox-demo/',
																'pro_link'			=> AIGPL_PLUGIN_LINK_UNLOCK,
															));

	// Register block and explicit attributes for gallery grid
	register_block_type( 'aigpl/gallery', array(
		'attributes' => array(
			'id' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'grid' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'show_title' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'show_description' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'show_caption' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'full',
						),
			'gallery_height' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'popup' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'aigpl_gallery_grid',
	));

	//Register block, and explicitly define the attributes for gallery slider
	register_block_type( 'aigpl/gallery-slider', array(
		'attributes' => array(
			'id' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'show_title' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'show_description' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'show_caption' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'full',
						),
			'popup' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'gallery_height' => array(
							'type'		=> 'number',
							'default'	=> 'self',
						),
			'slidestoshow' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'slidestoscroll' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'speed' => array(
							'type'		=> 'number',
							'default'	=> 300,
						),
			'loop' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'grid' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'aigpl_gallery_slider',
	));

	//Register block, and explicitly define the attributes for album grid
	register_block_type( 'aigpl/gallery-album', array(
		'attributes' => array(
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'full',
						),
			'album_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'album_grid' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'album_title' => array(
							'type'		=> 'boolean',
							'default'	=> true,
						),
			'album_description' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'album_full_content' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'words_limit' => array(
							'type'		=> 'number',
							'default'	=> 40,
						),
			'content_tail' => array(
							'type'		=> 'string',
							'default'	=> '...',
						),
			'album_height' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'total_photo' => array(
							'type'		=> 'string',
							'default'	=> '{total}'.' '.__('Photos','album-and-image-gallery-plus-lightbox'),
						),
			'album_link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'grid' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'show_title' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'show_description' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'show_caption' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'popup' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'gallery_height' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 15,
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'id' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'aigpl_gallery_album',
	));

	//Register block, and explicitly define the attributes for album slider
	register_block_type( 'aigpl/gallery-album-slider', array(
		'attributes' => array(
			'image_size' => array(
							'type'		=> 'string',
							'default'	=> 'full',
						),
			'album_design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'album_title' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'album_description' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'album_full_content' => array(
							'type'		=> 'boolean',
							'default'	=> false,
						),
			'words_limit' => array(
							'type'		=> 'number',
							'default'	=> 40,
						),
			'content_tail' => array(
							'type'		=> 'string',
							'default'	=> '...',
						),
			'album_height' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'total_photo' => array(
							'type'		=> 'string',
							'default'	=> '{total}'.' '.__('Photos','album-and-image-gallery-plus-lightbox'),
						),
			'album_link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'design' => array(
							'type'		=> 'string',
							'default'	=> 'design-1',
						),
			'grid' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'show_title' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'show_description' => array(
							'type'		=> 'string',
							'default'	=> 'false',
						),
			'show_caption' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'popup' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'link_target' => array(
							'type'		=> 'string',
							'default'	=> 'self',
						),
			'gallery_height' => array(
							'type'		=> 'number',
							'default'	=> '',
						),
			'album_slidestoshow' => array(
							'type'		=> 'number',
							'default'	=> 3,
						),
			'album_slidestoscroll' => array(
							'type'		=> 'number',
							'default'	=> 1,
						),
			'album_dots' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'album_arrows' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'album_autoplay' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'album_autoplay_interval' => array(
							'type'		=> 'number',
							'default'	=> 3000,
						),
			'album_speed' => array(
							'type'		=> 'number',
							'default'	=> 300,
						),
			'loop' => array(
							'type'		=> 'string',
							'default'	=> 'true',
						),
			'lazyload' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'limit' => array(
							'type'		=> 'number',
							'default'	=> 15,
						),
			'category' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'id' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'align' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
			'className' => array(
							'type'		=> 'string',
							'default'	=> '',
						),
		),
		'render_callback' => 'aigpl_gallery_album_slider',
	));

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'aigpl-block-js', 'album-and-image-gallery-plus-lightbox', AIGPL_DIR . '/languages' );
	}

}
add_action( 'init', 'aigpl_register_guten_block' );

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 2.3
 */
function aigpl_block_assets() {	
}
add_action( 'enqueue_block_assets', 'aigpl_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 2.3
 */
function aigpl_editor_assets() {

	// Block Editor CSS
	if( ! wp_style_is( 'wpos-free-guten-block-css', 'registered' ) ) {
		wp_register_style( 'wpos-free-guten-block-css', AIGPL_URL.'assets/css/blocks.editor.build.css', array( 'wp-edit-blocks' ), AIGPL_VERSION );
	}

	// Block Editor Script
	wp_enqueue_style( 'wpos-free-guten-block-css' );
	wp_enqueue_script( 'aigpl-block-js' );

}
add_action( 'enqueue_block_editor_assets', 'aigpl_editor_assets' );

/**
 * Adds an extra category to the block inserter
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 2.3
 */
function aigpl_add_block_category( $categories ) {

	$guten_cats = wp_list_pluck( $categories, 'slug' );

	if( ! in_array( 'wpos_guten_block', $guten_cats ) ) {
		$categories[] = array(
							'slug'	=> 'wpos_guten_block',
							'title'	=> __('Essential Plugin Blocks', 'album-and-image-gallery-plus-lightbox'),
							'icon'	=> null,
						);
	}

	return $categories;
}
add_filter( 'block_categories_all', 'aigpl_add_block_category' );