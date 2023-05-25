$('#edit-notification-name').on('keyup blur', function() {
    check_edit_notification_name();
});

$('#edit-email-subject').on('keyup blur', function() {
    check_edit_email_subject();
});

$('#edit-email-description').on('keyup blur', function() {
    check_edit_email_description();
});

$('#edit-client-name').on('change', function() {
    check_edit_client_name();    
});

$('#edit-case-type').on('change', function() {
    check_edit_case_type();  
});

$('#edit-sms-add-time').on('click', function() {
    add_edit_new_time();
});

$('#edit-rule-cirteria').on('change', function() {
    check_edit_rule_cirteria(); 
});

$('#edit-client-type').on('change', function() {
    get_all_clients($('#edit-client-type').val(),'edit');   
});

function check_edit_notification_name() {
    var variable_array = {};
    variable_array['input_id'] = '#edit-notification-name';
    variable_array['error_msg_div_id'] = '#edit-notification-name-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the notification name';
    variable_array['max_length'] = notification_name_max_length;
    variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+notification_name_max_length+' characters';
    return mandatory_any_input_with_max_length_limitation(variable_array);
}

function check_edit_email_subject() {
    var variable_array = {};
    variable_array['input_id'] = '#edit-email-subject';
    variable_array['error_msg_div_id'] = '#edit-email-subject-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the subject';
    return mandatory_any_input_with_no_limitation(variable_array);  
}

