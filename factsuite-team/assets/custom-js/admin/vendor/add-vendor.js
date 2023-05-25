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
	vendor_skill_tat_length = 3;

	// url_regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,

get_state_list();
function get_state_list() {
	 sessionStorage.clear(); 
  	$.ajax({
    	type:'POST',
    	url: 'assets/custom-js/json/states.json',
    	dataType: 'JSON',
    	success:function(data) {
      		var html = '';
      		if(data.length > 0) {  
        		html += '<option value="">Select State</option>';
        		for(var i = 0;i < data.length; i++) {
          			html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
        		}
      		} else {
        		html += '<option value="">No State Available</option>';
      		}
      		$('#vendor-state').html(html);
    	}
  	});
}

get_vendor_manager_list();
function get_vendor_manager_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"admin_Vendor/get_vendor_manager_list",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '';
      		if(data.length > 0) {  
        		html += '<option value="">Select Manager</option>';
        		for(var i = 0;i < data.length; i++) {
          			html += '<option value="'+data[i].team_id+'">'+data[i].first_name+' '+data[i].last_name+'</option>';
        		}
      		} else {
        		html += '<option value="">No Manager Available</option>';
      		}
      		$('#vendor-manager-name').html(html);
    	}
  	});
}

get_skills_list();
function get_skills_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"admin_Vendor/get_vendor_skills",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '';
      		if(data.length > 0) {
        		for(var i = 0;i < data.length; i++) {
        			// 
        			html += '<li class="vendor-skill-li">';
                  	html += '<div class="custom-control custom-checkbox custom-control-inline">';
                    html += '<input type="checkbox" onclick="select_skill_tat('+data[i].component_id+')" class="custom-control-input vendor-skills" name="vendor-skills-'+data[i].component_id+'" id="vendor-skills-'+data[i].component_id+'" value="'+data[i].component_id+'"> <label class="custom-control-label" for="vendor-skills-'+data[i].component_id+'">'+data[i].component_name+'</label>';
                  	html += '</div>';
                  	html += '<input type="text" disabled class="fld3 form-control tat" placeholder="Enter a '+data[i].component_name+' TAT"id="vendor-tat'+data[i].component_id+'" name="vendor-tat">';
                	html += '<div class="vendor-tat-error-msg-div" id="vendor-tat-error-msg-div'+data[i].component_id+'">&nbsp;</div>';
                	html += '</li>';
        		}
      		} else {
        		html += '<li value="">No Component Available</option>';
      		}
      		$('#vendor-skills-list').html(html);
    	}
  	});
}

function getTatValue(){
 	var tatValue = [];
	$(".tat").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
			tatValue.push($(this).val())
  		}
	});  
	return tatValue;
}

function select_skill_tat(id) {
    if($("input[name=vendor-skills-"+id+"]").prop('checked') == true) {
    	$('#vendor-tat'+id).attr( "disabled", false )   
    	$('#vendor-tat'+id).attr("onkeyup","check_vendor_skill_tat("+id+")"); 
    	$('#vendor-tat'+id).attr("blur","check_vendor_skill_tat("+id+")");
	} else {
		$('#vendor-tat'+id).attr( "disabled", true )  
		$('#vendor-tat'+id).val('');
		$('#vendor-tat-error-msg-div'+id).html('&nbsp;');
		$('#vendor-tat'+id).removeAttr("onkeyup");
		$('#vendor-tat'+id).removeAttr("blur");
		$('#vendor-tat'+id).removeClass("is-valid is-invalid");
	}
}

$("#vendor-name").on('keyup blur', function() {
	check_vendor_name();
});

$("#vendor-address-line-1").on('keyup blur', function() {
	check_address_line_1();
});

$("#vendor-city").on('keyup blur', function() {
	check_vendor_city();
});

$("#vendor-zip-code").on('keyup blur', function() {
	check_vendor_zip_code();
});

$("#vendor-state").on('change', function() {
	check_vendor_state();
});

