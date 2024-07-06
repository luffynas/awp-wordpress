<h1>SEO Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Use Yoast SEO</th>
            <td><input type="checkbox" name="use_yoast_seo" value="1" <?php checked($use_yoast_seo, 1); ?> /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Use Rank Math SEO</th>
            <td><input type="checkbox" name="use_rank_math_seo" value="1" <?php checked($use_rank_math_seo, 1); ?> /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_seo_settings" class="button-primary" value="Save SEO Settings" />
    </p>
</form>
