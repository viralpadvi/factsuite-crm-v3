// super-mart-login.js 
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
		  	url: base_url+"login/valid_login_auth",
		  	data: {
		  		email: email,
		  		password: password
		  	},
		  	dataType: "json",
		  	success: function(data) {
			  	if (data.status == '1') {
			  		if(data.user.role.toLowerCase() == 'admin') {
			  			// window.location.href = base_url+"factsuite-admin/dashboard";
						  window.location.href = base_url+"factsuite-admin/view-all-case-list";
			  		} else if(data.user.role.toLowerCase() == 'inputqc') {
			  			window.location.href = base_url+"factsuite-inputqc/assigned-case-list";
			  		} else if(data.user.role.toLowerCase() == 'analyst') {
			  			window.location.href = base_url+"factsuite-analyst/assigned-case-list";
			  		} else if(data.user.role.toLowerCase() == 'insuff analyst') {
			  			window.location.href = base_url+"factsuite-analyst/assigned-insuff-component-list";
			  		} else if(data.user.role.toLowerCase() == 'specialist') {
			  			window.location.href = base_url+"factsuite-specialist/view-all-component-list";
			  		} else if(data.user.role.toLowerCase() == 'outputqc') {
			  			window.location.href = base_url+"factsuite-outputqc/assigned-case-list";
			  		} else if(data.user.role.toLowerCase() == 'csm') {
			  			window.location.href = base_url+"factsuite-csm/view-all-case-list";
			  		} else if(data.user.role.toLowerCase() == 'am') {
			  			window.location.href = base_url+"factsuite-am/view-all-case-list";
			  		} else if(data.user.role.toLowerCase() == 'finance') {
			  			window.location.href = base_url+"factsuite-finance/view-all-case-list";
			  		} else if(data.user.role.toLowerCase() == 'tech support team') {
			  			window.location.href = base_url+"factsuite-tech-support/raise-ticket";
			  		} else {
						window.location.href = base_url+"factsuite-admin/dashboard";
			  		}
			  	} else {
					$('#login-error').html("<span class='text-danger'>Incorrect Email Id or Password</span>");
		  		}
		  	} 
		});
	} else {


		if (email == '' && password == '') {
			$('#sign-in-email').focus();
			$('#login-email-error').html('Please enter your email');
			$('#login-password-error').html('Please enter your password');
		} else if (!email_regex.test(email) && password.length < password_length) {
			$('#sign-in-email').focus();
			$('#login-email-error').html('Please enter a valid email id');
			$('#login-password-error').html('Password length should minimum '+password_length+' characters');
		} else {
			if (email == '') {
				$('#sign-in-email').focus();
				$('#login-email-error').html('Please enter your email');
			} else if (password == '') {
				$('#sign-in-password').focus();
				$('#login-password-error').html('Please enter your password');
			} else if (!email_regex.test(email))  {
				$('#sign-in-email').focus();
				$('#login-email-error').html('Please enter a valid email id');
			} else if (password < password_length){
				$('#sign-in-password').focus();
				$('#login-password-error').html('Password length should minimum '+password_length+' characters');
			} else {
				
				$('#login-email-error').html('Please enter a valid cradential');
			}
		}

		if (email != '' && email_regex.test(email) == true) {
			$('#login-email-error').html('');
		}

		if (password != '' && password >= password_length) {
			$('#login-password-error').html('');
		}
	}
})

$("#sign-in-email").on('keyup',function(){
	var email = $(this).val();
	if (!email_regex.test(email)) {
			$('#sign-in-email').focus();
			// $('#login-email-error').html('Please enter a valid email id');
			// $('#login-password-error').html('Password length should minimum 4 characters');
		} else if (email == '') {
			$('#sign-in-email').focus();
			$('#login-email-error').html('Please enter your email');
		}else{
			$('#login-email-error').html('');
		}
});

$("#sign-in-password").on('keyup',function(){
	var password = $(this).val();
	if (password.length < password_length) {
			$('#sign-in-password').focus(); 
			$('#login-password-error').html('Password length should minimum '+password_length+' characters');
		} else if (password == '') {
			$('#sign-in-password').focus();
			$('#login-password-error').html('Please enter your password');
		}else{
			$('#login-password-error').html('');
		}
});