$("#vendor-website").on('keyup blur', function() {
	check_vendor_website();
});

$("#vendor-monthly-quota").on('keyup blur', function() {
	check_vendor_monthly_quota();
});

$("#vendor-aggrement-start-date").on('change', function() {
	check_vendor_aggrement_start_date();
});

$("#vendor-aggrement-end-date").on('change', function() {
	check_vendor_aggrement_end_date();
});

$("#vendor-documents").on("change", handleFileSelect_vendor_documents);

// $("#vendor-tat").on('keyup blur', function() {
// 	check_vendor_skill_tat();
// });

$("#vendor-manager-name").on('change', function() {
	check_vendor_manager_name();
});

$("#vendor-manager-email-id").on('keyup blur', function() {
	check_vendor_manager_email_id();
});

$("#vendor-manager-mobile-number").on('keyup blur', function() {
	check_vendor_manager_mobile_number();
});

$("#vendor-spoc-name").on('keyup blur', function() {
	check_vendor_spoc_name();
});

$("#vendor-spoc-email-id").on('keyup blur', function() {
	check_vendor_spoc_email_id();
});

$("#vendor-spoc-mobile-number").on('keyup blur', function() {
	check_vendor_spoc_mobile_number();
});

function check_vendor_name() {
	var vendor_name = $('#vendor-name').val();
	if (vendor_name != '') {
		if (!alphabets_only.test(vendor_name)) {
			$('#vendor-name-error-msg-div').html('<span class="text-danger error-msg-small">Vendor name should be only alphabets.</span>');
			$('#vendor-name').val(vendor_name.slice(0,-1));
			input_is_invalid('#vendor-name');
		} else if (vendor_name.length > vendor_name_length) {
			$('#vendor-name-error-msg-div').html('<span class="text-danger error-msg-small">Vendor name should be of max '+vendor_name_length+' characters.</span>');
			$('#vendor-name').val(vendor_name.slice(0,vendor_name_length));
			input_is_invalid('#vendor-name');
		} else {
			$('#vendor-name-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-name');
		}
	} else {
		$('#vendor-name-error-msg-div').html('<span class="text-danger error-msg-small">Please add a Vendor Name.</span>');
		input_is_invalid('#vendor-name');
	}
}

function check_address_line_1() {
	var vendor_address_line_1 = $('#vendor-address-line-1').val();
	if (vendor_address_line_1 != '') {
		input_is_valid('#vendor-address-line-1');
		$('#vendor_address_line_1').html('&nbsp');
	} else {
		input_is_invalid('#vendor-address-line-1');
		$('#vendor_address_line_1').html('<span class="text-danger error-msg-small">Please enter the address line 1</span>');
	}
}

function check_vendor_city() {
	var vendor_city = $('#vendor-city').val();
	if (vendor_city != '') {
		if (!alphabets_only.test(vendor_city)) {
			$('#vendor-city-error-msg-div').html('<span class="text-danger error-msg-small">City name should be only alphabets.</span>');
			$('#vendor-city').val(vendor_city.slice(0,-1));
			input_is_invalid('#vendor-city');
		} else if (vendor_city.length > city_name_length) {
			$('#vendor-city-error-msg-div').html('<span class="text-danger error-msg-small">City name should be of max '+city_name_length+' characters.</span>');
			$('#vendor-city').val(vendor_city.slice(0,city_name_length));
			input_is_invalid('#vendor-city');
		} else {
			$('#vendor-city-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-city');
		}
	} else {
		input_is_invalid('#vendor-city');
		$('#vendor-city-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the city name.</span>');
	}
}

