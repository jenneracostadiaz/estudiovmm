<?php
/**
 * 'aigpl-gallery-album-slider' Shortcode
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `aigpl-gallery-album-slider` shortcode
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_gallery_album_slider( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ($_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json') ) {
		return "[aigpl-gallery-album-slider]";
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="aigpl-builder-shrt-prev">
					<div class="aigpl-builder-shrt-title"><span>'.esc_html__('Album Slider View', 'album-and-image-gallery-plus-lightbox').'</span></div>
					aigpl-gallery-album-slider
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="aigpl-builder-shrt-prev">
					<div class="aigpl-builder-shrt-title"><span>'.esc_html__('Gallery Grid View', 'album-and-image-gallery-plus-lightbox').'</span></div>
					aigpl-gallery-album-slider
				</div>';
	}

	// Taking some global
	global $post;

	// Shortcode Parameter
	extract(shortcode_atts(array(
				'limit'						=> 15,
				'album_design' 				=> 'design-1',
				'album_link_target'			=> 'self',
				'album_height'				=> '',
				'album_title'				=> 'false',
				'album_description'			=> 'false',
				'album_full_content' 		=> 'false',
				'words_limit' 				=> 40,
				'content_tail' 				=> '...',
				'id'						=> array(),
				'category' 					=> '',
				'total_photo'				=> '{total}'.' '.__('Photos','album-and-image-gallery-plus-lightbox'),
				'popup'						=> 'true',
				'grid'						=> 3,
				'gallery_height'			=> '',
				'design'					=> 'design-1',
				'show_caption'				=> 'true',
				'show_title'				=> 'false',
				'show_description'			=> 'false',
				'link_target'				=> 'self',
				'image_size'				=> 'full',

				'album_slidestoshow'		=> 3,
				'album_slidestoscroll' 		=> 1,
				'album_dots'     			=> 'true',
				'album_arrows'     			=> 'true',
				'album_autoplay'     		=> 'true',
				'album_autoplay_interval'	=> 3000,
				'album_speed'             	=> 300,
				'loop'						=> 'true',
				'lazyload'          		=> '',
				'extra_class'				=> '',
				'className'					=> '',
				'align'						=> '',
	), $atts, 'aigpl-gallery-album-slider' ));
	
	$album_designs 		= aigpl_album_designs();
	$unique_album_no 	= aigpl_unique_num();
	$content_tail 		= html_entity_decode( $content_tail );
	$limit 				= ! empty( $limit ) 					? $limit 							: 15;
	$post_ids			= ! empty( $id )						? explode(',', $id) 				: array();
	$album_design 		= ( $album_design && ( array_key_exists( trim( $album_design ), $album_designs ))) ? trim( $album_design ) : 'design-1';
	$album_link_target 	= ( $album_link_target == 'blank' ) 	? '_blank' 							: '_self';
	$album_title		= ( $album_title == 'true' )			? 1									: 0;
	$album_description	= ( $album_description == 'true' )		? 1									: 0;
	$album_full_content	= ( $album_full_content == 'true' )		? 1									: 0;
	$category 			= ! empty( $category )					? explode(',',$category) 			: '';
	$album_height		= ! empty( $album_height )				? $album_height 					: '';
	$album_height_css	= ! empty( $album_height )				? "height:{$album_height}px;"		: '';
	$total_photo 		= ! empty( $total_photo ) 				? $total_photo						: '';

	$slidestoshow 		= ! empty( $album_slidestoshow ) 		? $album_slidestoshow 				: 3;
	$slidestoscroll 	= ! empty( $album_slidestoscroll ) 		? $album_slidestoscroll 			: 1;
	$dots 				= ( $album_dots == 'false' ) 			? 'false' 							: 'true';
	$arrows 			= ( $album_arrows == 'false' ) 			? 'false' 							: 'true';
	$autoplay 			= ( $album_autoplay == 'false' ) 		? 'false' 							: 'true';
	$autoplay_interval 	= ! empty( $album_autoplay_interval ) 	? $album_autoplay_interval 			: 3000;
	$speed 				= ! empty( $album_speed ) 				? $album_speed 						: 300;
	$loop 				= ( $loop == 'false' ) 					? 'false' 							: 'true';
	$lazyload 			= ( $lazyload == 'ondemand' || $lazyload == 'progressive' ) ? $lazyload 	: ''; // ondemand or progressive
	$align				= ! empty( $align )						? 'align'.$align					: '';
	$extra_class		= $extra_class .' '. $align .' '. $className;
	$extra_class		= aigpl_sanitize_html_classes( $extra_class );
	$album_ses 			= ! empty( $_GET['album_ses'] ) ? $_GET['album_ses'] : '';

	// If album id passed and album_ses match to passed number
	if ( ! empty( $_GET['album'] ) && ( $album_ses == $unique_album_no ) ) {
		$post_ids = $_GET['album'];
	}

	// Enqueue required script
	// First Dequeue if gallery shortcode is placed before the slider shortcode
	wp_dequeue_script( 'aigpl-public-js' );

	wp_enqueue_script('wpos-slick-jquery');
	wp_enqueue_script('aigpl-public-js');

	// Shortcode file
	$design_file_path 	= AIGPL_DIR . '/templates/album/' . $album_design . '.php';
	$design_file 		= (file_exists($design_file_path)) ? $design_file_path : '';

	// Taking some variables
	$prefix 			= AIGPL_META_PREFIX;
	$unique				= aigpl_get_unique();
	$album_page 		= get_permalink();
	$loop_count			= 1;
	$wrpper_cls			= 'aigpl-slider-slide aigpl-cnt-wrp';

	// Slider configuration
	$slider_conf = compact('slidestoshow', 'slidestoscroll', 'dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'loop', 'lazyload');

	// If album id is not passed then take all albums else album images
	if( $album_ses != $unique_album_no ) {

		// WP Query Parameters
		$args = array (
			'post_type'     	 	=> AIGPL_POST_TYPE,
			'post_status' 			=> array( 'publish' ),
			'post__in'		 		=> $post_ids,
			'ignore_sticky_posts'	=> true,
			'posts_per_page'		=> $limit,
			'order'					=> 'DESC',
			'orderby'				=> 'date',
		);

		// Meta Query
		$args['meta_query'] = array(
								array(
									'key'     => $prefix.'gallery_imgs',
									'value'   => '',
									'compare' => '!=',
								));

		// Category Parameter
		if( !empty($category) ) {

			$args['tax_query'] = array(
									array( 
										'taxonomy' 	=> AIGPL_CAT,
										'field' 	=> 'term_id',
										'terms' 	=> $category,
								));

		}

		// WP Query Parameters
		$aigpl_query = new WP_Query($args);
	}

	ob_start();

	// If post is there
	if( ( $album_ses != $unique_album_no ) && $aigpl_query->have_posts() ) { ?>

	<div class="aigpl-gallery-slider-wrp <?php echo $extra_class; ?>">
		<div class="aigpl-gallery-album-wrp aigpl-gallery-slider aigpl-gallery-album-slider aigpl-clearfix aigpl-album-<?php echo $album_design; ?>" id="aigpl-gallery-<?php echo $unique; ?>">
			<?php while ( $aigpl_query->have_posts() ) : $aigpl_query->the_post();

					$album_image 		= add_query_arg( array( 'album' => $post->ID, 'album_ses' => $unique_album_no), $album_page )."#aigpl-album-gallery-".$unique_album_no;
					$image_link			= aigpl_get_image_src( get_post_thumbnail_id($post->ID), $image_size, true );
					$total_photo_no		= get_post_meta($post->ID, $prefix.'gallery_imgs', true);
					$total_photo_no 	= !empty($total_photo_no) ? count($total_photo_no) : '';
					$total_photo_lbl	= str_replace('{total}', $total_photo_no, $total_photo);

					// Include shortcode html file
					if( $design_file ) {
						include( $design_file );
					}

					$loop_count++; // Increment loop count
			endwhile;
			?>
		</div>
		<div class="aigpl-gallery-slider-conf aigpl-hide"><?php echo htmlspecialchars(json_encode($slider_conf)); ?></div>
	</div>

	<?php
		wp_reset_postdata(); // Reset WP Query

	} elseif( ! empty( $_GET['album'] ) && ( $album_ses == $unique_album_no ) ) { // If album id is passed
			
			echo "<div class='aigpl-breadcrumb-wrp' id='aigpl-album-gallery-{$unique_album_no}'><a class='aigpl-breadcrumb' href='{$album_page}'>".__('Main Album', 'album-and-image-gallery-plus-lightbox')."</a> &raquo; ".get_the_title($post_ids)."</div>";

			echo do_shortcode( '[aigpl-gallery id="'.$post_ids.'" grid="'.$grid.'" show_caption="'.$show_caption.'" gallery_height="'.$gallery_height.'" show_title="'.$show_title.'" show_description="'.$show_description.'" popup="'.$popup.'" link_target="'.$link_target.'" design="'.$design.'" image_size="'.$image_size.'"]' );

	} // end else

	$content .= ob_get_clean();
	return $content;
}

// 'aigpl-gallery-album-slider' shortcode
add_shortcode( 'aigpl-gallery-album-slider', 'aigpl_gallery_album_slider' );