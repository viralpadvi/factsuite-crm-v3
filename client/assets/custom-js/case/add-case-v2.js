var candidate_first_name_max_length = 50,
	candidate_last_name_max_length = 50,
	candidate_father_name_max_length = 100,
	initiate_mobile_number_length = 10,
	candidate_employee_id_max_length = 20;

get_country_code();
function get_country_code() {
	$.ajax({
  		type: "POST",
  		url: base_url+"factsuite-client/get-country-code-list", 
		dataType: 'json',
		contentType: false,
	    processData: false,
		success: function(data) {
			data = JSON.parse(data);
			$('#country-code').html('<option value="+91">+91 (India)</option>');
			for (var i = 0; i < data.length; i++) {
				if (data[i].dial_code != '+91') {
					$('#country-code').append('<option value="'+data[i].dial_code+'">'+data[i].dial_code+' ('+data[i].name+')</option>');
				}
			}
  		}
	});
}

$('#first-name-v2').on('keyup blur', function() {
	check_first_name_v2();	
});

$('#last-name-v2').on('keyup blur', function() {
	check_last_name_v2();	
});

$('#father-name-v2').on('keyup blur', function() {
	check_father_name_v2();	
});

$('#email-id-v2').on('keyup blur', function() {
	check_email_id_v2();	
	 valid_email_check($(this).val());
});

$('#contact-no-v2').on('keyup blur', function() {
	check_contact_no_v2();	
	if ($(this).val().length == 10) {
		valid_contact_check($(this).val());
	}
});

$('#add-new-case-step-1-next-btn').on('click', function() {
	check_add_new_case_step_1_fields();
});

$('#add-new-case-back-to-step-1-btn').on('click', function() {
	add_new_case_back_to_step_1_btn();
});


function valid_email_check(email){
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_mail/",
	          data:{email:email},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		$("#add-new-case-step-1-next-btn").attr('disabled',false);
	          		input_is_valid('#email-id-v2');
			        $('#email-id-error-v2').html("&nbsp;");
			    }else{
			    	$("#msg-for-the-warning").html('A case already exists with the entered Email ID you have entered.Do you want to create a duplicate?');
			    	$("#add-new-case-v2-confirm").modal('show');
			    	$("#add-new-case-step-1-next-btn").attr('disabled',true);
			    	input_is_invalid('#email-id-v2'); 
					$('#email-id-error-v2').html('<span class="text-danger error-msg">This email id already exists</span>');
			    }

	          }
     	 });
}

$("#edit-case-btn-v2-confirm").on('click',function(){
	$("#add-new-case-step-1-next-btn").attr('disabled',false);
});

function check_first_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#first-name-v2';
	variable_array['error_msg_div_id'] = '#first-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate first name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_first_name_max_length+' characters';
	variable_array['max_length'] = candidate_first_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_last_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#last-name-v2';
	variable_array['error_msg_div_id'] = '#last-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate last name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_last_name_max_length+' characters';
	variable_array['max_length'] = candidate_last_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_father_name_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#father-name-v2';
	variable_array['error_msg_div_id'] = '#father-name-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter candidate father name';
	variable_array['not_an_alphabet_input_error_msg'] = 'Name should be only alphabets';
	variable_array['exceeding_max_length_input_error_msg'] = 'Name should be of max '+candidate_father_name_max_length+' characters';
	variable_array['max_length'] = candidate_father_name_max_length;
	return mandatory_only_alphabets_with_max_length_limitation(variable_array);
}

function check_email_id_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#email-id-v2';
	variable_array['error_msg_div_id'] = '#email-id-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter your email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function check_contact_no_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#contact-no-v2';
	variable_array['error_msg_div_id'] = '#contact-no-error-v2';
	variable_array['empty_input_error_msg'] = 'Please enter your phone number';
	variable_array['not_a_number_input_error_msg'] = 'Mobile number should be only numbers.'
	variable_array['exceeding_max_length_input_error_msg'] = 'Mobile number should be of '+initiate_mobile_number_length+' digits';
	variable_array['max_length'] = initiate_mobile_number_length;
	return mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array);
}


