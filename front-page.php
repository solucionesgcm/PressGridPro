<?php
/**
 * Front Page Template - PressGrid Pro
 * Version: 16.3.0
 * 
 * @package PressGrid_Pro
 */

get_header(); ?>

<main class="pgp-home-wrapper">
    <div class="container">
        
        <?php 
        // 1. Cargar el Hero Principal de 3 Columnas (Fondo Blanco)
        get_template_part('template-parts/home/hero'); 
        ?>

        <?php 
        // 2. Cargar el Cuerpo Principal (Sub-Hero, Secciones Asimétricas, Grid 3Col y Sidebar integrado)
        get_template_part('template-parts/home/main-content'); 
        ?>

    </div>
</main>

<?php 
get_footer();