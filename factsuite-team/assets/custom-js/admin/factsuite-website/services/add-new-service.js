var service_name_max_length = 100,
	maximum_check_number_max_length = 5,
	service_benefit_description_max_length = 20,
	max_img_size = 10000000,
	thumbnail_image_array = [],
	banner_image_array = [],
	service_icon_array = [],
	service_benefits_images_array = [];

$('#service-name').on('keyup blur', function() {
	check_service_name();
});

$('#maximum-checks').on('keyup blur', function() {
	check_maximum_checks();
});

$('.checked-components').on('click', function() {
	check_checked_components();
});

$("#thumbnail-image").on("change", handle_file_select_thumbnail_image);

$("#banner-image").on("change", handle_file_select_banner_image);

$("#service-icon").on("change", handle_file_select_service_icon);

$("#service-benefits").on("change", handle_file_select_service_benefits);

$('#service-submit-btn').on('click', function() {
	add_new_service();
});

function check_service_name() {
	var variable_array = {};
	variable_array['input_id'] = '#service-name';
	variable_array['name_max_length'] = service_name_max_length;
	variable_array['error_msg_div_id'] = '#service-name-error-msg-div';
	variable_array['exceeding_max_length_error_msg'] = 'Service name should be of max '+service_name_max_length+' characters';
	variable_array['ajax_call_url'] = 'factsuite-admin/check-new-service-name';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, service_name : $('#service-name').val()};
	variable_array['duplication_error_msg'] = 'Entered service already exists. Please enter a new service.';
	variable_array['empty_input_error_msg'] = 'Please enter the service name.';
	return mandatory_input_with_max_length_check_name_duplication(variable_array);
}

function check_checked_components() {
	var components_checked = $('input[name="component-name[]"]:checked').length;
	if (components_checked > 0) {
		$('#components-check-error-msg-div').html('');
		return 1;
	} else {
		$('#components-check-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 component.</span>');
		return 0;
	}
}

function check_maximum_checks() {
	var variable_array = {};
	variable_array['input_id'] = '#maximum-checks';
	variable_array['error_msg_div_id'] = '#maximum-checks-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please enter the maximum check';
	variable_array['not_a_number_input_error_msg'] = 'Maximum check should be only in numbers.';
	variable_array['exceeding_max_length_input_error_msg'] = 'Maximum check should be of max '+maximum_check_number_max_length+' characters';
	variable_array['max_length'] = maximum_check_number_max_length;
	variable_array['no_error_msg'] = '&nbsp;';
	return only_number_with_max_length_limitation(variable_array);
}

function handle_file_select_thumbnail_image(e) {
	thumbnail_image_array = [];
	var variable_array = {};
	variable_array['e'] = e;
	variable_array['file_id'] = '#thumbnail-image';
	variable_array['show_image_name_msg_div_id'] = '#thumbnail-image-error-msg-div';
	variable_array['storedFiles_array'] = thumbnail_image_array;
	variable_array['col_type'] = 'col-md-12 mt-3';
	variable_array['file_ui_id'] = 'file_thumbnail_image';
	variable_array['file_size'] = max_img_size;
	variable_array['empty_input_error_msg'] = 'Please select the thumbnail image';
	variable_array['exceeding_max_length_error_msg'] = 'Thumbnail image should be of max 1MB';
	return single_file_upload_for_only_image(variable_array);
}

function handle_file_select_banner_image(e) {
	banner_image_array = [];
	var variable_array = {};
	variable_array['e'] = e;
	variable_array['file_id'] = '#banner-image';
	variable_array['show_image_name_msg_div_id'] = '#banner-image-error-msg-div';
	variable_array['storedFiles_array'] = banner_image_array;
	variable_array['col_type'] = 'col-md-12 mt-3';
	variable_array['file_ui_id'] = 'file_banner_image';
	variable_array['file_size'] = max_img_size;
	variable_array['empty_input_error_msg'] = 'Please select the banner image';
	variable_array['exceeding_max_length_error_msg'] = 'Banner image should be of max 1MB';
	return single_file_upload_for_only_image(variable_array);
}

function handle_file_select_service_icon(e) {
	service_icon_array = [];
	var variable_array = {};
	variable_array['e'] = e;
	variable_array['file_id'] = '#service-icon';
	variable_array['show_image_name_msg_div_id'] = '#service-icon-error-msg-div';
	variable_array['storedFiles_array'] = service_icon_array;
	variable_array['col_type'] = 'col-md-12 mt-3';
	variable_array['file_ui_id'] = 'file_service_icon';
	variable_array['file_size'] = max_img_size;
	variable_array['empty_input_error_msg'] = 'Please select the service icon';
	variable_array['exceeding_max_length_error_msg'] = 'Service icon should be of max 1MB';
	return single_file_upload_for_only_image(variable_array);
}