function check_edit_email_description() {
    var variable_array = {};
    variable_array['input_id'] = '#edit-email-description';
    variable_array['error_msg_div_id'] = '#edit-email-description-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the description';
    return mandatory_any_input_with_no_limitation(variable_array);  
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

function check_edit_case_type() {
    var variable_array = {};
    variable_array['input_id'] = '#edit-case-type';
    variable_array['error_msg_div_id'] = '#edit-case-type-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select the case type.';
    return mandatory_select(variable_array);
}

function schedule_edit_new_time(id) {
    var variable_array = {};
    variable_array['input_id'] = '#edit-schedule-time-'+id;
    variable_array['error_msg_div_id'] = '#edit-schedule-time-eror-msg-div-'+id;
    variable_array['empty_input_error_msg'] = 'Please add the time';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function add_edit_new_time(request_from = '') {
    var is_true = 1;
    // $('.edit-schedule-new-time').each(function() {
    //     var input_id = $(this).attr('id').split('-');
    //     var check_schedule_new_time = schedule_edit_new_time(input_id[3]);
    //     if (check_schedule_new_time != 1) {
    //         is_true = 0;
    //     }
    // });
    if (clock_type == 1) {
        is_true = 0;
        $('.edit-schedule-time-main-div').each(function() {
            var input_id = $(this).attr('id').split('-'),
                check_schedule_new_time = schedule_new_time(input_id[5]);

            if (check_schedule_new_time != 1) {
                is_true = 0;
            }
        });
    }

    if (request_from == '') {
        if(is_true == 1) {
            var variable_array = {};
                variable_array['id'] = time_count;
                variable_array['check_db_value'] = 0;
                variable_array['append'] = 1;
                variable_array['for_edit'] = 1;
            if (clock_type == 0) {
                variable_array['hrs-id'] = '#edit-schedule-time-hrs-'+time_count;
                variable_array['min-id'] = '#edit-schedule-time-min-'+time_count;
                variable_array['ampm-id'] = '#edit-schedule-time-ampm-'+time_count;
            } else if (clock_type == 1) {
                variable_array['timepicker-id'] = '#edit-schedule-time-'+time_count;
            }
            variable_array['ui-id'] = '#edit-schedule-time-div';
            add_new_time_slot(variable_array);
            time_count++;
        }
    }

    return is_true;
}

function delete_edit_time(id) {
    $('#edit-schedule-new-time-div-'+id).remove();
    $('#edit-schedule-new-time-delete-div-'+id).remove();
}

get_all_notifications();
function get_all_notifications() {
	$.ajax({
        type : "POST",
        url : base_url+"factsuite-admin/get-all-client-notification-rules",
        data : {
        	verify_admin_request : '1'
        },
        dataType: "json",
        success: function(data) {
        	var all_rules = data.all_rules,
        		html = '',
        		all_case_type = JSON.parse(data.all_case_type);
                
            if (all_rules.length > 0) {
                for (var i = 0; i < all_rules.length; i++) {
                	var checked = '',
                		show_case_type = '';
                	// for (var j = 0; j < all_rule_cirteria.length; j++) {
                	// 	if (all_rule_cirteria[j].id == all_rules[i].show_cases_rule_criteria) {
                	// 		show_case_type = all_rule_cirteria[j].name;
                	// 		break;
                	// 	}
                	// }

                	if (all_rules[i].notification_status == 1) {
                		checked = 'checked';
                	}

                    html += '<tr class="case-filter" id="tr_'+all_rules[i].client_case_automated_email_notification_id+'">';
                    html += '<td>'+(i+1)+'</td>';
                    html += '<td id="notification-name-'+all_rules[i].client_case_automated_email_notification_id+'">'+all_rules[i].notification_name+'</td>';
                    var notification_created_date_time = all_rules[i].notification_created_date.split(' '),
                        notification_created_date = notification_created_date_time[0].split('-'),
                        notification_created_time = notification_created_date_time[1].split(':');
                    html += '<td>'+moment(all_rules[i].notification_created_date).format(data.selected_datetime_format['js_code'])+'</td>';
                    // html += '<td>'+notification_created_date[2]+'-'+notification_created_date[1]+'-'+notification_created_date[0]+' '+notification_created_time[0]+':'+notification_created_time[1]+'</td>';
                    html += '<td><div class="custom-control custom-switch d-inline">';
                    html += '<input type="checkbox" '+checked+' onclick="change_rule_status('+all_rules[i].client_case_automated_email_notification_id+','+all_rules[i].notification_status+')" class="custom-control-input" id="change-rule-status-'+all_rules[i].client_case_automated_email_notification_id+'">';
                    html += '<label class="custom-control-label" for="change-rule-status-'+all_rules[i].client_case_automated_email_notification_id+'"></label></div></td>';
                    html += '<td class="text-center"><a href="javascript:void(0)" onclick="view_rule_details('+all_rules[i].client_case_automated_email_notification_id+')"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Rules Found.</td></tr>'; 
            }
            $('#get-rules-list').html(html);
        } 
    });
}

function change_rule_status(client_case_automated_email_notification_id,status) {
    var changed_status = 0;

    if (status == 1) {
        changed_status = 0;
    } else if (status == 0) {
        changed_status = 1;
    } else {
        get_all_notifications();
        toastr.error('OOPS! Something went wrong. Please try again.')
        return false;
    }

    var variable_array = {};
    variable_array['id'] = client_case_automated_email_notification_id;
    variable_array['actual_status'] = status;
    variable_array['changed_status'] = changed_status;
    variable_array['ajax_call_url'] = 'factsuite-admin/change-client-notification-status';
    variable_array['checkbox_id'] = '#change-rule-status-'+client_case_automated_email_notification_id;
    variable_array['onclick_method_name'] = 'change_rule_status';
    variable_array['success_message'] = 'Reminder status has been updated successfully.';
    variable_array['error_message'] = 'Something went wrong updating the reminder status. Please try again.';
    variable_array['error_callback_function'] = 'get_all_notifications()';
    variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : client_case_automated_email_notification_id, changed_status : changed_status};

    return change_status(variable_array);
}

function view_rule_details(client_case_automated_email_notification_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-admin/get-single-client-notification-rule-details",
        data : {
            verify_admin_request : '1',
            client_case_automated_email_notification_id : client_case_automated_email_notification_id
        },
        dataType: "json",
        success: function(data) {
            var html = '',
                notification_details = data.notification_details,
                all_case_type = JSON.parse(data.all_case_type),
                all_clients = data.all_clients,
                notification_time = JSON.parse(notification_details.notification_time),
                rule_details = data.notification_details,
                all_rule_cirteria = JSON.parse(data.all_rule_cirteria),
                all_remaining_days_type = JSON.parse(data.all_remaining_days_type),
                all_case_priorities = JSON.parse(data.all_case_priorities),
                rule_criteria_rules = JSON.parse(rule_details.rule_criteria_rules),
                all_client_type = JSON.parse(data.all_client_type);
            
            $('#edit-schedule-time-div, #edit-case-type, #edit-client-name').html('');

            $('#edit-notification-name').val(notification_details.notification_name);
            $('#edit-email-subject').val(notification_details.notification_email_subject);
            $('#edit-email-description').val(notification_details.notification_email_description);

            for (var i = 0; i < all_case_type.length; i++) {
                var selected = '';
                if (all_case_type[i].id == notification_details.case_type) {
                    selected = 'selected';
                }
                $('#edit-case-type').append('<option '+selected+' value="'+all_case_type[i].id+'">'+all_case_type[i].name+'</option>');
            }

            for (var i = 0; i < all_client_type.length; i++) {
                var selected = '';
                if (all_client_type[i].id == notification_details.client_type) {
                    selected = 'selected';
                }
                $('#edit-client-type').append('<option '+selected+' value="'+all_client_type[i].id+'">'+all_client_type[i].name+'</option>');
            }

            for (var i = 0; i < all_clients.length; i++) {
                var selected = '';
                if (jQuery.inArray(all_clients[i].client_id, notification_details.client_id.split(',')) != -1) {
                    selected = 'selected';
                }
                $('#edit-client-name').append('<option '+selected+' value="'+all_clients[i].client_id+'">'+all_clients[i].client_name+'</option>');
            }

            for (var i = 0; i < all_rule_cirteria.length; i++) {
                var selected = '';
                if (all_rule_cirteria[i].id == rule_details.rule_criteria) {
                    selected = 'selected';
                }

                 if (all_rule_cirteria[i].id == '1') {
                    $('#edit-rule-cirteria').append('<option '+selected+' value="'+all_rule_cirteria[i].id+'">'+all_rule_cirteria[i].name+'</option>');
                }
            }

            if (rule_details.rule_criteria == 1) {
                var html = '<span class="product-details-span-light">Is</span>';
                    html += '<select class="form-control" id="edit-remaining-days-type" onchange="check_edit_remaining_days_type()">';
                if (all_remaining_days_type.length > 0) {
                    for (var i = 0; i < all_remaining_days_type.length; i++) {
                        var selected = '';
                        if (all_remaining_days_type[i].id == rule_criteria_rules.remaining_days_type) {
                            selected = 'selected';
                        }
                        html += '<option '+selected+' value="'+all_remaining_days_type[i].id+'">'+all_remaining_days_type[i].name+'</option>';
                    }
                } else {
                    html = '<option value="">No Critera Available</div>';
                }
                html += '</select>';
                html += '<div id="edit-remaining-days-type-error-msg-div"></div>';
                html += '<span class="product-details-span-light d-block mt-3">Value</span>';
                html += '<input type="text" class="form-control" id="edit-remaining-days-value" onkeyup="check_edit_remaining_days_value()" onblur="check_edit_remaining_days_value()" placeholder="In Days" value="'+rule_criteria_rules.remaining_days_value+'">';
                html += '<div id="edit-remaining-days-value-error-msg-div"></div>';
            } else if(rule_details.rule_criteria == 2) {
                html = '<span class="product-details-span-light">Type</span>';
                html += '<select class="form-control" id="edit-priority-type" onchange="check_edit_priority_type()">';
                if (all_case_priorities.length > 0) {
                    for (var i = 0; i < all_case_priorities.length; i++) {
                        var selected = '';
                        if(all_case_priorities[i].id == rule_criteria_rules.priority_type) {
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

            var variable_array = {};
                variable_array['check_db_value'] = 1;
                variable_array['append'] = 1;    
                variable_array['for_edit'] = 1;
                variable_array['ui-id'] = '#edit-schedule-time-div';
            
            for (var i = 0; i < notification_time.length; i++) {
                selected_time = notification_time[i].split(' ');
                time = selected_time[0].split(':');
                variable_array['id'] = i;
                if (clock_type == 0) {
                    variable_array['hrs-id'] = '#edit-schedule-time-hrs-'+i;
                    variable_array['min-id'] = '#edit-schedule-time-min-'+i;
                    variable_array['ampm-id'] = '#edit-schedule-time-ampm-'+i;
                } else if (clock_type == 0) {
                    variable_array['timepicker-id'] = '#edit-schedule-time-0';
                }
                variable_array['selected-hrs'] = time[0];
                variable_array['selected-min'] = time[1];
                variable_array['selected-ampm'] = selected_time[1];
                add_new_time_slot(variable_array);
            }

            time_count = notification_time.length;

            $('#edit-rule-btn').attr('onclick','update_rule('+client_case_automated_email_notification_id+')');

            $('#edit-rule-modal').modal('show');
        } 
    });
}

function update_rule(client_case_automated_email_notification_id) {
    var check_notification_name_var = check_edit_notification_name(),
        check_email_subject_var = check_edit_email_subject(),
        check_email_description_var = check_edit_email_description(),
        check_client_name_var = check_edit_client_name(),
        check_case_type_var = check_edit_case_type(),
        check_add_new_time = add_edit_new_time('add-new'),
        check_edit_rule_cirteria_var = check_edit_rule_cirteria('edit_rule'),
        rule_cirteria = $('#edit-rule-cirteria').val();

    if(check_notification_name_var == 1 && check_email_subject_var == 1 && check_email_description_var == 1 && check_client_name_var == 1 && check_case_type_var == 1 && check_add_new_time == 1 && check_edit_rule_cirteria_var == 1) {
        $('#edit-rule-btn').prop('disabled',true);
        $('#edit-rule-error-msg-div').html('<span class="d-block text-center error-msg-div text-warning">Please wait while we are updating the reminder rule.</span>');
        var formdata = new FormData(),
            all_time = [];
        formdata.append('verify_admin_request',1);
        formdata.append('notification_name',$('#edit-notification-name').val());
        formdata.append('email_subject',$('#edit-email-subject').val());
        formdata.append('email_description',$('#edit-email-description').val());
        formdata.append('client_type',$('#edit-client-type').val());
        formdata.append('client_name',$('#edit-client-name').val());
        formdata.append('case_type',$('#edit-case-type').val());
        formdata.append('rule_cirteria',rule_cirteria);
        formdata.append('client_case_automated_email_notification_id',client_case_automated_email_notification_id);
        $('.edit-schedule-new-time').each(function() {
            all_time.push($(this).val());
        });

        $('.edit-schedule-time-main-div').each(function() {
            var input_id = $(this).attr('id').split('-');
            scheduled_time = $('#edit-schedule-time-hrs-'+input_id[5]).val()+':'+$('#edit-schedule-time-min-'+input_id[5]).val()+' '+$('#edit-schedule-time-ampm-'+input_id[5]).val();
            all_time.push(scheduled_time);
        });
        formdata.append('all_time',JSON.stringify(all_time));
        
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
        
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/update-client-notification-rule",
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == 1) {
                    $('#edit-rule-btn').prop('disabled',false);
                    $('#edit-rule-error-msg-div').html('');
                    if (data.rule_details.status == '1') {
                        $('#notification-name-'+client_case_automated_email_notification_id).html($('#edit-notification-name').val());
                        $('#edit-rule-modal').modal('hide');
                        toastr.success('Reminder rule has been updated successfully.');
                    } else {
                        toastr.error('Something went wrong while updating the reminder rule. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#edit-rule-btn').prop('disabled',false);
                $('#edit-rule-error-msg-div').html('');
                toastr.error('Something went wrong while updating the reminder rule. Please try again.');
            }
        });
    }
}