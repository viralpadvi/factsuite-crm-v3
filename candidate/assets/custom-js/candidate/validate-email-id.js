$('#send-otp-email-id-btn').on('click', function() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-candidate/send-otp-to-email-id',
        data : {
        	verify_candiate_request : '1'
        },
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	         	if(data.validate_email_id_response.status == 1) {
	         		$('#validate-email-id-otp-input-div, #validate-email-id-btn').removeClass('d-none');
	         		$('#send-otp-email-id-btn').addClass('d-none');
	         		toastr.success('Please enter the OTP sent to your email id');
	         	} else {
	         		toastr.error('Something went wrong while validating your email id. Please try again.');
	         	}
	        } else {
	        	toastr.error('Something went wrong while validating your email id. Please try again.');
	        }
	    }
    });
});

$('#validate-email-id-btn').on('click', function() {
	var otp = $('#email-id-otp').val();
	if (otp != '' && otp.length == 4) {
		$.ajax({
	        type  : 'POST',
	        url   : base_url+'factsuite-candidate/validate-to-email-id',
	        data : {
	        	verify_candiate_request : '1',
	        	otp : otp
	        },
	        dataType : 'json',
	        success : function(data) {
		        if (data.status == '1') {
		         	if(data.validate_email_id_response.status == 1) {
		         		if(link_request_from == '') {
		         			$('#email-id-main-div').removeClass('col-md-7').addClass('col-md-6');
		         			$('#email-id-div').removeClass('col-md-9 validate-input-div').addClass('col-md-12');
		         			$('#house-flat-no-main-div').removeClass('col-md-5').addClass('col-md-6');
		         		}
		         		$('#validate-email-id-otp-input-div, #validate-email-id-otp-btn-div').remove();
		         		// $('#save-candidate-information-btn-div').html('<button id="save-candidate-information" class="save-btn" onclick="save_candidate_details()">Save &amp; Continue</button>');
		         		toastr.success('Email ID successfully validated');
		         	} else {
		         		toastr.error('Something went wrong while validating your email id. Please try again.');
		         	}
		        } else {
		        	toastr.error('Something went wrong while validating your email id. Please try again.');
		        }
		    }
	    });
	} else {
		if (otp != '') {
			$('#email-id-otp-error').html('<span class="text-danger error-msg">OTP is of 4 digits.</span>');
		} else {
			$('#email-id-otp-error').html('<span class="text-danger error-msg">Please enter the otp.</span>');
		}
	}
});