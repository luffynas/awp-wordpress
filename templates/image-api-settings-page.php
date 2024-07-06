<h1>Image API Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Unsplash API Key</th>
            <td><input type="text" name="unsplash_api_key" value="<?php echo esc_attr($unsplash_api_key); ?>" class="regular-text" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Pexels API Key</th>
            <td><input type="text" name="pexels_api_key" value="<?php echo esc_attr($pexels_api_key); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_image_api_settings" class="button-primary" value="Save Image API Settings" />
    </p>
</form>

<br/><br/>
<button type="button" class="button-secondary" id="test-unsplash-connection">Test Unsplash Connection</button>
<span id="unsplash-connection-status"></span>

<br/><br/>
<button type="button" class="button-secondary" id="test-pexels-connection">Test Pexels Connection</button>
<span id="pexels-connection-status"></span>

<script>
jQuery(document).ready(function($) {
        $('#test-unsplash-connection').on('click', function() {
        $('#unsplash-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_unsplash_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#unsplash-connection-status').text('Connection Successful');
            } else {
                $('#unsplash-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

    $('#test-pexels-connection').on('click', function() {
        $('#pexels-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_pexels_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#pexels-connection-status').text('Connection Successful');
            } else {
                $('#pexels-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });
});
</script>