<?php
/* load plugin */
add_action( 'admin_init', 'CFYSPAY_check_load_cf7_plugin', 11 );
function CFYSPAY_check_load_cf7_plugin() {
	if ( ! ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) ) {
	   add_action( 'admin_notices','CFYSPAY_require_cf7_install_error' );
	}
}

/* install error  */
function CFYSPAY_require_cf7_install_error() {
    deactivate_plugins( plugin_basename( __FILE__ ) );?>
	<div class="error">
	   <p><?php _e( ' Stripe conatct form 7  plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=contact+form+7">Contact Form 7</a> plugin installed and activated.', 'stripe-with-contact-form-7' ); ?></p>
	</div>
<?php
}