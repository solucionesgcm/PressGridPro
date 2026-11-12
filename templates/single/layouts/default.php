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
            <?php $photo_caption = get_post_meta(get_the_ID(), '_pgp_photo_caption', true); ?>
            <figure class="pgp-feat-hero-media-wrapper">
                <div class="pgp-feat-hero-media">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <?php if (!empty($photo_caption)) : ?>
                    <figcaption class="pgp-featured-image-caption">
                        <?php echo esc_html($photo_caption); ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
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
