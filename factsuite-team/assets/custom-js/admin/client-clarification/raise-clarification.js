var max_img_size = 10000000,
    new_client_clarification_attach_file_array = [];

$('#client-clarification-subject').on('keyup blur', function() {
    check_client_clarification_subject();
});

$("#client-clarification-attach-file").on("change", handle_file_select_new_client_clarification_attach_file);

$('#raise-client-clarification-btn').on('click', function() {
    raise_new_client_clarification();
});

function check_client_clarification_subject() {
    var variable_array = {};
    variable_array['input_id'] = '#client-clarification-subject';
    variable_array['error_msg_div_id'] = '#client-clarification-subject-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the clarification subject';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function handle_file_select_new_client_clarification_attach_file(e) {
    new_ticket_attach_file_array = [];
    var variable_array = {};
    variable_array['e'] = e;
    variable_array['file_id'] = '#client-clarification-attach-file';
    variable_array['show_image_name_msg_div_id'] = '#client-clarification-attach-file-error-msg-div';
    variable_array['storedFiles_array'] = new_client_clarification_attach_file_array;
    variable_array['col_type'] = 'col-md-12';
    variable_array['file_ui_id'] = 'file_new_client_clarification_attach';
    variable_array['file_size'] = max_img_size;
    variable_array['exceeding_max_length_error_msg'] = 'Attached file should be of max 1MB';
    return not_mandatory_single_file_upload(variable_array);
}

function raise_new_client_clarification() {
    var client_clarification_subject = $('#client-clarification-subject').val(),
        client_clarification_description = CKEDITOR.instances['client_clarification_description'].getData(),
        client_clarification_priority = $('#client-clarification-priority').val(),
        client_clarification_classifications = $('#client-clarification-classifications').val(),
        client_clarification_attach_file = $("#client-clarification-attach-file")[0].files[0],
        candidate_id = $('#selected-hidden-candidate-id').val(),
        component_id = $('#selected-hidden-component-id').val(),
        component_index = $('#selected-hidden-component-index').val(),
        user_component_form_filled_id = $('#selected-hidden-user-component-form-filled-id').val();

    var check_client_clarification_subject_var = check_client_clarification_subject();

    if (check_client_clarification_subject_var == 1 && client_clarification_description != '') {
        $('#client-clarification-description-error-msg-div').html('');
        $('#raise-client-clarification-btn').prop('disabled',true);
        $('#raise-client-clarification-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are generating the error.</span>');

        var formdata = new FormData();
        formdata.append('verify_admin_request',1);
        formdata.append('client_clarification_subject',client_clarification_subject);
        formdata.append('client_clarification_description',client_clarification_description);
        formdata.append('client_clarification_priority',client_clarification_priority);
        formdata.append('client_clarification_classifications',client_clarification_classifications);
        formdata.append('candidate_id',candidate_id);
        formdata.append('component_id',component_id);
        formdata.append('component_index',component_index);
        formdata.append('user_component_form_filled_id',user_component_form_filled_id);

        if (client_clarification_attach_file != undefined) {
            formdata.append('client_clarification_attach_file',client_clarification_attach_file);
        }

        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/raise-new-client-clarification",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == 1) {
                    $('#raise-client-clarification-btn').prop('disabled',false);
                    $('#raise-client-clarification-error-msg-div').html('');
                    if (data.raise_client_clarification_details.status == '1') {
                        $('#add-new-client-clarification-modal').modal('hide');
                        toastr.success('Your clarification has been raised successfully.');
                        $('#client-clarification-subject').val('');
                        CKEDITOR.instances['client_clarification_description'].setData('');
                        $('#client-clarification-priority').val('');
                        $('#client-clarification-classifications').val('');
                        $("#client-clarification-attach-file").val('');
                        $('#client-clarification-attach-file-error-msg-div').html('');
                    } else {
                        toastr.error('Something went wrong while raising the clarification. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-client-clarification-btn').prop('disabled',false);
                $('#raise-client-clarification-error-msg-div').html('');
                toastr.error('Something went wrong while raising the clarification. Please try again.');
            }
        });
    } else {
        if (client_clarification_description == '') {
            $('#client-clarification-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the clarification description.</span>');
        } else {
            $('#client-clarification-description-error-msg-div').html('');
        }
    }
}