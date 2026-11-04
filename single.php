<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    ?>

    <!-- HERO OSCURO -->
    <div style="background-color: #060e1e; padding: 4rem 0 8rem 0;">
        <div style="display: grid; grid-template-columns: 100px 620px 320px; gap: 2rem; justify-content: center; max-width: 100%; margin: 0 auto; padding: 0 2rem; width: 100%; box-sizing: border-box;">
            
            <!-- Categoría -->
            <div style="padding-top: 0.5rem;">
                <span style="font-family: monospace; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #94a3b8;">
                    <?php echo esc_html($category_name); ?>
                </span>
            </div>

            <!-- Título (Forzado a 620px) -->
            <div style="max-width: 620px; width: 100%;">
                <h1 style="font-size: 2.8rem; line-height: 1.1; font-weight: 900; letter-spacing: -1px; color: #ffffff; margin: 0 0 1.5rem 0;">
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
            
            <div></div> <!-- Espacio vacío para el sidebar -->
        </div>
    </div>

    <!-- CUERPO BLANCO (Imagen y Texto) -->
    <div style="background-color: #ffffff; padding-bottom: 5rem;">
        <div style="display: grid; grid-template-columns: 100px 620px 320px; gap: 2rem; justify-content: center; max-width: 100%; margin: 0 auto; padding: 0 2rem; width: 100%; box-sizing: border-box;">
            
            <div></div> <!-- Espacio vacío debajo de la categoría -->

            <!-- Contenido (Forzado a 620px) -->
            <div style="max-width: 620px; width: 100%; min-width: 0;">
                
                <!-- Imagen -->
                <?php if (has_post_thumbnail()) : ?>
                    <div style="margin-top: -6rem; margin-bottom: 2rem; position: relative; z-index: 10; max-width: 620px; width: 100%;">
                        <?php the_post_thumbnail('full', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                    </div>
                <?php endif; ?>

                <!-- Texto -->
                <div class="nbc-post-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Sidebar (Forzado a 320px) -->
            <aside style="max-width: 320px; width: 100%;">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>