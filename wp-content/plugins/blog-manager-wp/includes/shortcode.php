<?php 
add_shortcode('wp_pbsm', 'pbsm_views');

/**
 * Return Blog posts
 */
function pbsm_views() {
    ob_start();
    add_filter('excerpt_more', 'pbsm_remove_continue_reading', 50);
    $settings = get_option('wp_blog_pbsm_settings');
    if (!isset($settings['template_name']) || empty($settings['template_name'])) {
        $link_message = '';
        if (is_user_logged_in()) {
            $link_message = __('plz go to ', 'blog-manager-wp') . '<a href="' . admin_url('admin.php?page=pbsm_settings') . '" target="_blank">' . __('Blog Manager Panel', 'blog-manager-wp') . '</a> , ' . __('select Blog Designs & save settings.', 'blog-manager-wp');
        }
        return __("You haven't created any PBSM shortcode.", 'blog-manager-wp') . ' ' . $link_message;
    }
    $theme = $settings['template_name'];
    $author = $cat = $tag = array();
    $category = '';
    if (isset($settings['template_category'])) {
        $cat = $settings['template_category'];
    }

    if (!empty($cat)) {
        foreach ($cat as $catObj) :
            $category .= $catObj . ',';
        endforeach;
        $cat = rtrim($category, ',');
    } else {
        $cat = array();
    }

    if (isset($settings['template_tags'])) {
        $tag = $settings['template_tags'];
    }
    if (empty($tag)) {
        $tag = array();
    }

    $tax_query = array();
    if (!empty($cat) && !empty($tag)) {
        $cat = explode(',', $cat);

        $tax_query = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $cat,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag,
                'operator' => 'IN',
            ),
        );
    } elseif (!empty($tag)) {
        $tax_query = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag,
                'operator' => 'IN',
            ),
        );
    } elseif (!empty($cat)) {
        $cat = explode(',', $cat);
        $tax_query = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $cat,
                'operator' => 'IN',
            ),
        );
    }

    if (isset($settings['template_authors']) && $settings['template_authors'] != '') {
        $author = $settings['template_authors'];
        $author = implode(',', $author);
    }

    $posts_per_page = get_option('posts_per_page');
    $paged = pbsm_paged();

    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'tax_query' => $tax_query,
        'author' => $author,
    );

    $display_sticky = get_option('display_sticky');
    if ($display_sticky != '' && $display_sticky == 1) {
        $args['ignore_sticky_posts'] = 1;
    }

    global $wp_query;
    $temp_query = $wp_query;
    $loop = new WP_Query($args);
    $wp_query = $loop;

    $alter = 1;
    $class = '';
    $alter_class = '';
    $main_container_class = isset($settings['main_container_class']) && $settings['main_container_class'] != '' ? $settings['main_container_class'] : '';
    if ($loop->have_posts()) {
        if ($main_container_class != '') {
            echo '<div class="' . esc_attr($main_container_class) . '">';
        }
        if ($theme == 'timeline') {
            ?>
            <div class="timeline_bg_wrap">
                <div class="timeline_back clearfix">
                    <?php
                }
                if ($theme == "grid-layout") {
                    ?>
                    <div class="blog_template grid-layout">
                        <ul>
                            <?php
                        }
                        if ($theme == 'default_slider') {
                            $slider_navigation = '';
                            $template_slider_scroll = isset($settings['template_slider_scroll']) ? $settings['template_slider_scroll'] : 1;
                            $display_slider_navigation = isset($settings['display_slider_navigation']) ? $settings['display_slider_navigation'] : 1;
                            $display_slider_controls = isset($settings['display_slider_controls']) ? $settings['display_slider_controls'] : 1;
                            $slider_autoplay = isset($settings['slider_autoplay']) ? $settings['slider_autoplay'] : 1;
                            $slider_autoplay_intervals = isset($settings['slider_autoplay_intervals']) ? $settings['slider_autoplay_intervals'] : 7000;
                            $slider_speed = isset($settings['slider_speed']) ? $settings['slider_speed'] : 600;
                            $template_slider_effect = isset($settings['template_slider_effect']) ? $settings['template_slider_effect'] : 'slide';
                            if (is_rtl()) {
                                $template_slider_effect = 'fade';
                            }
                            $slider_column = 1;
                            if (isset($settings['template_slider_effect']) && $settings['template_slider_effect'] == 'slide') {
                                $slider_column = isset($settings['template_slider_columns']) ? $settings['template_slider_columns'] : 1;
                                $slider_column_ipad = isset($settings['template_slider_columns_ipad']) ? $settings['template_slider_columns_ipad'] : 1;
                                $slider_column_tablet = isset($settings['template_slider_columns_tablet']) ? $settings['template_slider_columns_tablet'] : 1;
                                $slider_column_mobile = isset($settings['template_slider_columns_mobile']) ? $settings['template_slider_columns_mobile'] : 1;
                            } else {
                                $slider_column = $slider_column_ipad = $slider_column_tablet = $slider_column_mobile = 1;
                            }
                            $slider_arrow = isset($settings['arrow_style_hidden']) ? $settings['arrow_style_hidden'] : 'arrow1';
                            if ($slider_arrow == '') {
                                $prev = "<i class='fas fa-chevron-left'></i>";
                                $next = "<i class='fas fa-chevron-right'></i>";
                            } else {
                                $prev = "<div class='" . $slider_arrow . "'></div>";
                                $next = "<div class='" . $slider_arrow . "'></div>";
                            }
                            ?>
                            <script type="text/javascript" id="flexslider_script">
                                jQuery(document).ready(function () {
                                var $maxItems = 1;
                                        if (jQuery(window).width() > 980) {
                                $maxItems = <?php echo esc_html($slider_column); ?>;
                                } else if (jQuery(window).width() <= 980 && jQuery(window).width() > 720) {
                                $maxItems = <?php echo esc_html($slider_column_ipad); ?>;
                                } else if (jQuery(window).width() <= 720 && jQuery(window).width() > 480) {
                                $maxItems = <?php echo esc_html($slider_column_tablet); ?>;
                                } else if (jQuery(window).width() <= 480) {
                                $maxItems = <?php echo esc_html($slider_column_mobile); ?>;
                                }

                                <?php $slider_autoplay_new = ($slider_autoplay == 1) ? "slideshowSpeed: $slider_autoplay_intervals," : ''; ?>
                                <?php $slider_speed_new = $slider_speed ? "animationSpeed: $slider_speed," : ''; ?>

                                jQuery('.slider_template').flexslider({
                                move: <?php echo esc_html($template_slider_scroll); ?>,
                                        animation: '<?php echo esc_html($template_slider_effect); ?>',
                                        itemWidth: 10,
                                        itemMargin: 15,
                                        minItems: 1,
                                        maxItems: $maxItems,
                                        <?php echo (esc_html($display_slider_controls == 1)) ? "directionNav: true," : "directionNav: false,"; ?>
                                        <?php echo (esc_html($display_slider_navigation == 1)) ? "controlNav: true," : "controlNav: false,"; ?>
                                        <?php echo (esc_html($slider_autoplay == 1)) ? "slideshow: true," : "slideshow: false,"; ?>
                                        <?php echo esc_html($slider_autoplay_new); ?>
                                        <?php echo esc_html($slider_speed_new); ?>
                                        prevText: "<?php echo esc_html($prev); ?>",
                                        nextText: "<?php echo esc_html($next); ?>",
                                        rtl: <?php
                                        if (is_rtl()) {
                                            echo 1;
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                });
                                }
                                );</script><?php
            ?>
                            <div class="blog_template slider_template default_slider navigation4 <?php echo esc_attr($slider_navigation); ?>">
                                <ul class="slides">
                                    <?php
                                }
                                while (have_posts()) :
                                    the_post();
                                    if ($theme == 'default_layout') {
                                        $class = ' default_layout';
                                        pbsm_default_layout_template($alter_class);
                                    } elseif ($theme == 'grid-layout') {
                                        $class = ' grid-layout';
                                        pbsm_boxy_clean_template($settings);
                                    } elseif ($theme == 'default_slider') {
                                        $class = ' default_slider';

                                        pbsm_default_slider_template($settings);
                                    } elseif ($theme == 'center_top') {
                                        if (get_option('template_alternativebackground') == 0) {
                                            if ($alter % 2 == 0) {
                                                $alter_class = ' alternative-back';
                                            } else {
                                                $alter_class = ' ';
                                            }
                                        }
                                        $class = ' center_top';
                                        pbsm_center_top_template($alter_class);
                                        $alter ++;
                                    } elseif ($theme == 'timeline') {
                                        if ($alter % 2 == 0) {
                                            $alter_class = ' even';
                                        } else {
                                            $alter_class = ' ';
                                        }
                                        $class = 'timeline';
                                        pbsm_timeline_template($alter_class);
                                        $alter ++;
                                    } elseif ($theme == 'news_feed') {
                                        if (get_option('template_alternativebackground') == 0) {
                                            if ($alter % 2 == 0) {
                                                $alter_class = ' alternative-back';
                                            } else {
                                                $alter_class = ' ';
                                            }
                                        }
                                        $class = ' news_feed';
                                        pbsm_news_feed_template($alter_class);
                                        $alter ++;
                                    }
                                endwhile;
                                if ($theme == 'timeline') {
                                    ?>
                            </div>
                    </div>
                    <?php
                }
                if ($theme == 'grid-layout') {
                    ?>
                    </ul>
                </div>
                <?php
            }
            if ($theme == 'default_slider') {
                ?>
            </ul>
            </div>
            <?php
        }
    }
    if ($theme != 'default_slider') {
        echo '<div class="wl_pagination_box pbsm_pagination_box ' . esc_attr($class) . '">';
        echo pbsm_pagination();
        echo '</div>';
    }

    if ($main_container_class != '') {
        echo '</div>';
    }
    wp_reset_query();
    $wp_query = null;
    $wp_query = $temp_query;
    $content = ob_get_clean();
    return $content;
}