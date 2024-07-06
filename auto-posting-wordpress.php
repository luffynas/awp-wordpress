<?php
/*
Plugin Name: Auto Posting WordPress
Description: Plugin untuk memudahkan posting konten otomatis di WordPress.
Version: 1.0
Author: luffynas
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define constants
define('APW_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('APW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include files
include_once APW_PLUGIN_PATH . 'includes/class-apw-activator.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-admin.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-api.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-youtube.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-image.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-scheduler.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-social-media.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-seo.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-template.php';
include_once APW_PLUGIN_PATH . 'includes/class-apw-prompt.php';

// include_once APW_PLUGIN_PATH . 'includes/class-apw-cron.php';

// Activation hook
register_activation_hook(__FILE__, array('APW_Activator', 'activate'));

// Enqueue scripts and styles
function apw_enqueue_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('apw-custom-js', APW_PLUGIN_URL . 'assets/js/custom.js', array('jquery'), null, true);
    wp_localize_script('apw-custom-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('admin_enqueue_scripts', 'apw_enqueue_scripts');


// Admin settings
if (is_admin()) {
    $apw_admin = new APW_Admin();
}

// Initialize scheduler
$apw_scheduler = new APW_Scheduler();

// Cron jobs
// $apw_cron = new APW_Cron();

// Menyimpan Data ke Database
function apw_save_setting($key, $value) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'apw_settings';

    // Check if the setting already exists
    $existing_setting = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE setting_key = %s", $key));

    if ($existing_setting > 0) {
        // Update existing setting
        $wpdb->update(
            $table_name,
            array('setting_value' => $value),
            array('setting_key' => $key),
            array('%s'),
            array('%s')
        );
    } else {
        // Insert new setting
        $wpdb->insert(
            $table_name,
            array(
                'setting_key' => $key,
                'setting_value' => $value
            ),
            array(
                '%s',
                '%s'
            )
        );
    }
}

// Mengambil Data dari Database
function apw_get_setting($key) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'apw_settings';

    $value = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_key = %s", $key));

    return $value;
}

// Contoh penggunaan fungsi
// Save API Key
// apw_save_setting('chatgpt_api_key', 'your_chatgpt_api_key');

// Get API Key
// $chatgpt_api_key = apw_get_setting('chatgpt_api_key');


?>
