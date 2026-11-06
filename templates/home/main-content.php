<?php
/**
 * Main Content Body - PressGrid Pro Flow with Strict Unique Loop
 * Version: 17.7.0
 * 
 * @package PressGrid_Pro
 */

global $pgp_used_ids;
if (!is_array($pgp_used_ids)) {
    $pgp_used_ids = array();
}
?>

<!-- 1. SUB-HERO HORIZONTAL DE 4 COLUMNAS (NOTAS ÚNICAS SIN REPETICIÓN) -->
<section class="pgp-subhero-strip">
    <div class="subhero-grid">
        <?php
        $subhero_q = new WP_Query(array(
            'posts_per_page'      => 4,
            'post__not_in'        => $pgp_used_ids,
            'ignore_sticky_posts' => true
        ));

        if ($subhero_q->have_posts()) :
            while ($subhero_q->have_posts()) : $subhero_q->the_post();
                $pgp_used_ids[] = get_the_ID();
        ?>
                <a href="<?php the_permalink(); ?>" class="subhero-card">
                    <div class="subhero-thumb">
                        <?php if (has_post_thumbnail()) the_post_thumbnail('medium'); ?>
                    </div>
                    <h4 class="subhero-title"><?php the_title(); ?></h4>
                </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<!-- 2. RETÍCULA PRINCIPAL CON SIDEBAR ÚNICO INTEGRADO -->
<div class="pgp-main-layout">
    
    <!-- COLUMNA PRINCIPAL IZQUIERDA -->
    <div class="pgp-main-feed-col">

        <!-- BLOQUE 1: MERCADOS & FINANZAS (LAYOUT ASIMÉTRICO 60/40) -->
        <section class="pgp-block-section">
            <div class="pgp-block-header">
                <h2 class="pgp-block-title">Mercados & Finanzas</h2>
            </div>

            <div class="asymmetric-layout-grid">
                <?php
                $fin_main_q = new WP_Query(array(
                    'posts_per_page'      => 1,
                    'category_name'       => 'finanzas',
                    'post__not_in'        => $pgp_used_ids,
                    'ignore_sticky_posts' => true
                ));

                if (!$fin_main_q->have_posts()) {
                    $fin_main_q = new WP_Query(array(
                        'posts_per_page'      => 1,
                        'post__not_in'        => $pgp_used_ids,
                        'ignore_sticky_posts' => true
                    ));
                }

                if ($fin_main_q->have_posts()) :
                    while ($fin_main_q->have_posts()) : $fin_main_q->the_post();
                        $pgp_used_ids[] = get_the_ID();
                ?>
                        <a href="<?php the_permalink(); ?>" class="asym-main-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="asym-thumb"><?php the_post_thumbnail('medium_large'); ?></div>
                            <?php endif; ?>
                            <h3 class="asym-title"><?php the_title(); ?></h3>
                            <p class="asym-excerpt"><?php echo wp_trim_words(get_the_content(), 18); ?></p>
                        </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <div class="asym-side-list">
                    <?php
                    $fin_side_q = new WP_Query(array(
                        'posts_per_page'      => 3,
                        'category_name'       => 'finanzas',
                        'post__not_in'        => $pgp_used_ids,
                        'ignore_sticky_posts' => true
                    ));

                    if ($fin_side_q->have_posts()) :
                        while ($fin_side_q->have_posts()) : $fin_side_q->the_post();
                            $pgp_used_ids[] = get_the_ID();
                    ?>
                            <a href="<?php the_permalink(); ?>" class="asym-list-item">
                                <div class="asym-list-info">
                                    <span class="asym-date"><?php echo get_the_date('M j'); ?></span>
                                    <h4><?php the_title(); ?></h4>
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

        <!-- BANNER BOLETÍN CORPORATIVO -->
        <div class="pgp-newsletter-banner">
            <div class="news-banner-content">
                <h3>GCM Intelligence Morning Brief</h3>
                <p>El resumen ejecutivo de tecnología y finanzas antes de la apertura de mercado.</p>
            </div>
            <form class="news-banner-form" onsubmit="event.preventDefault();">
                <input type="email" placeholder="Tu correo corporativo..." required>
                <button type="submit">Suscribirme</button>
            </form>
        </div>

        <!-- BLOQUE 2: TECNOLOGÍA & IA (GRID 3 COLUMNAS LIMPIO) -->
        <section class="pgp-block-section">
            <div class="pgp-block-header">
                <h2 class="pgp-block-title">Tecnología & IA</h2>
            </div>

            <div class="pgp-grid-3col">
                <?php
                $tech_q = new WP_Query(array(
                    'posts_per_page'      => 3,
                    'category_name'       => 'tecnologia',
                    'post__not_in'        => $pgp_used_ids,
                    'ignore_sticky_posts' => true
                ));

                if (!$tech_q->have_posts()) {
                    $tech_q = new WP_Query(array(
                        'posts_per_page'      => 3,
                        'post__not_in'        => $pgp_used_ids,
                        'ignore_sticky_posts' => true
                    ));
                }

                if ($tech_q->have_posts()) :
                    while ($tech_q->have_posts()) : $tech_q->the_post();
                        $pgp_used_ids[] = get_the_ID();
                ?>
                        <a href="<?php the_permalink(); ?>" class="pgp-card-3col">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-thumb"><?php the_post_thumbnail('medium'); ?></div>
                            <?php endif; ?>
                            <h4 class="card-title"><?php the_title(); ?></h4>
                        </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>

    </div>

    <!-- SIDEBAR DERECHO INTEGRADO -->
    <?php get_template_part('templates/home/sidebar'); ?>

</div>