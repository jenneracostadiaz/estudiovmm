<?php
add_action( 'wp_head', 'ci_theme_customizer_css' );
if( ! function_exists( 'ci_theme_customizer_css' ) ):
function ci_theme_customizer_css() {
    ?><style type="text/css"><?php


		//
		// Global
		//
		if ( get_theme_mod( 'site_text_color' ) ) {
			?>
			body,
			.tagline {
				color: <?php echo get_theme_mod( 'site_text_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_headings_color' ) ) {
			?>
			h1, h2, h3, h4, h5, h6,
			.entry-title,
			.entry-title a {
				color: <?php echo get_theme_mod( 'site_headings_color' ); ?>;
			}

			.entry-title:after {
				background: <?php echo get_theme_mod( 'site_headings_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'site_link_color' ) ) {
			?>
			a {
				color: <?php echo get_theme_mod( 'site_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_link_color_hover' ) ) {
			?>
			a:hover,
			.entry-title a:hover,
			.socials li a:hover,
			.entry-utils .socials a:hover {
				color: <?php echo get_theme_mod( 'site_link_color_hover' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_accent_color' ) ) {
			?>
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button:not(.slick-arrow),
			.comment-reply-link,
			.onsale,
			.woocommerce-product-gallery__trigger {
				background-color: <?php echo get_theme_mod( 'site_accent_color' ); ?>;
			}

			.read-more,
			.button,
			.entry-title a:hover,
			.entry-meta a,
			.slick-slider button,
			.entry-tags a:hover,
			.navigation > li > a:hover,
			.navigation > li.sfHover > a,
			.navigation > li.sfHover > a:active,
			.navigation a:hover,
			.navigation > li ul a:hover,
			.navigation > li ul .sfHover > a {
				color: <?php echo get_theme_mod( 'site_accent_color' ); ?>;
			}

			.read-more:hover,
			.button:hover {
				border-color: <?php echo get_theme_mod( 'site_accent_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_accent_color_hover' ) ) {
			?>
			#paging a:hover,
			.btn:hover,
			input[type="button"]:hover,
			input[type="submit"]:hover,
			input[type="reset"]:hover,
			button:not(.slick-arrow):hover,
			#paging a:hover,
			#paging .current {
				background-color: <?php echo get_theme_mod( 'site_accent_color_hover' ); ?>;
			}

			.entry-meta a:hover,
			.read-more:hover,
			.button:hover {
				color: <?php echo get_theme_mod( 'site_accent_color_hover' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_border_color' ) ) {
			?>
			.site-bar,
			.home #site-content,
			#footer {
				border-top-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.site-bar,
			.widget,
			.widget_meta ul li a,
			.widget_pages ul li a,
			.widget_categories ul li a,
			.widget_archive ul li a,
			.widget_nav_menu ul li a,
			.widget_recent_entries ul li a,
			.widget_recent_comments ul li {
				border-bottom-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.sidebar.sidebar-left,
			#paging a,
			#paging > span,
			#paging li span {
				border-right-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.sidebar.sidebar-right,
			.sidebars-right .sidebar.sidebar-left,
			blockquote {
				border-left-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.read-more,
			.button,
			.entry-content .entry-counter-list li,
			#paging {
				border-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}

			.entry-utils:before,
			.navigation ul {
				background-color: <?php echo get_theme_mod( 'site_border_color' ); ?>;
			}
			<?php
		}

		//
		// Logo
		//
		if( get_theme_mod( 'logo_padding_top' ) || get_theme_mod( 'logo_padding_bottom' ) ) {
			?>
			.site-logo img {
				<?php if( get_theme_mod( 'logo_padding_top' ) ): ?>
					padding-top: <?php echo intval( get_theme_mod( 'logo_padding_top' ) ); ?>px;
				<?php endif; ?>
				<?php if( get_theme_mod( 'logo_padding_bottom' ) ): ?>
					padding-bottom: <?php echo intval( get_theme_mod( 'logo_padding_bottom' ) ); ?>px;
				<?php endif; ?>
			}
			<?php
		}

		if ( get_theme_mod( 'header_logo_color' ) ) {
			?>
			.site-header .site-logo a,
			.site-header .site-logo a:hover {
				color: <?php echo get_theme_mod( 'header_logo_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_logo_font_size' ) ) {
			?>
			.site-header .site-logo h1 {
				font-size: <?php echo get_theme_mod( 'header_logo_font_size' ); ?>px;
			}
			<?php
		}

		if ( get_theme_mod( 'header_logo_letter_spacing' ) ) {
			?>
			.site-header .site-logo h1 {
				letter-spacing: <?php echo get_theme_mod( 'header_logo_letter_spacing' ); ?>px;
			}
			<?php
		}


		//
		// Footer logo
		//

		if ( get_theme_mod( 'footer_logo_color' ) ) {
			?>
			#footer .site-logo a,
			#footer .site-logo a:hover {
				color: <?php echo get_theme_mod( 'footer_logo_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'footer_logo_font_size' ) ) {
			?>
			#footer .site-logo h3 {
				font-size: <?php echo get_theme_mod( 'footer_logo_font_size' ); ?>px;
			}
			<?php
		}

		if ( get_theme_mod( 'footer_logo_letter_spacing' ) ) {
			?>
			#footer .site-logo h3 {
				letter-spacing: <?php echo get_theme_mod( 'footer_logo_letter_spacing' ); ?>px;
			}
			<?php
		}

		//
		// Typography
		//
		if( get_theme_mod( 'h1_size' ) ) {
			?>
			h1 {
				font-size: <?php echo get_theme_mod( 'h1_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h2_size' ) ) {
			?>
			h2 {
				font-size: <?php echo get_theme_mod( 'h2_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h3_size' ) ) {
			?>
			h3 {
				font-size: <?php echo get_theme_mod( 'h3_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h4_size' ) ) {
			?>
			h4 {
				font-size: <?php echo get_theme_mod( 'h4_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h5_size' ) ) {
			?>
			h5 {
				font-size: <?php echo get_theme_mod( 'h5_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h6_size' ) ) {
			?>
			h6 {
				font-size: <?php echo get_theme_mod( 'h6_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'body_text_size' ) ) {
			?>
			body {
				font-size: <?php echo get_theme_mod( 'body_text_size' ); ?>px;
			}
			<?php
		}

		if ( get_theme_mod( 'menu_text_size' ) ) {
			?>
			.site-header .navigation {
				font-size: <?php echo get_theme_mod( 'menu_text_size' ); ?>px;
			}
			<?php
		}


		if ( get_theme_mod( 'submenu_text_size' ) ) {
			?>
			.site-header .navigation > li ul a {
				font-size: <?php echo get_theme_mod( 'submenu_text_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_size' ) ) {
			?>
			.sidebar .widget-title {
				font-size: <?php echo get_theme_mod( 'widgets_title_size' ); ?>px;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_logo', 1 ) ) {
			?>
			.site-logo {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_content_headings', 0 ) ) {
			?>
			.entry-content h1,
			.entry-content h2,
			.entry-content h3,
			.entry-content h4,
			.entry-content h5,
			.entry-content h6 {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_post_titles', 1 ) ) {
			?>
			.entry-title,
			.slide-title,
			.section-title {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_widget_titles', 1 ) ) {
			?>
			.widget-title {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_navigation', 1 ) ) {
			?>
			.nav {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_buttons', 1 ) ) {
			?>
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button,
			.button,
			#paging,
			.comment-reply-link,
			.read-more {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_entry_meta', 1 ) ) {
			?>
			.entry-meta,
			.entry-tags,
			.entry-brands,
			.entry-sig,
			.comment-metadata,
			.slide-meta {
				text-transform: uppercase;
			}
			<?php
		}


		//
		// Sidebar
		//
		if( get_theme_mod( 'sidebar_bg_color' ) ) {
			?>
			.sidebar {
				background-color: <?php echo get_theme_mod( 'sidebar_bg_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_border_color' ) ) {
			?>
			.sidebar .widget,
			.widget_meta ul li a,
			.widget_pages ul li a,
			.widget_categories ul li a,
			.widget_archive ul li a,
			.widget_nav_menu ul li a,
			.widget_recent_entries ul li a,
			.widget_recent_comments ul li {
				border-color: <?php echo get_theme_mod( 'widgets_border_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_bg_color' ) ) {
			?>
			.sidebar .widget-title {
				background-color: <?php echo get_theme_mod( 'widgets_title_bg_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_color' ) ) {
			?>
			.sidebar .widget-title{
				color: <?php echo get_theme_mod( 'widgets_title_color' ); ?>;
			}

			.sidebar .widget-title:after {
				background: <?php echo get_theme_mod( 'widgets_title_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_text_color' ) ) {
			?>
			.sidebar {
				color: <?php echo get_theme_mod( 'widgets_text_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_link_color' ) ) {
			?>
			.sidebar a {
				color: <?php echo get_theme_mod( 'widgets_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_hover_color' ) ) {
			?>
			.sidebar a:hover {
				color: <?php echo get_theme_mod( 'widgets_hover_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'custom_css' ) ) {
			echo get_theme_mod( 'custom_css' );
		}

	?></style><?php
}
endif;

if( ! function_exists( 'ci_theme_custom_background_cb' ) ):
function ci_theme_custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color ) {
		if ( is_customize_preview() ) {
			echo '<style type="text/css" id="custom-background-css"></style>';
		}
		return;
	}

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = ' background-image: url("' . esc_url_raw( $background ) . '");';

		// Background Position.
		$position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		$position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

		if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
			$position_x = 'left';
		}

		if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
			$position_y = 'top';
		}

		$position = " background-position: $position_x $position_y;";

		// Background Size.
		$size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

		if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
			$size = 'auto';
		}

		$size = " background-size: $size;";

		// Background Repeat.
		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

		if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
			$repeat = 'repeat';
		}

		$repeat = " background-repeat: $repeat;";

		// Background Scroll.
		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

		if ( 'fixed' !== $attachment ) {
			$attachment = 'scroll';
		}

		$attachment = " background-attachment: $attachment;";

		$style .= $image . $position . $size . $repeat . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
	body.custom-background { <?php echo trim( $style ); ?> }
	.site-bar.is_stuck,
	.entry-utils .socials,
	.read-more,
	.navigation > li ul a,
	.navigation > li ul a:hover {
		background-color: #<?php echo $color; ?>
	}
	</style>
	<?php
}
endif;
