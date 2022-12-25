<?php 
// Main Template
get_header(); ?> 
    <main class="site-main"><?php

        // Mission
        $page_name = 'mission';
        $args = array(
            'post_type' => 'page',
            'name' => $page_name,
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        $my_query->the_post();
        ?> 
        <article id="mission" class="fp">
            <div class="fp-mission">
                <div class="fp-mission__header fadeInTrigger"> 
                    <div class="fp-mission-ttl-en js_typing"><?php echo $page_name; ?></div>
                    <h2 class="fp-mission-ttl-jp">
                        <span class="fp-mission-ttl-jp__item"><?php echo get_post_meta($post->ID, 'mission_copy1', true); ?></span><?php
                        if (post_custom('mission_copy2')) {
                        ?> 
                        <span class="fp-mission-ttl-jp__item"><?php echo get_post_meta($post->ID, 'mission_copy2', true); ?></span><?php
                        if (post_custom('mission_copy3')) {
                        ?> 
                        <span class="fp-mission-ttl-jp__item"><?php echo get_post_meta($post->ID, 'mission_copy3', true); ?></span><?php
                        }
                        }
                        ?> 
                    </h2>
                </div><?php
                if ( get_post_meta($post->ID, 'mission_image1', true) && get_post_meta($post->ID, 'mission_image2', true) && get_post_meta($post->ID, 'mission_image3', true) ) {
                ?> 
                <div class="fp-mission__swiper fadeRightTrigger">
                    <div class="swiper-wrapper"><?php
                        for ($i = 1; $i <= 5; $i++) {
                        if ( get_post_meta($post->ID, 'mission_image'.$i, true) ) {
                        ?> 
                        <div class="swiper-slide">
                            <div class="fp-mission__img-wrapper"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'mission_image'.$i, true) );
                                $attachment_size = 'scaled';
                                if (wp_is_mobile()) {
                                    if (is_mobile()) {
                                        $attachment_size = '1024x1024';
                                    } else {
                                        $attachment_size = '1536x1536';
                                    }
                                } else {
                                    $attachment_size = '2048x2048';
                                }
                                $image_attributes = wp_get_attachment_image_src($attachment_id, $attachment_size);
                                if ($image_attributes) {
                                ?> 
                                <img class="fp-mission__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div>
                        </div><?php
                        }
                        }
                        ?> 
                    </div>
                </div><?php
                }
                ?> 
                <div class="fp-mission__body fadeUpTrigger">
                    <div class="fp-mission__txt-wrapper">
                        <div class="fp-mission__txt"><?php echo str_replace(array("\r\n", "\r", "\n", "\t"), '', get_the_content()); ?> </div>
                    </div>
                </div>
            </div>
        </article><?php
        }
        wp_reset_postdata();

        // About - 私のこと
        $page_name = 'about';
        $args = array(
            'post_type' => 'page',
            'name' => $page_name,
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        $my_query->the_post();
        ?> 
        <article id="about" class="fp">
            <div class="fp-about">
                <div class="fp-about-media fadeLeftTrigger">
                    <div class="fp-about-media__img-wrapper"><?php
                        $attachment_id = attachment_url_to_postid(get_post_meta($post->ID, 'profile_image', true));
                        if ($attachment_id) {
                        $attachment_size = 'scaled';
                        if (wp_is_mobile()) {
                            if ( is_mobile() ) {
                                $attachment_size = '1024x1024';
                            } else {
                                $attachment_size = '1536x1536';
                            }
                        } else {
                            $attachment_size = '2048x2048';
                        }
                        $image_attributes = wp_get_attachment_image_src($attachment_id, $attachment_size);
                        if ($image_attributes) {
                        ?> 
                        <img class="fp-about-media__img" src="<?php echo $image_attributes[0]; ?>"><?php
                        }
                        }
                        ?> 
                    </div>
                    <div class="fp-about-media__body">
                        <div class="fp-about-media__header">
                            <div class="fp-about-media__ttl fadeInTrigger">
                                <span class="fp-about-media__ttl--en js_typing"><?php echo $page_name; ?></span>
                                <h2 class="fp-about-media__ttl--jp"><?php echo get_the_title(); ?></h2>
                            </div>
                        </div>
                        <div class="fp-about-media__txt-wrapper">
                            <div class="fp-about-media__txt"><?php
                            $max_text_size = 150;
                            if (mb_strlen(get_the_content(), 'UTF-8') > $max_text_size) {
                                $text = mb_substr(get_the_content(), 0, $max_text_size, 'UTF-8');
                                $text = str_replace(array("\r\n", "\r", "\n", "\t"), '', $text);
                                echo $text.'…';
                            } else {
                                echo str_replace(array("\r\n", "\r", "\n", "\t"), '', get_the_content());
                            }
                            ?></div>
                        </div>
                        <div class="fp-about-media__btn-wrapper">
                            <div class="detail-btn fadeInTrigger"><a href="<?php echo esc_url(home_url('/about')); ?>" class="detail-btn__link"><span class="detail-btn__txt">View More</span><span class="detail-btn__icon"></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </article><?php
        }
        wp_reset_postdata();

        // Service - サービス
        $post_type_name = 'service';
        $max_display_num = '5';
        $post_count = wp_count_posts($post_type_name)->publish;
        $args = array(
            'post_type' => $post_type_name,
            'posts_per_page' => $max_display_num,
            'post_status' => 'publish',
        );
        $my_query = new WP_Query($args);
        if ( $my_query->have_posts() ) {
        ?> 
        <article id="service" class="fp">
            <div class="fp-service fadeRightTrigger">
                <div class="fp-service__header">
                    <div class="fp-service__ttl fadeInTrigger">
                        <span class="fp-service__ttl--en js_typing"><?php echo $post_type_name; ?></span>
                        <h2 class="fp-service__ttl--jp">サービス</h2>
                    </div>
                </div>
                <div class="fp-service__body">
                    <div class="fp-service__swiper">
                        <div class="fp-service-cols swiper-wrapper"><?php
                            while ($my_query->have_posts()) {
                            $my_query->the_post();
                            $count = $my_query->current_post + 1;
                            ?> 
                            <div class="fp-service-col swiper-slide">
                                <a href="<?php the_permalink(); ?>" class="fp-service-col__link">
                                    <div class="fp-service-col__img-wrapper"><?php
                                        if ( has_post_thumbnail() ) { 
                                        $attachment_id = get_post_thumbnail_id($post->ID);
                                        $attachment_size = 'scaled';
                                        if ( wp_is_mobile() ) {
                                            if ( is_mobile() ) {
                                                $attachment_size = '1024x1024';
                                            } else {
                                                $attachment_size = '1536x1536';
                                            }
                                        } else {
                                            $attachment_size = '2048x2048';
                                        }
                                        $image_attributes = wp_get_attachment_image_src($attachment_id, $attachment_size);
                                        if ( $image_attributes ) {
                                        ?> 
                                        <img class="fp-service-col__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                        }
                                        } else {
                                        ?> 
                                        <div class="fp-service-col__img--noimage">No Images</div><?php
                                        }
                                        ?> 
                                        <div class="fp-service-col__num"><span><?php echo sprintf('%02d', $count); ?></span></div>
                                    </div>
                                    <div class="fp-service-col__header">
                                        <h3 class="fp-service-col__ttl"><?php echo get_the_title(); ?></h3>
                                    </div>
                                    <div class="fp-service-col__body">
                                        <div class="fp-service-col__txt-wrapper">
                                            <div class="fp-service-col__txt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div><?php
                            }
                            ?> 
                        </div> 
                        <div class="swiper-arrow-wrapper fadeInTrigger">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div><?php
                if ($post_count > $max_display_num) {
                ?> 
                <div class="fp-footer">
                    <div class="fp-footer__btn-wrapper">
                        <div class="list-btn fadeInTrigger"><a href="<?php echo esc_url( home_url('/service') ); ?>" class="list-btn__link"><span class="list-btn__txt">View All</span><span class="list-btn__icon"></span></a></div>
                    </div>
                </div><?php
                }
                ?> 
            </div>
        </article><?php
        }
        wp_reset_postdata();
        
        // Work - 実績
        $post_type_name = 'work';
        $max_display_num = '4';
        $post_count = wp_count_posts($post_type_name)->publish;
        $args = array(
            'post_type' => $post_type_name,
            'posts_per_page' => $max_display_num,
            'post_status' => 'publish',
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        ?> 
        <article id="work" class="fp">
            <div class="fp__header">
                <div class="fp__ttl fadeInTrigger">
                    <span class="fp__ttl--en js_typing"><?php echo $post_type_name; ?></span>
                    <h2 class="fp__ttl--jp">今までの実績</h2>
                </div>
            </div>
            <div class="fp__body">
                <div class="fp-work">
                    <div class="fp-work-cols"><?php
                        while ( $my_query->have_posts() ) {
                        $my_query->the_post();
                        $count = $my_query->current_post+1;
                        ?> 
                        <div class="fp-work-col fadeUpTrigger">
                            <a href="<?php the_permalink(); ?>" class="fp-work-col__link">
                                <div class="fp-work-col__img-wrapper"><?php
                                    if (has_post_thumbnail()) { 
                                    $attachment_id = get_post_thumbnail_id($post->ID);
                                    $attachment_size = 'scaled';
                                    if (wp_is_mobile()) {
                                        if (is_mobile()) {
                                            $attachment_size = '1024x1024';
                                        } else {
                                            $attachment_size = '1536x1536';
                                        }
                                    } else {
                                        $attachment_size = '2048x2048';
                                    }
                                    $image_attributes = wp_get_attachment_image_src($attachment_id, $attachment_size);
                                    if ($image_attributes) {
                                    ?> 
                                    <img class="fp-work-col__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                    }
                                    } else {
                                    ?> 
                                    <div class="fp-work-col__img--noimage">No Images</div><?php
                                    }

                                    //Category
                                    $terms = get_the_terms($post->ID, 'work-category');
                                    if ($terms) {
                                    foreach ($terms as $term) {
                                    ?> 
                                    <div class="fp-work-col__cat">#<?php echo $term->name; ?></div>
                                    <?php
                                    }
                                    } else {
                                    ?> 
                                    <div class="fp-work-col__cat">No Category</div>
                                    <?php
                                    }
                                    ?> 
                                    <div class="fp-work-col__ttl-wrapper">
                                        <h3 class="fp-work-col__ttl"><?php echo get_the_title(); ?></h3>
                                    </div>
                                </div>
                            </a>
                        </div><?php
                        } ?> 
                    </div>
                </div>
            </div><?php
            if ($post_count > $max_display_num) {
            ?> 
            <div class="fp-footer">
                <div class="fp-footer__btn-wrapper">
                    <div class="list-btn fadeInTrigger"><a href="<?php echo esc_url(home_url('/work')); ?>" class="list-btn__link"><span class="list-btn__txt">View All</span><span class="list-btn__icon"></span></a></div>
                </div>
            </div><?php
            }
            ?> 
        </article><?php
        }
        wp_reset_postdata();

        // Blog - ブログ
        $post_type_name = 'blog';
        $max_display_num = '6';
        $post_count = wp_count_posts($post_type_name)->publish;
        $args = array(
            'post_type' => $post_type_name,
            'posts_per_page' => $max_display_num,
            'post_status' => 'publish',
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        ?> 
        <article id="blog" class="fp">
            <div class="fp__header">
                <div class="fp__ttl fadeInTrigger">
                    <span class="fp__ttl--en js_typing">Blog</span>
                    <h2 class="fp__ttl--jp">ブログ</h2>
                </div>
            </div>
            <div class="fp__body">
                <div class="fp-blog fadeRightTrigger">
                    <div class="fp-blog-cols"><?php
                        while ($my_query->have_posts()) {
                        $my_query->the_post();
                        ?> 
                        <div class="fp-blog-col">
                            <a href="<?php the_permalink(); ?>" class="fp-blog-col__link">
                                <div class="fp-blog-col__img-wrapper"><?php
                                    if (has_post_thumbnail()) { 
                                    $attachment_id = get_post_thumbnail_id($post->ID);
                                    $attachment_size = 'scaled';
                                    if (wp_is_mobile()) {
                                        if (is_mobile()) {
                                            $attachment_size = '1024x1024';
                                        } else {
                                            $attachment_size = '1536x1536';
                                        }
                                    } else {
                                        $attachment_size = '2048x2048';
                                    }
                                    $image_attributes = wp_get_attachment_image_src($attachment_id, $attachment_size);
                                    if ($image_attributes) {
                                    ?> 
                                    <img class="fp-blog-col__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                    }
                                    } else {
                                    ?> 
                                    <div class="fp-blog-col__img--noimage">No Images</div><?php
                                    }

                                    //Category
                                    $terms = get_the_terms($post->ID, 'blog-category');
                                    if ($terms) {
                                    ?> 
                                    <div class="fp-blog-col__cat-wrapper"><?php
                                        foreach ($terms as $term){
                                        ?> 
                                        <div class="fp-blog-col__cat">#<?php echo $term->name; ?></div><?php
                                        }
                                    ?> 
                                    </div><?php
                                    } else {
                                    ?>
                                    <div class="fp-blog-col__cat-wrapper">
                                        <div class="fp-blog-col__cat">No Category</div>
                                    </div><?php
                                    }
                                    ?> 
                                </div>
                                <div class="fp-blog-col__header">
                                    <h3 class="fp-blog-col__ttl"><?php
                                    $max_text_size = '40';
                                    if ( mb_strlen($post->post_title, 'UTF-8') > $max_text_size ) {
                                        $title= mb_substr($post->post_title, 0, $max_text_size, 'UTF-8');
                                        echo $title.'…';
                                    } else {
                                        echo $post->post_title;
                                    }
                                    ?></h3>
                                </div>
                            </a>
                        </div><?php
                        } ?> 
                    </div>
                </div>
            </div><?php
            if ($post_count > $max_display_num) {
            ?> 
            <div class="fp-footer">
                <div class="fp-footer__btn-wrapper">
                    <div class="list-btn fadeInTrigger"><a href="<?php echo esc_url( home_url('/blog') ); ?>" class="list-btn__link"><span class="list-btn__txt">View All</span><span class="list-btn__icon"></span></a></div>
                </div>
            </div><?php
            }
            ?> 
        </article><?php
        }
        wp_reset_postdata();

        // お知らせ
        $post_type_name = 'news';
        $max_display_num = '3';
        $post_count = wp_count_posts($post_type_name)->publish;
        $args = array(
            'post_type' => $post_type_name,
            'posts_per_page' => $max_display_num,
            'post_status' => 'publish',
        );
        $my_query = new WP_Query($args);
        if ( $my_query->have_posts() ) {
        ?> 
        <article id="blog" class="fp">
            <div class="fp__header">
                <div class="fp__ttl fadeInTrigger">
                    <span class="fp__ttl--en js_typing">News</span>
                    <h2 class="fp__ttl--jp">お知らせ</h2>
                </div>
            </div>
            <div class="fp__body">
                <div class="fp-news fadeUpTrigger">
                    <ul class="fp-news__list"><?php
                        while ($my_query->have_posts()) {
                        $my_query->the_post();
                        ?> 
                        <li class="fp-news__item">
                            <a href="<?php the_permalink(); ?>" class="fp-news__link">
                                <time class="fp-news__date"><?php the_time( get_option('date_format')); ?></time>
                                <h3 class="fp-news__ttl"><?php echo get_the_title(); ?></h3>
                            </a>
                        </li><?php
                        } ?> 
                    </ul>
                </div>
            </div><?php
            if ($post_count > $max_display_num) {
            ?> 
            <div class="fp-footer">
                <div class="fp-footer__btn-wrapper">
                    <div class="list-btn fadeInTrigger"><a href="<?php echo esc_url( home_url('/news') ); ?>" class="list-btn__link"><span class="list-btn__txt">View All</span><span class="list-btn__icon"></span></a></div>
                </div>
            </div><?php
            }
            ?> 
        </article><?php
        }
        wp_reset_postdata();
        ?> 
    </main>
<?php get_footer(); ?>