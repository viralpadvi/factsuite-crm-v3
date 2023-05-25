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

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_designation(id) {
	var variable_array = {};
	variable_array['input_id'] = '#designation'+id;
	variable_array['error_msg_div_id'] = '#designation-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the designation';
	variable_array['max_length'] = designation_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Designation should be of max '+designation_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_department(id) {
	var variable_array = {};
	variable_array['input_id'] = '#department'+id;
	variable_array['error_msg_div_id'] = '#department-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the department';
	variable_array['max_length'] = department_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Department should be of max '+department_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_employee_id(id) {
	var variable_array = {};
	variable_array['input_id'] = '#employee_id'+id;
	variable_array['error_msg_div_id'] = '#employee_id-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the employee ID';
	variable_array['max_length'] = employee_id_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Employee ID should be of max '+employee_id_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_company_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#company-name'+id;
	variable_array['error_msg_div_id'] = '#company-name-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the company name';
	variable_array['max_length'] = company_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Company name should be of max '+company_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_address(id) {
	var variable_array = {};
	variable_array['input_id'] = '#address'+id;
	variable_array['error_msg_div_id'] = '#address-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter valid address.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_annual_ctc(id) {
	var variable_array = {};
	variable_array['input_id'] = '#annual-ctc'+id;
	variable_array['error_msg_div_id'] = '#annual-ctc-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the annual CTC';
	variable_array['not_a_number_input_error_msg'] = 'Annual CTC should be only in numbers.';
	variable_array['exceeding_max_length_input_error_msg'] = 'Annual CTC should be of max '+annual_ctc_max_length+' digits';
	variable_array['max_length'] = annual_ctc_max_length;
	variable_array['no_error_msg'] = '';
	return only_number_with_max_length_limitation(variable_array);
}

function check_reason_of_leaving(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reason-for-leaving'+id;
	variable_array['error_msg_div_id'] = '#reason-for-leaving-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the reason for leaving';
	variable_array['max_length'] = reason_for_leaving_error_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Reason for leaving should be of max '+reason_for_leaving_error_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_joining_date(id,request_from = '') {
	var variable_array = {};
	variable_array['input_id'] = '#joining-date-'+id;
	variable_array['error_msg_div_id'] = '#joining-date-error'+id;
	variable_array['empty_input_error_msg'] = 'Please select the joining date';
	var return_result = mandatory_any_input_with_no_limitation(variable_array);
	if (return_result == 1) {
		if (request_from != 'form-filling') {
			$("#relieving-date-"+id).val('');
			$("#relieving-date-"+id).attr('disabled',false);
		}
	}
	return return_result;
}

