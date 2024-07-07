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
                'prompt' => $prompt,
                'max_tokens' => 1500,
                'temperature' => 0.7,
                'top_p' => 0.9
            )),
            'timeout' => 300, 
        ));

        // error_log('$response OpenApi generate_content_with_chatgpt::: '.print_r($response, true));
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => $response->get_error_message()));
        } else {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            error_log('$response OpenApi json_decode ::: '.print_r($data, true));
            if (isset($data['choices'])) {
                return $data['choices'][0]['text'];
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

    public static function generate_outline_with_chatgpt($prompt) {
        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $full_response = '';
        $attempt = 0;
        $max_attempts = 2;

        while ($attempt < $max_attempts) {
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode(array(
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $prompt,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                    'top_p' => 0.9
                )),
                'timeout' => 300, 
            ));

            if (is_wp_error($response)) {
                return 'Error: ' . $response->get_error_message();
            } else {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                if (isset($data['choices'])) {
                    $full_response .= $data['choices'][0]['text'];
                    
                    // Jika panjang response kurang dari max_tokens, artinya tidak terpotong
                    if (strlen($data['choices'][0]['text']) < 1000) {
                        break;
                    }

                    // Update prompt untuk melanjutkan dari bagian terakhir
                    $prompt = 'Continue from: ' . substr($data['choices'][0]['text'], -50);
                } else {
                    return 'Invalid API response.';
                }
            }

            $attempt++;
        }

        return $full_response;
    }

    public static function generate_summarize_section_content($outline, $section, $prompt_base) {
        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $full_prompt = "\n\nIkuti saja item-item yang ada di dalam Section dan jangan pernah membuat artikel diluar Section\n\n$prompt_base\n\nSection: $section\n\nPlease write a detailed and comprehensive section on the topic mentioned above, each section should be informative and in-depth, giving the reader a clear understanding of the topic covered. Please use Indonesian language and Make sure to Markdown format";
        // error_log('full_prompt $section :: '.$section);
        error_log('full_prompt HEADING :: '.$full_prompt);

        try {
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode(array(
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $full_prompt,
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                    'top_p' => 0.9
                )),
                'timeout' => 300, 
            ));

            if (is_wp_error($response)) {
                return 'Error: ' . $response->get_error_message();
            } else {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                if (isset($data['choices'])) {
                    return $data['choices'][0]['text'];
                } else {
                    return 'Invalid API response.';
                }
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    
    public static function generate_remember_outline($outline, $prompt_base) {
        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $full_prompt = "$prompt_base\n\nOutline:\n$outline";
        // error_log('full_prompt $section :: '.$section);
        error_log('generate_remember_outline :: '.$full_prompt);

        try {
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode(array(
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $full_prompt,
                    'max_tokens' => 10,
                    'temperature' => 0.5,
                    'top_p' => 0.9
                )),
                'timeout' => 300, 
            ));

            if (is_wp_error($response)) {
                return 'Error: ' . $response->get_error_message();
            } else {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                if (isset($data['choices'])) {
                    return $data['choices'][0]['text'];
                } else {
                    return 'Invalid API response.';
                }
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public static function generate_section_content($outline, $section, $prompt_base) {
        $api_key = apw_get_setting('openai_api_key');
        $url = 'https://api.openai.com/v1/completions';

        $full_prompt = "Ikuti saja item-item yang ada di dalam Section dan jangan pernah membuat artikel diluar Section\n\n $prompt_base\n\nSection: $section\n\nPlease write a detailed and comprehensive section on the topic mentioned above, each section should be informative and in-depth, giving the reader a clear understanding of the topic covered. Please use Indonesian language and Make sure to Markdown format and start with ## for heading";
        // error_log('full_prompt $section :: '.$section);
        error_log('full_prompt :: '.$full_prompt);

        try {
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode(array(
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $full_prompt,
                    'max_tokens' => 800,
                    'temperature' => 0.7,
                    'top_p' => 0.9
                )),
                'timeout' => 300, 
            ));

            if (is_wp_error($response)) {
                return 'Error: ' . $response->get_error_message();
            } else {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                if (isset($data['choices'])) {
                    return $data['choices'][0]['text'];
                } else {
                    return 'Invalid API response.';
                }
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public static function generate_full_article($outline, $prompt_base, $prompt_base_summarize) {
        $sections = explode("\n\n", $outline);
        $full_content = '';

        foreach ($sections as $section) {
            if (!empty(trim($section))) {
                // $content = self::generate_section_content($outline, $section, $prompt_base);
                $heading = APW_API::getHeadingItems($section);
                if (!empty($heading)) {
                    $content = self::generate_summarize_section_content($outline, $section, $prompt_base_summarize);
                    $full_content .= $content . "\n";
                }
                $subheading = APW_API::getSubheadingItems($section);
                if (!empty($subheading)) {
                    $content = self::generate_section_content($outline, $section, $prompt_base);
                    error_log("CONE+TENT ::: ".$content);
                    $full_content .= $content . "\n";
                }
            }
        }

        return $full_content;
    }

    // Function to parse markdown and get specific heading with its items
    public static function getHeadingItems($text) {
        // Split the text into lines
        $lines = explode("\n", $text);
        $capture = false;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Check if the line is the target subheading
            if (preg_match('/^# (.+)$/', $line, $matches)) {
                // Found a heading
                return $matches[1];
                break;
            }
        }
    
        return '';
    }

    // Function to parse markdown and get specific subheading with its items
    public static function getSubheadingItems($text) {
        // Split the text into lines
        $lines = explode("\n", $text);
        $capture = false;
    
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (preg_match('/^## (.+)$/', $line, $matches)) {
                // Found a subheading
                return $matches[1];
                break;
            }
        }
    
        return '';
    }
}

?>
