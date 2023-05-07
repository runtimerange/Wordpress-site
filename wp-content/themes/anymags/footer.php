<?php
$show_copyright=get_theme_mod('anymags_footer_copyright_display',true);
$copyright=get_theme_mod('anymags_copyright','Proudly powered by WordPress');
$companyname=get_theme_mod('anymags_company_name','anymags');
?>
<footer class="footer-section">
    <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) ||is_active_sidebar( 'footer-3' )  ) { ?>
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <?php dynamic_sidebar('footer-1');?>
                    </div>

                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <?php dynamic_sidebar('footer-2');?>
                    </div>
                     <div class="col-lg-3 col-md-6 col-sm-12">
                        <?php dynamic_sidebar('footer-3');?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($show_copyright){ ?>
        <div class="copyright-footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-lg-center align-self-center">
                        <p><?php echo wp_kses_post($copyright); ?></p>
                    </div>
                </div>
            </div>
        </div>
      <?php }?>
    </footer>
   
</div><!-- #page -->

<?php wp_footer(); ?>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <i class="fa fa-angle-up"></i>
    </button>
</body>
</html>