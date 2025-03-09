<?php
/**
 * The main template file
 *
 * @package Aviator_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

        <?php
        if (have_posts()) :
            /* Start the Loop */
            while (have_posts()) :
                the_post();
                
                get_template_part('template-parts/content', get_post_type());
                
            endwhile;

            the_posts_navigation();

        else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_sidebar();
get_footer(); 