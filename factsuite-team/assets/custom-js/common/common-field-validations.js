var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	numbers_only = /^[0-9]+$/,
	url_regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,
	file_extensions_list = ['jpeg','jpg','png','gif','bmp','mp4'],
    video_extensions_list = ['mp4'];

function only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length) {
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
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
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

function select_tag_validation_with_input_for(input_id,error_msg_div_id,empty_input_error_msg,input_for,callback_function) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		$(error_msg_div_id).html('');
		return 1;
	} else {
		callback_function+"("+input_for+")";
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
		return 0;
	}
}

function select_tag_validation(input_id,error_msg_div_id,empty_input_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		$(error_msg_div_id).html('');
		return 1;
	} else {
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
		return 0;
	}
}

function single_file_upload(e,file_id,show_image_name_msg_div_id,storedFiles_array,col_type,file_ui_id,file_size,empty_input_error_msg) {
	var files = e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	var i=1;
	if (files.length == 1) {
		$(show_image_name_msg_div_id).html('');
		if (files[0].size <= file_size) {
			for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        var html = '<div class="'+col_type+'" id="'+file_ui_id+'_'+i+'">'+
			            '<div class="image-selected-div">'+
			               	'<ul>'+
			                   	'<li class="image-selected-name">'+fileName+'</li>'+
		                      	'<li class="image-name-delete">'+
			                        '<a id="'+file_ui_id+i+'" onclick="remove_single_file('+i+',\'#'+file_ui_id+'\',\''+file_id+'\',\''+show_image_name_msg_div_id+'\',\''+empty_input_error_msg+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
			                    '</li>'+
			                '</ul>'+
		                '</div>'+
		            '</div>';
		            $(show_image_name_msg_div_id).append(html);
		            storedFiles_array.push(files[i]);
		            return 1;
		    }
		} else {
			$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">Image size should be of max 1 Mb.</span></div>');
			$(image_id).val('');
			return 0;
		}
	} else {
	    $(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+empty_input_error_msg+'</span></div>');
	    return 0;
	}
}

function not_mandatory_single_file_upload(e,file_id,show_image_name_msg_div_id,storedFiles_array,col_type,file_ui_id,file_size) {
	var files = e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	var i=1;
	if (files.length == 1) {
		$(show_image_name_msg_div_id).html('');
		if (files[0].size <= file_size) {
			for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        var html = '<div class="'+col_type+'" id="'+file_ui_id+'_'+i+'">'+
			            '<div class="image-selected-div">'+
			               	'<ul>'+
			                   	'<li class="image-selected-name">'+fileName+'</li>'+
		                      	'<li class="image-name-delete">'+
			                        '<a id="'+file_ui_id+i+'" onclick="not_mandatory_remove_single_file('+i+',\'#'+file_ui_id+'\',\''+file_id+'\',\''+show_image_name_msg_div_id+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
			                    '</li>'+
			                '</ul>'+
		                '</div>'+
		            '</div>';
		            $(show_image_name_msg_div_id).append(html);
		            storedFiles_array.push(files[i]);
		            return 1;
		    }
		} else {
			$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 1 Mb.</span></div>');
			$(image_id).val('');
			return 0;
		}
	} else {
	    $(show_image_name_msg_div_id).html('');
	    return 1;
	}
}

function remove_single_file(id,file_ui_id,file_id,show_image_name_msg_div_id,empty_input_error_msg) {
	var file = $(file_ui_id+id).data("file");
	$(file_ui_id+'_'+id).remove();
	$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+empty_input_error_msg+'</span></div>');
	$(file_id).val('');
	return 1;
}

function not_mandatory_remove_single_file(id,file_ui_id,file_id,show_image_name_msg_div_id) {
	var file = $(file_ui_id+id).data("file");
	$(file_ui_id+'_'+id).remove();
	$(show_image_name_msg_div_id).html('');
	$(file_id).val('');
	return 1;
}

