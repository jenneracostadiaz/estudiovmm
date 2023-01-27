<?php
/**
 * Plugin Name: Album and Image Gallery Plus Lightbox
 * Plugin URI: https://www.essentialplugin.com/wordpress-plugins/album-image-gallery-plus-lightbox
 * Description: Easy to add and display image gallery and gallery slider. Also work with Gutenberg shortcode block.
 * Author: WP OnlineSupport, Essential Plugin
 * Text Domain: album-and-image-gallery-plus-lightbox
 * Domain Path: /languages/
 * Version: 1.6.2
 * Author URI: https://www.essentialplugin.com/wordpress-plugin/album-image-gallery-plus-lightbox/
 *
 * @package WordPress
 * @author WP OnlineSupport
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Basic plugin definitions
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
if( ! defined( 'AIGPL_VERSION' ) ) {
	define( 'AIGPL_VERSION', '1.6.2' ); // Version of plugin
}

if( ! defined( 'AIGPL_NAME' ) ) {
	define( 'AIGPL_NAME', 'Album and Image Gallery Plus Lightbox' ); // Version of plugin
}

if( ! defined( 'AIGPL_DIR' ) ) {
	define( 'AIGPL_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if( ! defined( 'AIGPL_URL' ) ) {
	define( 'AIGPL_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if( ! defined( 'AIGPL_PLUGIN_BASENAME' ) ) {
	define( 'AIGPL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // plugin base name
}

if( ! defined( 'AIGPL_POST_TYPE' ) ) {
	define( 'AIGPL_POST_TYPE', 'aigpl_gallery' ); // Plugin post type
}

if( ! defined( 'AIGPL_CAT' ) ) {
	define( 'AIGPL_CAT', 'aigpl_cat' ); // Plugin category name
}

if( ! defined( 'AIGPL_META_PREFIX' ) ) {
	define( 'AIGPL_META_PREFIX', '_aigpl_' ); // Plugin metabox prefix
}

if( ! defined( 'AIGPL_PLUGIN_LINK' ) ) {
    define( 'AIGPL_PLUGIN_LINK', 'https://www.essentialplugin.com/pricing/?utm_source=WP&utm_medium=Album-Gallery&utm_campaign=Features-PRO' ); // Plugin link
}

if( ! defined( 'AIGPL_PLUGIN_BUNDLE_LINK' ) ) {
	define('AIGPL_PLUGIN_BUNDLE_LINK','https://www.essentialplugin.com/pricing/?utm_source=WP&utm_medium=Album-Gallery&utm_campaign=Welcome-Screen'); // Plugin link
}

if( ! defined( 'AIGPL_PLUGIN_LINK_UNLOCK' ) ) {
	define('AIGPL_PLUGIN_LINK_UNLOCK','https://www.essentialplugin.com/wordpress-plugin/album-image-gallery-plus-lightbox/?utm_source=WP&utm_medium=Album-Gallery&utm_campaign=Features-PRO#wpos-epb'); // Plugin link
}

if( ! defined( 'AIGPL_PLUGIN_LINK_UPGRADE' ) ) {
	define('AIGPL_PLUGIN_LINK_UPGRADE','https://www.essentialplugin.com/pricing/?utm_source=WP&utm_medium=Album-Gallery&utm_campaign=Upgrade-PRO#wpos-epb'); // Plugin Check link
}

if( ! defined( 'AIGPL_SITE_LINK' ) ) {
	define('AIGPL_SITE_LINK', 'https://www.essentialplugin.com'); // Plugin Site link
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_load_textdomain() {

	global $wp_version;

	// Set filter for plugin's languages directory
	$aigpl_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$aigpl_lang_dir = apply_filters( 'aigpl_pro_languages_directory', $aigpl_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'album-and-image-gallery-plus-lightbox' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'album-and-image-gallery-plus-lightbox', $locale );

	// Setup paths to current locale file
	$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( AIGPL_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'album-and-image-gallery-plus-lightbox', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'album-and-image-gallery-plus-lightbox', false, $aigpl_lang_dir );
	}
}
add_action('plugins_loaded', 'aigpl_load_textdomain');

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'aigpl_install' );

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'aigpl_uninstall');

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_install() {
	
	// Register post type function
	aigpl_register_post_type();
	aigpl_register_taxonomies();
	
	// Deactivate Pro version
	if( is_plugin_active('album-and-image-gallery-plus-lightbox-pro/album-and-image-gallery.php') ){
		add_action('update_option_active_plugins', 'aigpl_deactivate_pro_version');
	}

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();

	// Add option for solutions & features
	//add_option( 'aigpl_sf_optin', true );
}

/**
 * Deactivate PRO version when FREE is going to be active
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0
 */
