var time_count = 1,
	notification_name_max_length = 300,
	minimum_remaining_days = 0,
	maximum_remaining_days = 100;

$('#rule-cirteria').on('change', function() {
	check_rule_cirteria();	
});

$('#client-type').on('change', function() {
	get_all_clients($('#client-type').val());	
});

get_all_client_types(0);
function get_all_client_types(client_type = '') {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-client-type',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	        	var all_client_type = JSON.parse(data.all_client_type);
	         	if (data.all_client_type.length > 0) {
	         		var html = '';
	         		// var html = '<option value="">Select Client</option>';
	         		for (var i = 0; i < all_client_type.length; i++) {
	         			html += '<option value="'+all_client_type[i].id+'">'+all_client_type[i].name+'</option>';
	         		}
	         		get_all_clients(client_type);
	         	} else {
	         		html = '<option value="">No Client Type Available</div>';
	         	}
	         	$('#client-type').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

function get_all_clients(client_type = 0, request_from = '') {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-clients',
        data : {
        	verify_admin_request : '1',
        	client_type : client_type
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
	         	if (request_from == 'edit') {
	         		$('#edit-client-name').html(html);
	         	} else {
	         		$('#client-name').html(html);
	         	}
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

get_all_case_type();
function get_all_case_type() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-case-type',
        data : {
        	verify_admin_request : '1'
        },
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.length > 0) {
	         	var html = '<option value="" selected>Select Case Type</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Case Type  Available</div>';
	        }
	        $('#case-type').html(html);
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
	         		if (data[i].id == '1') {
	         			html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	         		}
	        	}
	        } else {
	         	html = '<option value="">No Critera Available</div>';
	        }
	        $('#rule-cirteria').html(html);
	    }
    });
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
        	var html = '<span class="product-details-span-light">Is</span>';
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
	        html += '<span class="product-details-span-light d-block mt-3">Value</span>';
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
	variable_array['exceeding_max_number_input_error_msg'] = 'Remaining days can be max '+maximum_remaining_days;
	variable_array['preceeding_min_number_input_error_msg'] = 'Remaining days can be min '+minimum_remaining_days;
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

$('#add-new-rule-modal-btn').on('click', function() {
	time_count = 1;
	clear_add_new_rule_input_fields();
	$('#add-new-rule-modal').modal('show');
});

$('#notification-name').on('keyup blur', function() {
	check_notification_name();
});

$('#email-subject').on('keyup blur', function() {
	check_email_subject();
});

$('#email-description').on('keyup blur', function() {
	check_email_description();
});

$('#client-name').on('change', function() {
	check_client_name();	
});

$('#case-type').on('change', function() {
	check_case_type();	
});

$('#sms-add-time').on('click', function() {
	add_new_time();
});

$('#add-new-rule-btn').on('click', function() {
	add_new_client_notification();
});

function check_notification_name() {
	var variable_array = {};
	variable_array['input_id'] = '#notification-name';
	variable_array['error_msg_div_id'] = '#notification-name-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the notification name';
	variable_array['max_length'] = notification_name_max_length;
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+notification_name_max_length+' characters';
	return mandatory_any_input_with_max_length_limitation(variable_array);
}

function check_email_subject() {
	var variable_array = {};
	variable_array['input_id'] = '#email-subject';
	variable_array['error_msg_div_id'] = '#email-subject-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the subject';
	return mandatory_any_input_with_no_limitation(variable_array);	
}

function check_email_description() {
	var variable_array = {};
	variable_array['input_id'] = '#email-description';
	variable_array['error_msg_div_id'] = '#email-description-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the description';
	return mandatory_any_input_with_no_limitation(variable_array);	
}

function check_client_name() {
	var variable_array = {};
	variable_array['input_id'] = '#client-name';
	variable_array['error_msg_div_id'] = '#client-name-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select atlease one client.';
	return mandatory_select(variable_array);
}

function check_case_type() {
	var variable_array = {};
	variable_array['input_id'] = '#case-type';
	variable_array['error_msg_div_id'] = '#case-type-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select the case type.';
	return mandatory_select(variable_array);
}

