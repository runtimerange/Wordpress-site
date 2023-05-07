<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package Accordion Slider Gallery Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrap timline-wp-wrap">
	<style type="text/css">
		.asg-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.asg-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .asg-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.timline-wp-wrap .asg-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.timline-wp-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.upgrade-to-pro{font-size:18px; text-align:center; margin-bottom:15px;}
		.asg-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
		.asg-new-feature{ font-size: 10px; margin-left:2px; color: #fff; font-weight: bold; background-color: #03aa29; padding:1px 4px; font-style: normal; }
		.button-orange{background: #ff2700 !important;border-color: #ff2700 !important; font-weight: 600;}
	</style>
	<h2><?php _e( 'Documentation', 'accordion-slider' ); ?></h2>
	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="meta-box-sortables">
						
						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Need Support & Solutions?', 'accordion-slider' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<td>
												<p><?php _e('Boost design and best solution for your website.', 'accordion-slider'); ?></p> <br/>
												<a class="button button-primary button-orange" href="<?php echo ACCORDION_SLIDER_PLUGIN_UPGRADE?>" target="_blank"><?php _e('Buy Now', 'accordion-slider'); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Documentation - Display and shortcode', 'accordion-slider' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php _e('Getting Started with Accordion Slider', 'accordion-slider'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php _e('Step-1. Go to "Accordion Slider --> Add New".', 'accordion-slider'); ?></li>
													<li><?php _e('Step-2. Add post title, images , title, description and button details then publish.', 'accordion-slider'); ?></li>
													
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('How Shortcode Works', 'accordion-slider'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php _e('Step-1. Create a page like Accordion OR Post Accordion.', 'accordion-slider'); ?></li>
													<li><?php _e('Step-2. Paste Accordion shortcode to the page or post as per your need.', 'accordion-slider'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('All Shortcodes', 'accordion-slider'); ?>:</label>
											</th>
											<td>
												<span class="asg-copy-clipboard timline-wp-shortcode-preview">[accordion-slider id="id number"]</span> – <?php _e('Accordion Slider Shortcode', 'accordion-slider'); ?>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php _e('Documentation', 'accordion-slider'); ?>:</label>
											</th>
											<td>
												<a class="button button-primary" href="https://blogwpthemes.com/docs/accordion-slider-gallery-documentation/
" target="_blank"><?php _e('Check Documentation', 'accordion-slider'); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php _e( 'Help to improve this plugin!', 'accordion-slider' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<p><?php _e('Enjoyed this plugin? You can help by rate this plugin ', 'accordion-slider'); ?><a href="https://wordpress.org/support/plugin/accordion-slider-gallery/reviews/" target="_blank"><?php _e('5 stars!', 'accordion-slider'); ?></a></p>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-body-content -->

				<!--Upgrad to Pro HTML -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						<div class="postbox asg-pro-box">
							<h3 class="hndle">
								<span><?php _e( 'Upgrade to Pro', 'accordion-slider' ); ?></span>
							</h3>
							<div class="inside">
								<ul class="asg-list">
									<li><?php _e( '20+ Cool Designs', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Create unlimited Accordion Slider inside your WordPress website or blog.', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Use via Shortcodes and adding 20+ Designs', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Vertical and Horizontal Accordion', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Also work with WordPress POST', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Add Unlimited Images', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Lightbox', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Image Border Settings', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Navigation Settings', 'accordion-slider' ); ?></li>

									<li><?php _e( 'Accordion Scrolling via Mouse and Keyboard - Quickly and easily navigate your Accordion with a beautiful scrolling navigation inside your Accordion.', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Mobile Compatibility View', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Gutenberg Block Supports', 'accordion-slider'); ?></li>
									
									<li><?php _e( 'Elementor, Beaver and SiteOrigin Page Builder Support', 'accordion-slider'); ?> <span class="asg-new-feature">New</span></li>
									<li><?php _e( 'Divi Page Builder Native Support', 'accordion-slider'); ?> <span class="asg-new-feature">New</span></li>
									
									<li><?php _e( 'Custom CSS', 'accordion-slider' ); ?></li>
									<li><?php _e( 'Fully Responsive', 'accordion-slider' ); ?></li>
									
								</ul>
								<div class="upgrade-to-pro"><?php echo sprintf( __( 'Gain access to <strong>Accordion Slider Gallery Pro</strong>', 'accordion-slider' ) ); ?></div>
								<a class="button button-primary asg-button-full button-orange" href="<?php echo ACCORDION_SLIDER_PLUGIN_UPGRADE; ?>" target="_blank"><?php _e('Buy Now', 'accordion-slider'); ?></a>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-container-1 -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div>
</div>