function single_file_upload_single_image_or_video(e,file_id,show_image_name_msg_div_id,storedFiles_array,col_type,file_ui_id,file_size,video_size,empty_input_error_msg) {
	var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);

    if ($.inArray(files[0].name.split('.').pop().toLowerCase(), file_extensions_list) == -1) {
        $(show_image_name_msg_div_id).html("<div class='"+col_type+"'><span class='text-danger error-msg-small'>Allowed formats are: "+file_extensions_list.join(', ')+"</span></div>");
        $(file_id).val('');
    } else {
        $(show_image_name_msg_div_id).html('');
        var video_counter = 0,
            image_counter = 0;
        
        if ($.inArray(files[0].name.split('.').pop().toLowerCase(),video_extensions_list) == 0) {
            if (files.length == 1 && files[0].size <= video_size) {
                video_counter++;
            } else {
                if(files[0].size > video_size) {
                    $(show_image_name_msg_div_id).html("<div class='"+col_type+"'><span class='text-danger error-msg-small'>Please select the video of Max "+home_page_banner_video_size_mb+" MB.</span></div>");
                } else {
                    $(show_image_name_msg_div_id).html("");
                }
                $(file_id).val('');
            }
        } else {
            if (files.length == 1 && files[0].size <= file_size) {
                image_counter++;
            } else {
                if(files[0].size > file_size) {
                    $(show_image_name_msg_div_id).html("<div class='"+col_type+"'><span class='text-danger error-msg-small'>Please select the image of Max "+home_page_banner_size_mb+" MB.</span></div>");
                } else {
                    $(show_image_name_msg_div_id).html("");
                }
                $(file_id).val('');
            }
        }

        if (video_counter == 1 || image_counter == 1) {
            var fileName = files[0].name; // get file name
            var html = '<div class="'+col_type+'" id="'+file_ui_id+'_1">'+
                '<div class="image-selected-div">'+
                    '<ul>'+
                        '<li class="image-selected-name">'+fileName+'</li>'+
                            '<li class="image-name-delete">'+
                                '<a id="'+file_ui_id+'" onclick="remove_single_file(1,\'#'+file_ui_id+'\',\''+file_id+'\',\''+show_image_name_msg_div_id+'\',\''+empty_input_error_msg+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
                            '</li>'+
                        '</ul>'+
                    '</div>'+
                '</div>';
                $(show_image_name_msg_div_id).append(html);
                storedFiles_array.push(files[0]);
                return 1;
        } else {
        	return 0;
        }
    }
}

function any_input(input_id,error_msg_div_id,empty_input_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		$(error_msg_div_id).html('');
		return 1;
	} else {
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
		return 0;
	}
}

function mandatory_any_input_with_no_limitation(input_id,error_msg_div_id,empty_input_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		$(error_msg_div_id).html('');
		return 1;
	} else {
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
		return 0;
	}
}

function change_status(id,actual_status,changed_status,ajax_call_url,checkbox_id,onclick_method_name,success_message,error_message,error_callback_function) {
	$.ajax({
        type: "post",
        url: base_url+ajax_call_url,
        data : {
        	id : id,
        	changed_status : changed_status 
        },
        dataType: "json",
        success: function(data) {
            if (data.status == '1') {
            	$(checkbox_id+id).attr("onclick",onclick_method_name+"("+id+","+changed_status+")");
        		toastr.success(success_message);
        		return 1;
            } else {
            	$(checkbox_id+id).attr("onclick",onclick_method_name+"("+id+","+actual_status+")");
        		if(actual_status == '0') {
          			$(checkbox_id+id).prop("checked", false);
        		} else {
          			$(checkbox_id+id).prop("checked", true);
        		}
        		toastr.error(error_message);
        		return 0;
            }
        },
        error: function(data) {
        	$(checkbox_id+id).attr("onclick",onclick_method_name+"("+id+","+actual_status+")");
    		if(actual_status == '0') {
      			$(checkbox_id+id).prop("checked", false);
    		} else {
      			$(checkbox_id+id).prop("checked", true);
    		}
    		toastr.error(error_message);
    		error_callback_function;
    		return 0;
        }
    });
}

function mandatory_any_input_with_max_length_validation(input_id,error_msg_div_id,empty_input_error_msg,max_length,exceeding_max_length_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		if (input_value.length > max_length) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+exceeding_max_length_error_msg+'</span>');
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

function mandatory_any_input_with_min_length_validation(input_id,error_msg_div_id,empty_input_error_msg,min_length,min_length_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		if (input_value.length < min_length) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+min_length_error_msg+'</span>');
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

function not_mandatory_any_input_with_max_length_validation(input_id,error_msg_div_id,max_length,exceeding_max_length_error_msg) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		if (input_value.length > max_length) {
			$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+exceeding_max_length_error_msg+'</span>');
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

function delete_file(id,error_msg_div_id,ajax_pass_data,ajax_call_url,success_message,error_msg,called_modal_id) {
	$.ajax({
        type  : 'POST',
        url: base_url+ajax_call_url,
        data : ajax_pass_data,
        dataType : 'json',
        success : function(data) {
            if (data.status == 1) {
                toastr.success(success_message);
                $(error_msg_div_id).remove();
                $(called_modal_id).modal('hide');
            } else {
                toastr.error(error_msg);
                $(called_modal_id).modal('hide');
            }
        },
        error: function(data) {
            toastr.error(error_msg);
            $(called_modal_id).modal('hide');            
        }
    });
}

