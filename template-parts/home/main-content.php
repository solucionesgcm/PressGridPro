<?php
/**
 * Main Content Section - NBC News Asymmetric Style
 * Version: 15.5.0
 */
?>

<!-- BLOQUE 1: FINANZAS Y ECONOMÍA (Layout Asimétrico NBC) -->
<section class="foxiz-block-section">
    <div class="foxiz-block-header">
        <h2 class="foxiz-block-title">Finanzas & Economía Global</h2>
    </div>

    <div class="asymmetric-layout-grid">
        <!-- Columna Izquierda: Nota Lead de Sección -->
        <?php
        $fin_main_q = new WP_Query(array(
            'posts_per_page' => 1,
            'category_name'  => 'finanzas',
            'ignore_sticky_posts' => true
        ));

        if ($fin_main_q->have_posts()) :
            while ($fin_main_q->have_posts()) : $fin_main_q->the_post();
        ?>
                <a href="<?php the_permalink(); ?>" class="asym-main-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="asym-thumb"><?php the_post_thumbnail('medium_large'); ?></div>
                    <?php endif; ?>
                    <h3 class="asym-title"><?php the_title(); ?></h3>
                    <p class="asym-excerpt"><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 20); ?></p>
                </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

        <!-- Columna Derecha: Stack Secundario de Sección -->
        <div class="asym-side-list">
            <?php
            $fin_side_q = new WP_Query(array(
                'posts_per_page' => 3,
                'category_name'  => 'finanzas',
                'offset'         => 1,
                'ignore_sticky_posts' => true
            ));

            if ($fin_side_q->have_posts()) :
                while ($fin_side_q->have_posts()) : $fin_side_q->the_post();
            ?>
                    <a href="<?php the_permalink(); ?>" class="asym-list-item">
                        <div class="asym-list-thumb">
                            <?php if (has_post_thumbnail()) the_post_thumbnail('thumbnail'); ?>
                        </div>
                        <div class="asym-list-info">
                            <h4><?php the_title(); ?></h4>
                            <span class="asym-date"><?php echo get_the_date('M j'); ?></span>
                        </div>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- BANNER DE BOLETÍN / NEWSLETTER -->
<div class="gcm-newsletter-banner">
    <div class="news-banner-content">
        <h3>Inteligencia Financiera & Tecnología</h3>
        <p>Recibe un análisis ejecutivo de los mercados cada mañana en tu correo.</p>
    </div>
    <form class="news-banner-form" onsubmit="event.preventDefault();">
        <input type="email" placeholder="Tu correo electrónico..." required>
        <button type="submit">Suscribirme</button>
    </form>
</div>

<!-- BLOQUE 2: TECNOLOGÍA E IA (Grid 2x2 Estilo NBC) -->
<section class="foxiz-block-section">
    <div class="foxiz-block-header">
        <h2 class="foxiz-block-title">Tecnología & Inteligencia Artificial</h2>
    </div>

    <div class="foxiz-grid-2x2">
        <?php
        $tech_q = new WP_Query(array(
            'posts_per_page' => 4,
            'category_name'  => 'tecnologia',
            'ignore_sticky_posts' => true
        ));

        if ($tech_q->have_posts()) :
            while ($tech_q->have_posts()) : $tech_q->the_post();
        ?>
                <a href="<?php the_permalink(); ?>" class="foxiz-card-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="card-thumb"><?php the_post_thumbnail('medium'); ?></div>
                    <?php endif; ?>
                    <h3 class="card-title"><?php the_title(); ?></h3>
                    <p class="card-excerpt"><?php echo wp_trim_words(get_the_content(), 16); ?></p>
                </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>