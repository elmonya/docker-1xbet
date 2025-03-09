<?php
/**
 * Custom template tags for this theme
 *
 * @package Aviator_Theme
 */

if (!function_exists('aviator_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function aviator_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'aviator-theme'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('aviator_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function aviator_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'aviator-theme'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('aviator_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function aviator_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'aviator-theme'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'aviator-theme') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'aviator-theme'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'aviator-theme') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'aviator-theme'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'aviator-theme'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('aviator_display_bonus_promo')) :
    /**
     * Displays a bonus promotion section
     */
    function aviator_display_bonus_promo($title = 'Welcome Bonus Package', $percentage = '450%', $freespins = '425', $amount = '6,000€', $deposits = '4', $code = '1x_2647364') {
        ?>
        <div class="bonus-promo">
            <h3><?php echo esc_html($title); ?></h3>
            <div class="bonus-details">
                <p class="bonus-percentage"><?php echo esc_html($percentage); ?> + <?php echo esc_html($freespins); ?> FS</p>
                <p class="bonus-amount">up to <?php echo esc_html($amount); ?> in first <?php echo esc_html($deposits); ?> deposits</p>
                <?php if (!empty($code)) : ?>
                    <p class="bonus-code">BONUS CODE: <strong><?php echo esc_html($code); ?></strong></p>
                <?php endif; ?>
                <a href="#" class="cta-button">Claim Bonus</a>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('aviator_display_game_info')) :
    /**
     * Displays a game information section with key details
     */
    function aviator_display_game_info($game_name, $developer, $rtp, $volatility, $min_bet, $max_bet) {
        ?>
        <div class="game-info-box">
            <h3><?php echo esc_html($game_name); ?> Game Information</h3>
            <ul class="game-details-list">
                <li><strong>Developer:</strong> <?php echo esc_html($developer); ?></li>
                <li><strong>RTP:</strong> <?php echo esc_html($rtp); ?></li>
                <li><strong>Volatility:</strong> <?php echo esc_html($volatility); ?></li>
                <li><strong>Min. Bet:</strong> <?php echo esc_html($min_bet); ?></li>
                <li><strong>Max. Bet:</strong> <?php echo esc_html($max_bet); ?></li>
            </ul>
        </div>
        <?php
    }
endif;

if (!function_exists('aviator_payment_methods')) :
    /**
     * Displays payment methods
     */
    function aviator_payment_methods($methods = array()) {
        if (empty($methods)) {
            $methods = array(
                'Visa',
                'MasterCard',
                'Skrill',
                'Neteller',
                'Bitcoin',
                'Ethereum',
                'AstroPay'
            );
        }
        
        if (!empty($methods)) :
        ?>
        <div class="payment-methods">
            <h4><?php echo esc_html__('Payment Methods', 'aviator-theme'); ?></h4>
            <ul class="payment-list">
                <?php foreach ($methods as $method) : ?>
                <li><?php echo esc_html($method); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        endif;
    }
endif;

if (!function_exists('aviator_display_rating')) :
    /**
     * Displays a star rating
     */
    function aviator_display_rating($score = 4.5, $max = 5) {
        $score = min(max(0, floatval($score)), floatval($max));
        $full_stars = floor($score);
        $half_star = $score - $full_stars > 0 ? 1 : 0;
        $empty_stars = floatval($max) - $full_stars - $half_star;
        ?>
        <div class="rating-display">
            <div class="star-rating">
                <?php
                // Display full stars
                for ($i = 0; $i < $full_stars; $i++) {
                    echo '<i class="fas fa-star"></i>';
                }
                
                // Display half star if needed
                if ($half_star) {
                    echo '<i class="fas fa-star-half-alt"></i>';
                }
                
                // Display empty stars
                for ($i = 0; $i < $empty_stars; $i++) {
                    echo '<i class="far fa-star"></i>';
                }
                ?>
            </div>
            <span class="rating-score"><?php echo esc_html($score); ?>/<?php echo esc_html($max); ?></span>
        </div>
        <?php
    }
endif; 