<?php
/**
 * Single Article Main Template - PressGrid Pro
 * Version: 15.8.0
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
                    <?php get_template_part('template-parts/sidebar/most-read'); ?>
                </aside>

            </div>

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>