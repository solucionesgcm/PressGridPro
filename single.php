<?php
/**
 * Single Article Template - PressGrid Pro
 *
 * @package PressGrid_Pro
 */

get_header();

while (have_posts()) :
    the_post();
    get_template_part('templates/single/layouts/default');
endwhile;

get_footer();