function check_vendor_zip_code() {
	var vendor_zip_code = $('#vendor-zip-code').val();
	if (vendor_zip_code != '') {
		if (isNaN(vendor_zip_code)) {
			$('#vendor-zip-code-error-msg-div').html('<span class="text-danger error-msg-small">Zip code should be only numbers.</span>');
			$('#vendor-zip-code').val(vendor_zip_code.slice(0,-1));
			input_is_invalid('#vendor-zip-code');
		} else if (vendor_zip_code.length != vendor_zip_code_length) {
			$('#vendor-zip-code-error-msg-div').html('<span class="text-danger error-msg-small">Zip code should be of '+vendor_zip_code_length+' digits.</span>');
			$('#vendor-zip-code').val(vendor_zip_code.slice(0,vendor_zip_code_length));
			input_is_invalid('#vendor-zip-code');
		} else {
			$('#vendor-zip-code-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-zip-code');
		}
	} else {
		input_is_invalid('#vendor-zip-code');
		$('#vendor-zip-code-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the zip code</sapn>');
	}
}

function check_vendor_state() {
	var vendor_state = $('#vendor-state').val();
	if (vendor_state != '') {
		$.ajax({
	    	type:'POST',
	    	url: 'assets/custom-js/json/states.json',
	    	dataType: 'JSON',
	    	success:function(data) {
	      		var html = '',
	      			count = 0;
	      		if(data.length > 0) {  
	        		html += '<option value="">Select State</option>';
	        		for(var i = 0;i < data.length; i++) {
	        			if (data[i].name.toLowerCase() == vendor_state.toLowerCase()) {
	        				count++;
	        			}
	          			html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
	        		}
	        		
	        		if (count == 1) {
	        			$('#vendor-state-error-msg-div').html('&nbsp;');
						input_is_valid('#vendor-state-error-msg-div');
          			} else {
          				input_is_invalid('#vendor-state-error-msg-div');
	        			$('#vendor-state-error-msg-div').html('<span class="text-danger error-msg-small">Please select the valid state</span>');
          				$('#vendor-state').html(html);		
          			}
	      		} else {
	        		html += '<option value="">No State Available</option>';
	      			$('#vendor-state').html(html);
	      		}
	    	}
	  	});
	} else {
		input_is_invalid('#vendor-state-error-msg-div');
		$('#vendor-state-error-msg-div').html('<span class="text-danger error-msg-small">Please select a state</span>');
	}
}

function check_vendor_website() {
	var vendor_website = $('#vendor-website').val();
	if (vendor_website != '') {
		if (!url_regex.test(vendor_website)) {
			$('#vendor-website-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the correct URL.</span>');
			input_is_invalid('#vendor-website');
		} else {
			$('#vendor-website-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-website');
		}
	} else {
		input_is_invalid('#vendor-website');
		$('#vendor-website-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the website URL.</span>');
	}
}

function check_vendor_monthly_quota() {
	var vendor_monthly_quota = $('#vendor-monthly-quota').val();
	if (vendor_monthly_quota != '') {
		if (isNaN(vendor_monthly_quota)) {
			$('#vendor-monthly-quota').val(vendor_monthly_quota.slice(0,-1));
			$('#vendor-monthly-quota-error-msg-div').html('<span class="text-danger error-msg-small">Monthly quota should be only numbers.</span>');
			input_is_invalid('#vendor-monthly-quota');
		} else if (vendor_monthly_quota.length > vendor_monthly_quota_length) {
			$('#vendor-monthly-quota').val(vendor_monthly_quota.slice(0,vendor_monthly_quota_length));
			$('#vendor-monthly-quota-error-msg-div').html('<span class="text-danger error-msg-small">Monthly quota cannot be more than '+vendor_monthly_quota_length+' digits.</span>');
			input_is_invalid('#vendor-monthly-quota');
		} else {
			$('#vendor-monthly-quota-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-monthly-quota');
		}
	} else {
		$('#vendor-monthly-quota-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the monthly quota.</span>');
		input_is_invalid('#vendor-monthly-quota');
	}
}

