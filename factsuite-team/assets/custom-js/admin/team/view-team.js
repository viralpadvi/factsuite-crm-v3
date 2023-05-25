var address_component_ids = [8,9,12];

function load_team(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"team/get_view_team",
	  	data:{
	  		token:'3ZGErMDCwxTOZYFp'
	  	},
	  	dataType: "json",
	  	success: function(data){ 
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	html += '<tr id="tr_'+data[i].team_id+'">'; 
        	html += '<td>'+j+'</td>';
        	html += '<td id="team_id_'+data[i].team_id+'">'+data[i]['team_id']+'</td>';
        	html += '<td class="text-capitalize" id="first_name_'+data[i].team_id+'">'+data[i]['first_name']+' '+data[i]['last_name']+'</td>';
        	html += '<td id="team_employee_email_'+data[i].team_id+'">'+data[i]['team_employee_email']+'</td>';
        	html += '<td id="contact_no_'+data[i].team_id+'">'+data[i]['contact_no']+'</td>';
        	html += '<td id="role_'+data[i].team_id+'">'+data[i]['role']+'</td>';
        	html += '<td id="reporting_manager_'+data[i].team_id+'">'+data[i]['reporting_manager']+'</td>';
        	if (data[i]['role'] !='admin' && data[i]['role'] !='csm') {  
        	html += '<td><a onclick="view_edit_team('+data[i].team_id+')" href="#"><i class="fa fa-pencil"></i></a></div><a onclick="remove_team_field('+data[i].team_id+')" href="#" class=" ml-1 d-none" ><i class="fa fa-trash text-danger"></i></a></td>';
        	}else{
        		html += '<td></td>';
        	}
        	html += '</tr>';
 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No team Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}


// get_skills_list();
function get_skills_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"admin_Vendor/get_vendor_skills",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '';
      		if(data.length > 0) {
        		for(var i = 0;i < data.length; i++) {
        			html += '<li>';
                  	html += '<div class="custom-control custom-checkbox custom-control-inline">';
                    html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="vendor-skills-'+data[i].component_id+'" value="'+data[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+data[i].component_id+'">'+data[i][component_config_name]+'</label>';
                  	html += '</div>';
                	html += '</li>';
        		}
      		} else {
        		html += '<li value="">No Component Available</option>';
      		}
      		$('#team-skills-list').html(html);
    	}
  	});
}


