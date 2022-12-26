<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php bloginfo('description'); ?>">
<?php wp_head(); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap');
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="modal-btn-wrapper"><div class="modal-btn"><span></span><span></span><span></span></div></div>
<nav class="modal">
    <div class="modal__inner">
        <div class="modal__header">
            <div class="modal-ttl">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="modal-ttl__link"><?php

                    // モーダルウインドウのロゴマーク
                    if ( has_custom_logo() ) {
                    $custom_logo_id = get_theme_mod('custom_logo'); 
                    $custom_logo_url = wp_get_attachment_image_src($custom_logo_id, 'large'); 
                    $custom_logo_url = $custom_logo_url[0];
                    ?> 
                    <div class="site-header-ttl__logo-wrapper">
                        <img class="site-header-ttl__logo" src="<?php echo $custom_logo_url; ?>" alt="<?php bloginfo('title'); ?>">
                    </div><?php
                    } else {
                    ?> 
                    <div class="modal-ttl__typo"><?php bloginfo('title'); ?></div><?php  
                    }

                    ?> 
                </a>
            </div>
        </div>
        <div class="modal__body">
            <div class="modal-nav"> 
                <?php echo str_replace(array("\r\n", "\r", "\n", "\t"), '', wp_nav_menu(array('theme_location' => 'modal-menu','echo' => false, 'container' => false, 'items_wrap' => '<ul class="modal-nav__menu">%3$s</ul>','add_li_class' => 'modal-nav__item','add_a_class' => 'modal-nav__link'))); ?> 
            </div>
            <div class="modal-sns-list">
                <?php echo str_replace(array("\r\n", "\r", "\n", "\t"), '', wp_nav_menu(array('theme_location' => 'sns-menu', 'echo' => false, 'container' => false, 'items_wrap' => '<ul class="modal-sns-list__menu">%3$s</ul>', 'add_li_class' => 'modal-sns-list__item', 'add_a_class' => 'modal-sns-list__link'))); ?> 
            </div>
        </div>
    </div>
</nav>
<div class="modal-bg-wrapper"><div class="modal-bg"></div></div>

