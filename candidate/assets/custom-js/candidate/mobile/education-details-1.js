var university_name_max_length = 100,
	college_name_max_length = 100,
	major_name_max_length = 100,
	registration_or_role_no_max_length = 20,
	list_of_education_to_not_be_included_in_major = ['10th'];

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_major(id) {
	var variable_array = {};
	variable_array['input_id'] = '#major-'+id;
	variable_array['error_msg_div_id'] = '#major-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the '+$("#major-"+id).data('major_name')+' name';
	variable_array['max_length'] = major_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = $("#major-"+id).data('major_name')+' name should be of max '+university_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_university_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#university-'+id;
	variable_array['error_msg_div_id'] = '#university-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the '+$("#university-"+id).data('board_or_university')+' name';
	variable_array['max_length'] = university_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = $("#university-"+id).data('board_or_university')+' name should be of max '+university_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_college_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#college-name-'+id;
	variable_array['error_msg_div_id'] = '#college-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the '+$("#college-name-"+id).data('school_or_college')+' name';
	variable_array['max_length'] = college_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = $("#college-name-"+id).data('school_or_college')+' name should be of max '+college_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_address(id) {
	var variable_array = {};
	variable_array['input_id'] = '#address-'+id;
	variable_array['error_msg_div_id'] = '#address-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter a valid address.';
	return mandatory_any_input_with_no_limitation(variable_array);
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

function check_registration_roll_number(id) {
	var variable_array = {};
	variable_array['input_id'] = '#registration-roll-number-'+id;
	variable_array['error_msg_div_id'] = '#registration-roll-number-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the registration or role number';
	variable_array['max_length'] = registration_or_role_no_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Registration or role number should be of max '+registration_or_role_no_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function save_details() {
	var type_of_degree = [],
		major = [],
		university_name = [],
		college_name = [],
		address = [],
		from_date = [],
		to_date = [],
		part_or_full_time = [],
		registration_roll_number = [],
 		invalid_type_of_degree_count = 0,
 		invalid_major_count = 0,
 		invalid_university_name_count = 0,
 		invalid_college_name_count = 0,
 		invalid_address_count = 0,
 		invalid_duration_of_stay_from_month_count = 0,
 		invalid_duration_of_stay_from_year_count = 0,
 		invalid_duration_of_stay_to_month_count = 0,
 		invalid_duration_of_stay_to_year_count = 0,
 		invalid_part_or_full_time_count = 0,
 		invalid_registration_roll_number_count = 0;

 	$('.type-of-degree').each(function(i) {
		if ($('#type-of-degree-'+i).val() != '') {
			type_of_degree.push({type_of_degree : $('#type-of-degree-'+i).val()});
		} else {
			type_of_degree.push({type_of_degree : '-'});
		}
	});

	$('.major').each(function(i) {
		var check_major_var = check_major(i);
		if (check_major_var == 1) {
			major.push({major : $('#major-'+i).val()});
		} else {
			invalid_major_count++;
		}
	});

	$('.university').each(function(i) {
		var check_university_name_var = check_university_name(i);
		if (check_university_name_var == 1) {
			university_name.push({university_board : $('#university-'+i).val()});
		} else {
			invalid_university_name_count++;
		}
	});

	$('.college-name').each(function(i) {
		var check_college_name_var = check_college_name(i);
		if (check_college_name_var == 1) {
			college_name.push({college_school : $('#college-name-'+i).val()});
		} else {
			invalid_college_name_count++;
		}
	});

	$('.address').each(function(i) {
		var check_address_var = check_address(i);
		if (check_address_var == 1) {
			address.push({address_of_college_school : $('#address-'+i).val()});
		} else {
			invalid_address_count++;
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
			from_date.push({course_start_date : $(this).val()+'-'+$('#duration-of-stay-from-month-'+i).val()+'-00'});
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
			to_date.push({course_end_date : $(this).val()+'-'+$('#duration-of-stay-to-month-'+i).val()+'-00'});
		} else {
			invalid_duration_of_stay_to_year_count++;
		}
	});

	$('.part-or-full-time:checked').each(function(i) {
		part_or_full_time.push({type_of_course:$(this).val()});
	});

	$('.registration-roll-number').each(function(i) {
		var check_registration_roll_number_var = check_registration_roll_number(i);
		if (check_registration_roll_number_var == 1) {
			registration_roll_number.push({registration_roll_number : $('#registration-roll-number-'+i).val()});
		} else {
			invalid_registration_roll_number_count++;
		}
	});

	if (invalid_major_count == 0 && invalid_university_name_count == 0 && invalid_college_name_count == 0 && invalid_address_count == 0 && invalid_duration_of_stay_from_month_count == 0
		&& invalid_duration_of_stay_from_year_count == 0 && invalid_duration_of_stay_to_month_count == 0 && invalid_duration_of_stay_to_year_count == 0 && invalid_registration_roll_number_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		var formdata = new FormData();
		formdata.append('url',7);
		formdata.append('verify_candidate_request',1);
		formdata.append('time',JSON.stringify(part_or_full_time));
		formdata.append('type_of_degree',JSON.stringify(type_of_degree));
		formdata.append('major',JSON.stringify(major));
		formdata.append('university',JSON.stringify(university_name));
		formdata.append('college_name',JSON.stringify(college_name));
		formdata.append('address',JSON.stringify(address));
		formdata.append('duration_of_course',JSON.stringify(to_date));
		formdata.append('registration_roll_number',JSON.stringify(registration_roll_number));
		formdata.append('duration_of_stay',JSON.stringify(from_date));

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-education-1-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-education-2';
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