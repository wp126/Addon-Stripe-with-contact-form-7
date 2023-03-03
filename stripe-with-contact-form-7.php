<?php
/**
* Plugin Name: Addon Stripe With Contact Form 7
* Description: This plugin allows create Addon Paypal With Contact Form 7 plugin.
* Version: 1.0
* Copyright: 2023
* Text Domain: addon-stripe-with-contact-form-7
* Domain Path: /languages 
*/


// define for plugin dir path
if (!defined('CF7SPAY_PLUGIN_DIR')) {
    define('CF7SPAY_PLUGIN_DIR',plugins_url('', __FILE__));
}

// define for plugin file
if (!defined('CF7SPAY_PLUGIN_FILE')) {
    define('CF7SPAY_PLUGIN_FILE', __FILE__);
}

// define for base name
if (!defined('CF7SPAY_BASE_NAME')) {
    define('CF7SPAY_BASE_NAME', plugin_basename( CF7SPAY_PLUGIN_FILE ));
}

include_once('main/backend/cfyspay-backend.php');
include_once('main/backend/cfyspay-export-csv.php');
include_once('main/backend/cfyspay-cf7-panel.php');
include_once('main/backend/cfyspay-payment.php');

if (!class_exists('Stripe\Stripe')) {
    include_once('includes/stripe_library/init.php');
}

include_once('main/resources/cfyspay-createtable.php');
include_once('main/resources/cfyspay-installation-require.php');
include_once('main/resources/cfyspay-language.php');
include_once('main/resources/cfyspay-load-js-css.php');

function CF7SPAY_support_and_rating_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ($plugin_file_name !== plugin_basename(__FILE__)) {
      return $links_array;
    }

    $links_array[] = '<a href="https://www.plugin999.com/support/">'. __('Support', 'stripe-with-contact-form-7') .'</a>';
    $links_array[] = '<a href="https://wordpress.org/support/plugin/addon-stripe-with-contact-form-7/reviews/?filter=5">'. __('Rate the plugin ★★★★★', 'stripe-with-contact-form-7') .'</a>';

    return $links_array;

}
add_filter( 'plugin_row_meta', 'CF7SPAY_support_and_rating_links', 10, 4 );