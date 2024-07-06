<h1>Scheduling Settings</h1>
<form method="post" action="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Interval Posting (dalam jam)</th>
            <td><input type="number" name="posting_interval" value="<?php echo esc_attr($posting_interval); ?>" class="small-text" min="1" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_scheduling_settings" class="button-primary" value="Save Scheduling Settings" />
    </p>
</form>
