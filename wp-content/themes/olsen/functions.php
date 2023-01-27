<?php
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/sanitization.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/helpers-post-meta.php';
require get_template_directory() . '/inc/custom-fields-post.php';
require get_template_directory() . '/inc/custom-fields-page.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-styles.php';
require get_template_directory() . '/inc/user-meta.php';
require get_template_directory() . '/inc/custom-taxonomy-brand.php';

add_filter('use_block_editor_for_post_type', '__return_false', 100);

add_action( 'after_setup_theme', 'ci_theme_content_width', 0 );
function ci_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ci_theme_content_width', 665 );
}

add_action( 'after_setup_theme', 'ci_theme_setup' );
if( !function_exists( 'ci_theme_setup' ) ) :
function ci_theme_setup() {

	if ( ! defined( 'CI_THEME_NAME' ) ) {
		define( 'CI_THEME_NAME', 'olsen' );
	}
	if ( ! defined( 'CI_WHITELABEL' ) ) {
		// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
		define( 'CI_WHITELABEL', false );
	}

	load_theme_textdomain( 'ci-theme', get_template_directory() . '/languages' );

	/*
	 * Theme supports.
	 */
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-formats', array(
		'image',
		'gallery',
		'audio',
		'video',
	) );
	add_theme_support( 'custom-background', array(
		'wp-head-callback' => 'ci_theme_custom_background_cb',
	) );
	add_theme_support( 'woocommerce' );

	/*
	 * Image sizes.
	 */
	set_post_thumbnail_size( 665, 435, true );
	add_image_size( 'ci_masonry', 665 );
	add_image_size( 'ci_slider', 1110, 600, true );
	add_image_size( 'ci_wide', 0, 260, false );
	add_image_size( 'ci_tall', 750, 1000, true );
	add_image_size( 'ci_square', 200, 200, true );

	/*
	 * Navigation menus.
	 */
	register_nav_menus( array(
		'main_menu'   => esc_html__( 'Main Menu', 'ci-theme' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'ci-theme' ),
		'idiomas'   => esc_html__( 'Idiomas', 'ci-theme' ),
	) );

	/*
	 * Default hooks
	 */
	// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
	add_action( 'admin_footer', 'ci_theme_print_inline_js' );
	add_action( 'wp_footer', 'ci_theme_print_inline_js' );

	// Handle the dismissible sample content notice.
	add_action( 'admin_notices', 'ci_theme_admin_notice_sample_content' );
	add_action( 'wp_ajax_ci_theme_dismiss_sample_content', 'ci_theme_ajax_dismiss_sample_content' );

	// Wraps post counts in span.ci-count
	// Needed for the default widgets, however more appropriate filters don't exist.
	add_filter( 'get_archives_link', 'ci_theme_wrap_archive_widget_post_counts_in_span', 10, 2 );
	add_filter( 'wp_list_categories', 'ci_theme_wrap_category_widget_post_counts_in_span', 10, 2 );

	ci_theme_migrate_background_color_to_native();
}
endif;



