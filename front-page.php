<?php get_header(); ?>

<!-- TICKER SUPERIOR DINÁMICO -->
<div class="gcm-ticker-bar">
    <div class="container gcm-ticker-container">
        <div class="ticker-badge">MERCADOS & EN VIVO</div>
        <div class="ticker-content">
            <span class="ticker-item"><strong>S&P 500:</strong> +0.45%</span>
            <span class="ticker-item"><strong>NASDAQ:</strong> +0.82%</span>
            <span class="ticker-item"><strong>BRENT:</strong> $74.20 (-1.1%)</span>
            
            <?php 
            $opts = get_option('pressgrid_options');
            $ticker_text = !empty($opts['ticker_text']) ? $opts['ticker_text'] : 'Mercados reaccionan ante nuevos anuncios de la FED';
            ?>
            <span class="ticker-item highlight"><strong>ÚLTIMA HORA:</strong> <?php echo esc_html($ticker_text); ?></span>
        </div>
    </div>
</div>

<main class="container gcm-home-wrapper">

    <?php $used_ids = array(); ?>

    <!-- SECCIÓN HERO -->
    <section class="nbc-hero-section">
        
        <!-- Columna 1: Nota Principal -->
        <div class="nbc-hero-col-1">
            <?php
            $main_hero_q = new WP_Query(array(
                'posts_per_page' => 1,
                'meta_key'       => '_gcm_is_featured',
                'meta_value'     => '1',
                'ignore_sticky_posts' => true
            ));

            if (!$main_hero_q->have_posts()) {
                $main_hero_q = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => true));
            }

            if ($main_hero_q->have_posts()) :
                while ($main_hero_q->have_posts()) : $main_hero_q->the_post();
                    $used_ids[] = get_the_ID();
                    $kicker   = get_post_meta(get_the_ID(), '_gcm_kicker', true);
                    $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
            ?>
                    <a href="<?php the_permalink(); ?>" class="nbc-hero-main-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="thumb-wrap"><?php the_post_thumbnail('large'); ?></div>
                        <?php endif; ?>
                        <div class="nbc-hero-kicker"><?php echo !empty($kicker) ? esc_html($kicker) : 'NOTA PRINCIPAL'; ?></div>
                        <h1 class="nbc-hero-title"><?php the_title(); ?></h1>
                        <p class="nbc-hero-excerpt">
                            <?php echo !empty($subtitle) ? esc_html($subtitle) : (has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 28)); ?>
                        </p>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <!-- Columna 2: Notas Secundarias -->
        <div class="nbc-hero-stack">
            <?php
            $secondary_posts = array();

            $sec_hero_q = new WP_Query(array(
                'posts_per_page' => 3,
                'post__not_in'   => $used_ids,
                'meta_key'       => '_gcm_is_secondary',
                'meta_value'     => '1',
                'ignore_sticky_posts' => true
            ));

            if ($sec_hero_q->have_posts()) {
                while ($sec_hero_q->have_posts()) {
                    $sec_hero_q->the_post();
                    $secondary_posts[] = get_post();
                    $used_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }

            $needed = 3 - count($secondary_posts);
            if ($needed > 0) {
                $fill_q = new WP_Query(array(
                    'posts_per_page' => $needed,
                    'post__not_in'   => $used_ids,
                    'ignore_sticky_posts' => true
                ));

                if ($fill_q->have_posts()) {
                    while ($fill_q->have_posts()) {
                        $fill_q->the_post();
                        $secondary_posts[] = get_post();
                        $used_ids[] = get_the_ID();
                    }
                    wp_reset_postdata();
                }
            }

            foreach ($secondary_posts as $post_obj) :
                setup_postdata($post_obj);
                $side_kicker = get_post_meta($post_obj->ID, '_gcm_kicker', true);
            ?>
                <a href="<?php echo get_permalink($post_obj->ID); ?>" class="nbc-hero-stack-item">
                    <?php if (has_post_thumbnail($post_obj->ID)) : ?>
                        <div class="thumb">
                            <?php echo get_the_post_thumbnail($post_obj->ID, 'medium'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="info">
                        <span class="meta-kicker"><?php echo !empty($side_kicker) ? esc_html($side_kicker) : get_the_date('M j', $post_obj->ID); ?></span>
                        <h4><?php echo get_the_title($post_obj->ID); ?></h4>
                    </div>
                </a>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

        <!-- Columna 3: Modo en Vivo o Al Momento -->
        <div class="nbc-hero-third-col">
            <?php 
            $theme_opts = get_option('pressgrid_options');
            $is_live = isset($theme_opts['live_status']) && $theme_opts['live_status'] === '1'; 
            ?>

            <?php if ($is_live) : ?>
                <!-- MODO EN VIVO ACTIVADO -->
                <div class="nbc-al-momento-header" style="border-bottom-color: var(--brand-red);">
                    <h3 class="nbc-al-momento-title" style="color: var(--brand-red);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        EN VIVO
                    </h3>
                </div>
                <div class="al-momento-feed" style="display: flex; flex-direction: column; height: 100%;">
                    <h4 style="font-size: 1.1rem; font-weight: 900; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php echo esc_html($theme_opts['live_title'] ?? 'Cobertura Especial'); ?>
                    </h4>
                    <p style="font-size: 0.85rem; color: #475569; margin-bottom: 1.5rem; line-height: 1.5;">
                        <?php echo esc_html($theme_opts['live_subtitle'] ?? ''); ?>
                    </p>
                    <a href="<?php echo esc_url($theme_opts['live_url'] ?? '#'); ?>" class="live-pulse-btn" style="display: inline-block; background: var(--brand-red); color: white; padding: 0.75rem 1rem; border-radius: 4px; text-align: center; font-weight: 800; text-decoration: none; font-size: 0.85rem; margin-top: auto;">
                        Seguir Minuto a Minuto →
                    </a>
                </div>
            <?php else : ?>
                <!-- MODO "AL MOMENTO" NORMAL -->
                <div class="nbc-al-momento-header">
                    <h3 class="nbc-al-momento-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                        Al Momento
                    </h3>
                </div>
                
                <div class="al-momento-feed">
                    <?php
                    $am_stream_q = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post__not_in'   => $used_ids,
                        'ignore_sticky_posts' => true
                    ));

                    if ($am_stream_q->have_posts()) :
                        while ($am_stream_q->have_posts()) : $am_stream_q->the_post();
                            $used_ids[] = get_the_ID();
                            $time_diff = human_time_diff(get_post_time('U', true), current_time('timestamp'));
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : 'NOTICIAS';
                    ?>
                            <a href="<?php the_permalink(); ?>" class="al-momento-item">
                                <div class="al-momento-meta-row">
                                    <span class="al-momento-time">Hace <?php echo esc_html($time_diff); ?></span>
                                    <span class="al-momento-tag"><?php echo esc_html($cat_name); ?></span>
                                </div>
                                <h4><?php the_title(); ?></h4>
                            </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            <?php endif; ?>
        </div>

    </section>

