var max_img_size = 10000000,
    new_ticket_attach_file_array = [];

var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
    email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
    alphabets_only = /^[A-Za-z ]+$/,
    vendor_name_length = 100,
    city_name_length = 100,
    vendor_zip_code_length = 6,
    vendor_monthly_quota_length = 5,
    vendor_docs = [],
    vendor_document_size = 1000000,
    max_vendor_document_select = 6,
    vendor_manager_name_length = 200,
    mobile_number_length = 10,
    vendor_spoc_name_length = 200,
    vendor_first_name_length = 100,
    vendor_last_name_length = 100,
    vendor_user_name_length = 70,
    min_vendor_user_name_length = 8,
    password_length = 8,
    vendor_skill_tat_length = 3,
    role_list_for_segments_array = ['analyst','specialist'],
    address_component_ids = [8,9,12];

function input_is_valid(input_id) {
    $(input_id).removeClass('is-invalid');
    $(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
    $(input_id).removeClass('is-valid');
    $(input_id).addClass('is-invalid');
}


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
$("#first-name").show();
$("#exist-first-name").hide();
if ($(this).val() !='0') {
$("#first-name").hide();
$("#exist-first-name").show();
} 
})


$("#exist-first-name").on("change",function(){
     var id = $(this).find(':selected').data('id');
     var first = $(this).find(':selected').data('first');
     var last = $(this).find(':selected').data('last');
     var email = $(this).find(':selected').data('email'); 
     var role = $(this).find(':selected').data('role');  
     $("#last-name").val(last);
     $("#user-name").val(email);
     $("#manager-name").val(id);
     $("#assigned-to-roles").val(role);
})

remarks_all();
function remarks_all() {
    var type_of_approval = $('#type-of-approval').val();  
    var flag =0;
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
                if (data[i].status == '2' && data[i].flag == flag) { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}

$("#ticket_description").on('change',function(){
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
     $('#ticket-description-error-msg-div').html('');
})



$(".radio-client").on('change',function(){
    var radio = $(this).val();
    if (radio == 'master') {
       $("#client-list").hide(); 
        }else{
          $("#client-list").show();   
        }
});

  $("type-of-approval").on('change',function(){
        var type = $(this).val();
        
        if (type == 0) {
           $("#client-list").hide(); 
           $("#client-type").show();
        }else{
          $("#client-list").show();   
          $("#client-type").hide();
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
                html += '<option value="client">Client</option>';
            $('#assigned-to-role').html(html);
      /*  } 
    });*/
}

function get_roles_person_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-roles-person-list", 
        dataType: "json",
        data : {
            verify_analyst_request : 1,
            role_type : $('#assigned-to-role').val()
        },
        success: function(data) {
            var html = '<option value="">Select Person</option>';
            if (data.all_persons.length > 0) {
                var all_persons = data.all_persons;
                for (var i = 0; i < all_persons.length; i++) {
                    html += '<option value="'+all_persons[i].team_id+'">'+all_persons[i].first_name+' '+all_persons[i].last_name+' ('+all_persons[i].team_employee_email+')</option>';
                }
            }
            $('#assigned-to-person').html(html);
        } 
    });
}

