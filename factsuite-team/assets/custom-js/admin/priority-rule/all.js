$('#edit-client-name').on('change', function() {
	check_edit_client_name();	
});

$('#edit-rule-cirteria').on('change', function() {
	check_edit_rule_cirteria();	
});

get_all_rules();
function get_all_rules() {
	$.ajax({
        type : "POST",
        url : base_url+"factsuite-admin/get-all-rules",
        data : {
        	verify_admin_request : '1'
        },
        dataType: "json",
        success: function(data) {
        	var all_rules = data.all_rules,
        		html = '',
        		all_rule_cirteria = JSON.parse(data.all_rule_cirteria),
        		selected_datetime_format = data.selected_datetime_format;

            if (all_rules.length > 0) {
                for (var i = 0; i < all_rules.length; i++) {
                	var checked = '',
                		show_criteria_type = '';
                	for (var j = 0; j < all_rule_cirteria.length; j++) {
                		if (all_rule_cirteria[j].id == all_rules[i].show_cases_rule_criteria) {
                			show_criteria_type = all_rule_cirteria[j].name;
                			break;
                		}
                	}

                	if (all_rules[i].show_cases_rule_status == 1) {
                		checked = 'checked';
                	}

                    html += '<tr class="case-filter" id="tr_'+all_rules[i].show_cases_rule_id+'">';
                    html += '<td>'+(i+1)+'</td>';
                    html += '<td id="rule-criteria-'+all_rules[i].show_cases_rule_id+'">'+show_criteria_type+'</td>';
                    html += '<td>'+moment(all_rules[i].show_cases_rule_created_date).format(selected_datetime_format['js_code'])+'</td>';
                    html += '<td><div class="custom-control custom-switch d-inline">';
                    html += '<input type="checkbox" '+checked+' onclick="change_rule_status('+all_rules[i].show_cases_rule_id+','+all_rules[i].show_cases_rule_status+')" class="custom-control-input" id="change-rule-status-'+all_rules[i].show_cases_rule_id+'">';
                    html += '<label class="custom-control-label" for="change-rule-status-'+all_rules[i].show_cases_rule_id+'"></label></div></td>';
                    html += '<td class="text-center"><a href="javascript:void(0)" onclick="view_rule_details('+all_rules[i].show_cases_rule_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Rules Found.</td></tr>'; 
            }
            $('#get-rules-list').html(html);
        } 
    });
}

function check_edit_client_name() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-client-name';
	variable_array['error_msg_div_id'] = '#edit-client-name-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select atlease one client.';
	return mandatory_select(variable_array);
}

function check_edit_rule_cirteria(request_from = '') {
	var rule_cirteria = $('#edit-rule-cirteria').val();
	if (request_from != 'edit_rule') {
		$('#edit-rule-details-div').html('');
	}
	var variable_array = {};
	variable_array['input_id'] = '#edit-rule-cirteria';
	variable_array['error_msg_div_id'] = '#edit-rule-cirteria-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select a criteria.';
	var return_result = mandatory_select(variable_array);

	if (return_result != 1) {
		return return_result;
	}

	if (request_from != 'edit_rule') {
		if(rule_cirteria == 1) {
			get_edit_remaining_days_list();
		} else if(rule_cirteria == 2) {
			get_edit_priority_list();
		}
	}

	return return_result;
}

function get_edit_remaining_days_list() {
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
        		html += '<select class="form-control" id="edit-remaining-days-type" onchange="check_edit_remaining_days_type()">';
	        if (data.length > 0) {
	         	html += '<option value="" selected>Select Type</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Critera Available</div>';
	        }
	        html += '</select>';
	        html += '<div id="edit-remaining-days-type-error-msg-div"></div>';
	        html += '<label class="product-details-span-light">Value</label>';
	        html += '<input type="text" class="form-control" id="edit-remaining-days-value" onkeyup="check_edit_remaining_days_value()" onblur="check_edit_remaining_days_value()" placeholder="In Days">';
	        html += '<div id="edit-remaining-days-value-error-msg-div"></div>';
	        $('#edit-rule-details-div').html(html);
	    }
    });
}

function get_edit_priority_list() {
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
        		html += '<select class="form-control" id="edit-priority-type" onchange="check_edit_priority_type()">';
	        if (data.length > 0) {
	         	html += '<option value="" selected>Select Type</option>';
	         	for (var i = 0; i < data.length; i++) {
	         		html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
	        	}
	        } else {
	         	html = '<option value="">No Priority Available</div>';
	        }
	        html += '</select>';
	        html += '<div id="edit-priority-type-error-msg-div"></div>';
	        $('#edit-rule-details-div').html(html);
	    }
    });
}

