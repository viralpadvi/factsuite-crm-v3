function edit_candidate_details_modal(candidate_id) {
	$('#edit-case-step-1, #edit-case-step-2, #edit-case-step-3').removeClass('active success');
	$('#edit-case-step-1').addClass('active');

	$('#edit-case-step-2-tab, #edit-case-step-3-tab').addClass('d-none').removeClass('d-block');
	$('#edit-case-step-1-tab').removeClass('d-none').addClass('d-block');
	$("#edit-CheckAll").prop('checked', false);
	$('#modal-edit-candidate-id').val(candidate_id);
	var formdata = new FormData(); 
		formdata.append('verify_client_request', 1);
		formdata.append('candidate_id', candidate_id);

	$.ajax({
		type: "POST",
	  	url: base_url+"factsuite-client/get-single-case-details",
	  	data: formdata,
	  	dataType: "json",
	  	contentType: false,
	    processData: false,
	  	success: function(data) {
		  	if (data.status == '1') {
		  		var case_details = data.case_details,
		  			mr = '',
					miss = '',
					mrs = '',
					country_code_list = JSON.parse(data.country_code_list);
				
				if (case_details[0].title.toLowerCase() == 'mr') {
					mr = 'selected';
				} else if (case_details[0].title.toLowerCase() == 'miss') {
					miss = 'selected';
				} else {
					mrs = 'selected';
				}

				var title_html = '<option '+mr+' value="mr">Mr</option>';
					title_html += '<option '+miss+' value="Miss">Miss</option>';
					title_html += '<option '+mrs+' value="Mrs">Mrs</option>';
		  		
		  		$('#edit-title-v2').html(title_html);
		  		$("#candidate_id-v2").val(case_details[0].candidate_id);
		  		$('#edit-first-name-v2').val(case_details[0].first_name);
		  		$('#edit-last-name-v2').val(case_details[0].last_name);
		  		$('#edit-father-name-v2').val(case_details[0].father_name);
		  		$('#edit-email-id-v2').val(case_details[0].email_id);

		  		var country_code_html = '';
		  		for (var i = 0; i < country_code_list.length; i++) {
		  			var selected = '';
		  			if (country_code_list[i].dial_code == case_details[0].country_code) {
		  				selected = ' selected';
		  			}
		  			country_code_html += '<option'+selected+' value="'+country_code_list[i].dial_code+'">'+country_code_list[i].dial_code+' ('+country_code_list[i].name+')</option>';
		  		}
		  		$('#edit-country-code').html(country_code_html);
		  		$('#edit-contact-no-v2').val(case_details[0].phone_number);
		  		$('#edit-birth-date-v2').val(case_details[0].date_of_birth);
		  		$('#edit-joining-date-v2').val(case_details[0].date_of_joining);
		  		$('#edit-employee-id-v2').val(case_details[0].employee_id);
		  		$('#edit-segment').val(case_details[0].segment);
		  		$('#edit-remark-v2').val(case_details[0].remark);
		  		$('#edit-cost-center').val(case_details[0].cost_center);

		  		var package = data.package,
		  			package_html = '<option value="">No Package Found</option>';

		  		if (package.length > 0) {
		  			package_html = '';
			  		for (var i = 0; i < package.length; i++) {
			  			var selected = '';
			  			if (case_details[0].package_name == package[i].package_id) {
			  				selected = 'selected';
			  			}
			  			package_html += '<option '+selected+' value="'+package[i].package_id+'">'+package[i].package_name+'</option>';
			  		}
			  	}
			  	$('#edit-package-v2').html(package_html);

			  	var client_uploader = '',
			  		candidate_uploader = '';

			  	if (case_details[0].document_uploaded_by.toLowerCase() == 'client') {
			  		client_uploader = 'selected';
			  	} else if (case_details[0].document_uploaded_by.toLowerCase() == 'candidate') {
			  		candidate_uploader = 'selected';
			  	}

			  	var uploader_html = '<option '+client_uploader+' value="client">Client</option>';
			  	uploader_html += '<option '+candidate_uploader+' value="candidate">Candidate</option>';
			  	$('#edit-document-uploader-v2').html(uploader_html);

			  	get_edit_checked_skills_list_v2(case_details[0].package_name,case_details[0].candidate_id);

		  		$('#modal-edit-case-v2').modal('show');
		  	} else {
		  		toastr.error('OOPS! Something went wrong while adding the Product details. Please try again.');
	  		}
	  	} 
	});
}

