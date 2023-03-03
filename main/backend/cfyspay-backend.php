<?php
add_action( 'admin_menu', 'cfyspay_my_menu_pages');
function cfyspay_my_menu_pages() {

    add_submenu_page( 'wpcf7', __( 'Stripe Entries', 'cf7wpay' ), __( 'Stripe Entries', 'cf7wpay' ),'manage_options','cfywpay_stripe_entries',  'cfyspay_list_table_page');
}

function cfyspay_recursive_sanitize_text_field($array) {
    $new_arr = array();
    if (is_array($array) || is_object($array)){
        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) ) {
                $value = cfyspay_recursive_sanitize_text_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
                $new_arr[] = $value;
            }
        }
    }
    return $new_arr;
}

function cfyspay_list_table_page() {

    $cfyspay_formid  = empty($_GET['cfyspay_formid']) ? 0 : (int) sanitize_text_field($_GET['cfyspay_formid']);
    $cfywpay_entryid = empty($_GET['cfywpay_entryid']) ? 0 : (int) sanitize_text_field($_GET['cfywpay_entryid']);

    if ( !empty($cfyspay_formid) && empty($_GET['cfywpay_entryid']) ) {
        $ListTable = new CF7SPAY_Data_List_Table();
        $ListTable->data_prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2><?php echo get_the_title((int) sanitize_text_field($_GET['cfyspay_formid'])); ?></h2>
                <form method="post" action="">

                    <?php $ListTable->search_box('Search', 'search'); ?>
                    <input type="hidden" name="cf7_pap" value="forcsv">
                    <?php $ListTable->display(); ?>
                </form>
            </div>
        <?php
        return;
    }

    if( !empty($cfywpay_entryid) && !empty($cfyspay_formid) ) {
        new CF7SPAY_Form_Details();
        return;
    }
    
    if(empty($cfyspay_formid)) {
        $ListTable = new CF7SPAY_Main_List_Table();
        $ListTable->prepare_items(); ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2><?php _e( 'Contact Forms Data List', 'cf7wpay' ); ?></h2>
            <?php $ListTable->display(); ?>
        </div>
    <?php
    }
}


function cfyspay_download_send_headers( $filename ) {
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}


function cfyspay_array2csv(array &$array, $df) {

    if (count($array) == 0) {
        return null;
    }

    $array_keys = array_keys($array);
    $heading    = array();
    $unwanted   = array('cfdb7_', 'your-');

    foreach ( $array_keys as $aKeys ) {
        $tmp       = str_replace( $unwanted, '', $aKeys );
        $heading[] = ucfirst( $tmp );
    }
    fputcsv( $df, $heading );

    foreach ( $array['form_id'] as $line => $form_id ) {
        $line_values = array();
        foreach($array_keys as $array_key ) {
            $val = isset( $array[ $array_key ][ $line ] ) ? $array[ $array_key ][ $line ] : '';
            $line_values[ $array_key ] = $val;
        }
        fputcsv($df, $line_values);
    }
}


