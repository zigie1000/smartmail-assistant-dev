<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Example API function
function example_api_function() {
    // Example API function code here
    return "This is an example API function response.";
}

// Function to fetch user data via an API
function sma_get_user_data($user_id) {
    $response = wp_remote_get("https://smartmail.store/api/user-data?user_id={$user_id}");

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['success']) && $data['success'] === true) {
        return $data['user_data'];
    }

    return false;
}

// Function to update user settings via an API
function sma_update_user_settings($user_id, $settings) {
    $response = wp_remote_post('https://smartmail.store/api/update-settings', array(
        'body' => json_encode(array('user_id' => $user_id, 'settings' => $settings)),
        'headers' => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return isset($data['success']) && $data['success'] === true;
}

// Function to check subscription status via an API
function sma_check_subscription($user_id) {
    $response = wp_remote_get("https://smartmail.store/api/check-subscription?user_id={$user_id}");

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return isset($data['active']) && $data['active'] === true;
}

// Function to subscribe a user via an API
function sma_subscribe_user($email) {
    $response = wp_remote_post('https://smartmail.store/api/subscribe', array(
        'body' => json_encode(array('email' => $email)),
        'headers' => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return isset($data['success']) && $data['success'] === true;
}

// Function to fetch email categories via an API
function sma_get_email_categories($user_id) {
    $response = wp_remote_get("https://smartmail.store/api/email-categories?user_id={$user_id}");

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['success']) && $data['success'] === true) {
        return $data['categories'];
    }

    return false;
}

?>
