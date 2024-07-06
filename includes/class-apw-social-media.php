<?php

class APW_Social_Media {
    public static function post_to_facebook($message, $link) {
        $api_key = apw_get_setting('facebook_api_key');
        $url = 'https://graph.facebook.com/v12.0/me/feed';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'message' => $message,
                'link' => $link
            ))
        ));

        return $response;
    }

    public static function post_to_twitter($message, $link) {
        $api_key = apw_get_setting('twitter_api_key');
        $url = 'https://api.twitter.com/2/tweets';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'text' => $message . ' ' . $link
            ))
        ));

        return $response;
    }

    public static function post_to_instagram($message, $image_url) {
        $api_key = apw_get_setting('instagram_api_key');
        $url = 'https://graph.instagram.com/me/media';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'image_url' => $image_url,
                'caption' => $message
            ))
        ));

        return $response;
    }

    public static function post_to_whatsapp($message) {
        $api_key = apw_get_setting('whatsapp_api_key');
        $url = 'https://graph.facebook.com/v13.0/me/messages';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'messaging_product' => 'whatsapp',
                'to' => 'RECIPIENT_PHONE_NUMBER',
                'type' => 'text',
                'text' => array(
                    'body' => $message
                )
            ))
        ));

        return $response;
    }
}

?>
