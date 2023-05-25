var password_length = 8,
    terms = ["NaN", "undefined","nan"];

get_filter_number_list();
function get_filter_number_list() {
    $.ajax({
        type: "POST",
        url: base_url+"custom_Util/get_custom_filter_number_list_v2", 
        dataType: "json",
        data : {
            verify_admin_request : 1
        },
        success: function(data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#filter-cases-number').html(html);
            get_all_cases();
        } 
    });
}

$dates = [];
load_dates();
function load_dates(){
     sessionStorage.clear(); 
    $.ajax({
        type: "POST",
        url: base_url+"holiday/get_holiday_details", 
        async: false,
        dataType: "json",
        success: function(data){   
  if (data.length > 0) { 
        for (var i = 0; i < data.length; i++) { 
          $dates.push(data[i].holiday_date); 
        }
      } 
         
        } 
    });
}
 
 
function get_all_cases(request_from = '') {
    sessionStorage.clear(); 

    $('#load-more-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
    $('#load-more-btn').removeAttr('onclick');

    if (request_from == 'filter_input' || request_from == 'bulk_reassigning') {
        $('#get-case-data').html('');
        $('#all-case-filter-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
        $('#all-case-filter-btn').removeAttr('onclick');
    }

    var filter_number = $('#filter-cases-number').val(),
        filter_input = $('#filter-input').val(),
        candidate_id_list = [],
        candidate_numbers_shown = [];

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    $('.case-filter').each(function() {
        candidate_numbers_shown.push($(this).data("candidate_display_number"));
    });

    $('#get-case-data').append('<tr id="spinner-indicator"><td colspan="13" class="text-center"><div class="spinner-border text-primary spinner-border-load-more"></div></td></tr>');
     $("#load-more-btn-div").show();
	$.ajax({
		type: "POST",
	  	url: base_url+"adminViewAllCase/getAllAssignedCases", 
        data: {
            candidate_id_list : candidate_id_list,
            filter_limit : filter_number,
            filter_input : filter_input,
            token:'3ZGErMDCwxTOZYFp'
        },
	  	dataType: "json",
	  	success: function(all_data) {
		    let html = '',
                data = all_data['cases'],
                selected_datetime_format = all_data.selected_datetime_format;
            if (data.length > 0) {
                var count = 1;
                // departureDate = futureDateDays(15)
                if (candidate_id_list.length > 0) {
                    count = candidate_id_list.length + 1;
                }
                var n = 1;
                for (var i = 0; i < data.length; i++) {
        	        var status = '',
                        classStatus = '',
                        fontAwsom = '';
        	        if (data[i].candidate.is_submitted == '0') {
                        // status = 'Pending';
                        classStatus = 'pending'
                        fontAwsom = '<i class="fa fa-check">'
                        status = '<span class="text-warning">Pending</span>';
                    } else if (data[i].candidate.is_submitted == '1') {
                        // status = 'Pending';
                        classStatus = 'pending'
                        fontAwsom = '<i class="fa fa-check">'
                        status = '<span class="text-info">Form&nbsp;Filled</span>';
                    } else if (data[i].candidate.is_submitted == '2') {
                        // status = 'Pending';
                        classStatus = 'pending'
                        fontAwsom = '<i class="fa fa-check">'
                        status = '<span class="text-success">Verified&nbsp;Clear</span>';
                    } else if (data[i].candidate.is_submitted == '3') {
                        // status = 'Pending';
                        classStatus = 'pending'
                        fontAwsom = '<i class="fa fa-check">'
                        status = '<span class="text-danger">Insuff</span>';
                    } else {
                        // status = 'Completed';
                        classStatus = 'pending'
                        fontAwsom = '<i class="fa fa-check">'
                        status = '<span class="text-warning">Pending</span>';
                    }

                    var outputQcName = '-'
                    // var outputQcName = '<span class="text-warning">Pending</span>'
                    if(data[i].outputQc != null) {
                        outputQcName = data[i].outputQc['first_name']+' '+data[i].outputQc['last_name'];
                    }

                    var inPutQcName = '-'
                    // var outputQcName = '<span class="text-warning">Pending</span>'
                    if(data[i].inputQc != null) {
                        inPutQcName = data[i].inputQc['first_name']+' '+data[i].inputQc['last_name'];
                    }

                    priority = '';
                    tat_days_color = '';
                    tat_days = '';
                    if(data[i].candidate.priority == '0') {
                        priority = '<span class="text-info font-weight-bold">Low</span>';
                        /*tat_days_color = '<span class="text-info font-weight-bold">'+data[i].client.low_priority_days+'</span>';
                        tat_days = data[i].client.low_priority_days;*/
                    } else if(data[i].candidate.priority == '1') {
                        priority = '<span class="text-warning  font-weight-bold">Medium</span>';
                       /* tat_days_color = '<span class="text-warning font-weight-bold">'+data[i].client.medium_priority_days+'</span>';
                        tat_days = data[i].client.medium_priority_days;*/
                    } else if(data[i].candidate.priority == '2') {
                        priority = '<span class="text-danger font-weight-bold">High</span>';
                       /* tat_days_color = '<span class="text-danger font-weight-bold">'+data[i].client.high_priority_days+'</span>';
                        tat_days = data[i].client.high_priority_days;*/
                    }

        	        html += '<tr class="case-filter" id="tr_'+data[i].candidate.candidate_id+'"  data-candidate_id="'+data[i].candidate.candidate_id+'" data-candidate_display_number="'+count+'">'; 
                    html += '<td id="candidate_check'+data[i].candidate.candidate_id+'">'+( n++ )+'</td>';
        	        // html += '<td>'+count+'</td>';
                    html += '<td id="first_name'+data[i].candidate.candidate_id+'">'+data[i].candidate.candidate_id+'</td>';
        	        html += '<td id="first_name'+data[i].candidate.candidate_id+'">'+data[i].candidate['first_name']+'</td>';
        	        html += '<td id="client_name_'+data[i].candidate.candidate_id+'">'+data[i].candidate['client_name']+'</td>';
                    var case_added_from = 'CRM';
                    if(data[i].candidate.candidate_details_added_from == 0) {
                        case_added_from = 'Website';
                    }
                    html += '<td class="d-none" id="case_added_from_'+data[i].candidate.candidate_id+'">'+data[i].candidate['social']+'</td>';
                    html += '<td id="case_added_from_'+data[i].candidate.candidate_id+'">'+case_added_from+'</td>';
                    html += '<td id="priority'+data[i].candidate_id+'">'+priority+'</td>';
                    var override_team_arg = data[i].candidate.candidate_id+','+i;
                    // if(inPutQcName != '-'  || (data[i].candidate.inputqc_id !='' && data[i].candidate.inputqc_id !='0')) {
                        html += '<td id="inputqc_emp_names_'+data[i].candidate.candidate_id+'" >';
                        html += '<select class="sel-allcase " id="inputqc_override_team_'+i+'" onchange="override_inputQc('+override_team_arg+',this.value)" title='+inPutQcName+'>';
                       html += '<option >Select</option>';
                        for (var e = 0; e < data[i].override_inputqc.length; e++) {  
                            if(data[i].candidate.assigned_inputqc_id == data[i].override_inputqc[e].team_id) {
                                html += '<option selected value="'+data[i].override_inputqc[e].team_id+'">'+data[i].override_inputqc[e].first_name+'&nbsp;('+data[i].override_inputqc[e].role+')</option>';
                            } else {
                                html += '<option value="'+data[i].override_inputqc[e].team_id+'">'+data[i].override_inputqc[e].first_name+'&nbsp;('+data[i].override_inputqc[e].role+')</option>';
                            }
                        }                                            
                        html += '</select>';
                        html += '</td>';
                    /*} else {
                        html += '<td id="inputqc_emp_names_'+data[i].candidate_id+'" >-</td>';
                    }*/ 

                    if(outputQcName != '-' || (data[i].outputqc_id !='' && data[i].outputqc_id !='0')) {
                        html += '<td id="outputqc_emp_names_'+data[i].candidate.candidate_id+'" >';
                        html += '<select class="sel-allcase" id="outputqc_override_team_'+i+'" onchange="override_outputqc('+override_team_arg+',this.value)" title='+outputQcName+'>';
                        html += '<option >Select</option>';
                        for (var e = 0; e < data[i].override_outputqc.length; e++) {
                            if(data[i].candidate.assigned_outputqc_id == data[i].override_outputqc[e].team_id){
                                html += '<option selected value="'+data[i].override_outputqc[e].team_id+'">'+data[i].override_outputqc[e].first_name+'&nbsp;('+data[i].override_outputqc[e].role+')</option>';
                            } else {
                                html += '<option value="'+data[i].override_outputqc[e].team_id+'">'+data[i].override_outputqc[e].first_name+'&nbsp;('+data[i].override_outputqc[e].role+')</option>';
                            }
                        }                                            
                        html += '</select>';
                        html += '</td>';
                    } else {
                        html += '<td id="outputqc_emp_names_'+data[i].candidate.candidate_id+'" >-</td>';
                    }
        	        html += '<td class"'+classStatus+'" id="status'+data[i].candidate.candidate_id+'">'+status+'</td>';

                    
                    var case_submitted_date = '';
                    if (data[i].candidate.case_submitted_date !=null && data[i].candidate.case_submitted_date !='') {
                        case_submitted_date = get_date_formate(data[i].candidate.case_submitted_date);
                    }
                    $report_generated_date ='';
                    if (data[i].candidate.report_generated_date !=null && data[i].candidate.report_generated_date !='') {
                        // moment(data[i].candidate.report_generated_date).format(selected_datetime_format['js_code'])
                       // $report_generated_date = chnageDateFormat(data[i].candidate.report_generated_date.split(" ")[0]);
                       $report_generated_date = get_date_formate(data[i].candidate.report_generated_date);
                    }
                    html += '<td class="text-center"><span>'+case_submitted_date+'</span></td>';
                    html += '<td class="text-center"><span>'+$report_generated_date+'</span></td>';
                    html += '<td class="text-center">'+data[i].left_tat_days+'</td>';
                    html += '<td class="text-center"><a href="'+base_url+'factsuite-csm/view-case-detail/'+data[i].candidate.candidate_id+'" ><i class="fa fa-eye"></i></a></div>';
        	        // html += '<a class="pl-2" href="javascript:void(0)" onclick="delete_case_modal('+data[i].candidate.candidate_id+')"><i class="fa fa-trash text-danger"></i></a></div></td>';
        	        html += '</tr>';
                    
                    count++;
                }
            } else {
                html += '<tr><td colspan="13" class="text-center">No Case Found.</td></tr>';
                 $("#load-more-btn-div").hide();
            }
            $('#spinner-indicator').remove();

            if (request_from == 'load_more') {
                $('#get-case-data').append(html); 
            } else {
                $('#get-case-data').html(html); 
            }

            get_new_cases_count();

            $('#all-case-filter-btn').html('Search');
            $('#all-case-filter-btn').attr('onclick','get_all_cases(\'filter_input\')');
	  	}
	});
}

function delete_case_modal(candidate_id) {
    $('#delete-case-verify-password-error-msg-div').html('');
    $('#delete-case-verify-password').val('');
    if (candidate_id != '') {
        $('#modal-hdr-delete-case-id, #modal-confirm-txt-delete-case-id, #modal-confirm-note-txt-delete-case-id').html(candidate_id);
        $('#delete-case-btn').attr('onclick','delete_case('+candidate_id+')');
        $('#delete-case-modal').modal('show');
    } else {
        get_all_cases('filter_input');
        toastr.warning('Something went wrong. Please try again.');
        $('#delete-case-modal').modal('hide');
    }
}

$("#delete-case-verify-password").on('keyup blur',function() {
    delete_case_verify_password();
});

function delete_case_verify_password() {
    var password = $('#delete-case-verify-password').val();
    if (password != '') {
        if (password.length < password_length) {
            $('#delete-case-verify-password-error-msg-div').html('<span class="text-danger error-msg-small">Password length should minimum '+password_length+' characters</span>');
            return 0;
        } else {
            $('#delete-case-verify-password-error-msg-div').html('');
            return 1;
        }
    } else {
        $('#delete-case-verify-password-error-msg-div').html('<span class="text-danger error-msg-small">Please enter your password</span>');
        return 0;
    }
}

function delete_case(candidate_id) {
    if (candidate_id != '') {
        var delete_case_verify_password_var = delete_case_verify_password();
        if (delete_case_verify_password_var == 1) {
            $('#delete-case-verify-password-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are processing the request.</span>');
            jQuery.ajax({
                type: "POST",
                url: base_url+'factsuite-admin/detete-case-permanently',
                dataType: "json",
                data: {
                    verify_admin_request : 1,
                    candidate_id : candidate_id,
                    password : $('#delete-case-verify-password').val()
                },
                success: function (data) {
                    if (data.status == 1) {
                        $('#filter-input').val('');
                        get_all_cases('filter_input');
                        toastr.success('Selected case successfully deleted permanently');
                        $('#delete-case-modal').modal('hide');
                    } else if(data.status == 2) {
                        $('#delete-case-verify-password-error-msg-div').html('<span class="text-danger error-msg-small">Entered password is incorrect. Please enter the correct password</span>');
                    }
                },
            });
        }
    } else {
        get_all_cases('filter_input');
        toastr.warning('Something went wrong. Please try again.');
        $('#delete-case-modal').modal('hide');
    }
}

function get_date_formate($param) {
    var it_works = $param;

jQuery.ajax({
  type: "POST",
  url: base_url+'custom_Util/get_actual_date_formate',
  data:{curr_date:$param},
  success: function (data) {
    it_works = data;
  }, 
  async: false 
}); 

return it_works;
}

function get_new_cases_count() {
    var filter_input = $('#filter-input').val(),
        candidate_id_list = [];

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    $.ajax({
        type : "POST",
        url : base_url+"factsuite-admin/get-new-cases-count",
        data : {
            candidate_id_list : candidate_id_list,
            filter_input : filter_input
        },
        dataType: "json",
        success: function(data) {
            if (data.new_cases_count > 0) {
                $('#load-more-btn-div').html('<button class="send-btn mt-0 mr-0 btn-filter-search" id="load-more-btn" onclick="get_all_cases(\'load_more\')">Load More</button>');
            } else {
                $('#load-more-btn-div').empty();
            }
        } 
    });
}

$('#filter-input').on('keyup', function() {
    var filter_input = $('#filter-input').val();
    if (filter_input == '') {
        get_all_cases('filter_input');
    }
});

$('#filter-input').on('keypress', function(e) {
    var key = e.which;
    if (key == 13) {
        get_all_cases('filter_input');
        return false;
    }
});

$('#load-more-btn').on('click', function() {
    get_all_cases('load_more');
});

$('#bulk-check-cases').on('click', function() {
    $('.candidate-list').prop('checked',false);
    if (this.checked == true) {
        var id = [];
        $('.candidate-list').each(function(i) {
            id[i] = $(this).val();
        });
        var check_length = id.length;
        // if (id.length > max_select_id_for_bulk_upload) {
        //    check_length = max_select_id_for_bulk_upload;
        // }

        for (var i = 0; i < check_length; i++) {
            $('#ids-'+id[i]).prop('checked',true);
        }

        check_bulk_cases_selected_or_not();
    } else {
        check_bulk_cases_selected_or_not();
        $('.candidate-list').prop('checked',false);
    }
});

$('#assign-to-dropdown').on('change', function() {
    var assign_to_dropdown = $('#assign-to-dropdown').val();
    $('#dropdown-2-div').empty();
    if (assign_to_dropdown == 'assign-to-inputqc') {
        $('#dropdown-2-div').html('<select class="form-control custom-iput-1" id="bulk-assign-to-inputqc" onchange="check_team_member_role_inputQC()"></select>');
        get_all_inutQC_list();
    } else if(assign_to_dropdown == 'assign-to-outputqc') {
        $('#dropdown-2-div').html('<select class="form-control custom-iput-1" id="bulk-assign-to-outputqc" onchange="check_team_member_role_outputQC()"></select>');
        get_all_oututQC_list();
    }
    $('#dropdown-2-div').append('<div id="bulk-assign-input-error-msg-div"></div>');
});

function get_all_inutQC_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-admin/get-role-list",
        data: {
            role_id : ['inputqc']
        },
        dataType: "json",
        success: function(data) {
            var html = '<option value="">Select InputQC</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].team_id+'">'+data[i].first_name+' '+data[i].last_name+'</option>';
            }
            $('#bulk-assign-to-inputqc').html(html);
        } 
    });
}