function check_vendor_aggrement_start_date() {
	var vendor_aggrement_start_date = $('#vendor-aggrement-start-date').val();
	if (vendor_aggrement_start_date != '') {
		$('#vendor-aggrement-end-date').val('');
		$('#vendor-aggrement-start-date-error-msg-div').html('');
		$('#vendor-aggrement-end-date').attr('disabled',false);
		input_is_valid('#vendor-aggrement-start-date');
	} else {
		$('#vendor-aggrement-end-date').attr('disabled',true);
		$('#vendor-aggrement-start-date-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the aggrement start date.</span>');
		input_is_invalid('#vendor-aggrement-start-date');
	}
}

function check_vendor_aggrement_end_date() {
	var vendor_aggrement_end_date = $('#vendor-aggrement-end-date').val();
	var vendor_aggrement_start_date = $('#vendor-aggrement-start-date').val();
	if (vendor_aggrement_end_date != '') {
		var date_difference = get_date_difference(vendor_aggrement_start_date,vendor_aggrement_end_date);
		if (date_difference < 0) {
			$('#vendor-aggrement-end-date').val('');
			$('#vendor-aggrement-end-date-error-msg-div').html('<span class="text-danger error-msg-small">Please select a date greater than or equal to Aggrement start date.</span>');	
			input_is_invalid('#vendor-aggrement-end-date');
		} else {
			$('#vendor-aggrement-end-date-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-aggrement-end-date');
		}
	} else {
		$('#vendor-aggrement-end-date-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the aggrement start date.</span>');
		input_is_invalid('#vendor-aggrement-end-date');
	}
}

function get_date_difference(vendor_aggrement_start_date,vendor_aggrement_end_date) {
	var check_vendor_aggrement_end_date = new Date(vendor_aggrement_end_date); 
	var check_vendor_aggrement_start_date = new Date(vendor_aggrement_start_date); 

    var difference_in_time = check_vendor_aggrement_end_date.getTime() - check_vendor_aggrement_start_date.getTime();
    return difference_in_days = difference_in_time / (1000 * 3600 * 24);
}

function handleFileSelect_vendor_documents(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var i = 1;
    if (files.length <= max_vendor_document_select) {
        $("#selected-vendor-docs-li").html('');
        if (files[0].size <= vendor_document_size) {
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name
	            var html = '<div class="col-md-12 mt-3" id="file_vendor_documents_'+i+'">'+
	                    '<div class="image-selected-div">'+
	                        '<ul>'+
	                            '<li class="image-selected-name p-0">'+fileName+'</li>'+
	                            '<li class="image-name-delete p-0">'+
	                                '<a id="file_vendor_documents'+i+'" onclick="removeFile_vendor_documents('+i+')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
	                            '</li>'+
	                        '</ul>'+
	                    '</div>'+
	                '</div>';
	                $("#selected-vendor-docs-li").append(html);
	                vendor_docs.push(files[i]);
	        }
	    } else {
	    	$("#vendor-upoad-docs-error-msg-div").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 1 Mb.</span></div>');
			$('#vendor-documents').val('');
	    }
    } else {
        $("#selected-vendor-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_vendor_document_select+' files</span>');
    }
}

function removeFile_vendor_documents(id) {
    var file = $('#file_vendor_documents'+id).data("file");
    for(var i = 0; i < vendor_docs.length; i++) {
        if(vendor_docs[i].name === file) {
            vendor_docs.splice(i,1); 
        }
    }
    $('#file_vendor_documents_'+id).remove();
    $("#vendor-documents").val('');
}

