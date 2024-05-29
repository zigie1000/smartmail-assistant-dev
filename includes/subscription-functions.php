<?php

function sma_check_subscription() {
    if (!class_exists('WC_Subscriptions')) {
        return false; // WooCommerce Subscriptions is not active
    }

    $user_id = get_current_user_id();
    $subscriptions = wcs_get_users_subscriptions($user_id);

    foreach ($subscriptions as $subscription) {
        if ($subscription->has_status('active')) {
            return true; // User has an active subscription
        }
    }

    return false; // No active subscription found
}