function get_all_oututQC_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-admin/get-role-list",
        data: {
            role_id : ['outputqc']
        },
        dataType: "json",
        success: function(data) {
            var html = '<option value="">Select OutputQC</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].team_id+'">'+data[i].first_name+' '+data[i].last_name+'</option>';
            }
            $('#bulk-assign-to-outputqc').html(html);
        } 
    });
}

function check_team_member_role_inputQC() {
    var inputqc_id = $('#bulk-assign-to-inputqc').val();
    $('#bulk-assign-input-error-msg-div').html('');
    if (inputqc_id != '') {
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/check-selected-team-member-role",
            data: {
                role_id : 'inputqc',
                team_member_id : inputqc_id
            },
            dataType: "json",
            success: function(data) {
                if(data != null && data != '') {
                    $('#bulk-assign-team-member-name').html(data.first_name+' '+data.last_name);
                    $('#bulk-assign-team-member-role').html('InputQC');
                    $('#btn-bulk-upload-confirm').attr('onclick','bulk_assign_cases_to_inputQC()');

                    $('#bulk-assign-modal-error-msg-div').html('');
                    $('#bulk-override-assignment-cases-modal').modal('show');
                } else {
                    $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid InputQC.</span>');
                    get_all_inutQC_list();
                }
            } 
        });
    } else {
        $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select an InputQC.</span>');
    }
}

