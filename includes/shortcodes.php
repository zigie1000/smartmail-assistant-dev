<?php

function sma_email_summarization_shortcode($atts, $content = null) {
    if (!sma_check_subscription()) {
        return '<div class="error">This feature is available for subscribed users only.</div>';
    }

    $email_content = $content; // The email content to summarize
    $api_response = sma_summarize_email($email_content);

    if (is_array($api_response) && isset($api_response['choices'][0]['text'])) {
        return '<div class="email-summary">' . esc_html($api_response['choices'][0]['text']) . '</div>';
    } else {
        return '<div class="error">Failed to summarize email.</div>';
    }
}
add_shortcode('sma_email_summarization', 'sma_email_summarization_shortcode');