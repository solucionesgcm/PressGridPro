<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <!-- HERO OSCURO ESTILO NBC NEWS -->
    <section class="gcm-single-hero-dark">
        <div class="container">
            <div class="gcm-nbc-master-grid">
                
                <!-- Columna Izquierda Meta -->
                <div class="gcm-hero-meta-left">
                    <span class="gcm-hero-category">
                        <?php 
                        $cats = get_the_category();
                        echo !empty($cats) ? esc_html($cats[0]->name) : 'EXCLUSIVO';
                        ?>
                    </span>
                </div>

                <!-- Columna Principal Encabezado -->
                <div class="gcm-hero-main-content">
                    <?php 
                    $kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);$subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                    ?>
                    
                    <?php if (!empty($kicker)) : ?>
                        <div class="gcm-hero-kicker-tag"><?php echo esc_html($kicker); ?></div>
                    <?php endif; ?>

                    <h1 class="gcm-hero-headline"><?php the_title(); ?></h1>

                    <?php if (!empty($subtitle)) : ?>
                        <p class="gcm-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php elseif (has_excerpt()) : ?>
                        <p class="gcm-hero-subtitle"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>

                    <div class="byline-date-block-dark">
                        <span class="pub-date">Publicado: <?php echo get_the_date('j \d\e F, Y — H:i'); ?> hrs</span>
                        <span class="byline-author">Por <strong><?php the_author(); ?></strong></span>
                    </div>

                    <!-- Widget de Reproductor de Audio Flotante -->
                    <div class="gcm-audio-player-bar">
                        <button class="audio-play-btn" aria-label="Escuchar artículo">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </button>
                        <span class="audio-info">Escuchar resumen en audio (2 min)</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CUERPO DE ARTÍCULO Y SIDEBAR -->
    <section class="gcm-single-body-area">
        <div class="container">

            <?php if (has_post_thumbnail()) : ?>
                <div class="gcm-feat-hero-media-wrapper">
                    <div class="gcm-feat-hero-media">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="gcm-nbc-sub-grid">
                
                <!-- Contenido del Artículo -->
                <article class="gcm-article-main-column">
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Navegación entre entradas -->
                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'Siguiente Nota: %title →'); ?></div>
                    </div>
                </article>

                <!-- Sidebar de Notas Relacionadas / Lo Más Leído -->
                <aside class="gcm-sidebar">
                    <div class="gcm-sidebar-widget">
                        <h3 class="widget-title">Tendencias B2B</h3>
                        <?php
                        $rel_q = new WP_Query(array(
                            'posts_per_page' => 4,
                            'post__not_in'   => array(get_the_ID()),
                            'ignore_sticky_posts' => true
                        ));

                        if ($rel_q->have_posts()) :
                            while ($rel_q->have_posts()) :$rel_q->the_post();
                        ?>
                                <a href="<?php the_permalink(); ?>" class="sidebar-news-card-nbc">
                                    <div class="sidebar-thumb-top-32">
                                        <?php if (has_post_thumbnail()) the_post_thumbnail('medium'); ?>
                                    </div>
                                    <div class="sidebar-card-info-nbc">
                                        <h4><?php the_title(); ?></h4>
                                        <span class="meta-time"><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </a>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </aside>

            </div>

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>
