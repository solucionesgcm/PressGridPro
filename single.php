<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <!-- 1. LLAMAMOS AL HERO (Título + Imagen) -->
    <?php get_template_part('template-parts/single/hero'); ?>

    <!-- 2. CUERPO (Texto y Sidebar) -->
    <section class="nbc-body-section">
        <div class="nbc-master-grid">
            
            <!-- Columna 1: Vacía -->
            <div class="nbc-col-cat"></div>

            <!-- Columna 2: Contenido -->
            <main class="nbc-col-main">
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

            <!-- Columna 3: Sidebar -->
            <aside class="nbc-col-side">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

        </div>
    </section>

<?php endwhile; ?>

<!-- SCRIPT: SÍNTESIS DE VOZ (Se mantiene igual) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('play-audio-btn');
    const iconPlay = document.getElementById('icon-play');
    const iconPause = document.getElementById('icon-pause');
    const audioText = document.getElementById('audio-text');
    const progressFill = document.getElementById('audio-progress-fill');
    const timeCurrent = document.getElementById('audio-current-time');
    const timeDuration = document.getElementById('audio-duration');
    
    if (!btn) return;
    // ... el resto del script es idéntico al que ya tienes.
});
</script>

<?php get_footer(); ?>