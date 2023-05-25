var landlord_name_max_length = 100,
	landlord_contact_length = 10;

$('#save-details-btn').on('click', function() {
	save_details();
});

function check_landlord_name(id) {
	var variable_array = {};
	variable_array['input_id'] = '#landlord-name-'+id;
	variable_array['error_msg_div_id'] = '#landlord-name-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter landlord first name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+landlord_name_max_length+' characters';
	variable_array['max_length'] = landlord_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_landlord_contact_no(id) {
	var variable_array = {};
	variable_array['input_id'] = '#landlord-contact-no-'+id;
	variable_array['error_msg_div_id'] = '#landlord-contact-no-error-'+id;
	variable_array['empty_input_error_msg'] = 'Please enter the landlord contact number';
	variable_array['not_a_number_input_error_msg'] = 'Landlord contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Landlord contact number should be of '+landlord_contact_length+' digits';
	variable_array['max_length'] = landlord_contact_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function save_details() {
	var landlord_name = [],
		landlord_contact_no = [],
		invalid_landlord_name_count = 0,
		invalid_landlord_contact_no_count = 0;

	$(".landlord-name").each(function(i) {
		var check_landlord_name_var = check_landlord_name(i);
		if (check_landlord_name_var == 1) {
			landlord_name.push({landlord_name : $(this).val()});
		} else {
			invalid_landlord_name_count++;
		}
	});

	$(".landlord-contact-no").each(function(i) {
		var check_landlord_contact_no_var = check_landlord_contact_no(i);
		if (check_landlord_contact_no_var == 1) {
			landlord_contact_no.push({case_contact_no : $(this).val()});
		} else {
			invalid_landlord_contact_no_count++;
		}
	});

	if(invalid_landlord_name_count == 0 && invalid_landlord_contact_no_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		var formdata = new FormData();
	 	formdata.append('url',12);
		formdata.append('landlord_name',JSON.stringify(landlord_name));
		formdata.append('case_contact_no',JSON.stringify(landlord_contact_no));
		formdata.append('verify_candidate_request',1);

		$.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-landlord-reference-details",
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