<div class="site-container">
    <header class="site-header">
        <div class="site-header__ttl-wrapper">
            <div class="site-header-ttl">
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-header-ttl__link"><?php

                    // ヘッダータイトル
                    if ( has_custom_logo() ) { 
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $custom_logo_url = wp_get_attachment_image_src($custom_logo_id, 'large'); 
                    $custom_logo_url = $custom_logo_url[0];
                    ?> 
                    <div class="site-header-ttl__logo-wrapper">
                        <img class="site-header-ttl__logo" src="<?php echo $custom_logo_url; ?>" alt="<?php bloginfo('title'); ?>">
                    </div><?php
                    } else {
                    ?> 
                    <h1 class="site-header-ttl__typo"><?php bloginfo('title'); ?></h1><?php  
                    }
                    
                    ?> 
                </a>
                <div class="site-header-ttl__desc"><?php bloginfo('description'); ?></div>
            </div>
        </div>
        <nav class="site-header__nav-wrapper">
            <div class="horizontal-nav">
                <?php echo str_replace(array("\r\n", "\r", "\n", "\t"), '', wp_nav_menu(array('theme_location' => 'horizontal-menu', 'echo' => false, 'container' => false, 'items_wrap' => '<ul class="horizontal-nav__menu">%3$s</ul>','add_li_class' => 'horizontal-nav__item','add_a_class' => 'horizontal-nav__link'))); ?> 
            </div>
        </nav>
    </header><?php

    // トップページの表示
    if ( is_front_page() ) {
    $page_name = 'hero';
    $args = array(
        'post_type' => 'page',
        'name' => $page_name,
        'post_status' => 'publish',
    );
    $my_query = new WP_Query($args);
    if ( $my_query->have_posts() ) {
    $my_query->the_post();
    ?> 
    <section class="hero">
        <div class="hero__swiper">
            <div class="swiper-wrapper"><?php
                for ($i = 1; $i <= 5; $i++) {
                if ( get_post_meta($post->ID, 'hero_image'.$i, true) ) {
                ?> 
                <div class="swiper-slide">
                    <div class="hero__img-wrapper"><?php
                        $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'hero_image'.$i, true) );
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
                        <img class="hero__img" src="<?php echo $image_attributes[0]; ?>"><?php
                        }
                        ?> 
                    </div>
                </div><?php
                }
                }
                ?> 
            </div>
        </div><?php

        // メインコピー
        if ( post_custom('hero_copy1') ) {
        ?> 
        <div class="hero__main-copy-wrapper">
            <h2 class="main-copy">
                <span class="main-copy__txt"><?php echo get_post_meta($post->ID, 'hero_copy1', true); ?></span><?php
                if ( post_custom('hero_copy2') ) {
                ?> 
                <span class="main-copy__txt"><?php echo get_post_meta($post->ID, 'hero_copy2', true); ?></span><?php
                if ( post_custom('hero_copy3') ) {
                ?> 
                <span class="main-copy__txt"><?php echo get_post_meta($post->ID, 'hero_copy3', true); ?></span><?php
                }
                }
                ?> 
            </h2>
        </div><?php
        }

        // お知らせ
        $post_type_name = 'news';
        $max_display_num = '5';
        $post_count = wp_count_posts($post_type_name)->publish;
        $args = array(
            'post_type' => $post_type_name,
            'posts_per_page' => $max_display_num,
            'post_status' => 'publish',
        );
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        ?> 
        <div class="hero-news"><?php
            if ($post_count > 1) {
            ?> 
            <div class="hero-news__swiper">
                <div class="news swiper-wrapper"><?php
                    while ($my_query->have_posts()) {
                    $my_query->the_post();
                    ?> 
                    <div class="hero-news__item swiper-slide">
                        <a href="<?php the_permalink(); ?>" class="hero-news__link">
                            <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="hero-news__date"><?php echo get_the_date(); ?></time>
                            <h3 class="hero-news__ttl"><?php the_title(); ?></h3>
                        </a>
                    </div><?php
                    }
                    ?> 
                </div>
            </div><?php
            } else {
            ?> 
            <div class="hero-news__no-swiper"><?php
                while ($my_query->have_posts()) {
                $my_query->the_post();
                ?> 
                <div class="hero-news__item">
                    <a href="<?php the_permalink(); ?>" class="hero-news__link">
                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="hero-news__date"><?php echo get_the_date(); ?></time>
                        <div class="hero-news__ttl"><?php the_title(); ?></div>
                    </a>
                </div><?php
                }
                ?> 
            </div>
            <?php
            }
            ?> 
        </div><?php
        }
        wp_reset_postdata();
        ?> 
    </section><?php
    }
    wp_reset_postdata();

    // Single Page - service
    } elseif( is_singular('service') ) {
    ?> 
    <section class="hero-service"><?php
        if ( get_post_meta($post->ID, 'service_header_image1', true) ) {
        ?> 
        <div class="hero-service__swiper">
            <div class="swiper-wrapper"><?php
                for ($i = 1; $i <= 5; $i++) {
                if ( get_post_meta($post->ID, 'service_header_image'.$i, true) ) {
                ?> 
                <div class="swiper-slide">
                    <div class="hero-service__img-wrapper"><?php
                        $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_header_image'.$i, true) );
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
                        if ($image_attributes) {
                        ?> 
                        <img class="hero-service__img" src="<?php echo $image_attributes[0]; ?>"><?php
                        }
                        ?> 
                    </div>
                </div><?php
                }
                }
                ?> 
            </div>
        </div><?php
        } else {
        ?> 
        <div class="hero-service__no-swiper">
        </div><?php
        }
        ?> 
        <div class="hero-service__main-copy-wrapper">
            <h2 class="hero-service-main-copy">
                <span class="hero-service-main-copy__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_header_title', true))); ?></span>
            </h2>
        </div>
    </section>
    <?php
    } else {
    ?> 
    <div class="page-header">
        <div class="page-header__inner"><?php
            if ( has_post_thumbnail() ) {
            ?> 
            <div class="page-header__img-wrapper"><?php
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
                $image_attributes = wp_get_attachment_image_src($attachment_id,$attachment_size);
                if ($image_attributes){
                ?> 
                <img class="page-header__img" src="<?php echo $image_attributes[0]; ?>"><?php
                }
                ?> 
            </div><?php
            }
            ?> 
            <div class="marquee-wrapper">
                <div class="marquee">
                    <div class="marquee__item"><?php
                    if (is_home() || is_category()) {
                        echo 'BLOG';
                    } elseif (is_page()) {
                        echo $post->post_name;
                    } elseif ( is_singular('service') ) {
                        echo get_post_meta($post->ID, 'service_header_title', true);
                    } elseif (is_archive() || is_single()) {
                        echo esc_html(get_post_type_object(get_post_type())->name);
                    } elseif (is_404()) {
                        echo 'NOT FOUND';
                    }
                    ?></div>
                </div>
            </div>
        </div>
    </div><?php
    }
    ?> 