function check_team_member_role_outputQC() {
    var outputqc_id = $('#bulk-assign-to-outputqc').val();
    $('#bulk-assign-input-error-msg-div').html('');
    if (outputqc_id != '') {
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/check-selected-team-member-role",
            data: {
                role_id : 'outputqc',
                team_member_id : outputqc_id
            },
            dataType: "json",
            success: function(data) {
                if(data != null && data != '') {
                    $('#bulk-assign-team-member-name').html(data.first_name+' '+data.last_name);
                    $('#bulk-assign-team-member-role').html('OutputQC');
                    $('#btn-bulk-upload-confirm').attr('onclick','bulk_assign_cases_to_outputQC()');
                    $('#bulk-assign-modal-error-msg-div').html('');

                    $('#bulk-override-assignment-cases-modal').modal('show');
                } else {
                    $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid OutputQC.</span>');
                    get_all_oututQC_list();
                }
            } 
        });
    } else {
        $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select an OutputQC.</span>');
    }
}

function bulk_assign_cases_to_inputQC() {
    var inputqc_id = $('#bulk-assign-to-inputqc').val(),
        candidate_id_list = [];

    $('.candidate-list:checked').each(function() {
        candidate_id_list.push($(this).val());
    });

    if (candidate_id_list.length > 0) {
        $('#btn-bulk-upload-confirm').removeAttr('onclick');
        $('#bulk-assign-modal-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are assigning to InputQC.</span>');
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/bulk-assign-cases-to-team-member",
            data: {
                role_id : 'inputqc',
                team_member_id : inputqc_id,
                candidate_id_list : candidate_id_list
            },
            dataType: "json",
            success: function(data) {
                $('#bulk-assign-modal-error-msg-div').html('');
                if(data.status == 1) {
                    get_all_cases('bulk_reassigning');
                    toastr.success('Assigned to the selected InputQC.');
                    $('#bulk-override-assignment-cases-modal').modal('hide');
                    
                    check_bulk_cases_selected_or_not();
                    $('#assign-to-dropdown').val('');
                    $('#dropdown-2-div').hide().empty();
                    $('.candidate-list').prop('checked',false);
                } else if(data.status == 0) {
                    $('#bulk-assign-modal-error-msg-div').html('<span class="text-danger error-msg-small">Something went wrong while assigning to InputQC. Please try again.</span>');
                } else {
                    $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid InputQC.</span>');
                    get_all_inutQC_list();
                }
            } 
        });
    } else {
        check_bulk_cases_selected_or_not();
        toastr.warning('Please select atleast one candidate.');
        $('#bulk-override-assignment-cases-modal').modal('hide');
    }
}

