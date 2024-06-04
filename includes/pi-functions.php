<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Function to process Pi Network payments
 */
function process_pi_payment($order_id) {
    $order = wc_get_order($order_id);
    // Payment processing logic here
    if ($payment_successful) {
        $order->payment_complete();
        wc_reduce_stock_levels($order_id);
        $order->add_order_note('Pi payment received.');
        WC()->cart->empty_cart();
        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url($order),
        );
    } else {
        wc_add_notice('Payment error:', 'error');
        return;
    }
}
?>
