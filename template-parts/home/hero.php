<?php
/**
 * Home Hero Section - PressGrid Pro Hybrid Layout with Global ID Tracking
 * Version: 17.3.0
 * 
 * @package PressGrid_Pro
 */
global $pgp_used_ids;
if (!is_array($pgp_used_ids)) {
    $pgp_used_ids = array();
}
?>

<section class="pgp-home-hero-white">
    
    <!-- Columna 1: Nota Principal (Main Lead) -->
    <div class="pgp-hero-main-col">
        <?php
        $main_hero_q = new WP_Query(array(
            'posts_per_page'      => 1,
            'meta_key'            => '_pgp_is_featured',
            'meta_value'          => '1',
            'ignore_sticky_posts' => true
        ));

        if (!$main_hero_q->have_posts()) {
            $main_hero_q = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => true));
        }

        if ($main_hero_q->have_posts()) :
            while ($main_hero_q->have_posts()) : $main_hero_q->the_post();
                $pgp_used_ids[] = get_the_ID();
                $subtitle = get_post_meta(get_the_ID(), '_pgp_subtitle', true);
        ?>
                <a href="<?php the_permalink(); ?>" class="pgp-hero-lead-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="lead-thumb-wrap"><?php the_post_thumbnail('large'); ?></div>
                    <?php endif; ?>
                    
                    <h1 class="lead-title"><?php the_title(); ?></h1>
                    
                    <p class="lead-excerpt">
                        <?php echo !empty($subtitle) ? esc_html($subtitle) : (has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 22)); ?>
                    </p>
                </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <!-- Columna 2: Layout Híbrido (1 Sub-Lead 16:9 + 3 Notas Compactas Inferiores) -->
    <div class="pgp-hero-stack-col">
        <?php
        $sec_hero_q = new WP_Query(array(
            'posts_per_page'      => 4,
            'post__not_in'        => $pgp_used_ids,
            'ignore_sticky_posts' => true
        ));

        $sec_posts = array();
        if ($sec_hero_q->have_posts()) {
            while ($sec_hero_q->have_posts()) {
                $sec_hero_q->the_post();
                $sec_posts[] = get_post();
                $pgp_used_ids[] = get_the_ID();
            }
            wp_reset_postdata();
        }

        // 1. Fila Superior: Nota Sub-Principal 16:9
        if (!empty($sec_posts[0])) :
            $post_top = $sec_posts[0];
            setup_postdata($post_top);
        ?>
            <a href="<?php echo get_permalink($post_top->ID); ?>" class="pgp-col2-top-lead">
                <?php if (has_post_thumbnail($post_top->ID)) : ?>
                    <div class="col2-top-thumb">
                        <?php echo get_the_post_thumbnail($post_top->ID, 'medium_large'); ?>
                    </div>
                <?php endif; ?>
                <h3 class="col2-top-title"><?php echo get_the_title($post_top->ID); ?></h3>
            </a>
        <?php 
            wp_reset_postdata();
        endif; 
        ?>

        <!-- Divider Horizontal -->
        <div class="pgp-col2-divider"></div>

        <!-- 2. Fila Inferior: 3 Notas Secundarias Compactas -->
        <div class="pgp-col2-bottom-list">
            <?php
            for ($i = 1; $i < count($sec_posts); $i++) :
                $post_item = $sec_posts[$i];
                setup_postdata($post_item);
            ?>
                <a href="<?php echo get_permalink($post_item->ID); ?>" class="pgp-stack-card">
                    <div class="stack-thumb">
                        <?php if (has_post_thumbnail($post_item->ID)) : ?>
                            <?php echo get_the_post_thumbnail($post_item->ID, 'thumbnail'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="stack-info">
                        <h4><?php echo get_the_title($post_item->ID); ?></h4>
                    </div>
                </a>
            <?php
            endfor;
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <!-- Columna 3: Feed Al Momento (Estilo Limpio Minimalista) -->
    <div class="pgp-hero-latest-col">
        <div class="latest-header">
            <h3 class="latest-title">AL MOMENTO</h3>
        </div>
        
        <div class="latest-feed-list">
            <?php
            $am_stream_q = new WP_Query(array(
                'posts_per_page'      => 6,
                'post__not_in'        => $pgp_used_ids,
                'ignore_sticky_posts' => true
            ));

            if ($am_stream_q->have_posts()) :
                while ($am_stream_q->have_posts()) : $am_stream_q->the_post();
                    $pgp_used_ids[] = get_the_ID();
                    $time_diff = human_time_diff(get_post_time('U', true), current_time('timestamp'));
            ?>
                    <a href="<?php the_permalink(); ?>" class="latest-feed-item">
                        <div class="latest-meta">
                            <span class="latest-time">Hace <?php echo esc_html($time_diff); ?></span>
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