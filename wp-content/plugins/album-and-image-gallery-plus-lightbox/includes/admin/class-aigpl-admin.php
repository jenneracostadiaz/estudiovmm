<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Aigpl_Admin {

	function __construct() {

		// Init Processes
		add_action( 'admin_init', array($this, 'aigpl_admin_init_process') );

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'aigpl_register_menu'), 12 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'aigpl_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post_'.AIGPL_POST_TYPE, array($this, 'aigpl_save_metabox_value') );

		// Filter to add row action in category table
		add_filter( AIGPL_CAT.'_row_actions', array($this, 'aigpl_add_tax_row_data'), 10, 2 );

		// Action to add custom column to Gallery listing
		add_filter( 'manage_'.AIGPL_POST_TYPE.'_posts_columns', array($this, 'aigpl_posts_columns') );

		// Action to add custom column data to Gallery listing
		add_action('manage_'.AIGPL_POST_TYPE.'_posts_custom_column', array($this, 'aigpl_post_columns_data'), 10, 2);

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'aigpl_add_post_row_data'), 10, 2 );

		// Action to add Attachment Popup HTML
		add_action( 'admin_footer', array($this,'aigpl_image_update_popup_html') );

		// Ajax call to update option
		add_action( 'wp_ajax_aigpl_get_attachment_edit_form', array($this, 'aigpl_get_attachment_edit_form'));
		add_action( 'wp_ajax_nopriv_aigpl_get_attachment_edit_form',array( $this, 'aigpl_get_attachment_edit_form'));

		// Ajax call to update attachment data
		add_action( 'wp_ajax_aigpl_save_attachment_data', array($this, 'aigpl_save_attachment_data'));
		add_action( 'wp_ajax_nopriv_aigpl_save_attachment_data',array( $this, 'aigpl_save_attachment_data'));

		// Action to add little JS code in admin footer
		//add_action( 'admin_footer', array($this, 'aigpl_upgrade_page_link_blank') );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_post_sett_metabox() {
		add_meta_box( 'aigpl-post-sett', __( 'Album and Image Gallery Plus Lightbox - Settings', 'album-and-image-gallery-plus-lightbox' ), array($this, 'aigpl_post_sett_mb_content'), AIGPL_POST_TYPE, 'normal', 'high' );
		add_meta_box( 'aigpl-post-metabox-pro', __('More Premium - Settings', 'album-and-image-gallery-plus-lightbox'), array($this, 'aigpl_post_sett_box_callback_pro'), AIGPL_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_post_sett_mb_content() {
		include_once( AIGPL_DIR .'/includes/admin/metabox/aigpl-sett-metabox.php');
	}

	/**
	 * Function to handle 'premium ' metabox HTML
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.4.3
	 */
	function aigpl_post_sett_box_callback_pro( $post ) {		
		include_once( AIGPL_DIR .'/includes/admin/metabox/aigpl-post-setting-metabox-pro.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  AIGPL_POST_TYPE ) )              					// Check if current post type is supported.
		{
			return $post_id;
		}
		
		$prefix = AIGPL_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$gallery_imgs = isset( $_POST['aigpl_img'] ) ? array_map( 'intval', (array) $_POST['aigpl_img'] ) : '';

		update_post_meta( $post_id, $prefix.'gallery_imgs', $gallery_imgs );
	}

	/**
	 * Function to add category row action
	 * 
	 * @package Album and Image Gallery Plus Lightbox
 	 * @since 1.0
	 */
	function aigpl_add_tax_row_data( $actions, $tag ) {
		return array_merge( array( 'aigpl_id' => "<span style='color:#555'>ID: {$tag->term_id}</span>" ), $actions );
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_posts_columns( $columns ) {

	    $new_columns['aigpl_shortcode'] 	= esc_html__( 'Shortcode', 'album-and-image-gallery-plus-lightbox' );
	    $new_columns['aigpl_photos'] 		= esc_html__( 'Number of Photos', 'album-and-image-gallery-plus-lightbox' );

	    $columns = aigpl_add_array( $columns, $new_columns, 1, true );

	    return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_post_columns_data( $column, $post_id ) {

		global $post;

		// Taking some variables
		$prefix = AIGPL_META_PREFIX;

		switch ($column) {
			case 'aigpl_shortcode':
				
				echo '<div class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery id="'.esc_attr( $post_id ).'"]</div> <br/>';
				echo '<div class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-slider id="'.esc_attr( $post_id ).'"]</div>';
				break;

			case 'aigpl_photos':
				$total_photos = get_post_meta( $post_id, $prefix.'gallery_imgs', true );
				echo ! empty( $total_photos ) ? count( $total_photos ) : '--';
				break;
		}
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_add_post_row_data( $actions, $post ) {
		
		if( $post->post_type == AIGPL_POST_TYPE ) {
			return array_merge( array( 'aigpl_id' => 'ID: ' . $post->ID ), $actions );
		}
		
		return $actions;
	}

	/**
	 * Image data popup HTML
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_image_update_popup_html() {

		global $typenow;

		if( $typenow == AIGPL_POST_TYPE ) {
			include_once( AIGPL_DIR .'/includes/admin/settings/aigpl-img-popup.php');
		}
	}

	/**
	 * Get attachment edit form
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_get_attachment_edit_form() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= esc_js( __( 'Sorry, Something happened wrong.', 'album-and-image-gallery-plus-lightbox' ) );
		$attachment_id 		= ! empty( $_POST['attachment_id'] ) ? trim( $_POST['attachment_id'] ) : '';

		if( ! empty( $attachment_id ) ) {
			$attachment_post = get_post( $_POST['attachment_id'] );

			if( ! empty( $attachment_post ) ) {

				ob_start();

				// Popup Data File
				include( AIGPL_DIR . '/includes/admin/settings/aigpl-img-popup-data.php' );

				$attachment_data = ob_get_clean();

				$result['success'] 	= 1;
				$result['msg'] 		= esc_js( __('Attachment Found.', 'album-and-image-gallery-plus-lightbox') );
				$result['data']		= $attachment_data;
			}
		}

		echo json_encode($result);
		exit;
	}

	/**
	 * Get attachment edit form
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 */
	function aigpl_save_attachment_data() {

		$prefix 			= AIGPL_META_PREFIX;
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= esc_js( __('Sorry, Something happened wrong.', 'album-and-image-gallery-plus-lightbox') );
		$attachment_id 		= ! empty( $_POST['attachment_id'] ) ? trim( $_POST['attachment_id'] ) : '';
		$form_data 			= parse_str( $_POST['form_data'], $form_data_arr );

		if( ! empty( $attachment_id ) && ! empty( $form_data_arr ) ) {

			// Getting attachment post
			$aigpl_attachment_post = get_post( $attachment_id );

			// If post type is attachment
			if( isset( $aigpl_attachment_post->post_type ) && $aigpl_attachment_post->post_type == 'attachment' ) {
				$post_args = array(
									'ID'			=> $attachment_id,
									'post_title'	=> ! empty( $form_data_arr['aigpl_attachment_title'] ) ? $form_data_arr['aigpl_attachment_title'] : $aigpl_attachment_post->post_name,
									'post_content'	=> $form_data_arr['aigpl_attachment_desc'],
									'post_excerpt'	=> $form_data_arr['aigpl_attachment_caption'],
								);
				$update = wp_update_post( $post_args );

				if( ! is_wp_error( $update ) ) {

					update_post_meta( $attachment_id, '_wp_attachment_image_alt', aigpl_clean( $form_data_arr['aigpl_attachment_alt'] ) );
					update_post_meta( $attachment_id, $prefix.'attachment_link', aigpl_clean_url( $form_data_arr['aigpl_attachment_link'] ) );

					$result['success'] 	= 1;
					$result['msg'] 		= esc_js( __('Your changes saved successfully.', 'album-and-image-gallery-plus-lightbox') );
				}
			}
		}

		echo json_encode($result);
		exit;
	}

	/**
	 * Function to notification transient
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.1.3
	 */
	function aigpl_admin_init_process() {

		// global $typenow, $pagenow;

		// $current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

		// If plugin notice is dismissed
		if( isset( $_GET['message']) && $_GET['message'] == 'aigpl-plugin-notice' ) {
			set_transient( 'aigpl_install_notice', true, 604800 );
		}

		// Redirect to external page for upgrade to menu
		// if( $typenow == AIGPL_POST_TYPE ) {

		// 	if( $current_page == 'aigpl-upgrade-pro' ) {

		// 		wp_redirect( AIGPL_PLUGIN_LINK_UPGRADE );
		// 		exit;
		// 	}

		// 	if( $current_page == 'aigpl-bundle-deal' ) {

		// 		wp_redirect( AIGPL_PLUGIN_BUNDLE_LINK );
		// 		exit;
		// 	}
		// }
	}

	/**
	 * Function to add menu
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.1.3
	 */
	function aigpl_register_menu() {

		// How it work page
		add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('How it works, our plugins and offers', 'album-and-image-gallery-plus-lightbox'), __('How It Works', 'album-and-image-gallery-plus-lightbox'), 'manage_options', 'aigpl-designs', array($this, 'aigpl_designs_page') );

		// Setting page
		add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('Solutions & Features - Album and Image Gallery Plus Lightbox', 'album-and-image-gallery-plus-lightbox'), '<span style="color:#2ECC71">'. __('Solutions & Features', 'album-and-image-gallery-plus-lightbox').'</span>', 'manage_options', 'aigpl-solutions-features', array($this, 'aigpl_solutions_features_page') );

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('Upgrade To PRO - Album and Image Gallery Plus Lightbox', 'album-and-image-gallery-plus-lightbox'), '<span style="color:#ff2700">'.__('Upgrade To PRO', 'album-and-image-gallery-plus-lightbox').'</span>', 'manage_options', 'aigpl-premium', array($this, 'aigpl_premium_page') );
		//add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('Upgrade To PRO - Album And Image Gallery Plus Lightbox', 'album-and-image-gallery-plus-lightbox'), '<span class="wpos-upgrade-pro" style="color:#ff2700">' . __('Upgrade To Premium ', 'album-and-image-gallery-plus-lightbox') . '</span>', 'manage_options', 'aigpl-upgrade-pro', array($this, 'aigpl_redirect_page') );
		//add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('Bundle Deal - Album And Image Gallery Plus Lightbox', 'album-and-image-gallery-plus-lightbox'), '<span class="wpos-upgrade-pro" style="color:#ff2700">' . __('Bundle Deal', 'album-and-image-gallery-plus-lightbox') . '</span>', 'manage_options', 'aigpl-bundle-deal', array($this, 'aigpl_redirect_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.1.4
	 */
	function aigpl_premium_page() {
		include_once( AIGPL_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * How It Work Page Html
	 * 
	 * @since 1.0
	 */
	// function aigpl_redirect_page() {
	// }

	/**
	 * How it work Page Html
	 * 
	* @package Album and Image Gallery Plus Lightbox
	 * @since 1.1.4
	 */
	function aigpl_designs_page() {		
		include_once( AIGPL_DIR . '/includes/admin/aigpl-how-it-work.php' );
	}

	/**
	 * Solution features Page Html
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.1.4
	 */
	function aigpl_solutions_features_page() {
		include_once( AIGPL_DIR . '/includes/admin/settings/solutions-features.php' );	
	}

	/**
	 * Add JS snippet to admin footer to add target _blank in upgrade link
	 * 
	 * @package Album and Image Gallery Plus Lightbox
	 * @since 1.0.0
	 //*/
	/* function aigpl_upgrade_page_link_blank() {

		global $wpos_upgrade_link_snippet;

		// Redirect to external page
		if( empty( $wpos_upgrade_link_snippet ) ) {

			$wpos_upgrade_link_snippet = 1;
	?>
		<script type="text/javascript">
			(function ($) {
				$('.wpos-upgrade-pro').parent().attr( { target: '_blank', rel: 'noopener noreferrer' } );
			})(jQuery);
		</script>
	<?php }
	} */
}

$aigpl_admin = new Aigpl_Admin();