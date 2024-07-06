<?php

class APW_SEO {
    public static function optimize_post($post_id, $title, $description, $keywords) {
        // Integrasi dengan Yoast SEO
        if (apw_get_setting('use_yoast_seo')) {
            update_post_meta($post_id, '_yoast_wpseo_title', $title);
            update_post_meta($post_id, '_yoast_wpseo_metadesc', $description);
            update_post_meta($post_id, '_yoast_wpseo_focuskw', $keywords);
        }

        // Integrasi dengan Rank Math SEO
        if (apw_get_setting('use_rank_math_seo')) {
            update_post_meta($post_id, 'rank_math_title', $title);
            update_post_meta($post_id, 'rank_math_description', $description);
            update_post_meta($post_id, 'rank_math_focus_keyword', $keywords);
        }
    }
}

?>