$('#edit-first-name-v2').on('keyup blur', function() {
	check_edit_first_name_v2();	
});

$('#edit-last-name-v2').on('keyup blur', function() {
	check_edit_last_name_v2();	
});

$('#edit-father-name-v2').on('keyup blur', function() {
	check_edit_father_name_v2();	
});

$('#edit-email-id-v2').on('keyup blur', function() {
	check_edit_email_id_v2();	
});

$('#edit-contact-no-v2').on('keyup blur', function() {
	check_edit_contact_no_v2();	
});

$('#edit-case-step-1-next-btn').on('click', function() {
	check_edit_case_step_1_next_btn();
});

$('#edit-case-back-to-step-1-btn').on('click', function() {
	edit_case_back_to_step_1_btn();
});

function check_edit_first_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-first-name-v2';
	variable_array['error_msg_div_id'] = '#edit-first-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate first name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_first_name_max_length+' characters';
	variable_array['max_length'] = candidate_first_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_edit_last_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-last-name-v2';
	variable_array['error_msg_div_id'] = '#edit-last-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate first name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_last_name_max_length+' characters';
	variable_array['max_length'] = candidate_last_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_edit_father_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-father-name-v2';
	variable_array['error_msg_div_id'] = '#edit-father-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate father name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_father_name_max_length+' characters';
	variable_array['max_length'] = candidate_father_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_edit_email_id_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-email-id-v2';
	variable_array['error_msg_div_id'] = '#edit-email-id-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter your email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function check_edit_contact_no_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-contact-no-v2';
	variable_array['error_msg_div_id'] = '#edit-contact-no-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter your phone number';
	variable_array['not_a_number_input_error_msg'] = 'Mobile number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Mobile number should be of '+initiate_mobile_number_length+' digits';
	variable_array['max_length'] = initiate_mobile_number_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}

function check_edit_candidate_birth_date() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-birth-date-v2';
	variable_array['error_msg_div_id'] = '#edit-birth-date-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select the candidate DOB.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_edit_case_step_1_next_btn() {
	var check_first_name_v2_var = check_edit_first_name_v2(),
		check_last_name_v2_var = check_edit_last_name_v2(),
		check_father_name_v2_var = check_edit_father_name_v2(),
		check_email_id_v2_var = check_edit_email_id_v2(),
		check_contact_no_v2_var = check_edit_contact_no_v2(),
		check_candidate_birth_date_var = check_edit_candidate_birth_date();
	if (check_first_name_v2_var == 1 && check_last_name_v2_var == 1 &&check_father_name_v2_var == 1 &&
		check_email_id_v2_var == 1 && check_contact_no_v2_var == 1 && check_candidate_birth_date_var == 1) {
		$('#edit-case-step-1').removeClass('active').addClass('success');
		$('#edit-case-step-2').addClass('active');
		$('#edit-case-step-1-tab').addClass('d-none').removeClass('d-block');
		$('#edit-case-step-2-tab').addClass('d-block');
	}
}

function edit_case_back_to_step_1_btn() {
	$('#edit-case-step-1').removeClass('success').addClass('active');
	$('#edit-case-step-2').removeClass('active');
	$('#edit-case-step-2-tab').addClass('d-none').removeClass('d-block');
	$('#edit-case-step-1-tab').removeClass('d-none').addClass('d-block');
}

$('#edit-package-v2').on('change',function(){
	valid_edit_package_v2();
});

$('#edit-document-uploader-v2').on('change',function(){
	valid_edit_document_uploader_v2();
});

function valid_edit_package_v2(request_from = '') {
	var variable_array = {};
	variable_array['input_id'] = '#edit-package-v2';
	variable_array['error_msg_div_id'] = '#edit-package-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select a package.';
	var valid_package_v2_var = mandatory_select(variable_array);

	if (valid_package_v2_var == 1 && request_from == '') {
		get_edit_checked_skills_list_v2($('#edit-package-v2').val(),$('#modal-edit-candidate-id').val());
	}

	return valid_package_v2_var;
}

