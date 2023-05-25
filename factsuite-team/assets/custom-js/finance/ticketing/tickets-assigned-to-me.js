get_all_assigned_tickets();
function get_all_assigned_tickets() {
	$.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-all-assigned-tickets",
        data : {
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
        	var all_tickets = data.all_tickets,
        		html = '',
        		get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                fs_team_list = data.all_team_members,
                fs_client_list = data.all_clients,
                selected_datetime_format = data.selected_datetime_format;

            if (data.all_tickets.length > 0) {
                for (var i = 0; i < all_tickets.length; i++) {
                	var status = '',
                        role = '';
                	for (var j = 0; j < get_ticket_status_list.length; j++) {
                		if (get_ticket_status_list[j].id == all_tickets[i].ticket_status) {
                			status = get_ticket_status_list[j].status;
                			break;
                		}
                	}

                    if(all_tickets[i].ticket_created_by_role == 'client') {
                        role = 'client';
                    } else {
                        for (var j = 0; j < fs_team_list.length; j++) {
                            if (all_tickets[i].ticket_created_by_role_id == fs_team_list[j].team_id) {
                                role = fs_team_list[j].role;
                                break;
                            }
                        }
                    }
                    html += '<tr class="case-filter" id="tr_'+all_tickets[i].ticket_id+'">';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+(i+1)+'</td>';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+all_tickets[i].ticket_id+'</td>';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+role+'</td>';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+all_tickets[i]['ticket_subject']+'</td>';
                    html += '<td id="start_date'+all_tickets[i].ticket_id+'">'+moment(all_tickets[i]['ticket_created_date']).format(selected_datetime_format['js_code'])+'</td>';
                    html += '<td id="ticket-status-'+all_tickets[i].ticket_id+'">'+status+'</td>';
                    html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].ticket_id+'"><a id="view_ticket_details_a'+all_tickets[i].ticket_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].ticket_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                }
            } else {
                html += '<tr><td colspan="8" class="text-center">No Tickets Found.</td></tr>'; 
            }
            $('#get-all-tickets').html(html);
        } 
    });
}

