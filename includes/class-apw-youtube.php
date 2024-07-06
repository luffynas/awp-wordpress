<?php

class APW_YouTube {
    public static function get_videos($keyword) {
        $api_key = apw_get_setting('youtube_api_key');
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q=" . urlencode($keyword) . "&key=" . $api_key;

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return 'Error: ' . $response->get_error_message();
        }

        $response_data = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($response_data['error'])) {
            if ($response_data['error']['message'] == 'The access token is invalid') {
                return 'Error: The access token is invalid. Please check your YouTube API key.';
            }
            return 'Error: ' . $response_data['error']['message'];
        }

        return $response_data['items'];
    }
}

?>
