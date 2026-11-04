<?php get_header(); ?>

<div class="gcm-archive-header" style="background: #0f172a; color: #fff; padding: 3.5rem 0; margin-bottom: 2rem; border-bottom: 4px solid #dc2626;">
    <div class="container">
        <span class="gcm-hero-category" style="color: #dc2626; font-family: 'DM Mono', monospace; font-weight: 800; letter-spacing: 1px;">SECCIÓN</span>
        <h1 style="font-size: 2.8rem; font-weight: 900; margin: 0; letter-spacing: -1px;"><?php the_archive_title(); ?></h1>
        <?php if (category_description()) : ?>
            <p style="color: #94a3b8; margin-top: 0.75rem; max-width: 600px; font-size: 1.1rem; line-height: 1.5;"><?php echo category_description(); ?></p>
        <?php endif; ?>
    </div>
</div>

<main class="container gcm-home-wrapper" style="padding-top: 0;">
    <div class="foxiz-grid-2x2">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="foxiz-card-item">
                <a href="<?php the_permalink(); ?>" class="card-thumb">
                    <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                </a>
                <span class="card-meta-tag" style="color: #dc2626; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 0.5rem; font-family: 'DM Mono', monospace;">
                    <?php $cats = get_the_category(); echo !empty($cats) ? $cats[0]->name : 'NOTICIA'; ?>
                </span>
                <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </article>
        <?php endwhile; else : ?>
            <div style="grid-column: 1 / -1; padding: 3rem; text-align: center; background: #f8fafc; border: 1px solid #e2e8f0;">
                <h2 style="font-weight: 900; color: #0f172a;">No hay noticias publicadas aquí aún.</h2>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="pagination" style="margin-top: 3rem; text-align: center; font-weight: 700; font-family: 'Inter', sans-serif;">
        <?php echo paginate_links(array('prev_text' => '← Anterior', 'next_text' => 'Siguiente →')); ?>
    </div>
</main>

<?php get_footer(); ?>