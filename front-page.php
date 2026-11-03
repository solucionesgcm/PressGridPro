<?php get_header(); ?>

<main class="container gcm-home-wrapper">

    <?php $used_ids = array(); ?>

    <!-- 1. BLOQUE HERO DE ALTO IMPACTO (3 COLUMNAS ASIMÉTRICAS) -->
    <section class="nbc-hero-section">
        
        <!-- Columna 1: Nota Principal Destacada -->
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
                            <?php echo !empty($subtitle) ? esc_html($subtitle) : (has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 26)); ?>
                        </p>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <!-- Columna 2: Stack Secundario Vertical (3 Notas) -->
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
                    <div class="thumb">
                        <?php if (has_post_thumbnail($post_obj->ID)) : ?>
                            <?php echo get_the_post_thumbnail($post_obj->ID, 'medium'); ?>
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&q=80" alt="GCM Noticias">
                        <?php endif; ?>
                    </div>
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

        <!-- Columna 3: Widget Al Momento / Cobertura en Vivo -->
        <div class="nbc-hero-third-col">
            <?php
            $pressgrid_opts = get_option('pressgrid_options');
            $is_live_active = isset($pressgrid_opts['live_status']) && $pressgrid_opts['live_status'] == '1';

            if ($is_live_active) :
                $live_title    = $pressgrid_opts['live_title'] ?? 'Cobertura en Vivo';
                $live_subtitle = $pressgrid_opts['live_subtitle'] ?? 'Seguimiento minuto a minuto del evento.';
                $live_url      = $pressgrid_opts['live_url'] ?? '#';
            ?>
                <div class="live-stream-box-col3">
                    <div class="live-head-row">
                        <span class="live-pulse-badge">COBERTURA EN VIVO</span>
                    </div>
                    <h4><?php echo esc_html($live_title); ?></h4>
                    <p><?php echo esc_html($live_subtitle); ?></p>
                    <a href="<?php echo esc_url($live_url); ?>" class="live-stream-link">
                        Seguir Transmisión Minuto a Minuto
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            <?php else : ?>
                <div class="nbc-al-momento-header">
                    <h3 class="nbc-al-momento-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
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

<!-- 2. FRANJA OSCURA MULTIMEDIA Y REPORTAJES ESPECIALES (FULL WIDTH) -->
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
                        <div class="multimedia-thumb">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                            <span class="video-play-icon">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#ffffff"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                            </span>
                        </div>
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

    <!-- 3. CUERPO PRINCIPAL DE BLOQUES TEMÁTICOS + SIDEBAR DERECHA CONTINUA -->
    <div class="foxiz-main-layout">
        
        <!-- Columna Principal (Secciones de Noticias) -->
        <div class="foxiz-content-col">
            
            <!-- SECCIÓN A: FINANZAS & ECONOMÍA GLOBAL (2x2 Grid) -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Finanzas & Economía Global</h2>
                </div>
                <div class="foxiz-grid-2x2">
                    <?php
                    $finanzas_q = new WP_Query(array(
                        'posts_per_page' => 4,
                        'post__not_in'   => $used_ids,
                        'ignore_sticky_posts' => true
                    ));

                    if ($finanzas_q->have_posts()) :
                        while ($finanzas_q->have_posts()) : $finanzas_q->the_post();
                            $used_ids[] = get_the_ID();
                    ?>
                            <article class="foxiz-card-item">
                                <a href="<?php the_permalink(); ?>" class="card-thumb">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php endif; ?>
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

            <!-- SECCIÓN B: TECNOLOGÍA & INTELIGENCIA ARTIFICIAL (2x2 Grid) -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Tecnología & Inteligencia Artificial</h2>
                </div>
                <div class="foxiz-grid-2x2">
                    <?php
                    $tecno_q = new WP_Query(array(
                        'posts_per_page' => 4,
                        'post__not_in'   => $used_ids,
                        'ignore_sticky_posts' => true
                    ));

                    if ($tecno_q->have_posts()) :
                        while ($tecno_q->have_posts()) : $tecno_q->the_post();
                            $used_ids[] = get_the_ID();
                    ?>
                            <article class="foxiz-card-item">
                                <a href="<?php the_permalink(); ?>" class="card-thumb">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php endif; ?>
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

            <!-- SECCIÓN C: ANÁLISIS & COLUMNAS DE OPINIÓN (3 Columnas con Avatar) -->
            <section class="foxiz-block-section">
                <div class="foxiz-block-header">
                    <h2 class="foxiz-block-title">Análisis & Columnas de Opinión</h2>
                </div>
                <div class="opinion-grid-3col">
                    <?php
                    $opinion_q = new WP_Query(array(
                        'posts_per_page' => 3,
                        'post__not_in'   => $used_ids,
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
                                    <span class="author-name">GCM Noticias</span>
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

        <!-- Sidebar Derecha Flotante (Lo Más Leído Continuous Feed) -->
        <aside class="foxiz-sidebar-col">
            <div class="sticky-sidebar-box">
                <h3 class="sidebar-header-title">Lo Más Leído</h3>
                
                <div class="sidebar-news-stack">
                    <?php
                    $side_pop_q = new WP_Query(array(
                        'posts_per_page' => 6,
                        'ignore_sticky_posts' => true
                    ));

                    if ($side_pop_q->have_posts()) :
                        while ($side_pop_q->have_posts()) : $side_pop_q->the_post();
                    ?>
                            <a href="<?php the_permalink(); ?>" class="sidebar-card-vertical">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="sidebar-card-thumb">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="sidebar-card-info">
                                    <h4><?php the_title(); ?></h4>
                                    <span class="sidebar-meta"><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                            </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </aside>

    </div>

</main>

<?php get_footer(); ?>
