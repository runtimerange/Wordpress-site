<?php
    $readmore=get_theme_mod('anymags_read_more_label','Read More');
    $showauthor=get_theme_mod('anymags_archive_co_post_author',true);
    $showdate=get_theme_mod('anymags_archive_co_post_date',true);
    $showimage=get_theme_mod('anymags_archive_co_featured_image',true);
?>

        <!-- begin post -->
    <div class="col-lg-4">
        <div class="card">
            <a href="">
                <?php anymags_post_thumbnail();?>
            </a>
            <div class="card-block">
                <h2 class="card-title"><a href="<?php esc_url(the_permalink());?>"><?php the_title();?></a></h2>
                <h4 class="card-text"><?php the_excerpt(); ?></h4>
                <div class="metafooter">
                    <div class="wrapfooter">
                        <div>
                           <span class="meta-footer-thumb">
                                <a><?php echo get_avatar( get_the_author_meta('email'), '35' );?></a>
                            </span> 
                        </div>
                        <div class="story-part">
                            <span class="post-date"><?php anymags_posted_on();?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- end post -->