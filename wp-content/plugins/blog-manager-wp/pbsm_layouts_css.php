<?php
$settings                       = get_option( 'wp_blog_pbsm_settings' );
$background                     = ( isset( $settings['template_bgcolor'] ) 			&& $settings['template_bgcolor'] != '' ) 			?	 $settings['template_bgcolor'] : '';
$templatecolor                  = ( isset( $settings['template_color'] ) 			&& $settings['template_color'] != '' ) 				?	 $settings['template_color'] : '';
$grid_hoverback_color           = ( isset( $settings['grid_hoverback_color'] ) 		&& $settings['grid_hoverback_color'] != '' ) 		?	 $settings['grid_hoverback_color'] : '';
$color                          = ( isset( $settings['template_ftcolor'] ) 			&& $settings['template_ftcolor'] != '' ) 			?	 $settings['template_ftcolor'] : '';
$linkhover                      = ( isset( $settings['template_fthovercolor'] ) 	&& $settings['template_fthovercolor'] != '' ) 		?	 $settings['template_fthovercolor'] : '';
$titlecolor                     = ( isset( $settings['template_titlecolor'] ) 		&& $settings['template_titlecolor'] != '' ) 		?	 $settings['template_titlecolor'] : '';
$titlehovercolor                = ( isset( $settings['template_titlehovercolor'] ) 	&& $settings['template_titlehovercolor'] != '' ) 	?	 $settings['template_titlehovercolor'] : '';
$contentcolor                   = ( isset( $settings['template_contentcolor'] ) 	&& $settings['template_contentcolor'] != '' ) 		?	 $settings['template_contentcolor'] : '';
$readmorecolor                  = ( isset( $settings['template_readmorecolor'] ) 	&& $settings['template_readmorecolor'] != '' ) 		?	 $settings['template_readmorecolor'] : '';
$readmorebackcolor              = ( isset( $settings['template_readmorebackcolor'] )&& $settings['template_readmorebackcolor'] != '' ) 	?	 $settings['template_readmorebackcolor'] : '';
$alterbackground                = ( isset( $settings['template_alterbgcolor'] ) 	&& $settings['template_alterbgcolor'] != '' ) 		?	 $settings['template_alterbgcolor'] : '';
$titlebackcolor                 = ( isset( $settings['template_titlebackcolor'] ) 	&& $settings['template_titlebackcolor'] != '' ) 	?	 $settings['template_titlebackcolor'] : '';
$social_icon_style              = get_option( 'social_icon_style' );
$template_alternativebackground = get_option( 'template_alternativebackground' );
$template_titlefontsize         = get_option( 'template_titlefontsize' );
$template_titleLineHeight       = get_option( 'template_titleLineHeight' );
$template_titleLetterSpacing    = get_option( 'template_titleLetterSpacing' );
$content_fontsize               = get_option( 'content_fontsize' );
$content_LineHeight             = get_option( 'content_LineHeight' );
$content_LetterSpacing          = get_option( 'content_LetterSpacing' );
?>

