$('#update-service-sort-btn').on('click', function() {
	update_service_sort();
});

get_all_services();
function get_all_services() {
	$.ajax({
        type  : 'POST',
        url   : base_url+'factsuite-admin/get-all-services',
        data : {
        	verify_admin_request : '1'
        },
        dataType : 'json',
        success : function(data) {
	        if (data.status == '1') {
	         	if (data.services_list.length > 0) {
	         		var html = '';
	         		for (var i = 0; i < data.services_list.length; i++) {
	         			var check ='';
				        if (data.services_list[i].status == '1') {
				        	check ='checked';
				        } else {
				            check ='';
				       	}

		        		html += '<div class="col-md-4 mt-3 service-main-div" id="service-div-'+data.services_list[i].service_id+'" data-service_sorting_id="'+data.services_list[i].service_id+'">';
		                html += '<div class="product-category-description">';
		                html += '<ul>';
		                html += '<li class="product-category-name" id="service-name-li-'+data.services_list[i].service_id+'">'+data.services_list[i].name+'</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<div class="custom-control custom-switch pl-0">';
					    html += '<input type="checkbox" '+check+' onclick="change_service_status('+data.services_list[i].service_id+','+data.services_list[i].status+')" class="custom-control-input" id="change_service_status_'+data.services_list[i].service_id+'">';
					    html += '<label class="custom-control-label" for="change_service_status_'+data.services_list[i].service_id+'"></label>';
					    html += '</div>';
		                html += '</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<a class="product-category-delete-a" id="view_service_'+data.services_list[i].service_id+'" onclick="view_service_modal('+data.services_list[i].service_id+')"><i class="fa fa-eye edit-a"></i></a>';
		                html += '</li>';
		                html += '<li class="product-category-edit-delete">';
		                html += '<a class="product-category-delete-a" id="delete_service_'+data.services_list[i].service_id+'" onclick="delete_service_modal('+data.services_list[i].service_id+')" data-service_name="'+data.services_list[i].name+'"><i class="fa fa-trash edit-a text-danger"></i></a>';
		                html += '</li>';
		                html += '</ul>';
		                html += '</div>';
		                html += '</div>';
	         		}
	         	} else {
	         		html = '<div class="col-md-12 text-center">No Services Available</div>';
	         	}
	         	$('#all-services-list').html(html);
	        } else {
	        	check_admin_login();
	        }
	    }
    });
}

$('#all-services-list').sortable({ tolerance: 'pointer' });

function change_service_status(service_id,status) {
	var changed_status = 0;

	if (status == 1) {
		changed_status = 0;
	} else if (status == 0) {
		changed_status = 1;
	} else {
		get_all_services();
		toastr.error('OOPS! Something went wrong. Please try again.')
		return false;
	}

	var variable_array = {};
	variable_array['id'] = service_id;
	variable_array['actual_status'] = status;
	variable_array['changed_status'] = changed_status;
	variable_array['ajax_call_url'] = 'factsuite-admin/change-factsuite-website-service-status';
	variable_array['checkbox_id'] = '#change_service_status_'+service_id;
	variable_array['onclick_method_name'] = 'change_service_status';
	variable_array['success_message'] = 'Service status has been updated successfully.';
	variable_array['error_message'] = 'Something went wrong updating the service status. Please try again.';
	variable_array['error_callback_function'] = 'get_all_services()';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : service_id, changed_status : changed_status};

	return change_status(variable_array);
}

function delete_service_modal(service_id) {
	$('#delete-service-name-hdr-span').html($('#delete_service_'+service_id).attr('data-service_name')+ ' service');
	$('#delete-service-btn').attr('onclick','delete_service('+service_id+')');
	$('#delete-service-modal').modal('show');
}

function delete_service(service_id) {
	var variable_array = {};
	variable_array['id'] = service_id;
	variable_array['ajax_call_url'] = 'factsuite-admin/delete-factsuite-website-service';
	variable_array['onclick_method_name'] = 'delete_service';
	variable_array['success_message'] = 'Service has been deleted successfully.';
	variable_array['error_message'] = 'Something went wrong deleting the service. Please try again.';
	variable_array['modal_id'] = '#delete-service-modal';
	variable_array['delete_image_div_id'] = '#service-div-'+service_id;
	variable_array['delete_btn_id'] = '#delete-service-btn';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, service_id : service_id};
	return delete_uploaded_image(variable_array);
}

