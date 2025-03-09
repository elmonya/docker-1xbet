<?php
/**
 * Aviator Theme functions and definitions
 *
 * @package Aviator_Theme
 */

// Define theme constants
define('AVIATOR_THEME_VERSION', '1.0.0');
define('AVIATOR_THEME_DIR', get_template_directory());
define('AVIATOR_THEME_URI', get_template_directory_uri());

// Set up theme
function aviator_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'aviator-theme'),
        'footer' => esc_html__('Footer Menu', 'aviator-theme'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'aviator_theme_setup');

// Enqueue scripts and styles
function aviator_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('aviator-theme-style', get_stylesheet_uri(), array(), AVIATOR_THEME_VERSION);
    
    // Enqueue Google Fonts
    wp_enqueue_style('aviator-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap', array(), null);
    
    // Enqueue Font Awesome for icons
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');
    
    // Enqueue main JavaScript file
    wp_enqueue_script('aviator-theme-js', AVIATOR_THEME_URI . '/js/main.js', array('jquery'), AVIATOR_THEME_VERSION, true);
    
    // Add comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'aviator_theme_scripts');

// Register widget areas
function aviator_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'aviator-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'aviator-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'aviator-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('First footer widget area', 'aviator-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'aviator-theme'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Second footer widget area', 'aviator-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'aviator-theme'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Third footer widget area', 'aviator-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'aviator_theme_widgets_init');

/**
 * Custom template tags for this theme.
 */
require AVIATOR_THEME_DIR . '/includes/template-tags.php';

/**
 * Custom Shortcodes
 */
// Bonus Display Shortcode
function aviator_bonus_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Welcome Bonus Package',
        'percentage' => '450%',
        'freespins' => '425',
        'amount' => '6,000€',
        'deposits' => '4',
        'code' => '1x_2647364',
    ), $atts);
    
    $output = '<div class="bonus-section">';
    $output .= '<h3>' . esc_html($atts['title']) . '</h3>';
    $output .= '<p><strong>' . esc_html($atts['percentage']) . ' bonus + ' . esc_html($atts['freespins']) . ' FS</strong></p>';
    $output .= '<p>up to ' . esc_html($atts['amount']) . ' in first ' . esc_html($atts['deposits']) . ' deposits</p>';
    if (!empty($atts['code'])) {
        $output .= '<p class="bonus-code">BONUS CODE: <strong>' . esc_html($atts['code']) . '</strong></p>';
    }
    $output .= '<a href="#" class="cta-button">Claim Bonus</a>';
    $output .= '</div>';
    
    return $output;
}
add_shortcode('aviator_bonus', 'aviator_bonus_shortcode');

// Game Info Table Shortcode
function aviator_game_table_shortcode($atts, $content = null) {
    $output = '<div class="game-table-container">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('aviator_table', 'aviator_game_table_shortcode');

// Rating Display Shortcode
function aviator_rating_shortcode($atts) {
    $atts = shortcode_atts(array(
        'score' => '4.5',
        'max' => '5',
    ), $atts);
    
    $score = min(max(0, floatval($atts['score'])), floatval($atts['max']));
    $percentage = ($score / floatval($atts['max'])) * 100;
    
    $output = '<div class="rating-section">';
    $output .= '<div class="rating-stars">';
    $full_stars = floor($score);
    $half_star = $score - $full_stars > 0 ? 1 : 0;
    $empty_stars = floatval($atts['max']) - $full_stars - $half_star;
    
    for ($i = 0; $i < $full_stars; $i++) {
        $output .= '<i class="fas fa-star"></i>';
    }
    if ($half_star) {
        $output .= '<i class="fas fa-star-half-alt"></i>';
    }
    for ($i = 0; $i < $empty_stars; $i++) {
        $output .= '<i class="far fa-star"></i>';
    }
    
    $output .= '</div>';
    $output .= '<div class="rating-score">' . esc_html($atts['score']) . '/' . esc_html($atts['max']) . '</div>';
    $output .= '</div>';
    
    return $output;
}
add_shortcode('aviator_rating', 'aviator_rating_shortcode');

// FAQ Shortcode
function aviator_faq_shortcode($atts, $content = null) {
    $output = '<div class="faq-section">';
    $output .= '<h2>Frequently Asked Questions</h2>';
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('aviator_faq', 'aviator_faq_shortcode');

// FAQ Item Shortcode
function aviator_faq_item_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'question' => '',
    ), $atts);
    
    $output = '<div class="faq-item">';
    $output .= '<div class="faq-question">' . esc_html($atts['question']) . '</div>';
    $output .= '<div class="faq-answer">' . wp_kses_post($content) . '</div>';
    $output .= '</div>';
    
    return $output;
}
add_shortcode('aviator_faq_item', 'aviator_faq_item_shortcode');

// Register custom post type for Casino Games
function aviator_register_casino_game_post_type() {
    $labels = array(
        'name'                  => _x('Casino Games', 'Post type general name', 'aviator-theme'),
        'singular_name'         => _x('Casino Game', 'Post type singular name', 'aviator-theme'),
        'menu_name'             => _x('Casino Games', 'Admin Menu text', 'aviator-theme'),
        'name_admin_bar'        => _x('Casino Game', 'Add New on Toolbar', 'aviator-theme'),
        'add_new'               => __('Add New', 'aviator-theme'),
        'add_new_item'          => __('Add New Casino Game', 'aviator-theme'),
        'new_item'              => __('New Casino Game', 'aviator-theme'),
        'edit_item'             => __('Edit Casino Game', 'aviator-theme'),
        'view_item'             => __('View Casino Game', 'aviator-theme'),
        'all_items'             => __('All Casino Games', 'aviator-theme'),
        'search_items'          => __('Search Casino Games', 'aviator-theme'),
        'parent_item_colon'     => __('Parent Casino Games:', 'aviator-theme'),
        'not_found'             => __('No casino games found.', 'aviator-theme'),
        'not_found_in_trash'    => __('No casino games found in Trash.', 'aviator-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'casino-game'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'menu_icon'          => 'dashicons-games',
    );

    register_post_type('casino_game', $args);
}
add_action('init', 'aviator_register_casino_game_post_type');

// Register custom taxonomy for Game Categories
function aviator_register_game_category_taxonomy() {
    $labels = array(
        'name'              => _x('Game Categories', 'taxonomy general name', 'aviator-theme'),
        'singular_name'     => _x('Game Category', 'taxonomy singular name', 'aviator-theme'),
        'search_items'      => __('Search Game Categories', 'aviator-theme'),
        'all_items'         => __('All Game Categories', 'aviator-theme'),
        'parent_item'       => __('Parent Game Category', 'aviator-theme'),
        'parent_item_colon' => __('Parent Game Category:', 'aviator-theme'),
        'edit_item'         => __('Edit Game Category', 'aviator-theme'),
        'update_item'       => __('Update Game Category', 'aviator-theme'),
        'add_new_item'      => __('Add New Game Category', 'aviator-theme'),
        'new_item_name'     => __('New Game Category Name', 'aviator-theme'),
        'menu_name'         => __('Game Categories', 'aviator-theme'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'game-category'),
    );

    register_taxonomy('game_category', array('casino_game'), $args);
}
add_action('init', 'aviator_register_game_category_taxonomy'); 