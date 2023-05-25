var timeLeft = time_on_first_page_load = 10,
	elem = document.getElementById('sec-time'),
	timerId = setInterval(countdown, 1000);

function moveOnMax(field,nextFieldID) {
  	if(field.value.length >= field.maxLength){
    	document.getElementById(nextFieldID).focus();
  	}
}

function countdown() {
   	if (timeLeft == 0) {
      	clearTimeout(timerId);
      	show_resend_otp_btn();
   	} else {
      	$('#otp-sec').html('<a onclick="resend_otp()" id="resend-btn" class="resend-otp">Resend OTP in <span id="sec-time">'+timeLeft+' sec</span></a>');
      	// elem.innerHTML = timeLeft + ' sec';
      	timeLeft--;
   	}
}

function show_resend_otp_btn() {
   	$('#otp-sec').html('<div class="otp-resend text-right"><a href="javascript:void(0)" onclick="resend_otp()" id="resend-btn" class="resend-otp">Resend OTP</a></div>');
}

function resend_otp() {
   	$('#resend-btn').removeAttr('onclick');
   	$('#resend-btn').html('Resending the OTP');
   	$.ajax({
      	type: "POST",
      	url: base_url+"candidate/resend-otp",
      	data: {
         	verify_candidate_request : 1
      	},
      	dataType: 'json',
      	success: function(data) {
         	if (data.status == '1') {
            	toastr.success('OTP has been sent to the registered mail id and mobile number. Please enter the same OTP');
            	time_on_first_page_load = timeLeft = time_on_first_page_load + 10;
            	timerId = setInterval(countdown, 1000);
         	} else {
            	$('#resend-btn').html('Resend OTP');
            	$('#resend-btn').attr('onclick','resend_otp()');
            	toastr.error('Something went wrong while resending the OTP. Please try again.');   
         	}
      	},
      	error: function(data) {
         	$('#resend-btn').html('Resend OTP');
         	$('#resend-btn').attr('onclick','resend_otp()');
      	}
   	});
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

$('#otp1').on('keyup blur',function() {
	valid_otp(1);
});

$('#otp2').on('keyup blur',function() {
	valid_otp(2);
});

$('#otp3').on('keyup blur',function() {
	valid_otp(3);
});

$('#otp4').on('keyup blur',function() {
	valid_otp(4);
});

function valid_otp(id) {
  	var otp = $('#otp'+id).val();
  	if (otp != '') {
      	input_is_valid('#otp'+id);
      	return 1;
  	} else {
  		input_is_invalid('#otp'+id);
  		return 0;
   	}
}

$("#sign-in-btn").on('click touchstart',function() {
	var otp1 = $("#otp1").val();
	var otp2 = $("#otp2").val();
	var otp3 = $("#otp3").val();
	var otp4 = $("#otp4").val();

	var valid_otp_1_var = valid_otp(1),
		valid_otp_2_var = valid_otp(2),
		valid_otp_3_var = valid_otp(3),
		valid_otp_4_var = valid_otp(4);

	if (valid_otp_1_var == 1 && valid_otp_2_var == 1 && valid_otp_3_var == 1 && valid_otp_4_var == 1) {
		// window.location.href=base_url+'factsuite-candidate/candidate-information';
		var password = otp1+otp2+otp3+otp4;
		$.ajax({
			type: "POST",
		  	url: base_url+"candidateLogin/checkedOtp",
		  	data: {
		  		token : password,
		  		link_request_from : link_request_from
		  	},
		  	dataType: "json",
		  	success: function(data) {
			  	if (data.status == '1' && data.is_submitted != '3' && data.redirect_url == '') {
			  		$('#invelid-otp-error').html('');
			  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			  			window.location.href = base_url+data.user_name+'/candidate-information';
			  		} else {
			  			// window.location.href = base_url+'m-component-list';
			  			window.location.href = base_url+'m-verification-steps';
			  		}
		  		} else if(data.status == '1' && data.is_submitted == '3') {
		  			$('#invelid-otp-error').html('');
		  			window.location.href = base_url+data.redirect_url;
		  		}else if(data.is_submitted == '1' && data.redirect_url !='') {
		  			$('#invelid-otp-error').html('');
		  			window.location.href = base_url+data.redirect_url;
		  		} else if(data.status == '2') {
		  			$('#otp1, #otp2, #otp3, #otp4').val('');
		  			$("#otp1").focus();
		  			$('#invelid-otp-error').html('<span class="text-success error-msg-small">E-Form Application has been submitted for this account</span>');
		  		} else {
		  			$('#otp1, #otp2, #otp3, #otp4').val('');
		  			$("#otp1").focus();
					$('#invelid-otp-error').html('<span class="text-danger error-msg-small">Entered OTP is incorrect. Please enter the correct OTP</span>');
		  		}
		  	}
		});
	} else {
		$('#otp1, #otp2, #otp3, #otp4').val('');
		$("#otp1").focus();
		$('#invelid-otp-error').html('<span class="text-danger error-msg-small">Please enter a valid otp.</span>');
	}
});