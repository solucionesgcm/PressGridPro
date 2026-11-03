<?php get_header(); ?>
<main class="container gcm-home-wrapper">

    <?php $used_ids = array(); ?>

    <!-- 1. BLOQUE HERO (3 COLUMNAS) -->
    <section class="nbc-hero-section">
        
        <!-- COLUMNA 1: NOTA PRINCIPAL DESTACADA -->
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

        <!-- COLUMNA 2: STACK DE NOTICIAS SECUNDARIAS (3 NOTAS) -->
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

        <!-- COLUMNA 3: AL MOMENTO / COBERTURA EN VIVO -->
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

    <!-- 2. GRID SECCIONAL TEMÁTICO (FINANZAS / TECNOLOGÍA / POLÍTICA) -->
    <section class="pressgrid-sections-block">
        <div class="section-block-header">
            <h2 class="section-block-title">Análisis y Cobertura Temática</h2>
        </div>
        
        <div class="pressgrid-3col-grid">
            <?php
            $cat_grid_q = new WP_Query(array(
                'posts_per_page' => 6,
                'post__not_in'   => $used_ids,
                'ignore_sticky_posts' => true
            ));

            if ($cat_grid_q->have_posts()) :
                while ($cat_grid_q->have_posts()) : $cat_grid_q->the_post();
                    $used_ids[] = get_the_ID();
                    $kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
                    $cats   = get_the_category();
                    $cat_label = !empty($kicker) ? $kicker : (!empty($cats) ? $cats[0]->name : 'EDITORIAL');
            ?>
                    <article class="pressgrid-card-item">
                        <a href="<?php the_permalink(); ?>" class="card-thumb-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=500&q=80" alt="GCM Noticias">
                            <?php endif; ?>
                        </a>
                        <div class="card-meta-tag"><?php echo esc_html($cat_label); ?></div>
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

    <!-- 3. FEED INFERIOR CONTINUO CON SIDEBAR DE LO MÁS LEÍDO -->
    <section class="pressgrid-bottom-feed-section">
        <div class="pressgrid-main-with-sidebar">
            
            <div class="pressgrid-feed-col">
                <h3 class="feed-header-title">Más Noticias</h3>
                
                <div class="pressgrid-list-feed">
                    <?php
                    $list_feed_q = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post__not_in'   => $used_ids,
                        'ignore_sticky_posts' => true
                    ));

                    if ($list_feed_q->have_posts()) :
                        while ($list_feed_q->have_posts()) : $list_feed_q->the_post();
                    ?>
                            <article class="pressgrid-list-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="list-thumb">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="list-content">
                                    <span class="list-date"><?php echo get_the_date('d M, Y'); ?></span>
                                    <h4 class="list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p class="list-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>
                                </div>
                            </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

            <aside class="pressgrid-sidebar-col">
                <div class="gcm-sidebar-widget">
                    <h3 class="widget-title">Tendencias B2B</h3>
                    <?php
                    $popular_q = new WP_Query(array(
                        'posts_per_page' => 4,
                        'ignore_sticky_posts' => true
                    ));

                    if ($popular_q->have_posts()) :
                        while ($popular_q->have_posts()) : $popular_q->the_post();
                    ?>
                            <a href="<?php the_permalink(); ?>" class="sidebar-news-card-nbc">
                                <div class="sidebar-thumb-top-32">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php endif; ?>
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
    </section>

</main>
<?php get_footer(); ?>