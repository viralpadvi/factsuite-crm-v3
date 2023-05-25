get_all_raised_tickets();
function get_all_raised_tickets() {
    $.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/get_approval_data_am_csm",
        data : {
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
            var all_tickets = data,
                html = '';

            if (data.length > 0) {
                for (var i = 0; i < all_tickets.length; i++) {
                    var status_one = 'Pending';
                    if (all_tickets[i].level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(all_tickets[i].level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (all_tickets[i].level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(all_tickets[i].level_two_status =='2') {
                        status_two = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (all_tickets[i].final_approval_status =='1') {
                        status = 'Accepted';
                    }else if(all_tickets[i].final_approval_status =='2') {
                        status = 'Rejected';
                    }
                     
                        var action = 'Creating';
                    if (all_tickets[i].type_of_action =='0') {
                        action = 'Creating';
                    }else if(all_tickets[i].type_of_action =='1') {
                        action = 'Deletion';
                    }else if(all_tickets[i].type_of_action =='3' && all_tickets[i].created_by_role =='csm') {
                        action = 'Rate';
                    }else if(all_tickets[i].created_by_role =='analyst' || all_tickets[i].created_by_role =='specialist'){
                        action = 'Fee';  
                    }

                    html += '<tr class="case-filter" id="tr_'+all_tickets[i].approval_id+'">';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+(i+1)+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i].approval_id+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+action+'</td>';
                    html += '<td id="start_date'+all_tickets[i].approval_id+'">'+get_date_formate(all_tickets[i]['approval_created_date'])+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['remarks']+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['team_name']+' ('+all_tickets[i].created_by_role+')</td>';
                     
                    html += '<td id="ticket-status-'+all_tickets[i].approval_id+'">'+status+'</td>';
                    html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].approval_id+'"><a id="view_ticket_details_a'+all_tickets[i].approval_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].approval_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                    } 
                }
             
            $('#get-all-tickets').html(html);
        } 
    });
}

