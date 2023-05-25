get_active_vendor_list();
function get_active_vendor_list() {
	 sessionStorage.clear(); 
	$.ajax({
	    type  : 'ajax',
	    url   : base_url+'admin_Vendor/get_active_vendor_list',
	    dataType : 'json',
	    success : function(data) {
	      	let html='';
	      	if (data.length > 0) {
	        	var j = 1;
	        	for (var i = 0; i < data.length; i++) {
		          	html += '<tr id="tr-'+data[i].vendor_id+'">'+
			            	'<td>'+j+'.</td>'+
			            	'<td>'+data[i].vendor_name+'</td>'+
			            	'<td>'+data[i].vendor_spoc_email_id+'</td>'+
			            	'<td>'+data[i].vendor_spoc_mobile_number+'</td>'+
			            	'<td>'+data[i].first_name+' '+data[i].last_name+'</td>'+
			            	'<td>'+
			            		'<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].vendor_id +'">'+
					            	'<input type="checkbox" checked onclick="change_vendor_status('+data[i].vendor_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_vendor_status_'+data[i].vendor_id +'">'+
					                '<label class="custom-control-label" for="change_vendor_status_'+data[i].vendor_id +'"></label>'+
					            '</div>'+
			                	'<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].vendor_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>'+
			            	'</td>'+ 
		            	'</tr>';
		            j++;
	        	}
	      	} else {
	        	html += '<tr>'+
	          			'<td colspan="6" class="text-center">No vendor found.</td>'+
	        		'</tr>';	
	    	}
	    	$('#get-active-vendor-list').html(html);   
	  	}
  	});
}

function change_vendor_status(vendor_id) {
	$.ajax({
    	type  : 'POST',
	    url   : base_url+'admin_Vendor/change_vendor_status',
	    data : {
	    	vendor_id : vendor_id,
	    	vendor_status : 0
	    },
	    dataType : 'json',
	    success: function(data) {
            if (data.status == '1') {
            	get_active_vendor_list();
        		toastr.success('Vendor status has been updated successfully.');
            } else {
          		$('#change_product_main_category_status_'+vendor_id). prop("checked", true);
        		toastr.error('Something went wrong updating the vendor status. Please try again.');
            }
        },
        error: function(data) {
    		$('#change_product_main_category_status_'+vendor_id). prop("checked", true);
    		toastr.error('Something went wrong updating the vendor status. Please try again.');
    		get_active_vendor_list();
        }
  	});
}