function check_edit_remaining_days_type() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-remaining-days-type';
	variable_array['error_msg_div_id'] = '#edit-remaining-days-type-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select the remaining days.';
	return mandatory_select(variable_array);
}

function check_edit_remaining_days_value() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-remaining-days-value';
	variable_array['error_msg_div_id'] = '#edit-remaining-days-value-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the remaining days';
	variable_array['not_a_number_input_error_msg'] = 'Remaining days should be only in numbers.';
	variable_array['exceeding_max_number_input_error_msg'] = 'Remaining days should be max '+maximum_remaining_days;
	variable_array['preceeding_min_number_input_error_msg'] = 'Remaining days should be min '+minimum_remaining_days;
	variable_array['max_number'] = maximum_remaining_days;
	variable_array['min_number'] = minimum_remaining_days;
	variable_array['no_error_msg'] = '';
	return only_number_with_min_and_max_number_limitation(variable_array);
}

function check_edit_priority_type() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-priority-type';
	variable_array['error_msg_div_id'] = '#edit-priority-type-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select the remaining days.';
	return mandatory_select(variable_array);
}

function view_rule_details(show_cases_rule_id) {
	$.ajax({
        type : "POST",
        url : base_url+"factsuite-admin/get-single-rule-details",
        data : {
        	verify_admin_request : '1',
        	show_cases_rule_id : show_cases_rule_id
        },
        dataType: "json",
        success: function(data) {
        	var html = '',
        		rule_details = data.rule_details,
        		all_rule_cirteria = JSON.parse(data.all_rule_cirteria),
        		all_remaining_days_type = JSON.parse(data.all_remaining_days_type),
        		all_case_priorities = JSON.parse(data.all_case_priorities),
        		all_clients = data.all_clients,
        		show_cases_rules = JSON.parse(rule_details.show_cases_rules);

        	$('#edit-client-name, #edit-rule-cirteria').html('');
        	for (var i = 0; i < all_clients.length; i++) {
        		var selected = '';
				if (jQuery.inArray(all_clients[i].client_id, rule_details.show_cases_rule_client_id) != -1) {
					selected = 'selected';
				}
				$('#edit-client-name').append('<option '+selected+' value="'+all_clients[i].client_id+'">'+all_clients[i].client_name+'</option>');
        	}

        	for (var i = 0; i < all_rule_cirteria.length; i++) {
        		var selected = '';
				if (all_rule_cirteria[i].id == rule_details.show_cases_rule_criteria) {
					selected = 'selected';
				}
				$('#edit-rule-cirteria').append('<option '+selected+' value="'+all_rule_cirteria[i].id+'">'+all_rule_cirteria[i].name+'</option>');
        	}

        	if (rule_details.show_cases_rule_criteria == 1) {
        		var html = '<label class="product-details-span-light">Is</label>';
	        		html += '<select class="form-control" id="edit-remaining-days-type" onchange="check_edit_remaining_days_type()">';
		        if (all_remaining_days_type.length > 0) {
		         	for (var i = 0; i < all_remaining_days_type.length; i++) {
		         		var selected = '';
		         		if (all_remaining_days_type[i].id == show_cases_rules.remaining_days_type) {
		         			selected = 'selected';
		         		}
		         		html += '<option '+selected+' value="'+all_remaining_days_type[i].id+'">'+all_remaining_days_type[i].name+'</option>';
		        	}
		        } else {
		         	html = '<option value="">No Critera Available</div>';
		        }
		        html += '</select>';
		        html += '<div id="edit-remaining-days-type-error-msg-div"></div>';
		        html += '<label class="product-details-span-light">Value</label>';
		        html += '<input type="text" class="form-control" id="edit-remaining-days-value" onkeyup="check_edit_remaining_days_value()" onblur="check_edit_remaining_days_value()" placeholder="In Days" value="'+show_cases_rules.remaining_days_value+'">';
		        html += '<div id="edit-remaining-days-value-error-msg-div"></div>';
        	} else if(rule_details.show_cases_rule_criteria == 2) {
        		html = '<label class="product-details-span-light">Type</label>';
        		html += '<select class="form-control" id="edit-priority-type" onchange="check_edit_priority_type()">';
		        if (all_case_priorities.length > 0) {
		         	for (var i = 0; i < all_case_priorities.length; i++) {
		         		var selected = '';
		         		if(all_case_priorities[i].id == show_cases_rules.priority_type) {
		         			selected = 'selected';
		         		}
		         		html += '<option '+selected+' value="'+all_case_priorities[i].id+'">'+all_case_priorities[i].name+'</option>';
		        	}
		        } else {
		         	html = '<option value="">No Priority Available</div>';
		        }
		        html += '</select>';
		        html += '<div id="edit-priority-type-error-msg-div"></div>';
        	}
            $('#edit-rule-details-div').html(html);

            $('#edit-rule-btn').attr('onclick','update_rule('+show_cases_rule_id+')');

            $('#edit-rule-modal').modal('show');
        } 
    });
}