function handle_file_select_service_benefits(e) {
	var variable_array = {};
	variable_array['e'] = e;
	variable_array['file_id'] = '#service-benefits';
	variable_array['storedFiles_array'] = service_benefits_images_array;
	variable_array['col_type'] = 'col-md-12';
	variable_array['file_ui_id'] = 'service-benefits-image-div';
	variable_array['max_img_size'] = max_img_size;
	variable_array['empty_input_error_msg'] = 'Please select images';
	variable_array['show_image_id'] = '#service-benefits-error-msg-div';
	variable_array['image_max_size_exceeding_error_msg'] = 'Image should be of max 1 Mb.';
	variable_array['remove_image_function_name'] = 'remove_selected_service_benefits_image';
	variable_array['image_input_id'] = 'service-benefits-description';
	variable_array['image_input_error_msg_div_id'] = 'service-benefits-description-error-msg-div';
	variable_array['input_function_name'] = 'check_service_benefits_description';
	variable_array['input_placeholder'] = 'Enter service description';
	variable_array['input_hidden_class_name'] = 'service-benefits-input-i';
	variable_array['input_class_name'] = 'service-benefits-input';
	variable_array['sorting_id'] = 'service_benefits_image_sort';
	variable_array['sorting_class'] = 'service-benefits-image-sorting-ui';
	variable_array['allowed_file_extensions'] = ['svg'];
	return multiple_file_upload_single_image_with_input_and_valid_file_extensions(variable_array);
}

$('#service-benefits-error-msg-div').sortable({ tolerance: 'pointer' });

function check_service_benefits_description(i) {
	var variable_array = {};
	variable_array['input_id'] = '#service-benefits-description-'+i;
	variable_array['error_msg_div_id'] = '#service-benefits-description-error-msg-div-'+i;
	variable_array['empty_input_error_msg'] = 'Please enter the service benefit description';
	variable_array['exceeding_max_length_input_error_msg'] = 'Service benefit description should be of max '+service_benefit_description_max_length+' characters';
	variable_array['max_length'] = service_benefit_description_max_length;
	return mandatory_any_input_with_max_length_limitation(variable_array);
}