add_action( 'init',  'cfyspay_bulk_action_csv' );
function cfyspay_bulk_action_csv() {
    if(isset($_REQUEST['cf7_pap']) && $_REQUEST['cf7_pap']=='forcsv' && $_REQUEST['action']=='csv'){

    	global $wpdb;
        $table_name  = $wpdb->prefix.'cf7spay_forms';
    	$form_ids = cfyspay_recursive_sanitize_text_field( $_POST['contact_form'] );
    	$all_ids = implode(",", $form_ids);
    	$heading_row = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id IN($all_ids)", OBJECT );
    	$heading_row    = reset( $heading_row );
        $heading_row    = unserialize( $heading_row->form_value );
        $heading_key    = array_keys( $heading_row );
        $total_rows  = COUNT($form_ids); 
        $per_query    = 1000;
        $total_query  = ( $total_rows / $per_query );


        cfyspay_download_send_headers( "cfdb7-" . date("Y-m-d-h-i-s") . ".csv" );
        $df = fopen("php://output", 'w');
        ob_start();
        for( $p = 0; $p <= $total_query; $p++ ) {

            $offset  = $p * $per_query;
            $results = $wpdb->get_results("SELECT form_id, form_value, form_date FROM $table_name
            WHERE form_id IN($all_ids) LIMIT $offset, $per_query",OBJECT);
            
            $data  = array();
            $i     = 0;
            foreach ($results as $result) :
                
                $i++;
                $data['form_id'][$i]    = $result->form_id;
                $data['form_date'][$i]  = $result->form_date;
                $resultTmp              = unserialize( $result->form_value );
                $upload_dir             = wp_upload_dir();
                $cfdb7_dir_url          = $upload_dir['baseurl'].'/cf7wpay_uploads';

                foreach ($resultTmp as $key => $value):
                    $matches = array();

                    if ( ! in_array( $key, $heading_key ) ) continue;
                    if( ! empty($matches[0]) ) continue;

                    if (strpos($key, 'cfdb7_file') !== false ){
                        $data[$key][$i] = $cfdb7_dir_url.'/'.$value;
                        continue;
                    }
                    if ( is_array($value) ) {

                        $data[$key][$i] = implode(', ', $value);
                        continue;
                    }

                    $data[$key][$i] = str_replace( array('&quot;','&#039;','&#047;','&#092;')
                    , array('"',"'",'/','\\'), $value );

                endforeach;

            endforeach;

            echo cfyspay_array2csv( $data, $df );
        }
        echo ob_get_clean();
        fclose( $df );
        die();
    }
}

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


//main cf7 list
class CF7SPAY_Main_List_Table extends WP_List_Table {

    public function prepare_items() {

        global $wpdb;

        $columns     = $this->get_columns();
        $hidden      = $this->get_hidden_columns();
        $data        = $this->table_data();
        $perPage     = 10;
        $currentPage = $this->get_pagenum();
        $totalItems  = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden );
        $this->items = $data;
    }
    
    public function get_columns() {

        $columns = array(
            'name' => __( 'Contact Form Name', 'cf7wpay' ),
            'count'=> __( 'Number of Entries', 'cf7wpay' )
        );
        return $columns;
    }

    public function get_hidden_columns() {
        return array();
    }

    private function table_data() {
        global $wpdb;

        $data         = array();
        $table_name   = $wpdb->prefix.'cf7spay_forms';
        $args = array(
            'post_type'=> 'wpcf7_contact_form',
            'order'    => 'ASC',
            'meta_query' => array (
                array (
                'key' => 'enabled_use_stripe',
                'value' => 'on',
                'compare' => '=',
                )
            )
        );
        $the_query = new WP_Query( $args );
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $form_post_id = get_the_id();
            $totalItems   = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE form_post_id = $form_post_id");
            $title = get_the_title();
            $link  = "<a class='row-title' href=admin.php?page=cfywpay_stripe_entries&cfyspay_formid=$form_post_id>%s</a>";
            $data_value['name']  = sprintf( $link, $title );
            $data_value['count'] = $totalItems;
            $data[] = $data_value;
        endwhile;
        return $data;
    }

    public function column_default( $item, $column_name ){
        return $item[ $column_name ];
    }
}

//end main cf7 list

class CF7SPAY_Data_List_Table extends WP_List_Table{
    private $form_post_id;
    private $column_titles;

    public function __construct() {

        parent::__construct(
            array(
                'singular' => 'contact_form',
                'plural'   => 'contact_forms',
                'ajax'     => false
            )
        );
    }


    public function data_prepare_items() {
        global $wpdb;

        $search = empty( $_REQUEST['s'] ) ? false :  sanitize_text_field( $_POST['s'] );
        $this->form_post_id =  (int) sanitize_text_field($_GET['cfyspay_formid']);
        $form_post_id  = $this->form_post_id;
        $columns     = $this->get_columns();
        $hidden      = $this->get_hidden_columns();
        $sortable    = $this->get_sortable_columns();
        $data        = $this->table_data();
        $perPage     = 15;
        $currentPage = $this->get_pagenum();
        $this->process_bulk_action();
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $table_name  = $wpdb->prefix.'cf7spay_forms';
        
        if ( ! empty($search) ) {
            $totalItems  = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE form_value LIKE '%$search%' AND form_post_id = '$form_post_id'");
        }else{
            $totalItems  = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE form_post_id = '$form_post_id'");
        }

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $this->_column_headers = array($columns, $hidden ,$sortable);
        $this->items = $data;
    }


