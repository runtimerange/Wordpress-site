<?php
/**
 * Alchemist Theme page
 *
 * @package Chique
 */

function anymags_about_admin_style( $hook ) {
	if ( 'appearance_page_anymags-about' === $hook ) {
		wp_enqueue_style( 'anymags-about-admin', get_theme_file_uri( 'assets/css/about-admin.css' ), null, '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'anymags_about_admin_style' );

/**
 * Add theme page
 */
function anymags_menu() {
	add_theme_page( esc_html__( 'About Theme', 'anymags' ), esc_html__( 'About Theme', 'anymags' ), 'edit_theme_options', 'anymags-about', 'anymags_about_display' );
}
add_action( 'admin_menu', 'anymags_menu' );

/**
 * Display About page
 */
function anymags_about_display() {
	$theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$description = explode( '. ', $theme->get( 'Description' ) );

					array_pop( $description );

					$description = implode( '. ', $description );

					echo esc_html( $description . '.' );
				?></p>
				<p class="actions">
					<a href="http://blogwpthemes.com/anymags-wp-theme/" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'anymags' ); ?></a>

					<a href="http://blogwpthemes.com/demo/anymags/" class="button button-secondary" target="_blank"><?php esc_html_e( 'View Demo', 'anymags' ); ?></a>

					<a href="http://blogwpthemes.com/demo/theme-docs/docs/anymags-documentation/" class="button button-primary" target="_blank"><?php esc_html_e( 'Theme Instructions', 'anymags' ); ?></a>

					<a href="http://wordpress.org/support/theme/anymags/#new-post" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate this theme', 'anymags' ); ?></a>

					<a href="http://blogwpthemes.com/product/anymags-blog-pro-wordpress-theme/" class="green button button-secondary" target="_blank"><?php esc_html_e( 'Upgrade to pro', 'anymags' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'anymags' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'anymags-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'anymags-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'anymags' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'anymags-about', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Free Vs Pro', 'anymags' ); ?></a>
		</nav>

		<?php
			anymags_main_screen();

			anymags_free_vs_pro_screen();

		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'anymags' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'anymags' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'anymags' ) : esc_html_e( 'Go to Dashboard', 'anymags' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function anymags_main_screen() {
	if ( isset( $_GET['page'] ) && 'anymags-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'anymags' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'anymags' ) ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'anymags' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'anymags' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'anymags' ) ?></p>
				<p><a href="http://blogwpthemes.com/forums/forum/theme-support/" class="button button-primary"><?php esc_html_e( 'Support Forum', 'anymags' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function anymags_free_vs_pro_screen() {
	if ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap vs-theme-table">
			<div id="compare" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" style="display: block;" aria-hidden="false">
			   <div class="tab-containter">
			      <div class="wrapper">
			         <div class="tab-header">
			            <h2 class="entry-title">Free Vs Pro (Premium)</h2>
			         </div>
			         <div class="compare-table">
			            <div class="hentry">
			            	<table>
							    <thead>
							        <tr>
							            <th>Free</th>
							            <th>Features</th>
							            <th>Pro (Premium)</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							            <td><i class="dashicons dashicons-yes"></i></td>
							            <td>Responsive Design</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-yes"></i></td>
							            <td>Super Easy Setup</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
									<tr>
							            <td><i class="dashicons dashicons-yes"></i></td>
							            <td>Woocommerce Compatible</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-yes"></i></td>
							            <td>Premium Support</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
									<tr>
							            <td><i class="dashicons dashicons-yes"></i></td>
							            <td>Excerpt Options</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Multiple Home Pages</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Unlimites Color Scheme</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Multiple Header Layouts</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Multiple Footer Layouts</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Footer Menu</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Premium Widgets</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Contact Form</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Social Shares</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Premium Plugins</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Page Customiztion</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Multiple Sidebar</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        <tr>
							            <td><i class="dashicons dashicons-no"></i></td>
							            <td>Multiple Page Layout</td>
							            <td><i class="dashicons dashicons-yes"></i></td>
							        </tr>
							        
							    </tbody>
							</table>
			            </div>
			         </div>
			      </div>
			   </div>
			</div>
		</div>
	<?php
	}
} 