function get_date_formate($param){
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
function view_ticket_details(approval_id) {
 $("#remarks-additionals").hide();
$("#additionals").hide();
   $("#action-status").val(1);
   $("#action-status").hide();

    $.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/get_approvals_data",
        data : {
            approval_id : approval_id,
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
                var action = 'Creating';
                var flag = 0;
                    if (data.type_of_action =='0') {
                        action = 'Creating';
                    }else if(data.type_of_action =='1') {
                        action = 'Deletion';
                        flag = 1;
                    }else if(data.type_of_action =='3' && data.created_by_role =='csm') {
                        action = 'Rate';  
                    }else if(data.created_by_role =='analyst' || data.created_by_role =='specialist'){
                        action = 'Fee';
                    }
                    var  level = 0;

                    var emp_id =0;
                    var matching_id = $("#matching_id").val();
                    if (data.level_one_status =='0') {
                         level = 1;
                         emp_id =data.level_one_id;
                    }else if(data.level_two_status =='0'){
                         level = 2;
                         emp_id =data.level_two_id;
                    }else if(data.approval_status =='0'){
                         level = 3;
                         emp_id =data.approved_by;

                    }
                    $("#approval-level").val(level);

                    $("#type-of-approval").val(data.number_of_list)
                    $("#flag").val(flag)
                    
                     if (data.levels !='') {
                        j =1;
                        for (var i = 0; i < data.levels.levels; i++) { 
                            $("#status_level_"+j++).show();
                        }
                    }



                        var access = [];
                            var level_one = '';
                            var level_two = '';
                            var level_tree = '';
                    if (data.teams.length > 0) {
                        var team = data.teams;
                        for (var i = 0; i < team.length; i++) {
                            if (team[i].approval_access_level !='' && team[i].approval_access_level !=null) {
                                access = team[i].approval_access_level.split(',');
                           
                            for (var k = 0; k < access.length; k++) {
                                 if (1== access[k]) { 
                                var select ='';
                                if (team[i].team_id == data.level_one_id) {
                                  
                               level_one += '( '+team[i].first_name+' )'; 
                                }
                            }
                            if (2== access[k]) {
                                var selecte ='';
                                if (team[i].team_id == data.level_two_id) {
                                   level_two += '( '+team[i].first_name+' )'; 
                                } 
                            }
                            if (3== access[k]) {
                                var selected ='';
                                if (team[i].team_id == data.approved_by) {
                                     level_tree += '( '+team[i].first_name+' )'; 
                                } 
                            }

                            }
                            }

                           


                        }
                    }

                       var status_one = 'Pending';
                    if (data.level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(data.level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (data.level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(data.level_two_status =='2') {
                        status_two = 'Rejected';
                    }

                     var status_three = 'Pending';
                    if (data.approval_status =='1') {
                        status_three = 'Accepted';
                    }else if(data.approval_status =='2') {
                        status_three = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (data.final_approval_status =='1') {
                        status = 'Accepted';
                    }else if(data.final_approval_status =='2') {
                        status = 'Rejected';
                    }

                            $("#level_one").html(status_one+level_one);
                            $("#level_two").html(status_two+level_two);
                            $("#level_three").html(status_three+level_tree);
                            $("#final_status").html(status);

                    var html = '';
                        let comp = '';
                        if (data.final_approval_status =='2') {
                            var rem = data.approve_remarks;
                            if (data.approve_additional_remarks !=null) {
                                rem += data.approve_additional_remarks;
                            }
                             $("#rejected_remarks").html("Rejected Remarks: "+rem);
                        }
                    comp += '<label>Details : </lable>';
                    if(data.type_of_action =='3' && data.created_by_role =='csm'){
                       var component = JSON.parse(data.components);
                        if (component.length > 0) {
                            for (var i = 0; i < component.length; i++) {
                                
                                // comp += '<label>Components</lable>';
                                comp +='<div class="col-md-4">'
                                    comp +='<div class=" custom-control">' 
                                    comp +='<label   >'+component[i].component_name
                                    comp +='</label>' 
                                 comp += '</div>'; 
                                 comp += '<div  class=" custom-control">'; 
                                 comp += '<input type="text" readonly value="'+component[i].form_values+'" id="component-text-'+component[i].component_id+'" class="form-control" placeholder="Add Comment" >';
                                 comp +='<label class="" > Current '+component[i].component_price
                                    comp +='</label>'
                                 comp += '</div>'; 
                                 comp += '</div>'; 
                            }
                        } 
                    }else if(data.created_by_role =='analyst' || data.created_by_role =='specialist'){
                         comp +='<div class="col-md-12">';
                        
                          comp += '</div>'; 
                         comp +='<div class="col-md-4">'
                                comp +='<div class=" custom-control">' 
                                comp +='<label   >'+data.component_name
                                comp +='</label>' 
                                 comp += '</div>'; 
                                 comp += '<div  class=" custom-control">'; 
                                 comp += '<input type="text" readonly value="'+data.amount+'"  class="form-control"  >';
                                 comp +='<label class="" > Current '+data.currency
                                    comp +='</label>'
                                 comp += '</div>'; 
                                 comp += '</div>';
                    }else if(data.created_by_role.trim() =='it administrator'){
                          var component = JSON.parse(data.components);
                        if (component.length > 0) { 
                         comp +='<div class=" custom-control">First Name: '+data.first_name+'</div><br>'
                         comp +='<div class=" custom-control">Last Name: '+data.last_name+'</div><br>'
                         comp +='<div class=" custom-control">Email: '+data.user_name+'</div><br>' 
                             
                    } 
                    } 

                    var remarks = data.remarks;
                    if (remarks =='Others') {
                        remarks = data.remarks+'('+data.additional_remarks+')';
                    }


                  console.log(JSON.stringify(data))
             $("#created_by").html(data.team_name+' ('+data.created_by_role+')'); 
              $("#action_type").html(action); 
               $("#created_remarks").html(remarks); 
                   
                $("#approver-remarks").val(data.approve_remarks)

                if (data.number_of_list =='1' || data.number_of_list =='1' ) {
                    if (data.client_data !='') {
                         var htm  = "<div class='custom-control'> Client Name :</div>"+data.client_data.client_name;
                        $("#extra-details").html(htm);
                    }
                }else{
                    $("#extra-details").html(comp);
                }

                             $("#edit-role-close-btn").hide();  
                               $("#raise-ticket-btn").hide();

                               // $("#action-status").hide();

                           if(data.final_approval_status =='1'){
                             $("#action-status").hide();
                               $("#edit-role-close-btn").hide(); 
                                $("#remarks-additionals").hide(); 
                                 $("#raise-ticket-btn").show();
                               $("#raise-ticket-btn").html('Accepted');
                            }else if(data.final_approval_status =='2'){
                                $("#action-status").hide();
                                 $("#raise-ticket-btn").show();
                                 $("#remarks-additionals").hide(); 
                               $("#raise-ticket-btn").html('Rejected');  
                            }

                if (data.team.length > 0) {
                    var access_level = 100;
                    if (data.team[0].approval_access_level !='') { 
                         access_level = data.team[0].approval_access_level.split(','); 
                         
                        for (var i = 0; i < access_level.length; i++) { 

                            if (access_level[i] == level && matching_id == emp_id) {
                                    if (data.final_approval_status =='0') {
                                $("#raise-ticket-btn").show();

                               $("#action-status").show();
                                $("#raise-ticket-btn").html('Confirm');
                                // $("#edit-role-close-btn").attr('onclick','approve_the_mechanism('+approval_id+',2)');
                                $("#raise-ticket-btn").attr('onclick','approve_the_mechanism('+approval_id+',1)');
                            }
                         }
                               
                        }
                    }
                    }

                 

            $("#add-new-ticket-modal").modal('show');
            remarks_all();
             

           } 
    });
}

function approve_the_mechanism(approval_id,status){ 
        var level = $("#approval-level").val();
        var statuss = $("#action-status").val();
        var description = $("#ticket_description").val();
         var additional_remarks = $("#additional_remarks").val();  
        var statuss = $("#action-status").val();
        var approval_link ='';
        if (level =='1') {
            approval_link = "Approval_Mechanisms/update_approval_data_level_one";
        }else if(level =='2'){
            approval_link = "Approval_Mechanisms/update_approval_data_level_two";
        }else{
           approval_link = "Approval_Mechanisms/update_approval_data"; 
        }
        $.ajax({
        type : "POST",
        url : base_url+approval_link,
        data : {
            remarks : $("#approver-remarks").val(),
            approval_id : approval_id,
            status : statuss,
            description : description,
            additional_remarks : additional_remarks,
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
             toastr.success('Approval status has been updated successfully.');
            $("#add-new-ticket-modal").modal('hide');
            get_all_raised_tickets();
            $("#edit-role-close-btn").attr('onclick','');
            $("#raise-ticket-btn").attr('onclick','');
           } 
    });
}


function update_ticket_status(approval_id) {
    var change_ticket_status = $('#modal-change-ticket-status').val();
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-csm/update-ticket-status",
        data : {
            approval_id : approval_id,
            change_ticket_status : change_ticket_status,
            verify_csm_request : 1
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
                $('#show-ticket-status-modal, #ticket-status-'+approval_id).html(ticket_status);

                show_new_comment(approval_id,data.ticket_details.comment_id);

                toastr.success('Ticket status has been updated successfully.');
            } else {
                toastr.error('Something went wrong while updating the ticket status. Please try again.');
            }
        } 
    });
}

