<?php
/**
 * Standard Home Hero - NBC News Style (Clean White Layout 4-Items)
 * Version: 15.3.0
 */
$used_ids = array();
?>

<section class="nbc-home-hero-white">
    
    <!-- Columna 1: Nota Principal (Main Lead) -->
    <div class="nbc-hero-main-col">
        <?php
        $main_hero_q = new WP_Query(array(
            'posts_per_page'      => 1,
            'meta_key'            => '_gcm_is_featured',
            'meta_value'          => '1',
            'ignore_sticky_posts' => true
        ));

        if (!$main_hero_q->have_posts()) {$main_hero_q = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => true));
        }

        if ($main_hero_q->have_posts()) :
            while ($main_hero_q->have_posts()) : $main_hero_q->the_post();$used_ids[] = get_the_ID();
                $kicker   = get_post_meta(get_the_ID(), '_gcm_kicker', true);$subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
        ?>
                <a href="<?php the_permalink(); ?>" class="nbc-hero-lead-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="lead-thumb-wrap"><?php the_post_thumbnail('large'); ?></div>
                    <?php endif; ?>
                    <span class="lead-kicker"><?php echo !empty($kicker) ? esc_html($kicker) : 'NOTA PRINCIPAL'; ?></span>
                    <h1 class="lead-title"><?php the_title(); ?></h1>
                    <p class="lead-excerpt">
                        <?php echo !empty($subtitle) ? esc_html($subtitle) : (has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 26)); ?>
                    </p>
                </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <!-- Columna 2: Stack Secundario (4 Notas con Miniatura Compacta) -->
    <div class="nbc-hero-stack-col">
        <?php
        $secondary_posts = array();

        $sec_hero_q = new WP_Query(array(
            'posts_per_page'      => 4,
            'post__not_in'        => $used_ids,
            'meta_key'            => '_gcm_is_secondary',
            'meta_value'          => '1',
            'ignore_sticky_posts' => true
        ));

        if ($sec_hero_q->have_posts()) {
            while ($sec_hero_q->have_posts()) {$sec_hero_q->the_post();
                $secondary_posts[] = get_post();$used_ids[] = get_the_ID();
            }
            wp_reset_postdata();
        }

        $needed = 4 - count($secondary_posts);
        if ($needed > 0) {$fill_q = new WP_Query(array(
                'posts_per_page'      => $needed,
                'post__not_in'        => $used_ids,
                'ignore_sticky_posts' => true
            ));

            if ($fill_q->have_posts()) {
                while ($fill_q->have_posts()) {$fill_q->the_post();
                    $secondary_posts[] = get_post();$used_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }
        }

        foreach ($secondary_posts as$post_obj) :
            setup_postdata($post_obj);
            $side_kicker = get_post_meta($post_obj->ID, '_gcm_kicker', true);
        ?>
            <a href="<?php echo get_permalink($post_obj->ID); ?>" class="nbc-stack-card">
                <div class="stack-thumb">
                    <?php if (has_post_thumbnail($post_obj->ID)) : ?>
                        <?php echo get_the_post_thumbnail($post_obj->ID, 'medium'); ?>
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&q=80" alt="GCM Noticias">
                    <?php endif; ?>
                </div>
                <div class="stack-info">
                    <span class="stack-kicker"><?php echo !empty($side_kicker) ? esc_html($side_kicker) : get_the_date('M j',$post_obj->ID);