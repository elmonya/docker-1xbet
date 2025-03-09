<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'aviator-theme'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else :
                ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php
                    $aviator_description = get_bloginfo('description', 'display');
                    if ($aviator_description || is_customize_preview()) :
                    ?>
                        <p class="site-description"><?php echo $aviator_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="menu-toggle-bar"></span>
                    <span class="menu-toggle-bar"></span>
                    <span class="menu-toggle-bar"></span>
                </button>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu-list',
                        'container'      => false,
                    )
                );
                ?>
            </nav><!-- #site-navigation -->
            
            <div class="header-buttons">
                <a href="#login" class="login-button"><?php echo esc_html__('Entrar', 'aviator-theme'); ?></a>
                <a href="#register" class="register-button cta-button"><?php echo esc_html__('Registro', 'aviator-theme'); ?></a>
            </div>
        </div><!-- .container -->
    </header><!-- #masthead -->
