<?php get_header(); ?> 
    <main class="site-main">
        <article class="page-cont">
            <header class="page-cont__header">
                <div class="page-cont__ttl fadeInTrigger">
                    <span class="page-cont__ttl--en js_typing"><?php echo $post->post_name; ?></span>
                    <h1 class="page-cont__ttl--jp"><?php the_title(); ?></h1>
                </div>
            </header>
            <div class="page-cont__body">
                <div class="page-cont__text-wrapper fadeUpTrigger">
                    <div class="page-cont-caution">
                        <div class="page-cont-caution__header">
                            <h3 class="page-cont-caution__ttl">ご注意点</h3>
                        </div>
                        <div class="page-cont-caution__body">
                            <div class="page-cont-caution__txt-wrapper">
                                <p class="page-cont-caution__txt">「無料相談」とは、お客様がホームぺージ制作等の当方サービスにあたり気になる点やご質問等の回答など、主に不安解消の為に行うための簡易的なミーティングですのでお気軽にご相談ください。無料相談後、実際にホームぺージ制作を当方にご依頼いただく場合は、改めて別途ヒアリングの機会を設けさせていただきます。</p>
                            </div>
                        </div>
                    </div>
                    <?php echo str_replace(array("\r\n","\r","\n","\t","<br />"),'',apply_filters('the_content',get_the_content())); ?> 
                </div>
            </div>
        </article>
    </main>
<?php get_footer(); ?>