function bulk_assign_cases_to_outputQC() {
     var outputqc_id = $('#bulk-assign-to-outputqc').val(),
        candidate_id_list = [];

    $('.candidate-list:checked').each(function() {
        candidate_id_list.push($(this).val());
    });

    if (candidate_id_list.length > 0) {
        $('#btn-bulk-upload-confirm').removeAttr('onclick');
        $('#bulk-assign-modal-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are assigning to OutputQC.</span>');
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/bulk-assign-cases-to-team-member",
            data: {
                role_id : 'outputqc',
                team_member_id : outputqc_id,
                candidate_id_list : candidate_id_list
            },
            dataType: "json",
            success: function(data) {
                $('#bulk-assign-modal-error-msg-div').html('');
                if(data.status == 1) {
                    get_all_cases('bulk_reassigning');
                    toastr.success('Assigned to the selected OutputQC.');
                    $('#bulk-override-assignment-cases-modal').modal('hide');
                    
                    check_bulk_cases_selected_or_not();
                    $('#assign-to-dropdown').val('');
                    $('#dropdown-2-div').hide().empty();
                    $('.candidate-list').prop('checked',false);
                } else if(data.status == 0) {
                    $('#bulk-assign-modal-error-msg-div').html('<span class="text-danger error-msg-small">Something went wrong while assigning to OutputQC. Please try again.</span>');
                } else {
                    $('#bulk-assign-input-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid OutputQC.</span>');
                    get_all_oututQC_list();
                }
            } 
        });
    } else {
        check_bulk_cases_selected_or_not();
        toastr.warning('Please select atleast one candidate.');
        $('#bulk-override-assignment-cases-modal').modal('hide');
    }
}

