// get_all_raised_tickets();
function get_all_raised_tickets() {
	$.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-all-raised-tickets",
        data : {
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
        	var all_tickets = data.all_tickets,
        		html = '',
        		get_ticket_status_list = JSON.parse(data.get_ticket_status_list);

            if (data.all_tickets.length > 0) {
                for (var i = 0; i < all_tickets.length; i++) {
                	var status = '';
                	for (var j = 0; j < get_ticket_status_list.length; j++) {
                		if (get_ticket_status_list[j].id == all_tickets[i].ticket_status) {
                			status = get_ticket_status_list[j].status;
                			break;
                		}
                	}
                    html += '<tr class="case-filter" id="tr_'+all_tickets[i].ticket_id+'">';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+(i+1)+'</td>';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+all_tickets[i].ticket_id+'</td>';
                    html += '<td id="first_name'+all_tickets[i].ticket_id+'">'+all_tickets[i]['ticket_subject']+'</td>';
                    html += '<td id="start_date'+all_tickets[i].ticket_id+'">'+get_date_formate(all_tickets[i]['ticket_created_date'])+'</td>';
                    html += '<td id="ticket-status-'+all_tickets[i].ticket_id+'">'+status+'</td>';
                    html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].ticket_id+'"><a id="view_ticket_details_a'+all_tickets[i].ticket_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].ticket_id+')"><img src="'+img_base_url+'assets/client/assets-v2/dist/img/black-eye.svg"></i></a></td>';
                    html += '</tr>';
                }
            } else {
                html += '<tr><td colspan="8" class="text-center">No Tickets Found.</td></tr>'; 
            }
            $('#get-all-tickets').html(html);
        } 
    });
}

function get_date_formate($param) {
    var it_works = $param;

jQuery.ajax({
  type: "POST",
  url: base_url+'cases/get_date_formate',
  data:{curr_date:$param},
  success: function (data) {
    it_works = data;
  }, 
  async: false 
}); 

return it_works;
}

function view_ticket_details(ticket_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-ticket-details",
        data : {
            ticket_id : ticket_id,
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
            var ticket_details = data.ticket_details.ticket_details,
                ticket_status = '-',
                ticket_classifications = '-',
                show_ticket_status_html = '<select class="form-control" id="modal-change-ticket-status"><option value="">Change status</option>',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                get_ticket_priority_list = JSON.parse(data.get_ticket_priority_list),
                team_details = data.ticket_details.team_details;

            if(ticket_details.ticket_status != 1) {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(ticket_details.ticket_status == get_ticket_status_list[i].id) {
                        ticket_status = get_ticket_status_list[i].status;
                        break;
                    }
                }
                $('#show-ticket-status-modal').html(ticket_status);
                $('#show-ticket-status-btn-modal').html('');
            } else {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(get_ticket_status_list[i].id == 3) {
                        show_ticket_status_html += '<option value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
                        break;
                    }
                }
                show_ticket_status_html += '</select>';
                $('#show-ticket-status-modal').html(show_ticket_status_html);
                $('#show-ticket-status-btn-modal').html('<button class="btn btn-comment" id="update-ticket-status-btn" onclick="update_ticket_status('+ticket_details.ticket_id+')">Save</button>');
            }
            // $('#show-ticket-status-modal').html(ticket_status);
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
                var html = '<div class="col-md-12">Download Attachment</div>';
                    html += '<div class="col-md-9">';
                    html += '<div class="download-ticket-attachment-div"><div class="row"><div class="col-md-10 download-ticket-attachment-name">'+ticket_details.ticket_attached_file+'</div>';
                    html += '<div class="col-md-2"><a class="download-ticket-attachment-a" download href="uploads/ticket-attached-files/'+ticket_details.ticket_attached_file+'"><img src="'+img_base_url+'assets/client/assets-v2/dist/img/download-v2.svg" class="download-ticket-attachment-a"></i></a></div></div></div></div>';
                $('#raise-ticket-attached-modal-file-main-div').html(html);
            } else {
                $('#raise-ticket-attached-modal-file-main-div').removeClass('mt-3');
                $('#raise-ticket-attached-modal-file-main-div').html('');
            }

            $('#show-ticket-subject-modal').html(ticket_details.ticket_subject);
            $('#show-ticket-description-modal').html(ticket_details.ticket_description);
            
            show_all_comments(ticket_id);

            $('#view-ticket-details-modal').modal('show');
        } 
    });
}