    public function get_columns() {
        $form_post_id  = $this->form_post_id;

        global $wpdb;
        $table_name    = $wpdb->prefix.'cf7spay_forms';
        $results       = $wpdb->get_results( "
            SELECT * FROM $table_name 
            WHERE form_post_id = $form_post_id ORDER BY form_id DESC LIMIT 20", OBJECT 
        );

        $first_row            = isset($results[0]) ? unserialize( $results[0]->form_value ): 0 ;
        $columns              = array();
        $rm_underscore        = apply_filters('remove_underscore_data', true);

        if( !empty($first_row) ){
            $columns['cb']      = '<input type="checkbox" />';
            foreach ($first_row as $key => $value) {

                $matches = array();

                if( $key == 'cf7wpay_status' ) continue;
                if( $rm_underscore ) preg_match('/^_.*$/m', $key, $matches);
                if( ! empty($matches[0]) ) continue;

                $key_val       = str_replace( array('your-', 'cfdb7_file'), '', $key);
                $columns[$key] = ucfirst( $key_val );
                
                $this->column_titles[] = $key_val;

                if ( sizeof($columns) > 4) break;
            }
            $columns['form-date'] = 'Date';
            $columns['action'] = 'View';
        }

        return $columns;
    }
    

    public function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['form_id']
        );
    }


    public function get_hidden_columns() {
        return  array('form_id');
    }


    public function get_sortable_columns() {
       return array('form-date' => array('form-date', true));
    }


    public function get_bulk_actions() {
        return array(
            'read'   => __( 'Read', 'cf7wpay' ),
            'unread' => __( 'Unread', 'cf7wpay' ),
            'delete' => __( 'Delete', 'cf7wpay' ),
            'csv' => __( 'Export CSV', 'cf7wpay' )
        );
    }

    private function table_data() {
        $data = array();
        global $wpdb;
        $search       = empty( $_REQUEST['s'] ) ? false :  sanitize_text_field( $_POST['s'] );
        $table_name   = $wpdb->prefix.'cf7spay_forms';
        $form_post_id = $this->form_post_id;

        $orderby = isset($_GET['orderby']) ? 'form_date' : 'form_id';
        $order   = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'desc';
        $order   = sanitize_text_field($order);

        if ( ! empty($search) ) {

            $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE  form_value LIKE '%$search%'
            AND form_post_id = '$form_post_id'
            ORDER BY $orderby $order", OBJECT );

        }else{

            $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_post_id = $form_post_id
            ORDER BY $orderby $order", OBJECT );
        }
        
        foreach ( $results as $result ) {

            $form_value = unserialize( $result->form_value );

            $link = "<b><a href=admin.php?page=cfywpay_stripe_entries&cfyspay_formid=%s&cfywpay_entryid=%s>%s</a></b>";
            if(isset($form_value['cf7wpay_status']) && ( $form_value['cf7wpay_status'] === 'read' ) )
                $link  = "<a href=admin.php?page=cfywpay_stripe_entries&cfyspay_formid=%s&cfywpay_entryid=%s>%s</a>";

            $cfyspay_formid           = $result->form_post_id;
            $form_values['form_id']   = $result->form_id;

            foreach ( $this->column_titles as $col_title) {
                $form_value[ $col_title ] = isset( $form_value[ $col_title ] ) ? $form_value[ $col_title ] : '';
            }

            foreach ($form_value as $k => $value) {

                $ktmp = $k;
                $can_foreach = is_array($value) || is_object($value);

                if ( $can_foreach ) {

                    foreach ($value as $k_val => $val):
                        $val                = esc_html( $val );
                        $form_values[$ktmp] = ( strlen($val) > 150 ) ? substr($val, 0, 150).'...': $val;
                        $form_values[$ktmp] = $form_values[$ktmp];

                    endforeach;
                }else{
                    $value = esc_html( $value );
                    $form_values[$ktmp] = ( strlen($value) > 150 ) ? substr($value, 0, 150).'...': $value;
                    $form_values[$ktmp] = $form_values[$ktmp];
                }

            }
            $form_values['form-date'] = $result->form_date;
            $form_values['action'] = sprintf($link, $cfyspay_formid, $result->form_id, 'View');
            $data[] = $form_values;
        }

        return $data;
    }


    public function process_bulk_action() {

        global $wpdb;
        $table_name = $wpdb->prefix.'cf7spay_forms';
        $action     = $this->current_action();

        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce        = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $nonce_action = 'bulk-' . $this->_args['plural'];

            if ( !wp_verify_nonce( $nonce, $nonce_action ) ) {

                wp_die( 'Not valid..!!' );
            }
        }

        if( 'delete' === $action ) {

            $form_ids = cfyspay_recursive_sanitize_text_field( $_POST['contact_form'] );

            foreach ($form_ids as $form_id):

                $results       = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id = $form_id LIMIT 1", OBJECT );
                $result_value  = $results[0]->form_value;
                $result_values = unserialize($result_value);
                $upload_dir    = wp_upload_dir();
                $cf7wpay_dirname = $upload_dir['basedir'].'/cf7wpay_uploads';

                foreach ($result_values as $key => $result) {

                    if ( ( strpos($key, 'cfdb7_file') !== false ) &&
                        file_exists($cf7wpay_dirname.'/'.$result) ) {
                        unlink($cf7wpay_dirname.'/'.$result);
                    }

                }

                $wpdb->delete(
                    $table_name ,
                    array( 'form_id' => $form_id ),
                    array( '%d' )
                );
                ?>
                <script type="text/javascript">
                    window.location.href = "<?php echo sanitize_text_field($_SERVER['HTTP_REFERER']); ?>";
                </script>
                <?php
            endforeach;
            
        }else if( 'read' === $action ) {

            $form_ids = cfyspay_recursive_sanitize_text_field( $_POST['contact_form'] );
            foreach ($form_ids as $form_id):

                $results       = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id = '$form_id' LIMIT 1", OBJECT );
                $result_value  = $results[0]->form_value;
                $result_values = unserialize( $result_value );
                $result_values['cf7wpay_status'] = 'read';
                $form_data = serialize( $result_values );
                $wpdb->query(
                    "UPDATE $table_name SET form_value = '$form_data' WHERE form_id = '$form_id'"
                );
            endforeach;
        }else if( 'unread' === $action ){

            $form_ids = cfyspay_recursive_sanitize_text_field( $_POST['contact_form'] );
            foreach ($form_ids as $form_id):

                $results       = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id = '$form_id' LIMIT 1", OBJECT );
                $result_value  = $results[0]->form_value;
                $result_values = unserialize( $result_value );
                $result_values['cf7wpay_status'] = 'unread';
                $form_data = serialize( $result_values );
                $wpdb->query(
                    "UPDATE $table_name SET form_value = '$form_data' WHERE form_id = '$form_id'"
                );
            endforeach;

        }else{

        }
    }
    

    public function column_default( $item, $column_name ){
        return $item[ $column_name ];
    }


    private function sort_data( $a, $b ){
        $orderby = 'form_date';
        $order = 'asc';
        
        if(!empty($_GET['orderby']))
        {
            $orderby = sanitize_text_field($_GET['orderby']);
        }
        
        if(!empty($_GET['order']))
        {
            $order = sanitize_text_field($_GET['order']);
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }


    protected function bulk_actions( $which = '' ) {
        if ( is_null( $this->_actions ) ) {
            $this->_actions = $this->get_bulk_actions();
           
            $this->_actions = apply_filters( "bulk_actions-{$this->screen->id}", $this->_actions );
            $two = '';
        } else {
            $two = '2';
        }

        if ( empty( $this->_actions ) )
            return;

        echo '<label for="bulk-action-selector-' . esc_attr( $which ) . '" class="screen-reader-text">' . __( 'Select bulk action', 'cf7wpay' ) . '</label>';
        echo '<select name="action' . esc_attr($two) . '" id="bulk-action-selector-' . esc_attr( $which ) . "\">\n";
        echo '<option value="-1">' . __( 'Bulk Actions', 'cf7wpay' ) . "</option>\n";

        foreach ( $this->_actions as $name => $title ) {
            $class = 'edit' === $name ? ' class="hide-if-no-js"' : '';

            echo "\t" . '<option value="' . esc_attr($name) . '"' . esc_attr($class) . '>' . esc_attr($title) . "</option>\n";
        }

        echo "</select>\n";

        submit_button( __( 'Apply', 'cf7wpay' ), 'action', '', false, array( 'id' => "doaction$two" ) );
        echo "\n";
        $nonce = wp_create_nonce( 'dnonce' );
        echo "<a href='".sanitize_text_field($_SERVER['REQUEST_URI'])."&csv=true&nonce=".esc_attr($nonce)."' style='float:right; margin:0;' class='button'>";
        _e( 'Export CSV', 'cf7wpay' );
        echo '</a>';
        
    }
}
//end main cf7 sub form list


