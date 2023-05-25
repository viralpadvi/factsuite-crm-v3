$('#view-all-raised-error-log').on('click', function() {
    view_all_error_logs();
});

function view_all_error_logs() {
	var formdata = new FormData();
        formdata.append('verify_specialist_request',1);
        formdata.append('candidate_id',$('#selected-hidden-candidate-id').val());
        formdata.append('component_id',$('#selected-hidden-component-id').val());
        formdata.append('component_index',$('#selected-hidden-component-index').val());
        formdata.append('user_component_form_filled_id',$('#selected-hidden-user-component-form-filled-id').val());

	$.ajax({
        type : "POST",
        url : base_url+"factsuite-specialist/get-all-error-log",
        data : formdata,
        contentType : false,
        processData : false,
        dataType : "json",
        success : function(data) {
        	var all_errors = data.all_errors,
        		html = '',
        		get_ticket_status_list = JSON.parse(data.get_ticket_status_list);

            if (data.all_errors.length > 0) {
                for (var i = 0; i < all_errors.length; i++) {
                	// var status = '';
                	// for (var j = 0; j < get_ticket_status_list.length; j++) {
                	// 	if (get_ticket_status_list[j].id == all_errors[i].error_status) {
                	// 		status = get_ticket_status_list[j].status;
                	// 		break;
                	// 	}
                	// }
                    html += '<tr class="case-filter" id="tr_'+all_errors[i].user_filled_details_component_error_id+'">';
                    html += '<td id="error-log-sr-no-'+all_errors[i].user_filled_details_component_error_id+'">'+(i+1)+'</td>';
                    html += '<td id="error-log-subject'+all_errors[i].user_filled_details_component_error_id+'">'+all_errors[i].error_description+'</td>';
                    // html += '<td id="ticket-status-'+all_errors[i].user_filled_details_component_error_id+'">'+status+'</td>';
                    html += '<td id="error-log-created-date-'+all_errors[i].user_filled_details_component_error_id+'">'+all_errors[i]['error_created_date']+'</td>';
                    html += '<td id="view_error_details_'+all_errors[i].user_filled_details_component_error_id+'"><a id="view_error_details_a_'+all_errors[i].user_filled_details_component_error_id+'" href="javascript:void(0)" onclick="view_error_details('+all_errors[i].user_filled_details_component_error_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Error Found.</td></tr>'; 
            }
            $('#error-log-list').html(html);
            $('#view-error-log-modal').modal('show');
        } 
    });
}

function view_error_details(user_filled_details_component_error_id) {
	var formdata = new FormData();
        formdata.append('verify_specialist_request',1);
        formdata.append('user_filled_details_component_error_id',user_filled_details_component_error_id);

	$.ajax({
        type : "POST",
        url : base_url+"factsuite-specialist/get-single-error-details",
        data : formdata,
        contentType : false,
        processData : false,
        dataType : "json",
        success : function(data) {
        	var error_details = data.error_details.error_details,
                error_status = '-',
                error_classifications = '-',
                show_error_status_html = '<select class="form-control" id="modal-change-error-status"><option value="">Change status</option>',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                get_ticket_priority_list = JSON.parse(data.get_ticket_priority_list),
                team_details = data.error_details.team_details;

            if(error_details.error_status != 1) {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(error_details.error_status == get_ticket_status_list[i].id) {
                        error_status = get_ticket_status_list[i].status;
                        break;
                    }
                }
                $('#show-error-status-modal').html(error_status);
                $('#show-error-status-btn-modal').html('');
            } else {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(get_ticket_status_list[i].id == 3) {
                        show_error_status_html += '<option value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
                        break;
                    }
                }
                show_error_status_html += '</select>';
                $('#show-error-status-modal').html(show_error_status_html);
                $('#show-error-status-btn-modal').html('<button class="btn btn-comment" id="update-error-status-btn" onclick="update_error_status('+error_details.user_filled_details_component_error_id+')">Save</button>');
            }
            // $('#show-error-status-modal').html(error_status);
            $('#submit-new-note').attr('onclick','add_new_error_comment('+error_details.user_filled_details_component_error_id+')');
            $('#refresh-chat-btn').attr('onclick','show_all_comments('+error_details.user_filled_details_component_error_id+',"refresh_chat")');

            var error_priority = 'None';
            if (error_details.error_priority != 0) {
                for (var i = 0; i < get_ticket_priority_list.length; i++) {
                    if (error_details.error_priority == get_ticket_priority_list[i].id) {
                        error_priority = get_ticket_priority_list[i].priority;
                        break;
                    }
                }
            }
            $('#show-error-priority-modal').html(error_priority);

            if (error_details.error_classifications != '' && error_details.error_classifications != null) {
                error_classifications = error_details.error_classifications;
            }
            $('#show-error-classification-modal').html(error_classifications);

            if (error_details.error_attached_file != '' && error_details.error_attached_file != null && error_details.error_attached_file != 'no-file') {
                $('#raise-error-attached-modal-file-main-div').addClass('mt-3');
                var html = '<div class="col-md-5">Download the Attachment</div>';
                    html += '<div class="col-md-7"><a download href="uploads/user-filled-details-component-error-attached-files/'+error_details.error_attached_file+'"><i class="fa fa-download"></i></a></div>';
                $('#raise-error-attached-modal-file-main-div').html(html);
            } else {
                $('#raise-error-attached-modal-file-main-div').removeClass('mt-3');
                $('#raise-error-attached-modal-file-main-div').html('');
            }

            $('#show-error-subject-modal').html(error_details.error_subject);
            $('#show-error-description-modal').html(error_details.error_description);
            
            show_all_comments(user_filled_details_component_error_id);
            $('#view-error-log-details-modal').modal('show');
        } 
    });
}

