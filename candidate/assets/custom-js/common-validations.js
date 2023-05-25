var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	alpha_num_only = /^[a-zA-Z0-9 ]+$/,
	numbers_only = /^[0-9]+$/,
	url_regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,
	file_extensions_list = ['jpeg','jpg','png','gif','bmp','svg','mp4'],
	image_extension_list = ['jpeg','jpg','png','gif','bmp','svg'],
    video_extensions_list = ['mp4'];

function mandatory_only_alphabets_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!alphabets_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_an_alphabet_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function mandatory_alphanumeric_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_an_alphabet_input_error_msg,exceeding_max_length_input_error_msg,product_weight_name_length) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		if (!alpha_num_only.test(input_value)) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+not_an_alphabet_input_error_msg+'</span>');
			$(input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length > max_length) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+exceeding_max_length_input_error_msg+'</span>');
			$(input_id).val(input_value.slice(0,max_length));
			return 0;
		} else {
			$(error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_alphanumeric_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!alpha_num_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_an_alphanumeric_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length != variable_array.max_input_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_input_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 1;
	}
}

function only_number_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_only_number_with_max_length_limitation(input_id,error_msg_div_id,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+not_a_number_input_error_msg+'</span>');
			$(input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length > max_length) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+exceeding_max_length_input_error_msg+'</span>');
			$(input_id).val(input_value.slice(0,max_length));
			return 0;
		} else {
			$(error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(error_msg_div_id).html('');
		return 1;
	}
}

function not_mandatory_link(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!url_regex.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_link_input_error_msg+'</span>');
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	}
}

function mandatory_select(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_select(variable_array) {
	$(variable_array.error_msg_div_id).html('');
	return 1;
}

function mandatory_any_input_with_no_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_any_input_with_no_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	$(variable_array.error_msg_div_id).html('');
	return 1;
}

function mandatory_any_input_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_any_input_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	}
}

function mandatory_any_input_with_max_length_validation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function mandatory_any_input_with_min_length_validation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (input_value.length < variable_array.min_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.min_length_error_msg+'</span>');
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_any_input_with_max_length_validation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (input_value.length > variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	}
}

function not_madatory_url(input_id,error_message_div_id) {
	var input_value = $(input_id).val();
    if (input_value != '') {
        if (!url_regex.test(input_value)) {
            $(error_message_div_id).html('<span class="text-danger error-msg-small">Entered string is not a URL. Please enter the url.</span>');
            return 0;
        } else {
            $(error_message_div_id).html('');
            return 1;
        }
    } else {
        $(error_message_div_id).html('');
        return 1;
    }
}

function mandatory_checkbox(input_id,error_msg_input_id,empty_input_error_msg,input_array) {
	$.each($(input_id), function(i) {
        input_array[i] = $(this).val();
    });

    if (input_array.length != 0) {
    	$(error_msg_input_id).html('');
    	return 1;
    } else {
    	$(error_msg_input_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
    	return 0;
    }
}

function mandatory_input_with_max_length_check_name_duplication(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '' && input_value.length > 0) {
		if (input_value.length > variable_array.name_max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.error_msg_div_id+'</span>');
		} else {
			var check_duplication_count = '';
			$.ajax({
				type: "POST",
			  	url: base_url+variable_array.ajax_call_url,
			  	data: variable_array.ajax_pass_data,
			  	dataType: 'json',
			    async: false,
			  	success: function(data) {
			  		if (data.status == 1) {
				  		check_duplication_count = data.check_duplication.count;					  	
				  	} else {
				  		check_admin_login();
				  	}
			  	},
			  	error: function(data) {
			  		toastr.error('Something went wrong. Please try again.');
			  	}
			});
			if (check_duplication_count == 0) {
				$(variable_array.error_msg_div_id).html('');
				return 1;
			} else {
				$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.duplication_error_msg+'</span>');
				return 0;
			}
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
	}
}

function mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length != variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_mobile_number_pin_code_with_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length != variable_array.max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	}
}

