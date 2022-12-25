
<?php get_header(); ?> 
    <main class="site-main archive">
        <header class="archive__header">
            <div class="archive__ttl fadeInTrigger">
                <span class="archive__ttl--en js_typing"><?php echo esc_html(get_post_type_object(get_post_type())->name); ?></span>
                <h1 class="archive__ttl--jp"><?php echo esc_html(get_post_type_object(get_post_type())->labels->name); ?></h1>
            </div>
        </header><?php
        if (have_posts()){
        $post_type_name = get_post_type_object(get_post_type())->name;
        $taxonomy_name = $post_type_name.'-category';
        if (is_taxonomy_hierarchical($taxonomy_name)){
        ?> 
        <nav class="sort-nav fadeRightTrigger">
            <ul class="sort-nav__menu">
                <li class="sort-nav__item<?php if (!is_tax()){echo ' current';} ?>"><a href="<?php echo esc_url(home_url('/')).$post_type_name; ?>" class="sort-nav__link">すべて</a></li><?php
                $taxonomy_terms = get_terms($taxonomy_name);
                foreach ($taxonomy_terms as $taxonomy_term) {
                ?> 
                <li class="sort-nav__item<?php if ($taxonomy_term->slug == $term){echo ' current';} ?>"><a href="<?php echo get_term_link($taxonomy_term->slug, $taxonomy_name)?>" class="sort-nav__link"><?php echo $taxonomy_term->name; ?></a></li><?php
                }
                ?> 
            </ul>
        </nav><?php
        }
        ?> 
        <div class="archive__body">
            <div class="fp-news fadeUpTrigger">
                <ul class="fp-news__list"><?php
                    while (have_posts()) {
                    the_post();
                    ?> 
                    <li class="fp-news__item">
                        <a href="<?php the_permalink(); ?>" class="fp-news__link">
                            <time class="fp-news__date"><?php the_time(get_option('date_format')); ?></time>
                            <h3 class="fp-news__ttl"><?php echo get_the_title(); ?></h3>
                        </a>
                    </li><?php
                    } ?> 
                </ul>
            </div><!-- /.fp-news -->
        </div><?php
        if ( paginate_links() ) {
        ?> 
        <nav class="pagination">
            <?php
            $pagination =paginate_links( array (
                'type' => 'list',
                'end_size' => '0',
                'mid_size' => '1',
                'prev_text' => '',
                'next_text' => '',
            ));
            echo str_replace( array("\r\n","\r","\n","\t"), '', $pagination ); ?> 
        </nav><?php
        }
        }
        ?> 
    </main>
<?php get_footer(); ?>