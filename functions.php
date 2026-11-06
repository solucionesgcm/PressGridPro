<?php
/**
 * Main Theme Functions Loader - PressGrid Pro
 * Version: 19.5.0
 * 
 * @package PressGrid_Pro
 */

if (!defined('ABSPATH')) exit;

// 1. Configuración base y soporte del tema
require_once get_template_directory() . '/includes/setup.php';

// 2. Encolado de estilos y scripts (incluye player.js)
require_once get_template_directory() . '/includes/enqueue.php';

// Herramientas editoriales que solo se necesitan en el escritorio
if (is_admin()) {
    require_once get_template_directory() . '/backend/meta-boxes.php';
    require_once get_template_directory() . '/backend/theme-options.php';
}