jQuery(document).ready(function($) {
    $('#manual-posting-form').on('submit', function(e) {
        e.preventDefault();
        $('#loading').show();
        $.post(ajaxurl, {
            action: 'manual_posting',
            post_title: $('#post-title').val(),
            post_category: $('#post-category').val(),
            security: '<?php echo wp_create_nonce("manual_posting_nonce"); ?>'
        }, function(response) {
            $('#loading').hide();
            $('#message').show().html(response.data.message);
            if(response.success) {
                $('#message').addClass('alert alert-success');
            } else {
                $('#message').addClass('alert alert-danger');
            }
        });
    });

    $('.delete-log').on('click', function() {
        var logId = $(this).data('id');
        $.post(ajaxurl, {
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
