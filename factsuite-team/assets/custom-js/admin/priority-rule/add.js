var minimum_remaining_days = 0,
	maximum_remaining_days = 100;

$('#add-new-rule-modal-btn').on('click', function() {
	clear_add_new_rule_input_fields();
	$('#add-new-rule-modal').modal('show');
});

$('#client-name').on('change', function() {
	check_client_name();	
});

$('#rule-cirteria').on('change', function() {
	check_rule_cirteria();	
});

$('#add-new-rule-btn').on('click', function() {
	add_new_rule();
});

get_all_clients();
function get_all_clients() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-clients',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	        	var all_clients = data.all_clients;
	         	if (data.all_clients.length > 0) {
	         		var html = '';
	         		// var html = '<option value="">Select Client</option>';
	         		for (var i = 0; i < all_clients.length; i++) {
	         			html += '<option value="'+all_clients[i].client_id+'">'+all_clients[i].client_name+'</option>';
	         		}
	         	} else {
	         		html = '<option value="">No Client Available</div>';
	         	}
	         	$('#client-name').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

get_all_rule_cirteria();
function get_all_rule_cirteria() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-rule-cirteria',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.length > 0) {
	         	var html = '<option value="" selected>Select Criteria</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Critera Available</div>';
	        }
	        $('#rule-cirteria').html(html);
	    }
    });
}

function check_client_name() {
	var variable_array = {};
	variable_array['input_id'] = '#client-name';
	variable_array['error_msg_div_id'] = '#client-name-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select atlease one client.';
	return mandatory_select(variable_array);
}

function check_client_name() {
	var variable_array = {};
	variable_array['input_id'] = '#client-name';
	variable_array['error_msg_div_id'] = '#client-name-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select atlease one client.';
	return mandatory_select(variable_array);
}

function check_rule_cirteria(request_from = '') {
	var rule_cirteria = $('#rule-cirteria').val();
	if (request_from != 'add_new_rule') {
		$('#add-new-rule-details-div').html('');
	}
	var variable_array = {};
	variable_array['input_id'] = '#rule-cirteria';
	variable_array['error_msg_div_id'] = '#rule-cirteria-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select a criteria.';
	var return_result = mandatory_select(variable_array);

	if (return_result != 1) {
		return return_result;
	}

	if (request_from != 'add_new_rule') {
		if(rule_cirteria == 1) {
			get_remaining_days_list();
		} else if(rule_cirteria == 2) {
			get_priority_list();
		}
	}

	return return_result;
}

function get_remaining_days_list() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-remaining-days-rules',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
        	var html = '<label class="product-details-span-light">Is</label>';
        		html += '<select class="form-control" id="remaining-days-type" onchange="check_remaining_days_type()">';
	        if (data.length > 0) {
	         	html += '<option value="" selected>Select Type</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Critera Available</div>';
	        }
	        html += '</select>';
	        html += '<div id="remaining-days-type-error-msg-div"></div>';
	        html += '<label class="product-details-span-light">Value</label>';
	        html += '<input type="text" class="form-control" id="remaining-days-value" onkeyup="check_remaining_days_value()" onblur="check_remaining_days_value()" placeholder="In Days">';
	        html += '<div id="remaining-days-value-error-msg-div"></div>';
	        $('#add-new-rule-details-div').html(html);
	    }
    });
}

function get_priority_list() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-case-priorities',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
        	var html = '<label class="product-details-span-light">Type</label>';
        		html += '<select class="form-control" id="priority-type" onchange="check_priority_type()">';
	        if (data.length > 0) {
	         	html += '<option value="" selected>Select Type</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Priority Available</div>';
	        }
	        html += '</select>';
	        html += '<div id="priority-type-error-msg-div"></div>';
	        $('#add-new-rule-details-div').html(html);
	    }
    });
}

function check_remaining_days_type() {
	var variable_array = {};
	variable_array['input_id'] = '#remaining-days-type';
	variable_array['error_msg_div_id'] = '#remaining-days-type-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select the remaining days.';
	return mandatory_select(variable_array);
}

function check_remaining_days_value() {
	var variable_array = {};
	variable_array['input_id'] = '#remaining-days-value';
	variable_array['error_msg_div_id'] = '#remaining-days-value-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the remaining days';
	variable_array['not_a_number_input_error_msg'] = 'Remaining days should be only in numbers.';
	variable_array['exceeding_max_number_input_error_msg'] = 'Remaining days should be max '+maximum_remaining_days;
	variable_array['preceeding_min_number_input_error_msg'] = 'Remaining days should be min '+minimum_remaining_days;
	variable_array['max_number'] = maximum_remaining_days;
	variable_array['min_number'] = minimum_remaining_days;
	variable_array['no_error_msg'] = '';
	return only_number_with_min_and_max_number_limitation(variable_array);
}

function check_priority_type() {
	var variable_array = {};
	variable_array['input_id'] = '#priority-type';
	variable_array['error_msg_div_id'] = '#priority-type-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select the remaining days.';
	return mandatory_select(variable_array);
}

function add_new_rule() {
	var client_name = $('#client-name').val(),
		rule_cirteria = $('#rule-cirteria').val();

	var check_client_name_var = check_client_name(),
		check_rule_cirteria_var = check_rule_cirteria('add_new_rule');

	if(check_client_name_var == 1 && check_rule_cirteria_var == 1) {
		var formdata = new FormData();
		formdata.append('verify_admin_request',1);
		formdata.append('client_name',client_name);
		formdata.append('rule_cirteria',rule_cirteria);

		if(rule_cirteria == 1) {
			var check_remaining_days_type_var = check_remaining_days_type(),
				check_remaining_days_value_var = check_remaining_days_value();

			if (check_remaining_days_type_var == 1 && check_remaining_days_value_var == 1) {
				formdata.append('remaining_days_type',$('#remaining-days-type').val());
				formdata.append('remaining_days_value',$('#remaining-days-value').val());
			} else {
				return false;
			}
		} else if(rule_cirteria == 2) {
			var check_priority_type_var = check_priority_type();

			if (check_priority_type_var == 1) {
				formdata.append('priority_type',$('#priority-type').val());
			} else {
				return false;
			}
		}

		$('#add-new-rule-btn').prop('disabled',true);
		$('#add-new-rule-error-msg-div').html('<span class="text-warning error-msg">Please wait while we are adding new rule.</span>');

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-admin/add-new-rule",
		  	data: formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#add-new-rule-btn').prop('disabled',false);
					$('#add-new-rule-error-msg-div').html('');
				  	if (data.rule_details.status == '1') {
				  		get_all_rules();
		  				$('#add-new-rule-modal').modal('hide');
				  		toastr.success('A new rule has been added successfully.');
		  				clear_add_new_rule_input_fields();
				  	} else {
				  		toastr.error('Something went wrong while adding the rule. Please try again.');
			  		}
			  	} else {
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#add-new-rule-btn').prop('disabled',false);
				$('#add-new-rule-error-msg-div').html('');
		  		toastr.error('Something went wrong while adding the rule. Please try again.');
		  	}
		});
	}
}

function clear_add_new_rule_input_fields() {
	$('#client-name, #rule-cirteria').val('');
	$('#add-new-rule-details-div').html('');
}