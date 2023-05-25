var form_fields_list = [];

$('#client_id').on('change', function() {
	get_selected_email_templates($('#client_id').val());
});

$('#templates').on('change', function() {
	get_client_list();
	$("#client-template-div").show();
	var myarray = [
		'Request Addition/ Deletion of Client',
		'Accept / Reject Addition/ Deletion of Client',
		'Request Client rate creation/ change',
		'Accept / Reject Client rate creation/ change',
		'Request Additional Verification Fee',
		'Accept / Reject Additional Verification Fee',
		'Request Addition/ Deletion of CRM users',
		'Accept / Reject Addition/ Deletion of CRM users'
		];
	if(jQuery.inArray($(this).val(), myarray) !== -1){
		$("#client-template-div").hide();
	}
});

get_email_templates();
function get_email_templates() {
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-email-templates',
	    dataType: 'JSON',
	    data: {
	    	verify_admin_request : 1
	    },
	    success:function(data) {
	    	var form_fields_list_html = '<option value="">Select Your Template</option>';
	  		if (data.length > 0) {
	  			for (var i = 0; i < data.length; i++) {
	  				var value = data[i].template_name;
	  				if (data[i].id == 6 || data[i].id == 7) {
	  					var value = data[i].id;
	  				}
	  				form_fields_list_html += '<option value="'+value+'">'+data[i].template_name+'</option>';
	  			}
	  		}
	      	$('#templates').html(form_fields_list_html);
	    }
  	});
}

function get_client_list() {
	CKEDITOR.instances['email-form'].setData('');
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-clients-for-email-templates',
	    dataType: 'JSON',
	    data: {
	    	verify_admin_request : 1,
	    	selected_template : $('#templates').val()
	    },
	    success:function(data) {
	    	var client_list_html = '<option value="">Select Your Client</option>',
	    		client_list = data.all_clients;
	  		if (client_list.length > 0) {
	  			client_list_html += '<option value="0">ALL</option>';
	  			for (var i = 0; i < client_list.length; i++) {
	  				client_list_html += '<option value="'+client_list[i].client_id+'">'+client_list[i].client_name+'</option>';
	  			}
	  		}
	      	$('#client_id').html(client_list_html);
	    }
  	});
}

get_form_fields();
function get_form_fields() {
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-form-fields',
	    dataType: 'JSON',
	    async: false,
	    data: {
	    	verify_admin_request : 1
	    },
	    success:function(data) {
	    	var form_fields_list_html = '';
	  		if (data.length > 0) {
	  			form_fields_list = data;
	  			for (var i = 0; i < data.length; i++) {
	  				form_fields_list_html += '<div class="col-md-4 custom-col-1">';
	  				form_fields_list_html += '<span class="form-field-span">@'+data[i].show_field_name+'</span>';
	  				form_fields_list_html += '</div>';
	  			}
	  		}
	      	$('#form-field-details').html(form_fields_list_html);
	    }
  	});
}

CKEDITOR.replace('email-form', {
    plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastefromgdocs, pastefromlibreoffice, pastefromword',
    contentsCss: [
        'http://cdn.ckeditor.com/4.20.1/full-all/contents.css',
        'https://ckeditor.com/docs/ckeditor4/4.20.1/examples/assets/mentions/contents.css'
    ],
    height: 200,
    toolbar: [{
        name: 'document',
        items: ['Undo', 'Redo']
    },
    {
       	name: 'basicstyles',
        items: ['Bold', 'Italic', 'Strike']
    },
    {
       	name: 'links',
        items: ['EmojiPanel', 'Link', 'Unlink']
    },],
    mentions: [{
        feed: dataFeed,
        itemTemplate: '<li data-id="{id}">' +
            '<strong class="show_field_name">@{show_field_name}</strong>' +
            // '<span class="show_field_name">{show_field_name}</span>' +
            '</li>',
        outputTemplate: '@{show_field_name}<span>&nbsp;</span>',
        minChars: 0
    }],
    removeButtons: 'PasteFromWord'
});

function dataFeed(opts, callback) {
    var matchProperty = 'show_field_name',
        data = form_fields_list.filter(function(item) {
          	return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
        });

      	data = data.sort(function(a, b) {
        	return a[matchProperty].localeCompare(b[matchProperty], undefined, {
          		sensitivity: 'accent'
        	});
      	});
    callback(data);
}

