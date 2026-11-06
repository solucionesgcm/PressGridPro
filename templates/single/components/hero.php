<?php
/**
 * Single Article Hero Section - PressGrid Pro
 * Version: 19.1.0 (Estandarización PGP & Barlow Condensed)
 * 
 * @package PressGrid_Pro
 */

$subtitle = get_post_meta(get_the_ID(), '_pgp_subtitle', true);
if (empty($subtitle)) {
    $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
}

$kicker = get_post_meta(get_the_ID(), '_pgp_kicker', true);
if (empty($kicker)) {
    $kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
}

$audio_url = get_post_meta(get_the_ID(), '_pgp_audio_url', true);

$cats     = get_the_category();
$cat_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
?>

<section class="pgp-single-hero-dark">
    <div class="container">
        <div class="pgp-single-hero-inner">
            
            <!-- Categoria o Kicker -->
            <span class="pgp-hero-category">
                <?php echo !empty($kicker) ? esc_html($kicker) : esc_html($cat_name); ?>
            </span>

            <!-- Headline Principal -->
            <h1 class="pgp-hero-headline"><?php the_title(); ?></h1>

            <!-- Subtítulo / Bajada -->
            <?php if (!empty($subtitle)) : ?>
                <p class="pgp-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php elseif (has_excerpt()) : ?>
                <p class="pgp-hero-subtitle"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>

            <!-- Bloque de Firma y Fecha -->
            <div class="byline-date-block-dark">
                <span class="byline-author">Por <strong><?php the_author(); ?></strong></span>
                <span class="pub-date">Publicado: <?php echo get_the_date('j \d\e F, Y'); ?></span>
            </div>

            <!-- Reproductor de Audio / Briefing -->
            <div class="pgp-audio-player-bar">
                <button class="audio-play-btn" aria-label="Escuchar artículo">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </button>
                <span class="audio-info">Escuchar versión en audio (2 min)</span>
            </div>

        </div>
    </div>
</section>