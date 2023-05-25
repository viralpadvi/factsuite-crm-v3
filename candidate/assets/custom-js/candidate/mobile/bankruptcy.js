var document_number_max_length = 15;

$('#add-document-check').on('click', function() {
    save_details();    
});

function check_document_type(i) {
    var variable_array = {};
    variable_array['input_id'] = '#document-type-'+i;
    variable_array['error_msg_div_id'] = '#document-type-error-'+i;
    variable_array['empty_input_error_msg'] = 'Please select a document type.';
    return mandatory_select(variable_array);
}

function check_document_number(i) {
    var variable_array = {};
    variable_array['input_id'] = '#document-number-'+i;
    variable_array['error_msg_div_id'] = '#document-number-error-'+i;
    variable_array['empty_input_error_msg'] = 'Please enter the company name';
    variable_array['max_length'] = document_number_max_length;
    variable_array['exceeding_max_length_error_msg'] = 'Document number should be of max '+document_number_max_length+' characters';
    return mandatory_any_input_with_max_length_validation(variable_array);
}

function save_details() {
    var document_type = [],
        document_number = [],
        invalid_document_type_count = 0,
        invalid_document_number_count = 0;

    $(".document-type").each(function(i) {
        var check_document_type_var = check_document_type(i),
            check_document_number_var = check_document_number(i);
        if (check_document_type_var == 1) {
            document_type.push({document_type : $('#document-type-'+i).val()});
        } else {
            invalid_document_type_count++;
        }

        if (check_document_number_var == 1) {
            document_number.push({bankruptcy_number : $('#document-number-'+i).val()});
        } else {
            invalid_document_number_count++;
        }
    });

    if (invalid_document_type_count == 0 && invalid_document_number_count == 0) {
        $('#save-data-error-msg').html('');
        $("#add-document-check").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
        var formdata = new FormData();
        formdata.append('document_type',JSON.stringify(document_type)); 
        formdata.append('bankruptcy_number',JSON.stringify(document_number));
        formdata.append('verify_candidate_request',1);

        $.ajax({
            type: "POST",
            url: base_url+"m-factsuite-candidate/update-bankruptcy-details",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                $('#save-data-error-msg').html('');
                $("#add-document-check").html('Save & Continue');
                if (data.status == '1') {
                    if (data.candidate_details.status == '1') {
                        window.location.href = base_url+'m-component-list';
                    } else {
                        toastr.error('Something went wrong while save the details. Please try again.');
                    }
                } else {
                    toastr.error('Something went wrong while save the details. Please try again.');
                }
            }
        });
    } else {
        $('#save-data-error-msg').html('<span class="text-danger error-msg-small">Please fill all the necessary details</span>');
    }
}