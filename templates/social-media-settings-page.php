<h1>Social Media API Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Facebook API Key</th>
            <td><input type="text" name="facebook_api_key" value="<?php echo esc_attr($facebook_api_key); ?>" class="regular-text" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Twitter API Key</th>
            <td><input type="text" name="twitter_api_key" value="<?php echo esc_attr($twitter_api_key); ?>" class="regular-text" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Instagram API Key</th>
            <td><input type="text" name="instagram_api_key" value="<?php echo esc_attr($instagram_api_key); ?>" class="regular-text" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">WhatsApp API Key</th>
            <td><input type="text" name="whatsapp_api_key" value="<?php echo esc_attr($whatsapp_api_key); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_social_media_settings" class="button-primary" value="Save Social Media API Settings" />
    </p>
</form>
<h2>Test Social Media API Connection</h2>
<form id="test-social-media-connection-form" method="post" action="">
    <button type="button" class="button-secondary" id="test-facebook-connection">Test Facebook Connection</button>
    <span id="facebook-connection-status"></span>
    <br/><br/>
    <button type="button" class="button-secondary" id="test-twitter-connection">Test Twitter Connection</button>
    <span id="twitter-connection-status"></span>
    <br/><br/>
    <button type="button" class="button-secondary" id="test-instagram-connection">Test Instagram Connection</button>
    <span id="instagram-connection-status"></span>
    <br/><br/>
    <button type="button" class="button-secondary" id="test-whatsapp-connection">Test WhatsApp Connection</button>
    <span id="whatsapp-connection-status"></span>
</form>
<script>
jQuery(document).ready(function($) {
    $('#test-facebook-connection').on('click', function() {
        $('#facebook-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_facebook_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#facebook-connection-status').text('Connection Successful');
            } else {
                $('#facebook-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

    $('#test-twitter-connection').on('click', function() {
        $('#twitter-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_twitter_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#twitter-connection-status').text('Connection Successful');
            } else {
                $('#twitter-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

    $('#test-instagram-connection').on('click', function() {
        $('#instagram-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_instagram_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#instagram-connection-status').text('Connection Successful');
            } else {
                $('#instagram-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

    $('#test-whatsapp-connection').on('click', function() {
        $('#whatsapp-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_whatsapp_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#whatsapp-connection-status').text('Connection Successful');
            } else {
                $('#whatsapp-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });
});
</script>