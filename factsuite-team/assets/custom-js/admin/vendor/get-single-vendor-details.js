 sessionStorage.clear(); 
function edit_vendor_details_modal(vendor_id) {
	$.ajax({
    	type  : 'POST',
	    url   : base_url+'admin_Vendor/get_single_vendor_details',
	    data : {
	    	vendor_id : vendor_id,
	    },
	    dataType : 'json',
	    success: function(data) {
            if (data.status == '1') {
            	$('#vendor-name').val(data.data.vendor_details.vendor_name);
            	$('#vendor-address-line-1').val(data.data.vendor_details.vendor_address_line_1);
            	$('#vendor-address-line-2').val(data.data.vendor_details.vendor_address_line_2);
            	$('#vendor-city').val(data.data.vendor_details.vendor_city);
            	$('#vendor-zip-code').val(data.data.vendor_details.vendor_zip_code);

            	var state_list = JSON.parse(data.data.state_list);
            	
            	var state_list_html = '';
            	for (var i = 0; i < state_list.length; i++) {
            		var state_selected = '';
            		if (data.data.vendor_details.vendor_state == state_list[i].name) {
            			state_selected = 'selected';
            		}
            		state_list_html += '<option value="'+state_list[i].name+'" '+state_selected+'>'+state_list[i].name+'</option>';
            	}
            	$('#vendor-state').html(state_list_html);

            	$('#vendor-website').val(data.data.vendor_details.vendor_website_url);
            	$('#vendor-monthly-quota').val(data.data.vendor_details.vendor_monthly_quota);
            	$('#vendor-aggrement-start-date').val(data.data.vendor_details.vendor_aggrement_start_date);
            	$('#vendor-aggrement-end-date').val(data.data.vendor_details.vendor_aggrement_end_date);
            	if (data.data.vendor_details.vendor_docs != '' && data.data.vendor_details.vendor_docs != null) {
	            	var vendor_docs_array = data.data.vendor_details.vendor_docs.split(',');
	            	var vendor_docs_html = '';
					for (var i = 0; i < vendor_docs_array.length; i++) {
			 			vendor_docs_html += '<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_'+i+'">'+
		                '<div class="image-selected-div">'+
		                    '<ul>'+
		                      '<li class="image-selected-name pb-0">'+vendor_docs_array[i]+'</li>'+
			          	      '<li class="image-name-delete pb-0">'+
			                    '<a id="vendor_docs_modal_file'+i+'" onclick="view_vendor_docs_modal('+i+')" data-vendor_docs="'+vendor_docs_array[i]+'" class="image-name-delete-a"><i class="fa fa-eye text-primary"></i></a>'+
			                    '<a id="delete_vendor_docs_modal_file'+i+'" onclick="delete_vendor_docs_modal('+vendor_id+','+i+')" data-vendor_docs="'+vendor_docs_array[i]+'" class="image-name-delete-a ml-2"><i class="fa fa-times text-danger"></i></a>'+
			                '</li>'+
		                    '</ul>'+
		                  '</div>'+
		                '</div>';
					}
				}
				$('#selected-vendor-docs-li').html(vendor_docs_html);
				// $('#vendor-tat').val(data.data.vendor_details.vendor_tat);

				var vendor_manager_list_html = '';
				var manager_list = data.data.manager_list;
            	for (var i = 0; i < manager_list.length; i++) {
            		var manager_selected = '';
            		if (data.data.vendor_details.vendor_manager_id == manager_list[i].team_id) {
            			manager_selected = 'selected';
            		}
            		vendor_manager_list_html += '<option value="'+manager_list[i].team_id+'" '+manager_selected+'>'+manager_list[i].first_name+' '+manager_list[i].last_name+'</option>';
            	}

            	$('#vendor-manager-name').html(vendor_manager_list_html);
            	$('#vendor-manager-email-id').val(data.data.single_manager_details.email_id);
            	$('#vendor-manager-mobile-number').val(data.data.single_manager_details.mobile_number);

            	$('#vendor-spoc-name').val(data.data.vendor_details.vendor_spoc_name);
            	$('#vendor-spoc-email-id').val(data.data.vendor_details.vendor_spoc_email_id);
            	$('#vendor-spoc-mobile-number').val(data.data.vendor_details.vendor_spoc_mobile_number);

            	var vendor_skill_list_html = '';
            	$('.vendor-skills').removeAttr('checked');
            	$('.tat').val('');
            	$('.tat').attr('disabled',true);
				var skill_list_array = data.data.skill_list;
				if (data.data.vendor_details.vendor_skills != '' && data.data.vendor_details.vendor_skills != null) {
					var selected_skill_list_array = data.data.vendor_details.vendor_skills.split(',');
					var selected_skill_tat_list_array = [];
					if (data.data.vendor_details.vendor_skill_tat != '' && data.data.vendor_details.vendor_skill_tat != null) {
						selected_skill_tat_list_array = data.data.vendor_details.vendor_skill_tat.split(',');
					}

					var k = 0; 
	            	for (var i = 0; i < skill_list_array.length; i++) {
	            		var skill_checked = '';
	            		var skill_tat_value = '';
	            		var check_skill_tat_count = 0;
	            		var check_skill_tat_value = 'disabled';

	            		if (jQuery.inArray(skill_list_array[i].component_id, selected_skill_list_array)!='-1') {
	            			skill_checked = 'checked'; 
	            			check_skill_tat_count++;
	            		}else{
	            			skill_checked = ''; 
	            		}

	            		if(check_skill_tat_count > 0) {
	            			if (typeof selected_skill_tat_list_array[k] !='undefined') { 
	            			check_skill_tat_value = 'value="'+selected_skill_tat_list_array[k]+'"';
	            			}else{
	            				check_skill_tat_value = 'value=""';
	            			}
	            			k++;
	            		}else{
	            			check_skill_tat_value = 'disabled';
	            		}

	            		vendor_skill_list_html += '<li class="vendor-skill-li">';
			            vendor_skill_list_html += '<div class="custom-control custom-checkbox custom-control-inline">';
			            vendor_skill_list_html += '<input type="checkbox" onclick="select_skill_tat('+skill_list_array[i].component_id+')" '+skill_checked+' class="custom-control-input vendor-skills" name="vendor-skills-'+skill_list_array[i].component_id+'" id="vendor-skills-'+skill_list_array[i].component_id+'" value="'+skill_list_array[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+skill_list_array[i].component_id+'">'+skill_list_array[i].component_name+'</label>';
			            vendor_skill_list_html += '</div>'; 
		                vendor_skill_list_html += '<input type="text" '+check_skill_tat_value+' class="fld3 form-control tat" placeholder="Enter a '+skill_list_array[i].component_name+' TAT" id="vendor-tat'+skill_list_array[i].component_id+'" name="vendor-tat" onkeyup="check_vendor_skill_tat('+skill_list_array[i].component_id+') onblur="check_vendor_skill_tat('+skill_list_array[i].component_id+')"">';
		                vendor_skill_list_html += '<div id="vendor-tat-error-msg-div'+skill_list_array[i].component_id+'">&nbsp;</div>';
		                vendor_skill_list_html += '</li>';

	            	}
	            	$('#vendor-skills-list').html(vendor_skill_list_html);
	            }

            	$('#edit-vendor-id').val(vendor_id);
            	
            	$('#edit-vendor-btn').attr('onclick','edit_vendor_details('+vendor_id+')');
            	$('#edit_vendor_details_module').modal('show');
            } else {
            	if (active_type == 1) {
            		get_active_vendor_list();
            	} else {
            		get_inactive_vendor_list();
            	}
        		toastr.error('Something went wrong updating the vendor status. Please try again.');
            }
        }
  	});
}

function delete_vendor_docs_modal(vendor_id,i) {
	$('#delete-vendor-docs-modal').modal('show');
	$('#delete-vendor-doc-name').val($('#delete_vendor_docs_modal_file'+i).data('vendor_docs')); 
	$('#delete-id').val(i);
  	$('#delete-vendor-doc-btn').attr("onclick","remove_vendor_doc("+vendor_id+","+i+")");
}
 

function remove_vendor_doc(vendor_id,i) {
	var vendor_doc_name = $('#delete-vendor-doc-name').val();
	$.ajax({
	    type  : 'POST',
	    url   : base_url+'admin_Vendor/remove_vendor_doc',
	    data : {
	    	vendor_id : vendor_id,
	    	vendor_doc_name : vendor_doc_name
	    },
	    dataType : 'json',
	    success : function(data) {
	      if (data.status == 1) {
	        toastr.success('Vendor doc has been successfully deleted.');
				$('#delete-vendor-docs-modal').modal('hide');
				get_vendor_docs(vendor_id);
			} else {
				toastr.error('Something went wrong while deleting the vendor doc. Please try again.');
				$('#delete-vendor-docs-modal').modal('hide');
			}
		}
	});
}

function get_vendor_docs(vendor_id) {
	$.ajax({
	    type  : 'POST',
	    url   : base_url+'admin_Vendor/get_vendor_docs',
	    data : {
	    	vendor_id : vendor_id
	    },
	    dataType : 'json',
	    success : function(data) {
	      	if (data.vendor_docs != '') {
	      		var vendor_docs_array = data.vendor_docs.split(',');
	            var vendor_docs_html = '';
				for (var i = 0; i < vendor_docs_array.length; i++) {
		 			vendor_docs_html += '<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_'+i+'">'+
	                '<div class="image-selected-div">'+
	                    '<ul>'+
	                      '<li class="image-selected-name pb-0">'+vendor_docs_array[i]+'</li>'+
		          	      '<li class="image-name-delete pb-0">'+
		                    '<a id="vendor_docs_modal_file'+i+'" onclick="view_vendor_docs_modal('+i+')" data-vendor_docs="'+vendor_docs_array[i]+'" class="image-name-delete-a"><i class="fa fa-eye text-primary"></i></a>'+
		                    '<a id="delete_vendor_docs_modal_file'+i+'" onclick="delete_vendor_docs_modal('+vendor_id+','+i+')" data-prod_images="'+vendor_docs_array[i]+'" class="image-name-delete-a ml-2"><i class="fa fa-times text-danger"></i></a>'+
		                '</li>'+
	                    '</ul>'+
	                  '</div>'+
	                '</div>';
				}
				$('#selected-vendor-docs-li').html(vendor_docs_html);
	      	}
		}
	});
}


function select_skill_tat(id) {
    if($("input[name=vendor-skills-"+id+"]").prop('checked') == true) {
    	$('#vendor-tat'+id).attr( "disabled", false )   
    	$('#vendor-tat'+id).attr("onkeyup","check_vendor_skill_tat("+id+")"); 
    	$('#vendor-tat'+id).attr("blur","check_vendor_skill_tat("+id+")");
	} else {
		$('#vendor-tat'+id).attr( "disabled", true )  
		$('#vendor-tat'+id).val('');
		$('#vendor-tat-error-msg-div'+id).html('&nbsp;');
		$('#vendor-tat'+id).removeAttr("onkeyup");
		$('#vendor-tat'+id).removeAttr("blur");
		$('#vendor-tat'+id).removeClass("is-valid is-invalid");
	}
}