add_action( 'wp_enqueue_scripts', 'ci_theme_enqueue_scripts' );
function ci_theme_enqueue_scripts() {

	/*
	 * Styles
	 */
	$theme = wp_get_theme();

	$font_url = '';
	/* translators: If there are characters in your language that are not supported by Lora and Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Lora and Lato fonts: on or off', 'ci-theme' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lora:400,700,400italic,700italic|Lato:400,400italic,700,700italic' ), '//fonts.googleapis.com/css' );
	}
	wp_register_style( 'ci-google-font', esc_url( $font_url ) );

	wp_register_style( 'ci-base', get_template_directory_uri() . '/css/base.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' );
	wp_register_style( 'magnific', get_template_directory_uri() . '/css/magnific.css', array(), '1.0.0' );
	wp_register_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.5.7' );
	wp_register_style( 'mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), '5.2.0' );
	wp_register_style( 'justifiedGallery', get_template_directory_uri() . '/css/justifiedGallery.min.css', array(), '3.6.0' );

	wp_enqueue_style( 'ci-style', get_template_directory_uri() . '/style.css', array(
		'ci-google-font',
		'ci-base',
		'font-awesome',
		'magnific',
		'slick',
		'mmenu',
		'justifiedGallery',
	), $theme->get( 'Version' ) );

	if( is_child_theme() ) {
		wp_enqueue_style( 'ci-style-child', get_stylesheet_directory_uri() . '/style.css', array(
			'ci-style',
		), $theme->get( 'Version' ) );
	}

	/*
	 * Scripts
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.8.3', false );

	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
	wp_register_script( 'matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.5.7', true );
	wp_register_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.2.0', true );
	wp_register_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_register_script( 'magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/isotope.js', array( 'jquery' ), '2.2.2', true );
	wp_register_script( 'instagramLite', get_template_directory_uri() . '/js/instagramLite.min.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_register_script( 'justifiedGallery', get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '3.6.0', true );
	wp_register_script( 'sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js', array( 'jquery' ), '1.1.2', true );


	/*
	 * Enqueue
	 */
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'ci-front-scripts', get_template_directory_uri() . '/js/scripts.js', array(
		'jquery',
		'superfish',
		'matchHeight',
		'slick',
		'mmenu',
		'fitVids',
		'magnific',
		'isotope',
		'instagramLite',
		'justifiedGallery',
		'sticky-kit'
	), $theme->get( 'Version' ), true );

}

add_action( 'admin_enqueue_scripts', 'ci_theme_admin_enqueue_scripts' );
function ci_theme_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */


	/*
	 * Scripts
	 */


	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'ci-theme-post-meta' );
		wp_enqueue_script( 'ci-theme-post-meta' );
	}

	if ( in_array( $hook, array( 'profile.php', 'user-edit.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'ci-theme-post-meta' );
		wp_enqueue_script( 'ci-theme-post-meta' );
	}

	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'ci-theme-post-meta' );
		wp_enqueue_script( 'ci-theme-post-meta' );
	}

}

add_action( 'customize_controls_print_styles', 'ci_theme_enqueue_customizer_styles' );
function ci_theme_enqueue_customizer_styles() {
	$theme = wp_get_theme();

	wp_register_style( 'ci-customizer-styles', get_template_directory_uri() . '/css/admin/customizer-styles.css', array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'ci-customizer-styles' );
}


add_action( 'widgets_init', 'ci_theme_widgets_init' );
function ci_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'ci-theme' ),
		'id'            => 'blog',
		'description'   => __('This is the main sidebar.', 'ci-theme'),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Blog - Left', 'widget area', 'ci-theme' ),
		'id'            => 'blog-left',
		'description'   => __('Widgets assigned here only appear on the two sidebar blog layout', 'ci-theme'),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'ci-theme' ),
		'id'            => 'page',
		'description'   => __('This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'ci-theme'),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer Sidebar', 'widget area', 'ci-theme' ),
		'id'            => 'footer-widgets',
		'description'   => __('Special site-wide sidebar for the WP Instagram Widget plugin.', 'ci-theme'),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'ci_theme_load_widgets' );
function ci_theme_load_widgets() {
	require get_template_directory() . '/inc/widgets/ci-about-me.php';
	require get_template_directory() . '/inc/widgets/ci-latest-posts.php';
	require get_template_directory() . '/inc/widgets/ci-socials.php';
	require get_template_directory() . '/inc/widgets/ci-newsletter.php';
}

add_filter( 'excerpt_length', 'ci_theme_excerpt_length' );
function ci_theme_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}


add_filter( 'previous_posts_link_attributes', 'ci_theme_previous_posts_link_attributes' );
function ci_theme_previous_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-older"';
	return $attrs;
}
add_filter( 'next_posts_link_attributes', 'ci_theme_next_posts_link_attributes' );
function ci_theme_next_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-newer"';
	return $attrs;
}

add_filter( 'wp_page_menu', 'ci_theme_wp_page_menu', 10, 2 );
function ci_theme_wp_page_menu( $menu, $args ) {
	preg_match( '#^<div class="(.*?)">(?:.*?)</div>$#', $menu, $matches );
	$menu = preg_replace( '#^<div class=".*?">#', '', $menu, 1 );
	$menu = preg_replace( '#</div>$#', '', $menu, 1 );
	$menu = preg_replace( '#^<ul>#', '<ul class="' . esc_attr( $args['menu_class'] ) . '">', $menu, 1 );
	return $menu;
}


