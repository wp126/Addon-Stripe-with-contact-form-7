<?php

add_action( 'wpcf7_init', 'cfyspay_add_form_tag_payment', 10, 0 );

function cfyspay_add_form_tag_payment() {
    wpcf7_add_form_tag( array( 'payment', 'payment*' ),
        'cfyspay_payment_form_tag_handler', array( 'name-attr' => true) );
}


function cfyspay_payment_form_tag_handler( $tag ) {
    if ( empty( $tag->name ) ) {
        return '';
    }

    $contact_form = WPCF7_ContactForm::get_current();
    $formid = $contact_form->id();
    
    $validation_error = wpcf7_get_validation_error( $tag->name );
    $class = wpcf7_form_controls_class( $tag->type );
    $class .= ' wpcf7-validates-as-payment';

    $atts = array();
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();
    
    $atts['class'] .= " cfywpay-payment";

    $atts['name'] = $tag->name;

    $atts = wpcf7_format_atts( $atts );

    
    $cfywpay_options = '';
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (  ( is_plugin_active( 'paypal-with-contact-form-7/paypal-with-contact-form-7.php' ) ) ) {
            $enabled_use_paypal = get_post_meta( $formid, 'enabled_use_paypal', true );
            $paypal_label = get_post_meta( $formid, 'pw_paypal_label', true );
               
            if($paypal_label == '') {
                $paypal_label = "Pay with Paypal";
            }
            if($enabled_use_paypal == 'on') {
                $cfywpay_options .= '<option value="paypal">'.$paypal_label.'</option>';
            }
    }

    $enabled_use_stripe = get_post_meta( $formid, 'enabled_use_stripe', true );
    $stripe_label = get_post_meta( $formid, 'pw_stripe_label', true );

    if($stripe_label == '') {
        $stripe_label = "Pay with Stripe";
    }

    if($enabled_use_stripe == 'on') {
        $cfywpay_options .= '<option value="stripe">'.$stripe_label.'</option>';
    }

    $html = '';

    if( $enabled_use_stripe != 'on') {
    	$html .= sprintf(
    '<span class="wpcf7-form-control-wrap %1$s"><p class="cf7wpay_npymthd">No Payment Method Defined</p>',
    sanitize_html_class( $tag->name ));
    } else {
    	$html .= sprintf(
    '<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select></span>',
    sanitize_html_class( $tag->name ), $atts, $cfywpay_options, $validation_error );
    }
    
    return $html;
}