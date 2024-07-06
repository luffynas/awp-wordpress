<h1>API Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">OpenAI API Key</th>
            <td>
                <input type="text" name="openai_api_key" value="<?php echo esc_attr($openai_api_key); ?>" class="regular-text" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Gemini API Key</th>
            <td>
                <input type="text" name="gemini_api_key" value="<?php echo esc_attr($gemini_api_key); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_api_settings" class="button-primary" value="Save API Settings" />
    </p>
</form>
<h2>Test API Connection</h2>
<form id="test-api-connection-form" method="post" action="">
    <button type="button" class="button-secondary" id="test-openai-connection">Test OpenAI Connection</button>
    <span id="openai-connection-status"></span>
    <br/><br/>
    <button type="button" class="button-secondary" id="test-gemini-connection">Test Gemini Connection</button>
    <span id="gemini-connection-status"></span>
</form>
<script>
jQuery(document).ready(function($) {
    $('#test-openai-connection').on('click', function() {
        $('#openai-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_openai_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#openai-connection-status').text('Connection Successful');
            } else {
                $('#openai-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });

    $('#test-gemini-connection').on('click', function() {
        $('#gemini-connection-status').text('Testing...');
        $.post(ajaxurl, {
            action: 'test_gemini_connection',
            security: '<?php echo wp_create_nonce("test_api_connection_nonce"); ?>'
        }, function(response) {
            if(response.success) {
                $('#gemini-connection-status').text('Connection Successful');
            } else {
                $('#gemini-connection-status').text('Connection Failed: ' + response.data.message);
            }
        });
    });
});
</script>