add_filter( 'the_content', 'ci_theme_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'ci_theme_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'ci_theme_lightbox_rel' );
if ( ! function_exists( 'ci_theme_lightbox_rel' ) ):
function ci_theme_lightbox_rel( $content ) {
	global $post;

	$data = 'data-lightbox="gal[' . $post->ID . ']"';

	$pattern = '#<a(.*?)>(.*?)</a>#i';
	if ( preg_match_all( $pattern, $content, $matches ) ) {
		foreach ( $matches[0] as $link_html ) {
			if ( strpos( $link_html, $data ) !== false ) {
				continue;
			}

			$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
			$replacement = '<a$1href=$2$3.$4$5 ' . $data . '$6>$7</a>';
			$fixed_html  = preg_replace( $pattern, $replacement, $link_html );
			$content     = str_replace( $link_html, $fixed_html, $content );
		}
	}

	return $content;
}
endif;


add_action( 'wp_head', 'ci_theme_print_google_analytics_tracking' );
if ( ! function_exists( 'ci_theme_print_google_analytics_tracking' ) ):
function ci_theme_print_google_analytics_tracking() {
	if ( is_admin() || ! get_theme_mod( 'google_anaytics_tracking_id' ) ) {
		return;
	}
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo get_theme_mod( 'google_anaytics_tracking_id' ); ?>', 'auto');
		ga('send', 'pageview');
	</script>
	<?php
}
endif;


add_filter( 'wp_link_pages_args', 'ci_theme_wp_link_pages_args' );
function ci_theme_wp_link_pages_args( $params ) {
	$params = array_merge( $params, array(
		'before' => '<p class="link-pages">' . __( 'Pages:', 'ci-theme' ),
		'after'  => '</p>',
	) );

	return $params;
}

if ( ! function_exists( 'ci_theme_has_more_tag' ) ):
function ci_theme_has_more_tag( $post = null ) {
	$post = get_post( $post );
	if ( preg_match( '/<!--more(.*?)?-->/', $post->post_content, $matches ) ) {
		return true;
	}

	return false;
}
endif;


if ( ! function_exists( 'ci_theme_get_social_networks') ) {
	function ci_theme_get_social_networks() {
		return array(
			array(
				'name'  => 'facebook',
				'label' => __( 'Facebook', 'ci-theme' ),
				'icon'  => 'fa-facebook'
			),
			array(
				'name'  => 'twitter',
				'label' => __( 'Twitter', 'ci-theme' ),
				'icon'  => 'fa-twitter'
			),
			array(
				'name'  => 'pinterest',
				'label' => __( 'Pinterest', 'ci-theme' ),
				'icon'  => 'fa-pinterest'
			),
			array(
				'name'  => 'instagram',
				'label' => __( 'Instagram', 'ci-theme' ),
				'icon'  => 'fa-instagram'
			),
			array(
				'name'  => 'gplus',
				'label' => __( 'Google Plus', 'ci-theme' ),
				'icon'  => 'fa-google-plus'
			),
			array(
				'name'  => 'linkedin',
				'label' => __( 'LinkedIn', 'ci-theme' ),
				'icon'  => 'fa-linkedin'
			),
			array(
				'name'  => 'tumblr',
				'label' => __( 'Tumblr', 'ci-theme' ),
				'icon'  => 'fa-tumblr'
			),
			array(
				'name'  => 'flickr',
				'label' => __( 'Flickr', 'ci-theme' ),
				'icon'  => 'fa-flickr'
			),
			array(
				'name'  => 'bloglovin',
				'label' => __( 'Bloglovin', 'ci-theme' ),
				'icon'  => 'fa-heart'
			),
			array(
				'name'  => 'youtube',
				'label' => __( 'YouTube', 'ci-theme' ),
				'icon'  => 'fa-youtube'
			),
			array(
				'name'  => 'vimeo',
				'label' => __( 'Vimeo', 'ci-theme' ),
				'icon'  => 'fa-vimeo'
			),
			array(
				'name'  => 'dribbble',
				'label' => __( 'Dribbble', 'ci-theme' ),
				'icon'  => 'fa-dribbble'
			),
			array(
				'name'  => 'wordpress',
				'label' => __( 'WordPress', 'ci-theme' ),
				'icon'  => 'fa-wordpress'
			),
			array(
				'name'  => '500px',
				'label' => __( '500px', 'ci-theme' ),
				'icon'  => 'fa-500px'
			),
			array(
				'name'  => 'soundcloud',
				'label' => __( 'Soundcloud', 'ci-theme' ),
				'icon'  => 'fa-soundcloud'
			),
			array(
				'name'  => 'spotify',
				'label' => __( 'Spotify', 'ci-theme' ),
				'icon'  => 'fa-spotify'
			),
			array(
				'name'  => 'vine',
				'label' => __( 'Vine', 'ci-theme' ),
				'icon'  => 'fa-vine'
			),
		);
	}
}