function add_new_error_comment(user_filled_details_component_error_id) {
    // var note_message = CKEDITOR.instances['note_message'].getData();
    var note_message = $('#note_message').val();
    if (note_message != '') {
        $('#note-message-error-msg-div').html('');
        $.ajax({
            type : "POST",
            url : base_url+"factsuite-specialist/add-new-error-comment",
            data : {
            	verify_specialist_request : 1,
                user_filled_details_component_error_id : user_filled_details_component_error_id,
                note_message : note_message
            },
            dataType: "json",
            success: function(data) {
                if (data.error_details.status == 1) {
                    $('#note_message').val('');
                    show_new_comment(user_filled_details_component_error_id,data.error_details.comment_id);
                    toastr.success('Error comment has been added successfully.');
                } else {
                    toastr.error('Something went wrong while adding the error comment. Please try again.');
                }
            } 
        });
    } else {
        $('#note-message-error-msg-div').html('<span class="text-danger error-msg-small pl-2">Please enter your message.</span>');
    }
}

function show_new_comment(user_filled_details_component_error_id,comment_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-specialist/get-error-single-comment",
        data : {
        	verify_specialist_request : 1,
            user_filled_details_component_error_id : user_filled_details_component_error_id,
            comment_id : comment_id
        },
        dataType: "json",
        success: function(data) {
            if(data.error_details.status == 1) {
                var class_for_first_comment = '';
                if (data.error_details.error_count.count == 1) {
                    class_for_first_comment = ' single-timeline-last';
                }
                var html = '<div class="single-timeline'+class_for_first_comment+'">';
                    html += '<div class="timeline-item">';
                    html += '<span class="time">';
                    html += '<i class="far fa-clock"></i> '+data.error_details.error_comment.user_filled_details_component_error_comment_created_date;
                    html += '</span>';
                    html += '<span> Added By : '+data.error_details.error_comment.user_filled_details_component_error_commented_by_role+' ('+data.error_details.comment_added_by.first_name+' '+data.error_details.comment_added_by.last_name+')</span>';
                    html += '<div class="timeline-body">'+data.error_details.error_comment.user_filled_details_component_error_comment+'</div>';
                    html += '</div>';
                    html += '</div>';
                    $('#timeline-chat').prepend(html);
            } else {
                show_all_comments(user_filled_details_component_error_id);
            }
        } 
    });
}

function show_all_comments(user_filled_details_component_error_id,request_from = '') {
    $('#timeline-chat').html('');
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-specialist/get-single-error-all-comments",
        data : {
        	verify_specialist_request : 1,
            user_filled_details_component_error_id : user_filled_details_component_error_id
        },
        dataType: "json",
        success: function(data) {
            var error_details = data.error_details.error_comments,
                error_raised_by = data.error_details.error_raised_by,
                raised_by_details = data.error_details.raised_by_details,
                all_team_members = data.all_team_members;

            if(error_details.length > 0) {
                for (var i = 0; i < error_details.length; i++) {
                    var class_for_first_comment = '';
                    if (i == 0) {
                        class_for_first_comment = ' single-timeline-last';
                    }
                    var html = '<div class="single-timeline'+class_for_first_comment+'">';
                        html += '<div class="timeline-item">';
                        html += '<span class="time">';
                        html += '<i class="far fa-clock"></i> '+error_details[i].user_filled_details_component_error_comment_created_date;
                        html += '</span>';
                        var full_name = '';
                        for (var j = 0; j < all_team_members.length; j++) {
                            if (error_details[i].user_filled_details_component_error_commented_by_id == all_team_members[j].team_id) {
                                full_name = all_team_members[j].first_name+' '+all_team_members[j].last_name;
                                break;
                            }
                        }
                        html += '<span> Added By : '+error_details[i].user_filled_details_component_error_commented_by_role+' ('+full_name+')</span>';
                        html += '<div class="timeline-body">'+error_details[i].user_filled_details_component_error_comment+'</div>';
                        html += '</div>';
                        html += '</div>';
                    $('#timeline-chat').prepend(html);
                }
            }

            if (request_from == 'refresh_chat') {
                check_error_status(user_filled_details_component_error_id);
            }
        } 
    });
}

function check_error_status(user_filled_details_component_error_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-specialist/get-single-error-details",
        data : {
            user_filled_details_component_error_id : user_filled_details_component_error_id
        },
        dataType: "json",
        success: function(data) {
            var ticket_details = data.ticket_details.ticket_details,
                ticket_status = '-',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                show_error_status_html = '<select class="form-control" id="modal-change-ticket-status"><option value="">Change status</option>';

            if(ticket_details.ticket_status != 1) {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(ticket_details.ticket_status == get_ticket_status_list[i].id) {
                        ticket_status = get_ticket_status_list[i].status;
                        break;
                    }
                }
                $('#show-error-status-modal').html(ticket_status);
                $('#show-error-status-btn-modal').html('');
            } else {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(get_ticket_status_list[i].id == 1) {
                        show_error_status_html += '<option value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
                        break;
                    }
                }
                show_error_status_html += '</select>';
                $('#show-error-status-modal').html(show_error_status_html);
                $('#show-error-status-btn-modal').html('<button class="btn btn-comment" id="update-ticket-status-btn" onclick="update_ticket_status('+ticket_details.ticket_id+')">Save</button>');
            }
        } 
    });
}