var component_icon_array= [],
		max_img_size = 10000000;

load_component();

$("#component-icon").on("change", handle_file_select_component_icon);

$('#component_name').on('keyup blur',function(){
	var component_name = $('#component_name').val(); 
	if (component_name != '') {
		$('#component-name-error-msg-div').html('');
	} else {
		$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#edit_fs_website_component_name').on('keyup blur',function(){
	var component_name = $('#edit_fs_website_component_name').val(); 
	if (component_name != '') {
		$('#edit-fs-website-component-name-error-msg-div').html('');
	} else {
		$('#edit-fs-website-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the FS website component name.</span>');
	}
}); 

$('#component_price').on('keyup blur',function(){
	var component_price = $('#component_price').val(); 
	if (component_price != '') {
		$('#component-price-error-msg-div').html('');
	} else {
		$('#component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 


$('#edit_component_name').on('keyup blur',function(){
	var edit_component_name = $('#edit_component_name').val(); 
	if (edit_component_name != '') {
		$('#edit-component-name-error-msg-div').html('');
	} else {
		$('#edit-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#edit_component_price').on('keyup blur',function(){
	var edit_component_price = $('#edit_component_price').val(); 
	if (edit_component_price != '') {
		$('#edit-component-price-error-msg-div').html('');
	} else {
		$('#edit-component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 

function handle_file_select_component_icon(e) {
	banner_image_array = [];
	var variable_array = {};
	variable_array['e'] = e;
	variable_array['file_id'] = '#component-icon';
	variable_array['show_image_name_msg_div_id'] = '#component-icon-error-msg-div';
	variable_array['storedFiles_array'] = component_icon_array;
	variable_array['col_type'] = 'col-md-12 mt-3 px-0';
	variable_array['file_ui_id'] = 'file_component_icon';
	variable_array['file_size'] = max_img_size;
	variable_array['empty_input_error_msg'] = '';
	variable_array['exceeding_max_length_error_msg'] = 'Component icon should be of max 1MB';
	return single_file_upload_for_only_image(variable_array);
}

function load_component(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"component/get_component_details", 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i][show_component_name]+'</td>';
        	html += '<td>'+data[i]['component_standard_price']+'</td>';
        	html += '<td>'+data[i]['form_threshold']+'</td>';
        	if(data[i]['component_status'] == 1){
        		html += '<td>Activate</td>';
        	}else{
        		html += '<td>Deactivate</td>';
        	}
        	// <a class="d-none"onclick="removeData('+data[i]['component_id']+')" href="#"><img src="assets/admin/images/delete.png" /></a>
        	html += '<td class="d-none"><a  onclick="edit_store('+data[i]['component_id']+')"  href="#"><i class="fa fa-pencil"></i></a></div></td>';
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

function edit_store(id){
  $('#edit_component').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"component/get_component_details/"+id, 
    dataType: "json",
    success: function(data){
      // console.log(JSON.stringify(data));
      $("#component-icon").val('');

        var edit_component_id = $('#edit_component_id').val(data.component_id);
        var edit_component_name = $('#edit_component_name').val(data.component_name);
        $('#edit_fs_website_component_name').val(data.fs_website_component_name);
        
        var edit_component_price = $('#edit_component_price').val(data.component_standard_price);
        var edit_component_form_threshold = $('#edit_component_form_threshold').val(data.form_threshold); 
        CKEDITOR.instances['edit_component_short_description'].setData(data.component_short_description);

        var icon_html = '<div class="col-md-12 mt-3 px-0" id="component-icon-div">';
        icon_html += '<div class="image-selected-div">';
        icon_html += '<ul>';
        icon_html += '<li class="image-selected-name">'+data.component_icon+'</li>';
        icon_html += '<li class="image-name-delete">';
        icon_html += '<a class="product-category-delete-a" id="view-component-icon-'+data.component_id+'" onclick="view_component_icon('+data.component_id+')" data-image="'+data.component_icon+'"><i class="fa fa-eye edit-a"></i></a>';
        icon_html += '</li>';
        icon_html += '</ul>';
        icon_html += '</div>';
        icon_html += '</div>';

        $('#component-icon-error-msg-div').html(icon_html);
       
    }
  });
}

function updateData(){
	var edit_component_id = $('#edit_component_id').val();
	var component_name = $('#edit_component_name').val();
	var fs_website_component_name = $('#edit_fs_website_component_name').val();
	var component_price = $('#edit_component_price').val();
	var form_threshold = $('#edit_component_form_threshold').val();
	var component_short_description = CKEDITOR.instances['edit_component_short_description'].getData();
	var component_icon = $("#component-icon")[0].files[0];
	// alert(component_name +" : "+ component_price + " : "+ edit_component_id);
	if(component_name != '' && component_price != '' && component_short_description != '' && fs_website_component_name != '') {
		var formdata = new FormData();
		formdata.append('edit_component_id',edit_component_id);
		formdata.append('component_name',component_name);
		formdata.append('fs_website_component_name',fs_website_component_name);
		formdata.append('component_price',component_price);
		formdata.append('form_threshold',form_threshold);
		formdata.append('component_short_description',component_short_description);
		if (component_icon != undefined) {
			formdata.append('component_icon',component_icon);
		}
		$('#edit-component-short-description-error-msg-div').html('');
		$.ajax({
	    type: "POST",
	    url: base_url+"component/update_component", 
	    data:formdata,
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Component updated successfully.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(component_name == ''){
			// alert("Name Null")
			$('#edit-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
		}

		if(fs_website_component_name == ''){
			// alert("Name Null")
			$('#edit-fs-website-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
		}

		if(component_price == ''){
			// alert("Price Null")
			$('#edit-component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
		}

		if (component_short_description == '') {
			$('#edit-component-short-description-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component description.</span>');
		} else {
			$('#edit-component-short-description-error-msg-div').html('');
		}
	}
	
}

function view_component_icon(component_id) {
	$.ajax({
    type: "POST",
    url: base_url+"component/get_component_details/"+component_id, 
    dataType: "json",
    success: function(data) {
      $('#show-image-modal-img').attr('src',img_base_url+'../uploads/component-icon/'+data.component_icon);
      $('#view-component-image-modal').modal('show'); 
    }
  });
}

function saveData(){
	var component_name = $('#component_name').val();
	var component_price = $('#component_price').val();
	// alert(component_name +" : "+ component_price );
	if(component_name != '' && component_price != ''){
		var formdata = new FormData();
		formdata.append('component_name',component_name);
		formdata.append('component_price',component_price);
		$.ajax({
	    type: "POST",
	    url: base_url+"component/insert_component", 
	    data:formdata,
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#add_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Component inserted successfully.');
			} else {
		         
		        toastr.error('Something went wrong with saveing the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#add_component').modal('hide'); 	
	    	toastr.error('Something went wrong with saveing the data. Please try again.');
	    } 
	  });
	}else{
		if(component_name == ''){
			// alert("Name Null")
			$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
		}

		if(component_price == ''){
			// alert("Price Null")
			$('#component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
		}
	}
	
}


function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"component/remove_component/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Component deleted successfully.');
			} else {
		         
		        toastr.error('Something went wrong with deleting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with deleting the data. Please try again.');
	    } 
	  });
	 
	
}