function valid_contact_check(contact){
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_phone_number/",
	          data:{contact:contact},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		input_is_valid("#contact-no-v2");
			        $("#contact-no-error-v2").html("&nbsp;");
			        $("#add-new-case-step-1-next-btn").attr('disabled',false);
			    }else{
			    	$("#msg-for-the-warning").html('A case already exists with the entered mobile number you have entered.Do you want to create a duplicate?');
			    	$("#add-new-case-v2-confirm").modal('show');
			    	$("#add-new-case-step-1-next-btn").attr('disabled',true);
			    	input_is_invalid("#contact-no-v2");
					$("#contact-no-error-v2").html('<span class="text-danger error-msg-small">This contact is already available</span>');
			    }

	          }
     	 });
}

function check_candidate_birth_date() {
	var variable_array = {};
	variable_array['input_id'] = '#birth-date-v2';
	variable_array['error_msg_div_id'] = '#birth-date-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select the candidate DOB.';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function check_add_new_case_step_1_fields() {
	var check_first_name_v2_var = check_first_name_v2(),
		check_last_name_v2_var = check_last_name_v2(),
		check_father_name_v2_var = check_father_name_v2(),
		check_email_id_v2_var = check_email_id_v2(),
		check_contact_no_v2_var = check_contact_no_v2(),
		check_candidate_birth_date_var = check_candidate_birth_date();
	if (check_first_name_v2_var == 1 && check_last_name_v2_var == 1 &&check_father_name_v2_var == 1 &&
		check_email_id_v2_var == 1 && check_contact_no_v2_var == 1 && check_candidate_birth_date_var == 1) {
		$('#add-new-case-step-1').removeClass('active').addClass('success');
		$('#add-new-case-step-2').addClass('active');
		$('#add-new-case-step-1-tab').addClass('d-none').removeClass('d-block');
		$('#add-new-case-step-2-tab').addClass('d-block');
	}
}

function add_new_case_back_to_step_1_btn() {
	$('#add-new-case-step-1').removeClass('success').addClass('active');
	$('#add-new-case-step-2').removeClass('active');
	$('#add-new-case-step-2-tab').addClass('d-none').removeClass('d-block');
	$('#add-new-case-step-1-tab').removeClass('d-none').addClass('d-block');
}

$('#package-v2').on('change',function(){
	valid_package_v2();
});

$('#document-uploader-v2').on('change',function(){
	valid_document_uploader_v2();
});

function valid_package_v2(request_from = '') {
	var variable_array = {};
	variable_array['input_id'] = '#package-v2';
	variable_array['error_msg_div_id'] = '#package-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select a package.';
	var valid_package_v2_var = mandatory_select(variable_array);

	if (valid_package_v2_var == 1 && request_from == '') {
		get_checked_skills_list_v2($('#package-v2').val());
	}

	return valid_package_v2_var;
}

function get_checked_skills_list_v2(id = '', request_from = '') {
	if (id != '') {
		$.ajax({
	    	type:'ajax',
	    	url: base_url+"cases/get_case_skills/"+id,
	    	dataType: "json",
		    async:false,
		    success: function(data) {
	    		var package_components = JSON.parse(data.client.package_components),
	    			all_components = data.components,
	      			edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 

	      		$('#edit_package_id').val(id);
	      		let comp = '';
	      		for (var i = 0; i < package_components.length; i++) {
	      			if (package_components[i]['package_id'] == id) {
						var component =  package_components[i].component_name,
			    			component_name = component.replaceAll(/\s+/g, '_').trim(),
			    			show_component_name = ''; 
			    		for (var j = 0; j < all_components.length; j++) {
			    			if (package_components[i].component_id == all_components[j].component_id) {
			    				show_component_name = all_components[j].fs_crm_component_name;
			    				break;
			    			}
			    		}
	      				comp += '<div class="col-md-12 mt-3">';
			      		comp += '<div class=" custom-control custom-checkbox custom-control-inline">';
				    	comp += '<input  checked type="checkbox"  data-component_name="'+component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
					    comp += 'class="custom-control-input components" value="'+package_components[i].component_id+'" ';
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
							comp += '<select  multiple data-component_name="'+component_name+'" class="form-control fld fld-2 numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';
							for(var k = 0;k < data.package_data[1]['documetn_type'].length;k++) {
								if ($.inArray(data.package_data[1]['documetn_type'][k].document_type_id,doc_array) !==-1) { 
								  	comp += '<option value="'+data.package_data[1]['documetn_type'][k].document_type_id+'">'+data.package_data[1]['documetn_type'][k].document_type_name+'</option>';
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
							comp += '<select  multiple  data-component_name="'+component_name+'" class="form-control fld fld-2  numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

						for(var k = 0;k < data.package_data[1]['drug_test_type'].length;k++) {
							if ($.inArray(data.package_data[1]['drug_test_type'][k].drug_test_type_id,doc_array) !== -1) { 
							    comp +='<option value="'+data.package_data[1]['drug_test_type'][k].drug_test_type_id+'">'+data.package_data[1]['drug_test_type'][k].drug_test_type_name+'</option>';
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
						comp += '<select  multiple  data-component_name="'+component_name+'" class="form-control fld fld-2 numberOfFomrs"';
						comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
						comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
						comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

						for(var k = 0;k < data.package_data[1]['education_type'].length;k++){
							if ($.inArray(data.package_data[1]['education_type'][k].education_type_id,doc_array) !== -1) { 
								comp +='<option value="'+data.package_data[1]['education_type'][k].education_type_id+'">'+data.package_data[1]['education_type'][k].education_type_name+'</option>';
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
								comp += '<option value="'+k+'">'+show_component_name+' '+k+'</option>';
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

	    	if(request_from == 'edit') {
	    		 
	    		$('#edit-case-skills-list-v2').html(comp);
	    	} else {
	    		$('#case-skills-list-v2').html(comp);
	    	}
	    }
	  });
	}
}

function valid_document_uploader_v2() {
	var variable_array = {};
	variable_array['input_id'] = '#document-uploader-v2';
	variable_array['error_msg_div_id'] = '#document-uploader-error-v2';
	variable_array['empty_input_error_msg'] = 'Please select an uploader.';
	return mandatory_select(variable_array);
}

$('#add-new-case-step-2-next-btn').on('click', function() {
	check_add_new_case_step_2_fields();
});

$('#add-new-case-back-to-step-2-btn').on('click', function() {
	add_new_case_back_to_step_2_btn();	
});

function add_new_case_back_to_step_2_btn() {
	$('#add-new-case-step-2').removeClass('success').addClass('active');
	$('#add-new-case-step-3').removeClass('active');
	$('#add-new-case-step-3-tab').addClass('d-none').removeClass('d-block');
	$('#add-new-case-step-2-tab').removeClass('d-none').addClass('d-block');
}

function check_add_new_case_step_2_fields() {
	var valid_package_v2_var = valid_package_v2('validation'),
		valid_document_uploader_v2_var = valid_document_uploader_v2();

	if (valid_package_v2_var == 1 && valid_document_uploader_v2_var == 1) {
		$('#add-new-case-step-2').removeClass('active').addClass('success');
		$('#add-new-case-step-3').addClass('active');
		$('#add-new-case-step-2-tab').removeClass('d-block').addClass('d-none');
		$('#add-new-case-step-3-tab').addClass('d-block');
	}
}

$('#add-new-case-btn-v2').on('click', function() {
	var title = $('#title-v2').val();
	var first_name = $('#first-name-v2').val();
	var father_name = $('#father-name-v2').val();
	var package = $('#package-v2').val();
	var document_uploader = $('#document-uploader-v2').val();
	var last_name = $('#last-name-v2').val();
	var birthdate = $('#birth-date-v2').val();
	var joining_date = $('#joining-date-v2').val();
	var employee_id = $('#employee-id-v2').val();
	var remark = $('#remark-v2').val();
	var email = $("#email-id-v2").val();
	var country_code = $('#country-code').val();
	var user_contact = $('#contact-no-v2').val();
	var client_email = $('#client-email-v2').val();
	var segment = $('#segment').val();
	var cost_center = $('#cost-center').val();

	var component_id = GetSelected();
	var skills = [];
	var package_component = [];
	$(".components:checked").each(function() {
		var id = $(this).val();
		if ($(this).val() !='') {
			skills.push($(this).val());
			var form_value = $("#numberOfFomrs"+$(this).val()).val(),
				component_name = $(this).data('component_name'),
		 		component_name = component_name.replaceAll(' ','_'),
				obj = [];
			package_component.push({component_id:$(this).val(),form_values:form_value});
			$("#numberOfFomrs"+id+" option:selected").each(function() {
				if ($(this).val() != '' && $(this).val() != null && $(this).val() != '0') { 
					obj.push($(this).val());
					$('#numberOfFomrs-error'+id).html('');
	  			}
			}); 
			selected[component_name.toLowerCase()] = obj;
		}
	});

	if (package_component.length == 0) {
		$("#add-new-case-step-error-msg-div").html('<span class="d-block text-center text-warning error-msg-small">Please select atleast one component</span>');
		return false;
	}

	var alacarte_component = [];
	$(".number_OfFomrs:checked").each(function() {
		var id = $(this).val(),
			form_value = $("#number_OfFomrs"+$(this).val()).val();
			skills.push($(this).val());
			component_name = $(this).data('component_name');
		 	component_name = component_name.replaceAll(' ','_');
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		var obj = []; 
		$("#number_OfFomrs"+id+" option:selected").each(function(){
			if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
				obj.push($(this).val());
  			}
		});
		selected[component_name.toLowerCase()] = obj;
	});

 	var form_values = JSON.stringify(selected),
		not_allowed = ['5','6','8','9'],
		flag = 0;
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
 
	$('#CheckAll').prop('checked', false);

	if (first_name != '' && package != '' && document_uploader != '' && last_name != '' && birthdate != '' &&
		email != '' && regex.test(email) && user_contact !='' && user_contact.length == 10 && skills.length > 0) {  

		$("#add-new-case-btn-v2").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		
		$("#add-new-case-step-error-msg-div").html('<span class="text-warning error-msg-small">Please wait while we are saving the details.</span>');
		var formdata = new FormData();

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
		$.ajax({
            type: "POST",
            url: base_url+"cases/insert_case/",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
              	$('#add-new-case-step-error-msg-div').html('');
              	if (data.status == '1') {
              		$('#add-new-case-v2').modal('hide');
					toastr.success('New case has been added successfully.');
					$('#add-new-case-step-1, #add-new-case-step-2, #add-new-case-step-3').removeClass('active success');
					$('#add-new-case-step-1').addClass('active');

					$('#add-new-case-step-2-tab, #add-new-case-step-3-tab').addClass('d-none').removeClass('d-block');
					$('#add-new-case-step-1-tab').removeClass('d-none').addClass('d-block');

					$('#first-name-v2').val('');
					$('#package-v2').val('');
					$("#father-name-v2").val('');
					$('#document-uploader-v2').val('');
					$('#last-name-v2').val('');
					$('#birth-date-v2').val('');
					$('#joining-date-v2').val('');
					$('#employee-id-v2').val('');
					$('#remark-v2').val('');
					$("#email-id-v2").val('');
					$('#country-code').val('+91'); 
					$('#contact-no-v2').val('');
					$(".skills:checked").each(function() {
						this.checked = false;
					});

					$(".alacarte_component_names").prop('checked',false);

					$('.is-valid').removeClass('is-valid');
					$('.is-invalid').removeClass('is-invalid');
					$("#case-skills-list").html("");
					$('#client-email-div').show();
					$("#client-email").val('');
					if (document_uploader == 'client') {
						// window.open(candidate_url_for_redirecting_to_candidate_module);
						window.location.href = candidate_url_for_redirecting_to_candidate_module;
					}
					// view_all_cases();
					get_required_list();
              	} else if(data.status == '2') {
					// let html = "<span class='text-danger'>"+data.msg+"</span>";
					// $('#error-team').html(html);
					toastr.error(data.msg+"Conect to admin");
				} else {
              		toastr.error('Something went wrong while adding a new case. Please try again.'); 	
              	}
              	$("#add-new-case-btn-v2").html('Submit');
            }
    	});
	}
});


function get_download(){
	var all_checks_id =[];

	$('.all_checks_id:checked').each(function(){
		all_checks_id.push($(this).val());
	})

	if (all_checks_id.length > 0) {
		$.ajax({
            type: "POST",
            url: base_url+"cases/get_report_bulk/",
            data:{candidate_id:all_checks_id},
            dataType: 'json', 
            success: function(data) {  
            var link=document.createElement('a');
			document.body.appendChild(link);
			link.href=data.url;
			link.click();	
			document.body.removeChild(link);	
			 toastr.success('Bulk report downloaded.');
            }
        });
	}else{
			 toastr.error('Please select Min 1 checkbox.');
	}
}