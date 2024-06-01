<?php
// Admin settings for SmartMail Assistant Developer Plugin

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
