<?php
add_action( 'customize_register', 'ci_theme_customize_register', 100 );
/**
 * Registers all theme-related options to the Customizer.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function ci_theme_customize_register( $wpc ) {

	$wpc->add_section( 'header', array(
		'title'       => _x( 'Header Options', 'customizer section title', 'ci-theme' ),
		'priority'    => 1
	) );

	$wpc->get_panel( 'nav_menus' )->priority = 2;

	$wpc->add_section( 'layout', array(
		'title'    => _x( 'Layout Options', 'customizer section title', 'ci-theme' ),
		'priority' => 20
	) );

	$wpc->add_section( 'homepage', array(
		'title'    => _x( 'Front Page Carousel', 'customizer section title', 'ci-theme' ),
		'priority' => 25
	) );

	$wpc->add_section( 'typography', array(
		'title'    => _x( 'Typography Options', 'customizer section title', 'ci-theme' ),
		'priority' => 30
	) );

	$wpc->get_section( 'colors' )->title    = __( 'Content Colors', 'ci-theme' );
	$wpc->get_section( 'colors' )->priority = 40;

	$wpc->add_section( 'sidebar', array(
		'title'       => _x( 'Sidebar Colors', 'customizer section title', 'ci-theme' ),
		'description' => __( 'These options affect your sidebar (when visible).', 'ci-theme' ),
		'priority'    => 50
	) );

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'widgets' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	//$wpc->get_panel( 'widgets' )->priority = 55;
	$panel_widgets = (object) $wpc->get_panel( 'widgets' );
	$panel_widgets->priority = 55;

	$wpc->add_section( 'social', array(
		'title'       => _x( 'Social Networks', 'customizer section title', 'ci-theme' ),
		'description' => __( 'Enter your social network URLs. Leaving a URL empty will hide its respective icon.', 'ci-theme' ),
		'priority'    => 60
	) );

	$wpc->add_section( 'single_post', array(
		'title'       => _x( 'Posts Options', 'customizer section title', 'ci-theme' ),
		'description' => __( 'These options affect your individual posts.', 'ci-theme' ),
		'priority'    => 70
	) );

	$wpc->add_section( 'single_page', array(
		'title'       => _x( 'Pages Options', 'customizer section title', 'ci-theme' ),
		'description' => __( 'These options affect your individual pages.', 'ci-theme' ),
		'priority'    => 80
	) );

	$wpc->add_section( 'footer', array(
		'title'       => _x( 'Footer Options', 'customizer section title', 'ci-theme' ),
		'priority'    => 100
	) );

	// Section 'static_front_page' is not defined when there are no pages.
	if ( get_pages() ) {
		$wpc->get_section( 'static_front_page' )->priority = 110;
	}

	$wpc->add_section( 'other', array(
		'title'       => _x( 'Other', 'customizer section title', 'ci-theme' ),
		'description' => __( 'Other options affecting the whole site.', 'ci-theme' ),
		'priority'    => 120
	) );



	//
	// Group options by registering the setting first, and the control right after.
	//

	//
	// Layout
	//
	$choices = array(
		'classic_2side'       => _x( 'Classic - Two Sidebars', 'page layout', 'ci-theme' ),
		'classic_2side_right' => _x( 'Classic - Two Sidebars on the Right', 'page layout', 'ci-theme' ),
		'classic_1side'       => _x( 'Classic - One Sidebar', 'page layout', 'ci-theme' ),
		'classic_full'        => _x( 'Classic - Full width', 'page layout', 'ci-theme' ),
		'small_side'          => _x( 'Small images - Sidebar', 'page layout', 'ci-theme' ),
		'small_full'          => _x( 'Small images - Full width', 'page layout', 'ci-theme' ),
		'2cols_side'          => _x( 'Two columns - Sidebar', 'page layout', 'ci-theme' ),
		'2cols_full'          => _x( 'Two columns - Full width', 'page layout', 'ci-theme' ),
		'2cols_narrow'        => _x( 'Two columns - Narrow - Full width', 'page layout', 'ci-theme' ),
		'2cols_masonry'       => _x( 'Two columns - Masonry - Sidebar', 'page layout', 'ci-theme' ),
		'3cols_full'          => _x( 'Three columns - Full width', 'page layout', 'ci-theme' ),
		'3cols_masonry'       => _x( 'Three columns - Masonry - Full width', 'page layout', 'ci-theme' ),
	);
	$wpc->add_setting( 'layout_blog', array(
		'default'           => 'classic_2side',
		'sanitize_callback' => 'ci_theme_sanitize_blog_terms_layout',
	) );
	$wpc->add_control( 'layout_blog', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Blog layout', 'ci-theme' ),
		'description' => __( 'Applies to the home page and blog-related pages.', 'ci-theme' ),
		'choices'     => $choices,
	) );

	$wpc->add_setting( 'layout_terms', array(
		'default'           => 'classic_2side',
		'sanitize_callback' => 'ci_theme_sanitize_blog_terms_layout',
	) );
	$wpc->add_control( 'layout_terms', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Categories and Tags layout', 'ci-theme' ),
		'description' => __( 'Applies to the categories and tags listing pages.', 'ci-theme' ),
		'choices'     => $choices,
	) );

	$wpc->add_setting( 'layout_other', array(
		'default'           => 'side',
		'sanitize_callback' => 'ci_theme_sanitize_other_layout',
	) );
	$wpc->add_control( 'layout_other', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Other Pages layout', 'ci-theme' ),
		'description' => __( 'Applies to all other pages, e.g. 404 page, etc.', 'ci-theme' ),
		'choices'     => array(
			'side' => _x( 'With sidebar', 'page layout', 'ci-theme' ),
			'full' => _x( 'Full width', 'page layout', 'ci-theme' ),
		),
	) );

	$wpc->add_setting( 'excerpt_length', array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
	) );
	$wpc->add_control( 'excerpt_length', array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'step' => 1,
		),
		'section'     => 'layout',
		'label'       => __( 'Automatically generated excerpt length (in words)', 'ci-theme' ),
	) );

	$wpc->add_setting( 'excerpt_on_classic_layout', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'excerpt_on_classic_layout', array(
		'type'    => 'checkbox',
		'section' => 'layout',
		'label'   => __( 'Display the excerpt on classic blog layouts.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'pagination_method', array(
		'default'           => 'numbers',
		'sanitize_callback' => 'ci_theme_sanitize_pagination_method',
	) );
	$wpc->add_control( 'pagination_method', array(
		'type'    => 'select',
		'section' => 'layout',
		'label'   => __( 'Pagination method', 'ci-theme' ),
		'choices' => array(
			'numbers' => _x( 'Numbered links', 'pagination method', 'ci-theme' ),
			'text'    => _x( '"Previous - Next" links', 'pagination method', 'ci-theme' ),
		),
	) );



	//
	// Header
	//
	$wpc->add_setting( 'header_socials', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_socials', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => __( 'Show social icons.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'header_searchform', array(
		'default'           => 0,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_searchform', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => __( 'Show search form.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'header_sticky_menu', array(
		'default'           => 0,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_sticky_menu', array(
		'type'    => 'checkbox',
		'section' => 'header',
		'label'   => __( 'Sticky menu.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'header_logo_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_logo_color', array(
		'section' => 'header',
		'label'   => __( 'Logo color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'header_logo_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'header_logo_font_size', array(
		'type'    => 'number',
		'section' => 'header',
		'label'   => __( 'Logo font size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'header_logo_letter_spacing', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'header_logo_letter_spacing', array(
		'type'    => 'number',
		'section' => 'header',
		'label'   => __( 'Logo letter spacing', 'ci-theme' ),
	) );


	//
	// Footer
	//
	$wpc->add_setting( 'footer_tagline', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_tagline', array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => __( 'Show tagline.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'footer_socials', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_socials', array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => __( 'Show social icons.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'footer_logo_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'footer_logo_color', array(
		'section' => 'footer',
		'label'   => __( 'Footer logo color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'footer_logo_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'footer_logo_font_size', array(
		'type'    => 'number',
		'section' => 'footer',
		'label'   => __( 'Footer logo font size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'footer_logo_letter_spacing', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'footer_logo_letter_spacing', array(
		'type'    => 'number',
		'section' => 'footer',
		'label'   => __( 'Footer logo letter spacing', 'ci-theme' ),
	) );


	if ( class_exists( 'null_instagram_widget' ) ) {
		$wpc->add_setting( 'instagram_auto', array(
			'default'           => 1,
			'sanitize_callback' => 'ci_theme_sanitize_checkbox',
		) );
		$wpc->add_control( 'instagram_auto', array(
			'type'    => 'checkbox',
			'section' => 'footer',
			'label'   => __( 'WP Instagram: Slideshow.', 'ci-theme' ),
		) );

		$wpc->add_setting( 'instagram_speed', array(
			'default'           => 300,
			'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
		) );
		$wpc->add_control( 'instagram_speed', array(
			'type'    => 'number',
			'section' => 'footer',
			'label'   => __( 'WP Instagram: Slideshow Speed.', 'ci-theme' ),
		) );
	}

	//
	// Social
	//
	$wpc->add_setting( 'social_target', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'social_target', array(
		'type'    => 'checkbox',
		'section' => 'social',
		'label'   => __( 'Open social and sharing links in a new tab.', 'ci-theme' ),
	) );

	$networks = ci_theme_get_social_networks();

	foreach ( $networks as $network ) {
		$wpc->add_setting( 'social_' . $network['name'], array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wpc->add_control( 'social_' . $network['name'], array(
			'type'    => 'url',
			'section' => 'social',
			'label'   => sprintf( _x( '%s URL', 'social network url', 'ci-theme' ), $network['label'] ),
		) );
	}

	$wpc->add_setting( 'rss_feed', array(
		'default'           => get_bloginfo( 'rss2_url' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'rss_feed', array(
		'type'    => 'url',
		'section' => 'social',
		'label'   => __( 'RSS Feed', 'ci-theme' ),
	) );

	//
	// Typography
	//
	$wpc->add_setting( 'h1_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h1_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H1 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'h2_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h2_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H2 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'h3_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h3_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H3 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'h4_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h4_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H4 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'h5_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h5_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H5 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'h6_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h6_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'H6 size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'body_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'body_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Body text size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'menu_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'menu_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Menu text size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'submenu_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'submenu_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Sub-menu text size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'widgets_title_size', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'widgets_title_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Widgets title size', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_logo', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_logo', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize textual logo and site tagline.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_navigation', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_navigation', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize navigation menus.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_content_headings', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_content_headings', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize post content headings (H1-H6).', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_post_titles', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_post_titles', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize post titles.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_entry_meta', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_entry_meta', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize entry meta (categories, time, tags).', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_widget_titles', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_widget_titles', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize widget titles.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'capital_buttons', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_buttons', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize button text.', 'ci-theme' ),
	) );


	//
	// Homepage
	//
	$wpc->add_control( new CI_Theme_Customize_Slick_Control( $wpc, 'home_slider', array(
		'section'     => 'homepage',
		'label'       => __( 'Home Slider', 'ci-theme' ),
		'description' => __( 'Fine-tune the homepage slider.', 'ci-theme' ),
	), array(
		'taxonomy' => 'category',
	) ) );


	//
	// Global colors
	//
	$wpc->get_control( 'background_image' )->section      = 'colors';
	$wpc->get_control( 'background_repeat' )->section     = 'colors';
	$wpc->get_control( 'background_attachment' )->section = 'colors';
	if ( ! is_null( $wpc->get_control( 'background_position_x' ) ) ) {
		$wpc->get_control( 'background_position_x' )->section = 'colors';
	} else {
		$wpc->get_control( 'background_position' )->section = 'colors';
		$wpc->get_control( 'background_preset' )->section   = 'colors';
		$wpc->get_control( 'background_size' )->section     = 'colors';
	}

	$wpc->add_setting( 'site_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Text color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_headings_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_headings_color', array(
		'section' => 'colors',
		'label'   => __( 'Headings color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_link_color', array(
		'section' => 'colors',
		'label'   => __( 'Link color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_link_color_hover', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_link_color_hover', array(
		'section' => 'colors',
		'label'   => __( 'Link hover color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_accent_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Accent Color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_accent_color_hover', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_accent_color_hover', array(
		'section' => 'colors',
		'label'   => __( 'Accent Color Hover', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'site_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_border_color', array(
		'section' => 'colors',
		'label'   => __( 'Border Color', 'ci-theme' ),
	) ) );


	//
	// Single Post
	//
	$wpc->add_setting( 'single_categories', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_categories', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show categories.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_tags', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_tags', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show tags.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_brands', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_brands', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show brands.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_date', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_date', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show date.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_comments', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_comments', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show comments.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_featured', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_featured', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show featured media.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_signature', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_signature', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show signature.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_social_sharing', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_social_sharing', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show social sharing buttons.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_nextprev', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_nextprev', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show next/previous post links.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_authorbox', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_authorbox', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show author box.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_related', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_related', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show related posts.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_related_title', array(
		'default'           => __( 'You may also like', 'ci-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'single_related_title', array(
		'type'    => 'text',
		'section' => 'single_post',
		'label'   => __( 'Related Posts section title', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_affiliate_title', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'single_affiliate_title', array(
		'type'        => 'text',
		'section'     => 'single_post',
		'label'       => __( 'Affiliate disclosure link text', 'ci-theme' ),
		'description' => __( 'If you promote products through affiliations, in some countries, you must provide a full disclosure about it. Use the following fields to create a link to your affiliate disclosure page. This link will appear at the very bottom of each post.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'single_affiliate_link', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'single_affiliate_link', array(
		'type'    => 'url',
		'section' => 'single_post',
		'label'   => __( 'Affiliate disclosure link', 'ci-theme' ),
	) );



	//
	// Single Page
	//
	$wpc->add_setting( 'page_signature', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'page_signature', array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => __( 'Show signature.', 'ci-theme' ),
	) );

	$wpc->add_setting( 'page_social_sharing', array(
		'default'           => 1,
		'sanitize_callback' => 'ci_theme_sanitize_checkbox',
	) );
	$wpc->add_control( 'page_social_sharing', array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => __( 'Show social sharing buttons.', 'ci-theme' ),
	) );


	//
	// Sidebar
	//
	$wpc->add_setting( 'sidebar_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_bg_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Background color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_border_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget border color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_title_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_title_bg_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget title background color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_title_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_title_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget title color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_text_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget text color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_link_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget link color', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'widgets_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_hover_color', array(
		'section' => 'sidebar',
		'label'   => __( 'Widget hover color', 'ci-theme' ),
	) ) );


	//
	// Other
	//
	$wpc->add_setting( 'custom_css', array(
		'default'              => '',
		'sanitize_callback'    => 'ci_theme_sanitize_custom_css',
		'sanitize_js_callback' => 'ci_theme_sanitize_custom_css',
	) );
	$wpc->add_control( 'custom_css', array(
		'type'    => 'textarea',
		'section' => 'other',
		'label'   => __( 'Custom CSS', 'ci-theme' ),
	) );

	$wpc->add_setting( 'google_anaytics_tracking_id', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'google_anaytics_tracking_id', array(
		'type'        => 'text',
		'section'     => 'other',
		'label'       => esc_html__( 'Google Analytics Tracking ID', 'ci-theme' ),
		'description' => sprintf( __( 'Tracking is enabled only for the non-admin portion of your website. If you need fine-grained control of the tracking code, you are strongly advised to <a href="%s" target="_blank">use a specialty plugin</a> instead.', 'ci-theme' ), 'https://wordpress.org/plugins/search.php?q=analytics' ),
	) );


	//
	// site_tagline Section
	//
	$wpc->add_setting( 'logo', array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'logo', array(
		'section'     => 'title_tagline',
		'label'       => __( 'Logo', 'ci-theme' ),
		'description' => __( 'If an image is selected, it will replace the default textual logo (site name) on the header.', 'ci-theme' ),
	) ) );

	$wpc->add_setting( 'logo_padding_top', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_top', array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => __( 'Logo top padding', 'ci-theme' ),
	) );

	$wpc->add_setting( 'logo_padding_bottom', array(
		'default'           => '',
		'sanitize_callback' => 'ci_theme_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_bottom', array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => __( 'Logo bottom padding', 'ci-theme' ),
	) );

	$wpc->add_setting( 'footer_logo', array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'footer_logo', array(
		'section'     => 'title_tagline',
		'label'       => __( 'Footer logo', 'ci-theme' ),
		'description' => __( 'If an image is selected, it will replace the default textual logo (site name) on the footer.', 'ci-theme' ),
	) ) );
}


add_action( 'customize_register', 'ci_theme_customize_register_custom_controls', 9 );
/**
 * Registers custom Customizer controls.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function ci_theme_customize_register_custom_controls( $wpc ) {
	require get_template_directory() . '/inc/customizer-controls/slick.php';
}
