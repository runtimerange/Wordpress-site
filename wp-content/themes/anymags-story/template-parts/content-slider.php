<!-- Begin Featured
    ================================================== -->
    <section class="featured-posts">
        <div class="container">
            <div class="section-title">
                <h2><span>Featured</span></h2>
            </div>
    <div class="card-columns listfeaturedtag">
        <?php 
                  $anymags_slider_category = get_theme_mod('anymags_featured_category'); 
                  $anymags_slider_posts  =   get_theme_mod('anymags_number_of_post',4); 
                  $args = array(
                  'category_name'=>$anymags_slider_category,
                  'posts_per_page'=> $anymags_slider_posts,
                  );
                  $query = new WP_Query( $args ); ?>
                  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- begin post -->
        <?php
        if($query->have_posts()):
                          while($query->have_posts()):$query->the_post();  
                            $categories = get_the_category();
                            foreach ( $categories as $category ) { 
                                $anymags_news_slider_category=$category->cat_name; 
                            }
                  ?>
        <div class="card">
            <div class="row">
                <div class="col-md-5 wrapthumbnail">
                    
                        <div class="thumbnail" style="">
                            <?php the_post_thumbnail('slider-post-thumbnail'); ?>
                        </div>

                </div>
        <div class="col-md-7">
            <div class="card-block">
                        <h2 class="card-title-new"><a href="<?php  the_permalink();?>"><?php the_title();?></a></h2>
                        <h4 class="card-text-new"><?php the_excerpt(); ?></h4>
                <div class="metafooter">
                    <div class="wrapfooter">
                        <div>
                            <span class="meta-footer-thumb">
                            <a><?php echo get_avatar( get_the_author_meta('email'), '50' );?></a>
                            </span>
                        </div>
                        <div class="space">
                            <span class="author-meta">
                            <span class="post-name">
                                <a><?php anymags_posted_by();?></a>
                            </span>
                        <span class="post-date"><?php anymags_posted_on(); ?></span>
                        </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
        <?php  
                endwhile;
                else:
                    echo "<p>No Content found</p>";

                endif;
              ?>
        
        <!-- end post -->

    </div>
 </div>
    </section>
    <!-- End Featured
    ================================================== --> 
    

    

