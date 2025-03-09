<?php
/**
 * The front page template file
 *
 * @package Aviator_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html__('Segredos do Popular jogo Aviator', 'aviator-theme'); ?></h1>
            <p class="hero-description">
                <?php echo esc_html__('O Aviator é um dos jogos mais emocionantes disponíveis, combinando simplicidade e adrenalina em uma experiência única.', 'aviator-theme'); ?>
            </p>
            <a href="#register" class="cta-button"><?php echo esc_html__('Registrar Agora', 'aviator-theme'); ?></a>
        </div>
    </section>

    <!-- Bonus Promo Section -->
    <section class="bonus-promo-section">
        <div class="container">
            <div class="bonus-card">
                <h2><?php echo esc_html__('Pacote de bônus de boas-vindas', 'aviator-theme'); ?></h2>
                <?php aviator_display_bonus_promo(); ?>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <article class="game-info">
                <h2><?php echo esc_html__('Entendendo O Jogo Aviador', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('O Aviator não é um caça-níqueis comum, pois não possui rolos, linhas de pagamento ou símbolos tradicionais. Trata-se de um jogo baseado na tecnologia Provably Fair (Comprovadamente Justo), garantindo que cada rodada seja totalmente aleatória e impossível de manipular por terceiros.', 'aviator-theme'); ?>
                </p>

                <table class="game-table">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Característica', 'aviator-theme'); ?></th>
                            <th><?php echo esc_html__('Especificação', 'aviator-theme'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo esc_html__('Desenvolvedor', 'aviator-theme'); ?></td>
                            <td>Spribe</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Data de Lançamento', 'aviator-theme'); ?></td>
                            <td>Fevereiro 2019</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Versão 2.0', 'aviator-theme'); ?></td>
                            <td>15 Agosto 2019</td>
                        </tr>
                        <tr>
                            <td>RTP</td>
                            <td>97%</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Volatilidade', 'aviator-theme'); ?></td>
                            <td><?php echo esc_html__('Baixa-Média', 'aviator-theme'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Aposta Mínima', 'aviator-theme'); ?></td>
                            <td>$0.10</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Aposta Máxima', 'aviator-theme'); ?></td>
                            <td>$100</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Tecnologia', 'aviator-theme'); ?></td>
                            <td>JS, HTML5</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Tamanho do Jogo', 'aviator-theme'); ?></td>
                            <td>2.6 MB</td>
                        </tr>
                        <tr>
                            <td><?php echo esc_html__('Dispositivos', 'aviator-theme'); ?></td>
                            <td>Desktop, Tablet, Móvel (iOS, Android)</td>
                        </tr>
                    </tbody>
                </table>

                <h2><?php echo esc_html__('Como Localizar O Aviator No Site', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('Encontrar o Aviator na interface é bastante simples. Após acessar o site ou aplicativo do cassino online, navegue até a seção "Cassino" no menu principal. O Aviator geralmente aparece em destaque na categoria de jogos populares ou na seção específica de "Jogos Crash".', 'aviator-theme'); ?>
                </p>

                <h2><?php echo esc_html__('Regras E Interface Do Aviator', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('As regras do Aviator são excepcionalmente simples. A cada rodada, um avião vermelho decola e um multiplicador começa a crescer a partir de 1x. O jogador deve decidir quando "sacar" seus ganhos antes que o avião voe para fora da tela (crash). Se o jogador sacar a tempo, sua aposta será multiplicada pelo valor mostrado na tela no momento do saque.', 'aviator-theme'); ?>
                </p>

                <h2><?php echo esc_html__('Como Jogar Aviator No Aplicativo Móvel', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('Para jogar Aviator no aplicativo móvel, primeiro faça o download do aplicativo oficial para Android ou iOS. Após a instalação, abra o aplicativo e faça login na sua conta. Navegue até a seção "Cassino" tocando no ícone correspondente na barra de navegação inferior.', 'aviator-theme'); ?>
                </p>

                <div class="cta-box">
                    <h3><?php echo esc_html__('JUNTE-SE HOJE', 'aviator-theme'); ?></h3>
                    <a href="#register" class="cta-button"><?php echo esc_html__('Registrar Agora', 'aviator-theme'); ?></a>
                </div>

                <h2><?php echo esc_html__('Apostando No Aviator', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('Para fazer apostas no Aviator, primeiro você precisa ter fundos disponíveis em sua conta. Com seu saldo preparado, o jogo requer login ativo para poder fazer apostas reais. Selecione o valor da sua aposta usando os botões + e – ou digite diretamente o valor desejado.', 'aviator-theme'); ?>
                </p>

                <h2><?php echo esc_html__('Bônus Para O Aviator', 'aviator-theme'); ?></h2>
                <p>
                    <?php echo esc_html__('Os jogadores interessados no jogo de Aviador podem aproveitar diversos bônus exclusivos. A promoção "Rain" (Chuva) é uma das mais populares, onde bets gratuitas são distribuídas aleatoriamente no chat do jogo.', 'aviator-theme'); ?>
                </p>
            </article>

            <!-- FAQ Section -->
            <section class="faq-section">
                <h2><?php echo esc_html__('Perguntas Frequentes Sobre O Aviator', 'aviator-theme'); ?></h2>
                <div class="faq-content">
                    <div class="faq-item">
                        <div class="faq-question"><?php echo esc_html__('É possível jogar Aviator gratuitamente?', 'aviator-theme'); ?></div>
                        <div class="faq-answer">
                            <p><?php echo esc_html__('Sim, é oferecida uma versão de demonstração do Aviator que permite jogar sem apostar dinheiro real. Esta opção é ideal para conhecer a mecânica do jogo, testar estratégias ou simplesmente se divertir sem riscos financeiros.', 'aviator-theme'); ?></p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><?php echo esc_html__('Qual foi o maior multiplicador já registrado no Aviator?', 'aviator-theme'); ?></div>
                        <div class="faq-answer">
                            <p><?php echo esc_html__('Segundo registros oficiais, o maior multiplicador já alcançado no Aviator foi de 2.586.812,24x. No entanto, multiplicadores acima de 100x já são considerados raros, e a maioria das rodadas termina com valores muito menores.', 'aviator-theme'); ?></p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question"><?php echo esc_html__('O Aviator está disponível em dispositivos móveis?', 'aviator-theme'); ?></div>
                        <div class="faq-answer">
                            <p><?php echo esc_html__('Sim, o Aviator é totalmente compatível com dispositivos móveis através do site responsivo ou do aplicativo oficial disponível para Android e iOS. Todas as funcionalidades do jogo desktop estão presentes na versão móvel.', 'aviator-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Rating Section -->
            <section class="rating-section">
                <h2><?php echo esc_html__('Classificação', 'aviator-theme'); ?></h2>
                <div class="rating-overview">
                    <div class="rating-item">
                        <h4><?php echo esc_html__('Classificação geral', 'aviator-theme'); ?></h4>
                        <?php aviator_display_rating(4.5); ?>
                    </div>
                    <div class="rating-item">
                        <h4><?php echo esc_html__('Confiança e justiça', 'aviator-theme'); ?></h4>
                        <?php aviator_display_rating(4.8); ?>
                    </div>
                    <div class="rating-item">
                        <h4><?php echo esc_html__('Bónus', 'aviator-theme'); ?></h4>
                        <?php aviator_display_rating(4.6); ?>
                    </div>
                    <div class="rating-item">
                        <h4><?php echo esc_html__('Jogos e Software', 'aviator-theme'); ?></h4>
                        <?php aviator_display_rating(4.5); ?>
                    </div>
                    <div class="rating-item">
                        <h4><?php echo esc_html__('Apoio ao cliente', 'aviator-theme'); ?></h4>
                        <?php aviator_display_rating(4.3); ?>
                    </div>
                </div>
            </section>

            <!-- Payment Methods Section -->
            <section class="payment-section">
                <h2><?php echo esc_html__('Métodos de Pagamento', 'aviator-theme'); ?></h2>
                <div class="payment-methods-container">
                    <div class="payment-category">
                        <h4><?php echo esc_html__('Métodos de depósito:', 'aviator-theme'); ?></h4>
                        <p>Skrill, Neteller, Visa, MasterCard, ecoPayz, AstroPay Card, MuchBetter, BTC, ETH, LTC, BCH, DOGE, XRP, TRX, EOS, USDT, ADA, DOT, BNB, AVAX, SOL, MATIC, CRO, FTM, RUNE, ATOM, NEAR</p>
                    </div>
                    <div class="payment-category">
                        <h4><?php echo esc_html__('Métodos de remoção:', 'aviator-theme'); ?></h4>
                        <p>Skrill, Neteller, Visa, MasterCard, ecoPayz, AstroPay Card, MuchBetter, BTC, ETH, LTC, BCH, DOGE, XRP, TRX, EOS, USDT, ADA, DOT, BNB, AVAX, SOL, MATIC, CRO, FTM, RUNE, ATOM, NEAR</p>
                    </div>
                </div>
            </section>

            <!-- Final CTA Section -->
            <section class="final-cta">
                <div class="cta-container">
                    <h2><?php echo esc_html__('Bónus', 'aviator-theme'); ?></h2>
                    <div class="bonus-info">
                        <p><?php echo esc_html__('No primeiro depósito 200% até 3.000€ +200 jogadas grátis', 'aviator-theme'); ?></p>
                        <a href="#register" class="cta-button"><?php echo esc_html__('Registo', 'aviator-theme'); ?></a>
                    </div>
                </div>
            </section>

            <!-- Disclaimer Section -->
            <section class="disclaimer-section">
                <div class="disclaimer-content">
                    <p>
                        <?php echo esc_html__('A plataforma é gerida pela Caecus N.V., uma entidade legalmente constituída em Curaçau sob o número de empresa 163779. A empresa opera sob a licença de jogo OGL/2024/1262/0493, emitida pelo Curaçao Gaming Control Board, na sequência da Portaria Nacional sobre Jogos Offshore de Risco (Landsverordening buitengaatse hazardspelen, P.B. 1993, n.º 63).', 'aviator-theme'); ?>
                    </p>
                </div>
            </section>
        </div><!-- .container -->
    </section><!-- .main-content -->
</main><!-- #primary -->

<?php
get_footer(); 