function remove_team_field(team_id){
	$("#remove_team_id").val(team_id)
	$("#remove-team-view").modal('show')
}
function view_edit_team(team_id){ 
	$("#team-skill-div").show();
	$('#error-team').html('');
	$(".approval-level").prop('checked',false);
		$.ajax({
		type: "POST",
	  	url: base_url+"team/get_view_team_single/"+team_id, 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data))
	  		// alert(data.team_list.first_name)
	  		$("#team_id").val(data.team_list[0].team_id);
				$("#first-name").val(data.team_list[0].first_name);
				$("#last-name").val(data.team_list[0].last_name);
				$("#email-id").val(data.team_list[0].team_employee_email);  
				$("#contact-no").val(data.team_list[0].contact_no);
				$("#user-name").val(data.team_list[0].user_name);
				$("#approval").val(data.team_list[0].approver_status);
				$("#approval-list").val(data.team_list[0].approval_list);
				var permission = data.team_list[0].approval_access_level;
 				 // $('.approval-level').attr('checked', false);
 
				 if (data.approval !='' && data.approval !=null) {
				 	var levels = data.approval.levels;
	          		var j = 1;
	          		for (var n = 0; n < levels; n++) {
	          			$("#approval_level_of"+(j++)).show();
	          		}
				 }
				if (permission !=null) {
					permission = permission.split(',');
					for (var i = 0; i < permission.length; i++) {  
 						 $('#customCheck'+permission[i]).prop('checked', true);
 
					}
				}
				$("#role").val(data.team_list[0].role.toLowerCase()).trigger('change');
				var html ='<option  value="">Select Manager</option>'
				for (var i = 0; i < data.team.length; i++) {
					if (data.team[i].first_name == data.team_list[0].reporting_manager) { 
						html +='<option selected value='+data.team[i].team_id+'>'+data.team[i].first_name+' ('+data.team[i].role+')</option>'
					} else {
						html +='<option value='+data.team[i].team_id+'>'+data.team[i].first_name+' ('+data.team[i].role+')</option>'
					}
				}
				$("#report-manager").html(html); 
				var arr =''; 
				if (data.team_list[0].skills !='' && data.team_list[0].skills !=null) {
					arr = data.team_list[0].skills.split(',');
				} 

				var html_skill = '',
      			address_component_html = '';
				for (var i = 0; i < data.skill_list.length; i++) {
					if (jQuery.inArray(parseInt(data.skill_list[i].component_id),address_component_ids) != -1) {
    				if (data.skill_list[i].component_id == 8) {
    					address_component_html += '<div class="row">';
    					address_component_html += '<div class="col-md-4">';
    					address_component_html += '<li class="w-100">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
            	var checked = '',
            			iverify_pv_div = ' d-none';
            	if (jQuery.inArray(data.skill_list[i].component_id, arr) != -1) {
            		checked = ' checked';
            		iverify_pv_div = '';
            	}
              address_component_html += '<input type="checkbox"'+checked+' class="custom-control-input skills" name="vendor-skills-'+data.skill_list[i].component_id+'" id="present-address-component" value="'+data.skill_list[i].component_id+'" onclick="check_present_address_component();"> <label class="custom-control-label" for="present-address-component">'+data.skill_list[i][component_config_name]+'</label>';
            	address_component_html += '</div>';
              address_component_html += '</li>';
    					address_component_html += '</div>';
    					address_component_html += '<div class="col-md-8'+iverify_pv_div+'" id="present-address-iverify-pv-div">';
    					var iverify_checked = '',
    							pv_checked = '';
    					if (data.team_list[0].present_address_iverify_status == 1) {
    						iverify_checked = ' checked';
    					}

    					if (data.team_list[0].present_address_pv_status == 1) {
    						pv_checked = ' checked';
    					}
    					address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+iverify_checked+' class="custom-control-input present-address-iverify-pv" name="present-address-iverify-pv[]" id="present-address-iverify" value="1" onclick="check_checked_present_address_iverify_pv_selected();"> <label class="custom-control-label" for="present-address-iverify">Iverify</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+pv_checked+' class="custom-control-input present-address-iverify-pv" name="present-address-iverify-pv[]" id="present-address-pv" value="2" onclick="check_checked_present_address_iverify_pv_selected();"> <label class="custom-control-label" for="present-address-pv">PV</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<div id="present-address-component-iverify-pv-error-msg-div"></div>';
    					address_component_html += '</div>';
    					address_component_html += '</div>';
    				} else if (data.skill_list[i].component_id == 9) {
    					address_component_html += '<div class="row">';
    					address_component_html += '<div class="col-md-4">';
    					address_component_html += '<li class="w-100">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
            	var checked = '',
            			iverify_pv_div = ' d-none';
            	if (jQuery.inArray(data.skill_list[i].component_id, arr) != -1) {
            		checked = ' checked';
            		iverify_pv_div = '';
            	}
              address_component_html += '<input type="checkbox"'+checked+' class="custom-control-input skills" name="vendor-skills-'+data.skill_list[i].component_id+'" id="permanent-address-component" value="'+data.skill_list[i].component_id+'" onclick="check_permanent_address_component();"> <label class="custom-control-label" for="permanent-address-component">'+data.skill_list[i][component_config_name]+'</label>';
            	address_component_html += '</div>';
              address_component_html += '</li>';
    					address_component_html += '</div>';
    					address_component_html += '<div class="col-md-8'+iverify_pv_div+'" id="permanent-address-iverify-pv-div">';
    					var iverify_checked = '',
    							pv_checked = '';
    					if (data.team_list[0].permanent_address_iverify_status == 1) {
    						iverify_checked = ' checked';
    					}

    					if (data.team_list[0].permanent_address_pv_status == 1) {
    						pv_checked = ' checked';
    					}
    					address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+iverify_checked+' class="custom-control-input permanent-address-iverify-pv" name="permanent-address-iverify-pv[]" id="permanent-address-iverify" value="1" onclick="check_checked_permanent_address_iverify_pv_selected();"> <label class="custom-control-label" for="permanent-address-iverify">Iverify</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+pv_checked+' class="custom-control-input permanent-address-iverify-pv" name="permanent-address-iverify-pv[]" id="permanent-address-pv" value="2" onclick="check_checked_permanent_address_iverify_pv_selected();"> <label class="custom-control-label" for="permanent-address-pv">PV</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<div id="permanent-address-component-iverify-pv-error-msg-div"></div>';
    					address_component_html += '</div>';
    					address_component_html += '</div>';
    				} else if (data.skill_list[i].component_id == 12) {
    					address_component_html += '<div class="row">';
    					address_component_html += '<div class="col-md-4">';
    					address_component_html += '<li class="w-100">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
            	var checked = '',
            			iverify_pv_div = ' d-none';
            	if (jQuery.inArray(data.skill_list[i].component_id, arr) != -1) {
            		checked = ' checked';
            		iverify_pv_div = '';
            	}
              address_component_html += '<input type="checkbox"'+checked+' class="custom-control-input skills" name="vendor-skills-'+data.skill_list[i].component_id+'" id="previous-address-component" value="'+data.skill_list[i].component_id+'" onclick="check_previous_address_component();"> <label class="custom-control-label" for="previous-address-component">'+data.skill_list[i][component_config_name]+'</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
    					address_component_html += '</div>';
    					address_component_html += '<div class="col-md-8'+iverify_pv_div+'" id="previous-address-iverify-pv-div">';
    					var iverify_checked = '',
    							pv_checked = '';
    					if (data.team_list[0].previous_address_iverify_status == 1) {
    						iverify_checked = ' checked';
    					}

    					if (data.team_list[0].previous_address_pv_status == 1) {
    						pv_checked = ' checked';
    					}
    					address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+iverify_checked+' class="custom-control-input previous-address-iverify-pv" name="previous-address-iverify-pv[]" id="previous-address-iverify" value="1" onclick="check_checked_previous_address_iverify_pv_selected();"> <label class="custom-control-label" for="previous-address-iverify">Iverify</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<li class="p-0">';
            	address_component_html += '<div class="custom-control custom-checkbox custom-control-inline">';
              address_component_html += '<input type="checkbox"'+pv_checked+' class="custom-control-input previous-address-iverify-pv" name="previous-address-iverify-pv[]" id="previous-address-pv" value="2" onclick="check_checked_previous_address_iverify_pv_selected();"> <label class="custom-control-label" for="previous-address-pv">PV</label>';
            	address_component_html += '</div>';
            	address_component_html += '</li>';
            	address_component_html += '<div id="previous-address-component-iverify-pv-error-msg-div"></div>';
    					address_component_html += '</div>';
    					address_component_html += '</div>';
    				}
    			} else {
    				html_skill += '<li>';
	          html_skill += '<div class="custom-control custom-checkbox custom-control-inline">';
	          if (jQuery.inArray(data.skill_list[i].component_id, arr) != '-1') {   
	            html_skill += '<input type="checkbox" checked class="custom-control-input skills" name="vendor-skills-'+data.skill_list[i].component_id+'" id="vendor-skills-'+data.skill_list[i].component_id+'" value="'+data.skill_list[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+data.skill_list[i].component_id+'">'+data.skill_list[i][component_config_name]+'</label>';
						} else {
	            html_skill += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data.skill_list[i].component_id+'" id="vendor-skills-'+data.skill_list[i].component_id+'" value="'+data.skill_list[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+data.skill_list[i].component_id+'">'+data.skill_list[i][component_config_name]+'</label>';
						}
	          html_skill += '</div>';
	          html_skill += '</li>'; 
    			}
				}
			 	$('#team-skills-list').html(address_component_html);
			 	$('#team-skills-list').append(html_skill);

				$('#segment-list-div').html('');
				if(jQuery.inArray(data.team_list[0].role.toLowerCase(),role_list_for_segments_array) != -1) {
					var all_segments = JSON.parse(data.all_segments), 
						html_segment = '<div class="col-md-12"><h3>Select Segments</h3></div>';
					for (var i = 0; i < all_segments.length; i++) {
						var checked = '';
						if(data.team_list[0].assigned_segments != '' && data.team_list[0].assigned_segments != null) {
							if (jQuery.inArray(all_segments[i].id.toString(), data.team_list[0].assigned_segments.split(',')) != -1) {
	          		checked = ' checked';
							}
						}
						html_segment += '<div class="col-md-2">';
	      		html_segment += '<div class="custom-control custom-checkbox custom-control-inline">';
	          html_segment += '<input type="checkbox"'+checked+' class="custom-control-input segments" value="'+all_segments[i].id+'" name="segment[]" id="segment-'+all_segments[i].id+'" onclick="check_segments()">';
	         	html_segment += '<label class="custom-control-label" for="segment-'+all_segments[i].id+'">'+all_segments[i].name+'</label>';
	        	html_segment += '</div>';
	        	html_segment += '</div>';
					}
					html_segment += '<div class="col-md-12" id="segment-error-msg-div"></div>';
				 	$('#segment-list-div').html(html_segment);
				}

				$("#edit-team-view").modal('show');

			if (data.team_list[0].role.toLowerCase() == 'analyst' || data.team_list[0].role.toLowerCase() =='specialist' || data.team_list[0].role.toLowerCase() =='insuff specialist' || data.team_list[0].role.toLowerCase() =='insuff analyst' || data.team_list[0].role.toLowerCase() =='am' ) {
				// alert(data.team_list[0].role)
				$("#team-skill-div").show(); 
		}else{
			// alert('false')
			$("#team-skill-div").hide();
		}
		}
	})
}

