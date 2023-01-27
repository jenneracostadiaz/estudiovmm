<?php
/**
 * Plugin generic functions file
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sanitize URL
 * 
 * @since 1.0
 */
function aigpl_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 1.0
 */
function aigpl_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'aigpl_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.2.6
 */
function aigpl_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( $classes && !is_array($classes) ) {
		$classes = explode($sep, $classes);
	}

	if( !empty($classes) ) {
		foreach($classes as $class){
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Function to unique number value
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_get_unique() {
	static $unique = 0;
	$unique++;

	// For Elementor & Beaver Builder
	if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
	|| ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) ) ) {
		$unique = current_time('timestamp') . '-' . rand();
	}

	return $unique;
}

/**
 * Function to unique number value
 * 
 * @since 1.0.0
 */
function aigpl_unique_num() {
	static $unique = 0;
	$unique++;

	// For Elementor & Beaver Builder
	if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
	|| ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) ) ) {
		$unique = current_time('timestamp') . '-' . rand();
	}

	return $unique;
}

/**
 * Function to add array after specific key
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_add_array(&$array, $value, $index, $from_last = false) {
	
	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count    = count($array);
			$index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}
		
		$split_arr  = array_splice($array, max(0, $index));
		$array      = array_merge( $array, $value, $split_arr);
	}
	
	return $array;
}

/**
 * Function to get post featured image
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_get_image_src( $post_id = '', $size = 'full' ) {
	$size   = !empty($size) ? $size : 'full';
	$image  = wp_get_attachment_image_src( $post_id, $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	return $image;
}

/**
 * Function to get post excerpt
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {
	
	$has_excerpt    = false;
	$word_length    = !empty($word_length) ? $word_length : '55';
	
	// If post id is passed
	if( !empty($post_id) ) {
		if (has_excerpt($post_id)) {

			$has_excerpt    = true;
			$content        = get_the_excerpt();

		} else {
			$content = !empty($content) ? $content : get_the_content();
		}
	}

	if( !empty($content) && (!$has_excerpt) ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}

	return $content;
}

/**
 * Function to get `igsp-gallery` shortcode designs
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_designs() {
	$design_arr = array(
					'design-1'  => __('Design 1', 'album-and-image-gallery-plus-lightbox')
				);
	return apply_filters('aigpl_designs', $design_arr );
}

/**
 * Function to get `igsp-gallery` shortcode designs
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_album_designs() {
	$design_arr = array(
					'design-1'  => __('Design 1', 'album-and-image-gallery-plus-lightbox'),
				);
	return apply_filters('aigpl_album_designs', $design_arr );
}