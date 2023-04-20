<?php get_header(); ?> 
    <main class="site-main">
        <article class="single-cont">
            <header class="single-cont__header">
                <div class="single-cont__ttl fadeInTrigger">
                    <span class="single-cont__ttl--en js_typing"><?php echo esc_html(get_post_type_object(get_post_type())->name); ?></span>
                    <h1 class="single-cont__ttl--jp"><?php echo get_the_title(); ?></h1>
                </div>
                <div class="single-cont__date"><time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time></div>
            </header>
            <div class="single-cont__body">
                <div class="single-cont__text-wrapper fadeUpTrigger">
                    <?php echo str_replace(array("\r\n", "\r", "\n", "\t", "<br />"), '', apply_filters('the_content', get_the_content())); ?> 
                </div>
            </div>
        </article>
    </main>
<?php get_footer(); ?>