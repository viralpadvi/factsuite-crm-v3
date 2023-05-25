var contact_number_length = 10;

$('#add-drug-test-btn').on('click', function() {
	save_data();
});

function valid_address(i) {
	var variable_array = {};
	variable_array['input_id'] = '#address'+i;
	variable_array['error_msg_div_id'] = '#address-error'+i;
	variable_array['empty_input_error_msg'] = 'Please enter your address.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function valid_country_code(i) {
	var variable_array = {};
	variable_array['input_id'] = '#code'+i;
	variable_array['error_msg_div_id'] = '#country-code-error'+i;
	variable_array['empty_input_error_msg'] = 'Please select a country code.';
	return mandatory_select(variable_array);
}

function valid_contact_number(i) {
	var variable_array = {};
	variable_array['input_id'] = '#contact_number'+i;
	variable_array['error_msg_div_id'] = '#contact_number-error'+i;
	variable_array['empty_input_error_msg'] = 'Please enter the contact number';
	variable_array['not_a_number_input_error_msg'] = 'Contact number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Contact number should be of '+contact_number_length+' digits';
	variable_array['max_length'] = contact_number_length;
	return not_mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function save_data() {
	var address = [],
		code = [],
		contact_number = [],
		name = [],
		date_of_birth = [],
		father_name = [],
		drug_count = 0,
		incorrect_address_count = 0,
		incorrect_code_count = 0,
		incorrect_contact_number_count = 0;

	$(".address").each(function(i) {
		drug_count++;
		var valid_address_var = valid_address(i);
		if (valid_address_var == 1) {
			address.push({address:$(this).val()});
		} else {
			incorrect_address_count++;
		}
	});

	$(".code").each(function(i) {
		var valid_country_code_var = valid_country_code(i);
		if (valid_country_code_var == 1) {
			code.push({code:$(this).val()});
		} else {
			incorrect_code_count++;
		}
	});

	$(".contact_number").each(function(i) {
		var valid_contact_number_var = valid_contact_number(i);
		if (valid_contact_number_var == 1) {
			contact_number.push({mobile_number:$(this).val()});
		} else {
			incorrect_contact_number_count++;
		}
	});

	$(".name").each(function() {
		if ($(this).val() !='' && $(this).val() !=null) {
			name.push({candidate_name:$(this).val()});
		}
	});

	$(".mdate").each(function() {
		if ($(this).val() !='' && $(this).val() !=null) {
			date_of_birth.push({dob:$(this).val()});
		}
	});

	$(".father_name").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
			father_name.push({father_name:$(this).val()});
		}
	});

	if (incorrect_address_count == 0 && incorrect_code_count == 0 && incorrect_contact_number_count == 0) {
		var drugtest_id = $('#drugtest_id').val();
		var formdata = new FormData();
		formdata.append('url',4);
		formdata.append('address',JSON.stringify(address));
		formdata.append('name',JSON.stringify(name));
		formdata.append('father_name',JSON.stringify(father_name));
		formdata.append('date_of_birth',JSON.stringify(date_of_birth)); 
		formdata.append('contact_no',JSON.stringify(contact_number)); 
		formdata.append('code',JSON.stringify(code)); 

		if (drugtest_id !='' && drugtest_id !=null) {
			formdata.append('drugtest_id',drugtest_id);
		}

		$("#save-data-error-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	  	$("#add-drug-test-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$.ajax({
            type: "POST",
            url: base_url+"candidate/update_candidate_drug_test",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
				if (data.status == '1') {
					// toastr.success('successfully saved data.'); 
					window.location.href=base_url+'m-component-list'; 
              	} else {
              		toastr.error('Something went wrong while saving the data. Please try again.'); 	
              	}
              	$("#save-data-error-msg").html('');
				$("#add-drug-test-btn").html('Save & Continue');
            }
        });
	} else {
		$('#save-data-error-msg').html("<span class='text-danger error-msg-small'>Please fill all the necessary details.</span>")
	}
}