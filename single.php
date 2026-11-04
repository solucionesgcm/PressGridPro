<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    ?>

    <!-- HERO OSCURO (Título) -->
    <div style="background-color: #060e1e; padding: 4rem 0 8rem 0; width: 100%;">
        <!-- Contenedor Flex para las 3 columnas -->
        <div style="display: flex; max-width: 1200px; margin: 0 auto; padding: 0 2rem; gap: 2rem; justify-content: center;">
            
            <!-- Columna 1: Categoría -->
            <div style="width: 100px; flex-shrink: 0; padding-top: 0.5rem;">
                <span style="font-family: monospace; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; display: block;">
                    <?php echo esc_html($category_name); ?>
                </span>
            </div>

            <!-- Columna 2: Título (Exactamente 620px) -->
            <div style="width: 620px; flex-shrink: 0;">
                <h1 style="font-family: 'Inter', sans-serif; font-size: 2.8rem; line-height: 1.1; font-weight: 900; letter-spacing: -1px; color: #ffffff; margin: 0 0 1.5rem 0;">
                    <?php the_title(); ?>
                </h1>
                <?php 
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                if (!empty($subtitle)) : 
                ?>
                    <p style="font-family: Georgia, serif; font-size: 1.25rem; line-height: 1.4; color: #cbd5e1; margin-bottom: 2.5rem;">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Columna 3: Espacio del Sidebar -->
            <div style="width: 320px; flex-shrink: 0;"></div>
        </div>
    </div>

    <!-- CUERPO BLANCO (Imagen y Texto) -->
    <div style="background-color: #ffffff; padding-bottom: 5rem; width: 100%;">
        <div style="display: flex; max-width: 1200px; margin: 0 auto; padding: 0 2rem; gap: 2rem; justify-content: center;">
            
            <!-- Columna 1 vacía -->
            <div style="width: 100px; flex-shrink: 0;"></div>

            <!-- Columna 2: Imagen y Texto (Exactamente 620px) -->
            <div style="width: 620px; flex-shrink: 0; min-width: 0;">
                
                <!-- Imagen Flotante -->
                <?php if (has_post_thumbnail()) : ?>
                    <div style="margin-top: -6rem; margin-bottom: 2rem; position: relative; z-index: 10; width: 620px;">
                        <?php the_post_thumbnail('full', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                    </div>
                <?php endif; ?>

                <!-- Texto del Artículo -->
                <div class="nbc-post-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Columna 3: Sidebar (Exactamente 320px) -->
            <aside style="width: 320px; flex-shrink: 0;">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>