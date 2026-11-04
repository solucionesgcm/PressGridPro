<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    ?>

    <!-- Contenedor principal de la página -->
    <div class="nbc-page-wrapper">
        
        <!-- El fondo oscuro que cubre el Hero -->
        <div class="nbc-bg-dark-top"></div>

        <!-- La Cuadrícula Maestra (Contenido | Sidebar) -->
        <div class="nbc-main-grid">
            
            <!-- Columna 1: Categoría -->
            <div class="nbc-grid-cat">
                <span class="nbc-cat-text"><?php echo esc_html($category_name); ?></span>
            </div>

            <!-- Columna 2: Título, Imagen, Contenido -->
            <div class="nbc-grid-content">
                
                <!-- Título y Subtítulo -->
                <header class="nbc-article-header">
                    <h1><?php the_title(); ?></h1>
                    <?php 
                    $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                    if (!empty($subtitle)) : 
                    ?>
                        <p class="nbc-excerpt"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </header>

                <!-- Imagen Flotante -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="nbc-image-wrapper">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <!-- Cuerpo del Texto -->
                <div class="nbc-post-content">
                    <?php the_content(); ?>
                </div>

            </div>

            <!-- Columna 3: Sidebar (Se queda a la derecha) -->
            <aside class="nbc-grid-sidebar">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>