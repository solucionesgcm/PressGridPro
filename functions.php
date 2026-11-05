<?php
/**
 * Functions and definitions - PressGrid Pro
 * Version: 17.8.0
 * 
 * @package PressGrid_Pro
 */

if (!defined('ABSPATH')) exit;

require_once get_template_directory() . '/inc/theme-options.php';

function pressgrid_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    register_sidebar(array(
        'name'          => __('Barra Lateral (Sidebar)', 'pressgrid'),
        'id'            => 'sidebar-1',
        'description'   => __('Widgets en la barra lateral de artículos.', 'pressgrid'),
        'before_widget' => '<div id="%1$s" class="gcm-sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_nav_menus(array(
        'primary' => __('Menú Principal', 'pressgrid'),
        'footer'  => __('Menú Pie de Página', 'pressgrid'),
    ));
}
add_action('after_setup_theme', 'pressgrid_setup');

function pressgrid_enqueue_scripts() {
    wp_enqueue_style('pressgrid-google-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,500;0,600;0,700;0,800;1,700&family=DM+Mono:wght@500;700&family=Inter:wght@400;500;600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;1,300&display=swap', array(), null);
    
    $theme = wp_get_theme();
    $style_version = $theme->get('Version');

    wp_enqueue_style('pressgrid-style', get_stylesheet_uri(), array('pressgrid-google-fonts'), $style_version);
}
add_action('wp_enqueue_scripts', 'pressgrid_enqueue_scripts');

/* ==========================================================================
   METABOXES EDITORIALES DE PORTADA Y DATOS AVANZADOS
   ========================================================================== */

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

    echo '<p style="font-size:0.75rem; color:#64748b; margin-top:0.5rem; line-height:1.3;">Si no marcas casillas, el sistema acomodará automáticamente las notas más recientes sin repetir contenidos.</p>';
    
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

    // Guardado de Visibilidad Portada
    if (isset($_POST['pressgrid_sidebar_meta_box_nonce']) && wp_verify_nonce($_POST['pressgrid_sidebar_meta_box_nonce'], 'pressgrid_save_sidebar_meta_box')) {
        update_post_meta($post_id, '_pgp_is_featured', isset($_POST['pgp_is_featured']) ? '1' : '0');
        update_post_meta($post_id, '_pgp_is_secondary', isset($_POST['pgp_is_secondary']) ? '1' : '0');
        update_post_meta($post_id, '_pgp_is_breaking', isset($_POST['pgp_is_breaking']) ? '1' : '0');
    }

    // Guardado de Datos Avanzados
    if (isset($_POST['pressgrid_unified_meta_box_nonce']) && wp_verify_nonce($_POST['pressgrid_unified_meta_box_nonce'], 'pressgrid_save_unified_meta_box')) {
        if (isset($_POST['pgp_kicker'])) update_post_meta($post_id, '_pgp_kicker', sanitize_text_field($_POST['pgp_kicker']));
        if (isset($_POST['pgp_subtitle'])) update_post_meta($post_id, '_pgp_subtitle', sanitize_textarea_field($_POST['pgp_subtitle']));
        if (isset($_POST['pgp_audio_url'])) update_post_meta($post_id, '_pgp_audio_url', esc_url_raw($_POST['pgp_audio_url']));
        if (isset($_POST['pgp_photo_caption'])) update_post_meta($post_id, '_pgp_photo_caption', sanitize_text_field($_POST['pgp_photo_caption']));
        if (isset($_POST['pgp_photo_credit'])) update_post_meta($post_id, '_pgp_photo_credit', sanitize_text_field($_POST['pgp_photo_credit']));
    }
}
add_action('save_post', 'pressgrid_save_editorial_meta_boxes');