function view_ticket_details(ticket_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-ticket-details",
        data : {
            ticket_id : ticket_id,
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
            var ticket_details = data.ticket_details.ticket_details,
                ticket_raised_by_name = '-',
                raised_ticket_phone_number = '-',
                raised_ticket_email_id = '-',
                ticket_status = '-',
                ticket_classifications = '-',
                show_ticket_status_html = '<select class="form-control" id="modal-change-ticket-status">',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list);
                get_ticket_priority_list = JSON.parse(data.get_ticket_priority_list);
                
            if (ticket_details.ticket_created_by_role == 'client') {

            } else {
                var created_by_details = data.ticket_details.created_by_details;
                ticket_raised_by_name = created_by_details.first_name+' '+created_by_details.last_name;
                raised_ticket_phone_number = created_by_details.contact_no;
                raised_ticket_email_id = created_by_details.team_employee_email;
            }
            $('#ticket-raised-by-name, #raised-ticket-about-full-name').html(ticket_raised_by_name);
            $('#raised-ticket-about-phone-number').html('+91-'+raised_ticket_phone_number);
            $('#raised-ticket-about-email-id').html(raised_ticket_email_id);
            for (var i = 0; i < get_ticket_status_list.length; i++) {
                var selected = '';
                if(ticket_details.ticket_status == get_ticket_status_list[i].id) {
                    selected = 'selected';
                    ticket_status = get_ticket_status_list[i].status;
                }
                show_ticket_status_html += '<option '+selected+' value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
            }
            show_ticket_status_html += '</select>';
            $('#show-ticket-status-modal').html(show_ticket_status_html);
            $('#update-ticket-status-btn').attr('onclick','update_ticket_status('+ticket_details.ticket_id+')');
            $('#submit-new-note').attr('onclick','add_new_ticket_comment('+ticket_details.ticket_id+')');
            $('#refresh-chat-btn').attr('onclick','show_all_comments('+ticket_details.ticket_id+',"refresh_chat")');
            
            var ticket_priority = 'None';
            if (ticket_details.ticket_priority != 0) {
                for (var i = 0; i < get_ticket_priority_list.length; i++) {
                    if (ticket_details.ticket_priority == get_ticket_priority_list[i].id) {
                        ticket_priority = get_ticket_priority_list[i].priority;
                        break;
                    }
                }
            }
            $('#show-ticket-priority-modal').html(ticket_priority);

            if (ticket_details.ticket_classifications != '' && ticket_details.ticket_classifications != null) {
                ticket_classifications = ticket_details.ticket_classifications;
            }
            $('#show-ticket-classification-modal').html(ticket_classifications);

            if (ticket_details.ticket_attached_file != '' && ticket_details.ticket_attached_file != null && ticket_details.ticket_attached_file != 'no-file') {
                $('#raise-ticket-attached-modal-file-main-div').addClass('mt-3');
                var html = '<div class="col-md-5">Download the Attachment</div>';
                    html += '<div class="col-md-7"><a download href="uploads/ticket-attached-files/'+ticket_details.ticket_attached_file+'"><i class="fa fa-download"></i></a></div>';
                $('#raise-ticket-attached-modal-file-main-div').html(html);
            } else {
                $('#raise-ticket-attached-modal-file-main-div').removeClass('mt-3');
                $('#raise-ticket-attached-modal-file-main-div').html('');
            }

            $('#show-ticket-subject-modal').html(ticket_details.ticket_subject);
            $('#show-ticket-description-modal').html(ticket_details.ticket_description);
            
            var ticket_status_html = '-';
            if(ticket_details.ticket_status == 0) {
                ticket_status_html = '<i class="far fa-clock text-warning"></i>Open';
            } else if(ticket_details.ticket_status == 1) {
                ticket_status_html = '<i class="fa fa-check text-success"></i>Closed';
            } else if(ticket_details.ticket_status == 2) {
                ticket_status_html = '<i class="fa fa-exclamation text-warning"></i>In Progress';
            } else if(ticket_details.ticket_status == 3) {
                ticket_status_html = '<i class="far fa-clock text-warning"></i>Re-Open';
            }
            $('#show-ticket-status').html(ticket_status_html);
            show_all_comments(ticket_id);

            $('#view-ticket-details-modal').modal('show');
        } 
    });
}

function update_ticket_status(ticket_id) {
    var change_ticket_status = $('#modal-change-ticket-status').val();
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/update-ticket-status",
        data : {
            ticket_id : ticket_id,
            change_ticket_status : change_ticket_status,
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
            if (data.ticket_details.status == 1) {
                var ticket_status_html = '-',
                    ticket_status = '-';
                if(change_ticket_status == 0) {
                    ticket_status_html = '<i class="fa fa-exclamation text-warning"></i>Open';
                    ticket_status = 'Open';
                } else if(change_ticket_status == 1) { 
                    ticket_status_html = '<i class="fa fa-check text-success"></i>Closed';
                    ticket_status = 'Closed';
                } else if(change_ticket_status == 2) { 
                    ticket_status_html = '<i class="fa fa-exclamation text-warning"></i>In Progress';
                    ticket_status = 'In Progress';
                } else if(change_ticket_status == 3) { 
                    ticket_status_html = '<i class="far fa-clock text-warning"></i>Re-Open';
                    ticket_status = 'Re-Open';
                }
                $('#show-ticket-status').html(ticket_status_html);
                $('#ticket-status-'+ticket_id).html(ticket_status);
                show_new_comment(ticket_id,data.ticket_details.comment_id);

                toastr.success('Ticket status has been updated successfully.');
            } else {
                toastr.error('Something went wrong while updating the ticket status. Please try again.');
            }
        } 
    });
}

