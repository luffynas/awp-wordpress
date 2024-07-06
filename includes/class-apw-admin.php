<?php

class APW_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_action('wp_ajax_manual_posting', array($this, 'manual_posting'));
        add_action('wp_ajax_delete_log', array($this, 'delete_log'));
        add_action('wp_ajax_test_openai_connection', array($this, 'test_openai_connection'));
        add_action('wp_ajax_test_gemini_connection', array($this, 'test_gemini_connection'));
        add_action('wp_ajax_test_unsplash_connection', array($this, 'test_unsplash_connection'));
        add_action('wp_ajax_test_pexels_connection', array($this, 'test_pexels_connection'));
        add_action('wp_ajax_test_youtube_connection', array($this, 'test_youtube_connection'));
        add_action('wp_ajax_test_facebook_connection', array($this, 'test_facebook_connection'));
        add_action('wp_ajax_test_twitter_connection', array($this, 'test_twitter_connection'));
        add_action('wp_ajax_test_instagram_connection', array($this, 'test_instagram_connection'));
        add_action('wp_ajax_test_whatsapp_connection', array($this, 'test_whatsapp_connection'));
    }

    public function add_admin_pages() {
        add_menu_page(
            'Auto Posting Settings',
            'Auto Posting',
            'manage_options',
            'apw_settings',
            array($this, 'create_admin_page'),
            'dashicons-admin-settings',
            110
        );

        add_submenu_page(
            'apw_settings',
            'API Settings',
            'API Settings',
            'manage_options',
            'apw_api_settings',
            array($this, 'create_api_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'YouTube Settings',
            'YouTube Settings',
            'manage_options',
            'apw_youtube_settings',
            array($this, 'create_youtube_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'Image API Settings',
            'Image API Settings',
            'manage_options',
            'apw_image_api_settings',
            array($this, 'create_image_api_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'Scheduling Settings',
            'Scheduling Settings',
            'manage_options',
            'apw_scheduling_settings',
            array($this, 'create_scheduling_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'Social Media Settings',
            'Social Media Settings',
            'manage_options',
            'apw_social_media_settings',
            array($this, 'create_social_media_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'SEO Settings',
            'SEO Settings',
            'manage_options',
            'apw_seo_settings',
            array($this, 'create_seo_settings_page')
        );

        add_submenu_page(
            'apw_settings',
            'Manage Keywords',
            'Keywords',
            'manage_options',
            'apw_keywords',
            array($this, 'create_keywords_page')
        );

        add_submenu_page(
            'apw_settings',
            'Manage Templates',
            'Templates',
            'manage_options',
            'apw_templates',
            array($this, 'create_templates_page')
        );
        
        add_submenu_page(
            'apw_settings',
            'Manage Styles',
            'Styles',
            'manage_options',
            'apw_styles',
            array($this, 'create_styles_page')
        );
    }



    public function create_admin_page() {
        // Content for the main settings page
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_styles';

        $gaya_penulisan = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'Gaya Penulisan'");
        $gaya_bahasa = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'Gaya Bahasa'");
        $bahasa = $wpdb->get_results("SELECT * FROM $table_name WHERE type = 'Bahasa'");


        echo '<h1> Auto Posting</h1>';
        include(APW_PLUGIN_PATH . 'templates/manual-posting-page.php');
    }

    public function create_keywords_page() {
        if (isset($_POST['save_keywords'])) {
            $keywords = explode(',', sanitize_text_field($_POST['keywords']));
            $this->apw_save_keywords($keywords);
            echo '<div class="updated"><p>Keywords saved.</p></div>';
        }

        $keywords = $this->apw_get_keywords();
        $keywords_string = implode(', ', $keywords);
        include(APW_PLUGIN_PATH . 'templates/keywords-page.php');
    }

    function apw_save_keywords($keywords) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_keywords';
    
        // Hapus semua keywords sebelumnya
        $wpdb->query("TRUNCATE TABLE $table_name");
    
        // Simpan keywords baru
        foreach ($keywords as $keyword) {
            $wpdb->insert(
                $table_name,
                array('keyword' => sanitize_text_field($keyword)),
                array('%s')
            );
        }
    }
    
    function apw_get_keywords() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_keywords';
    
        $results = $wpdb->get_results("SELECT keyword FROM $table_name", ARRAY_A);
    
        $keywords = array();
        foreach ($results as $row) {
            $keywords[] = $row['keyword'];
        }
    
        return $keywords;
    }    

    public function create_templates_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_templates';

        if (isset($_POST['save_template'])) {
            $template_name = sanitize_text_field($_POST['template_name']);
            $template_content = wp_kses_post($_POST['template_content']);

            $wpdb->insert(
                $table_name,
                array(
                    'template_name' => $template_name,
                    'template_content' => $template_content
                ),
                array(
                    '%s',
                    '%s'
                )
            );

            echo '<div class="updated"><p>Template saved.</p></div>';
        }

        include(APW_PLUGIN_PATH . 'templates/templates-page.php');
    }

    public function create_styles_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_styles';
        $styles = $wpdb->get_results("SELECT * FROM $table_name");

        include(APW_PLUGIN_PATH . 'templates/styles-page.php');
    }

    public function create_api_settings_page() {
        if (isset($_POST['save_api_settings'])) {
            $openai_api_key = sanitize_text_field($_POST['openai_api_key']);
            $gemini_api_key = sanitize_text_field($_POST['gemini_api_key']);
            apw_save_setting('openai_api_key', $openai_api_key);
            apw_save_setting('gemini_api_key', $gemini_api_key);
            echo '<div class="updated"><p>API settings saved.</p></div>';
        }

        $openai_api_key = apw_get_setting('openai_api_key');
        $gemini_api_key = apw_get_setting('gemini_api_key');
        include(APW_PLUGIN_PATH . 'templates/api-settings-page.php');
    }

    public function create_youtube_settings_page() {
        if (isset($_POST['save_youtube_api_settings'])) {
            $youtube_api_key = sanitize_text_field($_POST['youtube_api_key']);
            apw_save_setting('youtube_api_key', $youtube_api_key);
            echo '<div class="updated"><p>YouTube API settings saved.</p></div>';
        }

        $youtube_api_key = apw_get_setting('youtube_api_key');
        include(APW_PLUGIN_PATH . 'templates/youtube-settings-page.php');
    }

    public function create_image_api_settings_page() {
        if (isset($_POST['save_image_api_settings'])) {
            $unsplash_api_key = sanitize_text_field($_POST['unsplash_api_key']);
            $pexels_api_key = sanitize_text_field($_POST['pexels_api_key']);
            apw_save_setting('unsplash_api_key', $unsplash_api_key);
            apw_save_setting('pexels_api_key', $pexels_api_key);
            echo '<div class="updated"><p>Image API settings saved.</p></div>';
        }

        $unsplash_api_key = apw_get_setting('unsplash_api_key');
        $pexels_api_key = apw_get_setting('pexels_api_key');
        include(APW_PLUGIN_PATH . 'templates/image-api-settings-page.php');
    }

    public function create_scheduling_settings_page() {
        if (isset($_POST['save_scheduling_settings'])) {
            $posting_interval = intval($_POST['posting_interval']);
            apw_save_setting('posting_interval', $posting_interval);
            echo '<div class="updated"><p>Scheduling settings saved.</p></div>';
        }

        $posting_interval = apw_get_setting('posting_interval');
        include(APW_PLUGIN_PATH . 'templates/scheduling-settings-page.php');
    }

    public function create_social_media_settings_page() {
        if (isset($_POST['save_social_media_settings'])) {
            $facebook_api_key = sanitize_text_field($_POST['facebook_api_key']);
            $twitter_api_key = sanitize_text_field($_POST['twitter_api_key']);
            $instagram_api_key = sanitize_text_field($_POST['instagram_api_key']);
            $whatsapp_api_key = sanitize_text_field($_POST['whatsapp_api_key']);
            apw_save_setting('facebook_api_key', $facebook_api_key);
            apw_save_setting('twitter_api_key', $twitter_api_key);
            apw_save_setting('instagram_api_key', $instagram_api_key);
            apw_save_setting('whatsapp_api_key', $whatsapp_api_key);
            echo '<div class="updated"><p>Social media API settings saved.</p></div>';
        }

        $facebook_api_key = apw_get_setting('facebook_api_key');
        $twitter_api_key = apw_get_setting('twitter_api_key');
        $instagram_api_key = apw_get_setting('instagram_api_key');
        $whatsapp_api_key = apw_get_setting('whatsapp_api_key');
        include(APW_PLUGIN_PATH . 'templates/social-media-settings-page.php');
    }

    public function create_seo_settings_page() {
        if (isset($_POST['save_seo_settings'])) {
            $use_yoast_seo = isset($_POST['use_yoast_seo']) ? 1 : 0;
            $use_rank_math_seo = isset($_POST['use_rank_math_seo']) ? 1 : 0;
            apw_save_setting('use_yoast_seo', $use_yoast_seo);
            apw_save_setting('use_rank_math_seo', $use_rank_math_seo);
            echo '<div class="updated"><p>SEO settings saved.</p></div>';
        }

        $use_yoast_seo = apw_get_setting('use_yoast_seo');
        $use_rank_math_seo = apw_get_setting('use_rank_math_seo');
        include(APW_PLUGIN_PATH . 'templates/seo-settings-page.php');
    }

    public function manual_posting() {
        check_ajax_referer('manual_posting_nonce', 'security');
        error_log('post_title ::: '.print_r($_POST['post_title'], true));
        error_log('post_title ::: '.print_r($_POST['post_category'], true));

        $post_title = sanitize_text_field($_POST['post_title']);
        $post_category = intval($_POST['post_category']);
        $gaya_penulisan = sanitize_text_field($_POST['gaya_penulisan']);
        $gaya_bahasa = sanitize_text_field($_POST['gaya_bahasa']);
        $bahasa = sanitize_text_field($_POST['bahasa']);
        $table_name = $wpdb->prefix . 'apw_templates';
        error_log('$post_title ::: '.$post_title);
        error_log('$post_category ::: '.$post_category);
        error_log('$gaya_penulisan ::: '.$gaya_penulisan);
        error_log('$gaya_bahasa ::: '.$gaya_bahasa);
        error_log('$bahasa ::: '.$bahasa);


        // Ambil template artikel acak
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_templates';
        $template = $wpdb->get_row("SELECT * FROM $table_name ORDER BY RAND() LIMIT 1");

        if ($template) {
            $template_content_with_title = APW_Template::replace_title_placeholder($template->template_content, $post_title);
            error_log('$template_content_with_title ::: '.$template_content_with_title);

            // Buat Prompt berdasarkan input pengguna
            $prompt = APW_Prompt::create_prompt($gaya_bahasa, $gaya_penulisan, $bahasa);


            // Generate konten artikel menggunakan API
            // $content = APW_API::generate_content_with_chatgpt($template_content_with_title);
            // error_log('$generate_content_with_chatgpt ::: '.$content);

            // Generate gambar menggunakan API
            // $image_url = APW_Image::get_image_from_unsplash('related keyword');
            // $image_url = APW_Image::get_image_from_pexels('SEO');
            // error_log('$get_image_from_pexels ::: '.$image_url);

            // Membuat artikel baru
            // $post_data = array(
            //     'post_title'    => $post_title,
            //     'post_content'  => $content . '<img src="' . esc_url($image_url) . '" />',
            //     'post_status'   => 'publish',
            //     'post_author'   => get_current_user_id(),
            //     'post_category' => array($post_category),
            // );

            // $post_id = wp_insert_post($post_data);

            // if ($post_id) {
            //     // Optimasi SEO
            //     $seo_title = 'Generated SEO Title';
            //     $seo_description = 'Generated SEO Description';
            //     $seo_keywords = 'keyword1, keyword2, keyword3';
            //     APW_SEO::optimize_post($post_id, $seo_title, $seo_description, $seo_keywords);

            //     // Logging hasil posting
            //     $wpdb->insert(
            //         $table_name,
            //         array(
            //             'post_id' => $post_id,
            //             'status' => 'success',
            //             'message' => 'Post created successfully.',
            //         ),
            //         array('%d', '%s', '%s')
            //     );
            //     wp_send_json_success(array('message' => 'Post created successfully.'));
            // } else {
            //     $wpdb->insert(
            //         $table_name,
            //         array(
            //             'post_id' => 0,
            //             'status' => 'failed',
            //             'message' => 'Failed to create post.',
            //         ),
            //         array('%d', '%s', '%s')
            //     );
            //     wp_send_json_error(array('message' => 'Failed to create post.'));
            // }
        } else {
            wp_send_json_error(array('message' => 'No template available.'));
        }
    }

    public function delete_log() {
        check_ajax_referer('delete_log_nonce', 'security');

        $log_id = intval($_POST['log_id']);
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_logging';
        $deleted = $wpdb->delete($table_name, array('id' => $log_id), array('%d'));

        if ($deleted) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    }

    /// ============ TESTING =========
    public function test_openai_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');

        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => 'Test connection',
                'max_tokens' => 5
            ))
        ));

        error_log('$response OpenApi ::: '.print_r($response, true));
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        } else {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            if (isset($data['choices'])) {
                wp_send_json_success();
            } else {
                wp_send_json_error(array('message' => 'Invalid API response.'));
            }
        }
    }

    public function test_gemini_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');

        $api_key = apw_get_setting('gemini_api_key');
        $prompt = 'Test connection';

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=$api_key";
        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $options = [
            'body' => wp_json_encode($data),
            'headers' => ['Content-Type' => 'application/json'],
            'method' => 'POST',
        ];

        $response = wp_remote_post($url, $options);

        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        }

        $response_data = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($response_data['error'])) {
            wp_send_json_error(array('message' => $response_data['error']['message']));
        }

        wp_send_json_success();
    }

    public function test_unsplash_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $access_key = apw_get_setting('unsplash_access_key');
        $keyword = 'test';  // Kata kunci untuk pengujian
    
        $result = APW_Image::get_image_from_unsplash($keyword);
    
        if (strpos($result, 'Error:') === 0) {
            wp_send_json_error(array('message' => $result));
        } else {
            wp_send_json_success();
        }
    }

    public function test_pexels_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $access_key = apw_get_setting('pexels_access_key');
        $keyword = 'test';  // Kata kunci untuk pengujian
    
        $result = APW_Image::get_image_from_pexels($keyword);
    
        if (strpos($result, 'Error:') === 0) {
            wp_send_json_error(array('message' => $result));
        } else {
            wp_send_json_success();
        }
    }
    
    public function test_youtube_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $api_key = apw_get_setting('youtube_api_key');
        $keyword = 'test';  // Kata kunci untuk pengujian
    
        $result = APW_Youtube::get_videos($keyword);
    
        if (strpos($result, 'Error:') === 0) {
            wp_send_json_error(array('message' => $result));
        } else {
            wp_send_json_success();
        }
    }
    
    public function test_facebook_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $api_key = apw_get_setting('facebook_api_key');
        $url = "https://graph.facebook.com/me?access_token=$api_key";
    
        $response = wp_remote_get($url);
    
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        }
    
        $response_data = json_decode(wp_remote_retrieve_body($response), true);
    
        if (isset($response_data['error'])) {
            wp_send_json_error(array('message' => $response_data['error']['message']));
        }
    
        wp_send_json_success();
    }
    
    public function test_twitter_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $api_key = apw_get_setting('twitter_api_key');
        $url = "https://api.twitter.com/1.1/account/verify_credentials.json?oauth_token=$api_key";
    
        $response = wp_remote_get($url);
    
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        }
    
        $response_data = json_decode(wp_remote_retrieve_body($response), true);
    
        if (isset($response_data['errors'])) {
            wp_send_json_error(array('message' => implode(', ', $response_data['errors'])));
        }
    
        wp_send_json_success();
    }
    
    public function test_instagram_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $api_key = apw_get_setting('instagram_api_key');
        $url = "https://graph.instagram.com/me?access_token=$api_key";
    
        $response = wp_remote_get($url);
    
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        }
    
        $response_data = json_decode(wp_remote_retrieve_body($response), true);
        error_log('$response_data :::' . print_r($response_data, true));
    
        if (isset($response_data['error'])) {
            wp_send_json_error(array('message' => $response_data['error']['message']));
        }
    
        wp_send_json_success();
    }
    
    public function test_whatsapp_connection() {
        check_ajax_referer('test_api_connection_nonce', 'security');
    
        $api_key = apw_get_setting('whatsapp_api_key');
        // WhatsApp tidak memiliki API publik untuk memeriksa koneksi, ini contoh sederhana
        if ($api_key) {
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => 'Invalid API Key'));
        }
    }
    
}

?>