function add_new_service() {
	var service_name = $('#service-name').val(),
		very_short_description = CKEDITOR.instances['very_short_description'].getData(),
		short_description = CKEDITOR.instances['short_description'].getData(),
		long_description = CKEDITOR.instances['long_description'].getData(),
		service_included_description = CKEDITOR.instances['service_included_description'].getData(),
		maximum_checks = $('#maximum-checks').val(),
		thumbnail_image = $("#thumbnail-image")[0].files[0],
		service_icon = $("#service-icon")[0].files[0],
		banner_image = $("#banner-image")[0].files[0];

	var check_service_name_var = check_service_name(),
		check_maximum_checks_var = check_maximum_checks(),
		check_checked_components_var = check_checked_components();

	var add_service_benefits_images_counter = 0,
		add_service_benefits_image_input_counter = 0,
		service_benefits_image_input_counter = 0,
		service_benefits_image_input_array = [];

	if(service_benefits_images_array != '' && service_benefits_images_array.length > 0) {
		var service_benefits_image_input_i_array = [];
		$('.gallery-image-input-i').each(function(i) {
	    	service_benefits_image_input_i_array[i] = $(this).val();
	   	});
	   	
	   	if (service_benefits_image_input_i_array.length > 0) {
		   	for (var i = 0; i < service_benefits_image_input_i_array.length; i++) {
		   		var check_service_benefits_description_var = check_service_benefits_description(service_benefits_image_input_i_array[i]);
		   		if (check_service_benefits_description_var == 0) {
		   			service_benefits_image_input_counter++;
		   		}
		   	}
		}

	   	if(service_benefits_image_input_counter == 0) {
	   		add_service_benefits_image_input_counter++;
			add_service_benefits_images_counter++;
	   	}
	}

	var service_benefits_image_sorting_ids = [];
  	$('ul.service-benefits-image-sorting-ui').each(function (index) { 
    	var id = $(this).attr('data-sorting_id');
    	service_benefits_image_sorting_ids.push(id); 
  	});

	if (check_service_name_var == 1 && check_maximum_checks_var == 1 && check_checked_components_var == 1 && very_short_description != ''
		&& short_description != '' && long_description != '' && service_included_description != '' 
		&& thumbnail_image != undefined && banner_image != undefined && service_icon != undefined && add_service_benefits_image_input_counter != 0) {

		$('#short-description-error-msg-div').html('');
		$('#long-description-error-msg-div').html('');
		$('#service-included-description-error-msg-div').html('');

   		$('#service-submit-btn').prop('disabled',true);
		$('#new-service-error-msg-div').html('<span class="text-warning error-msg">Please wait while we are adding new service.</span>');

		var selected_component = [];
		$('input[name="component-name[]"]:checked').each(function(i) {
    		selected_component[i] = $(this).val();
   		});
   		
   		var is_self_check = 0;
   		if ($('#is-self-check-available:checked').val() == 1) {
   			is_self_check = 1;
   		}

		var formdata = new FormData();
		formdata.append('verify_admin_request',1);
		formdata.append('service_name',service_name);
		formdata.append('is_self_check',is_self_check);
		formdata.append('very_short_description',very_short_description);
		formdata.append('short_description',short_description);
		formdata.append('long_description',long_description);
		formdata.append('service_included_description',service_included_description);
		formdata.append('selected_component',selected_component);
		formdata.append('maximum_checks',maximum_checks);
		formdata.append('thumbnail_image',thumbnail_image);
		formdata.append('service_icon',service_icon);
		formdata.append('banner_image',banner_image);

		for(var i = 0; i <= service_benefits_images_array.length; i++) {
			formdata.append('service_benefits[]', service_benefits_images_array[i]);
		}

		$('.service-benefits-input').each(function(i) {
	    	service_benefits_image_input_array.push($(this).val());
	   	});
	   	
	   	formdata.append('service_benefits_image_input', service_benefits_image_input_array);
	   	formdata.append('service_benefits_image_sorting_ids', service_benefits_image_sorting_ids);

		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-admin/add-new-service",
		  	data:formdata,
		  	dataType: 'json',
		    contentType: false,
		    processData: false,
		  	success: function(data) {
		  		if (data.status == 1) {
			  		$('#service-submit-btn').prop('disabled',false);
					$('#new-service-error-msg-div').html('');
				  	if (data.service_details.status == '1') {
				  		toastr.success('New service has been added successfully.');
						$('#service-name').val('');

						CKEDITOR.instances['very_short_description'].setData('');
						CKEDITOR.instances['short_description'].setData('');
						CKEDITOR.instances['long_description'].setData('');
						CKEDITOR.instances['service_included_description'].setData('');
						
						$('.checked-components').prop('checked', false);
						$('#is-self-check-available').prop('checked', false);
						$('#maximum-checks').val('');
						$("#thumbnail-image").val('');
						$("#service-icon").val('');
						$("#banner-image").val('');

						$('#thumbnail-image-error-msg-div').html('&nbsp;');
						$('#banner-image-error-msg-div').html('&nbsp;');
						$('#service-icon-error-msg-div').html('');
						$('#service-benefits-error-msg-div').html('');
						
						thumbnail_image_array = [];
						banner_image_array = [];
						service_icon_array = [];
						service_benefits_images_array = [];
				  	} else {
				  		toastr.error('Something went wrong while adding the service. Please try again.');
			  		}
			  	} else if (data.status == 2) {
			  		$('#new-service-error-msg-div').html('<span class="text-danger error-msg-small">Entered service name already exists. Please enter a new service.</span>');
			  	} else {
			  		check_admin_login();
			  	}
		  	},
		  	error: function(data) {
		  		$('#service-submit-btn').prop('disabled',false);
				$('#new-service-error-msg-div').html('');
		  		toastr.error('Something went wrong while adding the service logo. Please try again.');
		  	}
		});
	} else {
		$('#new-service-error-msg-div').html('<span class="text-danger error-msg">Please fill all the required details correctly.</span>');

		if (very_short_description == '') {
			$('#very-short-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the very short description.</span>');
		} else {
			$('#very-short-description-error-msg-div').html('');
		}

		if (short_description == '') {
			$('#short-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the short description.</span>');
		} else {
			$('#short-description-error-msg-div').html('');
		}

		if (long_description == '') {
			$('#long-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the long description.</span>');
		} else {
			$('#long-description-error-msg-div').html('');
		}

		if (service_included_description == '') {
			$('#service-included-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the service included description.</span>');
		} else {
			$('#service-included-description-error-msg-div').html('');
		}

		if (thumbnail_image == undefined) {
			$('#thumbnail-image-error-msg-div').html('<span class="text-danger error-msg-small">Please select the thumbnail image.</span>');
		}

		if (banner_image == undefined) {
			$('#banner-image-error-msg-div').html('<span class="text-danger error-msg-small">Please select the banner image.</span>');
		}
	}
}