function add_new_ticket_comment(ticket_id) {
    // var note_message = CKEDITOR.instances['note_message'].getData();
    var note_message = $('#note_message').val();
    if (note_message != '') {
        $('#note-message-error-msg-div').html('');
        $.ajax({
            type : "POST",
            url : base_url+"factsuite-finance/add-new-ticket-comment",
            data : {
                ticket_id : ticket_id,
                note_message : note_message,
                verify_finance_request : 1
            },
            dataType: "json",
            success: function(data) {
                if (data.ticket_details.status == 1) {
                    $('#note_message').val('');
                    show_new_comment(ticket_id,data.ticket_details.comment_id);
                    toastr.success('New note is added successfully.');
                } else {
                    toastr.error('Something went wrong while adding the ticket note. Please try again.');
                }
            } 
        });
    } else {
        $('#note-message-error-msg-div').html('<span class="text-danger error-msg-small pl-2">Please enter your message.</span>');
    }
}

function show_new_comment(ticket_id,comment_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-ticket-single-comment",
        data : {
            ticket_id : ticket_id,
            comment_id : comment_id,
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
            if(data.ticket_details.status == 1) {
                var class_for_first_comment = '',
                    selected_datetime_format = data.selected_datetime_format;
                if (data.ticket_details.ticket_count.count == 1) {
                    class_for_first_comment = ' single-timeline-last';
                }
                var html = '<div class="single-timeline'+class_for_first_comment+'">';
                    html += '<div class="timeline-item">';
                    html += '<span class="time">';
                    html += '<i class="far fa-clock"></i> '+moment(data.ticket_details.ticket_comment.ticket_comment_created_date).format(selected_datetime_format['js_code']);
                    html += '</span>';
                    html += '<span> Added By : '+data.ticket_details.ticket_comment.ticket_comment_by_role+' ('+data.ticket_details.comment_added_by.first_name+' '+data.ticket_details.comment_added_by.last_name+')</span>';
                    html += '<div class="timeline-body">'+data.ticket_details.ticket_comment.ticket_comment+'</div>';
                    html += '</div>';
                    html += '</div>';
                    $('#timeline-chat').prepend(html);
                $('.extra-border').removeClass('d-none');
            } else {
                show_all_comments(ticket_id);
            }
        } 
    });
}

function show_all_comments(ticket_id) {
    $('#timeline-chat').html('');
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-single-ticket-all-comments",
        data : {
            ticket_id : ticket_id,
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
            var ticket_comments = data.ticket_details.ticket_comments,
                ticket_raised_by = data.ticket_details.ticket_raised_by,
                raised_by_details = data.ticket_details.raised_by_details,
                all_team_members = data.all_team_members,
                selected_datetime_format = data.selected_datetime_format;

            if(ticket_comments.length > 0) {
                $('.extra-border').removeClass('d-none');
                for (var i = 0; i < ticket_comments.length; i++) {
                    var class_for_first_comment = '';
                    if (i == 0) {
                        class_for_first_comment = ' single-timeline-last';
                    }
                    var html = '<div class="single-timeline'+class_for_first_comment+'">';
                        html += '<div class="timeline-item">';
                        html += '<span class="time">';
                        html += '<i class="far fa-clock"></i> '+moment(ticket_comments[i].ticket_comment_created_date).format(selected_datetime_format['js_code']);
                        html += '</span>';
                        var full_name = '';
                        if (ticket_comments[i].ticket_comment_by_role == 'client') {
                            full_name = '';
                        } else {
                            for (var j = 0; j < all_team_members.length; j++) {
                                if (ticket_comments[i].ticket_comment_by_id == all_team_members[j].team_id) {
                                    full_name = all_team_members[j].first_name+' '+all_team_members[j].last_name;
                                    break;
                                }
                            }
                        }
                        html += '<span> Added By : '+ticket_comments[i].ticket_comment_by_role+' ('+full_name+')</span>';
                        html += '<div class="timeline-body">'+ticket_comments[i].ticket_comment+'</div>';
                        html += '</div>';
                        html += '</div>';
                    $('#timeline-chat').prepend(html);
                }
            } else {
                $('.extra-border').addClass('d-none');
            }
        } 
    });
}