function view_service_modal(service_id) {
	$.ajax({
		type: "POST",
    	url: base_url+"factsuite-admin/get-single-factsuite-website-service",
    	dataType: "json",
    	data : {
    		verify_admin_request : 1,
    		service_id : service_id
    	},
    	success: function(data) {
			if (data.status == 1) {
				$('#modal-edit-service-id').val(service_id);
				$('#service-name').val(data.service_details.name);
				var is_self_check = false;
				if (data.service_details.service_for_self_check_status == 1) {
					is_self_check = true;
				}
				$('#is-self-check-available').prop('checked',is_self_check);
				// $('#is-self-check-available').val(data.service_details.service_for_self_check_status);
				
				CKEDITOR.instances['very_short_description'].setData(data.service_details.very_short_description);
				CKEDITOR.instances['short_description'].setData(data.service_details.short_description);
				CKEDITOR.instances['long_description'].setData(data.service_details.description);
				CKEDITOR.instances['service_included_description'].setData(data.service_details.services_included_description);

				var component_list_array = data.service_details.component_list.split(',');
				var component_list_html = '';
				for (var i = 0; i < data.component_list.length; i++) {
					var check = '';
					for (var j = 0; j < component_list_array.length; j++) {
						if (data.component_list[i].component_id == component_list_array[j]) {
							check = 'checked';
						}
					}
					component_list_html += '<div class="col-md-4">';
                  	component_list_html += '<div class="custom-control custom-checkbox custom-control-inline">';
                    component_list_html += '<input type="checkbox" '+check+' class="custom-control-input checked-components" value="'+data.component_list[i].component_id+'" name="component-name[]" id="component-'+data.component_list[i].component_id+'" onclick="check_checked_components()">';
                    component_list_html += '<label class="custom-control-label" for="component-'+data.component_list[i].component_id+'">'+data.component_list[i].component_name+'</label>';
                  	component_list_html += '</div>';
                	component_list_html += '</div>';
				}
				$('#components-list-div').html(component_list_html);

				$('#maximum-checks').val(data.service_details.maximum_checks);

				var thumbnail_image_html = '<div class="col-md-12 mt-3" id="service-thumbnail-image-div">';
                thumbnail_image_html += '<div class="image-selected-div">';
                thumbnail_image_html += '<ul>';
                thumbnail_image_html += '<li class="image-selected-name">'+data.service_details.thumbnail_image+'</li>';
                thumbnail_image_html += '<li class="image-name-delete">';
                thumbnail_image_html += '<a class="product-category-delete-a" id="view_service_thumbnail_image" onclick="view_service_thumbnail_image_modal()" data-image="'+data.service_details.thumbnail_image+'"><i class="fa fa-eye edit-a"></i></a>';
                thumbnail_image_html += '</li>';
                thumbnail_image_html += '</ul>';
                thumbnail_image_html += '</div>';
                thumbnail_image_html += '</div>';

                $('#thumbnail-image-error-msg-div').html(thumbnail_image_html);

                var banner_image_html = '<div class="col-md-12 mt-3" id="service-thumbnail-image-div">';
                banner_image_html += '<div class="image-selected-div">';
                banner_image_html += '<ul>';
                banner_image_html += '<li class="image-selected-name">'+data.service_details.banner_image+'</li>';
                banner_image_html += '<li class="image-name-delete">';
                banner_image_html += '<a class="product-category-delete-a" id="view_service_banner_image" onclick="view_service_banner_image_modal()" data-image="'+data.service_details.banner_image+'"><i class="fa fa-eye edit-a"></i></a>';
                banner_image_html += '</li>';
                banner_image_html += '</ul>';
                banner_image_html += '</div>';
                banner_image_html += '</div>';

                $('#banner-image-error-msg-div').html(banner_image_html);

                var service_icon_html = '<div class="col-md-12 mt-3" id="service-icon-div">';
                service_icon_html += '<div class="image-selected-div">';
                service_icon_html += '<ul>';
                service_icon_html += '<li class="image-selected-name">'+data.service_details.service_icon+'</li>';
                service_icon_html += '<li class="image-name-delete">';
                service_icon_html += '<a class="product-category-delete-a" id="view_service_icon" onclick="view_service_icon_modal()" data-image="'+data.service_details.service_icon+'"><i class="fa fa-eye edit-a"></i></a>';
                service_icon_html += '</li>';
                service_icon_html += '</ul>';
                service_icon_html += '</div>';
                service_icon_html += '</div>';

                $('#service-icon-error-msg-div').html(service_icon_html);

				$('#show-service-benefits-images-ui-div').empty();
				
				if (data.service_details.service_benefits != '' && data.service_details.service_benefits != null) {
					var i = 0;
					$.each(JSON.parse(data.service_details.service_benefits), function(index,value) {
						var html = '<div class="col-md-4" id="service-benefit-image-div-'+i+'">';
			            html += '<div class="row">';
			            html += '<div class="col-md-12 mt-3">';
			           	html += '<div class="image-selected-div">';
			           	html += '<ul class="product-service-benefit-image-sorting-ui" data-sorting_id="'+i+'">';
			            html += '<li class="image-selected-name" id="service-benefit-name-li-'+i+'">'+value.service_benefit_image+'</li>';
			            html += '<li class="product-category-edit-delete pb-0">';
	          			html += '<a class="product-category-delete-a" id="view-service-benefit-image-'+i+'" onclick="view_service_benefit_image_modal('+i+')" data-service_benefit_image_name="'+value.service_benefit_image+'"><i class="fa fa-eye edit-a"></i></a>';
	          			html += '</li>';
			            html += '<li class="product-category-edit-delete pb-0">';
			            html += '<a id="delete-product-service-benefit-image-'+i+'" onclick="delete_service_benefit_image_modal('+i+')" data-service_benefit_image_name="'+value.service_benefit_image+'" class="image-name-delete-a"><i class="fa fa-trash edit-a text-danger"></i></a>';
			            html += '</li>';
			            html += '</ul>';
			            html += '</div>';
			            html += '</div>';
			            html += '<div class="col-md-12 mt-2">';
			           	html += '<input type="hidden" class="input-txt added-service-benefit-image-input-i" id="added-service-benefit-image-input-i-'+i+'" value="'+i+'">';
			           	html += '<input type="text" class="form-control fld added-service-benefit-image-input" id="added-service-benefit-description-'+i+'" name="added-product-service-benefit-description-'+i+'" onkeyup="check_added_product_gallery_description('+i+')" onblur="check_added_product_gallery_description('+i+')" placeholder="Enter service benefit description" value="'+value.service_benefit_image_desc+'">';
			            html += '<div id="added-service-benefit-description-error-msg-div-'+i+'"></div>';
			            html += '</div>';
			            html += '</div>';
			            html += '</div>';
			            i++;
						$('#show-service-benefits-images-ui-div').append(html);
					});
				}

				$('#edit-service-btn').attr('onclick','update_service('+service_id+')');

				$('#edit-service-modal').modal('show');
			} else {
				check_admin_login();
			}
		}     	
	});
}

