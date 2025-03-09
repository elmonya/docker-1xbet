/**
 * Main JavaScript file for Aviator Theme
 */
(function($) {
    'use strict';

    // Toggle mobile menu
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('active');
        
        // Анимация иконки гамбургера
        if ($(this).hasClass('active')) {
            $('.menu-toggle-bar:nth-child(1)').css('transform', 'rotate(45deg) translate(5px, 5px)');
            $('.menu-toggle-bar:nth-child(2)').css('opacity', '0');
            $('.menu-toggle-bar:nth-child(3)').css('transform', 'rotate(-45deg) translate(7px, -7px)');
        } else {
            $('.menu-toggle-bar').css({
                'transform': 'none',
                'opacity': '1'
            });
        }
    });

    // FAQ Accordions
    $('.faq-question').on('click', function() {
        const $item = $(this).parent();
        
        if ($item.hasClass('active')) {
            $item.removeClass('active');
            $(this).next('.faq-answer').slideUp(200);
        } else {
            $('.faq-item.active .faq-answer').slideUp(200);
            $('.faq-item.active').removeClass('active');
            $item.addClass('active');
            $(this).next('.faq-answer').slideDown(200);
        }
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            
            const target = $(this.hash);
            
            if(target.length) {
                const headerHeight = $('header').outerHeight();
                
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - headerHeight - 20
                }, 800, 'swing', function() {
                    // Добавляем хэш в URL после прокрутки
                    window.location.hash = target;
                });
            }
        }
    });

    // Initialize ratings
    function initRatings() {
        $('.rating-stars').each(function() {
            const score = parseFloat($(this).data('score') || $(this).attr('data-score') || 4.5);
            const max = parseFloat($(this).data('max') || $(this).attr('data-max') || 5);
            
            const fullStars = Math.floor(score);
            const halfStar = score - fullStars > 0 ? 1 : 0;
            const emptyStars = max - fullStars - halfStar;
            
            let starsHtml = '';
            
            // Full stars
            for (let i = 0; i < fullStars; i++) {
                starsHtml += '<i class="fas fa-star"></i>';
            }
            
            // Half star
            if (halfStar) {
                starsHtml += '<i class="fas fa-star-half-alt"></i>';
            }
            
            // Empty stars
            for (let i = 0; i < emptyStars; i++) {
                starsHtml += '<i class="far fa-star"></i>';
            }
            
            $(this).html(starsHtml);
        });
    }

    // Bonus code copy to clipboard
    $('.bonus-code').on('click', function() {
        const bonusCodeText = $(this).text().replace('BONUS CODE:', '').trim();
        
        // Создаем временный элемент ввода
        const tempInput = document.createElement('input');
        tempInput.style.position = 'absolute';
        tempInput.style.left = '-9999px';
        document.body.appendChild(tempInput);
        tempInput.value = bonusCodeText;
        tempInput.select();
        
        // Копируем текст в буфер обмена
        try {
            document.execCommand('copy');
            
            // Показываем уведомление
            const originalText = $(this).html();
            $(this).html('<span class="copied">Код скопирован!</span>');
            
            setTimeout(() => {
                $(this).html(originalText);
            }, 1500);
            
        } catch (err) {
            console.error('Не удалось скопировать код: ', err);
        }
        
        document.body.removeChild(tempInput);
    });

    // Анимация при прокрутке
    function animateOnScroll() {
        $('.fade-in').each(function() {
            const elementTop = $(this).offset().top;
            const elementVisible = 150;
            const windowHeight = $(window).height();
            const scrollTop = $(window).scrollTop();
            
            if (scrollTop > (elementTop - windowHeight + elementVisible)) {
                $(this).addClass('visible');
            }
        });
    }

    // Стикки хедер с анимацией
    let lastScrollTop = 0;
    
    function stickyHeader() {
        const scrollTop = $(window).scrollTop();
        const header = $('header');
        
        if (scrollTop > 100) {
            header.addClass('sticky');
            
            // Скрываем хедер при прокрутке вниз и показываем при прокрутке вверх
            if (scrollTop > lastScrollTop && scrollTop > 300) {
                header.addClass('hide');
            } else {
                header.removeClass('hide');
            }
        } else {
            header.removeClass('sticky');
        }
        
        lastScrollTop = scrollTop;
    }

    // Добавляем классы для анимации
    function setupAnimations() {
        $('.game-info h2, .payment-section h2, .rating-section h2, .faq-section h2').addClass('fade-in');
        $('.bonus-section, .cta-box, .game-table, .faq-item').addClass('fade-in');
    }

    // Запуск при загрузке документа
    $(document).ready(function() {
        initRatings();
        setupAnimations();
        animateOnScroll();
        
        // Добавляем CSS для анимации
        const animationCSS = `
            <style>
                .sticky {
                    background-color: rgba(16, 24, 32, 0.95);
                    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
                    transition: all 0.3s ease;
                }
                
                .hide {
                    transform: translateY(-100%);
                }
                
                .fade-in {
                    opacity: 0;
                    transform: translateY(30px);
                    transition: opacity 0.8s ease, transform 0.8s ease;
                }
                
                .fade-in.visible {
                    opacity: 1;
                    transform: translateY(0);
                }
                
                .copied {
                    display: inline-block;
                    background-color: var(--success-color);
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-size: 0.9rem;
                }
            </style>
        `;
        
        $('head').append(animationCSS);
    });

    // События при прокрутке
    $(window).on('scroll', function() {
        stickyHeader();
        animateOnScroll();
    });

    // События при изменении размера окна
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('.main-navigation').removeClass('active');
            $('.menu-toggle').removeClass('active');
            $('.menu-toggle-bar').css({
                'transform': 'none',
                'opacity': '1'
            });
        }
    });

})(jQuery); 