<?php
/**
 * Plugin Name: SmartMail Assistant Developer
 * Description: Developer version of SmartMail Assistant for managing subscriptions and API integrations.
 * Version: 1.0.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SMARTMAIL_DEV_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SMARTMAIL_DEV_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/admin-settings.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/api-functions.php';

// Activation hook
function smartmail_dev_activate() {
    // Activation code here
}
register_activation_hook(__FILE__, 'smartmail_dev_activate');

// Deactivation hook
function smartmail_dev_deactivate() {
    // Deactivation code here
}
register_deactivation_hook(__FILE__, 'smartmail_dev_deactivate');

// Admin menu
function smartmail_dev_admin_menu() {
    add_menu_page(
        'SmartMail Assistant Dev',
        'SmartMail Dev',
        'manage_options',
        'smartmail-dev',
        'smartmail_dev_admin_page',
        'dashicons-admin-generic',
        90
    );
}
add_action('admin_menu', 'smartmail_dev_admin_menu');

// Admin page content
function smartmail_dev_admin_page() {
    ?>
    <div class="wrap">
        <h1>SmartMail Assistant Developer</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_dev_settings');
            do_settings_sections('smartmail-dev');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function smartmail_dev_register_settings() {
    register_setting('smartmail_dev_settings', 'smartmail_dev_api_key');
    add_settings_section('smartmail_dev_section', 'API Settings', null, 'smartmail-dev');
    add_settings_field('smartmail_dev_api_key', 'API Key', 'smartmail_dev_api_key_callback', 'smartmail-dev', 'smartmail_dev_section');
}
add_action('admin_init', 'smartmail_dev_register_settings');

// API Key field callback
function smartmail_dev_api_key_callback() {
    $api_key = get_option('smartmail_dev_api_key');
    echo '<input type="text" name="smartmail_dev_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
}
?>
