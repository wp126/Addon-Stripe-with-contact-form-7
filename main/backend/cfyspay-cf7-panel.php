<?php
add_filter( 'wpcf7_editor_panels','cf7spay_editor_panels', 10, 1 ); 
function cf7spay_editor_panels( $panels ) {
    $stripe = array(
        'stripe-panel' => array(
            'title' => __( 'Stripe Settings', 'contact-form-7' ),
            'callback' =>  'cf7spay_pp_strp_settings_editor_panel_popup',
        ),
    );
    $panels = array_merge($panels,$stripe);
    return $panels;
}


function cf7spay_pp_strp_settings_editor_panel_popup() {

    if(isset($_REQUEST['post']) && $_REQUEST['post'] != '') {
        $formid = sanitize_text_field($_REQUEST['post']);
    } else {
        $formid = NULL;
    }

    ?>
   
    <h2><?php echo esc_html_e('Stripe','stripe-with-contact-form-7');?></h2>
    <fieldset>
        <table class="cf7wpay_paypal_main">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Use Stripe','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo esc_html_e('enabled_use_stripe','stripe-with-contact-form-7');?>" value="on" <?php if(get_post_meta( $formid, 'enabled_use_stripe', true ) == "on") { echo "checked"; } ?>><label>Use Stripe</label>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Customer Email','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="<?php echo esc_html_e('stripe_customer_email' ,'stripe-with-contact-form-7');?>" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_customer_email', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Payment Gateway','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <p><strong>[payment payment]</strong> <?php echo esc_html_e('- Use this custom tag to add payment method option to your form.','stripe-with-contact-form-7');?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Item Description','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="<?php echo esc_html_e('stripe_item_description','stripe-with-contact-form-7');?>" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_item_description', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Item ID / SKU','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="<?php echo esc_html_e('stripe_item_id_sku','stripe-with-contact-form-7');?>" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_item_id_sku', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Custom Amount','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="number" name="amount" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_amount', true ));?>">
                      
                      
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Custom Quantity','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                       
                        <input type="number" name="<?php echo esc_html_e('quantity','stripe-with-contact-form-7');?>" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_quantity', true ));?>"  min="1">
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
    <h2><?php echo esc_html_e('Stripe Settings','stripe-with-contact-form-7');?></h2>
    <fieldset>
        <table class="cf7wpay_paypal_main">
            <tbody>
                 
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Use Sandbox','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="enabled_stripe_Sandbox" value="on" <?php if(get_post_meta( $formid, 'cf7wpay_enabled_stripe_Sandbox', true ) == "on"){ echo "checked"; } ?>><label><?php echo esc_html_e('Use Sandbox','stripe-with-contact-form-7');?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Pay with Stripe Label','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="pw_stripe_label" value="<?php if(get_post_meta( $formid, 'pw_stripe_label', true ) != '') { echo esc_attr(get_post_meta( $formid,'pw_stripe_label', true )); } else { echo esc_attr("Pay with Stripe"); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Live Publishable Key','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_live_pub_key" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_live_pub_key', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Live Secret Key','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_live_secret_key" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_live_secret_key', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Test Publishable Key','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_test_pub_key" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_test_pub_key', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Test Secret Key','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_test_secret_key" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_test_secret_key', true ));?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Currency','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <?php $stripe_currency = get_post_meta( $formid, 'cf7wpay_stripe_currency', true ); ?>
                        <select name="stripe_currency">
                            <option value="AUD" <?php if($stripe_currency == "AUD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Australian dollar (AUD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="BRL" <?php if($stripe_currency == "BRL"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Brazilian real (BRL)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="GBP" <?php if($stripe_currency == "GBP"){ echo "selected"; }?>>
                                <?php echo esc_html_e('British pound (GBP)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="CAD" <?php if($stripe_currency == "CAD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Canadian dollar (CAD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="CZK" <?php if($stripe_currency == "CZK"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Czech koruna (CZK)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="DKK" <?php if($stripe_currency == "DKK"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Danish krone (DKK)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="EUR" <?php if($stripe_currency == "EUR"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Euro (EUR)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="HKD" <?php if($stripe_currency == "HKD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Hong kong Dollar (HKD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="HUF" <?php if($stripe_currency == "HUF"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Hungarian forint (HUF)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="ILS" <?php if($stripe_currency == "ILS"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Israeli new shekel (ILS)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="JPY" <?php if($stripe_currency == "JPY"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Japanese yen (JPY)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="MYR" <?php if($stripe_currency == "MYR"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Malaysian Ringgit (MYR)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="MXN" <?php if($stripe_currency == "MXN"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Mexican peso (MXN)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="TWD" <?php if($stripe_currency == "TWD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('New Taiwan dollar (TWD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="NZD" <?php if($stripe_currency == "NZD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('New Zealand dollar (NZD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="NOK" <?php if($stripe_currency == "NOK"){ echo "selected"; }?>>
                               <?php echo esc_html_e(' Norwegian krone (NOK)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="PHP" <?php if($stripe_currency == "PHP"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Philippine peso (PHP)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="PLN" <?php if($stripe_currency == "PLN"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Polish złoty (PLN)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="RUB" <?php if($stripe_currency == "RUB"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Russian ruble (RUB)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="SGD" <?php if($stripe_currency == "SGD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Singapore dollar (SGD)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="SEK" <?php if($stripe_currency == "SEK"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Swedish krona (SEK)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="CHF" <?php if($stripe_currency == "CHF"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Swiss franc (CHF)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="THB" <?php if($stripe_currency == "THB"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Thai baht (THB)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="TRY" <?php if($stripe_currency == "TRY"){ echo "selected"; }?>>
                                <?php echo esc_html_e('Turkish Lira (TRY)','stripe-with-contact-form-7');?>
                            </option>
                            <option value="USD" <?php if($stripe_currency == "USD"){ echo "selected"; }?>>
                                <?php echo esc_html_e('U.S dollar (USD)','stripe-with-contact-form-7');?>
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Success Return URL','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_suc_url" value="<?php echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_suc_url', true ));?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo esc_html_e('Default Text:','stripe-with-contact-form-7');?> </b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Card Number','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_card_number_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_card_number_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_card_number_def_txt', true )); } else { echo esc_attr('Card Number'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Card Code (CSV)','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_card_code_csv_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_card_code_csv_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_card_code_csv_def_txt', true )); } else { echo esc_attr('Card Code (CSV)'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Expiration (MM/YY)','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_expiration_mmyy_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_expiration_mmyy_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_expiration_mmyy_def_txt', true )); } else { echo esc_attr('Expiration (MM/YY)'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Billing Zip / Postal Code','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_billing_zip_post_code_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_billing_zip_post_code_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_billing_zip_post_code_def_txt', true )); } else { echo esc_attr('Billing Zip / Postal Code'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Pay','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_pay_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_pay_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_pay_def_txt', true )); } else { echo esc_attr('Pay'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Status','stripe-with-contact-form-7');?></label>

                    </th>
                    <td>
                        <input type="text" name="stripe_status_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_status_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_status_def_txt', true )); } else { echo esc_attr('Status'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Order','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_order_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_order_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_order_def_txt', true )); } else { echo esc_attr('Order'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Payment Successful','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_pay_suc_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_pay_suc_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_pay_suc_def_txt', true )); } else { echo esc_attr('Payment Successful'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Payment Failed','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_pay_fail_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_pay_fail_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_pay_fail_def_txt', true )); } else { echo esc_attr('Payment Failed'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Processing Payment','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_procs_pay_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_procs_pay_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_procs_pay_def_txt', true )); } else { echo esc_attr('Processing Payment'); } ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php echo esc_html_e('Currency Symbol','stripe-with-contact-form-7');?></label>
                    </th>
                    <td>
                        <input type="text" name="stripe_currency_sym_def_txt" value="<?php if(get_post_meta( $formid, 'cf7wpay_stripe_currency_sym_def_txt', true ) != '') { echo esc_attr(get_post_meta( $formid, 'cf7wpay_stripe_currency_sym_def_txt', true )); } else { echo esc_attr('$'); } ?>">
                    </td>
                </tr>
                <h2>Dynamic Value</h2>
        
           
                
            </tbody>
        </table>
            <p><strong><?php echo esc_html_e('Note:','stripe-with-contact-form-7');?></strong><?php echo esc_html_e(' When using Custom Amount and Custom Quantity dynamic values defined below will be ignored, means either use Custom Amount and Custom Quantity for single static product or use multiple products adding details below.','stripe-with-contact-form-7');?></p>
            <div class="after-add-more">
                <div class="field_wrapper">
                    <div class="custom_product">
                        <div class="ocscw_child_div">
                            <?php 
                                $stripe_table_prices = get_post_meta( $formid, 'cf7wpay_stripe_prices', true);
                                $stripe_table_qunty = get_post_meta( $formid, 'cf7wpay_stripe_qunty', true);
                                $table_price_array = unserialize($stripe_table_prices);
                                $table_qunty_array = unserialize($stripe_table_qunty);

                                    // print_r($table_qunty_array);
                                if(!empty($table_price_array[0])) {
                                    $stripe_totalcol = get_post_meta( $formid, 'cf7wpay_stripe_totalcol', true);

                                    if($stripe_totalcol == '') {
                                        $stripe_totalcol = 1;
                                    }

                                    $stripe_totalrow  = get_post_meta( $formid, 'cf7wpay_stripe_totalrow', true);
                                    
                                    if($stripe_totalrow == '') {
                                        $stripe_totalrow = 1;
                                    }

                                    echo '<table class="stripe_ococf7_tbl">';
                                    echo '<input type="hidden" name="stripe_totalrow" value="'.esc_attr($stripe_totalrow).'">';
                                    echo '<input type="hidden" name="stripe_totalcol" value="'.esc_attr($stripe_totalcol).'">';

                                   
                                    $count = 0;?>
                                    
                                    <tr>
                                        <td></td>
                                        <?php 
                                            for($j=0; $j<$stripe_totalcol-1; $j++) { ?>
                                                <td><a class="stripe_addcolumn"><img src= "<?php echo CF7SPAY_PLUGIN_DIR; ?>;/includes/image/plus-circular-button_1.png"></a><a class="deletecolumn"><img src= "<?php echo CF7SPAY_PLUGIN_DIR ?>;/includes/images/delete.png"></a></td>

                                          <?php   } ?>
                                        <td></td>
                                    </tr>
                                    
                                    <?php
                                    for($i=0; $i<$stripe_totalrow; $i++) { ?>
                                        
                                        <tr>
                                            
                                            <?php 
                                            for($j=0; $j<$stripe_totalcol; $j++) { ?>
                                                <td><label>price</label><input type="text" name="stripe_prices[]" value="<?php echo esc_attr($table_price_array[$count]); ?>"></td>
                                                <td><label>Quantity</label><input type="text" name="stripe_qunty[]" value="<?php echo esc_attr($table_qunty_array[$count]); ?>"></td>
                                                <?php 
                                                    $count++;
                                            }

                                          
                                            if($count == $stripe_totalcol) { ?>
                                                <td><a class="stripe_addrow"><img src= "<?php echo  CF7SPAY_PLUGIN_DIR; ?>/includes/image/plus-circular-button_1.png"></a></td>
                                                <?php
                                            } else { ?>
                                                <td><a class="stripe_addrow"><img src= "<?php echo CF7SPAY_PLUGIN_DIR; ?>/includes/image/plus-circular-button_1.png"></a><a class="deleterow"><img src= "<?php echo  CF7SPAY_PLUGIN_DIR; ?>/includes/image/minus.png"></a></td>
                                           <?php  } ?>
                                       </tr>
                                       <?php 
                                    } ?>
                                   
                                   </table>
                                   <?php 
                                } else {
                                    ?>
                                    <table class="stripe_ococf7_tbl">
                                        <input type="hidden" name="stripe_totalrow">
                                        <input type="hidden" name="stripe_totalcol">
                                        <tr>
                                           <td>
                                                <a class="stripe_addcolumn">
                                                    <img src= " <?php //echo CF7WPAY_PLUGIN_DIR . '/includes/images/plus.png' ?>">
                                                </a>
                                            </td> 
                                            <td>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label><?php echo esc_html('Price'); ?></label><input type="text" name="stripe_prices[]"></td>
                                            <td><label><?php echo esc_html('Quantity');?></label><input type="text" name="stripe_qunty[]"></td>
                                            <td><a class="stripe_addrow"><img src= "<?php echo  CF7SPAY_PLUGIN_DIR; ?>/includes/image/plus-circular-button_1.png"></a></td>
                                        </tr>
                                    </table> 
                                    <?php
                                }
                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <p><strong><?php echo esc_html_e('Note:','stripe-with-contact-form-7');?></strong><?php echo esc_html_e(' If you want to use radio buttons or select dropdown in form, you can use','stripe-with-contact-form-7');?> <strong><?php echo esc_html_e('[radio price "item1-$10--10" "item2-$20--20"], in this example item1-$10 will be your label and 10 will be value of radio button elements. simply seperate label and value with','stripe-with-contact-form-7');?> <strong><?php echo esc_html_e('"--"','stripe-with-contact-form-7');?></strong><?php echo esc_html_e(' seperator. If Empty custom amount field and custom Quantity field then this multiple field working.','stripe-with-contact-form-7');?></p>
    </fieldset>
    <?php           
}



function  cf7spay_recursive_sanitize_text_field($array) {
    
    if(!empty($array)) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = cf7spay_recursive_sanitize_text_field($value);
            }else{
                $value = sanitize_text_field( $value );
            }
        }
    }
    return $array;
}


