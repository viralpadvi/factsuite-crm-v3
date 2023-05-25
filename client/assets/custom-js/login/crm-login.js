var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	password_length = 8;

$("#sign-in-btn").on('click',function() {
	var email = $("#sign-in-email").val();
	var password = $("#sign-in-password").val();
	
	if (email != '' && password != '' && email_regex.test(email) == true && password.length >= password_length) {
		$('#login-email-error').html('');
		$('#login-password-error').html('');
		$.ajax({
			type: "POST",
		  	url: base_url+"clientLogin/valid_login_auth",
		  	data: {
		  		email: email,
		  		password: password
		  	},
		  	dataType: "json",
		  	success: function(data) {  
			  	if (data.status == '1') {  
		  			// window.location.href = base_url+"factsuite-client/home-page"; 
		  			var client_name = data['user'].client_name.replace('#',''); 
		  			window.location.href = base_url+client_name.toLowerCase()+"/home-page";
		  		} else {
		  			let html = "<span class='text-danger error-msg-small'>Incorrect Email Id or Password</span>";
					$('#login-error').html(html);
		  		} 
		  	}
		});
	} else {
		if (email == '' && password == '') {
			$('#sign-in-email').focus();
			$('#login-email-error').html('<span class="text-danger error-msg-small">Please enter your email</span>');
			$('#login-password-error').html('<span class="text-danger error-msg-small">Please enter your password</span>');
		} else if (!email_regex.test(email) && password.length < password_length) {
			$('#sign-in-email').focus();
			$('#login-email-error').html('<span class="text-danger error-msg-small">Please enter a valid email id</span>');
			$('#login-password-error').html('<span class="text-danger error-msg-small">Password length should minimum '+password_length+' characters</span>');
		} else {
			if (email == '') {
				$('#sign-in-email').focus();
				$('#login-email-error').html('<span class="text-danger error-msg-small">Please enter your email</span>');
			} else if (password == '') {
				$('#sign-in-password').focus();
				$('#login-password-error').html('<span class="text-danger error-msg-small">Please enter your password</span>');
			} else if (!email_regex.test(email))  {
				$('#sign-in-email').focus();
				$('#login-email-error').html('<span class="text-danger error-msg-small">Please enter a valid email id</span>');
			} else if (password.length < password_length){
				$('#sign-in-password').focus();
				$('#login-password-error').html('<span class="text-danger error-msg-small">Password length should minimum '+password_length+' characters</span>');
			} else {
				
			}
		}

		if (email != '' && email_regex.test(email) == true) {
			$('#login-email-error').html('');
		}

		if (password != '' && password.length >= password_length) {
			$('#login-password-error').html('');
		}
	}
})

$("#sign-in-email").on('keyup',function() {
	var email = $(this).val();
	if (!email_regex.test(email)) {
		$('#sign-in-email').focus();
		// $('#login-email-error').html('Please enter a valid email id');
		// $('#login-password-error').html('Password length should minimum '+password_length+' characters');
	} else if (email == '') {
		$('#sign-in-email').focus();
		$('#login-email-error').html('<span class="text-danger error-msg-small">Please enter your email</span>');
	} else {
		$('#login-email-error').html('');
	}
});

$("#sign-in-password").on('keyup',function() {
	var password = $(this).val();
	if (password.length < password_length) {
		$('#sign-in-password').focus(); 
		$('#login-password-error').html('<span class="text-danger error-msg-small">Password length should be of minimum '+password_length+' characters</span>');
	} else if (password == '') {
		$('#sign-in-password').focus();
		$('#login-password-error').html('<span class="text-danger error-msg-small">Please enter your password</span>');
	} else {
		$('#login-password-error').html('');
	}
});