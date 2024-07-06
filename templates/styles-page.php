<h1>APW Styles</h1>
        <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Type</th><th>Name</th><th>Description</th><th>Example</th><th>Characteristics</th></tr></thead>
        <tbody>
        <?php foreach ($styles as $style) { ?>
            <tr>
            <td><?php echo  esc_html($style->id) ?></td>
            <td><?php echo  esc_html($style->type) ?></td>
            <td><?php echo  esc_html($style->name) ?></td>
            <td><?php echo  esc_html($style->description) ?></td>
            <td><?php echo  esc_html($style->example) ?></td>
            <td><?php echo  esc_html($style->characteristics) ?></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>