if ( ! function_exists( 'ci_theme_get_layout_classes' ) ) {
	function ci_theme_get_layout_classes( $setting ) {
		$layout            = get_theme_mod( $setting, 'classic_2side' );
		$content_col       = '';
		$sidebar_left_col  = '';
		$sidebar_right_col = '';
		$main_class        = 'entries-classic';
		$post_class        = '';
		$post_col          = '';
		$masonry           = false;

		switch ( $layout ) {
			case 'classic_2side':
				$content_col       = 'col-md-6 col-md-push-3';
				$sidebar_left_col  = 'col-md-3 col-md-pull-6';
				$sidebar_right_col = 'col-md-3';
				break;
			case 'classic_2side_right':
				$content_col       = 'col-md-6';
				$sidebar_left_col  = 'col-md-3';
				$sidebar_right_col = 'col-md-3';
				break;
			case 'classic_1side':
				$content_col       = 'col-md-8';
				$sidebar_right_col = 'col-md-4';
				break;
			case 'classic_full' :
				$content_col = 'col-md-8 col-md-offset-2';
				break;
			case 'small_side' :
				$content_col       = 'col-md-8';
				$sidebar_right_col = 'col-md-4';
				$main_class        = 'entries-list';
				$post_class        = 'entry-list';
				break;
			case 'small_full' :
				$content_col = 'col-md-8 col-md-offset-2';
				$main_class  = 'entries-list';
				$post_class  = 'entry-list';
				break;
			case '2cols_side' :
				$content_col       = 'col-md-8';
				$sidebar_right_col = 'col-md-4';
				$main_class        = 'entries-grid';
				$post_class        = 'entry-grid';
				$post_col          = 'col-sm-6';
				break;
			case '2cols_full' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				break;
			case '2cols_narrow' :
				$content_col = 'col-md-8 col-md-offset-2';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				break;
			case '2cols_masonry' :
				$content_col       = 'col-md-8';
				$sidebar_right_col = 'col-md-4';
				$main_class        = 'entries-grid';
				$post_class        = 'entry-grid';
				$post_col          = 'col-sm-6';
				$masonry           = true;
				break;
			case '3cols_full' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-md-4 col-sm-6';
				break;
			case '3cols_masonry' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-md-4 col-sm-6';
				$masonry     = true;
				break;
		}

		return array(
			'layout'            => $layout,
			'content_col'       => $content_col,
			'sidebar_right_col' => $sidebar_right_col,
			'sidebar_left_col'  => $sidebar_left_col,
			'main_class'        => $main_class,
			'post_class'        => $post_class,
			'post_col'          => $post_col,
			'masonry'           => $masonry
		);
	}
}


if ( ! function_exists( 'ci_theme_sanitize_blog_terms_layout' ) ):
function ci_theme_sanitize_blog_terms_layout( $layout ) {
	$layouts = array(
		'classic_2side',
		'classic_2side_right',
		'classic_1side',
		'classic_full',
		'small_side',
		'small_full',
		'2cols_side',
		'2cols_full',
		'2cols_narrow',
		'2cols_masonry',
		'3cols_full',
		'3cols_masonry',
	);
	if ( in_array( $layout, $layouts ) ) {
		return $layout;
	}

	return 'classic_1side';
}
endif;

