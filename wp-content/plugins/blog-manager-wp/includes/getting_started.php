<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings      = get_option( 'wp_blog_pbsm_settings' );
$template_name = ( isset( $settings['template_name'] ) && $settings['template_name'] != '' ) ? $settings['template_name'] : 'Classical';

$pbsm_version = get_option( 'pbsm_version' );
?>
<div class="wrap getting-started-wrap">
	<h2 style="display: none;"></h2>
	<div class="intro">
		<div class="intro-content">
			<h3><?php esc_html_e( 'Getting Started', 'blog-manager-wp' ); ?></h3>
			<h4><?php esc_html_e( 'You will find everything you need to get started here with Blog Manager plugin.', 'blog-manager-wp' ); ?>
				
			</h4>
		</div>
		<div class="intro-logo">
			<div class="intro-logo-cover">
				<img src="<?php echo esc_url(PBSM_URL . 'assets/images/pbsmp-logo.png'); ?>" alt="<?php _e( 'Blog Manager WP Logo', 'blog-manager-wp' ); ?>" />
				<span class="pbsmp-version"><?php echo __( 'Version', 'blog-manager-wp' ) . ' ' . esc_html($pbsm_version); ?></span>
			</div>
		</div>
	</div>

	<div class="post-blog-showcase-manager-panel">
		<ul class="post-blog-showcase-manager-panel-list">
			<li class="panel-item active">
				<a data-id="pbsm-help-files" href="javascript:void(0)"  ><?php _e( 'Read This First', 'blog-manager-wp' ); ?></a>
			</li>
		</ul>
		<div class="post-blog-showcase-manager-panel-wrap">
			<div id="pbsm-help-files" class="pbsm-help-files" style="display: block;">
				<div class="pbsm-panel-left">
					<div class="pbsm-notification">
						<h2>
							<?php printf( __( 'Success, The Blog Manager is now activated! &#x1F60A', 'blog-manager-wp' ) ); ?>
						</h2>
						<?php
						$create_test    = true;
						$post_link      = get_option( 'blog_page_display', 0 );
						$view_post_link = '';
						if ( $post_link == '' || $post_link == 0 ) {
							$create_test = false;
						} else {
							$view_post_link = get_permalink( $post_link );
						}
						?>
						<h4 class="do-create-test-page" <?php echo esc_attr( $create_test ) ? 'style="display: none;"' : ''; ?>>
							<?php _e( 'Would you like to create one test blog page to check usage of Blog Manager plugin?', 'blog-manager-wp' ); ?> <br/>
							<a class="create-test-page" href="javascript:void(0)"><?php _e( 'Yes, Please do it', 'blog-manager-wp' ); ?></a> 
							<img src="<?php echo esc_url(PBSM_URL . 'assets/images/ajax-loader.gif'); ?>" style="display: none;"/>
						</h4>
						<p class="done-create-test-page" <?php echo esc_attr( ! $create_test ) ? 'style="display: none;"' : ''; ?>>
							<?php echo __( 'We have created a', 'blog-manager-wp' ) . ' <b>' . __( 'Blog Page', 'blog-manager-wp' ) . '</b> ' . __( 'with', 'blog-manager-wp' ) . ' <span class="template_name">"' . esc_html($template_name) . '"</span> ' . __( 'blog template.', 'blog-manager-wp' ); ?>
							<a href="<?php echo esc_url($view_post_link); ?>" target="_blank"><?php _e( 'Visit blog page', 'blog-manager-wp' ); ?></a>
						</p>
						<p><?php echo __( 'To customize the Blog Page design after complete installation,', 'blog-manager-wp' ) . ' <a href="admin.php?page=pbsm_settings">' . __( 'Go to Blog Manager Settings', 'blog-manager-wp' ) . '</a>. ' . __( 'In case of an any doubt,', 'blog-manager-wp' ); ?> </p>
					</div>

					<h3>
						<?php _e( 'Getting Started', 'blog-manager-wp' ); ?> <span>(<?php _e( 'Must Read', 'blog-manager-wp' ); ?>)</span>
					</h3>
					<p><?php _e( 'Once you’ve activated your plugin, you’ll be redirected to this Getting Started page (Blog Manager > Getting Started). Here, you can view the required and helpful steps to use plugin.', 'blog-manager-wp' ); ?></p>
					<p><?php _e( 'We recommed that please read the below sections for more details.', 'blog-manager-wp' ); ?></p>

					<hr id="pbsm-important-things">
					<h3>
						<?php _e( 'Important things', 'blog-manager-wp' ); ?> <span>(<?php _e( 'Required', 'blog-manager-wp' ); ?>)</span> <a href="#pbsm-important-things">#</a>
						<a class="back-to-top" href="#pbsm-help-files"><?php _e( 'Back to Top', 'blog-manager-wp' ); ?></a>
					</h3>
					<p><?php _e( 'To use Blog Manager, follow the below steps for initial setup - Correct the Reading Settings.', 'blog-manager-wp' ); ?></p>
					<ul>
						<li><?php echo __( 'To check the reading settings, click', 'blog-manager-wp' ) . ' <b><a href="options-reading.php" target="_blank">' . __( 'Settings > Reading', 'blog-manager-wp' ) . '</a></b> ' . __( 'in the WordPress admin menu.', 'blog-manager-wp' ); ?></li>
						<li><?php echo __( 'If your ', 'blog-manager-wp' ) . '<b>' . __( 'Posts page', 'blog-manager-wp' ) . ' </b> ' . __( ' selection selected with the same exact', 'blog-manager-wp' ) . ' <b>' . __( 'Blog Page', 'blog-manager-wp' ) . '</b> ' . __( 'selection that same page you seleced under Blog Manager settings then change that selection to default one (', 'blog-manager-wp' ) . ' <b>' . __( '" — Select — "', 'blog-manager-wp' ) . '</b> ' . __( ') from the dropdown.', 'blog-manager-wp' ); ?></li>
					</ul>

					<hr id="pbsm-shortcode-usage">
					<h3>
						<?php _e( 'How to use Blog Manager Shortcode?', 'blog-manager-wp' ); ?> <span>(<?php _e( 'Optional', 'blog-manager-wp' ); ?>)</span> <a href="#pbsm-shortcode-usage">#</a>
						<a class="back-to-top" href="#pbsm-help-files"><?php _e( 'Back to Top', 'blog-manager-wp' ); ?></a>
					</h3>
					<p><?php _e( 'Blog Manager is flexible to be used with any page builders like Visual Composer, Elementor, Beaver Builder, SiteOrigin, Tailor, etc.', 'blog-manager-wp' ); ?></p>
					<ul>
						<li><?php echo __( 'Use shortcode', 'blog-manager-wp' ) . ' <b>' . __( '[wp_pbsm]', 'blog-manager-wp' ) . '</b> ' . __( 'in any WordPress post or page.', 'blog-manager-wp' ); ?></li>
						<li><?php echo __( 'Use', 'blog-manager-wp' ) . ' <b> &lt;&quest;php echo do_shortcode("[wp_pbsm]"); &nbsp;&quest;&gt; </b>' . __( 'into a template file within your theme files.', 'blog-manager-wp' ); ?></li>
					</ul>

					<hr id="pbsm-plugin-support">
					<h3>
						<?php _e( 'Blog Manager Plugin Support', 'blog-manager-wp' ); ?> <a href="#pbsm-plugin-support">#</a>
						<a class="back-to-top" href="#pbsm-help-files"><?php _e( 'Back to Top', 'blog-manager-wp' ); ?></a>
					</h3>
					<p><?php _e( 'Blog Manager comes with this handy help file to help you get started with setting up the plugin and showcasing blog page in beautiful ways.', 'blog-manager-wp' ); ?></p>
				</div>
				<div class="pbsm-panel-right">

				</div>
			</div>
		</div>
	</div>
</div>
