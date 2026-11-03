<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container header-container">
        <div class="logo">
            <h1><a href="<?php echo esc_url(home_url('/')); ?>">GCM<span class="highlight">NOTICIAS</span></a></h1>
        </div>
        <nav class="main-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'fallback_cb'    => false,
            ));
            ?>
        </nav>
    </div>
</header>