if ( ! function_exists( 'ci_theme_sanitize_other_layout' ) ):
function ci_theme_sanitize_other_layout( $layout ) {
	$layouts = array(
		'side',
		'full',
	);
	if ( in_array( $layout, $layouts ) ) {
		return $layout;
	}

	return 'side';
}
endif;


//
// Migrate theme_mods from olsen-light
//
add_action( 'after_switch_theme', 'ci_theme_after_switch_theme_migrate_mods' );
function ci_theme_after_switch_theme_migrate_mods() {
	$theme_mods = get_theme_mods();
	$light_mods = get_option( 'theme_mods_olsen-light' );
	if ( get_theme_mod( 'imported_olsen_light' ) === false && ! empty( $light_mods ) ) {
		foreach ( $light_mods as $key => $option ) {
			if ( ! isset( $theme_mods[ $key ] ) ) {
				set_theme_mod( $key, $option );
			}
		}
		set_theme_mod( 'imported_olsen_light', true );
	}
}

//
// Migrate old background color mod to native
//
function ci_theme_migrate_background_color_to_native() {
	if ( get_theme_mod( 'site_bg_color' ) !== false ) {
		set_theme_mod( 'background_color', ci_theme_sanitize_hex_color( get_theme_mod( 'site_bg_color' ), false ) );
		remove_theme_mod( 'site_bg_color' );
	}
}

//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_layout_blog', 'ci_theme_handle_url_theme_mod_layout_blog' );
function ci_theme_handle_url_theme_mod_layout_blog( $value ) {

	if( ! empty( $_GET['layout_blog'] ) ) {
		$value = ci_theme_sanitize_blog_terms_layout( $_GET['layout_blog'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_terms', 'ci_theme_handle_url_theme_mod_layout_terms' );
function ci_theme_handle_url_theme_mod_layout_terms( $value ) {

	if( ! empty( $_GET['layout_terms'] ) ) {
		$value = ci_theme_sanitize_blog_terms_layout( $_GET['layout_terms'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_other', 'ci_theme_handle_url_theme_mod_layout_other' );
function ci_theme_handle_url_theme_mod_layout_other( $value ) {

	if( ! empty( $_GET['layout_other'] ) ) {
		$value = ci_theme_sanitize_other_layout( $_GET['layout_other'] );
	}
	return $value;
}

add_action( 'pre_get_posts', 'ci_theme_handle_url_posts_per_page' );
function ci_theme_handle_url_posts_per_page( $q ) {
	if ( $q->is_main_query() && ! ( is_admin() || $q->is_singular() || isset( $q->query_vars['posts_per_page'] ) ) ) {
		if( ! empty( $_GET['ppp'] ) && intval( $_GET['ppp'] ) > 0 && intval( $_GET['ppp'] ) <= 100 ) {
			$q->set( 'posts_per_page', intval( $_GET['ppp'] ) );
		}
	}
}

//
// WooCommerce integration
//

if ( class_exists( 'WooCommerce' ) ) :
	add_action( 'init', 'ci_theme_woocommerce_integration' );
	function ci_theme_woocommerce_integration() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	}

	// Change posts_per_page on upsell products
	add_filter( 'woocommerce_upsells_total', 'ci_woocommerce_upsells_total' );
	if ( !function_exists( 'ci_woocommerce_upsells_total' ) ):
	function ci_woocommerce_upsells_total( $limit ) {
		$limit =  4;
		return $limit;
	}
	endif;

	// Change posts_per_page on related products
	add_filter( 'woocommerce_output_related_products_args', 'ci_output_related_products_args' );
	if ( !function_exists( 'ci_output_related_products_args' ) ):
	function ci_output_related_products_args( $args ) {
		$args[ 'posts_per_page' ] =  4;
		return $args;
	}
	endif;

	// Change posts_per_page on cross sells
	add_filter( 'woocommerce_cross_sells_total', 'ci_woocommerce_cross_sells_total' );
	if ( !function_exists( 'ci_woocommerce_cross_sells_total' ) ):
	function ci_woocommerce_cross_sells_total( $limit ) {
		$limit =  4;
		return $limit;
	}
	endif;

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );

endif;