class CF7SPAY_Form_Details{
    private $form_id;
    private $form_post_id;
    public function __construct() {
       $this->form_post_id = sanitize_text_field( $_GET['cfyspay_formid'] );
       $this->form_id = sanitize_text_field( $_GET['cfywpay_entryid'] );
       $this->CF7SPAY_form_details_page();
    }


    public function CF7SPAY_form_details_page() {
        global $wpdb;
        $table_name    = $wpdb->prefix.'cf7spay_forms';
        $upload_dir    = wp_upload_dir();
        $cfdb7_dir_url = $upload_dir['baseurl'].'/cf7wpay_uploads';


        if ( is_numeric($this->form_post_id) && is_numeric($this->form_id) ) {

           $results    = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_post_id = $this->form_post_id AND form_id = $this->form_id LIMIT 1", OBJECT );
        }

        if ( empty($results) ) {
            wp_die( $message = 'Not valid contact form' );
        }
        ?>
        <div class="cf7wpay_trandetais">
            <div class="wrap">
                <div id="welcome-panel" class="welcome-panel">
                    <div class="welcome-panel-content">
                        <div class="welcome-panel-column-container">
                            <h2><?php echo get_the_title( $this->form_post_id ); ?></h2>
                            <p><span><?php echo esc_html($results[0]->form_date); ?></span></p>
                            <table>
                                <?php $form_data  = unserialize( $results[0]->form_value );

                                    $payment_method = 'Stripe';

                                    foreach ($form_data as $key => $data):

                                            echo "<tr>";

                                            $matches = array();

                                            if ( $key == 'cf7wpay_status' )  continue;

                                            if( ! empty($matches[0]) ) continue;

                                            if ( strpos($key, 'cfdb7_file') !== false ) {

                                                $key_val = str_replace('cfdb7_file', '', $key);
                                                $key_val = str_replace('your-', '', $key_val);
                                                $key_val = ucfirst( $key_val );
                                                echo '<td><b>'.esc_attr($key_val).'</b></td><td><a href="'.esc_attr($cfdb7_dir_url).'/'.esc_attr($data).'">'
                                                .esc_attr($data).'</a></td>';

                                            } else {


                                                if ( is_array($data) ) {

                                                    $key_val = str_replace('your-', '', $key);
                                                    $key_val = ucfirst( $key_val );
                                                    $arr_str_data =  implode(', ',$data);
                                                    $arr_str_data =  esc_html($arr_str_data);
                                                    echo '<td><b>'.esc_attr($key_val).'</b></td><td> '. nl2br(esc_html($arr_str_data)) .'</td>';

                                                } else {

                                                    $key_val = str_replace('your-', '', $key);
                                                    $key_val = ucfirst( $key_val );
                                                    $data    = esc_html($data);
                                                    echo '<td><b>'.esc_attr($key_val).'</b></td><td> '.nl2br(esc_html($data)).'</td>';
                                                }
                                                
                                            }
                                        echo "</tr>";
                                    endforeach;
                                    
                                ?>
                                <tr>
                                    <td><b><?php echo esc_html('Item (Description)'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_item_name', true );?></td>
                                </tr>
                                <tr>
                                    <td><b><?php echo esc_html('Item ID / SKU'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_item_number', true );?></td>
                                </tr>
                                <?php
                                if($payment_method == 'stripe') {
                                ?>
                                <tr>
                                    <td><b><?php echo esc_html('Payment Status'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_payment_status', true );?></td>
                                </tr>
                                <?php
                            	}
                                ?>
                                <tr>
                                    <td><b><?php echo esc_html('Payment Amount'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_payment_amount', true );?></td>
                                </tr>
                                <tr>
                                    <td><b><?php echo esc_html('Payment Currency'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_payment_currency', true );?></td>
                                </tr>
                                <tr>
                                    <td><b><?php echo esc_html('Transaction Id'); ?></b></td>
                                    <td><?php echo get_post_meta( $this->form_id, 'cf7wpay_txn_id', true );?></td>
                                </tr>
                            </table>
                            <?php
                            $form_data['cf7wpay_status'] = 'read';
                            $form_data = serialize( $form_data );
                            $form_id = $results[0]->form_id;
                            $wpdb->query( "UPDATE $table_name SET form_value = '$form_data' WHERE form_id = $form_id");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}