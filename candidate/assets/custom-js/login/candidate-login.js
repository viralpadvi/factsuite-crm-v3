var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	password_length = 8,
	mobile_number_length = 10;

$("#sign-in-btn").on('click', function() {
	sign_in();
});

$('#contact-no').on('keyup blur',function() {
	valid_contact();
});

$('#contact-no').on('keypress', function(e) {
    var key = e.which;
    if (key == 13) {
        sign_in();
        return false;
    }
});

function valid_contact() {
  	var user_contact = $('#contact-no').val();
  	if (user_contact != '') {
    	/*if(user_contact.length > mobile_number_length) {
      		$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of '+mobile_number_length+' digits</span>');
      		$('#contact-no').val(user_contact.slice(0,mobile_number_length));
      		return 0;
    	} else {
      		if (user_contact.length == mobile_number_length) {*/
      			$('#contact-no-error').html('');
      			$('#sign-in-btn').show();
      			input_is_valid('#contact-no');
      			return 1;
      		/*} else {
      			$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of '+mobile_number_length+' digits</span>');
      			input_is_invalid('#contact-no');
      			return 0;
      		}*/
    	// }
  	} else {
  		input_is_invalid('#contact-no');
    	// $('#contact-no-error').html('<span class="text-danger error-msg-small">Please enter a valid mobile number Or Login ID.</span>');
    	$('#contact-no-error').html('<span class="text-danger error-msg-small">Please enter a valid Login ID.</span>');
    	return 0;
  	}
}

function sign_in() {
	var contact_no = $('#contact-no').val(),
		valid_contact_var = valid_contact();
	if (valid_contact_var == 1) {
		$('#sign-in-btn').show();
		$('#contact-no-error').html('');
		 
		$.ajax({
			type: "POST",
		  	url: base_url+"candidateLogin/valid_login_auth",
		  	data: {
		  		contact_no: contact_no,
		  		// country_code: $('#country-code').val()
		  	},
		  	dataType: "json",
		  	success: function(data) {
			  	if (data.status == '1') {
			  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		  				window.location.href = base_url+"factsuite-candidate/sign-in";
		  			} else {
		  				window.location.href = base_url+"m-verify-otp";
		  			}
			  	// 	if(data.user.is_submitted == '0' || data.user.is_submitted == '3') {
			  			
			  	// 	} else {
			  	// 		$('#sign-in-btn').hide();
			  	// 		let html = "<span class='text-success error-msg-small'>E-Form Application has been submitted for this number</span>";
						// $('#contact-no-error').html(html);
			  	// 	}
		  		} else if(data.status == '2') {
		  			// let html = "<span class='text-danger error-msg-small'>Entered mobile number or Login ID doesn\'t exists with us. Please enter the correct mobile number or Login ID.</span>";
		  			let html = "<span class='text-success error-msg-small'>E-Form Application has been submitted for this account</span>";
					$('#contact-no-error').html(html);
		  		} else {
		  			// let html = "<span class='text-danger error-msg-small'>Entered mobile number or Login ID doesn\'t exists with us. Please enter the correct mobile number or Login ID.</span>";
		  			let html = "<span class='text-danger error-msg-small'>Entered Login ID doesn\'t exists with us. Please enter the correct Login ID.</span>";
					$('#contact-no-error').html(html);
		  		} 
		  	}
		});
	} else { 
		valid_contact();
	}
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}