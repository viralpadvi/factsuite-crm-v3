var designation_max_length = 80,
	department_max_length = 80,
	employee_id_max_length = 50,
	company_name_max_length = 80,
	annual_ctc_max_length = 10,
	reason_for_leaving_error_max_length = 200,
	reporting_manager_name_max_length = 40,
	reporting_manager_designation_max_length = 40,
	reporting_manager_contact_length = 10,
	hr_name_max_length = 40,
	hr_contact_length = 10;

$('#designation').on('keyup blur', function() {
	check_designation();	
});

$('#department').on('keyup blur', function() {
	check_department();	
});

$('#employee_id').on('keyup blur', function() {
	check_employee_id();	
});

$('#company-name').on('keyup blur', function() {
	check_company_name();	
});

$('#annual-ctc').on('keyup blur', function() {
	check_annual_ctc();	
});

$('#reason-for-leaving').on('keyup blur', function() {
	check_reason_for_leaving();	
});

$('#joining-date').on('keyup blur change', function() {
	check_joining_date();	
});

$('#relieving-date').on('keyup blur change', function() {
	check_relieving_date();	
});

$('#reporting-manager-name').on('keyup blur', function() {
	check_reporting_manager_name();	
});

$('#reporting-manager-designation').on('keyup blur', function() {
	check_reporting_manager_designation();	
});

$('#reporting-manager-contact').on('keyup blur', function() {
	check_reporting_manager_contact();	
});

$('#reporting-manager-email-id').on('keyup blur', function() {
	check_reporting_manager_email_id();	
});

$('#hr-name').on('keyup blur', function() {
	check_hr_name();	
});

$('#hr-contact').on('keyup blur', function() {
	check_hr_contact();	
});

$('#hr-email-id').on('keyup blur', function() {
	check_hr_email_id();	
});

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_designation() {
	var variable_array = {};
	variable_array['input_id'] = '#designation';
	variable_array['error_msg_div_id'] = '#designation-error';
	variable_array['empty_input_error_msg'] = 'Please enter the designation';
	variable_array['max_length'] = designation_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Designation should be of max '+designation_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_department() {
	var variable_array = {};
	variable_array['input_id'] = '#department';
	variable_array['error_msg_div_id'] = '#department-error';
	variable_array['empty_input_error_msg'] = 'Please enter the department';
	variable_array['max_length'] = department_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Department should be of max '+department_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_employee_id() {
	var variable_array = {};
	variable_array['input_id'] = '#employee_id';
	variable_array['error_msg_div_id'] = '#employee_id-error';
	variable_array['empty_input_error_msg'] = 'Please enter the employee ID';
	variable_array['max_length'] = employee_id_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Employee ID should be of max '+employee_id_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_company_name() {
	var variable_array = {};
	variable_array['input_id'] = '#company-name';
	variable_array['error_msg_div_id'] = '#company-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter the company name';
	variable_array['max_length'] = company_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Company name should be of max '+company_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_annual_ctc() {
	var variable_array = {};
	variable_array['input_id'] = '#annual-ctc';
	variable_array['error_msg_div_id'] = '#annual-ctc-error';
	variable_array['empty_input_error_msg'] = 'Please enter the annual CTC';
	variable_array['not_a_number_input_error_msg'] = 'Annual CTC should be only in numbers.';
	variable_array['exceeding_max_length_input_error_msg'] = 'Annual CTC should be of max '+annual_ctc_max_length+' digits';
	variable_array['max_length'] = annual_ctc_max_length;
	variable_array['no_error_msg'] = '';
	return only_number_with_max_length_limitation(variable_array);
}

function check_reason_for_leaving() {
	var variable_array = {};
	variable_array['input_id'] = '#reason-for-leaving';
	variable_array['error_msg_div_id'] = '#reason-for-leaving-error';
	variable_array['empty_input_error_msg'] = 'Please enter the reason for leaving';
	variable_array['max_length'] = reason_for_leaving_error_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Reason for leaving should be of max '+reason_for_leaving_error_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_joining_date() {
	var variable_array = {};
	variable_array['input_id'] = '#joining-date';
	variable_array['error_msg_div_id'] = '#joining-date-error';
	variable_array['empty_input_error_msg'] = 'Please select the joining date';
	var return_result = mandatory_any_input_with_no_limitation(variable_array);
	if (return_result == 1) {
		$("#relieving-date").attr('disabled',false);
	}
	return return_result;
}