function aigpl_deactivate_pro_version() {
   deactivate_plugins('album-and-image-gallery-plus-lightbox-pro/album-and-image-gallery.php',true);
}

/**
 * Display Plugin Notice
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0
 */
function aigpl_plugin_admin_notice() {

	global $pagenow;

	$dir                = WP_PLUGIN_DIR . '/album-and-image-gallery-plus-lightbox-pro/album-and-image-gallery.php';
	$notice_link        = add_query_arg( array('message' => 'aigpl-plugin-notice'), admin_url('plugins.php') );
	$notice_transient   = get_transient( 'aigpl_install_notice' );

	if( $notice_transient == false && $pagenow == 'plugins.php' && file_exists( $dir ) && current_user_can( 'install_plugins' ) ) {
		echo '<div class="updated notice" style="position:relative;">
			<p>
				<strong>'.sprintf( __('Thank you for activating %s', 'album-and-image-gallery-plus-lightbox'), 'Album and Image Gallery Plus Lightbox').'</strong>.<br/>
				'.sprintf( __('It looks like you had PRO version %s of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it.', 'album-and-image-gallery-plus-lightbox'), '<strong>(<em>Album and Image Gallery Plus Lightbox PRO</em>)</strong>' ).'
			</p>
			<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
		</div>';
	}
}
add_action( 'admin_notices', 'aigpl_plugin_admin_notice');

/**
 * Plugin Setup (On Deactivation)
 * 
 * Delete  plugin options.
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_uninstall() {
	
	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}

// Taking some globals
global $aigpl_gallery_render;

// Functions file
require_once( AIGPL_DIR . '/includes/aigpl-functions.php' );

// Plugin Post Type File
require_once( AIGPL_DIR . '/includes/aigpl-post-types.php' );

// Admin Class File
require_once( AIGPL_DIR . '/includes/admin/class-aigpl-admin.php' );

// Script Class File
require_once( AIGPL_DIR . '/includes/class-aigpl-script.php' );

// Shortcode File
require_once( AIGPL_DIR . '/includes/shortcode/aigpl-gallery.php' );
require_once( AIGPL_DIR . '/includes/shortcode/aigpl-gallery-slider.php' );
require_once( AIGPL_DIR . '/includes/shortcode/aigpl-gallery-album.php' );
require_once( AIGPL_DIR . '/includes/shortcode/aigpl-gallery-album-slider.php' );

// Gutenberg Block Initializer
if ( function_exists( 'register_block_type' ) ) {
	require_once( AIGPL_DIR . '/includes/admin/supports/gutenberg-block.php' );
}

/* Recommended Plugins Starts */
if ( is_admin() ) {
	require_once( AIGPL_DIR . '/wpos-plugins/wpos-recommendation.php' );

	wpos_espbw_init_module( array(
							'prefix'	=> 'aigpl',
							'menu'	=> 'edit.php?post_type='.AIGPL_POST_TYPE,
						));
}
/* Recommended Plugins Ends */

/* Plugin Wpos Analytics Data Starts */
function wpos_analytics_anl29_load() {

	require_once dirname( __FILE__ ) . '/wpos-analytics/wpos-analytics.php';

	$wpos_analytics =  wpos_anylc_init_module( array(
							'id'					=> 29,
							'file'				=> plugin_basename( __FILE__ ),
							'name'				=> 'Album and Image Gallery Plus Lightbox',
							'slug'      	   => 'album-and-image-gallery-plus-lightbox',
							'type'   	      => 'plugin',
							'menu' 	         => 'edit.php?post_type=aigpl_gallery',
							'redirect_page'	=> 'edit.php?post_type=aigpl_gallery&page=aigpl-solutions-features',
							'text_domain'		=> 'album-and-image-gallery-plus-lightbox',
						));

	return $wpos_analytics;
}

// Init Analytics
wpos_analytics_anl29_load();
/* Plugin Wpos Analytics Data Ends */