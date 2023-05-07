<?php get_header();
    
    $showslider=get_theme_mod('anymags_slider_display',true);
?>
    
    <?php 
    
        if($showslider){
            include get_template_directory() . '/inc/slider.php';
        }
    ?>
    <section class="blog-sec-wp ptb-100" id="primary">
		<div class="container">
            <?php
                $sidebar_position = get_theme_mod('anymags_sidebar_position', 'right');
                if ($sidebar_position == 'left') {
                    $sidebar_position = 'has-left-sidebar';
                } elseif ($sidebar_position == 'right') {
                    $sidebar_position = 'has-right-sidebar';
                } elseif ($sidebar_position == 'no') {
                    $sidebar_position = 'no-sidebar';
                }
            ?>
			<div class="row <?php echo esc_attr($sidebar_position); ?>">
				<div class="col-lg-8">
                    <?php if(have_posts()):
                            while(have_posts()):the_post();
                                get_template_part( 'template-parts/content', get_post_type() );
                            endwhile;
                        else:
                            echo "<p>No Content found</p>";

                        endif;
                        ?>
                    <div class="paging-navigation">
                        <nav class="navigation">
                            <?php
                             echo paginate_links();
                            ?> 
                        </nav>
                    </div>
				</div>
                <?php
                if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
                <div class="col-lg-4">
                    <?php get_template_part( 'sidebar', get_post_type() );?>
				</div>
                <?php } ?>
			</div>
		</div>
	</section>
<?php get_footer();?>