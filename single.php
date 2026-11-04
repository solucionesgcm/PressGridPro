<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $audio_url = get_post_meta(get_the_ID(), '_gcm_audio_url', true); 
    $photo_caption = get_post_meta(get_the_ID(), '_gcm_photo_caption', true);
    $photo_credit  = get_post_meta(get_the_ID(), '_gcm_photo_credit', true);
    ?>

    <!-- 1. ENCABEZADO OSCURO (Texto centrado) -->
    <section class="gcm-single-hero-dark">
        <div class="container">
            <div class="nbc-article-header">
                <span class="gcm-hero-category">
                    <?php 
                    $cats = get_the_category();
                    echo !empty($cats) ? esc_html($cats[0]->name) : 'EXCLUSIVO';
                    ?>
                </span>

                <?php 
                $kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                ?>

                <?php if (!empty($kicker)) : ?>
                    <div class="gcm-hero-kicker-tag"><?php echo esc_html($kicker); ?></div>
                <?php endif; ?>

                <h1 class="nbc-hero-title-single"><?php the_title(); ?></h1>

                <?php if (!empty($subtitle)) : ?>
                    <p class="nbc-hero-subtitle-single"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <!-- Reproductor de Audio -->
                <div class="nbc-audio-player-container">
                    <button id="play-audio-btn" class="nbc-audio-play-btn" aria-label="Escuchar artículo">
                        <svg id="icon-play" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        <svg id="icon-pause" style="display:none;" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                    </button>
                    
                    <div class="nbc-audio-content">
                        <div class="nbc-audio-text-row">
                            <span id="audio-text">
                                <?php echo !empty($audio_url) ? 'Listen to this article' : 'Añade una URL de audio en el editor para activar esto'; ?>
                            </span>
                        </div>
                        <div class="nbc-audio-progress-row">
                            <span id="audio-current-time">00:00</span>
                            <div class="nbc-audio-progress-bar" id="audio-progress-container">
                                <div class="nbc-audio-progress-fill" id="audio-progress-fill"></div>
                            </div>
                            <span id="audio-duration">00:00</span>
                            <span class="nbc-audio-speed">1x</span>
                        </div>
                    </div>
                    
                    <?php if (!empty($audio_url)) : ?>
                        <audio id="article-audio" src="<?php echo esc_url($audio_url); ?>" preload="metadata"></audio>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. CUERPO BLANCO -->
    <section class="gcm-single-body-area">
        <div class="container">

            <!-- Imagen Flotante -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="nbc-featured-image-wrapper">
                    <div class="nbc-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                        <div class="nbc-image-caption">
                            <?php if (!empty($photo_caption)) : ?>
                                <div class="nbc-caption-text"><?php echo esc_html($photo_caption); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($photo_credit)) : ?>
                                <div class="nbc-photo-credit"><?php echo esc_html($photo_credit); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Cuadrícula: Contenido a la izquierda, Sidebar a la derecha -->
            <div class="nbc-article-layout">
                
                <!-- Columna Principal -->
                <main class="nbc-article-main">
                    
                    <div class="nbc-action-bar">
                        <a href="#" class="nbc-action-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>
                            SHARE
                        </a>
                        <div class="nbc-action-divider"></div>
                        <a href="#" class="nbc-action-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            ADD GCM NOTICIAS TO GOOGLE
                        </a>
                    </div>

                    <div class="nbc-meta-info">
                        <span class="nbc-pub-date"><?php echo get_the_date('M. j, Y, g:i A T'); ?></span>
                        <span class="nbc-author-name">By <?php the_author(); ?></span>
                    </div>

                    <div class="nbc-post-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%title: %link →'); ?></div>
                    </div>
                </main>

                <!-- Sidebar -->
                <aside class="nbc-article-sidebar">
                    <?php get_template_part('template-parts/home/sidebar'); ?>
                </aside>

            </div>

        </div>
    </section>

<?php endwhile; ?>

<!-- SCRIPT DE AUDIO -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('article-audio');
    const btn = document.getElementById('play-audio-btn');
    const iconPlay = document.getElementById('icon-play');
    const iconPause = document.getElementById('icon-pause');
    const progressFill = document.getElementById('audio-progress-fill');
    const timeCurrent = document.getElementById('audio-current-time');
    const timeDuration = document.getElementById('audio-duration');

    if(audio && btn) {
        function formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }

        audio.addEventListener('loadedmetadata', function() {
            timeDuration.textContent = formatTime(audio.duration);
        });

        btn.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                iconPlay.style.display = 'none';
                iconPause.style.display = 'block';
            } else {
                audio.pause();
                iconPlay.style.display = 'block';
                iconPause.style.display = 'none';
            }
        });

        audio.addEventListener('timeupdate', function() {
            const percent = (audio.currentTime / audio.duration) * 100;
            progressFill.style.width = percent + '%';
            timeCurrent.textContent = formatTime(audio.currentTime);
        });

        audio.addEventListener('ended', function() {
            iconPlay.style.display = 'block';
            iconPause.style.display = 'none';
            progressFill.style.width = '0%';
        });
    }
});
</script>

<?php get_footer(); ?>