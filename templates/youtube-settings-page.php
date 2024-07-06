<h1>YouTube API Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">YouTube API Key</th>
            <td><input type="text" name="youtube_api_key" value="<?php echo esc_attr($youtube_api_key); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_youtube_api_settings" class="button-primary" value="Save YouTube API Settings" />
    </p>
</form>
<br/><br/>
<button type="button" class="button-secondary" id="test-youtube-connection">Test YouTube Connection</button>
<span id="youtube-connection-status"></span>

<script>
jQuery(document).ready(function($) {
    $('#test-youtube-connection').on('click', function() {
        $('#youtube-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_youtube_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#youtube-connection-status').text('Connection Successful');
            } else {
                $('#youtube-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

});
</script>