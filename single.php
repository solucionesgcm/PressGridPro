<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    ?>

    <!-- 1. HERO OSCURO -->
    <section class="nbc-hero-section">
        <div class="nbc-hero-container">
            <!-- Categoría -->
            <div class="nbc-cat-col">
                <span class="nbc-cat-text"><?php echo esc_html($category_name); ?></span>
            </div>
            <!-- Título, Subtítulo e Imagen -->
            <div class="nbc-main-hero-col">
                <h1><?php the_title(); ?></h1>
                <?php 
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                if (!empty($subtitle)) : 
                ?>
                    <p class="nbc-excerpt"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <!-- Imagen -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="nbc-image-wrapper">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Columna vacía para el sidebar -->
            <div class="nbc-side-col"></div>
        </div>
    </section>

    <!-- 2. CUERPO BLANCO -->
    <section class="nbc-body-section">
        <div class="nbc-body-container">
            <div class="nbc-cat-col"></div>
            <!-- Texto -->
            <main class="nbc-article-main">
                <div class="nbc-post-content">
                    <?php the_content(); ?>
                </div>
            </main>
            <!-- Sidebar -->
            <aside class="nbc-sidebar-col">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>