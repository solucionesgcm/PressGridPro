<?php
/**
 * Editorial Meta Boxes Management - PressGrid Pro
 * Version: 19.5.0
 */

if (!defined('ABSPATH')) exit;

function pressgrid_cleanup_and_register_single_meta_box() {
    remove_meta_box('gcm_post_metadata_box', 'post', 'normal');
    remove_meta_box('gcm_advanced_meta_box', 'post', 'normal');
    remove_meta_box('gcm_post_meta_box', 'post', 'normal');

    add_meta_box(
        'pressgrid_sidebar_editorial_meta_box',
        'PRESSGRID — Visibilidad Portada',
        'pressgrid_render_sidebar_meta_box',
        'post',
        'side',
        'high'
    );

    add_meta_box(
        'pressgrid_unified_editorial_meta_box',
        'PRESSGRID — Datos Editoriales Avanzados',
        'pressgrid_render_unified_meta_box',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pressgrid_cleanup_and_register_single_meta_box', 99);

function pressgrid_render_sidebar_meta_box($post) {
    wp_nonce_field('pressgrid_save_sidebar_meta_box', 'pressgrid_sidebar_meta_box_nonce');

    $is_featured  = get_post_meta($post->ID, '_pgp_is_featured', true);
    $is_secondary = get_post_meta($post->ID, '_pgp_is_secondary', true);
    $is_breaking  = get_post_meta($post->ID, '_pgp_is_breaking', true);
    
    echo '<div style="font-family:-apple-system,BlinkMacSystemFont,sans-serif;">';
    
    echo '<label style="display:flex; align-items:center; gap:0.5rem; font-weight:700; font-size:0.825rem; margin-bottom:0.6rem; color:#0f172a;">';
    echo '<input type="checkbox" name="pgp_is_featured" value="1" ' . checked($is_featured, '1', false) . ' /> Nota Principal (Hero Lead)';
    echo '</label>';
    
    echo '<label style="display:flex; align-items:center; gap:0.5rem; font-weight:600; font-size:0.825rem; margin-bottom:0.6rem; color:#334155;">';
    echo '<input type="checkbox" name="pgp_is_secondary" value="1" ' . checked($is_secondary, '1', false) . ' /> Forzar en Secundarias (Columna 2)';
    echo '</label>';

    echo '<label style="display:flex; align-items:center; gap:0.5rem; font-weight:600; font-size:0.825rem; margin-bottom:0.6rem; color:#dc2626;">';
    echo '<input type="checkbox" name="pgp_is_breaking" value="1" ' . checked($is_breaking, '1', false) . ' /> Alerta Flash (Al Momento)';
    echo '</label>';

    echo '<p style="font-size:0.75rem; color:#64748b; margin-top:0.5rem; line-height:1.3;">Marcar como Principal desmarcará automáticamente cualquier otra nota principal activa.</p>';
    
    echo '</div>';
}

function pressgrid_render_unified_meta_box($post) {
    wp_nonce_field('pressgrid_save_unified_meta_box', 'pressgrid_unified_meta_box_nonce');

    $kicker        = get_post_meta($post->ID, '_pgp_kicker', true);
    $subtitle      = get_post_meta($post->ID, '_pgp_subtitle', true);
    $audio_url     = get_post_meta($post->ID, '_pgp_audio_url', true);
    $photo_caption = get_post_meta($post->ID, '_pgp_photo_caption', true);
    $photo_credit  = get_post_meta($post->ID, '_pgp_photo_credit', true);

    echo '<div style="font-family:-apple-system,BlinkMacSystemFont,sans-serif; background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:1.15rem;">';
    
    echo '<div style="margin-bottom:1rem;">';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Kicker / Ante-título (Aparece arriba del título):</label>';
    echo '<input type="text" name="pgp_kicker" value="' . esc_attr($kicker) . '" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;" />';
    echo '</div>';
    
    echo '<div style="margin-bottom:1rem;">';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Bajada / Subtítulo (Sustituye el extracto automático):</label>';
    echo '<textarea name="pgp_subtitle" rows="3" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;">' . esc_textarea($subtitle) . '</textarea>';
    echo '</div>';

    echo '<div style="margin-bottom:1rem;">';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">URL del Audio MP3 (Opcional):</label>';
    echo '<input type="text" name="pgp_audio_url" value="' . esc_attr($audio_url) . '" placeholder="https://..." style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;" />';
    echo '</div>';

    echo '<div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">';
    echo '<div>';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Pie de Foto:</label>';
    echo '<input type="text" name="pgp_photo_caption" value="' . esc_attr($photo_caption) . '" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;" />';
    echo '</div>';
    echo '<div>';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Crédito de Imagen (Ej. GCM Noticias / AI Generativa):</label>';
    echo '<input type="text" name="pgp_photo_credit" value="' . esc_attr($photo_credit) . '" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;" />';
    echo '</div>';
    echo '</div>';
    
    echo '</div>';
}

function pressgrid_save_editorial_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['pressgrid_sidebar_meta_box_nonce']) && wp_verify_nonce($_POST['pressgrid_sidebar_meta_box_nonce'], 'pressgrid_save_sidebar_meta_box')) {
        $is_featured_new = isset($_POST['pgp_is_featured']) ? '1' : '0';

        if ($is_featured_new === '1') {
            global $wpdb;
            $wpdb->query($wpdb->prepare(
                "UPDATE {$wpdb->postmeta} SET meta_value = '0' WHERE meta_key = '_pgp_is_featured' AND post_id != %d",
                $post_id
            ));
        }

        update_post_meta($post_id, '_pgp_is_featured', $is_featured_new);
        update_post_meta($post_id, '_pgp_is_secondary', isset($_POST['pgp_is_secondary']) ? '1' : '0');
        update_post_meta($post_id, '_pgp_is_breaking', isset($_POST['pgp_is_breaking']) ? '1' : '0');
    }

    if (isset($_POST['pressgrid_unified_meta_box_nonce']) && wp_verify_nonce($_POST['pressgrid_unified_meta_box_nonce'], 'pressgrid_save_unified_meta_box')) {
        if (isset($_POST['pgp_kicker'])) update_post_meta($post_id, '_pgp_kicker', sanitize_text_field($_POST['pgp_kicker']));
        if (isset($_POST['pgp_subtitle'])) update_post_meta($post_id, '_pgp_subtitle', sanitize_textarea_field($_POST['pgp_subtitle']));
        if (isset($_POST['pgp_audio_url'])) update_post_meta($post_id, '_pgp_audio_url', esc_url_raw($_POST['pgp_audio_url']));
        if (isset($_POST['pgp_photo_caption'])) update_post_meta($post_id, '_pgp_photo_caption', sanitize_text_field($_POST['pgp_photo_caption']));
        if (isset($_POST['pgp_photo_credit'])) update_post_meta($post_id, '_pgp_photo_credit', sanitize_text_field($_POST['pgp_photo_credit']));
    }
}
add_action('save_post', 'pressgrid_save_editorial_meta_boxes');