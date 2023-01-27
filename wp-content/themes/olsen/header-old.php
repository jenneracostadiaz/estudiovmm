<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta name="theme-color" content="#21387f" />
	<a class='flotante' href='https://api.whatsapp.com/send?phone=+51936534190&text=Hola%20GEO Open Data.' ><img src='https://geo-opendata.org/wp-content/uploads/2020/04/whatsapp_logo.png' border="0"/></a>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
	
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=977331562379399&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	</head>
<body <?php body_class(); ?>>

<div id="page">
<div class="row">  
	<div class="amarillo">
			<div class="col-md-4 mas2">
				<?php if ( ! is_page_template( 'template-blank.php') ) : ?>
					<header id="masthead" class="site-header group">

						<div class="site-logo">
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
		<div class="menu-lifecare">
					<header id="masthead" class="site-header group">
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
							<div id="mobilemenu">
								<?php wp_nav_menu( array(
									'theme_location' => 'main_menu',
									'container'      => '',
									'menu_id'        => '',
									'menu_class'     => 'mobile'
								) ); ?>
							
							
							</div>

							<?php $has_search = get_theme_mod( 'header_searchform', 1 ); ?>

							<div class="site-tools <?php echo $has_search === 1 ? 'has-search' : ''; ?>">
								<?php if ( $has_search == 1 ) {
									get_search_form();
								} ?>

								<?php if ( get_theme_mod( 'header_socials', 1 ) == 1 ) {
									get_template_part( 'part-social-icons' );
								} ?>
						
							</div><!-- /site-tools -->
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