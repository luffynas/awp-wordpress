<?php

class APW_Scheduler {
    public function __construct() {
        add_action('wp', array($this, 'schedule_auto_post'));
        add_action('apw_auto_post_event', array($this, 'auto_post'));
    }

    public function schedule_auto_post() {
        if (!wp_next_scheduled('apw_auto_post_event')) {
            $posting_interval = intval(apw_get_setting('posting_interval'));
            if ($posting_interval > 0) {
                wp_schedule_event(time(), 'hourly', 'apw_auto_post_event');
            }
        }
    }

    public function auto_post() {
        // Ambil template artikel
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_templates';
        $template = $wpdb->get_row("SELECT * FROM $table_name ORDER BY RAND() LIMIT 1");

        if ($template) {
            // Generate konten artikel menggunakan API
            $prompt = $template->template_content;
            $content = APW_API::generate_content_with_chatgpt($prompt);
            
            // Generate gambar menggunakan API
            $image_url = APW_Image::get_image_from_unsplash('related keyword');

            // Membuat artikel baru
            $post_data = array(
                'post_title'    => wp_strip_all_tags('Generated Post Title'),
                'post_content'  => $content . '<img src="' . esc_url($image_url) . '" />',
                'post_status'   => 'publish',
                'post_author'   => 1,
            );

            // Insert the post into the database
            $post_id = wp_insert_post($post_data);

            // Optimasi SEO
            $seo_title = 'Generated SEO Title';
            $seo_description = 'Generated SEO Description';
            $seo_keywords = 'keyword1, keyword2, keyword3';
            APW_SEO::optimize_post($post_id, $seo_title, $seo_description, $seo_keywords);

            // Dapatkan URL artikel baru
            $post_url = get_permalink($post_id);

            // Posting ke sosial media
            APW_Social_Media::post_to_facebook('Check out our latest post!', $post_url);
            APW_Social_Media::post_to_twitter('Check out our latest post!', $post_url);
            APW_Social_Media::post_to_instagram('Check out our latest post!', $image_url);
            APW_Social_Media::post_to_whatsapp('Check out our latest post: ' . $post_url);
        }
    }
}

?>
