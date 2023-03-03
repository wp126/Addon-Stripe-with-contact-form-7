<?php
/*PLUGIN LOADED contact form 7 */
add_action( 'plugins_loaded', 'CFYSPAY_load_textdomain' );
function CFYSPAY_load_textdomain() {
    load_plugin_textdomain( 'stripe-with-contact-form-7', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

/*LANGUAGES FOLDER contact form 7 */
function CFYSPAY_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'stripe-with-contact-form-7' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'CFYSPAY_load_my_own_textdomain', 10, 2 );