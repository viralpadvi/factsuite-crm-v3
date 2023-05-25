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

function mandatory_alpha_numbers_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_an_alphabet_input_error_msg,exceeding_max_length_input_error_msg,product_weight_name_length) {
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
			$(variable_array.error_msg_div_id).html(variable_array.no_error_msg);
			return 1;
		}
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

function only_number_with_max_number_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value > variable_array.max_number) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(variable_array.max_number);
			return 0;
		} else {
			$(variable_array.error_msg_div_id).html(variable_array.no_error_msg);
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

function single_file_upload(variable_array) {
	var files = variable_array.e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	var i=1;
	if (files.length == 1) {
		$(variable_array.show_image_name_msg_div_id).html('');
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
	    $(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span></div>');
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

function multiple_file_upload_single_image_or_video_with_input(variable_array) {
	var files = variable_array.e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    $(variable_array.show_image_id).html('');
    
    if(files.length > 0) {
    	var image_or_video_check_counter = 0,
    		check_max_video_size_counter = 0,
    		check_max_image_size_counter = 0;
    	for (var i = 0; i < files.length; i++) {
    		if ($.inArray(files[i].name.split('.').pop().toLowerCase(), file_extensions_list) == -1) {
        		image_or_video_check_counter++;
    		} else {
    			if ($.inArray(files[i].name.split('.').pop().toLowerCase(),video_extensions_list) != -1) {
    				if (files[i].size > variable_array.max_video_size) {
                		check_max_video_size_counter++;
            		}
    			} else {
    				if (files[i].size > variable_array.max_img_size) {
                		check_max_image_size_counter++;
            		}
    			}
    		}
    	}

    	if (image_or_video_check_counter == 0 && check_max_video_size_counter == 0 && check_max_image_size_counter == 0) {
			for (var i = 0; i < files.length; i++) {
    			variable_array.storedFiles_array.push(files[i]);
		    	var fileName = files[i].name; // get file name
		        var html = '<div class="col-md-4" id="'+variable_array.file_ui_id+'-'+i+'">';
	            html += '<div class="row">';
	            html += '<div class="'+variable_array.col_type+' mt-3">';
	           	html += '<div class="image-selected-div">';
	           	html += '<ul class="'+variable_array.sorting_class+'" id="'+variable_array.sorting_id+'" data-sorting_id="'+i+'">';
	            html += '<li class="image-selected-name">'+fileName+'</li>';
	            html += '<li class="image-name-delete">';
	            html += '<a id="'+variable_array.file_ui_id+i+'" onclick="'+variable_array.remove_image_function_name+'('+i+',\''+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>';
	            html += '</li>';
	            html += '</ul>';
	            html += '</div>';
	            html += '</div>';
	            html += '<div class="col-md-12 mt-2">';
	           	html += '<input type="hidden" class="input-txt '+variable_array.input_hidden_class_name+'" id="'+variable_array.input_hidden_class_name+'-'+i+'" value="'+i+'">';
	           	html += '<input type="text" class="input-txt '+variable_array.input_class_name+'" id="'+variable_array.image_input_id+'-'+i+'" name="'+variable_array.image_input_id+'-'+i+'" onkeyup="'+variable_array.input_function_name+'('+i+')" onblur="'+variable_array.input_function_name+'('+i+')" placeholder="'+variable_array.input_plcaeholder+'">';
	            html += '<div id="'+variable_array.image_input_error_msg_div_id+'-'+i+'"></div>';
	            html += '</div>';
	            html += '</div>';
	            html += '</div>';
	            $(variable_array.show_image_id).append(html);
	        }
    	} else {
    		var error_msg = '';
    		if (image_or_video_check_counter != 0) {
    			error_msg = 'Allowed formats are: '+file_extensions_list.join(', ');
    		} else if (check_max_video_size_counter != 0) {
    			error_msg = variable_array.video_max_size_exceeding_error_msg;
    		} else if (check_max_image_size_counter != 0) {
    			error_msg = variable_array.image_max_size_exceeding_error_msg;
    		}
    		$(variable_array.show_image_id).html("<div class='"+variable_array.col_type+"'><span class='text-danger error-msg-small'>"+error_msg+"</span></div>");
        	$(variable_array.file_id).val('');
    	}
    }
}

function multiple_file_upload_single_image_with_input_and_valid_file_extensions(variable_array) {
	var files = variable_array.e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    // $(variable_array.show_image_id).html('');
    
    if(files.length > 0) {
    	var image_check_counter = 0,
    		check_max_image_size_counter = 0;
    	for (var i = 0; i < files.length; i++) {
    		if ($.inArray(files[i].name.split('.').pop().toLowerCase(), variable_array.allowed_file_extensions) == -1) {
        		image_check_counter++;
    		} else {
    			if (files[i].size > variable_array.max_img_size) {
                	check_max_image_size_counter++;
            	}
    		}
    	}

    	if (image_check_counter == 0 && check_max_image_size_counter == 0) {
			for (var i = 0; i < files.length; i++) {
    			variable_array.storedFiles_array.push(files[i]);
		    	var fileName = files[i].name; // get file name
		        var html = '<div class="col-md-4" id="'+variable_array.file_ui_id+'-'+i+'">';
	            html += '<div class="row">';
	            html += '<div class="'+variable_array.col_type+' mt-3">';
	           	html += '<div class="image-selected-div">';
	           	html += '<ul class="'+variable_array.sorting_class+'" id="'+variable_array.sorting_id+'" data-sorting_id="'+i+'">';
	            html += '<li class="image-selected-name">'+fileName+'</li>';
	            html += '<li class="image-name-delete">';
	            html += '<a id="'+variable_array.file_ui_id+i+'" onclick="'+variable_array.remove_image_function_name+'('+i+',\''+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>';
	            html += '</li>';
	            html += '</ul>';
	            html += '</div>';
	            html += '</div>';
	            html += '<div class="col-md-12 mt-2">';
	           	html += '<input type="hidden" class="input-txt '+variable_array.input_hidden_class_name+'" id="'+variable_array.input_hidden_class_name+'-'+i+'" value="'+i+'">';
	           	html += '<input type="text" class="form-control fld '+variable_array.input_class_name+'" id="'+variable_array.image_input_id+'-'+i+'" name="'+variable_array.image_input_id+'-'+i+'" onkeyup="'+variable_array.input_function_name+'('+i+')" onblur="'+variable_array.input_function_name+'('+i+')" placeholder="'+variable_array.input_placeholder+'">';
	            html += '<div id="'+variable_array.image_input_error_msg_div_id+'-'+i+'"></div>';
	            html += '</div>';
	            html += '</div>';
	            html += '</div>';
	            $(variable_array.show_image_id).append(html);
	        }
    	} else {
    		var error_msg = '';
    		if (image_check_counter != 0) {
    			error_msg = 'Allowed formats are: '+variable_array.allowed_file_extensions.join(', ');
    		} else if (check_max_image_size_counter != 0) {
    			error_msg = variable_array.image_max_size_exceeding_error_msg;
    		}
    		$(variable_array.show_image_id).html("<div class='"+variable_array.col_type+"'><span class='text-danger error-msg-small'>"+error_msg+"</span></div>");
    	}
        $(variable_array.file_id).val('');
    }
}

function remove_selected_service_benefits_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < service_benefits_images_array.length; i++) {
		if(service_benefits_images_array[i].name === file) {
			service_benefits_images_array.splice(i,1); 
		}
	}
	if (service_benefits_images_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function single_file_upload_for_only_image(variable_array) {
	var files = variable_array.e.target.files;
    var filesArr = Array.prototype.slice.call(files);

    if ($.inArray(files[0].name.split('.').pop().toLowerCase(), image_extension_list) == -1) {
        $(variable_array.show_image_name_msg_div_id).html("<div class='"+variable_array.col_type+"'><span class='text-danger error-msg-small'>Allowed formats are: "+image_extension_list.join(', ')+"</span></div>");
        $(variable_array.file_id).val('');
    } else {
        $(variable_array.show_image_name_msg_div_id).html('');
        if (files.length == 1 && files[0].size <= variable_array.file_size) {
            var fileName = files[0].name; // get file name
            var html = '<div class="'+variable_array.col_type+'" id="'+variable_array.file_ui_id+'_1">'+
                '<div class="image-selected-div">'+
                    '<ul>'+
                        '<li class="image-selected-name">'+fileName+'</li>'+
                            '<li class="image-name-delete">'+
                                '<a id="'+variable_array.file_ui_id+'" onclick="remove_single_file_for_only_image(1,\'#'+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\',\''+variable_array.show_image_name_msg_div_id+'\',\''+variable_array.empty_input_error_msg+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
                            '</li>'+
                        '</ul>'+
                    '</div>'+
                '</div>';
                $(variable_array.show_image_name_msg_div_id).append(html);
                variable_array.storedFiles_array.push(files[0]);
                return 1;
        } else {
            if(files[0].size > variable_array.file_size) {
                $(variable_array.show_image_name_msg_div_id).html("<div class='"+variable_array.col_type+"'><span class='text-danger error-msg-small'>"+variable_array.exceeding_max_length_error_msg+"</span></div>");
            } else {
                $(variable_array.show_image_name_msg_div_id).html("");
            }
            $(variable_array.file_id).val('');
            return 0;
        }
    }
}

function remove_single_file_for_only_image(id,file_ui_id,file_id,show_image_name_msg_div_id,empty_input_error_msg) {
	var file = $(file_ui_id+id).data("file");
	$(file_ui_id+'_'+id).remove();
	$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+empty_input_error_msg+'</span></div>');
	$(file_id).val('');
	return 1;
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

function remove_selected_gse_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < gse_header_images_array.length; i++) {
		if(gse_header_images_array[i].name === file) {
			gse_header_images_array.splice(i,1); 
		}
	}
	if (gse_header_images_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function remove_selected_mhe_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < mhe_header_images_array.length; i++) {
		if(mhe_header_images_array[i].name === file) {
			mhe_header_images_array.splice(i,1); 
		}
	}
	if (mhe_header_images_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function remove_selected_product_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < product_image_array.length; i++) {
		if(product_image_array[i].name === file) {
			product_image_array.splice(i,1); 
		}
	}
	if (product_image_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function remove_selected_careers_page_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < team_or_company_images_array.length; i++) {
		if(team_or_company_images_array[i].name === file) {
			team_or_company_images_array.splice(i,1); 
		}
	}
	if (team_or_company_images_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function remove_selected_about_us_header_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < about_us_header_image_array.length; i++) {
		if(about_us_header_image_array[i].name === file) {
			about_us_header_image_array.splice(i,1); 
		}
	}
	if (about_us_header_image_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function mandatory_multiple_image_upload_with_input(variable_array) {
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

		    	for (var i = 0; i < files.length; i++) {
		    		variable_array.storedFiles_array.push(files[i]);
		    		var fileName = files[i].name; // get file name
		            var html = '<div class="col-md-4" id="'+variable_array.file_ui_id+'-'+i+'">';
		            html += '<div class="row">';
		            html += '<div class="'+variable_array.col_type+' mt-3">';
		           	html += '<div class="image-selected-div">';
		           	html += '<ul>';
		            html += '<li class="image-selected-name">'+fileName+'</li>';
		            html += '<li class="image-name-delete">';
		            html += '<a id="'+variable_array.file_ui_id+i+'" onclick="'+variable_array.remove_image_function_name+'('+i+',\''+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>';
		            html += '</li>';
		            html += '</ul>';
		            html += '</div>';
		            html += '</div>';
		            html += '<div class="col-md-12 mt-2">';
		           	html += '<input type="hidden" class="input-txt '+variable_array.input_hidden_class_name+'" id="'+variable_array.input_hidden_class_name+'-'+i+'" value="'+i+'">';
		           	html += '<input type="text" class="input-txt '+variable_array.input_class_name+'" id="'+variable_array.image_input_id+'-'+i+'" name="'+variable_array.image_input_id+'-'+i+'" onkeyup="'+variable_array.input_function_name+'('+i+')" onblur="'+variable_array.input_function_name+'('+i+')" placeholder="'+variable_array.input_plcaeholder+'">';
		            html += '<div id="'+variable_array.image_input_error_msg_div_id+'-'+i+'"></div>';
		            html += '</div>';
		            html += '</div>';
		            html += '</div>';
		            $(variable_array.show_image_id).append(html);
	        	}
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

function remove_selected_product_gallery_image(id,file_ui_id,file_id) {
	var file = $('#'+file_ui_id+id).data("file");
	for(var i = 0;i < product_gallery_images_array.length; i++) {
		if(product_gallery_images_array[i].name === file) {
			product_gallery_images_array.splice(i,1); 
		}
	}
	if (product_gallery_images_array.length == 0) {
		$(file_id).val('');
	}
	
	$('#'+file_ui_id+'-'+id).remove();
	return 1;
}

function multiple_file_upload_with_max_file_upload(variable_array) {
	var files = variable_array.e.target.files;
	var filesArr = Array.prototype.slice.call(files);
	if (files.length != 0 && files.length <= variable_array.max_file_upload_length) {
		$(variable_array.show_image_name_msg_div_id).html('');
		if (files[0].size <= variable_array.file_size) {
			for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        var html = '<div class="'+variable_array.col_type+' mt-3" id="'+variable_array.file_ui_id+'-'+i+'">'+
			            '<div class="image-selected-div">'+
			               	'<ul>'+
			                   	'<li class="image-selected-name">'+fileName+'</li>'+
		                      	'<li class="image-name-delete">'+
			                        '<a id="'+variable_array.file_ui_id+i+'" onclick="'+variable_array.remove_image_function_name+'('+i+',\'#'+variable_array.file_ui_id+'\',\''+variable_array.file_id+'\',\''+variable_array.show_image_name_msg_div_id+'\',\''+variable_array.empty_input_error_msg+'\')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
			                    '</li>'+
			                '</ul>'+
		                '</div>'+
		            '</div>';
		            $(variable_array.show_image_name_msg_div_id).append(html);
		            variable_array.storedFiles_array.push(files[i]);
		    }
		    return 1;
		} else {
			$(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_error_msg+'</span></div>');
			$(variable_array.file_id).val('');
			return 0;
		}
	} else {
		if(files.length == 0) {
	    	$(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span></div>');
		} else if (files.length > 2) {
			$(variable_array.show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+variable_array.exceeding_max_file_upload_error_msg_div+'</span></div>');
		}
		$(variable_array.file_id).val('');
	    return 0;
	}
}

function remove_selected_product_document(id,file_ui_id,file_id,show_image_name_msg_div_id,empty_input_error_msg) {
	var file = $(file_ui_id+id).data("file");
	for(var i = 0;i < product_documents_array.length; i++) {
		if(product_documents_array[i].name === file) {
			product_documents_array.splice(i,1);
		}
	}

	if (product_documents_array.length == 0) {
		$(show_image_name_msg_div_id).html('<div class="col-md-12"><span class="text-danger error-msg-small">'+empty_input_error_msg+'</span></div>');
		$(file_id).val('');
	}
	
	$(file_ui_id+'-'+id).remove();
	return 1;
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

function change_status(variable_array) {
	$.ajax({
        type: "post",
        url: base_url+variable_array.ajax_call_url,
        data : variable_array.ajax_pass_data,
        dataType: "json",
        success: function(data) {
            if (data.status == '1') {
            	if (data.return_status.status == 1) {
            		if(variable_array.changed_status == '0') {
	          			$(variable_array.checkbox_id).prop("checked", false);
	        		} else {
	          			$(variable_array.checkbox_id).prop("checked", true);
	        		}
            		$(variable_array.checkbox_id).attr("onclick",variable_array.onclick_method_name+"("+variable_array.id+","+variable_array.changed_status+")");
        			toastr.success(variable_array.success_message);
        			return 1;
            	} else {
            		$(variable_array.checkbox_id).attr("onclick",variable_array.onclick_method_name+"("+variable_array.id+","+variable_array.actual_status+")");
	        		if(variable_array.actual_status == '0') {
	          			$(variable_array.checkbox_id).prop("checked", false);
	        		} else {
	          			$(variable_array.checkbox_id).prop("checked", true);
	        		}
	        		toastr.error(variable_array.error_message);
	        		return 0;
            	}
            } else {
            	$(variable_array.checkbox_id).attr("onclick",variable_array.onclick_method_name+"("+variable_array.id+","+variable_array.actual_status+")");
        		if(variable_array.actual_status == '0') {
          			$(variable_array.checkbox_id).prop("checked", false);
        		} else {
          			$(variable_array.checkbox_id).prop("checked", true);
        		}
        		toastr.error(variable_array.error_message);
        		return 0;
            }
        },
        error: function(data) {
        	$(variable_array.checkbox_id).attr("onclick",variable_array.onclick_method_name+"("+variable_array.id+","+variable_array.actual_status+")");
    		if(variable_array.actual_status == '0') {
      			$(variable_array.checkbox_id).prop("checked", false);
    		} else {
      			$(variable_array.checkbox_id).prop("checked", true);
    		}
    		toastr.error(variable_array.error_message);
    		variable_array.error_callback_function;
    		return 0;
        }
    });
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

function delete_uploaded_image(variable_array) {
	$(variable_array.delete_btn_id).removeAttr('onclick');
	$.ajax({
        type  : 'POST',
        url   : base_url+variable_array.ajax_call_url,
        data : variable_array.ajax_pass_data,
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	        	if (data.delete_image.status == 1) {
	        		toastr.success(variable_array.success_message);
	        		$(variable_array.delete_image_div_id).remove();
	         		$(variable_array.modal_id).modal('hide');
	        	} else {
	        		$(variable_array.delete_btn_id).attr('onclick',variable_array.onclick_method_name+'('+variable_array.id+')');
	        		toastr.error(variable_array.error_message);
	        	}
	        } else {
	        	check_admin_login();
	        }
	    },
	    error : function(data) {
	    	$(variable_array.delete_btn_id).attr('onclick',variable_array.onclick_method_name+'('+variable_array.id+')');
	    	toastr.error(variable_array.error_message);
	    }
    });
}

function delete_product_uploaded_image(variable_array) {
	$(variable_array.delete_btn_id).removeAttr('onclick');
	var return_status = 0;
	$.ajax({
        type  : 'POST',
        url   : base_url+variable_array.ajax_call_url,
        data : variable_array.ajax_pass_data,
        async : false,
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	        	if (data.delete_image.status == 1) {
	        		return_status = 1;
	        		toastr.success(variable_array.success_message);
	        		$(variable_array.delete_image_div_id).remove();
	         		$(variable_array.modal_id).modal('hide');
	        	} else {
	        		return_status = 0;
	        		$(variable_array.delete_btn_id).attr('onclick',variable_array.onclick_method_name+'('+variable_array.id+',\''+variable_array.gse_or_mhe+'\')');
	        		toastr.error(variable_array.error_message);
	        	}
	        } else {
	        	return_status = 0;
	        	check_admin_login();
	        }
	    },
	    error : function(data) {
	    	return_status = 0;
	    	$(variable_array.delete_btn_id).attr('onclick',variable_array.onclick_method_name+'('+variable_array.id+',\''+variable_array.gse_or_mhe+'\')');
	    	toastr.error(variable_array.error_message);
	    }
    });
    return return_status;
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
		return 0;
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

function mandatory_mobile_number_with_two_different_mobile_numbers_and_max_length_limitation(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		if (!numbers_only.test(input_value)) {
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_a_number_input_error_msg+'</span>');
			$(variable_array.input_id).val(input_value.slice(0,-1));
			return 0;
		} else if (input_value.length == variable_array.max_length_1 || input_value.length == variable_array.max_length_2) {
			$(variable_array.error_msg_div_id).html('');
			return 1;
		} else {
			if (input_value.length != variable_array.max_length_2) {
				$(variable_array.input_id).val(input_value.slice(0,variable_array.max_length_2));
			}
			$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.exceeding_max_length_input_error_msg+'</span>');
			return 0;
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