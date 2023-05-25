var pincode_length = 6;

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_address(id) {
	var variable_array = {};
	variable_array['input_id'] = '#address-'+id;
	variable_array['error_msg_div_id'] = '#address-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter valid address.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_pincode(id) {
	var variable_array = {};
	variable_array['input_id'] = '#pincode-'+id;
	variable_array['error_msg_div_id'] = '#pincode-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the pincode';
	variable_array['not_a_number_input_error_msg'] = 'Pincode should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Pincode should be of '+pincode_length+' digits';
	variable_array['max_length'] = pincode_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_country(id,request_from = '') {
	var variable_array = {};
    variable_array['input_id'] = '#country-'+id;
    variable_array['error_msg_div_id'] = '#country-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a country';
    var return_result = mandatory_select(variable_array);
    if (request_from != 'save-details') {
    	get_state_list(id);
	}
    return return_result;
}

function get_state_list(id) {
	var c_id = $("#country-"+id).children('option:selected').data('id');
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
			$("#state-"+id).html(html);
			$("#city-"+id).html("<option value=''>Select City/Town</option>");
        }
    });
}

function check_state(id,request_from = '') {
	var variable_array = {};
    variable_array['input_id'] = '#state-'+id;
    variable_array['error_msg_div_id'] = '#state-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a state';
    var return_result = mandatory_select(variable_array);
    if (request_from != 'save-details') {
    	get_city_list(id);
	}
    return return_result;
}

function get_city_list(id) {
	var c_id = $("#state-"+id).children('option:selected').data('id');
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
			$("#city-"+id).html(html);
        }
    });
}

function check_city(id) {
	var variable_array = {};
    variable_array['input_id'] = '#city-'+id;
    variable_array['error_msg_div_id'] = '#city-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a city';
    return mandatory_select(variable_array);
}

function save_details() {
	var address = [],
		pincode = [],
		country = [],
		state = [],
		city = [],
 		invalid_address_count = 0,
 		invalid_pincode_count = 0,
 		invalid_country_count = 0,
 		invalid_state_count = 0,
 		invalid_city_count = 0;

 	$(".address").each(function(i) {
		var check_address_var = check_address(i);
		if (check_address_var == 1) {
			address.push({address : $(this).val()});
		} else {
			invalid_address_count++;
		}
	});

	$(".pincode").each(function(i) {
		var check_pincode_var = check_pincode(i);
		if (check_pincode_var == 1) {
			pincode.push({pincode : $(this).val()});
		} else {
			invalid_pincode_count++;
		}
	});

	$(".country").each(function(i) {
		var check_country_var = check_country(i,'save-details');
		if (check_country_var == 1) {
			country.push({country : $(this).val()});
		} else {
			invalid_country_count++;
		}
	});

	$(".state").each(function(i) {
		var check_state_var = check_state(i,'save-details');
		if (check_state_var == 1) {
			state.push({state : $(this).val()});
		} else {
			invalid_state_count++;
		}
	});

	$(".city").each(function(i) {
		var check_city_var = check_city(i);
		if (check_city_var == 1) {
			city.push({city : $(this).val()});
		} else {
			invalid_city_count++;
		}
	});

	if (invalid_address_count == 0 && invalid_pincode_count == 0 && invalid_country_count == 0 && invalid_state_count == 0 && invalid_city_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',2);
		formdata.append('address',JSON.stringify(address));
		formdata.append('pincode',JSON.stringify(pincode));
		formdata.append('city',JSON.stringify(city));
		formdata.append('state',JSON.stringify(state));
		formdata.append('country',JSON.stringify(country));
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-court-record-1-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-court-record-2';
              	} else {
              		toastr.error('Something went wrong while save the data. Please try again.');
              	}
              	$("#save-details-btn").html("Save & Continue");
            },
            error: function(data) {
            	toastr.error('Something went wrong while save the data. Please try again.');
            	$("#save-details-btn").html("Save & Continue");;	
            }
        });
	} else {
		$('#save-data-error-msg').html('<span class="err-msg-small text-danger">Please fill all the necessary details</span>');
	}
}