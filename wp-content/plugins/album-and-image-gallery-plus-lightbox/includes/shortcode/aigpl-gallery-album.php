<?php
/**
 * 'aigpl-gallery-album' Shortcode
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `aigpl-gallery-album` shortcode
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_gallery_album( $atts, $content = null ) {

	// SiteOrigin Page Builder Gutenberg Block Tweak - Do not Display Preview
	if( isset( $_POST['action'] ) && ($_POST['action'] == 'so_panels_layout_block_preview' || $_POST['action'] == 'so_panels_builder_content_json') ) {
		return "[aigpl-gallery-album]";
	}

	// Divi Frontend Builder - Do not Display Preview
	if( function_exists( 'et_core_is_fb_enabled' ) && isset( $_POST['is_fb_preview'] ) && isset( $_POST['shortcode'] ) ) {
		return '<div class="aigpl-builder-shrt-prev">
					<div class="aigpl-builder-shrt-title"><span>'.esc_html__('Album Grid View', 'album-and-image-gallery-plus-lightbox').'</span></div>
					aigpl-gallery-album
				</div>';
	}

	// Fusion Builder Live Editor - Do not Display Preview
	if( class_exists( 'FusionBuilder' ) && (( isset( $_GET['builder'] ) && $_GET['builder'] == 'true' ) || ( isset( $_POST['action'] ) && $_POST['action'] == 'get_shortcode_render' )) ) {
		return '<div class="aigpl-builder-shrt-prev">
					<div class="aigpl-builder-shrt-title"><span>'.esc_html__('Gallery Grid View', 'album-and-image-gallery-plus-lightbox').'</span></div>
					aigpl-gallery-album
				</div>';
	}

	// Shortcode Parameter
	extract(shortcode_atts(array(
		'limit'					=> 15,
		'album_grid'    		=> 3,
		'album_design' 			=> 'design-1',
		'album_link_target'		=> 'self',
		'album_height'			=> '',
		'album_title'			=> 'true',
		'album_description'		=> 'false',
		'album_full_content' 	=> 'false',
		'words_limit' 			=> 40,
		'content_tail' 			=> '...',
		'id'					=> array(),
		'category' 				=> '',
		'total_photo'			=> '{total}'.' '.__('Photos','album-and-image-gallery-plus-lightbox'),
		'popup'					=> 'true',
		'grid'					=> 3,
		'gallery_height'		=> '',
		'design'				=> 'design-1',
		'show_caption'			=> 'true',
		'show_title'			=> 'false',
		'show_description'		=> 'false',
		'link_target'			=> 'self',
		'image_size'			=> 'full',
		'extra_class'			=> '',
		'className'				=> '',
		'align'					=> '',
	), $atts, 'aigpl-gallery-album'));
	
	$album_designs 		= aigpl_album_designs();
	$unique_album_no 	= aigpl_unique_num();
	$content_tail 		= html_entity_decode( $content_tail );
	$limit 				= ! empty( $limit ) 					? $limit 							: 15;
	$post_ids			= ! empty( $id )						? explode( ',', $id ) 				: array();
	$album_grid 		= ( ! empty( $album_grid ) && $album_grid <= 12 ) 	? $album_grid 			: 3;
	$album_design 		= ( $album_design && ( array_key_exists( trim( $album_design ), $album_designs ))) ? trim( $album_design ) : 'design-1';
	$album_link_target 	= ( $album_link_target == 'blank' ) 	? '_blank' 							: '_self';
	$album_title		= ( $album_title == 'true' )			? 1									: 0;
	$album_description	= ( $album_description == 'true' )		? 1									: 0;
	$album_full_content	= ( $album_full_content == 'true' )		? 1									: 0;
	$category 			= ! empty( $category )					? explode( ',',$category ) 			: '';
	$album_height		= ! empty( $album_height )				? $album_height 					: '';
	$album_height_css	= ! empty( $album_height )				? "height:{$album_height}px;"		: '';
	$total_photo 		= ! empty( $total_photo ) 				? $total_photo						: '';
	$align				= ! empty( $align )						? 'align'.$align					: '';
	$extra_class		= $extra_class .' '. $align .' '. $className;
	$extra_class		= aigpl_sanitize_html_classes( $extra_class );
	$lazyload 			= '';
	$album_ses 			= ! empty( $_GET['album_ses'] ) 		? $_GET['album_ses'] 				: '';

	// Taking some global
	global $post;

	// If album id passed and album_ses match to passed number
	if ( ! empty( $_GET['album'] ) && ( $album_ses == $unique_album_no ) ) {
		$post_ids = $_GET['album'];
	}

	// Shortcode file
	$design_file_path 	= AIGPL_DIR . '/templates/album/' . $album_design . '.php';
	$design_file 		= (file_exists($design_file_path)) ? $design_file_path : '';
	
	// Taking some variables
	$prefix 			= AIGPL_META_PREFIX;
	$unique				= aigpl_get_unique();
	$album_page 		= get_permalink();
	$loop_count			= 1;
	$main_cls 			= "aigpl-cnt-wrp aigpl-col-{$album_grid} aigpl-columns";

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
									'key' 		=> $prefix.'gallery_imgs',
									'value' 	=> '',
									'compare' 	=> '!=',
								));

		// Category Parameter
		if( ! empty( $category ) ) {

			$args['tax_query'] = array(
									array( 
										'taxonomy' 			=> AIGPL_CAT,
										'field' 			=> 'term_id',
										'terms' 			=> $category,
								));

		}

		// WP Query Parameters
		$aigpl_query = new WP_Query( $args );
	}

	ob_start();

	// If post is there
	if ( ( $album_ses != $unique_album_no ) && $aigpl_query->have_posts() ) { ?>

		<div class="aigpl-gallery-album-wrp aigpl-gallery-album aigpl-clearfix aigpl-album-<?php echo esc_attr( $album_design ); ?> <?php echo esc_attr( $extra_class ); ?>" id="aigpl-gallery-<?php echo esc_attr( $unique ); ?>">

		<?php while ( $aigpl_query->have_posts() ) : $aigpl_query->the_post();

				$wrpper_cls			= ($loop_count == 1) ? $main_cls.' aigpl-first' : $main_cls;
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

				// Reset loop count
				if( $loop_count == $album_grid ) {
					$loop_count = 0;
				}
		endwhile;
		?>

		</div><!-- end .aigpl-gallery-album-wrp -->

	<?php
		wp_reset_postdata(); // Reset WP Query

	} elseif( ! empty( $_GET['album'] ) && ( $album_ses == $unique_album_no ) ) { // If album id is passed

			echo "<div class='aigpl-breadcrumb-wrp' id='aigpl-album-gallery-{$unique_album_no}'><a class='aigpl-breadcrumb' href='{$album_page}'>".__('Main Album', 'album-and-image-gallery-plus-lightbox')."</a> &raquo; ".get_the_title($post_ids)."</div>";

			echo do_shortcode( '[aigpl-gallery id="'.$post_ids.'" grid="'.$grid.'" gallery_height="'.$gallery_height.'" show_caption="'.$show_caption.'" show_title="'.$show_title.'" show_description="'.$show_description.'" popup="'.$popup.'" link_target="'.$link_target.'" design="'.$design.'" image_size="'.$image_size.'"]' );

	} // end else

	$content .= ob_get_clean();
	return $content;
}

// 'aigpl-gallery-album' shortcode
add_shortcode( 'aigpl-gallery-album', 'aigpl_gallery_album' );