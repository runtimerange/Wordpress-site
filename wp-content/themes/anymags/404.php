<?php
get_header();
?>
	<section class="page-404" id="primary">
        <div class="container">
            <div class="page-404-inner">
                <h1><?php esc_html_e( '404', 'anymags' ); ?></h1>
                <h3><i class="fa fa-exclamation-triangle"></i> <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'anymags' ); ?></h3>
                <p><?php esc_html_e( 'Sorry but the page you are looking for is not found. Please make sure you have typed the correct URL.', 'anymags' ); ?></p>
                <div class="btn-group">
                    <a href="<?php echo esc_url(home_url());?>" class="btn">
                        <?php esc_html_e( 'Back To Home', 'anymags' ); ?> 
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();