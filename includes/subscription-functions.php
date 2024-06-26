<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function sma_check_subscription() {
    $user_id = get_current_user_id();
    $response = wp_remote_get("https://smartmail.store/api/check-subscription?user_id={$user_id}");

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return isset($data['active']) && $data['active'] === true;
}

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
?>
