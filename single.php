<?php
/**
 * Single Article Main Template - PressGrid Pro
 * Version: 19.1.0 (Maquetación Limpia B2B)
 * 
 * @package PressGrid_Pro
 */
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <!-- HERO OSCURO INSTITUCIONAL -->
    <?php get_template_part('template-parts/single/hero'); ?>

    <!-- CUERPO PRINCIPAL DEL ARTÍCULO -->
    <section class="pgp-single-body-area">
        <div class="container">

            <!-- IMAGEN DESTACADA FLOTANTE -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="pgp-feat-hero-media-wrapper">
                    <div class="pgp-feat-hero-media">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- RETÍCULA DE LECTURA & SIDEBAR -->
            <div class="pgp-single-sub-grid">
                
                <!-- COLUMNA PRINCIPAL DEL TEXTO -->
                <article class="pgp-article-main-column">
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- TIRA DE NAVEGACIÓN ENTRE NOTAS -->
                    <div class="pgp-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'Siguiente Nota: %title →'); ?></div>
                    </div>
                </article>

                <!-- SIDEBAR INTEGRADAS -->
                <?php get_template_part('template-parts/home/sidebar'); ?>

            </div>

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>