<style type="text/css">

	/**
	 * Table of Contents
	 *
	 * 1.0 - Pagination
	 * 2.0 - Social Media Icon
	 * 3.0 - Default Blog Template
	 * 4.0 - Default Layout Template
	 * 5.0 - Center Top Template
	 * 6.0 - Timeline Template
	 * 7.0 - News Feed Template
	 *
	 */

	/**
	 * 1.0 - Pagination
	 */

	.pbsm_pagination_box.wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers:hover,
	.pbsm_pagination_box.wl_pagination_box .paging-navigation ul.page-numbers li > span.current {
		<?php echo ( esc_html($readmorebackcolor) != '' ) ? 'background-color: ' . esc_attr($readmorebackcolor) . ';' : ''; ?>
		<?php echo ( esc_html($readmorecolor) != '' ) ? 'color: ' . esc_attr($readmorecolor) . ';' : ''; ?>
		<?php echo ( esc_html($content_fontsize) != '' ) ? 'font-size:' . esc_attr($content_fontsize) . 'px;' : ''; ?>
	}

	.pbsm_pagination_box.wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers {
		<?php echo ( esc_html($readmorecolor != '' )) ? 'background-color: ' . esc_attr($readmorecolor) . ';' : ''; ?>
		<?php echo ( esc_html($readmorebackcolor != '' )) ? 'color: ' . esc_attr($readmorebackcolor) . ';' : ''; ?>
		<?php echo ( esc_html($content_fontsize != '' )) ? 'font-size:' . esc_attr($content_fontsize) . 'px;' : ''; ?>
	}
	.pbsm_pagination_box.wl_pagination_box .paging-navigation ul.page-numbers li a.page-numbers.dots {
		<?php echo ( esc_html($content_fontsize != '' )) ? 'font-size:' . esc_attr($content_fontsize) . 'px !important;' : ''; ?>
	}
	/**
	 * 2.0 - Social Media Icon
	 */    

	.pbsmp_blog_template .social-component a {
		<?php
		if ( $social_icon_style == 0 ) {
			echo 'border-radius: 100%;';
		}
		?>
	}

	/**
	 * 3.0 - Default Blog Template
	 */    

	.pbsmp_blog_template .pbsm-blog-header h2,.blog_template.default_slider .blog_manager_wp_header h2 {        
		<?php
		if ( $titlebackcolor != '' ) {
			echo 'background: ' . esc_attr($titlebackcolor);
		}
		?>
	}
	.blog_template .pbsm-more-tag-inline {
		<?php echo ( esc_html($readmorecolor != '' )) ? 'color: ' . esc_attr($readmorecolor) . ' !important;' : ''; ?>
		<?php echo ( esc_html($content_fontsize != '' )) ? 'font-size:' . esc_attr($content_fontsize) . 'px;' : ''; ?>
	}

	<?php if ( $titlecolor != '' || $template_titlefontsize != '' ||  $titlehovercolor != '' || $template_titleLineHeight  ) { ?>
		.pbsmp_blog_template .blog_manager_wp_header h2,
		.pbsmp_blog_template.timeline .desc h3 a,
		.pbsmp_blog_template .blog_manager_wp_header h2 a,
		.pbsmp_blog_template .pbsm-blog-header h2,
		.pbsmp_blog_template .pbsm-blog-header h2 a {
			<?php echo ( esc_html($titlecolor != '' )) ? 'color: ' . esc_attr($titlecolor) . ' !important;' : ''; ?>
			<?php echo ( esc_html($template_titlefontsize != '' )) ? 'font-size: ' . esc_attr($template_titlefontsize) . 'px;' : ''; ?>
			<?php echo ( esc_html($template_titleLineHeight != '' )) ? 'line-height: ' . esc_attr($template_titleLineHeight) . 'px;' : ''; ?>
			<?php echo ( esc_html($template_titleLetterSpacing != '' )) ? 'letter-spacing: ' . esc_attr($template_titleLetterSpacing) . 'px;' : ''; ?>
		}
		.pbsmp_blog_template .blog_manager_wp_header h2:hover,
		.pbsmp_blog_template .blog_manager_wp_header h2 a:hover,
		.pbsmp_blog_template .pbsm-blog-header h2:hover,
		.pbsmp_blog_template .pbsm-blog-header h2 a:hover {
			<?php echo ( esc_html($titlehovercolor != '' )) ? 'color: ' . esc_attr($titlehovercolor) . ' !important;' : ''; ?>
		}
	<?php } ?>
	.pbsmp_blog_template .pbsm-metacats,
	.pbsm-tags,
	span.pbsm-category-link,
	.pbsmp_blog_template .author,
	.pbsmp_blog_template .date,
	.pbsmp_blog_template .pbsm-categories,
	.pbsmp_blog_template.center_top .pbsm-categories a,
	.pbsmp_blog_template .pbsm-categories a,
	.pbsm-meta-data-box .pbsm-metacats,
	.pbsm-meta-data-box .pbsm-metacomments,
	.pbsm-meta-data-box .pbsm-metacomments span,
	.pbsmp_blog_template .date i, .pbsmp_blog_template .author i, .pbsmp_blog_template .comment i,
	.pbsm-tags a,
	span.pbsm-category-link a,
	.pbsm-metadatabox p,
	span .pbsm-link-label,
	.pbsmp_blog_template .blog_footer span,
	.pbsm-metacomments i,
	.date_wrap i,
	.pbsmp_blog_template a,
	.pbsmp_blog_template .post_content,
	.pbsm-categories i,
	.pbsm-metadatabox,.pbsmp_blog_template.center_top .pbsm-post-content p,
	.pbsmp_blog_template.news_feed .pbsm-blog-header .pbsm-metadatabox a,
	.pbsmp_blog_template.news_feed .post-content-div .post_cat_tag > span i,
	.pbsmp_blog_template .pbsm-meta-data-box .pbsm-metadate, .pbsmp_blog_template .pbsm-meta-data-box .pbsm-metauser, .pbsmp_blog_template .pbsm-meta-data-box .pbsm-metacats,
	.pbsm-meta-data-box .pbsm-metacats a,
	.pbsm-meta-data-box .pbsm-metacomments a,
	.pbsmp_blog_template.box-template .pbsm-tags,
	.pbsmp_blog_template .post-date {
		<?php echo ( esc_html($content_fontsize != '' )) ? 'font-size:' . esc_attr($content_fontsize) . 'px;' : ''; ?>
	}
	
	.pbsmp_blog_template .post_content p,.pbsmp_blog_template.center_top .pbsm-post-content p,.pbsmp_blog_template.default_layout .pbsm-post-content p,.pbsmp_blog_template.news_feed .pbsm-post-content p,.pbsmp_blog_template.timeline .pbsm-post-content p{
		<?php echo ( esc_html($contentcolor != '' )) ? 'color:' . esc_attr($contentcolor) . ';' : ''; ?>		
		<?php echo ( esc_html($content_LineHeight != '' )) ? 'line-height:' . esc_attr($content_LineHeight) . 'px;' : ''; ?>
		<?php echo ( esc_html($content_LetterSpacing != '' )) ? 'letter-spacing:' . esc_attr($content_LetterSpacing) . 'px;' : '';
		 ?>
		 <?php echo ( esc_html($content_fontsize != '' )) ? 'font-size:' . esc_attr($content_fontsize) . 'px;' : ''; ?>
	}
	.pbsmp_blog_template .date,
	.pbsmp_blog_template .pbsm-post-content,
	.pbsmp_blog_template .post_content,
	.pbsmp_blog_template .comment,
	.pbsmp_blog_template .author .pbsm-icon-author,
	.pbsmp_blog_template .author,
	.pbsmp_blog_template .post-by,
	.pbsmp_blog_template .pbsm-categories i,
	.pbsmp_blog_template .pbsm-tags i,
	.pbsmp_blog_template .pbsm-metacomments,
	.pbsmp_blog_template .tags i {
		<?php echo ( esc_html($contentcolor != '' )) ? 'color:' . esc_attr($contentcolor) . ';' : ''; ?>
	}
	.pbsmp_blog_template .pbsm-meta-data-box {
		<?php echo ( esc_html($contentcolor != '' )) ? 'color:' . esc_attr($contentcolor) . ';' : ''; ?>
	}

	.pbsmp_blog_template .pbsm-meta-data-box i {
		<?php echo ( esc_html($titlecolor != '' )) ? 'color: ' . esc_attr($titlecolor) . ';' : ''; ?>
	}

	<?php if ( $contentcolor != '' ) { ?>
		.pbsm-metadatabox {
			<?php echo ( esc_html($contentcolor != '' )) ? 'color:' . esc_attr($contentcolor) . ';' : ''; ?>
		}
	<?php } ?>
	.pbsm-link-label {
		<?php echo ( esc_html($contentcolor != '' )) ? 'color:' . esc_attr($contentcolor) . ';' : ''; ?>
	}

	.pbsmp_blog_template a.pbsm-more-tag,.pbsmp_blog_template .slider_read_more a.slider-more-tag,.pbsmp_blog_template .grid_read_more a.grid-more-tag {
		<?php echo ( esc_html($readmorebackcolor != '' )) ? 'background-color: ' . esc_attr($readmorebackcolor) . '!important;;' : ''; ?>
		<?php echo ( esc_html($readmorecolor != '' )) ? 'color: ' . esc_attr($readmorecolor) . '!important;;' : ''; ?>
	}

	<?php if ( $readmorebackcolor != '' || $readmorecolor != '' ) { ?>
		.pbsmp_blog_template a.pbsm-more-tag:hover,.pbsmp_blog_template .slider_read_more a.slider-more-tag:hover,.pbsmp_blog_template .grid_read_more a.grid-more-tag:hover {
			<?php echo ( esc_html($readmorecolor != '' )) ? 'background-color: ' . esc_attr($readmorecolor) . '!important;;' : ''; ?>
			<?php echo ( esc_html($readmorebackcolor != '' )) ? 'color: ' . esc_attr($readmorebackcolor) . '!important;;' : ''; ?>
		}
	<?php } ?>

	.pbsmp_blog_template i {
		font-style: normal !important;
	}
	<?php if ( $color != '' ) { ?>
		.pbsm-tags,
		span.pbsm-category-link,
		.pbsmp_blog_template .date_wrap i,
		.pbsmp_blog_template .post-comment a,
		.pbsmp_blog_template .author i,
		.pbsmp_blog_template.news_feed .post-content-div .post_cat_tag > span i ,
		.pbsmp_blog_template .post-date,
		.blog_template.pbsmp_blog_template.default_slider .category-link a,
		.pbsmp_blog_template .pbsm-categories .pbsm-link-label,
		.pbsmp_blog_template .pbsm-categories i,
		.pbsmp_blog_template .tags i,
		.pbsmp_blog_template .pbsm-metacats i,
		.pbsmp_blog_template .pbsm-tags .pbsm-link-label,
		.pbsmp_blog_template .pbsm-tags i,
		.pbsm-meta-data-box .pbsm-metacats,
		.pbsm-meta-data-box .pbsm-metacats a,
		.pbsm-meta-data-box .pbsm-metacomments a,
		.pbsmp_blog_template .pbsm-categories a,
		.pbsm-post-content a,
		.pbsm-tags a,
		span.pbsm-category-link a,
		.pbsmp_blog_template a {
			color:<?php echo esc_attr($color); ?>;
			font-weight: normal !important;
		}
	<?php } ?>

	<?php if ( $linkhover != '' ) { ?>
		.pbsmp_blog_template.timeline .desc h3 a:hover,
		.pbsm-meta-data-box .pbsm-metacats a:hover,
		.pbsm-meta-data-box .pbsm-metacomments a:hover,
		.pbsmp_blog_template .pbsm-categories a:hover,
		.pbsm-post-content a:hover,
		.pbsm-tags a:hover,
		span.pbsm-category-link a:hover,
		.pbsmp_blog_template a:hover,
		.pbsm-post-content a:hover {
			color:<?php echo esc_attr($linkhover); ?> !important;
		}
	<?php } ?>

	<?php if ( $background != '' ) { ?>
		.pbsmp_blog_template.center_top {
			background: <?php echo esc_attr($background); ?>;
		}
	<?php } ?>

	<?php
	if ( $template_alternativebackground == '0' ) {
		if ( $alterbackground != '' ) {
			?>
			.pbsmp_blog_template.center_top.alternative-back {
				background: <?php echo esc_attr($alterbackground); ?>;
			}
		<?php } else { ?>
			.pbsmp_blog_template.center_top.alternative-back {
				background: transparent;
			}
			<?php
		}
	}
	?>

	/**
	 * 4.0 - Default Layout Template
	 */

	.pbsmp_blog_template.default_layout .pbsm-blog-header .pbsm-tags {
		<?php echo ( esc_html($color != '' )) ? 'color: ' . esc_attr($color) . ';' : ''; ?>
	}


	/**
	 * 5.0 - Center Top Template
	 */



	/**
	 * 6.0 - Timeline Template
	 */

	.timeline_bg_wrap:before {
		background: none repeat scroll 0 0 <?php echo esc_attr($templatecolor); ?>;
	}

	.pbsm-datetime {
		background: none repeat scroll 0 0 <?php echo esc_attr($templatecolor); ?>;
	}

	.pbsmp_blog_template.timeline .post_hentry > p > i {
		<?php echo ( esc_html($templatecolor != '' )) ? 'background: ' . esc_attr($templatecolor) . ';' : ''; ?>
	}

	.pbsmp_blog_template.timeline:nth-child(2n+1) .post_content_wrap:before,
	.pbsmp_blog_template.timeline:nth-child(2n+1) .post_content_wrap:after {
		border-left: 8px solid <?php echo esc_attr($templatecolor); ?>;
	}

	.rtl .pbsmp_blog_template.timeline:nth-child(2n+1) .post_content_wrap:before,
	.rtl .pbsmp_blog_template.timeline:nth-child(2n+1) .post_content_wrap:after {
		border-right: 8px solid <?php echo esc_attr($templatecolor); ?>;
	}

	.pbsmp_blog_template.timeline:nth-child(2n) .post_content_wrap:before,
	.pbsmp_blog_template.timeline:nth-child(2n) .post_content_wrap:after {
		border-right: 8px solid <?php echo esc_attr($templatecolor); ?>;
	}

	.rtl .pbsmp_blog_template.timeline:nth-child(2n) .post_content_wrap:before,
	.rtl .pbsmp_blog_template.timeline:nth-child(2n) .post_content_wrap:after {
		border-left: 8px solid <?php echo esc_attr($templatecolor); ?>;
	}

	.post_content_wrap {
		border:1px solid <?php echo esc_attr($templatecolor); ?>;
	}

	.pbsmp_blog_template .post_content_wrap .blog_footer {
		border-top: 1px solid <?php echo esc_attr($templatecolor); ?> ;
	}

	.pbsmp_blog_template .post-icon {
		<?php echo ( esc_html($titlebackcolor != '' )) ? 'background:' . esc_attr($titlebackcolor) . ';' : ''; ?>
	}

	.pbsmp_blog_template.timeline .desc h3 {
		<?php echo ( esc_html($titlebackcolor != '' )) ? 'background:' . esc_attr($titlebackcolor) . ' !important;' : ''; ?>
	}

	.pbsmp_blog_template.timeline .desc h3 a{
		<?php echo ( esc_html($titlecolor != '' )) ? 'color: ' . esc_attr($titlecolor) . ' !important;' : ''; ?>
		<?php echo ( esc_html($template_titlefontsize != '' )) ? 'font-size: ' . esc_attr($template_titlefontsize) . 'px;' : ''; ?>
	}

	/**
	 * 7.0 - News Feed Template
	 */

	<?php if ( $titlecolor != '' || $template_titlefontsize != '' ) { ?>
		.pbsmp_blog_template.news_feed .pbsm-blog-header h2.title a{
			<?php echo ( esc_html($titlecolor != '' )) ? 'color: ' . esc_attr($titlecolor) . ';' : ''; ?>
			<?php echo ( esc_html($template_titlefontsize != '' )) ? 'font-size: ' . esc_attr($template_titlefontsize) . 'px;' : ''; ?>
		}
	<?php } ?>

	.pbsmp_blog_template.news_feed .pbsm-blog-header h2.title{
		<?php
		if ( $titlebackcolor != '' ) {
			echo 'background: ' . esc_attr($titlebackcolor);
		}
		?>
	}
	.pbsmp_blog_template.news_feed a.pbsm-more-tag{
		float: right !important;
	}
	.blog_template.grid-layout ul li:hover,
	.blog_template.grid-layout ul li:hover .blog_footer,
	.blog_template.grid-layout ul li:hover .blog_div,
	.blog_template.grid-layout ul li:hover .blog_manager_wp_header h2 {
		background: <?php echo esc_attr($grid_hoverback_color); ?>;
	}	
</style>