function get_edit_checked_skills_list_v2(id = '',candidate_id = '') {
	// var candidate_id = $("#candidate_id-v2").val();
	if (id != '') {
		$.ajax({
	    	type:'POST',
	    	url: base_url+"cases/get_case_skills/"+id,
	    	data:{candidate_id:candidate_id},
	    	dataType: "json",
		    async:false,
		    success: function(data) {
	    		var package_components = JSON.parse(data.client.package_components),
	    			all_components = data.components,
	      			edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      		var component_ids =  [];
	      		var form_value = [];
	      		if (data.candidate.length > 0) {
	      			component_ids = data.candidate[0].component_ids.split(',');
	      			form_value = JSON.parse(JSON.parse(data.candidate[0].form_values));
	      		}
	      		$('#edit_package_id').val(id);
	      		let comp = '';
	      		 
	      		for (var i = 0; i < package_components.length; i++) {
	      			if (package_components[i]['package_id'] == id) {
						var component =  package_components[i].component_name,
			    			component_name = component.replaceAll(/\s+/g, '_').trim().toLowerCase(),
			    			show_component_name = ''; 
			    		for (var j = 0; j < all_components.length; j++) {
			    			if (package_components[i].component_id == all_components[j].component_id) {
			    				show_component_name = all_components[j].fs_crm_component_name;
			    				break;
			    			}
			    		}
			    		var check = '';
			    		var disabled = '';
			    		var form_values = [];
			    		if ($.inArray(package_components[i].component_id,component_ids) !== -1) { 
							check = 'checked'; 
							disabled = 'disabled'; 
							form_values = form_value[component_name];
						}

	      				comp += '<div class="col-md-12 mt-3">';
			      		comp += '<div class="custom-control custom-checkbox custom-control-inline">';
				    	comp += '<input '+check+'  '+disabled+' type="checkbox" data-component_name="'+component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
					    comp += 'class="custom-control-input components edit-components" value="'+package_components[i].component_id+'" ';
					    comp += 'name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
				    	comp += '<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+show_component_name;
						comp += '</label>';
			    		comp += ' </div>';
			    		if (package_components[i]['component_id'] == '3' || package_components[i]['component_id'] == '27') {
			    			var doc_array = [];
			    			for (var k = 0; k < package_components[i].form_data.length; k++) {
			    				doc_array.push(package_components[i].form_data[k].form_id);
			    			}
					
			    			comp += '<div>';
							comp += '<select multiple   data-component_name="'+component_name+'" class="form-control fld fld-2 numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

							for(var k = 0;k < data.package_data[1]['documetn_type'].length;k++) {
								if ($.inArray(data.package_data[1]['documetn_type'][k].document_type_id,doc_array) !==-1) { 
									var select = '';
								if ($.inArray(data.package_data[1]['documetn_type'][k].document_type_id,form_values) !==-1) { 
									select = 'selected'; 
								}
								  	comp += '<option '+select+' value="'+data.package_data[1]['documetn_type'][k].document_type_id+'">'+data.package_data[1]['documetn_type'][k].document_type_name+'</option>';
								}
							}	
							comp += '</select>';
							comp += '<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>';
				    		comp += '</div>';
						} else if(package_components[i]['component_id'] == '4') {
							var doc_array = [];
			    			for (var k = 0; k < package_components[i].form_data.length; k++) {
			    				doc_array.push(package_components[i].form_data[k].form_id);
			    			}

							comp += '<div>';
							comp += '<select multiple   data-component_name="'+component_name+'" class="form-control fld fld-2  numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

							for(var k = 0;k < data.package_data[1]['drug_test_type'].length;k++) {
								if ($.inArray(data.package_data[1]['drug_test_type'][k].drug_test_type_id,doc_array) !== -1) { 
									var select =''; 
									if ($.inArray(data.package_data[1]['drug_test_type'][k].drug_test_type_id,form_values) !==-1) { 
										select = 'selected';
									}
								    comp +='<option '+select+' value="'+data.package_data[1]['drug_test_type'][k].drug_test_type_id+'">'+data.package_data[1]['drug_test_type'][k].drug_test_type_name+'</option>';
								}
							}

							comp += '</select>';
						 	comp += '<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>';
				    		comp += '</div>';	
						} else if(package_components[i]['component_id'] == '7') {
							var doc_array = [];
				    		for (var k = 0; k < package_components[i].form_data.length; k++) {
				    			doc_array.push(package_components[i].form_data[k].form_id);
				    		}
							comp += '<div>';
							comp += '<select multiple data-component_name="'+component_name+'" class="form-control fld fld-2 numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

							for(var k = 0;k < data.package_data[1]['education_type'].length;k++){
								if ($.inArray(data.package_data[1]['education_type'][k].education_type_id,doc_array) !== -1) { 
									var select ='';
									if ($.inArray(data.package_data[1]['education_type'][k].education_type_id,form_values) !==-1) { 
										select = 'selected';
									}
									comp +='<option '+select+' value="'+data.package_data[1]['education_type'][k].education_type_id+'">'+data.package_data[1]['education_type'][k].education_type_name+'</option>';
								}
							}	
							comp += '</select>';
							comp += '<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>';
					    	comp += '</div>';
						} else if (!jQuery.inArray(package_components[i]['component_id'], ['3','4','7','27']) !== -1) {
							var showOptiontValue = package_components[i].fs_crm_component_name,
				    			forLoopLength = package_components[i].form_data.length;
							
				    		comp += '<div>';
							comp += '<select data-component_name="'+component_name+'" class="form-control fld fld-2 numberOfFomrs"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'onChange="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';
							if (forLoopLength > 0) {
								for(var k = 1;k <= forLoopLength;k++) {
									var select ='';
									if ($.inArray(k,form_values) !==-1) { 
										select = 'selected';
									}
									comp += '<option '+select+' value="'+k+'">'+show_component_name+' '+k+'</option>';
								}	
								// comp += '<option value="more">Add More '+show_component_name+'</option>';
							} else {
								comp += '<option value="'+1+'">'+show_component_name+' '+1+'</option>';
							}
							comp += '</select>';
							comp += '<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>';
					    	comp += '</div>';
						}
	      				comp +=' </div>';
	      			}
	      		}
	    		$('#edit-case-skills-list-v2').html(comp); 
	    	}
	  	});
	}
}

