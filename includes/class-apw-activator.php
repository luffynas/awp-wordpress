<?php

class APW_Activator {
    public static function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();

        // Table for settings
        $table_name = $wpdb->prefix . 'apw_settings';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            setting_key varchar(255) NOT NULL,
            setting_value text NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY setting_key (setting_key)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Table for keywords
        $table_name = $wpdb->prefix . 'apw_keywords';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            keyword varchar(255) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY keyword (keyword)
        ) $charset_collate;";
        dbDelta($sql);

        // Table for templates
        $table_name = $wpdb->prefix . 'apw_templates';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            template_name varchar(255) NOT NULL,
            template_content text NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY template_name (template_name)
        ) $charset_collate;";
        dbDelta($sql);

        // Table for social media settings
        $table_name = $wpdb->prefix . 'apw_social_media';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            platform varchar(255) NOT NULL,
            api_key varchar(255) NOT NULL,
            access_token text NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY platform (platform)
        ) $charset_collate;";
        dbDelta($sql);

        // Tabel logging
        $table_name = $wpdb->prefix . 'apw_logging';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id bigint(20) NOT NULL,
            status varchar(255) NOT NULL,
            message text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);

        // Tabel Style
        $table_name = $wpdb->prefix . 'apw_styles';
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            type varchar(50) NOT NULL,
            name varchar(50) NOT NULL,
            description text,
            example text,
            characteristics text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);

        //// Seeder
        require_once plugin_dir_path( __FILE__ ) . 'class-apw-seeder.php';
        APW_Seeder::seed_styles();
    }
}
?>
