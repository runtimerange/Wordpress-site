<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package blog manager
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrap blog-manager-wrap">
	<style type="text/css">
		.pbsm-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.pbsm-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .pbsm-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.blog-manager-wrap .pbsm-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.blog-manager-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.blog-manager-upgrade-to-pro{font-size:18px; text-align:center; margin-bottom:15px;}
		.pbsm-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
		.pbsm-new-feature{ font-size: 10px; margin-left:2px; color: #fff; font-weight: bold; background-color: #03aa29; padding:1px 4px; font-style: normal; }
		.button-orange{background: #ff2700 !important;border-color: #ff2700 !important; font-weight: 600;}
	</style>
	<h2><?php _e( 'Documentation','blog-manager-wp' ); ?></h2>
	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="meta-box-sortables">
						
						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Need Support & Solutions?','blog-manager-wp' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<td>
												<p><?php _e('Boost design and best solution for your website.','blog-manager-wp'); ?></p> <br/>
												<a class="button button-primary button-orange" href="<?php echo BLOGMANAGER_WP_PLUGIN_UPGRADE?>" target="_blank"><?php _e('Buy Now','blog-manager-wp'); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Documentation - Display and shortcode','blog-manager-wp' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php _e('Geeting Started with Blog Manager Pro','blog-manager-wp'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php _e('Step-1. Go to "Blog Manager Pro --> Create New Layout".','blog-manager-wp'); ?></li>
													<li><?php _e('Step-2. Select Template, fill other settings and Save Changes.','blog-manager-wp'); ?></li>
													
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('How Shortcode Works','blog-manager-wp'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php _e('Step-1. Create a layout.','blog-manager-wp'); ?></li>
													<li><?php _e('Step-2. Put below shortcode as per your need.','blog-manager-wp'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('All Shortcodes','blog-manager-wp'); ?>:</label>
											</th>
											<td>
												<span class="pbsm-copy-clipboard blog-manager-shortcode-preview">[wp_pbsm"]</span> – <?php _e('Blog Manager Shortcode','blog-manager-wp'); ?>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('Documentation','blog-manager-wp'); ?>:</label>
											</th>
											<td>
												<a class="button button-primary" href="https://blogwpthemes.com/docs/blog-manager-wp-pro-documentation/" target="_blank"><?php _e('Check Documentation','blog-manager-wp'); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Help to improve this plugin!','blog-manager-wp' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<p><?php _e('Enjoyed this plugin? You can help by rate this plugin ','blog-manager-wp'); ?><a href="https://wordpress.org/plugins/blog-manager-wp/#reviews" target="_blank"><?php _e('5 stars!','blog-manager-wp'); ?></a></p>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-body-content -->

				<!--Upgrad to Pro HTML -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						<div class="postbox pbsm-pro-box">
							<h3 class="hndle">
								<span><?php _e( 'Upgrade to Pro','blog-manager-wp' ); ?></span>
							</h3>
							<div class="inside">
								<ul class="pbsm-list">
									<li><?php _e( '35+ cool designs','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Create better blog layout inside your WordPress website.','blog-manager-wp' ); ?></li>
									
									<li><?php _e( 'List and Magazine Blog Manager Layout','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Grid and Masonry Blog Manager Layout','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Slider Blog Manager Layout','blog-manager-wp' ); ?></li>
									<li><?php _e( 'You can create Archive Layouts','blog-manager-wp' ); ?></li>
									<li><?php _e( 'You can create Single Layouts','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Pagination and Load More features available','blog-manager-wp' ); ?></li>
									
									<li><?php _e( 'Blog Manager Filter Category and Tag Management – Separate your blog post with specific category and tag.','blog-manager-wp' ); ?></li>
								
									
									<li><?php _e( 'Mobile Compatibility View','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Add default image with media settings','blog-manager-wp' ); ?></li>
									
									<li><?php _e( 'Elementor, Beaver and SiteOrigin Page Builder Support.','blog-manager-wp'); ?> <span class="pbsm-new-feature">New</span></li>
									<li><?php _e( 'Divi Page Builder Native Support.','blog-manager-wp'); ?> <span class="pbsm-new-feature">New</span></li>
									
									<li><?php _e( 'WP Templating Features','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Custom CSS','blog-manager-wp' ); ?></li>
									<li><?php _e( 'Fully responsive','blog-manager-wp' ); ?></li>
									<li><?php _e( '500+ Font family','blog-manager-wp' ); ?></li>
									
								</ul>
								<div class="blog-manager-upgrade-to-pro"><?php echo sprintf( __( 'Gain access to <strong>Blog Manager Pro</strong>','blog-manager-wp' ) ); ?></div>
								<a class="button button-primary pbsm-button-full button-orange" href="<?php echo BLOGMANAGER_WP_PLUGIN_UPGRADE; ?>" target="_blank"><?php _e('Buy Now','blog-manager-wp'); ?></a>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-container-1 -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div>
</div>