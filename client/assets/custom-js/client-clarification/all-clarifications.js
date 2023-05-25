$('#view-all-raised-client-clarification-log').on('click', function() {
    view_all_client_clarifications();
});

function view_all_client_clarifications(candidate_id,component_id,priority,component_name,component_index,form_values) {
    var formdata = new FormData();
        formdata.append('verify_client_request',1);
        formdata.append('candidate_id',candidate_id);
        formdata.append('component_id',component_id);
        formdata.append('component_index',component_index);
        formdata.append('user_component_form_filled_id','');

    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-all-client-clarifications",
        data : formdata,
        contentType : false,
        processData : false,
        dataType : "json",
        success : function(data) {
            var all_clarifications = data.all_clarifications,
                html = '',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list);

            if (data.all_clarifications.length > 0) {
                html = '';
                // html = '<div class="font-weight-bold">Client Clarifications</div>';
                // html += '<table class="table table-striped">';
                // html += '<thead class="thead-bd-color">';
                // html += '<tr>'
                // html += '<th>Sr No.</th>';
                // html += '<th>Subject</th>';
                // html += '<th>Status</th>';
                // html += '<th>Created Date</th>';
                // html += '<th>View</th>';
                // html += '</tr>';
                // html += '</thead>';
                // html += '<tbody class="tbody-datatable" id="client-clarification-log-list-'+component_index+'">';
                for (var i = 0; i < all_clarifications.length; i++) {
                    var status = '';
                    for (var j = 0; j < get_ticket_status_list.length; j++) {
                        if (get_ticket_status_list[j].id == all_clarifications[i].client_clarification_status) {
                            status = get_ticket_status_list[j].status;
                            break;
                        }
                    }
                    html += '<tr class="case-filter" id="tr_'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">';
                    html += '<td id="clarification-log-sr-no-'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">'+(i+1)+'</td>';
                    html += '<td id="clarification-log-subject'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">'+all_clarifications[i].client_clarification_subject+'</td>';
                    html += '<td id="clarification-ticket-status-'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">'+status+'</td>';
                    var variable_array = {};
                        variable_array['is_date_time'] = 1;
                        variable_array['date'] = all_clarifications[i]['client_clarification_created_date'];
                    // html += '<td id="clarification-log-created-date-'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">'+show_date_time_in_ist_format(variable_array)+'</td>';
                    html += '<td id="clarification-log-created-date-'+all_clarifications[i].user_filled_details_component_client_clarification_id+'">'+get_date_formate(all_clarifications[i]['client_clarification_created_date'])+'</td>';
                    html += '<td id="view_clarification_details_'+all_clarifications[i].user_filled_details_component_client_clarification_id+'"><a id="view_clarification_details_a_'+all_clarifications[i].user_filled_details_component_client_clarification_id+'" href="javascript:void(0)" onclick="view_clarification_details('+all_clarifications[i].user_filled_details_component_client_clarification_id+')"><img src="'+img_base_url+'assets/client/assets-v2/dist/img/black-eye.svg"></a></td>';
                    html += '</tr>';
                }
                // html += '</tbody>';
                // html += '</table>';
                // $('#client-clarification-log-list-div-'+component_index).html(html);
                $('#client-clarification-log-list').html(html);
            } else {
                html += '<tr><td colspan="5" class="text-center">No Client Clarification Found.</td></tr>'; 
            }
            $('#view-client-clarification-log-modal').modal('show');
        } 
    });
}

