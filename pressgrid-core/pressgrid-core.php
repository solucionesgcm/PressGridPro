<?php
/**
 * Plugin Name: PressGrid Core
 * Description: Funciones editoriales de PressGrid Pro.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * Text Domain: pressgrid-core
 *
 * @package PressGrid_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('add_meta_boxes', 'pressgrid_core_register_editorial_meta_boxes', 99);
add_action('save_post_post', 'pressgrid_core_save_editorial_meta_boxes', 10, 2);

function pressgrid_core_register_editorial_meta_boxes() {
    remove_meta_box('gcm_post_metadata_box', 'post', 'normal');
    remove_meta_box('gcm_advanced_meta_box', 'post', 'normal');
    remove_meta_box('gcm_post_meta_box', 'post', 'normal');

    add_meta_box(
        'pressgrid_core_sidebar_editorial',
        __('Visibilidad en portada', 'pressgrid-core'),
        'pressgrid_core_render_sidebar_meta_box',
        'post',
        'side',
        'high'
    );

    add_meta_box(
        'pressgrid_core_editorial_data',
        __('Datos editoriales', 'pressgrid-core'),
        'pressgrid_core_render_editorial_meta_box',
        'post',
        'normal',
        'high'
    );
}

function pressgrid_core_render_sidebar_meta_box($post) {
    wp_nonce_field(
        'pressgrid_core_save_sidebar_meta',
        'pressgrid_core_sidebar_nonce'
    );

    $is_featured = get_post_meta($post->ID, '_pgp_is_featured', true);
    if (!metadata_exists('post', $post->ID, '_pgp_is_featured')) {
        $is_featured = get_post_meta($post->ID, '_gcm_is_featured', true);
    }

    $is_secondary = get_post_meta($post->ID, '_pgp_is_secondary', true);
    if (!metadata_exists('post', $post->ID, '_pgp_is_secondary')) {
        $is_secondary = get_post_meta($post->ID, '_gcm_is_secondary', true);
    }

    $is_breaking = get_post_meta($post->ID, '_pgp_is_breaking', true);
    ?>
    <p>
        <label>
            <input
                type="checkbox"
                name="pgp_is_featured"
                value="1"
                <?php checked($is_featured, '1'); ?>
            />
            <?php esc_html_e('Nota principal de portada', 'pressgrid-core'); ?>
        </label>
    </p>

    <p>
        <label>
            <input
                type="checkbox"
                name="pgp_is_secondary"
                value="1"
                <?php checked($is_secondary, '1'); ?>
            />
            <?php esc_html_e('Nota secundaria de portada', 'pressgrid-core'); ?>
        </label>
    </p>

    <p>
        <label>
            <input
                type="checkbox"
                name="pgp_is_breaking"
                value="1"
                <?php checked($is_breaking, '1'); ?>
            />
            <?php esc_html_e('Mostrar en Al Momento', 'pressgrid-core'); ?>
        </label>
    </p>

    <p>
        <?php esc_html_e('Solo puede haber una nota principal activa.', 'pressgrid-core'); ?>
    </p>
    <?php
}

function pressgrid_core_render_editorial_meta_box($post) {
    wp_nonce_field(
        'pressgrid_core_save_editorial_data',
        'pressgrid_core_editorial_nonce'
    );

    $kicker = get_post_meta($post->ID, '_pgp_kicker', true);
    if (!metadata_exists('post', $post->ID, '_pgp_kicker')) {
        $kicker = get_post_meta($post->ID, '_gcm_kicker', true);
    }

    $subtitle = get_post_meta($post->ID, '_pgp_subtitle', true);
    if (!metadata_exists('post', $post->ID, '_pgp_subtitle')) {
        $subtitle = get_post_meta($post->ID, '_gcm_subtitle', true);
    }

    $audio_url = get_post_meta($post->ID, '_pgp_audio_url', true);
    $photo_caption = get_post_meta($post->ID, '_pgp_photo_caption', true);
    $photo_credit = get_post_meta($post->ID, '_pgp_photo_credit', true);
    ?>
    <p>
        <label for="pgp_kicker">
            <?php esc_html_e('Kicker o antetítulo', 'pressgrid-core'); ?>
        </label>
        <input
            type="text"
            class="widefat"
            id="pgp_kicker"
            name="pgp_kicker"
            value="<?php echo esc_attr($kicker); ?>"
        />
    </p>

    <p>
        <label for="pgp_subtitle">
            <?php esc_html_e('Bajada o subtítulo', 'pressgrid-core'); ?>
        </label>
        <textarea
            class="widefat"
            id="pgp_subtitle"
            name="pgp_subtitle"
            rows="3"
        ><?php echo esc_textarea($subtitle); ?></textarea>
    </p>

    <p>
        <label for="pgp_audio_url">
            <?php esc_html_e('URL del audio', 'pressgrid-core'); ?>
        </label>
        <input
            type="url"
            class="widefat"
            id="pgp_audio_url"
            name="pgp_audio_url"
            value="<?php echo esc_attr($audio_url); ?>"
        />
    </p>

    <p>
        <label for="pgp_photo_caption">
            <?php esc_html_e('Pie de foto', 'pressgrid-core'); ?>
        </label>
        <input
            type="text"
            class="widefat"
            id="pgp_photo_caption"
            name="pgp_photo_caption"
            value="<?php echo esc_attr($photo_caption); ?>"
        />
    </p>

    <p>
        <label for="pgp_photo_credit">
            <?php esc_html_e('Crédito de imagen', 'pressgrid-core'); ?>
        </label>
        <input
            type="text"
            class="widefat"
            id="pgp_photo_credit"
            name="pgp_photo_credit"
            value="<?php echo esc_attr($photo_credit); ?>"
        />
    </p>
    <?php
}

function pressgrid_core_save_editorial_meta_boxes($post_id, $post) {
    if (
        !$post instanceof WP_Post
        || 'post' !== $post->post_type
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || wp_is_post_autosave($post_id)
        || !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    $sidebar_nonce = isset($_POST['pressgrid_core_sidebar_nonce'])
        && is_string($_POST['pressgrid_core_sidebar_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['pressgrid_core_sidebar_nonce']))
        : '';

    if (
        $sidebar_nonce
        && wp_verify_nonce($sidebar_nonce, 'pressgrid_core_save_sidebar_meta')
    ) {
        $is_featured = isset($_POST['pgp_is_featured']) ? '1' : '0';

        if ('1' === $is_featured) {
            $featured_posts = get_posts(
                array(
                    'post_type'      => 'post',
                    'post_status'    => array('publish', 'future', 'draft', 'pending', 'private'),
                    'posts_per_page' => -1,
                    'fields'         => 'ids',
                    'post__not_in'   => array($post_id),
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array(
                            'key'   => '_pgp_is_featured',
                            'value' => '1',
                        ),
                        array(
                            'key'   => '_gcm_is_featured',
                            'value' => '1',
                        ),
                    ),
                )
            );

            foreach ($featured_posts as $featured_post_id) {
                update_post_meta($featured_post_id, '_pgp_is_featured', '0');
                update_post_meta($featured_post_id, '_gcm_is_featured', '0');
            }
        }
        update_post_meta($post_id, '_pgp_is_featured', $is_featured);
        update_post_meta($post_id, '_gcm_is_featured', $is_featured);

        $is_secondary = isset($_POST['pgp_is_secondary']) ? '1' : '0';
        update_post_meta($post_id, '_pgp_is_secondary', $is_secondary);
        update_post_meta($post_id, '_gcm_is_secondary', $is_secondary);

        $is_breaking = isset($_POST['pgp_is_breaking']) ? '1' : '0';
        update_post_meta($post_id, '_pgp_is_breaking', $is_breaking);

        if ('1' === $is_breaking) {
            $breaking_post_ids = get_posts(
                array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'fields'         => 'ids',
                    'meta_query'     => array(
                        array(
                            'key'   => '_pgp_is_breaking',
                            'value' => '1',
                        ),
                    ),
                    'orderby'        => array(
                        'date' => 'DESC',
                        'ID'   => 'DESC',
                    ),
                )
            );

            foreach (array_slice($breaking_post_ids, 5) as $old_post_id) {
                update_post_meta($old_post_id, '_pgp_is_breaking', '0');
            }
        }
    }

    $editorial_nonce = isset($_POST['pressgrid_core_editorial_nonce'])
        && is_string($_POST['pressgrid_core_editorial_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['pressgrid_core_editorial_nonce']))
        : '';

    if (
        !$editorial_nonce
        || !wp_verify_nonce($editorial_nonce, 'pressgrid_core_save_editorial_data')
    ) {
        return;
    }

    if (isset($_POST['pgp_kicker']) && is_string($_POST['pgp_kicker'])) {
        $kicker = sanitize_text_field(wp_unslash($_POST['pgp_kicker']));
        update_post_meta($post_id, '_pgp_kicker', $kicker);
        update_post_meta($post_id, '_gcm_kicker', $kicker);
    }

    if (isset($_POST['pgp_subtitle']) && is_string($_POST['pgp_subtitle'])) {
        $subtitle = sanitize_textarea_field(wp_unslash($_POST['pgp_subtitle']));
        update_post_meta($post_id, '_pgp_subtitle', $subtitle);
        update_post_meta($post_id, '_gcm_subtitle', $subtitle);
    }

    if (isset($_POST['pgp_audio_url']) && is_string($_POST['pgp_audio_url'])) {
        update_post_meta(
            $post_id,
            '_pgp_audio_url',
            esc_url_raw(wp_unslash($_POST['pgp_audio_url']))
        );
    }

    if (isset($_POST['pgp_photo_caption']) && is_string($_POST['pgp_photo_caption'])) {
        update_post_meta(
            $post_id,
            '_pgp_photo_caption',
            sanitize_text_field(wp_unslash($_POST['pgp_photo_caption']))
        );
    }

    if (isset($_POST['pgp_photo_credit']) && is_string($_POST['pgp_photo_credit'])) {
        update_post_meta(
            $post_id,
            '_pgp_photo_credit',
            sanitize_text_field(wp_unslash($_POST['pgp_photo_credit']))
        );
    }
}