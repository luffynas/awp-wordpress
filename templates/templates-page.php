<h1>Manage Templates</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Template Name</th>
            <td><input type="text" name="template_name" class="regular-text" required /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Template Content</th>
            <td><textarea name="template_content" rows="10" cols="50" class="large-text" required></textarea></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_template" class="button-primary" value="Save Template" />
    </p>
</form>
