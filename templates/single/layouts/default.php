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
            <?php $photo_credit = get_post_meta(get_the_ID(), '_pgp_photo_credit', true); ?>
            <figure class="pgp-feat-hero-media-wrapper">
                <div class="pgp-feat-hero-media">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                    <figcaption class="pgp-featured-image-caption">
                        <?php if (!empty($photo_caption)) : ?>
                            <span><?php echo esc_html($photo_caption); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($photo_credit)) : ?>
                            <span class="pgp-featured-image-credit">
                                <?php echo esc_html('Crédito: ' . $photo_credit); ?>
                            </span>
                        <?php endif; ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="pgp-single-sub-grid">
            <article class="pgp-article-main-column">
                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <time
                    class="pgp-article-published-at"
                    datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"
                >
                    Publicado: <?php echo esc_html(get_the_date('j \d\e F, Y')); ?>
                </time>

                <div class="pgp-post-nav-strip">
                    <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Siguiente Nota: %title →'); ?></div>
                </div>
            </article>

            <?php get_template_part('templates/home/sidebar'); ?>
        </div>

    </div>
</section>
