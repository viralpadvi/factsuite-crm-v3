var reference_name_max_length = 100,
	company_name_max_length = 100,
	designation_max_length = 80,
	contact_number_length = 10,
	years_of_association_max_length = 3;

$('#save-details-btn').on('click', function() {
	save_details();	
});

function check_reference_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reference-name-'+id;
	variable_array['error_msg_div_id'] = '#reference-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter reference name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+reference_name_max_length+' characters';
	variable_array['max_length'] = reference_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_company_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#company-name-'+id;
	variable_array['error_msg_div_id'] = '#company-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the company name';
	variable_array['max_length'] = company_name_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Company name should be of max '+company_name_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_designation(id) {
	var variable_array = {};
	variable_array['input_id'] = '#designation-'+id;
	variable_array['error_msg_div_id'] = '#designation-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the designation';
	variable_array['max_length'] = designation_max_length;
	variable_array['exceeding_max_length_error_msg'] = 'Designation should be of max '+designation_max_length+' characters';
	return mandatory_any_input_with_max_length_validation(variable_array);
}

function check_contact(id) {
	var variable_array = {};
	variable_array['input_id'] = '#contact-'+id;
	variable_array['error_msg_div_id'] = '#contact-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the contact number';
	variable_array['not_a_number_input_error_msg'] = 'Contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Contact number should be of '+contact_number_length+' digits';
	variable_array['max_length'] = contact_number_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_email(id) {
	var variable_array = {};
	variable_array['input_id'] = '#email-id-'+id;
	variable_array['error_msg_div_id'] = '#email-id-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function check_years_of_association(id) {
	var variable_array = {};
	variable_array['input_id'] = '#association-'+id;
	variable_array['error_msg_div_id'] = '#years-of-association-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the years of association';
	variable_array['not_a_number_input_error_msg'] = 'Years of association should be only in numbers.';
	variable_array['exceeding_max_length_input_error_msg'] = 'Years of association should be of max '+years_of_association_max_length+' digits';
	variable_array['max_length'] = years_of_association_max_length;
	variable_array['no_error_msg'] = '';
	return only_number_with_max_length_limitation(variable_array);
}

function check_start_time(id,request_from = '') {
	var variable_array = {};
	variable_array['input_id'] = '#timepicker-'+id;
	variable_array['error_msg_div_id'] = '#timepicker-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please select the start time';
	var return_result = mandatory_any_input_with_no_limitation(variable_array);
	if (return_result == 1) {
		if (request_from != 'form-filling') {
			$("#timepicker2-"+id).val('');
		}
	}
	return return_result;
}

function check_end_time(id,request_from = '') {
	var variable_array = {};
	variable_array['input_id'] = '#timepicker2-'+id;
	variable_array['error_msg_div_id'] = '#timepicker2-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please select the end time';
	var return_result = mandatory_any_input_with_no_limitation(variable_array);
	if (return_result == 1) {
		if (request_from != 'form-filling') {
			if ($('#timepicker-'+id).val() == $('#timepicker2-'+id).val()) {
				$("#timepicker2-"+id).val('');
				$('#timepicker2-error-'+id).html('<span class="text-danger error-msg-small">Start Time and End Time cannot be same.</span>');
			}
		}
	}

	return return_result;
}

function save_details() {
	var reference_name = [],
		company_name = [],
		designation = [],
		code = [],
		contact_number = [],
		email_id = [],
		years_of_association = [],
		start_time = [],
		end_time = [],
 		invalid_reference_name_count = 0,
 		invalid_company_name_count = 0,
 		invalid_designation_count = 0,
 		invalid_code_count = 0,
 		invalid_contact_number_count = 0,
 		invalid_email_id_count = 0,
 		invalid_years_of_association_count = 0,
 		invalid_start_time_count = 0,
 		invalid_end_time_count = 0;

	$(".reference-name").each(function(i) {
		var check_reference_name_var = check_reference_name(i);
		if (check_reference_name_var == 1) {
			reference_name.push($(this).val());
		} else {
			invalid_reference_name_count++;
		}
	});

	$(".company-name").each(function(i) {
		var check_company_name_var = check_company_name(i);
		if (check_company_name_var == 1) {
			company_name.push($(this).val());
		} else {
			invalid_company_name_count++;
		}
	});

	$(".designation").each(function(i) {
		var check_designation_var = check_designation(i);
		if (check_designation_var == 1) {
			designation.push($(this).val());
		} else {
			invalid_designation_count++;
		}
	});

	$(".code").each(function(i) {
		code.push($(this).val());
	});

	$(".contact").each(function(i) {
		var check_contact_var = check_contact(i);
		if (check_contact_var == 1) {
			contact_number.push($(this).val());
		} else {
			invalid_contact_number_count++;
		}
	});

	$(".email").each(function(i) {
		var check_email_var = check_email(i);
		if (check_email_var == 1) {
			email_id.push($(this).val());
		} else {
			invalid_email_id_count++;
		}
	});

	$(".association").each(function(i) {
		var check_years_of_association_var = check_years_of_association(i);
		if (check_years_of_association_var == 1) {
			years_of_association.push($(this).val());
		} else {
			invalid_years_of_association_count++;
		}
	});

	/*$(".start-time").each(function(i) {
		var check_start_time_var = check_start_time(i,'form-filling');
		if (check_start_time_var == 1) {
			start_time.push($(this).val());
		} else {
			invalid_start_time_count++;
		}
	});

	$(".end-time").each(function(i) {
		var check_end_time_var = check_end_time(i);
		if (check_end_time_var == 1) {
			end_time.push($(this).val());
		} else {
			invalid_end_time_count++;
		}
	});*/

	 var start_date = [];
	 var hour =[], minute=[], type=[];
	 var endhour =[], endminute=[], endtype=[];
	$('.start-hour').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		hour.push($(this).val());
		}
	});	$('.start-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		minute.push($(this).val());
		}
	});	$('.start-type').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		type.push($(this).val());
		}
	});	
	$('.end-hour').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endhour.push($(this).val());
		}
	});	$('.end-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endminute.push($(this).val());
		}
	});	$('.end-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endtype.push($(this).val());
		}
	}); 

	 var end_date = [];

	 for (var i = 0; i < hour.length; i++) {
	 	start_date.push(hour[i]+':'+minute[i]+':'+type[i]);
	 	 end_date.push(endhour[i]+':'+endminute[i]+':'+endtype[i]);
	 }
	/*$('.end-time').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		end_date.push($(this).val());
		}
	});*/

	if (invalid_reference_name_count == 0 && invalid_company_name_count == 0 && invalid_designation_count == 0 && invalid_contact_number_count == 0 && invalid_email_id_count == 0 
		&& invalid_years_of_association_count == 0 ) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',11);
		formdata.append('name',reference_name);
		formdata.append('company_name',company_name);
		formdata.append('designation',designation);
		formdata.append('contact',contact_number);
		formdata.append('email',email_id);
		formdata.append('association',years_of_association);
		formdata.append('start_date',start_date);
		formdata.append('end_date',end_date); 
		formdata.append('code',code);
		var reference_id = $("#reference_id").val();
		if (reference_id !='' && reference_id !=null) {
			formdata.append('reference_id',reference_id);
		}
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-reference-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') { 
					window.location.href = base_url+'m-component-list';
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