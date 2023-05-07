<section class="wp-hero-slider">
  <div class="container">
      <div class="row">
          <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php 
              $anymags_slide_category      =   get_theme_mod('anymags_featured_category'); 
              
              $anymags_slide_posts      =   get_theme_mod('anymags_number_of_post',10); 
              $args = array(
              'category_name'=>$anymags_slide_category,
              'posts_per_page'=> $anymags_slide_posts,
              );

              $query = new WP_Query( $args );
                $c = 1;
                $class = '';
              if($query->have_posts()):
                      while($query->have_posts()):$query->the_post();
                         
                      if ( $c == "1" )
                      $class = ' active';
                      else
                      $class=''; 
                          ?>
                          
                          <div class="carousel-item <?php echo esc_html($class); ?>">
                            <?php if (has_post_thumbnail()) { ?>
                               <div class="overlay"></div>
                               <?php the_post_thumbnail(); ?>
                            <?php }else{ ?>
                               <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/defaultthemecolor.png') ?>" class="img-responsive" alt="...">
                          <?php } ?>
                            <div class="carousel-caption d-md-block">
                              <h5> <a href="<?php esc_url(the_permalink());?>"><?php esc_html(the_title());?> </a></h5>
                              <div class="content">

                                <span class="name"><?php anymags_posted_by();?></span>
                                <span class="post-date"><?php anymags_posted_on();?></span>
                              </div>
                            </div>
                          
                          </div>
                          
                          <?php
                          $c++;
                      endwhile;
                    else:
                        echo "<p>No Content found</p>";

                    endif;
                  ?>
              
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>
          </div>
      </div>
  </div>
</section>