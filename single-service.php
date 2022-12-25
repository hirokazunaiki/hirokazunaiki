<?php get_header(); ?> 
    <main class="site-main">
        <article class="single-service-cont">
            <div class="single-service-cont__body"><?php

                /*****************************************/

                /*	Header - ヘッダー
                /*****************************************/

                if ( get_post_meta( $post->ID, 'service_header_main_copy', true ) && get_post_meta( $post->ID, 'service_header_episode', true ) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-header">
                        <div class="single-service-header__header fadeInTrigger">
                            <div class="single-service-header__header--en js_typing">Episode</div>
                            <div class="single-service-header__header--jp"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_header_main_copy', true))); ?></div>
                        </div><?php
                        if ( get_post_meta($post->ID, 'service_header_image1', true) ) {
                        ?> 
                        <div class="single-service-header__swiper zoomInTrigger">
                            <div class="swiper-wrapper"><?php
                                for ($i = 1; $i <= 5; $i++) {
                                if ( get_post_meta($post->ID, 'service_header_image'.$i, true) ) {
                                ?> 
                                <div class="swiper-slide">
                                    <div class="single-service-header__img-wrapper"><?php
                                        $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_header_image'.$i, true) );
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
                                        <img class="single-service-header__img" src="<?php echo $image_attributes[0]; ?>"><?php
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
                        <div class="single-service-header__txt-wrapper fadeInTrigger">
                            <div class="single-service-header__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_header_episode', true))); ?></div>
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	Future Nega - フューチャー（ネガ）
                /*****************************************/

                if ( get_post_meta( $post->ID, 'service_future_negative_title', true ) && get_post_meta( $post->ID, 'service_future_negative_content', true ) && get_post_meta( $post->ID, 'service_future_negative_image', true ) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-future"><?php
                        if ( get_post_meta( $post->ID, 'service_future_negative_image', true ) ) {
                        ?> 
                        <div class="single-service-future__img-wrapper zoomInTrigger"><?php
                            $attachment_id = attachment_url_to_postid( get_post_meta( $post->ID, 'service_future_negative_image', true ) );
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
                            $image_attributes = wp_get_attachment_image_src( $attachment_id, $attachment_size );
                            if ( $image_attributes ) {
                            ?> 
                            <img class="single-service-future__img" src="<?php echo $image_attributes[0]; ?>"><?php
                            }
                            ?> 
                        </div><?php
                        }
                        ?> 
                        <div class="single-service-future__body fadeRightTrigger">
                            <div class="single-service-future__header">
                                <h2 class="single-service-future__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', get_post_meta($post->ID, 'service_future_negative_title', true)); ?></h2>
                            </div>
                            <div class="single-service-future__txt-wrapper">
                                <div class="single-service-future__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', get_post_meta($post->ID, 'service_future_negative_content', true)); ?></div>
                            </div>
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	CONCEPT - コンセプト
                /*****************************************/
                
                if ( get_post_meta( $post->ID, 'service_concept_content', true ) ) {
                ?> 
                <section id="concept" class="single-service-sect">
                    <div class="single-service-concept">
                        <div class="single-service-concept__body">
                            <div class="single-service-concept__header fadeInTrigger">
                                <div class="single-service-concept__header--en js_typing">Concept</div>
                                <h2 class="single-service-concept__header--jp">コンセプト</h2>
                            </div>
                            <div class="single-service-concept__txt-wrapper fadeUpTrigger">
                                <div class="single-service-concept__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_concept_content', true))); ?></div>
                            </div>
                        </div><?php
                        if ( get_post_meta($post->ID, 'service_concept_main_image1', true) && get_post_meta($post->ID, 'service_concept_main_image2', true) ) {
                        ?> 
                        <div class="single-service-concept__img-outer zoomInTrigger">
                            <div class="single-service-concept__img-wrapper"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_concept_main_image1', true) );
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
                                <img class="single-service-concept__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div>
                            <div class="single-service-concept__img-wrapper"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_concept_main_image2', true) );
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
                                <img class="single-service-concept__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div>
                        </div><?php
                        }
                        ?> 
                    </div><?php

                    // ターゲット

                    if ( get_post_meta($post->ID, 'service_target_card1_title', true) && get_post_meta($post->ID, 'service_target_card2_title', true) && get_post_meta($post->ID, 'service_target_card3_title', true) ) {
                    ?> 
                    <div class="single-service-target">
                        <div class="single-service-target__header zoomInTrigger">
                            <h3 class="fukidashi-heading">こんな方にオススメ</h3>
                        </div>
                        <div class="single-service-target__body">
                            <div class="single-service-target__swiper fadeRightTrigger">
                                <div class="swiper-wrapper"><?php
                                    for ($i = 1; $i <= 5; $i++) {
                                    if ( get_post_meta($post->ID, 'service_target_card'.$i.'_title', true) ) {
                                    ?> 
                                    <div class="swiper-slide">
                                        <div class="single-service-target-card">
                                            <div class="single-service-target-card__inner">
                                                <div class="single-service-target-card__header">
                                                    <h3 class="single-service-target-card__ttl"><?php echo get_post_meta($post->ID, 'service_target_card'.$i.'_title', true); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div><?php
                                    }
                                    }
                                    ?> 
                                </div>
                            </div>
                        </div><?php
                        if ( get_post_meta($post->ID, 'service_target_main_image', true) ) {
                        ?> 
                        <div class="single-service-target__img-wrapper fadeInTrigger"><?php
                            $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_target_main_image', true) );
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
                            <img class="single-service-target__img" src="<?php echo $image_attributes[0]; ?>"><?php
                            }
                            ?> 
                        </div><?php
                        }
                        ?> 
                    </div><?php
                    }
                    ?> 
                </section><?php
                }

                /*****************************************/

                /*	Features - 特徴
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_feature_card1_title', true) && get_post_meta($post->ID, 'service_feature_card1_content', true) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Features</div>
                        <h2 class="single-service-sect__header--jp"><?php the_title(); ?>の特長</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-feature-cards"><?php
                            for ($i = 1; $i <= 6; $i++) {
                            if ( get_post_meta($post->ID, 'service_feature_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_feature_card'.$i.'_content', true) ) {
                            ?> 
                            <div class="single-service-feature-card fadeUpTrigger">
                                <div class="single-service-feature-card__header">
                                    <div class="single-service-feature-card__num"><?php echo sprintf('%02d', $i); ?></div>
                                    <h3 class="single-service-feature-card__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', get_post_meta($post->ID, 'service_feature_card'.$i.'_title', true)); ?></h3>
                                </div>
                                <div class="single-service-feature-card__body">
                                    <div class="single-service-feature-card__txt"><?php echo get_post_meta($post->ID, 'service_feature_card'.$i.'_content', true); ?></div>
                                </div>
                            </div><?php
                            }
                            }
                            ?> 
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	MERIT&DEMERIT - メリット・デメリット
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_merit_card1_title', true) && get_post_meta($post->ID, 'service_merit_card1_content', true) && get_post_meta($post->ID, 'service_merit_card1_image', true) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Merit & Demerit</div>
                        <h2 class="single-service-sect__header--jp"><?php the_title(); ?>のメリットとデメリット</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-merit">
                            <div class="single-service-merit__header zoomInTrigger">
                                <h3 class="fukidashi-heading">メリット</h3>
                            </div>
                            <div class="single-service-merit-cards"><?php
                                for ($i = 1; $i <= 6; $i++) {
                                if ( get_post_meta($post->ID, 'service_merit_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_merit_card'.$i.'_content', true) && get_post_meta($post->ID, 'service_merit_card'.$i.'_image', true) ) {
                                ?> 
                                <div class="single-service-merit-card">
                                    <div class="single-service-merit-card__inner">
                                        <div class="single-service-merit-card__img-wrapper zoomInTrigger">
                                            <div class="single-service-merit-card__num"><?php echo sprintf('%02d', $i); ?></div>
                                            <div class="single-service-merit-card__icon--merit"></div><?php
                                            $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_merit_card'.$i.'_image', true) );
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
                                            <img class="single-service-merit-card__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                            }
                                            ?> 
                                        </div>
                                        <div class="single-service-merit-card__body fadeRightTrigger">
                                            <div class="single-service-merit-card__header">
                                                <h4 class="single-service-merit-card__ttl"><?php echo get_post_meta($post->ID, 'service_merit_card'.$i.'_title', true); ?></h4>
                                            </div>
                                            <div class="single-service-merit-card__txt-wrapper">
                                                <div class="single-service-merit-card__txt"><?php echo get_post_meta($post->ID, 'service_merit_card'.$i.'_content', true); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                                }
                                }
                                ?> 
                            </div>
                        </div><?php
                        if ( get_post_meta($post->ID, 'service_demerit1_title', true) && get_post_meta($post->ID, 'service_demerit1_content', true) && get_post_meta($post->ID, 'service_demerit1_image', true) ) {
                        ?> 
                        <div class="single-service-merit">
                            <div class="single-service-merit__header zoomInTrigger">
                                <h3 class="fukidashi-heading">デメリット</h3>
                            </div>
                            <div class="single-service-merit-cards"><?php
                                for ($i = 1; $i <= 6; $i++) {
                                if ( get_post_meta($post->ID, 'service_demerit'.$i.'_title', true) && get_post_meta($post->ID, 'service_demerit'.$i.'_content', true) && get_post_meta($post->ID, 'service_demerit'.$i.'_image', true)) {
                                ?> 
                                <div class="single-service-merit-card">
                                    <div class="single-service-merit-card__inner">
                                        <div class="single-service-merit-card__img-wrapper zoomInTrigger">
                                            <div class="single-service-merit-card__num"><?php echo sprintf('%02d', $i); ?></div>
                                            <div class="single-service-merit-card__icon--demerit"></div><?php
                                            $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_demerit'.$i.'_image', true) );
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
                                            <img class="single-service-merit-card__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                            }
                                            ?> 
                                        </div>
                                        <div class="single-service-merit-card__body fadeRightTrigger">
                                            <div class="single-service-merit-card__header">
                                                <h4 class="single-service-merit-card__ttl"><?php echo get_post_meta($post->ID, 'service_demerit'.$i.'_title', true); ?></h4>
                                            </div>
                                            <div class="single-service-merit-card__txt-wrapper">
                                                <div class="single-service-merit-card__txt"><?php echo get_post_meta($post->ID, 'service_demerit'.$i.'_content', true); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                                }
                                }
                                ?> 
                            </div>
                        </div><?php
                        }
                        ?> 
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	FUTURE positive - フューチャー（ポジ）
                /*****************************************/

                if ( get_post_meta( $post->ID, 'service_future_positive_title', true ) && get_post_meta( $post->ID, 'service_future_positive_content', true ) && get_post_meta( $post->ID, 'service_future_positive_image', true ) ) {
                ?> 
                <section id="future-pos" class="single-service-sect">
                    <div class="single-service-future single-service-future--pos"><?php
                        if ( get_post_meta( $post->ID, 'service_future_positive_image', true ) ) {
                        ?> 
                        <div class="single-service-future__img-wrapper zoomInTrigger"><?php
                            $attachment_id = attachment_url_to_postid( get_post_meta( $post->ID, 'service_future_positive_image', true ) );
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
                            $image_attributes = wp_get_attachment_image_src( $attachment_id, $attachment_size );
                            if ( $image_attributes ) {
                            ?> 
                            <img class="ssingle-service-future__img" src="<?php echo $image_attributes[0]; ?>"><?php
                            }
                            ?> 
                        </div><?php
                        }
                        ?> 
                        <div class="single-service-future__body fadeRightTrigger">
                            <div class="single-service-future__header">
                                <h2 class="single-service-future__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', get_post_meta($post->ID, 'service_future_positive_title', true)); ?></h2>
                            </div>
                            <div class="single-service-future__txt-wrapper">
                                <div class="single-service-future__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', get_post_meta($post->ID, 'service_future_positive_content', true)); ?></div>
                            </div>
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	PRICE - 価格
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_price_content', true) ) {
                ?> 
                <section class="single-service-sect type">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Price</div>
                        <h2 class="single-service-sect__header--jp"><?php the_title(); ?>の費用</h2>
                    </div>
                    <div class="single-service-sect__body"><?php
                        if ( get_post_meta($post->ID, 'service_price_content', true) ) {
                        ?> 
                        <div class="single-service-sect__txt-wrapper fadeUpTrigger">
                            <div class="single-service-sect__txt"><?php echo get_post_meta($post->ID, 'service_price_content', true); ?></div>
                        </div><?php
                        }
                        ?> 
                        <div class="single-service-type-cards"><?php
                            for ($i = 1; $i <= 8; $i++) {
                            if ( get_post_meta($post->ID, 'service_price_card'.$i.'_hashtag', true) && get_post_meta($post->ID, 'service_price_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_price_card'.$i.'_content', true) && get_post_meta($post->ID, 'service_price_card'.$i.'_image', true)) {
                            ?> 
                            <div class="single-service-type-card">
                                <div class="single-service-type-card__img-wrapper fadeInTrigger"><?php
                                    $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_price_card'.$i.'_image', true) );
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
                                    <img class="single-service-type-card__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                    }
                                    ?> 
                                </div>
                                <div class="single-service-type-card__body fadeUpTrigger">
                                    <div class="single-service-type-card__num"><?php echo get_post_meta($post->ID, 'service_price_card'.$i.'_hashtag', true); ?></div>
                                    <div class="single-service-type-card__header">
                                        <h3 class="single-service-type-card__ttl"><?php echo get_post_meta($post->ID, 'service_price_card'.$i.'_title', true); ?></h3>
                                    </div>
                                    <div class="single-service-type-card__txt-wrapper">
                                        <div class="single-service-type-card__txt"><?php echo get_post_meta($post->ID, 'service_price_card'.$i.'_content', true); ?></div>
                                    </div><?php
                                    if ( get_post_meta($post->ID, 'service_price_card'.$i.'_detail1_item_name', true) && get_post_meta($post->ID, 'service_price_card'.$i.'_detail1_item_content', true) ) {
                                    ?> 
                                    <div class="single-service-type-card__detail-wrapper">
                                        <table class="single-service-type-card-detail"><?php
                                            for ($ii = 1; $ii <= 3; $ii++) {
                                            if ( get_post_meta($post->ID, 'service_price_card'.$i.'_detail'.$ii.'_item_name', true) ) {
                                            ?> 
                                            <tr class="single-service-type-card-detail__item">
                                                <th class="single-service-type-card-detail__item-name"><?php echo get_post_meta($post->ID, 'service_price_card'.$i.'_detail'.$ii.'_item_name', true); ?></th>
                                                <td class="single-service-type-card-detail__item-content"><?php echo get_post_meta($post->ID, 'service_price_card'.$i.'_detail'.$ii.'_item_content', true); ?></td>
                                            </tr><?php
                                            }
                                            }
                                            ?> 
                                        </table>
                                    </div><?php
                                    }
                                    ?> 
                                </div>
                            </div><?php
                            }
                            }
                            ?> 
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	CASE - 事例紹介
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_case_card1_title', true) && get_post_meta($post->ID, 'service_case_card1_content', true) && get_post_meta($post->ID, 'service_case_card1_image', true)) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Case</div>
                        <h2 class="single-service-sect__header--jp"><?php the_title(); ?>の事例</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-sect__txt-wrapper fadeUpTrigger">
                            <div class="single-service-sect__txt"><?php echo get_post_meta($post->ID, 'service_case_content', true); ?></div>
                        </div>
                        <div class="single-service-case-swiper">
                            <div class="swiper-wrapper"><?php
                                for ($i = 1; $i <= 6; $i++) {
                                if ( get_post_meta($post->ID, 'service_case_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_case_card'.$i.'_content', true) && get_post_meta($post->ID, 'service_case_card'.$i.'_image', true)) {
                                ?> 
                                <div class="swiper-slide">
                                    <div class="single-service-case-card fadeUpTrigger">
                                        <div class="single-service-case-card__img-wrapper"><?php
                                            $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_case_card'.$i.'_image', true) );
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
                                            <img class="single-service-case-card__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                            }
                                            ?> 
                                        </div>
                                        <div class="single-service-case-card__body">
                                            <div class="single-service-case-card__header">
                                                <h3 class="single-service-case-card__ttl"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_title', true); ?></h3>
                                            </div>
                                            <div class="single-service-case-card__txt-wrapper">
                                                <div class="single-service-case-card__txt"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_content', true); ?></div>
                                            </div>
                                            <div class="single-service-case-card__detail-wrapper">
                                                <table class="single-service-case-card-detail">
                                                    <tr class="single-service-case-card-detail__item">
                                                        <th class="single-service-case-card-detail__item-name">タイプ</th>
                                                        <td class="single-service-case-card-detail__item-content"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_detail1', true); ?></td>
                                                    </tr>
                                                    <tr class="single-service-case-card-detail__item">
                                                        <th class="single-service-case-card-detail__item-name">制作期間</th>
                                                        <td class="single-service-case-card-detail__item-content"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_detail2', true); ?></td>
                                                    </tr>
                                                    <tr class="single-service-case-card-detail__item">
                                                        <th class="single-service-case-card-detail__item-name">担当範囲</th>
                                                        <td class="single-service-case-card-detail__item-content"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_detail3', true); ?></td>
                                                    </tr><?php
                                                    if ( get_post_meta($post->ID, 'service_case_card'.$i.'_detail4', true) ) {
                                                    ?> 
                                                    <tr class="single-service-case-card-detail__item">
                                                        <th class="single-service-case-card-detail__item-name">URL</th>
                                                        <td class="single-service-case-card-detail__item-content"><a href="<?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_detail4', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'service_case_card'.$i.'_detail4', true); ?></a></td>
                                                    </tr><?php
                                                    }
                                                    ?> 
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                                }
                                }
                                ?> 
                            </div>
                            <div class="swiper-arrow-wrapper fadeInTrigger">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	FLOW - 進め方
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_flow_card1_title', true) && get_post_meta($post->ID, 'service_flow_card1_content', true) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Flow</div>
                        <h2 class="single-service-sect__header--jp"><?php the_title(); ?>の進め方</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="flow-timeline">
                            <ul class="flow-timeline__list"><?php
                                for ($i = 1; $i <= 10; $i++) {
                                if ( get_post_meta($post->ID, 'service_flow_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_flow_card'.$i.'_content', true) ) {
                                ?> 
                                <li class="flow-timeline__item">
                                    <dl class="flow-timeline__inner zoomInTrigger">
                                        <dt class="flow-timeline__ttl">
                                            <span class="flow-timeline__ttl--en"><?php echo sprintf('%02d', $i); ?></span>
                                            <span class="flow-timeline__ttl--jp"><?php echo get_post_meta($post->ID, 'service_flow_card'.$i.'_title', true); ?></span>
                                        </dt>
                                        <dd class="flow-timeline__content"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_flow_card'.$i.'_content', true))); ?></dd>
                                    </dl>
                                    <span class="flow-timeline__border-line"></span>
                                </li><?php
                                }
                                }
                                ?> 
                            </ul>
                        </div><?php
                        
                        // アフターサポート
                        if ( get_post_meta($post->ID, 'service_support_content', true) ) {
                        ?> 
                        <div class="flow-timeline-media fadeUpTrigger">
                            <div class="flow-timeline-media__header">
                                <span class="flow-timeline-media__ttl--en">After Support</span>
                                <h2 class="flow-timeline-media__ttl--jp">アフターサポート</h2>
                            </div><?php
                            if ( get_post_meta($post->ID, 'service_support_main_image', true) ) {
                            ?> 
                            <div class="flow-timeline-media__img-wrapper"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_support_main_image', true) );
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
                                <img class="flow-timeline-media__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div><?php
                            }
                            ?> 
                            <div class="flow-timeline-media__body">
                                <div class="flow-timeline-media__txt-wrapper">
                                    <div class="flow-timeline-media__txt"><?php echo get_post_meta($post->ID, 'service_support_content', true); ?></div>
                                </div>
                            </div>
                        </div><?php
                        }

                        // 公開後について
                        if ( get_post_meta($post->ID, 'service_support_card1_title', true) && get_post_meta($post->ID, 'service_support_card2_title', true) && get_post_meta($post->ID, 'service_support_card3_title', true) ) {
                        ?> 
                        <div class="flow-timeline-media-swiper">
                            <div class="flow-timeline-media-swiper__header zoomInTrigger">
                                <h3 class="fukidashi-heading">公開後にやること</h3>
                            </div>
                            <div class="swiper-wrapper"><?php
                                for ( $i = 1; $i <= 5; $i++ ) {
                                if ( get_post_meta($post->ID, 'service_support_card'.$i.'_title', true) ) {
                                ?> 
                                <div class="swiper-slide">
                                    <div class="timeline-after-support-card">
                                        <div class="timeline-after-support-card__inner">
                                            <div class="timeline-after-support-card__header">
                                                <h4 class="timeline-after-support-card__ttl"><?php echo get_post_meta( $post->ID, 'service_support_card'.$i.'_title', true ); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                                }
                                }
                                ?> 
                            </div><?php
                            if ( get_post_meta($post->ID, 'service_support_sub_image', true) ) {
                            ?> 
                            <div class="flow-timeline-media-swiper__img-wrapper fadeInTrigger"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta ($post->ID, 'service_support_sub_image', true ) );
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
                                <img class="flow-timeline-media-swiper__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div><?php
                            }
                            ?> 
                        </div><?php
                        }
                        ?> 
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	FAQ - よくあるご質問
                /*****************************************/

                if ( get_post_meta($post->ID, 'service_faq_card1_title', true) && get_post_meta($post->ID, 'service_faq_card1_content', true) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">FAQ</div>
                        <h2 class="single-service-sect__header--jp">よくあるご質問</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-sect__txt-wrapper fadeUpTrigger">
                            <div class="single-service-sect__txt"><?php echo get_post_meta($post->ID, 'service_faq_content', true); ?></div>
                        </div>
                        <div class="accordions fadeUpTrigger"><?php
                            for ($i = 1; $i <= 10; $i++) {
                            if ( get_post_meta($post->ID, 'service_faq_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_faq_card'.$i.'_content', true) ) {
                            ?> 
                            <section class="accordion">
                                <h3 class="accordion__question"><?php echo get_post_meta($post->ID, 'service_faq_card'.$i.'_title', true); ?></h3>
                                <div class="accordion__answer-wrapper">
                                    <div class="accordion__answer"><?php echo get_post_meta($post->ID, 'service_faq_card'.$i.'_content', true); ?></div>
                                </div>
                            </section><?php
                            }
                            }
                            ?> 
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/
                /*	特典の提示
                /*****************************************/
                if ( get_post_meta($post->ID, 'service_special_offer_card1_title', true) && get_post_meta($post->ID, 'service_special_offer_card1_content', true) && get_post_meta($post->ID, 'service_special_offer_card1_image', true) ) {
                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Special Offer</div>
                        <h2 class="single-service-sect__header--jp">無料相談をお申込みした方の特典</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-special-offer-cards"><?php
                            for ($i = 1; $i <= 6; $i++) {
                            if ( get_post_meta($post->ID, 'service_special_offer_card'.$i.'_title', true) && get_post_meta($post->ID, 'service_special_offer_card'.$i.'_content', true) && get_post_meta($post->ID, 'service_special_offer_card'.$i.'_image', true) ) {
                            ?> 
                            <div class="single-service-special-offer-card fadeUpTrigger">
                                <div class="single-service-special-offer-card__img-wrapper">
                                    <div class="single-service-special-offer-card__num"><?php echo sprintf('%02d', $i); ?></div><?php
                                    $attachment_id = attachment_url_to_postid( get_post_meta($post->ID, 'service_special_offer_card'.$i.'_image', true) );
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
                                    <img class="single-service-special-offer-card__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                    }
                                    ?> 
                                </div>
                                <div class="single-service-special-offer-card__body">
                                    <div class="single-service-special-offer-card__header">
                                        <h3 class="single-service-special-offer-card__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_special_offer_card'.$i.'_title', true))); ?></h3>
                                    </div>
                                    <div class="single-service-special-offer-card__txt-wrapper">
                                        <div class="single-service-special-offer-card__txt"><?php echo get_post_meta($post->ID, 'service_special_offer_card'.$i.'_content', true); ?></div>
                                    </div>
                                </div>
                            </div><?php
                            }
                            }
                            ?> 
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	Summarize - まとめ
                /*****************************************/

                if ( get_post_meta( $post->ID, 'service_summarize_title', true ) ) {
                ?> 
                <section id="summarize" class="single-service-sect">
                    <div class="single-service-summarize">
                        <div class="single-service-summarize__body fadeInTrigger">
                            <div class="single-service-summarize__inner">
                                <div class="single-service-summarize__header">
                                    <h2 class="single-service-summarize__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_summarize_title', true))); ?></h2>
                                </div>
                                <div class="single-service-summarize__txt-wrapper">
                                    <div class="single-service-summarize__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_summarize_content', true))); ?></div>
                                </div>
                            </div>
                        </div><?php
                        if ( get_post_meta( $post->ID, 'service_summarize_image', true ) ) {
                        ?> 
                        <div class="single-service-summarize__img-wrapper fadeUpTrigger"><?php
                            $attachment_id = attachment_url_to_postid( get_post_meta( $post->ID, 'service_summarize_image', true ) );
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
                            $image_attributes = wp_get_attachment_image_src( $attachment_id, $attachment_size );
                            if ( $image_attributes ) {
                            ?> 
                            <img class="single-service-summarize__img" src="<?php echo $image_attributes[0]; ?>"><?php
                            }
                            ?> 
                        </div><?php
                        }
                        ?> 
                    </div>
                </section><?php
                }               

                ?> 
                <section class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Application</div>
                        <h2 class="single-service-sect__header--jp">「無料相談」のお申込み方法</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-sect__txt-wrapper">
                            <div class="single-service-sect__txt"><?php echo get_post_meta($post->ID, 'service_cta_content', true); ?></div>
                        </div>
                        <div class="single-service-cta fadeUpTrigger">
                            <div class="single-service-cta__body">
                                <div class="single-service-cta__btn-wrapper">
                                    <div class="cta-btn"><a class="cta-btn__link" href="<?php echo esc_url(home_url('/application')); ?>"><span class="cta-btn__txt">無料相談をしてみる</span><span class="cta-btn__icon"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><?php 

                /*****************************************/

                /*	PS - 追伸
                /*****************************************/

                if ( get_post_meta( $post->ID, 'service_ps_title', true ) && get_post_meta( $post->ID, 'service_ps_content', true ) ) {
                ?> 
                <section id="ps" class="single-service-sect">
                    <div class="single-service-ps fadeInTrigger">
                        <div class="single-service-ps__header">
                            <h2 class="single-service-ps__ttl"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_ps_title', true))); ?></h2>
                        </div>
                        <div class="single-service-ps__body">
                            <div class="single-service-ps__txt-wrapper">
                                <div class="single-service-ps__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_ps_content', true))); ?></div>
                            </div>
                        </div>
                    </div>
                </section><?php
                }

                /*****************************************/

                /*	Profile - プロフィール
                /*****************************************/
                
                if ( get_post_meta( $post->ID, 'service_profile_image', true ) && get_post_meta( $post->ID, 'service_profile_content', true ) ) {
                ?> 
                <section id="profile" class="single-service-sect">
                    <div class="single-service-sect__header fadeInTrigger">
                        <div class="single-service-sect__header--en js_typing">Profile</div>
                        <h2 class="single-service-sect__header--jp">制作者のプロフィール</h2>
                    </div>
                    <div class="single-service-sect__body">
                        <div class="single-service-profile fadeRightTrigger"><?php
                            if ( get_post_meta( $post->ID, 'service_profile_image', true ) ) {
                            ?> 
                            <div class="single-service-profile__img-wrapper"><?php
                                $attachment_id = attachment_url_to_postid( get_post_meta( $post->ID, 'service_profile_image', true ) );
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
                                $image_attributes = wp_get_attachment_image_src( $attachment_id, $attachment_size );
                                if ( $image_attributes ) {
                                ?> 
                                <img class="single-service-profile__img" src="<?php echo $image_attributes[0]; ?>"><?php
                                }
                                ?> 
                            </div><?php
                            }
                            ?> 
                            <div class="single-service-profile__body">
                                <div class="single-service-profile__txt-wrapper">
                                    <div class="single-service-profile__txt"><?php echo str_replace(array("\r\n","\r","\n","\t"), '', nl2br(get_post_meta($post->ID, 'service_profile_content', true))); ?></div>
                                </div>
                                <div class="single-service-profile__btn-wrapper">
                                    <div class="detail-btn fadeInTrigger"><a href="<?php echo esc_url(home_url('/about')); ?>" class="detail-btn__link"><span class="detail-btn__txt">View More</span><span class="detail-btn__icon"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><?php
                }
                ?> 
            </div>
        </article>
    </main>
<?php get_footer(); ?>