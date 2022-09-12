<?php
/**
* Plugin Name: Addon Stripe With Contact Form 7
* Description: This plugin allows create Addon Paypal With Contact Form 7 plugin.
* Version: 1.0
* Copyright: 2020
* Text Domain: addon-stripe-with-contact-form-7
* Domain Path: /languages 
*/


if (!defined('CF7SPAY_PLUGIN_DIR')) {
    define('CF7SPAY_PLUGIN_DIR',plugins_url('', __FILE__));
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