function valid_edit_document_uploader_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#edit-document-uploader-v2';
	variable_array['error_msg_div_id'] = '#edit-document-uploader-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select an uploader.';
	return mandatory_select(variable_array);
}

$('#edit-case-step-2-next-btn').on('click', function() {
	edit_case_step_2_next_btn();
});

$('#edit-case-back-to-step-2-btn').on('click', function() {
	edit_case_back_to_step_2_btn();	
});

function edit_case_back_to_step_2_btn() {
	$('#edit-case-step-2').removeClass('success').addClass('active');
	$('#edit-case-step-3').removeClass('active');
	$('#edit-case-step-3-tab').addClass('d-none').removeClass('d-block');
	$('#edit-case-step-2-tab').removeClass('d-none').addClass('d-block');
}

function edit_case_step_2_next_btn() {
	var valid_package_v2_var = valid_edit_package_v2('validation'),
		valid_document_uploader_v2_var = valid_edit_document_uploader_v2();

	if (valid_package_v2_var == 1 && valid_document_uploader_v2_var == 1) {
		$('#edit-case-step-2').removeClass('active').addClass('success');
		$('#edit-case-step-3').addClass('active');
		$('#edit-case-step-2-tab').removeClass('d-block').addClass('d-none');
		$('#edit-case-step-3-tab').addClass('d-block');
	}
}

$("#edit-CheckAll").click(function () {
  	$(".custom-control-input.edit-components").prop('checked', $(this).prop('checked'));
});

$('#edit-case-btn-v2').on('click', function() {
	edit_case();
});

