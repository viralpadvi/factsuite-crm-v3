var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
	email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5,
	vendor_docs = [],
	vendor_document_size = 1000000,
	max_vendor_document_select = 6,
	vendor_manager_name_length = 200,
	mobile_number_length = 10,
	vendor_spoc_name_length = 200,
	vendor_first_name_length = 100,
	vendor_last_name_length = 100,
	vendor_user_name_length = 70,
	min_vendor_user_name_length = 8,
	password_length = 8,
	vendor_skill_tat_length = 3,
	role_list_for_segments_array = ['analyst','specialist'],
	address_component_ids = [8,9,12];

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

function get_segment_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"factsuite-admin/get-all-segments",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '<div class="col-md-12"><h3>Select Segments</h3></div>';
      		if(data.length > 0) { 
        		for(var i = 0;i < data.length; i++) {
        			html += '<div class="col-md-2">';
        			html += '<div class="custom-control custom-checkbox custom-control-inline">';
                    html += '<input type="checkbox" class="custom-control-input segments" value="'+data[i].id+'" name="segment[]" id="segment-'+data[i].id+'" onclick="check_segments()">';
                   	html += '<label class="custom-control-label" for="segment-'+data[i].id+'">'+data[i].name+'</label>';
                  	html += '</div>';
                  	html += '</div>';
        		}
        		html += '<div class="col-md-12" id="segment-error-msg-div"></div>';
      		} else {
        		html += '<div class="col-md-12 text-center">No Segment Available</div>';
      		}
      		$('#segment-list-div').html(html);
    	}
  	});
}

get_skills_list();
function get_skills_list() {
	sessionStorage.clear(); 
	$.ajax({
    	type:'ajax',
    	url: base_url+"admin_Vendor/get_vendor_skills",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '',
      			address_component_html = '';
      		if(data.length > 0) { 
        		for(var i = 0;i < data.length; i++) {
        			if (jQuery.inArray(parseInt(data[i].component_id),address_component_ids) != -1) {
        				if (data[i].component_id == 8) {
        					address_component_html += '<div class="row">';
        					address_component_html += '<div class="col-md-3">';
        					address_component_html += '<li class="w-100">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="present-address-component" value="'+data[i].component_id+'" onclick="check_present_address_component();"> <label class="custom-control-label" for="present-address-component">'+data[i][component_config_name]+'</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
        					address_component_html += '</div>';
        					address_component_html += '<div class="col-md-9 d-none" id="present-address-iverify-pv-div">';
        					address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input present-address-iverify-pv" name="present-address-iverify-pv[]" id="present-address-iverify" value="1" onclick="check_checked_present_address_iverify_pv_selected();"> <label class="custom-control-label" for="present-address-iverify">Iverify</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input present-address-iverify-pv" name="present-address-iverify-pv[]" id="present-address-pv" value="2" onclick="check_checked_present_address_iverify_pv_selected();"> <label class="custom-control-label" for="present-address-pv">PV</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<div id="present-address-component-iverify-pv-error-msg-div"></div>';
        					address_component_html += '</div>';
        					address_component_html += '</div>';
        				} else if (data[i].component_id == 9) {
        					address_component_html += '<div class="row">';
        					address_component_html += '<div class="col-md-3">';
        					address_component_html += '<li class="w-100">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="permanent-address-component" value="'+data[i].component_id+'" onclick="check_permanent_address_component();"> <label class="custom-control-label" for="permanent-address-component">'+data[i][component_config_name]+'</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
        					address_component_html += '</div>';
        					address_component_html += '<div class="col-md-9 d-none" id="permanent-address-iverify-pv-div">';
        					address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input permanent-address-iverify-pv" name="permanent-address-iverify-pv[]" id="permanent-address-iverify" value="1" onclick="check_checked_permanent_address_iverify_pv_selected();"> <label class="custom-control-label" for="permanent-address-iverify">Iverify</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input permanent-address-iverify-pv" name="permanent-address-iverify-pv[]" id="permanent-address-pv" value="2" onclick="check_checked_permanent_address_iverify_pv_selected();"> <label class="custom-control-label" for="permanent-address-pv">PV</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<div id="permanent-address-component-iverify-pv-error-msg-div"></div>';
        					address_component_html += '</div>';
        					address_component_html += '</div>';
        				} else if (data[i].component_id == 12) {
        					address_component_html += '<div class="row">';
        					address_component_html += '<div class="col-md-3">';
        					address_component_html += '<li class="w-100">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="previous-address-component" value="'+data[i].component_id+'" onclick="check_previous_address_component();"> <label class="custom-control-label" for="previous-address-component">'+data[i][component_config_name]+'</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
        					address_component_html += '</div>';
        					address_component_html += '<div class="col-md-9 d-none" id="previous-address-iverify-pv-div">';
        					address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input previous-address-iverify-pv" name="previous-address-iverify-pv[]" id="previous-address-iverify" value="1" onclick="check_checked_previous_address_iverify_pv_selected();"> <label class="custom-control-label" for="previous-address-iverify">Iverify</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<li class="p-0">';
		                  	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
		                    address_component_html += '<input type="checkbox" class="custom-control-input previous-address-iverify-pv" name="previous-address-iverify-pv[]" id="previous-address-pv" value="2" onclick="check_checked_previous_address_iverify_pv_selected();"> <label class="custom-control-label" for="previous-address-pv">PV</label>';
		                  	address_component_html += '</div>';
		                	address_component_html += '</li>';
		                	address_component_html += '<div id="previous-address-component-iverify-pv-error-msg-div"></div>';
        					address_component_html += '</div>';
        					address_component_html += '</div>';
        				}
        			} else {
        				html += '<li>';
	                  	html += '<div class="custom-control custom-checkbox custom-control-inline">';
	                    html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="vendor-skills-'+data[i].component_id+'" value="'+data[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+data[i].component_id+'">'+data[i][component_config_name]+'</label>';
	                  	html += '</div>';
	                	html += '</li>';
        			}
        		}
      		} else {
        		html += '<li>No Component Available</option>';
      		}
      		$('#team-skills-list').html(address_component_html);
      		$('#team-skills-list').append(html);
    	}
  	});
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