function verify_admin_password(input_id,error_msg_div_id,empty_input_error_msg,verify_for) {
	var input_value = $(input_id).val();
	if (input_value != '') {
		$(error_msg_div_id).html('');
		$.ajax({
	        type  : 'POST',
	        url: base_url+'rajakshetra-admin/verify-admin-password',
	        data : { admin_password : input_value },
	        dataType : 'json',
	        async : false,
	        success : function(data) {
	        	if (data.count == 1) {
	        		if (verify_for == 'payment-gateway-update') {
		            	payment_gateway_update();
		            } else if (verify_for == 'update-farmer-pay-amount') {
		            	farmer_pay_amount_update();
		            }
	        	} else {
	        		$(error_msg_div_id).html('<span class="text-danger error-msg-small">Entered password is incorrect. Please enter the correct password.</span>')
	        	}
	        }
	    });
	} else {
		$(error_msg_div_id).html('<span class="text-danger error-msg-small">'+empty_input_error_msg+'</span>');
        return 2;
	}
}

function update_with_verifying_admin(ajax_call_url,ajax_pass_data,success_message,error_message,incorrect_admin_password_error_message,admin_error_msg_div_id,close_modal_id,call_back_url) {
	$.ajax({
        type  : 'POST',
        url: base_url+'rajakshetra-admin/'+ajax_call_url,
        data : ajax_pass_data,
        dataType : 'json',
        success : function(data) {
        	if (data.count == 1) {
        		$(admin_error_msg_div_id).html('');
        		if (data.status == 1) {
	                toastr.success(success_message);
	                $(close_modal_id).modal('hide');
	            } else {
	                toastr.error(error_message);
	            }
        	} else {
        		$(admin_error_msg_div_id).html(incorrect_admin_password_error_message);
        	}
        },
        error: function(data) {
            toastr.error(error_message);
            $(close_modal_id).modal('hide');        
        }
    });
}

function confirm_both_passwords(new_password,confirm_password,new_password_error_msg_div,confirm_password_error_msg_div,new_password_empty_error_msg,new_password_min_length_error_msg,confirm_password_empty_error_msg,confirm_password_min_length_error_msg,password_min_length) {
	var new_password_input = $(new_password).val();
	var confirm_password_input = $(confirm_password).val();

	if (new_password_input != '' && new_password_input.length >= password_min_length && confirm_password_input != '' && confirm_password_input.length >= password_min_length) {
		if (new_password_input == confirm_password_input) {
			$(confirm_password_error_msg_div).html('<span class="text-success error-msg-small">Passwords are same.</span>');
			return 1;
		} else {
			$(confirm_password_error_msg_div).html('<span class="text-danger error-msg-small">New passwords are not same.</span>');
			return 0;
		}
	} else {
		if (new_password_input != '') {
			if (new_password_input.length < password_min_length) {
				$(new_password_error_msg_div).html('<span class="text-danger error-msg-small">'+new_password_min_length_error_msg+'</span>');
			} else {
				$(new_password_error_msg_div).html('');
			}
		} else {
			$(new_password_error_msg_div).html('<span class="text-danger error-msg-small">'+new_password_empty_error_msg+'</span>');
		}

		if (confirm_password_input != '') {
			if (confirm_password_input.length < password_min_length) {
				$(confirm_password_error_msg_div).html('<span class="text-danger error-msg-small">'+confirm_password_min_length_error_msg+'</span>');
			} else {
				$(confirm_password_error_msg_div).html('');
			}
		} else {
			$(confirm_password_error_msg_div).html('<span class="text-danger error-msg-small">'+confirm_password_empty_error_msg+'</span>');
		}

		return 0;
	}
}

function view_password_toggle(input_id,input_id_i,password_type) {
	var password_type_val = $(password_type).val();
    if (password_type_val == "1") {
     	$(password_type).val('0');
      	$(input_id).prop('type', 'text');
      	$(input_id_i).removeClass('fa-eye-slash');
      	$(input_id_i).addClass('fa-eye');
    } else {
      	$(password_type).val('1');
      	$(input_id).prop('type', 'password');
      	$(input_id_i).removeClass('fa-eye');
      	$(input_id_i).addClass('fa-eye-slash');
    }
}