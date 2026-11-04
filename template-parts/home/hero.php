<?php 
global $used_ids; 
$used_ids = array(); 
?>

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

    <!-- Columna 3: Modo en Vivo / Al Momento -->
    <div class="nbc-hero-third-col">
        <?php 
        $theme_opts = get_option('pressgrid_options');
        $is_live = isset($theme_opts['live_status']) && $theme_opts['live_status'] === '1'; 
        ?>

        <?php if ($is_live) : ?>
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