var house_flat_max_length= 10,
	street_max_length = 100,
	area_max_length = 100,
	pincode_length = 6,
	annual_ctc_max_length = 10,
	contact_person_name_max_length = 100,
	contact_number_length = 10;

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_house_flat(id) {
	var variable_array = {};
	variable_array['input_id'] = '#house-flat-'+id;
	variable_array['error_msg_div_id'] = '#house-flat-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the house or flat number';
	variable_array['max_length'] = house_flat_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'House or Flat number should be of max '+house_flat_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_street(id) {
	var variable_array = {};
	variable_array['input_id'] = '#street-'+id;
	variable_array['error_msg_div_id'] = '#street-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the street or road name';
	variable_array['max_length'] = street_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Street or Road name should be of max '+street_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_area(id) {
	var variable_array = {};
	variable_array['input_id'] = '#area-'+id;
	variable_array['error_msg_div_id'] = '#area-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the area name';
	variable_array['max_length'] = area_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Area name should be of max '+area_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
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

function check_land_mark(id) {
	var variable_array = {};
	variable_array['input_id'] = '#land-mark-'+id;
	variable_array['error_msg_div_id'] = '#land-mark-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter valid landmark.';
	return mandatory_any_input_with_no_limitation(variable_array);
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

function check_duration_of_stay_from_month(id) {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-from-month-'+id;
    variable_array['error_msg_div_id'] = '#duration-of-stay-from-month-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a month';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_from_year(id) {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-from-year-'+id;
    variable_array['error_msg_div_id'] = '#duration-of-stay-from-year-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a year';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_to_month(id) {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-to-month-'+id;
    variable_array['error_msg_div_id'] = '#duration-of-stay-to-month-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a month';
    return mandatory_select(variable_array);
}

function check_duration_of_stay_to_year(id) {
	var variable_array = {};
    variable_array['input_id'] = '#duration-of-stay-to-year-'+id;
    variable_array['error_msg_div_id'] = '#duration-of-stay-to-year-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select a year';
    return mandatory_select(variable_array);
}

function check_contact_person_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#contact-person-name-'+id;
	variable_array['error_msg_div_id'] = '#contact-person-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter contact person name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+contact_person_name_max_length+' characters';
	variable_array['max_length'] = contact_person_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_relationship(id) {
	var variable_array = {};
    variable_array['input_id'] = '#relationship-'+id;
    variable_array['error_msg_div_id'] = '#relationship-error-'+id;
    variable_array['empty_input_error_msg'] = 'Please select your relationship with candidate';
    return mandatory_select(variable_array);
}

function check_contact_person_contact_no(id) {
	var variable_array = {};
	variable_array['input_id'] = '#contact-person-contact-no-'+id;
	variable_array['error_msg_div_id'] = '#contact-person-contact-no-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the contact number';
	variable_array['not_a_number_input_error_msg'] = 'Contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Contact number should be of '+contact_number_length+' digits';
	variable_array['max_length'] = contact_number_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function save_details() {
	var house_flat = [],
		street_var = [],
		area = [],
		company_name = [],
		address = [],
		pincode = [],
		land_mark = [],
		country = [],
		state = [],
		city = [],
		from_date = [],
		to_date = [],
		contact_person_name = [],
		relationship = [],
		code = [],
		contact_no = [],
 		invalid_house_flat_count = 0,
 		invalid_street_var_count = 0,
 		invalid_area_count = 0,
 		invalid_pincode_count = 0,
 		invalid_land_mark_count = 0,
 		invalid_country_count = 0,
 		invalid_state_count = 0,
 		invalid_city_count = 0,
 		invalid_duration_of_stay_from_month_count = 0,
 		invalid_duration_of_stay_from_year_count = 0,
 		invalid_duration_of_stay_to_month_count = 0,
 		invalid_duration_of_stay_to_year_count = 0,
 		invalid_contact_person_name_count = 0,
 		invalid_relationship_count = 0,
 		invalid_code_count = 0,
 		invalid_contact_no_count = 0;

	$(".house-flat").each(function(i) {
		var check_house_flat_var = check_house_flat(i);
		if (check_house_flat_var == 1) {
			house_flat.push({flat_no : $(this).val()});
		} else {
			invalid_house_flat_count++;
		}
	});

	$(".street").each(function(i) {
		var check_street_var = check_street(i);
		if (check_street_var == 1) {
			street_var.push({street : $(this).val()});
		} else {
			invalid_street_var_count++;
		}
	});

	$(".area").each(function(i) {
		var check_area_var = check_area(i);
		if (check_area_var == 1) {
			area.push({area : $(this).val()});
		} else {
			invalid_area_count++;
		}
	});

	$(".pincode").each(function(i) {
		var check_pincode_var = check_pincode(i);
		if (check_pincode_var == 1) {
			pincode.push({pin_code : $(this).val()});
		} else {
			invalid_pincode_count++;
		}
	});

	$(".land-mark").each(function(i) {
		var check_land_mark_var = check_land_mark(i);
		if (check_land_mark_var = 1) {
			land_mark.push({nearest_landmark : $(this).val()});
		} else {
			invalid_land_mark_count++;
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

	$(".duration-of-stay-from-month").each(function(i) {
		var check_duration_of_stay_from_month_var = check_duration_of_stay_from_month(i);
		if (check_duration_of_stay_from_month_var != 1) {
			invalid_duration_of_stay_from_month_count++;
		}
	});

	$(".duration-of-stay-from-year").each(function(i) {
		var check_duration_of_stay_from_year_var = check_duration_of_stay_from_year(i);
		if (check_duration_of_stay_from_year_var == 1) {
			from_date.push({duration_of_stay_start : $(this).val()+'-'+$('#duration-of-stay-from-month-'+i).val()+'-00'});
		} else {
			invalid_duration_of_stay_from_year_count++;
		}
	});

	$(".duration-of-stay-to-month").each(function(i) {
		var check_duration_of_stay_to_month_var = check_duration_of_stay_to_month(i);
		if (check_duration_of_stay_to_month_var != 1) {
			invalid_duration_of_stay_to_month_count++;
		}
	});

	$(".duration-of-stay-to-year").each(function(i) {
		var check_duration_of_stay_to_year_var = check_duration_of_stay_to_year(i);
		if (check_duration_of_stay_to_year_var == 1) {
			to_date.push({duration_of_stay_end : $(this).val()+'-'+$('#duration-of-stay-to-month-'+i).val()+'-00'});
		} else {
			invalid_duration_of_stay_to_year_count++;
		}
	});

	$(".contact-person-name").each(function(i) {
		var check_contact_person_name_var = check_contact_person_name(i);
		if (check_contact_person_name_var == 1) {
			contact_person_name.push({contact_person_name : $(this).val()});
		} else {
			invalid_contact_person_name_count++;
		}
	});

	$(".relationship").each(function(i) {
		var check_relationship_var = check_relationship(i);
		if (check_relationship_var == 1) {
			relationship.push({contact_person_relationship : $(this).val()});
		} else {
			invalid_relationship_count++;
		}
	});

	$(".code").each(function(i) {
		code.push({code : $(this).val()});
	});

	$(".contact-no").each(function(i) {
		var check_contact_person_contact_no_var = check_contact_person_contact_no(i);
		if (check_contact_person_contact_no_var == 1) {
			contact_no.push({contact_person_mobile_number : $(this).val()});
		} else {
			invalid_contact_no_count++;
		}
	});

	if(invalid_house_flat_count == 0 && invalid_street_var_count == 0 && invalid_area_count == 0 && invalid_pincode_count == 0 && invalid_land_mark_count == 0 && invalid_country_count == 0 && invalid_state_count == 0 && invalid_city_count == 0 && invalid_duration_of_stay_from_month_count == 0
		&& invalid_duration_of_stay_from_year_count == 0 && invalid_duration_of_stay_to_month_count == 0 && invalid_duration_of_stay_to_year_count == 0 && invalid_contact_person_name_count == 0 && invalid_relationship_count == 0 && invalid_contact_no_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',12);
		formdata.append('permenent_house',JSON.stringify(house_flat));
		formdata.append('permenent_street',JSON.stringify(street_var));
		formdata.append('permenent_area',JSON.stringify(area));
		formdata.append('permenent_city',JSON.stringify(city));
		formdata.append('permenent_pincode',JSON.stringify(pincode));
		formdata.append('permenent_land_mark',JSON.stringify(land_mark));
		formdata.append('permenent_start_date',JSON.stringify(from_date));
		formdata.append('permenent_end_date',JSON.stringify(to_date));
		formdata.append('permenent_present',JSON.stringify($("#permenent-customCheck1:checked").val()));
		formdata.append('permenent_name',JSON.stringify(contact_person_name));
		formdata.append('permenent_relationship',JSON.stringify(relationship));
		formdata.append('permenent_contact_no',JSON.stringify(contact_no));
		formdata.append('state',JSON.stringify(state));
		formdata.append('country',JSON.stringify(country));
		formdata.append('code',JSON.stringify(code));
		formdata.append('previos_address_id',$("#previos_address_id").val());
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-previous-address-1-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-previous-address-2';
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