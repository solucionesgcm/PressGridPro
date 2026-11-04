<?php get_header(); ?>

<main class="container gcm-home-wrapper" style="display: flex; align-items: center; justify-content: center; min-height: 60vh; text-align: center;">
    <div style="max-width: 600px;">
        <h1 style="font-size: 7rem; font-weight: 900; color: #dc2626; margin: 0; line-height: 1; letter-spacing: -3px;">404</h1>
        <h2 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 1rem 0;">Página no encontrada</h2>
        <p style="color: #64748b; margin-bottom: 2.5rem; font-size: 1.1rem;">La nota que buscas fue movida, eliminada o la dirección está mal escrita.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" style="background: #0f172a; color: #ffffff; padding: 0.85rem 2rem; font-weight: 800; border-radius: 4px; text-decoration: none; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; transition: background 0.2s;">Volver a la Portada</a>
    </div>
</main>

<?php get_footer(); ?>