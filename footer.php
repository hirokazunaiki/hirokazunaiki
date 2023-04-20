    <footer class="site-footer">
        <div class="site-footer__sitemap fadeUpTrigger">
            <div class="sitemap">
                <div class="sitemap__header">
                    <div class="footer-ttl">
                        <a class="footer-ttl__link" href="<?php echo esc_url(home_url('/')); ?>"><?php
                            if (has_custom_logo()) { 
                            $custom_logo_id = get_theme_mod('custom_logo'); 
                            $custom_logo_url = wp_get_attachment_image_src($custom_logo_id, 'large'); 
                            $logo_url = $custom_logo_url[0];
                            ?> 
                            <div class="site-header-ttl__logo-wrapper">
                                <img class="site-header-ttl__logo" src="<?php echo $logo_url; ?>">
                            </div><?php
                            } else {
                            ?> 
                            <div class="footer-ttl__typo"><?php bloginfo('title'); ?></div><?php  
                            }
                            ?> 
                        </a>
                    </div>
                </div>
                <div class="sitemap__body"><?php

                    // フッターメニュー
                    if(has_nav_menu('footer-menu')){
                    ?> 
                    <div class="sitemap-list">
                        <?php echo str_replace(array("\r\n", "\r", "\n", "\t"),'',wp_nav_menu (array('theme_location' => 'footer-menu', 'echo' => false, 'container' => false, 'items_wrap' => '<ul class="sitemap-list__menu">%3$s</ul>', 'add_li_class' => 'sitemap-list__item', 'add_a_class' => 'sitemap-list__link'))); ?> 
                    </div><?php
                    }

                    // SNSメニュー
                    if(has_nav_menu('sns-menu')){
                    ?> 
                    <div class="sitemap-sns-list">
                        <?php echo str_replace(array("\r\n", "\r", "\n", "\t"),'',wp_nav_menu (array('theme_location' => 'sns-menu', 'echo' => false, 'container' => false, 'items_wrap' => '<ul class="sitemap-sns-list__menu">%3$s</ul>', 'add_li_class' => 'sitemap-sns-list__item', 'add_a_class' => 'sitemap-sns-list__link'))); ?> 
                    </div><?php
                    }

                    ?> 
                </div>
            </div>
        </div>
        <div class="site-footer__copyright">
            <div class="copyright">&copy; <?php bloginfo('name'); ?>. All rights reserved.  ／ <a class="footer-copyright__link" href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy policy</a></div>
        </div>
    </footer>
    <div class="page-top"><a class="page-top__link" href="#"></a></div>
</div>
<?php wp_footer(); ?>
</body>
</html>