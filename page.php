<?php get_header(); ?> 
    <main class="site-main"><?php

        // 固定ぺージ - About - プロフィール写真の表示
        $attachment_id = attachment_url_to_postid(get_post_meta( $post->ID, 'profile_image', true));
        if (is_page('about') && $attachment_id){
        ?> 
        <div class="page-profile-wrapper">
            <div class="profile fadeUpTrigger">
                <div class="profile__img-wrapper"><?php
                    $attachment_size = 'scaled';
                    if ( wp_is_mobile() ){
                        if ( is_mobile() ){
                            $attachment_size = '1024x1024';
                        } else {
                            $attachment_size = '1536x1536';
                        }
                    } else {
                        $attachment_size = '2048x2048';
                    }
                    $image_attributes = wp_get_attachment_image_src($attachment_id,$attachment_size);
                    if ($image_attributes) {
                    ?> 
                    <img class="profile__img" src="<?php echo $image_attributes[0]; ?>"><?php
                    }
                    ?> 
                </div>
            </div>
        </div><?php
        }

        ?> 
        <article class="page-cont">
            <header class="page-cont__header">
                <div class="page-cont__ttl fadeInTrigger">
                    <span class="page-cont__ttl--en js_typing"><?php echo $post->post_name; ?></span>
                    <h1 class="page-cont__ttl--jp"><?php the_title(); ?></h1>
                </div>
            </header>
            <div class="page-cont__body">
                <div class="page-cont__text-wrapper fadeUpTrigger">
                    <?php echo str_replace(array("\r\n","\r","\n","\t","<br />"),'',apply_filters('the_content',get_the_content())); ?> 
                </div>
            </div><?php

            // 固定ぺージ - About - 事業概要の表示
            if ( is_page('about') && get_post_meta($post->ID, 'overview_item1_name', true) ) {
            ?> 
            <div class="overview">
                <div class="overview__header">
                    <h2 class="overview__ttl"><?php echo get_post_meta($post->ID, 'overview_title', true); ?></h2>
                </div>
                <div class="overview__body">
                    <ul class="overview__items"><?php
                        for ($i = 1; $i <= 10; $i++) {
                        if ( get_post_meta($post->ID, 'overview_item'.$i.'_name', true) ) {
                        ?> 
                        <li class="overview__item"><span class="overview__item-name"><?php echo get_post_meta($post->ID, 'overview_item'.$i.'_name', true); ?></span><span class="overview__item-content"><?php echo nl2br(get_post_meta($post->ID, 'overview_item'.$i.'_content', true)); ?></span></li><?php
                        }
                        }
                        ?> 
                    </ul>
                </div>
            </div><?php
            }

            ?> 
        </article>
    </main>
<?php get_footer(); ?>