<?php global $used_ids; ?>
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