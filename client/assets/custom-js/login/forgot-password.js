$('#forgot-password-email-id').on('keyup blur', function() {
	check_forgot_password_email_id();
});

$('#verify-email-btn').on('click', function() {
	verify_email();
});

function check_forgot_password_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#forgot-password-email-id';
	variable_array['error_msg_div_id'] = '#forgot-password-email-id-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter your email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function verify_email() {
	var check_forgot_password_email_id_var = check_forgot_password_email_id();
	if (check_forgot_password_email_id_var == 1) {
		$('#verify-email-btn').prop('disabled',true);
		$('#forgot-password-email-id-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are verifying.</span>');
		var formdata = new FormData();
		formdata.append('verify_user_request',1);
		formdata.append('email_id',$('#forgot-password-email-id').val());

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-client-forgot-password",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#verify-email-btn').prop('disabled',false);
					$('#forgot-password-email-id-error-msg-div').html('');
				  	if (data.verify.status == '1') {
				  		toastr.success('A Link is successfully sent to your registered Email Id for reseting your password .');
				  		setTimeout(function() { window.location = login_url; }, 3000);
				  	} else if (data.verify.status == '2') {
				  		toastr.warning('Entered mail id doesn\'t exists with us. Please enter the correct mail id.');
			  		} else {
			  			toastr.error('Something went wrong. Please try again.');
			  		}
			  	} else {
			  		toastr.error('Something went wrong. Please try again.');
			  	}
		  	},
		  	error: function(data) {
		  		$('#verify-email-btn').prop('disabled',false);
				$('#forgot-password-email-id-error-msg-div').html('');
		  		toastr.error('Something went wrong. Please try again.');
		  	}
		});
	}
}