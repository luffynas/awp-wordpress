<?php

class APW_API {
    public static function generate_content_with_chatgpt($prompt) {
        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $sample_prompt = 'Tulis artikel blog yang komprehensif tentang "Cara Efektif Belajar SEO untuk Pemula". 
Artikel harus mencakup pendahuluan, langkah-langkah praktis, tips penting, dan kesimpulan. Tolong format dengan Markdown.';

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $sample_prompt,
                'max_tokens' => 500,
                'temperature' => 0.7,
                'top_p' => 0.9
            )),
            'timeout' => 300, 
        ));

        error_log('$response OpenApi generate_content_with_chatgpt::: '.print_r($response, true));
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        } else {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            error_log('$response OpenApi json_decode ::: '.print_r($data, true));
            if (isset($data['choices'])) {
                wp_send_json_success();
            } else {
                wp_send_json_error(array('message' => 'Invalid API response.'));
            }
        }
    }

    public static function generate_content_with_gemini($prompt) {
        $api_key = apw_get_setting('gemini_api_key');
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
            return 'Error: ' . $response->get_error_message();
        }

        $response_data = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($response_data['error'])) {
            return 'Error: ' . $response_data['error']['message'];
        }

        return $response_data['contents'][0]['parts'][0]['text'];
    }
}

?>