function check_bulk_cases_selected_or_not() {
    var candidate_id_list = [];

    $('.candidate-list:checked').each(function() {
        candidate_id_list.push($(this).val());
    });

    if (candidate_id_list.length > 0) {
        $('#assign-to-dropdown-div, #dropdown-2-div').show();
    } else {
        $('#assign-to-dropdown-div, #dropdown-2-div').hide();
    }
}

$('#btn_pause_re_start_tat').on('click',function() {
    $('#all_case_TAT_confirm_dailog').modal({backdrop: 'static', keyboard: false},'show');
    $('#tat_hading').html('Are you sure you want to pause the all case TAT')
    $('#all_case_tat').attr('onclick', 'update_all_case_tat(\'pause\')');
});

$('#btn_re_start_tat').on('click',function() {
    $('#all_case_TAT_confirm_dailog').modal({backdrop: 'static', keyboard: false},'show');
    $('#tat_hading').html('Are you sure you want to re-start the all case TAT');
    $('#all_case_tat').attr('onclick', 'update_all_case_tat(\'re_start\')');
});

function update_all_case_tat(type) {
    $('#password_error').html('')
    var login_password = $('#login_password').val();
    
    if(login_password != null && login_password != ''){
        $('#all_case_tat_cancle').addClass('disabled');
        $('#all_case_tat_cancle').prop('disabled',true);
        $('#all_case_tat').addClass('disabled');
        $('#all_case_tat').prop('disabled',true);
        $('#all_case_tat').html('Confirming... <div class="spinner-border custom-spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div>')
    
        $.ajax({
            type: "POST",
            url: base_url+"adminViewAllCase/allCaseTatDateUpdate",
            data:{
                type:type,
                login_password:login_password
            },
            dataType: "json",
            success: function(data){
                // console.log(JSON.stringify(data)) 
                // alert(data.status)
                $('#all_case_tat_cancle').removeClass('disabled');
                $('#all_case_tat_cancle').prop('disabled',false);
                $('#all_case_tat').removeClass('disabled');
                $('#all_case_tat').prop('disabled',false);
                $('#all_case_tat').html('Confirm')
                if(data.status){
                    $('#all_case_TAT_confirm_dailog').modal('hide');
                    toastr.success('All case TAT updated successfully.');    
                }else if(data.msg == 'null'){
                    $('#password_error').html('<span class="text-danger">Please enter login password.</span>')
                }else if(data.msg == 'wrong credential'){
                    $('#password_error').html('<span class="text-danger">The wrong credential entered</span>')
                }else{
                    toastr.error('All case TAT update failed.');  
                }
                // $('#all_case_TAT_confirm_dailog').modal('hide')
                // if (data.status == '1' && data.logStatus == '1') { 
                //     toastr.success('priority has been update successfully.'); 
                // }else if(data.status == '1' && data.logStatus == '0') {
                //     toastr.error('assignment has been update successfully. but log data is not inserted.');
                // }else{
                //     toastr.error('assignment status update failed.');
                // }
            },error: function (jqXHR, exception) {
                $('#all_case_tat_cancle').removeClass('disabled');
                $('#all_case_tat_cancle').prop('disabled',false);
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }

                $('#password_error').html(msg)

            }
        });  
    }else{
        $('#password_error').html('<span class="text-danger">Please enter login password.</span>')
    }
}

