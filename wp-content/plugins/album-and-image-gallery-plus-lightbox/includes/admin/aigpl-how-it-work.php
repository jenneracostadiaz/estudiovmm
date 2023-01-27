<?php
/**
 * Getting Started Page
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wrap aigpl-wrap">
	<style type="text/css">
		.wpos-box{box-shadow: 0 5px 30px 0 rgba(214,215,216,.57);background: #fff; padding-bottom:10px; position:relative;}
		.wpos-box ul{padding: 15px;}
		.wpos-box h5{background:#555; color:#fff; padding:15px; text-align:center;}
		.wpos-box h4{ padding:0 15px; margin:5px 0; font-size:18px;}
		.wpos-box .button{margin:0px 15px 15px 15px; text-align:center; padding:7px 15px; font-size:15px;display:inline-block;}
		.wpos-box .wpos-list{list-style:square; margin:10px 0 0 20px;}
		.wpos-clearfix:before, .wpos-clearfix:after{content: "";display: table;}
		.wpos-clearfix::after{clear: both;}
		.wpos-clearfix{clear: both;}
		.wpos-col{width: 47%; float: left; margin-right:10px; margin-bottom:10px;}
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .wpos-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.aigpl-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.aigpl-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.upgrade-to-pro{font-size:18px; text-align:center; margin-bottom:15px;}
		.wpos-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
		.wpos-new-feature{ font-size: 10px; color: #fff; font-weight: bold; background-color: #03aa29; padding:1px 4px; font-style: normal; }
		.button-orange{background: #ff5d52 !important;border-color: #ff5d52 !important; font-weight: 600;}
		.button-blue{background: #0055fb !important;border-color: #0055fb !important; font-weight: 600;}
	</style>
	<h2><?php _e( 'How It Works', 'album-and-image-gallery-plus-lightbox' ); ?></h2>
	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">

				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="meta-box-sortables">

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'How It Works - Display and Shortcode', 'album-and-image-gallery-plus-lightbox' ); ?></span>
								</h2>
							</div>
							

							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php esc_html_e('Getting Started', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. Go to "Album Gallery --> Add Album Gallery tab".', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-2. Add Album title, description and images under Album and Image Gallery Plus Lightbox - Settings.', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-3. Under "Choose Gallery Images" click on "Gallery Images" button and select multiple images from WordPress media and click on "Add to Gallery" button.', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-4. You can find out shortcode for album under "Album Gallery" list view.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php esc_html_e('How Shortcode Works', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. Create a page like Album OR My Album.', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-2. Put below shortcode as per your need.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php esc_html_e('All Shortcodes', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery]</span> – <?php esc_html_e('Gallery Grid Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
												<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-slider]</span> – <?php esc_html_e('Gallery Slider Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
												<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-album]</span> – <?php esc_html_e('Image Album Grid Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
												<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-album-slider]</span> – <?php esc_html_e('Image Album Slider Shortcode', 'album-and-image-gallery-plus-lightbox'); ?>
											</td>
										</tr>
										
										<tr>
											<th>
												<label><?php esc_html_e('Documentation', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<a class="button button-primary" href="https://docs.essentialplugin.com/album-and-image-gallery-plus-lightbox/" target="_blank"><?php esc_html_e('Check Documentation', 'album-and-image-gallery-plus-lightbox'); ?></a>
											</td>
										</tr>
										
										<tr>
											<th>
												<label><?php esc_html_e('Demo', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<a class="button button-primary" href="https://demo.essentialplugin.com/album-and-image-gallery-plus-lightbox-demo/" target="_blank"><?php esc_html_e('Check Free Demo', 'album-and-image-gallery-plus-lightbox'); ?></a>
											</td>
										</tr>
										
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'Gutenberg Support', 'album-and-image-gallery-plus-lightbox' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php esc_html_e('How it Work', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. Go to the Gutenberg editor of your page.', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-2. Search "gallery/album" keyword in the Gutenberg block list.', 'album-and-image-gallery-plus-lightbox'); ?></li>
													<li><?php esc_html_e('Step-3. Add any block of gallery/album and you will find its relative options on the right end side.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'Help to improve this plugin!', 'album-and-image-gallery-plus-lightbox' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<p><?php esc_html_e('Enjoyed this plugin? You can help by rate this plugin', 'album-and-image-gallery-plus-lightbox'); ?> <a href="https://wordpress.org/support/plugin/album-and-image-gallery-plus-lightbox/reviews/#new-post" target="_blank"><?php esc_html_e('5 stars!', 'album-and-image-gallery-plus-lightbox'); ?></a></p>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-body-content -->
				
				<!--Upgrad to Pro HTML -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						<div class="postbox wpos-pro-box">
							<h3 class="hndle">
								<span><?php esc_html_e( 'Album and Gallery Premium Features', 'album-and-image-gallery-plus-lightbox' ); ?></span>
							</h3>
							<div class="inside">
								<ul class="wpos-list">
									<li><?php esc_html_e('15+ image gallery designs', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('4 shortcodes ', 'album-and-image-gallery-plus-lightbox'); ?>[aigpl-gallery], [aigpl-gallery-slider], [aigpl-gallery-album] and [aigpl-gallery-album-slider]</li>
									<li><?php esc_html_e('Display album category wise', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Easy Drag & Drop Image Feature', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Masonry style for image gallery', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Display gallery image with title and description', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Display image album with title and description', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Custom link to gallery image', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('WPBakery Page Builder Support', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e( 'Gutenberg, Elementor, Beaver and SiteOrigin Page Builder Support. <span class="wpos-new-feature">New</span>', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e( 'Divi Page Builder Native Support. <span class="wpos-new-feature">New</span>', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e( 'Fusion Page Builder (Avada) native support <em class="wpos-new-feature">New</em> <span>', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Template overriding feature support', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Strong Shortcode Parameters', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Slider Center Mode Effect', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Slider RTL support', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Custom CSS option', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('Fully responsive', 'album-and-image-gallery-plus-lightbox'); ?></li>
									<li><?php esc_html_e('100% Multi language', 'album-and-image-gallery-plus-lightbox'); ?></li>
								</ul>
								<div class="upgrade-to-pro"><?php echo sprintf( __( 'Gain access to <strong>Album and Image Gallery Plus Lightbox</strong>', 'album-and-image-gallery-plus-lightbox' ) ); ?></div>
								<a class="button button-primary wpos-button-full button-orange" href="<?php echo AIGPL_PLUGIN_LINK_UPGRADE; ?>" target="_blank"><?php esc_html_e('Grab Album Gallery Now', 'album-and-image-gallery-plus-lightbox'); ?></a>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-container-1 -->

			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div>
</div>