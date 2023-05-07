<?php
    $readmore=get_theme_mod('anymags_read_more_label','Read More');
    $showauthor=get_theme_mod('anymags_archive_co_post_author',true);
    $showdate=get_theme_mod('anymags_archive_co_post_date',true);
    $showimage=get_theme_mod('anymags_archive_co_featured_image',true);

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-area anymags-blog mb-5">
        <?php if($showimage){?>
        <div class="blog-img">
            <?php anymags_post_thumbnail();?>
        </div>
        <?php } ?>
        <div class="blog-content content">
            <h3 class="title mb-20 mt-4">
            <a href="<?php esc_url(the_permalink());?>"><?php the_title();?></a>
            </h3>
            <?php if($showauthor!='' || $showdate!=''){?>
            <ul class="blog-user-details mb-20">
                <?php if($showauthor){?>
                <li><?php echo get_avatar( get_the_author_meta('email'), '30' );?><?php anymags_posted_by();?></li>
                <?php } ?>
                <?php if($showdate){?>
                <li><i class="fa fa-calendar-check-o"></i><?php anymags_posted_on();?></li>
                <?php } ?>

            </ul>
            <?php } ?>
            <?php the_excerpt();?>
            <?php if($readmore!=''){ ?>
            <a class="read-more" href="<?php esc_url(the_permalink());?>"><?php echo esc_html($readmore);?><i class="fa fa-chevron-right"></i></a>
            <?php } ?>
        </div>
    </div>
</div>