function view_clarification_details(user_filled_details_component_client_clarification_id) {
	var formdata = new FormData();
        formdata.append('verify_client_request',1);
        formdata.append('user_filled_details_component_client_clarification_id',user_filled_details_component_client_clarification_id);

	$.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-single-client-clarification-details",
        data : formdata,
        contentType : false,
        processData : false,
        dataType : "json",
        success : function(data) {
        	var clarification_details = data.clarification_details.clarification_details,
                clarification_status = '-',
                client_clarification_classifications = '-',
                show_client_clarification_status_html = '<select class="form-control" id="modal-change-error-status"><option value="">Change status</option>',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                get_ticket_priority_list = JSON.parse(data.get_ticket_priority_list);

            for (var i = 0; i < get_ticket_status_list.length; i++) {
                var selected = '';
                if(get_ticket_status_list[i].id == clarification_details.client_clarification_status) {
                    // selected = 'selected';
                    show_client_clarification_status_html = get_ticket_status_list[i].status;
                    break;
                }
                // show_client_clarification_status_html += '<option '+selected+' value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
            }
            // show_client_clarification_status_html += '</select>';
            $('#show-client-clarification-status-modal').html(show_client_clarification_status_html);
            // $('#show-client-clarification-status-btn-modal').html('<button class="btn btn-comment" id="update-error-status-btn" onclick="update_error_status('+clarification_details.user_filled_details_component_client_clarification_id+')">Save</button>');

            // $('#show-client-clarification-status-modal').html(clarification_status);
            $('#submit-client-clarification-new-note').attr('onclick','add_new_client_clarification_comment('+clarification_details.user_filled_details_component_client_clarification_id+')');
            $('#refresh-client-clarification-chat-btn').attr('onclick','show_all_client_clarification_comments('+clarification_details.user_filled_details_component_client_clarification_id+',"refresh_chat")');

            var client_clarification_priority = 'None';
            if (clarification_details.client_clarification_priority != 0) {
                for (var i = 0; i < get_ticket_priority_list.length; i++) {
                    if (clarification_details.client_clarification_priority == get_ticket_priority_list[i].id) {
                        client_clarification_priority = get_ticket_priority_list[i].priority;
                        break;
                    }
                }
            }
            $('#show-client-clarification-priority-modal').html(client_clarification_priority);

            if (clarification_details.client_clarification_classifications != '' && clarification_details.client_clarification_classifications != null && clarification_details.client_clarification_classifications != 'null') {
                client_clarification_classifications = clarification_details.client_clarification_classifications;
            }
            $('#show-client-clarification-classification-modal').html(client_clarification_classifications);

            if (clarification_details.client_clarification_attached_file != '' && clarification_details.client_clarification_attached_file != null && clarification_details.client_clarification_attached_file != 'no-file') {
                $('#raise-client-clarification-attached-modal-file-main-div').addClass('mt-3');
                var html = '<div class="col-md-5">Download the Attachment</div>';
                    html += '<div class="col-md-7"><a download href="../uploads/user-filled-details-component-client-clarification-attached-files/'+clarification_details.client_clarification_attached_file+'"><i class="fa fa-download"></i></a></div>';
                $('#raise-client-clarification-attached-modal-file-main-div').html(html);
            } else {
                $('#raise-client-clarification-attached-modal-file-main-div').removeClass('mt-3');
                $('#raise-client-clarification-attached-modal-file-main-div').html('');
            }

            $('#show-client-clarification-subject-modal').html(clarification_details.client_clarification_subject);
            $('#show-client-clarification-description-modal').html(clarification_details.client_clarification_description);
            
            show_all_client_clarification_comments(user_filled_details_component_client_clarification_id);
            $('#view-client-clarification-log-details-modal').modal('show');
        } 
    });
}

function add_new_client_clarification_comment(user_filled_details_component_client_clarification_id) {
    // var note_message = CKEDITOR.instances['note_message'].getData();
    var note_message = $('#client_clarification_note_message').val();
    if (note_message != '') {
        $('#client-clarification-note-message-error-msg-div').html('');
        $.ajax({
            type : "POST",
            url : base_url+"factsuite-client/add-new-client-clarification-comment",
            data : {
            	verify_client_request : 1,
                user_filled_details_component_client_clarification_id : user_filled_details_component_client_clarification_id,
                note_message : note_message
            },
            dataType: "json",
            success: function(data) {
                if (data.clarification_details.status == 1) {
                    $('#client_clarification_note_message').val('');
                    show_new_client_clarification_comment(user_filled_details_component_client_clarification_id,data.clarification_details.comment_id);
                    toastr.success('Clarification note has been added successfully.');
                } else {
                    toastr.error('Something went wrong while adding the clarification comment. Please try again.');
                }
            } 
        });
    } else {
        $('#client-clarification-note-message-error-msg-div').html('<span class="text-danger error-msg-small pl-2">Please enter your message.</span>');
    }
}

