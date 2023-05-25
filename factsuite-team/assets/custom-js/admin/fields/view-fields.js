load_field();

$('#component_name').on('keyup blur',function(){
	var component_name = $('#component_name').val(); 
	if (component_name != '') {
		$('#component-name-error-msg-div').html('');
	} else {
		$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
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

function load_field(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"dynamicFields/get_field_values", 
	  	dataType: "json",
	  	success: function(all_data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
		var data = all_data.field_values,
				selected_datetime_format = all_data.selected_datetime_format;

		var count = $("#total_fields").val();
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	var values = JSON.parse(data[i]['field_values']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	if (values.length > 0) {
        		for (var k = 0; k < count; k++) {
        			$vl = values[k]?values[k]:'';
        			html += '<td>'+$vl+'</td>'; 
        		}
        	}
        	
        	html += '<td>'+moment(data[i]['created_date']).format(selected_datetime_format['js_code'])+'</td>'; 
        	html += '<td>'+moment(data[i]['updated_date']).format(selected_datetime_format['js_code'])+'</td>'; 
        	html += '<td><a  onclick="edit_field_value('+data[i]['dynamic_id']+')"  href="#"><i class="fa fa-pencil"></i></a></td>'; 
        	 
         html += '</tr>'; 
			 
          j++; 
        }
      }else{
        // html+='<tr><td colspan="7" class="text-center">No team Found.</td></tr>'; 
    }
    $('#get-field-data').html(html); 
	  	} 
	});
}


$("#team-submit-btn-values").on('click',function(){
	var count = $("#total_fields").val();
	var names = $("#total_field_name").val();
	let html ='';
	var name = names.split(',');
	for (var i = 0; i < count; i++) {
		html +='<div class="col-sm-12">';
    html +='<h6 class="product-details-span-light">'+ name[i] +'</h6>';
    html +='<input type="text" class="fld field_name_value" name="field_name_value"  placeholder="Enter '+name[i]+' Value">';
    html +='<div id="field-name-error-msg-div"></div>'; 
  	html +='</div>';
	}
	$("#add_field_values").html(html);
})

function addfieldvalues(){
		var field_value = [];

		$(".field_name_value").each(function(){ 
			field_value.push($(this).val());
		});

	if(field_value != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"dynamicFields/insert_field_values",
	  	data:{
	  		field_value:field_value
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_field_value_model').modal('hide'); 	
	        if (data.status == '1') {
	        	load_field();
	        	 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('fields value successfully inserted.');
		        window.location.reload();
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(field_name != ''){
			$('#field-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the field name.</span>');
		}
		 
	}
}

function addfield(){
	 
	var field_name = $("#field_name").val();

	if(field_name != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"dynamicFields/insert_field",
	  	data:{
	  		field_name:field_name
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_fields').modal('hide'); 	
	        if (data.status == '1') {
	        	load_field();
	        	$("#field_name").val('')
	        	 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('field inserted successfully.');
		        window.location.reload();
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(field_name != ''){
			$('#field-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the field name.</span>');
		}
		 
	}
	
}
 

function edit_field_value(id){
  $('#edit_field').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"dynamicFields/get_field_details/"+id, 
    dataType: "json",
    success: function(data){  
    	var count = $("#total_fields").val();
			var names = $("#total_field_name").val();
			$("#edit_dynamic_id").val(data['dynamic_id']);
			let html ='';
			var name = names.split(',');
			var values = JSON.parse(data['field_values']);
			for (var i = 0; i < count; i++) {
				$val = values[i]?values[i]:'';
				html +='<div class="col-sm-12">';
		    html +='<h6 class="product-details-span-light">'+ name[i] +'</h6>';
		    html +='<input type="text" class="fld edit_field_name_value" value="'+$val+'" name="field_name_value"  placeholder="Enter '+name[i]+' Value">';
		    html +='<div id="field-name-error-msg-div"></div>'; 
		  	html +='</div>';
			}
			$("#edit_field_values").html(html);
    }
  });
}



function updateData(){
	 
	var field_value = [];
	var dynamic_id = $("#edit_dynamic_id").val();

		$(".edit_field_name_value").each(function(){ 
			field_value.push($(this).val());
		});

	if(field_value != '' && dynamic_id !=''){
		$.ajax({
		type: "POST",
	  	url: base_url+"dynamicFields/update_field_values",
	  	data:{
	  		dynamic_id:dynamic_id,
	  		field_value:field_value
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_field').modal('hide'); 	
	        if (data.status == '1') {
	        	load_field();
	        	  
		        toastr.success('field updated successfully.');
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
		if(field_name != ''){
			$('#field-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the field name.</span>');
		}
		 
	}
	
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"field/remove_field/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_field();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Role deleted successfully.');
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




function import_excel(){
	var files = $('#add-bulk-upload-case')[0].files[0];
	 
	if (files != undefined) {
		$('#error-client').html('');
		// var form_values = JSON.stringify(selected);
		var formdata = new FormData(); 
		formdata.append('files', files); 
		formdata.append('type', 'education'); 
		$('#error-client').html('<span class="text-warning error-msg-small">Please wait while we are submitting the details</span>');
		 
		$.ajax({
			type: "POST",
		  	url: base_url+"dynamicFields/import_excel",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
		    processData: false,
		  	success: function(data){
		  		$('#error-client').html('');
		  		$('#import_excel_file').prop('disabled',false);
		  		$('#import_excel_file').css('background','#005799');
			  	if (data.status == '1') {
			  		toastr.success('New Users Added successfully.');
					$('#add-bulk-upload-case').val(''); 
			  	} else {
			  		toastr.error('OOPS! Something went wrong while adding the User details. Please try again.');
		  		}
		  		 window.location.reload();
		  	} 
		});
	} else {
		$('#error-client').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}

