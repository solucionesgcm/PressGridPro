<?php
$cats = get_the_category();
$category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
$kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
$photo_caption = get_post_meta(get_the_ID(), '_gcm_photo_caption', true);
$photo_credit  = get_post_meta(get_the_ID(), '_gcm_photo_credit', true);

$clean_cat = strtolower(remove_accents(trim($category_name)));
$clean_kicker = strtolower(remove_accents(trim($kicker)));

if ($clean_kicker === $clean_cat || empty($kicker)) {
    $kicker = '';
}
?>

<!-- 1. HERO OSCURO (Título e Imagen Juntos) -->
<section class="nbc-hero-section">
    <div class="nbc-master-grid">
        
        <!-- Columna 1: Categoría -->
        <div class="nbc-col-cat">
            <span class="nbc-cat-label"><?php echo esc_html($category_name); ?></span>
            <?php if (!empty($kicker)) : ?>
                <span class="nbc-kicker-label"><?php echo esc_html($kicker); ?></span>
            <?php endif; ?>
        </div>

        <!-- Columna 2: Título, Audio e Imagen -->
        <div class="nbc-col-main">
            <h1 class="nbc-title"><?php the_title(); ?></h1>

            <?php 
            $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
            if (!empty($subtitle)) : ?>
                <p class="nbc-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>

            <!-- Reproductor de Audio -->
            <div class="nbc-audio-wrapper">
                <button id="play-audio-btn" class="nbc-audio-btn" aria-label="Escuchar artículo">
                    <svg id="icon-play" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    <svg id="icon-pause" style="display:none;" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                </button>
                
                <div class="nbc-audio-content">
                    <div class="nbc-audio-text-row">
                        <span id="audio-text">Listen to this article with a free profile</span>
                    </div>
                    <div class="nbc-audio-progress-row">
                        <span id="audio-current-time">00:00</span>
                        <div class="nbc-audio-progress-bar" id="audio-progress-container">
                            <div class="nbc-audio-progress-fill" id="audio-progress-fill"></div>
                        </div>
                        <span id="audio-duration">04:28</span>
                        <span class="nbc-audio-speed">1x</span>
                    </div>
                </div>
            </div>

            <!-- IMAGEN FLOTANTE (Aquí está el truco del Z-index) -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="nbc-image-floating">
                    <?php the_post_thumbnail('full'); ?>
                    <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                        <div class="nbc-image-caption">
                            <?php if (!empty($photo_caption)) : ?><div class="nbc-caption-text"><?php echo esc_html($photo_caption); ?></div><?php endif; ?>
                            <?php if (!empty($photo_credit)) : ?><div class="nbc-photo-credit"><?php echo esc_html($photo_credit); ?></div><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Columna 3: Vacía -->
        <div class="nbc-col-side"></div>

    </div>
</section>