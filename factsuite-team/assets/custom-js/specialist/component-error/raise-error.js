var max_img_size = 10000000,
    new_error_attach_file_array = [];

get_ticket_priority_list();
function get_ticket_priority_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-specialist/get-ticket-priority-list", 
        dataType: "json",
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].id+'">'+data[i].priority+'</option>';
            }
            $('#error-priority, #client-clarification-priority').html(html);
        } 
    });
}

get_ticket_classification_list();
function get_ticket_classification_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-specialist/get-ticket-classification-list", 
        dataType: "json",
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#error-classifications, #client-clarification-classifications').html(html);
        } 
    });
}

$('#error-subject').on('keyup blur', function() {
    check_error_subject();
});

$("#error-attach-file").on("change", handle_file_select_new_error_attach_file);

$('#raise-error-btn').on('click', function() {
    raise_new_error();
});

function check_error_subject() {
    var variable_array = {};
    variable_array['input_id'] = '#error-subject';
    variable_array['error_msg_div_id'] = '#error-subject-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the error subject';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function handle_file_select_new_error_attach_file(e) {
    new_ticket_attach_file_array = [];
    var variable_array = {};
    variable_array['e'] = e;
    variable_array['file_id'] = '#error-attach-file';
    variable_array['show_image_name_msg_div_id'] = '#error-attach-file-error-msg-div';
    variable_array['storedFiles_array'] = new_error_attach_file_array;
    variable_array['col_type'] = 'col-md-12';
    variable_array['file_ui_id'] = 'file_new_error_attach';
    variable_array['file_size'] = max_img_size;
    variable_array['exceeding_max_length_error_msg'] = 'Attached file should be of max 1MB';
    return not_mandatory_single_file_upload(variable_array);
}

function raise_new_error() {
    // var error_subject = $('#error-subject').val(),
    //     error_description = CKEDITOR.instances['error_description'].getData(),
    //     error_priority = $('#error-priority').val(),
    //     error_classifications = $('#error-classifications').val(),
    //     error_attach_file = $("#error-attach-file")[0].files[0],
    //     candidate_id = $('#selected-hidden-candidate-id').val(),
    //     component_id = $('#selected-hidden-component-id').val(),
    //     component_index = $('#selected-hidden-component-index').val(),
    //     user_component_form_filled_id = $('#selected-hidden-user-component-form-filled-id').val();

    var error_subject = '',
        error_description = CKEDITOR.instances['error_description'].getData(),
        error_priority = 0,
        error_classifications = 0,
        error_attach_file = $("#error-attach-file")[0].files[0],
        candidate_id = $('#selected-hidden-candidate-id').val(),
        component_id = $('#selected-hidden-component-id').val(),
        component_index = $('#selected-hidden-component-index').val(),
        user_component_form_filled_id = $('#selected-hidden-user-component-form-filled-id').val();

    // var check_error_subject_var = check_error_subject();
    // check_error_subject_var == 1 &&
    if (error_description != '') {
        $('#error-classifications-error-msg-div').html('');
        $('#raise-error-btn').prop('disabled',true);
        $('#raise-error-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are generating the error.</span>');

        var formdata = new FormData();
        formdata.append('verify_specialist_request',1);
        formdata.append('error_subject',error_subject);
        formdata.append('error_description',error_description);
        formdata.append('error_priority',error_priority);
        formdata.append('error_classifications',error_classifications);
        formdata.append('candidate_id',candidate_id);
        formdata.append('component_id',component_id);
        formdata.append('component_index',component_index);
        formdata.append('user_component_form_filled_id',user_component_form_filled_id);

        if (error_attach_file != undefined) {
            formdata.append('error_attach_file',error_attach_file);
        }

        $.ajax({
            type: "POST",
            url: base_url+"factsuite-specialist/raise-new-error",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == 1) {
                    $('#raise-error-btn').prop('disabled',false);
                    $('#raise-error-error-msg-div').html('');
                    if (data.raise_error_details.status == '1') {
                        $('#add-new-error-modal').modal('hide');
                        toastr.success('Your error has been raised successfully.');
                        $('#error-subject').val('');
                        // CKEDITOR.instances['error_description'].setData('');
                        $('#error_description').val('');
                        $('#error-priority').val('');
                        $('#error-classifications').val('');
                        $("#error-attach-file").val('');
                        get_all_errors();
                    } else {
                        toastr.error('Something went wrong while raising the error. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-error-btn').prop('disabled',false);
                $('#raise-error-error-msg-div').html('');
                toastr.error('Something went wrong while raising the error. Please try again.');
            }
        });
    } else {
        if (error_description == '') {
            $('#error-classifications-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the error description.</span>');
        } else {
            $('#error-classifications-error-msg-div').html('');
        }
    }
}