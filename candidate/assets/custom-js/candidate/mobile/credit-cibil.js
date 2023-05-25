var credit_cibil_number_max_length = 20,
	pincode_length = 6;

$('#document-type').on('change', function() {
	check_document_type();
});

$('#credit-cibil-number').on('keyup blur', function() {
	check_credit_cibil_number();
});

$('#country').on('change', function() {
	check_country();
});

$('#state').on('change', function() {
	check_state();
});

$('#city').on('change', function() {
	check_city();
});

$('#pincode').on('keyup blur', function() {
	check_pincode();
});

$('#address').on('keyup blur', function() {
	check_address();
});

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_document_type() {
	 var variable_array = {};
    variable_array['input_id'] = '#document-type';
    variable_array['error_msg_div_id'] = '#document-type-error';
    variable_array['empty_input_error_msg'] = 'Please select a document type.';
    return mandatory_select(variable_array);
}

function check_credit_cibil_number() {
	var variable_array = {};
    variable_array['input_id'] = '#credit-cibil-number';
    variable_array['error_msg_div_id'] = '#credit-cibil-number-error';
    variable_array['empty_input_error_msg'] = 'Please enter the credit / cibil number';
    variable_array['max_length'] = credit_cibil_number_max_length;
    variable_array['exceeding_max_length_error_msg'] = 'Document number should be of max '+credit_cibil_number_max_length+' characters';
    return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_country(request_from = '') {
	var variable_array = {};
    variable_array['input_id'] = '#country';
    variable_array['error_msg_div_id'] = '#country-error';
    variable_array['empty_input_error_msg'] = 'Please select a country';
    var return_result = mandatory_select(variable_array);
    if (request_from != 'save-details') {
    	get_state_list();
	}
    return return_result;
}

function get_state_list() {
	var c_id = $("#country").children('option:selected').data('id');
	$.ajax({
        type: "POST",
        url: base_url+"candidate/get_selected_states/"+c_id, 
        dataType: 'json', 
        success: function(data) {
          	var html = '';
          	html += "<option value=''>Select State</option>";
			if (data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
				}
			}
			$("#state").html(html);
			$("#city").html("<option value=''>Select City/Town</option>");
        }
    });
}

function check_state(request_from = '') {
	var variable_array = {};
    variable_array['input_id'] = '#state';
    variable_array['error_msg_div_id'] = '#state-error';
    variable_array['empty_input_error_msg'] = 'Please select a state';
    var return_result = mandatory_select(variable_array);
    if (request_from != 'save-details') {
    	get_city_list();
	}
    return return_result;
}

function get_city_list() {
	var c_id = $("#state").children('option:selected').data('id');
	$.ajax({
        type: "POST",
        url: base_url+"candidate/get_selected_cities/"+c_id, 
        dataType: 'json', 
        success: function(data) {
          	var html = '';
          	html += "<option value=''>Select City/Town</option>";
			if (data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
				}
			}
			$("#city").html(html);
        }
    });
}

function check_city() {
	var variable_array = {};
    variable_array['input_id'] = '#city';
    variable_array['error_msg_div_id'] = '#city-error';
    variable_array['empty_input_error_msg'] = 'Please select a city';
    return mandatory_select(variable_array);
}

function check_pincode() {
	var variable_array = {};
	variable_array['input_id'] = '#pincode';
	variable_array['error_msg_div_id'] = '#pincode-error';
	variable_array['empty_input_error_msg'] = 'Please enter the pincode';
	variable_array['not_a_number_input_error_msg'] = 'Pincode should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Pincode should be of '+pincode_length+' digits';
	variable_array['max_length'] = pincode_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_address() {
	var variable_array = {};
	variable_array['input_id'] = '#address';
	variable_array['error_msg_div_id'] = '#address-error';
	variable_array['empty_input_error_msg'] = 'Please enter valid address.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function save_details() {
	var check_document_type_var = check_document_type(),
		check_credit_cibil_number_var = check_credit_cibil_number(),
		check_country_var = check_country('save-details'),
		check_state_var = check_state('save-details'),
		check_city_var = check_city(),
		check_pincode_var = check_pincode(),
		check_address_var = check_address();

	if (check_document_type_var == 1 && check_credit_cibil_number_var == 1 && check_country_var == 1 && check_state_var == 1 && check_city_var == 1 && check_pincode_var == 1 && check_address_var == 1) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		var document_type = [],
			credit_cibil_number = [];

		document_type.push({document_type : $('#document-type').val()});
		credit_cibil_number.push({credit_cibil_number : $('#credit-cibil-number').val()});

		var formdata = new FormData();
	 	formdata.append('url',17);
	 	formdata.append('document_type',JSON.stringify(document_type));
		formdata.append('credit_cibil_number',JSON.stringify(credit_cibil_number));
		formdata.append('country',$('#country').val());
		formdata.append('state',$('#state').val());
		formdata.append('city',$('#city').val());
		formdata.append('pincode',$('#pincode').val());
		formdata.append('address',$('#address').val());
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-credit-cibil-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-component-list';
              	} else {
              		toastr.error('Something went wrong while saving the data. Please try again.');
              	}
              	$("#save-details-btn").html("Save & Continue");
            },
            error: function(data) {
            	toastr.error('Something went wrong while saving the data. Please try again.');
            	$("#save-details-btn").html("Save & Continue");;	
            }
        });
	} else {
		$('#save-data-error-msg').html('<span class="err-msg-small text-danger">Please fill all the necessary details</span>');
	}
}