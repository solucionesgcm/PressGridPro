<?php
/**
 * Componente: Lo Más Leído - PressGrid Pro
 * Version: 15.8.0
 */
$current_id = is_single() ? get_the_ID() : 0;

$top_posts_q = new WP_Query(array(
    'posts_per_page'      => 5,
    'post__not_in'        => array($current_id),
    'orderby'             => 'comment_count', // O por vistas si usas algún plugin de post_views
    'order'               => 'DESC',
    'ignore_sticky_posts' => true
));

if (!$top_posts_q->have_posts()) {
    $top_posts_q = new WP_Query(array(
        'posts_per_page'      => 5,
        'post__not_in'        => array($current_id),
        'ignore_sticky_posts' => true
    ));
}

if ($top_posts_q->have_posts()) :
    $rank = 1;
?>
    <div class="gcm-most-read-widget">
        <h3 class="widget-title">LO MÁS LEÍDO</h3>
        <div class="top-ranked-list">
            <?php while ($top_posts_q->have_posts()) : $top_posts_q->the_post(); 
                $rank_str = sprintf('%02d', $rank);
            ?>
                <a href="<?php the_permalink(); ?>" class="top-rank-item">
                    <span class="rank-number"><?php echo $rank_str; ?></span>
                    <div class="rank-info">
                        <h4><?php the_title(); ?></h4>
                        <span class="rank-meta"><?php echo get_the_date('M j'); ?></span>
                    </div>
                </a>
            <?php 
                $rank++;
            endwhile; 
            wp_reset_postdata(); 
            ?>
        </div>
    </div>
<?php endif; ?>