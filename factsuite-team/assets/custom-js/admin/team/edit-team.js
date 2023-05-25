var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
 	mobile_number_length = 10,
	role_list_for_segments_array = ['analyst','specialist'];

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

function check_segments() {
	var segment = $('input[name="segment[]"]:checked').length;
	if (segment > 0) {
		$('#segment-error-msg-div').html('');
		return 1;
	} else {
		$('#segment-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 segment.</span>');
		return 0;
	}
}

$("#present-address-component").on('click', function() {
	check_present_address_component();
});

function check_present_address_component() {
	$('#present-address-component-iverify-pv-error-msg-div').html('');
	if ($('#present-address-component').is(':checked')) {
	 	$('#present-address-iverify-pv-div').removeClass('d-none');
	} else {
	 	$('#present-address-iverify-pv-div').addClass('d-none');
	 	$('.present-address-iverify-pv').prop('checked',false);
	}
}

$('.present-address-iverify-pv').on('click', function() {
	check_checked_present_address_iverify_pv_selected();
});

function check_checked_present_address_iverify_pv_selected() {
	if ($('input[name="present-address-iverify-pv[]"]:checked').length > 0) {
		$('#present-address-component-iverify-pv-error-msg-div').html('');
		return 1;
	} else {
		$('#present-address-component-iverify-pv-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 type.</span>');
		return 0;
	}
}

$("#permanent-address-component").on('click', function() {
	check_permanent_address_component();
});

function check_permanent_address_component() {
	$('#permanent-address-component-iverify-pv-error-msg-div').html('');
	if ($('#permanent-address-component').is(':checked')) {
	 	$('#permanent-address-iverify-pv-div').removeClass('d-none');
	} else {
	 	$('#permanent-address-iverify-pv-div').addClass('d-none');
	 	$('.permanent-address-iverify-pv').prop('checked',false);
	}
}

$('.permanent-address-iverify-pv').on('click', function() {
	check_checked_permanent_address_iverify_pv_selected();
});

function check_checked_permanent_address_iverify_pv_selected() {
	if ($('input[name="permanent-address-iverify-pv[]"]:checked').length > 0) {
		$('#permanent-address-component-iverify-pv-error-msg-div').html('');
		return 1;
	} else {
		$('#permanent-address-component-iverify-pv-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 type.</span>');
		return 0;
	}
}

$("#previous-address-component").on('click', function() {
	check_previous_address_component();
});

function check_previous_address_component() {
	$('#previous-address-component-iverify-pv-error-msg-div').html('');
	if ($('#previous-address-component').is(':checked')) {
	 	$('#previous-address-iverify-pv-div').removeClass('d-none');
	} else {
	 	$('#previous-address-iverify-pv-div').addClass('d-none');
	 	$('.previous-address-iverify-pv').prop('checked',false);
	}
}

$('.previous-address-iverify-pv').on('click', function() {
	check_checked_previous_address_iverify_pv_selected();
});

function check_checked_previous_address_iverify_pv_selected() {
	if ($('input[name="previous-address-iverify-pv[]"]:checked').length > 0) {
		$('#previous-address-component-iverify-pv-error-msg-div').html('');
		return 1;
	} else {
		$('#previous-address-component-iverify-pv-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 type.</span>');
		return 0;
	}
}

