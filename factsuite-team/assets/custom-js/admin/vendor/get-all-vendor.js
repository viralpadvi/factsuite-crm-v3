get_all_vendor_list();
function get_all_vendor_list() {
	 sessionStorage.clear(); 
	$.ajax({
	    type  : 'ajax',
	    url   : base_url+'admin_Vendor/get_all_vendor_list',
	    dataType : 'json',
	    success : function(data) {
	      	let html='';
	      	if (data.length > 0) {
	        	var j = 1;
	        	for (var i = 0; i < data.length; i++) {
	        		var check = '';
                	if (data[i].vendor_status == '1') {
                		check = 'checked';
                	} else {
                		check = '';
                	}

		          	html += '<tr id="tr-'+data[i].vendor_id+'">'+
			            	'<td>'+j+'.</td>'+
			            	'<td>'+data[i].vendor_name+'</td>'+
			            	'<td>'+data[i].vendor_spoc_email_id+'</td>'+
			            	'<td>'+data[i].vendor_spoc_mobile_number+'</td>'+
			            	'<td>'+data[i].first_name+' '+data[i].last_name+'</td>'+
			            	'<td>'+
			            		'<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].vendor_id +'">'+
					            	'<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].vendor_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_vendor_status_'+data[i].vendor_id +'">'+
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

function change_vendor_status(vendor_id,vendor_status) {
	var changed_vendor_status = 0;
	if (vendor_status == 1) {
		changed_vendor_status = 0;
	} else if (vendor_status == 0) {
		changed_vendor_status = 1;
	} else {
		toastr.error('OOPS! Something went wrong. Please try again.')
		if (active_type == 1) {
  			get_active_vendor_list();
  		} else if (active_type == 0) {
  			get_inactive_vendor_list();
  		} else {
  			get_all_vendor_list();
  		}
		return false;
	}

	$.ajax({
    	type  : 'POST',
	    url   : base_url+'admin_Vendor/change_vendor_status',
	    data : {
	    	vendor_id : vendor_id,
	    	vendor_status : changed_vendor_status
	    },
	    dataType : 'json',
	    success: function(data) {
	    	if (data.status == '1') {
            	$('#change_vendor_status_'+vendor_id).attr("onclick","change_vendor_status("+vendor_id+","+changed_vendor_status+")");
        		toastr.success('Vendor status has been updated successfully.');
            } else {
            	$('#change_vendor_status_'+vendor_id).attr("onclick","change_vendor_status("+vendor_id+","+vendor_status+")");
        		if(status == '0') {
          			$('#change_vendor_status_'+vendor_id). prop("checked", false);
        		} else {
          			$('#change_vendor_status_'+vendor_id). prop("checked", true);
        		}
        		toastr.error('Something went wrong updating the vendor status. Please try again.');
            }
        },
        error: function(data) {
    		$('#change_vendor_status_'+vendor_id).attr("onclick","change_vendor_status("+vendor_id+","+vendor_status+")");
    		if(status == '0') {
      			$('#change_vendor_status_'+vendor_id). prop("checked", false);
    		} else {
      			$('#change_vendor_status_'+vendor_id). prop("checked", true);
    		}
    		toastr.error('Something went wrong updating the vendor status. Please try again.');
        }
  	});
}