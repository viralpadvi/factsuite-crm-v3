var min_password_length = 8;

$('#new-password, #verify-new-password').on('keyup blur', function() {
	check_new_password();
});

$('#save-password-btn').on('click', function() {
	save_new_password();	
});

function check_new_password() {
	var new_password = $('#new-password').val(),
		verify_new_password = $('#verify-new-password').val();

	if (new_password != '' && verify_new_password != '' && new_password.length >= min_password_length && verify_new_password.length >= min_password_length) {
		$('#new-password-error-msg-div').html('');
		if(new_password == verify_new_password) {
			$('#verify-new-password-error-msg-div').html('<span class="text-success error-msg-small">Passwords matched.</span>');
			return 1;
		} else {
			$('#verify-new-password-error-msg-div').html('<span class="text-danger error-msg-small">Entered password doesn\'t match. Please check your password..</span>');
			return 0;
		}
	} else {
		if (new_password == '') {
			$('#new-password-error-msg-div').html('<span class="text-danger error-msg-small">Please enter your new password.</span>');
		} else if (new_password.length < min_password_length) {
			$('#new-password-error-msg-div').html('<span class="text-danger error-msg-small">Password should be on minimum '+min_password_length+' characters.</span>');
		} else {
			$('#new-password-error-msg-div').html('');
		}

		if (verify_new_password == '') {
			$('#verify-new-password-error-msg-div').html('<span class="text-danger error-msg-small">Please re-enter your new password.</span>');
		} else if (verify_new_password.length < min_password_length) {
			$('#verify-new-password-error-msg-div').html('<span class="text-danger error-msg-small">Password should be on minimum '+min_password_length+' characters.</span>');
		} else {
			$('#verify-new-password-error-msg-div').html('');
		}
		return 0;
	}
}

function save_new_password() {
	var check_new_password_var = check_new_password();
	if (check_new_password_var == 1) {
		$('#save-password-btn').prop('disabled',true);
		$('#verify-new-password-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are updating your password.</span>');
		var formdata = new FormData();
		formdata.append('verify_user_request',1);
		formdata.append('new_password',$('#new-password').val());
		formdata.append('email_id',email_id);
		formdata.append('encoded_date',encoded_date);

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-client/reset-password",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
		  			
			  		$('#save-password-btn').prop('disabled',false);
					$('#verify-new-password-error-msg-div').html('');
				  	if (data.reset.status == '1') {
				  		setTimeout(function() { window.location = base_url; }, 3000);
				  		toastr.success('Your password has been re-setted successfully. You will be redirected to login in a while.');
				  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				  			setTimeout(function() { window.location = base_url; }, 3000);
				  		} else {
				  			setTimeout(function() { window.location = base_url; }, 3000);
				  		}
				  	} else if (data.reset.status == '2') {
				  		toastr.warning('Entered mail id doesn\'t exists with us. Please enter the correct mail id.');
			  		} else {
			  			toastr.error('Something went wrong. Please try again.');
			  		}
			  	} else {
			  		toastr.error('Something went wrong. Please try again.');
			  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			  			setTimeout(function() { window.location = base_url; }, 3000);
			  		} else {
			  			setTimeout(function() { window.location = base_url; }, 3000);
			  		}
			  	}
		  	},
		  	error: function(data) {
		  		$('#save-password-btn').prop('disabled',false);
				$('#verify-new-password-error-msg-div').html('');
		  		toastr.error('Something went wrong. Please try again.');
		  	}
		});
	}
}