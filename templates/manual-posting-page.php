<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Cara Menyertakan Instruksi Style dalam Prompt</h2>
            <p></p>Untuk menentukan style bahasa dalam prompt Anda, sertakan instruksi style di akhir atau awal prompt. Misalnya:</p>
            <p></p>
            <p>"Tuliskan panduan tentang SEO dalam gaya formal dan profesional, dengan bahasa yang serius dan terstruktur."</p>
            <p>"Buat artikel tentang SEO dengan nada santai dan ramah, menggunakan bahasa sehari-hari dan humor ringan."</p>
            <p>"Jelaskan teknik SEO dengan pendekatan teknis yang mendalam, mengutamakan penggunaan jargon industri dan detail teknis."</p>
            <h2>Manual Posting</h2>
            <form id="manual-posting-form" method="post" action="">
                <div class="mb-3">
                    <label for="post-title" class="form-label">Post Title</label>
                    <input type="text" class="form-control" id="post-title" name="post_title" required>
                </div>
                <div class="mb-3">
                    <label for="post-category" class="form-label">Category</label>
                    <select class="form-control" id="post-category" name="post_category">
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gaya_penulisan">Gaya Penulisan:</label>
                    <select id="gaya_penulisan" name="gaya_penulisan" required>
                        <?php foreach ($gaya_penulisan as $style) : ?>
                            <option value="<?php echo esc_attr($style->name); ?>"><?php echo esc_html($style->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gaya_bahasa">Gaya Bahasa:</label>
                    <select id="gaya_bahasa" name="gaya_bahasa" required>
                        <?php foreach ($gaya_bahasa as $style) : ?>
                            <option value="<?php echo esc_attr($style->name); ?>"><?php echo esc_html($style->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bahasa">Bahasa:</label>
                    <select id="bahasa" name="bahasa" required>
                        <?php foreach ($bahasa as $style) : ?>
                            <option value="<?php echo esc_attr($style->name); ?>"><?php echo esc_html($style->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="manual-posting-button">Post</button>
                <div id="loading" style="display:none;">Loading...</div>
                <div id="message" style="display:none;"></div>
            </form>
        </div>
        <div class="col-md-6">
            <h2>Logging</h2>
            <form id="search-logging-form" method="get" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search logs">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Post ID</th>
                        <th>Status</th>
                        <th>Message</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'apw_logging';
                    $logs = $wpdb->get_results("SELECT * FROM $table_name");
                    foreach ($logs as $log) {
                        echo '<tr>';
                        echo '<td>' . $log->id . '</td>';
                        echo '<td>' . $log->post_id . '</td>';
                        echo '<td>' . $log->status . '</td>';
                        echo '<td>' . $log->message . '</td>';
                        echo '<td>' . $log->created_at . '</td>';
                        echo '<td><button class="btn btn-danger delete-log" data-id="' . $log->id . '">Delete</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $manual_posting_nonce = wp_create_nonce('manual_posting_nonce'); ?>
<script type="text/javascript">
     var manual_posting_nonce = '<?php echo $manual_posting_nonce; ?>';
    jQuery(document).ready(function($) {
        $('#manual-posting-form').on('submit', function(e) {
            e.preventDefault();
            console.log('adfadfadfdf ::: '+$('#post-title').val());
            console.log('adfadfadfdf ::: '+$('#post-category').val());
            
            var data = {
                action: 'manual_posting',
                security: manual_posting_nonce,
                post_title: $('#post-title').val(),
                post_category: $('#post-category').val(),
                gaya_penulisan: $('#gaya_penulisan').val(),
                gaya_bahasa: $('#gaya_bahasa').val(),
                bahasa: $('#bahasa').val()
            };

            $.post(ajaxurl, data, function(response) {
                if(response.success) {
                    $('#manual-posting-status').text('Post created successfully.');
                } else {
                    $('#manual-posting-status').text('Error: ' + response.data.message);
                }
            }).fail(function(xhr, status, error) {
                $('#manual-posting-status').text('Request failed: ' + status + ', ' + error);
            });
        });

        $('.delete-log').on('click', function() {
            var logId = $(this).data('id');
            $.post(ajax_object.ajax_url, {
                action: 'delete_log',
                log_id: logId,
                security: '<?php echo wp_create_nonce("delete_log_nonce"); ?>'
            }, function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Failed to delete log.');
                }
            });
        });
    });
</script>
