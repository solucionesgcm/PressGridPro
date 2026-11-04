<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    ?>

    <!-- 1. HERO OSCURO (Categoría y Título) -->
    <section class="nbc-hero-section">
        <div class="nbc-hero-container">
            <div class="nbc-cat-col">
                <span class="nbc-cat-text"><?php echo esc_html($category_name); ?></span>
            </div>
            <div class="nbc-title-col">
                <h1><?php the_title(); ?></h1>
                <?php 
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                if (!empty($subtitle)) : 
                ?>
                    <p class="nbc-excerpt"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 2. IMAGEN FLOTANTE -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="nbc-image-container">
            <div class="nbc-image-inner">
                <?php the_post_thumbnail('full'); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3. CUERPO: Texto y Sidebar -->
    <section class="nbc-body-section">
        <div class="nbc-body-container">
            
            <!-- Columna Izquierda: Texto -->
            <main class="nbc-post-content">
                <?php the_content(); ?>
            </main>

            <!-- Columna Derecha: Sidebar -->
            <aside class="nbc-sidebar-col">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>