function schedule_new_time(id) {
	var variable_array = {};
	variable_array['input_id'] = '#schedule-time-'+id;
	variable_array['error_msg_div_id'] = '#schedule-time-error-msg-div-'+id;
	variable_array['empty_input_error_msg'] = 'Please add the time';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function add_new_time(request_from = '') {
	var is_true = 1;
	if (clock_type == 1) {
		is_true = 0;
		$('.schedule-time-main-div').each(function() {
			var input_id = $(this).attr('id').split('-'),
				check_schedule_new_time = schedule_new_time(input_id[4]);

			if (check_schedule_new_time != 1) {
				is_true = 0;
			}
		});
	}
	// $('.schedule-new-time').each(function() {
	// 	var input_id = $(this).attr('id').split('-');
	// 	var check_schedule_new_time = schedule_new_time(input_id[2]);
	// 	if (check_schedule_new_time != 1) {
	// 		is_true = 0;
	// 	}
	// });
	
	if (request_from == '') {
		if(is_true == 1) {
			var variable_array = {};
				variable_array['id'] = time_count;
				variable_array['check_db_value'] = 0;
				variable_array['append'] = 1;
				variable_array['for_edit'] = 0;
			if (clock_type == 0) {
				variable_array['hrs-id'] = '#schedule-time-hrs-'+time_count;
				variable_array['min-id'] = '#schedule-time-min-'+time_count;
				variable_array['ampm-id'] = '#schedule-time-ampm-'+time_count;
			} else if (clock_type == 1) {
				variable_array['timepicker-id'] = '#schedule-time-'+time_count;
			}
			
			variable_array['ui-id'] = '#schedule-time-div';
			add_new_time_slot(variable_array);
			time_count++;
		}
	}

	return is_true;
}

function delete_time(id) {
	$('#schedule-time-main-div-'+id).remove();
}

function clear_add_new_rule_input_fields() {
	$('#client-name, #case-type, #notification-name, #email-subject, #email-description, #rule-cirteria, #client-type').val('');
	$('#add-new-rule-details-div').html('');
	get_all_client_types(0);
	time_count = 1;

	var variable_array = {};
		variable_array['id'] = 0;
		variable_array['check_db_value'] = 0;
		variable_array['append'] = 0;
		variable_array['for_edit'] = 0;
		variable_array['ui-id'] = '#schedule-time-div';
	if (clock_type == 0) {
		variable_array['hrs-id'] = '#schedule-time-hrs-0';
		variable_array['min-id'] = '#schedule-time-min-0';
		variable_array['ampm-id'] = '#schedule-time-ampm-0';
	} else if (clock_type == 1) {
		variable_array['timepicker-id'] = '#schedule-time-0';
	}
	add_new_time_slot(variable_array);
}

function add_new_time_slot(variable_array) {
	var id = variable_array['id'],
		edit_id = '',
		delete_btn_html = '',
		time_12_24_hr_format_class = ' timepicker-24-hr';

	if (variable_array['for_edit'] == 1) {
		edit_id = 'edit-';
	}

	if (clock_type == 1) {
		if (time_12_24_hr_format == 0) {
			time_12_24_hr_format_class = ' timepicker-12-hr';
		}
	}
	if (id != 0) {
    	delete_btn_html = '<span class="product-details-span-light product-details-span-light-small d-block">&nbsp;</span>';
    	delete_btn_html += '<button id="sms-add-time" class="btn btn-danger"';
    	if (variable_array['for_edit'] == 1) {
    		delete_btn_html += 'onclick="delete_edit_time('+id+')"';
    	} else {
    		delete_btn_html += 'onclick="delete_time('+id+')"';
    	}
    	delete_btn_html += '><i class="fa fa-trash"></i></button>';
    }
	var html = '<div class="row mt-3 '+edit_id+'schedule-time-main-div" id="'+edit_id+'schedule-time-main-div-'+id+'">';
	if (clock_type == 1) {
		html += '<div class="col-md-4">';
		html += '<span class="product-details-span-light product-details-span-light-small">Time</span>';
		html += '<input type="text" class="form-control'+time_12_24_hr_format_class+'" name="'+edit_id+'schedule-time-'+id+'" id="'+edit_id+'schedule-time-'+id+'" >';
        html += '</div>';
        html += '<div class="col-md-8">';
        html += delete_btn_html;
        html += '</div>';
        html += '<div class="col-md-12" id="'+edit_id+'schedule-time-error-msg-div-'+id+'"></div>';
        html += '</div>';

	    if (variable_array['append'] == 0) {
			$(variable_array['ui-id']).html(html);
	    } else {
	    	$(variable_array['ui-id']).append(html);
	    }
	} else if(clock_type == 0) {
		html += '<div class="col-md-2">';
		html += '<span class="product-details-span-light product-details-span-light-small">Hrs</span>';
		html += '<select class="form-control schedule-new-time-hrs schedule-time-select" name="'+edit_id+'schedule-time-hrs-'+id+'" id="'+edit_id+'schedule-time-hrs-'+id+'"></select>';
        html += '</div>';
        html += '<div class="col-md-2">';
		html += '<span class="product-details-span-light product-details-span-light-small">Min</span>';
		html += '<select class="form-control schedule-new-time-min schedule-time-select" name="'+edit_id+'schedule-time-min-'+id+'" id="'+edit_id+'schedule-time-min-'+id+'"></select>';
        html += '</div>';
        html += '<div class="col-md-3">';
		html += '<span class="product-details-span-light product-details-span-light-small">AM/PM</span>';
		html += '<select class="form-control schedule-new-time-ampm schedule-time-select w-80" name="'+edit_id+'schedule-time-ampm-'+id+'" id="'+edit_id+'schedule-time-ampm-'+id+'"></select>';
        html += '</div>';
        html += '<div class="col-md-5">';
        html += delete_btn_html;
        html += '</div>';
        html += '</div>';

	    if (variable_array['append'] == 0) {
			$(variable_array['ui-id']).html(html);
	    } else {
	    	$(variable_array['ui-id']).append(html);
	    }
		get_hours(variable_array);
		get_minutes(variable_array);
		get_ampm(variable_array);
	}
}

function add_new_client_notification() {
	var check_notification_name_var = check_notification_name(),
		check_email_subject_var = check_email_subject(),
		check_email_description_var = check_email_description(),
		check_client_name_var = check_client_name(),
		check_case_type_var = check_case_type(),
		check_rule_cirteria_var = check_rule_cirteria('add_new_rule'),
		// check_add_new_time = add_new_time('add-new'),
		rule_cirteria = $('#rule-cirteria').val();

	if(check_notification_name_var == 1 && check_email_subject_var == 1 && check_email_description_var == 1 && check_client_name_var == 1 && check_case_type_var == 1 && check_rule_cirteria_var == 1) {
		$('#add-new-rule-btn').prop('disabled',true);
		$('#add-new-rule-error-msg-div').html('<span class="d-block text-center error-msg-div text-warning">Please wait while we are saving the new reminder rule.</span>');
		var formdata = new FormData(),
			all_time = [];
		formdata.append('verify_admin_request',1);
		formdata.append('notification_name',$('#notification-name').val());
		formdata.append('email_subject',$('#email-subject').val());
		formdata.append('email_description',$('#email-description').val());
		formdata.append('client_type',$('#client-type').val());
		formdata.append('client_name',$('#client-name').val());
		formdata.append('case_type',$('#case-type').val());
		formdata.append('rule_cirteria',rule_cirteria);
		
		$('.schedule-time-main-div').each(function() {
			var input_id = $(this).attr('id').split('-');
			scheduled_time = $('#schedule-time-hrs-'+input_id[4]).val()+':'+$('#schedule-time-min-'+input_id[4]).val()+' '+$('#schedule-time-ampm-'+input_id[4]).val();
			all_time.push(scheduled_time);
		});
		formdata.append('all_time',JSON.stringify(all_time));
		
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
		} else {
			toastr.error('Something went wrong while adding the reminder rule. Please try again.');
			$('#add-new-rule-modal').modal('hide');
			return false;
		}

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-admin/add-new-client-notification-rule",
		  	data: formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#add-new-rule-btn').prop('disabled',false);
					$('#add-new-rule-error-msg-div').html('');
				  	if (data.rule_details.status == '1') {
				  		get_all_notifications();
		  				$('#add-new-rule-modal').modal('hide');
				  		toastr.success('A new reminder rule has been added successfully.');
		  				clear_add_new_rule_input_fields();
				  	} else {
				  		toastr.error('Something went wrong while adding the reminder rule. Please try again.');
			  		}
			  	} else {
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#add-new-rule-btn').prop('disabled',false);
				$('#add-new-rule-error-msg-div').html('');
		  		toastr.error('Something went wrong while adding the reminder rule. Please try again.');
		  	}
		});
	}
}

