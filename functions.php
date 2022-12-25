<?php

/* ========================================================================== */

/*	CSS & Script設定
/* ========================================================================== */

function custom_enqueue_scripts() {
    $theme_version = wp_get_theme()->get('Version');
    // CSS
    wp_enqueue_style('reset', get_template_directory_uri().'/assets/css/ress.min.css', array(), '4.0.0');
    wp_enqueue_style('custom-theme-style', get_stylesheet_uri(), array(), $theme_version);
    wp_enqueue_style('swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '8.4.3');

    // Script
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
    wp_enqueue_script('shuffle-text-script', 'https://cdn.jsdelivr.net/npm/shuffle-text@0.3.0/build/shuffle-text.min.js', '', '0.3.0', true);
    wp_enqueue_script('shuffle-text-start-script', get_template_directory_uri().'/assets/js/shuffle-text/shuffle-text-start.js', array(), $theme_version, true);
    wp_enqueue_script('swiper-script', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), '8.4.3', true);
    wp_enqueue_script('swiper-start-script', get_template_directory_uri().'/assets/js/swiper/swiper-start.js', array(), $theme_version, true);
    wp_enqueue_script('original-theme-script', get_template_directory_uri().'/assets/js/custom.js', array(), $theme_version, true);
}
add_action('wp_enqueue_scripts','custom_enqueue_scripts');


function custom_admin_style(){
    $theme_version = wp_get_theme()->get('Version');
    // CSS
    wp_enqueue_style('admin_style', get_template_directory_uri().'/assets/css/admin.css', array(), $theme_version);
}
add_action('admin_enqueue_scripts', 'custom_admin_style');

/* ========================================================================== */

/*	自動的に出力される不要項目の削除
/* ========================================================================== */

function remove_wp_block_library() {
    wp_dequeue_style('wp-block-library');
}
add_action('wp_print_styles', 'remove_wp_block_library');
add_action( 'wp_enqueue_scripts', 'remove_my_global_styles' );
function remove_my_global_styles() {
	wp_dequeue_style( 'global-styles' );
}
add_filter('show_admin_bar', '__return_false');
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/* ========================================================================== */

/*	各機能の有効化
/* ========================================================================== */

function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo'); 
}
add_action('after_setup_theme','custom_theme_setup');

// 固定ぺージでの抜粋の有効化
add_post_type_support('page', 'excerpt');

/* ========================================================================== */

/*	ナビゲーションメニューの設定
/* ========================================================================== */

function register_custom_menu() { 
    register_nav_menus( array(
        'horizontal-menu' => '水平メニュー',
        'footer-menu' => 'フッターメニュー',
        'sns-menu' => 'SNSメニュー',
        'modal-menu' => 'モーダルメニュー',
    ) );
}
add_action( 'after_setup_theme', 'register_custom_menu' );

// メニューのID削除
function remove_menu_id($id) { 
    return $id = array(); 
}
add_filter( 'nav_menu_item_id', 'remove_menu_id', 10 );