sessionStorage.clear(); 
function add_team(){
	 $("#skill-error").html("&nbsp;");
	var team_id = $("#team_id").val();
	var first_name = $("#first-name").val();
	var last_name = $("#last-name").val();
	var email = $("#email-id").val(); 
	var role = $("#role").val().toLowerCase();
	var contact = $("#contact-no").val();
	var user_name = $("#user-name").val();
	var manager = $("#report-manager").val();
	var approver = $("#approval").val();
	var approval_list = $("#approval-list").val();
	var selected_segment_check = 1;
	var skills = [];
	var formdata = new FormData();
	$('.skills:checked').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
			skills.push($(this).val());
		}
	});

	if(jQuery.inArray(role,role_list_for_segments_array) != -1) {
		selected_segment_check = check_segments();
	}

	if ((role == 'analyst' || role =='specialist' || role =='insuff analyst') && skills.length ==0) {
		$("#skill-error").html("<span class='text-danger'>Select atleast one skill.</span>");
		return false; 
	}

	formdata.append('present_address_component',0);
	var present_address_component_checked_type_status = 1;
	var present_address_component_checked_types = [];
	if ($('#present-address-component').is(':checked')) {
		formdata.append('present_address_component',1);
		present_address_component_checked_type_status = check_checked_present_address_iverify_pv_selected();
		if (present_address_component_checked_type_status == 1) {
			$('input[name="present-address-iverify-pv[]"]:checked').each(function(i) {
    		present_address_component_checked_types[i] = $(this).val();
   		});
   		formdata.append('present_address_component_checked_types',present_address_component_checked_types);
		}
	}

	formdata.append('permanent_address_component',0);
	var permanent_address_component_checked_type_status = 1;
	var permanent_address_component_checked_types = [];
	if ($('#permanent-address-component').is(':checked')) {
		formdata.append('permanent_address_component',1);
		permanent_address_component_checked_type_status = check_checked_permanent_address_iverify_pv_selected();
		if (permanent_address_component_checked_type_status == 1) {
			$('input[name="permanent-address-iverify-pv[]"]:checked').each(function(i) {
    		permanent_address_component_checked_types[i] = $(this).val();
   		});
   		formdata.append('permanent_address_component_checked_types',permanent_address_component_checked_types);
		}
	}

	formdata.append('previous_address_component',0);
	var previous_address_component_checked_type_status = 1;
	var previous_address_component_checked_types = [];
	if ($('#previous-address-component').is(':checked')) {
		formdata.append('previous_address_component',1);
		previous_address_component_checked_type_status = check_checked_previous_address_iverify_pv_selected();
		if (previous_address_component_checked_type_status == 1) {
			$('input[name="previous-address-iverify-pv[]"]:checked').each(function(i) {
    		previous_address_component_checked_types[i] = $(this).val();
   		});
   		formdata.append('previous_address_component_checked_types',previous_address_component_checked_types);
		}
	}

	if (first_name != '' && last_name != '' && email != '' && team_id != '' && selected_segment_check == 1 && present_address_component_checked_type_status == 1 && permanent_address_component_checked_type_status == 1 && previous_address_component_checked_type_status == 1) {
		var selected_segments = [];
		$('input[name="segment[]"]:checked').each(function(i) {
    		selected_segments[i] = $(this).val();
   		});

   		var level =[];
   		$('input[name="approval-level"]:checked').each(function(i) {
    		level[i] = $(this).val();
   		});
   		
   		formdata.append('team_id',team_id);
   		formdata.append('first_name',first_name);
		formdata.append('last_name',last_name);
		formdata.append('email',email);
		formdata.append('role',role);
		formdata.append('contact_no',contact);
		formdata.append('user_name',user_name);
		formdata.append('skill',skills);
		formdata.append('manager',manager);
		formdata.append('selected_segments',selected_segments);
		formdata.append('approver',approver);
		formdata.append('level',level);
		formdata.append('approval_list',approval_list);

		$.ajax({
			type: "POST",
		  	url: base_url+"team/update_team",
		  	data: formdata,
		  	contentType: false,
            processData: false,
		  	dataType: "json",
		  	success: function(data){ 
			  	if (data.status == '1') {
			  		// let html = "<span class='text-success'>Success data updated</span>";
					$('#error-team').html('');
					toastr.success('Team member has been updated successfully.');
					$("#first_name_"+team_id).html(first_name+' '+last_name);
					$("#team_employee_email_"+team_id).html(email);
					$("#contact_no_"+team_id).html(contact);
					$("#role_"+team_id).html(role);
					// $("#reporting_manager_"+team_id).html(manager);
			  	} else {
			  		// let html = "<span class='text-danger'>Somthing went wrong.</span>";
					$('#error-team').html('');
					toastr.error('SOmething went wrong while updating the data.');
		  		}
		  		$("#edit-team-view").modal('hide');
		  	} 
		});

	} else { 
		check_reccovery_password_match();
		check_valid_email();
		check_user_name();
		check_contact();
		valid_first_name();
		valid_last_name();
		valid_role();
		valid_report_manager();
		if (skills.length == 0) {
			$("#skill-error").html("<span class='text-danger'>Select atlease one skill.</span>");
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
	    	input_is_invalid("#email-id")
			$('#email-id-error').html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    } else {
	        $('#email-id-error').html("&nbsp;");
	        input_is_valid("#email-id")
	    }
	} else {
		$('#email-id-error').html('<span class="text-danger error-msg">Please enter email id.</span>');
		input_is_invalid("#email-id")
	}
}


