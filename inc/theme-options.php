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

// 1. REGISTRO SEGURO DE OPCIONES
function pressgrid_register_settings() {
    register_setting('pressgrid_options_group', 'pressgrid_options', array(
        'sanitize_callback' => 'pressgrid_sanitize_options'
    ));
}
add_action('admin_init', 'pressgrid_register_settings');

// 2. FUNCIÓN DE SEGURIDAD (Limpia los datos antes de guardarlos)
function pressgrid_sanitize_options($input) {
    if (!is_array($input)) return $input;
    
    $clean = array();
    if (isset($input['live_status'])) $clean['live_status'] = $input['live_status'] === '1' ? '1' : '0';
    if (isset($input['live_title'])) $clean['live_title'] = sanitize_text_field($input['live_title']);
    if (isset($input['live_subtitle'])) $clean['live_subtitle'] = sanitize_textarea_field($input['live_subtitle']);
    if (isset($input['live_url'])) $clean['live_url'] = esc_url_raw($input['live_url']);
    if (isset($input['ticker_text'])) $clean['ticker_text'] = sanitize_text_field($input['ticker_text']);
    
    return $clean;
}

// 3. RENDERIZADO DEL PANEL
function pressgrid_render_options_page() {
    $options = get_option('pressgrid_options', array(
        'live_status'   => '0',
        'live_title'    => 'Elecciones Presidenciales 2027: Cobertura en Vivo',
        'live_subtitle' => 'El conteo oficial de actas avanza tras el cierre de casillas en todo el país.',
        'live_url'      => '#',
        'ticker_text'   => 'ÚLTIMA HORA: Mercados reaccionan ante nuevos anuncios de la FED'
    ));
    ?>
    <div class="pressgrid-admin-wrap">
        <div class="pressgrid-admin-header">
            <h1>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                PRESSGRID PRO — Panel de Control Editorial
            </h1>
            <span class="badge">v10.38.0 B2B</span>
        </div>
        
        <div class="pressgrid-dashboard-container">
            
            <!-- 4. MENÚ LATERAL LIMPIO (Sin botones falsos) -->
            <div class="pressgrid-admin-sidebar">
                <div class="pressgrid-nav-item active">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.9 19.1C1 15.2 1 8.8 4.9 4.9"/><path d="M7.8 16.2c-2.3-2.3-2.3-6.1 0-8.5"/><circle cx="12" cy="12" r="2"/><path d="M16.2 7.8c2.3 2.3 2.3 6.1 0 8.5"/><path d="M19.1 4.9c3.9 3.9 3.9 10.3 0 14.2"/></svg>
                    Cobertura y Ticker
                </div>
            </div>

            <div class="pressgrid-admin-content">
                <form method="post" action="options.php">
                    <?php settings_fields('pressgrid_options_group'); ?>
                    
                    <!-- TARJETA 1: COBERTURA EN VIVO -->
                    <div class="pressgrid-card">
                        <div class="pressgrid-card-title">
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

                    <!-- TARJETA 2: TICKER SUPERIOR -->
                    <div class="pressgrid-card">
                        <div class="pressgrid-card-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>
                            Control del Ticker Superior (Última Hora)
                        </div>
                        
                        <div class="pressgrid-field">
                            <label for="ticker_text">Texto de Última Hora (Barra negra superior):</label>
                            <input type="text" id="ticker_text" name="pressgrid_options[ticker_text]" value="<?php echo esc_attr($options['ticker_text'] ?? ''); ?>" placeholder="Ej. ÚLTIMA HORA: ..." />
                        </div>
                    </div>

                    <?php submit_button('Guardar Configuración Editorial', 'pressgrid-submit-btn'); ?>
                </form>
            </div>

        </div>
    </div>
    <?php
} ?>
