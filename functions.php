<?php
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

// ENCOLE DE ESTILOS Y FUENTES CON CACHE-BUSTING
function pressgrid_enqueue_scripts() {
    wp_enqueue_style('pressgrid-google-fonts', 'https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,400&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Inter:wght@400;500;600;700;800;900&display=swap', array(), null);
    
    wp_enqueue_style('pressgrid-style', get_stylesheet_uri(), array('pressgrid-google-fonts'), '10.38.0');
}
add_action('wp_enqueue_scripts', 'pressgrid_enqueue_scripts');

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

    $is_featured  = get_post_meta($post->ID, '_gcm_is_featured', true);
    $is_secondary = get_post_meta($post->ID, '_gcm_is_secondary', true);
    
    echo '<div style="font-family:-apple-system,BlinkMacSystemFont,sans-serif;">';
    echo '<label style="display:flex; align-items:center; gap:0.5rem; font-weight:700; font-size:0.825rem; margin-bottom:0.4rem;">';
    echo '<input type="checkbox" name="gcm_is_featured" value="1" ' . checked($is_featured, '1', false) . ' /> Nota Principal (Hero Col 1)';
    echo '</label>';
    echo '<label style="display:flex; align-items:center; gap:0.5rem; font-weight:700; font-size:0.825rem; margin-bottom:0.4rem;">';
    echo '<input type="checkbox" name="gcm_is_secondary" value="1" ' . checked($is_secondary, '1', false) . ' /> Nota Secundaria (Hero Col 2)';
    echo '</label>';
    echo '</div>';
}

function pressgrid_render_unified_meta_box($post) {
    wp_nonce_field('pressgrid_save_unified_meta_box', 'pressgrid_unified_meta_box_nonce');

    $kicker   = get_post_meta($post->ID, '_gcm_kicker', true);
    $subtitle = get_post_meta($post->ID, '_gcm_subtitle', true);

    echo '<div style="font-family:-apple-system,BlinkMacSystemFont,sans-serif; background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:1.15rem;">';
    echo '<div style="margin-bottom:1rem;">';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Kicker / Ante-título:</label>';
    echo '<input type="text" name="gcm_kicker" value="' . esc_attr($kicker) . '" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;" />';
    echo '</div>';
    echo '<div>';
    echo '<label style="display:block; font-weight:700; font-size:0.825rem; margin-bottom:0.3rem;">Bajada / Subtítulo:</label>';
    echo '<textarea name="gcm_subtitle" rows="3" style="width:100%; padding:0.5rem; border:1px solid #cbd5e1; border-radius:4px;">' . esc_textarea($subtitle) . '</textarea>';
    echo '</div>';
    echo '</div>';
}

function pressgrid_save_unified_meta_box($post_id) {
    if (isset($_POST['pressgrid_sidebar_meta_box_nonce']) && wp_verify_nonce($_POST['pressgrid_sidebar_meta_box_nonce'], 'pressgrid_save_sidebar_meta_box')) {
        update_post_meta($post_id, '_gcm_is_featured', isset($_POST['gcm_is_featured']) ? '1' : '0');
        update_post_meta($post_id, '_gcm_is_secondary', isset($_POST['gcm_is_secondary']) ? '1' : '0');
    }

    if (!isset($_POST['pressgrid_unified_meta_box_nonce']) || !wp_verify_nonce($_POST['pressgrid_unified_meta_box_nonce'], 'pressgrid_save_unified_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['gcm_kicker'])) update_post_meta($post_id, '_gcm_kicker', sanitize_text_field($_POST['gcm_kicker']));
    if (isset($_POST['gcm_subtitle'])) update_post_meta($post_id, '_gcm_subtitle', sanitize_textarea_field($_POST['gcm_subtitle']));
}
add_action('save_post', 'pressgrid_save_unified_meta_box');
?>