function check_relieving_date(id) {
	var variable_array = {};
	variable_array['input_id'] = '#relieving-date-'+id;
	variable_array['error_msg_div_id'] = '#relieving-date-error'+id;
	variable_array['empty_input_error_msg'] = 'Please select the relieving date';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_reporting_manager_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-name'+id;
	variable_array['error_msg_div_id'] = '#reporting-manager-name-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter reporting manager name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Reporting manager name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Reporting manager name should be of max '+reporting_manager_name_max_length+' characters';
	variable_array['max_length'] = reporting_manager_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_reporting_manager_designation(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-designation'+id;
	variable_array['error_msg_div_id'] = '#reporting-manager-designation-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the reporting manager designation';
	variable_array['max_length'] = reporting_manager_designation_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Designation should be of max '+reporting_manager_designation_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_reporting_manager_contact(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-contact'+id;
	variable_array['error_msg_div_id'] = '#reporting-manager-contact-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the reporting manager contact number';
	variable_array['not_a_number_input_error_msg'] = 'Reporting manager contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Reporting manager contact number should be of '+reporting_manager_contact_length+' digits';
	variable_array['max_length'] = reporting_manager_contact_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_reporting_manager_email_id(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-email-id'+id;
	variable_array['error_msg_div_id'] = '#reporting-manager-email-id-error'+id;
	variable_array['empty_input_error_msg'] = '';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return not_mandatory_email_id(variable_array);
}

function check_hr_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#hr-name'+id;
	variable_array['error_msg_div_id'] = '#hr-name-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter HR name';
	variable_array['not_an_alphabet_input_error_msg'] = 'HR name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'HR name should be of max '+hr_name_max_length+' characters';
	variable_array['max_length'] = hr_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_hr_contact(id) {
	var variable_array = {};
	variable_array['input_id'] = '#hr-contact'+id;
	variable_array['error_msg_div_id'] = '#hr-contact-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the HR contact number';
	variable_array['not_a_number_input_error_msg'] = 'HR contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'HR contact number should be of '+hr_contact_length+' digits';
	variable_array['max_length'] = hr_contact_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_hr_email_id(id) {
	var variable_array = {};
	variable_array['input_id'] = '#hr-email-id'+id;
	variable_array['error_msg_div_id'] = '#hr-email-id-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter HR manager email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function save_details() {
	var designation = [],
		department = [],
		employee_id = [],
		company_name = [],
		address = [],
		annual_ctc = [],
		reason_of_leaving = [],
		joining_date = [],
		relieving_date = [],
		reporting_manager_name = [],
		reporting_manager_designation = [],
		reporting_manager_contact = [],
		reporting_manager_contact_code = [],
		reporting_manager_email_id = [],
		hr_name = [],
		hr_contact_code = [],
		hr_contact = [],
		hr_email_id = [],
		company_url = [],
 		invalid_designation_count = 0,
 		invalid_department_count = 0,
 		invalid_employee_id_count = 0,
 		invalid_company_name_count = 0,
 		invalid_address_count = 0,
 		invalid_annual_ctc_count = 0,
 		invalid_reason_of_leaving_count = 0,
 		invalid_joining_date_count = 0,
 		invalid_relieving_date_count = 0,
 		invalid_reporting_manager_name_count = 0,
 		invalid_reporting_manager_designation_count = 0,
 		invalid_reporting_manager_contact_count = 0,
 		invalid_reporting_manager_email_id_count = 0,
 		invalid_hr_name_count = 0,
 		invalid_hr_contact_count = 0,
 		invalid_hr_email_id_count = 0;

	$(".designation").each(function(i) {
		var check_designation_var = check_designation(i);
		if (check_designation_var == 1) {
			designation.push({desigination : $(this).val()});
		} else {
			invalid_designation_count++;
		}
	});

	$(".department").each(function(i) {
		var check_department_var = check_department(i);
		if (check_department_var == 1) {
			department.push({department : $(this).val()});
		} else {
			invalid_department_count++;
		}
	});

	$(".employee_id").each(function(i) {
		var check_employee_id_var = check_employee_id(i);
		if (check_employee_id_var == 1) {
			employee_id.push({employee_id : $(this).val()});
		} else {
			invalid_employee_id_count++;
		}
	});

	$(".company-name").each(function(i) {
		var check_company_name_var = check_company_name(i);
		if (check_company_name_var == 1) {
			company_name.push({company_name : $(this).val()});
		} else {
			invalid_company_name_count++;
		}
	});
$(".company_url").each(function(i) {
		 
			company_url.push({company_url : $(this).val()});
	 
	});

	$(".address").each(function(i) {
		var check_address_var = check_address(i);
		if (check_address_var = 1) {
			address.push({address : $(this).val()});
		} else {
			invalid_address_count++;
		}
	});

	$(".annual-ctc").each(function(i) {
		var check_annual_ctc_var = check_annual_ctc(i);
		if (check_annual_ctc_var == 1) {
			annual_ctc.push({annual_ctc : $(this).val()});
		} else {
			invalid_annual_ctc_count++;
		}
	});

	$(".reason-of-leaving").each(function(i) {
		var check_reason_of_leaving_var = check_reason_of_leaving(i);
		if (check_reason_of_leaving_var == 1) {
			reason_of_leaving.push({reason_for_leaving : $(this).val()});
		} else {
			invalid_reason_of_leaving_count++;
		}
	});

	$(".joining-date").each(function(i) {
		var check_joining_date_var = check_joining_date(i,'form-filling');
		if (check_joining_date_var == 1) {
			joining_date.push({joining_date : $(this).val()});
		} else {
			invalid_joining_date_count++;
		}
	});

	$(".relieving-date").each(function(i) {
		var check_relieving_date_var = check_relieving_date(i);
		if (check_relieving_date_var == 1) {
			relieving_date.push({relieving_date : $(this).val()});
		} else {
			invalid_relieving_date_count++;
		}
	});

	$(".reporting-manager-name").each(function(i) {
		var check_reporting_manager_name_var = check_reporting_manager_name(i);
		if (check_reporting_manager_name_var == 1) {
			reporting_manager_name.push({reporting_manager_name : $(this).val()});
		} else {
			invalid_reporting_manager_name_count++;
		}
	});

	$(".reporting-manager-designation").each(function(i) {
		var check_reporting_manager_designation_var = check_reporting_manager_designation(i);
		if (check_reporting_manager_designation_var == 1) {
			reporting_manager_designation.push({reporting_manager_desigination : $(this).val()});
		} else {
			invalid_reporting_manager_designation_count++;
		}
	});

	$(".reporting-manager-contact").each(function(i) {
		var check_reporting_manager_contact_var = check_reporting_manager_contact(i);
		if (check_reporting_manager_contact_var == 1) {
			reporting_manager_contact.push({reporting_manager_contact_number : $(this).val()});
		} else {
			invalid_reporting_manager_contact_count++;
		}
	});

	$(".reporting-manager-contact-code").each(function(i) {
		reporting_manager_contact_code.push({code : $(this).val()});
	});

	$(".reporting-manager-email-id").each(function(i) {
		var check_reporting_manager_email_id_var = check_reporting_manager_email_id(i);
		if (check_reporting_manager_email_id_var == 1) {
			reporting_manager_email_id.push({reporting_manager_email_id : $(this).val()});
		} else {
			invalid_reporting_manager_email_id_count++;
		}
	});

	$(".hr-name").each(function(i) {
		var check_hr_name_var = check_hr_name(i);
		if (check_hr_name_var == 1) {
			hr_name.push({hr_name : $(this).val()});
		} else {
			invalid_hr_name_count++;
		}
	});

	$(".hr-contact-code").each(function(i) {
		hr_contact_code.push({hr_code : $(this).val()});
	});

	$(".hr-contact").each(function(i) {
		var check_hr_contact_var = check_hr_contact(i);
		if (check_hr_contact_var == 1) {
			hr_contact.push({hr_contact_number : $(this).val()});
		} else {
			invalid_hr_contact_count++;
		}
	});

	$(".hr-email-id").each(function(i) {
		var check_hr_email_id_var = check_hr_email_id(i);
		if (check_hr_email_id_var == 1) {
			hr_email_id.push({hr_email_id : $(this).val()});
		} else {
			invalid_hr_email_id_count++;
		}
	});

	if (invalid_designation_count == 0 && invalid_department_count == 0 && invalid_employee_id_count == 0 && invalid_company_name_count == 0 && invalid_address_count == 0 
		&& invalid_annual_ctc_count == 0 && invalid_reason_of_leaving_count == 0 && invalid_joining_date_count == 0 && invalid_relieving_date_count == 0 && invalid_reporting_manager_name_count == 0 
		&& invalid_reporting_manager_designation_count == 0 && invalid_reporting_manager_contact_count == 0 && invalid_reporting_manager_email_id_count == 0 && invalid_hr_name_count == 0 && invalid_hr_contact_count == 0  && invalid_hr_email_id_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',10);
		formdata.append('designation',JSON.stringify(designation));
		formdata.append('department',JSON.stringify(department));
		formdata.append('employee_id',JSON.stringify(employee_id));
		formdata.append('company_name',JSON.stringify(company_name));
		formdata.append('address',JSON.stringify(address));
		formdata.append('annual_ctc',JSON.stringify(annual_ctc));
		formdata.append('reason_of_leaving',JSON.stringify(reason_of_leaving));
		formdata.append('joining_date',JSON.stringify(joining_date));
		formdata.append('relieving_date',JSON.stringify(relieving_date));
		formdata.append('reporting_manager_name',JSON.stringify(reporting_manager_name));
		formdata.append('reporting_manager_designation',JSON.stringify(reporting_manager_designation));
		formdata.append('reporting_manager_contact_code',JSON.stringify(reporting_manager_contact_code));
		formdata.append('reporting_manager_contact',JSON.stringify(reporting_manager_contact));
		formdata.append('reporting_manager_email_id',JSON.stringify(reporting_manager_email_id));
		formdata.append('hr_name',JSON.stringify(hr_name));
		formdata.append('hr_contact_code',JSON.stringify(hr_contact_code));
		formdata.append('hr_contact',JSON.stringify(hr_contact));
		formdata.append('hr_email_id',JSON.stringify(hr_email_id));
		formdata.append('company_url',JSON.stringify(company_url));
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-previous-employment-1-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					// toastr.success('successfully saved data.');  
					window.location.href = base_url+'m-previous-employment-2';
              	} else {
              		toastr.error('Something went wrong while save this data. Please try again.');
              	}
              	$("#add_employments").html("Save & Continue");
            },
            error: function(data) {
            	toastr.error('Something went wrong while save this data. Please try again.');
            	$("#add_employments").html("Save & Continue");;	
            }
        });
	} else {
		$('#save-data-error-msg').html('<span class="err-msg-small text-danger">Please fill all the necessary details</span>');
	}
}