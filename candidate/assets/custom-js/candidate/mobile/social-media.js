var company_name_max_length = 100,
	highest_education_college_name_max_length = 150,
	university_name_max_length = 150,
	social_media_max_length = 150;

$('#latest-employement-company-name').on('keyup blur', function() {
	check_latest_employement_company_name();
});

$('#highest-education-college-name').on('keyup blur', function() {
	check_highest_education_college_name();
});

$('#university-name').on('keyup blur', function() {
	check_university_name();
});

$('#social-media').on('keyup blur', function() {
	check_social_media();
});

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_latest_employement_company_name() {
	var variable_array = {};
	variable_array['input_id'] = '#latest-employement-company-name';
	variable_array['error_msg_div_id'] = '#latest-employement-company-name-error';
	variable_array['empty_input_error_msg'] = '';
	variable_array['max_length'] = company_name_max_length;
	variable_array['exceeding_max_length_input_error_msg'] = 'Company name should be of max '+company_name_max_length+' characters';
	return not_mandatory_any_input_with_max_length_validation(variable_array);
}

function check_highest_education_college_name() {
	var variable_array = {};
	variable_array['input_id'] = '#highest-education-college-name';
	variable_array['error_msg_div_id'] = '#highest-education-college-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter the college name';
	variable_array['max_length'] = highest_education_college_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Company name should be of max '+highest_education_college_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_university_name() {
	var variable_array = {};
	variable_array['input_id'] = '#university-name';
	variable_array['error_msg_div_id'] = '#university-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter the university name';
	variable_array['max_length'] = university_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Company name should be of max '+university_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_social_media() {
	var variable_array = {};
	variable_array['input_id'] = '#social-media';
	variable_array['error_msg_div_id'] = '#social-media-error';
	variable_array['empty_input_error_msg'] = '';
	variable_array['max_length'] = social_media_max_length;
	variable_array['exceeding_max_length_input_error_msg'] = 'Social media should be of max '+social_media_max_length+' characters';
	return not_mandatory_any_input_with_max_length_validation(variable_array);
}

function save_details() {
	var check_latest_employement_company_name_var = check_latest_employement_company_name(),
		check_highest_education_college_name_var = check_highest_education_college_name(),
		check_university_name_var = check_university_name(),
		check_social_media_var = check_social_media();

	if (check_latest_employement_company_name_var == 1 && check_highest_education_college_name_var == 1 && check_university_name_var == 1 && check_social_media_var == 1) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',25);
	 	formdata.append('employee_company',$('#latest-employement-company-name').val());
		formdata.append('education',$('#highest-education-college-name').val());
		formdata.append('university',$('#university-name').val());
		formdata.append('social_media',$('#social-media').val());
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-social-media-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-component-list';
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