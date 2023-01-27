<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Aigpl_Script {

	function __construct() {

		// Action to add style and script in backend
		add_action( 'admin_enqueue_scripts', array($this, 'aigpl_admin_style_script') );

		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'aigpl_front_style_script') );
	}

	/**
	 * Function to register admin scripts and styles
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.3.2
	 */
	function aigpl_register_admin_assets() {

		/* Styles */
		// Registring admin css
		wp_register_style( 'aigpl-admin-style', AIGPL_URL.'assets/css/aigpl-admin.css', array(), AIGPL_VERSION );


		/* Scripts */
		// Registring admin script
		wp_register_script( 'aigpl-admin-script', AIGPL_URL.'assets/js/aigpl-admin.js', array('jquery'), AIGPL_VERSION, true );
		wp_localize_script( 'aigpl-admin-script', 'AigplAdmin', array(
																'img_edit_popup_text'	=> __('Edit Image in Popup', 'album-and-image-gallery-plus-lightbox'),
																'attachment_edit_text'	=> __('Edit Image', 'album-and-image-gallery-plus-lightbox'),
																'img_delete_text'		=> __('Remove Image', 'album-and-image-gallery-plus-lightbox'),
															));
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0
	 */
	function aigpl_admin_style_script( $hook ) {   

		global $typenow;

		$this->aigpl_register_admin_assets();

		// If page is plugin setting page then enqueue script
		if( $typenow == AIGPL_POST_TYPE ) {

			// Enquque admin script
			wp_enqueue_style( 'aigpl-admin-style' );

			// Enqueue required inbuilt sctipt
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'aigpl-admin-script' );
			wp_enqueue_media(); // For media uploader

			// How it work page
			if( $hook == 'aigpl_gallery_page_aigpl-designs' ) {
				wp_enqueue_script( 'aigpl-admin-script' );
			}
		}
	}

	/**
	 * Function to add script at front side
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_front_style_script() {

		global $post;

		/* Styles */
		// Registring and enqueing magnific css
		if( ! wp_style_is( 'wpos-magnific-style', 'registered' ) ) {
			wp_register_style( 'wpos-magnific-style', AIGPL_URL.'assets/css/magnific-popup.css', array(), AIGPL_VERSION );
		}
		wp_enqueue_style( 'wpos-magnific-style');

		// Registring and enqueing slick css
		if( ! wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', AIGPL_URL.'assets/css/slick.css', array(), AIGPL_VERSION );
		}
		wp_enqueue_style( 'wpos-slick-style');

		// Registring and enqueing public css
		wp_register_style( 'aigpl-public-css', AIGPL_URL.'assets/css/aigpl-public.css', array(), AIGPL_VERSION );
		wp_enqueue_style( 'aigpl-public-css' );


		/* Scripts */
		// Registring magnific popup script
		if( ! wp_script_is( 'wpos-magnific-script', 'registered' ) ) {
			wp_register_script( 'wpos-magnific-script', AIGPL_URL.'assets/js/jquery.magnific-popup.min.js', array('jquery'), AIGPL_VERSION, true );
		}

		// Registring slick slider script
		if( ! wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-slick-jquery', AIGPL_URL.'assets/js/slick.min.js', array('jquery'), AIGPL_VERSION, true );
		}

		// Register Elementor script
		wp_register_script( 'aigpl-elementor-js', AIGPL_URL.'assets/js/elementor/aigpl-elementor.js', array('jquery'), AIGPL_VERSION, true );

		// Registring public script
		wp_register_script( 'aigpl-public-js', AIGPL_URL.'assets/js/aigpl-public.js', array('jquery'), AIGPL_VERSION, true );
		wp_localize_script( 'aigpl-public-js', 'Aigpl', array(
															'is_mobile' 		=> (wp_is_mobile()) 	? 1 : 0,
															'is_rtl' 			=> (is_rtl()) 			? 1 : 0,
															'mfp_img_counter'	=> esc_html__( '%curr% of %total%', 'album-and-image-gallery-plus-lightbox' ),
															'is_avada' 			=> (class_exists( 'FusionBuilder' ))	? 1 : 0,
														));

		// Enqueue Script for Elementor Preview
		if ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_GET['elementor-preview'] ) && $post->ID == (int) $_GET['elementor-preview'] ) {

			wp_enqueue_script( 'wpos-magnific-script' );
			wp_enqueue_script( 'wpos-slick-jquery' );
			wp_enqueue_script( 'aigpl-public-js' );
			wp_enqueue_script( 'aigpl-elementor-js' );
		}

		// Enqueue Style & Script for Beaver Builder
		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {

			$this->aigpl_register_admin_assets();

			wp_enqueue_style( 'aigpl-admin-style');
			wp_enqueue_script( 'aigpl-admin-script' );
			wp_enqueue_script( 'wpos-magnific-script' );
			wp_enqueue_script( 'wpos-slick-jquery' );
			wp_enqueue_script( 'aigpl-public-js' );
		}

		// Enqueue Admin Style & Script for Divi Page Builder
		if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_GET['et_fb'] ) && $_GET['et_fb'] == 1 ) {
			$this->aigpl_register_admin_assets();

			wp_enqueue_style( 'aigpl-admin-style');
		}

		// Enqueue Admin Style for Fusion Page Builder
		if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) ) ) {
			$this->aigpl_register_admin_assets();

			wp_enqueue_style( 'aigpl-admin-style');
		}
	}
}

$aigpl_script = new Aigpl_Script();