function chnageDateFormat(date) {
    let monthNames =["Jan","Feb","Mar","Apr",
                      "May","Jun","Jul","Aug",
                      "Sep", "Oct","Nov","Dec"];
     var custom_date = new Date(date);  
     custom_date = custom_date.getDate()+'-'+monthNames[custom_date.getMonth()]+'-'+custom_date.getFullYear(); 
     return custom_date;               
}

function getEndDate(startDate,noOfDaysToAdd){ 
    if (endDate <= startDate) {
        return "Wrong Date";
    }
    startDate = new Date(startDate.replace(/-/g, "/"));
    var endDate = "", count = 0;
    while(count < noOfDaysToAdd){
        endDate = new Date(startDate.setDate(startDate.getDate() + 1));
        if(endDate.getDay() != 0 && endDate.getDay() != 6){
           count++;
        }
    }
 
    return chnageDateFormat(endDate) ;
}

var function_count =0 
let workingDaysBetweenDates = (startDate, endDate) => {
// let workingDaysBetweenDates = (d0, d1) => {
  /* Two working days and an sunday (not working day) */
  // var holidays = ['2016-05-03', '2016-05-05', '2016-05-07'];
  // var startDate = parseDate(startDate);
  // var endDate = parseDate(endDate);  
    console.log('Count: '+ ++function_count)
    console.log('startDate: '+startDate)
    console.log('endDate: '+endDate)
// Validate input
  // if (endDate <= startDate) {
  //   return 0;
  // }

// Calculate days between dates
  var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
  startDate.setHours(0, 0, 0, 1);  // Start just after midnight
  endDate.setHours(23, 59, 59, 999);  // End just before midnight
  var diff = endDate - startDate;  / Milliseconds between datetime objects    /
  var days = Math.ceil(diff / millisecondsPerDay);

  // Subtract two weekend days for every week in between
  var weeks = Math.floor(days / 7);
  days -= weeks * 2;

  // Handle special cases
  var startDay = startDate.getDay();
  var endDay = endDate.getDay();
    
  // Remove weekend not previously removed.   
  if (startDay - endDay > 1) {
    days -= 2;
  }
  // Remove start day if span starts on Sunday but ends before Saturday
  if (startDay == 0 && endDay != 6) {
    days--;  
  }
  // Remove end day if span ends on Saturday but starts after Sunday
  if (endDay == 6 && startDay != 0) {
    days--;
  }
  /* Here is the code */
  // holidays.forEach(day => {
  //   if ((day >= d0) && (day <= d1)) {
      /* If it is not saturday (6) or sunday (0), substract it */
  //     if ((parseDate(day).getDay() % 6) != 0) {
  //       days--;
  //     }
  //   }
  // });
  return days;
}



