<?php

function sma_register_settings() {
    add_option('sma_email_server_incoming', '');
    add_option('sma_email_server_outgoing', '');
    add_option('sma_email_username', '');
    add_option('sma_email_password', '');
    add_option('sma_free_plan_price', 0);
    add_option('sma_trial_plan_price', 0);
    add_option('sma_subscribed_plan_price', 10);
    register_setting('sma_options_group', 'sma_email_server_incoming', 'sanitize_text_field');
    register_setting('sma_options_group', 'sma_email_server_outgoing', 'sanitize_text_field');
    register_setting('sma_options_group', 'sma_email_username', 'sanitize_text_field');
    register_setting('sma_options_group', 'sma_email_password', 'sanitize_text_field');
    register_setting('sma_subscription_group', 'sma_free_plan_price', 'intval');
    register_setting('sma_subscription_group', 'sma_trial_plan_price', 'intval');
    register_setting('sma_subscription_group', 'sma_subscribed_plan_price', 'intval');
}
add_action('admin_init', 'sma_register_settings');

function sma_register_options_page() {
    add_options_page('SmartMail Settings', 'SmartMail', 'manage_options', 'sma', 'sma_options_page');
}
add_action('admin_menu', 'sma_register_options_page');

function sma_options_page() {
    $plans = array(
        'free' => get_option('sma_free_plan_price'),
        'trial' => get_option('sma_trial_plan_price'),
        'subscribed' => get_option('sma_subscribed_plan_price'),
    );
?>
  <div>
  <h2>SmartMail Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields('sma_options_group'); ?>
  <table>
  <tr valign="top">
  <th scope="row"><label for="sma_email_server_incoming">Incoming Mail Server</label></th>
  <td><input type="text" id="sma_email_server_incoming" name="sma_email_server_incoming" value="<?php echo esc_attr(get_option('sma_email_server_incoming')); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_email_server_outgoing">Outgoing Mail Server</label></th>
  <td><input type="text" id="sma_email_server_outgoing" name="sma_email_server_outgoing" value="<?php echo esc_attr(get_option('sma_email_server_outgoing')); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_email_username">Email Username</label></th>
  <td><input type="text" id="sma_email_username" name="sma_email_username" value="<?php echo esc_attr(get_option('sma_email_username')); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_email_password">Email Password</label></th>
  <td><input type="password" id="sma_email_password" name="sma_email_password" value="<?php echo esc_attr(get_option('sma_email_password')); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_free_plan_price">Free Plan Price</label></th>
  <td><input type="number" id="sma_free_plan_price" name="sma_free_plan_price" value="<?php echo esc_attr($plans['free']); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_trial_plan_price">Trial Plan Price</label></th>
  <td><input type="number" id="sma_trial_plan_price" name="sma_trial_plan_price" value="<?php echo esc_attr($plans['trial']); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="sma_subscribed_plan_price">Subscribed Plan Price</label></th>
  <td><input type="number" id="sma_subscribed_plan_price" name="sma_subscribed_plan_price" value="<?php echo esc_attr($plans['subscribed']); ?>" /></td>
  </tr>
  </table>
  <?php submit_button(); ?>
  </form>

  <h2>Send Updates</h2>
  <form method="post" action="">
      <table>
          <tr valign="top">
              <th scope="row"><label for="update_message">Update Message</label></th>
              <td><textarea id="update_message" name="update_message" rows="5" cols="50"></textarea></td>
          </tr>
      </table>
      <input type="submit" name="send_update" value="Send Update" class="button button-primary" />
  </form>

  <?php
  if (isset($_POST['send_update'])) {
      $update_message = sanitize_textarea_field($_POST['update_message']);
      // Logic to send the update message to users, e.g., via email
      echo '<div class="updated"><p>Update sent successfully!</p></div>';
  }
  ?>
  </div>
<?php
}