</main>

<!-- STRIP MULTIMEDIA -->
<section class="gcm-multimedia-dark-strip">
    <div class="container">
        <div class="multimedia-header">
            <span class="multimedia-label">GCM NOTICIAS — COBERTURAS & REPORTAJES MULTIMEDIA</span>
        </div>
        <div class="multimedia-grid">
            <?php
            $multi_q = new WP_Query(array(
                'posts_per_page' => 4,
                'post__not_in'   => $used_ids,
                'ignore_sticky_posts' => true
            ));

            if ($multi_q->have_posts()) :
                while ($multi_q->have_posts()) : $multi_q->the_post();
                    $used_ids[] = get_the_ID();
            ?>
                    <a href="<?php the_permalink(); ?>" class="multimedia-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="multimedia-thumb">
                                <?php the_post_thumbnail('medium'); ?>
                                <span class="video-play-icon">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#ffffff"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                                </span>
                            </div>
                        <?php endif; ?>
                        <h4><?php the_title(); ?></h4>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<main class="container gcm-home-wrapper" style="padding-top: 1.5rem;">

    <div class="foxiz-main-layout">
        
        <div class="foxiz-content-col">
            
            <!-- BLOQUE FINANZAS -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Finanzas & Economía Global</h2>
                </div>
                
                <div class="asymmetric-layout-grid">
                    <?php
                    $fin_q = new WP_Query(array(
                        'posts_per_page' => 4,
                        'post__not_in'   => $used_ids,
                        'category_name'  => 'finanzas', // FILTRO AGREGADO
                        'ignore_sticky_posts' => true
                    ));

                    $count = 0;
                    if ($fin_q->have_posts()) :
                        while ($fin_q->have_posts()) : $fin_q->the_post();
                            $used_ids[] = get_the_ID();
                            $count++;
                            
                            if ($count === 1) :
                    ?>
                                <article class="asym-main-card">
                                    <a href="<?php the_permalink(); ?>" class="asym-thumb">
                                        <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
                                    </a>
                                    <span class="card-meta-tag">FINANZAS</span>
                                    <h3 class="asym-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p class="asym-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>
                                </article>
                                <div class="asym-side-list">
                    <?php
                            else :
                    ?>
                                <article class="asym-list-item">
                                    <a href="<?php the_permalink(); ?>" class="asym-list-thumb">
                                        <?php if (has_post_thumbnail()) the_post_thumbnail('thumbnail'); ?>
                                    </a>
                                    <div class="asym-list-info">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <span class="asym-date"><?php echo get_the_date('M j'); ?></span>
                                    </div>
                                </article>
                    <?php
                            endif;
                        endwhile;
                        echo '</div>';
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

            <!-- BANNER NEWSLETTER -->
            <div class="gcm-newsletter-banner">
                <div class="news-banner-content">
                    <h3>Inteligencia Financiera & Tecnología</h3>
                    <p>Recibe los análisis ejecutivos diarios directamente en tu correo.</p>
                </div>
                <form class="news-banner-form" action="#" method="POST">
                    <input type="email" name="email" placeholder="Tu correo ejecutivo..." required />
                    <button type="submit">Suscribirme</button>
                </form>
            </div>

            <!-- BLOQUE TECNOLOGÍA -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Tecnología & Inteligencia Artificial</h2>
                </div>
                <div class="foxiz-grid-2x2">
                    <?php
                    $tecno_q = new WP_Query(array(
                        'posts_per_page' => 4,
                        'post__not_in'   => $used_ids,
                        'category_name'  => 'tecnologia', // FILTRO AGREGADO
                        'ignore_sticky_posts' => true
                    ));

                    if ($tecno_q->have_posts()) :
                        while ($tecno_q->have_posts()) : $tecno_q->the_post();
                            $used_ids[] = get_the_ID();
                    ?>
                            <article class="foxiz-card-item">
                                <a href="<?php the_permalink(); ?>" class="card-thumb">
                                    <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                                </a>
                                <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                            </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

            <!-- BLOQUE OPINIÓN -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Análisis & Columnas de Opinión</h2>
                </div>
                <div class="opinion-grid-3col">
                    <?php
                    $opinion_q = new WP_Query(array(
                        'posts_per_page' => 3,
                        'post__not_in'   => $used_ids,
                        'category_name'  => 'opinion', // FILTRO AGREGADO
                        'ignore_sticky_posts' => true
                    ));

                    if ($opinion_q->have_posts()) :
                        while ($opinion_q->have_posts()) : $opinion_q->the_post();
                    ?>
                            <div class="opinion-card">
                                <div class="author-row">
                                    <div class="author-avatar-ph">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <span class="author-name"><?php the_author(); ?></span>
                                </div>
                                <h4 class="opinion-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

        </div>

        <!-- SIDEBAR -->
        <aside class="foxiz-sidebar-col">
            <div class="sticky-sidebar-box">
                
                <h3 class="sidebar-header-title">Lo Más Leído</h3>
                
                <div class="top-ranked-list">
                    <?php
                    $pop_q = new WP_Query(array(
                        'posts_per_page' => 5,
                        'ignore_sticky_posts' => true
                    ));

                    $rank = 0;
                    if ($pop_q->have_posts()) :
                        while ($pop_q->have_posts()) : $pop_q->the_post();
                            $rank++;
                    ?>
                            <a href="<?php the_permalink(); ?>" class="top-rank-item">
                                <span class="rank-number">0<?php echo $rank; ?></span>
                                <div class="rank-info">
                                    <h4><?php the_title(); ?></h4>
                                    <span class="rank-meta"><?php echo get_the_date('M j'); ?></span>
                                </div>
                            </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <div class="sidebar-podcast-widget">
                    <span class="podcast-badge">PODCAST B2B</span>
                    <h4>Resumen Económico Diario</h4>
                    <p>Escucha las 5 claves financieras del día en 4 minutos.</p>
                    <button class="podcast-play-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#ffffff"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        Reproducir ahora
                    </button>
                </div>

            </div>
        </aside>

    </div>

</main>

<?php get_footer(); ?>