function mandatory_mobile_number_with_min_and_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length < variable_array.min_length || input_value.length > variable_array.max_length) {
			if (input_value.length < variable_array.min_length) {
				$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_min_length_input_error_msg+'</span>');
			} else {
				$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
				$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length));
			}
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function mandatory_email_id(variable_array) {
	var email = $(variable_array.input_id).val().toLowerCase();
	if (email != '') {
	    if(!email_regex.test(email)) {
	    	$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_an_email_input_error_msg+'</span>');
	    	return 0;
	    } else {
	    	$(variable_array.error_msg_div_id).html('');
	    	return 1;
	    }
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_email_id(variable_array) {
	var email = $(variable_array.input_id).val().toLowerCase();
	if (email != '') {
	    if(!email_regex.test(email)) {
	    	$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_an_email_input_error_msg+'</span>');
	    	return 0;
	    } else {
	    	$(variable_array.error_msg_div_id).html('');
	    	return 1;
	    }
	} else {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	}
}

function mandatory_input_with_max_length_check_name_duplication(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '' && input_value.length > 0) {
		if (input_value.length > variable_array.name_max_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.error_msg_div_id+'</span>');
		} else {
			var check_duplication_count = '';
			$.ajax({
				type: "POST",
			  	url: base_url+variable_array.ajax_call_url,
			  	data: variable_array.ajax_pass_data,
			  	dataType: 'json',
			    async: false,
			  	success: function(data) {
			  		if (data.status == 1) {
				  		check_duplication_count = data.check_duplication.count;					  	
				  	} else {
				  		check_admin_login();
				  	}
			  	},
			  	error: function(data) {
			  		toastr.error('Something went wrong. Please try again.');
			  	}
			});
			if (check_duplication_count == 0) {
				$(variable_array.error_msg_div_id).html('');
				return 1;
			} else {
				$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.duplication_error_msg+'</span>');
				return 0;
			}
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
	}
}

