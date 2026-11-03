<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- 1. HERO OSCURO SUPERIOR ESTILO NBC NEWS -->
        <section class="gcm-single-hero-dark">
            <div class="container">
                <div class="gcm-nbc-master-grid">
                    
                    <div class="gcm-hero-category">
                        <?php
                        $meta_kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
                        if (!empty($meta_kicker)) {
                            echo esc_html($meta_kicker);
                        } else {
                            $categories = get_the_category();
                            echo !empty($categories) ? esc_html($categories[0]->name) : 'TECNOLOGÍA + FINANZAS';
                        }
                        ?>
                    </div>

                    <div class="gcm-hero-main-col">
                        <h1 class="gcm-hero-headline"><?php the_title(); ?></h1>
                        
                        <?php 
                        $meta_subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                        if (!empty($meta_subtitle)) :
                        ?>
                            <div class="gcm-hero-subtitle"><?php echo esc_html($meta_subtitle); ?></div>
                        <?php elseif (has_excerpt()) : ?>
                            <div class="gcm-hero-subtitle"><?php echo get_the_excerpt(); ?></div>
                        <?php else : ?>
                            <div class="gcm-hero-subtitle"><?php echo wp_trim_words(get_the_content(), 28, '...'); ?></div>
                        <?php endif; ?>

                        <!-- PLAYER DE AUDIO ENCABEZADO CON LUCIDE PLAY ICON -->
                        <div class="gcm-audio-player-bar">
                            <div class="audio-play-btn">
                                <!-- Lucide Play Icon -->
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                            </div>
                            <div class="audio-info">
                                Escuchar versión narrada por IA (04:15)
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 2. CUERPO PRINCIPAL DEL ARTÍCULO (IMAGEN DESTACADA Y CONTENIDO) -->
        <section class="gcm-single-body-area">
            <div class="container">
                <div class="gcm-nbc-master-grid">
                    
                    <div class="gcm-layout-left-spacer"></div>

                    <div class="gcm-hero-main-col">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="gcm-feat-hero-media-wrapper">
                                <div class="gcm-feat-hero-media">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="gcm-nbc-sub-grid">
                            
                            <main class="gcm-article-main">
                                <div class="byline-date-block">
                                    <span class="pub-date">Por <?php the_author(); ?> — <?php echo get_the_date('j \d\e F, Y — g:i A'); ?></span>
                                </div>

                                <div class="post-content">
                                    <?php the_content(); ?>
                                </div>
                            </main>

                            <aside class="gcm-sidebar">
                                <?php if (is_active_sidebar('sidebar-1')) : ?>
                                    <?php dynamic_sidebar('sidebar-1'); ?>
                                <?php else : ?>
                                    <div class="gcm-sidebar-widget">
                                        <h3 class="widget-title">Lo Más Leído</h3>
                                        <?php
                                        $recent_posts = new WP_Query(array('posts_per_page' => 4, 'post__not_in' => array(get_the_ID()), 'ignore_sticky_posts' => true));
                                        if ($recent_posts->have_posts()) :
                                            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                                        ?>
                                            <a href="<?php the_permalink(); ?>" class="sidebar-news-card-nbc">
                                                <div class="sidebar-thumb-top-32">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail('medium'); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="sidebar-card-info-nbc">
                                                    <h4><?php the_title(); ?></h4>
                                                    <span class="meta-time"><?php echo get_the_date('M j, Y'); ?></span>
                                                </div>
                                            </a>
                                        <?php
                                            endwhile;
                                            wp_reset_postdata();
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </aside>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
