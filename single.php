<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <!-- 1. HERO OSCURO (Titular, Bajada y Autor) -->
    <section class="gcm-single-hero-dark">
        <div class="container">
            <div class="gcm-single-hero-inner">
                <span class="gcm-hero-category">
                    <?php 
                    $cats = get_the_category();
                    echo !empty($cats) ? esc_html($cats[0]->name) : 'EXCLUSIVO';
                    ?>
                </span>

                <?php 
                $kicker   = get_post_meta(get_the_ID(), '_gcm_kicker', true);
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
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
                    <span class="pub-date">Publicado: <?php echo get_the_date('j \d\e F, Y'); ?></span>
                    <span class="byline-author">Por <strong><?php the_author(); ?></strong></span>
                </div>

                <!-- Reproductor de Audio (Visual) -->
                <div class="gcm-audio-player-bar">
                    <button class="audio-play-btn" aria-label="Escuchar artículo">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </button>
                    <span class="audio-info">Escuchar versión en audio (2 min)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. CUERPO DEL ARTÍCULO Y SIDEBAR -->
    <section class="gcm-single-body-area">
        <div class="container">

            <!-- Imagen Destacada Flotante -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="gcm-feat-hero-media-wrapper">
                    <div class="gcm-feat-hero-media">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="gcm-nbc-sub-grid">
                
                <!-- Artículo Principal -->
                <article class="gcm-article-main-column">
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Botones Siguiente / Anterior -->
                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%title: %link →'); ?></div>
                    </div>
                </article>

                <!-- Sidebar Reutilizado -->
                <?php get_template_part('template-parts/home/sidebar'); ?>

            </div>

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>