function single_file_upload_with_and_valid_file_extensions(variable_array) {
	var files = variable_array.e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	var i=1;
	if (files.length == 1) {
		$(variable_array.show_image_name_msg_div_id).html('');
		if ($.inArray(files[0].name.split('.').pop().toLowerCase(), variable_array.allowed_file_extensions) != -1) {
			if (files[0].size <= variable_array.file_size) {
				for (var i = 0; i < files.length; i++) {
			        var fileName = files[i].name; // get file name
			        var html = '<div class="'+variable_array.col_type+'" id="'+variable_array.file_ui_id+'_'+i+'">'+
				            '<div class="image-selected-div">'+
				               	'<ul>'+
				                   	'<li class="image-selected-name">'+fileName+'</li>'+
			                      	'<li class="image-name-delete">'+
				                        '<a id="'+variable_array.file_ui_id+i+'" onclick="remove_single_file('+i+',\'#'+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\',\''+variable_array.show_image_name_msg_div_id+'\',\''+variable_array.empty_input_error_msg+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
				                    '</li>'+
				                '</ul>'+
			                '</div>'+
			            '</div>';
			            $(variable_array.show_image_name_msg_div_id).append(html);
			            variable_array.storedFiles_array.push(files[i]);
			            return 1;
			    }
			} else {
				$(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_error_msg+'</span></div>');
				$(variable_array.image_id).val('');
				return 0;
			}
		} else {
			$(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">Allowed formats are: '+variable_array.allowed_file_extensions.join(', ')+'</span></div>');
			$(variable_array.image_id).val('');
			return 0;
		}
	} else {
	    $(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span></div>');
	    return 0;
	}
}

function remove_single_file(id,file_ui_id,file_id,show_image_name_msg_div_id,empty_input_error_msg) {
	var file = $(file_ui_id+id).data("file");
	$(file_ui_id+'_'+id).remove();
	$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+empty_input_error_msg+'</span></div>');
	$(file_id).val('');
	return 1;
}

function mandatory_email_id_with_check_duplication(variable_array) {
	var email = $(variable_array.input_id).val().toLowerCase();
	if (email != '') {
	    if(!email_regex.test(email)) {
	    	$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg">'+variable_array.not_an_email_input_error_msg+'</span>');
	    	return 0;
	    } else {
	    	var return_value = 0;
	    	$.ajax({
				type: "POST",
				url: base_url+variable_array.ajax_call_url,
				data: variable_array.ajax_pass_data,
				async : false,
				dataType: "json",
				success: function(data) {
					if (data.status == '1') {
			    		if (data.email_count.count == 0) {
				      		$(variable_array.error_msg_div_id).html('');
				      		return_value = 1;
				      	} else {
				      		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg">'+variable_array.duplicate_email_id_error_msg+'</span>');
				      		return_value = 0;
				      	}
			    	} else {
			    		$(variable_array.error_msg_div_id).html('');
			    		check_user_login();
			    		return_value = 0;
			    	}
				} 
			});
			return return_value;
	    }
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg">'+variable_array.not_an_email_input_error_msg+'</span>');
		return 0;
	}
}

function mandatory_mobile_number_with_check_duplication(variable_array) {
	var mobile_number = $(variable_array.input_id).val();
	if (mobile_number != '') {
		if (!numbers_only.test(mobile_number)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(mobile_number.slice(0,-1));
			return 0;
		} else if (mobile_number.length != variable_array.mobile_number_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			$(variable_array.input_id).val(mobile_number.slice(0,10));
			return 0;
		} else {
			$.ajax({
				type: "POST",
			    url: base_url+variable_array.ajax_call_url,
			    dataType: "json",
			    data : variable_array.ajax_pass_data,
			    success: function(data) {
			    	if (data.status == '1') {
			    		if (data.number_count.count == 0) {
				      		$(variable_array.error_msg_div_id).html('');
				      		return 1;
				      	} else {
				      		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.duplicate_email_id_error_msg+'</span>');
				      		return 0;
				      	}
			    	} else {
			    		$(variable_array.error_msg_div_id).html('');
			    	}
			    }
			});
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}


function mandatory_pincode(variable_array) {
	var mobile_number = $(variable_array.input_id).val();
	if (mobile_number != '') {
		if (!numbers_only.test(mobile_number)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(mobile_number.slice(0,-1));
			return 0;
		} else if (mobile_number.length != variable_array.mobile_number_length) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
			$(variable_array.input_id).val(mobile_number.slice(0,6));
			return 0;
		} else { 
			$(variable_array.error_msg_div_id).html('');
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function not_mandatory_multiple_image_upload(variable_array) {
	var files = variable_array.e.target.files;
    var filesArr = Array.prototype.slice.call(files);

    if (files.length > 0) {
    	var not_an_image_count = 0,
    		exceeding_max_image_size_count = 0;
    	for (var i = 0; i < files.length; i++) {
    		if ($.inArray(files[i].name.split('.').pop().toLowerCase(), image_extension_list) == -1) {
		        not_an_image_count++;
		    }

		    if (files[i].size > max_img_size) {
		    	exceeding_max_image_size_count++;
		    }
        }

    	if (not_an_image_count != 0) {
	        $(variable_array.show_image_id).html("<div class='"+variable_array.col_type+"'><span class='text-danger error-msg-small'>Allowed formats are: "+image_extension_list.join(', ')+"</span></div>");
	        $(variable_array.file_id).val('');
	    	return 0;
	    } else {
	    	if (exceeding_max_image_size_count == 0) {
	    		$(variable_array.show_image_id).html('');

	    		var sorting_id = 'no-sort',
	    			sorting_class = '';
	    		if (variable_array.sorting_id != '' && variable_array.sorting_id != undefined) {
	    			sorting_id = variable_array.sorting_id;
	    		}

	    		if (variable_array.sorting_class != '' && variable_array.sorting_class != undefined) {{
	    			sorting_class = variable_array.sorting_class;
	    		}}
		    	for (var i = 0; i < files.length; i++) {
		    		variable_array.storedFiles_array.push(files[i]);
		    		var fileName = files[i].name; // get file name
		            var html = '<div class="'+variable_array.col_type+' mt-3" id="'+variable_array.file_ui_id+'-'+i+'">'+
		                '<div class="image-selected-div">'+
		                	'<ul class="'+sorting_class+'" id="'+sorting_id+'_'+i+'" data-sorting_id="'+i+'">'+
		                      	'<li class="image-selected-name">'+fileName+'</li>'+
		                      	'<li class="image-name-delete">'+
		                        	'<a id="'+variable_array.file_ui_id+i+'" onclick="'+variable_array.remove_image_function_name+'('+i+',\''+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
		                      	'</li>'+
		                    '</ul>'+
		                  '</div>'+
		                '</div>';
		            $(variable_array.show_image_id).append(html);
	        	}
		        return 1;
	    	} else {
	    		$(variable_array.show_image_id).html("<span class='text-danger error-msg-small'>"+variable_array.max_size_exceeding_error_msg+"</span>");
	    		$(variable_array.file_id).val('');
	    		return 0;
	    	}
	    }
	} else {
		$(variable_array.show_image_id).html("<span class='text-danger error-msg-small'>"+variable_array.empty_input_error_msg+"</span>");
		return 1;
	}
}