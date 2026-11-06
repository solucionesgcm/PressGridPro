<?php
/**
 * Sidebar Template - PressGrid Pro (Tendencias 16:9 + Lo Más Leído)
 * Version: 19.3.0
 * 
 * @package PressGrid_Pro
 */
global $pgp_used_ids;
if (!is_array($pgp_used_ids)) {$pgp_used_ids = array();
}

// Excluir la nota actual si estamos en la vista de artículo (single)
if (is_single()) {
    $pgp_used_ids[] = get_the_ID();
}
?>

<aside class="pgp-sidebar">
    
    <!-- BLOQUE 1: TARJETAS VISUALES 16:9 (TENDENCIAS B2B) -->
    <div class="pgp-sidebar-media-widget">
        <h3 class="widget-title">TENDENCIAS EN INTELIGENCIA FINANCIERA Y TECNOLÓGICA</h3>
        
        <div class="sidebar-media-list">
            <?php
            $sidebar_media_q = new WP_Query(array(
                'posts_per_page'      => 3,
                'post__not_in'        => $pgp_used_ids,
                'ignore_sticky_posts' => true
            ));

            if ($sidebar_media_q->have_posts()) :
                while ($sidebar_media_q->have_posts()) : $sidebar_media_q->the_post();$pgp_used_ids[] = get_the_ID();
            ?>
                    <a href="<?php the_permalink(); ?>" class="sidebar-media-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="sidebar-media-thumb">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        <h4 class="sidebar-media-title"><?php the_title(); ?></h4>
                    </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- BLOQUE 2: LO MÁS LEÍDO (LISTA NUMERADA) -->
    <div class="pgp-most-read-widget">
        <h3 class="widget-title">LO MÁS LEÍDO</h3>
        
        <div class="top-ranked-list">
            <?php
            $most_read_q = new WP_Query(array(
                'posts_per_page'      => 5,
                'post__not_in'        => $pgp_used_ids,
                'orderby'             => 'comment_count',
                'order'               => 'DESC',
                'ignore_sticky_posts' => true
            ));

            if (!$most_read_q->have_posts()) {$most_read_q = new WP_Query(array(
                    'posts_per_page'      => 5,
                    'post__not_in'        => $pgp_used_ids,
                    'ignore_sticky_posts' => true
                ));
            }

            if ($most_read_q->have_posts()) :$rank = 1;
                while ($most_read_q->have_posts()) : $most_read_q->the_post();$pgp_used_ids[] = get_the_ID();
                    $formatted_rank = sprintf('\%02d',$rank);
            ?>
                    <a href="<?php the_permalink(); ?>" class="top-rank-item">
                        <span class="rank-number"><?php echo esc_html($formatted_rank); ?></span>
                        <div class="rank-info">
                            <h4><?php the_title(); ?></h4>
                            <span class="rank-meta"><?php echo get_the_date('M j'); ?></span>
                        </div>
                    </a>
            <?php
                    $rank++;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

</aside>