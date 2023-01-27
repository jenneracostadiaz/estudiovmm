<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta name="theme-color" content="#264a64" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
	<div id="page">
    <header class="cerra">
		<div class="amarillo">
			<div class="col-md-4 mas2">
				<?php if ( ! is_page_template( 'template-blank.php') ) : ?>
					<div id="masthead" class="site-header group">

						<div class="site-logo sustituida">
							<h1>
								<a href="<?php echo esc_url( home_url() ); ?>">
									<?php if ( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ): ?>
										<img src="<?php echo esc_url( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>"
										     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
									<?php else: ?>
										<?php bloginfo( 'name' ); ?>
									<?php endif; ?>
								</a>
							</h1>

							<?php if ( get_bloginfo( 'description' ) ): ?>
								<p class="tagline"><?php bloginfo( 'description' ); ?></p>
							<?php endif; ?>
						</div><!-- /site-logo -->
			</div>
		</div>
		<div class="menu-lifecare ">
						<div class="site-bar group <?php echo get_theme_mod('header_sticky_menu') ? 'sticky-head' : ''; ?>">
							<nav class="nav" role="navigation">
								<?php wp_nav_menu( array(
									'theme_location' => 'main_menu',
									'container'      => '',
									'menu_id'        => '',
									'menu_class'     => 'navigation'
								) ); ?>

								<a class="mobile-nav-trigger" href="#mobilemenu"><i class="fa fa-navicon"></i> <?php _e( '', 'ci-theme' ); ?></a>
							</nav>
							<div class="movilsi" id="mobilemenu">
								<?php wp_nav_menu( array(
									'theme_location' => 'main_menu',
									'container'      => '',
									'menu_id'        => '',
									'menu_class'     => 'mobile'
								) ); ?>
							
						</header>
							</div>
						</div><!-- /site-bar -->
					</div>
				</div>
		</div>
		
	<div class="container">
		<div class="row">
			
					</div>
				<?php endif; ?>

				<?php if ( is_home() ) {
					get_template_part( 'part', 'slider' );
				} ?>

				<div id="site-content">