var max_img_size = 10000000,
    new_ticket_attach_file_array = [];

get_ticket_priority_list();
function get_ticket_priority_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-ticket-priority-list", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].id+'">'+data[i].priority+'</option>';
            }
            $('#ticket-priority').html(html);
        } 
    });
}

$("#type-of-approval").on('change',function(){
remarks_all();
})

remarks_all();
function remarks_all() {
    var type_of_approval = $('#type-of-approval').val();  
    var flag =1;
    if (type_of_approval =='1') {
         flag =1;
    }

    $.ajax({
        type: "POST",
        url: base_url+"approval_Mechanisms/get_all_remarks", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {

            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].status == '1' && data[i].flag == flag) { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}

$("#ticket_description").on('change',function(){
    $('#ticket-description-error-msg-div').html("");
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
})


$(".radio-client").on('change',function(){
    var radio = $(this).val();
    if (radio == 'master') {
       $("#master-client").hide(); 
        }else{
          $("#master-client").show();   
        }
});

  $("#type-of-approval").on('change',function(){
        var type = $(this).val();
        
        if (type == 0) {
           $("#client-list").hide(); 
           $("#client-type").show();
           $("#new-user-name-div").show();
        }else{
          $("#client-list").show();   
          $("#client-type").hide();
           $("#new-user-name-div").hide();
        }
    });
get_ticket_classification_list();
function get_ticket_classification_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-ticket-classification-list",
        data : {
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#ticket-classifications').html(html);
        } 
    });
}

get_roles_list();
function get_roles_list() {
   /* $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-roles-list", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {
            if (data.all_roles.length > 0) {
                var all_roles = data.all_roles;
                for (var i = 0; i < all_roles.length; i++) {
                    html += '<option value="'+all_roles[i].role_name+'">'+all_roles[i].role_name+'</option>';
                }
            }*/
            var html = '<option value="">Select Role</option>';
                html += '<option selected value="client">Client</option>';
            $('#assigned-to-role').html(html);
      /*  } 
    });*/
}
// get_roles_person_list();

function get_roles_person_list() {
    $.ajax({
        type: "POST",
        url: base_url+"client/get_view_client", 
        dataType: "json",
        data : {
            verify_csm_request : 1,
            role_type : 'client'
        },
        success: function(data) {
            var html = '<option value="">Select Client</option>';
            if (data.length > 0) {
                var all_persons = data;
                for (var i = 0; i < all_persons.length; i++) {
                    html += '<option value="'+all_persons[i].client_id+'">'+all_persons[i].client_name+'</option>';
                }
            }
            $('#assigned-to-person').html(html);
        } 
    });
}

$('#assigned-to-role').on('change', function() {
    check_assigned_to_role();
});

$('#assigned-to-person').on('change', function() {
    check_assigned_to_person();
});

$('#ticket-subject').on('keyup blur', function() {
    check_ticket_subject();
});

$("#ticket-attach-file").on("change", handle_file_select_new_ticket_attach_file);

$('#raise-ticket-btn').on('click', function() {
    raise_new_ticket();
});

function check_assigned_to_role() {
    var variable_array = {};
    variable_array['input_id'] = '#assigned-to-role';
    variable_array['error_msg_div_id'] = '#assigned-to-role-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a role.';
    var mandatory_select_var = mandatory_select(variable_array);
    if (mandatory_select_var == 1) {
        get_roles_person_list();
    } else {
        $('#assigned-to-person').html('<option value="">Select Client</option>');
    }
    return mandatory_select_var;
}

function check_assigned_to_person() {
    var variable_array = {};
    variable_array['input_id'] = '#assigned-to-person';
    variable_array['error_msg_div_id'] = '#assigned-to-person-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a Client.';
    return mandatory_select(variable_array);
}

function check_ticket_subject() {
    var variable_array = {};
    variable_array['input_id'] = '#ticket-subject';
    variable_array['error_msg_div_id'] = '#ticket-subject-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the text subject';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function handle_file_select_new_ticket_attach_file(e) {
    new_ticket_attach_file_array = [];
    var variable_array = {};
    variable_array['e'] = e;
    variable_array['file_id'] = '#ticket-attach-file';
    variable_array['show_image_name_msg_div_id'] = '#ticket-attach-file-error-msg-div';
    variable_array['storedFiles_array'] = new_ticket_attach_file_array;
    variable_array['col_type'] = 'col-md-12';
    variable_array['file_ui_id'] = 'file_new_ticket_attach';
    variable_array['file_size'] = max_img_size;
    variable_array['exceeding_max_length_error_msg'] = 'Attached file should be of max 1MB';
    return not_mandatory_single_file_upload(variable_array);
}

function raise_new_ticket() {
    var assigned_to_role = $('#assigned-to-role').val(),
        assigned_to_person = $('#assigned-to-person').val(),  
        ticket_description = $('#ticket_description').val(),
        ticket_priority = $('#ticket-priority').val();

    var check_assigned_to_role_var = check_assigned_to_role(),
        check_assigned_to_person_var = check_assigned_to_person();
        var type_of_approval = $('#type-of-approval').val(); 
        var radio_client = $('.radio-client:checked').val();
          var additional_remarks = $("#additional_remarks").val();  

          var user_name = $("#new-user-name").val();  
          var client_master = $("#user-name").val();  

 
    if (check_assigned_to_role_var == 1 &&  ticket_description != '') {
        $('#ticket-classifications-error-msg-div').html('');
        $('#raise-ticket-btn').prop('disabled',true);
        $('#raise-ticket-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are adding the Approval Request.</span>');

        var formdata = new FormData();
        formdata.append('verify_csm_request',1);
        formdata.append('assigned_to_role',assigned_to_role);
        formdata.append('assigned_to_person_id',assigned_to_person); 
        formdata.append('description',ticket_description);  
        formdata.append('type_of_approval',type_of_approval);  
        formdata.append('client_type',radio_client);  
        formdata.append('additional_remarks',additional_remarks);  
        formdata.append('client_master',client_master);  
        formdata.append('user_name',user_name);  

        

        $.ajax({
            type: "POST",
            url: base_url+"approval_Mechanisms/create_approval_for_client",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == '1') {
                    $('#raise-ticket-btn').prop('disabled',false);
                    $('#raise-ticket-error-msg-div').html('');
                    
                        toastr.success('Your Request has been raised successfully.');
                        $('#add-new-ticket-modal').modal('hide');
                        $('#assigned-to-role').val('');
                        $('#assigned-to-person').html('<option value="">Select Person</option>');
                        $('#ticket-subject').val('');
                        // CKEDITOR.instances['ticket_description'].setData('');
                        $('#ticket_description').val();
                        $('#ticket-priority').val('');
                        $('#ticket-classifications').val('');
                        $("#ticket-attach-file").val('');
                        get_all_raised_tickets();
                    
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-ticket-btn').prop('disabled',false);
                $('#raise-ticket-error-msg-div').html('');
                toastr.error('Something went wrong while raising the data. Please try again.');
            }
        });
    } else {
        if (ticket_description == '') {
            $('#ticket-description-error-msg-div').html('<span class="text-danger error-msg-small">Please select the remarks.</span>');
        } else {
            $('#ticket-description-error-msg-div').html('');
        }
    }
}