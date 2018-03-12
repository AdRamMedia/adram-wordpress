<?php
/**
 * Plugin Name: AdRam
 * Description: Retrieve Adram placement script by it's ID
 * Version: 0.1
 */

require_once plugin_dir_path(__FILE__) . 'includes/adram.php';

add_action('wp_enqueue_scripts', 'adram_scripts', 20);

if (!function_exists('adram_scripts')) {
    function adram_scripts() {
        wp_register_script('adram-placement-script', adram_get_placement_url(), [], null, true);
        wp_enqueue_script('adram-placement-script');
    }
}

if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/adram-admin.php';
}