$('#user-name').on('keyup blur',function() {
	check_user_name();
});

function check_user_name(){
	var user_name = $("#user-name").val();
	if (user_name != '') {
	    if(user_name > 4) {
	    	input_is_invalid("#user-name")
			$('#user-name-error').html("<span class='text-danger error-msg'>please enter min 4 digit user name.</span>");
	    } else {
	        $('#user-name-error').html("&nbsp;");
	        input_is_valid("#user-name")
	    }
	} else {
		input_is_invalid("#user-name")
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
      		input_is_valid("#contact-no")
    	}
  	} else {
  		input_is_invalid("#contact-no")
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
		input_is_valid("#first-name")
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg">Please enter your first name.</span>');
		input_is_invalid("#first-name")
	}
}

$('#last-name').on('keyup blur',function(){
	valid_last_name();
});


function valid_last_name(){
	var last_name = $('#last-name').val();
	if (last_name != '') {
		$('#last-name-error').html('&nbsp;');
		 input_is_valid("#last-name")
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg">Please enter your last name.</span>');
		 input_is_invalid("#last-name")
	}
}

$('#role').on('change',function(){ 
	valid_role();
});

function valid_role(){
	var role = $('#role').val();
	if (role != '' && role !=null) {
		$('#role-error').html('&nbsp;');
		role = role.toLowerCase();
		input_is_valid("#role")
				if (role == 'analyst' || role =='specialist'|| role =='insuff specialist'|| role =='insuff analyst' ||  role =='am') {
			$("#team-skill-div").show();
			// get_skills_list()
		}else{
			$("#team-skill-div").hide();
		}
	} else {
		$('#role-error').html('<span class="text-danger error-msg">Please select a role.</span>');
		input_is_invalid("#role")
	}
}

$('#report-manager-error').on('change',function(){
	valid_report_manager();
});

function valid_report_manager(){
	var manager = $('#report-manager').val();
	if (manager != '') {
		$('#report-manager-error').html('&nbsp;');
		input_is_valid("#report-manager")
	} else {
		input_is_invalid("#report-manager")
		$('#report-manager-error').html('<span class="text-danger error-msg">Please select the report manager.</span>');
	}
}

function delete_team(){
	var team_id = $("#remove_team_id").val()
	$.ajax({
		type: "POST",
	  	url: base_url+"team/remove_team",
	  	data: {team_id:team_id},
	  	dataType: "json",
	  	success: function(data){ 
	  		if (data.status=='1') {
	  			$("#tr_"+team_id).remove();
	  		}
	  		$("#remove-team-view").modal('hide')
	  	}
	 })
}


/**/

$("#approval-list").on("change",function(){
	var id = $(this).val();
		$(".approval_level_of").hide();
	if (id !='') {

	    	$.ajax({
	          type: "POST",
	          url: base_url+"approval_Mechanisms/get_list_of_value/",
	          data:{id:id},
	          dataType: 'json', 
	          success: function(data) { 
	          	if (data !='') {
	          		var levels = data.levels;
	          		var j = 1;
	          		for (var i = 0; i < levels; i++) {
	          			$("#approval_level_of"+(j++)).show();
	          		}
	          	}
	          }
     	 });
	}
})

