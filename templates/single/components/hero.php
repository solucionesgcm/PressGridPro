<?php
/**
 * Single Article Hero Section - PressGrid Pro
 * Version: 19.1.0 (Estandarización PGP & Barlow Condensed)
 * 
 * @package PressGrid_Pro
 */

$subtitle = get_post_meta(get_the_ID(), '_pgp_subtitle', true);
if (!metadata_exists('post', get_the_ID(), '_pgp_subtitle')) {
    $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
}

$kicker = get_post_meta(get_the_ID(), '_pgp_kicker', true);
if (!metadata_exists('post', get_the_ID(), '_pgp_kicker')) {
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

            <div
                class="pgp-audio-player-bar"
                data-audio-src="<?php echo esc_url($audio_url); ?>"
                data-idle-label="<?php echo esc_attr($audio_url ? __('Escuchar audio del artículo', 'pressgrid-pro') : __('Escuchar versión en audio con IA', 'pressgrid-pro')); ?>"
            >
                <button class="audio-play-btn" type="button" aria-label="Escuchar artículo">
                    <svg class="player-play-icon" width="13" height="13" viewBox="0 0 24 24" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    <svg class="player-pause-icon" width="13" height="13" viewBox="0 0 24 24" aria-hidden="true" hidden><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                </button>
                <div class="pgp-audio-player-content">
                    <div class="pgp-audio-player-heading">
                        <span class="audio-info"><?php echo $audio_url ? esc_html__('Escuchar audio del artículo', 'pressgrid-pro') : esc_html__('Escuchar versión en audio con IA', 'pressgrid-pro'); ?></span>
                        <span class="audio-duration-estimate"></span>
                    </div>
                    <div class="pgp-audio-player-controls">
                        <div class="audio-progress-group">
                            <span class="audio-current-time">0:00</span>
                            <input class="audio-progress" type="range" min="0" max="100" value="0" step="0.1" aria-label="<?php esc_attr_e('Posición de reproducción', 'pressgrid-pro'); ?>" />
                            <span class="audio-duration">0:00</span>
                        </div>
                        <button class="audio-restart-btn" type="button" aria-label="Volver al inicio">
                            <svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 11a8 8 0 1 1 2.3 5.7M4 4v7h7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <label class="audio-speed-control">
                            <select class="audio-speed" aria-label="Velocidad de lectura">
                                <option value="0.8">0.8×</option>
                                <option value="1" selected>1×</option>
                                <option value="1.25">1.25×</option>
                                <option value="1.5">1.5×</option>
                                <option value="2">2×</option>
                            </select>
                        </label>
                    </div>
                    <span class="audio-status" role="status" aria-live="polite"></span>
                </div>
            </div>

        </div>
    </div>
</section>