function add_new_ticket_comment(approval_id) {
    // var note_message = CKEDITOR.instances['note_message'].getData();
    var note_message = $('#note_message').val();
    if (note_message != '') {
        $('#note-message-error-msg-div').html('');
        $.ajax({
            type : "POST",
            url : base_url+"factsuite-csm/add-new-ticket-comment",
            data : {
                approval_id : approval_id,
                note_message : note_message,
                verify_csm_request : 1
            },
            dataType: "json",
            success: function(data) {
                if (data.ticket_details.status == 1) {
                    $('#note_message').val('');
                    show_new_comment(approval_id,data.ticket_details.comment_id);
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

function show_new_comment(approval_id,comment_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-csm/get-ticket-single-comment",
        data : {
            approval_id : approval_id,
            comment_id : comment_id,
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
            if(data.ticket_details.status == 1) {
                var class_for_first_comment = '';
                if (data.ticket_details.ticket_count.count == 1) {
                    class_for_first_comment = ' single-timeline-last';
                }
                var html = '<div class="single-timeline'+class_for_first_comment+'">';
                    html += '<div class="timeline-item">';
                    html += '<span class="time">';
                    html += '<i class="far fa-clock"></i> '+data.ticket_details.ticket_comment.ticket_comment_created_date;
                    html += '</span>';
                    html += '<span> Added By : '+data.ticket_details.ticket_comment.ticket_comment_by_role+' ('+data.ticket_details.comment_added_by.first_name+' '+data.ticket_details.comment_added_by.last_name+')</span>';
                    html += '<div class="timeline-body">'+data.ticket_details.ticket_comment.ticket_comment+'</div>';
                    html += '</div>';
                    html += '</div>';
                    $('#timeline-chat').prepend(html);
                $('.extra-border').removeClass('d-none');
            } else {
                show_all_comments(approval_id);
            }
        } 
    });
}

function show_all_comments(approval_id,request_from = '') {
    $('#timeline-chat').html('');
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-csm/get-single-ticket-all-comments",
        data : {
            approval_id : approval_id,
            verify_csm_request : 1
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
                    var html = '<div class="single-timeline'+class_for_first_comment+'">';
                        html += '<div class="timeline-item">';
                        html += '<span class="time">';
                        html += '<i class="far fa-clock"></i> '+ticket_comments[i].ticket_comment_created_date;
                        html += '</span>';
                        var full_name = '';
                        for (var j = 0; j < all_team_members.length; j++) {
                            if (ticket_comments[i].ticket_comment_by_id == all_team_members[j].team_id) {
                                full_name = all_team_members[j].first_name+' '+all_team_members[j].last_name;
                                break;
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

            if (request_from == 'refresh_chat') {
                check_ticket_status(approval_id);
            }
        } 
    });
}

function check_ticket_status(approval_id) {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-csm/get-ticket-details",
        data : {
            approval_id : approval_id,
            verify_csm_request : 1
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
                $('#show-ticket-status-btn-modal').html('<button class="btn btn-comment" id="update-ticket-status-btn" onclick="update_ticket_status('+ticket_details.approval_id+')">Save</button>');
            }
        } 
    });
} 



$("#action-type").on('change',function(){
    if ($(this).val() =='0') {}
remarks_all();
})


function remarks_all() {
    var type_of_approval = $('#type-of-approval').val();  
    var flag = $('#flag').val();  
   

    $.ajax({
        type: "POST",
        url: base_url+"approval_Mechanisms/get_reject_remarks", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {

            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].status == type_of_approval && (data[i].flag == flag || flag == '2' || flag == '3') ) { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}

$("#action-status").on('change',function(){
    var type = $(this).val();
    if (type =='2') {
        $("#remarks-additionals").show();
    }else{
        $("#remarks-additionals").hide();
    }
})


$("#ticket_description").on('change',function(){
    $('#ticket-description-error-msg-div').html("");
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
})
