<?php
/**
 * Single Article Main Template - PressGrid Pro
 * Version: 15.7.0
 */
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('template-parts/single/hero'); ?>

    <section class="gcm-single-body-area">
        <div class="container">

            <?php if (has_post_thumbnail()) : ?>
                <div class="gcm-feat-hero-media-wrapper">
                    <div class="gcm-feat-hero-media">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="gcm-nbc-sub-grid">
                
                <article class="gcm-article-main-column">
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'Siguiente Nota: %title →'); ?></div>
                    </div>
                </article>

                <aside class="gcm-sidebar">
                    <div class="gcm-sidebar-widget">
                        <h3 class="widget-title">Tendencias Destacadas</h3>
                        <?php
                        $rel_q = new WP_Query(array(
                            'posts_per_page'      => 4,
                            'post__not_in'        => array(get_the_ID()),
                            'ignore_sticky_posts' => true
                        ));

                        if ($rel_q->have_posts()) :
                            while ($rel_q->have_posts()) : $rel_q->the_post();
                        ?>
                                <a href="<?php the_permalink(); ?>" class="sidebar-news-card-nbc">
                                    <div class="sidebar-thumb-top-32">
                                        <?php if (has_post_thumbnail()) the_post_thumbnail('medium'); ?>
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

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>