let workingDaysBetweenDate = (d0, d1) => {
  /* Two working days and an sunday (not working day) */
  var holidays = $dates;
  // alert(holidays)
  var startDate = parseDate(d0);
  var endDate = parseDate(d1);  

// Validate input
  if (endDate <= startDate) {
    return 0;
  }

// Calculate days between dates
  var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
  startDate.setHours(0, 0, 0, 1);  // Start just after midnight
  endDate.setHours(23, 59, 59, 999);  // End just before midnight
  var diff = endDate - startDate;  // Milliseconds between datetime objects    
  var days = Math.ceil(diff / millisecondsPerDay);

  // Subtract two weekend days for every week in between
  var weeks = Math.floor(days / 7);
  days -= weeks * 2;

  // Handle special cases
  var startDay = startDate.getDay();
  var endDay = endDate.getDay();
    
  // Remove weekend not previously removed.   
  if (startDay - endDay > 1) {
    days -= 2;
  }
  // Remove start day if span starts on Sunday but ends before Saturday
  if (startDay == 0 && endDay != 6) {
    days--;  
  }
  // Remove end day if span ends on Saturday but starts after Sunday
  if (endDay == 6 && startDay != 0) {
    days--;
  }
  /* Here is the code */
  holidays.forEach(day => {
    if ((day >= d0) && (day <= d1)) {
      /* If it is not saturday (6) or sunday (0), substract it */
      if ((parseDate(day).getDay() % 6) != 0) {
        days--;
      }
    }
  });
  return days;
}

           
function parseDate(input) {
    // Transform date from text to date
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}

function differenceBetweenTwoDates(startDate,endDate){
    // var start = $('#start_date').val();
    // var end = $('#end_date').val();

    // // end - start returns difference in milliseconds 
    // var diff = new Date(end - start);

    // // get days
    // var days = diff/1000/60/60/24;


    var start = startDate;
    var end = endDate;

    var diffInDays = end.diff(start, 'days');

    if (diffInDays > 0)
    {
        return diffInDays;
    }
    else
    {
        return 0;
    }
}


function override_inputQc(candidate_id,postion,team_id){
    // alert(team_id)
    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="override_inputQc_action('+candidate_id+',\''+postion+'\',\''+team_id+'\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>') 

}
 
