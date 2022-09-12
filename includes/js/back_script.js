jQuery( document ).ready(function() {
	
	    jQuery('body').on('click','.stripe_addcolumn',function(){
        var td = jQuery(this).closest('td');
        var indexa = td.index();
        jQuery('.stripe_ococf7_tbl tr:first td:nth-child('+(indexa+1)+')').after('<td><a class="stripe_addcolumn"><img src= " '+ CF7SPAY_name.CF7SPAY_array_img + '/includes/images/plus-circular-button_1.png"></a><a class="deletecolumn"><img src= " '+ CF7SPAY_name.CF7SPAY_array_img + '/includes/image/minus.png"></a></td>');
        


        jQuery(".stripe_ococf7_tbl tr").not(':first').each(function(index){
            jQuery(this).find('td:nth-child('+(indexa+1)+')').after("<td><input type='text' name='dis[]'></td>");     
        });
        var total_row = cfway_count_row();
        var total_column = cfway_count_col();
        jQuery('input[name="stripe_totalrow"]').val(total_row);
        jQuery('input[name="stripe_totalcol"]').val(total_column);
    });


    jQuery('body').on('click','.stripe_addrow',function(){
    	var total_column = cfway_count_col();
        let row = jQuery('<tr></tr>');
        var column = "";
        for (col = 1; col <= total_column; col++) {
            column += '<td><label>price</label><input type="text" name="stripe_prices[]"></td>';
            column += '<td><label>Quantity</label><input type="text" name="stripe_qunty[]"></td>';
        }
        column += '<td><a class="stripe_addrow"><img src= " '+ CF7SPAY_name.CF7SPAY_array_img + '/includes/image/plus-circular-button_1.png"></a><a class="deleterow"><img src= " '+ CF7SPAY_name.CF7SPAY_array_img + '/includes/image/minus.png"></a></td>';
        row.append(column);
        jQuery(this).closest('tr').after(row);
        var total_row = cfway_count_row();
        var total_column = cfway_count_col();
        jQuery('input[name="stripe_totalrow"]').val(total_row);
        jQuery('input[name="stripe_totalcol"]').val(total_column);
    });


    function cfway_count_col(){
    	var colCount = 0;
	    jQuery('.stripe_ococf7_tbl tr:nth-child(1) td').each(function () {
	       	colCount++;
	    });
	    return colCount - 1;
    }


    function cfway_count_row(){
    	var rowCount = jQuery('.stripe_ococf7_tbl tr').length;
    	return rowCount - 1;
    }


    jQuery("body").on('click', '.deletecolumn', function(){
        var td = jQuery(this).closest('td');
        var indexa = td.index();
        jQuery(this).closest('table').find('tr').each(function() {
            this.removeChild(this.cells[ indexa ]);
        });
        var total_row = cfway_count_row();
        var total_column = cfway_count_col();
        jQuery('input[name="stripe_totalrow"]').val(total_row);
        jQuery('input[name="stripe_totalcol"]').val(total_column);
        return false;
    });


    jQuery("body").on('click', '.deleterow', function(){
        jQuery(this).parent().parent().remove();
        var total_row = cfway_count_row();
        var total_column = cfway_count_col();
        jQuery('input[name="stripe_totalrow"]').val(total_row);
        jQuery('input[name="stripe_totalcol"]').val(total_column);
        return false;
    });




});