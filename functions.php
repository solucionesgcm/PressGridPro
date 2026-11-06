<?php
/**
 * Main Theme Functions Loader - PressGrid Pro
 * Version: 19.5.0
 * 
 * @package PressGrid_Pro
 */

if (!defined('ABSPATH')) exit;

// 1. Configuración base y soporte del tema
require_once get_template_directory() . '/inc/setup.php';

// 2. Encolado de estilos y scripts (incluye player.js)
require_once get_template_directory() . '/inc/enqueue.php';

// 3. Metaboxes editoriales para el admin
require_once get_template_directory() . '/inc/meta-boxes.php';

// 4. Opciones del tema
require_once get_template_directory() . '/inc/theme-options.php';