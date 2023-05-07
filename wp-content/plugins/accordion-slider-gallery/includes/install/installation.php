<?php
add_action( 'admin_notices', 'asg_cns_review' );
function asg_cns_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'asg_cns_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('asg_cns_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible asg-cns-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo esc_url(ACCORDION_SLIDER_IMAGES.'icon-128x128.png'); ?>" />
		</div>
		<p style="font-size:18px;"><?php esc_html_e('Hi! We saw you have been using ',"accordion-slider"); ?><strong><?php esc_html_e('Accordion Slider Gallery',"accordion-slider"); ?></strong><?php esc_html_e(' for a few days and wanted to ask for your help to ',"accordion-slider"); ?><strong><?php esc_html_e('make the plugin better',"accordion-slider"); ?></strong><?php esc_html_e('. We just need a minute of your time to rate the plugin. Thank you!',"accordion-slider"); ?></p>
		<p style="font-size:18px;"><strong><?php _e( '~ wpdiscover', '' ); ?></strong></p>
		<p style="font-size:19px;"> 
			<a style="color: #fff;background: #ef4238;padding: 5px 7px 4px 6px;border-radius: 4px; text-decoration: none;" href="https://wordpress.org/support/plugin/accordion-slider-gallery/reviews/" class="asg-cns-dismiss-review-notice asg-cns-review-out" target="_blank" rel="noopener"><?php esc_html_e('Rate the plugin',"accordion-slider"); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px; text-decoration: none;" href="#"  class="asg-cns-dismiss-review-notice asg-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px; text-decoration: none;" href="#" class="asg-cns-dismiss-review-notice asg-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>
		<a style="    color: #fff;
    background: #000;
    padding: 5px 7px 4px 6px;
    border-radius: 4px;
    margin-left: 10px;
    text-decoration: none;" href="<?php echo ACCORDION_SLIDER_PLUGIN_UPGRADE; ?>" class="btn btn-primary" target="_blank" rel="noopener"><?php _e( 'Upgrade To Accordion Slider Gallery Pro Plugin', '' ); ?></a>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.asg-cns-dismiss-review-notice, .asg-cns-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('asg-cns-review-out') ) {
					var asg_rate_data_val = "1";
				}
				if ( $(this).hasClass('asg-rate-later') ) {
					var asg_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('asg-rated') ) {
					var asg_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'asg_cns_dismiss_review',
					asg_rate_data_cns : asg_rate_data_val
				});
				
				$('.asg-cns-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_asg_cns_dismiss_review', 'asg_cns_dismiss_review' );
function asg_cns_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['asg_rate_data_cns']=="1"){
		
	}
	if($_POST['asg_rate_data_cns']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		update_option( 'asg_cns_review', $review );
	}
	if($_POST['asg_rate_data_cns']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		update_option( 'asg_cns_review', $review );
	}
	
	die;
}
?>