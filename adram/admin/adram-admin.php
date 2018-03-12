<?php

add_action('admin_menu', 'adram_setup_menu');
add_action('admin_init', 'adram_register_settings');

if (!function_exists('adram_setup_menu')) {
    function adram_setup_menu() {
        add_options_page('AdRam Plugin Page', 'AdRam', 'manage_options', 'adram-plugin', 'adram_admin_init');
    }
}

if (!function_exists('adram_register_settings')) {
    function adram_register_settings() {
        register_setting('adram-options', 'adram-placement-id', [
            'type' => 'string',
            'description' => 'AdRam service placement ID',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
        ]);
        register_setting('adram-options', 'adram-placement-cache-lifetime', [
            'type' => 'integer',
            'description' => 'AdRam placement cache lifetime in seconds',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 86400 * 7, // 1 week
        ]);
    }
}

if (!function_exists('adram_admin_init')) {
    function adram_admin_init () {
        ?>
        <div class="wrap">
        <h1>AdRam Plugin</h1>
        <form method="post" action="options.php">
        <?php settings_fields('adram-options'); ?>
        <?php do_settings_sections('adram-options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Placement ID:</th>
                <td><input type="text" name="adram-placement-id" value="<?php echo esc_attr(get_option('adram-placement-id')) ?>"></td>
            </tr>
            <tr valign="top">
                <th scope="row">Cache Lifetime:</th>
                <td><input type="number" name="adram-placement-cache-lifetime" value="<?php echo esc_attr(get_option('adram-placement-cache-lifetime')) ?>"></td>
            </tr>
        </table>
        <?php submit_button('Update'); ?>
        </form>
        <?php
    }
}
