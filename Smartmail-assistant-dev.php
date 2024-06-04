<?php
/**
 * Plugin Name: SmartMail Assistant Dev
 * Plugin URI: https://smartmail.store
 * Description: Development version of the SmartMail Assistant plugin.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 * License: MIT
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define('SMARTMAIL_DEV_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SMARTMAIL_DEV_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/admin-settings.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/api-functions.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/class-wc-gateway-pi.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/shortcodes.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/subscription-functions.php';

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
        6
    );
}
add_action('admin_menu', 'smartmail_dev_admin_menu');

// Admin page content
function smartmail_dev_admin_page() {
    ?>
    <div class="wrap">
        <h1>SmartMail Assistant Dev</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_dev_options_group');
            do_settings_sections('smartmail-dev');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function smartmail_dev_register_settings() {
    register_setting('smartmail_dev_options_group', 'smartmail_dev_option_name');
    add_settings_section('smartmail_dev_main_section', 'Main Settings', 'smartmail_dev_main_section_cb', 'smartmail-dev');
    add_settings_field('smartmail_dev_option_name', 'Option Name', 'smartmail_dev_option_name_cb', 'smartmail-dev', 'smartmail_dev_main_section');
}
add_action('admin_init', 'smartmail_dev_register_settings');

function smartmail_dev_main_section_cb() {
    echo '<p>Main description of this section here.</p>';
}

function smartmail_dev_option_name_cb() {
    $setting = get_option('smartmail_dev_option_name');
    echo "<input type='text' name='smartmail_dev_option_name' value='" . esc_attr($setting) . "'>";
}
?>
