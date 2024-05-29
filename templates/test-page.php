<?php
/*
Template Name: Test Page
*/

// Ensure only users with the 'developer' role can access this page
if (!current_user_can('developer')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

get_header(); ?>

<div class="test-page-container">
    <h1>SmartMail Assistant Test Page</h1>
    <p>This is a test page for developers to check the look and functionality of the SmartMail Assistant plugin.</p>

    <h2>Email Summarization Test</h2>
    <form method="post" action="">
        <label for="email_content">Email Content:</label>
        <textarea id="email_content" name="email_content" rows="5" cols="50"></textarea>
        <input type="submit" name="summarize_email" value="Summarize Email" class="button button-primary" />
    </form>

    <?php
    if (isset($_POST['summarize_email'])) {
        $email_content = sanitize_textarea_field($_POST['email_content']);
        $summary = sma_summarize_email($email_content);
        echo '<h3>Summarized Email:</h3>';
        echo '<div class="email-summary">' . esc_html($summary['choices'][0]['text']) . '</div>';
    }
    ?>
</div>

<?php get_footer(); ?>
