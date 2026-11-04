<?php get_header(); ?>

<!-- TICKER SUPERIOR -->
<?php get_template_part('template-parts/home/ticker'); ?>

<main class="container gcm-home-wrapper">
    <!-- 1. SECCIÓN HERO -->
    <?php get_template_part('template-parts/home/hero'); ?>
</main>

<!-- 2. STRIP MULTIMEDIA -->
<?php get_template_part('template-parts/home/multimedia'); ?>

<main class="container gcm-home-wrapper" style="padding-top: 1.5rem;">
    <div class="foxiz-main-layout">
        
        <!-- 3. CONTENIDO PRINCIPAL -->
        <div class="foxiz-content-col">
            <?php get_template_part('template-parts/home/main-content'); ?>
        </div>

        <!-- 4. SIDEBAR -->
        <?php get_template_part('template-parts/home/sidebar'); ?>

    </div>
</main>

<?php get_footer(); ?>