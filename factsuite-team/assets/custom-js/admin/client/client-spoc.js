$('#send-credentials-to-multiple-client-spoc').on('click', function() {
    var spoc_id = [];
    $('input[name="send-credentials-to-multiple-spoc-id[]"]:checked').each(function(i) {
        spoc_id[i] = $(this).val();
    });
    if (spoc_id.length > 0) {
        $('#send-credentials-to-multiple-client-spoc-error-msg-div').html('');
        send_credentials_to_spoc(spoc_id.toString(','));
    } else {
        $('#send-credentials-to-multiple-client-spoc-error-msg-div').html('<span class="error-msg text-danger">Please select atleast one spoc.</span>');
    }
});

function send_credentials_to_spoc(spoc_id) { 
    if (spoc_id != '' &&  spoc_id != 'undefined' && spoc_id != undefined) {
        // for (var i = 0; i < spoc_id.length; i++) {
            $('#send-credentials-to-client-spoc-'+spoc_id).html('Sending');    
        // }
        
        $.ajax({
            type: "POST",
            url: base_url+"factsuite-admin/send-credentials-to-client-spoc",
            data: {
                verify_admin_request : '1',
                spoc_id : spoc_id
            },
            dataType: "json",
            success: function(data) {
                if (data.send_credentials_to_client_spoc.status == 1) {
                    toastr.success('Credentials has been sent successfully to the client\'s SPOC');
                } else {
                    toastr.error('OOPS! Something went wrong while sending the credentials to the client SPOC. Please try again.');
                }
                // for (var i = 0; i < spoc_id.length; i++) {
                    $('#send-credentials-to-client-spoc-'+spoc_id).html('<a onclick="send_credentials_to_spoc('+spoc_id+')" href="javascript:void(0)" class="text-dark">Send</a>');    
                // }
                
                if (typeof request_page != 'undefined' && request_page == 'add-edit-client') {
                    window.location.href = base_url+'factsuite-admin/add-new-client';
                }
                // $('#send-credentials-to-client-spoc-'+spoc_id).html('<a onclick="send_credentials_to_spoc('+spoc_id+')" href="javascript:void(0)" class="text-dark">Send</a>');
            } 
        });
    }
}