function check_vendor_manager_name() {
	var vendor_manager_name = $('#vendor-manager-name').val();
	$('#vendor-manager-email-id').val('');
	$('#vendor-manager-mobile-number').val('');

	if (vendor_manager_name != '') {
		$.ajax({
	    	type:'ajax',
	    	url: base_url+"admin_Vendor/get_vendor_manager_list",
	    	dataType: 'JSON',
	    	success: function(data) {
	      		var html = '', count = 0;
	      		if(data.length > 0) {  
	        		html += '<option value="">Select Manager</option>';
	        		for(var i = 0;i < data.length; i++) {
	        			if (vendor_manager_name == data[i].team_id) {
	        				count++;
	        			}
	          			html += '<option value="'+data[i].team_id+'">'+data[i].first_name+' '+data[i].last_name+'</option>';
	        		}
	        		
	        		if (count == 1) {
	        			$.ajax({
					    	type:'POST',
					    	url: base_url+"admin_Vendor/get_selected_vendor_manager_details",
					    	dataType: 'JSON',
					    	data : {
					    		team_id : vendor_manager_name
					    	},
					    	success: function(data) {
					      		$('#vendor-manager-email-id').val(data.email_id);
					      		$('#vendor-manager-mobile-number').val(data.mobile_number);
					    	}
					  	});
	        			$('#vendor-manager-name-error-msg-div').html('&nbsp;');
						input_is_valid('#vendor-manager-name');
	        		} else {
	        			$('#vendor-manager-name').html(html);
	        			$('#vendor-manager-name-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid manager name.</span>');
						input_is_invalid('#vendor-manager-name');
	        		}
	      		} else {
	        		html += '<option value="">No Manager Available</option>';
	      			$('#vendor-manager-name').html(html);
	      		}
	    	}
	  	});
	} else {
		$('#vendor-manager-name-error-msg-div').html('<span class="text-danger error-msg-small">Please select a manager name.</span>');
		input_is_invalid('#vendor-manager-name');
	}
}

function check_vendor_spoc_name() {
	var vendor_spoc_name = $('#vendor-spoc-name').val();
	if (vendor_spoc_name != '') {
		if (!alphabets_only.test(vendor_spoc_name)) {
			$('#vendor-spoc-name-error-msg-div').html('<span class="text-danger error-msg-small">SPOC name should be only alphabets.</span>');
			$('#vendor-spoc-name').val(vendor_spoc_name.slice(0,-1));
			input_is_invalid('#vendor-spoc-name');
		} else if (vendor_spoc_name.length > vendor_spoc_name_length) {
			$('#vendor-spoc-name-error-msg-div').html('<span class="text-danger error-msg-small">SPOC name should be of max '+vendor_spoc_name_length+' characters.</span>');
			$('#vendor-spoc-name').val(vendor_spoc_name.slice(0,vendor_spoc_name_length));
			input_is_invalid('#vendor-spoc-name');
		} else {
			$('#vendor-spoc-name-error-msg-div').html('&nbsp;');
			input_is_valid('#vendor-spoc-name');
		}
	} else {
		$('#vendor-spoc-name-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the SPOC name.</span>');
		input_is_invalid('#vendor-spoc-name');
	}
}

function check_vendor_spoc_email_id() {
	var vendor_spoc_email_id = $('#vendor-spoc-email-id').val();
	if (vendor_spoc_email_id != '') {
		if(!email_regex.test(vendor_spoc_email_id)) {
        	$('#vendor-spoc-email-id-error-msg-div').html('<span class="text-danger error-msg">Please enter a valid email id.</span>');
        	input_is_invalid('#vendor-spoc-email-id');
      	} else {
      		$.ajax({
				type: "POST",
			  	url: base_url+"admin_Vendor/check_new_vendor_spoc_email_id_exists",
			  	data: { vendor_spoc_email_id : vendor_spoc_email_id },
			  	dataType: "json",
			  	success: function(data) {
				  	if (data.count != '0') {
				  		$('#vendor-spoc-email-id-error-msg-div').html('<span class="text-danger error-msg-small">Entered email already exists. Please enter the new one.</span>');
				  		input_is_invalid('#vendor-spoc-email-id');
				  	} else {
				  		$('#vendor-spoc-email-id-error-msg-div').html('&nbsp;');
      					input_is_valid('#vendor-spoc-email-id');
			  		}
			  	}
			});
      	}
	} else {
		$('#vendor-spoc-email-id-error-msg-div').html('<span class="text-danger error-msg">Please enter a valid email id.</span>');
		input_is_invalid('#vendor-spoc-email-id');
	}
}

