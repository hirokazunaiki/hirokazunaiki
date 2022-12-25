
<?php get_header(); ?> 
    <main class="site-main archive">
        <header class="archive__header">
            <div class="archive__ttl fadeInTrigger">
                <span class="archive__ttl--en js_typing"><?php echo esc_html(get_post_type_object(get_post_type())->name); ?></span>
                <h1 class="archive__ttl--jp"><?php echo esc_html(get_post_type_object(get_post_type())->labels->name); ?></h1>
            </div>
        </header><?php
        if ( have_posts() ) {
        $post_type_name = get_post_type_object( get_post_type() )->name;
        $taxonomy_name = $post_type_name.'-category';
        if ( is_taxonomy_hierarchical($taxonomy_name) ){
        ?> 
        <nav class="sort-nav fadeRightTrigger">
            <ul class="sort-nav__menu">
                <li class="sort-nav__item<?php if ( !is_tax() ){echo ' current';} ?>"><a href="<?php echo esc_url(home_url('/')).$post_type_name; ?>" class="sort-nav__link">すべて</a></li><?php
                $taxonomy_terms = get_terms($taxonomy_name);
                foreach ($taxonomy_terms as $taxonomy_term) {
                ?> 
                <li class="sort-nav__item<?php if ($taxonomy_term->slug == $term){echo ' current';} ?>"><a href="<?php echo get_term_link($taxonomy_term->slug, $taxonomy_name)?>" class="sort-nav__link">#<?php echo $taxonomy_term->name; ?></a></li><?php
                }
                ?> 
            </ul>
        </nav><?php
        }
        ?> 
        <div class="archive__body">
            <div class="archive-cols-wrapper"><?php
                while ( have_posts() ) {
                the_post();
                ?> 
                <article class="archive-col fadeUpTrigger">
                    <a href="<?php the_permalink(); ?>" class="archive-col__link">
                        <div class="archive-col__img-wrapper"><?php
                            if ( has_post_thumbnail() ) { 
                            $attachment_id = get_post_thumbnail_id ($post->ID);
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
                            $image_attributes = wp_get_attachment_image_src ($attachment_id, $attachment_size);
                            if ($image_attributes) {
                            ?> 
                            <img class="archive-col__img" src="<?php echo $image_attributes[0]; ?>"><?php
                            }
                            } else {
                            ?> 
                            <div class="archive-col__img--noimage">No Images</div><?php
                            }

                            //Category
                            $post_type_name = get_post_type_object ( get_post_type() )->name;
                            $taxonomy_name = $post_type_name.'-category';
                            if ( is_taxonomy_hierarchical($taxonomy_name) ){
                            $taxonomy_terms = get_the_terms($post->ID, $taxonomy_name);
                            if ($taxonomy_terms){
                            ?> 
                            <div class="archive-col__cat-wrapper">
                                <div class="archive-col__cats"><?php
                                    foreach ($taxonomy_terms as $taxonomy_term) {
                                    ?> 
                                    <span class="archive-col__cat">#<?php echo $taxonomy_term->name; ?></span><?php
                                    }
                                ?> 
                                </div>
                            </div><?php
                            } else {
                            ?> 
                            <div class="archive-col__cat">No Category</div><?php
                            }
                            }
                            ?> 
                        </div>
                        <header class="archive-col__header">
                            <h2 class="archive-col__ttl"><?php
                            $max_text_size = '40';
                            if ( mb_strlen($post->post_title, 'UTF-8') > $max_text_size ) {
                                $title= mb_substr($post->post_title, 0, $max_text_size, 'UTF-8');
                                echo $title.'…';
                            } else {
                                echo $post->post_title;
                            }
                            ?></h2>
                        </header>
                        <div class="archive-col__body">
                            <div class="archive-col__txt-wrapper">
                                <div class="archive-col__txt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </article><?php
                }
                ?> 
            </div>
        </div><?php
        if (paginate_links()) {
        ?> 
        <nav class="pagination fadeInTrigger">
            <?php
            $pagination =paginate_links(array(
                'type' => 'list',
                'end_size' => '0',
                'mid_size' => '1',
                'prev_text' => '',
                'next_text' => '',
            ));
            echo str_replace(array("\r\n", "\r", "\n", "\t"), '', $pagination ); ?> 
        </nav><?php
        }
        }
        ?> 
    </main>
<?php get_footer(); ?>