function view_service_thumbnail_image_modal() {
	$('#show-img-hdr').html('Thumbnail Image');
 	$('#show-image-modal-img').attr('src',img_base_url+'../uploads/factsuite-website-thumbnail-image/'+$('#view_service_thumbnail_image').data('image'));
 	$('#view-service-images-modal').modal('show');
}

function view_service_banner_image_modal() {
	$('#show-img-hdr').html('Banner Image');
 	$('#show-image-modal-img').attr('src',img_base_url+'../uploads/factsuite-website-banner-image/'+$('#view_service_banner_image').data('image'));
 	$('#view-service-images-modal').modal('show');
}

function view_service_icon_modal() {
	$('#show-img-hdr').html('Service Icon');
 	$('#show-image-modal-img').attr('src',img_base_url+'../uploads/factsuite-website-service-icon/'+$('#view_service_icon').data('image'));
 	$('#view-service-images-modal').modal('show');
}

function view_service_benefit_image_modal(i) {
	$('#show-img-hdr').html('Service Benefit Image');
 	$('#show-image-modal-img').attr('src',img_base_url+'../uploads/factsuite-website-service-benefits-image/'+$('#view-service-benefit-image-'+i).data('service_benefit_image_name'));
 	$('#view-service-images-modal').modal('show');
}

function delete_service_benefit_image_modal(i) {
	$('#delete-service-name-hdr-span').html('Service Benefit');
	$('#delete-service-btn').attr('onclick','delete_service_benefit_image('+i+')');
	$('#delete-service-modal').modal('show');
}

function delete_service_benefit_image(i) {
	var variable_array = {};
	variable_array['id'] = i;
	variable_array['ajax_call_url'] = 'factsuite-admin/delete-factsuite-service-benefit';
	variable_array['onclick_method_name'] = 'delete_service_benefit_image';
	variable_array['success_message'] = 'Service benefit has been deleted successfully.';
	variable_array['error_message'] = 'Something went wrong deleting the service benefit. Please try again.';
	variable_array['modal_id'] = '#delete-service-modal';
	variable_array['delete_image_div_id'] = '#service-benefit-image-div-'+i;
	variable_array['delete_btn_id'] = '#delete-service-btn';
	variable_array['ajax_pass_data'] = {verify_admin_request : 1, service_benefit_i : i, image_name : $('#delete-product-service-benefit-image-'+i).data('service_benefit_image_name'), service_id : $('#modal-edit-service-id').val()};
	return delete_uploaded_image(variable_array);
}

$('#show-service-benefits-images-ui-div').sortable({ tolerance: 'pointer' });

function update_service_sort() {
	var service_sorting_ids = [];
	$('.service-main-div').each(function (index) { 
    	service_sorting_ids.push($(this).attr('data-service_sorting_id'));
  	});

  	$.ajax({
      	type: "POST",
      	url: base_url+'factsuite-admin/update-factsuite-website-service-sorting',
      	data: {
      		verify_admin_request : 1,
      		service_sorting_ids : service_sorting_ids
      	},
      	dataType:'json',
      	success: function(data) {
      		if (data.status == 1) {
      			if (data.product_sort.status == 1) {
        			toastr.success('Service order has been updated successfully.');
      			} else {
      				toastr.error('Something went wrong while sorting the service. Please try again');
      			}
      		} else {
      			check_admin_login();
      		}
      	}
    });
}