function add_team() { 
	$("#skill-error").html("&nbsp;");
	var first_name = $("#first-name").val();
	var last_name = $("#last-name").val();
	var email = $("#email-id").val();
	var password = $("#team-password").val();
	var role = $("#role").val().toLowerCase();
	var contact = $("#contact-no").val();
	var user_name = $("#user-name").val();
	var manager = $("#report-manager").val();
	var approver = $("#approver").val();
	var approval_list = $("#approval-list").val();
	var selected_segment_check = 1;
	var skills = [];
	var formdata = new FormData();
	$('.skills:checked').each(function() {
		if ($(this).val() !='' && $(this).val() !=null) {
			skills.push($(this).val());
		}
	});

	if ((role == 'analyst' || role =='specialist') && skills.length == 0) {
		$("#skill-error").html("<span class='text-danger error-msg-small'>Select atleast one Skill.</span>");
		return false; 
	}

   	if(jQuery.inArray(role,role_list_for_segments_array) != -1) {
		selected_segment_check = check_segments();
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

	if (first_name != '' && last_name != '' && email != '' && selected_segment_check == 1 && present_address_component_checked_type_status == 1 && permanent_address_component_checked_type_status == 1 && previous_address_component_checked_type_status == 1) {
		let html = "<span class='text-warning text-right error-msg-small'>Please wait we are submiting the data.</span>";
		$('#error-team').html(html);
		$("#team-submit-btn").attr('disabled',true);
		$("#team-submit-btn").css('pointer-events', 'none');

		var selected_segments = [];
		$('input[name="segment[]"]:checked').each(function(i) {
    		selected_segments[i] = $(this).val();
   		});

   		var level =[];
   		$('input[name="approval-level"]:checked').each(function(i) {
    		level[i] = $(this).val();
   		});

   		formdata.append('first_name',first_name);
		formdata.append('last_name',last_name);
		formdata.append('email',email);
		formdata.append('password',password);
		formdata.append('role',role);
		formdata.append('contact_no',contact);
		formdata.append('user_name',user_name);
		formdata.append('skill',skills);
		formdata.append('manager',manager);
		formdata.append('selected_segments',selected_segments);
		formdata.append('level',level);
		formdata.append('approver',approver);
		formdata.append('approval_list',approval_list);

		$.ajax({
			type: "POST",
		  	url: base_url+"team/insert_team",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
            processData: false,
		  	success: function(data){ 
			  	if (data.status == '1') {
			  		// let html = "<span class='text-success text-right error-msg-small'>data has successfully inserted</span>";
			  		var html = '';
					$('#error-team').html(html);
					toastr.success('New data has been successfully inserted.');
					$("#first-name").val('');
					$("#last-name").val('');
					$("#email-id").val('');
					$("#team-password").val(''); 
					$("#contact-no").val('');
					$("#user-name").val('');
					$('.skills:checked').each(function() {
						this.checked = false;
					});
					$('#segment-list-div').empty();
					check_present_address_component();
					check_permanent_address_component();
					check_previous_address_component();
			  	} else {
			  		// let html = "<span class='text-danger text-right error-msg-small'>Somthing went wrong.</span>";
					$('#error-team').html('');
					toastr.error('Something went wrong while creating adding the data. Please try again');
		  		}
		  		$("#team-submit-btn").attr('disabled',false);
		  		$('#team-submit-btn').removeAttr('style');
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
			$("#skill-error").html("<span class='text-danger error-msg-small'>Select atlease one skill.</span>");
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
			input_is_valid("#confirm-team-password")
            $("#new-confirm-password-error-msg-div").html("<span class='text-success error-msg-small'>Passwords are same</span>");
        } else {
        	input_is_invalid("#confirm-team-password")
            $("#new-confirm-password-error-msg-div").html("<span class='text-danger error-msg-small'>Passwords didnt matched.</span>");
        }
	} else {
		if (password == '') {
			input_is_invalid("#team-password")
			$("#new-password-error-msg-div").html('<span class="text-danger error-msg-small">Please enter your password.</span>');
		} else {
			$("#new-password-error-msg-div").html('&nbsp;');
			input_is_valid("#team-password")

		}

		if (confirm_password == '') {
			input_is_invalid("#confirm-team-password")
			$('#new-confirm-password-error-msg-div').html('<span class="text-danger error-msg-small">Please confirm your password.</span>');
		} else {
			$('#new-confirm-password-error-msg-div').html('&nbsp;');
			input_is_valid("#confirm-team-password")
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
			$('#email-id-error').html("<span class='text-danger error-msg-small'>Please enter a valid email id</span>");
	    } else {

	    	$.ajax({
	          type: "POST",
	          url: base_url+"team/duplicate_email/",
	          data:{email:user_email},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {
	          		$('#email-id-error').html("&nbsp;");
	        input_is_valid("#email-id")
	        $("#team-submit-btn").attr('disabled',false);
			    }else{
			    	input_is_invalid('#email-id');
			    	// $("#spoc-email"+id).val('');
			    	$("#team-submit-btn").attr('disabled',true);
					$('#email-id-error').html('<span class="text-danger error-msg-small">This email id already exists.</span>');
			    }
	          }
     	 });
	        
	    }
	} else {
		$('#email-id-error').html('<span class="text-danger error-msg-small">Please enter email id.</span>');
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
			$('#user-name-error').html("<span class='text-danger error-msg-small'>Please enter min 4 digit user name.</span>");
	    } else {
	        $('#user-name-error').html("&nbsp;");
	        input_is_valid("#user-name")
	    }
	} else {
		input_is_invalid("#user-name")
		$('#user-name-error').html('<span class="text-danger error-msg-small">Please enter user name.</span>');
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
    	} else if(user_contact.length ==10 ){

	    	$.ajax({
	          type: "POST",
	          url: base_url+"team/duplicate_contact/",
	          data:{contact:user_contact},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {
	          		$('#contact-no-error').html('&nbsp;');
      				input_is_valid("#contact-no")
      				$("#team-submit-btn").attr('disabled',false);
			    }else{
			    	$("#team-submit-btn").attr('disabled',true);
			    	input_is_invalid("#contact-no"); 
					$('#contact-no-error').html('<span class="text-danger error-msg-small">This number already exists.</span>');
			    }
	          }
     	 });

    	}
  	} else {
  		input_is_invalid("#contact-no")
    	$('#contact-no-error').html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
  	}
}

