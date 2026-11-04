<?php
/**
 * Single Article Hero Section - PressGrid Pro
 * Version: 15.7.0
 */
$subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
$cats     = get_the_category();$cat_name = !empty($cats) ?$cats[0]->name : 'EXCLUSIVO';
?>

<section class="gcm-single-hero-dark">
    <div class="container">
        <div class="gcm-single-hero-inner">
            <span class="gcm-hero-category"><?php echo esc_html($cat_name); ?></span>

            <h1 class="gcm-hero-headline"><?php the_title(); ?></h1>

            <?php if (!empty($subtitle)) : ?>
                <p class="gcm-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php elseif (has_excerpt()) : ?>
                <p class="gcm-hero-subtitle"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>

            <div class="byline-date-block-dark">
                <span class="byline-author">Por <strong><?php the_author(); ?></strong></span>
                <span class="pub-date">Publicado: <?php echo get_the_date('j \d\e F, Y'); ?></span>
            </div>

            <div class="gcm-audio-player-bar">
                <button class="audio-play-btn" aria-label="Escuchar artículo">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </button>
                <span class="audio-info">Escuchar versión en audio (2 min)</span>
            </div>
        </div>
    </div>
</section>