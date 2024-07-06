<h1>Manage Keywords</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Keywords</th>
            <td><input type="text" name="keywords" value="<?php echo esc_attr($keywords_string); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_keywords" class="button-primary" value="Save Keywords" />
    </p>
</form>
