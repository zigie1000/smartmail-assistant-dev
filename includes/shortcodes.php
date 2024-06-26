<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function sma_display_email_categorization() {
    if (current_user_can('sma_use_pro_features')) {
        return '<div class="sma-feature">Email Categorization is enabled for Pro users.</div>';
    }
    return '<div class="sma-feature">Email Categorization is available for Pro users only. <a href="/subscribe">Subscribe now</a></div>';
}
add_shortcode('

sma_email_categorization', 'sma_display_email_categorization');

function sma_display_priority_inbox() {
    if (current_user_can('sma_use_pro_features')) {
        return '<div class="sma-feature">Priority Inbox is enabled for Pro users.</div>';
    }
    return '<div class="sma-feature">Priority Inbox is available for Pro users only. <a href="/subscribe">Subscribe now</a></div>';
}
add_shortcode('sma_priority_inbox', 'sma_display_priority_inbox');

function sma_display_email_summarization($atts, $content = null) {
    if (current_user_can('sma_use_pro_features')) {
        $summary = sma_summarize_email($content);
        return '<div class="sma-feature">Email Summary: ' . esc_html($summary) . '</div>';
    }
    return '<div class="sma-feature">Email Summarization is available for Pro users only. <a href="/subscribe">Subscribe now</a></div>';
}
add_shortcode('sma_email_summarization', 'sma_display_email_summarization');
?>
