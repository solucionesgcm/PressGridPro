<?php
/**
 * Theme Setup & Registrations - PressGrid Pro
 * Version: 19.5.0
 */

if (!defined('ABSPATH')) exit;

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