add_action( 'wpcf7_after_save','cf7spay_after_save', 10, 1 );
function cf7spay_after_save( $instance) {

    $formid = $instance->id;

    if(isset($_POST['enabled_use_stripe']) && !empty($_POST['enabled_use_stripe'])) {
        $enabled_use_stripe = sanitize_text_field($_POST['enabled_use_stripe']);
    } else {
        $enabled_use_stripe = 'off';
    }
    update_post_meta( $formid, 'enabled_use_stripe', $enabled_use_stripe );

    $pw_stripe_label = sanitize_text_field($_POST['pw_stripe_label']);
    update_post_meta( $formid, 'pw_stripe_label', $pw_stripe_label );

    $stripe_totalrow = sanitize_text_field( $_REQUEST['stripe_totalrow'] );
    update_post_meta( $formid, 'cf7wpay_stripe_totalrow', $stripe_totalrow );

    $stripe_totalcol = sanitize_text_field( $_REQUEST['stripe_totalcol'] );
    update_post_meta( $formid, 'cf7wpay_stripe_totalcol', $stripe_totalcol );

    $prices_data   = cf7spay_recursive_sanitize_text_field( $_REQUEST['stripe_prices'] );
    update_post_meta(  $formid, 'cf7wpay_stripe_prices', serialize($prices_data) );

    $qunty_data   = cf7spay_recursive_sanitize_text_field( $_REQUEST['stripe_qunty'] );
    update_post_meta(  $formid, 'cf7wpay_stripe_qunty', serialize($qunty_data) );

    /*$enabled_stripe_Sandbox = sanitize_text_field($_POST['enabled_stripe_Sandbox']);
    update_post_meta( $formid, 'cf7wpay_enabled_stripe_Sandbox', $enabled_stripe_Sandbox );*/

    if(isset($_POST['enabled_stripe_Sandbox']) && !empty($_POST['enabled_stripe_Sandbox'])) {
        $enabled_stripe_Sandbox = sanitize_text_field($_POST['enabled_stripe_Sandbox']);
    } else {
        $enabled_stripe_Sandbox = 'off';
    }
    update_post_meta( $formid, 'cf7wpay_enabled_stripe_Sandbox', $enabled_stripe_Sandbox );

    /*$customer_email = sanitize_text_field($_POST['customer_email']);
    update_post_meta( $formid, 'cf7wpay_customer_email', $customer_email );*/

    $stripe_customer_email = sanitize_text_field($_POST['stripe_customer_email']);
    update_post_meta( $formid, 'cf7wpay_stripe_customer_email', $stripe_customer_email );

    /*$item_description = sanitize_text_field($_POST['item_description']);
    update_post_meta( $formid, 'cf7wpay_item_description', $item_description );*/

    $stripe_item_description = sanitize_text_field($_POST['stripe_item_description']);
    update_post_meta( $formid, 'cf7wpay_stripe_item_description', $stripe_item_description );

    /*$item_id_sku = sanitize_text_field($_POST['item_id_sku']);
    update_post_meta( $formid, 'cf7wpay_item_id_sku', $item_id_sku );*/

    $stripe_item_id_sku = sanitize_text_field($_POST['stripe_item_id_sku']);
    update_post_meta( $formid, 'cf7wpay_stripe_item_id_sku', $stripe_item_id_sku );

    /*$tax_rates = sanitize_text_field($_POST['tax_rates']);
    update_post_meta( $formid, 'cf7wpay_tax_rates', $tax_rates );*/

    $amount = sanitize_text_field($_POST['amount']);
    update_post_meta( $formid, 'cf7wpay_amount', $amount );

    /*$discount_rate = sanitize_text_field($_POST['discount_rate']);
    update_post_meta( $formid, 'cf7wpay_discount_rate', $discount_rate );*/

    /*$paypal_amount = sanitize_text_field($_POST['paypal_amount']);
    update_post_meta( $formid, 'cf7wpay_paypal_amount', $paypal_amount );*/
    
    $quantity = sanitize_text_field($_POST['quantity']);
    update_post_meta( $formid, 'cf7wpay_quantity', $quantity );

    /*$currency = sanitize_text_field($_POST['currency']);
    update_post_meta( $formid, 'cf7wpay_currency', $currency );*/

    $stripe_live_pub_key = sanitize_text_field($_POST['stripe_live_pub_key']);
    update_post_meta( $formid, 'cf7wpay_stripe_live_pub_key', $stripe_live_pub_key );

    $stripe_live_secret_key = sanitize_text_field($_POST['stripe_live_secret_key']);
    update_post_meta( $formid, 'cf7wpay_stripe_live_secret_key', $stripe_live_secret_key );

    $stripe_test_pub_key = sanitize_text_field($_POST['stripe_test_pub_key']);
    update_post_meta( $formid, 'cf7wpay_stripe_test_pub_key', $stripe_test_pub_key );

    $stripe_test_secret_key = sanitize_text_field($_POST['stripe_test_secret_key']);
    update_post_meta( $formid, 'cf7wpay_stripe_test_secret_key', $stripe_test_secret_key );

    $stripe_currency = sanitize_text_field($_POST['stripe_currency']);
    update_post_meta( $formid, 'cf7wpay_stripe_currency', $stripe_currency );

    $stripe_suc_url = sanitize_text_field($_POST['stripe_suc_url']);
    update_post_meta( $formid, 'cf7wpay_stripe_suc_url', $stripe_suc_url );

    $stripe_card_number_def_txt = sanitize_text_field($_POST['stripe_card_number_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_card_number_def_txt', $stripe_card_number_def_txt );

    $stripe_card_code_csv_def_txt = sanitize_text_field($_POST['stripe_card_code_csv_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_card_code_csv_def_txt', $stripe_card_code_csv_def_txt );

    $stripe_expiration_mmyy_def_txt = sanitize_text_field($_POST['stripe_expiration_mmyy_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_expiration_mmyy_def_txt', $stripe_expiration_mmyy_def_txt );

    $stripe_billing_zip_post_code_def_txt = sanitize_text_field($_POST['stripe_billing_zip_post_code_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_billing_zip_post_code_def_txt', $stripe_billing_zip_post_code_def_txt );

    $stripe_pay_def_txt = sanitize_text_field($_POST['stripe_pay_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_pay_def_txt', $stripe_pay_def_txt );

    $stripe_status_def_txt = sanitize_text_field($_POST['stripe_status_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_status_def_txt', $stripe_status_def_txt );

    $stripe_order_def_txt = sanitize_text_field($_POST['stripe_order_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_order_def_txt', $stripe_order_def_txt );

    $stripe_pay_suc_def_txt = sanitize_text_field($_POST['stripe_pay_suc_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_pay_suc_def_txt', $stripe_pay_suc_def_txt );

    $stripe_pay_fail_def_txt = sanitize_text_field($_POST['stripe_pay_fail_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_pay_fail_def_txt', $stripe_pay_fail_def_txt );

    $stripe_procs_pay_def_txt = sanitize_text_field($_POST['stripe_procs_pay_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_procs_pay_def_txt', $stripe_procs_pay_def_txt );

    $stripe_currency_sym_def_txt = sanitize_text_field($_POST['stripe_currency_sym_def_txt']);
    update_post_meta( $formid, 'cf7wpay_stripe_currency_sym_def_txt', $stripe_currency_sym_def_txt );
}


add_filter( 'wpcf7_feedback_response', 'cf7spay_ajax_json_echo', 20, 2 );
function cf7spay_ajax_json_echo( $response, $result ) {
    global $wpdb;
    $table_name    = $wpdb->prefix.'cf7spay_forms';
    $time_now      = time();

    $form = WPCF7_Submission::get_instance();

    if ( $form ) {

        $black_list   = array('_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag',
        '_wpcf7_is_ajax_call','cfdb7_name', '_wpcf7_container_post','_wpcf7cf_hidden_group_fields',
        '_wpcf7cf_hidden_groups', '_wpcf7cf_visible_groups', '_wpcf7cf_options','g-recaptcha-response');

        $data           = $form->get_posted_data();
        $files          = $form->uploaded_files();
        // print_r($data);
        $uploaded_files = array();
        foreach ($files as $file_key => $file) {
            array_push($uploaded_files, $file_key);
        }

        $form_data   = array();
        $form_data['cf7wpay_status'] = 'unread';

        foreach ($data as $key => $d) {
           
            $matches = array();

            if ( !in_array($key, $black_list ) && !in_array($key, $uploaded_files ) && empty( $matches[0] ) ) {

                $tmpD = $d;

                if ( ! is_array($d) ) {

                    $bl   = array('\"',"\'",'/','\\','"',"'");
                    $wl   = array('&quot;','&#039;','&#047;', '&#092;','&quot;','&#039;');

                    $tmpD = str_replace($bl, $wl, $tmpD );
                }

                $form_data[$key] = $tmpD;
            }
            if ( in_array($key, $uploaded_files ) ) {
                $form_data[$key.'cfdb7_file'] = $_SESSION['image_name'];
            }
        }

        $paymentgateway         = 'payment';
        if($paymentgateway != '') {
            $payment_gateway     = $data[$paymentgateway];
        } else {
            $payment_gateway     = '';
        }


        $form_post_id = $result['contact_form_id'];
        $form_value   = serialize( $form_data );
        $form_date    = current_time('Y-m-d H:i:s');
        $insert_id= "";
        if($payment_gateway == 'stripe'){

             $wpdb->insert( $table_name, array(
                'form_post_id' => $form_post_id,
                'form_value'   => $form_value,
                'form_date'    => $form_date
             ) );
             $insert_id = $wpdb->insert_id;
        }
    }

    $formid                 = $result['contact_form_id'];
    $customer_email         = get_post_meta( $formid, 'cf7wpay_stripe_customer_email', true );
    $stripe_customer_email  = get_post_meta( $formid, 'cf7wpay_stripe_customer_email', true );
    $customer               = get_post_meta( $formid, 'cf7wpay_stripe_customer_email', true );
    $item_id_sku            = get_post_meta( $formid, 'cf7wpay_stripe_item_id_sku', true );
    // $tax_rates              = get_post_meta( $formid, 'cf7wpay_tax_rates', true );
    
    //stripe settings
    $enabled_use_stripe         = get_post_meta( $formid, 'enabled_use_stripe', true );
    $enabled_stripe_Sandbox     = get_post_meta( $formid, 'cf7wpay_enabled_stripe_Sandbox', true );
    $stripe_live_pub_key        = get_post_meta( $formid, 'cf7wpay_stripe_live_pub_key', true );
    $stripe_live_secret_key     = get_post_meta( $formid, 'cf7wpay_stripe_live_secret_key', true );
    $stripe_test_pub_key        = get_post_meta( $formid, 'cf7wpay_stripe_test_pub_key', true );
    $stripe_test_secret_key     = get_post_meta( $formid, 'cf7wpay_stripe_test_secret_key', true );
    $stripe_currency            = get_post_meta( $formid, 'cf7wpay_stripe_currency', true );
    $stripe_suc_url             = get_post_meta( $formid, 'cf7wpay_stripe_suc_url', true );
    $stripe_insert_id           = $insert_id;

    $stripe_card_number_def_txt = get_post_meta( $formid, 'cf7wpay_stripe_card_number_def_txt', true );

    if($stripe_card_number_def_txt == '') {
        $stripe_card_number_def_txt = 'Card Number';
    }

    $stripe_card_code_csv_def_txt = get_post_meta( $formid, 'cf7wpay_stripe_card_code_csv_def_txt', true );

    if($stripe_card_code_csv_def_txt == '') {
        $stripe_card_code_csv_def_txt = 'Card Code (CSV)';
    }

    $stripe_expiration_mmyy_def_txt    = get_post_meta( $formid, 'cf7wpay_stripe_expiration_mmyy_def_txt', true );

    if($stripe_expiration_mmyy_def_txt == '') {
        $stripe_expiration_mmyy_def_txt = 'Expiration (MM/YY)';
    }

    $stripe_billing_zip_post_code_def_txt    = get_post_meta( $formid, 'cf7wpay_stripe_billing_zip_post_code_def_txt', true );

    if($stripe_billing_zip_post_code_def_txt == '') {
        $stripe_billing_zip_post_code_def_txt = 'Billing Zip / Postal Code';
    }

    $stripe_pay_def_txt    = get_post_meta( $formid, 'cf7wpay_stripe_pay_def_txt', true );
        
    if($stripe_pay_def_txt == '') {
        $stripe_pay_def_txt = 'Pay';
    }

    $stripe_currency_sym_def_txt    = get_post_meta( $formid, 'cf7wpay_stripe_currency_sym_def_txt', true );

    if($stripe_currency_sym_def_txt == '') {
        $stripe_currency_sym_def_txt = '$';
    }

    $stripe_status_def_txt      = get_post_meta( $formid, 'cf7wpay_stripe_status_def_txt', true );
    $stripe_order_def_txt       = get_post_meta( $formid, 'cf7wpay_stripe_order_def_txt', true );
    $stripe_pay_suc_def_txt     = get_post_meta( $formid, 'cf7wpay_stripe_pay_suc_def_txt', true );
    $stripe_pay_fail_def_txt    = get_post_meta( $formid, 'cf7wpay_stripe_pay_fail_def_txt', true );
    $stripe_procs_pay_def_txt   = get_post_meta( $formid, 'cf7wpay_stripe_procs_pay_def_txt', true );
    $stripe_table_prices        = get_post_meta( $formid, 'cf7wpay_stripe_prices', true); 
    // $discount_rate              = get_post_meta( $formid, 'cf7wpay_discount_rate', true );
    $table_price_array          = unserialize($stripe_table_prices);
    $stripe_table_qunty         = get_post_meta( $formid, 'cf7wpay_stripe_qunty', true); 
    $table_qunty_array          = unserialize($stripe_table_qunty);
    $stripe_pub_key = '';
    $stripe_secret_key = '';
    $price = 0;

    if($enabled_stripe_Sandbox == "on") {
        $stripe_pub_key = $stripe_test_pub_key;
        $stripe_secret_key = $stripe_test_secret_key;
    } else {
        $stripe_pub_key = $stripe_live_pub_key;
        $stripe_secret_key = $stripe_live_secret_key;
    }


    if($stripe_customer_email != '') {
        $custmr_email = $data[$stripe_customer_email];
    } else {
        $custmr_email = '';
    }


 
    
    $descs = array();
    $x =1 ;
    $amountaa = 0;
    $price_amount=0;
    $quantity = get_post_meta( $formid, 'cf7wpay_quantity', true );
    $amount = get_post_meta( $formid, 'cf7wpay_amount', true );
    
    if(!empty($amount) && !empty($quantity)) {

         $price_amount = $amount * $quantity;
      
    } else {

        if(!empty($table_price_array)) {

            foreach ($table_price_array as $key => $value) {

                if(!empty($_REQUEST[$value]) && $_REQUEST[$table_qunty_array[$key]]) {

                    $pieces = explode("--", sanitize_text_field($_REQUEST[$value]));

                    $Quntiti = sanitize_text_field($_REQUEST[$table_qunty_array[$key]]);
                   
                    if(!empty($pieces[1])) {
                        $amountaa = $pieces[1];
                    } else {
                        $amountaa = $pieces[0];
                    }
                    $price_amount += $amountaa * $Quntiti;
                }
            }
        }
    }

    $final_price = $price_amount;
    $stripe_final_amount = $final_price;
    $stripe_final_amount = number_format((float)$stripe_final_amount, 2, '.', '');
    $stripe_amount_text = $stripe_pay_def_txt.' '.$stripe_currency_sym_def_txt.$stripe_final_amount;
    $response['enabled_use_stripe']  = $enabled_use_stripe;
    $response[ 'payment_gateway' ]     = $payment_gateway;

    //stripe data and stripe form data
    $result = '';

    if($enabled_stripe_Sandbox == "on") {
        $result .= "<a href='https://stripe.com/docs/testing#cards' target='_blank' class='cf7wpay_sandbox'>sandbox mode</a>";
    }

    $result .= "<div class='cf7wpay_stripe'>";
        $result .= "<form method='post' id='cf7wpay-payment-form'>";
            $result .= "<div class='cf7wpay_body'>";
                $result .= "<div class='cf7wpay_row'>";
                    $result .= "<div class='cf7wpay_details_input'>";
                        $result .= "<label for='cf7wpay_stripe_credit_card_number'>"; $result .= $stripe_card_number_def_txt; $result .= "</label>";
                        $result .= "<div id='cf7wpay_stripe_credit_card_number'></div>";
                    $result .= "</div>";
                    $result .= "<div class='cf7wpay_details_input'>";
                        $result .= "<label for='cf7wpay_stripe_credit_card_csv'>"; $result .= $stripe_card_code_csv_def_txt; $result .= "</label>";
                        $result .= "<div id='cf7wpay_stripe_credit_card_csv'></div>";
                    $result .= "</div>";
                $result .= "</div>";
                $result .= "<div class='cf7wpay_row'>";
                    $result .= "<div class='cf7wpay_details_input'>";
                        $result .= "<label for='cf7wpay_stripe_credit_card_expiration'>"; $result .= $stripe_expiration_mmyy_def_txt; $result .= "</label>";
                        $result .= "<div id='cf7wpay_stripe_credit_card_expiration'></div>";
                    $result .= "</div>";
                    $result .= "<div class='cf7wpay_details_input'>";
                        $result .= "<label for='cf7wpay_stripe_credit_card_zip'>"; $result .= $stripe_billing_zip_post_code_def_txt; $result .= "</label>";
                        $result .= "<div id='cf7wpay_stripe_credit_card_zip'></div>";
                    $result .= "</div>";
                $result .= "</div>";
                $result .= "<div id='card-errors' role='alert'></div>";
            $result .= "<br/>&nbsp;<input id='stripe-submit' value='".$stripe_amount_text."' type='submit'>";
            $result .= "<div>";
        $result .= "</form>";
    $result .= "<div>";
    $response[ 'stripe_form' ] = $result;
    $response[ 'stripe_pubkey' ] = $stripe_pub_key;
    $response[ 'stripe_seckey' ] = $stripe_secret_key;
    $response[ 'stripe_email' ] =  $custmr_email;
    $response[ 'stripe_suc_url' ] =  $stripe_suc_url;
    $response[ 'stripe_procs_pay_txt' ] =  $stripe_procs_pay_def_txt;
    $response[ 'stripe_amount_text' ] =  $stripe_amount_text;
    $response[ 'stripe_pay_fail_text' ] =  $stripe_pay_fail_def_txt;
    $response[ 'stripe_pay_amount' ] =  $stripe_final_amount;
    $response[ 'stripe_insert_id' ] = $stripe_insert_id;
    //$response[ 'stripe_item_desc' ] = $descs;

    return $response;
}


add_action( 'wp_footer',  'cf7spay_footer' );
function cf7spay_footer() {
    ?>
    <script>
        document.addEventListener( 'wpcf7mailsent', function( event ) {
      //console.log(event);
            var enabled_use_paypal  = event.detail.apiResponse.enabled_use_paypal;
            var enabled_use_stripe  = event.detail.apiResponse.enabled_use_stripe;
            var payment_gateway     = event.detail.apiResponse.payment_gateway;
            var stripe_email        = event.detail.apiResponse.stripe_email;
            var stripe_suc_url      = event.detail.apiResponse.stripe_suc_url;
            var stripe_procs_pay_txt = event.detail.apiResponse.stripe_procs_pay_txt;
            var stripe_amount_text = event.detail.apiResponse.stripe_amount_text;
            var stripe_pay_fail_text = event.detail.apiResponse.stripe_pay_fail_text;
            var stripe_pay_amount = event.detail.apiResponse.stripe_pay_amount;
            var stripe_insert_id = event.detail.apiResponse.stripe_insert_id;

           if((event.detail.unitTag) ){
             var cf7wpay_id_long     = event.detail.unitTag;
           }else{
             var cf7wpay_id_long     = event.detail.id;
           }
             //console.log(cf7wpay_id_long);
            var cf7wpay_id          = event.detail.contactFormId;

            var cf7wpay_formid      = cf7wpay_id;

             if(payment_gateway == 'stripe') {
                if(enabled_use_stripe == "on") {
                    var stripe_form = event.detail.apiResponse.stripe_form;
                    setTimeout(function() {
                        jQuery('#'+cf7wpay_id_long).html(stripe_form);
                        if (jQuery('.cf7wpay_stripe').length ) {

                            var stripe = Stripe(event.detail.apiResponse.stripe_pubkey);
                            var elements = stripe.elements();
                            var elementClasses = {
                                base:       'cf7wpay_details_input',
                                focus:      'focus',
                                empty:      'empty',
                                invalid:    'invalid',
                            };

                            var cardNumber = elements.create('cardNumber', {
                                classes:    elementClasses,
                                placeholder:  "\u2022\u2022\u2022\u2022 \u2022\u2022\u2022\u2022 \u2022\u2022\u2022\u2022 \u2022\u2022\u2022\u2022",
                            });
                            cardNumber.mount('#cf7wpay_stripe_credit_card_number');

                            var cardExpiry = elements.create('cardExpiry', {
                                classes: elementClasses,
                                placeholder:  "\u2022\u2022 / \u2022\u2022",
                            });
                            cardExpiry.mount('#cf7wpay_stripe_credit_card_expiration');

                            var cardCvc = elements.create('cardCvc', {
                                classes: elementClasses,
                                placeholder:  "\u2022\u2022\u2022",
                            });
                            cardCvc.mount('#cf7wpay_stripe_credit_card_csv');

                            var cardPostalCode = elements.create('postalCode', {
                                classes: elementClasses,
                                placeholder:  "\u2022\u2022\u2022\u2022\u2022",
                            });
                            cardPostalCode.mount('#cf7wpay_stripe_credit_card_zip');

                            // Handle real-time validation errors from the card Element.
                            cardNumber.addEventListener('change', function(event) {

                                var displayError = document.getElementById('card-errors');

                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }

                            });

                            cardExpiry.addEventListener('change', function(event) {

                                var displayError = document.getElementById('card-errors');

                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }

                            });

                            cardCvc.addEventListener('change', function(event) {

                                var displayError = document.getElementById('card-errors');

                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }

                            });

                            cardPostalCode.addEventListener('change', function(event) {

                                var displayError = document.getElementById('card-errors');

                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }

                            });

                            
                            // action when contact form 7 form is submitted
                            var cf7wpay_form = document.getElementById('cf7wpay-payment-form');

                            cf7wpay_form.addEventListener('submit', function(event) {
                        
                                var cf7wpay_id_long       = jQuery('.cf7wpay_stripe').closest('.wpcf7').attr("id");
                                var cf7wpay_formid        = cf7wpay_id_long.split('f').pop().split('-').shift();
                                var cf7wpay_email         = stripe_email;
                                var cf7wpay_stripe_return = stripe_suc_url;
                                
                                jQuery('#stripe-submit').attr("disabled", "disabled");
                                jQuery('#stripe-submit').val(stripe_procs_pay_txt);

                                event.preventDefault();

                                stripe.createToken(cardNumber).then(function(result) { 
                                    if (result.error) {
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;

                                        jQuery('#stripe-submit').removeAttr("disabled");
                                        jQuery('#stripe-submit').val(stripe_amount_text);
                                    } else {
                                        var cf7wpay_data = {
                                            'action':           'cf7spay_stripe_charge',
                                            'token':            result.token,
                                            'cf7wpay-security': '<?php echo wp_create_nonce( "cf7wpay-ajax-nonce" ); ?>',
                                            'id':               cf7wpay_formid,
                                            'email':            cf7wpay_email,
                                            'pay_amount':       stripe_pay_amount,
                                            'stripe_insert_id': stripe_insert_id,
                                        };
                                        
                                        jQuery.ajax({
                                            type: "POST",
                                            data: cf7wpay_data,
                                            dataType: "json",
                                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                            xhrFields: {
                                                withCredentials: true
                                            },
                                            success: function (result) {
                                                if (result.response == 'completed') {
                                                    if (cf7wpay_stripe_return) {
                                                        window.location.href = cf7wpay_stripe_return;
                                                    } else {
                                                        jQuery('#'+cf7wpay_id_long).html(result.html_success);
                                                    }
                                                } else {
                                                    jQuery('#card-errors').html(stripe_pay_fail_text);
                                                    jQuery('#stripe-submit').removeAttr("disabled");
                                                    jQuery('#stripe-submit').val(stripe_amount_text);
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                        };
                    }, 1500);
                }
             }

        }, false );
    </script>
    <?php
}

// stripe charge ajax call
add_action( 'wp_ajax_cf7spay_stripe_charge',  'cf7spay_stripe_charge');
add_action( 'wp_ajax_nopriv_cf7spay_stripe_charge','cf7spay_stripe_charge');
function cf7spay_stripe_charge() {

    if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'POST' && isset($_POST['stripeToken']) ) {
        return;
    }

    if ( ! check_ajax_referer( 'cf7wpay-ajax-nonce', 'cf7wpay-security', false ) ) {    
        wp_send_json_error( 'Invalid security token sent.' );
        wp_die();
    }

    $token = sanitize_text_field($_POST['token']['id']);

    //form id
    $id = sanitize_text_field($_POST['id']);
    // $stripe_item_desc = sanitize_text_field($_POST['stripe_item_desc']);

    $stripe_key = '';
    $stripe_mode = get_post_meta( $id, 'cf7wpay_enabled_stripe_Sandbox', true );

    if($stripe_mode == "on") {
        $stripe_key = get_post_meta( $id, 'cf7wpay_stripe_test_secret_key', true );
    } else {
        $stripe_key = get_post_meta( $id, 'cf7wpay_stripe_live_secret_key', true );
    }

    $currency = get_post_meta( $id, 'cf7wpay_stripe_currency', true );

    if (empty($currency)) { $currency = "USD"; }
    
    $sku = get_post_meta( $id, 'cf7wpay_stripe_item_id_sku', true );

    $amount = sanitize_text_field($_POST['pay_amount']);

    if ($currency != 'JPY') {
        // convert amount to cents
        $amount = $amount * 100;
    } else {
        $amount = (int)$amount;
    }

    $email = sanitize_text_field($_POST['email']);
    
    if (empty($email)) {
        $email = '';
    }
     $desc = get_post_meta( $id, 'cf7wpay_stripe_item_description', true ); 
    if(empty($desc)) {
         $desc = 'Payment Using CF7';
    }

   

    // default status
    $status = '';
    // class

    \Stripe\Stripe::setApiKey($stripe_key);
    //$stripe_response = "";
    // Create a charge: this will charge the user's card
     try {

        
        $customer = \Stripe\Customer::create(array(
            "source"                => $token,
            "email"                 => $email
            // "address" => ["city" => 'Sydney', "country" => 'Australia', "line1" => "line1", "line2" => "", "postal_code" => "2000", "state" => "New South Wales"], 
            // "description"   => 'sadasdsa',
            // "name"  => 'sadsd' 
        ));
        
         
        $charge = \Stripe\Charge::create(array(
            "amount"                => $amount, // Amount in cents
            "currency"              => $currency,
            "description"           => $desc,
            "metadata"              => array("ID/SKU" => $sku ,"customer_email"=>$email  ),
            "customer"              => $customer->id,
        ));



        $txn_id = sanitize_text_field($charge->id);
        
        $status = 'completed';
      
        $stripe_response = $charge->jsonSerialize();

    } 
    catch(\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];

    } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];


    } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];


    } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];


    } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];


    } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];


    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $reason = $err['message'];

    }


    // transaction failed
    if ($status != 'completed') {
        $status = 'failed';
        $txn_id = '';


    }

    $stripe_status_def_txt = get_post_meta( $id, 'cf7wpay_stripe_status_def_txt', true );
    if($stripe_status_def_txt != '') {
        $stripe_status_txt = $stripe_status_def_txt;
    } else {
        $stripe_status_txt = 'Status';
    }

    $stripe_order_def_txt = get_post_meta( $id, 'cf7wpay_stripe_order_def_txt', true );
    if($stripe_order_def_txt != '') {
        $stripe_order_txt = $stripe_order_def_txt;
    } else {
        $stripe_order_txt = 'Order';
    }

    $stripe_pay_suc_def_txt     = get_post_meta( $id, 'cf7wpay_stripe_pay_suc_def_txt', true );
    if($stripe_pay_suc_def_txt != '') {
            $stripe_pay_succ_txt = $stripe_pay_suc_def_txt;
    } else {
            $stripe_pay_succ_txt = 'Payment Successful';
    }

    $html_success = "
        <table>
        <tr><td>".$stripe_status_txt.": </td><td>".$stripe_pay_succ_txt."</td></tr>
        <tr><td>".$stripe_order_txt." #: </td><td>".$txn_id."</td></tr>";

    $stripe_insert_id = sanitize_text_field($_POST['stripe_insert_id']);
    $stripe_amount = sanitize_text_field($_POST['pay_amount']);

    update_post_meta($stripe_insert_id, 'cf7wpay_item_name', $desc);
    update_post_meta($stripe_insert_id, 'cf7wpay_item_number', $sku);
    update_post_meta($stripe_insert_id, 'cf7wpay_payment_status', $status);
    update_post_meta($stripe_insert_id, 'cf7wpay_payment_amount', $stripe_amount);
    update_post_meta($stripe_insert_id, 'cf7wpay_payment_currency', $currency);
    update_post_meta($stripe_insert_id, 'cf7wpay_txn_id', $txn_id);

    $response = array(
        'response'          =>    $status,
        'html_success'      =>    $html_success,
        'json_response'     =>    $stripe_response
    );

    echo json_encode($response);
        wp_die();
}