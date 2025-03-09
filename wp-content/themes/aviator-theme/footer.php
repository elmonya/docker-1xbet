    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-links">
                <div class="footer-column">
                    <h4><?php echo esc_html__('Menu', 'aviator-theme'); ?></h4>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'depth'          => 1,
                        )
                    );
                    ?>
                </div>
                
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h4><?php echo esc_html__('About Us', 'aviator-theme'); ?></h4>
                        <ul>
                            <li><a href="#"><?php echo esc_html__('About', 'aviator-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Contact', 'aviator-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Privacy Policy', 'aviator-theme'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h4><?php echo esc_html__('Games', 'aviator-theme'); ?></h4>
                        <ul>
                            <li><a href="#"><?php echo esc_html__('Aviator', 'aviator-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Casino', 'aviator-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Sports', 'aviator-theme'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <h4><?php echo esc_html__('Payment Methods', 'aviator-theme'); ?></h4>
                        <ul class="payment-list">
                            <li>Visa</li>
                            <li>MasterCard</li>
                            <li>Skrill</li>
                            <li>Neteller</li>
                            <li>Bitcoin</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div><!-- .footer-links -->
            
            <div class="footer-bottom">
                <div class="site-info">
                    <?php
                    /* translators: 1: Copyright, 2: Site name, 3: Current year. */
                    printf(esc_html__('© Copyright %1$s %2$s %3$s. All Rights Reserved.', 'aviator-theme'), '&copy;', get_bloginfo('name'), date('Y'));
                    ?>
                </div><!-- .site-info -->
                
                <div class="footer-disclaimer">
                    <p class="disclaimer-text">
                        <?php echo esc_html__('The information provided on this website is for entertainment purposes only. Gambling involves risk and you must not gamble with funds you cannot afford to lose.', 'aviator-theme'); ?>
                    </p>
                </div>
            </div><!-- .footer-bottom -->
        </div><!-- .container -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 