$('#first-name').on('keyup blur',function(){
	valid_first_name();
});

$('#last-name').on('keyup blur',function(){
	valid_last_name();
}); 

function valid_first_name(){
	 
	var first_name = $('#first-name').val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be only alphabets.</span>');
			$('#first-name').val(first_name.slice(0,-1));
			input_is_invalid('#first-name');
		} else if (first_name.length > vendor_name_length) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be of max '+vendor_name_length+' characters.</span>');
			$('#first-name').val(first_name.slice(0,vendor_name_length));
			input_is_invalid('#first-name');
		} else {
			$('#first-name-error').html('&nbsp;');
			input_is_valid('#first-name');
		}
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter first name.</span>');
		input_is_invalid('#first-name');
	}
}

function valid_last_name(){
	 
	var last_name = $('#last-name').val();
	if (last_name != '') {
		if (!alphabets_only.test(last_name)) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be only alphabets.</span>');
			$('#last-name').val(last_name.slice(0,-1));
			input_is_invalid('#last-name');
		} else if (last_name.length > vendor_name_length) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be of max '+vendor_name_length+' characters.</span>');
			$('#last-name').val(last_name.slice(0,vendor_name_length));
			input_is_invalid('#last-name');
		} else {
			$('#last-name-error').html('&nbsp;');
			input_is_valid('#last-name');
		}
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please enter last name.</span>');
		input_is_invalid('#last-name');
	}
}

$('#role').on('change',function(){ 
	valid_role();
});

function valid_role() {
	var role = $('#role').val().toLowerCase();
	if (role != '') {
		$('#role-error').html('&nbsp;');
		input_is_valid("#role");
		if (role == 'analyst' || role =='specialist'|| role =='insuff specialist'|| role =='insuff analyst' ||  role =='am') {
			if(jQuery.inArray(role,role_list_for_segments_array) != -1) {
				get_segment_list();
			} else {
				$('#segment-list-div').empty();
			}
			$("#team-skill-div").show();
			get_skills_list();
		}else{
			$('#segment-list-div').empty();
			$("#team-skill-div").hide();
		}
	} else {
		$('#segment-list-div').empty();
		$('#role-error').html('<span class="text-danger error-msg-small">Please select a role.</span>');
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
		$('#report-manager-error').html('<span class="text-danger error-msg-small">Please select the report manager.</span>');
	}
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