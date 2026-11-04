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