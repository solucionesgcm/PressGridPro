<?php global $used_ids; ?>

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
            'category_name'  => 'finanzas',
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
            'category_name'  => 'tecnologia',
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
            'category_name'  => 'opinion',
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