//メニューのクラス設定（li）
function add_menu_class_li($classes, $item, $args) {
    $classes = array();
    if ( isset( $args->add_li_class ) ) {
        if ( $item->current == true || get_post_type() == wp_basename( $item->url ) ) {
            $classes['class'] = $args->add_li_class.' current';
        } else {
            $classes['class'] = $args->add_li_class;
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'add_menu_class_li', 1, 3 );

//メニューのクラス設定（a）
function add_menu_class_a($classes, $item, $args) {
    if ( isset ( $args->add_a_class ) ) {
        $classes['class'] = $args->add_a_class;
    }
    return $classes;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_class_a', 1, 3 );

/* ========================================================================== */

/*	新規カスタム投稿タイプの設定
/* ========================================================================== */

function create_custom_post_type() {

    // デフォルトの投稿の無効化
    register_post_type(
        'post',
        array(
            'public' => false,
        )
    );

    register_taxonomy(
        'category',
        'post',
        array(
            'public' => false,
        )
    );

    register_taxonomy(
        'post_tag',
        'post',
        array(
            'public' => false,
        )
    );

    // Blog - ブログ
    register_post_type(
        'blog',
        array(
            'labels' => array(
                'name' => 'ブログ',
                'all_items' => '投稿一覧',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'revisions'
            ),
            'rewrite' => array(
                'with_front' => false,
            ),
        )
    );

    // Blog - ブログ（カテゴリー）
    register_taxonomy(
        'blog-category',
        'blog',
        array(
            'label' => 'カテゴリー',
            'hierarchical' => true,
            'public' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'blog/category',
            ),
        )
    );

    // Blog - ブログ（タグ）
    register_taxonomy(
        'blog-tag',
        'blog',
        array(
            'label' => 'タグ',
            'hierarchical' => false,
            'public' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'blog/tag',
            ),
        )
    );

    // News - お知らせ
    register_post_type(
        'news',
        array(
            'labels' => array(
                'name' => 'お知らせ',
                'all_items' => '投稿一覧',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'supports' => array(
                'title',
                'editor',
                'revisions'
            ),
            'rewrite' => array(
                'with_front' => false,
            ),
        )
    );

    // Service - サービス
    register_post_type(
        'service',
        array(
            'labels' => array(
                'name' => 'サービス',
                'all_items' => '投稿一覧',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'supports' => array(
                'title',
                'thumbnail',
                'excerpt',
                'revisions',
            ),
            'rewrite' => array(
                'with_front' => false,
            ),
        )
    );

    // Work - 実績
    register_post_type(
        'work',
        array(
            'labels' => array(
                'name' => '実績',
                'all_items' => '投稿一覧',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'supports' => array(
                'title',
                'revisions',
                'editor',
                'thumbnail',
                'excerpt',
                'revisions'
            ),
            'rewrite' => array(
                'with_front' => false,
            ),
        )
    );

    // Works - 実績（カテゴリー）
    register_taxonomy(
        'work-category',
        'work',
        array(
            'label' => 'カテゴリー',
            'hierarchical' => true,
            'public' => true,
            'show_in_rest' => false,
            'show_in_nav_menus' => false,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'work/category',
            ),
        )
    );
}
add_action('init', 'create_custom_post_type');

// リライトルールの追加
function custom_rewrite_rule() {

    // リライトルールの変更（Blog）
    add_rewrite_rule('blog/category/([^/]+)/?$', 'index.php?blog-category=$matches[1]', 'top');
    add_rewrite_rule('blog/tag/([^/]+)/?$', 'index.php?blog-tag=$matches[1]', 'top');

    // リライトルールの変更（Work）
    add_rewrite_rule('work/category/([^/]+)/?$', 'index.php?work-category=$matches[1]', 'top');

}
add_action('init', 'custom_rewrite_rule');


/* ========================================================================== */

/*	新規カスタムフィールドの追加
/* ========================================================================== */

/* -------------------------------------------------------------------------- */

/* メディアアップローダーの設定
/* -------------------------------------------------------------------------- */

function my_admin_scripts() {
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'my_admin_scripts' );


/* -------------------------------------------------------------------------- */

/*	画像アップロードのjQuery設定
/* -------------------------------------------------------------------------- */

function my_admin_footer_script() {
    ?>
    <script>
    jQuery ( function($) {
        $(".my_uploader .current_img").on('click', '.select_img', function(event) {
            event.preventDefault();
            const modal = wp.media({
                title: "画像を選択",
                library: {
                    type: "image"
                },
                multiple: false
            });
            modal.open();
            const group = $(this).parents('.my_uploader'); 
            const current = group.find('.current_img');
            const imageUrl = group.find("input[type='hidden']");
            modal.on( "select", function(){
                const images = modal.state().get("selection").first();
                current.empty();
                imageUrl.val(images.attributes.url);
                current.append('<a href="#" class="select_img"><img src="'+images.attributes.url+'" /></a><p class="hide-if-no-js howto">編集または更新する画像をクリック</p><p><a href="#" class="remove_img">プロフィール画像を削除</a></p>');
            });
        });
    
        $(".my_uploader .current_img").on('click', '.remove_img', function(event) {
            event.preventDefault();
            const group = $(this).parents('.my_uploader'); 
            const current = group.find('.current_img');
            const imageUrl = group.find("input[type='hidden']");
            current.empty();
            imageUrl.val('');
            current.append('<a href="#" class="select_img">画像を設定</a>');
        });
    });
    </script>
    <?php
}
add_action('admin_print_footer_scripts', 'my_admin_footer_script');


/* -------------------------------------------------------------------------- */

/*	新規カスタムフィールドの初期設定
/* -------------------------------------------------------------------------- */

function my_meta_boxes() {
    global $post;

    // カスタム投稿 - hero
    if ($post->post_name == 'hero') {
        add_meta_box(
            'hero_image',
            'ヘッダー画像',
            'hero_image_callback',
            'page',
            'normal'
        );
        add_meta_box(
            'hero_copy',
            'メインコピー',
            'hero_copy_callback',
            'page',
            'normal'
        );
    }

    // 固定ぺージ - about
    if ($post->post_name == 'about') {
        add_meta_box(
            'profile_image',
            'プロフィール画像',
            'profile_image_callback',
            'page',
            'side'
        );
        add_meta_box(
            'overview',
            '事業概要',
            'overview_callback',
            'page',
            'normal'
        );
    }

    // 固定ぺージ - mission
    if ($post->post_name == 'mission') {
        add_meta_box(
            'mission_copy',
            'ミッションコピー',
            'mission_copy_callback',
            'page',
            'normal'
        );
        add_meta_box(
            'mission_image',
            'ミッション画像',
            'mission_image_callback',
            'page',
            'normal'
        );
    }

    // カスタム投稿タイプ - Service
    add_meta_box(
        'service_header',
        'ヘッダー',
        'service_header_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_future_negative',
        'フューチャー（ネガ）',
        'service_future_negative_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_concept',
        'コンセプト',
        'service_concept_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_target',
        'ターゲット',
        'service_target_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_feature',
        '特長',
        'service_feature_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_merit',
        'メリット',
        'service_merit_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_demerit',
        'デメリット',
        'service_demerit_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_future_positive',
        'フューチャー（ポジ）',
        'service_future_positive_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_price',
        '価格',
        'service_price_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_case',
        '事例',
        'service_case_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_flow',
        'フロー',
        'service_flow_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_support',
        'サポート',
        'service_support_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_faq',
        'よくあるご質問',
        'service_faq_callback',
        'service',
        'normal'
    );

    add_meta_box(
        'service_special_offer',
        '特典',
        'service_special_offer_callback',
        'service',
        'normal'
    );

    // Summarize - まとめ
    add_meta_box(
        'service_summarize',
        'まとめ',
        'service_summarize_callback',
        'service',
        'normal'
    );

    // CTA - 行動喚起
    add_meta_box(
        'service_cta',
        '行動喚起',
        'service_cta_callback',
        'service',
        'normal'
    );

    // PS - 追伸
    add_meta_box(
        'service_ps',
        '追伸',
        'service_ps_callback',
        'service',
        'normal'
    );

    // Profile - プロフィール
    add_meta_box(
        'service_profile',
        'プロフィール',
        'service_profile_callback',
        'service',
        'normal'
    );

}
add_action('add_meta_boxes', 'my_meta_boxes');

/* -------------------------------------------------------------------------- */

/*	カスタムフィールドのコールバック設定
/* -------------------------------------------------------------------------- */

/*****************************************/
/*	固定ぺージ - Hero
/*****************************************/

function hero_image_callback($post) {
    global $post;
    for ($i = 1; $i <= 5; $i++) {

        // キーの設定
        $keyname = 'hero_image'.$i;

        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta($post->ID, $keyname, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

        // HTMLの出力
        ?> 
        <fieldset class="my_uploader">
            <legend >画像<?php echo $i ?></legend>
            <input type="hidden" name="<?php echo $keyname ?>" value="<?php echo esc_attr($get_value); ?>" />
            <div class="current_img">
                <?php
                if ($get_value) {
                ?>
                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value); ?>"></a>
                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                <p><a href="#" class="remove_img">画像を削除</a></p>
                <?php
                } else {
                ?>
                <a href="#" class="select_img">画像を設定</a>
                <?php
                }
                ?>
            </div>
        </fieldset>
        <?php
    }	
}

function hero_copy_callback($post) {
    global $post;
    for ($i = 1; $i <= 3; $i++){

        // キーの設定
        $keyname = 'hero_copy'.$i;

        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta($post->ID, $keyname, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

        // HTMLの出力
        ?> 
        <fieldset class="form-wrapper">
            <legend><?php echo $i; ?>行目</legend>
            <input type="text" name="<?php echo $keyname; ?>" value="<?php echo $get_value; ?>" size="30" maxlength="20">
        </fieldset>
        <?php
    }
}

/*****************************************/
/*	固定ぺージ - ABOUT
/*****************************************/

/* ----------------------------- */
/* プロフィール画像
/* ----------------------------- */

function profile_image_callback($post) {
    global $post;

    // キーの設定
    $keyname = 'profile_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力
    ?> 
    <fieldset class="my_uploader" style="margin-top:15px;">
        <input type="hidden" name="<?php echo $keyname; ?>" value="<?php echo esc_attr($get_value); ?>" />
        <div class="current_img">
            <?php
            if ($get_value) {
            ?>
            <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value); ?>"></a>
            <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
            <p><a href="#" class="remove_img">プロフィール画像を削除</a></p>
            <?php
            } else {
            ?>
            <a href="#" class="select_img">プロフィール画像を設定</a>
            <?php
            }
            ?>
        </div>
    </fieldset>
	<?php	
}

/* ----------------------------- */
/* 事業概要
/* ----------------------------- */

function overview_callback($post) {
    global $post;

    // キーの設定
    $keyname = 'overview_title';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力    
    ?>
    <fieldset class="form-wrapper">
        <legend>見出し</legend>
        <input type="text" name="overview_title" value="<?php echo $get_value; ?>" size="30" maxlength="20">
    </fieldset>
    <?php
    for ($i = 1; $i <= 10; $i++){

        $keyname1 = 'overview_item'.$i.'_name';
        $keyname2 = 'overview_item'.$i.'_content';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend><?php echo $i; ?>行目</legend>
            <p>項目名</br><input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="30"></p>
            <p>内容</br><textarea name="<?php echo $keyname2; ?>" rows="3" cols="100%"><?php echo $get_value2; ?></textarea></p>
        </fieldset>
        <?php
    }
}

/*****************************************/

/*	固定ぺージ - Mission
/*****************************************/

/* ----------------------------- */
/* ミッションイメージ画像
/* ----------------------------- */

function mission_image_callback($post) {

    global $post;

    for ($i = 1; $i <= 5; $i++) {

        // キーの設定
        $keyname = 'mission_image'.$i;

        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta($post->ID, $keyname, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

        // HTMLの出力
        ?> 
        <fieldset class="my_uploader">
            <legend >画像<?php echo $i ?></legend>
            <input type="hidden" name="<?php echo $keyname ?>" value="<?php echo esc_attr($get_value); ?>" />
            <div class="current_img">
                <?php
                if ($get_value) {
                ?>
                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value); ?>"></a>
                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                <p><a href="#" class="remove_img">画像を削除</a></p>
                <?php
                } else {
                ?>
                <a href="#" class="select_img">画像を設定</a>
                <?php
                }
                ?>
            </div>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */
/* ミッションコピー
/* ----------------------------- */

function mission_copy_callback($post) {
    global $post;
    for ($i = 1; $i <= 3; $i++){

        // キーの設定
        $keyname = 'mission_copy'.$i;

        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta($post->ID, $keyname, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend><?php echo $i; ?>行目</legend>
            <input type="text" name="<?php echo $keyname; ?>" value="<?php echo $get_value; ?>" size="30" maxlength="20">
        </fieldset>
        <?php
    }
}

/*****************************************/

/*	カスタム投稿タイプ - Service
/*****************************************/

/* ----------------------------- */

/* Header - ヘッダー
/* ----------------------------- */

function service_header_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_header_title';
    $keyname2 = 'service_header_main_copy';
    $keyname3 = 'service_header_episode';
    $keyname4 = 'service_header_image1';
    $keyname5 = 'service_header_image2';
    $keyname6 = 'service_header_image3';
    $keyname7 = 'service_header_image4';
    $keyname8 = 'service_header_image5';


    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);
    $get_value3 = get_post_meta($post->ID, $keyname3, true);
    $get_value4 = get_post_meta($post->ID, $keyname4, true);
    $get_value5 = get_post_meta($post->ID, $keyname5, true);
    $get_value6 = get_post_meta($post->ID, $keyname6, true);
    $get_value7 = get_post_meta($post->ID, $keyname7, true);
    $get_value8 = get_post_meta($post->ID, $keyname8, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
    wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);
    wp_nonce_field('action-'.$keyname4, 'nonce-'.$keyname4);
    wp_nonce_field('action-'.$keyname5, 'nonce-'.$keyname5);
    wp_nonce_field('action-'.$keyname6, 'nonce-'.$keyname6);
    wp_nonce_field('action-'.$keyname7, 'nonce-'.$keyname7);
    wp_nonce_field('action-'.$keyname8, 'nonce-'.$keyname8);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>タイトル</th>
            <td><textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea></td>
        </tr>
        <tr>
            <th>メインコピー</th>
            <td><textarea name="<?php echo $keyname2; ?>" rows="3" cols="100%"><?php echo $get_value2; ?></textarea></td>
        </tr>
        <tr>
            <th>エピソード</th>
            <td><textarea name="<?php echo $keyname3; ?>" rows="20" cols="100%"><?php echo $get_value3; ?></textarea></td>
        </tr>
        <tr>
            <th>画像1</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname4 ?>" value="<?php echo esc_attr($get_value4); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value4) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value4); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>画像2</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname5 ?>" value="<?php echo esc_attr($get_value5); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value5) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value5); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>画像3</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname6 ?>" value="<?php echo esc_attr($get_value6); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value6) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value6); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>画像4</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname7 ?>" value="<?php echo esc_attr($get_value7); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value7) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value7); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>画像5</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname8 ?>" value="<?php echo esc_attr($get_value8); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value8) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value8); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* Future nega - フューチャー（ネガ）
