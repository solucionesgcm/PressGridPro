<?php
if (!defined('ABSPATH')) exit;

function pressgrid_add_admin_menu() {
    add_menu_page(
        'PressGrid Pro',
        'PressGrid Pro',
        'manage_options',
        'pressgrid_options',
        'pressgrid_render_options_page',
        'dashicons-newspaper',
        3
    );
}
add_action('admin_menu', 'pressgrid_add_admin_menu');

function pressgrid_admin_styles($hook) {
    if ($hook != 'toplevel_page_pressgrid_options') return;
    wp_enqueue_style('pressgrid-admin-css', get_template_directory_uri() . '/inc/admin-style.css', array(), '10.38.0');
}
add_action('admin_enqueue_scripts', 'pressgrid_admin_styles');

function pressgrid_register_settings() {
    register_setting('pressgrid_options_group', 'pressgrid_options');
}
add_action('admin_init', 'pressgrid_register_settings');

function pressgrid_render_options_page() {
    $options = get_option('pressgrid_options', array(
        'live_status'   => '0',
        'live_title'    => 'Elecciones Presidenciales 2027: Cobertura en Vivo',
        'live_subtitle' => 'El conteo oficial de actas avanza tras el cierre de casillas en todo el país.',
        'live_url'      => '#'
    ));
    ?>
    <div class="pressgrid-admin-wrap">
        <div class="pressgrid-admin-header">
            <h1>
                <!-- Lucide LayoutGrid Icon -->
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                PRESSGRID PRO — Panel de Control Editorial
            </h1>
            <span class="badge">v10.38.0 B2B</span>
        </div>
        
        <div class="pressgrid-dashboard-container">
            
            <div class="pressgrid-admin-sidebar">
                <div class="pressgrid-nav-item active">
                    <!-- Lucide Radio/Live Icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.9 19.1C1 15.2 1 8.8 4.9 4.9"/><path d="M7.8 16.2c-2.3-2.3-2.3-6.1 0-8.5"/><circle cx="12" cy="12" r="2"/><path d="M16.2 7.8c2.3 2.3 2.3 6.1 0 8.5"/><path d="M19.1 4.9c3.9 3.9 3.9 10.3 0 14.2"/></svg>
                    Cobertura en Vivo
                </div>
                <div class="pressgrid-nav-item">
                    <!-- Lucide Settings Icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.38a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.72v-.51a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    Ajustes Generales
                </div>
                <div class="pressgrid-nav-item">
                    <!-- Lucide Layers Icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 12.5-8.58 3.91a2 2 0 0 1-1.66 0L3.18 12.5"/><path d="m22 17.5-8.58 3.91a2 2 0 0 1-1.66 0L3.18 17.5"/></svg>
                    Layout & Hero
                </div>
            </div>

            <div class="pressgrid-admin-content">
                <form method="post" action="options.php">
                    <?php settings_fields('pressgrid_options_group'); ?>
                    
                    <div class="pressgrid-card">
                        <div class="pressgrid-card-title">
                            <!-- Lucide Video Icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 8-6 4 6 4V8Z"/><rect width="14" height="12" x="2" y="6" rx="2"/></svg>
                            Control de Cobertura en Vivo (Columna 3 Hero)
                        </div>
                        
                        <div class="pressgrid-field">
                            <div class="pressgrid-toggle-wrapper">
                                <input type="checkbox" id="live_status" name="pressgrid_options[live_status]" value="1" <?php checked(isset($options['live_status']) && $options['live_status'] == '1'); ?> />
                                <label for="live_status">ACTIVAR COBERTURA EN VIVO EN PORTADA</label>
                            </div>
                            <p style="font-size:0.75rem; color:#64748b; margin-top:0.35rem;">Al activar esta casilla, el módulo en vivo toma el control total de la Columna 3 del Hero en lugar de "Al Momento".</p>
                        </div>

                        <div class="pressgrid-field">
                            <label for="live_title">Título de la Cobertura (Encabezado Principal):</label>
                            <input type="text" id="live_title" name="pressgrid_options[live_title]" value="<?php echo esc_attr($options['live_title'] ?? ''); ?>" placeholder="Ej. Elecciones Presidenciales 2027" />
                        </div>

                        <div class="pressgrid-field">
                            <label for="live_subtitle">Subtítulo / Estado del Directo:</label>
                            <textarea id="live_subtitle" name="pressgrid_options[live_subtitle]" rows="3" placeholder="Ej. Conteo oficial de votos en desarrollo..."><?php echo esc_textarea($options['live_subtitle'] ?? ''); ?></textarea>
                        </div>

                        <div class="pressgrid-field">
                            <label for="live_url">Enlace al Seguimiento Minuto a Minuto (URL):</label>
                            <input type="text" id="live_url" name="pressgrid_options[live_url]" value="<?php echo esc_attr($options['live_url'] ?? '#'); ?>" placeholder="https://..." />
                        </div>
                    </div>

                    <?php submit_button('Guardar Configuración Editorial', 'pressgrid-submit-btn'); ?>
                </form>
            </div>

        </div>
    </div>
    <?php
}