function check_vendor_spoc_mobile_number() {
	var vendor_spoc_mobile_number = $('#vendor-spoc-mobile-number').val();
	if (vendor_spoc_mobile_number != '') {
		if(isNaN(vendor_spoc_mobile_number)) {
        	$('#vendor-spoc-mobile-number-error-msg-div').html('<span class="text-danger error-msg-small">Mobile number should be only digits.</span>');
        	$('#vendor-spoc-mobile-number').val(vendor_spoc_mobile_number.slice(0,-1));
        	input_is_invalid('#vendor-spoc-mobile-number');
      	} else if (vendor_spoc_mobile_number.length != mobile_number_length) {
      		$('#vendor-spoc-mobile-number-error-msg-div').html('<span class="text-danger error-msg-small">Mobile number should be of '+mobile_number_length+' digits</span>');
        	$('#vendor-spoc-mobile-number').val(vendor_spoc_mobile_number.slice(0,mobile_number_length));
        	input_is_invalid('#vendor-spoc-mobile-number');
      	} else {
        	$('#vendor-spoc-mobile-number-error-msg-div').html('&nbsp;');
        	input_is_valid('#vendor-spoc-mobile-number');
      	}
	} else {
		$('#vendor-spoc-mobile-number-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the mobile number.</span>');
		input_is_invalid('#vendor-spoc-mobile-number');
	}
}

function check_vendor_skill_tat(id) {
	var vendor_skill_tat = $('#vendor-tat'+id).val();
	if (vendor_skill_tat != '') {
		if (isNaN(vendor_skill_tat)) {
			$('#vendor-tat'+id).val(vendor_skill_tat.slice(0,-1));
			$('#vendor-tat-error-msg-div'+id).html('<span class="text-danger error-msg-small">TAT should be only numbers.</span>');
			input_is_invalid('#vendor-tat'+id);
		} else if (vendor_skill_tat < 0) {
			$('#vendor-tat'+id).val('');
			$('#vendor-tat-error-msg-div'+id).html('<span class="text-danger error-msg-small">TAT should not be less then 0.</span>');
			input_is_invalid('#vendor-tat'+id);
		} else {	
			$('#vendor-tat-error-msg-div'+id).html('&nbsp;');
			input_is_valid('#vendor-tat'+id);
		}
	} else {
		$('#vendor-tat-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the tat</span>');
		input_is_invalid('#vendor-tat'+id);
	}
}

function cancel_add_new_vedor() {
	$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number, .tat').val('');
	$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number, .tat').removeClass('is-valid is-invalid');
	$('.vendor-skills:checkbox:checked').prop("checked", false);
	$('.tat').prop('disabled',true);
	$('#vendor-confirm-password-error-msg-div, .vendor-tat-error-msg-div').html('&nbsp;');
	$('#vendor-name-error-msg-div, #vendor-address-line-1-error-msg-div, #vendor-address-line-2-error-msg-div, #vendor-city-error-msg-div, #vendor-zip-code-error-msg-div, #vendor-state-error-msg-div, #vendor-website-error-msg-div, #vendor-monthly-quota-error-msg-div, #vendor-aggrement-start-date-error-msg-div, #vendor-aggrement-end-date-error-msg-div, #vendor-upoad-docs-error-msg-div, #selected-vendor-docs-li, #vendor-tat-error-msg-div, #vendor-manager-name-error-msg-div, #vendor-manager-email-id-error-msg-div, #vendor-manager-mobile-number-error-msg-div, #vendor-spoc-name-error-msg-div, #vendor-spoc-email-id-error-msg-div, #vendor-spoc-mobile-number-error-msg-div, #vendor-skill-error-msg-div').html('&nbsp;');
}