/* ----------------------------- */

function service_future_negative_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_future_negative_title';
    $keyname2 = 'service_future_negative_content';
    $keyname3 = 'service_future_negative_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);
    $get_value3 = get_post_meta($post->ID, $keyname3, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
    wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

    // HTMLの出力
    ?> 
    <table class="form-table">
        <tr>
            <th>キャッチコピー</th>
            <td><textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea></td>
        </tr>
        <tr>
            <th>説明文</th>
            <td><textarea name="<?php echo $keyname2; ?>" rows="5" cols="100%"><?php echo $get_value2; ?></textarea></td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value3) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* Concept - コンセプト
/* ----------------------------- */

function service_concept_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_concept_content';
    $keyname2 = 'service_concept_main_image1';
    $keyname3 = 'service_concept_main_image2';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);
    $get_value3 = get_post_meta($post->ID, $keyname3, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
    wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td><textarea name="<?php echo $keyname1; ?>" rows="5" cols="100%"><?php echo $get_value1; ?></textarea></td>
        </tr>
        <tr>
            <th>画像1</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname2 ?>" value="<?php echo esc_attr($get_value2); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value2) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value2); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>画像2</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value3) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* セクション - ターゲット
/* ----------------------------- */

function service_target_callback($post) {
    global $post;

    /*	カード
    /* ----------------------------- */

    for ($i = 1; $i <= 5; $i++){
    // キーの設定
    $keyname = 'service_target_card'.$i.'_title';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <fieldset class="form-wrapper">
        <legend>カード<?php echo $i; ?></legend>
        <table class="form-table">
            <tr>
                <th>タイトル</th>
                <td><textarea name="<?php echo $keyname; ?>" rows="3" cols="100%"><?php echo $get_value; ?></textarea></td>
            </tr>
        </table>
    </fieldset>
    <?php
    }

    /*	ターゲット画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_target_main_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力
    ?>
    <table class="form-table">
        <tr>
            <th>スライダー下画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname ?>" value="<?php echo esc_attr($get_value); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* セクション - 特長
/* ----------------------------- */

function service_feature_callback($post) {
    global $post;

    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_feature_card'.$i.'_title';
        $keyname2 = 'service_feature_card'.$i.'_content';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td><textarea name="<?php echo $keyname1; ?>" rows="2" cols="100%"><?php echo $get_value1; ?></textarea></td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td><textarea name="<?php echo $keyname2; ?>" rows="5" cols="100%"><?php echo $get_value2; ?></textarea></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* セクション - メリット
/* ----------------------------- */

function service_merit_callback($post) {
    global $post;

    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_merit_card'.$i.'_title';
        $keyname2 = 'service_merit_card'.$i.'_content';
        $keyname3 = 'service_merit_card'.$i.'_image';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);
        $get_value3 = get_post_meta($post->ID, $keyname3, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
        wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td><input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="80"></td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td><textarea name="<?php echo $keyname2; ?>" rows="3" cols="100%"><?php echo $get_value2; ?></textarea></td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <fieldset class="my_uploader">
                            <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                            <div class="current_img">
                                <?php
                                if ($get_value3) {
                                ?>
                                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                                <p><a href="#" class="remove_img">画像を削除</a></p>
                                <?php
                                } else {
                                ?>
                                <a href="#" class="select_img">画像を設定</a>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* セクション - デメリット
/* ----------------------------- */

function service_demerit_callback($post) {
    global $post;

    for ($i = 1; $i <= 3; $i++){

        $keyname1 = 'service_demerit'.$i.'_title';
        $keyname2 = 'service_demerit'.$i.'_content';
        $keyname3 = 'service_demerit'.$i.'_image';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);
        $get_value3 = get_post_meta($post->ID, $keyname3, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
        wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td><input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="80"></td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td><textarea name="<?php echo $keyname2; ?>" rows="3" cols="100%"><?php echo $get_value2; ?></textarea></td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <fieldset class="my_uploader">
                            <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                            <div class="current_img">
                                <?php
                                if ($get_value3) {
                                ?>
                                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                                <p><a href="#" class="remove_img">画像を削除</a></p>
                                <?php
                                } else {
                                ?>
                                <a href="#" class="select_img">画像を設定</a>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* セクション - フューチャー（ポジ）
/* ----------------------------- */

function service_future_positive_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_future_positive_title';
    $keyname2 = 'service_future_positive_content';
    $keyname3 = 'service_future_positive_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);
    $get_value3 = get_post_meta($post->ID, $keyname3, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
    wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

    // HTMLの出力
    ?> 
    <table class="form-table">
        <tr>
            <th>キャッチコピー</th>
            <td>
                <textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname2; ?>" rows="5" cols="100%"><?php echo $get_value2; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value3) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* セクション - 価格
/* ----------------------------- */

function service_price_callback($post) {
    global $post;

    /*	説明文
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_price_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname; ?>" rows="5" cols="100%"><?php echo $get_value; ?></textarea>
            </td>
        </tr>
    </table>
    <?php

    /*	カード
    /* ----------------------------- */

    for ($i = 1; $i <= 8; $i++){

        // キーの設定
        $keyname1 = 'service_price_card'.$i.'_hashtag';
        $keyname2 = 'service_price_card'.$i.'_title';
        $keyname3 = 'service_price_card'.$i.'_content';
        $keyname4 = 'service_price_card'.$i.'_image';
        $keyname5 = 'service_price_card'.$i.'_detail1_item_name';
        $keyname6 = 'service_price_card'.$i.'_detail1_item_content';
        $keyname7 = 'service_price_card'.$i.'_detail2_item_name';
        $keyname8 = 'service_price_card'.$i.'_detail2_item_content';
        $keyname9 = 'service_price_card'.$i.'_detail3_item_name';
        $keyname10 = 'service_price_card'.$i.'_detail3_item_content';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);
        $get_value3 = get_post_meta($post->ID, $keyname3, true);
        $get_value4 = get_post_meta($post->ID, $keyname4, true);
        $get_value5 = get_post_meta($post->ID, $keyname5, true);
        $get_value6 = get_post_meta($post->ID, $keyname6, true);
        $get_value7 = get_post_meta($post->ID, $keyname7, true);
        $get_value8 = get_post_meta($post->ID, $keyname8, true);
        $get_value9 = get_post_meta($post->ID, $keyname9, true);
        $get_value10 = get_post_meta($post->ID, $keyname10, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
        wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);
        wp_nonce_field('action-'.$keyname4, 'nonce-'.$keyname4);
        wp_nonce_field('action-'.$keyname5, 'nonce-'.$keyname5);
        wp_nonce_field('action-'.$keyname6, 'nonce-'.$keyname6);
        wp_nonce_field('action-'.$keyname7, 'nonce-'.$keyname7);
        wp_nonce_field('action-'.$keyname8, 'nonce-'.$keyname8);
        wp_nonce_field('action-'.$keyname9, 'nonce-'.$keyname9);
        wp_nonce_field('action-'.$keyname10, 'nonce-'.$keyname10);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>ハッシュタグ</th>
                    <td>
                        <input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="80">
                    </td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td>
                        <input type="text" name="<?php echo $keyname2; ?>" value="<?php echo $get_value2; ?>" size="80">
                    </td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td>
                        <textarea name="<?php echo $keyname3; ?>" rows="5" cols="100%"><?php echo $get_value3; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <fieldset class="my_uploader">
                            <input type="hidden" name="<?php echo $keyname4 ?>" value="<?php echo esc_attr($get_value4); ?>" />
                            <div class="current_img">
                                <?php
                                if ($get_value4) {
                                ?>
                                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value4); ?>"></a>
                                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                                <p><a href="#" class="remove_img">画像を削除</a></p>
                                <?php
                                } else {
                                ?>
                                <a href="#" class="select_img">画像を設定</a>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th>詳細1</th>
                    <td><input type="text" name="<?php echo $keyname5; ?>" value="<?php echo $get_value5; ?>" size="20" placeholder="項目名"> <input type="text" name="<?php echo $keyname6; ?>" value="<?php echo $get_value6; ?>" size="50" placeholder="内容"></td>
                </tr>
                <tr>
                    <th>詳細2</th>
                    <td><input type="text" name="<?php echo $keyname7; ?>" value="<?php echo $get_value7; ?>" size="20" placeholder="項目名"> <input type="text" name="<?php echo $keyname8; ?>" value="<?php echo $get_value8; ?>" size="50" placeholder="内容"></td>
                </tr>
                <tr>
                    <th>詳細3</th>
                    <td><input type="text" name="<?php echo $keyname9; ?>" value="<?php echo $get_value9; ?>" size="20" placeholder="項目名"> <input type="text" name="<?php echo $keyname10; ?>" value="<?php echo $get_value10; ?>" size="50" placeholder="内容"></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }

}

/* ----------------------------- */

/* セクション - 事例
/* ----------------------------- */

function service_case_callback($post) {
    global $post;

    /*	説明文
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_case_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname; ?>" rows="10" cols="100%"><?php echo $get_value; ?></textarea>
            </td>
        </tr>
    </table>
    <?php
    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_case_card'.$i.'_title';
        $keyname2 = 'service_case_card'.$i.'_content';
        $keyname3 = 'service_case_card'.$i.'_image';
        $keyname4 = 'service_case_card'.$i.'_detail1';
        $keyname5 = 'service_case_card'.$i.'_detail2';
        $keyname6 = 'service_case_card'.$i.'_detail3';
        $keyname7 = 'service_case_card'.$i.'_detail4';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);
        $get_value3 = get_post_meta($post->ID, $keyname3, true);
        $get_value4 = get_post_meta($post->ID, $keyname4, true);
        $get_value5 = get_post_meta($post->ID, $keyname5, true);
        $get_value6 = get_post_meta($post->ID, $keyname6, true);
        $get_value7 = get_post_meta($post->ID, $keyname7, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
        wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);
        wp_nonce_field('action-'.$keyname4, 'nonce-'.$keyname4);
        wp_nonce_field('action-'.$keyname5, 'nonce-'.$keyname5);
        wp_nonce_field('action-'.$keyname6, 'nonce-'.$keyname6);
        wp_nonce_field('action-'.$keyname7, 'nonce-'.$keyname7);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td>
                        <input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="50">
                    </td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td>
                        <textarea name="<?php echo $keyname2; ?>" rows="5" cols="100%"><?php echo $get_value2; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td>
                        <fieldset class="my_uploader">
                            <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                            <div class="current_img">
                                <?php
                                if ($get_value3) {
                                ?>
                                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                                <p><a href="#" class="remove_img">画像を削除</a></p>
                                <?php
                                } else {
                                ?>
                                <a href="#" class="select_img">画像を設定</a>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th>タイプ</th>
                    <td>
                        <input type="text" name="<?php echo $keyname4; ?>" value="<?php echo $get_value4; ?>" size="50">
                    </td>
                </tr>
                <tr>
                    <th>制作期間</th>
                    <td>
                        <input type="text" name="<?php echo $keyname5; ?>" value="<?php echo $get_value5; ?>" size="50">
                    </td>
                </tr>
                <tr>
                    <th>担当</th>
                    <td>
                        <input type="text" name="<?php echo $keyname6; ?>" value="<?php echo $get_value6; ?>" size="50">
                    </td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td>
                        <input type="text" name="<?php echo $keyname7; ?>" value="<?php echo $get_value7; ?>" size="100">
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* セクション - フロー
/* ----------------------------- */

function service_flow_callback($post) {
    global $post;

    /*	説明文
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_flow_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname; ?>" rows="10" cols="100%"><?php echo $get_value; ?></textarea>
            </td>
        </tr>
    </table>
    <?php

    for ($i = 1; $i <= 10; $i++){

        // キーの設定
        $keyname1 = 'service_flow_card'.$i.'_title';
        $keyname2 = 'service_flow_card'.$i.'_content';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>ステップ<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td>
                        <input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="50">
                    </td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td>
                        <textarea name="<?php echo $keyname2; ?>" rows="3" cols="100%"><?php echo $get_value2; ?></textarea>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* セクション - サポート
/* ----------------------------- */

function service_support_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_support_content';
    $keyname2 = 'service_support_main_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);


    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname1; ?>" rows="5" cols="100%"><?php echo $get_value1; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>メイン画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname2 ?>" value="<?php echo esc_attr($get_value2); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value2) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value2); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php

    /*	カード
    /* ----------------------------- */
    for ($i = 1; $i <= 5; $i++){

        // キーの設定
        $keyname = 'service_support_card'.$i.'_title';

        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta($post->ID, $keyname, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>カード<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td>
                        <input type="text" name="<?php echo $keyname; ?>" value="<?php echo $get_value; ?>" size="50">
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }

    /*	画像
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_support_sub_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力
    ?>
    <table class="form-table">
        <tr>
            <th>スライダー下画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname ?>" value="<?php echo esc_attr($get_value); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* Q&A - よくあるご質問
/* ----------------------------- */

function service_faq_callback($post) {
    global $post;

    /*	説明文
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_faq_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname; ?>" rows="10" cols="100%"><?php echo $get_value; ?></textarea>
            </td>
        </tr>
    </table>
    <?php

    /*	カード
    /* ----------------------------- */

    for ($i = 1; $i <= 10; $i++){

        // キーの設定
        $keyname1 = 'service_faq_card'.$i.'_title';
        $keyname2 = 'service_faq_card'.$i.'_content';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>質問<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>質問内容</th>
                    <td>
                        <input type="text" name="<?php echo $keyname1; ?>" value="<?php echo $get_value1; ?>" size="100">
                    </td>
                </tr>
                <tr>
                    <th>回答</th>
                    <td>
                        <textarea name="<?php echo $keyname2; ?>" rows="8" cols="100%"><?php echo $get_value2; ?></textarea>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* Special Offer - 特典
/* ----------------------------- */

function service_special_offer_callback($post) {
    global $post;

    for ($i = 1; $i <= 6; $i++){

        $keyname1 = 'service_special_offer_card'.$i.'_title';
        $keyname2 = 'service_special_offer_card'.$i.'_content';
        $keyname3 = 'service_special_offer_card'.$i.'_image';

        // 保存されているカスタムフィールドの値を取得
        $get_value1 = get_post_meta($post->ID, $keyname1, true);
        $get_value2 = get_post_meta($post->ID, $keyname2, true);
        $get_value3 = get_post_meta($post->ID, $keyname3, true);

        // nonceの追加
        wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
        wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
        wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

        // HTMLの出力  
        ?>
        <fieldset class="form-wrapper">
            <legend>特典<?php echo $i; ?></legend>
            <table class="form-table">
                <tr>
                    <th>タイトル</th>
                    <td>
                        <textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td>
                        <textarea name="<?php echo $keyname2; ?>" rows="5" cols="100%"><?php echo $get_value2; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td>
                        <fieldset class="my_uploader">
                            <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                            <div class="current_img">
                                <?php
                                if ($get_value3) {
                                ?>
                                <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                                <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                                <p><a href="#" class="remove_img">画像を削除</a></p>
                                <?php
                                } else {
                                ?>
                                <a href="#" class="select_img">画像を設定</a>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/* ----------------------------- */

/* Summarize - まとめ
/* ----------------------------- */

function service_summarize_callback($post) {
    global $post;

    /*	画像
    /* ----------------------------- */

    // キーの設定
    $keyname1 = 'service_summarize_title';
    $keyname2 = 'service_summarize_content';
    $keyname3 = 'service_summarize_image';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);
    $get_value3 = get_post_meta($post->ID, $keyname3, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);
    wp_nonce_field('action-'.$keyname3, 'nonce-'.$keyname3);

    // HTMLの出力
    ?> 
    <table class="form-table">
        <tr>
            <th>キャッチコピー</th>
            <td>
                <textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname2; ?>" rows="10" cols="100%"><?php echo $get_value2; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname3 ?>" value="<?php echo esc_attr($get_value3); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value3) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value3); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* CTA - 行動喚起
/* ----------------------------- */

function service_cta_callback($post) {
    global $post;

    // キーの設定
    $keyname = 'service_cta_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta($post->ID, $keyname, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname, 'nonce-'.$keyname);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname; ?>" rows="10" cols="100%"><?php echo $get_value; ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* ps - 追伸
/* ----------------------------- */

function service_ps_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_ps_title';
    $keyname2 = 'service_ps_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

    // HTMLの出力  
    ?>
    <table class="form-table">
        <tr>
            <th>キャッチコピー</th>
            <td>
                <textarea name="<?php echo $keyname1; ?>" rows="3" cols="100%"><?php echo $get_value1; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname2; ?>" rows="10" cols="100%"><?php echo $get_value2; ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/* ----------------------------- */

/* Profile - プロフィール
/* ----------------------------- */

function service_profile_callback($post) {
    global $post;

    // キーの設定
    $keyname1 = 'service_profile_image';
    $keyname2 = 'service_profile_content';

    // 保存されているカスタムフィールドの値を取得
    $get_value1 = get_post_meta($post->ID, $keyname1, true);
    $get_value2 = get_post_meta($post->ID, $keyname2, true);

    // nonceの追加
    wp_nonce_field('action-'.$keyname1, 'nonce-'.$keyname1);
    wp_nonce_field('action-'.$keyname2, 'nonce-'.$keyname2);

    // HTMLの出力
    ?> 
    <table class="form-table">
        <tr>
            <th>画像</th>
            <td>
                <fieldset class="my_uploader">
                    <input type="hidden" name="<?php echo $keyname1 ?>" value="<?php echo esc_attr($get_value1); ?>" />
                    <div class="current_img">
                        <?php
                        if ($get_value1) {
                        ?>
                        <a href="#" class="select_img"><img src="<?php echo esc_attr($get_value1); ?>"></a>
                        <p class="hide-if-no-js howto">編集または更新する画像をクリック</p>
                        <p><a href="#" class="remove_img">画像を削除</a></p>
                        <?php
                        } else {
                        ?>
                        <a href="#" class="select_img">画像を設定</a>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>説明文</th>
            <td>
                <textarea name="<?php echo $keyname2; ?>" rows="10" cols="100%"><?php echo $get_value2; ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/* -------------------------------------------------------------------------- */

/*	カスタムフィールドの保存設定
/* -------------------------------------------------------------------------- */

function my_save_post_meta($post_id) {

/* ----------------------------- */
/*	シングルぺージ（Service）
/* ----------------------------- */

    /*	ヘッダー - タイトル
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_header_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    
    /*	ヘッダー - メインコピー
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_header_main_copy';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    
    /*	ヘッダー - 画像
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_header_image1';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    // キーの設定
    $keyname = 'service_header_image2';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    // キーの設定
    $keyname = 'service_header_image3';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    // キーの設定
    $keyname = 'service_header_image4';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    // キーの設定
    $keyname = 'service_header_image5';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	ヘッダー - エピソード
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_header_episode';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	フューチャー（ネガ） - キャッチコピー
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_negative_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	フューチャー（ネガ） - 画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_negative_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	フューチャー（ネガ） - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_negative_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	コンセプト - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_concept_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }


    /*	コンセプト - 画像
    /* ----------------------------- */

    for ($i = 1; $i <= 2; $i++){

        // キーの設定
        $keyname = 'service_concept_main_image'.$i;

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }

    }

    /*	ターゲット（カード） 
    /* ----------------------------- */

    for ($i = 1; $i <= 5; $i++){

        // キーの設定
        $keyname = 'service_target_card'.$i.'_title';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }

    }

    /*	ターゲット（画像） 
    /* ----------------------------- */

    // キーの設定
    $keyname = 'service_target_main_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	メリット（カード） 
    /* ----------------------------- */
    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_merit_card'.$i.'_title';
        $keyname2 = 'service_merit_card'.$i.'_content';
        $keyname3 = 'service_merit_card'.$i.'_image';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname3] ) && $_POST['nonce-'.$keyname3] ) {
            if ( check_admin_referer( 'action-'.$keyname3, 'nonce-'.$keyname3 ) ) {

                if( isset( $_POST[$keyname3] ) && $_POST[$keyname3] ) {
                    update_post_meta( $post_id, $keyname3, $_POST[$keyname3] );
                } else {
                    delete_post_meta( $post_id, $keyname3, get_post_meta( $post_id, $keyname3, true ) );
                }
            }
        }
    }

    for ($i = 1; $i <= 3; $i++){

        // キーの設定
        $keyname1 = 'service_demerit'.$i.'_title';
        $keyname2 = 'service_demerit'.$i.'_content';
        $keyname3 = 'service_demerit'.$i.'_image';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname3] ) && $_POST['nonce-'.$keyname3] ) {
            if ( check_admin_referer( 'action-'.$keyname3, 'nonce-'.$keyname3 ) ) {

                if( isset( $_POST[$keyname3] ) && $_POST[$keyname3] ) {
                    update_post_meta( $post_id, $keyname3, $_POST[$keyname3] );
                } else {
                    delete_post_meta( $post_id, $keyname3, get_post_meta( $post_id, $keyname3, true ) );
                }
            }
        }
    }

    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_feature_card'.$i.'_title';
        $keyname2 = 'service_feature_card'.$i.'_content';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
    }

    /*	フューチャー（ポジ） - 画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_positive_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	フューチャー（ポジ） - キャッチコピー
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_positive_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	フューチャー（ポジ） - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_future_positive_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	Price - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_price_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	タイプ- カード
    /* ----------------------------- */
    for ($i = 1; $i <= 8; $i++){

        // キーの設定
        $keyname1 = 'service_price_card'.$i.'_hashtag';
        $keyname2 = 'service_price_card'.$i.'_title';
        $keyname3 = 'service_price_card'.$i.'_content';
        $keyname4 = 'service_price_card'.$i.'_image';
        $keyname5 = 'service_price_card'.$i.'_detail1_item_name';
        $keyname6 = 'service_price_card'.$i.'_detail1_item_content';
        $keyname7 = 'service_price_card'.$i.'_detail2_item_name';
        $keyname8 = 'service_price_card'.$i.'_detail2_item_content';
        $keyname9 = 'service_price_card'.$i.'_detail3_item_name';
        $keyname10 = 'service_price_card'.$i.'_detail3_item_content';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname3] ) && $_POST['nonce-'.$keyname3] ) {
            if ( check_admin_referer( 'action-'.$keyname3, 'nonce-'.$keyname3 ) ) {

                if( isset( $_POST[$keyname3] ) && $_POST[$keyname3] ) {
                    update_post_meta( $post_id, $keyname3, $_POST[$keyname3] );
                } else {
                    delete_post_meta( $post_id, $keyname3, get_post_meta( $post_id, $keyname3, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname4] ) && $_POST['nonce-'.$keyname4] ) {
            if ( check_admin_referer( 'action-'.$keyname4, 'nonce-'.$keyname4 ) ) {

                if( isset( $_POST[$keyname4] ) && $_POST[$keyname4] ) {
                    update_post_meta( $post_id, $keyname4, $_POST[$keyname4] );
                } else {
                    delete_post_meta( $post_id, $keyname4, get_post_meta( $post_id, $keyname4, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname5] ) && $_POST['nonce-'.$keyname5] ) {
            if ( check_admin_referer( 'action-'.$keyname5, 'nonce-'.$keyname5 ) ) {

                if( isset( $_POST[$keyname5] ) && $_POST[$keyname5] ) {
                    update_post_meta( $post_id, $keyname5, $_POST[$keyname5] );
                } else {
                    delete_post_meta( $post_id, $keyname5, get_post_meta( $post_id, $keyname5, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname6] ) && $_POST['nonce-'.$keyname6] ) {
            if ( check_admin_referer( 'action-'.$keyname6, 'nonce-'.$keyname6 ) ) {

                if( isset( $_POST[$keyname6] ) && $_POST[$keyname6] ) {
                    update_post_meta( $post_id, $keyname6, $_POST[$keyname6] );
                } else {
                    delete_post_meta( $post_id, $keyname6, get_post_meta( $post_id, $keyname6, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname7] ) && $_POST['nonce-'.$keyname7] ) {
            if ( check_admin_referer( 'action-'.$keyname7, 'nonce-'.$keyname7 ) ) {

                if( isset( $_POST[$keyname7] ) && $_POST[$keyname7] ) {
                    update_post_meta( $post_id, $keyname7, $_POST[$keyname7] );
                } else {
                    delete_post_meta( $post_id, $keyname7, get_post_meta( $post_id, $keyname7, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname8] ) && $_POST['nonce-'.$keyname8] ) {
            if ( check_admin_referer( 'action-'.$keyname8, 'nonce-'.$keyname8 ) ) {

                if( isset( $_POST[$keyname8] ) && $_POST[$keyname8] ) {
                    update_post_meta( $post_id, $keyname8, $_POST[$keyname8] );
                } else {
                    delete_post_meta( $post_id, $keyname8, get_post_meta( $post_id, $keyname8, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname9] ) && $_POST['nonce-'.$keyname9] ) {
            if ( check_admin_referer( 'action-'.$keyname9, 'nonce-'.$keyname9 ) ) {

                if( isset( $_POST[$keyname9] ) && $_POST[$keyname9] ) {
                    update_post_meta( $post_id, $keyname9, $_POST[$keyname9] );
                } else {
                    delete_post_meta( $post_id, $keyname9, get_post_meta( $post_id, $keyname9, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname10] ) && $_POST['nonce-'.$keyname10] ) {
            if ( check_admin_referer( 'action-'.$keyname10, 'nonce-'.$keyname10 ) ) {

                if( isset( $_POST[$keyname10] ) && $_POST[$keyname10] ) {
                    update_post_meta( $post_id, $keyname10, $_POST[$keyname10] );
                } else {
                    delete_post_meta( $post_id, $keyname10, get_post_meta( $post_id, $keyname10, true ) );
                }
            }
        }
    }

    
    /*	事例 - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_case_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	事例 - カード
    /* ----------------------------- */
    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_case_card'.$i.'_title';
        $keyname2 = 'service_case_card'.$i.'_content';
        $keyname3 = 'service_case_card'.$i.'_image';
        $keyname4 = 'service_case_card'.$i.'_detail1';
        $keyname5 = 'service_case_card'.$i.'_detail2';
        $keyname6 = 'service_case_card'.$i.'_detail3';
        $keyname7 = 'service_case_card'.$i.'_detail4';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname3] ) && $_POST['nonce-'.$keyname3] ) {
            if ( check_admin_referer( 'action-'.$keyname3, 'nonce-'.$keyname3 ) ) {

                if( isset( $_POST[$keyname3] ) && $_POST[$keyname3] ) {
                    update_post_meta( $post_id, $keyname3, $_POST[$keyname3] );
                } else {
                    delete_post_meta( $post_id, $keyname3, get_post_meta( $post_id, $keyname3, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname4] ) && $_POST['nonce-'.$keyname4] ) {
            if ( check_admin_referer( 'action-'.$keyname4, 'nonce-'.$keyname4 ) ) {

                if( isset( $_POST[$keyname4] ) && $_POST[$keyname4] ) {
                    update_post_meta( $post_id, $keyname4, $_POST[$keyname4] );
                } else {
                    delete_post_meta( $post_id, $keyname4, get_post_meta( $post_id, $keyname4, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname5] ) && $_POST['nonce-'.$keyname5] ) {
            if ( check_admin_referer( 'action-'.$keyname5, 'nonce-'.$keyname5 ) ) {

                if( isset( $_POST[$keyname5] ) && $_POST[$keyname5] ) {
                    update_post_meta( $post_id, $keyname5, $_POST[$keyname5] );
                } else {
                    delete_post_meta( $post_id, $keyname5, get_post_meta( $post_id, $keyname5, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname6] ) && $_POST['nonce-'.$keyname6] ) {
            if ( check_admin_referer( 'action-'.$keyname6, 'nonce-'.$keyname6 ) ) {

                if( isset( $_POST[$keyname6] ) && $_POST[$keyname6] ) {
                    update_post_meta( $post_id, $keyname6, $_POST[$keyname6] );
                } else {
                    delete_post_meta( $post_id, $keyname6, get_post_meta( $post_id, $keyname6, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname7] ) && $_POST['nonce-'.$keyname7] ) {
            if ( check_admin_referer( 'action-'.$keyname7, 'nonce-'.$keyname7 ) ) {

                if( isset( $_POST[$keyname7] ) && $_POST[$keyname7] ) {
                    update_post_meta( $post_id, $keyname7, $_POST[$keyname7] );
                } else {
                    delete_post_meta( $post_id, $keyname7, get_post_meta( $post_id, $keyname7, true ) );
                }
            }
        }
    }

    /*	フロー - 説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_flow_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* フロー - カード
    /* ----------------------------- */
    for ($i = 1; $i <= 10; $i++){

        // キーの設定
        $keyname1 = 'service_flow_card'.$i.'_title';
        $keyname2 = 'service_flow_card'.$i.'_content';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - サポート
    /* ----------------------------- */

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_support_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	メイン画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_support_main_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* スライダー
    /* ----------------------------- */
    for ($i = 1; $i <= 5; $i++){

        // キーの設定
        $keyname = 'service_support_card'.$i.'_title';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer( 'action-'.$keyname, 'nonce-'.$keyname ) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }

    }

    /*	スライダー下画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_support_sub_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - Q&A
    /* ----------------------------- */

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_faq_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* カード
    /* ----------------------------- */
    for ($i = 1; $i <= 10; $i++){

        // キーの設定
        $keyname1 = 'service_faq_card'.$i.'_title';
        $keyname2 = 'service_faq_card'.$i.'_content';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - 特典
    /* ----------------------------- */

    /* カード
    /* ----------------------------- */
    for ($i = 1; $i <= 6; $i++){

        // キーの設定
        $keyname1 = 'service_special_offer_card'.$i.'_title';
        $keyname2 = 'service_special_offer_card'.$i.'_content';
        $keyname3 = 'service_special_offer_card'.$i.'_image';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname3] ) && $_POST['nonce-'.$keyname3] ) {
            if ( check_admin_referer( 'action-'.$keyname3, 'nonce-'.$keyname3 ) ) {

                if( isset( $_POST[$keyname3] ) && $_POST[$keyname3] ) {
                    update_post_meta( $post_id, $keyname3, $_POST[$keyname3] );
                } else {
                    delete_post_meta( $post_id, $keyname3, get_post_meta( $post_id, $keyname3, true ) );
                }
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - まとめ
    /* ----------------------------- */
    
    /*	画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_summarize_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	キャッチコピー
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_summarize_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_summarize_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - CTA
    /* ----------------------------- */

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_cta_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }
    /* ----------------------------- */
    /*	セクション - 追伸
    /* ----------------------------- */
    
    /*	タイトル
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_ps_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_ps_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* ----------------------------- */
    /*	セクション - プロフィール
    /* ----------------------------- */
    
    /*	画像
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_profile_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /*	説明文
    /* ----------------------------- */
    
    // キーの設定
    $keyname = 'service_profile_content';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    /* ----------------------------- */
    /*	フロントぺージ（hero）
    /* ----------------------------- */
    
    for ($i = 1; $i <= 5; $i++){

        // キーの設定
        $keyname = 'hero_image'.$i;

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }

    }

    // ヘッダー画像 - メインコピー
    for ($i = 1; $i <= 3; $i++){

        // キーの設定
        $keyname = 'hero_copy'.$i;

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer('action-'.$keyname, 'nonce-'.$keyname) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }
    }

    /* ----------------------------- */
    /*	固定ぺージ（About）
    /* ----------------------------- */

    // キーの設定
    $keyname = 'profile_image';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer( 'action-'.$keyname, 'nonce-'.$keyname ) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }


    /* ----------------------------- */
    /*	固定ぺージ（Mission）
    /* ----------------------------- */

    for ($i = 1; $i <= 3; $i++){
        // キーの設定
        $keyname = 'mission_copy'.$i;

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer( 'action-'.$keyname, 'nonce-'.$keyname ) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }
    }

    // ミッション画像
    for ($i = 1; $i <= 5; $i++){
        // キーの設定
        $keyname = 'mission_image'.$i;

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
            if ( check_admin_referer( 'action-'.$keyname, 'nonce-'.$keyname ) ) {

                if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                    update_post_meta( $post_id, $keyname, $_POST[$keyname] );
                } else {
                    delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
                }
            }
        }
    }

    /* ----------------------------- */
    /*	固定ぺージ（About）
    /* ----------------------------- */

    // キーの設定
    $keyname = 'overview_title';

    // nonceのチェックと保存
    if ( isset( $_POST['nonce-'.$keyname] ) && $_POST['nonce-'.$keyname] ) {
        if ( check_admin_referer( 'action-'.$keyname, 'nonce-'.$keyname ) ) {

            if( isset( $_POST[$keyname] ) && $_POST[$keyname] ) {
                update_post_meta( $post_id, $keyname, $_POST[$keyname] );
            } else {
                delete_post_meta( $post_id, $keyname, get_post_meta( $post_id, $keyname, true ) );
            }
        }
    }

    for ($i = 1; $i <= 10; $i++){

        // キーの設定
        $keyname1 = 'overview_item'.$i.'_name';
        $keyname2 = 'overview_item'.$i.'_content';

        // nonceのチェックと保存
        if ( isset( $_POST['nonce-'.$keyname1] ) && $_POST['nonce-'.$keyname1] ) {
            if ( check_admin_referer( 'action-'.$keyname1, 'nonce-'.$keyname1 ) ) {

                if( isset( $_POST[$keyname1] ) && $_POST[$keyname1] ) {
                    update_post_meta( $post_id, $keyname1, $_POST[$keyname1] );
                } else {
                    delete_post_meta( $post_id, $keyname1, get_post_meta( $post_id, $keyname1, true ) );
                }
            }
        }
        if ( isset( $_POST['nonce-'.$keyname2] ) && $_POST['nonce-'.$keyname2] ) {
            if ( check_admin_referer( 'action-'.$keyname2, 'nonce-'.$keyname2 ) ) {

                if( isset( $_POST[$keyname2] ) && $_POST[$keyname2] ) {
                    update_post_meta( $post_id, $keyname2, $_POST[$keyname2] );
                } else {
                    delete_post_meta( $post_id, $keyname2, get_post_meta( $post_id, $keyname2, true ) );
                }
            }
        }
    }

}
add_action('save_post', 'my_save_post_meta');

/* -------------------------------------------------------------------------- */

/*	特定の固定ぺージのエディターの非表示
/* -------------------------------------------------------------------------- */

add_filter('use_block_editor_for_post', function($use_block_editor, $post) {
    if ($post->post_type == 'page'){
        if (in_array($post->post_name, ['hero'])){
            remove_post_type_support('page', 'editor');
            remove_post_type_support('page', 'thumbnail');
            return false;
        }
    }
    return $use_block_editor;
}, 10, 2);

/* ========================================================================== */

/*	出力されるタイトル名の変更
/* ========================================================================== */

add_filter('get_the_archive_title', function($title) {
    if ( is_category() ) {

        $title = single_cat_title( '', false );

    } elseif ( is_tag() ) {

        $title = single_tag_title( '', false );

	} elseif ( is_tax() ) {

	    $title = single_term_title( '', false );

	} elseif ( is_post_type_archive() ){

		$title = post_type_archive_title( '', false);

	} elseif ( is_date() ) {

	    $title = get_the_time( 'Y年n月' );

	} elseif ( is_search() ) {

	    $title = '検索結果：'.esc_html( get_search_query(false) );

	} elseif ( is_404() ) {

	    $title = 'ページが見つかりません';

	}
    return $title;
});

/* ========================================================================== */

/*	投稿URLの自動生成（ランダム化）
/* ========================================================================== */

function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if (get_post_type() == 'blog' || get_post_type() == 'hero' || get_post_type() == 'news' || get_post_type() == 'work'){
        $str = md5( $post_ID );
        $str = base64_encode(pack( 'H*', $str ));
        $str = str_replace( '+', '', $str );
        $str = str_replace( '/', '', $str );
        $slug = substr( $str, 0, 10 );
        $slug = strtolower( $slug );
    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4 );

/* ========================================================================== */

/*	画像アップロード時の自動リサイズ設定
/* ========================================================================== */

function uplode_image_size_setup() {
    add_image_size( '1024x1024', 1024, 1024);
    add_image_size( '1536x1536', 1536, 1536);
    add_image_size( '2048x2048', 2048, 2048);
}
add_action( 'after_setup_theme', 'uplode_image_size_setup' );

/* ========================================================================== */

/*	アップロードファイルのリネーム（ランダム化）
/* ========================================================================== */

function rename_file_md5( $fileName ) {
    $i = strrpos($fileName, '.');
    if ($i) $Exts = '.'.substr( $fileName, $i + 1 );
    else $Exts = '';
    $fileName = md5( time().$fileName ).$Exts;
    return strtolower ($fileName );
}
add_filter('sanitize_file_name', 'rename_file_md5', 10);

/* ========================================================================== */

/*	Body要素へのクラス付与
/* ========================================================================== */

add_filter('body_class', 'add_page_slug_class_name');
function add_page_slug_class_name( $classes ) {
    if (is_page()){
        $page = get_post( get_the_ID() );
        $classes[] = $page->post_name;
    }
    return $classes;
}

/* ========================================================================== */

/*	All in One SEO翻訳修正
/* ========================================================================== */

add_filter( 'gettext', 'um_rename_messagetxt', 10, 3 );
function um_rename_messagetxt( $translation, $text, $domain ) {
    if ( 'all-in-one-seo-pack' === $domain ) {
        if ( 'Page' === $text ) {
            $translation = 'ぺージ';
        }
    }
    return $translation;
}

/* ========================================================================== */

/*	抜粋記号の変更
/* ========================================================================== */

function twpp_change_excerpt_more( $more ) {
    return '…';
}
add_filter( 'excerpt_more', 'twpp_change_excerpt_more' );

/* ========================================================================== */

/*	モバイルの判別
/* ========================================================================== */

function is_mobile() {
    $useragents = array(
      'iPhone',          // iPhone
      'iPod',            // iPod touch
      'Android',         // 1.5+ Android
      'dream',           // Pre 1.5 Android
      'CUPCAKE',         // 1.5+ Android
      'blackberry9500',  // Storm
      'blackberry9530',  // Storm
      'blackberry9520',  // Storm v2
      'blackberry9550',  // Storm v2
      'blackberry9800',  // Torch
      'webOS',           // Palm Pre Experimental
      'incognito',       // Other iPhone browser
      'webmate'          // Other iPhone browser
    );
    $pattern = '/'.implode( '|', $useragents ) . '/i';
    return preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] );
}

/* ========================================================================== */

/*	管理画面の一覧表示での画像表示
/* ========================================================================== */

add_filter( 'manage_posts_columns', 'add_custom_post_columns' );
add_filter( 'manage_pages_columns', 'add_custom_post_columns' );
if ( !function_exists( 'add_custom_post_columns' ) ) {
    function add_custom_post_columns( $columns ) {
        global $post_type;
        if ( in_array( $post_type, array( 'hero' ) ) ) {
            $columns['thumbnail'] = '画像';
        }
        return $columns;
    }
}
add_action( 'manage_posts_custom_column', 'output_custom_post_columns', 10, 2 );
add_action( 'manage_pages_custom_column', 'output_custom_post_columns', 10, 2 );
if ( !function_exists( 'output_custom_post_columns' ) ) {
    function output_custom_post_columns( $column_name, $post_id ) {
        if ( 'thumbnail' == $column_name ) {
            if ( $thumb_id ) {
                $thumb_img = wp_get_attachment_image_src( $thumb_id, 'small' );
                echo '<img src="',$thumb_img[0],'" width="150px" height="auto">';
            } elseif ( get_post_meta( $post_id, 'hero_image1' ) ) {
                $image_url = get_post_meta( $post_id, 'hero_image1', true );
                echo '<img src="'.$image_url.'" width="150px" height="auto">';
            } else {
                echo '画像が設定されていません';
            }
        }
    }
}

/* ========================================================================== */

/*	表示させないぺージのリダイレクト
/* ========================================================================== */

function specific_url_redirect(){
	if (in_array(wp_basename($_SERVER['REQUEST_URI']), ['hero'])){
		wp_redirect(home_url('/'), 301);
		exit;
	}
}
add_action( 'get_header', 'specific_url_redirect' );