function update_ticket_status(ticket_id) {
    var change_ticket_status = $('#modal-change-ticket-status').val();
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/update-ticket-status",
        data : {
            ticket_id : ticket_id,
            change_ticket_status : change_ticket_status,
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
            if (data.ticket_details.status == 1) {
                var ticket_status = '-',
                    get_ticket_status_list = JSON.parse(data.get_ticket_status_list);
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(change_ticket_status == get_ticket_status_list[i].id) {
                        ticket_status = get_ticket_status_list[i].status;
                        break;
                    }
                }
                $('#show-ticket-status-modal, #ticket-status-'+ticket_id).html(ticket_status);

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
            url : base_url+"factsuite-client/add-new-ticket-comment",
            data : {
                ticket_id : ticket_id,
                note_message : note_message,
                verify_client_request : 1
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
        url : base_url+"factsuite-client/get-ticket-single-comment",
        data : {
            ticket_id : ticket_id,
            comment_id : comment_id,
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
            if(data.ticket_details.status == 1) {
                var class_for_first_comment = '';
                if (data.ticket_details.ticket_count.count == 1) {
                    class_for_first_comment = ' single-timeline-last';
                }
                var html = '<div class="single-timeline-1'+class_for_first_comment+'">';
                    html += '<div class="timeline-item">';
                    // ('+data.ticket_details.comment_added_by.first_name+' '+data.ticket_details.comment_added_by.last_name+')
                    // html += '<span> Added By : '+data.ticket_details.ticket_comment.ticket_comment_by_role+'</span>';
                    // html += '<span class="time">';
                    // html += '<i class="far fa-clock"></i> '+data.ticket_details.ticket_comment.ticket_comment_created_date;
                    // html += '</span>';
                    // html += '<div class="timeline-body">'+data.ticket_details.ticket_comment.ticket_comment+'</div>';
                    // html += '</div>';
                    // html += '</div>';

                    html += '<span class="ticket-comment-added-by-details"> Added By : '+data.ticket_details.ticket_comment.ticket_comment_by_role+'</span>';
                    html += '<span class="time float-unset"><i class="far fa-clock"></i> '+data.ticket_details.ticket_comment.ticket_comment_created_date+'</span>';
                    html += '<div class="timeline-body"><span class="ticket-single-comment">'+data.ticket_details.ticket_comment.ticket_comment+'</span></div>';
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

function show_all_comments(ticket_id,request_from = '') {
    $('#timeline-chat').html('');
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-single-ticket-all-comments",
        data : {
            ticket_id : ticket_id,
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
            var ticket_comments = data.ticket_details.ticket_comments,
                ticket_raised_by = data.ticket_details.ticket_raised_by,
                raised_by_details = data.ticket_details.raised_by_details,
                all_team_members = data.all_team_members;

            if(ticket_comments.length > 0) {
                $('.extra-border').removeClass('d-none');
                for (var i = 0; i < ticket_comments.length; i++) {
                    var class_for_first_comment = '';
                    if (i == 0) {
                        class_for_first_comment = ' single-timeline-last';
                    }
                    var html = '<div class="single-timeline-1'+class_for_first_comment+'">';
                        html += '<div class="timeline-item">';

                        // var full_name = '';
                        // for (var j = 0; j < all_team_members.length; j++) {
                        //     if (ticket_comments[i].ticket_comment_by_id == all_team_members[j].team_id) {
                        //         full_name = all_team_members[j].first_name+' '+all_team_members[j].last_name;
                        //         break;
                        //     }
                        // }
                        // ('+full_name+')
                        html += '<div><span class="ticket-comment-added-by-details"> Added By : '+ticket_comments[i].ticket_comment_by_role+'</span>';
                        html += '<span class="time float-unset"><i class="far fa-clock"></i> '+ticket_comments[i].ticket_comment_created_date+'</span></div>';
                        html += '<div class="timeline-body"><span class="ticket-single-comment">'+ticket_comments[i].ticket_comment+'</span></div>';
                        html += '</div>';
                        html += '</div>';
                    $('#timeline-chat').prepend(html);
                }
            } else {
                $('.extra-border').addClass('d-none');
            }

            if (request_from == 'refresh_chat') {
                check_ticket_status(ticket_id);
            }
        } 
    });
}

function check_ticket_status(ticket_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-client/get-ticket-details",
        data : {
            ticket_id : ticket_id,
            verify_client_request : 1
        },
        dataType: "json",
        success: function(data) {
            var ticket_details = data.ticket_details.ticket_details,
                ticket_status = '-',
                get_ticket_status_list = JSON.parse(data.get_ticket_status_list),
                show_ticket_status_html = '<select class="form-control" id="modal-change-ticket-status"><option value="">Change status</option>';

            if(ticket_details.ticket_status != 1) {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(ticket_details.ticket_status == get_ticket_status_list[i].id) {
                        ticket_status = get_ticket_status_list[i].status;
                        break;
                    }
                }
                $('#show-ticket-status-modal').html(ticket_status);
                $('#show-ticket-status-btn-modal').html('');
            } else {
                for (var i = 0; i < get_ticket_status_list.length; i++) {
                    if(get_ticket_status_list[i].id == 1) {
                        show_ticket_status_html += '<option value="'+get_ticket_status_list[i].id+'">'+get_ticket_status_list[i].status+'</option>';
                        break;
                    }
                }
                show_ticket_status_html += '</select>';
                $('#show-ticket-status-modal').html(show_ticket_status_html);
                $('#show-ticket-status-btn-modal').html('<button class="btn btn-comment" id="update-ticket-status-btn" onclick="update_ticket_status('+ticket_details.ticket_id+')">Save</button>');
            }
        } 
    });
}