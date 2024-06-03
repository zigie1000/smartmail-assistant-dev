<?php
// Add admin settings page
function smartmail_dev_admin_settings() {
    add_options_page(
        'SmartMail Assistant Dev Settings',
        'SmartMail Assistant Dev',
        'manage_options',
        'smartmail-dev',
        'smartmail_dev_admin_settings_page'
    );
}
add_action('admin_menu', 'smartmail_dev_admin_settings');

// Admin settings page content
function smartmail_dev_admin_settings_page() {
    echo '<div class="wrap">';
    echo '<h1>SmartMail Assistant Dev Settings</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields('smartmail_dev_options_group');
    do_settings_sections('smartmail-dev');
    submit_button();
    echo '</form>';
    echo '</div>';
}

// Register and define the settings
function smartmail_dev_register_settings() {
    register_setting('smartmail_dev_options_group', 'smartmail_dev_options');
    add_settings_section('smartmail_dev_main_section', 'Main Settings', 'smartmail_dev_section_callback', 'smartmail-dev');
    add_settings_field('smartmail_dev_field', 'API Key', 'smartmail_dev_field_callback', 'smartmail-dev', 'smartmail_dev_main_section');
}
add_action('admin_init', 'smartmail_dev_register_settings');

// Section callback
function smartmail_dev_section_callback() {
    echo 'Enter your SmartMail Dev settings below:';
}

// Field callback
function smartmail_dev_field_callback() {
    $options = get_option('smartmail_dev_options');
    echo '<input type="text" name="smartmail_dev_options[api_key]" value="' . esc_attr($options['api_key']) . '">';
}
?>
