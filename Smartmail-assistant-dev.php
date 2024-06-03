<?php
/**
 * Plugin Name: SmartMail Assistant Dev
 * Description: A WordPress plugin for SmartMail Assistant Dev functionality.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Plugin URI: https://example.com
 */

// Prevent direct access to the file
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
        6
    );
}
add_action('admin_menu', 'smartmail_dev_admin_menu');

// Admin page callback
function smartmail_dev_admin_page() {
    echo '<div class="wrap">';
    echo '<h1>SmartMail Assistant Dev</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields('smartmail_dev_options_group');
    do_settings_sections('smartmail-dev');
    submit_button();
    echo '</form>';
    echo '</div>';
}

// Register settings
function smartmail_dev_register_settings() {
    register_setting('smartmail_dev_options_group', 'smartmail_dev_options');
    add_settings_section('smartmail_dev_main_section', 'Main Settings', 'smartmail_dev_section_callback', 'smartmail-dev');
    add_settings_field('smartmail_dev_field', 'API Key', 'smartmail_dev_field_callback', 'smartmail-dev', 'smartmail_dev_main_section');
}
add_action('admin_init', 'smartmail_dev_register_settings');

// Section callback
function smartmail_dev_section_callback() {
    echo 'Enter your settings below:';
}

// Field callback
function smartmail_dev_field_callback() {
    $options = get_option('smartmail_dev_options');
    echo '<input type="text" name="smartmail_dev_options[api_key]" value="' . esc_attr($options['api_key']) . '">';
}
