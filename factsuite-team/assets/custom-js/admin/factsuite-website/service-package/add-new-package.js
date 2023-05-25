var package_name_max_length= 50,
	tat_name_max_length = 30,
	maximum_tat_days = 100,
	tat_max_price = 99999,
	tat_count = 1;

get_service_list();
function get_service_list() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-services',
        data : {
        	verify_admin_request : '1'
        },
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	         	if (data.services_list.length > 0) {
	         		var html = '<option value="">Select Service</option>';
	         		for (var i = 0; i < data.services_list.length; i++) {
	         			if (data.services_list[i].status == 1) {
	         				html += '<option value="'+data.services_list[i].service_id+'">'+data.services_list[i].name+'</option>';
	         			}
	         		}
	         	} else {
	         		html = '<option value="">No Services Available</option>';
	         	}
	         	$('#service-name').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

get_package_type();
function get_package_type() {
	$.ajax({
	    type:'POST',
	    url: img_base_url+'assets/custom-js/json/main-website-service-packages-type.json',
	    dataType: 'JSON',
	    success:function(data) {
	      	var package_type_list_html = '<option value="">Select Package Type</option>';
	      	$.each(data, function(index,value) {
  				package_type_list_html += '<option value="'+value+'">'+value+'</option>';
			});
	      	$('#package-type').html(package_type_list_html);
	    }
  	});
}

get_component_list();
function get_component_list() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'component/get_component_list',
        data : {
        	verify_admin_request : '1'
        },
        dataType : 'json',
        success : function(data) {
        	var html = '<div class="col-md-12 text-center">No Component Available</div>',
        		alacarte_html = '<div class="col-md-12 text-center">No Component Available</div>';
	        if (data.length > 0) {
	        	html = '';
	        	alacarte_html = '';
	        	for (var i = 0; i < data.length; i++) {
	         		html += '<div class="col-md-4">';
	                html += '<div class="custom-control custom-checkbox custom-control-inline">';
	                html += '<input type="checkbox" class="custom-control-input checked-package-components" value="'+data[i].component_id+'" name="package-component-name[]" id="package-component-'+data[i].component_id+'">';
	                html += '<label class="custom-control-label" for="package-component-'+data[i].component_id+'">'+data[i].component_name+'</label>';
	                html += '</div>';
	                html += '</div>';

	                alacarte_html += '<div class="col-md-4">';
	                alacarte_html += '<div class="custom-control custom-checkbox custom-control-inline">';
	                alacarte_html += '<input type="checkbox" class="custom-control-input checked-alacarte-package-components" value="'+data[i].component_id+'" name="package-alacarte-component-name[]" id="package-alacarte-component-'+data[i].component_id+'">';
	                alacarte_html += '<label class="custom-control-label" for="package-alacarte-component-'+data[i].component_id+'">'+data[i].component_name+'</label>';
	                alacarte_html += '</div>';
	                alacarte_html += '</div>';
	            }
         	}

         	$('#package-components').html(html);

         	$('#package-alacarte-components').html(alacarte_html);
	    }
    });
}

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

$('#add-new-package-btn').on('click', function() {
	add_new_package();	
});

$(document).ready(function() {
	$('.checked-package-components').on('click', function() {
		check_package_checked_components();
	});
});

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

function add_new_package() {
	var service_name = $('#service-name').val(),
		package_type =$('#package-type').val(),
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
	
	var check_service_name_var = check_service_name(),
		check_package_type_var = check_package_type(),
		check_package_name_var = check_package_name(),
		check_package_description_var = check_package_description(),
		check_package_checked_components_var = check_package_checked_components();

	if(check_service_name_var == 1 && check_package_type_var == 1 && check_package_name_var == 1 && check_package_description_var == 1
		&& tat_name_check == 0 && tat_days_check == 0 && tat_price_check == 0 && check_package_checked_components_var == 1) {
		
		$('#add-new-package-btn').prop('disabled',true);
		$('#new-package-error-msg').html('<span class="text-warning error-msg">Please wait while we are adding new package.</span>');

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
		formdata.append('service_name',service_name);
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
		  	url: base_url+"factsuite-admin/add-new-website-package",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#add-new-package-btn').prop('disabled',false);
					$('#new-package-error-msg').html('');
				  	if (data.service_package_details.status == '1') {
				  		// toastr.success('Will redirect to next page.');
				  		window.location = base_url+'factsuite-admin/add-website-package-component-details?package_type='+package_type+'&package_name='+package_name+'&package_id='+data.service_package_details.package_id;
				  	} else {
				  		toastr.error('Something went wrong while adding the package. Please try again.');
			  		}
			  	} else if (data.status == 2) {
			  		$('#new-package-error-msg').html('<span class="text-danger error-msg-small">Entered package name already exists for selected service. Please enter a new package name.</span>');
			  		$('#package-name-error').html('<span class="text-danger error-msg-small">Entered package name already exists for selected service. Please enter a new package name.</span>');
			  	} else {
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#add-new-package-btn').prop('disabled',false);
				$('#new-package-error-msg').html('');
		  		toastr.error('Something went wrong while adding the package. Please try again.');
		  	}
		});

	} else {
		$('#new-package-error-msg').html('<span class="text-danger error-msg-small">Please enter all the mandatory inputs</span>');
	}
}