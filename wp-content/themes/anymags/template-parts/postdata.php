<?php
$showauthor=get_theme_mod('anymags_single_co_post_author',true);
$showdate=get_theme_mod('anymags_single_co_post_date',true);
$showimage=get_theme_mod('anymags_single_co_featured_image_post',true);
$showtag=get_theme_mod('anymags_single_co_post_tags',true);
?>
<div class="blog-area">
   	<div class="blog-content content">
        <h3 class="title mb-20"><?php esc_html(the_title());?></h3>
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
        <?php if($showimage){?>
        <div class="blog-img mb-25">
            <?php anymags_post_thumbnail();?>
        </div>
        <?php } ?>
        <p class="descriptison">
            <?php the_content();?>
        </p>
        <blockquote>
            <?php the_excerpt();?>
        </blockquote>

        <div class="tag-share-list pt-4">
            <?php if($showtag){?>
            <div class="tags-links">
                <?php the_tags();?>
            </div>
            <?php } ?>
        </div>
        <?php 
        $prevPost = get_previous_post();
        $nextPost = get_next_post();
        $previous_post_url = esc_url(get_permalink( get_adjacent_post(false,'',true)));
        $next_post_url = esc_url(get_permalink( get_adjacent_post(false,'',false)));
        ?>
        <div class="navigation-blog">
            <?php if (get_previous_post_link()) {  ?>
            <div class="navi-item prev-blog">
                <a href="<?php echo esc_url($previous_post_url); ?>" class="navi-arrow">
                    <i class="fa fa-chevron-left"></i>
                </a>
                <div class="navi-text">
                    <div class="name-navi">
                        <?php echo esc_html_e('Previous Post','anymags'); ?>
                    </div>
                    <div class="title-navi">
                        <?php esc_url(previous_post_link( '%link', '%title', true )) ?>
                    </div>
                    <div class="info-navi">
                        <?php anymags_posted_on();?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (get_next_post_link()) {  ?>
            <div class="navi-item next-blog">
                <div class="navi-text">
                    <div class="name-navi">
                        <?php esc_html_e('Next Post','anymags');?>
                    </div>
                    <div class="title-navi">
                        <?php next_post_link( '%link', '%title', true ); ?>
                    </div>
                    <div class="info-navi">
                        <?php anymags_posted_on();?>
                    </div>
                </div>
                <a href="<?php echo esc_url($next_post_url); ?>" class="navi-arrow">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>