$('#assigned-to-roles').on('change', function() {
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
    variable_array['input_id'] = '#assigned-to-roles';
    variable_array['error_msg_div_id'] = '#assigned-to-role-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a role.';
    var mandatory_select_var = mandatory_select(variable_array);
    if (mandatory_select_var == 1) {
        get_roles_person_list();
    } else {
        $('#assigned-to-person').html('<option value="">Select Person</option>');
    }
    return mandatory_select_var;
}

function check_assigned_to_person() {
    var variable_array = {};
    variable_array['input_id'] = '#assigned-to-person';
    variable_array['error_msg_div_id'] = '#assigned-to-person-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a person.';
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

        var type = $('#type-of-approval').val();
        var ticket_description = $('#ticket_description').val(); 
        var user_name = $("#user-name").val();
        var designation = $("#designation").val();
        var manager_name = $("#manager-name").val();
        var contact = $("#contact").val();
        var role = $("#assigned-to-roles").val();

        var first_name = 0;
        var first = $("#first-name").val();
        var last_name = $("#last-name").val();
        if (type !='0') {
            first_name = $("#exist-first-name").val();
            first = $("#first-name").find(':selected').data("name");
        } 
        var manager = $("#manager-name").find(':selected').data("first");
        
        var components = [];
        $('.package_components:checked').each(function(){
            components.push($(this).val());
        });

        var check_assigned_to_role_var = check_assigned_to_role();

 /*case-id
component-name
amount
portal-name*/
    if (components.length > 0 && ticket_description != '' && check_assigned_to_role_var == '1' && manager !='' && last_name !='' && user_name !='') {
        $('#ticket-classifications-error-msg-div').html('');
        $('#raise-ticket-btn').prop('disabled',true);
        $('#raise-ticket-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are adding the Approval Request.</span>');

        var formdata = new FormData();
        formdata.append('verify_csm_request',1);
        formdata.append('assigned_to_role',role);
        formdata.append('manager_name',manager_name); 
        formdata.append('description',ticket_description);   
        formdata.append('user_name',user_name);   
        formdata.append('designation',designation);   
        formdata.append('components',JSON.stringify(components));   
        formdata.append('team_id',first_name);   
        formdata.append('first_name',first);   
        formdata.append('last_name',last_name);   
        formdata.append('manager',manager);   
        formdata.append('contact',contact);   
        formdata.append('type',type);   

        

        $.ajax({
            type: "POST",
            url: base_url+"approval_Mechanisms/approval_for_crm_user",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == '1') {
                    $('#raise-ticket-btn').prop('disabled',false);
                    $('#raise-ticket-error-msg-div').html('');
                    if (data.status == '1') {
                        toastr.success('Your Request has been raised successfully.');
                        $('#add-new-ticket-modal').modal('hide');
                        $('#assigned-to-role').val('');
                        $('#type-of-approval').val('');
                        $('#ticket_description').val(''); 
                        $("#user-name").val('');
                        $("#designation").val('');
                        $("#manager-name").val('');
                        $("#assigned-to-roles").val('');
                        $('.package_components').attr('checked',false);
                        get_all_raised_tickets();
                    } else {
                        toastr.error('Something went wrong while raising the Request. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-ticket-btn').prop('disabled',false);
                $('#raise-ticket-error-msg-div').html('');
                toastr.error('Something went wrong while raising the Request. Please try again.');
            }
        });
    } else {

        check_user_name();
        check_contact();
        valid_last_name();
        valid_report_manager();
        if (ticket_description == '') {
            $('#ticket-description-error-msg-div').html('<span class="text-danger error-msg-small">Please select the Remarks.</span>');
        } else {
            $('#ticket-description-error-msg-div').html('');
        }

         if (components.length == 0) {
             $('#component-error-msg-div').html('<span class="text-danger error-msg-small">Please select checks min 1 required.</span>');
        }
    }
}



$('#user-name').on('keyup blur', function () {
    check_user_name();
});

function check_user_name(){
    var user_name = $("#user-name").val();
    if (user_name != '') {
        if(user_name > 4) {
            input_is_invalid("#user-name")
            $('#user-name-error').html("<span class='text-danger error-msg-small'>Please enter email Id.</span>");
        } else {
            $('#user-name-error').html("&nbsp;");
            input_is_valid("#user-name")
        }
    } else {
        input_is_invalid("#user-name")
        $('#user-name-error').html('<span class="text-danger error-msg-small">Please enter email Id.</span>');
    }   
}



$('#contact').on('keyup blur', function () {
    check_contact();
});

function check_contact(){
    var user_contact = $('#contact').val();
    if (user_contact != '') {
        if(user_contact.length > mobile_number_length) {
            $('#contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
            $('#contact').val(user_contact.slice(0,mobile_number_length));

        } else if (isNaN(user_contact)) {
            $('#contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
            $('#contact').val(user_contact.slice(0,-1));
        } else if(user_contact.length ==10 ){

            $.ajax({
              type: "POST",
              url: base_url+"team/duplicate_contact/",
              data:{contact:user_contact},
              dataType: 'json', 
              success: function(data) {
                if (data.status =='1') {
                    $('#contact-error').html('&nbsp;');
                    input_is_valid("#contact")
                    // $("#team-submit-btn").attr('disabled',false);
                }else{
                    // $("#team-submit-btn").attr('disabled',true);
                    input_is_invalid("#contact"); 
                    $('#contact-error').html('<span class="text-danger error-msg-small">This number already exists.</span>');
                }
              }
         });

        }
    } else {
        input_is_invalid("#contact")
        $('#contact-error').html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
    }
}

$('#first-name').on('keyup blur',function(){
    valid_first_name();
});

$('#last-name').on('keyup blur',function(){
    valid_last_name();
}); 

function valid_first_name(){
     
    var first_name = $('#first-name').val();
    if (first_name != '') {
        if (!alphabets_only.test(first_name)) {
            $('#first-name-error').html('<span class="text-danger error-msg-small">First name should be only alphabets.</span>');
            $('#first-name').val(first_name.slice(0,-1));
            input_is_invalid('#first-name');
        } else if (first_name.length > vendor_name_length) {
            $('#first-name-error').html('<span class="text-danger error-msg-small">First name should be of max '+vendor_name_length+' characters.</span>');
            $('#first-name').val(first_name.slice(0,vendor_name_length));
            input_is_invalid('#first-name');
        } else {
            $('#first-name-error').html('&nbsp;');
            input_is_valid('#first-name');
        }
    } else {
        $('#first-name-error').html('<span class="text-danger error-msg-small">Please enter first name.</span>');
        input_is_invalid('#first-name');
    }
}

function valid_last_name(){
     
    var last_name = $('#last-name').val();
    if (last_name != '') {
        if (!alphabets_only.test(last_name)) {
            $('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be only alphabets.</span>');
            $('#last-name').val(last_name.slice(0,-1));
            input_is_invalid('#last-name');
        } else if (last_name.length > vendor_name_length) {
            $('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be of max '+vendor_name_length+' characters.</span>');
            $('#last-name').val(last_name.slice(0,vendor_name_length));
            input_is_invalid('#last-name');
        } else {
            $('#last-name-error').html('&nbsp;');
            input_is_valid('#last-name');
        }
    } else {
        $('#last-name-error').html('<span class="text-danger error-msg-small">Please enter last name.</span>');
        input_is_invalid('#last-name');
    }
}
 
$('#manager-name').on('change',function(){
    valid_report_manager();
});

function valid_report_manager(){
    var manager = $('#manager-name').val();
    if (manager != '') {
        $('#manager-name-error').html('&nbsp;');
        input_is_valid("#manager-name")
    } else {
        input_is_invalid("#manager-name")
        $('#manager-name-error').html('<span class="text-danger error-msg-small">Please select the report manager.</span>');
    }
}