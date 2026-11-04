<?php get_header(); ?>

<?php get_template_part('template-parts/home/ticker'); ?>

<main class="container gcm-home-wrapper">
    <?php get_template_part('template-parts/home/hero'); ?>
</main>

<?php get_template_part('template-parts/home/multimedia'); ?>

<main class="container gcm-home-wrapper" style="padding-top: 1.5rem;">
    <div class="foxiz-main-layout">
        <div class="foxiz-content-col">
            <?php get_template_part('template-parts/home/main-content'); ?>
        </div>
        <aside class="foxiz-sidebar-col">
            <?php get_template_part('template-parts/home/sidebar'); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>