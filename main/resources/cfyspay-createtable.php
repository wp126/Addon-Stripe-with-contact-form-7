<?php 
function CFYSPAY_createTableDatabase(){
    global $wpdb;
    $table_name = $wpdb->prefix.'cf7spay_forms';
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            form_id bigint(20) NOT NULL AUTO_INCREMENT,
            form_post_id bigint(20) NOT NULL,
            form_value longtext NOT NULL,
            form_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (form_id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    $upload_dir      = wp_upload_dir();
    $cf7wpay_dirname = $upload_dir['basedir'].'/cf7wpay_uploads';
    if ( ! file_exists( $cf7wpay_dirname ) ) {
        wp_mkdir_p( $cf7wpay_dirname );
    }
}
add_action('init' , 'CFYSPAY_createTableDatabase' );