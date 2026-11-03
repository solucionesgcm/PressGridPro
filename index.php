<?php get_header(); ?>
<main class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div><?php the_excerpt(); ?></div>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
