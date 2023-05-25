var package_name_max_length= 50,
	tat_name_max_length = 30,
	maximum_tat_days = 100,
	tat_max_price = 99999,
	tat_count = 0;

$('#select-service-name').on('change', function() {
	get_service_packages();
});

$('#update-package-sort-btn').on('click', function() {
	update_package_sort();
});

$('#service-name').on('change', function() {
	check_service_name();
});

$('#package-type').on('change', function() {
	check_package_type();
});

$('#package-name').on('keyup blur', function() {
	check_package_name();
});

$('#package-description').on('keyup blur', function() {
	check_package_description();
});

$('#add-new-package-tat').on('click', function() {
	add_new_package_tat();	
});

$('.checked-package-components').on('click', function() {
	check_package_checked_components();
});

get_all_services();
function get_all_services() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-services',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	         	if (data.services_list.length > 0) {
	         		var html = '';
	         		for (var i = 0; i < data.services_list.length; i++) {
	         			html += '<option value="'+data.services_list[i].service_id+'">'+data.services_list[i].name+'</option>';
	         		}
	         	} else {
	         		html = '<option value="">No Services Available</div>';
	         	}
	         	$('#select-service-name').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

get_service_packages();
function get_service_packages() {
	$('#all-packages-list').html('');
	var service_name = $('#select-service-name').val();
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-website-service-packages',
        data : {
        	verify_admin_request : '1',
        	service_id : service_name
        },
        dataType : 'json',
        success : function(data) {
	        var html = '';
	        if (data.status == '1') {
	         	if (data.package_list.length > 0) {
	         		for (var i = 0; i < data.package_list.length; i++) {
	         			var check ='';
				        if (data.package_list[i].status == '1') {
				        	check ='checked';
				        } else {
				            check ='';
				       	}

		        		html += '<div class="col-md-4 mt-3 service-package-main-div" id="package-div-'+data.package_list[i].package_id+'" data-package_sorting_id="'+data.package_list[i].package_id+'">';
		                html += '<div class="product-category-description">';
		                html += '<ul>';
		                html += '<li class="product-category-name" id="package-name-li-'+data.package_list[i].package_id+'">'+data.package_list[i].name+' ('+data.package_list[i].package_type+')</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<div class="custom-control custom-switch pl-0">';
					    html += '<input type="checkbox" '+check+' onclick="change_package_status('+data.package_list[i].package_id+','+data.package_list[i].status+')" class="custom-control-input" id="change_package_status_'+data.package_list[i].package_id+'">';
					    html += '<label class="custom-control-label" for="change_package_status_'+data.package_list[i].package_id+'"></label>';
					    html += '</div>';
		                html += '</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<a class="product-category-delete-a" id="view_package_'+data.package_list[i].package_id+'" href="'+base_url+'factsuite-admin/edit-website-package-details?package_id='+data.package_list[i].package_id+'"><i class="fa fa-pencil edit-a"></i></a>';
		                html += '</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<a class="product-category-delete-a" id="delete_package_'+data.package_list[i].package_id+'" onclick="delete_package_modal('+data.package_list[i].package_id+')" data-package_name="'+data.package_list[i].name+'"><i class="fa fa-trash edit-a text-danger"></i></a>';
		                html += '</li>';
		                html += '</ul>';
		                html += '</div>';
		                html += '</div>';
	         		}
	         	} else {
	         		html = '<div class="col-md-12 text-center">No Packages Available</div>';
	         	}
	         	$('#all-packages-list').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

$('#all-packages-list').sortable({ tolerance: 'pointer' });

function change_package_status(package_id,status) {
	var changed_status = 0;

	if (status == 1) {
		changed_status = 0;
	} else if (status == 0) {
		changed_status = 1;
	} else {
		get_service_packages();
		toastr.error('OOPS! Something went wrong. Please try again.')
		return false;
	}

	var variable_array = {};
	variable_array['id'] = package_id;
	variable_array['actual_status'] = status;
	variable_array['changed_status'] = changed_status;
	variable_array['ajax_call_url'] = 'factsuite-admin/change-factsuite-website-service-package-status';
	variable_array['checkbox_id'] = '#change_package_status_'+package_id;
	variable_array['onclick_method_name'] = 'change_package_status';
	variable_array['success_message'] = 'Package status has been updated successfully.';
	variable_array['error_message'] = 'Something went wrong updating the package status. Please try again.';
	variable_array['error_callback_function'] = 'get_service_packages()';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : package_id, changed_status : changed_status};

	return change_status(variable_array);
}

function delete_package_modal(package_id) {
	$('#delete-package-name-hdr-span').html($('#delete_package_'+package_id).attr('data-package_name')+' Package');
	$('#delete-package-btn').attr('onclick','delete_package('+package_id+')');
	$('#delete-package-modal').modal('show');
}

function delete_package(package_id) {
	var variable_array = {};
	variable_array['id'] = package_id;
	variable_array['ajax_call_url'] = 'factsuite-admin/delete-factsuite-website-service-package';
	variable_array['onclick_method_name'] = 'delete_package';
	variable_array['success_message'] = 'Package has been deleted successfully.';
	variable_array['error_message'] = 'Something went wrong deleting the package. Please try again.';
	variable_array['modal_id'] = '#delete-package-modal';
	variable_array['delete_image_div_id'] = '#package-div-'+package_id;
	variable_array['delete_btn_id'] = '#delete-package-btn';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, package_id : package_id};
	return delete_uploaded_image(variable_array);
}

function update_package_sort() {
	var service_name = $('#select-service-name').val();
	var package_sorting_ids = [];
	$('.service-package-main-div').each(function (index) { 
    	package_sorting_ids.push($(this).attr('data-package_sorting_id'));
  	});

  	$.ajax({
      	type: "POST",
      	url: base_url+'factsuite-admin/update-factsuite-website-service-package-sorting',
      	data: {
      		verify_admin_request : 1,
      		service_id : service_name,
      		package_sorting_ids : package_sorting_ids
      	},
      	dataType:'json',
      	success: function(data) {
      		if (data.status == 1) {
      			if (data.package_sort.status == 1) {
        			toastr.success('Package order has been updated successfully.');
      			} else {
      				toastr.error('Something went wrong while sorting the package order. Please try again');
      			}
      		} else {
      			check_admin_login();
      		}
      	}
    });
}

function view_package_details(package_id) {
	tat_count = 0;
	$.ajax({
		type: "POST",
    	url: base_url+"factsuite-admin/get-single-factsuite-website-service-package",
    	dataType: "json",
    	data : {
    		verify_admin_request : 1,
    		package_id : package_id
    	},
    	success: function(data) {
			if (data.status == 1) {
				// $('#modal-edit-service-package-id').val(package_id);
				$('#edit-package-service-name').html(data.package_details.service_name);
				var package_type_html = '';
				var package_type_list = JSON.parse(data.package_type_list);
				
				$.each(package_type_list, function(index,value) {
	      			var selected = '';
	      			if(jQuery.inArray(value, data.package_details.package_type.split(',')) != -1) {
	      				selected = 'selected';
	      			}
  					package_type_html += '<option '+selected+' value="'+value+'">'+value+'</option>';
  				});
				$('#package-type').html(package_type_html);

				$('#package-name').val(data.package_details.name);

				$('#package-description').val(data.package_details.description);

				var is_most_popular = false;
				if (data.package_details.mark_as_most_popular == 1) {
					is_most_popular = true;
				}
				$('#is-package-most-popular').prop('checked',is_most_popular);

				$('#additional-tat-div').html('');
				var tat_and_price = JSON.parse(data.package_details.tat_and_price);
	            if (tat_and_price.length > 0) {
	                for (var i = 0; i < tat_and_price.length; i++) {
	                    var row = '<div class="row mt-3" id="tat-row-'+tat_count+'">';
						row += '<div class="col-md-3">';
						row += '<label>TAT Name</label>';
						row += '<input type="text" class="form-control fld tat_name" id="add-new-tat-name-'+tat_count+'" value="'+tat_and_price[i].name+'" placeholder="TAT Name" onkeyup="validate_tat_name('+tat_count+')" onblur="validate_tat_name('+tat_count+')">';
						row += '<div id="add-new-tat-name-error-'+tat_count+'"></div>';
						row += '</div>';
						row += '<div class="col-md-3">';
						row += '<label>TAT Days</label>';
						row += '<input type="text" class="form-control fld tat_days" id="add-new-tat-days-'+tat_count+'" value="'+tat_and_price[i].days+'" placeholder="TAT Days" onkeyup="validate_tat_days('+tat_count+')" onblur="validate_tat_days('+tat_count+')">';
						row += '<div id="add-new-tat-days-error-'+tat_count+'"></div>';
						row += '</div>';
						row += '<div class="col-md-3">';
						row += '<label>TAT Price</label>';
						row += '<input type="text" class="form-control fld tat_price" id="add-new-tat-price-'+tat_count+'" value="'+tat_and_price[i].price+'" placeholder="TAT Price" onkeyup="validate_tat_price('+tat_count+')" onblur="validate_tat_price('+tat_count+')">';
						row += '<div id="add-new-tat-price-error-'+tat_count+'"></div>';
						row += '</div>';
						row += '<div class="col-md-1">';
						row += '<label>&nbsp;</label>';
						if(i != 0) {
							row += '<button onclick="remove_tat('+tat_count+')" class="btn btn-danger" id="remove-package-tat-'+tat_count+'"><i class="fa fa-remove"></i></button>';
						} else {
							row += '<button class="btn btn-success" id="add-new-package-tat" onclick="add_new_package_tat()"><i class="fa fa-plus"></i></button>';
						}
						row += '</div>';
						row += '</div>';
						tat_count++;
	            		$('#additional-tat-div').append(row);
	                }
	            }

	            var html = '<div class="col-md-12 text-center">No Component Available</div>',
        		alacarte_html = '<div class="col-md-12 text-center">No Component Available</div>';

        		var components_included_details = JSON.parse(data.package_details.components_included_details);

        		var alacarte_component_included_details = '';
        		if (data.package_details.alacarte_component_included_details != '' && data.package_details.alacarte_component_included_details != null) {
        			alacarte_component_included_details = JSON.parse(data.package_details.alacarte_component_included_details);
        		}
        		
		        if (data.component_list.length > 0) {
		        	html = '';
		        	alacarte_html = '';
		        	for (var i = 0; i < data.component_list.length; i++) {
		        		var checked = '';
		        		for (var j = 0; j < components_included_details.length; j++) {
		        			if (data.component_list[i].component_id == components_included_details[j].component_id) {
		        				checked = 'checked';
		        			}
		        		}
		         		html += '<div class="col-md-4">';
		                html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                html += '<input type="checkbox" '+checked+' class="custom-control-input checked-package-components" value="'+data.component_list[i].component_id+'" name="package-component-name[]" id="package-component-'+data.component_list[i].component_id+'" onclick="check_package_checked_components()">';
		                html += '<label class="custom-control-label" for="package-component-'+data.component_list[i].component_id+'">'+data.component_list[i].component_name+'</label>';
		                html += '</div>';
		                html += '</div>';

		                var checked = '';
		                if(alacarte_component_included_details.length > 0) {
		                	for (var j = 0; j < alacarte_component_included_details.length; j++) {
		        				if (data.component_list[i].component_id == alacarte_component_included_details[j].component_id) {
		        					checked = 'checked';
		        				}
		        			}
		                }
		                alacarte_html += '<div class="col-md-4">';
		                alacarte_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                alacarte_html += '<input type="checkbox" '+checked+' class="custom-control-input checked-alacarte-package-components" value="'+data.component_list[i].component_id+'" name="package-alacarte-component-name[]" id="package-alacarte-component-'+data.component_list[i].component_id+'">';
		                alacarte_html += '<label class="custom-control-label" for="package-alacarte-component-'+data.component_list[i].component_id+'">'+data.component_list[i].component_name+'</label>';
		                alacarte_html += '</div>';
		                alacarte_html += '</div>';
		            }
	         	}

	         	$('#package-components').html(html);

	         	$('#package-alacarte-components').html(alacarte_html);

				$('#edit-package-details-btn').attr('onclick','update_package_details('+package_id+')');

				// $('#edit-package-details-modal').modal('show');
			} else {
				check_admin_login();
			}
		}     	
	});
}

function check_service_name() {
	var variable_array = {};
	variable_array['input_id'] = '#service-name';
	variable_array['error_msg_div_id'] = '#service-name-error';
	variable_array['empty_input_error_msg'] = 'Please select the service name.';
	return mandatory_select(variable_array);
}

function check_package_type() {
	var variable_array = {};
	variable_array['input_id'] = '#package-type';
	variable_array['error_msg_div_id'] = '#package-type-error';
	variable_array['empty_input_error_msg'] = 'Please select the package type.';
	return mandatory_select(variable_array);
}

function check_package_name() {
	var variable_array = {};
	variable_array['input_id'] = '#package-name';
	variable_array['error_msg_div_id'] = '#package-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter the package name';
	variable_array['max_length'] = package_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Package name should be of max '+package_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_package_description() {
	var variable_array = {};
	variable_array['input_id'] = '#package-description';
	variable_array['error_msg_div_id'] = '#package-description-error';
	variable_array['empty_input_error_msg'] = 'Please enter the package description';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function validate_tat_name(id = '') {
	var variable_array = {};
	variable_array['input_id'] = '#add-new-tat-name-'+id;
	variable_array['error_msg_div_id'] = '#add-new-tat-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the TAT name';
	variable_array['max_length'] = tat_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'TAT name should be of max '+tat_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function validate_tat_days(id = '') {
	var variable_array = {};
	variable_array['input_id'] = '#add-new-tat-days-'+id;
	variable_array['error_msg_div_id'] = '#add-new-tat-days-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the TAT days';
	variable_array['not_a_number_input_error_msg'] = 'TAT days should be only in numbers.';
	variable_array['exceeding_max_number_input_error_msg'] = 'TAT days should be max '+maximum_tat_days;
	variable_array['max_number'] = maximum_tat_days;
	variable_array['no_error_msg'] = '';
	return only_number_with_max_number_limitation(variable_array);
}

function validate_tat_price(id = '') {
	var variable_array = {};
	variable_array['input_id'] = '#add-new-tat-price-'+id;
	variable_array['error_msg_div_id'] = '#add-new-tat-price-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the TAT price';
	variable_array['not_a_number_input_error_msg'] = 'TAT price should be only in numbers.';
	variable_array['exceeding_max_number_input_error_msg'] = 'TAT price should be max '+tat_max_price;
	variable_array['max_number'] = tat_max_price;
	variable_array['no_error_msg'] = '';
	return only_number_with_max_number_limitation(variable_array);
}

function add_new_package_tat() {
	var is_true = true,
		tat_check = 0;
   	$('.tat_name').each(function() {
   		var validate_tat_name_var = validate_tat_name(tat_check),
   			validate_tat_days_var = validate_tat_days(tat_check),
   			validate_tat_price_var = validate_tat_price(tat_check);

	    if(validate_tat_name_var != '1' || validate_tat_days_var != '1' || validate_tat_price_var != '1') { 
	      	is_true = false;
	    }
	    tat_check++;
	});

	if (is_true == false) {
	  	return false;
	}

	var row = '<div class="row mt-3" id="tat-row-'+tat_count+'">';
		row += '<div class="col-md-3">';
		row += '<label>TAT Name</label>';
		row += '<input type="text" class="form-control fld tat_name" id="add-new-tat-name-'+tat_count+'" placeholder="TAT Name" onkeyup="validate_tat_name('+tat_count+')" onblur="validate_tat_name('+tat_count+')">';
		row += '<div id="add-new-tat-name-error-'+tat_count+'"></div>';
		row += '</div>';
		row += '<div class="col-md-3">';
		row += '<label>TAT Days</label>';
		row += '<input type="text" class="form-control fld tat_days" id="add-new-tat-days-'+tat_count+'" placeholder="TAT Days" onkeyup="validate_tat_days('+tat_count+')" onblur="validate_tat_days('+tat_count+')">';
		row += '<div id="add-new-tat-days-error-'+tat_count+'"></div>';
		row += '</div>';
		row += '<div class="col-md-3">';
		row += '<label>TAT Price</label>';
		row += '<input type="text" class="form-control fld tat_price" id="add-new-tat-price-'+tat_count+'" placeholder="TAT Price" onkeyup="validate_tat_price('+tat_count+')" onblur="validate_tat_price('+tat_count+')">';
		row += '<div id="add-new-tat-price-error-'+tat_count+'"></div>';
		row += '</div>';
		row += '<div class="col-md-1">';
		row += '<label>&nbsp;</label>';
		row += '<button onclick="remove_tat('+tat_count+')" class="btn btn-danger" id="remove-package-tat-'+tat_count+'"><i class="fa fa-remove"></i></button>';
		row += '</div>';
		row += '</div>';

	$("#additional-tat-div").append(row);     
    tat_count++;
}

function remove_tat(id) { 
   	$('#tat-row-'+id).remove(); 
}

function check_package_checked_components() {
	var components_checked = $('input[name="package-component-name[]"]:checked').length;
	if (components_checked > 0) {
		$('#package-components-error-msg').html('');
		return 1;
	} else {
		$('#package-components-error-msg').html('<span class="text-danger error-msg-small">Please select at least 1 component.</span>');
		return 0;
	}
}

function update_package_details(package_id) {
	var package_type =$('#package-type').val(),
		package_name = $('#package-name').val(),
		package_description = $('#package-description').val();

	var tat_name_check = 0,
		tat_days_check = 0,
		tat_price_check = 0;

	var tat_name_array = [],
		tat_days_array = [],
		tat_price_array = [];

	$('.tat_name').each(function(i) {
   		var validate_tat_name_var = validate_tat_name(i);
	    if(validate_tat_name_var == '1') { 
	      	tat_name_array[i] = $(this).val();
	    } else {
	    	tat_name_check++;
	    }
	});

	$('.tat_days').each(function(i) {
   		var validate_tat_days_var = validate_tat_days(i);
	    if(validate_tat_days_var == '1') { 
	      	tat_days_array[i] = $(this).val();
	    } else {
	    	tat_days_check++;
	    }
	});

	$('.tat_price').each(function(i) {
   		var validate_tat_price_var = validate_tat_price(i);
	    if(validate_tat_price_var == '1') { 
	      	tat_price_array[i] = $(this).val();
	    } else {
	    	tat_price_check++;
	    }
	});
	
	var check_package_type_var = check_package_type(),
		check_package_name_var = check_package_name(),
		check_package_description_var = check_package_description(),
		check_package_checked_components_var = check_package_checked_components();
	
	if(check_package_type_var == 1 && check_package_name_var == 1 && check_package_description_var == 1
		&& tat_name_check == 0 && tat_days_check == 0 && tat_price_check == 0 && check_package_checked_components_var == 1) {
		
		$('#edit-package-details-btn').prop('disabled',true);
		$('#edit-package-details-btn').removeAttr('onclick');
		$('#update-package-details-error-msg-div').html('<span class="text-warning error-msg">Please wait while we are updating package.</span>');

		var is_package_most_popular = 0;
   		if ($('#is-package-most-popular:checked').val() == 1) {
   			is_package_most_popular = 1;
   		}

		var selected_package_component = [];
		$('input[name="package-component-name[]"]:checked').each(function(i) {
    		selected_package_component[i] = $(this).val();
   		});

   		var selected_alacarte_package_component = [];
		$('input[name="package-alacarte-component-name[]"]:checked').each(function(i) {
    		selected_alacarte_package_component[i] = $(this).val();
   		});

		var formdata = new FormData();
		formdata.append('verify_admin_request',1);
		formdata.append('package_id',package_id);
		formdata.append('package_type',package_type);
		formdata.append('package_name',package_name);
		formdata.append('package_description',package_description);
		formdata.append('tat_name_array',tat_name_array);
		formdata.append('tat_days_array',tat_days_array);
		formdata.append('tat_price_array',tat_price_array);
		formdata.append('selected_package_component',selected_package_component);
		formdata.append('is_package_most_popular',is_package_most_popular);
		formdata.append('selected_alacarte_package_component',selected_alacarte_package_component);

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-admin/update-website-package-details",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#edit-package-details-btn').prop('disabled',false);
					$('#update-package-details-error-msg-div').html('');
				  	if (data.service_package_details.status == '1') {
				  		window.location = base_url+'factsuite-admin/edit-website-package-components?package_id='+package_id;
				  	} else {
				  		$('#edit-package-details-btn').attr('onclick','update_package_details('+package_id+')');
				  		toastr.error('Something went wrong while updating the package. Please try again.');
			  		}
			  	} else if (data.status == 2) {
			  		$('#edit-package-details-btn').prop('disabled',false);
			  		$('#edit-package-details-btn').attr('onclick','update_package_details('+package_id+')');
			  		$('#update-package-details-error-msg-div').html('<span class="text-danger error-msg-small">Entered package name already exists for selected service. Please enter a new package name.</span>');
			  		$('#package-name-error').html('<span class="text-danger error-msg-small">Entered package name already exists for selected service. Please enter a new package name.</span>');
			  	} else {
			  		$('#edit-package-details-btn').prop('disabled',false);
			  		$('#edit-package-details-btn').attr('onclick','update_package_details('+package_id+')');
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#edit-package-details-btn').prop('disabled',false);
		  		$('#edit-package-details-btn').attr('onclick','update_package_details('+package_id+')');
				$('#update-package-details-error-msg-div').html('');
		  		toastr.error('Something went wrong while updating the package. Please try again.');
		  	}
		});

	} else {
		$('#update-package-details-error-msg-div').html('<span class="text-danger error-msg-small">Please enter all the mandatory inputs</span>');
	}
}