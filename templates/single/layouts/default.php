<?php
/**
 * Default single post layout.
 *
 * @package PressGrid_Pro
 */
?>

<?php get_template_part('templates/single/components/hero'); ?>

<section class="pgp-single-body-area">
    <div class="container">

        <?php if (has_post_thumbnail()) : ?>
            <div class="pgp-feat-hero-media-wrapper">
                <div class="pgp-feat-hero-media">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="pgp-single-sub-grid">
            <article class="pgp-article-main-column">
                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <div class="pgp-post-nav-strip">
                    <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Siguiente Nota: %title →'); ?></div>
                </div>
            </article>

            <?php get_template_part('templates/home/sidebar'); ?>
        </div>

    </div>
</section>