function get_hours(variable_array) {
	for (var i = 0; i <= 12; i++) {
		var value = i;
		if (i >= 0 && i <= 9) {
			value = '0'+i;
		}
		var selected = '';
		if (variable_array['check_db_value'] == 1) {
			if (variable_array['selected-hrs'] == value) {
				selected = ' selected';
			}
		}
		$(variable_array['hrs-id']).append('<option'+selected+' value="'+value+'">'+value+'</option>');
	}
}

function get_minutes(variable_array) {
	for (var i = 0; i <= 59; i++) {
		var value = i;
		if (i >= 0 && i <= 9) {
			value = '0'+i;
		}
		var selected = '';
		if (variable_array['check_db_value'] == 1) {
			if (parseInt(variable_array['selected-min']) == parseInt(value)) {
				selected = ' selected';
			}
		}
		$(variable_array['min-id']).append('<option'+selected+' value="'+value+'">'+value+'</option>');
	}
}

function get_ampm(variable_array) {
	var am_selected = '',
		pm_selected = '';
	if (variable_array['check_db_value'] == 1) {
		if (variable_array['selected-ampm'].toLowerCase() == 'am') {
			am_selected = ' selected';
		} else {
			pm_selected = ' selected';
		}
	}
	var html = '<option'+am_selected+' value="am">AM</option>';
		html += '<option'+pm_selected+' value="pm">PM</option>';
	$(variable_array['ampm-id']).html(html);
}