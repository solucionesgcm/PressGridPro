<?php
/**
 * Category and archive landing page.
 *
 * @package PressGrid_Pro
 */

get_header();

$archive_title = is_category() ? single_cat_title('', false) : get_the_archive_title();
$archive_description = get_the_archive_description();
$post_count = (int) $GLOBALS['wp_query']->post_count;
?>

<main class="pgp-category-page">
    <header class="pgp-category-hero">
        <div class="container pgp-category-hero-inner">
            <span class="pgp-category-eyebrow"><?php esc_html_e('Sección', 'pressgrid-pro'); ?></span>
            <h1><?php echo esc_html($archive_title); ?></h1>
            <?php if (!empty($archive_description)) : ?>
                <div class="pgp-category-description">
                    <?php echo wp_kses_post($archive_description); ?>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="container pgp-category-content">
        <?php if (have_posts()) : ?>
            <section class="pgp-category-featured" aria-label="<?php esc_attr_e('Noticias destacadas', 'pressgrid-pro'); ?>">
                <?php the_post(); ?>
                <article class="pgp-category-lead">
                    <a class="pgp-category-image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php else : ?>
                            <span class="pgp-category-image-placeholder" aria-hidden="true"></span>
                        <?php endif; ?>
                    </a>
                    <div class="pgp-category-lead-copy">
                        <span class="pgp-category-story-label"><?php esc_html_e('Lo más reciente', 'pressgrid-pro'); ?></span>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if (has_excerpt()) : ?>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 32)); ?></p>
                        <?php endif; ?>
                    </div>
                </article>

                <?php if ($post_count > 1) : ?>
                    <div class="pgp-category-feature-grid">
                        <?php
                        $featured_count = min(5, $post_count);
                        for ($post_index = 1; $post_index < $featured_count; $post_index++) :
                            the_post();
                        ?>
                            <article class="pgp-category-card">
                                <a class="pgp-category-image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php else : ?>
                                        <span class="pgp-category-image-placeholder" aria-hidden="true"></span>
                                    <?php endif; ?>
                                </a>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </article>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </section>

            <?php if ($post_count > 5) : ?>
                <section class="pgp-category-more" aria-labelledby="pgp-category-more-title">
                    <div class="pgp-category-section-heading">
                        <h2 id="pgp-category-more-title">
                            <?php
                            printf(
                                /* translators: %s: archive or category name. */
                                esc_html__('Más de %s', 'pressgrid-pro'),
                                esc_html($archive_title)
                            );
                            ?>
                        </h2>
                    </div>
                    <div class="pgp-category-more-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="pgp-category-card">
                                <a class="pgp-category-image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php else : ?>
                                        <span class="pgp-category-image-placeholder" aria-hidden="true"></span>
                                    <?php endif; ?>
                                </a>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>

            <div class="pgp-category-pagination">
                <?php
                the_posts_pagination(
                    array(
                        'mid_size'  => 1,
                        'prev_text' => esc_html__('← Anterior', 'pressgrid-pro'),
                        'next_text' => esc_html__('Siguiente →', 'pressgrid-pro'),
                    )
                );
                ?>
            </div>
        <?php else : ?>
            <div class="pgp-category-empty">
                <h2><?php esc_html_e('Aún no hay noticias en esta sección.', 'pressgrid-pro'); ?></h2>
                <p><?php esc_html_e('Vuelve pronto para encontrar nuevas historias.', 'pressgrid-pro'); ?></p>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Volver al inicio', 'pressgrid-pro'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
