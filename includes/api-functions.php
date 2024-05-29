function sma_call_ai_api($endpoint, $data) {
    $api_key = 'your-openai-api-key'; // Replace with your actual OpenAI API key

    $response = wp_remote_post($endpoint, array(
        'body'    => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key
        )
    ));

    if (is_wp_error($response)) {
        return 'API request failed: ' . $response->get_error_message();
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true);
}

function sma_summarize_email($email_content) {
    $endpoint = 'https://api.openai.com/v1/engines/gpt-4/completions';
    $data = array(
        'prompt' => "Summarize the following email: $email_content",
        'max_tokens' => 150
    );
    return sma_call_ai_api($endpoint, $data);
}
