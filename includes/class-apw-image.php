<?php

class APW_Image {
    // public static function get_image_from_unsplash($query) {
    //     $api_key = apw_get_setting('unsplash_api_key');
    //     $url = 'https://api.unsplash.com/photos/random?query=' . urlencode($query) . '&client_id=' . $api_key;

    //     $response = wp_remote_get($url);
    //     error_log('$response ::: '.print_r($response, true));

    //     if (is_wp_error($response)) {
    //         return 'Error: ' . $response->get_error_message();
    //     } else {
    //         $body = wp_remote_retrieve_body($response);
    //         $data = json_decode($body, true);
    //         error_log('$get_image_from_unsplash ::: '.print_r($data, true));
    //         return $data['urls']['regular'];
    //     }
    // }
    public static function get_image_from_unsplash($keyword) {
        $access_key = apw_get_setting('unsplash_api_key');
        $url = "https://api.unsplash.com/photos/random?query=" . urlencode($keyword) . "&client_id=" . $access_key;

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return 'Error: ' . $response->get_error_message();
        }

        $response_data = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($response_data['errors'])) {
            if (in_array('OAuth error: The access token is invalid', $response_data['errors'])) {
                return 'Error: Invalid access token. Please check your Unsplash API key.';
            }
            return 'Error: ' . implode(', ', $response_data['errors']);
        }

        return $response_data['urls']['regular'];
    }

    public static function get_image_from_pexels($keyword) {
        $access_key = apw_get_setting('pexels_api_key');
        error_log('$access_key get_image_from_pexels ::: '.$access_key);
        $url = "https://api.pexels.com/v1/search?query=" . urlencode($keyword) . "&per_page=1";

        $options = [
            'headers' => ['Authorization' => $access_key],
            'method' => 'GET',
        ];

        $response = wp_remote_get($url, $options);

        if (is_wp_error($response)) {
            return 'Error: ' . $response->get_error_message();
        }

        $response_data = json_decode(wp_remote_retrieve_body($response), true);
        error_log('$response_data ::: '.print_r($response_data, true));

        if (isset($response_data['error']) || $response_data['status'] == 401) {
            if ($response_data['error'] == 'OAuth error: The access token is invalid') {
                return 'Error: The access token is invalid. Please check your Pexels access key.';
            }else if ($response_data['status'] == 401) {
                return 'Error: ' . $response_data['code'];    
            }
            return 'Error: ' . $response_data['error'];
        }

        return $response_data['photos'][0]['src']['original'];
    }
}

?>
