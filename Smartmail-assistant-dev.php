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

// Check for required dependencies
function smartmail_dev_check_dependencies() {
    $missing_dependencies = array();

    if (!function_exists('wp_remote_get')) {
        $missing_dependencies[] = 'wp_remote_get function (WordPress core)';
    }

    if (!class_exists('WooCommerce')) {
        $missing_dependencies[] = 'WooCommerce';
    }

    if (!empty($missing_dependencies)) {
        deactivate_plugins(plugin_basename(__FILE__));
        $message = 'The following dependencies are missing: ' . implode(', ', $missing_dependencies);
        wp_die($message);
    }
}
add_action('admin_init', 'smartmail_dev_check_dependencies');

// Include necessary files
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/admin-settings.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/api-functions.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/class-wc-gateway-pi.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/shortcodes.php';
require_once SMARTMAIL_DEV_PLUGIN_PATH . 'includes/subscription-functions.php';

// Activation hook
function smartmail_dev_activate() {
    try {
        // Add activation code here
        error_log('SmartMail Assistant Dev plugin activated successfully.');
    } catch (Exception $e) {
        error_log('SmartMail Assistant Dev activation error: ' . $e->getMessage());
        wp_die('SmartMail Assistant Dev activation error: ' . $e->getMessage());
    }
}
register_activation_hook(__FILE__, 'smartmail_dev_activate');

// Deactivation hook
function smartmail_dev_deactivate() {
    try {
        // Add deactivation code here
        error_log('SmartMail Assistant Dev plugin deactivated successfully.');
    } catch (Exception $e) {
        error_log('SmartMail Assistant Dev deactivation error: ' . $e->getMessage());
        wp_die('SmartMail Assistant Dev deactivation error: ' . $e->getMessage());
    }
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
        <h2>Dependency Check</h2>
        <?php
        $dependencies = smartmail_dev_check_all_dependencies();
        if (empty($dependencies)) {
            echo '<p>All dependencies are met.</p>';
        } else {
            echo '<p>Missing dependencies:</p><ul>';
            foreach ($dependencies as $dependency) {
                echo '<li>' . esc_html($dependency) . '</li>';
            }
            echo '</ul>';
        }
        ?>
        <h2>Template Management</h2>
        <form method="post">
            <input type="hidden" name="smartmail_dev_create_test_page" value="1">
            <?php submit_button('Create Test Page'); ?>
        </form>
        <?php
        if (isset($_POST['smartmail_dev_create_test_page']) && check_admin_referer()) {
            smartmail_dev_create_test_page();
        }
        ?>
    </div>
    <?php
}

// Check all dependencies function
function smartmail_dev_check_all_dependencies() {
    $missing_dependencies = array();

    if (!function_exists('wp_remote_get')) {
        $missing_dependencies[] = 'wp_remote_get function (WordPress core)';
    }

    if (!class_exists('WooCommerce')) {
        $missing_dependencies[] = 'WooCommerce';
    }

    return $missing_dependencies;
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

// Function to create a test page for developers
function smartmail_dev_create_test_page() {
    $post_data = array(
        'post_title'    => 'SmartMail Assistant Dev Test Page',
        'post_content'  => 'This is a test page for SmartMail Assistant Dev.',
        'post_status'   => 'publish',
        'post_author'   => get_current_user_id(),
        'post_type'     => 'page',
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        echo '<p>Test page created successfully. <a href="' . get_permalink($post_id) . '">View Page</a></p>';
    } else {
        echo '<p>Failed to create test page.</p>';
    }
}
?>
