var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;

function add_team(){
	 sessionStorage.clear(); 
	 $("#skill-error").html("&nbsp;");
	var first_name = $("#first-name").val();
	var last_name = $("#last-name").val();
	var email = $("#email-id").val();
	var password = $("#team-password").val();
	var role = $("#team-password").val();
	var contact = $("#contact-no").val();
	var user_name = $("#user-name").val();
	var manager = $("#report-manager").val();


	var skills = [];
	$('.skills:checked').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {

		skills.push($(this).val());
		}
	});

	if (first_name !='' && last_name !='' && email !='' && skills.length !=0) {

	$.ajax({
		type: "POST",
	  	url: base_url+"team/update_team",
	  	data: {first_name:first_name,last_name:last_name,email: email, password: password,role:role,contact_no:contact,user_name:user_name,skill:skills,manager:manager},
	  	dataType: "json",
	  	success: function(data){ 
		  	if (data.status == '1') {
		  		let html = "<span class='text-success'>Success data updated</span>";
				$('#error-team').html(html);
				toastr.success('New data has been update successfully.');
				 
		  	} else {
		  		let html = "<span class='text-danger'>Somthing went wrong.</span>";
				$('#error-team').html(html);
				toastr.error('New data has been update failed.');
	  		}
	  	} 
	});

	}else{
		check_reccovery_password_match();
		check_valid_email();
		check_user_name();
		check_contact();
		valid_first_name();
		valid_last_name();
		valid_role();
		valid_report_manager();
		if (skills.length == 0) {
			$("#skill-error").html("<span class='text-danger'>Select Min 1 Skill.</span>");
		}
	}

}

$("#team-password").on('keyup blur',function(){
	check_reccovery_password_match();
});
$("#confirm-team-password").on('keyup blur',function(){
	check_reccovery_password_match();
});
 

function check_reccovery_password_match() {
	var password = $('#team-password').val();
	var confirm_password = $("#confirm-team-password").val();
	if (password != '' && confirm_password !='') {
		if(password == confirm_password){
            $("#new-confirm-password-error-msg-div").html("<span class='text-success error-msg'>Passwords are same</span>");
        } else {
            $("#new-confirm-password-error-msg-div").html("<span class='text-danger error-msg'>Passwords didnt matched.</span>");
        }
	} else {
		if (password == '') {
			$("#new-password-error-msg-div").html('<span class="text-danger error-msg">Please enter your password.</span>');
		} else {
			$("#new-password-error-msg-div").html('&nbsp;');
		}

		if (confirm_password == '') {
			$('#new-confirm-password-error-msg-div').html('<span class="text-danger error-msg">Please confirm your password.</span>');
		} else {
			$('#new-confirm-password-error-msg-div').html('&nbsp;');
		}
	}
}


$('#email-id').on('keyup blur',function() {
	check_valid_email();
});

function check_valid_email(){
	var user_email = $("#email-id").val();
	if (user_email != '') {
	    if(!regex.test(user_email)) {
			$('#email-id-error').html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    } else {
	        $('#email-id-error').html("&nbsp;");
	    }
	} else {
		$('#email-id-error').html('<span class="text-danger error-msg">Please enter email id.</span>');
	}
}


$('#user-name').on('keyup blur',function() {
	check_user_name();
});

function check_user_name(){
	var user_name = $("#user-name").val();
	if (user_name != '') {
	    if(user_name > 4) {
			$('#user-name-error').html("<span class='text-danger error-msg'>please enter min 4 digit user name.</span>");
	    } else {
	        $('#user-name-error').html("&nbsp;");
	    }
	} else {
		$('#user-name-error').html('<span class="text-danger error-msg">Please enter user name.</span>');
	}	
}

$('#contact-no').on('keyup blur', function () {
	check_contact();
});
function check_contact(){
  	var user_contact = $('#contact-no').val();
  	if (user_contact != '') {
    	if(user_contact.length > mobile_number_length) {
      		$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#contact-no').val(user_contact.slice(0,mobile_number_length));
    	} else if (isNaN(user_contact)) {
      		$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#contact-no').val(user_contact.slice(0,-1));
    	} else {
      		$('#contact-no-error').html('&nbsp;');
    	}
  	} else {
    	$('#contact-no-error').html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
  	}
}

$('#first-name').on('keyup blur',function(){
	valid_first_name();
});

function valid_first_name(){
	var first_name = $('#first-name').val();
	if (first_name != '') {
		$('#first-name-error').html('&nbsp;');
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg">Please enter your first name.</span>');
	}
}

$('#last-name').on('keyup blur',function(){
	valid_last_name();
});

function valid_last_name(){
	var last_name = $('#last-name').val();
	if (last_name != '') {
		$('#last-name-error').html('&nbsp;');
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg">Please enter your last name.</span>');
	}
}

$('#role').on('change',function(){ 
	valid_role();
});

function valid_role(){
	var role = $('#role').val();
	if (role != '') {
		$('#role-error').html('&nbsp;');
	} else {
		$('#role-error').html('<span class="text-danger error-msg">Please select role.</span>');
	}
}

$('#report-manager-error').on('change',function(){
	valid_report_manager();
});

function valid_report_manager(){
	var manager = $('#report-manager-error').val();
	if (manager != '') {
		$('#report-manager-error-error').html('&nbsp;');
	} else {
		$('#report-manager-error-error').html('<span class="text-danger error-msg">Please select report manager.</span>');
	}
}