function check_relieving_date() {
	var variable_array = {};
	variable_array['input_id'] = '#relieving-date';
	variable_array['error_msg_div_id'] = '#relieving-date-error';
	variable_array['empty_input_error_msg'] = 'Please select the relieving date';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_reporting_manager_name() {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-name';
	variable_array['error_msg_div_id'] = '#reporting-manager-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter reporting manager name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Reporting manager name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Reporting manager name should be of max '+reporting_manager_name_max_length+' characters';
	variable_array['max_length'] = reporting_manager_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_reporting_manager_designation() {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-designation';
	variable_array['error_msg_div_id'] = '#reporting-manager-designation-error';
	variable_array['empty_input_error_msg'] = 'Please enter the reporting manager designation';
	variable_array['max_length'] = reporting_manager_designation_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Designation should be of max '+reporting_manager_designation_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_reporting_manager_contact() {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-contact';
	variable_array['error_msg_div_id'] = '#reporting-manager-contact-error';
	variable_array['empty_input_error_msg'] = 'Please enter the reporting manager contact number';
	variable_array['not_a_number_input_error_msg'] = 'Reporting manager contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Reporting manager contact number should be of '+reporting_manager_contact_length+' digits';
	variable_array['max_length'] = reporting_manager_contact_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_reporting_manager_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-email-id';
	variable_array['error_msg_div_id'] = '#reporting-manager-email-id-error';
	variable_array['empty_input_error_msg'] = 'Please enter reporting manager email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function check_hr_name() {
	var variable_array = {};
	variable_array['input_id'] = '#hr-name';
	variable_array['error_msg_div_id'] = '#hr-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter HR name';
	variable_array['not_an_alphabet_input_error_msg'] = 'HR name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'HR name should be of max '+hr_name_max_length+' characters';
	variable_array['max_length'] = hr_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_hr_contact() {
	var variable_array = {};
	variable_array['input_id'] = '#hr-contact';
	variable_array['error_msg_div_id'] = '#hr-contact-error';
	variable_array['empty_input_error_msg'] = 'Please enter the HR contact number';
	variable_array['not_a_number_input_error_msg'] = 'HR contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'HR contact number should be of '+hr_contact_length+' digits';
	variable_array['max_length'] = hr_contact_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_hr_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#hr-email-id';
	variable_array['error_msg_div_id'] = '#hr-email-id-error';
	variable_array['empty_input_error_msg'] = 'Please enter HR manager email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function save_details() {
	var check_designation_var = check_designation(),
		check_department_var = check_department(),
		check_employee_id_var = check_employee_id(),
		check_company_name_var = check_company_name(),
		check_annual_ctc_var = check_annual_ctc(),
		check_reason_for_leaving_var = check_reason_for_leaving(),
		check_joining_date_var = check_joining_date(),
		check_relieving_date_var = check_relieving_date(),
		check_reporting_manager_name_var = check_reporting_manager_name(),
		check_reporting_manager_designation_var = check_reporting_manager_designation(),
		check_reporting_manager_contact_var = check_reporting_manager_contact(),
		check_reporting_manager_email_id_var = check_reporting_manager_email_id(),
		check_hr_name_var = check_hr_name(),
		check_hr_contact_var = check_hr_contact(),
		check_hr_email_id_var = check_hr_email_id();

	if (check_designation_var == 1 && check_department_var == 1 && check_employee_id_var == 1 && check_company_name_var == 1 && check_annual_ctc_var == 1 && check_reason_for_leaving_var == 1 && check_joining_date_var == 1 && check_relieving_date_var == 1 && check_reporting_manager_name_var == 1 && check_reporting_manager_designation_var == 1 && check_reporting_manager_contact_var == 1 && check_reporting_manager_email_id_var == 1 && check_hr_name_var == 1 && check_hr_contact_var == 1 && check_hr_email_id_var == 1) {
		var formdata = new FormData();
		formdata.append('verify_candidate_request',1);
		formdata.append('designation',$('#designation').val());
		formdata.append('department',$('#department').val());
		formdata.append('employee_id',$('#employee_id').val());
		formdata.append('company_name',$('#company-name').val());
		formdata.append('address',$('#address').val());
		formdata.append('annual_ctc',$('#annual-ctc').val());
		formdata.append('reason_for_leaving',$('#reason-for-leaving').val());
		formdata.append('joining_date',$('#joining-date').val());
		formdata.append('relieving_date',$('#relieving-date').val());
		formdata.append('reporting_manager_name',$('#reporting-manager-name').val());
		formdata.append('reporting_manager_designation',$('#reporting-manager-designation').val());
		formdata.append('reporting_manager_contact_code',$('#reporting-manager-contact-code').val());
		formdata.append('reporting_manager_contact',$('#reporting-manager-contact').val());
		formdata.append('reporting_manager_email_id',$('#reporting-manager-email-id').val());
		formdata.append('hr_name',$('#hr-name').val());
		formdata.append('hr_contact_code',$('#hr-contact-code').val());
		formdata.append('hr_contact',$('#hr-contact').val());
		formdata.append('hr_email_id',$('#hr-email-id').val());
		formdata.append('company_url',$('#company_url').val());

		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-current-employment-1-details",
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
              	$("#save-data-error-msg").html('');
				if (data.status == '1') {
					if(data.candidate_details.status == 1) {
						window.location.href = base_url+'m-current-employment-2';
					} else {
						toastr.error('Something went wrong while saving the data. Please try again.'); 		
					}
              	} else {
              		toastr.error('Something went wrong while saving the data. Please try again.');
              	}
              	$("#save-details-btn").html('Save &amp; Continue');
            },
            error: function(data) {
            	toastr.error('Something went wrong while saving the data. Please try again.');
         		$("#save-data-error-msg").html('');
         		$("#save-details-btn").html('Save &amp; Continue');
      		}
        });
	}
}