function add_new_vendor() {
	var vendor_name = $('#vendor-name').val();
	var vendor_address_line_1 = $('#vendor-address-line-1').val();
	var vendor_address_line_2 = $('#vendor-address-line-2').val();
	var vendor_city = $('#vendor-city').val();
	var vendor_zip_code = $('#vendor-zip-code').val();
	var vendor_state = $('#vendor-state').val();
	var vendor_website = $('#vendor-website').val();
	var vendor_monthly_quota = $('#vendor-monthly-quota').val();
	var vendor_aggrement_start_date = $('#vendor-aggrement-start-date').val();
	var vendor_aggrement_end_date = $('#vendor-aggrement-end-date').val();
	// var vendor_skill_tat = $('#vendor-tat').val()getTatValue();
	var vendor_skill_tat = getTatValue();
	var vendor_manager_name = $('#vendor-manager-name').val();
	var vendor_manager_email_id = $('#vendor-manager-email-id').val();
	var vendor_manager_mobile_number = $('#vendor-manager-mobile-number').val();
	var vendor_spoc_name = $('#vendor-spoc-name').val();
	var vendor_spoc_email_id = $('#vendor-spoc-email-id').val();
	var vendor_spoc_mobile_number = $('#vendor-spoc-mobile-number').val();
	var vendor_skills = [];
	$('.vendor-skills:checkbox:checked').each(function(i){
		vendor_skills[i] = $(this).val();
	});

	var date_difference = get_date_difference(vendor_aggrement_start_date,vendor_aggrement_end_date);

	var check_skill_empty_count = 0;
	if (vendor_skills.length > 0) {
		$('#vendor-skill-error-msg-div').html('&nbsp;');
		for (var i = 0; i < vendor_skills.length; i++) {
		    var skill_checked = '';
		    var skill_tat_value = '';

		    if (jQuery.inArray(vendor_skills[i], vendor_skill_tat)!='-1') {
		    	var get_checked_skill_tat_value = $('#vendor-tat'+vendor_skills[i]).val();
		    	check_vendor_skill_tat(vendor_skills[i]);
		    	if (get_checked_skill_tat_value == '' || isNaN(get_checked_skill_tat_value) || get_checked_skill_tat_value < 0) {
		    		check_skill_empty_count++;
		    	}
		    }
		}
	} else {
		$('#vendor-skill-error-msg-div').html('<span class="text-danger error-msg-small">Please select the vendor skills.</span>');
	}

	if (vendor_name != '' &&
		vendor_address_line_1 != '' && vendor_city != ''  && vendor_zip_code != ''  && vendor_state != '' && vendor_website != '' 
		&& vendor_monthly_quota != '' && vendor_aggrement_start_date != '' && vendor_aggrement_end_date != '' && vendor_manager_name != '' 
		&& vendor_spoc_name != ''   && vendor_spoc_email_id != '' && vendor_spoc_mobile_number != '' && vendor_spoc_mobile_number.length == mobile_number_length 
		&& vendor_skill_tat != ''  && vendor_skill_tat.length > 0 && vendor_skills.length > 0 /*&& vendor_skills != '' && vendor_skills != null && vendor_skills != undefined && check_skill_empty_count == 0*/) {
			$('#vendor-skill-error-msg-div').html('&nbsp;');

			$.ajax({
				type: "POST",
			  	url: base_url+"admin_Vendor/check_new_vendor_spoc_email_id_exists",
			  	data: { 
			  		vendor_spoc_email_id : vendor_spoc_email_id
			  	},
			  	dataType: "json",
			  	success: function(data) {
				  	if (data.count == '0') {
				  		$('#add-vendor-main-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are adding.</span>');
				  		btn_disabled();

				  		$('#vendor-user-name-error-msg-div').html('&nbsp;');
				  		input_is_valid('#vendor-user-name');
				  		var formdata = new FormData();
						formdata.append('vendor_name', vendor_name);
						formdata.append('vendor_address_line_1', vendor_address_line_1);
						formdata.append('vendor_address_line_2', vendor_address_line_2);
						formdata.append('vendor_city', vendor_city);
						formdata.append('vendor_zip_code', vendor_zip_code);
						formdata.append('vendor_state', vendor_state);
						formdata.append('vendor_website', vendor_website);
						formdata.append('vendor_monthly_quota', vendor_monthly_quota);
						formdata.append('vendor_aggrement_start_date', vendor_aggrement_start_date);
						formdata.append('vendor_aggrement_end_date', vendor_aggrement_end_date);
						formdata.append('vendor_skill_tat', vendor_skill_tat);
						formdata.append('vendor_manager_name', vendor_manager_name);
						formdata.append('vendor_manager_email_id', vendor_manager_email_id);
						formdata.append('vendor_manager_mobile_number', vendor_manager_mobile_number);
						formdata.append('vendor_spoc_name', vendor_spoc_name);
						formdata.append('vendor_spoc_email_id', vendor_spoc_email_id);
						formdata.append('vendor_spoc_mobile_number', vendor_spoc_mobile_number);
						formdata.append('vendor_skills', vendor_skills);

						if (vendor_docs.length > 0) {
							for(var i=0, len=vendor_docs.length; i<len; i++) {
								formdata.append('vendor_docs[]', vendor_docs[i]);
							}
						} else {
							formdata.append('vendor_docs[]', '');
						}

						$.ajax({
							type: "POST",
						  	url: base_url+"admin_Vendor/add_new_vendor",
						  	data: formdata,
						  	dataType: "json",
						  	contentType: false,
		    				processData: false,
						  	success: function(data) {
						  		$('#add-vendor-main-error-msg-div').html('');
						  		btn_enabled();
							  	if (data.status == '1') {
							  		$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number, .tat').val('');
							  		$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number, .tat').removeClass('is-valid is-invalid');
							  		$('.vendor-skills:checkbox:checked').prop("checked", false);
							  		$('.tat').prop('disabled',true);
							  		$('#vendor-confirm-password-error-msg-div, .vendor-tat-error-msg-div').html('&nbsp;');
							  		$('#selected-vendor-docs-li').html('');
							  		vendor_docs = [];
							  		vendor_skills = [];
							  		$('.is-valid').removeClass('is-valid');
							  		toastr.success('New vendor has been added successfully.');
							  	} else {
							  		toastr.error('OOPS! Something went wrong while adding the vendor. Please try again.');
						  		}
						  	},
						  	error: function(data) {
						  		toastr.error('OOPS! Something went wrong while adding the vendor. Please try again.');
						  		btn_enabled();
						  	}
						});
				  	} else {
				  		$('#add-vendor-main-error-msg-div').html('<span class="text-danger error-msg-small">Entered SOPC email id already exists. Please enter the new email id.</span>');
				  		btn_enabled();
				  		check_vendor_spoc_email_id();
			  		}
			  	}
			});
	} else {

		$('#add-vendor-main-error-msg-div').html('<span class="text-danger error-msg-small">Please fill all the necessary details.</span>');

		check_vendor_name();

		check_address_line_1();

		check_vendor_city();

		check_vendor_zip_code();

		check_vendor_state();

		check_vendor_website();

		check_vendor_monthly_quota();

		if (vendor_aggrement_start_date == '') {
			check_vendor_aggrement_start_date();
		}

		check_vendor_aggrement_end_date();

		// check_vendor_skill_tat();

		check_vendor_manager_name();

		check_vendor_spoc_name();

		check_vendor_spoc_email_id();

		check_vendor_spoc_mobile_number();

		if (vendor_skills == '' || vendor_skills == null || vendor_skills == undefined) {
			$('#vendor-skill-error-msg-div').html('<span class="text-danger error-msg-small">Please select the vendor skills.</span>');
		}

		if (vendor_docs.length > max_vendor_document_select) {
			$("#selected-vendor-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_vendor_document_select+' files</span>');
		}
	}
}

function btn_disabled() {
	$('#add-new-vendor-btn').removeAttr('onclick');
	$('#cancel-new-vendor-btn').removeAttr('onclick');
}

function btn_enabled() {
	$('#add-new-vendor-btn').attr("onclick","add_new_vendor()");
	$('#cancel-new-vendor-btn').attr("onclick","cancel_add_new_vedor()");
}