function override_inputQc_action(candidate_id,postion,team_id){

    // alert('candidate_id:'+candidate_id+'\n postion:'+postion+'\n team_id:'+team_id)
    // return false
     $.ajax({
        type: "POST",
        url: base_url+"am/overrideInputQc",
        data:{
            candidate_id:candidate_id,
            postion:postion,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') { 
                toastr.success('Assignment has been updated successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('Assignment has been updated successfully. but log data is not inserted.');
            }else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}


function override_outputqc(candidate_id,postion,team_id){
    // alert(team_id)
    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="override_outputqc_action('+candidate_id+',\''+postion+'\',\''+team_id+'\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')    
}
 
function override_outputqc_action(candidate_id,postion,team_id){
    // alert('candidate_id:'+candidate_id+'\n postion:'+postion+'\n team_id:'+team_id)
    // return false
    $.ajax({
        type: "POST",
        url: base_url+"am/overrideOutputQc",
        data:{
            candidate_id:candidate_id,
            postion:postion,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') {
                 
                toastr.success('Assignment has been updated successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('Assignment has been updated successfully. but log data is not inserted.');
            }else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}

function get_single_cases_detail(id){

    $.ajax({
        type: "POST",
        url: base_url+"inputQc/get_single_cases_detail", 
        data:{
            id:id
        },
        dataType: "json",
        success: function(data){ 
            
        let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
            var status = '';
            if (data[i].is_submitted == '0') {
                // status = 'Pending';
                status = '<span class="text-warning">Pending</span>';
            }else{
                // status = 'Completed';
                status = '<span class="text-sucess">Completed</span>';
            }

            // if (data[i].vendor_status == '1') {
            //     check = 'checked';
            // } else {
            //     check = '';
            // }

            html += '<tr id="tr_'+data[i].candidate_id+'">'; 
            html += '<td>'+j+'</td>';
            html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
            html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
            html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
            html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
            html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
            html += '<td id="status'+data[i].candidate_id+'">'+status+'</td>';
            html += '<td class="text-center"><a onclick="view_edit_team('+data[i].candidate_id+')" href="'+base_url+"inputQc/get_single_cases_detail/"+encodeURIComponent(btoa(data[i].candidate_id))+'"><i class="fa fa-eye"></i></a></div></td>';
            // html += '<td>';
            // html += '<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].candidate_id +'">'+
            //                         '<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].candidate_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_candidate_status_'+data[i].candidate_id +'">'+
            //                         '<label class="custom-control-label" for="change_vendor_status_'+data[i].candidate_id +'"></label>'+
            //                     '</div>';
            // html += '<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].candidate_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>';
            // html += '</td>';
            html += '</tr>';




          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
        } 
    });
}
 function randomString(length) {
    var result = '';
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}
 function view_case_progress(candidate_id){
     
    $('#View').modal('show');
     var statusPage = '2'
     var randomChars = randomString(7);
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/getSingleAssignedCaseDetails/"+randomChars, 
        data:{
            candidate_id:candidate_id,
            statusPage:statusPage
        },
        dataType: "json",
        success: function(data){ 
            // console.log(JSON.stringify(data))
            var date = new Date(); 
            date. setDate(date.getDate() + 10);
            // var pdate = date.split(' ') 
            var caseEndDate =  date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear();
            // roundProgress(data)       
            if (data.length > 0) {
                var caseStatus= ''
                if(data[0]['is_submitted'] == 0){
                    caseStatus = 'Pending'
                }else if(data[0]['is_submitted'] == 1){
                    caseStatus = 'In Progress'
                }else if(data[0]['is_submitted'] == 2){
                    caseStatus = 'Completed'
                }
                $('#candidate-id').html(data[0].candidate_id)
                $('#candidate-name').html(data[0]['title']+". "+data[0]['first_name']+" "+data[0]['last_name'])
                $('#phone-number').html(data[0]['phone_number'])
                $('#Email-id').html(data[0]['email_id'])
                $('#date-of-birth').html(data[0]['date_of_birth'])
                $('#case-date').html(data[0]['created_date'])
                $('#case-status').html(caseStatus)
                $('#case-end-date').html(caseEndDate)
                 
                let html='';
                html += '<li class="active">';
                html += '   <div class="view-tp"><span class="view-bg1">Candidate Form</span></div>';
                html += '   <div class="view-nm">Updated By <span class="view-bg1 text-capitalize">'+data[0]['document_uploaded_by']+'</span></div>';
                html += '   <div class="view-btm">';
                html += '       <span>Start</span>'+data[0]['created_date'];
                html += '   </div>';
                html += '</li>';
                html += '<li class="active">';
                html += '   <div class="view-tp">';
                html +=         '<span class="view-bg1 text-capitalize">Persional Info</span>';
                html +=     '</div>';
                html += '   <div class="view-nm">Updated By';
                html +=         '<span class="view-bg1 text-capitalize">'+data[0]['document_uploaded_by']+'</span></div>';
                html += '   <div class="view-btm">';
                html += '       <span>Start</span> 12 Feb 2020';
                html += '   </div>';
                html += '</li>';

                totalCompletedComponentIds = [];
                for(var i=0;i<data.length;i++){
                    var status ='';
                    if(data[i].component_status != null && data[i].component_status != ''){
                        if(data[i].component_status.analyst_status == '0'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '1'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '2'){
                            status = 'active'
                        }else if(data[i].component_status.analyst_status == '3'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '4'){
                            status = 'active'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '5'){
                            status = 'deadline'
                        }else if(data[i].component_status.analyst_status == '6'){
                            status = 'deadline'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '7'){
                            status = 'pending'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '8'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '9'){
                            status = 'active'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }
                    }else{
                       status = 'pending' 
                    }

                    componentCreatedDate = '';
                    if(data[i].component_status != null){
                        componentCreatedDate = data[i].component_status.created_date
                    }else{
                        componentCreatedDate = data[0]['created_date']
                    }
                    html += '<li class="'+status+'">';
                    html += '   <div class="view-tp">';
                    html +=         '<span class="view-bg1 text-capitalize">'+data[i].component_name+'</span>';
                    html +=     '</div>';
                    html += '   <div class="view-nm">Updated By';
                    html +=         '<span class="view-bg1 text-capitalize">'+data[i].document_uploaded_by+'</span></div>';
                    html += '   <div class="view-btm">';
                    html += '       <span>Start</span>'+componentCreatedDate;
                    html += '   </div>';
                    html += '</li>';
                }
                // html += '<li class="deadline">';
                //     html += '<div class="view-btm">';
                //         html += '<span class="view-bg3">Dead Line </span>'+caseEndDate;
                //     html += '</div>';
                // html += '</li>';

                $('#milestones-ul').html(html) 

                var percentageTotal = (parseInt(totalCompletedComponentIds.length+2)/data[0].component_id_total)*100
                percentageTotal = Math.round(percentageTotal,2);
                $('#progress-percentage').html(percentageTotal+"%") 
                roundProgress(parseInt(percentageTotal))
            }else{

            }

        }
    });
 }

function roundProgress(percentageTotal){ 
    $(".progress").each(function() {
        // alert(percentageTotal);
        // var value = $(this).attr('data-value');
        var value = percentageTotal
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
          if (value <= 50) {
            // alert('if');
            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            left.css('transform', 'rotate(0deg)')
          } else {
            // alert('else');
            right.css('transform', 'rotate(180deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
          }
        }
    })
}
function percentageToDegrees(percentage) {
    return percentage / 100 * 360
}


  


// function get_single_cases_detail(id){}
