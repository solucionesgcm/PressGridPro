<?php
/**
 * Scripts & Styles Enqueue Loader - PressGrid Pro
 * Version: 19.5.0
 */

if (!defined('ABSPATH')) exit;

function pressgrid_enqueue_scripts() {
    wp_enqueue_style(
        'pressgrid-google-fonts', 
        'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,500;0,600;0,700;0,800;1,700&family=DM+Mono:wght@500;700&family=Inter:wght@400;500;600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;1,300&display=swap', 
        array(), 
        null
    );
    
    $theme = wp_get_theme();
    $style_version = $theme->get('Version');

    wp_enqueue_style('pressgrid-style', get_stylesheet_uri(), array('pressgrid-google-fonts'), $style_version);

    // Cargar reproductor nativo de voz exclusivamente en entradas individuales
    if (is_single()) {
        wp_enqueue_script(
            'pressgrid-player',
            get_template_directory_uri() . '/assets/js/player.js',
            array(),
            $style_version,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'pressgrid_enqueue_scripts');