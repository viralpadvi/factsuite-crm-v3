var pincode_length = 6;

$('#save-details-btn').on('click', function() {
	save_details();	
});

function valid_address(i) {
	var variable_array = {};
	variable_array['input_id'] = '#address'+i;
	variable_array['error_msg_div_id'] = '#address-error'+i;
	variable_array['empty_input_error_msg'] = 'Please enter your address.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function valid_pincode(i) {
	var variable_array = {};
	variable_array['input_id'] = '#pincode'+i;
	variable_array['error_msg_div_id'] = '#pincode-error'+i;
	variable_array['empty_input_error_msg'] = 'Please enter the pincode';
	variable_array['not_a_number_input_error_msg'] = 'Pincode should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Pincode should be of '+pincode_length+' digits';
	variable_array['max_length'] = pincode_length;
	return not_mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function valid_countries(id, request_from = '') {
	if (request_from != 'update-data') {
		$('#state'+id).html("<option selected value=''>Select State</option>");
		$('#city'+id).html("<option selected value=''>Select City/Town</option>");
	}
	var variable_array = {};
	variable_array['input_id'] = '#country'+id;
	variable_array['error_msg_div_id'] = '#country-error'+id;
	variable_array['empty_input_error_msg'] = 'Please select your country.';
	var return_result = mandatory_select(variable_array);
	
	if(return_result == 1) {
		if (request_from != 'update-data') {
			var c_id = $("#country"+id).children('option:selected').data('id');
			$.ajax({
	      		type: "POST",
	      		url: base_url+"candidate/get_selected_states/"+c_id, 
	      		dataType: 'json', 
	      		success: function(data) {
	     			var html = "<option selected value=''>Select State</option>";
					if (data.length > 0) {
						for (var i = 0; i < data.length; i++) {
							html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
						}
					}
					$("#state"+id).html(html);
	      		}
	   		});
		}
		return 1;
	} else {
		return 0;
	}
}

function valid_state(id, request_from = '') {
	if (request_from != 'update-data') {
		$('#city'+id).html("<option selected value=''>Select City/Town</option>");
	}
	var variable_array = {};
	variable_array['input_id'] = '#state'+id;
	variable_array['error_msg_div_id'] = '#state-error'+id;
	variable_array['empty_input_error_msg'] = 'Please select your state.';
	var return_result = mandatory_select(variable_array);
	
	if(return_result == 1) {
		if (request_from != 'update-data') {
			var c_id = $("#state"+id).children('option:selected').data('id');
			$.ajax({
	      		type: "POST",
	      		url: base_url+"candidate/get_selected_cities/"+c_id, 
	     		dataType: 'json', 
	      		success: function(data) {
	       			var html = "<option selected value=''>Select City/Town</option>";
					if (data.length > 0) {
						for (var i = 0; i < data.length; i++) {
							html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
						}
					}
					$("#city"+id).html(html);
	      		}
	    	});
		}
		return 1;
	} else {
		return 0;
	}
}

function valid_city(id) {
	var variable_array = {};
	variable_array['input_id'] = '#city'+id;
	variable_array['error_msg_div_id'] = '#city-error'+id;
	variable_array['empty_input_error_msg'] = 'Please select your city.';
	return mandatory_select(variable_array);
}

function save_details() {
	var address = [],
		pincode = [],
		city = [],
		state = [],
		country = [],
		criminal_checks_id = $("#criminal_checks_id").val(),
		total_count = 0,
		incomplete_address_count = 0,
		incomplete_pincode_count = 0,
		incomplete_city_count = 0,
		incomplete_state_count = 0,
		incomplete_country_count = 0;

	$(".address").each(function(i) {
		var valid_address_var = valid_address(i);
		if (valid_address_var == 1) {
		 	address.push({address : $(this).val()});
		} else {
			incomplete_address_count++;
		}
	});

	$(".pincode").each(function(i) {
		var valid_pincode_var = valid_pincode(i);
		if (valid_pincode_var == 1) {
		 	pincode.push({pincode : $(this).val()});
		} else {
			incomplete_pincode_count++;
		}
	});

	$(".city").each(function(i) {
		var valid_countries_var = valid_countries(i,'update-data')
		if (valid_countries_var == 1) {
			city.push({city : $(this).val()});
		} else {
			incomplete_city_count++;
		}
	});

	$(".state").each(function(i) {
		var valid_state_var = valid_state(i,'update-data')
		if (valid_state_var == 1) {
			state.push({state : $(this).val()});
		} else {
			incomplete_state_count++;
		}
	});

	$(".country").each(function(i) {
		var valid_city_var = valid_city(i);
		if (valid_city_var == 1) {
			country.push({country : $(this).val()});
		} else {
			incomplete_country_count++;
		}
	});

	if(incomplete_address_count == 0 && incomplete_pincode_count == 0 && incomplete_city_count == 0 && incomplete_state_count == 0 && incomplete_country_count == 0) {
		var formdata = new FormData();
			formdata.append('url',1);
			formdata.append('address',JSON.stringify(address));
			formdata.append('pincode',JSON.stringify(pincode));
			formdata.append('city',JSON.stringify(city));
			formdata.append('state',JSON.stringify(state));
			formdata.append('country',JSON.stringify(country));

			if (criminal_checks_id !='' && criminal_checks_id !=null) {
				formdata.append('criminal_checks_id',criminal_checks_id);
			}
			
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		$('#save-data-error-msg').html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
		$.ajax({
            type: "POST",
            url: base_url+"candidate/update_candidate_criminal_check",
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
              	$("#save-details-btn").html('Save & Continue');
            }
        });
	} else {
		$('#save-data-error-msg').html("<span class='text-danger error-msg-small'>Please fill the correct details</span>");
	}
}