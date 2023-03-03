<?php
/* frontend style and script */
add_action('wp_enqueue_scripts', 'CF7SPAY_load_front_script_style');
function CF7SPAY_load_front_script_style() {
    wp_enqueue_script('jquery', false, array(), false, false);
    wp_enqueue_style( 'CF7SPAY-front-style', CF7SPAY_PLUGIN_DIR . '/includes/css/front_style.css', false, '1.0.0' );
    wp_enqueue_script('cf7pp-stripe-checkout','https://js.stripe.com/v3/');
    wp_enqueue_script( 'CF7SPAY-front-script', CF7SPAY_PLUGIN_DIR . '/includes/js/front.js', false, '1.0.0' );
}

/* backend style and script */
add_action('admin_enqueue_scripts',  'CF7SPAY_load_admin_script_style');
function CF7SPAY_load_admin_script_style() {
    wp_enqueue_style( 'CF7SPAY-back-style', CF7SPAY_PLUGIN_DIR . '/includes/css/back_style.css', false, '1.0.0' );
    wp_enqueue_script( 'CF7SPAY-back-script', CF7SPAY_PLUGIN_DIR . '/includes/js/back_script.js', false, '1.0.0' );
    $CF7SPAY_array_img = CF7SPAY_PLUGIN_DIR;
    wp_localize_script( 'CF7SPAY-back-script', 'CF7SPAY_name', array('CF7SPAY_array_img'=>$CF7SPAY_array_img) );
}