function view_change_team_password(id){
	 
	$("#team-change-pass-div").modal('show');
	$("#selected_team_id").val(id);
	$('#new-password').val('')
			  		$('#verify-new-password').val('')
}


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
		formdata.append('verify_admin_request',1);
		formdata.append('new_password',$('#new-password').val());
		formdata.append('team_id',$('#selected_team_id').val());

		$.ajax({
			type: "POST",
		  	url: base_url+"team/verify_and_reset_password",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
		  			$("#team-change-pass-div").modal('hide');
			  		$('#save-password-btn').prop('disabled',false);
					$('#verify-new-password-error-msg-div').html('');
				  	if (data.reset.status == '1') {
			  		$('#new-password').val('')
			  		$('#verify-new-password').val('')
				  		// setTimeout(function() { window.location = base_url; }, 3000);
				  		toastr.success('The password has been reset successfully.');
				  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				  			// setTimeout(function() { window.location = base_url; }, 3000);
				  		} else {
				  			// setTimeout(function() { window.location = base_url; }, 3000);
				  		}
				  	/*} else if (data.reset.status == '2') {
				  		toastr.warning('Entered mail id doesn\'t exists with us. Please enter the correct mail id.');
			  		} else {
			  			toastr.error('Something went wrong. Please try again.');
			  		}*/
			  	} else {
			  		toastr.error('Something went wrong. Please try again.');
			  		if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			  			// setTimeout(function() { window.location = base_url; }, 3000);
			  		} else {
			  			// setTimeout(function() { window.location = base_url; }, 3000);
			  		}
			  	}
		  	}},
		  	error: function(data) {
		  		$('#save-password-btn').prop('disabled',false);
				$('#verify-new-password-error-msg-div').html('');
		  		toastr.error('Something went wrong. Please try again.');
		  	}
		});
	}
}