function show_new_client_clarification_comment(user_filled_details_component_client_clarification_id,comment_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-client-clarification-single-comment",
        data : {
        	verify_client_request : 1,
            user_filled_details_component_client_clarification_id : user_filled_details_component_client_clarification_id,
            comment_id : comment_id
        },
        dataType: "json",
        success: function(data) {
            if(data.clarification_details.status == 1) {
                var class_for_first_comment = '';
                if (data.clarification_details.clarification_count.count == 1) {
                    class_for_first_comment = ' single-timeline-last';
                }
                var html = '<div class="single-timeline-1'+class_for_first_comment+'">';
                    html += '<div class="timeline-item">';
                    // html += '<span class="time">';
                    // var variable_array = {};
                    //     variable_array['is_date_time'] = 1;
                    //     variable_array['date'] = data.clarification_details.clarification_comment.client_clarification_comment_created_date;
                    // html += '<i class="far fa-clock"></i> '+get_date_formate(data.clarification_details.clarification_comment.client_clarification_comment_created_date);
                    // // html += '<i class="far fa-clock"></i> '+show_date_time_in_ist_format(variable_array);
                    // html += '</span>';
                    // // ('+data.clarification_details.comment_added_by.spoc_name+')
                    // html += '<span> Added By : Client</span>';
                    // html += '<div class="timeline-body">'+data.clarification_details.clarification_comment.user_filled_details_component_client_clarification_comment+'</div>';
                    html += '<span class="ticket-comment-added-by-details"> Added By : Client</span>';
                    html += '<span class="time float-unset"><i class="far fa-clock"></i> '+get_date_formate(data.clarification_details.clarification_comment.client_clarification_comment_created_date)+'</span>';
                    html += '<div class="timeline-body"><span class="ticket-single-comment">'+data.clarification_details.clarification_comment.user_filled_details_component_client_clarification_comment+'</span></div>';
                    html += '</div>';
                    html += '</div>';
                    $('#client-clarification-timeline-chat').prepend(html);
            } else {
                show_all_client_clarification_comments(user_filled_details_component_client_clarification_id);
            }
        } 
    });
}

function show_all_client_clarification_comments(user_filled_details_component_client_clarification_id,request_from = '') {
    $('#client-clarification-timeline-chat').html('');
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-single-client-clarifications-all-comments",
        data : {
        	verify_client_request : 1,
            user_filled_details_component_client_clarification_id : user_filled_details_component_client_clarification_id
        },
        dataType: "json",
        success: function(data) {
            var clarification_details = data.clarification_details.clarification_commet,
                clarification_raised_by = data.clarification_details.clarification_raised_by,
                all_team_members = data.all_team_members,
                client_list = data.clarification_details.client_list;

            if(clarification_details.length > 0) {
                for (var i = 0; i < clarification_details.length; i++) {
                    var class_for_first_comment = '';
                    if (i == 0) {
                        class_for_first_comment = ' single-timeline-last';
                    }
                    var html = '<div class="single-timeline-1'+class_for_first_comment+'">';
                        html += '<div class="timeline-item">';
                        // html += '<span class="time">';
                        // var variable_array = {};
                        //     variable_array['is_date_time'] = 1;
                        //     variable_array['date'] = clarification_details[i].client_clarification_comment_created_date;
                        // html += '<i class="far fa-clock"></i> '+get_date_formate(clarification_details[i].client_clarification_comment_created_date);
                        // html += '<i class="far fa-clock"></i> '+show_date_time_in_ist_format(variable_array);
                        // html += '</span>';
                        var full_name = '';
                        if (clarification_details[i].component_client_clarification_commented_by_role != 'client') {
                            for (var j = 0; j < all_team_members.length; j++) {
                                if (clarification_details[i].component_client_clarification_commented_by_id == all_team_members[j].team_id) {
                                    full_name = all_team_members[j].first_name+' '+all_team_members[j].last_name;
                                    break;
                                }
                            }
                        } else {
                            for (var j = 0; j < client_list.length; j++) {
                                if (clarification_details[i].component_client_clarification_commented_by_id == client_list[j].spoc_id) {
                                    full_name = client_list[j].spoc_name;
                                    break;
                                }
                            }
                        }
                        // ('+full_name+')
                        // html += '<span> Added By : '+clarification_details[i].component_client_clarification_commented_by_role+'</span>';
                        // html += '<div class="timeline-body">'+clarification_details[i].user_filled_details_component_client_clarification_comment+'</div>';
                        html += '<span class="ticket-comment-added-by-details"> Added By : '+clarification_details[i].component_client_clarification_commented_by_role+'</span>';
                        html += '<span class="time float-unset"><i class="far fa-clock"></i> '+get_date_formate(clarification_details[i].client_clarification_comment_created_date)+'</span>';
                        html += '<div class="timeline-body"><span class="ticket-single-comment">'+clarification_details[i].user_filled_details_component_client_clarification_comment+'</span></div>';
                        html += '</div>';
                        html += '</div>';
                    $('#client-clarification-timeline-chat').prepend(html);
                }
            }

            if (request_from == 'refresh_chat') {
                check_client_clarification_error_status(user_filled_details_component_client_clarification_id);
            }
        } 
    });
}

function get_date_formate($param) {
    var it_works = $param;

    jQuery.ajax({
        type: "POST",
        url: base_url+'cases/get_date_formate',
        data:{curr_date:$param},
        async: false,
        success: function (data) {
            it_works = data;
        }
    });
    return it_works;
}