function change_rule_status(show_cases_rule_id,status) {
	var changed_status = 0;

	if (status == 1) {
		changed_status = 0;
	} else if (status == 0) {
		changed_status = 1;
	} else {
		get_all_rules();
		toastr.error('OOPS! Something went wrong. Please try again.')
		return false;
	}

	var variable_array = {};
	variable_array['id'] = show_cases_rule_id;
	variable_array['actual_status'] = status;
	variable_array['changed_status'] = changed_status;
	variable_array['ajax_call_url'] = 'factsuite-admin/change-rule-status';
	variable_array['checkbox_id'] = '#change-rule-status-'+show_cases_rule_id;
	variable_array['onclick_method_name'] = 'change_rule_status';
	variable_array['success_message'] = 'Rule status has been updated successfully.';
	variable_array['error_message'] = 'Something went wrong updating the rule status. Please try again.';
	variable_array['error_callback_function'] = 'get_all_rules()';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : show_cases_rule_id, changed_status : changed_status};

	return change_status(variable_array);
}

function update_rule(show_cases_rule_id) {
	var client_name = $('#edit-client-name').val(),
		rule_cirteria = $('#edit-rule-cirteria').val();

	var check_edit_client_name_var = check_edit_client_name(),
		check_edit_rule_cirteria_var = check_edit_rule_cirteria('edit_rule');

	if(check_edit_client_name_var == 1 && check_edit_rule_cirteria_var == 1) {
		var formdata = new FormData();
		formdata.append('verify_admin_request',1);
		formdata.append('show_cases_rule_id',show_cases_rule_id);
		formdata.append('client_name',client_name);
		formdata.append('rule_cirteria',rule_cirteria);

		if(rule_cirteria == 1) {
			var check_edit_remaining_days_type_var = check_edit_remaining_days_type(),
				check_edit_remaining_days_value_var = check_edit_remaining_days_value();

			if (check_edit_remaining_days_type_var == 1 && check_edit_remaining_days_value_var == 1) {
				formdata.append('remaining_days_type',$('#edit-remaining-days-type').val());
				formdata.append('remaining_days_value',$('#edit-remaining-days-value').val());
			} else {
				return false;
			}
		} else if(rule_cirteria == 2) {
			var check_edit_priority_type_var = check_edit_priority_type();

			if (check_edit_priority_type_var == 1) {
				formdata.append('priority_type',$('#edit-priority-type').val());
			} else {
				return false;
			}
		}

		$('#edit-rule-btn').prop('disabled',true);
		$('#edit-rule-error-msg-div').html('<span class="text-warning error-msg">Please wait while we are updating the rule.</span>');

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-admin/update-rule",
		  	data: formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#edit-rule-btn').prop('disabled',false);
					$('#edit-rule-error-msg-div').html('');
				  	if (data.rule_details.status == '1') {
				  		var all_rule_cirteria = JSON.parse(data.all_rule_cirteria);
				  		for (var i = 0; i < all_rule_cirteria.length; i++) {
				  			if (all_rule_cirteria[i].id == rule_cirteria) {
				  				$('#rule-criteria-'+show_cases_rule_id).html(all_rule_cirteria[i].name);
				  				break;
				  			}
				  		}
				  		toastr.success('Rule has been updated successfully.');
		  				$('#edit-rule-modal').modal('hide');
				  	} else {
				  		toastr.error('Something went wrong while updating the rule. Please try again.');
			  		}
			  	} else {
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#edit-rule-btn').prop('disabled',false);
				$('#edit-rule-error-msg-div').html('');
		  		toastr.error('Something went wrong while updating the rule. Please try again.');
		  	}
		});
	}
}