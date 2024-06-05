<?php
/**
 * Plugin Name: SmartMail Assistant Dev
 * Plugin URI: https://smartmail.store
 * Description: Development and management plugin for SmartMail Assistant, including subscription control.
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

// Admin menu for subscription management
function smartmail_dev_admin_menu() {
    add_menu_page(
        'SmartMail Dev',
        'SmartMail Dev',
        'manage_options',
        'smartmail-dev',
        'smartmail_dev_admin_page',
        'dashicons-admin-generic',
        6
    );
}
add_action('admin_menu', 'smartmail_dev_admin_menu');

// Admin page content for subscription management
function smartmail_dev_admin_page() {
    ?>
    <div class="wrap">
        <h1>SmartMail Dev</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_dev_options_group');
            do_settings_sections('smartmail-dev');
            submit_button();
            ?>
        </form>
        <h2>Subscription Management</h2>
        <form method="post">
            <input type="hidden" name="smartmail_dev_update_subscription" value="1">
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id">
            <label for="subscription_level">Subscription Level:</label>
            <select id="subscription_level" name="subscription_level">
                <option value="free">Free</option>
                <option value="trial">Trial</option>
                <option value="subscription">Subscription</option>
            </select>
            <?php submit_button('Update Subscription'); ?>
        </form>
        <?php
        if (isset($_POST['smartmail_dev_update_subscription']) && check_admin_referer()) {
            $user_id = intval($_POST['user_id']);
            $subscription_level = sanitize_text_field($_POST['subscription_level']);
            update_user_meta($user_id, 'smartmail_subscription_level', $subscription_level);
            echo '<p>Subscription updated successfully.</p>';
        }
        ?>
    </div>
    <?php
}

// Register settings for the dev plugin
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
