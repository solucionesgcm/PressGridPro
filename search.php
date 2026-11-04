<?php get_header(); ?>

<div class="gcm-archive-header" style="background: #0f172a; color: #fff; padding: 3.5rem 0; margin-bottom: 2rem; border-bottom: 4px solid #dc2626;">
    <div class="container">
        <span class="gcm-hero-category" style="color: #dc2626; font-family: 'DM Mono', monospace; font-weight: 800; letter-spacing: 1px;">BÚSQUEDA</span>
        <h1 style="font-size: 2.8rem; font-weight: 900; margin: 0; letter-spacing: -1px;">Resultados para: "<?php echo get_search_query(); ?>"</h1>
    </div>
</div>

<main class="container gcm-home-wrapper" style="padding-top: 0;">
    <div class="foxiz-grid-2x2">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="foxiz-card-item">
                <a href="<?php the_permalink(); ?>" class="card-thumb">
                    <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                </a>
                <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </article>
        <?php endwhile; else : ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #f8fafc; border: 1px solid #e2e8f0;">
                <h2 style="font-weight: 900; color: #0f172a; font-size: 1.8rem; margin-bottom: 1rem;">No encontramos resultados</h2>
                <p style="color: #64748b; margin-bottom: 2rem;">Intenta buscar con otras palabras clave.</p>
                <div style="max-width: 500px; margin: 0 auto;">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>