var house_flat_max_length= 10,
	street_max_length = 100,
	area_max_length = 100,
	pincode_length = 6,
	annual_ctc_max_length = 10,
	contact_person_name_max_length = 100,
	contact_number_length = 10;

$('#house-flat').on('keyup blur', function() {
	check_house_flat();
});

$('#street').on('keyup blur', function() {
	check_street();
});

$('#area').on('keyup blur', function() {
	check_area();
});

$('#pincode').on('keyup blur', function() {
	check_pincode();
});

$('#land-mark').on('keyup blur', function() {
	check_land_mark();
});

$('#annual-ctc').on('keyup blur', function() {
	check_annual_ctc();
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

$('#duration-of-stay-from-month').on('change', function() {
	check_duration_of_stay_from_month();
});

$('#duration-of-stay-from-year').on('change', function() {
	check_duration_of_stay_from_year();
});

$('#duration-of-stay-to-month').on('change', function() {
	check_duration_of_stay_to_month();
});

$('#duration-of-stay-to-year').on('change', function() {
	check_duration_of_stay_to_year();
});

$('#contact-person-name').on('keyup blur', function() {
	check_contact_person_name();
});

$('#relationship').on('change', function() {
	check_relationship();
});

$('#contact-person-contact-no').on('keyup blur', function() {
	check_contact_person_contact_no();
});

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_house_flat() {
	var variable_array = {};
	variable_array['input_id'] = '#house-flat';
	variable_array['error_msg_div_id'] = '#house-flat-error';
	variable_array['empty_input_error_msg'] = 'Please enter the house or flat number';
	variable_array['max_length'] = house_flat_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'House or Flat number should be of max '+house_flat_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_street() {
	var variable_array = {};
	variable_array['input_id'] = '#street';
	variable_array['error_msg_div_id'] = '#street-error';
	variable_array['empty_input_error_msg'] = 'Please enter the street or road name';
	variable_array['max_length'] = street_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Street or Road name should be of max '+street_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_area() {
	var variable_array = {};
	variable_array['input_id'] = '#area';
	variable_array['error_msg_div_id'] = '#area-error';
	variable_array['empty_input_error_msg'] = 'Please enter the area name';
	variable_array['max_length'] = area_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Area name should be of max '+area_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
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

function check_land_mark() {
	var variable_array = {};
	variable_array['input_id'] = '#land-mark';
	variable_array['error_msg_div_id'] = '#land-mark-error';
	variable_array['empty_input_error_msg'] = 'Please enter valid landmark.';
	return mandatory_any_input_with_no_limitation(variable_array);
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

function check_duration_of_stay_from_month() {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-from-month';
    variable_array['error_msg_div_id'] = '#duration-of-stay-from-month-error';
    variable_array['empty_input_error_msg'] = 'Please select a month';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_from_year() {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-from-year';
    variable_array['error_msg_div_id'] = '#duration-of-stay-from-year-error';
    variable_array['empty_input_error_msg'] = 'Please select a year';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_to_month() {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-to-month';
    variable_array['error_msg_div_id'] = '#duration-of-stay-to-month-error';
    variable_array['empty_input_error_msg'] = 'Please select a month';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_to_year() {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-to-year';
    variable_array['error_msg_div_id'] = '#duration-of-stay-to-year-error';
    variable_array['empty_input_error_msg'] = 'Please select a year';
    return mandatory_select(variable_array);
}

function check_contact_person_name() {
	var variable_array = {};
	variable_array['input_id'] = '#contact-person-name';
	variable_array['error_msg_div_id'] = '#contact-person-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter contact person name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+contact_person_name_max_length+' characters';
	variable_array['max_length'] = contact_person_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_relationship() {
	var variable_array = {};
    variable_array['input_id'] = '#relationship';
    variable_array['error_msg_div_id'] = '#relationship-error';
    variable_array['empty_input_error_msg'] = 'Please select your relationship with candidate';
    return mandatory_select(variable_array);
}

function check_contact_person_contact_no() {
	var variable_array = {};
	variable_array['input_id'] = '#contact-person-contact-no';
	variable_array['error_msg_div_id'] = '#contact-person-contact-no-error';
	variable_array['empty_input_error_msg'] = 'Please enter the contact number';
	variable_array['not_a_number_input_error_msg'] = 'Contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Contact number should be of '+contact_number_length+' digits';
	variable_array['max_length'] = contact_number_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function save_details() {
	var check_house_flat_var = check_house_flat(),
		check_street_var = check_street(),
		check_area_var = check_area(),
		check_pincode_var = check_pincode(),
		check_land_mark_var = check_land_mark(),
		check_country_var = check_country('save-details'),
		check_state_var = check_state('save-details'),
		check_city_var = check_city(),
		check_duration_of_stay_from_month_var = check_duration_of_stay_from_month(),
		check_duration_of_stay_from_year_var = check_duration_of_stay_from_year(),
		check_duration_of_stay_to_month_var = check_duration_of_stay_to_month(),
		check_duration_of_stay_to_year_var = check_duration_of_stay_to_year(),
		check_contact_person_name_var = check_contact_person_name(),
		check_relationship_var = check_relationship(),
		check_contact_person_contact_no_var = check_contact_person_contact_no();

	if(check_house_flat_var == 1 && check_street_var == 1 && check_area_var == 1 && check_pincode_var == 1 && check_land_mark_var == 1 && check_country_var == 1 && check_state_var == 1 && check_city_var == 1 && check_duration_of_stay_from_month_var == 1
		&& check_duration_of_stay_from_year_var == 1 && check_duration_of_stay_to_month_var == 1 && check_duration_of_stay_to_year_var == 1 && check_contact_person_name_var == 1 && check_relationship_var == 1 && check_contact_person_contact_no_var == 1) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',8);
	 	formdata.append('house',$('#house-flat').val());
		formdata.append('street',$('#street').val());
		formdata.append('area',$('#area').val());
		formdata.append('pincode',$('#pincode').val());
		formdata.append('land_mark',$('#land-mark').val());
		formdata.append('country',$('#country').val());
		formdata.append('state',$('#state').val());
		formdata.append('city',$('#city').val());
		formdata.append('start_month',$('#duration-of-stay-from-month').val());
		formdata.append('start_year',$('#duration-of-stay-from-year').val());
		formdata.append('end_month',$('#duration-of-stay-to-month').val());
		formdata.append('end_year',$('#duration-of-stay-to-year').val());
		formdata.append('present',$("#customCheck1:checked").val());
		formdata.append('name',$('#contact-person-name').val());
		formdata.append('relationship',$('#relationship').val());
		formdata.append('code',$('#contact-person-contact-code').val());
		formdata.append('contact_no',$('#contact-person-contact-no').val());
		formdata.append('verify_candidate_request',1);

		var present_address_id = $("#present_address_id").val();
		if (present_address_id !='' && present_address_id !=null) {
			formdata.append('present_address_id',present_address_id);
		}

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-present-address-1-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-present-address-2';
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