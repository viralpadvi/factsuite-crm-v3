var candidate_first_name_max_length = 50,
	candidate_last_name_max_length = 50,
	candidate_father_name_max_length = 100,
	pincode_length = 6;

$("#title").on('change',function() {
	valid_title();
});

$('#first-name').on('keyup blur',function() {
	valid_first_name();
});

$('#last-name').on('keyup blur',function() {
	valid_last_name();
});

$('#father-name').on('keyup blur',function() {
	valid_father_name();
});

$('#email-id').on('keyup blur',function() {
	valid_email_id();
});

$("#date-of-birth").on('keyup keydown input blur change',function() {
	valid_birth_date();
});

$("#nationality").on('change',function() {
	valid_nationality();
});

$('#pincode').on('keyup blur',function() {
	valid_pincode();
});

$('#save-details-btn').on('click', function() {
	save_details();
});

function valid_title() {
	var variable_array = {};
	variable_array['input_id'] = '#title';
	variable_array['error_msg_div_id'] = '#title-error';
	variable_array['empty_input_error_msg'] = 'Please select a title.';
	return mandatory_select(variable_array);
}

function valid_first_name() {
	var variable_array = {};
	variable_array['input_id'] = '#first-name';
	variable_array['error_msg_div_id'] = '#first-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter candidate first name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_first_name_max_length+' characters';
	variable_array['max_length'] = candidate_first_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function valid_last_name() {
	var variable_array = {};
	variable_array['input_id'] = '#last-name';
	variable_array['error_msg_div_id'] = '#last-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter candidate last name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_last_name_max_length+' characters';
	variable_array['max_length'] = candidate_last_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function valid_father_name() {
	var variable_array = {};
	variable_array['input_id'] = '#father-name';
	variable_array['error_msg_div_id'] = '#father-name-error';
	variable_array['empty_input_error_msg'] = 'Please enter candidate father\'s name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_father_name_max_length+' characters';
	variable_array['max_length'] = candidate_father_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function valid_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#email-id';
	variable_array['error_msg_div_id'] = '#email-id-error';
	variable_array['empty_input_error_msg'] = 'Please enter candidate email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	variable_array['duplicate_email_id_error_msg'] = 'Entered email id already exists. Please enter a new email id.';
	variable_array['ajax_call_url'] = 'factsuite-candidate/check-candidate-email-id';
	variable_array['ajax_pass_data'] = {verify_candidate_request : '1',email : $('#email-id').val().toLowerCase()};
	return mandatory_email_id_with_check_duplication(variable_array);
}

function valid_birth_date() {
	var variable_array = {};
	variable_array['input_id'] = '#date-of-birth';
	variable_array['error_msg_div_id'] = '#date-of-birth-error';
	variable_array['empty_input_error_msg'] = 'Please enter your birth date.';
	return not_mandatory_any_input_with_no_limitation(variable_array);
}

function valid_nationality() {
	var variable_array = {};
	variable_array['input_id'] = '#nationality';
	variable_array['error_msg_div_id'] = '#nationality-error';
	variable_array['empty_input_error_msg'] = 'Please select your nationality.';
	return not_mandatory_select(variable_array);
}

function valid_pincode() {
	var variable_array = {};
	variable_array['input_id'] = '#pincode';
	variable_array['error_msg_div_id'] = '#pincode-error';
	variable_array['empty_input_error_msg'] = 'Please enter the pincode';
	variable_array['not_a_number_input_error_msg'] = 'Pincode should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Pincode should be of '+pincode_length+' digits';
	variable_array['max_length'] = pincode_length;
	return not_mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function save_details() {
	var title = $("#title").val(),
		first_name = $('#first-name').val(),
		last_name = $('#last-name').val(),
		father_name = $('#father-name').val(),
		email_id = $('#email-id').val(),
		date_of_birth = $("#date-of-birth").val(),
		house_flat = $('#house-flat').val(),
		street = $('#street').val(),
		area = $('#area').val(),
		state = $('#state').val(),
		city = $('#city').val(),
		pincode = $('#pincode').val(),
		nationality = $("#nationality").val(),
		gender = $("[name='gender']:checked").val(),
		marital = $("[name='marital-status']:checked").val(),
		/*timepicker = $("#timepicker").val(),
		timepicker2 = $("#timepicker2").val(),*/
		week = [];

		var timepicker = $('#start-hour').val()+':'+$('#start-minute').val()+':'+$('#start-type').val(); //$('#timepicker').val();
	var timepicker2 = $('#end-hour').val()+':'+$('#end-minute').val()+':'+$('#end-type').val(); //$('#timepicker2').val(); 


		$('.weeks:checked').each(function() {
			week.push($(this).val());
		});

	var valid_title_var = valid_title(),
		valid_first_name_var = valid_first_name(),
		valid_last_name_var = valid_last_name(),
		valid_father_name_var = valid_father_name(),
		valid_email_id_var = valid_email_id(),
		valid_birth_date_var = valid_birth_date(),
		valid_nationality_var = valid_nationality(),
		valid_pincode_var = valid_pincode();

	if(valid_title_var == 1 && valid_first_name_var == 1 && valid_last_name_var == 1 && valid_father_name_var == 1 && valid_email_id_var == 1 && valid_birth_date_var == 1 && valid_nationality_var == 1 && valid_pincode_var == 1) {
		var formdata = new FormData();
		formdata.append('url',0);
		formdata.append('verify_candidate_request',1);
		formdata.append('title',title);
		formdata.append('first_name',first_name);
		formdata.append('last_name',last_name);
		formdata.append('father_name',father_name);
		formdata.append('email_id',email_id);
		formdata.append('date_of_birth',date_of_birth);
		formdata.append('nationality',nationality);
		formdata.append('gender',gender);
		formdata.append('marital',marital);
		formdata.append('timepicker',timepicker);
		formdata.append('timepicker2',timepicker2);
		formdata.append('preference_week',week);
		formdata.append('house_flat',house_flat);
		formdata.append('street',street);
		formdata.append('area',area);
		formdata.append('state',state);
		formdata.append('city',city);
		formdata.append('pincode',pincode);

		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-candidate-1-details",
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
              	$("#save-data-error-msg").html('');
				if (data.status == '1') {
					if(data.candidate_details.status == 1) {
						window.location.href = base_url+'m-component-list';
					} else {
						toastr.error('Something went wrong while saving the data. Please try again.'); 		
					}
              	} else if(data.status == '2') {
              		valid_email_id();
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