function get_form_field(id) {
	var consent = CKEDITOR.instances['email-form'].getData().replace(/(<([^>]+)>)/ig,"");
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-form-fields',
	    dataType: 'JSON',
	    data: {
	    	verify_admin_request : 1
	    },
	    success:function(data) {
	  		if (data.length > 0) {
	  			for (var i = 0; i < data.length; i++) {
	  				if (data[i].id == id) {
	  					consent += data[i].show_field_name+'&nbsp;';
	  					break;
	  				}
	  			}
	  		}
	  		CKEDITOR.instances['email-form'].setData(consent);
	  		$('#email-form').focus();
	    }
  	});
}

// getTatData();
// $("#client_id").trigger('change');
function get_selected_email_templates(client_id) {
	CKEDITOR.instances['email-form'].setData(''); 
	$("#selected-vendor-docs-li").html('');
	if (client_id == '') {
		client_id = $("#client_id").val();
	}
	var templates = $("#templates").val();
	if (templates == '6' && client_id != 0 && client_id != '') {
		get_selected_insuff_email_template_for_client();
	} else if (templates == '7' && client_id != 0 && client_id != '') {
		get_selected_insuff_email_template_for_client();
	} else {
		$.ajax({
			type:'POST',
			dataType:'json',
			url:base_url+"client/get_templates",
			data:{
				client_id : client_id,
				templates : templates,
			},
			success:function(data) {  
				CKEDITOR.instances['email-form'].setData(data.template_content);

				if (data.additional ==1) { 
					$(".change_client_additional").prop("checked", true);
				}
			} 
		});
	}
}

function get_selected_insuff_email_template_for_client() {
	if ($("#templates").val() == '6') {
		$.ajax({
		    type:'POST',
		    url: base_url+'Client/get_selected_insuff_email_template_for_client',
		    dataType: 'JSON',
		    data: {
		    	verify_admin_request : 1,
		    	client_id : client_id
		    },
		    success:function(data) {
		    	console.log(data);
				// CKEDITOR.instances['email-form'].setData('');
				if (data.client_template != '') {
					CKEDITOR.instances['email-form'].setData(data.client_template.template);
				}
		    }
	  	});
		// $.ajax({
		// 	type:'POST',
		// 	dataType:'json',
		// 	url:base_url+"factsuite-admin/get-selected-insuff-email-template-for-client",
		// 	data: {
		// 		client_id : client_id
		// 	},
		// 	success:function(data) {
		// 		console.log(data);
		// 		CKEDITOR.instances['email-form'].setData('');
		// 		if (data.client_template != '') {
		// 			CKEDITOR.instances['email-form'].setData(data.client_template.template);
		// 		}
		// 	} 
		// });
	}
}

function get_selected_insuff_email_template_to_client() {
	$.ajax({
		type:'POST',
		dataType:'json',
		url:base_url+"client/get_templates",
		data:{
			client_id : $("#client_id").val(),
			templates : $("#templates").val(),
		},
		success:function(data) {  
			CKEDITOR.instances['email-form'].setData(data.template_content);

			if (data.additional ==1) { 
				$(".change_client_additional").prop("checked", true);
			}
		} 
	});
}

function confirmationDailg() {
	var templates = $("#templates").val();
	var client_id = $("#client_id").val();
	var form = CKEDITOR.instances['email-form'].getData();
	// alert(form);
	// console.log(form);
	// return false;
	var formdata = new FormData();
		formdata.append('client_id',client_id);
		formdata.append('form',form);
		formdata.append('templates',templates); 

	if(client_id != '') {
		$.ajax({
			type: "POST",
	  		url: base_url+"Client/add_templates",
	  		data:formdata,
      		dataType: 'json',
      		contentType: false,
      		processData: false, 
	  		success: function(data) {
	   			$('#add_holiday').modal('hide'); 	
	        	if (data.status == '1') {
	        		$("#templates").val('')
	        		$("#client_id").val('')
	        		CKEDITOR.instances['email-form'].setData('');  
		        	// $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        	toastr.success('Email Template Data is Updated.');
				} else {
		        	toastr.error('Something went wrong with inserting the data. Please try again.');
				}
	    	},
	    	error: function(data) {
	       		$('#edit_component').modal('hide'); 	
	    		toastr.error('Something went wrong with inserting the data. Please try again.');
	    	} 
	  	});
	} else {
		if(client_id != '') {
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the details.</span>');
		}
	}
}