function edit_case() {
	var candidate_id = $("#modal-edit-candidate-id").val();
	var title = $('#edit-title-v2').val();
	var first_name = $('#edit-first-name-v2').val();
	var last_name = $('#edit-last-name-v2').val();
	var father_name = $('#edit-father-name-v2').val();
	var birthdate = $('#edit-birth-date-v2').val();
	var email = $("#edit-email-id-v2").val();
	var country_code = $('#edit-country-code').val();
	var user_contact = $('#edit-contact-no-v2').val();
	var joining_date = $('#edit-joining-date-v2').val();
	var employee_id = $('#edit-employee-id-v2').val();
	var package = $('#edit-package-v2').val();
	var document_uploader = $('#edit-document-uploader-v2').val();
	var remark = $('#edit-remark-v2').val();
	var client_email = $('#client-email').val();
	var segment = $('#edit-segment').val();
	var cost_center = $('#edit-cost-center').val();

	var component_id = GetSelected();
	var skills = [];
	var package_component = [];
	$(".edit-components:checked").each(function(){
		// if ($(this).val() !='') {
		skills.push($(this).val());
		// alert($(this).data("component_name"))
		var component_name = $(this).data("component_name");
		 	component_name = component_name.replaceAll(' ','_')
		getValusFromSelect($(this).val(),component_name); 

		var form_value = $("#numberOfFomrs"+$(this).val()).val(); 
		package_component.push({component_id:$(this).val(),form_values:form_value});
		// }
	});
	if (package_component.length == 0) {
		$("#edit-case-step-error-msg-div").html('<span class="d-block text-center text-warning error-msg-small">Please select atleast one component</span>');
		return false;
	}
 	var alacarte_component = [];
	$(".alacarte_component_names:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		// component_id.push($(this).val());
		skills.push($(this).val());
		var component_name =$(this).data("component_name");
			component_name = component_name.replaceAll(' ','_')
			// getValusFromSelect($(this).val(),component_name);
		var obj = [];
		$("#number_OfFomrs"+id+" option:selected").each(function(){
			if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
				obj.push($(this).val()) 
				// $('#numberOfFomrs-error'+id).html('')
			  }
		}); 
		selected[component_name.toLowerCase()] = obj
	});

 	var form_values =  JSON.stringify(selected);
	
	var not_allowed = ['5','6','8','9'];
	var flag = 0;
	for (var i = 0; i < skills.length; i++) {
		if(jQuery.inArray(skills[i], not_allowed) === -1) { 
    		var comp_val = $("#numberOfFomrs"+skills[i]).val();
    		if (comp_val == 0 || comp_val == '') {
    			$('#numberOfFomrs-error'+skills[i]).html("<span class='text-danger error-msg-small'>Please select at least one.</span>");
    			flag = 1;
    		}
		}
	}

	if (flag == 1) { return false; }

	if (first_name !='' && package !='' && document_uploader !='' &&
		last_name !='' && birthdate !='' /*&& joining_date !='' && employee_id !='' &&
		remark !=''*/ && email !='' && regex.test(email) && user_contact !='' && user_contact.length ==10 && skills.length > 0
		) 
	{  
		// $("#edit-case-step-error-msg-div").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		$("#edit-case-step-error-msg-div").html('<span class="d-block text-center text-warning error-msg-small">Please wait while we are updating the candidate details</span>');

		var formdata = new FormData();

		formdata.append('candidate_id',candidate_id);
		formdata.append('title',title);
		formdata.append('first_name',first_name);
		formdata.append('package',package);
		formdata.append('document_uploader',document_uploader);
		formdata.append('last_name',last_name);
		formdata.append('birthdate',birthdate);
		formdata.append('joining_date',joining_date);
		formdata.append('employee_id',employee_id);
		formdata.append('remark',remark);
		formdata.append('email',email);
		formdata.append('country_code',country_code); 
		formdata.append('user_contact',user_contact); 
		formdata.append('skills',skills); 
		formdata.append('father_name',father_name); 
		formdata.append('form_values',form_values); 
		formdata.append('client_email',client_email); 
		formdata.append('segment',segment);
		formdata.append('cost_center',cost_center); 
		formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
		formdata.append('package_component', JSON.stringify(package_component)); 
		formdata.append('init', $("#case-init").val()); 
		$.ajax({
	        type: "POST",
	        url: base_url+"cases/update_case/",
	        data:formdata,
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        success: function(data) {
	            if (data.status == '1') {
					$('#modal-edit-case-v2').modal('hide');
					toastr.success('Candidate details has been updated successfully.'); 
					// window.location.href = base_url+'factsuite-client/all-cases';
					$('.is-valid').removeClass('is-valid');
					$('.is-invalid').removeClass('is-invalid');
					$("#edit-CheckAll").prop('checked', false);
	            } else {
	              	toastr.error('Something went wrong while updating the candidate details. Please try again.'); 	
	            }
	            $("#edit-case-step-error-msg-div").html('');
	        }
	    });
	}
}