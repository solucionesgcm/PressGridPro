<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $photo_caption = get_post_meta(get_the_ID(), '_gcm_photo_caption', true);
    $photo_credit  = get_post_meta(get_the_ID(), '_gcm_photo_credit', true);
    ?>

    <!-- 1. LLAMAMOS AL HERO -->
    <?php get_template_part('template-parts/single/hero'); ?>

    <!-- 2. CUERPO (Imagen y Texto) -->
    <section class="nbc-body-section">
        <div class="nbc-container-wide">
            
            <!-- Imagen flotante -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="nbc-image-wrapper">
                    <div class="nbc-image-container">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                        <div class="nbc-image-caption">
                            <?php if (!empty($photo_caption)) : ?><div class="nbc-caption-text"><?php echo esc_html($photo_caption); ?></div><?php endif; ?>
                            <?php if (!empty($photo_credit)) : ?><div class="nbc-photo-credit"><?php echo esc_html($photo_credit); ?></div><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Layout de 2 columnas: Texto y Sidebar -->
            <div class="nbc-body-grid">
                
                <main class="nbc-body-main">
                    <div class="nbc-action-bar">
                        <a href="#" class="nbc-action-btn">SHARE</a>
                        <div class="nbc-action-divider"></div>
                        <a href="#" class="nbc-action-btn">ADD GCM NOTICIAS TO GOOGLE</a>
                    </div>

                    <div class="nbc-meta-info">
                        <span class="nbc-pub-date"><?php echo get_the_date('M. j, Y, g:i A T'); ?></span>
                        <span class="nbc-author-name">By <?php the_author(); ?></span>
                    </div>

                    <div class="nbc-post-content" id="article-content-for-tts">
                        <?php the_content(); ?>
                    </div>

                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%title: %link →'); ?></div>
                    </div>
                </main>

                <aside class="nbc-body-sidebar">
                    <?php get_template_part('template-parts/home/sidebar'); ?>
                </aside>

            </div>
        </div>
    </section>

<?php endwhile; ?>

<!-- SCRIPT: SÍNTESIS DE VOZ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('play-audio-btn');
    if (!btn) return;
    // El código del reproductor se mantiene igual...
});
</script>

<?php get_footer(); ?>